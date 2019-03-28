<?php
	class Account {

		private $con;
		private $errorArray;
		protected $db;

		public function __construct($con) {
			$this->con = $con;
			$this->db = MyPDO::instance();
			$this->errorArray = array();
		}

		public function login($un, $pw) {
			$pw = md5($pw); // encycrpt the pw
			$sql = "SELECT * FROM Users
					WHERE username = ? AND password = ?";
			$query = $this->db->run($sql, [$un, $pw]);
			// check if un and pw combination are unique in db
			if ($query->rowCount() == 1) {
				return true;
			} else {
				// if not, push error message to array
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
			$this->validateUsername($un);
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em, $em2);
			$this->validatePasswords($pw, $pw2);

			if(empty($this->errorArray) == true) {
				// if there has been no errors, insert the data into the db
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			/*
			if user attempts to register and returns an error, print the error message associated with that error on the registration screen.
			*/
			if(!in_array($error, $this->errorArray)) { // checks if $error NOT exists in the erroryArray
				$error = ""; // set $error to an empty string
			}
			return "<span class='errorMessage'>$error</span>"; // returns an HTML element
		}

		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$encryptedPw = md5($pw); // encrypts the password using the md5 method
			$profilePic = "assets/images/profile-pics/default_profile_pic.png";
			$date = date("Y-m-d");

			$sql = "INSERT INTO Users
					VALUES (userID, ?, ?, ?, ?, ?, ?, ?)";
			$query = $this->db->run($sql, [$un, $fn, $ln, $em, $encryptedPw, $date, $profilePic]);

			if ($query->rowCount() == 1) {
				$result = true;
			} else {
				$result = false;
			}
			return $result;
		}

		private function validateUsername($un) {

			if(strlen($un) > 25 || strlen($un) < 5) {
				// the "::" is similar to the "->"
				// the "->" is where you have an instance of a class
				// the "::" is where you don't have an instance of a class, because it is function
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}

			// checks if username exists
			$sql = "SELECT username FROM Users
					WHERE username = ?";
			$query = $this->db->run($sql, [$un]);
			if ($query->rowCount() != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}

		}

		private function validateFirstName($fn) {
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function validateLastName($ln) {
			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}

		private function validateEmails($em, $em2) {
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			// checks if email exists
			$sql = "SELECT email FROM Users
					WHERE email = ?";
			$query = $this->db->run($sql, [$em]);
			if ($query->rowCount() != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}
		}

		private function validatePasswords($pw, $pw2) {
			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordNotAlphaNumeric);
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}

			if($pw != $pw2) {
				array_push($this->errorArray, Constants::$passwordsDoNotMatch);
				return;
			}

		}


	}
?>
