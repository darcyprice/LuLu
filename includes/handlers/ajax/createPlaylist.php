<?php
include("../../config.php");

if (isset($_POST['name'], $_POST['username'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO Playlists VALUES(playlistID, '$name', '$username', '$date')";
    $query = mysqli_query($con, $sql);
} else {
    echo "Name or Username parameters not passed into file";
}
?>
