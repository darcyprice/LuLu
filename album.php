<?php
include("includes/includedFiles.php");

if(isset($_GET['albumID'])) {
	$albumID = $_GET['albumID'];
}
else {
	header("Location: index.php");
}

$album = new Album($con, $albumID);
$artist = $album->getArtist();
?>

<div class="entityInfo">
	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>
	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p><?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p>
	</div>
</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php
			$songIDArray = $album->getSongIDs();
			$i = 1; // counter for row number
			foreach($songIDArray as $songID) {

				$albumSong = new Song($con, $songID);
				$albumArtist = $album->getArtist();

				echo "<li class='trackListRow'>
						<div class='trackCount'>
							<img class='play' src='assets/images/icons/play-white.png' alt='playWhiteIcon' onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)'>
							<span class='trackNumber'>$i</span>
						</div>
						<div class='trackInfo'>
							<span class='trackName'>" . $albumSong->getTitle() . "</span>
							<span class='artistName'>" . $albumArtist->getName() . "</span>
						</div>
						<div class='trackOptions'>
							<input type='hidden' class='songID' value='" . $albumSong->getID() . "'
							<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)' alt='optionsButton'>
						</div>
						<div class='trackDuration'>
							<span class='duration'>" . $albumSong->getDuration() . "</span>
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
	<div class="item">Option 2</div>
	<div class="item">Option 3</div>
</nav>

<?php include("includes/footer.php"); ?>
