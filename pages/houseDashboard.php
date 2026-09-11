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
    <link rel="stylesheet" href="../public/css/premium-dashboard.css?v=<?= time() ?>">
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
                                        <input type="text" name="captain_number" style="display: none;" class="form-control " value="<?php echo $houseLeads[2] ?? '' ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group"> <label for="vice_captain_name">
                                        <h6>Vice Captain Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="vice_captain_name" placeholder="Enter Vice Captain Name" class="form-control " required>
                                        <input type="text" name="vice_captain_number" style="display: none;" class="form-control " value="<?php echo $houseLeads[3] ?? '' ?>" required>

                                    </div>
                                </div>

                                <div class="col-md-12 form-group"> <label for="vice_captain_name">
                                        <h6>Vice Captain Name</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="vice_vice_captain_name" placeholder="Enter Vice Captain Name" class="form-control " required>
                                        <input type="text" name="vice_vice_captain_number" style="display: none;" class="form-control " value="<?php echo $houseLeads[4] ?? '' ?>" required>

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
            <div class="title-area d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                <h4 class="title m-0"><i class="fas fa-calendar-alt mr-2 text-warning"></i>Event Details</h4>
                <div class="btn-group btn-group-sm table-view-toggle d-md-none" role="group">
                    <button type="button" class="btn btn-outline-info active" id="btnCardView"><i class="fas fa-th-large mr-1"></i>Cards</button>
                    <button type="button" class="btn btn-outline-info" id="btnTableView"><i class="fas fa-table mr-1"></i>Table</button>
                </div>
            </div>

            <?php
            $genderResult = mysqli_query($conn, "SELECT gender FROM housedb WHERE name = '$houseName'");
            $gender = mysqli_fetch_assoc($genderResult);
            $gender = $gender['gender'];
            mysqli_free_result($genderResult);

            $eventsResult = mysqli_query($conn, "SELECT * FROM eventdb WHERE gender = '$gender' UNION SELECT * FROM eventdb WHERE gender = 'COMMON'");
            $eventsList = [];
            $safeHouseName = mysqli_real_escape_string($conn, $houseName);

            $idx = 1;
            while ($event = mysqli_fetch_assoc($eventsResult)) {
                $rawEventName = $event['event_name'];
                $safeEventName = mysqli_real_escape_string($conn, $rawEventName);
                $eventCoordinatorResult = mysqli_query($conn, "SELECT name from admindb WHERE role = 'event coordinator' AND event_name = '$safeEventName'");
                $coord = mysqli_fetch_assoc($eventCoordinatorResult);
                $eventCoordinator = $coord['name'] ?? null;
                mysqli_free_result($eventCoordinatorResult);

                // Fetch team allowance from DB
                $teamAllowance = (int)$event['allowance'];

                // Count registered participants specifically for this house and this event
                $SpecificEventRegStuCountResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM registerationdb WHERE student_house = '$safeHouseName' AND event_name = '$safeEventName'");
                $regRow = $SpecificEventRegStuCountResult ? mysqli_fetch_assoc($SpecificEventRegStuCountResult) : null;
                $registeredParticipants = (int)($regRow['row_count'] ?? 0);
                if ($SpecificEventRegStuCountResult) {
                    mysqli_free_result($SpecificEventRegStuCountResult);
                }

                $remainingAllowance = max(0, $teamAllowance - $registeredParticipants);
                $isGroup = ($event['is_group'] >= 1);

                $eventsList[] = [
                    'sno'                => $idx++,
                    'event_name'         => $rawEventName,
                    'coordinator'        => $eventCoordinator,
                    'allowance'          => $teamAllowance,
                    'registered'         => $registeredParticipants,
                    'remaining'          => $remainingAllowance,
                    'is_group'           => $isGroup,
                    'group_counts'       => (int)$event['group_counts'],
                    'group_participants' => (int)$event['group_participants'],
                ];
            }
            mysqli_free_result($eventsResult);
            ?>

            <!-- Mobile Cards View (shown on mobile by default) -->
            <div class="mobile-cards-view d-block d-md-none" id="eventCardsView">
                <?php foreach ($eventsList as $ev): ?>
                    <div class="mobile-event-card">
                        <div class="card-header-row">
                            <h5 class="event-title">
                                <span class="event-sno">#<?= $ev['sno'] ?></span>
                                <?= htmlspecialchars($ev['event_name']) ?>
                            </h5>
                            <?php if ($ev['remaining'] > 0): ?>
                                <span class="badge badge-success" style="font-size: 0.8rem; padding: 5px 8px;"><?= $ev['remaining'] ?> Left</span>
                            <?php else: ?>
                                <span class="badge badge-danger" style="font-size: 0.8rem; padding: 5px 8px;">Full (<?= $ev['registered'] ?>/<?= $ev['allowance'] ?>)</span>
                            <?php endif; ?>
                        </div>

                        <div class="event-coord">
                            <i class="fas fa-user-tie mr-1 text-info"></i>
                            <?= $ev['coordinator'] ? htmlspecialchars($ev['coordinator']) : '<span class="text-muted">Coordinator Not Assigned !</span>' ?>
                        </div>

                        <div class="stats-badge-grid">
                            <div class="stat-pill">
                                <span class="label">Allowance</span>
                                <span class="val text-warning"><?= $ev['allowance'] ?></span>
                            </div>
                            <div class="stat-pill">
                                <span class="label">Registered</span>
                                <span class="val text-info"><?= $ev['registered'] ?></span>
                            </div>
                            <div class="stat-pill">
                                <span class="label">Remaining</span>
                                <span class="val <?= $ev['remaining'] > 0 ? 'text-success' : 'text-danger' ?>"><?= $ev['remaining'] ?></span>
                            </div>
                            <div class="stat-pill">
                                <span class="label">Group Event</span>
                                <span class="val"><?= $ev['is_group'] ? '<span class="badge badge-info p-1">Yes</span>' : '<span class="text-muted">No</span>' ?></span>
                            </div>
                            <?php if ($ev['is_group']): ?>
                                <div class="stat-pill">
                                    <span class="label">Max Groups</span>
                                    <span class="val text-warning"><?= $ev['group_counts'] ?></span>
                                </div>
                                <div class="stat-pill">
                                    <span class="label">Group Size</span>
                                    <span class="val text-secondary"><?= $ev['group_participants'] ?></span>
                                </div>
                            <?php else: ?>
                                <div class="stat-pill">
                                    <span class="label">Type</span>
                                    <span class="val text-muted">Solo</span>
                                </div>
                                <div class="stat-pill">
                                    <span class="label">Group Size</span>
                                    <span class="val text-muted">-</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-action">
                            <?php if ($ev['remaining'] > 0): ?>
                                <a href="studentRegisteration.php?eventName=<?= urlencode($ev['event_name']); ?>" class="btn btn-primary">
                                    <i class="fas fa-user-plus mr-1"></i> Assign Member
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary disabled" disabled style="opacity: 0.6; cursor: not-allowed;">
                                    <i class="fas fa-ban mr-1"></i> Registration Full
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Table View (default on desktop/tablet, toggleable on mobile) -->
            <div class="desktop-table-view d-none d-md-block" id="eventTableView">
                <div class="swipe-hint d-md-none py-2 px-3 text-center text-muted">
                    <i class="fas fa-arrows-alt-h text-info mr-1"></i> Swipe horizontally to view all columns
                </div>
                <div class="table-responsive">
                    <table class="premium-table sticky-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px;">#</th>
                                <th>Event Name</th>
                                <th>Event Coordinator</th>
                                <th class="text-center">Allowance</th>
                                <th class="text-center">Registered</th>
                                <th class="text-center">Remaining</th>
                                <th class="text-center">Group</th>
                                <th class="text-center text-nowrap">Max Groups</th>
                                <th class="text-center text-nowrap">Group Size</th>
                                <th class="text-center text-nowrap" style="min-width: 140px;">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventsList as $ev): ?>
                                <tr>
                                    <td class="text-center"><?= $ev['sno'] ?></td>
                                    <td><strong><?= htmlspecialchars($ev['event_name']) ?></strong></td>
                                    <td>
                                        <?= $ev['coordinator'] ? htmlspecialchars($ev['coordinator']) : '<span class="text-muted">Not Assigned !</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info" style="font-size: 0.85rem;"><?= $ev['allowance'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary" style="font-size: 0.85rem;"><?= $ev['registered'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $ev['remaining'] > 0 ? 'badge-success' : 'badge-danger' ?>" style="font-size: 0.85rem;">
                                            <?= $ev['remaining'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ev['is_group']): ?>
                                            <span class="badge badge-info">Yes</span>
                                        <?php else: ?>
                                            <span class="text-muted">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ev['is_group']): ?>
                                            <span class="badge badge-warning" style="font-size: 0.85rem;"><?= $ev['group_counts'] ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ev['is_group']): ?>
                                            <span class="badge badge-secondary" style="font-size: 0.85rem;"><?= $ev['group_participants'] ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <?php if ($ev['remaining'] > 0): ?>
                                            <a href="studentRegisteration.php?eventName=<?= urlencode($ev['event_name']); ?>" class="btn btn-primary btn-sm">Assign Member</a>
                                        <?php else: ?>
                                            <span class="badge badge-secondary" style="padding: 6px 10px; font-size: 0.78rem;">Full (<?= $ev['registered']; ?>/<?= $ev['allowance']; ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Register Number</th>
                            <th>Student Name</th>
                            <th>Department</th>
                            <th class="text-center">Year</th>
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
                                <td class="text-center font-weight-bold text-muted">
                                    <?php echo $i++ ?>
                                </td>
                                <td>
                                    <code style="color: var(--accent-cyan); font-size: 0.9rem;"><?php echo htmlspecialchars($reg_no) ?></code>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($stu_name) ?></strong>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($dept) ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info" style="font-size: 0.8rem;"><?php echo htmlspecialchars($year) ?></span>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnCard = document.getElementById('btnCardView');
            const btnTable = document.getElementById('btnTableView');
            const cardsView = document.getElementById('eventCardsView');
            const tableView = document.getElementById('eventTableView');

            if (btnCard && btnTable && cardsView && tableView) {
                btnCard.addEventListener('click', function () {
                    btnCard.classList.add('active');
                    btnTable.classList.remove('active');
                    cardsView.classList.remove('d-none');
                    tableView.classList.add('d-none');
                });

                btnTable.addEventListener('click', function () {
                    btnTable.classList.add('active');
                    btnCard.classList.remove('active');
                    cardsView.classList.add('d-none');
                    tableView.classList.remove('d-none');
                });
            }
        });
    </script>
</body>

</html>