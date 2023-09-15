<?php
session_start();

if (!isset($_SESSION['role']) && !isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /');
    exit();
}

$role = $_SESSION['role'];

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
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/houseDashboardStyles.css">


</head>

<body>
    <header class="site-header">
        <div class="header-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-10 col-lg-4">
                        <h1 class="site-branding flex">
                            <img src="../public/images/logos/waves-logo.png" alt="" class="" width="120">
                        </h1>
                    </div>
                    <div class="col-2 col-lg-8">
                        <nav class="site-navigation">
                            <div class="hamburger-menu d-lg-none">
                                <span style="background-color:black"></span>
                                <span style="background-color:black"></span>
                                <span style="background-color:black"></span>
                                <span style="background-color:black"></span>
                            </div>
                            <ul>
                                <li><a href="../index.php"><button type="button" class="btn btn-login btn-primary"
                                            data-toggle="modal" data-target="#loginModal">Logout</button></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="card dark gradient-border" style="margin-top:140px">

        <?php
        $path = '../public/images/house/';
        $img = str_replace(" ", "_", $_SESSION['house_name']);
        ?>
        <img src="<?php echo $path . $img . ".png" ?>" class="card-img-top" alt="...">

        <div class="card-body">
            <div class="text-section">
                <h1 style="color:#e22361" class='card-title'>
                    <?php echo $_SESSION['house_name'] ?>
                </h1>
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
                $registeredStudentsQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT reg_no) as row_count FROM registerationdb WHERE student_house = '$houseName'");
                $registeredStudentsDetails = mysqli_fetch_assoc($registeredStudentsQuery);
                ?>
                <h5 class="card-text">Participants Count:
                    <?php echo $registeredStudentsDetails['row_count'];
                    mysqli_free_result($registeredStudentsQuery);
                    ?>
                </h5>

                <?php
					$house_name = $_SESSION['house_name'];
					$queryHouseLeadsName = "SELECT name FROM `admindb` WHERE house_name = '$house_name'";
					$getHouseLeadsResult = mysqli_query($conn, $queryHouseLeadsName);

					$houseLeads = array();
					while ($houseLead = mysqli_fetch_array($getHouseLeadsResult)) {
						array_push($houseLeads, $houseLead['name']);
					}
					?>
                <h3 style="color:#e22361" class='card-title'> House Leads Details
                </h3>
                <h5 class="card-text">
                    House Incharges:
                    <?php echo $houseLeads[0] . ', ' . $houseLeads[1] ?>
                </h5>
                <h5 class="card-text">
                    House Captain:
                    <?php echo $houseLeads[2] ?>
                </h5>
                <h5 class="card-text">
                    House Vice Captain:
                    <?php echo $houseLeads[3] ?>
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
                                    <th>Allowance</th>
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
                                    if ($SpecificEventRegStuCountResult) {
                                        $registeredParticipants = mysqli_fetch_assoc($SpecificEventRegStuCountResult);
                                        $registeredParticipants = $registeredParticipants['row_count'];
                                    } else {
                                        $registeredParticipants = 0;
                                    }

                                    if ($event['is_group'] >= 1) {
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
                                            <?php echo $registeredParticipants ?>
                                        </td>
                                        <td>
                                            <?php echo $event['max_participants'] - $registeredParticipants ?>
                                        </td>
                                        <td>
                                            <?php echo $isGroup ?>
                                        </td>
                                        <td>
                                            <?php echo $event['group_counts'] ?>
                                        </td>

                                        <td>
                                            <ul class="action-list">
                                                <li><a href=<?php echo './studentRegisteration.php' . "?eventName=" . urlencode($eventName) ?> data-tip="edit"><i
                                                            class="fa fa-edit"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <?php
                                    mysqli_free_result($eventCoordinatorResult);
                                    if ($SpecificEventRegStuCountResult) {
                                        mysqli_free_result($SpecificEventRegStuCountResult);

                                    }
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

    <!-- student details table -->

    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">Student <span>Details</span></h4>
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
                                    <th>Register Number</th>
                                    <th>Student Name</th>
                                    <th>Department</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stuDBResult = mysqli_query($conn, "SELECT * FROM studentdb WHERE house = '$houseName'");
                                $i = 1;
                                while ($studentDetail = mysqli_fetch_assoc($stuDBResult)) {
                                    $reg_no = $studentDetail['reg_no'];
                                    $stu_name = $studentDetail['name'];
                                    $dept = $studentDetail['dept'];
                                    $year = $studentDetail['year'];

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++ ?>
                                        </td>
                                        <td>
                                            <?php echo $reg_no ?>
                                        </td>
                                        <td>
                                            <?php echo $stu_name ?>
                                        </td>
                                        <td>
                                            <?php echo $dept ?>
                                        </td>
                                        <td>
                                            <?php echo $year ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                mysqli_free_result($stuDBResult);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../public/js/coordinatordashboard.js"></script>
    <script type="text/javascript" src="../public/js/jquery.js"></script>
    <script type="text/javascript" src="../public/js/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="../public/js/jquery.collapsible.min.js"></script>
    <script type="text/javascript" src="../public/js/swiper.min.js"></script>
    <script type="text/javascript" src="../public/js/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="../public/js/circle-progress.min.js"></script>
    <script type="text/javascript" src="../public/js/jquery.countTo.min.js"></script>
    <script type="text/javascript" src="../public/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
    <script>
        const duration = 10 * 1000,
            animationEnd = Date.now() + duration,
            defaults = {
                startVelocity: 30,
                spread: 720,
                ticks: 60,
                zIndex: 0
            };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        const interval = setInterval(function () {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 20 * (timeLeft / duration);

            // since particles fall down, start a bit higher than random
            confetti(
                Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: randomInRange(0.1, 0.3),
                        y: Math.random() - 0.2
                    },
                })
            );
            confetti(
                Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: randomInRange(0.7, 0.9),
                        y: Math.random() - 0.2
                    },
                })
            );
        }, 250);
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../public/js/jquery.js"></script>
    <script src="https://kit.fontawesome.com/6a9b11d703.js" crossorigin="anonymous"></script>
</body>

</html>