<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $slot_array = mysqli_real_escape_string($conn, $_POST["slot_array"]);
    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);

    $slot = explode(",",$slot_array);
    echo $slot[0];
    echo $gender;
    echo $event_name;
}

mysqli_close($conn);
ob_end_flush();
?>