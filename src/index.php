<!--/*Includes all header and declarations*/-->
<?php
	$page = "1";
	include ".header.php";
?>
<head>
	<meta name="Description" content="The main page of this website. It shows the tree animation and exact water level.">
	<title>
		Home
	</title>
<style>
<!--/*PHP Code for adjusting the height of the water in the tree*/-->
<?php
	$percent_full = file_get_contents("logs/latest.txt");

	$wave_timing = $percent_full / 100.0 * 1.5; /*Make timing change as the height of the water changes*/

	$wave_top_m = -360;
	$wave_top_b = 830;
	$wave_top = ($wave_top_m * $percent_full / 100.0) + $wave_top_b; /*range 100% 470px to 0% 830px so equation = -360(x/100.0) + 830*/

	$wavebox_top_m = -435;
	$wavebox_top_b = 850;
	$wavebox_top = ($wavebox_top_m * $percent_full / 100.0) + $wavebox_top_b; /*range: 100%: 415px, 0%: 850px; 400px + height of tree (400px) - height of block (varible)*/
	$wavebox_height = 850 - $wavebox_top; /*/*this plus top must equal 850px*/
?>
<!--/*Stye of tree (not in style.css so that it can be adjusted with php)*/-->
svg.wave {
	position: absolute;
	left: 0;
	right: 0;
	top: /*100%: 470px, 0%: 830px*/
	<?php
		echo $wave_top, "px;";
	?>
	margin: auto;
	z-index: -1;
	animation: WaveUDMotion
	<?php
		echo $wave_timing, "s ";
	?>
	linear 0s 1 normal, WaveLRMotion 0.75s linear 0s infinite normal;
}
svg.wavebox {
	position: absolute;
	left: 0;
	right: 0;
	top: /*415px;*/
	<?php
		echo $wavebox_top, "px;";
	?>
	margin: auto;
	z-index: -1;
	height: /*435px;*/
	<?php
		echo $wavebox_height, "px;";
	?>
	animation: WaveboxUDMotion
	<?php
		echo $wave_timing, "s ";
	?>
	linear 0s 1 normal;
}
@keyframes WaveboxUDMotion {
	0% {
		height: 0px;
		top: 850px;
	}
	100% {
		height: /*435px;*/
	<?php
		echo $wavebox_height, "px;";
	?>
		top: /*415px;*/
	<?php
		echo $wavebox_top, "px;";
	?>
	}
}
@keyframes WaveUDMotion {
	0% {
		top: 830px;
	}
	100% {
		top: /*830px; /*range: 830px(empty) to 470px(full)*//*\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\make adjustable*/
	<?php
		echo $wave_top, "px;";
	?>
	}
}
@keyframes WaveLRMotion {
	0% {
		transform: translateX(-95px);
	}
	100% {
		transform: translateX(90px);
	}
}
</style>
</head>
<body>
<!--/*---------------Message---------------*/-->
<!--/*Auto-adjusting alert based on current water level*/-->
<h1 class="alert">
	<?php
		if ($percent_full < "026") {
			echo "Fill me up immediately!";
		}
		elseif ($percent_full < "051") {
			echo "Fill me up quite soon.";
		}
		elseif ($percent_full < "076") {
			echo "Fill me up when you have a chance.";
		}
		elseif ($percent_full < "101") {
			echo "No need to fill me up.";
		}
	?>
</h1>

<!--/*Standard message displaying the latest reading of the water level and when it was taken*/-->
<p class="msg">
	The christmas tree is
	<?php echo ltrim($percent_full, "0");?>% full at
	<?php echo file_get_contents("logs/latest-time.txt");?>.
</p>



<!--/*SVG code for the star on to of the tree*/-->
<!--/*  calculating x and y from radius (r) and angle (n) (for star) x = cos(n) * r + xoffset
	 and y = -1 * (sin(n) * r) + yoffest (because y increase as you go down the screen);
	 angle of star is 360/5 = 72 degrees but peak at 90 so angles are 18, 90, 162, 234 and 306;
	 inner point created by another circle with radius r/2 and also angles offset by 36 degrees
	 so angles are 54, 126, 198, 270 and 342
	*/-->
<svg class="star" width="100px" height="100px" viewBox="0 0 100 100">
	<path d="M50 0 L35.3 29.8 L5 31 L26.2 57.7 L20 90 L50 75 L80 90 L73.8 57.7 L95 31 L64.7 29.8 L50 0" fill="gold" stroke="none"/>
</svg>

<!--/*Labels for visual reference of how full the tree is*/-->
<h3 class="measurement">
	100%
	<br>
	90%
	<br>
	80%
	<br>
	70%
	<br>
	60%
	<br>
	50%
	<br>
	40%
	<br>
	30%
	<br>
	20%
	<br>
	10%
	<br>
	0%
</h3>

<!--/*SVG code for the mask and border of the tree branches and trunk*/-->
<svg class="tree" width="700px" height="400px" viewBox="-100 0 400 300" preserveAspectRatio="none">
	<g class="masktree">
		<path d="M0 0 L200 0 L200 50 L100 0 L0 50 L50 50 L0 75 L50 75 L0 100 L50 100 L0 125 L50 125 L0 150 L50 150 L0 175 L50 175 L0 200 L50 200 L0 225 L50 225 L0 250 L50 250 L0 275 M200 50 L150 50 L200 75 L150 75 L200 100 L150 100 L200 125 L150 125 L200 150 L150 150 L200 175 L150 175 L200 200 L150 200 L200 225 150 225 L200 250 L150 250 L200 275 Z" fill="#328832" stroke="none"/>
		<path d="M0 275 L0 300 L75 300 L75 275 L0 275 M125 275 L125 300 L200 300 L200 275 L125 275 Z" fill="#328832" stroke="none" />
		<rect width="100px" height="300px" x="-100" y="0" fill="#328832" />
		<rect width="100px" height="300px" x="200" y="0" fill="#328832" />
	</g>
	<!--/*SVG code for the outline or the tree branches and trunk*/-->
	<g class="bordertree">
		<path d="M200 50 L100 0 L0 50 L50 50 L0 75 L50 75 L0 100 L50 100 L0 125 L50 125 L0 150 L50 150 L0 175 L50 175 L0 200 L50 200 L0 225 L50 225 L0 250 L50 250 L0 275 M200 50 L150 50 L200 75 L150 75 L200 100 L150 100 L200 125 L150 125 L200 150 L150 150 L200 175 L150 175 L200 200 L150 200 L200 225 150 225 L200 250 L150 250 L200 275" fill="none" stroke="black" stroke-width="1px"/>
		<path d="M0 275 L75 275 L75 300 L125 300 L125 275 L200 275" fill="none" stroke="black" stroke-width="1px" />
	</g>
</svg>

<!--/*SVG and HTML code for the water part of the rising water animation*/-->
<svg class="wave" width="500px" height="20px" viewBox="0 0 720 44" preserveAspectRatio="none">
	<path d="m 0.04289559,11.271448 c 0,0 28.21305541,-10.56188569 44.97380341,-10.56188576 16.760748,-7e-8 28.213058,10.56188576 44.973807,10.56188576 16.760744,0 28.213054,-10.56188569 44.973804,-10.56188576 16.76075,-7e-8 28.21306,10.56188576 44.97381,10.56188576 16.76075,0 28.21305,-10.56188531 44.9738,-10.56188576 16.76075,-4.5e-7 28.21306,10.56188676 44.9738,10.56188576 16.76075,-10e-7 28.21306,-10.56188501 44.97381,-10.56188576 16.76075,-7.5e-7 28.21305,10.56188576 44.9738,10.56188576 16.76075,0 28.21307,-10.56188651 44.97381,-10.56188576 16.76075,7.5e-7 28.21304,10.56188476 44.97379,10.56188576 16.76075,1e-6 28.21307,-10.56188576 44.97382,-10.56188576 16.76075,0 28.21307,10.56188676 44.97381,10.56188576 16.76075,-10e-7 28.21304,-10.56188501 44.97379,-10.56188576 16.76075,-7.5e-7 28.21307,10.56188576 44.97382,10.56188576 16.76075,0 28.21305,-10.56188651 44.9738,-10.56188576 16.76075,7.5e-7 44.9738,10.56188576 44.9738,10.56188576 V 42.957105 H 0.04289559 Z" stroke="none" fill="blue" />
</svg>
<svg class="wavebox" width="500px" height="30px" viewBox="0 0 720 50" preserveAspectRatio="none">
	<rect fill="blue" width="720" height="50" x="0.26726952" y="7.9291615" />
</svg>

<!--/*Footer Reference*/-->
<?php
include ".footer.php";
?>
</body>
</html>
