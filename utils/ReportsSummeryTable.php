<?php

$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path."utils/DatabaseManager.php");
require_once($path.'model/Report.php');
require_once($path.'model/User.php');
require_once($path.'model/Customer.php');
require_once($path.'model/Project.php');
require_once($path.'model/FilteredReport.php');



class ReportsSummeryTable
{


    public function show($dateStart = null, $dateEnd = null, $customerId = null, $projectId = null, $userId = null)
    {

        $db = new DatabaseManager();
        $dataArray = $db->getReportsWithFilter($dateStart, $dateEnd, $customerId, $projectId, $userId);
        $db->closeConnetion();

        $html = $this->getSumRow($dataArray[1]);
        $html .= "<table>";
        $html .= $this->getTableHeaderRow();
        if( count($dataArray[0])<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($dataArray[0] as $report) {
                $html .= $this->getTableRow($report->getId(),
                    $report->getUser(), $report->getUserId(),
                    $report->getCustomer(), $report->getCustomerId(),
                    $report->getProject(), $report->getProjectId(),
                    $report->getTime(), $report->getDate());
            }
        }

        $html .= "</table>";

        return $html;
    }

    private function getTableHeaderRow()
    {
        $header = "<tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Project</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($id, $user, $userId, $customer, $customerId, $project, $projectId, $time, $date)
    {
        $row = "<tr id='root_reports_table_row'>
                    <td>" . $id . "</td>
                    <td>" . $user . "</td>
                    <td>" . $customer . "</td>
                    <td>" . $project . "</td>
                    <td>" . $time . "</td>
                    <td>" . $date . "</td>
                    <td> 
                    <form action='root_edit_report.php' method='post'>
                        <input class='hidden' name='reportId' value='$id'>
                        <input class='hidden' name='userId' value='$userId'>
                        <input class='hidden' name='customerId' value='$customerId'>
                        <input class='hidden' name='projectId' value='$projectId'>
                        <input class='hidden' name='time' value='$time'>
                        <input class='hidden' name='date' value='$date'>
                        <input type='submit' class='icon-input' name='edit_report' value='&#xf044;' />
                    </form>               
                    <input type='submit' class='icon-input' name='remove_report' value='&#xf1f8;' onclick='onRemoveReport(".$id.")' />
                    </td>
            </tr>";
        return $row;
    }

    private function getSumRow($sum)
    {
        $row = "<table id='root_table_toolbar'> 
                    <tr>
                        <td id='root_download_csv_td' onclick='onDownloadCsv()'> <i class='icon-download' aria-hidden='true'>  Download CSV</i> </td>
                        <td id='root_sum_td'>Sum: <b>" . $sum . "</b></td> 
                    </tr>
                </table>";
        return $row;
    }

    private function getEmptyRow() {
        $row = "<tr>
                    <td colspan='7' style='text-align: center'>No records!</td>
                </tr>";
        return $row;
    }


}


