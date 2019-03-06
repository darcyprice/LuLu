<?php
include("../../config.php");

if (isset($_POST['playlistID'])) {
    $playlistID = $_POST['playlistID'];

    $playlist_sql = "DELETE FROM Playlists WHERE playlistID = '$playlistID'";
    $songs_sql = "DELETE FROM PlaylistSongs WHERE playlistSongsID = '$playlistID'";

    $playlist_query = mysqli_query($con, $playlist_sql);
    $songs_query = mysqli_query($con, $songs_sql);
} else {
    echo "Name or Username parameters not passed into file";
}
?>
