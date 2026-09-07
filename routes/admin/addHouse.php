<?php
require_once('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $house_name = isset($_POST['house_name']) ? trim($_POST['house_name']) : '';
    $house_id = isset($_POST['house_id']) ? intval($_POST['house_id']) : 0;
    $score = isset($_POST['score']) ? intval($_POST['score']) : 0;
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : 'M';

    if (empty($house_name)) {
        echo "<script>alert('House name is required!'); window.history.back();</script>";
        exit;
    }

    // Handle file upload for house logo
    $image_path = 'public/images/logos/waves-logo.png'; // default fallback

    if (isset($_FILES['house_logo']) && $_FILES['house_logo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['house_logo']['tmp_name'];
        $file_name = $_FILES['house_logo']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_exts = ['png', 'jpg', 'jpeg', 'webp', 'svg'];
        if (in_array($file_ext, $allowed_exts)) {
            // Normalize filename: uppercase/clean house name or unique timestamp
            $clean_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', strtoupper($house_name));
            $new_filename = $clean_name . '_' . time() . '.' . $file_ext;
            
            $target_dir = '../../public/images/house/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . $new_filename;
            if (move_uploaded_file($file_tmp, $target_file)) {
                $image_path = 'public/images/house/' . $new_filename;
            }
        }
    }

    // Check if house_id is provided or generate next available ID
    if ($house_id <= 0) {
        $id_query = "SELECT MAX(id) AS max_id FROM housedb";
        $id_res = mysqli_query($conn, $id_query);
        if ($id_res && $row = mysqli_fetch_assoc($id_res)) {
            $house_id = ($row['max_id'] ? intval($row['max_id']) : 0) + 1;
        } else {
            $house_id = 1;
        }
    }

    // Prepare insert
    $stmt = mysqli_prepare($conn, "INSERT INTO housedb (name, id, score, gender, image) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "siiss", $house_name, $house_id, $score, $gender, $image_path);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('House added successfully!'); window.location.href='../../pages/adminForm.php';</script>";
        } else {
            $err = mysqli_error($conn);
            echo "<script>alert('Error adding house: " . addslashes($err) . "'); window.history.back();</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Database prepare error'); window.history.back();</script>";
    }
} else {
    header("Location: ../../pages/adminForm.php");
    exit;
}
?>
