<?php
ob_start();
include('../connect.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug output for received POST data
    echo '<pre style="background:#222;color:#fff;padding:1em;">';
    echo "Received POST data:\n";
    print_r($_POST);
    echo "\nDecoded slot_array:\n";
    print_r(json_decode($_POST['slot_array'], true));
    echo '</pre>';
    // Uncomment the next line to stop execution after debug
    // exit;

    $slot_array = isset($_POST["slot_array"]) ? mysqli_real_escape_string($conn, $_POST["slot_array"]) : null;
    $event_name = isset($_POST["event_name"]) ? mysqli_real_escape_string($conn, $_POST["event_name"]) : null;
    $gender = isset($_POST["gender"]) ? mysqli_real_escape_string($conn, $_POST["gender"]) : null;

    $slot = $slot_array ? json_decode($slot_array, true) : null;

    if ($slot_array === null || $event_name === null || $gender === null) {
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Missing required POST data.<br>slot_array: '.var_export($slot_array, true).'<br>event_name: '.var_export($event_name, true).'<br>gender: '.var_export($gender, true).'</div>';
        exit;
    }

    if ($gender == 'GIRLS') {
    $teams = array("BLUE BLASTERS", "GALACTIC STARS", "ROSY RIDERS", "VIOLET VIPERS", "EMERALD EAGLES");
    }

    if ($gender == 'BOYS') {
        $teams = array("DINO THUNDERS", "DRAGON WARRIORS", "PHOENIX BLASTERS", "TIGER THRASHERS");
    }


    if (count($slot) == 4) {
        for ($i = 0; $i < count($slot); $i++) {

            $slotNo = $slot[$i];

            // group_count - is fixed to 2. further may increase
            $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$teams[$i]', '$event_name', 0, 0, 0, $slotNo, '$gender')";
            if (!mysqli_query($conn, $query)) {
                echo '<div style="color:red;background:#fff;padding:1em;">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
            }
        }
        header('Location: ../../allotment/ungrouped.php?eventName=' . urlencode($_POST["event_name"]));
    }


    if (count($slot) == 8) {
        $groupedAllotment = array_chunk($slot, 4);

        for ($i = 0; $i < count($groupedAllotment); $i++) {
            for ($j = 0; $j < count($groupedAllotment[$i]); $j++) {

                $slotNo = $groupedAllotment[$i][$j];

                // group_count - is fixed to 2. further may increase
                $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$teams[$j]', '$event_name', 1, 2, $i+1, $slotNo, '$gender')";
                if (!mysqli_query($conn, $query)) {
                    echo '<div style="color:red;background:#fff;padding:1em;">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
                }
            }
        }
        header('Location: ../../allotment/grouped.php?eventName=' . urlencode($_POST["event_name"]));
    }

    // Handle 9 slots: 5 girls, 4 boys
    if (count($slot) == 9 && $gender == 'GIRLS') {
        $teams_girls = array("BLUE BLASTERS", "GALACTIC STARS", "ROSY RIDERS", "VIOLET VIPERS", "EMERALD EAGLES");
        $teams_boys = array("DINO THUNDERS", "DRAGON WARRIORS", "PHOENIX BLASTERS", "TIGER THRASHERS");
        // First 5 slots for girls
        for ($i = 0; $i < 5; $i++) {
            $slotNo = $slot[$i];
            $team = $teams_girls[$i];
            $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$team', '$event_name', 1, 2, 1, $slotNo, 'GIRLS')";
            if (!mysqli_query($conn, $query)) {
                echo '<div style="color:red;background:#fff;padding:1em;">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
            }
        }
        // Next 4 slots for boys
        for ($i = 5; $i < 9; $i++) {
            $slotNo = $slot[$i];
            $team = $teams_boys[$i-5];
            $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$team', '$event_name', 1, 2, 2, $slotNo, 'BOYS')";
            if (!mysqli_query($conn, $query)) {
                echo '<div style="color:red;background:#fff;padding:1em;">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
            }
        }
        header('Location: ../../allotment/grouped.php?eventName=' . urlencode($_POST["event_name"]));
    }
}
mysqli_close($conn);
ob_end_flush();
?>