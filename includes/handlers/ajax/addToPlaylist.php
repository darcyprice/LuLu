<?php
include("../../config.php");

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
    $playlistID = $_POST['playlistID'];
    $songID = $_POST['songID'];

    // fetch which song has the highest playlistOrder, and add 1 to it
    // BUG: when playlist has no songs in it, there is no max
    $sql = "SELECT MAX(playlistOrder) + 1 AS playlistOrder
            FROM PlaylistSongs
            WHERE playlistID = '$playlistID'";
    $orderIDQuery = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($orderIDQuery);
    $order = $row['playlistOrder'];

    // insert song into playlist (with playlistOrder)
    $sql = "INSERT INTO PlaylistSongs
            VALUES(playlistSongsID, '$songID', '$playlistID', '$order')";
    $query = mysqli_query($con, $sql);
} else {
    echo "playlistID or songID was not passed into addToPlaylist.php";
}
?>
