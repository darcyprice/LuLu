<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
    $playlistID = $_POST['playlistID'];
    $songID = $_POST['songID'];

    // fetch which song has the highest playlistOrder, and add 1 to it
    // BUG: when playlist has no songs in it, there is no max
    $sql = "SELECT MAX(playlistOrder) + 1 AS playlistOrder
            FROM PlaylistSongs
            WHERE playlistID = ?";
    $stmt = $db->run($sql, [$playlistID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $order = $row['playlistOrder'];
    // if $order is null (because the playlist currently has no songs in it)
    // then set $order to 1
    if (is_null($order)) {
        $order = 1;
    }
    // insert song into playlist (with playlistOrder)
    $sql = "INSERT INTO PlaylistSongs
            VALUES (playlistSongsID, ?, ?, ?)";
    $stmt = $db->run($sql, [$songID, $playlistID, $order]);
} else {
    echo "playlistID or songID was not passed into addToPlaylist.php";
}
?>
