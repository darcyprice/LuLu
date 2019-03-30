<?php
include("includes/includedFiles.php");

$db = MyPDO::instance();
?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">
	<?php
	$sql = "SELECT * FROM Albums
			ORDER BY RAND()
			LIMIT 10";
	$stmt = $db->run($sql);

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// create an html div element each time it loops through the queryset
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
