<?php
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['group']) && isset($_POST['event_name'])) {
    $reg_number = $_POST['reg_number'];
    $group = $_POST['group'];
    $event_name = $_POST['event_name'];

    $reg_student = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE `reg_no` = '$reg_number'");
    if (mysqli_num_rows($reg_student) >= 2) {
        echo "<script>alert('Student Limit Reached')</script>";
        header("Location: ../../pages/studentRegisteration.php?eventName=" . urlencode($event_name));
    } else {
        $std_details = mysqli_query($conn, "SELECT `name`, `house`, `gender`, `dept` FROM `studentdb` WHERE `reg_no`='$reg_number'");
        $data = mysqli_fetch_array($std_details);
        $house_name = $data['house'];
        $student_name = $data['name'];
        $student_dept = $data['dept'];
        $gender = $data['gender'];

        $query = "INSERT INTO `registerationdb`(`reg_no`, `event_name`, `student_house`, `grouped`, `student_name`, `student_dept`, `gender`) VALUES ('$reg_number','$event_name','$house_name', '$group','$student_name','$student_dept','$gender')";

        if (mysqli_query($conn, $query)) {
            header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($event_name));
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

?>