var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;


function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time/60);
	var seconds = time - (minutes * 60);

	var extraZero;
	// a one-line expression (instead of an if-statement) that says if seconds < 10, then extraZero = "0", else extraZero = "1"
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	// IDEA: I actually prefer not to have the total duration decreasing
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100; // calculating a percentage
	$(".playbackBar .progress").css("width", progress + "%");

}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}


function Audio() {

	this.currentlyPlaying;
	// "this.audio" is the property of the Class. It's the same as self.name = name ?
	// "document.createElement('audio')" creates an HTML element which, in this case, is a built-in HTML audio element
	this.audio = document.createElement('audio');

	this.audio.addEventListener("canplay", function() {
		// 'this' refers to the object that event was called on (which in this case, is 'audio')
		var duration = formatTime(this.duration);
		// update the HTML tag with the duration of the song
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("timeupdate", function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	// takes the JSON object 'track' as a parameter
	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}

}