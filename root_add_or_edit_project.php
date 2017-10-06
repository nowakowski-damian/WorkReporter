<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/Project.php');
require_once($path.'model/Customer.php');


session_start();
Session::validateAsRoot();

$editProjectMode = false;
if( isset( $_POST["projectId"]) ) {
    $editProjectMode = true;
    $db = new DatabaseManager();
    $project = $db->getProjectById($_POST["projectId"]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php if($editProjectMode) echo "Edit project"; else echo "Add project"; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>

<div class="content-container" id="add_or_edit_project_container">

    <?php Notification::notify() ?>

    <form method="POST" action="action/root_modify_project.php" >
        <h1 id="add_or_edit_project_header">
            <?php if($editProjectMode) echo "Edit project"; else echo "Add project"; ?>
        </h1><br>

        <table id="add_or_edit_project_table">

            <tr>
                <td>
                    Customer
                </td>

            </tr>

            <tr>

                <td>
                    <select name="customerId" id="customerSelect" required>
                        <option value="NULL" selected>All</option>
                        <?php
                        if($db==null) {
                            $db = new DatabaseManager();
                        }
                        $customers = $db->getCustomers(true);
                        foreach ($customers as $customer) {
                            $option = "<option value='".$customer->getId()."'";
                            if( $editProjectMode && $project->getCustomerId()===$customer->getId() ) $option .= " selected";
                            $option .= ">".$customer->getName().", ".$customer->getAddress()."</option>";
                            echo $option;
                        }
                        ?>
                    </select>
                </td>

            </tr>

            <tr>
                <td>
                    Name
                </td>
            </tr>

            <tr>

                <td>
                    <input name="name" required="required"
                        <?php if($editProjectMode) echo "value='".$project->getName()."'"; ?>
                    >
                </td>

            </tr>

            <tr>
                <td>
                    Description
                </td>
            </tr>

            <tr>

                <td>
                    <input name="description"
                        <?php if($editProjectMode) echo "value='".$project->getDescription()."'"; ?>
                    >
                </td>

            </tr>

        </table>

        <div id="add_or_edit_project_buttons">
            <?php
            if( isset( $_POST["projectId"]) ) {
                echo "<input class='hidden' name='projectId' value='".$_POST["projectId"]."'>";
            }
            ?>
            <input type="submit" class="button button-large withmargin" name="saveButton" value="Save" />
            <input type="submit" class="button button-large withmargin" name="cancelButton" value="Cancel" formnovalidate/>
        </div>
    </form>


</div>

</body>

</html>

<?php $db->closeConnetion() ?>