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

		// function to get the playlist options on the add to playlist dropdown menu
		// function has to be static because we want to be able to call it without calling an instance of it's class
		// accordingly, we need to pass $con in again
		public static function getPlaylistsDropdown($con, $username) {
			$dropdown = '<select class="item playlist">
							<option value="">Add to playlist</option>';
			// fetch all playlists associated with userLoggedIn
			$sql = "SELECT id, name FROM Playlists
					WHERE owner = '$username'";
			$query = mysqli_query($con, $sql);
			// iterate over each row in the query
			while ($row = mysqli_fetch_array($query)) {
				$id = $row['id'];
				$name = $row['name'];
				// append the $row as an option to the select tag
				$dropdown = $dropdown . "<option value='$id'>$name</option>";
			}

			return $dropdown . "</select>";
		}

	}
?>
