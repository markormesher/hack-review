<?php

class Questions {

	/* ACCESSORS */

	public static function getByEventId($eventId) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'event_questions`, `' . DB_PREFIX . 'questions` WHERE `' . DB_PREFIX . 'event_questions`.`question_id` = `' . DB_PREFIX . 'questions`.`question_id` AND `event_id` = \'' . $eventId . '\' ORDER BY `' . DB_PREFIX . 'event_questions`.`order` ASC;');
		echo mysql_error();
		if (mysql_num_rows($result) == 0) {
			return null;
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
			return $output;
		}
	}

}