<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $event_name          = mysqli_real_escape_string($conn, $_POST["event_name"] ?? '');
    $coordinator_name_1  = mysqli_real_escape_string($conn, $_POST["coordinator_name_1"] ?? '');
    $coordinator_reg_no_1= mysqli_real_escape_string($conn, $_POST["coordinator_reg_no_1"] ?? '-');
    $staff_dept_1        = mysqli_real_escape_string($conn, $_POST["staff_dept_1"] ?? '');

    $coordinator_name_2  = mysqli_real_escape_string($conn, $_POST["coordinator_name_2"] ?? '');
    $coordinator_reg_no_2= mysqli_real_escape_string($conn, $_POST["coordinator_reg_no_2"] ?? '-');
    $staff_dept_2        = mysqli_real_escape_string($conn, $_POST["staff_dept_2"] ?? '');

    $password            = trim($_POST["password"] ?? '');

    if (empty($event_name) || empty($coordinator_name_1) || empty($password)) {
        echo "<script>alert('Event name, Coordinator name, and Password are required!'); window.history.back();</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query1 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) 
               VALUES ('$coordinator_name_1', '$staff_dept_1', '$coordinator_reg_no_1', 'event coordinator', '$hashed_password', '$event_name', '-')";
    $ok1 = mysqli_query($conn, $query1);

    $ok2 = true;
    if (!empty($coordinator_name_2)) {
        $query2 = "INSERT INTO `admindb`(`name`, `dept`, `reg_no`, `role`, `password`, `event_name`, `house_name`) 
                   VALUES ('$coordinator_name_2', '$staff_dept_2', '$coordinator_reg_no_2', 'event coordinator', '$hashed_password', '$event_name', '-')";
        $ok2 = mysqli_query($conn, $query2);
    }

    $coordinators = $coordinator_name_1 . '|' . $coordinator_name_2;
    $query3 = "UPDATE eventdb SET event_cordinators = '$coordinators' WHERE event_name = '$event_name'";
    $ok3 = mysqli_query($conn, $query3);

    if ($ok1 && $ok2 && $ok3) {
        header('Location: ../../pages/adminForm.php?success=coordinator_assigned#assign-coordinator');
        exit;
    } else {
        echo "Error assigning coordinator: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>