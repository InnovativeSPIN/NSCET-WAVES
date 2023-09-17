<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    if ($_POST["assignedByIncharge"]) {
        $captainNumber = $_POST['captain_number'];
        $captainName = $_POST['captain_name'];

        $vicecaptainNumber = $_POST['vice_captain_number'];
        $vicecaptainName = $_POST['vice_captain_name'];


        $query1 = "UPDATE admindb SET name = '$captainName' WHERE id = '$captainNumber'";
        $query2 = "UPDATE admindb SET name = '$vicecaptainName' WHERE id = '$vicecaptainNumber'";

        if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
            if ($_POST['assignedByIncharge']) {
                header('Location: ../../pages/houseDashboard.php');
            } else {
                header('Location: ../../pages/adminForm.php');
            }
        }else{
            die("Error executing the query: " . mysqli_error($conn));
        }

    } else {
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
            if ($_POST['whoUpdate']) {
                header('Location: ../../pages/houseDashboard.php');
            } else {
                header('Location: ../../pages/adminForm.php');
            }
        }
    }
}

mysqli_close($conn);
ob_end_flush();
?>