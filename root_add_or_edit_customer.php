<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/Customer.php');

session_start();
Session::validateAsRoot();

$editCustomerMode = false;
if( isset( $_POST["customerId"]) ) {
    $editCustomerMode = true;
    $db = new DatabaseManager();
    $customer = $db->getCustomerById($_POST["customerId"]);
    $db->closeConnetion();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php if($editCustomerMode) echo "Edit customer"; else echo "Add customer"; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>

<div class="content-container" id="add_or_edit_customer_container">

    <?php Notification::notify() ?>

    <form method="POST" action="action/root_modify_customer.php" >
        <h1 id="add_edit_customer_header">
            <?php if($editCustomerMode) echo "Edit customer"; else echo "Add customer"; ?>
        </h1><br>

        <table id="add_or_edit_customer_table">

            <tr>
                <td>
                    Name
                </td>

            </tr>

            <tr>

                <td>
                    <input name="name" required="required"
                        <?php if($editCustomerMode) echo "value='".$customer->getName()."'"; ?>
                    >
                </td>

            </tr>

            <tr>
                <td>
                    Addres
                </td>
            </tr>

            <tr>

                <td>
                    <input name="address" required="required"
                        <?php if($editCustomerMode) echo "value='".$customer->getAddress()."'"; ?>
                    >
                </td>

            </tr>

        </table>

        <div id="add_or_edit_customer_buttons">
            <?php
            if( isset( $_POST["customerId"]) ) {
                echo "<input class='hidden' name='customerId' value='".$_POST["customerId"]."'>";
            }
            ?>
            <input type="submit" class="button button-large withmargin" name="saveButton" value="Save" />
            <input type="submit" class="button button-large withmargin" name="cancelButton" value="Cancel" formnovalidate/>
        </div>
    </form>


</div>

</body>


</html>