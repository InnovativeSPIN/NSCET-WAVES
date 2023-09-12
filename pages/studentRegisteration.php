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
                    <?php echo $event['max_participants'] ?>
                </h5>
                <h5 class="card-text">
                    Registered Participants :
                    <?php echo $registeredParticipants ?>
                </h5>
                <h5 class="card-text">
                    Allowance :
                    <?php echo $event['max_participants'] - $registeredParticipants ?>
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
    <?php if ($event['max_participants'] - $registeredParticipants > 0) { ?>
        <h2>Add Participant</h2>

        <div class="container" style="display: flex;justify-content: center;">
            <form style="max-width: 320px;" action="../routes/studentReg/addStudent.php" class="form-control" method="post">
                <input style="width: 90%;margin: 12px;" type="text" name="event_name" value="<?php echo $eventName ?>">

                <input style="width: 90%;margin: 12px;" placeholder="Student Reg No" type="text" name="reg_number" id="reg_number">

                <?php
                if ($event['is_group'] == 1) {
                    echo '<input style="width: 90%;margin: 12px;" placeholder="Group Number" type="text" name="group" id="group">';
                } else {
                    echo '<input type="text" name="group" value="0" id="group" hidden>';
                }
                ?>


                <button style="width: 90%;margin: 12px;" class="btn btn-primary">Add</button>
            </form>
        </div> <br><br>
    <?php } else { ?>
        <display an error>
        <?php } ?>

        <!-- table -->

        <div class="container">
            <div class="row">
                <div class="col-md-offset-1 col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="row">
                                <!-- <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">Event <span>Details</span></h4>
                            </div> -->
                                <div class="col col-sm-3 col-xs-12">
                                    <h4 class="title">Event <span>Details</span></h4>
                                </div>
                                <div class="panel-body table-responsive">

                                    <?php
                                    $house_name = $_SESSION['house_name'];
                                    $event_list = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_name`= '$eventName'");
                                    $data = mysqli_fetch_array($event_list);
                                    $event = $data['is_group'];

                                    if ($event == '0') {
                                    ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th> </th>
                                                    <th>Register Number</th>
                                                    <th>Student Name</th>
                                                    <th>Student Department</th>

                                                </tr><?
                                                        $participantsList = mysqli_query($conn, "SELECT * FROM registerationdb WHERE event_name = '$eventName' && `student_house` = '$house_name'");
                                                        $i = 1;
                                                        while ($list = mysqli_fetch_array($participantsList)) {
                                                        ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $list['reg_no'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $list['student_name'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $list['student_dept'] ?>
                                                        </td>
                                                    </tr>

                                                <?php
                                                        }
                                                ?>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                </div>
                                <?php
                                    } else {
                                        $i = 1;
                                        $k = 1;
                                        while ($i <= $data['group_counts']) {
                                            $participantsList = mysqli_query($conn, "SELECT * FROM registerationdb WHERE event_name = '$eventName' && `student_house` = '$house_name' && `grouped` = $i");
                                ?><div class="col col-sm-3 col-xs-12">
                                        <h4 class="title">Group <span><?php echo $i ?></span></h4>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Register Number</th>
                                                <th>Student Name</th>
                                                <th>Student Department</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($list = mysqli_fetch_array($participantsList)) {

                                            ?>
                                                <div class="panel-body table-responsive">

                                                    <tr>
                                                        <td>
                                                            <?php echo $k++ ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $list['reg_no'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $list['student_name'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $list['student_dept'] ?>
                                                        </td>
                                                        <td><a href=<?php echo '../routes/studentReg/removeStudentRegisteration.php' . "?ID=" . urlencode($list['id']) . "&eventName=" . urlencode($eventName) ?> data-tip="edit"><i style="color: red;" class="fa fa-trash"></i></a></td>
                                                    </tr>


                                                <?php

                                            }

                                            $i++;

                                                ?>
                                        </tbody>
                                    </table>
                            </div>

                    <?php
                                        }
                                    }

                    ?>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="../public/js/jquery.js"></script>
        <script src="https://kit.fontawesome.com/6a9b11d703.js" crossorigin="anonymous"></script>
</body>

</html>