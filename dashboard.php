<?php
session_start();

if (!isset($_SESSION['role']) && !isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /'); 
    exit();
}

print_r($_SESSION);
echo 'success !';

?>