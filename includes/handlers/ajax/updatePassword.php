<?php
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "Sorry, username not found";
    exit();
}

// check all fields have been set
if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Sorry, not all passwords have been set";
    exit();
}
// check all fields aren't empty strings
if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Sorry, not all passwords have been set";
    exit();
}

if (isset($_POST['oldPassword'], $_POST['newPassword1'], $_POST['newPassword2'])) {
    $username = $_POST['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    // encrypt the password (necessary because DB passwords are encrpyted)
    $oldMd5 = md5($oldPassword);
    // check if old password is correct
    $sql = "SELECT * FROM users
            WHERE username = '$username'
            AND password = '$oldMd5'";
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) != 1) {
        echo "Password is incorrect";
        exit();
    }
    // check new passwords match
    if ($newPassword1 != $newPassword2) {
        echo "Sorry, the new passwords don't match";
        exit();
    }
    // check password is alphanumeric
    if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
        echo "Sorry, the new password must be alphanumeric";
        exit();
    }
    // check password length
    if (strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
        echo "Sorry, the password must be between 5 and 30 characters";
        exit();
    }

    $newMd5 = md5($newPassword1);

    $sql = "UPDATE Users SET password = '$newMd5'
            WHERE username = '$username'";
    $query = mysqli_query($con, $sql);
    // success message
    echo "Password updated";
}
?>
