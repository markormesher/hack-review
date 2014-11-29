<?php

class Events {

	/* ACCESSORS */

	public static function getById($id) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'events` WHERE `event_id` = \'' . $id . '\' LIMIT 1;');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}
	}

	public static function searchByTitle($title) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'events` WHERE MATCH (`title`) AGAINST (\'' . $title . '\')');
		if (mysql_num_rows($result) == 0) {
			return array();
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
			return $output;
		}
	}

	public static function searchByLocation($location) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'events` WHERE MATCH (`address`) AGAINST (\'' . $location . '\') OR MATCH (`city`) AGAINST (\'' . $location . '\') OR MATCH (`postcode`) AGAINST (\'' . $location . '\') OR MATCH (`country`) AGAINST (\'' . $location . '\');');
		echo mysql_error();
		if (mysql_num_rows($result) == 0) {
			return array();
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
			return $output;
		}
	}

	public static function searchByDate($rangeStart, $rangeEnd) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'events` WHERE `start` >= \'' . date('Y-m-d H:i:s', strtotime($rangeStart)) . '\' AND `end` <= \'' . date('Y-m-d H:i:s', strtotime($rangeEnd)) . '\';');
		if (mysql_num_rows($result) == 0) {
			return array();
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
			return $output;
		}
	}

	public static function getByOrganiserId($organiserId) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'events` WHERE `organiser_id` = \'' . $organiserId . '\' ORDER BY `start`;');
		if (mysql_num_rows($result) == 0) {
			return array();
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
			return $output;
		}
	}

	/* MUTATORS */

	public static function create($title, $address, $city, $postcode, $country, $start, $end, $hackStart, $hackEnd, $logoFile, $organiserId) {
		mysql_query('INSERT INTO `' . DB_PREFIX . 'events` VALUES(
			NULL,
			\'' . $title . '\',
			\'' . $address . '\',
			\'' . $city . '\',
			\'' . $postcode . '\',
			\'' . $country . '\',
			\'' . date('Y-m-d H:i:s', strtotime($start)) . '\',
			\'' . date('Y-m-d H:i:s', strtotime($end)) . '\',
			\'' . date('Y-m-d H:i:s', strtotime($hackStart)) . '\',
			\'' . date('Y-m-d H:i:s', strtotime($hackEnd)) . '\',
			\'' . $logoFile . '\',
			' . $organiserId . '
		);');
		$insertId = mysql_insert_id();
		if ($insertId === false) {
			return null;
		} else {
			return Events::getById($insertId);
		}
	}

	public static function update($id, $title = null, $address = null, $city = null, $postcode = null, $country = null, $start = null, $end = null, $hackStart = null, $hackEnd = null, $logoFile = null, $organiserId = null) {
		// collect updates
		$updates = array();
		if ($title != null) $updates['title'] = $title;
		if ($address != null) $updates['address'] = $address;
		if ($city != null) $updates['city'] = $city;
		if ($postcode != null) $updates['postcode'] = $postcode;
		if ($country != null) $updates['country'] = $country;
		if ($start != null) $updates['start'] = $start;
		if ($end != null) $updates['end'] = $end;
		if ($hackStart != null) $updates['hack_start'] = $hackStart;
		if ($hackEnd != null) $updates['hack_end'] = $hackEnd;
		if ($logoFile != null) $updates['logo_file'] = $logoFile;
		if ($organiserId != null) $updates['organiser_id'] = $organiserId;

		// create query
		if (!empty($updates)) {
			$intFields = array('organiser_id');
			$dateFields = array('start', 'end', 'hack_start', 'hack_end');
			$updateStrings = array();
			foreach ($updates as $k => $v) {
				if (in_array($k, $intFields)) {
					$updateStrings[] = '`' . $k . '` = ' . $v;
				} elseif (in_array($k, $dateFields)) {
					$updateStrings[] = '`' . $k . '` = \'' . date('Y-m-d H:i:s', strtotime($v)) . '\'';
				} else {
					$updateStrings[] = '`' . $k . '` = \'' . $v . '\'';
				}
			}
			mysql_query('UPDATE `' . DB_PREFIX . 'events` SET ' . implode(', ', $updateStrings) . ' WHERE `event_id` = \'' . $id . '\' LIMIT 1;');
		}
		return Events::getById($id);
	}

}