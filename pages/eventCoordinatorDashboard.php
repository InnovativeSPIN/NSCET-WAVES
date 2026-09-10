<?php
include('../routes/connect.php');
session_start();
$eventName = $_SESSION['event_name'];
$role = $_SESSION['role'];

$event_list = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_name`= '$eventName'");
$data = mysqli_fetch_array($event_list);
$eventData['event'] = array(
    'is_group' => $data['is_group'],
    'group_counts' => $data['group_counts']
);

if ($data['is_group'] == '0') {
    $participantsList = mysqli_query($conn, "SELECT * FROM registerationdb WHERE event_name = '$eventName'");
    $participants = array();
    while ($list = mysqli_fetch_array($participantsList)) {
        // Fetch slot for this participant
        $reg_no = $list['reg_no'];
        $slotRes = mysqli_query($conn, "SELECT slot FROM allotmentdb WHERE event = '$eventName' AND reg_no = '$reg_no' LIMIT 1");
        $slotRow = mysqli_fetch_assoc($slotRes);
        $slot = $slotRow ? $slotRow['slot'] : '';
        $participants[] = array(
            'reg_no' => $list['reg_no'],
            'student_name' => $list['student_name'],
            'student_dept' => $list['student_dept'],
            'student_house' => $list['student_house'],
            'slot' => $slot
        );
    }
    $eventData['participants'] = $participants;
} else {
    $eventData['groups'] = array();
    $i = 1;
    while ($i <= $data['group_counts']) {
        $participantsList = mysqli_query($conn, "SELECT * FROM registerationdb WHERE event_name = '$eventName' && `grouped` = '$i'");
        $participants = array();
        while ($list = mysqli_fetch_array($participantsList)) {
            $participants[] = array(
                'reg_no' => $list['reg_no'],
                'student_name' => $list['student_name'],
                'student_dept' => $list['student_dept'],
                'student_house' => $list['student_house']
            );
        }

        $allotmentListResult = mysqli_query($conn, "SELECT * FROM `allotmentdb` WHERE `event`= '$eventName' && `grouped` = '$i'");
        $allotmentSlots = array();
        while ($allotmentData = mysqli_fetch_array($allotmentListResult)) {
            $allotmentSlots[] = array(
                'house' => $allotmentData['house'],
                'slot' => $allotmentData['slot']
            );
        }

        for ($k = 0; $k < count($participants); $k++) {
            for ($j = 0; $j < count($allotmentSlots); $j++) {
                if ($participants[$k]['student_house'] == $allotmentSlots[$j]['house']) {
                    $participants[$k]['slot'] = $allotmentSlots[$j]['slot'];
                }
            }
        }

        $eventData['groups'][] = array(
            'group_number' => $i,
            'participants' => $participants
        );
        $i++;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Coordinator | Dashboard</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Rubik:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/premium-dashboard.css">
    <script src="https://kit.fontawesome.com/5fe2f4c2ef.js" crossorigin="anonymous"></script>
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
                    <form action="../routes/pdf/EventCopdf.php" method="post" class="m-0">
                        <input type="text" style="display: none;" value="<?php echo $_SESSION['event_name'] ?>" name='event'>
                        <button class="btn btn-action m-0"><i class="fas fa-file-export mr-1"></i> Data Export</button>
                    </form>
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
    <div class="modal fade premium-modal" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body login-modal-body">
                    <div class="column" id="main">
                        <h3 class="mb-4 text-center">Reset Password</h3>
                        <form action="../routes/admin/coordinatorEdit.php" method="post">

                            <div class="form-group" id='login-event-name'> <label for="event_name">
                                    <h6>Event Name</h6>
                                </label> <input type="text" name="event_name" value="<?php echo $eventName ?>" readonly class="form-control">
                            </div>
                            <input type="text" value="EVENT_CORDINATOR" name="whoUpdate" style="display: none;">
                            <div class="col-md-12 form-group"> <label for="update_password">
                                    <h6>Update Password</h6>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="premium-table-container mt-4">
            <div class="title-area">
                <h4 class="title"><i class="fas fa-users mr-2 text-info"></i>Participants Details</h4>
            </div>

            <div class="scroll-nav-wrapper">
                <div class="scroll-nav-container">
                    <button class="house-pill active" onclick="populateItems(eventData, 'BLUE BLASTERS'); setActive(this)">
                        <i class="fa-sharp fa-solid fa-explosion"></i> BLUE BLASTERS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'DINO THUNDERS'); setActive(this)">
                        <i class="fa-solid fa-skull-crossbones"></i> DINO THUNDERS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'DRAGON WARRIORS'); setActive(this)">
                        <i class="fa-solid fa-dragon"></i> DRAGON WARRIORS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'GALACTIC STARS'); setActive(this)">
                        <i class="fa-solid fa-star"></i> GALACTIC STARS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'PHOENIX BLASTERS'); setActive(this)">
                        <i class="fa-brands fa-phoenix-framework"></i> PHOENIX BLASTERS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'ROSY RIDERS'); setActive(this)">
                        <i class="fa-solid fa-motorcycle"></i> ROSY RIDERS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'TIGER THRASHERS'); setActive(this)">
                        <i class="fa-brands fa-wolf-pack-battalion"></i> TIGER THRASHERS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'VIOLET VIPERS'); setActive(this)">
                        <i class="fa-solid fa-staff-snake"></i> VIOLET VIPERS
                    </button>
                    <button class="house-pill" onclick="populateItems(eventData, 'EMERALD EAGLES'); setActive(this)">
                        <img src="../public/images/icon/eagle.png" alt="" width="20px"> EMERALD EAGLES
                    </button>
                </div>
            </div>

            <div class="menu p-4">
                <!-- Javascript will populate the premium tables here -->
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
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854" integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg==" data-cf-beacon='{"rayId":"801ca2883dc3859f","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.8.0","si":100}' crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        var eventData = <?php echo json_encode($eventData); ?>;
        populateItems(eventData, 'BLUE BLASTERS');
    </script>


</body>

</html>