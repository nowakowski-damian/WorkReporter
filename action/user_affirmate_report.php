<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');

session_start();
Session::validateAsUser();

if( !isset($_POST['affirmation_checkbox'],$_POST['userId']) ) {
    header('Location: ../index.php');
    exit();
}

$db = new DatabaseManager();
$result = $db->setReportAffirmation($_POST['userId']);
$db->closeConnetion();
header('Location: ../user_affirmation.php');