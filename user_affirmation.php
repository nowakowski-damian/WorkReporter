<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
session_start();
Session::validateAsUser();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link href="css/calendar.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/user.css" media="screen" />
    <title>Affirm</title>
</head>

<body>

<?php include("view/user_top_navigation.html"); ?>

<div class="content-container" id="user_affirmation_main_container">

    <?php
        $db =  new DatabaseManager();
        $userId = $_SESSION[Session::LOGGED_USER]->getId();
        $affirmation = $db->getTodayAffirmation($userId);
        if( $affirmation ) {
            if($affirmation->isVacation()) {
                Notification::setInfo("Today is vacation day.");
            }
            else {
                Notification::setInfo("You have already finished reporting for today.");
            }
            Notification::notify();
        }
        else {
            Notification::setError("You have not finished reporting for today!");
            Notification::notify();
            echo "
                <div id=\"user_affirmation_container\">
                    <h1>Affirm reporting</h1>
                    <form action=\"action/user_affirmate_report.php\" method=\"post\">
                        <input class=\"hidden\" name=\"userId\" value=\"$userId\">
                        <input type=\"checkbox\" name=\"affirmation_checkbox\" required> I have finished reporting for today.
                        <input class=\"button\" type=\"submit\" value=\"Affirm\">
                    </form>
                </div>";
        }
        ?>
</div>



</body>
</html>

<?php
    $db->closeConnetion();