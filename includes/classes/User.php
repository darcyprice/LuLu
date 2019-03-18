<?php
	class User {

		private $con;
        private $username;

		public function __construct($con, $username) { // $con connects the db to the class
			$this->con = $con;
            $this->username = $username;
		}

        public function getUsername() {
            return $this->username;
        }

		// function to get User's first and last name
		public function getFullName() {
			$sql = "SELECT concat(firstName, ' ', lastName) as 'fullName'
					FROM Users
					WHERE username = '$this->username'";
			$query = mysqli_query($this->con, $sql);
			$row = mysqli_fetch_array($query);
			return $row['fullName'];
		}

	}
?>
