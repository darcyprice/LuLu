<?php
	class User {

		protected $db;
		private $con;
        private $username;

		public function __construct($con, $username) {
			$this->db = MyPDO::instance();
			$this->con = $con;
            $this->username = $username;
		}

        public function getUsername() {
            return $this->username;
        }

		public function getEmail() {
			$sql = "SELECT email FROM Users WHERE username = ?";
			$stmt = $this->db->run($sql, [$this->username]);
			$query = $stmt->fetch(PDO::FETCH_ASSOC);
			return $query['email'];
		}

		// function to get User's first and last name
		public function getFullName() {
			$sql = "SELECT CONCAT(firstName, ' ', lastName) as `fullName`
					FROM Users
					WHERE username = ?";
			$stmt = $this->db->run($sql, [$this->username]);
			$query = $stmt->fetch(PDO::FETCH_ASSOC);
			return $query['fullName'];
		}

	}
?>
