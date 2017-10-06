<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');

session_start();
Session::validateAsUser();


if( isset($_POST["dateStart"],$_POST["dateEnd"]) ) {
    $dateStart = $_POST["dateStart"];
    $dateEnd = $_POST["dateEnd"];
    $db = new DatabaseManager();
    $begin = new DateTime( $dateStart );
    $end = new DateTime( $dateEnd );
    $end = $end->modify( '+1 day' );
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $success = true;
    foreach ( $period as $dt ) {
        $success &= $db->setVacationDay($_SESSION[Session::LOGGED_USER]->getId(), $dt->format("Y-m-d") );
    }
    $db->closeConnetion();
    if($success) {
        if($dateStart===$dateEnd) {
            Notification::setInfo("Vacation in " .$dateStart." submitted!");
        }
        else {
            Notification::setInfo("Vacation from " .$dateStart. " to " .$dateEnd. " submitted!");
        }
    }
    else {
        Notification::setError("Vacation submitting error!");
    }
}
else {
    Notification::setError("Vacation submitting error!");
}



header("Location: ../user_add_vacation.php");
die();
