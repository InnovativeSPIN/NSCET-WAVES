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
    $isGroup_post = isset($_POST["isGroup"]) ? intval($_POST["isGroup"]) : null;
    $group_count_post = isset($_POST["group_count"]) ? intval($_POST["group_count"]) : null;

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

    $slotCount = count($slot);

    // If isGroup and group_count are set in POST (from ungrouped.php), use them. Otherwise, use old logic (grouped.php)
    if ($isGroup_post !== null && $group_count_post !== null) {
        $isGroup = $isGroup_post;
        $group_count = $group_count_post;
    } else {
        $isGroup = ($slotCount > count($teams)) ? 1 : 0;
        $group_count = $isGroup ? 2 : 0;
    }

    if ($isGroup == 0 && $group_count == 1) {
        // Assign slots per participant for ungrouped events, matching slot order to registration order per house
        $housesQuery = mysqli_query($conn, "SELECT DISTINCT student_house FROM registerationdb WHERE event_name = '$event_name' AND gender = '$gender'");
        while ($houseRow = mysqli_fetch_assoc($housesQuery)) {
            $house = $houseRow['student_house'];
            // Get all registered students for this house, event, and gender
            $studentsQuery = mysqli_query($conn, "SELECT reg_no FROM registerationdb WHERE event_name = '$event_name' AND gender = '$gender' AND student_house = '$house' ORDER BY id ASC");
            $studentIdx = 0;
            while ($studentRow = mysqli_fetch_assoc($studentsQuery)) {
                $reg_no = $studentRow['reg_no'];
                $slotNo = isset($slot[$studentIdx]) ? $slot[$studentIdx] : 0;
                $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`, `reg_no`) VALUES ('$house', '$event_name', 0, 1, 0, $slotNo, '$gender', '$reg_no')";
                if (!mysqli_query($conn, $query)) {
                    echo '<div style="color:red;background:#fff;padding:1em;">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
                    exit;
                }
                $studentIdx++;
            }
        }
    } else {
        // Grouped logic as before
        for ($i = 0; $i < $slotCount; $i++) {
            $slotNo = $slot[$i];
            $team = $teams[$i % count($teams)];
            $grouped = $isGroup ? (int)floor($i / count($teams)) + 1 : 0;
            $query = "INSERT INTO `allotmentdb`(`house`, `event`, `isGroup`, `group_count`, `grouped`, `slot`, `gender`) VALUES ('$team', '$event_name', $isGroup, $group_count, $grouped, $slotNo, '$gender')";
            if (!mysqli_query($conn, $query)) {
                echo '<div style=\"color:red;background:#fff;padding:1em;\">Error: ' . mysqli_error($conn) . '<br>Query: ' . htmlspecialchars($query) . '</div>';
            }
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