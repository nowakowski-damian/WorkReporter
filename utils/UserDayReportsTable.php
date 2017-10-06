<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 13/04/2017
 * Time: 12:14 AM
 */
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path."utils/DatabaseManager.php");
require_once($path.'model/Report.php');
require_once($path.'model/Customer.php');
require_once($path.'model/Project.php');


class UserDayReportsTable
{


    public function show($forUser,$date) {
        $html = "<table>".$this->getTableHeaderRow();

        $db = new DatabaseManager();
        $reports = $db->getReports($forUser,$date);
        if( count($reports)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach( $reports as $report ) {
                $project = $db->getProjectById( $report->getProjectId() );
                $customer = $db->getCustomerById( $report->getCustomerId() );
                $customerFullName = $customer->getName().", ".$customer->getAddress();
                $html .= $this->getTableRow( $report->getId(),$customerFullName, $project->getName(), $report->getTimeHours(), $report->getDescription() );
            }
        }
        $db->closeConnetion();

        $html .= "</table>";
        return $html;
    }

    private function getTableHeaderRow() {
        $header = "<tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Project</th>
                        <th>Time</th>
                        <th>Description</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($id,$customerFullName,$project,$time,$description) {
        $row = "<tr>
                    <td>".$id."</td>
                    <td>".$customerFullName."</td>
                    <td>".$project."</td>
                    <td>".$time."</td>
                    <td>".$description."</td>
            </tr>";
        return $row;
    }

    private function getEmptyRow() {
        $row = "<tr>
                    <td colspan='5' style='text-align: center'>No records!</td>
                </tr>";
        return $row;
    }


}