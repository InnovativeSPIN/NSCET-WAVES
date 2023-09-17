<?php
ob_start();
include('../connect.php');
?>

<?php

if (isset($_POST["submit"])) {

    $slot_array = mysqli_real_escape_string($conn, $_POST["slot_array"]);
    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);

    $slot = explode(",", $slot_array);

    if ($gender == 'GIRLS') {
        $teams = array("BLUE BLASTERS", "GALACTIC STARS", "ROSY RIDERS", "VIOLET VIPERS");
    }

    if ($gender == 'BOYS') {
        $teams = array("DINO THUNDERS", "DRAGON WARRIORS", "PHOENIX BLASTERS", "TIGER THRASHERS");
    }


    if (count($slot) == 4) {
        for ($i = 0; $i < count($slot); $i++) {
            
            $slotNo = $slot[$i];

            // group_count - is fixed to 2. further may increase
            $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$teams[$i]', '$event_name', 0, 0, 0, $slotNo, '$gender')";
            mysqli_query($conn, $query);
            echo "Error : " . mysqli_error($conn);
        }
    }


    if (count($slot) == 8) {
        $groupedAllotment = array_chunk($slot, 4);

        for ($i = 0; $i < count($groupedAllotment); $i++) {
            for ($j = 0; $j < count($groupedAllotment[$i]); $j++) {

                $slotNo = $groupedAllotment[$i][$j];

                // group_count - is fixed to 2. further may increase
                $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$teams[$j]', '$event_name', 1, 2, $i+1, $slotNo, '$gender')";
                mysqli_query($conn, $query);
                echo "Error : " . mysqli_error($conn);
            }
        }
    }
}
mysqli_close($conn);
ob_end_flush();
?>