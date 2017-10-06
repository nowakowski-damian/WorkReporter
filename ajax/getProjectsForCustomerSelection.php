<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/Session.php');
require_once($path.'utils/DatabaseManager.php');

$customerId = $_GET["customerId"];
$withBlocked = $_GET["withBlocked"];

if (!is_numeric($customerId)) {
    echo "Data Error";
    exit;
}

require_once($path.'utils/DatabaseManager.php');
$db = new DatabaseManager();
$projects = @$db->getProjectsForCustomerId( $customerId, $withBlocked );
echo "<select name='project' id='projectSelect'>";
foreach ($projects as $project) {
    echo "<option value='".$project->getId()."'>".$project->getName()."</option>";
}
echo "</select>";

$db->closeConnetion();