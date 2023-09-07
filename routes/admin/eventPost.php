<?php
include('../connect.php');
?>

<?php

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {

    // check the file is uploaded
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $file_name = $_FILES["image"]["name"];
        $target_dir = "../../public/images/event/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // check the upload file is image format or not
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            echo 'Please upload image formats only';
        }

        if ($uploadOk === 1) {

            // check the file is already uploaded or not
            if (file_exists($target_file)) {
                echo "File already exists.";
            } else {

                // migrate the upload file to public folder
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

                    // for preventing sql attack
                    $event_name = mysqli_real_escape_string($conn, $_POST["event_name"]);
                    $event_id = mysqli_real_escape_string($conn, $_POST["event_id"]);
                    $event_date = mysqli_real_escape_string($conn, $_POST["event_date"]);
                    $event_time = mysqli_real_escape_string($conn, $_POST["event_time"]);
                    $event_venue = mysqli_real_escape_string($conn, $_POST["event_venue"]);
                    $max_participants = mysqli_real_escape_string($conn, $_POST["max_participants"]);
                    $is_group = mysqli_real_escape_string($conn, $_POST["is_group"]);
                    $group_counts = mysqli_real_escape_string($conn, $_POST["group_counts"]);
                    $group_participants = mysqli_real_escape_string($conn, $_POST["group_participants"]);
                    $allowance = mysqli_real_escape_string($conn, $_POST["allowance"]);
                    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
                    $image = mysqli_real_escape_string($conn, $_FILES["image"]["name"]);
                    $event_type = mysqli_real_escape_string($conn, $_POST["event_type"]);
                    $event_rules = mysqli_real_escape_string($conn, $_POST["event_rules"]);

                    // insert the data
                    $query = "INSERT INTO eventdb VALUES('$event_name','$event_id','$event_date','$event_time','$event_venue','$max_participants','$is_group','$group_counts','$group_participants','$allowance','$gender','public/images/event/$image','$event_type','$event_rules')";

                    if (mysqli_query($conn, $query)) {
                        header('Location: adminForm.php');
                    } else {
                        echo 'query error: ' . mysqli_error($conn);
                    }

                } else {
                    echo "Error uploading file.";
                }
            }
        }
    } else {
        echo "Error uploading file. Error code: " . $_FILES["image"]["error"];
    }

}

mysqli_close($conn);

?>