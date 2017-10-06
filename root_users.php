<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/UsersTable.php');
session_start();
Session::validateAsRoot();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
    <link href="css/calendar.css" type="text/css" rel="stylesheet" />
    <title>Users</title>
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>


<div class="content-container">

    <?php Notification::notify() ?>

    <form action="root_add_or_edit_user.php" method="POST" >
        <input class='icon-input add-button' id='root_add_user_button' type='submit'  name='addButton' value='&#xf0fe; Add user' />
    </form>

    <div class="list_table" id="root_users_list_container" >
        <?php
            $list = new UsersTable();
            echo $list->show();
        ?>
    </div>

</div>



</body>
</html>