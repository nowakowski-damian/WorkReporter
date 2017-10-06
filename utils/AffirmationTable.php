<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'model/User.php');
require_once($path.'model/FilteredReportAffirmation.php');

class AffirmationTable
{

    public function showClosed($date,$withBlocked) {
        $html = "<div id='closed_affirmation_container'> <table>".$this->getTableHeaderRow();
        $db = new DatabaseManager();
        $affirmations = $db->getClosedReportAffirmationForDate($date,$withBlocked);
        if( count($affirmations)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($affirmations as $affirmation) {
                $totalTime = $affirmation->isVacation() ? "vacation" : $affirmation->getUserTotalTime();
                $html .= $this->getTableRow($date, $affirmation->getUserId(), $affirmation->getUserFullName(), $affirmation->isUserBlocked(), $totalTime,false);
            }
        }
        $db->closeConnetion();
        $html .= "</table> </div>";
        return $html;
    }

    public function showOpened($date,$withBlocked) {

        $html = "<div id='opened_affirmation_container'> <table>".$this->getTableHeaderRow();
        $db = new DatabaseManager();
        $affirmations = $db->getOpenedReportAffirmationForDate($date,$withBlocked);
        if( count($affirmations)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($affirmations as $affirmation) {
                $html .= $this->getTableRow($date, $affirmation->getUserId(), $affirmation->getUserFullName(), $affirmation->isUserBlocked(), $affirmation->getUserTotalTime(),true);
            }
        }
        $db->closeConnetion();
        $html .= "</table> </div>";
        return $html;
    }

    private function getTableHeaderRow() {
        $header = "<tr>
                        <th>User</th>
                        <th>Reported time</th>
                        <th>Action</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($date, $userId,$name,$isBlocked,$time,$isOpened) {
        if($isBlocked) {
            $row = "<tr class='blocked_tr'>";
        }
        else {
            $row = "<tr>";
        }
        $argumentsString = "\"".$date."\",".$userId.",".($isOpened ? "false":"true");
        $row .= "
                <td>$name</td>
                <td>$time</td>
                <td><button onclick='changeAffirmation($argumentsString)' class='button button-small ".($isOpened ? "greenish":"reddish")."' > <i class='".($isOpened ? "icon-check'></i>   confirm" : "icon-close'></i>   cancel")."</button></td>
            </tr>";
        return $row;
    }

    private function getEmptyRow() {
        $row = "<tr>
                    <td colspan='3' style='text-align: center'>No records!</td>
                </tr>";
        return $row;
    }


}