<?php
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ID'])) {
    $reg_number = $_GET['ID'];

    if (mysqli_query($conn, "DELETE FROM `registerationdb` WHERE `id` = '$reg_number'")) {
        header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($_GET['eventName']));
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>