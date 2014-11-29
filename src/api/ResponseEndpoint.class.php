<?php
require_once 'BaseApi.class.php';

class ResponseEndpoint extends BaseAPI {

	function __construct($request) {
		parent::__construct($request);
	}

	function processAPI() {
		$method = parent::getMethod();
		$args = parent::getArgs();

		if ($method == 'GET' && count($args) == 1) {
			$this->getById($args[0]);
			return;
		}

		// default
		$ie = new InvalidEndpoint(parent::getOriginalRequest());
		$ie->processAPI();
	}

	function getById($id) {
		$result = Responses::getById($id);
		if ($result != null) {
			parent::_sendResponse($result);
		} else {
			$data = array('Error' => 'Response does not exist');
			parent::_sendResponse($data, 404);
		}
	}
}