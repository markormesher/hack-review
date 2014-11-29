<?php

class Security {

	static $user;

	public static function makeSecure() {
		if(isset($_SESSION) && isset($_SESSION['userID'])) {
			$userID = $_SESSION['userID'];
			Security::$user = Users::getById($userID);
		} else {
			Security::$user = null;
		}

		if (Security::$user == null) {
			header('Location: login.php');
		}
	}

	public static function login($userId) {
		$_SESSION['userID'] = $userId;
	}

	public static function logout() {
		$_SESSION['userID'] = 0;
		session_destroy();
	}

}