<?php 
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_number']) && isset($_POST['group']) && isset($_POST['event_name'])) {
    $reg_number = $_POST['reg_number'];
    $group = $_POST['group'];
    $event_name = $_POST['event_name'];

    $std_details = mysqli_query($conn, "SELECT `name`, `house`, `gender`, `dept` FROM `studentdb` WHERE `reg_no`='$reg_number'");
    $data = mysqli_fetch_array($std_details);

    $house_name = $data['house'];
    $student_name = $data['name'];
    $student_dept = $data['dept'];
    $gender = $data['gender'];

    $sql = "INSERT INTO `registerationdb`(`reg_no`, `event_name`, `house_name`, `grouped`, `student_name`, `student_dept`, `gender`) VALUES ('$reg_number','$event_name','$house_name', '$group','$student_name','$student_dept','$gender')";
}
?>