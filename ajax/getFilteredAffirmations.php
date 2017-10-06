<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/AffirmationTable.php');
require_once($path.'utils/Session.php');
session_start();
Session::validateAsRoot();

if( isset($_GET["date"],$_GET["blocked"]) ) {
    $date = $_GET["date"];
    $withBlocked = $_GET["blocked"]==="true" ? true : false;
    $list = new AffirmationTable();
    echo $list->showClosed($date, $withBlocked);
    echo $list->showOpened($date, $withBlocked);
}


