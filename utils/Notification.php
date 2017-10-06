<?php

class Notification
{

    public static function notify() {
        if( isset($_SESSION[Session::ERROR_MESSAGE]) ) {
            echo '<div class="error">'.$_SESSION[Session::ERROR_MESSAGE].'</div>';
            unset($_SESSION[Session::ERROR_MESSAGE]);
        }
        else if( isset($_SESSION[Session::INFO_MESSAGE]) ) {
            echo '<div class="info">'.$_SESSION[Session::INFO_MESSAGE].'</div>';
            unset($_SESSION[Session::INFO_MESSAGE]);
        }
    }

    public static function setError($message) {
        $_SESSION[Session::ERROR_MESSAGE] = $message;
    }

    public static function setInfo($message) {
        $_SESSION[Session::INFO_MESSAGE] = $message;
    }

}