<?php
include('../routes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allotment</title>

    <link rel="stylesheet" href="allotment.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
</head>

<body>
    <div id="app">
        <h1 style="color: black;">Boys Group Event Allotment</h1>

        <div class="doors" style="flex-wrap: wrap;">
            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px"></div>

            <div class="col-md-2">
                <div class="boxes">
                    <div class="box">
                        <img src="../public/images/house/DINO_THUNDERS.png" width="210px" alt="">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="boxes">
                    <div class="box">
                        <img src="../public/images/house/DRAGON_WARRIORS.png" width="210px" alt="">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="boxes">
                    <div class="box">
                        <img src="../public/images/house/PHOENIX_BLASTERS.png" width="210px" alt="">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="boxes">
                    <div class="box">
                        <img src="../public/images/house/TIGER_THRASHERS.png" width="210px" alt="">
                    </div>
                </div>
            </div>

            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px"></div>
            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px">Group 1</div>


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

            <div class="col-md-2" style="align-self: center;text-align:center;color: black;font-size:20px">Group 2</div>

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
            <button onclick="confetiiShow()"
                style="PADDING: 10PX 29PX;border: none;FONT-SIZE: 25PX; border-radius: 4px;" class="btn-primary"
                id="spinner">Spin</button>
            <a class="btn" id="reseter" href=" ">Reset</a>
        </div>

        <form class="buttons row" action="../routes/admin/assignSlot.php" method="post">
            <input type="text" id="slot" name="slot_array" style="display: none;">
            <input type="text" id="slot" name="gender" value="BOYS" style="display: none;">
            <div class="form-group col-8" id='login-event-name'>
                <input type="text" list="listName" name="event_name" placeholder="Enter Event Name"
                    class="form-control">
                <datalist id="listName">
                    <?php
                    $events = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `is_group`='1' && `gender`!='GIRLS'");
                    while ($event = mysqli_fetch_array($events)) {
                        ?>
                        <option value="<?php echo $event['event_name'] ?>">
                            <?php echo $event['event_name'] ?>
                        </option>

                        <?php
                    }
                    ?>
                </datalist>
            </div>
            
            <button type="submit" name='submit' class="btn-primary col-4" style="height: 40px; border-radius: 4px;"
                id="spinner">Submit</button>
            <!-- <a class="btn" id="reseter" href=" ">Reset</a> -->
        </form>

        <p class="info" style="visibility: hidden;"></p>
    </div>

    <script src="./groped.js"></script>
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
        const interval = setInterval(function () {
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