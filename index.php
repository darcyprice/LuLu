<?php

include("includes/config.php");

/* to prevent the user from accessing index.php until they register/login */
if(isset($_SESSION['userLoggedIn'])) { // check if session variable is set. that is, if user is already logged in
	$userLoggedIn = $_SESSION['userLoggedIn']; // if yes, create a variable that contains the user's username
} else {
	header("Location: register.php"); // if no, direct to register.php. That is, prevent the user from accessing index.php until they log in
}

?>

<html>
<head>
	<title>Welcome to Slotify!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

	<div id="mainContainer">

		<div id="topContainer">
			
			<div id="navBarContainer">

				<nav class="navBar">

					<a href="index.php" class="logo">
						<img src="assets/images/icons/logo.png" alt="Icon">
					</a>

					<div class="group">
						<div class="navItem">
							<a href="search.php" class="navItemLink">Search</a>
								<img src="assets/images/icons/search.png" class="icon" alt="Search">
						</div>
					</div>

					<div class="group">
						<div class="navItem">
							<a href="browse.php" class="navItemLink">Browse</a>
						</div>
						<div class="navItem">
							<a href="yourMusic.php" class="navItemLink">Your Music</a>
						</div>
						<div class="navItem">
							<a href="profile.php" class="navItemLink">Homer Simpson</a>
						</div>
					</div>

				</nav>
				
			</div>

		</div>

		<div id="nowPlayingBarContainer">

			<div id="nowPlayingBar">

				<div id="nowPlayingLeft">

					<div class="content">
						
						<span class="albumLink">
							<img class="albumArtwork" src="https://upload.wikimedia.org/wikipedia/en/thumb/4/42/Beatles_-_Abbey_Road.jpg/220px-Beatles_-_Abbey_Road.jpg">
						</span>

						<div class="trackInfo">
							
							<span class="trackName">
								<span>Golden Slumbers</span>
							</span>

							<span class="artistName">
								<span>The Beatles</span>
							</span>

						</div>

					</div>
					
				</div>

				<div id="nowPlayingCenter">

					<div class="content playerControls">

						<div class="buttons">

							<button class="controlButton shuffle" title="Shuffle">
								<img src="assets/images/icons/shuffle.png" alt="Shuffle button">
							</button>

							<button class="controlButton previous" title="Previous">
								<img src="assets/images/icons/previous.png" alt="Previous button">
							</button>

							<button class="controlButton play" title="Play">
								<img src="assets/images/icons/play.png" alt="Play button">
							</button>

							<button class="controlButton pause" title="Pause" style="display: none">
								<img src="assets/images/icons/pause.png" alt="Pause button">
							</button>

							<button class="controlButton next" title="Next">
								<img src="assets/images/icons/next.png" alt="Next button">
							</button>

							<button class="controlButton repeat" title="Repeat">
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

						<button class="controlButton volume" title="Volume Button">
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
		
	</div>

</body>

</html>