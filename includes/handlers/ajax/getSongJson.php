<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if (isset($_POST['songID'])) {
	$songID = $_POST['songID'];
	$sql = "SELECT * FROM Songs WHERE songID = ?";
	$stmt = $db->run($sql, [$songID]);
	$resultArray = $stmt->fetch(PDO::FETCH_ASSOC);
	echo json_encode($resultArray);
}
?>
