<?php
ob_start();
include('../connect.php');

if (isset($_POST["submit"])) {

    // Check if image input exists
    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] === UPLOAD_ERR_NO_FILE) {
        header('Location: ../../pages/adminForm.php?error=' . urlencode("No image file was selected. Please choose an event poster image."));
        exit;
    }

    $error_code = $_FILES["image"]["error"];

    if ($error_code !== UPLOAD_ERR_OK) {
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE   => 'Image exceeds server max upload size. Use a smaller image (max 5MB).',
            UPLOAD_ERR_FORM_SIZE  => 'Image exceeds max allowed size. Use a smaller image (max 5MB).',
            UPLOAD_ERR_PARTIAL    => 'Image was only partially uploaded. Please try again.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server error: Missing temp folder. Contact admin.',
            UPLOAD_ERR_CANT_WRITE => 'Server error: Cannot write file to disk. Contact admin.',
            UPLOAD_ERR_EXTENSION  => 'Server extension blocked the upload. Contact admin.',
        ];
        $msg = isset($upload_errors[$error_code]) ? $upload_errors[$error_code] : "Unknown upload error (code: {$error_code}).";
        header('Location: ../../pages/adminForm.php?error=' . urlencode($msg));
        exit;
    }

    $file_name = basename($_FILES["image"]["name"]);
    $file_size = $_FILES["image"]["size"];
    $file_tmp  = $_FILES["image"]["tmp_name"];
    $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate size (max 5MB)
    $max_size = 5 * 1024 * 1024;
    if ($file_size > $max_size) {
        $size_mb = round($file_size / (1024 * 1024), 2);
        header('Location: ../../pages/adminForm.php?error=' . urlencode("Image too large ({$size_mb}MB). Maximum allowed: 5MB."));
        exit;
    }

    // Validate format
    $allowed = ['jpg','jpeg','png','gif','webp'];
    if (!in_array($imageFileType, $allowed)) {
        header('Location: ../../pages/adminForm.php?error=' . urlencode("Invalid format (.{$imageFileType}). Allowed: JPG, PNG, GIF, WEBP."));
        exit;
    }

    // Validate it's a real image
    if (getimagesize($file_tmp) === false) {
        header('Location: ../../pages/adminForm.php?error=' . urlencode("File is not a valid image."));
        exit;
    }

    // Build target path
    $target_dir = dirname(__FILE__) . '/../../public/images/event/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle duplicate filenames
    $target_file = $target_dir . $file_name;
    if (file_exists($target_file)) {
        $name_base = pathinfo($file_name, PATHINFO_FILENAME);
        $file_name = $name_base . '_' . time() . '.' . $imageFileType;
        $target_file = $target_dir . $file_name;
    }

    // Move uploaded file
    if (!move_uploaded_file($file_tmp, $target_file)) {
        header('Location: ../../pages/adminForm.php?error=' . urlencode("Failed to save image. Target: " . realpath($target_dir)));
        exit;
    }

    // Sanitize inputs
    $event_name         = mysqli_real_escape_string($conn, $_POST["event_name"] ?? '');
    $event_id           = mysqli_real_escape_string($conn, $_POST["event_id"] ?? '');
    $event_date         = mysqli_real_escape_string($conn, $_POST["event_date"] ?? '');
    $event_time         = mysqli_real_escape_string($conn, $_POST["event_time"] ?? '');
    $event_venue        = mysqli_real_escape_string($conn, $_POST["event_venue"] ?? '');
    $max_participants   = mysqli_real_escape_string($conn, $_POST["max_participants"] ?? '0');
    $is_group           = mysqli_real_escape_string($conn, $_POST["is_group"] ?? '0');
    $group_counts       = mysqli_real_escape_string($conn, $_POST["group_counts"] ?? '0');
    $group_participants = mysqli_real_escape_string($conn, $_POST["group_participants"] ?? '0');
    $allowance          = mysqli_real_escape_string($conn, $_POST["allowance"] ?? '0');
    $gender             = mysqli_real_escape_string($conn, $_POST["gender"] ?? 'COMMON');
    $image              = mysqli_real_escape_string($conn, $file_name);
    $event_type         = mysqli_real_escape_string($conn, $_POST["event_type"] ?? 'On Stage');
    $event_rules        = mysqli_real_escape_string($conn, $_POST["event_rules"] ?? '');

    $query = "INSERT INTO eventdb VALUES('$event_name','$event_id','$event_date','$event_time','$event_venue','$max_participants','$is_group','$group_counts','$group_participants','$allowance','$gender','public/images/event/$image','$event_type','$event_rules','-')";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../pages/adminForm.php?success=event_added');
        exit;
    } else {
        header('Location: ../../pages/adminForm.php?error=' . urlencode('Database error: ' . mysqli_error($conn)));
        exit;
    }
}

mysqli_close($conn);
ob_end_flush();
?>
