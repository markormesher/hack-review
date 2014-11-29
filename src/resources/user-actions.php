<?php

class User {

	public static function getById($id) {

	}

	public static function getByCredentials($email, $password) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'users` WHERE `email` = \'' . $email . '\' AND `password` = \'' . Utils::hashPassword($password) . '\' LIMIT 1');

	}

}