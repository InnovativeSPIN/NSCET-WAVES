<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $coordinator_reg_no = mysqli_real_escape_string($conn, $_POST["coordinator_reg_no"]);
    $update_password = mysqli_real_escape_string($conn, $_POST["update_password"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE admindb SET password = '$hashed_password' WHERE reg_no = '$coordinator_reg_no'";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>