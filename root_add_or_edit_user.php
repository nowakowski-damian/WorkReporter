<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'utils/Notification.php');
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');

session_start();
Session::validateAsRoot();

$editUserMode = false;
if( isset( $_POST["userId"]) ) {
    $editUserMode = true;
    $db = new DatabaseManager();
    $user = $db->getUserById($_POST["userId"]);
    $db->closeConnetion();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php if($editUserMode) echo "Edit user"; else echo "Add user"; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/root.css" media="screen" />
</head>

<body>

<?php include("view/root_top_navigation.html"); ?>

<div class="content-container" id="add_or_edit_user_container">

    <?php Notification::notify() ?>

    <form method="POST" action="action/root_modify_user.php" >
        <h1 id="add_edit_user_header">
            <?php if($editUserMode) echo "Edit user"; else echo "Add user"; ?>
            </h1><br>

        <table id="add_or_edit_user_table">

            <tr>
                <td>
                    Login
                </td>

                <td>
                    Account type
                </td>
            </tr>

            <tr>

                <td>
                    <input name="login" required="required"
                        <?php if($editUserMode) echo "value='".$user->getLogin()."' disabled"; ?>
                    >
                </td>

            <td>
                <select name="account_type" id="accountTypeSelect"
                    <?php if( $editUserMode && $user->getAccountType()===User::ACC_TYPE_ROOT && $user->getLogin()==='root' ) echo " disabled"; ?>
                    >
                    <option value=<?php echo "'".User::ACC_TYPE_USER."'";
                        if( $editUserMode && $user->getAccountType()===User::ACC_TYPE_USER ) echo " selected"; ?>
                    >Employee</option>
                    <option value=<?php echo "'".User::ACC_TYPE_ROOT."'";
                        if( $editUserMode && $user->getAccountType()===User::ACC_TYPE_ROOT ) echo " selected"; ?>
                    >Administrator</option>
                </select>
            </td>
            </tr>

            <tr>
                <td>
                    Name
                </td>

                <td>
                    Surname
                </td>
            </tr>

            <tr>

                <td>
                    <input name="name" required="required"
                        <?php if($editUserMode) echo "value='".$user->getName()."'"; ?>
                    >
                </td>
                <td>
                    <input name="surname" required="required"
                        <?php if($editUserMode) echo "value='".$user->getSurname()."'"; ?>
                    >
                </td>

            </tr>

            <tr>
                <td>
                    Password
                </td>
                <td>
                    Confirm password
                </td>
            </tr>

            <tr>
                <td>
                    <input name="password" id="password1" type="password" autocomplete=off />
                </td>
                <td>
                    <input name="password2" id="password2" type="password" autocomplete=off />
                </td>
            </tr>

        </table>

        <div id="add_or_edit_user_buttons">
        <?php
            if( isset( $_POST["userId"]) ) {
                echo "<input class='hidden' name='userId' value='".$_POST["userId"]."'>";
            }
            if( $editUserMode && $user->getAccountType()===User::ACC_TYPE_ROOT && $user->getLogin()==='root' ) {
                echo "<input class='hidden' name='account_type' value='".User::ACC_TYPE_ROOT."'>";
            }
            ?>
        <input type="submit" class="button button-large withmargin" name="saveButton" value="Save"
               onsubmit='return validatePasswordsEquality(<?php echo $editUserMode; ?>);' />
        <input type="submit" class="button button-large withmargin" name="cancelButton" value="Cancel" formnovalidate/>
        </div>
    </form>


</div>

</body>


</html>

<script type="text/javascript" src="js/user_validation.js"></script>
