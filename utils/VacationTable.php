<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'model/User.php');
require_once($path.'model/FilteredReportAffirmation.php');

class VacationTable {
    public function show($userId,$all=false) {
        $html = "<div id='vacation_dates_container'> <table class='list_table'>".$this->getTableHeaderRow();
        $db = new DatabaseManager();
        $vacationDates = $db->getNextVacationsDay($userId,$all);
        if( count($vacationDates)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($vacationDates as $date) {
                $html .= $this->getTableRow($date);
            }
        }
        $db->closeConnetion();
        $html .= "</table> </div>";
        return $html;
    }

    private function getTableHeaderRow() {
        $header = "<tr>
                        <th>Submitted days</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($date) {
        $row = "<tr>
                    <td>$date</td>
                </tr>";
        return $row;
    }

    private function getEmptyRow() {
        $row = "<tr>
                    <td colspan='1' style='text-align: center'>No records!</td>
                </tr>";
        return $row;
    }


}