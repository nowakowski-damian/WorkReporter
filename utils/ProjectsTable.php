<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'model/Project.php');
require_once($path.'model/Customer.php');


class ProjectsTable
{

    public function show() {
        $html = "<table id='projects_table'>".$this->getTableHeaderRow();
        $db = new DatabaseManager();
        $projects = $db->getProjects(true);
        if( count($projects)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($projects as $project) {
                $customerId = $project->getCustomerId();
                if( $customerId==null ) {
                    $customerFullName = "ALL";
                }
                else {
                    $customer = $db->getCustomerById($customerId);
                    $customerFullName = $customer->getName().", ".$customer->getAddress();
                }
                $html .= $this->getTableRow($project->getId(), $customerFullName, $project->getName(), $project->getDescription(), $project->isBlocked());
            }
        }
        $db->closeConnetion();
        $html .= "</table>";
        return $html;
    }

    private function getTableHeaderRow() {
        $header = "<tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Customer info</th>
                        <th>Action</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($id, $customerFullName, $name, $description, $isBlocked) {
        if($isBlocked) {
            $row = "<tr class='blocked_tr'>";
        }
        else {
            $row = "<tr>";
        }
        $row .= "
                <td>$id</td>
                <td>$name</td>
                <td>$description</td>
                <td>$customerFullName</td>
                <td>  
                    <form action='root_add_or_edit_project.php' method='post'>
                        <input class='hidden' name='projectId' value='$id'>
                        <input type='submit' class='icon-input' id='edit_project_input' name='edit_project' value='&#xf044;' />
                    </form>
                    <form action='action/root_modify_project.php' method='post'>
                        <input class='hidden' name='projectId' value='$id'>
                        <input class='hidden' name='block' value='".!$isBlocked."'>
                        <input type='submit' id='block_unblock_project_input' class='icon-input' name='block_unblock_project'
                        value=".($isBlocked ? "'&#xf023;'":"'&#xf09c;'").">
                    </form>
                    <form action='action/root_modify_project.php' method='post' onsubmit='return confirm(\"All the reports for this project will be removed too!\\nAre you sure you want to continue?\");'>
                        <input class='hidden' name='projectId' value='$id'>
                        <input class='icon-input' id='remove_project_input' type='submit'  name='remove_project' value='&#xf1f8;' />
                    </form>
                </td>
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