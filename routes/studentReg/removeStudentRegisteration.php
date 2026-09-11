<?php
ob_start();
session_start();
include('../connect.php');

$eventName = $_GET['eventName'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['ID'])) {
        $id = (int)$_GET['ID'];
        mysqli_query($conn, "DELETE FROM `registerationdb` WHERE `id` = '$id'");
    } elseif (isset($_GET['groupID'], $_GET['house'])) {
        $grp = (int)$_GET['groupID'];
        $house = mysqli_real_escape_string($conn, $_GET['house']);
        $safeEvent = mysqli_real_escape_string($conn, $eventName);
        mysqli_query($conn, "DELETE FROM `registerationdb` WHERE `event_name` = '$safeEvent' AND `student_house` = '$house' AND `grouped` = '$grp'");
    }
    header('Location: ../../pages/studentRegisteration.php?eventName=' . urlencode($eventName));
    exit;
}
ob_end_flush();
?>