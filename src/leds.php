<?php
	$page = "3";
	include ".header.php";
?>
<head>
	<title>
		LEDs
	</title>
	<meta name="Description" content="Turn on and off the LED measuring system. It automatically turns off after 5 mins.">
</head>
<body>

<form class="general" method="post">
	<label>Amount of time the LEDs will be on (mins):</label>
	<input type="text" name="led_time" value="5" />
	<input type="submit" name="on" value="On" />
</form>

<?php
	ignore_user_abort(true);
	set_time_limit(0);
	if (array_key_exists("on", $_POST)) {
		if (($_POST[led_time] <= 60) and ($_POST[led_time] >= 1)) {
			echo "<h3>The LEDs are now on. You can now fill up the tree and the LEDs will indicate the level of water.</h3>";
			$command = ".hidden/leds_on " . $_POST[led_time];
			exec($command);
		}
		else {
			echo "<h3>The LED delay must be between 1 and 60 minutes, inclusive</h3>";
		}
	}
?>

<?php
	include ".footer.php";
?>
</body>
</html>
