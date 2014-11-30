<?php

class Questions {

	/* ACCESSORS */

	public static function getById($id) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'questions` WHERE `question_id` = \'' . $id . '\' LIMIT 1;');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}
	}

	public static function getByEventId($eventId) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'event_questions`, `' . DB_PREFIX . 'questions` WHERE `' . DB_PREFIX . 'event_questions`.`question_id` = `' . DB_PREFIX . 'questions`.`question_id` AND `event_id` = \'' . $eventId . '\' ORDER BY `' . DB_PREFIX . 'event_questions`.`order` ASC;');
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
			return $output;
		}
	}

	public static function getByResponseId($responseId) {
		$eventId = mysql_query('SELECT * FROM `' . DB_PREFIX . 'responses` WHERE `response_id` = \'' . $responseId . '\' LIMIT 1;');
		$eventRow = mysql_fetch_array($eventId, MYSQL_ASSOC);
		return Questions::getByEventId($eventRow['event_id']);
	}

}