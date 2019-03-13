<?php
include("../../config.php");

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
    $playlistID = $_POST['playlistID'];
    $songID = $_POST['songID'];

    $sql = "DELETE FROM playlistSongs
            WHERE playlistID = '$playlistID'
            AND songID = '$songID'";
    $query = mysqli_query($con, $sql);

} else {
    echo "playlistID and/or songID parameters not passed into removeFromPlaylist.php";
}


?>
