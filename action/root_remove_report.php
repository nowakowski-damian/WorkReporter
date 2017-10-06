<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Session.php');
session_start();
Session::validateAsRoot();

if( isset($_GET["reportId"]) && is_numeric($_GET["reportId"]) ) {
    $db = new DatabaseManager();
    echo $db->removeReport( $_GET["reportId"] );
    $db->closeConnetion();
}







