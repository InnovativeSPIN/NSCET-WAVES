<?php
include('../routes/connect.php');
session_start();
$eventName = $_SESSION['event_name'];
$role = $_SESSION['role'];

if ($role != 'event coordinator') {
    header('../index.php');
}

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
    <link rel="stylesheet" href="../public/css/eventCoordinatorDashboard.css">
    
</head>

<body>

<header class="site-header">
        <div class="header-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-10 col-lg-4">
                        <h1 class="site-branding flex">
                            <!-- <img src="public/images/logos/waves-logo.png" alt="" class="" width="120"> -->

                            <!-- <a href="#">Waves'23</a> -->
                        </h1>
                    </div>
                    <div class="col-2 col-lg-8">
                        <nav class="site-navigation">
                            <div class="hamburger-menu d-lg-none">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <ul>
                                <!-- <li><a href="#">HOME</a></li>
                                <li><a href="#">Waves'23</a></li>
                                <li><a href="#">ARTISTS</a></li>
                                <li><a href="#">BLOG</a></li>
                                <li><a href="#">CONTACT</a></li>
                                <li><a href="#"><i class="fas fa-search"></i></a></li> -->
                                <li><button type="button" class="btn btn-login btn-primary" data-toggle="modal" data-target="#loginModal">Login</button></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="header">
            <div class="title">Events Details</div>
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
                    <div class="navi-icon"><i class="fas fa-seedling"></i></div>
                    <div class="navi-text">BLUE BLASTERS</div>
                </button>
            </div>
            <div class="navi-item2">
                <button class="nav-button" onclick="populateItems(eventData, 'DINO THUNDERS')" id="mainsbutton">
                    <div class="navi-icon"><i class="fas fa-pizza-slice"></i></div>
                    <div class="navi-text">DINO THUNDERS</div>
                </button>
            </div>
            <div class="navi-item3">
                <button class="nav-button" onclick="populateItems(eventData, 'DRAGON WARRIORS')" id="dessertsbutton">
                    <div class="navi-icon"><i class="fas fa-ice-cream"></i></div>
                    <div class="navi-text">DRAGON WARRIORS</div>
                </button>
            </div>
            <div class="navi-item4">
                <button class="nav-button" onclick="populateItems(eventData, 'GALACTIC STARS')" id="drinksbutton">
                    <div class="navi-icon"><i class="fas fa-wine-glass-alt"></i></div>
                    <div class="navi-text">GALACTIC STARS</div>
                </button>
            </div>
            <div class="navi-item5">
                <button class="nav-button" onclick="populateItems(eventData, 'PHOENIX BLASTERS')" id="phoenix">
                    <div class="navi-icon"><i class="fas fa-seedling"></i></div>
                    <div class="navi-text">PHOENIX BLASTERS</div>
                </button>
            </div>
            <div class="navi-item6">
                <button class="nav-button" onclick="populateItems(eventData, 'ROSY RIDERS')" id="rosy">
                    <div class="navi-icon"><i class="fas fa-seedling"></i></div>
                    <div class="navi-text">ROSY RIDERS</div>
                </button>
            </div>
            <div class="navi-item7">
                <button class="nav-button" onclick="populateItems(eventData, 'TIGER THRASHERS')" id="tiger">
                    <div class="navi-icon"><i class="fas fa-seedling"></i></div>
                    <div class="navi-text">TIGER THRASHERS</div>
                </button>
            </div>
            <div class="navi-item4">
                <button class="nav-button" onclick="populateItems(eventData, 'VIOLET VIPERS')" id="violet">
                    <div class="navi-icon"><i class="fas fa-wine-glass-alt"></i></div>
                    <div class="navi-text">VIOLET VIPERS</div>
                </button>
            </div>
        </div>
        <div class="menu">
            
        </div>
    </div>
    <script src="../public/js/coordinatordashboard.js"></script>
    <script>
        var eventData = <?php echo json_encode($eventData); ?>;
        populateItems(eventData, 'BLUE BLASTERS');
    </script>


</body>

</html>