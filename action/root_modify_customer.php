<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/Customer.php');
session_start();
Session::validateAsRoot();

$db = new DatabaseManager();
$goToLocation = "Location: ../root_customers.php";

// block/unblock mode
if( isset($_POST["block"],$_POST["customerId"]) ) {
    $customerId = $_POST["customerId"];
    $result = $db->setCustomerBlocked($customerId,$_POST["block"]);
    if( $result ) {
        Notification::setInfo("Customer ".($_POST["block"] ? 'blocked' : 'unblocked')."!");
    }
    else {
        Notification::setError("Blocking error!");
    }
}
// remove mode
else if( isset($_POST["remove_customer"],$_POST["customerId"]) ) {
    $customerId = $_POST["customerId"];
    $result = $db->removeCustomer($customerId);
    if( $result ) {
        Notification::setInfo("Customer and its projects removed!");
    }
    else {
        Notification::setError("Removing error!");
    }
}
// edit mode
else if( isset($_POST["saveButton"],$_POST["customerId"],$_POST["name"],$_POST["address"]) ) {
    $customerId = $_POST["customerId"];
    $result = $db->updateCustomer($customerId,$_POST["name"],$_POST["address"] );
    if( $result ) {
        Notification::setInfo("Data updated successfully!");
    }
    else {
        Notification::setError("Updating error!");
    }
}
// save mode
else if( isset($_POST["saveButton"],$_POST["name"],$_POST["address"]) ) {
    $address = $_POST["address"];
    $name = $_POST["name"];
    $customer = $db->getCustomerByAddress($address);
    if( $customer!=null && $customer->getName()===$name ) {
        Notification::setError("Customer with such a name and address already exists!");
        $goToLocation = "Location: ../root_add_or_edit_customer.php";
    }
    else {
        $result = $db->addCustomer($name,$address);
        if( $result ) {
            Notification::setInfo("Customer '".$name."' added successfully!");
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








