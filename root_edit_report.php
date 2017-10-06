<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');
session_start();
Session::validateAsRoot();

$reportId = $_POST["reportId"];
$userId = $_POST["userId"];
$customerId = $_POST["customerId"];
$projectId = $_POST["projectId"];
$time = $_POST["time"];
$date = $_POST["date"];

$db = new DatabaseManager();
$project = $db->getProjectById($projectId);

?>

    <script type="text/javascript" src="js/ajax.js"></script>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Report edit</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/user.css" media="screen" />
    </head>

    <body>

    <?php include("view/root_top_navigation.html"); ?>

    <div class="content-container" id="user_add_report_container">

        <?php Notification::notify() ?>


        <form method="POST" action="action/root_modify_report.php">
            <h1 id="user_add_report_header">Report edit</h1><br>

            <table id="user_add_report_table">

                <tr>
                    <td>
                        User
                    </td>

                    <td>
                        Date
                    </td>
                </tr>

                <tr>
                    <td>
                        <select name="user" id="user_select" required>
                            <?php
                            $users = @$db->getUsers();
                            foreach ($users as $user) {
                                $html = "<option value='".$user->getId()."'";
                                if( $userId==$user->getId() ) $html .= " selected";
                                $html .= ">".$user->getFullName()."</option>";
                                echo $html;
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="date" name="date" id="datePicker" value="<?php echo $date ?>" required>
                    </td>
                </tr>

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
                        <select name="customer" id="customerSelect" onchange="updateProjectSelect(this.value,'projectSelect',true);" required >
                            <?php
                            $customers = $db->getCustomers(true);
                            foreach ($customers as $customer) {
                                $option = "<option value='".$customer->getId()."'";
                                if( $customerId===$customer->getId() ) $option .= " selected";
                                $option .= ">".$customer->getName().", ".$customer->getAddress()."</option>";
                                echo $option;
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="project" id="projectSelect" required>
                            <?php
                            $projects = @$db->getProjectsForCustomerId( $customerId );
                            foreach ($projects as $project) {
                                $option = "<option value='".$project->getId()."'";
                                if( $projectId===$project->getId() ) $option .= " selected";
                                $option .= ">".$project->getName()."</option>";
                                echo $option;
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
                        <input name="reported_time" type="number" step="0.01" min="0.01" value='<?php echo $time; ?>' required >
                    </td>
                    <td>
                        <input name="reported_description" value='<?php echo $project->getDescription();?>'>
                    </td>
                </tr>

            </table>

            <div id="user_add_report_buttons">
                <input class='hidden' name='reportId' value='<?php echo $reportId; ?>' />
                <input type="submit" class="button button-large withmargin" name="saveButton" value="Save"/>
                <input type="submit" class="button button-large withmargin" name="cancelButton" value="Cancel"/>
            </div>
        </form>


    </div>



    </body>


    </html>

<?php
$db->closeConnetion();
?>