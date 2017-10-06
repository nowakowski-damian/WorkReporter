<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 11:12 PM
 */
class Session
{
    const INFO_MESSAGE = "info_mssg";
    const ERROR_MESSAGE = "error_mssg";
    const LOGGED_USER = "logged_user";
    const BACKUP_DONE = "backup_done";


    public static function validateAsRoot() {
        $path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
        require_once($path.'model/User.php');

        if( !isset($_SESSION[Session::LOGGED_USER]) ) {
            $_SESSION[Session::ERROR_MESSAGE]="The session has expired!<br>Sign in again.";
            header('Location: index.php');
            exit();
        }
        else if( !$_SESSION[Session::LOGGED_USER]->isRoot() ){
            header('Location: user_dashboard.php');
            exit();
        }
    }

    public static function validateAsUser() {
        $path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
        require_once($path.'model/User.php');

        if( !isset($_SESSION[Session::LOGGED_USER]) ) {
            $_SESSION[Session::ERROR_MESSAGE]="The session has expired!<br>Sign in again.";
            header('Location: index.php');
            exit();
        }
        else if( $_SESSION[Session::LOGGED_USER]->isRoot() ){
            header('Location: root_dashboard.php');
            exit();
        }
    }

    public static function setBackupDone($isDone) {
        if( $isDone ) {
            $_SESSION[Session::BACKUP_DONE] = true;
        }
        else {
            unset($_SESSION[Session::BACKUP_DONE]);
        }
    }

    public static function isBackupDone() {
        return isset($_SESSION[Session::BACKUP_DONE]) && $_SESSION[Session::BACKUP_DONE]===true ;
    }

}