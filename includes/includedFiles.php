<?php

// in terms of URL entry, the script checks whether the request has been sent by ajax, or
// whether the User manually entered the URL

// check whether the url request was from ajax
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  include("includes/config.php");
  include("includes/classes/Artist.php");
  include("includes/classes/Album.php");
  include("includes/classes/Song.php");
}
else {
  include("includes/header.php");
  include("includes/footer.php");
  // call openPage()
  $url = $_SERVER['REQUEST_URI'];
  echo "<script> openPage('$url') </script>";
  // prevents from loading the rest of the page
  exit();
}

?>
