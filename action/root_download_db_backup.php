<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'model/User.php');
require_once($path.'utils/DatabaseManager.php');


session_start();
Session::validateAsRoot();
$db = new DatabaseManager();
$time = date("dmy_His");
downloadSendHeaders( "db_backup_".$time.".sql" );
ob_start();
$df = fopen("php://output", 'w');
fwrite($df, $db->getBackup());
fclose($df);
echo ob_get_clean();
Session::setBackupDone(true);
die();


function downloadSendHeaders($filename) {

    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}