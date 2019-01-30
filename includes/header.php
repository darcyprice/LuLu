<?php

include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

/* to prevent the user from accessing index.php until they register/login */
if(isset($_SESSION['userLoggedIn'])) { // check if session variable is set. that is, if user is already logged in
	$userLoggedIn = $_SESSION['userLoggedIn']; // if yes, create a variable that contains the user's username
	// store the username of the userLoggedIn as a JS variable
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else {
	header("Location: register.php"); // if no, direct to register.php. That is, prevent the user from accessing index.php until they log in
}

?>

<html>
<head>
	<title>Welcome to Slotify!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>

</head>

<body>

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">
