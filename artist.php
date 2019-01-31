<?php
include("includes/includedFiles.php");

if(isset($_GET['artistID'])) {
	$artistID = $_GET['artistID'];
}
else {
  // IDEA: include 'Artist couldn't be found' page
	header("Location: index.php");
}

$artist = new Artist($con, $artistID);
?>

<div class="entityInfo">
  <div class="centerSection">
    <div class="artistInfo">
      <h1 class="artistName">
        <?php
          echo $artist->getName();
        ?>
      </h1>
      <div class="headerButtons">
        <button class="button green">PLAY</button>
      </div>
    </div>
  </div>
</div>
