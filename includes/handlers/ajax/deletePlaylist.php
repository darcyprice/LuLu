<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if (isset($_POST['playlistID'])) {
    $playlistID = $_POST['playlistID'];

    // delete Playlist
    $sql = "DELETE FROM Playlists WHERE playlistID = ?";
    $stmt = $db->run($sql, [$playlistID]);

    // delete PlaylistSongs linked the (now) deleted Playlist
    $sql = "DELETE FROM PlaylistSongs WHERE playlistID = ?";
    $stmt = $db->run($sql, [$playlistID]);
} else {
    echo "Name or Username parameters not passed into file";
}
?>
