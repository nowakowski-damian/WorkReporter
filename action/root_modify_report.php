<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/Report.php');
session_start();
Session::validateAsRoot();

$db = new DatabaseManager();
$goToLocation = "Location: ../root_dashboard.php";

// edit mode
if( isset($_POST["saveButton"],$_POST["reportId"], $_POST["user"], $_POST["project"], $_POST["customer"],$_POST["date"],$_POST["reported_time"],$_POST["reported_description"]) ) {
    $result = $db->updateReport($_POST["reportId"],$_POST["user"], $_POST["project"], $_POST["customer"], $_POST["date"],$_POST["reported_time"], $_POST["reported_description"] );
    if( $result ) {
        Notification::setInfo("Data updated successfully!");
    }
    else {
        Notification::setError("Updating error!");
    }
}
$db->closeConnetion();

// cancel button or incorrect path
header($goToLocation);
exit();








