<?php
	$page = "5";
	include ".header.php";
?>
<head>
	<title>
		Shutdown
	</title>
	<meta name="Description" content="Page for shutting the server down">
</head>
<body>
<form class="general" method="post">
	<input type="submit" name="cancel" value="Cancel" />
	<input type="submit" name="shutdown" value="Shutdown" />
</form>
<?php
if (array_key_exists("cancel", $_POST)) {
	header("Location: index.php");
}
elseif (array_key_exists("shutdown", $_POST)) {
	echo "<h1>Shutting down now...</h1>";
	exec("./.hidden/shutdown",$out);
}
?>
<?php
	include ".footer.php";
?>
</body>
</html>
