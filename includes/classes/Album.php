<?php
	class Album {

		private $con;
		private $albumID;
		private $albumTitle;
		private $artistID;
		private $artworkPath;

		public function __construct($con, $albumID) {
			$this->con = $con;
			$this->albumID = $albumID;

			$albumQuery = mysqli_query($this->con, "SELECT * FROM Albums WHERE albumID='$this->albumID'");
			$album = mysqli_fetch_array($albumQuery);

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
			$query = mysqli_query($this->con,
				"SELECT songID FROM Songs WHERE songAlbum='$this->albumID'"
			);
			return mysqli_num_rows($query);
		}

		public function getSongIDs() {

			$query = mysqli_query($this->con, "SELECT songID FROM Songs WHERE songAlbum='$this->albumID' ORDER BY albumOrder ASC");

			$array = array(); // create an array to hold all the songIDs

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songID']);
			}

			return $array;
		}





		public function ORIGINAL_getSongIDs() {
			$query = mysqli_query($this->con,
				"SELECT songID FROM Songs WHERE songAlbum='$this->albumID' ORDER BY albumOrder ASC"
			);

			// create an array that holds all the IDs
			$array = array();
			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songID']);
			}
			return $array;
		}

	}
?>