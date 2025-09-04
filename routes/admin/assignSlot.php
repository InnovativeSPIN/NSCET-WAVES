<?php
ob_start();
include('../connect.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug output for received POST data
    // echo '<pre style="background:#222;color:#fff;padding:1em;">';
    // echo "Received POST data:\n";
    // print_r($_POST);
    // echo "\nDecoded slot_array:\n";
    // print_r(json_decode($_POST['slot_array'], true));
    // echo '</pre>';

    $slot_array = isset($_POST["slot_array"]) ? mysqli_real_escape_string($conn, $_POST["slot_array"]) : null;
    $event_name = isset($_POST["event_name"]) ? mysqli_real_escape_string($conn, $_POST["event_name"]) : null;
    $gender = isset($_POST["gender"]) ? mysqli_real_escape_string($conn, $_POST["gender"]) : null;

    $slot = $slot_array ? json_decode($slot_array, true) : null;

    if ($slot_array === null || $event_name === null || $gender === null) {
        echo '<div style="color:red;background:#fff;padding:1em;">Error: Missing required POST data.<br>slot_array: '.var_export($slot_array, true).'<br>event_name: '.var_export($event_name, true).'<br>gender: '.var_export($gender, true).'</div>';
        exit;
    }

    // Team names
    $teams_girls = array("BLUE BLASTERS", "GALACTIC STARS", "ROSY RIDERS", "VIOLET VIPERS", "EMERALD EAGLES");
    $teams_boys = array("DINO THUNDERS", "DRAGON WARRIORS", "PHOENIX BLASTERS", "TIGER THRASHERS");

    // Insert all slots as received from frontend
    if ($gender == 'GIRLS') {
        $teams = $teams_girls;
    } else if ($gender == 'BOYS') {
        $teams = $teams_boys;
    } else {
        $teams = array_merge($teams_girls, $teams_boys);
    }

    // Determine group logic based on slot count
    $slotCount = count($slot);
    $isGroup = ($slotCount > count($teams)) ? 1 : 0;
    $group_count = $isGroup ? 2 : 0;

    for ($i = 0; $i < $slotCount; $i++) {
        $slotNo = $slot[$i];
        // Assign team cyclically
        $team = $teams[$i % count($teams)];
        $grouped = $isGroup ? (int)floor($i / count($teams)) + 1 : 0;
        $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$team', '$event_name', $isGroup, $group_count, $grouped, $slotNo, '$gender')";
        if (!mysqli_query($conn, $query)) {
            echo '<div style="color:red;background:#fff;padding:1em;">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
        }
    }

    // Redirect after insert
    if ($isGroup) {
        header('Location: ../../allotment/grouped.php?eventName=' . urlencode($_POST["event_name"]));
        exit;
    } else {
        header('Location: ../../allotment/ungrouped.php?eventName=' . urlencode($_POST["event_name"]));
        exit;
    }
}
mysqli_close($conn);
ob_end_flush();
?>