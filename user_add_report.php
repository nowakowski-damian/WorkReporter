<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');
require_once($path.'model/ReportAffirmation.php');

session_start();
Session::validateAsUser();
?>

<script type="text/javascript" src="js/ajax.js"></script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Add report</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/user.css" media="screen" />
</head>

<body>

<?php include("view/user_top_navigation.html"); ?>

<div class="content-container" id="user_add_report_container">

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
        echo "</div></body></html>";
        $db->closeConnetion();
        die();
    }
    Notification::notify()
    ?>


    <form method="POST" action="action/user_save_report.php">
        <h1 id="user_add_report_header">Add report</h1><br>

        <table id="user_add_report_table">

            <tr>
                <td>
                    Customer
                </td>

                <td>
                    Project
                </td>
            </tr>

            <tr>
                <td>
                    <select name="customer" id="customerSelect" onchange="updateProjectSelect(this.value,'projectSelect', false);" required >
                        <?php
                        $customers = $db->getCustomers();
                        foreach ($customers as $customer) {
                            echo "<option value='".$customer->getId()."'>".$customer->getName()."</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="project" id="projectSelect" required>
                        <?php
                        if( $customers!=null && $customers[0]!=null ) {
                            $projects = @$db->getProjectsForCustomerId($customers[0]->getId(),false);
                            foreach ($projects as $project) {
                                echo "<option value='" . $project->getId() . "'>" . $project->getName() . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    Time [h]
                </td>
                <td>
                    Description
                </td>
            </tr>

            <tr>
                <td>
                    <input name="reported_time" type="number" step="0.01" min="0.01" required >
                </td>
                <td>
                    <input name="reported_description">
                </td>
            </tr>

        </table>

        <div id="user_add_report_buttons">

        <input type="submit" class="button button-large withmargin" name="addButton" value="Add"/>
        <input type="submit" class="button button-large withmargin" name="addContinueButton" value="Add and continue"/>
        </div>
    </form>


</div>



</body>


</html>

<?php
$db->closeConnetion();
?>