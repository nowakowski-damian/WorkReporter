<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
session_start();
Session::validateAsRoot();

$db = new DatabaseManager();
$goToLocation = "Location: ../root_users.php";

// block/unblock mode
if( isset($_POST["block"],$_POST["userId"]) ) {
    $userId = $_POST["userId"];
    $result = $db->setUserBlocked($userId,$_POST["block"]);
    if( $result ) {
        Notification::setInfo("User ".($_POST["block"] ? 'blocked' : 'unblocked')."!");
    }
    else {
        Notification::setError("Blocking error!");
    }
}
// remove mode
else if( isset($_POST["remove_user"],$_POST["userId"]) ) {
    $userId = $_POST["userId"];
    $result = $db->removeUser($userId);
    if( $result ) {
        Notification::setInfo("User and his reports removed!");
    }
    else {
        Notification::setError("Removing error!");
    }
}
// edit mode
else if( isset($_POST["saveButton"],$_POST["userId"],$_POST["account_type"],$_POST["name"],$_POST["surname"],$_POST["password"]) ) {
    $userId = $_POST["userId"];
    $result = $db->updateUser($userId,$_POST["name"],$_POST["surname"],$_POST["password"], $_POST["account_type"]);
    if( $result ) {
        Notification::setInfo("Data updated successfully!");
    }
    else {
        Notification::setError("Updating error!");
    }
}
// save mode
else if( isset($_POST["saveButton"],$_POST["login"],$_POST["account_type"],$_POST["name"],$_POST["surname"],$_POST["password"]) ) {
    $login = $_POST["login"];

    if( $db->getUserByLogin($login)!=null ) {
        Notification::setError("User with such a login already exists!");
        $goToLocation = "Location: ../root_add_or_edit_user.php";
    }
    else {
        $result = $db->addUser($login,$_POST["name"],$_POST["surname"],$_POST["password"], $_POST["account_type"]);
        if( $result ) {
            Notification::setInfo("User '".$login."' added successfully!");
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








