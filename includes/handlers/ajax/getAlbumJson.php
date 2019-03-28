<?php

include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if(isset($_POST['albumID'])) {
	$albumID = $_POST['albumID'];

	$sql = "SELECT * FROM Albums WHERE albumID = ?";
	$stmt = $db->run($sql, [$albumID]);
	
	$resultArray = $stmt->fetch(PDO::FETCH_ASSOC);

	echo json_encode($resultArray);
}

?>
