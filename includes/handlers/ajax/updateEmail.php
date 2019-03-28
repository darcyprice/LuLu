<?php
include("../../config.php");
include("../../classes/MyPDO.php");

$db = MyPDO::instance();

if (isset($_POST['email'], $_POST['username']) && $_POST['email'] != "") {
	$email = $_POST['email'];
    $username = $_POST['username'];

    // check email is in valid format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Sorry, that is not a valid email";
        // prevent rest of page from loading
        exit();
    }

    // check email is unique
	$sql = "SELECT email FROM Users
			WHERE email = ?
			AND username != ?";
	$stmt = $db->run($sql, [$email, $username]);

	if ($stmt->fetch(PDO::FETCH_ASSOC) != 0) {
		echo "Sorry, email is already taken";
		exit();
	} else {
		// update the email in db
		$sql = "UPDATE Users
				SET email = ?
				WHERE username = ?";
		$stmt = $db->run($sql, [$email, $username]);
		echo "Update successful";
	}
}
?>
