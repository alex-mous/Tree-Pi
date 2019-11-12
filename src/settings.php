<?php
	$page = "4";
	include ".header.php";
?>
<head>
	<title>
		Settings
	</title>
	<meta name="Description" content="Settings page. First setting: Adjust max and min levels for scaling of the animation in the tree on this page. Second setting: Change email address to which low level alerts are sent.">
</head>
<body>
<?php
	$email = file_get_contents("logs/address.txt");
	$max = file_get_contents("logs/max-level.txt");
	$min = file_get_contents("logs/min-level.txt");
?>

<form class="general" method="post">
	<label>Email that alerts are sent to:</label>
	<input type="text" name="email" value="<?php echo $email; ?>"></input>
	<br>
	<label>Maximum water level (2-14):</label>
	<input type="text" name="max" value="<?php echo $max; ?>"></input>
	<br>
	<label>Minimum water level (1-13):</label>
	<input type="text" name="min" value="<?php echo $min; ?>"></input>
	<br>
	<br>
	<input type="submit" name="save" value="Save" />
	<input type="submit" name="cancel" value="Cancel" />
</form>
<?php
	if (array_key_exists("save", $_POST)) {
		preg_match("/^[a-z]+@[a-z]+.[a-z]+$/i",$_POST[email],$email_match);
		if (($_POST[max] <= 14) and ($_POST[max] >= 2)) {
			$max_match = true;
		}
		else {
			$max_match = false;
		}
		if (($_POST[min] <= 13) and ($_POST[min] >= 1)) {
			$min_match = true;
		}
		else {
			$min_match = false;
		}
		if ($_POST[min] < $_POST[max]) {
			if ($email_match[0]) {
				file_put_contents("logs/address.txt", $_POST[email]);
				if ($max_match) {
					file_put_contents("logs/max-level.txt", $_POST[max]);
					if ($min_match) {
						file_put_contents("logs/min-level.txt", $_POST[min]);
						echo "<h3>Saved</h3>";
						system("./.hidden/update");
						header("Location: index.php");
					}
					else {
						echo "<h3>The minimum water level must be between 1 and 13, inclusive</h3>";
					}
				}
				else {
						echo "<h3>The maximum water level must be between 2 and 14, inclusive</h3>";
				}
			}
			else {
				echo "<h3>The email must match the pattern johndoe@domain.com</h3>";
			}
		}
		else {
			echo "<h3>Please ensure that the Minimum water level is less than the Maximum water level</h3>";
		}
	}
	elseif (array_key_exists("cancel", $_POST)) {
		header("Location: index.php");
	}
?>

<?php
	include ".footer.php";
?>
</body>
</html>
