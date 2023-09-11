<?php
session_start();

if (!isset($_SESSION['role']) && !isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /');
    exit();
}

include('../routes/connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House | Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/houseDashboardStyles.css">
</head>

<body>
    <div class="card dark">
        <img src="https://codingyaar.com/wp-content/uploads/chair-image.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <div class="text-section">
                <h1 class='card-title'>
                    <?php echo $_SESSION['house_name'] ?>
                </h1>
                <h5 class="card-text">
                    Team Captain:
                    <?php echo $_SESSION['name'] ?>
                </h5>
                    <!-- <h5 class="card-text">
                        Vice Captain:
                    </h5> -->
                <?php
                $houseName = $_SESSION['house_name'];
                $totalMembersResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM studentdb WHERE house = '$houseName'");
                $totalMembers = mysqli_fetch_assoc($totalMembersResult);
                ?>
                <h5 class="card-text">Total Members: 
                    <?php echo $totalMembers['row_count'];
                        mysqli_free_result($totalMembersResult);
                    ?>
                </h5>
                <?php
                $registeredStudentsQuery = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM registerationdb WHERE student_house = '$houseName'");
                $registeredStudentsDetails = mysqli_fetch_assoc($registeredStudentsQuery);
                ?>
                <h5 class="card-text">Participants Count:
                    <?php echo $registeredStudentsDetails['row_count'];
                    mysqli_free_result($registeredStudentsQuery);
                    ?>
                </h5>
            </div>
            <div class="cta-section">
            <?php
                $scoreResult = mysqli_query($conn, "SELECT score FROM housedb WHERE name = '$houseName'");
                $score = mysqli_fetch_assoc($scoreResult);
                ?>
                <div>Score: 
                    <?php echo $score['score'];
                        mysqli_free_result($scoreResult);
                    ?>
                </div>
                <!-- <a href="#" class="btn btn-light">Buy Now</a> -->
            </div>
        </div>
    </div>

    <!-- table -->

    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">Event <span>Details</span></h4>
                            </div>
                            <!-- <div class="col-sm-9 col-xs-12 text-right">
                                <div class="btn_group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <button class="btn btn-default" title="Reload"><i
                                            class="fa fa-sync-alt"></i></button>
                                    <button class="btn btn-default" title="Pdf"><i class="fa fa-file-pdf"></i></button>
                                    <button class="btn btn-default" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Event Name</th>
                                    <th>Event Coordinator</th>
                                    <th>Max Participants</th>
                                    <th>Registered Participants</th>
                                    <th>Group</th>
                                    <th>Group Count</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $genderResult = mysqli_query($conn, "SELECT gender FROM housedb WHERE name = '$houseName'");
                                $gender = mysqli_fetch_assoc($genderResult);
                                $gender = $gender['gender'];
                                mysqli_free_result($genderResult);


                                $eventsResult = mysqli_query($conn, "SELECT * FROM eventdb WHERE gender = '$gender' UNION SELECT * FROM eventdb WHERE gender = 'COMMON'");
                                $i = 1;
                                while ($event = mysqli_fetch_assoc($eventsResult)) {

                                    $eventName = $event['event_name'];
                                    $houseName = mysqli_real_escape_string($conn, $houseName);
                                    $eventName = mysqli_real_escape_string($conn, $eventName);
                                    $eventCoordinatorResult = mysqli_query($conn, "SELECT name from admindb WHERE role = 'event coordinator' AND event_name = '$eventName'");
                                    $eventCoordinator = mysqli_fetch_assoc($eventCoordinatorResult);

                                    $SpecificEventRegStuCountResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM registerationdb WHERE student_house = '$houseName' AND event_name = '$eventName'");
                                    $registeredParticipants = mysqli_fetch_assoc($SpecificEventRegStuCountResult);

                                    if ($event['is_group'] == 1) {
                                        $isGroup = 'Yes';
                                    } else {
                                        $isGroup = 'No';
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++ ?>
                                        </td>
                                        <td>
                                            <?php echo $eventName ?>
                                        </td>
                                        <td>
                                            <?php if (isset($eventCoordinator['name'])) {
                                                echo $eventCoordinator['name'];
                                            } else {
                                                echo 'Not Assigned !';
                                            } ?>
                                        </td>
                                        <td>
                                            <?php echo $event['max_participants'] ?>
                                        </td>
                                        <td>
                                            <?php echo $registeredParticipants['row_count'] ?>
                                        </td>
                                        <td>
                                            <?php echo $isGroup ?>
                                        </td>
                                        <td>
                                            <?php echo $event['group_counts'] ?>
                                        </td>

                                        <td>
                                            <ul class="action-list">
                                                <li><a href="#" data-tip="edit"><i class="fa fa-edit"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <?php
                                    mysqli_free_result($eventCoordinatorResult);
                                    mysqli_free_result($SpecificEventRegStuCountResult);
                                }
                                mysqli_free_result($eventsResult);
                                ?>
                            </tbody>
                        </table>
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