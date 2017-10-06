<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 6:51 PM
 */
$path = $_SERVER['DOCUMENT_ROOT'].'/work_reporter/';
require_once($path.'model/User.php');
require_once($path.'model/Report.php');
require_once($path.'model/Customer.php');
require_once($path.'model/Project.php');
require_once($path.'model/FilteredReport.php');
require_once($path.'model/FilteredReportAffirmation.php');
require_once($path.'model/ReportAffirmation.php');


class DatabaseManager
{

    private $host = "localhost";
    private $db_user = "root";
    private $db_password = "psswd_to_change";
    private $db_name = "work_reporter";

    private $dbConnection;

    /**
     * DatabaseManager constructor.
     */
    public function __construct()
    {
        $this->dbConnection = @new mysqli($this->host, $this->db_user, $this->db_password, $this->db_name);
        if ( $this->dbConnection->connect_errno!=0 ) {
            echo "Database error: ".$this->dbConnection->connect_errno;
            exit();
        }
        mysqli_set_charset($this->dbConnection, "utf8");
    }

    public function closeConnetion() {
        $this->dbConnection->close();
    }

    public function sanitize($userInput) {
        return mysqli_real_escape_string($this->dbConnection, htmlspecialchars($userInput, ENT_QUOTES, "UTF-8") );
    }

    public function query($queryString) {
        return @$this->dbConnection->query($queryString);
    }

    function getBackup() {
        $queryTables = $this->query('SHOW TABLES');
        while($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }
        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\n
        SET time_zone = \"+00:00\";\r\n\r\n\r\n
        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n
        /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n
        /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n
        /*!40101 SET NAMES utf8 */;\r\n
        --\r\n-- Database: `".$this->db_name."`\r\n--\r\n\r\n\r\n";

        foreach($target_tables as $table){
            if ( empty($table) ) {
                continue;
            }
            $result	= $this->query('SELECT * FROM `'.$table.'`');
            $fields_amount=$result->field_count;
            $rows_num = $this->dbConnection->affected_rows;
            $res = $this->query('SHOW CREATE TABLE '.$table);
            $TableMLine=$res->fetch_row();
            $content .= "\n\n".$TableMLine[1].";\n\n";
            $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter=0) {
                while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )	{
                        $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++){
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                        if (isset($row[$j])){
                            $content .= '"'.$row[$j].'"' ;
                        }
                        else {
                            $content .= '""';
                        }
                        if ($j<($fields_amount-1)){
                            $content.= ',';
                        }
                    }
                    $content .=")";
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {
                        $content .= ";";
                    }
                    else {
                        $content .= ",";
                    }
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n
        /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n
        /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        ob_get_clean();
        return $content;
    }

    function clearDatabase() {
        $queryTables = $this->query('SHOW TABLES');
        while($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }
        $result = true;
        foreach($target_tables as $table) {
            if (empty($table)) {
                continue;
            }
            $result  &= $this->query("TRUNCATE TABLE ".$table);
        }
        $result &= $this->query("INSERT INTO user VALUES('1','root','\$2y\$10\$HfsIQLrn1/KrFYVXfksUseXVY1Si2F8Sz7TYFYwxOQcM.GtV9fBUm','-','-','root','0')" );
        return $result;
    }



//    USERS

    public function isUserCorrect($userName) {

        $sql = sprintf("SELECT * FROM user WHERE login='%s'",$this->sanitize($userName) );
        if( $result = $this->query($sql) ) {
            $isCorrect =  $result->num_rows > 0;
            $result->free();
            return $isCorrect;
        }
        return false;
    }

    public function isPasswordCorrect($userName, $password) {

        $sql = sprintf("SELECT * FROM user WHERE login='%s'",$this->sanitize($userName));
        if( ($result = $this->query($sql)) && $result->num_rows>0 ) {
            $dbRow =  $result->fetch_assoc();
            $result->free();
            if ( password_verify($password,$dbRow["password"]) ) {
                return true;
            }
        }
        return false;
    }

    public function getUserByLogin($login) {
        $sql = sprintf("SELECT * FROM user WHERE login='%s'",$this->sanitize($login) );
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $user = $result->fetch_assoc();
            $result->free();
            return new User($user["id"],$user["login"],$user["password"],$user["name"],$user["surname"],$user["account_type"],$user["blocked"]);
        }
        return null;
    }

    public function getUserById($id) {
        $sql = sprintf("SELECT * FROM user WHERE id='%s'",$this->sanitize($id) );
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $user = $result->fetch_assoc();
            $result->free();
            return new User($user["id"],$user["login"],$user["password"],$user["name"],$user["surname"],$user["account_type"],$user["blocked"]);
        }
        return null;
    }

    public function removeUser($userId) {
        $sql1 = sprintf("DELETE FROM report WHERE user_id='%s'",$this->sanitize($userId) );
        $sql2 = sprintf("DELETE FROM user WHERE id='%s'",$this->sanitize($userId) );
        return $this->query($sql1) && $this->query($sql2);
    }

    public function setUserBlocked($userId,$blocked) {
            $sql = sprintf("UPDATE user SET blocked='%s' WHERE id='%s'", $this->sanitize($blocked),$this->sanitize($userId));
        return $this->query($sql);
    }

    public function updateUser($userId,$name,$surname,$password, $accountType) {
        if( strlen($password) >=3 ) {
            $sql = sprintf("UPDATE user SET name='%s', surname='%s', account_type='%s', password='%s' WHERE id='%s'",
                $this->sanitize($name),$this->sanitize($surname),$this->sanitize($accountType),password_hash($this->sanitize($password),PASSWORD_DEFAULT),$this->sanitize($userId) );
        }
        else {
            $sql = sprintf("UPDATE user SET name='%s', surname='%s', account_type='%s' WHERE id='%s'",
                $this->sanitize($name),$this->sanitize($surname),$this->sanitize($accountType),$this->sanitize($userId) );
        }

        return $this->query($sql);
    }

    public function addUser($login,$name,$surname,$password, $accountType) {
        $sql = sprintf("INSERT INTO user (login,name,surname,password,account_type) VALUES ('%s','%s','%s','%s','%s')",
            $this->sanitize($login),$this->sanitize($name),$this->sanitize($surname),password_hash($this->sanitize($password),PASSWORD_DEFAULT),$this->sanitize($accountType) );
        return $this->query($sql);
    }

    public function getUsers() {
        $sql = "SELECT * FROM user ORDER BY surname,name ASC";
        if( $result = $this->query($sql) ) {
            $users = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $usersList = [];
            foreach ($users as $user) {
                $usersList[] = new User($user["id"], $user["login"], $user["password"], $user["name"], $user["surname"], $user["account_type"],$user["blocked"]);
            }
            return $usersList;
        }
        return null;
    }

//    REPORTS

    public function getReports($forUser, $date=null) {
        if($date==null) {
            $sql = sprintf("SELECT * FROM report WHERE user_id='%s' ORDER BY id", $forUser->getId());
        }
        else {
            $sql = sprintf("SELECT * FROM report WHERE user_id='%s' AND date='%s' ORDER BY id", $forUser->getId(), $date);
        }
        if( $result = $this->query($sql) ) {
            $reports = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $reportsObject = [];
            foreach( $reports as $reportRow ) {
                $reportsObject[] = new Report($reportRow["id"],
                    $reportRow["user_id"],$reportRow["project_id"],$reportRow["customer_id"],
                    $reportRow["date"],$reportRow["time_hours"],$reportRow["description"]);
            }
            return $reportsObject;
        }
        return null;
    }

    public function getReportsWithFilter($dateStart=null, $dateEnd=null, $customerId=null, $projectId=null, $userId=null ) {
        $sql = "SELECT 
                report.id as id,
                CONCAT( user.name,' ',user.surname,' (',user.login,')' ) as user,
                user.id as userId,
                CONCAT(customer.name,', ',customer.address) as customer,
                customer.id as customerId,
                CONCAT(project.name,' (',project.description,')') as project,
                project.id as projectId,
                report.time_hours as time,
                report.date as date
                FROM report 
                JOIN user ON report.user_id=user.id
                JOIN project ON report.project_id=project.id
                JOIN customer ON report.customer_id=customer.id";
        $needConcatenation = false;

        //date
        if( $dateStart!=null && $dateEnd!=null ) {
            $sql .= sprintf(" WHERE (report.date BETWEEN '%s' AND '%s')",$dateStart,$dateEnd);
            $needConcatenation = true;
        }
        else if ( $dateStart!=null || $dateEnd!=null ) {
            $sql .= sprintf(" WHERE report.date='%s'",$dateStart!=null ? $dateStart : $dateEnd);
            $needConcatenation = true;
        }

        //customerId
        if($customerId!=null) {
            if($needConcatenation) {
                $sql .= " AND ";
            }
            else{
                $sql .= " WHERE ";
                $needConcatenation = true;
            }
            $sql .= sprintf("report.customer_id=%s",$customerId);
        }

        //projectId
        if($projectId!=null) {
            if($needConcatenation) {
                $sql .= " AND ";
            }
            else{
                $sql .= " WHERE ";
                $needConcatenation = true;
            }
            $sql .= sprintf("project.id=%s",$projectId);
        }

        //userId
        if($userId!=null) {
            if($needConcatenation) {
                $sql .= " AND ";
            }
            else{
                $sql .= " WHERE ";
            }
            $sql .= sprintf("user.id=%s",$userId);
        }

        if( $result = $this->query($sql) ) {
            $reports = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $reportsObject = [];
            $reportsSumTime = 0.0;
            foreach( $reports as $reportRow ) {
                $reportsObject[] = new FilteredReport($reportRow["id"],
                    $reportRow["user"],$reportRow["userId"],
                    $reportRow["customer"],$reportRow["customerId"],
                    $reportRow["project"],$reportRow["projectId"],
                    $reportRow["time"],$reportRow["date"] );
                $reportsSumTime+=$reportRow["time"];
            }
            return [$reportsObject,$reportsSumTime];
        }
        return null;
    }

    public function addReport($userId, $projectId, $customerId, $time, $description) {
        $sql = sprintf("INSERT INTO report (user_id,project_id,customer_id,date,time_hours,description) VALUES ('%d','%d','%d','%s','%f','%s')",
            $userId,$projectId, $customerId, date('Y-m-d'),$time, $description);
        return $this->query($sql);
    }

    public function removeReport($reportId) {
        $sql = sprintf("DELETE FROM report WHERE id='%s'", $reportId );
        return $this->query($sql);
    }

    public function getReportWithId($reportId) {
        $sql = sprintf("SELECT * FROM report WHERE id='%s'", $reportId );
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $report = $result->fetch_assoc();
            $result->free();
            $reportObject = new Report($report["id"],
                $report["user_id"],$report["project_id"],$report["customer_id"],
                $report["date"],$report["time_hours"],$report["description"]);
            return $reportObject;
        }
        return null;
    }

    public function updateReport($reportId,$userId, $projectId, $customerId, $date, $time, $description) {
        $sql = sprintf("UPDATE report SET user_id='%d',project_id='%d', customer_id='%d', date='%s',time_hours='%f',description='%s' WHERE id='%s'", $userId,$projectId, $customerId, $date,$time, $description, $reportId );
        return $this->query($sql);
    }

//    CUSTOMERS

    public function getCustomers($withBlocked=false) {
        if( $withBlocked ) {
            $sql ="SELECT * FROM customer ORDER BY name ASC";
        }
        else {
            $sql ="SELECT * FROM customer WHERE blocked=false ORDER BY name ASC";
        }
        if( $result = $this->query($sql) ) {
            $customers = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $customersObject = [];
            foreach( $customers as $customerRow ) {
                $customersObject[] = new Customer($customerRow["id"], $customerRow["name"],$customerRow["address"],$customerRow["blocked"] );
            }
            return $customersObject;
        }
        return null;
    }

    public function getCustomerByAddress($address) {
        $sql = sprintf("SELECT * FROM customer WHERE address='%s'",$address);
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $customer = $result->fetch_assoc();
            $result->free();
            $customerObject = new Customer($customer["id"], $customer["name"],$customer["address"],$customer["blocked"] );
            return $customerObject;
        }
        return null;
    }

    public function getCustomerById($id) {
        $sql = sprintf("SELECT * FROM customer WHERE id='%s'",$id);
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $customer = $result->fetch_assoc();
            $result->free();
            $customerObject = new Customer($customer["id"], $customer["name"],$customer["address"],$customer["blocked"] );
            return $customerObject;
        }
        return null;
    }

    public function removeCustomer($customerId) {
        $sql1 = sprintf("DELETE FROM project WHERE customer_id='%s'", $customerId );
        $sql2 = sprintf("DELETE FROM customer WHERE id='%s'", $customerId );
        return $this->query($sql1) & $this->query($sql2);
    }

    public function updateCustomer($customerId,$name,$address ) {
        $sql = sprintf("UPDATE customer SET name='%s', address='%s' WHERE id='%s'", $name, $address, $customerId );
        return $this->query($sql);
    }

    public function addCustomer($name, $address) {
      $sql = sprintf("INSERT INTO customer (name,address) VALUES ('%s','%s')",$name, $address);
      return $this->query($sql);
    }

    public function setCustomerBlocked($customerId,$blocked) {
        $sql = sprintf("UPDATE customer SET blocked='%s' WHERE id='%s'", $this->sanitize($blocked),$this->sanitize($customerId));
        return $this->query($sql);
    }

//    PROJECTS

    public function getProjectsForCustomerId($forCustomerId, $withBlocked=true) {

        if( $withBlocked ) {
            $sql = sprintf("SELECT * FROM project WHERE customer_id=%s OR ISNULL(customer_id) ORDER BY name ASC", $forCustomerId);
        }
        else {
            $sql = sprintf("SELECT * FROM project WHERE customer_id=%s OR ISNULL(customer_id) AND blocked=false ORDER BY name ASC", $forCustomerId);
        }

        if( $result = $this->query($sql) ) {
            $projects = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $projectsObject = [];
            foreach( $projects as $projectRow ) {
                $projectsObject[] = new Project($projectRow["id"], $projectRow["customer_id"],$projectRow["name"],$projectRow["description"],$projectRow["blocked"] );
            }
            return $projectsObject;
        }
        return null;
    }

    public function getProjects($withBlocked=false) {
        if( $withBlocked ) {
            $sql = "SELECT * FROM project ORDER BY name ASC";
        }
        else {
            $sql = "SELECT * FROM project WHERE blocked=false ORDER BY name ASC";
        }
        if( $result = $this->query($sql) ) {
            $projects = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $projectsObject = [];
            foreach( $projects as $projectRow ) {
                $projectsObject[] = new Project($projectRow["id"], $projectRow["customer_id"],$projectRow["name"],$projectRow["description"],$projectRow["blocked"] );
            }
            return $projectsObject;
        }
        return null;
    }

    public function getProjectById($id) {
        $sql = sprintf("SELECT * FROM project WHERE id='%s'",$id);
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $project = $result->fetch_assoc();
            $result->free();
            $projectObject = new Project($project["id"],$project["customer_id"], $project["name"],$project["description"],$project["blocked"] );
            return $projectObject;
        }
        return null;
    }

    public function removeProject($projectId) {
        $sql1 = sprintf("DELETE FROM report WHERE project_id='%s'", $projectId );
        $sql2 = sprintf("DELETE FROM project WHERE id='%s'", $projectId );
        return $this->query($sql1) & $this->query($sql2);
    }

    public function updateProject( $projectId,$customerId,$name, $description ) {
        $sql = sprintf("UPDATE project SET customer_id=%s, name='%s', description='%s' WHERE id='%s'", $customerId, $name, $description, $projectId );
        return $this->query($sql);
    }

    public function getProjectByCustomerAndName($customerId,$name) {
        $sql = sprintf("SELECT * FROM project WHERE customer_id=%s AND name='%s'",$customerId,$name);
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $project = $result->fetch_assoc();
            $result->free();
            $projectObject = new Project($project["id"], $project["customer_id"],$project["name"],$project["description"],$project["blocked"] );
            return $projectObject;
        }
        return null;
    }

    public function addProject( $customerId,$name,$description ) {
        $sql = sprintf("INSERT INTO project (customer_id,name,description) VALUES (%s,'%s','%s')",$customerId,$name,$description);
        echo $sql;
        return $this->query($sql);
    }

    public function setProjectBlocked($projectId,$blocked) {
        $sql = sprintf("UPDATE project SET blocked='%s' WHERE id='%s'", $this->sanitize($blocked),$this->sanitize($projectId));
        return $this->query($sql);
    }


//    REPORTS AFFIRMATION

    public function setReportAffirmation($userId) {
        $sql = sprintf("INSERT INTO report_affirmation (user_id,date) VALUES ('%s',CURDATE() )",$this->sanitize($userId) );
        return $this->query($sql);
    }

    public function getTodayAffirmation($userId) {
        $sql = sprintf("SELECT * FROM report_affirmation WHERE user_id='%s' AND date=CURDATE()",$this->sanitize($userId) );
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $affirmation = $result->fetch_assoc();
            $result->free();
            $affirmationObject = new ReportAffirmation($affirmation["id"], $affirmation["user_id"],$affirmation["date"],$affirmation["vacation"] );
            return $affirmationObject;
        }
        return null;
    }

    public function updateReportAffirmation($userId, $date, $setAffirmed) {
        if ($setAffirmed) {
            $sql = sprintf("INSERT INTO report_affirmation (user_id,date) VALUES ('%s','%s')",$this->sanitize($userId),$this->sanitize($date) );
            return $this->query($sql);
        }
        else {
            $sql = sprintf("DELETE FROM report_affirmation WHERE user_id='%s' AND date='%s'",$this->sanitize($userId),$this->sanitize($date) );
            return $this->query($sql);
        }
    }

//date format: 2017-09-24
    public function getClosedReportAffirmationForDate($date, $withBlocked = false) {
        if( $withBlocked ) {
            $sql = sprintf("SELECT user.id as id, CONCAT( user.name,' ',user.surname,' (',user.login,')' ) as user, IFNULL(SUM(report.time_hours),0) as time, user.blocked as blocked, report_affirmation.vacation as vacation
                              FROM report_affirmation
                               JOIN user ON report_affirmation.user_id=user.id
                                LEFT JOIN report ON (user.id=report.user_id AND report_affirmation.date=report.date)
                                WHERE report_affirmation.date='%s' AND user.account_type!='root'
								GROUP BY user                             
                                ", $this->sanitize($date));
        }
        else {
            $sql = sprintf("SELECT user.id as id, CONCAT( user.name,' ',user.surname,' (',user.login,')' ) as user, IFNULL(SUM(report.time_hours),0) as time, user.blocked as blocked, report_affirmation.vacation as vacation 
                              FROM report_affirmation
                               JOIN user ON report_affirmation.user_id=user.id
                                LEFT JOIN report ON (user.id=report.user_id AND report_affirmation.date=report.date)
                                WHERE report_affirmation.date='%s' AND user.blocked=false AND user.account_type!='root'
								GROUP BY user                             
                                ", $this->sanitize($date));
        }
        if( $result = $this->query($sql) ) {
            $affirmations = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $affirmationObject = [];
            foreach( $affirmations as $affirmationRow ) {
                $affirmationObject[] = new FilteredReportAffirmation($affirmationRow["id"], $affirmationRow["user"],$affirmationRow["blocked"], $affirmationRow["time"], $affirmationRow["vacation"] );
            }
            return $affirmationObject;
        }
        return null;
    }

    public function getOpenedReportAffirmationForDate($date, $withBlocked = false) {
        if( $withBlocked ) {
            $sql = sprintf("SELECT user.id as id, CONCAT( user.name,' ',user.surname,' (',user.login,')' ) as user, IFNULL(SUM(report.time_hours),0) as time, user.blocked as blocked 
                              FROM user
                               LEFT JOIN report_affirmation ON (user.id=report_affirmation.user_id AND report_affirmation.date='%s')
                               LEFT JOIN report ON (user.id=report.user_id AND report.date='%s')
                               WHERE ISNULL(report_affirmation.id) AND user.account_type!='root'
                               GROUP BY user
                               ", $this->sanitize($date), $this->sanitize($date));
        }
        else {
            $sql = sprintf("SELECT user.id as id, CONCAT( user.name,' ',user.surname,' (',user.login,')' ) as user, IFNULL(SUM(report.time_hours),0) as time, user.blocked as blocked 
                              FROM user
                               LEFT JOIN report_affirmation ON (user.id=report_affirmation.user_id AND report_affirmation.date='%s')
                               LEFT JOIN report ON (user.id=report.user_id AND report.date='%s')
                               WHERE ISNULL(report_affirmation.id) AND user.blocked=false AND user.account_type!='root'
                               GROUP BY user
                               ", $this->sanitize($date), $this->sanitize($date));
        }
        if( $result = $this->query($sql) ) {
            $affirmations = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $affirmationObject = [];
            foreach( $affirmations as $affirmationRow ) {
                $affirmationObject[] = new FilteredReportAffirmation($affirmationRow["id"], $affirmationRow["user"],$affirmationRow["blocked"],  $affirmationRow["time"], false );
            }
            return $affirmationObject;
        }
        return null;
    }

//    VACATIONS

    public function setVacationDay($userId,$date) {
        $sql = sprintf("SELECT id,vacation FROM report_affirmation WHERE user_id='%d' AND date='%s'",$this->sanitize($userId),$this->sanitize($date) );
        $result = $this->query($sql);
        if( $result && $result->num_rows>0 ) {
            $affirmation = $result->fetch_assoc();
            $result->free();
            if( !$affirmation["vacation"] ) {
                $sql = sprintf("UPDATE report_affirmation SET vacation=TRUE WHERE id='%d'",$affirmation["id"] );
                return $this->query($sql);
            }
            return true;
        }

        $sql = sprintf("INSERT INTO report_affirmation (user_id,date,vacation) VALUES ('%s','%s',TRUE)",$this->sanitize($userId),$this->sanitize($date) );
        return $this->query($sql);
    }

    public function getNextVacationsDay($userId, $all=false) {
        if( $all ) {
            $sql = sprintf("SELECT * FROM report_affirmation WHERE user_id='%d' AND vacation=TRUE ORDER BY date ASC",$userId);
        }
        else {
            $sql = sprintf("SELECT * FROM report_affirmation WHERE user_id='%d' AND vacation=TRUE AND DATE>=CURDATE() ORDER BY date ASC", $userId);
        }
        if( $result = $this->query($sql) ) {
            $affirmations = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $affirmationDates = [];
            foreach( $affirmations as $affirmationRow ) {
                $affirmationDates[] = $affirmationRow["date"];
            }
            return $affirmationDates;
        }
        return null;
    }

}