<?php
	class Song {

		protected $db;
		private $con;
		private $mysqliData;
		private $songID;
		private $songTitle;
		private $songArtist;
		private $songAlbum;
		private $songInstrument;
		private $duration;
		private $path;
		private $albumOrder;

		public function __construct($con, $songID) {
			$this->db = MyPDO::instance();
			$this->con = $con;
			$this->songID = $songID;

			$sql = "SELECT * FROM Songs WHERE songID = ?";
			$stmt = $this->db->run($sql, [$this->songID]);
			$songQuery = $stmt->fetch(PDO::FETCH_ASSOC);
			// to be used later when we play songs
			$this->mysqliData = $songQuery;

			$this->songTitle = $this->mysqliData['songTitle'];
			$this->songArtist = $this->mysqliData['songArtist'];
			$this->songAlbum = $this->mysqliData['songAlbum'];
			$this->duration = $this->mysqliData['duration'];
			$this->songInstrument = $this->mysqliData['songInstrument'];
			$this->path = $this->mysqliData['path'];
			// $this->albumOrder = $song['albumOrder']; this is done later
			// $this->plays ; we don't create a variable for plays, because we want to create the variable every time the song is played
		}

		public function getID() {
			return $this->songID;
		}

		public function getTitle() {
			return $this->songTitle;
		}

		public function getArtist() {
			// returns artistName (ie 'The Beatles') rather than artistID (ie '1'). That is, returns an Artist object.
			return new Artist($this->con, $this->songArtist);
		}

		public function getAlbum() {
			// returns albumName (ie 'The Beatles') rather than albumID (ie '1'). That is, returns an Album object.
			return new Album($this->con, $this->albumID);
		}

		public function getDuration() {
			return $this->duration;
		}

		public function getInstrument() {
			return $this->songInstrument;
		}

		public function getArtworkPath() {
			return $this->path;
		}

		public function getMysqliData() {
			return $this->mysqliData;
		}

	}
?>
