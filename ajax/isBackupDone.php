<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'model/User.php');
require_once($path.'utils/Session.php');
session_start();
Session::validateAsRoot();
echo Session::isBackupDone() ? "true" : "false";
die();
