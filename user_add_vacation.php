<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Calendar.php');
require_once($path.'utils/VacationTable.php');

session_start();
Session::validateAsUser();
?>

    <script type="text/javascript" src="js/ajax.js"></script>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Add vacation</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/user.css" media="screen" />
    </head>

    <body>

    <?php include("view/user_top_navigation.html"); ?>

    <div class="content-container" id="user_add_vacation_main_container">

        <?php Notification::notify() ?>

        <h1 id="user_add_vacation_header">Submit vacation</h1><br>

        <?php
        $table = new VacationTable();
        echo $table->show($_SESSION[Session::LOGGED_USER]->getId());
        ?>

        <div id="user_add_vacation_container">

        <form action="action/user_add_vacation.php" method="post">
            <table id="user_add_vacation_table">

                <tr>
                    <td>
                        Start date
                    </td>

                    <td>
                        End date
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="date" id="dateStart" name="dateStart" size="20" <?php echo "value='".date("Y-m-d")."'"?>/>
                    </td>
                    <td>
                        <input type="date" id="dateEnd" name="dateEnd" size="20" <?php echo "value='".date("Y-m-d")."'"?>/>
                    </td>
                </tr>
            </table>

            <input type="submit" class="button button-large withmargin" name="addButton" value="Submit" onsubmit="return validateDates();"/>
        </form>
        </div>

    </div>

    </body>


    </html>

<script type="text/javascript">
    var datefield=document.createElement("input");
    datefield.setAttribute("type", "date");
    if (datefield.type!="date") { //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write("<link href='css/jquery-ui.css' rel='stylesheet' type='text/css' \/>\n");
        document.write("<script src='js/jquery/jquery-1.12.4.js'><\/script>\n");
        document.write("<script src='js/jquery/jquery-ui.js'><\/script>\n");
    }
</script>


<script type="text/javascript">
    if (datefield.type!="date") { //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        jQuery(function($){ //on document.ready
            $('#dateStart').datepicker({ dateFormat: 'yy-mm-dd' });
            $('#dateEnd').datepicker({ dateFormat: 'yy-mm-dd' });
        });
    }
</script>

<script type="text/javascript" src="js/add_vacation_validation.js"></script>
