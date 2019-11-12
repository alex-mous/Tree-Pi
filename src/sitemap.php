<?php
	include ".header.php";
?>
<head>
	<title>
		Sitemap
	</title>
	<meta name="Description" content="Sitemap for this website.">
</head>
<body>
<div class="sitemaptable">
	<table>
		<caption>
			Sitemap
		</caption>
		<tr>
			<td>---index.php</td><td id="TABLEPADDING" /><td>Main page for website</td>
		</tr>
		<tr>
			<td>|------sitemap.php</td><td id="TABLEPADDING" /><td>This sitemap</td>
		</tr>
		<tr>
			<td>|------settings.php</td><td id="TABLEPADDING" /><td>The page on which settings can be adjusted</td>
		</tr>
		<tr>
			<td>|------shutdown.php</td><td id="TABLEPADDING" /><td>Shutdown the server on this page</td>
		</tr>
		<tr>
			<td>|------log.php</td><td id="TABLEPADDING" /><td>This page shows the log</td>
		</tr>
		<tr>
			<td>|------leds.php</td><td id="TABLEPADDING" /><td>The LED measuring system can be turned on by this page</td>
		</tr>
		<tr>
			<td>|------style.css</td><td id="TABLEPADDING" /><td>The stylesheet used by all the pages on this website</td>
		</tr>
		<tr>
			<td>|------.header.php</td><td id="TABLEPADDING" /><td>The header for all pages</td>
		</tr>
		<tr>
			<td>|------.footer.html</td><td id="TABLEPADDING" /><td>The footer for all pages</td>
		</tr>
		<tr>
			<td>|------.icon.ico</td><td id="TABLEPADDING" /><td>The icon used in the header</td>
		</tr>
		<tr>
			<td>---logs</td><td id="TABLEPADDING" /><td>Folder containing all the text files</td>
		</tr>
		<tr>
			<td>|------log.txt</td><td id="TABLEPADDING" /><td>Log file containg timestamps and data, updated every 15 minutes, not overwritten</td>
		</tr>
		<tr>
			<td>|------latest.txt</td><td id="TABLEPADDING" /><td>Latest percentage level</td>
		</tr>
		<tr>
			<td>|------latest-time.txt</td><td id="TABLEPADDING" /><td>Timestamp for the latest record, also contains error messages</td>
		</tr>
		<tr>
			<td>|------address.txt</td><td id="TABLEPADDING" /><td>Email address to which the alert emails are sent (emails are sent weekdays at 8:30am), can be changed in Settings</td>
		</tr>
		<tr>
			<td>|------max-level.txt</td><td id="TABLEPADDING" /><td>Maximum water level, the level at which the reported percentage level should be 100%, can be changed in settings</td>
		</tr>
		<tr>
			<td>|------min-level.txt</td><td id="TABLEPADDING" /><td>Maximum water level, the level at which the reported percentage level should be 0%, can be changed in Settings</td>
		</tr>
		<tr>
			<td>|------raw-level.txt</td><td id="TABLEPADDING" /><td>File updated by the update script, contains the raw level (1-14)</td>
		</tr>
		<tr>
			<td>|------led-time.txt</td><td id="TABLEPADDING" /><td></td>
		</tr>
		<tr>
			<td>---errors</td><td id="TABLEPADDING" /><td>Folder containing the error pages</td>
		</tr>
		<tr>
			<td>---.hidden</td><td id="TABLEPADDING" /><td>Folder containing all of the scripts for this website</td>
		</tr>
		<tr>
			<td>|------email</td><td id="TABLEPADDING" /><td>Script to send emails with the current percent level</td>
		</tr>
		<tr>
			<td>|------update</td><td id="TABLEPADDING" /><td>Script to update the percent level in latest.txt and also log.txt, runs read script</td>
		</tr>
		<tr>
			<td>|------shutdown</td><td id="TABLEPADDING" /><td>Deconfigures pins and shuts down</td>
		</tr>
		<tr>
			<td>|------pin_setup</td><td id="TABLEPADDING" /><td>Configures pin states at boot</td>
		</tr>
		<tr>
			<td>|------leds_on</td><td id="TABLEPADDING" /><td>The LED script for filling up the tree</td>
		</tr>
		<tr>
			<td>|------read</td><td id="TABLEPADDING" /><td>Reads the raw level and outputs it to raw-level.txt</td>
		</tr>
		<tr>
			<td>|------tests</td><td id="TABLEPADDING" /><td>Folder containing the testing and pin matching scripts</td>
		</tr>
	</table>
</div>

<!--/*Footer reference*/-->
<?php
	include ".footer.php";
?>
</body>
</html>
