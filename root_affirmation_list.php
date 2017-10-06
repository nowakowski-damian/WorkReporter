<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/Customer.php');
require_once($path.'utils/CustomersTable.php');
require_once($path.'utils/AffirmationTable.php');

session_start();
Session::validateAsRoot();
?>

<script type="text/javascript" src="js/ajax.js"></script>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
    <link href="css/calendar.css" type="text/css" rel="stylesheet" />
    <title>Affirmations</title>
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>


<div class="content-container">

    <?php Notification::notify() ?>

    <div id="root_filter_view_container" >

        <table>
            <tr>
                <td> <input type="date" id="date_picker" <?php echo "value=".date("Y-m-d")?> > </td>
                <td> <input type="checkbox" id="locked_users_checkbox">  Show blocked users</td>
                <td> <input class="button button-large" type="submit" id="apply_date_button" value="Apply" onclick="onAfirmationFilter();"> </td>
            </tr>
        </table>

    </div>

    <div id="root_affirmation_list_headers">
        <h1 id="root_affirmation_list_header_left">Affirmed</h1>
        <h1 id="root_affirmation_list_header_right">Not affirmed</h1>
    </div>

    <div class="list_table" id="root_affirmation_list_container" >
        <?php
        $list = new AffirmationTable();
        echo $list->showClosed(date('Y-m-d'), false);
        echo $list->showOpened(date('Y-m-d'), false);
        ?>
    </div>

</div>

</body>
</html>