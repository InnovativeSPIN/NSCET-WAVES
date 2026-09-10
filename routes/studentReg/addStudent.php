<?php 
ob_start(); 
include('../connect.php');  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number'], $_POST['group'], $_POST['event_name'])) {
    $group = mysqli_real_escape_string($conn, $_POST['group']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);

    $raw_reg_numbers = $_POST['reg_number'];
    if (!is_array($raw_reg_numbers)) {
        $raw_reg_numbers = [$raw_reg_numbers];
    }
    
    // Filter out empty ones
    $reg_numbers = [];
    foreach ($raw_reg_numbers as $r) {
        $r = trim($r);
        if ($r !== '') {
            $reg_numbers[] = mysqli_real_escape_string($conn, $r);
        }
    }
    
    if (empty($reg_numbers)) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=NoStudentProvided");
        exit;
    }

    $valid_students = [];

    foreach ($reg_numbers as $reg_number) {
        // Step 1: Check student details
        $std_details = mysqli_query($conn, "SELECT `name`, `house`, `gender`, `dept`, `year` FROM `studentdb` WHERE `reg_no`='$reg_number'");
        if (mysqli_num_rows($std_details) == 0) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=StudentNotFound_$reg_number");
            exit;
        }
        $data = mysqli_fetch_assoc($std_details);

        // Step 2: Check duplicate for same event
        $dup_check = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE `reg_no` = '$reg_number' AND `event_name` = '$event_name'");
        if (mysqli_num_rows($dup_check) > 0) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=AlreadyRegistered_$reg_number");
            exit;
        }

        // Step 3: Count existing registrations
        $sql = "SELECT event_name FROM registerationdb WHERE reg_no='$reg_number'";
        $res = mysqli_query($conn, $sql);

        $total_events = 0;
        $has_flash_mob = ($event_name === 'FLASH MOB');

        while ($row = mysqli_fetch_assoc($res)) {
            $total_events++;
            if ($row['event_name'] === 'FLASH MOB') {
                $has_flash_mob = true;
            }
        }

        // Step 4: Apply rules
        // Max 2 events per student. 
        // Exception: A student may participate in up to 3 events ONLY IF one of those events is "FLASH MOB".
        $new_total = $total_events + 1;
        $valid = false;
        
        if ($new_total <= 2) {
            $valid = true;
        } elseif ($new_total == 3 && $has_flash_mob) {
            $valid = true;
        }
        
        if (!$valid) {
            header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=MaxLimitReached_$reg_number");
            exit;
        }
        
        // Add to valid list
        $valid_students[] = [
            'reg_no' => $reg_number,
            'house' => $data['house'],
            'name' => $data['name'],
            'dept' => $data['dept'],
            'gender' => $data['gender'],
            'year' => $data['year']
        ];
    }
    
    // Step 5: Insert all valid students
    $success = true;
    foreach ($valid_students as $st) {
        $query = "INSERT INTO `registerationdb`
                  (`reg_no`, `event_name`, `student_house`, `grouped`, `student_name`, `student_dept`, `gender`, `student_year`) 
                  VALUES 
                  ('".$st['reg_no']."','$event_name','".$st['house']."','$group','".$st['name']."','".$st['dept']."','".$st['gender']."','".$st['year']."')";
        if (!mysqli_query($conn, $query)) {
            $success = false;
        }
    }

    if ($success) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&success=1");
    } else {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=DBError");
    }
}
ob_end_flush();
