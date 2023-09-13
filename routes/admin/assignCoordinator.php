<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $coordinator_name_1 = mysqli_real_escape_string($conn, $_POST["coordinator_name_1"]);
    $coordinator_name_2 = mysqli_real_escape_string($conn, $_POST["coordinator_name_2"]);
    $staff_dept_1 = mysqli_real_escape_string($conn, $_POST["staff_dept_1"]);
    $staff_dept_2 = mysqli_real_escape_string($conn, $_POST["staff_dept_2"]);

    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query1 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) VALUES ('$coordinator_name_1','$staff_dept_1','-','event coordinator','$hashed_password','$event_name','-')";
    $query2 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) VALUES ('$coordinator_name_2','$staff_dept_2','-','event coordinator','$hashed_password','$event_name','-')";

    if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>