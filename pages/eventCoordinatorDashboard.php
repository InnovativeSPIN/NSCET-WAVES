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
        $participants[] = array(
            'reg_no' => $list['reg_no'],
            'student_name' => $list['student_name'],
            'student_dept' => $list['student_dept'],
            'student_house' => $list['student_house']
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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Rubik:wght@300;700&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="../public/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/eventCoordinatorDashboard.css">
    <script src="https://kit.fontawesome.com/5fe2f4c2ef.js" crossorigin="anonymous"></script>

    

    
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
                            <div class="hamburger-menu d-lg-none" >
                                <span style="background-color:black"></span>
                                <span style="background-color:black"></span>
                                <span style="background-color:black"></span>
                                <span style="background-color:black"></span>
                            </div>
                            <ul>
                                <li><a href="../index.php"><button type="button" class="btn btn-login btn-primary" data-toggle="modal" data-target="#loginModal">Logout</button></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="header" style="margin-top:85px">
            <div class="title">Participants Details</div>
        </div>
        <div class="indicators">
            <div id="i1">
                <div class="navi-indicator" id="ni1"></div>
            </div>
            <div id="i2">
                <div class="navi-indicator" id="ni2"></div>
            </div>
            <div id="i3">
                <div class="navi-indicator" id="ni3"></div>
            </div>
            <div id="i4">
                <div class="navi-indicator" id="ni4"></div>
            </div>
        </div>
        <div class="indicators-2">
            <div id="i5">
                <div class="navi-indicator" id="ni5"></div>
            </div>
            <div id="i6">
                <div class="navi-indicator" id="ni6"></div>
            </div>
            <div id="i7">
                <div class="navi-indicator" id="ni7"></div>
            </div>
            <div id="i8">
                <div class="navi-indicator" id="ni8"></div>
            </div>
        </div>

        <div class="navi">
            <div class="navi-item1">
                <button class="nav-button" onclick="populateItems(eventData, 'BLUE BLASTERS')" id="startersbutton">
                    <div class="navi-icon"><i class="fa-sharp fa-solid fa-explosion fa-shake"></i></div>
                    <div class="navi-text">BLUE BLASTERS</div>
                </button>
            </div>
            <div class="navi-item2">
                <button class="nav-button" onclick="populateItems(eventData, 'DINO THUNDERS')" id="mainsbutton">
                    <div class="navi-icon"><i class="fa-solid fa-skull-crossbones fa-fade"></i></div>
                    <div class="navi-text">DINO THUNDERS</div>
                </button>
            </div>
            <div class="navi-item3">
                <button class="nav-button" onclick="populateItems(eventData, 'DRAGON WARRIORS')" id="dessertsbutton">
                    <div class="navi-icon"><i class="fa-solid fa-dragon fa-bounce"></i></div>
                    <div class="navi-text">DRAGON WARRIORS</div>
                </button>
            </div>
            <div class="navi-item4">
                <button class="nav-button" onclick="populateItems(eventData, 'GALACTIC STARS')" id="drinksbutton">
                    <div class="navi-icon"><i class="fa-solid fa-star fa-beat-fade"></i></div>
                    <div class="navi-text">GALACTIC STARS</div>
                </button>
            </div>
            <div class="navi-item5">
                <button class="nav-button" onclick="populateItems(eventData, 'PHOENIX BLASTERS')" id="phoenix">
                    <div class="navi-icon"><i class="fa-brands fa-phoenix-framework fa-flip"></i></div>
                    <div class="navi-text">PHOENIX BLASTERS</div>
                </button>
            </div>
            <div class="navi-item6">
                <button class="nav-button" onclick="populateItems(eventData, 'ROSY RIDERS')" id="rosy">
                    <div class="navi-icon"><i class="fa-solid fa-motorcycle fa-spin-pulse"></i></div>
                    <div class="navi-text">ROSY RIDERS</div>
                </button>
            </div>
            <div class="navi-item7">
                <button class="nav-button" onclick="populateItems(eventData, 'TIGER THRASHERS')" id="tiger">
                    <div class="navi-icon"><i class="fa-brands fa-wolf-pack-battalion fa-shake"></i></div>
                    <div class="navi-text">TIGER THRASHERS</div>
                </button>
            </div>
            <div class="navi-item4">
                <button class="nav-button" onclick="populateItems(eventData, 'VIOLET VIPERS')" id="violet">
                    <div class="navi-icon"><i class="fa-solid fa-staff-snake fa-flip"></i></div>
                    <div class="navi-text">VIOLET VIPERS</div>
                </button>
            </div>
        </div>
        <div class="menu">
            
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