// in terms of URL entry, the script checks whether the request has been sent by ajax, or
// whether the User manually entered the URL

<?php

// check whether the url request was from ajax
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  // ENTER CODE
  // temp:
  echo "came from ajax";
}
else {
  // load the header and footer files
  include("includes/header.php");
  include("includes/footer.php");
}

?>
