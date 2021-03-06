<?php

/**
 * Sessions
 */

session_start();

/**
 * Connections
 */

require_once 'connections/mysql.php';

/**
 * Actions
 */

require_once 'utils.php';
require_once 'event-actions.php';
require_once 'user-actions.php';
require_once 'question-actions.php';
require_once 'response-actions.php';
require_once 'security-actions.php';
