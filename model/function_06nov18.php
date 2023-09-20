<?php
class functions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
        $this->leadGenChannel = "";
        if($_SESSION['role_id']!=1){
            if($_SESSION['domain']=="IARC"){
                $this->leadGenChannel = "1,2,5";
            }elseif($_SESSION['domain']=="MIR"){
                $this->leadGenChannel = "3,4";
            }elseif($_SESSION['domain']=="ALL"){
                $this->leadGenChannel = "1,2,3,4,5";
            }
        }
        //echo $this->leadGenChannel;
        //exit;
    }

    function employeeLogin($user, $password)
    {
        $pass = md5($password);
        $loginQuery = "select * from employees where (email='$user' or username='$user') and status=1";
        $getLoginDetails = $this->dbObject->getRow($loginQuery);
        if ($getLoginDetails) {
            if ($getLoginDetails['password'] == $pass) {
                $roleData = $this->getEmployeeRoleByRoleId($getLoginDetails['role_id']);
                $teamData = $this->getEmployeeTeamByTeamId($getLoginDetails['team_id']);
                $departmentData = $this->getEmployeeDepartmentsByDepartmentIds($getLoginDetails['department_ids']);
                $_SESSION['employee_id'] = $getLoginDetails['employee_id'];
                $_SESSION['name'] = $getLoginDetails['firstname'] . " " . $getLoginDetails['lastname'];
                $_SESSION['email'] = $getLoginDetails['email'];
                $_SESSION['username'] = $getLoginDetails['username'];
                $_SESSION['domain'] = $getLoginDetails['domain'];
                $_SESSION['manager_id'] = $getLoginDetails['manager_id'];
                $_SESSION['role_id'] = $getLoginDetails['role_id'];
                $_SESSION['role'] = $roleData['role'];
                $_SESSION['team_id'] = $getLoginDetails['team_id'];
                $_SESSION['team'] = $teamData['team'];
                $_SESSION['departments'] = $departmentData;
                $_SESSION['mail_password'] = $getLoginDetails['mail_password'];
                $getLoginDetails['login'] = "Success";
                $getLoginDetails['loginstatus'] = "Success";
            } else {
                $getLoginDetails['login'] = "Failed";
                $getLoginDetails['loginstatus'] = "Invalid Password";
            }
        } else {
            $getLoginDetails['login'] = "Failed";
            $getLoginDetails['loginstatus'] = "User not exist";
        }
        return $getLoginDetails;
    }

    function checkEmployee($user)
    {
        $loginQuery = "select * from employees where (email='$user' or username='$user') and status=1";
        $getLoginDetails = $this->dbObject->getRow($loginQuery);
        return $getLoginDetails;
    }

    function getEmployeeRoleByRoleId($roleId)
    {
        $whr = array('role_id' => $roleId);
        $roleQuery = $this->dbObject->selectQuery('roles', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }

    function getEmployeeTeamByTeamId($teamId)
    {
        $whr = array('id' => $teamId);
        $roleQuery = $this->dbObject->selectQuery('teams', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }

    function getEmployeeDepartmentsByDepartmentIds($depIds)
    {
        $roleQuery = "select * from departments where department_id in ($depIds)";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getCountries()
    {
        $roleQuery = "SELECT DISTINCT(`name`) AS country FROM country";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getCountriesByLeadCount()
    {
        $roleQuery = "SELECT country,COUNT(*) AS tot FROM leads GROUP BY country ORDER BY tot DESC";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getlatestPendingLeads()
    {
        $roleQuery = "SELECT * FROM leads WHERE `status`= 0 ORDER BY id DESC LIMIT 10";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getEmployeeLists()
    {
        $roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, 'employee_id', 'DESC', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        $empData = array();
        $i = 0;
        foreach ($result as $row) {
            $empData[$i]['name'] = $row['firstname'] . " " . $row['lastname'];
            $empData[$i]['email'] = $row['email'];
            $empData[$i]['employee_id'] = $row['employee_id'];
            $empData[$i]['username'] = $row['username'];
            $empData[$i]['mobile'] = $row['mobile'];
            $empData[$i]['status'] = $row['status'];
			$empData[$i]['domain'] = $row['domain'];
            $roleData = $this->getEmployeeRoleByRoleId($row['role_id']);
            $teamData = $this->getEmployeeTeamByTeamId($row['team_id']);
            $empData[$i]['role'] = $roleData['role'];
            $empData[$i]['team'] = $teamData['team'];
            $i++;
        }
        return $empData;
    }

    function getLeadStages()
    {
        $roleQuery = $this->dbObject->selectQuery('lead_stages', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getRoleLists()
    {
        $roleQuery = $this->dbObject->selectQuery('roles', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getTeamLists()
    {
        $roleQuery = $this->dbObject->selectQuery('teams', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getAllTasks()
    {
        $roleQuery = $this->dbObject->selectQuery('tasks', '*', '', '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getleadbyId($leadId)
    {
        $whr = array('id' => $leadId);
        $roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getleadbyFilter($whr)
    {
        $roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getInvoiceById($invoiceid)
    {
        $whr = array('id' => $invoiceid);
        $roleQuery = $this->dbObject->selectQuery('invoices', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }

    function getEmployeeListsByRoleId($roleId)
    {
        $whr = array('role_id' => $roleId);
        $roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getEmployeeByEmpId($empId)
    {
        $whr = array('employee_id' => $empId);
        $roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }

    function getEmployeebyManagerId($managerId)
    {
        $whr = array('manager_id' => $managerId, 'role_id' => 4);
        $roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getDepartmentLists()
    {
        $roleQuery = $this->dbObject->selectQuery('departments', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getGenerationChannels(){
        $roleQuery = $this->dbObject->selectQuery('generation_channel', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getDepartmentByDepartmentId($dId)
    {
        $whr = array('department_id' => $dId);
        $roleQuery = $this->dbObject->selectQuery('departments', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }

    function getNotesbyLeadId($leadid)
    {
        $whr = array('lead_id' => $leadid);
        $roleQuery = $this->dbObject->selectQuery('notes', '*', $whr, 'id', 'DESC', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getUpdatedvaluesbyleadId($leadid)
    {
        $whr = array('lead_id' => $leadid);
        $roleQuery = $this->dbObject->selectQuery('lead_updates', '*', $whr, 'id', 'DESC', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getSalesManager()
    {
       // $whr = array('role_id' => 3, 'team_id' => 2);
        //$roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
        $domain=$_SESSION['domain'];
        //$roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and domain = '$domain'";
		$roleQuery="select * from employees where role_id in (3,4) and team_id = 2";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getTasksbByassignById($assign_by_id)
    {
        $whr = array('assigned_by_id' => $assign_by_id);
        $roleQuery = $this->dbObject->selectQuery('tasks', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getTasksByStatusAndId($assign_by_id, $status)
    {
        $whr = array('assigned_by_id' => $assign_by_id, 'status' => $status);
        $roleQuery = $this->dbObject->selectQuery('tasks', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function getTasksbByassignToId($assign_to_id)
    {
        $whr = array('assigned_to_id' => $assign_to_id);
        $roleQuery = $this->dbObject->selectQuery('tasks', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function insertEmployee($data)
    {
        $table = "employees";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function insertDepartment($data)
    {
        $table = "departments";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function insertTeam($data)
    {
        $table = "teams";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function insertLeads($data)
    {
        $table = "leads";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function insertNotes($data)
    {
        $table = "notes";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function insertTasks($data)
    {
        $table = "tasks";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function InsertInvoice($data)
    {
        $table = "invoices";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function logout()
    {
        session_destroy();
    }
    function  updateEmployeeById($empid,$data){
        $table_name = "employees";
        $search_by = array('employee_id' => $empid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }
    function updateInvoiceById($invoiceId, $data)
    {
        $table_name = "invoices";
        $search_by = array('id' => $invoiceId);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }

    function updateAdminDetailsByAdminId($adminId, $data)
    {
        $table_name = "admin";
        $search_by = array('id' => $adminId);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }

    function updateLeadDetailsByLeadId($leadId, $data)
    {
        $table_name = "leads";
        $search_by = array('id' => $leadId);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }

    function updateTaskById($taskid, $data)
    {
        $table_name = "tasks";
        $search_by = array('id' => $taskid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }
    function deleteAdminUser($adminId)
    {
        $value = array('id' => $adminId);
        $table_name = "admin";
        $status = $this->dbObject->delete($table_name, $value);
        return $status;
    }

    function insertLeadUpdates($data)
    {
        $table = "lead_updates";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function reArrayFiles(&$file_post)
    {
        $file_ary = array();
        $file_count = count($file_post);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }
    function getCountOfAllLeads(){
        $roleQuery ="Select count(*) as count from leads";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getCountOfPendingLeads(){
        $roleQuery ="Select count(*) as count from leads where status = 0";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getCountOfAssignLeads(){
        $roleQuery ="Select count(*) as count from leads where associated_id != 0";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getCountOfApproveLeads(){
        $roleQuery ="Select count(*) as count from leads where status = 1";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getCountOfRejectLeads(){
        $roleQuery ="Select count(*) as count from leads where status = 2";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
 /* ----------------------  email sending--------------------------------*/
    function smtpMail($to,$subject,$message){
        require_once('../PHPMailer/class.phpmailer.php');
        $m_user="salesiarc123@gmail.com";
        $m_pass="iarc@123";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $m_user;
        $mail->Password = $m_pass;
        $mail->SetFrom($m_user, "CRM-Portal");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        $mail->Send();
    }
    function getToassignedmanageremail($assignedid){
        $roleQuery="select * from employees where employee_id = $assignedid";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
 /*-------------------------pagination and leads filter functions ----------------------------------------------*/
    public function getnumSearchRecords($limit)
    {
        if($this->leadGenChannel==""){
            $query="Select count(*) as tot from leads";
        }else{
            $query="select count(*) as tot from leads where lead_generation_channel_id in ($this->leadGenChannel)";
        }
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    public function getAllleadsPagination($page,$recordsperpage)
    {
        if($this->leadGenChannel==""){
            $query="select * from leads order by id desc ";
        }else{
            $query="select * from leads where lead_generation_channel_id in ($this->leadGenChannel) order by id desc ";
        }
        $srt= $page-1;
        $startIndex = $srt*$recordsperpage;
        $maxLimit = $recordsperpage;
        $condition="LIMIT ".$startIndex.", ".$maxLimit;
        $query=$query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getAllleads()
    {
        if($this->leadGenChannel==""){
            $roleQuery = $this->dbObject->selectQuery('leads', '*', '', 'id', 'desc', '', '');
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        //echo $roleQuery;
        return $result;
    }
    function getLeadsByStatus($status)
    {
        if($this->leadGenChannel==""){
            $roleQuery="select * from leads where status = $status";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND status = $status";
        }
        //$whr = array('status' => $status);
        //$roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getLeadsByLeadStages($stage){
        if($this->leadGenChannel==""){
            $roleQuery="select * from leads where lead_stage_id = $stage";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND lead_stage_id = $stage";
        }
        //$whr = array('status' => $status);
        //$roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getLeadByNameOrEmail($name)
    {
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT * FROM leads WHERE (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') order by id desc";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    /*----------- contact lists filters functions End-------------------*/
    function getmyLeadByNameOrEmail($empId,$myname)
    {
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT * FROM leads WHERE associated_id = $empId AND 
            (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') order by id desc";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel)
              AND associated_id = $empId AND (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    public  function getnumSearchRecordsOfMyLeads($empId,$limit)
    {
        if($this->leadGenChannel=="") {
            $roleQuery ="Select count(*) as tot from leads where associated_id = $empId";
        }else {
            $roleQuery ="Select count(*) as tot from leads where lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId";
        }
            $result = $this->dbObject->getRow($roleQuery);
            $total_pages = ceil($result['tot'] / $limit);
            return $total_pages;
    }
    public function getMyLeadsPagination($empId,$page,$recordsperpage)
    {
        if($this->leadGenChannel=="") {
            $query = "select * from leads where associated_id = $empId  order by id desc ";
        }else{
            $query = "select * from leads where lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId  order by id desc ";
        }
        $srt= $page-1;
        $startIndex = $srt*$recordsperpage;
        $maxLimit = $recordsperpage;
        $condition="LIMIT ".$startIndex.", ".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    /*----------- My contact  filters functions End-------------------*/
    function getCountOfPendingContactsByName($empId,$search_pending,$limit){
        if($this->leadGenChannel=="") {
        $query = "SELECT count(*) as tot FROM leads WHERE seo_associated_id = $empId  AND status = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%')";
        }else{
            $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId  AND status = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%')";
        }
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    function getLeadBySeoIdPendingPagination($empId,$search_pending,$page,$limit)
    {
        if($this->leadGenChannel=="") {
            $query = "SELECT * FROM leads WHERE seo_associated_id = $empId  AND status = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%') order by id desc ";
        }else{
            $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId  AND status = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%') order by id desc ";
        }
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $condition="LIMIT ".$startIndex.", ".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    public  function getnumSearchRecordsPending($empId,$limit)
    {
        if($this->leadGenChannel=="") {
            $roleQuery = "Select count(*) as tot from leads where seo_associated_id = $empId AND status = 0";
        }else{
            $roleQuery = "Select count(*) as tot from leads where lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId AND status = 0";
        }
        $result = $this->dbObject->getRow($roleQuery);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    public function getAllleadsPendingPagination($empId,$page,$recordsperpage){
         if($this->leadGenChannel=="") {
             $query = "select * from leads where seo_associated_id = $empId AND status = 0  order by id desc ";
         }else{
             $query = "select * from leads where lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId AND status = 0  order by id desc ";
         }
        $srt= $page-1;
        $startIndex = $srt*$recordsperpage;
        $maxLimit = $recordsperpage;
        $condition="LIMIT ".$startIndex.", ".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
 /*----------- pending contacts filters functions End-------------------*/
    function getSearchData($data)
    {
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {

            //$condition.="AND created LIKE '%".$data['created']."%' ";
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }

        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) ";
            }
        }
        $query=$query.$condition." order by created DESC";
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getSearchDataInMyContacts($empId,$data){

        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {

            //$condition.="AND created LIKE '%".$data['created']."%' ";
			$condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE associated_id = $empId AND ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE associated_id = $empId ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId  ";
            }
        }
        $query=$query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
 /*------------------------- call logs functions ----------------------------------------------*/

    function insertCallLogs($data)
    {
        $table = "call_logs";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }

    function getCallLogsByLeadId($leadid)
    {
        $whr = array('lead_id' => $leadid);
        $roleQuery = $this->dbObject->selectQuery('call_logs', '*', $whr, 'id', 'DESC', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

    function updateCallLogsByCallSId($callSID, $data)
    {
        $table_name = "call_logs";
        $search_by = array('call_sid' => $callSID);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }

    /*-------------------------pagination and leads filter functions ----------------------------------------------*/
    public function getLeadsbyFromAndToDate($fromdate,$todate){
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT * FROM leads WHERE (created BETWEEN '$fromdate' AND '$todate') order by created DESC";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (created BETWEEN '$fromdate' AND '$todate') order by created DESC";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    public function getTasksbyFromAndToDate($fromdate,$todate){
        $roleQuery = "SELECT * FROM tasks WHERE (created BETWEEN '$fromdate' AND '$todate')";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    public function getInvoicebyFromAndToDate($fromdate,$todate){
        $roleQuery = "SELECT * FROM invoices WHERE (created BETWEEN '$fromdate' AND '$todate')";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getLeadsbyAssociateId($associateId){
        $whr = array('associated_id' => $associateId);
        $roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getLeadsbyAssociateIdByLimit($associateId){
        $whr = array('associated_id' => $associateId);
        $roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, 'id', 'DESC', '', '5');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getLeadsbyAssociateIdCount($associateId){
        $whr = array('associated_id' => $associateId);
        $roleQuery = $this->dbObject->selectQuery('leads', 'COUNT(*) as count', $whr, 'id', 'DESC', '', '5');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }

    function deleteLeadsByIds($ids){
        $roleQuery ="DELETE from leads WHERE id IN ($ids)";
        $status = $this->dbObject->execute($roleQuery);
        return $status;
    }
	
	function UpdateEployeeStatus($empid,$data){
		$table_name = "employees";
		$search_by = array('employee_id' => $empid);
		$status = $this->dbObject->update($table_name, $data, $search_by);
		return $status;
	}
	
	function getAllleadsHaveFollowupDates(){
		if($this->leadGenChannel==""){
			$roleQuery = "SELECT * FROM leads WHERE next_followup_date<>'0000-00-00 00:00:00' AND next_followup_date IS NOT NULL order by id desc";
		}else{
			$roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) and next_followup_date<>'0000-00-00 00:00:00' AND next_followup_date IS NOT NULL order by id desc";
		}
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
    /*------------------------- my leads and filter pagination functions ----------------------------------------------*/

    function getnumSearchRecordsOfMyLeadsByMyName($empId,$myname,$limit){
        if($this->leadGenChannel=="") {
            $roleQuery ="Select count(*) as tot from leads where associated_id = $empId AND 
            (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') ";
        }else {
            $roleQuery ="Select count(*) as tot from leads where lead_generation_channel_id 
            in ($this->leadGenChannel) AND associated_id = $empId AND (fname LIKE '%{$myname}%' 
            OR email LIKE '%{$myname}%')";
        }
        $result = $this->dbObject->getRow($roleQuery);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    function getmyLeadsByNamePagination($empId,$myname,$page,$limit){
        if($this->leadGenChannel=="") {
            $query = "select * from leads where associated_id = $empId  AND 
            (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') order by id desc ";
        }else{
            $query = "select * from leads where lead_generation_channel_id in ($this->leadGenChannel)
            AND associated_id = $empId  AND (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') 
            order by id desc ";
        }
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $condition="LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getCountOfSearchDataInMyContacts($empId,$data,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['created'] !="") {
            //  $condition.="AND created LIKE '%".$data['created']."%' ";
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }

        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads WHERE associated_id = $empId AND ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads WHERE associated_id = $empId ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId  ";
            }
        }
        $query=$query.$condition;
        // $result = $this->dbObject->getAllRows($query);
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
        //return $result;
    }
    function getSearchDataInMyContactsPagination($empId,$data,$page,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {
            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['created'] !="") {
            //  $condition.="AND created LIKE '%".$data['created']."%' ";
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE associated_id = $empId AND ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE associated_id = $empId ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId  ";
            }
        }
        $query=$query.$condition." order by id desc ";
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $countlimit="LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$countlimit;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }

    /*------------------------- all leads and filter pagination functions ----------------------------------------------*/
    function getnumSearchRecordsOfAllLeadsByName($name,$limit){
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT count(*) as tot from leads WHERE (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') order by id desc";
        }else{
            $roleQuery = "SELECT count(*) as tot from leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') order by id desc";
        }
        $result = $this->dbObject->getRow($roleQuery);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    function getAllLeadsByNamePagination($name,$page,$limit){
        if($this->leadGenChannel==""){
            $query = "SELECT * FROM leads WHERE (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') order by id desc ";
        }else{
            $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') order by id desc ";
        }
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $condition="LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getCountOfSearchDataInAllContacts($data,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }

        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads WHERE ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) ";
            }
        }
        $query=$query.$condition;
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    function getSearchDataInAllContactsPagination($data,$page,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = '$channel' ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }

        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE ";
            }else{
				if ($data['lead_generation_channel_id'] !="") {
					$query = "SELECT * FROM leads WHERE ";
				}else{
					$query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND ";
				}                
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) ";
            }
        }
        $query=$query.$condition." order by id desc ";
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $countlimit="LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$countlimit;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }

    /*------------------------- all leads and name and filter pagination functions ----------------------------------------------*/
    function getCountOfAllLeadsByNameAndSearchData($data,$name,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }
        if($name){
            $condition.="AND (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads WHERE ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) ";
            }
        }
        $query=$query.$condition;
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    function getAllleadsByNameAndSearchDataPagination($data,$name,$page,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }
        if($name){
            $condition.="AND (fname LIKE '%{$name}%' OR email LIKE '%{$name}%') ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) ";
            }
        }
        $query=$query.$condition." order by id desc ";
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $countlimit="LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$countlimit;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    /*------------------------- my leads and name and filter pagination functions ----------------------------------------------*/
    function getCountOfMyLeadsByNameAndSearchData($empId,$data,$myname,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }
        if($myname){
            $condition.="AND (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads WHERE associated_id = $empId ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT count(*) as tot FROM leads associated_id = $empId ";
            }else{
                $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId ";
            }
        }
        $query=$query.$condition;
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        return $total_pages;
    }
    function getMyleadsByNameAndSearchDataPagination($empId,$data,$myname,$page,$limit){
        $condition = "";
        if ($data['company'] !="") {
            $condition.="AND company LIKE '%".$data['company']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['phone_number'] !="") {

            $condition.="AND phone_number LIKE '%".$data['phone_number']."%' ";
        }
        if ($data['job_title'] !="") {

            $condition.="AND job_title LIKE '%".$data['job_title']."%' ";
        }
        if ($data['report_code'] !="") {

            $condition.="AND report_code LIKE '%".$data['report_code']."%' ";
        }
        if ($data['department'] !="") {

            $condition.="AND department LIKE '%".$data['department']."%' ";
        }
        if ($data['status'] !="") {
            $status=$data['status'];
            $condition.="AND status = $status ";
        }
        if ($data['lead_stage_id'] !="") {
            $stage=$data['lead_stage_id'];
            $condition.="AND lead_stage_id = $stage ";
        }
        if ($data['lead_generation_channel_id'] !="") {
            $channel=$data['lead_generation_channel_id'];
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
        if ($data['next_followup_date'] !="") {

            $condition.="AND next_followup_date LIKE '%".$data['next_followup_date']."%' ";
        }
        if($myname){
            $condition.="AND (fname LIKE '%{$myname}%' OR email LIKE '%{$myname}%') ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads WHERE associated_id = $empId ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId AND ";
            }
        }else{
            if($this->leadGenChannel=="") {
                $query = "SELECT * FROM leads associated_id = $empId ";
            }else{
                $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) associated_id = $empId ";
            }
        }
        $query=$query.$condition." order by id desc ";
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $countlimit="LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$countlimit;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
}
?>
