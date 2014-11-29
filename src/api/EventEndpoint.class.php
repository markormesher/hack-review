<?php
require_once 'BaseApi.class.php';

class EventEndpoint extends BaseAPI {

	function __construct($request) {
		parent::__construct($request);
	}

	function processAPI() {
		$method = parent::getMethod();
		$args = parent::getArgs();
		$verb = parent::getVerb();
		$qs = parent::getQueryString();

		if ($method == 'GET' && count($args) == 1 && $verb == 'by_organiser') {
			$this->getByOrganiserId($args[0]);
			return;
		}

		if ($method == 'GET' && count($args) == 1 && $verb == 'by_response') {
			$this->getByResponseId($args[0]);
			return;
		}

		if ($method == 'GET' && count($args) == 1) {
			$this->getById($args[0]);
			return;
		}

		if ($method == 'GET' && $verb == 'search' && array_key_exists('title', $qs)) {
			$this->searchByTitle($qs['title']);
			return;
		}

		if ($method == 'GET' && $verb == 'search' && array_key_exists('location', $qs)) {
			$this->searchByLocation($qs['location']);
			return;
		}

		if ($method == 'GET' && $verb == 'search' && array_key_exists('range_start', $qs) && array_key_exists('range_end', $qs)) {
			$this->searchByDate($qs['range_start'], $qs['range_end']);
			return;
		}

		// default
		$ie = new InvalidEndpoint(parent::getOriginalRequest());
		$ie->processAPI();
	}

	function getById($id) {
		$result = Events::getById($id);
		if ($result != null) {
			parent::_sendResponse($result);
		} else {
			$data = array('Error' => 'Event does not exist');
			parent::_sendResponse($data, 404);
		}
	}

	function getByOrganiserId($id) {
		$result = Events::getByOrganiserId($id);
		parent::_sendResponse($result);
	}

	function getByResponseId($id) {
		$result = Events::getByResponseId($id);
		parent::_sendResponse($result);
	}

	function searchByTitle($title) {
		$result = Events::searchByTitle($title);
		parent::_sendResponse($result);
	}

	function searchByLocation($location) {
		$result = Events::searchByLocation($location);
		parent::_sendResponse($result);
	}

	function searchByDate($rangeStart, $rangeEnd) {
		$result = Events::searchByDate($rangeStart, $rangeEnd);
		parent::_sendResponse($result);
	}

}