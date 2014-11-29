<?php
require_once 'BaseApi.class.php';

class QuestionEndpoint extends BaseAPI {

	function __construct($request) {
		parent::__construct($request);
	}

	function processAPI() {
		$method = parent::getMethod();
		$args = parent::getArgs();
		$verb = parent::getVerb();

		if ($method == 'GET' && $verb == 'byevent' && count($args) == 1) {
			$this->getByEventId($args[0]);
			return;
		}

		if ($method == 'GET' && count($args) == 1) {
			$this->getById($args[0]);
			return;
		}

		// default
		$ie = new InvalidEndpoint(parent::getOriginalRequest());
		$ie->processAPI();
	}

	function getById($id) {
		$result = Questions::getById($id);
		if ($result != null) {
			parent::_sendResponse($result);
		} else {
			$data = array('Error' => 'Question does not exist');
			parent::_sendResponse($data, 404);
		}
	}

	function getByEventId($eventId) {
		$result = Questions::getByEventId($eventId);
		parent::_sendResponse($result);
	}
}