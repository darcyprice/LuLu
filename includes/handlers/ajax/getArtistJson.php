<?php

include("../../config.php");

if(isset($_POST['artistID'])) {
	$artistID = $_POST['artistID'];

	$query = mysqli_query($con, "SELECT * FROM Artists WHERE artistID='$artistID'");

	$resultArray = mysqli_fetch_array($query);

	echo json_encode($resultArray);
} 

?>