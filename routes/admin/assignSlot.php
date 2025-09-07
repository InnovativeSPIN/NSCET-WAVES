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
    // Sanitize and validate POST data
    $slot_array = isset($_POST["slot_array"]) ? mysqli_real_escape_string($conn, $_POST["slot_array"]) : null;
    $event_name = isset($_POST["event_name"]) ? mysqli_real_escape_string($conn, $_POST["event_name"]) : null;
    $gender = isset($_POST["gender"]) ? mysqli_real_escape_string($conn, $_POST["gender"]) : null;
    $isGroup_post = isset($_POST["isGroup"]) ? intval($_POST["isGroup"]) : null;
    $group_count_post = isset($_POST["group_count"]) ? intval($_POST["group_count"]) : null;

    // Decode slot_array
    $slot = $slot_array ? json_decode($slot_array, true) : null;

    // Input validation
    if ($slot_array === null || $event_name === null || $gender === null) {
        error_log("Missing POST data: slot_array=" . var_export($slot_array, true) . ", event_name=" . var_export($event_name, true) . ", gender=" . var_export($gender, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Missing required POST data.</div>';
        exit;
    }
    if ($slot === null || !is_array($slot) || empty($slot)) {
        error_log("Invalid slot_array: " . var_export($slot_array, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid slot_array format. Must be a valid JSON array.</div>';
        exit;
    }
    if (!in_array($gender, ['BOYS', 'GIRLS', 'MIXED'])) {
        error_log("Invalid gender: " . var_export($gender, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid gender value. Must be BOYS, GIRLS, or MIXED.</div>';
        exit;
    }
    if ($isGroup_post !== null && !in_array($isGroup_post, [0, 1])) {
        error_log("Invalid isGroup: " . var_export($isGroup_post, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid isGroup value. Must be 0 or 1.</div>';
        exit;
    }
    if ($group_count_post !== null && $group_count_post < 0) {
        error_log("Invalid group_count: " . var_export($group_count_post, true));
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Invalid group_count value. Must be non-negative.</div>';
        exit;
    }

    // Team names (for grouped events)
    $teams_girls = ["BLUE BLASTERS", "GALACTIC STARS", "ROSY RIDERS", "VIOLET VIPERS", "EMERALD EAGLES"];
    $teams_boys = ["DINO THUNDERS", "DRAGON WARRIORS", "PHOENIX BLASTERS", "TIGER THRASHERS"];

    // Select teams for grouped events
    if ($gender == 'GIRLS') {
        $teams = $teams_girls;
    } elseif ($gender == 'BOYS') {
        $teams = $teams_boys;
    } else {
        $teams = array_merge($teams_girls, $teams_boys);
    }

    $slotCount = count($slot);

    // Grouping decision
    if ($isGroup_post !== null && $group_count_post !== null) {
        $isGroup = $isGroup_post;
        $group_count = $group_count_post;
    } else {
        $isGroup = ($slotCount > count($teams)) ? 1 : 0;
        $group_count = $isGroup ? 2 : 0;
    }

    // UNGROUPED LOGIC (Adapted from old code: house-based, registration order)
    if ($isGroup == 0 && $group_count == 0) {
        $groups = ($gender == 'MIXED') ? ['GIRLS', 'BOYS'] : [$gender];
        $atLeastOneStudent = false; // Track if any students are found

        foreach ($groups as $g) {
            // Fetch distinct houses
            $stmt = mysqli_prepare($conn, "SELECT DISTINCT student_house FROM registerationdb WHERE event_name = ? AND gender = ?");
            if (!$stmt) {
                error_log("Prepare failed for houses query: " . mysqli_error($conn) . " for event: $event_name, gender: $g");
                echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
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

            // Prepare insert statement
            $insertStmt = mysqli_prepare($conn, "INSERT INTO allotmentdb (house, event, isGroup, group_count, grouped, slot, gender, reg_no) VALUES (?, ?, 0, 1, 0, ?, ?, ?)");
            if (!$insertStmt) {
                error_log("Prepare failed for insert: " . mysqli_error($conn) . " for event: $event_name, gender: $g");
                echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
                exit;
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

                error_log("Fetched students for event: $event_name, gender: $g, house: $house: " . json_encode($students));

                if (empty($students)) {
                    error_log("No students found for event: $event_name, gender: $g, house: $house");
                    continue; // Skip if no students for this house
                }

                $atLeastOneStudent = true;
                $studentIdx = 0;
                foreach ($students as $student) {
                    $reg_no = $student['reg_no'];
                    if (empty($reg_no) || $reg_no === null) {
                        error_log("Empty or NULL reg_no for event: $event_name, gender: $g, house: $house, student index: $studentIdx");
                        continue; // Skip if reg_no is empty or NULL
                    }
                    $slotNo = isset($slot[$studentIdx % $slotCount]) ? $slot[$studentIdx % $slotCount] : 0;
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
            mysqli_stmt_close($insertStmt);
        }

        if (!$atLeastOneStudent) {
            error_log("No students found for event: $event_name, gender: $gender");
            echo '<div style="color:red;background:#fff;padding:1em;">Error: No students found for event: ' . htmlspecialchars($event_name) . ', gender: ' . htmlspecialchars($gender) . '</div>';
            exit;
        }
    } else {
        // GROUPED RANDOM LOGIC (Unchanged from new code)
        shuffle($slot); // Randomize slots
        $insertStmt = mysqli_prepare($conn, "INSERT INTO allotmentdb (house, event, isGroup, group_count, grouped, slot, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$insertStmt) {
            error_log("Prepare failed for grouped insert: " . mysqli_error($conn));
            echo '<div style="color:red;background:#fff;padding:1em;">Error: Database query preparation failed.</div>';
            exit;
        }

        for ($i = 0; $i < $slotCount; $i++) {
            $slotNo = $slot[$i];
            $team = $teams[$i % count($teams)];
            $grouped = $isGroup ? (int)floor($i / count($teams)) + 1 : 0;
            mysqli_stmt_bind_param($insertStmt, "ssiisss", $team, $event_name, $isGroup, $group_count, $grouped, $slotNo, $gender);
            if (!mysqli_stmt_execute($insertStmt)) {
                error_log("Insert error for grouped event: $event_name, team: $team, slot: $slotNo: " . mysqli_error($conn));
                echo '<div style="color:red;background:#fff;padding:1em;">Error: Failed to process slot allotment.</div>';
                mysqli_stmt_close($insertStmt);
                exit;
            }
        }
        mysqli_stmt_close($insertStmt);
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