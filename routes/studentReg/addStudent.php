<?php
ob_start();
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['group']) && isset($_POST['event_name'])) {
    $reg_number = $_POST['reg_number'];
    $group      = $_POST['group'];
    $event_name = $_POST['event_name'];

    // Check if student already in 2 events (limit reached)
    $reg_student = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE `reg_no` = '$reg_number'");
    if (mysqli_num_rows($reg_student) >= 2) {
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name) . "&error=StudentLimit");
        exit();
    }

    // Get student details
    $std_details = mysqli_query($conn, "SELECT `name`, `house`, `gender`, `dept`, `year` 
                                        FROM `studentdb` 
                                        WHERE `reg_no`='$reg_number'");
    $data = mysqli_fetch_array($std_details);

    $house_name   = $data['house'];
    $student_name = $data['name'];
    $student_dept = $data['dept'];
    $gender       = $data['gender'];
    $year         = $data['year'];

    // Verify correct house
    if ($house_name == $_POST['house_name']) {
        // Prevent duplicate registration for same event
        $sql = "SELECT reg_no FROM registerationdb 
                WHERE reg_no = '$reg_number' AND event_name = '$event_name'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name) . "&error=AlreadyRegistered");
            exit();
        }

        // ---------- NEW: Fetch event details ----------
        $eventRes = mysqli_query($conn, "SELECT max_participants, group_counts, is_group, group_participants 
                                         FROM eventdb 
                                         WHERE event_name = '$event_name'");
        $event = mysqli_fetch_assoc($eventRes);

        if ($event) {
            // 1) Check total event participant capacity
            $totalCountRes = mysqli_query($conn, "SELECT COUNT(*) as cnt 
                                                  FROM registerationdb 
                                                  WHERE event_name = '$event_name'");
            $totalCount = mysqli_fetch_assoc($totalCountRes)['cnt'];

            if ($totalCount >= $event['max_participants']) {
                header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name) . "&error=EventFull");
                exit();
            }

            // 2) If group event, check per-group capacity
            if ($event['is_group'] == 1) {
                $maxPerGroup = $event['group_participants']; // directly from DB

                $groupCountRes = mysqli_query($conn, "SELECT COUNT(*) as cnt 
                                                      FROM registerationdb 
                                                      WHERE event_name = '$event_name' 
                                                      AND student_house = '$house_name' 
                                                      AND grouped = '$group'");
                $groupCount = mysqli_fetch_assoc($groupCountRes)['cnt'];

                if ($groupCount >= $maxPerGroup) {
                    header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name) . "&error=GroupFull");
                    exit();
                }
            }
        }
        // ---------- END NEW ----------

        // Insert student into registration
        $query = "INSERT INTO `registerationdb`
                  (`reg_no`, `event_name`, `student_house`, `grouped`, `student_name`, `student_dept`, `gender`, `student_year`) 
                  VALUES 
                  ('$reg_number','$event_name','$house_name', '$group','$student_name','$student_dept','$gender', '$year')";

        if (mysqli_query($conn, $query)) {
            header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name) . "&success=1");
        } else {
            error_log("Registration insert failed: " . mysqli_error($conn));
            header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name) . "&error=DBError");
        }
    } else {
        header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name) . "&error=HouseMismatch");
    }
}
ob_end_flush();
