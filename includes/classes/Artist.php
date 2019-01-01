<?php
	class Artist {

		private $con;
		private $artistID;

		public function __construct($con, $artistID) { 
			$this->con = $con;
			$this->artistID = $artistID;
		}

		public function getName() {
			$artistQuery = mysqli_query($this->con, "SELECT artistName FROM Artists WHERE artistID='$this->artistID'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['artistName'];
		}

	}
?>