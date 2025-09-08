<?php
ob_start();
include('../connect.php');

// Ensure database connection is valid
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Database connection failed. Please try again later.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and normalize POST data
    $slot_array = isset($_POST["slot_array"]) ? mysqli_real_escape_string($conn, $_POST["slot_array"]) : null;
    $event_name = isset($_POST["event_name"]) ? trim(strtoupper(mysqli_real_escape_string($conn, $_POST["event_name"]))) : null;
    $gender = isset($_POST["gender"]) ? trim(strtoupper(mysqli_real_escape_string($conn, $_POST["gender"]))) : null;
    $source = isset($_POST["source"]) ? trim(strtolower(mysqli_real_escape_string($conn, $_POST["source"]))) : null;
    $wheel_count = isset($_POST["wheel_count"]) ? (int)$_POST["wheel_count"] : null;
    $isGroup = isset($_POST["isGroup"]) ? (int)$_POST["isGroup"] : null;
    $group_count = isset($_POST["group_count"]) ? (int)$_POST["group_count"] : null;

    // Log raw POST data for debugging
    error_log("Raw POST data: " . json_encode($_POST));

    // Input validation
    if ($slot_array === null || $event_name === null || $gender === null || $source === null || $wheel_count === null) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Missing required POST data.</div>";
        exit;
    }
    if (!in_array($gender, ['BOYS', 'GIRLS'])) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Invalid gender value. Must be BOYS or GIRLS.</div>";
        exit;
    }
    if (!in_array($source, ['boys', 'girls'])) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Invalid source. Must be 'boys' or 'girls'.</div>";
        exit;
    }
    if ($wheel_count < 1 || $wheel_count > 4) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Invalid wheel count. Must be between 1 and 4.</div>";
        exit;
    }

    // Decode slot_array
    $slot = json_decode($slot_array, true);
    if ($slot === null || !is_array($slot) || empty($slot)) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Invalid slot_array format.</div>";
        exit;
    }

    $slotCount = count($slot);
    $expectedSlots = ($source === 'boys') ? $wheel_count * 4 : $wheel_count * 5;
    if ($slotCount !== $expectedSlots) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Slot count mismatch. Expected $expectedSlots, got $slotCount.</div>";
        exit;
    }

    // Fetch event details from event_slots
    $stmt = mysqli_prepare($conn, "SELECT is_group, group_participants FROM event_slots WHERE event_name = ? AND gender = ?");
    if (!$stmt) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Database query preparation failed.</div>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ss", $event_name, $gender);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $db_isGroup, $db_group_count);
    if (!mysqli_stmt_fetch($stmt)) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Event not found for name: " . htmlspecialchars($event_name) . " and gender: " . htmlspecialchars($gender) . "</div>";
        mysqli_stmt_close($stmt);
        exit;
    }
    mysqli_stmt_close($stmt);

    $isGroup = ($isGroup !== null) ? $isGroup : $db_isGroup;
    $group_count = ($group_count !== null) ? $group_count : $db_group_count;

    // Check for existing allotments
    $checkStmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM allotmentdb WHERE event = ? AND gender = ?");
    mysqli_stmt_bind_param($checkStmt, "ss", $event_name, $gender);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_bind_result($checkStmt, $existingCount);
    mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);
    if ($existingCount > 0) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Slots already assigned for this event and gender.</div>";
        exit;
    }

    if ($isGroup == 1 && $group_count <= 0) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: Invalid group_count value for grouped event.</div>";
        exit;
    }

    shuffle($slot); // Randomize slots
    $atLeastOneStudent = false;

    if ($isGroup == 0) {
        // UNGROUPED LOGIC
        $insertStmt = mysqli_prepare($conn, "INSERT INTO allotmentdb (house, event, isGroup, group_count, grouped, slot, gender, reg_no) VALUES (?, ?, 0, 1, 0, ?, ?, ?)");
        $stmt = mysqli_prepare($conn, "SELECT DISTINCT student_house FROM registerationdb WHERE event_name = ? AND gender = ?");
        mysqli_stmt_bind_param($stmt, "ss", $event_name, $gender);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $houses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);

        $studentIdx = 0;
        foreach ($houses as $houseRow) {
            $house = $houseRow['student_house'];
            $studentStmt = mysqli_prepare($conn, "SELECT reg_no FROM registerationdb WHERE event_name = ? AND gender = ? AND student_house = ? ORDER BY id ASC");
            mysqli_stmt_bind_param($studentStmt, "sss", $event_name, $gender, $house);
            mysqli_stmt_execute($studentStmt);
            $studentResult = mysqli_stmt_get_result($studentStmt);
            $students = mysqli_fetch_all($studentResult, MYSQLI_ASSOC);
            mysqli_stmt_close($studentStmt);

            foreach ($students as $student) {
                $reg_no = $student['reg_no'];
                $slotNo = $slot[$studentIdx];
                mysqli_stmt_bind_param($insertStmt, "ssiss", $house, $event_name, $slotNo, $gender, $reg_no);
                mysqli_stmt_execute($insertStmt);
                $studentIdx++;
                $atLeastOneStudent = true;
            }
        }
        mysqli_stmt_close($insertStmt);

    } else {
        // GROUPED LOGIC
        $house_stmt = mysqli_prepare($conn, "SELECT DISTINCT student_house FROM registerationdb WHERE event_name = ? AND gender = ?");
        mysqli_stmt_bind_param($house_stmt, "ss", $event_name, $gender);
        mysqli_stmt_execute($house_stmt);
        $result = mysqli_stmt_get_result($house_stmt);
        $houses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($house_stmt);

        $insertStmt = mysqli_prepare($conn, "INSERT INTO allotmentdb (house, event, isGroup, group_count, grouped, slot, gender, reg_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $updateStmt = mysqli_prepare($conn, "UPDATE registerationdb SET grouped = ? WHERE id = ?");

        $slotIdx = 0;
        foreach ($houses as $houseRow) {
            $house = $houseRow['student_house'];
            $studentStmt = mysqli_prepare($conn, "SELECT id, reg_no FROM registerationdb WHERE event_name = ? AND gender = ? AND student_house = ? ORDER BY id ASC");
            mysqli_stmt_bind_param($studentStmt, "sss", $event_name, $gender, $house);
            mysqli_stmt_execute($studentStmt);
            $studentResult = mysqli_stmt_get_result($studentStmt);
            $students = mysqli_fetch_all($studentResult, MYSQLI_ASSOC);
            mysqli_stmt_close($studentStmt);

            $studentIdx = 0;
            foreach ($students as $student) {
                $grouped = (int)floor($studentIdx / $group_count) + 1;
                mysqli_stmt_bind_param($updateStmt, "ii", $grouped, $student['id']);
                mysqli_stmt_execute($updateStmt);
                $studentIdx++;
            }

            $num_teams = (int)ceil($studentIdx / $group_count);
            for ($grouped = 1; $grouped <= $num_teams; $grouped++) {
                $slotNo = $slot[$slotIdx];
                $groupStudentStmt = mysqli_prepare($conn, "SELECT reg_no FROM registerationdb WHERE event_name = ? AND gender = ? AND student_house = ? AND grouped = ? ORDER BY id ASC");
                mysqli_stmt_bind_param($groupStudentStmt, "sssi", $event_name, $gender, $house, $grouped);
                mysqli_stmt_execute($groupStudentStmt);
                $groupResult = mysqli_stmt_get_result($groupStudentStmt);
                $groupStudents = mysqli_fetch_all($groupResult, MYSQLI_ASSOC);
                mysqli_stmt_close($groupStudentStmt);

                foreach ($groupStudents as $gStudent) {
                    $reg_no = $gStudent['reg_no'];
                    mysqli_stmt_bind_param($insertStmt, "ssiissss", $house, $event_name, $isGroup, $group_count, $grouped, $slotNo, $gender, $reg_no);
                    mysqli_stmt_execute($insertStmt);
                    $atLeastOneStudent = true;
                }
                $slotIdx++;
            }
        }
        mysqli_stmt_close($insertStmt);
        mysqli_stmt_close($updateStmt);
    }

    if (!$atLeastOneStudent) {
        echo "<div style=\"color:red;background:#fff;padding:1em;\">Error: No students found for event: " . htmlspecialchars($event_name) . ", gender: " . htmlspecialchars($gender) . "</div>";
        exit;
    }
}

mysqli_close($conn);
ob_end_flush();
?>
