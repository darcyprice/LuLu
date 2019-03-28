<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
    $playlistID = $_POST['playlistID'];
    $songID = $_POST['songID'];

    // delete PlaylistSongs linked the (now) deleted Playlist
    $sql = "DELETE FROM PlaylistSongs
            WHERE playlistID = ?
            AND songID = ?";
    $stmt = $db->run($sql, [$playlistID, $songID]);

} else {
    echo "playlistID and/or songID parameters not passed into removeFromPlaylist.php";
}


?>
