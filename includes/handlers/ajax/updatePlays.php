<?php
include("../../config.php");

if(isset($_POST['songID'])) {
	$songID = $_POST['songID'];

	// increment Songs.plays by 1
	$query = mysqli_query($con, "UPDATE Songs SET plays = plays + 1 WHERE songID='$songID'");
} 
?>
