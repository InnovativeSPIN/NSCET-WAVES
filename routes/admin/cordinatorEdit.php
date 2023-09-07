<?php
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $cordinator_name = mysqli_real_escape_string($conn, $_POST["cordinator_name"]);
    $update_password = mysqli_real_escape_string($conn, $_POST["update_password"]);

    $query = "UPDATE admindb SET password = '$update_password' WHERE name = '$cordinator_name'";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>