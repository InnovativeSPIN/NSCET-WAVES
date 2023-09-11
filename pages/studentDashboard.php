<?php
session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
    header('Location: /'); 
    exit();
}

print_r($_SESSION);

include('../routes/connect.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student | Dashboard</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/studentDashboardStyles.css">
</head>
<body>

<div class="container">
	<div class="row">

    <?php
	$student_reg_no = $_SESSION['reg_no'];
    $registeredEvents = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE reg_no = $student_reg_no");
    while ($registeredEvent = mysqli_fetch_array($registeredEvents)) {
        ?>
        <?php
        $eventName = $registeredEvent['event_name'];
        $eventDetails = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE event_name = '$eventName'");
        $eventDetail =  mysqli_fetch_array($eventDetails);

        $houseName = $registeredEvent['house_name'];
        $houseDetails = mysqli_query($conn, "SELECT * FROM `housedb` WHERE name = '$houshName'");
        $houseDetail =  mysqli_fetch_array($houseDetails);
        ?>

		<div class="col">
			<div class="registered-details-card one">
				<div class="top" style="background: url(<?php echo '../'.$eventDetail['image'] ?>) no-repeat;">
					<div class="wrapper">
						<div class="mynav">
							<a href="#"><span class="lnr lnr-chevron-left"></span></a>
							<a href="#"><span class="lnr lnr-cog"></span></a>
						</div>
						<h1 class="heading"><?php echo $eventDetail['event_date']?></h1>
						<h3 class="location"><?php echo $eventDetail['event_time']?></h3>
						<h3 class="location"><?php echo $eventDetail['event_venue']?></h3>
						<p class="temp">
							<span class="temp-value"><?php echo $eventDetail['event_name']?></span>
						</p>
					</div>
				</div>
				<div class="bottom">
					<div class="wrapper">
						<ul class="forecast">
							<a href="#"><span class="lnr lnr-chevron-up go-up"></span></a>
							<li class="active">
								<span class="date">Yesterday</span>
								<span class="lnr lnr-sun condition">
									<span class="temp">23<span class="deg">0</span><span class="temp-type">C</span></span>
								</span>
							</li>
							<li>
								<span class="date">Tomorrow</span>
								<span class="lnr lnr-cloud condition">
									<span class="temp">21<span class="deg">0</span><span class="temp-type">C</span></span>
								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

        <?php
    }
    ?>
	</div>
</div>
    



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.js"></script>
</body>
</html>