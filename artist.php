<?php
include("includes/includedFiles.php");

if(isset($_GET['artistID'])) {
	$artistID = $_GET['artistID'];
}
else {
  // IDEA: include 'Artist couldn't be found' page
	header("Location: index.php");
}

$artist = new Artist($con, $artistID);
?>

<div class="entityInfo borderBottom">
  <div class="centerSection">
    <div class="artistInfo">
      <h1 class="artistName">
        <?php
          echo $artist->getName();
        ?>
      </h1>
      <div class="headerButtons">
        <button class="button green" onclick="playFirstSong()">PLAY</button>
      </div>
    </div>
  </div>
</div>

<div class="trackListContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="trackList">
		<?php
			$songIDArray = $artist->getSongIDs();
			$i = 1; // counter for row number
			foreach($songIDArray as $songID) {
				// limit to 5 results
				if($i > 5) {
					break;
				}

				$albumSong = new Song($con, $songID);
				$albumArtist = $albumSong->getArtist();

				echo "<li class='trackListRow'>
						<div class='trackCount'>
							<img
								class='play' src='assets/images/icons/play-white.png' alt='playWhiteIcon'
								onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)'
							>
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
				$i = $i + 1;
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

<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM Albums WHERE albumArtist='$artistID' LIMIT 10");

		while($row = mysqli_fetch_array($albumQuery)) {
			// create an html div element each time it loops through the queryset
			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?albumID=" . $row['albumID'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['albumTitle'] .
						"</div>
					</span>

				</div>";
		}
	?>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songID">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
