<?php
session_start();

if (!isset($_SESSION['name']) && !isset($_SESSION['reg_no'])) {
	header('Location: /');
	exit();
}

$role = $_SESSION['role'];

if ($role != 'student') {
	header('Location: /');
	exit();
}

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
	<link rel="stylesheet" href="../public/css/houseDashboardStyles.css">
	<link rel="stylesheet" href="../public/css/style.css">

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
							<div class="hamburger-menu d-lg-none">
								<span style="background-color:black"></span>
								<span style="background-color:black"></span>
								<span style="background-color:black"></span>
								<span style="background-color:black"></span>
							</div>
							<ul>
								<li><a href="../index.php"><button type="button" class="btn btn-login btn-primary"
											data-toggle="modal" data-target="#loginModal">Logout</button></a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div style="margin-top: 138px;">
			<div class="card dark gradient-border">

				<?php
				$path = '../public/images/house/';
				$img = str_replace(" ", "_", $_SESSION['house']);
				?>
				
				<img src="<?php echo $path . $img . ".png" ?>" class="card-img-top" alt="...">
				<?php
				$house_name = $_SESSION['house'];
				$queryHouseLeadsName = "SELECT name FROM `admindb` WHERE house_name = '$house_name'";
				$getHouseLeadsResult = mysqli_query($conn, $queryHouseLeadsName);

				$houseLeads = array();
				while ($houseLead = mysqli_fetch_array($getHouseLeadsResult)) {
					array_push($houseLeads, $houseLead['name']);
				}
				?>
				<div class="card-body">
					<div class="text-section">
						<h1 style="color:#e22361;text-align: center;" class='card-title'>
							Group : <?php echo $_SESSION['house'] ?>
						</h1>
						<h5 class="card-text">
							Your Reg No:
							<?php echo $_SESSION['reg_no'] ?>
						</h5>
						<h5 class="card-text">
							Your Name:
							<?php echo $_SESSION['name'] ?>
						</h5>
						<h5 class="card-text">
							Your Department:
							<?php echo $_SESSION['dept'] ?>
						</h5>
						<h5 class="card-text">
							Your Year:
							<?php echo $_SESSION['year'] ?>
						</h5>
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
						<h5 class="card-text">
							House Vice Captain:
							<?php echo $houseLeads[4] ?>
						</h5>
					</div>


				</div>
			</div>
			<div class="row">
				<h2 style="color: black;">Your Events</h2>

				<?php
				$student_reg_no = $_SESSION['reg_no'];
				$registeredEvents = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE reg_no = $student_reg_no");
				while ($registeredEvent = mysqli_fetch_array($registeredEvents)) {
					?>

					<?php
					$eventName = $registeredEvent['event_name'];
					$eventDetails = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE event_name = '$eventName'");
					$eventDetail = mysqli_fetch_array($eventDetails);

					$houseName = $registeredEvent['student_house'];
					$houseDetails = mysqli_query($conn, "SELECT * FROM `housedb` WHERE name = '$houseName'");
					$houseDetail = mysqli_fetch_array($houseDetails);

					$allotmentListResult = mysqli_query($conn, "SELECT * FROM `allotmentdb` WHERE `event`= '$eventName' && house = '$houseName'");
					$slot = mysqli_fetch_array($allotmentListResult);
					?>
					<!-- Modal -->
					<div class="modal fade <?php echo $eventDetail['event_id'] ?>" tabindex="-1" role="dialog"
						aria-labelledby="<?php echo $eventDetail['event_id'] ?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content" style="padding: 23px;">
								<div class="modal-header">
									<h4 class="modal-title" id="exampleModalLabel" style="color: #e22361;">
										<?php echo $eventDetail['event_name'] ?>
									</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div>
										<div style="margin: 12px; text-align: center;">
											<img src="<?php echo '../' . $eventDetail['image'] ?>" alt="" srcset=""
												width="270px" height="170px" style="margin: 22px;">

											<h4>
												<?php echo $eventDetail['event_date'] ?>
											</h4>
											<h4>
												<?php echo $eventDetail['event_time'] ?>
											</h4>
											<h4>
												<?php echo $eventDetail['event_venue'] ?>
											</h4>

											<p>Event Cordinators
												<br />
												<?php $coordinators = explode("|", $eventDetail['event_cordinators']);
												foreach ($coordinators as $letter => $index) {
													echo '<span>' . $coordinators[$letter] . '<br /></span>';
												}
												?>
											</p>
										</div>
										<h4 style="color: #e22361;">Rules</h4>
										<p>

											<?php $rules = explode(".", $eventDetail['event_rules']);
											array_pop($rules);
											foreach ($rules as $letter => $index) {
												echo ($letter + 1) . '. ' . $rules[$letter] . '<br />';
											}


											?>
										</p>
									</div>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div data-toggle="modal" data-target=".<?php echo $eventDetail['event_id'] ?>"
							class="single-schedule-area d-flex flex-wrap justify-content-between align-items-center wow fadeInUp"
							data-wow-delay="300ms">

							<div class="single-schedule-tumb-info d-flex align-items-center">

								<div class="single-schedule-tumb">
									<img height="100px" width="100px" src="<?php echo '../' . $eventDetail['image'] ?>">
								</div>

								<div class="single-schedule-info">
									<h6>
										<?php echo $eventDetail['event_name'] ?>
									</h6>
									<p>Cordinators,
										<br />
										<?php $coordinators = explode("|", $eventDetail['event_cordinators']);
										foreach ($coordinators as $letter => $index) {
											echo '<span>' . $coordinators[$letter] . '<br /></span>';
										}
										?>
									</p>
								</div>
							</div>

							<div class="schedule-time-place">
								<p><i class="zmdi zmdi-time"></i>
									<?php echo $eventDetail['event_date'] ?> |
									<?php echo $eventDetail['event_time'] ?>
								</p>
								<p><i class="zmdi zmdi-map"></i>
									<?php echo $eventDetail['event_venue'] ?>
								</p>
								<p>Slot No: <?php echo $slot['slot'] ?></p>
							</div>

							<a class="btn confer-btn">Detail <i class="zmdi zmdi-long-arrow-right"></i></a>
						</div>
					</div>


					<!-- <div class="col">
					<div class="registered-details-card one">
						<div class="top" style="background: url(<?php echo '../' . $eventDetail['image'] ?>) no-repeat;">
							<div class="wrapper">
								<div class="mynav">
									<a href="#"><span class="lnr lnr-chevron-left"></span></a>
									<a href="#"><span class="lnr lnr-cog"></span></a>
								</div>
								<h1 class="heading"><?php echo $eventDetail['event_date'] ?></h1>
								<h3 class="location"><?php echo $eventDetail['event_time'] ?></h3>
								<h3 class="location"><?php echo $eventDetail['event_venue'] ?></h3>
								<p class="temp">
									<span class="temp-value"><?php echo $eventDetail['event_name'] ?></span>
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
				</div> -->

					<?php
				}
				?>
			</div>
		</div>




		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="../public/js/jquery.js"></script>
		<script type="text/javascript" src="../public/js/jquery.js"></script>
		<script type="text/javascript" src="../public/js/masonry.pkgd.min.js"></script>
		<script type="text/javascript" src="../public/js/jquery.collapsible.min.js"></script>
		<script type="text/javascript" src="../public/js/swiper.min.js"></script>
		<script type="text/javascript" src="../public/js/jquery.countdown.min.js"></script>
		<script type="text/javascript" src="../public/js/circle-progress.min.js"></script>
		<script type="text/javascript" src="../public/js/jquery.countTo.min.js"></script>
		<script type="text/javascript" src="../public/js/custom.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
			integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
			</script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
			integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
			</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
			integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
			</script>
		<script
			src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
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
			}, 250);
		</script>
</body>

</html>