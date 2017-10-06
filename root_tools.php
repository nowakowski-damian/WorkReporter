<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'model/User.php');
require_once($path.'utils/Session.php');
session_start();
Session::validateAsRoot();
Session::setBackupDone(false);
?>

<script type="text/javascript" src="js/ajax.js"></script>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
    <title>Tools</title>
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>


<div class="content-container">

    <?php Notification::notify() ?>

    <div  id="root_tools_db_container" >
        <h1>Database</h1>
        <table id='root_tools_db_table'>
            <tr>
                <td id='root_tools_db_backup_td' onclick='onDatabaseBackup()'> <i class='icon-download' aria-hidden='true'> Backup</i> </td>
                <td id='root_tools_db_clear_td' onclick='onDatabaseClear()'><i class='icon-trash' aria-hidden='true'> Clear</i></td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>