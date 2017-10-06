<?php

if ( (!isset($_POST['username'])) || (!isset($_POST['password'])) ) {
    header('Location: ../index.php');
    exit();
}

$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'utils/DatabaseManager.php');
session_start();

$userName = $_POST['username'];
$password = $_POST['password'];

$db = new DatabaseManager();

if( !$db->isUserCorrect($userName) ) {
    $_SESSION[Session::ERROR_MESSAGE] = "Incorrect login!";
    header('Location: ../index.php');
    $db->closeConnetion();
    exit();
}

if( !$db->isPasswordCorrect($userName,$password) ) {
    $_SESSION[Session::ERROR_MESSAGE] = "Incorrect password!";
    header('Location: ../index.php');
    $db->closeConnetion();
    exit();
}

$user = $db->getUserByLogin($userName);

if( $user->isBlocked() ) {
    $_SESSION[Session::ERROR_MESSAGE] = "Your account was blocked by administrator!";
    header('Location: ../index.php');
    $db->closeConnetion();
    exit();
}

$_SESSION[Session::LOGGED_USER] = $user;
if( $user->isRoot() ) {
    header('Location: ../root_dashboard.php');
}
else {
    header('Location: ../user_dashboard.php');
}

$db->closeConnetion();