<html lang="en">
<div class="home">
<head>
	<meta name="viewport" content="width=500px, initial-scale=1.0">
	<meta name="theme-color" content="#328832">
	<link rel="stylesheet" href="/style.css">
	<link rel="icon" type="image/x-icon" href="/.icon.ico">
</head>
<style>
<?php
if (isset($page)) {
	if ($page == "1") {
		echo "a#heada1";
		echo "{color: black;}";
	}
	elseif ($page == "2") {
		echo "a#heada2";
		echo "{color: black;}";
	}
	elseif ($page == "3") {
		echo "a#heada3";
		echo "{color: black;}";
	}
	elseif ($page == "4") {
		echo "a#heada4";
		echo "{color: black;}";
	}
	elseif ($page == "5") {
		echo "a#heada5";
		echo "{color: black;}";
	}
}
?>
</style>
<a class="header" href="/">
	<div class="header"">
		<img src="/.icon.ico" class="imgl" alt="Icon">
		<h1>
			Tree Pi
		</h1>
		<img src="/.icon.ico" class="imgr" alt="Icon">
		<h2>
			A christmas tree water monitor<br>using a Raspberry Pi
		</h2>
	</div>
</a>
<div class="navbar">
	<span class="link">
		<a class="header" id="heada1" href="/">
			Home
		</a>
	</span>
	<span class="spacer" />
	<span class="link">
		<a class="header" id="heada2" href="log.php">
			Log
		</a>
	</span>
	<span class="spacer" />
	<span class="link">
		<a class="header" id="heada3" href="leds.php">
			LEDs
		</a>
	</span>
	<span class="spacer" />
	<span class="link">
		<a class="header" id="heada4" href="settings.php">
			Settings
		</a>
	</span>
	<span class="spacer" />
	<span class="link">
		<a class="header" id="heada5" href="shutdown.php">
			Shutdown
		</a>
	</span>
</div>
