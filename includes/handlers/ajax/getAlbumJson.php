<?php

include("../../config.php");

if(isset($_POST['albumID'])) {
	$albumID = $_POST['albumID'];

	$query = mysqli_query($con, "SELECT * FROM Albums WHERE albumID='$albumID'");

	$resultArray = mysqli_fetch_array($query);

	echo json_encode($resultArray);
} 

?>