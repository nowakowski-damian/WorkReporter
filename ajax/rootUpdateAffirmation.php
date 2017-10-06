<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');

session_start();
Session::validateAsRoot();

if( !isset($_GET['userId'],$_GET['date'],$_GET['affirmed']) ) {
    exit();
}

$db = new DatabaseManager();
$result = $db->updateReportAffirmation($_GET['userId'],$_GET['date'],$_GET['affirmed']==='false' );
$db->closeConnetion();
