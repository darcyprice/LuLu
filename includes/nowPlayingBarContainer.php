<?php

/* CREATE A PLAYLIST IN THE nowPlayingBar */
/* Testing PHP comments and git commit */

// select a RANDOM set of songs from the db
$songQuery = mysqli_query($con,
	"SELECT songID FROM Songs ORDER BY RAND() LIMIT 10"
);

$resultArray = array();

// converts the result of the query into an array
while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['songID']);
}

// use JSON to convert the PHP array ($resultArray) into a JS array
$jsonArray = json_encode($resultArray);

?>

<!-- use JS to handle the playing and loading of music -->
<script>

$(document).ready(function() {
	var newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio(); // the Audio Class created in script.js
	setTrack(newPlaylist[0], newPlaylist, false); // set the track of the audioElement, using the setTrack function from below
	updateVolumeProgressBar(audioElement.audio);

	$('#nowPlayingBarContainer').on("mousedown touchstart mousemove touchmove", function(e) {
		e.preventDefault();
	});

	$(".playbackBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
			// set the time of song, depending on position of the mouse
			timeFromOffset(e, this);
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
	});

	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();
		audioElement.audio.volume = percentage;
	});

	// sets mouseDown to false if the mouse is unclicked anywhere on the page
	$(document).mouseup(function() {
		mouseDown = false;
	});

});

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function nextSong() {

	if(repeat == true) {
		// if the User repeats the song, set the time of the song to 0
		audioElement.setTime(0);
		playSong();
		return;
	}

	if(currentIndex == currentPlaylist.length - 1) {
		currentIndex = 0;
	}
	else {
		currentIndex++;
	}

	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}

function previousSong() {
	// if the currentTime of the song is greater, or equal to, 3 seconds (or the current Index is 0), clicking previousSong button will restart the same song.
	if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0);
	}
	else {
		currentIndex--;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	}
}

function setRepeat() {
	repeat = !repeat; // repeat equals not repeat.
	var imageName = repeat ? "repeat-active.png" : "repeat.png"; // shorthand JS if/else statement
	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function setMute() {
	audioElement.audio.muted = !audioElement.audio.muted; // muted equals not muted.
	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png"; // shorthand JS if/else statement
	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setShuffle() {
	shuffle = !shuffle; // shuffle equals not shuffle.
	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png"; // shorthand JS if/else statement
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if(shuffle == true) {
		// shuffle the playlist
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.songID);
	}
	else {
		// shuffle has been deactivated, go back to regular playlist (that is, the unshuffled playlist)
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.songID);
	}
}

function shuffleArray(a) {
	/* function to randomize an array */
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}


function setTrack(trackID, newPlaylist, play) {

	// if the User selects a new song, that comes with a new playlist (ie, selected a song from a different Album)
	if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice() // .slice() creates a copy of an array
		shuffleArray(shufflePlaylist); // shuffles the copy of currentPlaylist
	}

	if(shuffle) { // same as if shuffle == true
		currentIndex = shufflePlaylist.indexOf(trackID);
	}
	else {
		currentIndex = currentPlaylist.indexOf(trackID);
	}

	pauseSong();

	/* AJAX call */
	$.post("includes/handlers/ajax/getSongJson.php", { songID : trackID }, function(data) {
		
		// first, we need to parse the data to convert it into an object
		var track = JSON.parse(data);

		// automatically update the html element with the songTitle of track currently playing
		$(".trackName span").text(track.songTitle);

		// use an AJAX call to retrieve the artistName from the song curretly playing
		$.post("includes/handlers/ajax/getArtistJson.php", { artistID : track.songArtist }, function(data) {
			var artist = JSON.parse(data);
			// automatically update the html element with the artistName of track currently playing
			$(".artistName span").text(artist.artistName);
		});

		// use an AJAX call to retrieve the albumArtwork from the song curretly playing
		$.post("includes/handlers/ajax/getAlbumJson.php", { albumID : track.songAlbum }, function(data) {
			var album = JSON.parse(data);
			// automatically update the html element with the artistName of track currently playing
			$(".albumLink img").attr("src", album.artworkPath);
		});

		audioElement.setTrack(track);
		playSong();
	});

	if(play == true) {
		audioElement.play(); 
	}
}

function playSong() {

	// only update the play count if the time is 0 (as then a new song is being played) (that is, don't include times when we hit play, pause, play)
	// IDEA: change this to be if the time > 10
	if(audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", { songID: audioElement.currentlyPlaying.songID });
	}

	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}

function pauseSong() {
	$(".controlButton.play").show();
	$(".controlButton.pause").hide();
	audioElement.pause();
}

</script>


<div id="nowPlayingBarContainer">
	<div id="nowPlayingBar">
		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img class="albumArtwork" src="" alt="alt: albumArtwork">
				</span>
				<div class="trackInfo">
					<span class="trackName">
						<span></span>
					</span>
					<span class="artistName">
						<span></span>
					</span>
				</div>
			</div>
		</div>
		<div id="nowPlayingCenter">
			<div class="content playerControls">
				<div class="buttons">
					<button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle button">
					</button>
					<button class="controlButton previous" title="Previous" onclick="previousSong()">
						<img src="assets/images/icons/previous.png" alt="Previous button">
					</button>
					<button class="controlButton play" title="Play" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play button">
					</button>
					<button class="controlButton pause" title="Pause" onclick="pauseSong()" style="display: none">
						<img src="assets/images/icons/pause.png" alt="Pause button">
					</button>
					<button class="controlButton next" title="Next" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next button">
					</button>
					<button class="controlButton repeat" title="Repeat" onclick="setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat button">
					</button>
				</div>
				<div class="playbackBar">
					<span class="progressTime current">0.00</span>
					<div class="progressBar">
						<div class="progressBarBackground">
							<div class="progress">

							</div>
						</div>
					</div>
					<span class="progressTime remaining">0.00</span>
				</div>
			</div>
		</div>
		<div id="nowPlayingRight">
			<div class="volumeBar">
				<button class="controlButton volume" title="Volume Button" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume Button">
				</button>
				<div class="progressBar">
					<div class="progressBarBackground">
						<div class="progress">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>