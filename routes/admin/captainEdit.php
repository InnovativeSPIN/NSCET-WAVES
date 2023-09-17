<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $house_name = mysqli_real_escape_string($conn, $_POST["house_name"]);
    $houseNameQuery = "SELECT name FROM admindb WHERE house_name = '$house_name'";
    $result = mysqli_query($conn, $houseNameQuery);

    if (!$result) {
        die("Error executing the query: " . mysqli_error($conn));
    }

    $names = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $names[] = $row['name'];
    }

    if (isset($names[0])) {
        $incharge_name_1 = $names[0];
    }
    if (isset($names[1])) {
        $incharge_name_2 = $names[1];
    }
    if (isset($names[2])) {
        $captain_name = $names[2];
    }
    if (isset($names[3])) {
        $vice_captain_name = $names[3];
    }

    $update_password = mysqli_real_escape_string($conn, $_POST["update_password"]);
    $hashed_password = password_hash($update_password, PASSWORD_DEFAULT);
    
    $query1 = "UPDATE admindb SET password = '$hashed_password' WHERE name = '$incharge_name_1'";
    $query2 = "UPDATE admindb SET password = '$hashed_password' WHERE name = '$incharge_name_2'";
    $query3 = "UPDATE admindb SET password = '$hashed_password' WHERE name = '$captain_name'";
    $query4 = "UPDATE admindb SET password = '$hashed_password' WHERE name = '$vice_captain_name'";

    if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3) && mysqli_query($conn, $query4)) {
        header('Location: ../../pages/adminForm.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
ob_end_flush();
?>