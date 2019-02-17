<?php
	class Playlist {

		private $con;
        private $id;
        private $playlistName;
        private $playistOwner;
        private $dateCreated;

		public function __construct($con, $data) { // $con connects the db to the class
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

	}
?>
