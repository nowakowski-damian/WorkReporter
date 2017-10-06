<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>

<body id="login_body">

<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
session_start();
if( isset($_SESSION[Session::LOGGED_USER]) ) {
    if( $_SESSION[Session::LOGGED_USER]->isRoot() ) {
        header('Location: root_dashboard.php');
    }
    else {
        header('Location: user_dashboard.php');
    }
}
?>

<div id="login_topbar">
    <img src="img/logo.png">
    <h1>Work time reporting system</h1>
    <a href="http://www.example.com/">www.example.com</a>
</div>

<div class="login-container">
    <?php
    if( isset($_SESSION[Session::ERROR_MESSAGE]) ) {
        echo '<div class="error">'.$_SESSION[Session::ERROR_MESSAGE].'</div>';
        unset($_SESSION[Session::ERROR_MESSAGE]);
    }
    ?>
    <form action="action/login.php" method="post">
        <input class="input-login" type="text" name="username" placeholder="login" required="required"/>
        <input class="input-login" type="password" name="password" placeholder="hasło" required="required" autocomplete=off />
        <input type="submit" class="button button-large" value="Login"/>
    </form>
</div>


</body>
</html>
