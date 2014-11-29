<?php

class Users {

	public static function getById($id) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'users` WHERE `user_id` = \'' . $id . '\' LIMIT 1');
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

	public static function create($name, $email, $pass) {
		mysql_query('INSERT INTO `' . DB_PREFIX . 'users` VALUES(
			NULL,
			\'' . $email . '\',
			\'' . Utils::hashPassword($pass) . '\',
			\'' . $name . '\'
 		);');
		$insertId = mysql_insert_id();
		if ($insertId === false) {
			return null;
		} else {
			return Users::getById($insertId);
		}
	}
}