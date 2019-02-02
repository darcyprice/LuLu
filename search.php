<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
  $term = urldecode($_GET['term']);
}
else {
  $term = "";
}
?>

<!-- HTML element for searchInput -->
<div class="searchContainer">
  <h4>Search for an artist, album or song</h4>
  <input
    class="searchInput" type="text"
    value="<?php echo $term; ?>"
    placeholder="Start typing..."
    onfocus="this.value = this.value"
  >
</div>

<!-- reload page with searchTerm in URL when User has finished typing in searchInput -->
<script>
// give searchInput 'focus' when page loads
$(".searchInput").focus();
$(function() {
  // check if user has started typing
  $(".searchInput").keyup(function() {
    // clear timer
    clearTimeout(timer);
    // create new timer (with 2000 miliseconds)
    timer = setTimeout( function () {
      // get the value of the input field
      var val = $(".searchInput").val();
      // reload the page with the term included
      openPage("search.php?term=" + val);
    }, 2000) // number of miliseconds to wait
  })
})
</script>

<!-- HTML element containing relevant search results from db -->


<?php
// if term is empty, don't search
if($term == "") exit();
?>

<div class="trackListContainer borderBottom">
  <h2>SONGS</h2>
  <ul class="trackList">
    <?php
    // select all songs with term included
    $songsQuery = mysqli_query($con, "SELECT songID FROM Songs WHERE songTitle LIKE '%$term%'");
    // if no results returned, print message
    if(mysqli_num_rows($songsQuery) == 0) {
      echo "<span class='noResults'> No songs found matching " . $term . "</span>";
    }

    $songIDArray = array();
    // counter for row number
    $c = 1;
    while($row = mysqli_fetch_array($songsQuery)) {
      // limit to 15 results
      if($c > 15) {
        break;
      }

      array_push($songIDArray, $row['songID']);
      $albumSong = new Song($con, $row['songID']);
      $albumArtist = $albumSong->getArtist();

      echo "<li class='trackListRow'>
        <div class='trackCount'>
          <img
            class='play' src='assets/images/icons/play-white.png' alt='playWhiteIcon'
            onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)'
          >
            <span class='trackNumber'>$c</span>
        </div>
        <div class='trackInfo'>
          <span class='trackName'>" . $albumSong->getTitle() . "</span>
          <span class='artistName'>" . $albumArtist->getName() . "</span>
        </div>
        <div class='trackOptions'>
          <img class='optionsButton' src='assets/images/icons/more.png' alt='optionsButton'>
        </div>
        <div class='trackDuration'>
          <span class='duration'>" . $albumSong->getDuration() . "</span>
        </div>
        </li>";
        $c = $c + 1;
    }
    ?>

    <!-- create an array of all songIDs on page -->
    <script>
    // convert a PHP array into json format
    var tempSongIDs = '<?php echo json_encode($songIDArray); ?>';
    // used json format array to convert into an object
    tempPlaylist = JSON.parse(tempSongIDs);
    </script>

  </ul>
</div>

<div class="artistContainer borderBottom">
    <h2>ARTISTS</h2>
    <?php
    // select all artists with term included
    $artistsQuery = mysqli_query($con, "SELECT artistID FROM Artists WHERE artistName LIKE '%$term%'");
    // if no results returned, print message
    if(mysqli_num_rows($artistsQuery) == 0) {
        echo "<span class='noResults'> No artists found matching " . $term . "</span>";
    }

    while($row = mysqli_fetch_array($artistsQuery)) {
        $artistFound = new Artist($con, $row['artistID']);

        echo "<div class='searchResultRow'>
                <div class='artistName'>
                    <span role='link' tabindex='0' onclick='openPage(\"artist.php?artistID=" . $artistFound->getID() . "\")'>
                    " . $artistFound->getName() . "
                    </span>
                </div>
            </div>";
    }
    ?>
</div>

<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php
        // select all artists with term included
		$albumQuery = mysqli_query($con, "SELECT * FROM Albums WHERE albumTitle LIKE '%$term%'");
        // if no results returned, print message
        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<span class='noResults'> No albums found matching " . $term . "</span>";
        }

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
