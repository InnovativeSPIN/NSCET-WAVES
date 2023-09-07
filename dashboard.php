<?php
session_start();

if (!isset($_SESSION['role']) && !isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /'); 
    exit();
}

echo 'success !';

?>