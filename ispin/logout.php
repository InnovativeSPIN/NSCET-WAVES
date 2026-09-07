<?php
session_start();
$_SESSION['ispin_admin_logged_in'] = false;
unset($_SESSION['ispin_admin_logged_in']);
unset($_SESSION['admin_user']);
unset($_SESSION['admin_auth_time']);
header("Location: index.php");
exit();
