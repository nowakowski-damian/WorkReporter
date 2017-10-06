<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/Calendar.php');
require_once($path.'utils/UserDayReportsTable.php');
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
    <title>Dashboard</title>
</head>

<body>

<?php include("view/user_top_navigation.html"); ?>

<div class="content-container" id="user_main_container">

    <?php Notification::notify() ?>

    <section id="user_dashboard_main_section">
        <div class="calendar" >
            <?php
            $calendar = new Calendar();
            echo $calendar->show();
            ?>
        </div>

        <div class="list_table" id="user_dashboard_report_table" >
            <?php
            $list = new UserDayReportsTable();
            echo $list->show($_SESSION[Session::LOGGED_USER], $_GET[Calendar::ARG_YEAR]."-".$_GET[Calendar::ARG_MONTH]."-".$_GET[Calendar::ARG_DAY] );
            ?>
        </div>
    </section>

</div>



</body>
</html>