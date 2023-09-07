<?php
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $event_date = mysqli_real_escape_string($conn, $_POST["event_date"]);
    $event_time = mysqli_real_escape_string($conn, $_POST["event_time"]);
    $event_venue = mysqli_real_escape_string($conn, $_POST["event_venue"]);
    $event_rules = mysqli_real_escape_string($conn, $_POST["event_rules"]);

    $query = "UPDATE eventdb SET event_date = '$event_date', event_time = '$event_time', event_venue = '$event_venue', event_rules = '$event_rules' WHERE event_name = '$event_name'";

    if (mysqli_query($conn, $query)) {
        header('Location: adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>