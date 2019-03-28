<?php
	class Playlist {

		private $con;
		protected $db;
        private $id;
        private $playlistName;
        private $playistOwner;
        private $dateCreated;

		public function __construct($con, $data) {
			$this->db = MyPDO::instance();
			// if $data is NOT an array (ie, it's playlistID)
			// convert it into an using using playlistID to fetch from db
			if (! is_array($data)) {
				$sql = "SELECT * FROM Playlists WHERE playlistID = ?";
				$stmt = $this->db->run($sql, [$data]);
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			$this->con = $con;
            $this->id = $data['playlistID'];
            $this->playlistName = $data['playlistName'];
            $this->playlistOwner = $data['playlistOwner'];
            $this->dateCreated = $data['$dateCreated'];
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
			$sql = "SELECT songID FROM PlaylistSongs
					WHERE playlistID = ?";
			$stmt = $this->db->run($sql, [$this->id]);
			return $stmt->rowCount();
		}

		public function getSongIDs() {
			$sql = "SELECT songID FROM PlaylistSongs
					WHERE playlistID = ?
					ORDER BY playlistOrder ASC";
			$stmt = $this->db->run($sql, [$this->id]);
			$array = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
			// BUG: convert to PDO (challenge is that it is a static function, so how to pass $this->db into static function??)
			// fetch all playlists associated with userLoggedIn
			$sql = "SELECT playlistID, playlistName
					FROM Playlists
					WHERE playlistOwner = '$username'";
			$query = mysqli_query($con, $sql);
			// iterate over each row in the query
			while ($row = mysqli_fetch_array($query)) {
				$id = $row['playlistID'];
				$name = $row['playlistName'];
				// append the $row as an option to the select tag
				$dropdown = $dropdown . "<option value='$id'>$name</option>";
			}
			return $dropdown . "</select>";
		}

	}
?>
