<div id="navBarContainer">

	<nav class="navBar">

		<span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
			<img src="assets/images/icons/logo.png" alt="Icon">
		</span>

		<div class="group">
			<div class="navItem">
				<span role='link' onclick='openPage("search.php")' class="navItemLink">
					Search
					<img src="assets/images/icons/search.png" class="icon" alt="Search">
				</span>
			</div>
		</div>

		<div class="group">
			<div class="navItem">
				<span role="link" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
			</div>
			<div class="navItem">
				<span role="link" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
			</div>
			<div class="navItem">
				<span role="link" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getFullName(); ?></span>
			</div>
		</div>

	</nav>

</div>
