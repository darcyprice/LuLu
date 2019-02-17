<?php
include("../../includes/config.php");

if (isset($_POST['name']) && isset($_POST['username'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO Playlists VALUES(playlistID, '$name', '$username', '$date')";
    $query = mysqli_query($con, $sql);
    $rowsAffected = mysql_affected_rows($query);

    echo $rowsAffected;

} else {
    echo "Name or Username parameters not passed into file";
}
?>
