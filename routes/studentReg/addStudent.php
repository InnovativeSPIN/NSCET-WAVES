<?php 
ob_start(); 
session_start();
include('../connect.php');  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_name'])) {
    $event_name = trim($_POST['event_name']);
    $group = isset($_POST['group']) ? (int)$_POST['group'] : 0;
    
    // House name from session (captain's house) with POST fallback
    $house_name = $_SESSION['house_name'] ?? ($_SESSION['house'] ?? trim($_POST['house_name'] ?? ''));

    if (empty($house_name) || empty($event_name)) {
        header("Location: ../../pages/houseDashboard.php");
        exit;
    }

    // Fetch event details from DB to get allowance and configuration
    $eventStmt = mysqli_prepare($conn, "SELECT * FROM `eventdb` WHERE `event_name` = ? LIMIT 1");
    mysqli_stmt_bind_param($eventStmt, "s", $event_name);
    mysqli_stmt_execute($eventStmt);
    $eventRes = mysqli_stmt_get_result($eventStmt);
    $event = mysqli_fetch_assoc($eventRes);
    mysqli_stmt_close($eventStmt);

    if (!$event) {
        header("Location: ../../pages/houseDashboard.php");
        exit;
    }

    // Team allowance fetched directly from eventdb.allowance (e.g. 2 to 8)
    $teamAllowance = (int)$event['allowance'];
    $isGroup = ((int)$event['is_group'] >= 1);
    $eventGender = strtoupper(trim($event['gender'] ?? 'COMMON'));

    // Extract submitted register numbers
    $raw_reg_numbers = $_POST['reg_number'] ?? [];
    if (!is_array($raw_reg_numbers)) {
        $raw_reg_numbers = [$raw_reg_numbers];
    }
    
    $reg_numbers = [];
    foreach ($raw_reg_numbers as $r) {
        $r = trim($r);
        if ($r !== '') {
            $reg_numbers[] = $r;
        }
    }
    
    if (empty($reg_numbers)) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=NoStudentProvided");
        exit;
    }

    // Check for duplicate register numbers within the current form submission
    if (count($reg_numbers) !== count(array_unique($reg_numbers))) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=DuplicateInBatch");
        exit;
    }

    // Count existing registered members specifically for this team and this event
    $cStmt = mysqli_prepare($conn, "SELECT COUNT(*) as cnt FROM registerationdb WHERE student_house = ? AND event_name = ?");
    mysqli_stmt_bind_param($cStmt, "ss", $house_name, $event_name);
    mysqli_stmt_execute($cStmt);
    $cRow = mysqli_fetch_assoc(mysqli_stmt_get_result($cStmt));
    $currentCount = (int)($cRow['cnt'] ?? 0);
    mysqli_stmt_close($cStmt);

    // Enforce team allowance from DB (separate per team and per event)
    $newTotal = $currentCount + count($reg_numbers);
    if ($newTotal > $teamAllowance) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=AllowanceExceeded");
        exit;
    }

    // If group event, validate group number
    if ($isGroup) {
        if ($group <= 0) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=InvalidGroup");
            exit;
        }
        $grpStmt = mysqli_prepare($conn, "SELECT 1 FROM registerationdb WHERE student_house = ? AND event_name = ? AND grouped = ? LIMIT 1");
        mysqli_stmt_bind_param($grpStmt, "ssi", $house_name, $event_name, $group);
        mysqli_stmt_execute($grpStmt);
        $grpExists = mysqli_num_rows(mysqli_stmt_get_result($grpStmt)) > 0;
        mysqli_stmt_close($grpStmt);

        if ($grpExists) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=GroupAlreadyRegistered");
            exit;
        }
    } else {
        $group = 0;
    }

    $valid_students = [];

    foreach ($reg_numbers as $reg_number) {
        // Step 1: Check student details from studentdb
        $sStmt = mysqli_prepare($conn, "SELECT `name`, `house`, `gender`, `dept`, `year` FROM `studentdb` WHERE `reg_no` = ? LIMIT 1");
        mysqli_stmt_bind_param($sStmt, "s", $reg_number);
        mysqli_stmt_execute($sStmt);
        $sRes = mysqli_stmt_get_result($sStmt);
        if (mysqli_num_rows($sRes) == 0) {
            mysqli_stmt_close($sStmt);
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=StudentNotFound_" . urlencode($reg_number));
            exit;
        }
        $data = mysqli_fetch_assoc($sRes);
        mysqli_stmt_close($sStmt);

        // Step 2: Validate student belongs to the team captain's house
        if (strcasecmp(trim($data['house']), trim($house_name)) !== 0) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=HouseMismatch_" . urlencode($reg_number));
            exit;
        }

        // Step 3: Validate gender category if event has one
        $stuGender = strtoupper(trim($data['gender'] ?? ''));
        if ($eventGender !== 'COMMON' && $stuGender !== $eventGender) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=GenderMismatch_" . urlencode($reg_number));
            exit;
        }

        // Step 4: Check if student is already registered for this event
        $dStmt = mysqli_prepare($conn, "SELECT 1 FROM `registerationdb` WHERE `reg_no` = ? AND `event_name` = ? LIMIT 1");
        mysqli_stmt_bind_param($dStmt, "ss", $reg_number, $event_name);
        mysqli_stmt_execute($dStmt);
        $alreadyRegistered = mysqli_num_rows(mysqli_stmt_get_result($dStmt)) > 0;
        mysqli_stmt_close($dStmt);

        if ($alreadyRegistered) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=AlreadyRegistered_" . urlencode($reg_number));
            exit;
        }

        // Step 5: Count existing event participations for this student
        $pStmt = mysqli_prepare($conn, "SELECT event_name FROM registerationdb WHERE reg_no = ?");
        mysqli_stmt_bind_param($pStmt, "s", $reg_number);
        mysqli_stmt_execute($pStmt);
        $pRes = mysqli_stmt_get_result($pStmt);

        $total_events = 0;
        $has_flash_mob = (stripos($event_name, 'FLASH MOB') !== false);

        while ($pRow = mysqli_fetch_assoc($pRes)) {
            $total_events++;
            if (stripos($pRow['event_name'], 'FLASH MOB') !== false) {
                $has_flash_mob = true;
            }
        }
        mysqli_stmt_close($pStmt);

        // Max 2 events per student. 
        // Exception: Up to 3 events ONLY IF one of those events is Flash Mob.
        $new_student_total = $total_events + 1;
        $valid = false;
        if ($new_student_total <= 2) {
            $valid = true;
        } elseif ($new_student_total == 3 && $has_flash_mob) {
            $valid = true;
        }

        if (!$valid) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=MaxLimitReached_" . urlencode($reg_number));
            exit;
        }

        $valid_students[] = [
            'reg_no' => $reg_number,
            'house' => $data['house'],
            'name' => $data['name'],
            'dept' => $data['dept'],
            'gender' => $data['gender'],
            'year' => $data['year']
        ];
    }

    // Step 6: Insert valid students into registerationdb
    $insertStmt = mysqli_prepare(
        $conn, 
        "INSERT INTO `registerationdb` (`reg_no`, `event_name`, `student_house`, `grouped`, `student_name`, `student_dept`, `gender`, `student_year`, `attendance`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)"
    );
    
    $success = true;
    foreach ($valid_students as $st) {
        mysqli_stmt_bind_param(
            $insertStmt,
            "sssissss",
            $st['reg_no'],
            $event_name,
            $st['house'],
            $group,
            $st['name'],
            $st['dept'],
            $st['gender'],
            $st['year']
        );
        if (!mysqli_stmt_execute($insertStmt)) {
            $success = false;
        }
    }
    mysqli_stmt_close($insertStmt);

    if ($success) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&success=1");
        exit;
    } else {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=DBError");
        exit;
    }
} else {
    header("Location: ../../pages/houseDashboard.php");
    exit;
}
ob_end_flush();
?>
