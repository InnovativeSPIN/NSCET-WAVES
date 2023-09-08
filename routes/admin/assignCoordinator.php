<?php
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $coordinator_name = mysqli_real_escape_string($conn, $_POST["coordinator_name"]);
    $coordinator_reg_no = mysqli_real_escape_string($conn, $_POST["coordinator_reg_no"]);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $dept = mysqli_real_escape_string($conn, $_POST["dept"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admindb VALUES('$coordinator_name','$dept','$role','$coordinator_reg_no','$hashed_password','$event_name','-')";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>