<?php 
ob_start(); 
include('../connect.php');  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number'], $_POST['group'], $_POST['event_name'])) {
    $reg_number = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $group = mysqli_real_escape_string($conn, $_POST['group']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);

    // Step 1: Check student details
    $std_details = mysqli_query($conn, "SELECT `name`, `house`, `gender`, `dept`, `year` FROM `studentdb` WHERE `reg_no`='$reg_number'");
    if (mysqli_num_rows($std_details) == 0) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=StudentNotFound");
        exit;
    }
    $data = mysqli_fetch_assoc($std_details);

    // Step 2: Check duplicate for same event
    $dup_check = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE `reg_no` = '$reg_number' AND `event_name` = '$event_name'");
    if (mysqli_num_rows($dup_check) > 0) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=AlreadyRegistered");
        exit;
    }

    // Step 3: Define dance events
    $dance_events = ["CHOREO BOOM", "ANY BODY CAN DANCE"];
    $is_dance_event = in_array($event_name, $dance_events) ? 1 : 0;

    // Step 4: Count existing registrations
    $sql = "SELECT event_name FROM registerationdb WHERE reg_no='$reg_number'";
    $res = mysqli_query($conn, $sql);

    $total_events = 0;
    $dance_count = 0;
    $offstage_count = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $total_events++;
        if (in_array($row['event_name'], $dance_events)) {
            $dance_count++;
        } else {
            $offstage_count++;
        }
    }

    // Step 5: Apply rules
    if ($total_events >= 3) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=MaxLimitReached");
        exit;
    }

    $new_dance_count = $dance_count + ($is_dance_event ? 1 : 0);
    $new_offstage_count = $offstage_count + ($is_dance_event ? 0 : 1);
    $new_total = $total_events + 1;

    $valid = false;
    if ($new_total <= 2) {
        // First and second event always okay
        $valid = true;
    } elseif ($new_total == 3) {
        // Third event must satisfy exact combo
        if (($new_dance_count == 1 && $new_offstage_count == 2) ||
            ($new_dance_count == 2 && $new_offstage_count == 1)) {
            $valid = true;
        }
    }

    if (!$valid) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=InvalidCombo");
        exit;
    }

    // Step 6: Insert record
    $query = "INSERT INTO `registerationdb`
              (`reg_no`, `event_name`, `student_house`, `grouped`, `student_name`, `student_dept`, `gender`, `student_year`) 
              VALUES 
              ('$reg_number','$event_name','".$data['house']."','$group','".$data['name']."','".$data['dept']."','".$data['gender']."','".$data['year']."')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&success=1");
    } else {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=DBError");
    }
}
ob_end_flush();
