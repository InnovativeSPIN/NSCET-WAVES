<?php
    include('../connect.php');
?>

<?php
$target_dir = "../public/images/event/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    // $check = getimagesize($_FILES["file"]["tmp_name"]);
    // if ($check !== false) {
    //     echo "File is an image - " . $check["mime"] . ".";
    //     $uploadOk = 1;
    // } else {
    //     echo "File is not an image.";
    //     $uploadOk = 0;
    // }

    // $result = mysqli_query($conn, "SELECT * FROM `eventdb`");
    // $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // mysqli_free_result($result);
    // mysqli_close($conn);

    $event_name = mysqli_real_escape_string($conn,$_POST["event_name"]);
    $event_id = mysqli_real_escape_string($conn,$_POST["event_id"]);
    $event_date = mysqli_real_escape_string($conn,$_POST["event_date"]);
    $event_time = mysqli_real_escape_string($conn,$_POST["event_time"]);
    $event_venue = mysqli_real_escape_string($conn,$_POST["event_venue"]);
    $max_participants = mysqli_real_escape_string($conn,$_POST["max_participants"]);
    $is_group = mysqli_real_escape_string($conn,$_POST["is_group"]);
    $group_counts = mysqli_real_escape_string($conn,$_POST["group_counts"]);
    $group_participants = mysqli_real_escape_string($conn,$_POST["group_participants"]);
    $allowance = mysqli_real_escape_string($conn,$_POST["allowance"]);
    $gender = mysqli_real_escape_string($conn,$_POST["gender"]);
    $image = mysqli_real_escape_string($conn,$_POST["image"]);
    $event_type = mysqli_real_escape_string($conn,$_POST["event_type"]);
    $event_rules = mysqli_real_escape_string($conn,$_POST["event_rules"]);

    $query = "INSERT INTO eventdb VALUES('$event_name','$event_id','$event_date','$event_time','$event_venue','$max_participants','$is_group','$group_counts','$group_participants','$allowance','$gender','$image','$event_type','$event_rules')";

    if(mysqli_query($conn, $query)){
        echo 'inserted';
        header('Location: ../../index.php');
    }else{
        echo 'query error: '. mysqli_error($conn);
    }


}

?>