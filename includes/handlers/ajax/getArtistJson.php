<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if(isset($_POST['artistID'])) {
	$artistID = $_POST['artistID'];

	$sql = "SELECT * FROM Artists WHERE artistID = ?";
	$stmt = $db->run($sql, [$artistID]);

	$resultArray = $stmt->fetch(PDO::FETCH_ASSOC);

	echo json_encode($resultArray);
}
?>
