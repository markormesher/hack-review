<?php

class Users {

	public static function getById($id) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'organisers` WHERE `organiser_id` = \'' . $id . '\' LIMIT 1');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}
	}

	public static function getByCredentials($email, $password) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'organisers` WHERE `email` = \'' . $email . '\' AND `password` = \'' . Utils::hashPassword($password) . '\' LIMIT 1');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}
	}

	public static function create($name, $email, $pass) {
		mysql_query('INSERT INTO `' . DB_PREFIX . 'organisers` VALUES(
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

	public static function update($id, $name = null, $email = null, $pass = null) {
		// collect updates
		if ($name != null) $updates['name'] = $name;
		if ($email != null) $updates['email'] = $email;
		if ($pass != null) $updates['pass'] = $pass;

		// create query
		if (!empty($updates)) {
			$updateStrings = array();
			foreach ($updates as $k => $v) {
				$updateStrings[] = '`' . $k . '` = \'' . $v . '\'';
			}
			mysql_query('UPDATE `' . DB_PREFIX . 'organisers` SET ' . implode(', ', $updateStrings) . ' WHERE `organiser_id` = \'' . $id . '\' LIMIT 1;');
		}
		return Users::getById($id);
	}
}