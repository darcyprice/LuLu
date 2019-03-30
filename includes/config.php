<?php
	// turns on 'output buffering'
	ob_start();
	session_start();
	$timezone = date_default_timezone_set("Asia/Seoul");

	// "localhost" = host
	// "root" = user
	// "root" = password (MAMP)
	// "mysql" = password (AMPPS)
	// "slotify" = mysql database name
	$con = mysqli_connect("localhost", "root", "root", "slotify");

	// if there's an error connecting to db
	if (mysqli_connect_errno()) {
		// echo error message
		echo "Failed to connect: " . mysqli_connect_errno();
	}

?>
