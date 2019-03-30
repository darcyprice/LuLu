<?php
	ob_start(); // turns on output buffering : "wait until you have all the data until you send it to the server"
	session_start(); // enables the use of sessions

	$timezone = date_default_timezone_set("Asia/Seoul");

	// "localhost" = host
	// "root" = user
	// "root" = password (MAMP)
	// "mysql" = password (AMPPS)
	// "slotify" = mysql database name

	$con = mysqli_connect("localhost", "root", "mysql", "slotify"); // connects to database

	if(mysqli_connect_errno()) { // if there's an error connecting to the db, print the error message
		echo "Failed to connect: " . mysqli_connect_errno();
	}

?>
