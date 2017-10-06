<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');

session_start();
Session::validateAsUser();

if( !isset($_POST['project'],$_POST['reported_time'],$_POST["customer"]) ) {
    header('Location: ../index.php');
    exit();
}

$projectId = $_POST['project'];
$customerId = $_POST['customer'];
$reportedTime = $_POST['reported_time'];
$reportedDescrption = $_POST['reported_description'];

if( $reportedTime<=0 ) {
    $_SESSION[Session::ERROR_MESSAGE]="Adding error!<br>Time can't be negative value.";
    header('Location: ../user_add_report.php');
    exit();
}

$db = new DatabaseManager();
$result = $db->addReport($_SESSION[Session::LOGGED_USER]->getId(),$projectId, $customerId, $reportedTime, $reportedDescrption );
$db->closeConnetion();

if( !$result ) {
    $_SESSION[Session::ERROR_MESSAGE]="Adding error!<br>Please try again.";
    header('Location: ../user_add_report.php');
}
else {
    $_SESSION[Session::INFO_MESSAGE]="Added successfully!";
    if (isset($_POST['addButton'])) {
        header('Location: ../index.php');
    } else {
        header('Location: ../user_add_report.php');
    }
}