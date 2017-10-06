<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');

session_start();
Session::validateAsRoot();
$db = new DatabaseManager();
if ($db->clearDatabase()) {
    Notification::setInfo("Database cleared!");
} else {
    Notification::setError("Database clearing error!");
}
header("Location: ../root_tools.php");
die();
