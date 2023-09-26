<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../routes/connect.php');
session_unset();
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Waves'23</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../public/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        .marquee {
            /*   overflow: hidden; */
        }

        .marquee-content {
            display: flex;
            animation: scrolling 15s linear infinite;
        }

        
        .marquee-item {
            flex: 0 0 16vw;
            margin: 0 1vw;
            /*   flex: 0 0 20vw; */
            /*   margin: 0 2vw; */
        }

        .marquee-item img {
            display: block;
            width: 100%;
            /*   padding: 0 20px; */
        }

        @keyframes scrolling {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translatex(-144vw);
            }
        }
    </style>

</head>

<body>
    <section class="our-schedule-area section-padding-100">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="section-heading-2 text-center wow fadeInUp" data-wow-delay="300ms">
                        <h2>Event Showcase</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="schedule-tab">

                        <ul class="nav nav-tabs wow fadeInUp" data-wow-delay="300ms" id="conferScheduleTab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tuesday-tab" data-toggle="tab" href="#step-one"
                                    role="tab" aria-controls="step-one" aria-expanded="true">Tuesday <br>
                                    <span>September 26, 2023</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="wednesday-tab" data-toggle="tab" href="#step-two" role="tab"
                                    aria-controls="step-two" aria-expanded="true">Wednesday <br> <span>September 27,
                                        2023</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="friday-tab" data-toggle="tab" href="#step-three" role="tab"
                                    aria-controls="step-three" aria-expanded="true">Friday <br> <span>September 29,
                                        2023</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="saturday-tab" data-toggle="tab" href="#step-four" role="tab"
                                    aria-controls="step-three" aria-expanded="true">Saturday <br> <span>September 30,
                                        2023</span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="conferScheduleTabContent">
                        <div class="tab-pane fade show active" id="step-one" role="tabpanel"
                            aria-labelledby="monday-tab">

                            <div class="single-tab-content">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='26/09/23'");
                                        while ($event = mysqli_fetch_array($events)) {
                                            ?>
                                            <div class="col-md-12" style='margin-top: 64px;'>
                                                <h2>
                                                    <?php echo $event['event_name'] ?>
                                                </h2>
                                                <div class="marquee">
                                                    <div class="marquee-content">
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="step-two" role="tabpanel" aria-labelledby="monday-tab">

                            <div class="single-tab-content">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='27/09/23'");
                                        while ($event = mysqli_fetch_array($events)) {
                                            ?>
                                            <div class="col-md-12" style='margin-top: 64px;'>
                                                <h2>
                                                    <?php echo $event['event_name'] ?>
                                                </h2>
                                                <div class="marquee">
                                                    <div class="marquee-content">
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="step-three" role="tabpanel" aria-labelledby="monday-tab">

                            <div class="single-tab-content">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='29/09/23'");
                                        while ($event = mysqli_fetch_array($events)) {
                                            ?>
                                            <div class="col-md-12" style='margin-top: 64px;'>
                                                <h2>
                                                    <?php echo $event['event_name'] ?>
                                                </h2>
                                                <div class="marquee">
                                                    <div class="marquee-content">
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="step-four" role="tabpanel" aria-labelledby="monday-tab">

                            <div class="single-tab-content">
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `event_date`='30/09/23'");
                                        while ($event = mysqli_fetch_array($events)) {
                                            ?>
                                            <div class="col-md-12" style='margin-top: 64px;'>
                                                <h2>
                                                    <?php echo $event['event_name'] ?>
                                                </h2>
                                                <div class="marquee">
                                                    <div class="marquee-content">
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>

                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                        <div class="marquee-item">
                                                            <img src=<?php echo '../' . $event['image'] ?> alt="">
                                                        </div>
                                                    </div>
                                                </div>
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
    <footer id="footer" class="site-footer" style='margin-top: 128px;'>
        <div class="footer-cover-title flex justify-content-center align-items-center">
            <h2>Waves'23</h2>
        </div>
        <div class="footer-content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-logo shadow">
                            <img src="../public/images/logos/ispin-logo.png" width="130" alt="">
                            <h4 style="color: white;">Innovative Software Product Industry of NSCET</h4>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="entry-title">
                            <a href="#">Waves'23</a>
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
</body>

<script type="text/javascript" src="../public/js/jquery.js"></script>
<script type="text/javascript" src="../public/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="../public/js/swiper.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="../public/js/circle-progress.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.countTo.min.js"></script>
<script type="text/javascript" src="../public/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r71/three.min.js"></script>
<script type="text/javascript" src="../public/js/3d-text.js"></script>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854"
    integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg=="
    data-cf-beacon='{"rayId":"801ca2883dc3859f","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.8.0","si":100}'
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>


</html>