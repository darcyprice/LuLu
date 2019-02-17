<?php
	class Artist {

		private $con;
		private $artistID;

		public function __construct($con, $artistID) {
			$this->con = $con;
			$this->artistID = $artistID;
		}

		public function getID() {
			return $this->artistID;
		}

		public function getName() {
			$sql = "SELECT artistName FROM Artists WHERE artistID='$this->artistID'";
			$artistQuery = mysqli_query($this->con, $sql);
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['artistName'];
		}

		public function getSongIDs() {
			$query = mysqli_query($this->con, "SELECT songID FROM Songs WHERE songArtist='$this->artistID' ORDER BY plays DESC");
			// create array to holds all songIDs
			$array = array();
			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songID']);
			}
			return $array;
		}

	}
?>
