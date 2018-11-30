<?php
if(isset($_POST['loginButton'])) {
	//Login button was pressed
	$username = $_POST['loginUsername']; // needs to match the name in the form tag within register.php
	$password = $_POST['loginPassword']; // needs to match the name in the form tag within register.php

	// login function
	$result = $account->login($username, $password);

	if($result == true) {
		$_SESSION['userLoggedIn'] = $username; // creates the session variable and give it the value of "username"
		header("Location: index.php");
	}
	
}
?>