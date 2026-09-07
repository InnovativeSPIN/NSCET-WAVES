<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {
    $house_name          = mysqli_real_escape_string($conn, $_POST["house_name"] ?? '');
    $captain_name        = mysqli_real_escape_string($conn, $_POST["captain_name"] ?? '');
    $captain_reg_no      = mysqli_real_escape_string($conn, $_POST["captain_reg_no"] ?? '');
    $cap_dept            = mysqli_real_escape_string($conn, $_POST["cap_dept"] ?? '');
    $vice_captain_name   = mysqli_real_escape_string($conn, $_POST["vice_captain_name"] ?? '');
    $vice_captain_reg_no = mysqli_real_escape_string($conn, $_POST["vice_captain_reg_no"] ?? '');
    $vice_cap_dept       = mysqli_real_escape_string($conn, $_POST["vice_cap_dept"] ?? '');
    $password            = trim($_POST["password"] ?? '');

    if (empty($house_name) || empty($captain_name) || empty($password)) {
        echo "<script>alert('House name, Captain name, and Password are required!'); window.history.back();</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query1 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) 
               VALUES ('$captain_name', '$cap_dept', '$captain_reg_no', 'team captain', '$hashed_password', '-', '$house_name')";

    $ok1 = mysqli_query($conn, $query1);
    $ok2 = true;

    if (!empty($vice_captain_name)) {
        $query2 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) 
                   VALUES ('$vice_captain_name', '$vice_cap_dept', '$vice_captain_reg_no', 'team captain', '$hashed_password', '-', '$house_name')";
        $ok2 = mysqli_query($conn, $query2);
    }

    if ($ok1 && $ok2) {
        header('Location: ../../pages/adminForm.php?success=house_leads_assigned#assign-house');
        exit;
    } else {
        echo "Error assigning captains: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>