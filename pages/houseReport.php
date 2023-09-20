<?php
session_start();

if (!isset($_SESSION['role']) && !isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /');
    exit();
}

$role = $_SESSION['role'];

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
    <link rel="stylesheet" href="../public/css/houseDashboardStyles.css">

    <style>
        @media only screen and (max-width: 768px) {
            .img-logo {
                max-width: 65vw !important;
            }
        }
    </style>

</head>

<body>
    <header class="site-header">
        <div class="header-bar">
            <div class="container-fluid">
                <div class="row align-items-center" style="justify-content: space-around;">
                <img src="../public/images/logos/clg-logo-min.png" alt="" class="" width="120">
                <a href="../AdminOfWaves23.php"><img src="../public/images/logos/waves-logo.png" alt="" class="" width="120"></a>
                        <img src="../public/images/logos/ispin-logo.png" alt="" class="" width="80">

                </div>
            </div>
        </div>
    </header>
    <h1 style="margin-top:110px; color: black;">Live House Status</h1>
    <div style="display: flex;
    flex-wrap: wrap;">
        <?php
        $housesResult = mysqli_query($conn, "SELECT * FROM housedb");
        while ($house = mysqli_fetch_assoc($housesResult)) {
            $houseName = $house['name'];
            $path = '../public/images/house/';
            $img = str_replace(" ", "_", $house['name']);
        ?>
            <div class="card dark gradient-border" style="margin-top:20px;display: block;text-align: c;">
                <div style="display: flex;justify-content: center;">
                    <img class='img-logo' style="max-width: 15vw;" src="<?php echo $path . $img . ".png" ?>" class="card-img-top" alt="...">

                </div>
                <div class="card-body">
                    <div class="text-section" style="max-width: 100vh;">
                        <h3 style="color:#e22361" class='card-title'>
                            <?php echo $house['name'] ?>
                        </h3>
                        <?php

                        $totalMembersResult = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM studentdb WHERE house = '$houseName'");
                        $totalMembers = mysqli_fetch_assoc($totalMembersResult);
                        ?>
                        <h5 class="card-text">Total Members:
                            <?php echo $totalMembers['row_count'];
                            mysqli_free_result($totalMembersResult);
                            ?>
                        </h5>
                        <?php
                        $registeredStudentsQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT reg_no) as row_count FROM registerationdb WHERE student_house = '$houseName'");
                        $registeredStudentsDetails = mysqli_fetch_assoc($registeredStudentsQuery);
                        ?>
                        <h5 class="card-text">Participants Count:
                            <?php echo $registeredStudentsDetails['row_count'];
                            mysqli_free_result($registeredStudentsQuery);
                            ?>
                        </h5>

                        <?php
                        $house_name = $house['name'];
                        $queryHouseLeadsName = "SELECT name FROM `admindb` WHERE house_name = '$house_name'";
                        $getHouseLeadsResult = mysqli_query($conn, $queryHouseLeadsName);

                        $houseLeads = array();
                        while ($houseLead = mysqli_fetch_array($getHouseLeadsResult)) {
                            array_push($houseLeads, $houseLead['name']);
                        }
                        ?>
                        <h3 style="color:#e22361" class='card-title'> House Leads Details
                    </h3>
                    <h5 class="card-text">
                        House Incharges:
                        <?php echo $houseLeads[0] . ', ' . $houseLeads[1] ?>
                    </h5>
                    <h5 class="card-text">
                        House Captain:
                        <?php echo $houseLeads[2] ?>
                    </h5>
                    <h5 class="card-text">
                        House Vice Captain:
                        <?php echo $houseLeads[3] ?>
                    </h5>
                    </div>
                    <div class="cta-section">
                        <?php
                        $scoreResult = mysqli_query($conn, "SELECT score FROM housedb WHERE name = '$houseName'");
                        $score = mysqli_fetch_assoc($scoreResult);
                        ?>
                        <!-- <div>Score:
                            <?php echo $score['score'];
                            mysqli_free_result($scoreResult);
                            ?>
                        </div> -->
                        <!-- <a href="#" class="btn btn-light">Buy Now</a> -->
                    </div>
                </div>
            </div>
        <?php
        }
        mysqli_free_result($housesResult);
        ?>
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