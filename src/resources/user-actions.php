<?php

class Users {

	public static function getById($id) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'users` WHERE `id` = \'' . $id . '\' LIMIT 1');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}
	}

	public static function getByCredentials($email, $password) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'users` WHERE `email` = \'' . $email . '\' AND `password` = \'' . Utils::hashPassword($password) . '\' LIMIT 1');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}
	}

}