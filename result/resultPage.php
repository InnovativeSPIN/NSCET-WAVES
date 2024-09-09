<?php
include('../routes/connect.php');
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Result Page</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,400,700" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../public/css/base.css" />
	<link rel="stylesheet" type="text/css" href="../public/css/resultCard.css" />
	<script>document.documentElement.className = "js"; var supportsCssVars = function () { var e, t = document.createElement("style"); return t.innerHTML = "root: { --tmp-var: bold; }", document.head.appendChild(t), e = !!(window.CSS && window.CSS.supports && window.CSS.supports("font-weight", "var(--tmp-var)")), t.parentNode.removeChild(t), e }; supportsCssVars() || alert("Please view this demo in a modern browser that supports CSS Variables.");</script>
</head>

<body class="demo-8">
	<main>
		<div class="content content--fixed">

			<div class="debug">
				<svg class="icon icon--debug" title="Toggle Debug Mode" style="display:none;">
					<use xlink:href="#icon-debug"></use>
				</svg>
				<div class="timescale-wrap">
					<label class="timescale-label">
						<span class="timescale-title">Timescale:</span>
						<span class="timescale-value">1.0</span>
						<input class="timescale-range" type="range" min="0" max="3" step="0.1" value="1">
					</label>
				</div>
			</div>
		</div>
		<div class="loader"></div>
		<div class="content-outer">
			<div class="content-inner">
				<h1 style="display:none;">Superposition</h1>
				<a style="display:none;" href="#" class="replay-animation">Replay</a>
				

				<section>
					<div class="row">
						<?php
						$i=0;
						$houseDetails = mysqli_query($conn, "SELECT * FROM `housedb` WHERE `gender` = 'BOYS' ORDER BY `housedb`.`score` ASC");
						while ($houseDetail = mysqli_fetch_array($houseDetails)) {
							?>
							<div class="col-lg-3 col-md-3 col-sm-6">
								<div class="cardSection" style="--color: hsl(357, 100%, 49%);">
									<div class="card__border"></div>
									<div class="card__border-line"></div>
									<div class="card__inner">
										<div class="card__img">
											<div class="img__team">
												<?php if($i == 0){?>
												<img src="../public/images/gold-medal-1st.png" alt="Team Position">
												<?php }elseif($i == 1){?>
												<img src="../public/images/silver-medal-runner.png" alt="Team Position">
												<?php } else{?>
													<img src="../public/images/runners.png" alt="Team Position">
												<?php }?>
											</div>
											<div class="img__athlete">
												<?php
												$path = '../public/images/house/';
												$img = str_replace(" ", "_", $houseDetail['name']);
												?>
												<img src="<?php echo $path . $img . ".png" ?>" class="card-img-top"
													alt="Team Logo">
											</div>
										</div>
										<div class="card__text">
											<h1 class="name" style="color:black;">Score</h1>
											<p class="points" style="color:black;">
												<?php echo $houseDetail['score'] ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						<?php $i++; } ?>
					</div>
					<br><br>
					<div class="row">
						<?php
						$i = 0;
						$houseDetails = mysqli_query($conn, "SELECT * FROM `housedb` WHERE `gender` = 'GIRLS' ORDER BY `housedb`.`score` ASC");
						while ($houseDetail = mysqli_fetch_array($houseDetails)) {
							?>
							<div class="col-lg-3 col-md-3 col-sm-6">
								<div class="cardSection" style="--color: hsl(357, 100%, 49%);">
									<div class="card__border"></div>
									<div class="card__border-line"></div>
									<div class="card__inner">
										<div class="card__img">
											<div class="img__team">
											<?php if($i == 0){?>
												<img src="../public/images/gold-medal-1st.png" alt="Team Position">
												<?php }elseif($i == 1){?>
												<img src="../public/images/silver-medal-runner.png" alt="Team Position">
												<?php } else{?> 
													<img src="../public/images/runners.png" alt="Team Position">
												<?php }?>
											</div>
											<div class="img__athlete">
												<?php
												$path = '../public/images/house/';
												$img = str_replace(" ", "_", $houseDetail['name']);
												?>
												<img src="<?php echo $path . $img . ".png" ?>" class="card-img-top"
													alt="Team Logo">
											</div>
										</div>
										<div class="card__text">
											<h1 class="name" style="color:black;">Score</h1>
											<p class="points" style="color:black;">
												<?php echo $houseDetail['score'] ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						<?php $i++; } ?>
					</div>
					<br><br>
				</section>
			</div>
		</div>	
	</main>
	
	<script src="../public/js/demo.js"></script>
	<script src="../public/js/vendor/three.min.js"></script>
	<script src="../public/js/vendor/OrbitControls.js"></script>
	<script src="../public/js/vendor/fast-simplex-noise.js"></script>
	<script src="../public/js/demo-8/index.bundle.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
		crossorigin="anonymous"></script>

</body>

</html>