<?php
	class Playlist {

		private $con;
        private $id;
        private $playlistName;
        private $playistOwner;
        private $dateCreated;

		public function __construct($con, $data) {
			// if $data is NOT an array (ie, it's playlistID)
			// convert it into an using using playlistID to fetch from db
			if (! is_array($data)) {
				$sql = "SELECT * FROM Playlists WHERE playlistID='$data'";
				$query = mysqli_query($con, $sql);
				$data = mysqli_fetch_array($query);
			}

			$this->con = $con;
            $this->id = $data['playlistID'];
            $this->playlistName = $data['playlistName'];
            $this->playlistOwner = $data['playlistOwner'];
            $this->$dateCreated = $data['$dateCreated'];
		}

        public function getID() {
            return $this->id;
        }

        public function getName() {
            return $this->playlistName;
        }

        public function getOwner() {
            return $this->playlistOwner;
        }

        public function getDate() {
            return $this->dateCreated;
        }

		public function getNumberOfSongs() {
			$sql = "SELECT songID FROM PlaylistSongs WHERE playlistID='$this->id'";
			$query = mysqli_query($this->con, $sql);
			return mysqli_num_rows($query);
		}

		public function getSongIDs() {
			$sql = "SELECT songID FROM PlaylistSongs WHERE playlistID='$this->id' ORDER BY playlistOrder ASC";
			$query = mysqli_query($this->con, $sql);
			$array = array(); // create an array to hold all the songIDs
			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songID']);
			}
			return $array;
		}

	}
?>
