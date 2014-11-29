<?php
require_once 'BaseApi.class.php';

class UserEndpoint extends BaseAPI {

	function __construct($request) {
		parent::__construct($request);
	}

	function processAPI() {
		$method = parent::getMethod();
		$args = parent::getArgs();
		$qs = parent::getQueryString();

		if ($method == 'GET' && count($args) == 1) {
			$this->getById($args[0]);
			return;
		}

		if ($method == 'GET' && array_key_exists('email', $qs) && array_key_exists('password', $qs)) {
			$this->getByCredentials($qs['email'], $qs['password']);
			return;
		}

		// default
		$ie = new InvalidEndpoint(parent::getOriginalRequest());
		$ie->processAPI();
	}

	function getById($id) {
		$result = Users::getById($id);
		if ($result != null) {
			parent::_sendResponse($result);
		} else {
			$data = array('Error' => 'User does not exist');
			parent::_sendResponse($data, 404);
		}
	}

	function getByCredentials($email, $password) {
		$result = Users::getByCredentials($email, $password);
		if ($result != null) {
			parent::_sendResponse($result);
		} else {
			$data = array('Error' => 'Invalid username/password combination');
			parent::_sendResponse($data, 403);
		}
	}
}