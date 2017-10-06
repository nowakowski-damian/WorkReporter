<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 11:26 PM
 */
session_start();
session_unset();
header("Location: ../index.php");