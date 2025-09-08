<?php
ob_start();
include('../connect.php');

// Ensure database connection is valid
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    echo '<div style="color:red;background:#fff;padding:1em;">Error: Database connection failed. Please try again later.</div>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and normalize POST data
    $slot_array = isset($_POST["slot_array"]) ? mysqli_real_escape_string($conn, $_POST["slot_array"]) : null;
    $event_name = isset($_POST["event_name"]) ? trim(strtoupper(mysqli_real_escape_string($conn, $_POST["event_name"]))) : null;
    $gender = isset($_POST["gender"]) ? trim(strtoupper(mysqli_real_escape_string($conn, $_POST["gender"]))) : null;

    // Log POST data for debugging
    error_log("POST Data - event_name: " . var_export($event_name, true) . ", gender: " . var_export($gender, true) . ", slot_array: " . var_export($slot_array, true));

    // Input validation
    if ($slot_array === null || $event_name === null || $gender === null) {
        error_log("Missing POST data: slot_array=" . var_export($slot_array, true) . ", event_name=" . var_export($event_name, true) . ", gender=" . var_export($gender, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Missing required POST data.</div>';
        exit;
    }
    if (!in_array($gender, ['BOYS', 'GIRLS', 'COMMON'])) {
        error_log("Invalid gender: " . var_export($gender, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid gender value. Must be BOYS, GIRLS, or COMMON.</div>';
        exit;
    }

    // Decode slot_array
    $slot = json_decode($slot_array, true);
    if ($slot === null || !is_array($slot) || empty($slot)) {
        error_log("Invalid slot_array: " . var_export($slot_array, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid slot_array format. Must be a valid JSON array.</div>';
        exit;
    }

    // Fetch event details from eventdb
    $stmt = mysqli_prepare($conn, "SELECT is_group AS isGroup, group_participants AS group_count, gender AS event_gender FROM eventdb WHERE event_name = ?");
    if (!$stmt) {
        error_log("Prepare failed for event query: " . mysqli_error($conn));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
        exit;
    }
    mysqli_stmt_bind_param($stmt, "s", $event_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $isGroup, $group_count, $event_gender);
    if (!mysqli_stmt_fetch($stmt)) {
        error_log("No event found for event_name: $event_name");
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Event not found for name: ' . htmlspecialchars($event_name) . '</div>';
        mysqli_stmt_close($stmt);
        exit;
    }
    mysqli_stmt_close($stmt);

    // Validate POST gender against eventdb gender
   // Validate POST gender against eventdb gender
if ($event_gender !== 'COMMON' && $event_gender !== $gender) {
    error_log("Gender mismatch: POST gender=$gender, eventdb gender=$event_gender for event_name: $event_name");
    echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid gender for event ' . htmlspecialchars($event_name) . '. Expected gender: ' . htmlspecialchars($event_gender) . '.</div>';
    exit;
}


    if ($isGroup == 1 && $group_count <= 0) {
        error_log("Invalid group_count for grouped event: $group_count");
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid group_count value for grouped event. Must be positive.</div>';
        exit;
    }

    $slotCount = count($slot);
    shuffle($slot); // Randomize slots for fairness

    $atLeastOneStudent = false; // Track if any allotments are made

    if ($isGroup == 0) {
        // UNGROUPED LOGIC: Assign unique slots to individual participants
        $groups = ($event_gender == 'COMMON') ? ['GIRLS', 'BOYS'] : [$event_gender];
        $studentIdx = 0;

        // Prepare insert statement
        $insertStmt = mysqli_prepare($conn, "INSERT INTO allotmentdb (house, event, isGroup, group_count, grouped, slot, gender, reg_no) VALUES (?, ?, 0, 1, 0, ?, ?, ?)");
        if (!$insertStmt) {
            error_log("Prepare failed for insert: " . mysqli_error($conn));
            echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
            exit;
        }

        foreach ($groups as $g) {
            // Fetch distinct houses
            $stmt = mysqli_prepare($conn, "SELECT DISTINCT student_house FROM registerationdb WHERE event_name = ? AND gender = ?");
            if (!$stmt) {
                error_log("Prepare failed for houses query: " . mysqli_error($conn) . " for event: $event_name, gender: $g");
                echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
                mysqli_stmt_close($insertStmt);
                exit;
            }
            mysqli_stmt_bind_param($stmt, "ss", $event_name, $g);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $houses = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);

            if (empty($houses)) {
                error_log("No houses found for event: $event_name, gender: $g");
                continue; // Skip if no houses for this gender
            }

            foreach ($houses as $houseRow) {
                $house = $houseRow['student_house'];
                // Fetch students for this house, ordered by id
                $studentStmt = mysqli_prepare($conn, "SELECT reg_no FROM registerationdb WHERE event_name = ? AND gender = ? AND student_house = ? ORDER BY id ASC");
                if (!$studentStmt) {
                    error_log("Prepare failed for students query: " . mysqli_error($conn) . " for event: $event_name, gender: $g, house: $house");
                    echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
                    mysqli_stmt_close($insertStmt);
                    exit;
                }
                mysqli_stmt_bind_param($studentStmt, "sss", $event_name, $g, $house);
                mysqli_stmt_execute($studentStmt);
                $studentResult = mysqli_stmt_get_result($studentStmt);
                $students = mysqli_fetch_all($studentResult, MYSQLI_ASSOC);
                mysqli_stmt_close($studentStmt);

                if (empty($students)) {
                    error_log("No students found for event: $event_name, gender: $g, house: $house");
                    continue; // Skip if no students for this house
                }

                $atLeastOneStudent = true;

                foreach ($students as $student) {
                    $reg_no = $student['reg_no'];
                    if (empty($reg_no) || $reg_no === null) {
                        error_log("Empty or null reg_no for event: $event_name, gender: $g, house: $house");
                        continue; // Skip if reg_no is empty or NULL
                    }
                    if ($studentIdx >= $slotCount) {
                        error_log("Not enough slots for all participants for event: $event_name, gender: $g, house: $house");
                        echo '<div style="color:red;background:#fff;padding:1em;">Error: Not enough slots for all participants.</div>';
                        mysqli_stmt_close($insertStmt);
                        exit;
                    }
                    $slotNo = $slot[$studentIdx];
                    mysqli_stmt_bind_param($insertStmt, "ssiss", $house, $event_name, $slotNo, $g, $reg_no);
                    if (!mysqli_stmt_execute($insertStmt)) {
                        error_log("Insert error for reg_no: $reg_no, event: $event_name, gender: $g, house: $house, slot: $slotNo: " . mysqli_error($conn));
                        echo '<div style="color:red;background:#fff;padding:1em;">Error: Failed to process slot allotment.</div>';
                        mysqli_stmt_close($insertStmt);
                        exit;
                    }
                    $studentIdx++;
                }
            }
        }
        mysqli_stmt_close($insertStmt);

        if (!$atLeastOneStudent) {
            error_log("No students found for event: $event_name, gender: $event_gender");
            echo '<div style="color:red;background:#fff;padding:1em;">Error: No students found for event: ' . htmlspecialchars($event_name) . ', gender: ' . htmlspecialchars($event_gender) . '</div>';
            exit;
        }
    } else {
        // GROUPED LOGIC: Assign slots to teams based on participants per house
        $participant_genders = ($event_gender == 'COMMON') ? ['BOYS', 'GIRLS'] : [$event_gender];
        $gender_where = "gender IN ('" . implode("','", $participant_genders) . "')";

        // Fetch distinct houses
        $house_stmt = mysqli_prepare($conn, "SELECT DISTINCT student_house FROM registerationdb WHERE event_name = ? AND " . $gender_where);
        if (!$house_stmt) {
            error_log("Prepare failed for houses query: " . mysqli_error($conn));
            echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
            exit;
        }
        mysqli_stmt_bind_param($house_stmt, "s", $event_name);
        mysqli_stmt_execute($house_stmt);
        $result = mysqli_stmt_get_result($house_stmt);
        $houses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($house_stmt);

        if (empty($houses)) {
            error_log("No houses found for event: $event_name, gender: $event_gender");
            echo '<div style="color:red;background:#fff;padding:1em;">Error: No houses found for event: ' . htmlspecialchars($event_name) . ', gender: ' . htmlspecialchars($event_gender) . '</div>';
            exit;
        }

        // Sort houses for consistent order
        usort($houses, function($a, $b) {
            return strcmp($a['student_house'], $b['student_house']);
        });

        $insertStmt = mysqli_prepare($conn, "INSERT INTO allotmentdb (house, event, isGroup, group_count, grouped, slot, gender, reg_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$insertStmt) {
            error_log("Prepare failed for grouped insert: " . mysqli_error($conn));
            echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
            exit;
        }

        $updateStmt = mysqli_prepare($conn, "UPDATE registerationdb SET grouped = ? WHERE id = ?");
        if (!$updateStmt) {
            error_log("Prepare failed for update: " . mysqli_error($conn));
            echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
            mysqli_stmt_close($insertStmt);
            exit;
        }

        $slotIdx = 0;
        foreach ($houses as $houseRow) {
            $house = $houseRow['student_house'];

            // Fetch students for this house, ordered by id
            $studentStmt = mysqli_prepare($conn, "SELECT id, reg_no FROM registerationdb WHERE event_name = ? AND " . $gender_where . " AND student_house = ? ORDER BY id ASC");
            if (!$studentStmt) {
                error_log("Prepare failed for students query: " . mysqli_error($conn) . " for event: $event_name, house: $house");
                echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
                mysqli_stmt_close($insertStmt);
                mysqli_stmt_close($updateStmt);
                exit;
            }
            mysqli_stmt_bind_param($studentStmt, "ss", $event_name, $house);
            mysqli_stmt_execute($studentStmt);
            $studentResult = mysqli_stmt_get_result($studentStmt);
            $students = mysqli_fetch_all($studentResult, MYSQLI_ASSOC);
            mysqli_stmt_close($studentStmt);

            if (empty($students)) {
                error_log("No students found for event: $event_name, house: $house");
                continue; // Skip if no students for this house
            }

            $atLeastOneStudent = true;
            $studentIdx = 0;

            foreach ($students as $student) {
                $reg_no = $student['reg_no'];
                if (empty($reg_no) || $reg_no === null) {
                    error_log("Empty or null reg_no for event: $event_name, house: $house, id: " . $student['id']);
                    continue; // Skip if reg_no is empty or NULL
                }
                $grouped = (int)floor($studentIdx / $group_count) + 1;
                mysqli_stmt_bind_param($updateStmt, "ii", $grouped, $student['id']);
                if (!mysqli_stmt_execute($updateStmt)) {
                    error_log("Update error for id: " . $student['id'] . ", grouped: $grouped: " . mysqli_error($conn));
                    echo '<div style="color:red;background:#fff;padding:1em;">Error: Failed to update grouped status.</div>';
                    mysqli_stmt_close($insertStmt);
                    mysqli_stmt_close($updateStmt);
                    exit;
                }
                $studentIdx++;
            }

            $num_teams = (int)ceil($studentIdx / $group_count);

            for ($grouped = 1; $grouped <= $num_teams; $grouped++) {
                if ($slotIdx >= $slotCount) {
                    error_log("Not enough slots for all teams for event: $event_name, house: $house");
                    echo '<div style="color:red;background:#fff;padding:1em;">Error: Not enough slots for all teams.</div>';
                    mysqli_stmt_close($insertStmt);
                    mysqli_stmt_close($updateStmt);
                    exit;
                }

                $slotNo = $slot[$slotIdx];

                // Fetch students for this specific team (grouped)
                $groupStudentStmt = mysqli_prepare($conn, "SELECT reg_no FROM registerationdb WHERE event_name = ? AND " . $gender_where . " AND student_house = ? AND grouped = ? ORDER BY id ASC");
                if (!$groupStudentStmt) {
                    error_log("Prepare failed for group students query: " . mysqli_error($conn) . " for event: $event_name, house: $house, grouped: $grouped");
                    echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
                    mysqli_stmt_close($insertStmt);
                    mysqli_stmt_close($updateStmt);
                    exit;
                }
                mysqli_stmt_bind_param($groupStudentStmt, "ssi", $event_name, $house, $grouped);
                mysqli_stmt_execute($groupStudentStmt);
                $groupResult = mysqli_stmt_get_result($groupStudentStmt);
                $groupStudents = mysqli_fetch_all($groupResult, MYSQLI_ASSOC);
                mysqli_stmt_close($groupStudentStmt);

                if (empty($groupStudents)) {
                    error_log("No students found for event: $event_name, house: $house, grouped: $grouped");
                    continue; // Skip if no students for this team
                }

                foreach ($groupStudents as $gStudent) {
                    $reg_no = $gStudent['reg_no'];
                    if (empty($reg_no) || $reg_no === null) {
                        error_log("Empty or null reg_no for event: $event_name, house: $house, grouped: $grouped");
                        continue;
                    }
                    mysqli_stmt_bind_param($insertStmt, "ssiissss", $house, $event_name, $isGroup, $group_count, $grouped, $slotNo, $event_gender, $reg_no);
                    if (!mysqli_stmt_execute($insertStmt)) {
                        error_log("Insert error for reg_no: $reg_no, event: $event_name, house: $house, grouped: $grouped, slot: $slotNo: " . mysqli_error($conn));
                        echo '<div style="color:red;background:#fff;padding:1em;">Error: Failed to process slot allotment.</div>';
                        mysqli_stmt_close($insertStmt);
                        mysqli_stmt_close($updateStmt);
                        exit;
                    }
                }
                $slotIdx++;
            }
        }
        mysqli_stmt_close($insertStmt);
        mysqli_stmt_close($updateStmt);

        if (!$atLeastOneStudent) {
            error_log("No students found for event: $event_name, gender: $event_gender");
            echo '<div style="color:red;background:#fff;padding:1em;">Error: No students found for event: ' . htmlspecialchars($event_name) . ', gender: ' . htmlspecialchars($event_gender) . '</div>';
            exit;
        }
    }

    // Redirect after insert
    if ($isGroup) {
        header('Location: ../../allotment/grouped.php?eventName=' . urlencode($_POST["event_name"]));
        exit;
    } else {
        header('Location: ../../allotment/ungrouped.php?eventName=' . urlencode($_POST["event_name"]));
        exit;
    }
}

mysqli_close($conn);
ob_end_flush();
?>