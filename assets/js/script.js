var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

// event: if the User clicks on the page
$(document).click(function(click) {
	// where the User has clicked
	var target = $(click.target);
	// if the User hasn't clicked on .item or .optionsMenu, hide .optionsMenu
	if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}


});

// event: if the User scrolls on the page
$(window).scroll(function() {
	// call hideOptionsMenu() function
	hideOptionsMenu();
});

// function will be fired everytime the select.playlist dropdown menu changes
$(document).on("onchage", "select.playlist", function() {
	// create a jQuery object with this (to be used below)
	var select = $(this);
	// 'this' refers to the element which the event was fired on (this is case: "select.playlist")
	var playlistID = $(this).val();
	// 'prev' goes up the document object model to find the immediate ancestor in the html doc
	var songID = $(this).prev(."songID").val();

	$.post(
		"includes/handlers/ajax/addToPlaylist.php",
		{ playlistID: playlistID, songID: songID}
	).done(function() {
		// if there's any errors, alert them
		if (error != "") {
			alert(error);
			return;
		}
		// close the options menu
		hideOptionsMenu();
		// set the playlist ID back to an empty value
		// set the value to blank
		select.val("");
	});
});

function openPage(url) {
	// if timer is going, clear timer when open new page
	if(timer != null) {
		clearTimeout(timer);
	}
	// if the URL doesn't have a "?", include it
	if(url.indexOf("?") == -1) {
		url = url + "?";
	}
	// encodes the URL into a variable
	var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	// swap the current content of #mainContent with the new content
	$("#mainContent").load(encodedURL);
	// scrolls to the top of page, when the page is changed
	$("body").scrollTop(0);
	// inserts the url into the history (so that the user thinks the url has actually
	// changed, when, instead, ajax has merely changed the container)
	history.pushState(null, null, url);
}

// button is the 'optionsButton that has been pressed'
function removeFromPlaylist(button, playlistID) {
	// 'prevAll' will go up multiple ancestors to find the match in the html doc
	var songID = $(button).prevAll(".songID").val();
	// ajax call
	$.post(
		"includes/handlers/ajax/removeFromPlaylist.php",
		{ playlistID : playlistID, songID: songID }
	)
	// .done() executes when the ajax call is completed
	.done(function(error) {
		if (error != "") {
			alert(error);
			return;
		}
		// open openMusic.php (which the page we're already on, so it's essentially a refresh)
		openPage("playlist.phpid=" + playlistID);
	});

}

function createPlaylist() {
	var popup = prompt("Enter name of the playlist");

	if (popup != null) {
		// AJAX call
		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		// .done() executes when the ajax call is completed
		.done(function(error) {

			if (error != "") {
				alert(error);
				return;
			}
			// do something when ajax returns
			// open openMusic.php (which the page we're already on, so it's essentially a refresh)
			openPage("yourMusic.php");
		});
	}
}

// function to hide the optionsMenu (function is called when page is scrolled)
function hideOptionsMenu() {
	var menu = $(".optionsMenu");

	if (menu.css("display") != "none") {
		menu.css("display", "none");
	}

}

// function to ensure that optionsMenu button appears in line with each <li class='trackListRow'>
// to do that, need to get the position of each trackListRow on the screen
function showOptionsMenu(button) {
	// everytime the songID menu is shown,
	// 'prevAll' will go up multiple ancestors to find the match in the html doc
	var songID = $(button).prevAll(".songID").val();
	var menu = $(".optionsMenu");
	var menuWith = menu.width();
	// finds the value of the songID item from the menu (which = ".optionsMenu")
	menu.find(".songID").val(songID);

	// distance from top of window to top of document
	var scrollTop = $(window).scrollTop();
	// distance from top of document
	var elementOffset = $(button).offset().top;
	// how far from the top the optionsButton is
	var top = elementOffset - scrollTop;
	// how far from the left the optionsButton is
	var left = $(button).position().left;
	// add css to menu (which is .optionsMenu)
	menu.css({ "top": top + "px", "left": left - menuWith + "px", "display": "inline" })


 function deletePlaylist(playlistID) {
	var prompt = confirm("Are you sure you want to delete this playlist?");

	if (prompt == true) {
		// AJAX call
		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistID : playlistID })
		// .done() executes when the ajax call is completed
		.done(function(error) {
			if (error != "") {
				alert(error);
				return;
			}
			// open openMusic.php (which the page we're already on, so it's essentially a refresh)
			openPage("yourMusic.php");
		});
	}
}

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

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
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
