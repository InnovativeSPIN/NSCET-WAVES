<?php
session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: ../index.php');
    exit();
}
$role      = $_SESSION['role'] ?? '';
$eventName = $_GET['eventName'] ?? '';

include('../routes/connect.php');

$houseName = $_SESSION['house_name'] ?? ($_SESSION['house'] ?? '');

// Fetch event details from eventdb
$eventStmt = mysqli_prepare($conn, "SELECT * FROM `eventdb` WHERE `event_name` = ? LIMIT 1");
mysqli_stmt_bind_param($eventStmt, "s", $eventName);
mysqli_stmt_execute($eventStmt);
$eventResult = mysqli_stmt_get_result($eventStmt);
$event = mysqli_fetch_assoc($eventResult);
mysqli_stmt_close($eventStmt);

if (!$event) {
    header('Location: houseDashboard.php');
    exit();
}

$isGroup = ((int)$event['is_group'] >= 1);
// Team-specific allowance from DB (e.g. 2 to 8)
$teamAllowance = (int)$event['allowance'];

// Count registered members specifically for THIS team and THIS event
$cStmt = mysqli_prepare($conn, "SELECT COUNT(*) as cnt FROM registerationdb WHERE student_house = ? AND event_name = ?");
mysqli_stmt_bind_param($cStmt, "ss", $houseName, $eventName);
mysqli_stmt_execute($cStmt);
$cRow = mysqli_fetch_assoc(mysqli_stmt_get_result($cStmt));
$registeredParticipants = (int)($cRow['cnt'] ?? 0);
mysqli_stmt_close($cStmt);

$remainingAllowance = max(0, $teamAllowance - $registeredParticipants);

// Handle feedback messages
$successMsg = '';
$errorMsg   = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMsg = "Participant(s) successfully registered!";
} elseif (isset($_GET['error'])) {
    $err = $_GET['error'];
    if ($err === 'AllowanceExceeded') {
        $errorMsg = "Registration limit reached! Your team's maximum allowance for this event is $teamAllowance.";
    } elseif ($err === 'GroupAlreadyRegistered') {
        $errorMsg = "This group number has already been registered by your team.";
    } elseif ($err === 'InvalidGroup') {
        $errorMsg = "Please select a valid group number.";
    } elseif ($err === 'DuplicateInBatch') {
        $errorMsg = "Duplicate register numbers entered in the form.";
    } elseif ($err === 'NoStudentProvided') {
        $errorMsg = "Please enter at least one valid register number.";
    } elseif (strpos($err, 'StudentNotFound_') === 0) {
        $rn = htmlspecialchars(substr($err, 16));
        $errorMsg = "Student with register number $rn not found in student database.";
    } elseif (strpos($err, 'HouseMismatch_') === 0) {
        $rn = htmlspecialchars(substr($err, 14));
        $errorMsg = "Student $rn does not belong to your house (" . htmlspecialchars($houseName) . ").";
    } elseif (strpos($err, 'GenderMismatch_') === 0) {
        $rn = htmlspecialchars(substr($err, 15));
        $errorMsg = "Student $rn does not match the event gender requirement (" . htmlspecialchars($event['gender'] ?? '') . ").";
    } elseif (strpos($err, 'AlreadyRegistered_') === 0) {
        $rn = htmlspecialchars(substr($err, 18));
        $errorMsg = "Student $rn is already registered for this event.";
    } elseif (strpos($err, 'MaxLimitReached_') === 0) {
        $rn = htmlspecialchars(substr($err, 16));
        $errorMsg = "Student $rn has already reached the maximum allowed event participation limit.";
    } else {
        $errorMsg = "An error occurred during registration. Please check details and try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student | <?= htmlspecialchars($eventName) ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/premium-dashboard.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.1/css/all.css">
    <style>
        .custom-group-select {
            height: 48px !important;
            line-height: 28px !important;
            padding: 10px 42px 10px 16px !important;
            background-color: #1a163a !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230ee1e7' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 14px center !important;
            background-size: 16px 16px !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            color: #ffffff !important;
            font-size: 0.95rem !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: var(--radius-sm, 8px) !important;
            cursor: pointer !important;
            box-sizing: border-box !important;
        }
        .custom-group-select:focus {
            background-color: #211c49 !important;
            border-color: #0ee1e7 !important;
            box-shadow: 0 0 12px rgba(14, 225, 231, 0.35) !important;
            outline: none !important;
        }
        .custom-group-select option {
            background-color: #181436 !important;
            color: #ffffff !important;
            padding: 12px 16px !important;
            font-size: 0.95rem !important;
        }
        .custom-group-select option:disabled {
            color: rgba(255, 255, 255, 0.35) !important;
            background-color: #110d27 !important;
            font-style: italic !important;
        }
    </style>
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
                    <a href="houseDashboard.php" class="btn btn-action">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../index.php" class="btn btn-action">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($successMsg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i><?= htmlspecialchars($successMsg) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($errorMsg): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i><?= htmlspecialchars($errorMsg) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="glass-card">
            <div class="house-profile-wrapper">
                <div class="house-logo-container">
                    <?php if (!empty($event['image'])): ?>
                        <img src="../<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($eventName) ?> Image">
                    <?php else: ?>
                        <img src="../public/images/logos/waves-logo.png" alt="<?= htmlspecialchars($eventName) ?> Image">
                    <?php endif; ?>
                </div>

                <div class="house-info-container">
                    <h1><?= htmlspecialchars($eventName) ?></h1>
                    <p class="text-muted mb-3"><i class="fas fa-shield-alt mr-1 text-info"></i> House: <strong><?= htmlspecialchars($houseName) ?></strong></p>
                    
                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="label">Team Allowance</span>
                            <span class="value text-warning">
                                <?= $teamAllowance ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Registered</span>
                            <span class="value text-info">
                                <?= $registeredParticipants ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Remaining</span>
                            <span class="value <?= $remainingAllowance > 0 ? 'text-success' : 'text-danger' ?>">
                                <?= $remainingAllowance ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Group Event</span>
                            <span class="value">
                                <?= $isGroup ? 'Yes' : 'No' ?>
                            </span>
                        </div>
                        <?php if ($isGroup): ?>
                        <div class="stat-box">
                            <span class="label">Max Groups</span>
                            <span class="value text-warning">
                                <?= (int)$event['group_counts'] ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Group Size</span>
                            <span class="value text-info">
                                <?= (int)$event['group_participants'] ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form Section -->
    <div class="container my-4">
    <?php if ($remainingAllowance > 0): ?>
        <div class="premium-modal" style="max-width: 520px; margin: 0 auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" style="color: var(--accent-pink);">
                        <i class="fas fa-user-plus mr-2"></i>Add Participant (<?= $remainingAllowance ?> left)
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="../routes/studentReg/addStudent.php" method="post">
                        <input type="hidden" name="house_name" value="<?= htmlspecialchars($houseName) ?>">
                        <input type="hidden" name="event_name" value="<?= htmlspecialchars($eventName) ?>">

                        <?php
                        $studentResult = mysqli_query($conn, "SELECT reg_no, name, dept, year FROM `studentdb` WHERE house = '$houseName' ORDER BY name ASC");
                        echo "<datalist id='listName'>";
                        while ($stu = mysqli_fetch_assoc($studentResult)) {
                            echo "<option value='{$stu['reg_no']}'>" . htmlspecialchars($stu['name']) . " (" . htmlspecialchars($stu['dept']) . " - " . htmlspecialchars($stu['year']) . ")</option>";
                        }
                        echo "</datalist>";
                        
                        if ($isGroup) {
                            $groupSize = (int)($event['group_participants'] > 0 ? $event['group_participants'] : ($event['group_counts'] > 0 ? $event['group_counts'] : 1));
                            for ($idx = 1; $idx <= $groupSize; $idx++) {
                                $required = ($idx == 1) ? 'required' : '';
                                echo "<div class='form-group'>
                                    <label><h6>Student $idx Reg No " . ($idx == 1 ? '<span class="text-danger">*</span>' : '') . "</h6></label>
                                    <input type='text' list='listName' name='reg_number[]' placeholder='Enter Register Number' $required class='form-control'>
                                </div>";
                            }

                            // Fetch groups already registered by this team
                            $usedGroupsRes = mysqli_query($conn, "SELECT DISTINCT grouped FROM registerationdb WHERE student_house = '$houseName' AND event_name = '$eventName' AND grouped > 0");
                            $usedGroups = [];
                            while ($ug = mysqli_fetch_assoc($usedGroupsRes)) {
                                $usedGroups[] = (int)$ug['grouped'];
                            }

                            $maxGroups = max(1, (int)($event['group_counts'] > 0 ? $event['group_counts'] : 1));
                            echo "<div class='form-group'>
                                <label><h6>Group Number <span class=\"text-danger\">*</span></h6></label>
                                <select name='group' id='group' required class='form-control custom-group-select'>";
                            $firstAvailableSelected = false;
                            for ($g = 1; $g <= $maxGroups; $g++) {
                                if (in_array($g, $usedGroups)) {
                                    echo "<option value='$g' disabled>Group $g (Already Registered)</option>";
                                } else {
                                    $selectedAttr = (!$firstAvailableSelected) ? 'selected' : '';
                                    $firstAvailableSelected = true;
                                    echo "<option value='$g' $selectedAttr>Group $g</option>";
                                }
                            }
                            echo "</select></div>";
                        } else {
                            echo "<div class='form-group'>
                                <label><h6>Student Register Number <span class=\"text-danger\">*</span></h6></label>
                                <input type='text' list='listName' name='reg_number[]' placeholder='Enter Register Number' required class='form-control'>
                            </div>";
                            echo '<input type="hidden" name="group" value="0" id="group">';
                        }
                        ?>

                        <button class="btn btn-primary btn-block mt-4" type="submit">
                            <i class="fas fa-check mr-1"></i> Register for <?= htmlspecialchars($houseName) ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert" style="background: rgba(255,209,102,0.1); border: 1px solid rgba(255,209,102,0.3); color: var(--accent-gold); border-radius: 12px; padding: 24px; max-width: 600px; margin: 0 auto;">
            <h4 class="alert-heading"><i class="fas fa-ban mr-2"></i>Registration Full for <?= htmlspecialchars($houseName) ?>!</h4>
            <p class="mb-0">Your team has reached its maximum allowance of <strong><?= $teamAllowance ?></strong> registration(s) for <strong><?= htmlspecialchars($eventName) ?></strong>.</p>
        </div>
    <?php endif; ?>
    </div>

    <!-- Registered Participants for this house -->
    <div class="container mb-5">
        <h4 class="title mb-4" style="color: var(--accent-pink);">Registered <span>Participants (<?= htmlspecialchars($houseName) ?>)</span></h4>
        <div class="premium-table-container">

            <?php
            if (!$isGroup) {
                $pStmt = mysqli_prepare($conn, "SELECT * FROM registerationdb WHERE event_name = ? AND student_house = ? ORDER BY id ASC");
                mysqli_stmt_bind_param($pStmt, "ss", $eventName, $houseName);
                mysqli_stmt_execute($pStmt);
                $participantsList = mysqli_stmt_get_result($pStmt);
            ?>
                <div class="table-responsive">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px;">#</th>
                                <th>Register Number</th>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th class="text-center">Year</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        if (mysqli_num_rows($participantsList) == 0) {
                            echo "<tr><td colspan='6' class='text-center text-muted p-4'>No participants registered yet for this event.</td></tr>";
                        } else {
                            while ($list = mysqli_fetch_assoc($participantsList)) {
                        ?>
                            <tr>
                                <td class="text-center font-weight-bold text-muted"><?= $i++ ?></td>
                                <td><code style="color: var(--accent-cyan); font-size: 0.9rem;"><?= htmlspecialchars($list['reg_no']) ?></code></td>
                                <td><strong><?= htmlspecialchars($list['student_name']) ?></strong></td>
                                <td><?= htmlspecialchars($list['student_dept']) ?></td>
                                <td class="text-center"><span class="badge badge-info" style="font-size: 0.8rem;"><?= htmlspecialchars($list['student_year']) ?></span></td>
                                <td class="text-center">
                                    <a href="../routes/studentReg/removeStudentRegisteration.php?ID=<?= urlencode($list['id']) ?>&eventName=<?= urlencode($eventName) ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to remove this registration?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                        mysqli_stmt_close($pStmt);
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                // Group event display
                $grpStmt = mysqli_prepare($conn, "SELECT DISTINCT grouped FROM registerationdb WHERE event_name = ? AND student_house = ? AND grouped > 0 ORDER BY grouped ASC");
                mysqli_stmt_bind_param($grpStmt, "ss", $eventName, $houseName);
                mysqli_stmt_execute($grpStmt);
                $grpRes = mysqli_stmt_get_result($grpStmt);
                
                if (mysqli_num_rows($grpRes) == 0) {
                    echo "<div class='text-center text-muted p-4'>No groups registered yet for this event.</div>";
                } else {
                    while ($gRow = mysqli_fetch_assoc($grpRes)) {
                        $grpNum = (int)$gRow['grouped'];
                        $memberStmt = mysqli_prepare($conn, "SELECT * FROM registerationdb WHERE event_name = ? AND student_house = ? AND grouped = ? ORDER BY id ASC");
                        mysqli_stmt_bind_param($memberStmt, "ssi", $eventName, $houseName, $grpNum);
                        mysqli_stmt_execute($memberStmt);
                        $mRes = mysqli_stmt_get_result($memberStmt);
            ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                            <h5 class="title m-0" style="color: var(--accent-pink);"><i class="fas fa-users mr-2"></i>Group <?= $grpNum ?></h5>
                            <a href="../routes/studentReg/removeStudentRegisteration.php?groupID=<?= $grpNum ?>&house=<?= urlencode($houseName) ?>&eventName=<?= urlencode($eventName) ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure you want to remove all members of Group <?= $grpNum ?>?');">
                                <i class="fa fa-trash-alt mr-1"></i> Remove Entire Group
                            </a>
                        </div>
                        <div class="premium-table-container mb-4">
                            <div class="table-responsive">
                                <table class="premium-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">#</th>
                                            <th>Register Number</th>
                                            <th>Student Name</th>
                                            <th>Department</th>
                                            <th class="text-center">Year</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $k = 1;
                                    while ($m = mysqli_fetch_assoc($mRes)) {
                                    ?>
                                        <tr>
                                            <td class="text-center font-weight-bold text-muted"><?= $k++ ?></td>
                                            <td><code style="color: var(--accent-cyan); font-size: 0.9rem;"><?= htmlspecialchars($m['reg_no']) ?></code></td>
                                            <td><strong><?= htmlspecialchars($m['student_name']) ?></strong></td>
                                            <td><?= htmlspecialchars($m['student_dept']) ?></td>
                                            <td class="text-center"><span class="badge badge-info" style="font-size: 0.8rem;"><?= htmlspecialchars($m['student_year']) ?></span></td>
                                            <td class="text-center">
                                                <a href="../routes/studentReg/removeStudentRegisteration.php?ID=<?= urlencode($m['id']) ?>&eventName=<?= urlencode($eventName) ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure you want to remove this registration?');">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    mysqli_stmt_close($memberStmt);
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
            <?php
                    }
                }
                mysqli_stmt_close($grpStmt);
            }
            ?>
        </div>
    </div>

    <script src="../public/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5fe2f4c2ef.js" crossorigin="anonymous"></script>
</body>

</html>