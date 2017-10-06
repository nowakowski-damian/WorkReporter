<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'utils/DatabaseManager.php');
require_once($path.'model/User.php');

class UsersTable
{

    public function show() {
        $html = "<table id='users_table'>".$this->getTableHeaderRow();
        $db = new DatabaseManager();
        $users = $db->getUsers();
        if( count($users)<=0 ) {
            $html .= $this->getEmptyRow();
        }
        else {
            foreach ($users as $user) {
                $html .= $this->getTableRow($user->getId(), $user->getLogin(), $user->getName(), $user->getSurname(), $user->isRoot(), $user->isBlocked());
            }
        }
        $db->closeConnetion();
        $html .= "</table>";
        return $html;
    }

    private function getTableHeaderRow() {
        $header = "<tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Action</th>
                    </tr>";
        return $header;
    }

    private function getTableRow($id,$login,$name,$surname, $isRoot, $isBlocked) {
        if($isBlocked) {
            $row = "<tr class='blocked_tr'>";
        }
        else {
            $row = "<tr>";
        }
        if($isRoot) {
            $row .= "<td>$id  <i id='icon_admin' class='icon-buysellads'/> </td>";
        }
        else {
            $row .= "<td>$id </td>";
        }
        $row .= "
                <td>$login</td>
                <td>$name</td>
                <td>$surname</td>
                <td>  
                    <form action='root_add_or_edit_user.php' method='post'>
                        <input class='hidden' name='userId' value='$id'>
                        <input type='submit' class='icon-input' id='edit_user_input' name='edit_user' value='&#xf044;' />
                    </form>";
        if($login!='root') {
            $row .="
                    <form action='action/root_modify_user.php' method='post'>
                        <input class='hidden' name='userId' value='$id'>
                        <input class='hidden' name='block' value='".!$isBlocked."'>
                        <input type='submit' id='block_unblock_user_input' class='icon-input' name='block_unblock_user'
                        value=".($isBlocked ? "'&#xf023;'":"'&#xf09c;'").">
                    </form>
                    <form action='action/root_modify_user.php' method='post' onsubmit='return confirm(\"All the users reports will be removed too!\\nAre you sure you want to continue??\");'>
                            <input class='hidden' name='userId' value='$id'>
                            <input class='icon-input' id='remove_user_input' type='submit' name='remove_user' value='&#xf1f8;'/>
                    </form>";
        }
        $row .="</td></tr>";
        return $row;
    }

    private function getEmptyRow() {
        $row = "<tr>
                    <td colspan='5' style='text-align: center'>No records!</td>
                </tr>";
        return $row;
    }

}