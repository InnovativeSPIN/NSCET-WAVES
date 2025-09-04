<?php
ob_start();
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['group']) && isset($_POST['event_name'])) {
    $reg_number = $_POST['reg_number'];
    $group = $_POST['group'];
    $event_name = $_POST['event_name'];

    $reg_student = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE `reg_no` = '$reg_number'");
    if (mysqli_num_rows($reg_student) >= 2) {
        // echo "Student Limit Reached";
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name));
    } else {
        $std_details = mysqli_query($conn, "SELECT `name`, `house`, `gender`, `dept`, `year` FROM `studentdb` WHERE `reg_no`='$reg_number'");
        $data = mysqli_fetch_array($std_details);
        $house_name = $data['house'];
        $student_name = $data['name'];
        $student_dept = $data['dept'];
        $gender = $data['gender'];
        $year = $data['year'];


        if ($data['house'] == $_POST['house_name']) {
            // The reg_no to check
            $reg_no_to_check = $reg_number;

            // SQL query to check if the reg_no exists in the column
            $sql = "SELECT reg_no FROM registerationdb WHERE reg_no = '$reg_no_to_check' AND event_name = '$event_name'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name));
            } else {
                $query = "INSERT INTO `registerationdb`(`reg_no`, `event_name`, `student_house`, `grouped`, `student_name`, `student_dept`, `gender`, `student_year`) VALUES ('$reg_number','$event_name','$house_name', '$group','$student_name','$student_dept','$gender', '$year')";

                if (mysqli_query($conn, $query)) {
                    header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name));
                } else {
                    // echo "Error updating record: " . mysqli_error($conn);
                }
            }
        } else {
            header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name));
        }
    }
}
ob_end_flush();
