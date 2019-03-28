<?php
	class Album {

		private $con;
		protected $db;
		private $albumID;
		private $albumTitle;
		private $artistID;
		private $artworkPath;

		public function __construct($con, $albumID) {
			$this->con = $con;
			$this->db = MyPDO::instance();
			$this->albumID = $albumID;

			$sql = "SELECT * FROM Albums
					WHERE albumID = ?";
			$stmt = $this->db->run($sql, [$this->albumID]);
			$album = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->albumTitle = $album['albumTitle'];
			$this->artistID = $album['albumArtist'];
			$this->artworkPath = $album['artworkPath'];

		}

		public function getTitle() {
			return $this->albumTitle;
		}

		public function getArtist() {
			// returns artistName ('The Beatles'), rather than artistID ('1')
			return new Artist($this->con, $this->artistID);
		}

		public function getArtworkPath() {
			return $this->artworkPath;
		}

		public function getNumberOfSongs() {
			// return the number of songs in the album
			$sql = "SELECT songID FROM Songs
					WHERE songAlbum = ?";
			$stmt = $this->db->run($sql, [$this->albumID]);
			return $stmt->rowCount();
		}

		public function getSongIDs() {
			$sql = "SELECT songID FROM Songs
					WHERE songAlbum = ?
					ORDER BY albumOrder ASC";
			$stmt = $this->db->run($sql, [$this->albumID]);
			$array = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				array_push($array, $row['songID']);
			}
			return $array;
		}
	}
?>
