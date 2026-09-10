<?php
session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /');
    exit();
}
$role = $_SESSION['role'];
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
    <div class="container mt-5">
        <div class="glass-card">
            <div class="house-profile-wrapper">
                <div class="house-logo-container">
                    <img src="<?php echo '../' . $event['image'] ?>" alt="<?php echo $eventName ?> Image">
                </div>

                <div class="house-info-container">
                    <h1><?php echo $eventName ?></h1>
                    
                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="label">Max Participants</span>
                            <span class="value text-warning">
                                <?php echo $event['max_participants'] ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Registered</span>
                            <span class="value text-info">
                                <?php echo $registeredParticipants ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Allowance</span>
                            <span class="value text-success">
                                <?php echo $event['max_participants'] - $registeredParticipants ?>
                            </span>
                        </div>
                        <div class="stat-box">
                            <span class="label">Group Event</span>
                            <span class="value">
                                <?php echo $isGroup ?>
                            </span>
                        </div>
                        <?php if ($event['is_group'] == 1) { ?>
                        <div class="stat-box">
                            <span class="label">Group Count</span>
                            <span class="value">
                                <?php echo $event['group_counts'] ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
    <?php if ($event['max_participants'] - $registeredParticipants > 0) { ?>
        <div class="premium-modal" style="max-width: 500px; margin: 0 auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" style="color: var(--accent-pink);">Add Participant</h4>
                </div>
                <div class="modal-body">
                    <form action="../routes/studentReg/addStudent.php" method="post">
                        <input type="text" name="house_name" value="<?php echo $houseName ?>" readonly hidden>
                        <input type="text" name="event_name" value="<?php echo $eventName ?>" readonly hidden>

                        <?php
                        $studentResult = mysqli_query($conn, "SELECT reg_no FROM `studentdb` WHERE house = '$houseName'");
                        $studentList = [];
                        while ($studentDetail = mysqli_fetch_array($studentResult)) {
                            $studentList[] = $studentDetail[0];
                        }

                        echo "<datalist id='listName'>";
                        foreach ($studentList as $stu) {
                            echo "<option value='$stu'>$stu</option>";
                        }
                        echo "</datalist>";
                        
                        if ($event['is_group'] >= 1) {
                            $groupSize = (int)$event['group_counts'];
                            for ($idx = 1; $idx <= $groupSize; $idx++) {
                                $required = ($idx == 1) ? 'required' : '';
                                echo "<div class='form-group'>
                                <label><h6>Student Reg No $idx</h6></label>
                                <input type='text' list='listName' name='reg_number[]' placeholder='Enter Register Number' $required class='form-control'>
                                </div>";
                            }
                        } else {
                            echo "<div class='form-group'>
                            <label><h6>Student Reg No</h6></label>
                            <input type='text' list='listName' name='reg_number[]' placeholder='Enter Register Number' required class='form-control'>
                            </div>";
                        }
                        ?>

                        <?php
                        if ($event['is_group'] == 1) {
                            $groupCountResult = mysqli_query($conn, "SELECT group_counts FROM `eventdb` WHERE event_name = '$eventName'");
                            $groupCount = mysqli_fetch_array($groupCountResult);

                            if ($groupCount) {
                                $count = (int)$groupCount['group_counts'];

                                echo "<div class='form-group'>
                                    <label><h6>Group Number</h6></label>
                                    <select name='group' id='group' required class='form-control'>";
                                for ($i = 1; $i <= $count; $i++) {
                                    echo "<option value='$i'>Group $i</option>";
                                }

                                echo "</select></div>";
                            }
                        } else {
                            echo '<input type="text" name="group" value="0" id="group" hidden>';
                        }
                        ?>

                        <button class="btn btn-primary btn-block mt-4">Add Participants</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">Registration Full!</h4>
            <p>The maximum number of participants for this event has been reached.</p>
        </div>
    <?php } ?>
    </div>
        <div class="container mb-5">
            <h4 class="title mb-4" style="color: var(--accent-pink);">Event <span>Details</span></h4>
            <div class="premium-table-container">

                <?php
                $house_name = $_SESSION['house_name'];
                $event_list = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_name`= '$eventName'");
                $data = mysqli_fetch_array($event_list);
                $event = $data['is_group'];

                if ($event == '0') {
                ?>
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Register Number</th>
                                <th>Student Name</th>
                                <th>Student Department</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
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
                                    <?php echo $list['student_dept']; ?>
                                </td>
                                <td>
                                    <?php
                                    $sql = "SELECT * FROM studentdb WHERE reg_no = '$list[reg_no]'";

                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        // Fetch the row as an associative array
                                        $row = $result->fetch_assoc();

                                        // Display the data from the selected row
                                        echo $row["year"];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href=<?php echo '../routes/studentReg/removeStudentRegisteration.php' . "?ID=" . urlencode($list['id']) . "&eventName=" . urlencode($eventName) ?> class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php
                } else {
            ?>
                <?php
                        $i = 1;
                        $k = 1;
                        while ($i <= $data['group_counts']) {
                            $participantsList = mysqli_query($conn, "SELECT * FROM registerationdb WHERE event_name = '$eventName' && `student_house` = '$house_name' && `grouped` = $i");
                ?>
                    <h4 class="title mb-3" style="color: var(--accent-pink); margin-top: 24px;">Group <span><?php echo $i ?></span></h4>
                    <div class="premium-table-container mb-4">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Register Number</th>
                                    <th>Student Name</th>
                                    <th>Department</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($list = mysqli_fetch_array($participantsList)) {
                                ?>
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
                                        <td>
                                            <?php
                                            $sql = "SELECT * FROM studentdb WHERE reg_no = '$list[reg_no]'";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                // Fetch the row as an associative array
                                                $row = $result->fetch_assoc();

                                                // Display the data from the selected row
                                                echo $row["year"];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href=<?php echo '../routes/studentReg/removeStudentRegisteration.php' . "?ID=" . urlencode($list['id']) . "&eventName=" . urlencode($eventName) ?> class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
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
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src="../public/js/jquery.js"></script>
        <script type="text/javascript" src="../public/js/masonry.pkgd.min.js"></script>
        <script type="text/javascript" src="../public/js/jquery.collapsible.min.js"></script>
        <script type="text/javascript" src="../public/js/swiper.min.js"></script>
        <script type="text/javascript" src="../public/js/jquery.countdown.min.js"></script>
        <script type="text/javascript" src="../public/js/circle-progress.min.js"></script>
        <script type="text/javascript" src="../public/js/jquery.countTo.min.js"></script>
        <script type="text/javascript" src="../public/js/custom.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/6a9b11d703.js" crossorigin="anonymous"></script>
</body>

</html>