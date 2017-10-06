<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/ReportsSummeryTable.php');
require_once($path.'utils/DatabaseManager.php');
session_start();
Session::validateAsRoot();
?>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/utils.js"></script>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link href="css/calendar.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
    <title>Dashboard</title>
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>


<div class="content-container">

    <?php Notification::notify() ?>

    <div id="root_filter_view_container" >

            <table>

                <tr>
                    <td> <input type="checkbox" id="start_date_checkbox">  Start date </td>
                    <td> <input type="checkbox" id="customer_checkbox">  Customer </td>
                    <td> <input type="checkbox" id="user_checkbox">  User </td>
                </tr>

                <tr>
                    <td> <input type="date" id="start_date_picker"<?php echo "value='".date("Y-m-d")."'"?> onclick="checkCheckboxWitId('start_date_checkbox');"> </td>
                    <td> <select id="customer_select"
                                 onclick="checkCheckboxWitId('customer_checkbox');"
                                 onchange="updateProjectSelect(this.value,'project_select', true);" >
                            <?php
                            $db = new DatabaseManager();
                            $customers = @$db->getCustomers(true);
                            foreach ($customers as $customer) {
                                echo "<option value='".$customer->getId()."'>".$customer->getFullName()."</option>";
                            }
                            ?>
                        </select> </td>
                    <td> <select id="user_select" onclick="checkCheckboxWitId('user_checkbox');">
                            <?php
                            $users = @$db->getUsers();
                            foreach ($users as $user) {
                                echo "<option value='".$user->getId()."'>".$user->getFullName()."</option>";
                            }
                            ?> </select> </td>
                </tr>

                <tr>
                    <td> <input type="checkbox" id="end_date_checkbox">  End date </td>
                    <td> <input type="checkbox" id="project_checkbox">  Project </td>
                    <td> <input class="button button-large" type="submit" id="reset_button" value="Reset" onclick="onFilter(false);"> </td>
                </tr>

                <tr>
                    <td> <input type="date" id="end_date_picker" <?php echo "value='".date("Y-m-d")."'"?> onclick="checkCheckboxWitId('end_date_checkbox');"> </td>
                    <td> <select id="project_select" onclick="checkCheckboxWitId('project_checkbox');">
                            <?php
                            if( $customers!=null && $customers[0]!=null ) {
                                $projects = @$db->getProjectsForCustomerId( $customers[0]->getId() );
                                foreach ($projects as $project) {
                                    echo "<option value='".$project->getId()."'>".$project->getName()."</option>";
                                }
                            }
                            ?>
                        </select> </td>
                    <td> <input class="button button-large" type="submit" id="apply_button" value="Apply" onclick="onFilter(true);"> </td>
                </tr>

            </table>

    </div>

    <div class="list_table" id="root_reports_list_container" >
            <?php
            $list = new ReportsSummeryTable();
            echo $list->show();
            ?>
    </div>

</div>



</body>
</html