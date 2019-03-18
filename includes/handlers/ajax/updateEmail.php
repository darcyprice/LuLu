<?php
include("../../config.php");

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
            WHERE email = '$email'
            AND username != '$username'";
    $emailCheck = mysqli_query($con, $sql);
    if (mysqli_num_rows($emailCheck) > 0) {
        echo "Sorry, email is already taken";
        exit();
    }

	$sql = "UPDATE Users SET email = '$email'
            WHERE username = '$username'";
	$updateQuery = mysqli_query($con, $sql);

    echo "Update successful";
}
?>
