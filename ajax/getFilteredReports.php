<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/ReportsSummeryTable.php');
require_once($path.'utils/Session.php');
session_start();
Session::validateAsRoot();

$dateStart = isset($_GET["start"]) ? $_GET["start"] : null;
$dateEnd = isset($_GET["end"]) ? $_GET["end"] : null;
$customerId = isset($_GET["customer"]) ? $_GET["customer"] : null;
$projectId = isset($_GET["project"]) ? $_GET["project"] : null;
$userId = isset($_GET["user"]) ? $_GET["user"] : null;

$table = new ReportsSummeryTable();
echo $table->show($dateStart,$dateEnd,$customerId,$projectId,$userId);

