<?php
include("includes/includedFiles.php");
?>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLIST</h2>
        <div class="buttonItems">
            <button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
        </div>

        <?php
            $username = $userLoggedIn->getUsername();
            // select all playlists associated with the User
            $sql = "SELECT * FROM Playlists WHERE playlistOwner='$username'";
    		$playlistQuery = mysqli_query($con, $sql);
            // if no results returned, print message
            if(mysqli_num_rows($playlistQuery) == 0) {
                echo "<span class='noResults'>You don't have any playlists yet</span>";
            }

    		while($row = mysqli_fetch_array($playlistQuery)) {

                // create the playlist object
                // the $data is $row
                $playlist = new Playlist($con, $row);

    			// create an html div element each time it loops through the queryset
                // outputting each playlist fetched in the query
    			echo "<div class='gridViewItem'>
                        <div class='playlistImage'>
                            <img src='assets/images/icons/playlist.png' alt='playlistIcon'>
                        </div>
                        <div class='gridViewInfo'>"
                            . $playlist->getName() .
                        "</div>
    				</div>";
    		}
    	?>
    </div>
</div>
