<?php

class Responses {

	/* ACCESSORS */

	public static function getById($id) {
		$result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'response_values` WHERE `response_id` = \'' . $id . '\';');
		if (mysql_num_rows($result) == 0) {
			return array();
		} else {
			$output = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($row['is_text']) {
					$result1 = mysql_query('SELECT * FROM `' . DB_PREFIX . 'response_text_values` WHERE `response_text_id` = \'' . $row['value'] . '\' LIMIT 1;');
					echo mysql_error();
					$row1 = mysql_fetch_array($result1, MYSQL_ASSOC);
					$row['value'] = $row1['value'];
				}
				$output[] = $row;
			}
			return $output;
		}
	}

	public static function getCountByEventId($eventId) {
		$result = mysql_query('SELECT COUNT(`event_id`) FROM `' . DB_PREFIX . 'responses` WHERE `event_id` = \'' . $eventId . '\' AND `status` = \'closed\';');
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return $row[0];
	}

	public static function getStatusById($id) {
		$result = mysql_query('SELECT `status` FROM `' . DB_PREFIX . 'responses` WHERE `response_id` = \'' . $id . '\';');
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return $row[0];
	}

	public static function getAverageScoreByEventId($eventId) {
		$result = mysql_query('SELECT AVG(`value`) FROM `' . DB_PREFIX . 'response_values` WHERE `response_id` IN (SELECT `response_id` FROM `' . DB_PREFIX . 'responses` WHERE `event_id` = \'' . $eventId . '\') AND `is_text` = 0;');
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return $row[0];
	}

	public static function getAverageScoreByQuestionId($questionId) {
		$result = mysql_query('SELECT count(`value`) FROM `' . DB_PREFIX . 'response_values` WHERE `' . DB_PREFIX . 'response_values`.`question_id` = \'' . $questionId . '\' AND `' . DB_PREFIX . 'response_values`.`is_text` = 0;');
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return $row[0];
	}

	public static function getAverageScoreByEventAndQuestionId($eventId, $questionId) {
		$result = mysql_query('SELECT AVG(`value`) FROM `' . DB_PREFIX . 'response_values` WHERE `response_id` IN (SELECT `response_id` FROM `' . DB_PREFIX . 'responses` WHERE `event_id` = \'' . $eventId . '\') AND `question_id` = \'' . $questionId . '\' AND `is_text` = 0;');
		$row = mysql_fetch_array($result, MYSQL_NUM);
		return $row[0];
	}

	public static function getAverageQuestionScoreByEventId($eventId) {
		$result = mysql_query('SELECT `question_id`, AVG(`value`) AS `average_score` FROM `' . DB_PREFIX . 'response_values` WHERE `response_id` IN (SELECT `response_id` FROM `' . DB_PREFIX . 'responses` WHERE `event_id` = \'' . $eventId . '\') AND `is_text` = 0 GROUP BY `question_id`;');
		$output = array();
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) $output[] = $row;
		return $output;
	}

	/* MUTATORS */

	public static function send($responseId, $values) {
		foreach ($values as $questionId => $value) {
			if (is_numeric($value)) {
				mysql_query('INSERT INTO `' . DB_PREFIX . 'response_values` VALUES (NULL, \'' . $responseId . '\', \'' . $questionId . '\', \'' . $value . '\', \'0\');');
			} else {
				mysql_query('INSERT INTO `' . DB_PREFIX . 'response_text_values` VALUES (NULL, \'' . mysql_escape_string($value) . '\');');
				mysql_query('INSERT INTO `' . DB_PREFIX . 'response_values` VALUES (NULL, \'' . $responseId . '\', \'' . $questionId . '\', \'' . mysql_insert_id() . '\', \'1\');');
			}
		}
		mysql_query('UPDATE `' . DB_PREFIX . 'responses` SET `status` = \'closed\' WHERE `response_id` = \'' . $responseId . '\';');
	}

	public static function generateResponseIds($eventId, $quantity) {
		$result = mysql_query('SELECT `response_id` FROM `' . DB_PREFIX . 'responses` ORDER BY `response_id` DESC LIMIT 1;');
		$row = mysql_fetch_array($result, 0);
		$highest = base_convert($row[0], 36, 10);
		$ids = array();
		for ($i = 0; $i < $quantity; $i++) {
			$newId = str_pad(base_convert(($highest + $i) . '', 10, 36), 6, '0', STR_PAD_LEFT);
			$ids[] = $newId;
			mysql_query('INSERT INTO `' . DB_PREFIX . 'responses` VALUES (\'' . $newId . '\', \'' . $eventId . '\', \'open\');');
		}
		return $ids;
	}

}