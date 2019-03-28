<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if (isset($_POST['name'], $_POST['username'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO Playlists
            VALUES (playlistID, ?, ?, ?)";
    $stmt = $db->run($sql, [$name, $username, $date]);
} else {
    echo "Name or Username parameters not passed into file";
}
?>
