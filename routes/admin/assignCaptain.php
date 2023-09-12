<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $house_name = mysqli_real_escape_string($conn, $_POST["house_name"]);
    $captain_name = mysqli_real_escape_string($conn, $_POST["captain_name"]);
    $captain_number = mysqli_real_escape_string($conn, $_POST["captain_number"]);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $dept = mysqli_real_escape_string($conn, $_POST["dept"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admindb VALUES('$captain_name','$dept','$role','$captain_number','$hashed_password','-','$house_name')";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>