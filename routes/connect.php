<?php
// Database connection configuration
$db_host = 'localhost';
// $db_user = 'waves_user';
// $db_pass = 'waves2026';
$db_user ="root";
$db_pass="root";
$db_name = 'nscet_waves_25';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die('Connection Error: ' . mysqli_connect_error());
}
?>
