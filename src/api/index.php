<?php

// get classes
require_once 'UserEndpoint.class.php';
require_once 'EventEndpoint.class.php';
require_once 'QuestionEndpoint.class.php';
require_once 'InvalidEndpoint.class.php';

// request sent from client
$request = $_REQUEST['request'];

// collect arguments, endpoint and verb
$args = explode('/', rtrim($request, '/'));
$version = strtolower(array_shift($args));
$endpoint = strtolower(array_shift($args));

// which versions are currently alive?
$aliveVersions = array('v1');
if (!in_array($version, $aliveVersions)) {
	$api = new InvalidEndpoint($request);
	$api->processAPI();
	exit;
}

// decide which endpoint to use
switch ($endpoint) {

	case 'event':
		$api = new EventEndpoint($request);
		break;

	case 'question':
		$api = new QuestionEndpoint($request);
		break;

	case 'user':
		$api = new UserEndpoint($request);
		break;

	default:
		$api = new InvalidEndpoint($request);
		break;
}

// execute!
$api->processAPI();