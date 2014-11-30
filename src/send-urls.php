<?php
require_once 'resources/_master-list.php';
$file = 'uploads/testdata.txt';
$rawList = str_replace("\r\n", ',', trim(file_get_contents($file)));
$rawList = str_replace("\n", ',', $rawList);
$rawList = str_replace("\r", ',', $rawList);
$rawList = str_replace(' ', '', $rawList);
$rawList = preg_replace('/([,]{2,})/', ',', $rawList);
$emailsToSend = explode(',', $rawList);
$sent = Responses::sendResponseUrls($_GET['e'], $emailsToSend);
echo('Sent ' . $sent . ' emails');