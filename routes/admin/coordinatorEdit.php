<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {
    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);

    $eventQuery = "SELECT name FROM admindb WHERE event_name = '$event_name'";
    $result = mysqli_query($conn, $eventQuery);

    if (!$result) {
        die("Error executing the query: " . mysqli_error($conn));
    }

    $names = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $names[] = $row['name'];
    }
    if (isset($names[0])) {
        $coordinator_name_1 = $names[0];
    }
    if (isset($names[1])) {
        $coordinator_name_2 = $names[1];
    }

    $update_password = mysqli_real_escape_string($conn, $_POST["update_password"]);
    $hashed_password = password_hash($update_password, PASSWORD_DEFAULT);

    $query1 = "UPDATE admindb SET password = '$hashed_password' WHERE name = '$coordinator_name_1'";
    $query2 = "UPDATE admindb SET password = '$hashed_password' WHERE name = '$coordinator_name_2'";

    if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
        if($_POST['whoUpdate']){
            header('Location: ../../pages/eventCoordinatorDashboard.php');

        }else{
            header('Location: ../../pages/adminForm.php');

        }
    }
}

mysqli_close($conn);
ob_end_flush();
?>