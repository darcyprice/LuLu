<?php
include("../../config.php");

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
    $playlistID = $_POST['playlistID'];
    $songID = $_POST['songID'];

    // fetch which song has the highest playlistOrder, and add 1 to it
    $sql = "SELECT MAX(playlistOrder) + 1 AS playlistOrder
            FROM playlistSongs
            WHERE playlistID = '$playlistID'";
    $orderIDQuery = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($orderIDQuery);
    $order = $row['playlistOrder'];

    // insert song into playlist (with playlistOrder)
    // TODO: check this query against the sql table
    $sql = "INSERT INTO playlistSongs
            VALUES(
                playlistSongID,
                '$songID',
                '$playlistID',
                '$order'
            )";
    $query = mysqli_query($con, $sql);
} else {
    echo "playlistID or songID was not passed into addToPlaylist.php";
}
?>



?>
