<?php

$conn = mysqli_connect('localhost', 'root', '', 'waves_23');        // make sql db connection
if (!$conn) {
    echo 'Connection Error  ' . mysqli_connect_error();
}

?>