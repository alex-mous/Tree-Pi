<?php
	$page = "2";
	include ".header.php";
?>
<head>
	<meta name="Description" content="Page that show to contents of the log file with a bit of stylising">
	<title>
		Log
	</title>
</head>
<body>
<pre>
<?php
$log = file_get_contents("/var/www/html/logs/log.txt");
echo $log;
?>
</pre>
</body>
</html>
