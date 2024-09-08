<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('routes/connect.php');
session_unset();
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Waves'24</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body id="body">

    <header class="site-header">
        <div class="header-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-10 col-lg-4">
                        <h1 class="site-branding flex">
                            <!-- <img src="public/images/logos/waves-logo.png" alt="" class="" width="120"> -->

                            <!-- <a href="#">Waves'24</a> -->
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
                                <li><a href="#">Waves'24</a></li>
                                <li><a href="#">ARTISTS</a></li>
                                <li><a href="#">BLOG</a></li>
                                <li><a href="#">CONTACT</a></li>
                                <li><a href="#"><i class="fas fa-search"></i></a></li> -->
                                <!-- <li><button type="button" class="btn btn-login btn-primary" data-toggle="modal" data-target="#loginModal">Login</button></li> -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>




    <div class="hero-content">
        <div class="row">
            <div class="col-md-12" style="
    align-items: center;">

                <div class="entry-header">
                    <div class="shadow">

                        <img src="public/images/logos/clg-logo.png" alt="" class="" width="180">
                        <img style="margin-bottom: 24px;" src="public/images/logos/waves-logo.png" alt="" class="" width="150">

                    </div>
                    <!-- <h2 id="waves-text" style="filter: drop-shadow( 0px 0px 30px rgba(255, 255, 255, 1));;font-family: 'mountains';padding: 0;margin-bottom: 32px;">Waves 24</h2> -->


                    <!-- <div id="stage" style="margin-top: 64px;display: nonr;"></div> -->

                    <!-- <canvas id="text" width="800" height="200"></canvas> -->

                    <!-- <input id="input" type="text" value="Waves'24 W" style="display: none;" /> -->

                </div>


                <div class="col-md-12">
                    <div class="entry-footer">

                        <a href="#plans" class="btn btn-primary">
                            Event and Slot Allotment
                        </a>
                        <a href="/pages/houseReport.php" class="btn current">House Status</a>
                        <a href="/pages/adminForm.php" class="btn current">Admin Panel</a>

                        <!-- <a href="/pages/adminForm.php" class="btn current">Allot Group Name</a> -->


                    </div>
                </div>

            </div>
            <div class="row">

            </div>
        </div>
    </div>

    <div class="content-section" style="padding: 0;min-height: 2300px;">
        <div class="container">
            <section class="our-schedule-area section-padding-100">
                <div class="container">
                    <div id="plans" class="row">

                        <div class="col-12">
                            <div class="section-heading-2 text-center wow fadeInUp" data-wow-delay="300ms">
                                <h2>Schedule Plan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="schedule-tab">

                                <ul class="nav nav-tabs wow fadeInUp" data-wow-delay="300ms" id="conferScheduleTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tuesday-tab" data-toggle="tab" href="#step-one" role="tab" aria-controls="step-one" aria-expanded="true">Tuesday <br> <span>September 26, 2023</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="wednesday-tab" data-toggle="tab" href="#step-two" role="tab" aria-controls="step-two" aria-expanded="true">Wednesday <br> <span>September 27, 2023</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="friday-tab" data-toggle="tab" href="#step-three" role="tab" aria-controls="step-three" aria-expanded="true">Friday <br> <span>September 29, 2023</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="saturday-tab" data-toggle="tab" href="#step-four" role="tab" aria-controls="step-three" aria-expanded="true">Saturday <br> <span>September 30, 2023</span></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="conferScheduleTabContent">
                                <div class="tab-pane fade show active" id="step-one" role="tabpanel" aria-labelledby="monday-tab">

                                    <div class="single-tab-content">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='26/09/23'");
                                                while ($event = mysqli_fetch_array($events)) {
                                                ?><div data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>" class="single-schedule-area d-flex flex-wrap justify-content-between align-items-center wow fadeInUp" data-wow-delay="300ms">

                                                        <div class="single-schedule-tumb-info d-flex align-items-center">

                                                            <div class="single-schedule-tumb">
                                                                <img height="100px" width="100px" src="<?php echo $event['image'] ?>">
                                                            </div>

                                                            <div class="single-schedule-info">
                                                                <h6><?php echo $event['event_name'] ?></h6>
                                                                <p>Cordinators,
                                                                    <br />
                                                                    <?php $coordinators = explode("|", $event['event_cordinators']);
                                                                    foreach ($coordinators as $letter => $index) {
                                                                        echo '<span>' . $coordinators[$letter] . '<br /></span>';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="schedule-time-place">
                                                            <p><i class="zmdi zmdi-time"></i><?php echo $event['event_date'] ?> | <?php echo $event['event_time'] ?></p>
                                                            <p><i class="zmdi zmdi-map"></i> <?php echo $event['event_venue'] ?></p>
                                                        </div>

                                                        <?php 
                                                        $data = $event['is_group'];

                                                        if ($data == 0) {
                                                        ?>
                                                            <a href=<?php echo '/allotment/ungroped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }else{
                                                            ?>
                                                            <a href=<?php echo '/allotment/groped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="step-two" role="tabpanel" aria-labelledby="monday-tab">

                                    <div class="single-tab-content">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='27/09/23'");
                                                while ($event = mysqli_fetch_array($events)) {
                                                ?><div data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>" class="single-schedule-area d-flex flex-wrap justify-content-between align-items-center wow fadeInUp" data-wow-delay="300ms">

                                                        <div class="single-schedule-tumb-info d-flex align-items-center">

                                                            <div class="single-schedule-tumb">
                                                                <img height="100px" width="100px" src="<?php echo $event['image'] ?>">
                                                            </div>

                                                            <div class="single-schedule-info">
                                                                <h6><?php echo $event['event_name'] ?></h6>
                                                                <p>Cordinators,
                                                                    <br />
                                                                    <?php $coordinators = explode("|", $event['event_cordinators']);
                                                                    foreach ($coordinators as $letter => $index) {
                                                                        echo '<span>' . $coordinators[$letter] . '<br /></span>';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="schedule-time-place">
                                                            <p><i class="zmdi zmdi-time"></i><?php echo $event['event_date'] ?> | <?php echo $event['event_time'] ?></p>
                                                            <p><i class="zmdi zmdi-map"></i> <?php echo $event['event_venue'] ?></p>
                                                        </div>

                                                        <?php 
                                                        $data = $event['is_group'];

                                                        if ($data == 0) {
                                                        ?>
                                                            <a href=<?php echo '/allotment/ungroped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }else{
                                                            ?>
                                                            <a href=<?php echo '/allotment/groped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="step-three" role="tabpanel" aria-labelledby="monday-tab">

                                    <div class="single-tab-content">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='29/09/23'");
                                                while ($event = mysqli_fetch_array($events)) {
                                                ?><div data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>" class="single-schedule-area d-flex flex-wrap justify-content-between align-items-center wow fadeInUp" data-wow-delay="300ms">

                                                        <div class="single-schedule-tumb-info d-flex align-items-center">

                                                            <div class="single-schedule-tumb">
                                                                <img height="100px" width="100px" src="<?php echo $event['image'] ?>">
                                                            </div>

                                                            <div class="single-schedule-info">
                                                                <h6><?php echo $event['event_name'] ?></h6>
                                                                <p>Cordinators,
                                                                    <br />
                                                                    <?php $coordinators = explode("|", $event['event_cordinators']);
                                                                    foreach ($coordinators as $letter => $index) {
                                                                        echo '<span>' . $coordinators[$letter] . '<br /></span>';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="schedule-time-place">
                                                            <p><i class="zmdi zmdi-time"></i><?php echo $event['event_date'] ?> | <?php echo $event['event_time'] ?></p>
                                                            <p><i class="zmdi zmdi-map"></i> <?php echo $event['event_venue'] ?></p>
                                                        </div>
                                                        <?php 
                                                        $data = $event['is_group'];
                                                            
                                                        if ($data == 0) {
                                                        ?>
                                                            <a href=<?php echo '/allotment/ungroped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }else{
                                                            ?>
                                                            <a href=<?php echo '/allotment/groped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade show" id="step-four" role="tabpanel" aria-labelledby="monday-tab">

                                    <div class="single-tab-content">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='30/09/23'");
                                                while ($event = mysqli_fetch_array($events)) {
                                                ?><div data-toggle="modal" data-target=".<?php echo $event['event_id'] ?>" class="single-schedule-area d-flex flex-wrap justify-content-between align-items-center wow fadeInUp" data-wow-delay="300ms">

                                                        <div class="single-schedule-tumb-info d-flex align-items-center">

                                                            <div class="single-schedule-tumb">
                                                                <img height="100px" width="100px" src="<?php echo $event['image'] ?>">
                                                            </div>

                                                            <div class="single-schedule-info">
                                                                <h6><?php echo $event['event_name'] ?></h6>
                                                                <p>Cordinators,
                                                                    <br />
                                                                    <?php $coordinators = explode("|", $event['event_cordinators']);
                                                                    foreach ($coordinators as $letter => $index) {
                                                                        echo '<span>' . $coordinators[$letter] . '<br /></span>';
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="schedule-time-place">
                                                            <p><i class="zmdi zmdi-time"></i><?php echo $event['event_date'] ?> | <?php echo $event['event_time'] ?></p>
                                                            <p><i class="zmdi zmdi-map"></i> <?php echo $event['event_venue'] ?></p>
                                                        </div>

                                                        <?php 
                                                        $data = $event['is_group'];

                                                        if ($data == 0) {
                                                        ?>
                                                            <a href=<?php echo '/allotment/ungroped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }else{
                                                            ?>
                                                            <a href=<?php echo '/allotment/groped.php?eventName=' . urlencode($event['event_name']) ?> class="btn confer-btn"> Slot <i class="zmdi zmdi-long-arrow-right"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="site-footer">
            <div class="footer-cover-title flex justify-content-center align-items-center">
                <h2>Waves'24</h2>
            </div>
            <div class="footer-content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer-logo shadow">
                                <img src="public/images/logos/ispin-logo.png" width="130" alt="">
                                <h4 style="color: white;">Innovative Software Product Industry of NSCET</h4>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="entry-title">
                                <a href="#">Waves'24</a>
                            </div>

                            <div class="copyright-info">

                                Copyright &copy;
                                <script data-cfasync="false" src="public/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> Design & Developed with <i style="color: red;" class="fa fa-heart" aria-hidden="true"></i> by <br /> <a href="https://nscet.org/ispin/" target="_blank" style="font-size: 19px;color: white;">Department of Computer Science Engineering | iSPIN</a>
                            </div>



                            <div class="footer-social">
                                <ul class="flex justify-content-center align-items-center">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
        <script type="text/javascript" src="public/js/jquery.js"></script>
        <script type="text/javascript" src="public/js/masonry.pkgd.min.js"></script>
        <script type="text/javascript" src="public/js/jquery.collapsible.min.js"></script>
        <script type="text/javascript" src="public/js/swiper.min.js"></script>
        <script type="text/javascript" src="public/js/jquery.countdown.min.js"></script>
        <script type="text/javascript" src="public/js/circle-progress.min.js"></script>
        <script type="text/javascript" src="public/js/jquery.countTo.min.js"></script>
        <script type="text/javascript" src="public/js/custom.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js"></script>
        <script type="text/javascript" src="public/js/3d-text.js"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
        <script>
            var window, dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-23581568-13');
        </script>
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
            AOS.init();
        </script>
        <script>
            function checkLogin() {
                if (document.getElementById('login-role').value == 'student') {
                    document.getElementById('login-event-name').style.display = 'none'
                    document.getElementById('login-event-password').style.display = 'none'
                    document.getElementById('login-house-name').style.display = 'none'
                    document.getElementById('login-event-regno').style.display = 'block'
                }
                if (document.getElementById('login-role').value == 'event coordinator') {
                    document.getElementById('login-event-regno').style.display = 'none'
                    document.getElementById('login-house-name').style.display = 'none'
                    document.getElementById('login-event-name').style.display = 'block'
                    document.getElementById('login-event-password').style.display = 'block'
                }
                if (document.getElementById('login-role').value == 'team captain') {
                    document.getElementById('login-event-regno').style.display = 'none'
                    document.getElementById('login-event-name').style.display = 'none'
                    document.getElementById('login-house-name').style.display = 'block'
                    document.getElementById('login-event-password').style.display = 'block'
                }
                if (document.getElementById('login-role').value == 'team incharge') {
                    document.getElementById('login-event-regno').style.display = 'none'
                    document.getElementById('login-event-name').style.display = 'none'
                    document.getElementById('login-house-name').style.display = 'block'
                    document.getElementById('login-event-password').style.display = 'block'
                }
            }
        </script>

        <script>
            const duration = 10 * 1000,
                animationEnd = Date.now() + duration,
                defaults = {
                    startVelocity: 30,
                    spread: 360,
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
        <script>
            function clickEffect(e) {
                var d = document.createElement("div");
                d.className = "clickEffect";
                d.style.top = e.clientY + "px";
                d.style.left = e.clientX + "px";
                document.body.appendChild(d);
                d.addEventListener('animationend', function() {
                    d.parentElement.removeChild(d);
                }.bind(this));
            }
            document.addEventListener('click', clickEffect);
        </script>
</body>

</html>