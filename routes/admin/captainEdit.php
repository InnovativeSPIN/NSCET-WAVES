<?php
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $captain_number = mysqli_real_escape_string($conn, $_POST["captain_number"]);
    $update_password = mysqli_real_escape_string($conn, $_POST["update_password"]);

    $query = "UPDATE admindb SET password = '$update_password' WHERE reg_no = '$captain_number'";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>