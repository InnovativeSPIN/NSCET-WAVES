<?php
session_start();

include('../routes/connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House | Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/premium-dashboard.css">
</head>

<body class="premium-theme">
    <nav class="navbar navbar-expand-lg premium-navbar sticky-top">
        <a class="navbar-brand" href="#">
            <img src="../public/images/logos/waves-logo.png" alt="WAVES Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#premiumNav" aria-controls="premiumNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="premiumNav">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <button type="button" class="btn btn-action" data-toggle="modal" data-target="#assignLeadModal">
                        <i class="fas fa-user-plus mr-1"></i> Assign Lead
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-action" data-toggle="modal" data-target="#resetModal">
                        <i class="fas fa-key mr-1"></i> Password
                    </button>
                </li>
                <li class="nav-item">
                    <a href="../index.php" class="btn btn-action">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Reset Modal -->
    <div class="modal fade premium-modal" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body login-modal-body">
                    <div class="column" id="main">
                        <h3 class="mb-4 text-center">Reset Password</h3>
                        <form action="../routes/admin/captainEdit.php" method="post">

                            <div class="form-group" id='login-event-name'> <label for="event_name">
                                    <h6>House Name</h6>
                                </label> <input type="text" name="house_name" value="<?php echo $_SESSION['house_name'] ?>" readonly class="form-control">
                            </div>
                            <input type="text" value="HOUSE_CORDINATOR" name="whoUpdate" style="display: none;">
                            <div class="col-md-12 form-group"> <label for="update_password">
                                    <h6>Update Common Password</h6>
                                </label>
                                <div class="input-group"> <input type="password" name="update_password" placeholder="New Password" class="form-control " required>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-login btn-primary">Update</button>
                        </form>
                    </div>
                    <div>
                        <svg width="67px" height="480px" viewBox="0 0 67 480" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>Path</title>
                            <desc>Created with Sketch.</desc>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path d="M11.3847656,-5.68434189e-14 C-7.44726562,36.7213542 5.14322917,126.757812 49.15625,270.109375 C70.9827986,341.199016 54.8877465,443.829224 0.87109375,578 L67,578 L67,-5.68434189e-14 L11.3847656,-5.68434189e-14 Z" id="Path" fill="#0ee1e7"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="column" id="secondary">
                        <div class="sec-content">
                            <!-- <h2>Welcome Back!</h2>
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Lead Model Modal -->
    <div class="modal fade premium-modal" id="assignLeadModal" tabindex="-1" role="dialog" aria-labelledby="assignLeadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="column" id="main">
                        <h3 class="mb-4 text-center">Assign Lead</h3>
                        <?php
                        $house_name = $_SESSION['house_name'];
                        $queryHouseLeadsName = "SELECT id FROM `admindb` WHERE house_name = '$house_name'";
                        $getHouseLeadsResult = mysqli_query($conn, $queryHouseLeadsName);

                        $houseLeads = array();
                        while ($houseLead = mysqli_fetch_array($getHouseLeadsResult)) {
                            array_push($houseLeads, $houseLead['id']);
                        }
                        ?>
                        <form role="form" action="../routes/admin/captainEdit.php" method="post">

                            <input type="text" name="assignedByIncharge" value="TEAM_INCHARGE" style="display: none;" id="">
                            <div class="form-group"> <label for="house_name">
                                    <h6>House Name</h6>
                                </label> <input type="text" readonly value="<?php echo $_SESSION['house_name'] ?>" list="houseName" name="house_name" placeholder="Enter House Name" required class="form-control ">
                                <datalist id="houseName">

                                </datalist>
                            </div>

                            <div class="row">
                                <div class="col-md-12 form-group"> <label for="captain_name">
                                        <h6>Captain Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="captain_name" placeholder="Enter Captain Name" class="form-control " required>
                                        <input type="text" name="captain_number" style="display: none;" class="form-control " value="<?php echo $houseLeads[2] ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group"> <label for="vice_captain_name">
                                        <h6>Vice Captain Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="vice_captain_name" placeholder="Enter Vice Captain Name" class="form-control " required>
                                        <input type="text" name="vice_captain_number" style="display: none;" class="form-control " value="<?php echo $houseLeads[3] ?>" required>

                                    </div>
                                </div>

                                <div class="col-md-12 form-group"> <label for="vice_captain_name">
                                        <h6>Vice Captain Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="vice_vice_captain_name" placeholder="Enter Vice Captain Name" class="form-control " required>
                                        <input type="text" name="vice_vice_captain_number" style="display: none;" class="form-control " value="<?php echo $houseLeads[4] ?>" required>

                                    </div>
                                </div>

                            </div>


                            <div class="text-center mt-4"> 
                                <button type="submit" name='submit' class="btn btn-primary btn-block shadow-sm">
                                    Assign House Leads 
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div>
                    <svg width="67px" height="620px" viewBox="0 0 67 620" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>Path</title>
                        <desc>Created with Sketch.</desc>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <path d="M11.3847656,-5.68434189e-14 C-7.44726562,36.7213542 5.14322917,126.757812 49.15625,270.109375 C70.9827986,341.199016 54.8877465,443.829224 0.87109375,578 L67,578 L67,-5.68434189e-14 L11.3847656,-5.68434189e-14 Z" id="Path" fill="#0ee1e7"></path>
                        </g>
                    </svg>
                </div>
                <div class="column" id="secondary">
                    <div class="sec-content">
                        <!-- <h2>Welcome Back!</h2>
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="container mt-5">
        <div class="glass-card">
            <div class="house-profile-wrapper">
                <div class="house-logo-container">
                    <?php
                    $path = '../public/images/house/';
                    $img  = str_replace(" ", "_", $_SESSION['house_name']);
                    echo '<img src="' . $path . $img . '.png" alt="' . $_SESSION['house_name'] . ' Logo">';
                    ?>
                </div>

                <div class="house-info-container">
                    <h1><?php echo $_SESSION['house_name'] ?></h1>
                    
                    <div class="stats-grid">
                        <?php
                        $houseName = $_SESSION['house_name'];
                        $totalMembersResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM studentdb WHERE house = '$houseName'");
                        $totalMembers = mysqli_fetch_assoc($totalMembersResult);
                        ?>
                        <div class="stat-box">
                            <span class="label">Total Members</span>
                            <span class="value">
                                <?php echo $totalMembers['row_count'];
                                mysqli_free_result($totalMembersResult);
                                ?>
                            </span>
                        </div>
                        <?php
                        $registeredStudentsQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT reg_no) as row_count FROM registerationdb WHERE student_house = '$houseName'");
                        $registeredStudentsDetails = mysqli_fetch_assoc($registeredStudentsQuery);
                        ?>
                        <div class="stat-box">
                            <span class="label">Participants</span>
                            <span class="value text-info">
                                <?php echo $registeredStudentsDetails['row_count'];
                                mysqli_free_result($registeredStudentsQuery);
                                ?>
                            </span>
                        </div>

                        <?php
                        $scoreResult = mysqli_query($conn, "SELECT score FROM housedb WHERE name = '$houseName'");
                        $score = mysqli_fetch_assoc($scoreResult);
                        ?>
                        <div class="stat-box">
                            <span class="label">House Score</span>
                            <span class="value text-warning">
                                <?php echo $score['score'];
                                mysqli_free_result($scoreResult);
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="leads-section mt-4">
                        <?php
                        $house_name = $_SESSION['house_name'];
                        $queryHouseLeadsName = "SELECT name FROM `admindb` WHERE house_name = '$house_name' AND role = 'team captain' ORDER BY id ASC";
                        $getHouseLeadsResult = mysqli_query($conn, $queryHouseLeadsName);

                        $captainsList = array();
                        while ($houseLead = mysqli_fetch_array($getHouseLeadsResult)) {
                            $captainsList[] = $houseLead['name'];
                        }
                        ?>
                        <h3><i class="fas fa-crown mr-2 text-warning"></i>Student House Leads</h3>
                        <div class="leads-list">
                            <?php if (isset($captainsList[0])): ?>
                                <p>Captain: <span><?php echo htmlspecialchars($captainsList[0]); ?></span></p>
                            <?php endif; ?>
                            <?php if (isset($captainsList[1])): ?>
                                <p>Vice Captain: <span><?php echo htmlspecialchars($captainsList[1]); ?></span></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="cta-section d-flex flex-column gap-2" style="gap: 10px;">
                    <form action="../routes/pdf/HousepdfGen.php" method="post" class="w-100">
                        <input type="text" style="display: none;" value="<?php echo $houseName ?>" name='house'>
                        <button class="btn btn-action w-100 m-0"><i class="fas fa-file-pdf mr-1 text-danger"></i> House Data Export</button>
                    </form>
                    <form action="../routes/pdf/EventpdfGen.php" method="post" class="w-100">
                        <input type="text" style="display: none;" value="<?php echo $houseName ?>" name='house'>
                        <button class="btn btn-action w-100 m-0"><i class="fas fa-file-export mr-1 text-success"></i> Event Data Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- table -->

    <div class="container mb-5">
        <div class="premium-table-container">
            <div class="title-area">
                <h4 class="title"><i class="fas fa-calendar-alt mr-2 text-warning"></i>Event Details</h4>
            </div>
            <div class="table-responsive">
                <table class="premium-table">
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

                                    if ($event['is_group'] >= 1) {
                                        $SpecificEventRegStuCountResult = mysqli_query($conn, "SELECT COUNT(DISTINCT grouped) as row_count FROM registerationdb WHERE student_house = '$houseName' AND event_name = '$eventName' AND grouped > 0");
                                    } else {
                                        $SpecificEventRegStuCountResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM registerationdb WHERE student_house = '$houseName' AND event_name = '$eventName'");
                                    }
                                    
                                    if ($SpecificEventRegStuCountResult) {
                                        $registeredParticipants = mysqli_fetch_assoc($SpecificEventRegStuCountResult);
                                        $registeredParticipants = $registeredParticipants['row_count'];
                                    } else {
                                        $registeredParticipants = 0;
                                    }
                                    
                                    $allowance = $event['max_participants'] - $registeredParticipants;

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
                                            <?php echo $allowance ?>
                                        </td>
                                        <td>
                                            <?php echo $isGroup ?>
                                        </td>
                                        <td>
                                            <?php echo $event['group_counts'] ?>
                                        </td>

                                        <td>
                                            <?php if ($allowance > 0) { ?>
                                                <a href="studentRegisteration.php?eventName=<?php echo urlencode($eventName); ?>" class="btn btn-primary btn-sm">Assign Member</a>
                                            <?php } else { ?>
                                                <span class="badge badge-secondary">Full</span>
                                            <?php } ?>
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

    <!-- student details table -->

    <div class="container mb-5">
        <div class="premium-table-container">
            <div class="title-area">
                <h4 class="title"><i class="fas fa-users mr-2 text-info"></i>Student Details</h4>
            </div>
            <div class="table-responsive">
                <table class="premium-table">
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

        const interval = setInterval(function() {
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