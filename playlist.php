<?php
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$playlistID = $_GET['id'];
}
else {
	header("Location: index.php");
}

$playlist = new Playlist($con, $playlistID);
/* the reason we don't simply pass userLoggedIn as the variable, is so that
we can expand functionality in the future to allow User's to view
playlist of other Users. That is, Users won't simply be able to view
their own playlist page, but other User's playlist pages too. */
$owner = new User($con, $playlist->getOwner());
?>

<div class="entityInfo">
	<div class="leftSection">
        <div class="playlistImage">
    		<img src="assets/images/icons/playlist.png" alt="playlistIcon">
        </div>
	</div>
	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p><?php echo $playlist->getOwner(); ?></p>
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistID; ?>')">DELETE PLAYLIST</button>
	</div>
</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php
			$songIDArray = $playlist->getSongIDs();
			$i = 1; // counter for row number
			foreach($songIDArray as $songID) {

				$playlistSong = new Song($con, $songID);
                $songArtist = $playlistSong->getArtist();

				echo "<li class='trackListRow'>
						<div class='trackCount'>
							<img class='play' src='assets/images/icons/play-white.png' alt='playWhiteIcon' onclick='setTrack(
                                \"" . $playlistSong->getID() . "\", tempPlaylist, true)'>
							<span class='trackNumber'>$i</span>
						</div>
						<div class='trackInfo'>
							<span class='trackName'>" . $playlistSong->getTitle() . "</span>
							<span class='artistName'>" . $songArtist->getName() . "</span>
						</div>
						<div class='trackOptions'>
							<input type='hidden' class='songID' value='" . $playlistSong->getID() . "'
							<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)' alt='optionsButton'>
						</div>
						<div class='trackDuration'>
							<span class='duration'>" . $playlistSong->getDuration() . "</span>
						</div>
					</li>";

				$i = $i + 1; // increment the counter
			}
		?>

		<script>
			// creates an array that contains all the IDs of the songs on that page
			// convert a PHP array into json format
			var tempSongIDs = '<?php echo json_encode($songIDArray); ?>';
			// used json format array to convert into an object
			tempPlaylist = JSON.parse(tempSongIDs);
		</script>

	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songID">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistID; ?>')">
		Remove from Playlist
	</div>
</nav>

<?php
include("includes/footer.php");
?>
