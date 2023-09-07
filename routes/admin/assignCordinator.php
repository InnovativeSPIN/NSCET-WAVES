<?php
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $cordinator_name = mysqli_real_escape_string($conn, $_POST["cordinator_name"]);
    $cordinator_reg_no = mysqli_real_escape_string($conn, $_POST["cordinator_reg_no"]);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $dept = mysqli_real_escape_string($conn, $_POST["dept"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admindb VALUES('$cordinator_name','$dept','$role','$cordinator_reg_no','$hashed_password','$event_name','-')";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>