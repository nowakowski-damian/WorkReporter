<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/ReportsSummeryTable.php');
require_once($path.'utils/Session.php');

session_start();
Session::validateAsRoot();

$dateStart = isset($_GET["start"]) ? $_GET["start"] : null;
$dateEnd = isset($_GET["end"]) ? $_GET["end"] : null;
$customerId = isset($_GET["customer"]) ? $_GET["customer"] : null;
$projectId = isset($_GET["project"]) ? $_GET["project"] : null;
$userId = isset($_GET["user"]) ? $_GET["user"] : null;

$db = new DatabaseManager();
$dataArray = $db->getReportsWithFilter($dateStart, $dateEnd, $customerId, $projectId, $userId );
$time = date("dmy_His");
downloadSendHeaders( "Report_".$time.".csv" );
ob_start();
$df = fopen("php://output", 'w');
fwrite($df, "sep=,\n");
$header = array("Id","User","Customer","Project","Time","Date");
//array_walk( $header, 'excelEncode');
fputcsv($df, $header,",");
foreach( $dataArray[0] as $report ) {
    $row = array($report->getId(),$report->getUser(),$report->getCustomer(), $report->getProject(), $report->getTime(), $report->getDate());
//    array_walk( $row, 'excelEncode');
    fputcsv($df,$row ,"," );
}
fclose($df);
echo ob_get_clean();
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

function excelEncode(&$value, $key) {
    $value = iconv('UTF-8', 'Windows-1252', $value);
}

