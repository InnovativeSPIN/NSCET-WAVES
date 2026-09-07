<?php
ob_start();
require_once('../connect.php');

if (isset($_POST["submit"])) {
    $event_name         = mysqli_real_escape_string($conn, $_POST["event_name"] ?? '');
    $event_date         = mysqli_real_escape_string($conn, $_POST["event_date"] ?? '');
    $event_time         = mysqli_real_escape_string($conn, $_POST["event_time"] ?? '');
    $event_venue        = mysqli_real_escape_string($conn, $_POST["event_venue"] ?? '');
    $max_participants   = intval($_POST["max_participants"] ?? 0);
    $is_group           = intval($_POST["is_group"] ?? 0);
    $group_counts       = intval($_POST["group_counts"] ?? 0);
    $group_participants = intval($_POST["group_participants"] ?? 0);
    $allowance          = intval($_POST["allowance"] ?? 0);
    $gender             = mysqli_real_escape_string($conn, $_POST["gender"] ?? 'COMMON');
    $event_type         = mysqli_real_escape_string($conn, $_POST["event_type"] ?? 'On Stage');
    $event_rules        = mysqli_real_escape_string($conn, $_POST["event_rules"] ?? '');

    // Optional image update
    $image_sql = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $target_dir = "../../public/images/event/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($file_tmp, $target_file)) {
            $image_path = "public/images/event/" . $file_name;
            $image_sql = ", image = '$image_path'";
        }
    }

    $query = "UPDATE eventdb SET 
                event_date = '$event_date', 
                event_time = '$event_time', 
                event_venue = '$event_venue', 
                max_participants = '$max_participants', 
                is_group = '$is_group', 
                group_counts = '$group_counts', 
                group_participants = '$group_participants', 
                allowance = '$allowance', 
                gender = '$gender', 
                event_type = '$event_type', 
                event_rules = '$event_rules' 
                $image_sql 
              WHERE event_name = '$event_name'";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php?success=event_updated');
        exit;
    } else {
        echo "<script>alert('Error updating event: " . addslashes(mysqli_error($conn)) . "'); window.history.back();</script>";
        exit;
    }
} elseif (isset($_POST["delete_event"])) {
    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"] ?? '');
    $query = "DELETE FROM eventdb WHERE event_name = '$event_name'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php?success=event_deleted');
        exit;
    } else {
        header('Location: ../../pages/adminForm.php?error=' . urlencode("Error deleting event: " . mysqli_error($conn)));
        exit;
    }
}

mysqli_close($conn);
ob_end_flush();
?>

