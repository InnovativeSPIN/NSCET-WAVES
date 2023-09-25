<?php ?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Result Page</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../public/css/base.css" />
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
				<h1>Superposition</h1>
				<a href="#" class="replay-animation">Replay</a>
			</div>
		</div>
	</main>
	<script src="../public/js/demo.js"></script>
	<script src="../public/js/vendor/three.min.js"></script>
	<script src="../public/js/vendor/OrbitControls.js"></script>
	<script src="../public/js/vendor/fast-simplex-noise.js"></script>
	<script src="../public/js/demo-8/index.bundle.js"></script>
</body>

</html>