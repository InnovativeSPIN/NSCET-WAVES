<?php

$conn = mysqli_connect('localhost', 'root', '', 'nscet_waves_25');        // make sql db connection
if (!$conn) {
    echo 'Connection Error  ' . mysqli_connect_error();
}

// $conn = mysqli_connect('localhost', 'nscet_waves_25', 'nscet_waves_25', 'nscet_waves_25');        
// if (!$conn) {
//     echo 'Connection Error  ' . mysqli_connect_error();
// }

?>