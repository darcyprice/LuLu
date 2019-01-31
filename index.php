<?php

// header is included in includes/includedFiles.php
include("includes/includedFiles.php");

?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">

	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

		while($row = mysqli_fetch_array($albumQuery)) {
			/* create an html div element each time it loops through the queryset */
			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?albumID=" . $row['albumID'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['albumTitle'] .
						"</div>
					</span>

				</div>";
		}
	?>

</div>
