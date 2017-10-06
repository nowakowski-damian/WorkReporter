<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/Project.php');
session_start();
Session::validateAsRoot();

$db = new DatabaseManager();
$goToLocation = "Location: ../root_projects.php";

// block/unblock mode
if( isset($_POST["block"],$_POST["projectId"]) ) {
    $projectId = $_POST["projectId"];
    $result = $db->setProjectBlocked($projectId,$_POST["block"]);
    if( $result ) {
        Notification::setInfo("Project ".($_POST["block"] ? 'blocked' : 'unblocked')."!");
    }
    else {
        Notification::setError("Blocking error!");
    }
}
// remove mode
else if( isset($_POST["remove_project"],$_POST["projectId"]) ) {
    $projectId = $_POST["projectId"];
    $result = $db->removeProject($projectId);
    if( $result ) {
        Notification::setInfo("Project and its reports removed!");
    }
    else {
        Notification::setError("Removing error!");
    }
}
// edit mode
else if( isset($_POST["saveButton"],$_POST["projectId"],$_POST["customerId"],$_POST["name"],$_POST["description"]) ) {
    $projectId = $_POST["projectId"];
    $result = $db->updateProject($projectId,$_POST["customerId"],$_POST["name"], $_POST["description"]);
    if( $result ) {
        Notification::setInfo("Data updated successfully!");
    }
    else {
        Notification::setError("Updating error!");
    }
}
// save mode
else if( isset($_POST["saveButton"],$_POST["customerId"],$_POST["name"],$_POST["description"]) ) {
    $customerId = $_POST["customerId"];
    $name = $_POST["name"];

    if( $db->getProjectByCustomerAndName($customerId,$name)!=null ) {
        Notification::setError("Project '".$name."' for chosen customer already exists!");
        $goToLocation = "Location: ../root_add_or_edit_project.php";
    }
    else {
        $result = $db->addProject($customerId,$name,$_POST["description"]);
        if( $result ) {
            Notification::setInfo("Project '".$name."' added successfully!");
        }
        else {
            Notification::setError("Adding error!");
        }
    }
}

$db->closeConnetion();

// cancel button or incorrect path
header($goToLocation);
exit();








