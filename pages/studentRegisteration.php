<?php
session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /');
    exit();
}
$eventName = $_GET['eventName'];

include('../routes/connect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/houseDashboardStyles.css">

</head>

<body>
    <div class="card dark gradient-border">

        <?php
        $houseName = $_SESSION['house_name'];
        
        $eventsResult = mysqli_query($conn, "SELECT * FROM eventdb WHERE event_name = '$eventName'");
        $event = mysqli_fetch_assoc($eventsResult);

        $eventName = $event['event_name'];
        $houseName = mysqli_real_escape_string($conn, $houseName);
        $eventName = mysqli_real_escape_string($conn, $eventName);
        $eventCoordinatorResult = mysqli_query($conn, "SELECT name from admindb WHERE role = 'event coordinator' AND event_name = '$eventName'");
        $eventCoordinator = mysqli_fetch_assoc($eventCoordinatorResult);

        $SpecificEventRegStuCountResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM registerationdb WHERE student_house = '$houseName' AND event_name = '$eventName'");
        if ($SpecificEventRegStuCountResult) {
            $registeredParticipants = mysqli_fetch_assoc($SpecificEventRegStuCountResult);
            $registeredParticipants = $registeredParticipants['row_count'];
        } else {
            $registeredParticipants = 0;
        }

        if ($event['is_group'] == 1) {
            $isGroup = 'Yes';
        } else {
            $isGroup = 'No';
        }

        ?>
        <img src="<?php echo '../' . $event['image'] ?>" class="card-img-top" alt="...">

        <div class="card-body">
            <div class="text-section">
                <h1 class='card-title'>
                    <?php echo $eventName ?>
                </h1>
                <h5 class="card-text">
                    Max Participants :
                    <?php echo $event['max_participants']?>
                </h5>
                <h5 class="card-text">
                    Registered Participants :
                    <?php echo $registeredParticipants ?>
                </h5>
                <h5 class="card-text">
                    Allowance :
                    <?php echo $event['max_participants'] - $registeredParticipants?>
                </h5>
                <h5 class="card-text">
                    Group Event :
                    <?php echo $isGroup ?>
                </h5>
                <h5 class="card-text">
                    Group Count :
                    <?php echo $event['group_counts'] ?>
                </h5>
            </div>

        </div>
    </div>
</body>

</html>