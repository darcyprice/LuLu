<?php
	class Artist {

		protected $db;
		private $con;
		private $artistID;

		public function __construct($con, $artistID) {
			$this->con = $con;
			$this->db = MyPDO::instance();
			$this->artistID = $artistID;
		}

		public function getID() {
			return $this->artistID;
		}

		public function getName() {
			$sql = "SELECT artistName FROM Artists WHERE artistID = ?";
			$stmt = $this->db->run($sql, [$this->artistID]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$artist = $row['artistName'];
			return $artist;
		}

		public function getSongIDs() {
			$sql = "SELECT songID FROM Songs
					WHERE songArtist = ?
					ORDER BY plays DESC";
			$stmt = $this->db->run($sql, [$this->artistID]);
			// create an array to hold all songIDs
			$array = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				array_push($array, $row['songID']);
			}
			return $array;
		}

	}
?>
