<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'model/User.php');

class CustomersTable
{

    public function show() {
        $html = "<table id='customers_table'>".$this->getTableHeaderRow();
        $db = new DatabaseManager();
        $customers = $db->getCustomers(true);
        if( count($customers)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($customers as $customer) {
                $html .= $this->getTableRow($customer->getId(), $customer->getName(), $customer->getAddress(), $customer->isBlocked());
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
                        <th>Addres</th>
                        <th>Action</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($id,$name,$address,$isBlocked) {
        if($isBlocked) {
            $row = "<tr class='blocked_tr'>";
        }
        else {
            $row = "<tr>";
        }
        $row .= "
                <td>$id</td>
                <td>$name</td>
                <td>$address</td>
                <td>  
                    <form action='root_add_or_edit_customer.php' method='post'>
                        <input class='hidden' name='customerId' value='$id'>
                        <input type='submit' class='icon-input' id='edit_customer_input' name='edit_customer' value='&#xf044;' />
                    </form>
                    <form action='action/root_modify_customer.php' method='post'>
                        <input class='hidden' name='customerId' value='$id'>
                        <input class='hidden' name='block' value='".!$isBlocked."'>
                        <input type='submit' id='block_unblock_customer_input' class='icon-input' name='block_unblock_customer'
                        value=".($isBlocked ? "'&#xf023;'":"'&#xf09c;'").">
                    </form>
                    <form action='action/root_modify_customer.php' method='post' onsubmit='return confirm(\"All the customers projects and reports will be removed too!\\nAre you sure you want to continue?\");'>
                        <input class='hidden' name='customerId' value='$id'>
                        <input class='icon-input' id='remove_customer_input' type='submit'  name='remove_customer' value='&#xf1f8;'/>
                    </form>
                </td>
            </tr>";
        return $row;
    }

    private function getEmptyRow() {
        $row = "<tr>
                    <td colspan='4' style='text-align: center'>No records!</td>
                </tr>";
        return $row;
    }


}