<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $house_name = mysqli_real_escape_string($conn, $_POST["house_name"]);
    $coordinator_name_1 = mysqli_real_escape_string($conn, $_POST["coordinator_name_1"]);
    $coordinator_name_2 = mysqli_real_escape_string($conn, $_POST["coordinator_name_2"]);
    $captain_name = mysqli_real_escape_string($conn, $_POST["captain_name"]);
    $captain_reg_no = mysqli_real_escape_string($conn, $_POST["captain_reg_no"]);
    $vice_captain_name = mysqli_real_escape_string($conn, $_POST["vice_captain_name"]);
    $vice_captain_reg_no = mysqli_real_escape_string($conn, $_POST["vice_captain_reg_no"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query1 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) VALUES ('$coordinator_name_1','-','-','team captain','$hashed_password','-','$house_name')";
    $query2 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) VALUES ('$coordinator_name_2','-','-','team captain','$hashed_password','-','$house_name')";
    $query3 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) VALUES ('$captain_name','-','$captain_reg_no','team captain','$hashed_password','-','$house_name')";
    $query4 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) VALUES ('$vice_captain_name','-','$vice_captain_reg_no','team captain','$hashed_password','-','$house_name')";

    if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3) && mysqli_query($conn, $query4)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>