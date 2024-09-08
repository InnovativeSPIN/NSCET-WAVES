<?php
include('../../routes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allotment</title>

    <link rel="stylesheet" href="../allotment.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
</head>

<body>
    <style>
        h1{
            color: black;
        }

    </style>
    <header class="site-header">
        <div class="header-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-10 col-lg-4">
                        <h1 class="site-branding flex">
                            <img src="../../public/images/logos/waves-logo.png" alt="" class="" width="120">

                            <!-- <a href="#">Waves'23</a> -->
                        </h1>
                    </div>
                    <div class="col-2 col-lg-8">
                        <nav class="site-navigation">
                            <div class="hamburger-menu d-lg-none" style="position: fixed;">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <ul>
                                <li><a href="../../AdminOfWaves24.php"><button type="button" class="btn btn-login btn-primary" data-toggle="modal" data-target="#loginModal">BACK</button></a> </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="app">

        <h1 style="color: black;">Girls Team Name Allotment</h1>

        <div class="doors" style="flex-wrap: wrap;">
            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px"></div>

            <div class="col-md-2 ">
                <div class="boxes">
                    <div class="box">
                        <h1>G1</h1>
                    </div>
                </div>
            </div>

            <div class="col-md-2 ">
                <div class="boxes">
                    <div class="box">
                        <h1>G2</h1>

                    </div>
                </div>
            </div>

            <div class="col-md-2 ">
                <div class="boxes">
                    <div class="box">
                        <h1>G3</h1>

                    </div>
                </div>
            </div>

            <div class="col-md-2 ">
                <div class="boxes">
                    <div class="box">
                        <h1>G4</h1>

                    </div>
                </div>
            </div>



            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px"></div>
            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px"></div>


            <div class="col-md-2 door">
                <div class="boxes">
                    <!-- <div class="box">?</div> -->
                </div>
            </div>

            <div class="col-md-2 door">
                <div class="boxes">
                    <!-- <div class="box">?</div> -->
                </div>
            </div>

            <div class="col-md-2 door">
                <div class="boxes">
                    <!-- <div class="box">?</div> -->
                </div>
            </div>

            <div class="col-md-2 door">
                <div class="boxes">
                    <!-- <div class="box">?</div> -->
                </div>
            </div>
        </div>

        <div class="buttons">
            
            <button onclick="confetiiShow()" style="PADDING: 10PX 29PX;border: none;FONT-SIZE: 25PX; border-radius: 4px;" class="btn-primary" id="spinner">SPIN</button>
            <a class="btn" id="reseter" href=" ">Reset</a>
            
        </div>
        <form class="buttons" action="../routes/admin/assignTeam.php" method="post" style="text-align: center;">
            <input type="text" id="slot" name="slot_array" style="display: none;">
            <input type="text" id="slot" name="gender" value="GIRLS" style="display: none;">
            
            <button type="submit" name='submit' class="btn-primary col-4" style="height: 40px; border-radius: 4px;width: 240px;" id="spinner">Submit</button>
            <!-- <a class="btn" id="reseter" href=" ">Reset</a> -->
        </form>

        <p class="info" style="visibility: hidden;"></p>
    </div>
    
    <script src="./girls.js"></script>
</body>

<script>
    const duration = 10 * 1200,
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

    function confetiiShow() {
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
        }, 300);
    }
</script>

</html>