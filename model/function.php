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
                $this->leadGenChannel = "1,2,5,6";
            }elseif($_SESSION['domain']=="MIR"){
                $this->leadGenChannel = "3,4";
            }elseif($_SESSION['domain']=="ALL"){
                $this->leadGenChannel = "1,2,3,4,5,6";
            }
        }
        //echo $this->leadGenChannel;
        //exit;
    }

    function employeeLogin($user,$password)
    {
        $pass = md5($password);
		//$user = str_replace(['='," OR '1",' '],"",$user);
		/*$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		if (preg_match($regex, $user)) {
			$user = $user;
		} else { 
			$user = "";
		} */
		$email = filter_var($user, FILTER_SANITIZE_EMAIL);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		
		if($email!=''){
			$allowedIP = $this->getAllIpAddress();
			$adminIP = $this->get_client_ip();
			$loginQuery = "select * from employees where email='$user' and status=1";
			$getLoginDetails = $this->dbObject->getRow($loginQuery);
			if ($getLoginDetails) {
				if ($getLoginDetails['password'] == $pass) {
					if($getLoginDetails['role_id']==1 || ($getLoginDetails['role_id']==3 && $getLoginDetails['team_id']==2)){
						$roleData = $this->getEmployeeRoleByRoleId($getLoginDetails['role_id']);
						$teamData = $this->getEmployeeTeamByTeamId($getLoginDetails['team_id']);
						$departmentData = $this->getEmployeeDepartmentsByDepartmentIds($getLoginDetails['department_ids']);
						$_SESSION['employee_id'] = $getLoginDetails['employee_id'];
						$_SESSION['name'] = $getLoginDetails['firstname'] . " " . $getLoginDetails['lastname'];
						$_SESSION['email'] = $getLoginDetails['email'];
						$_SESSION['username'] = $getLoginDetails['username'];
						$_SESSION['domain'] = $getLoginDetails['domain'];
						$_SESSION['manager_id'] = $getLoginDetails['manager_id'];
                        $_SESSION['zoho_ref_token'] = $getLoginDetails['zoho_ref_token'];
						$_SESSION['role_id'] = $getLoginDetails['role_id'];
						$_SESSION['role'] = $roleData['role'];
						$_SESSION['team_id'] = $getLoginDetails['team_id'];
						$_SESSION['team'] = $teamData['team'];
						$_SESSION['departments'] = $departmentData;
						$_SESSION['mail_password'] = $getLoginDetails['mail_password'];
						$getLoginDetails['login'] = "Success";
						$getLoginDetails['loginstatus'] = "Success";
					}else{
						//if(in_array($adminIP,$allowedIP['ip'])){
							$roleData = $this->getEmployeeRoleByRoleId($getLoginDetails['role_id']);
							$teamData = $this->getEmployeeTeamByTeamId($getLoginDetails['team_id']);
							$departmentData = $this->getEmployeeDepartmentsByDepartmentIds($getLoginDetails['department_ids']);
							$_SESSION['employee_id'] = $getLoginDetails['employee_id'];
							$_SESSION['name'] = $getLoginDetails['firstname'] . " " . $getLoginDetails['lastname'];
							$_SESSION['email'] = $getLoginDetails['email'];
							$_SESSION['username'] = $getLoginDetails['username'];
							$_SESSION['domain'] = $getLoginDetails['domain'];
							$_SESSION['manager_id'] = $getLoginDetails['manager_id'];
                            $_SESSION['zoho_ref_token'] = $getLoginDetails['zoho_ref_token'];
							$_SESSION['role_id'] = $getLoginDetails['role_id'];
							$_SESSION['role'] = $roleData['role'];
							$_SESSION['team_id'] = $getLoginDetails['team_id'];
							$_SESSION['team'] = $teamData['team'];
							$_SESSION['departments'] = $departmentData;
							$_SESSION['mail_password'] = $getLoginDetails['mail_password'];
							$getLoginDetails['login'] = "Success";
							$getLoginDetails['loginstatus'] = "Success";
						//}else{
						//	$getLoginDetails['login'] = "Failed";
						//	$getLoginDetails['loginstatus'] = "Access Denied";
						//}
					}     
				} else {
					$getLoginDetails['login'] = "Failed";
					$getLoginDetails['loginstatus'] = "Invalid Password";
				}
			} else {
				$getLoginDetails['login'] = "Failed";
				$getLoginDetails['loginstatus'] = "User not exist";
			}
		}else{
			$getLoginDetails['login'] = "Failed";
			$getLoginDetails['loginstatus'] = "Please enter valid EMAIL";
		}
        return $getLoginDetails;
    }
	
	function getAllIpAddress()
    {
        $roleQuery = $this->dbObject->selectQuery('ip_address', 'ip_address', '', '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
		$data = array();
		foreach($result as $row){
			$data['ip'][] = $row['ip_address'];
		}
        return $data;
    }

    function UpdateEployeeStatus($empid,$data){
        $table_name = "employees";
        $search_by = array('employee_id' => $empid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
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
       // $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and domain = '$domain'";
        $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and status=1 and email NOT LIKE 'sale%'";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
	
	function getAllSalesManager()
    {
       // $whr = array('role_id' => 3, 'team_id' => 2);
        //$roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
        $domain=$_SESSION['domain'];
       // $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and domain = '$domain'";
        $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and email NOT LIKE 'sale%'";
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

    function insertLeads_old($data)
    {
        $table = "leads";
        $memberDetailsId = $this->dbObject->insert($table, $data);
        return $memberDetailsId;
    }
	
	function insertLeads($data)
	{
		$arr['associated_id']=$data['associated_id'];
		$arr['seo_associated_id']=$data['seo_associated_id'];
		$arr['fname']=mysqli_escape_string($this->dbObject->connection,$data['fname']);
		$arr['lname']=mysqli_escape_string($this->dbObject->connection,$data['lname']);
		$arr['job_title']=mysqli_escape_string($this->dbObject->connection,$data['job_title']);
		$arr['email']=mysqli_escape_string($this->dbObject->connection,$data['email']);
		$arr['company']=mysqli_escape_string($this->dbObject->connection,$data['company']);
		$arr['company_url']=mysqli_escape_string($this->dbObject->connection,$data['company_url']);
		$arr['country']=mysqli_escape_string($this->dbObject->connection,$data['country']);
		$arr['phone_number']=mysqli_escape_string($this->dbObject->connection,$data['phone_number']);
		$arr['mobile']=mysqli_escape_string($this->dbObject->connection,$data['mobile']);
		$arr['lead_stage_id']=$data['lead_stage_id'];
		$arr['lead_generation_channel_id']=$data['lead_generation_channel_id'];
		$arr['lead_significance']=$data['lead_significance'];
		$arr['manager_id']=($data['manager_id']!="")?$data['manager_id']:0;
		$arr['seo_manager_id']=($data['seo_manager_id']!="")?$data['seo_manager_id']:0;
		$arr['assign_manager']=mysqli_escape_string($this->dbObject->connection,$data['assign_manager']);
		$arr['department']=mysqli_escape_string($this->dbObject->connection,$data['department']);
		$arr['entry_point']=$data['entry_point'];
		$arr['txt_comments']=mysqli_escape_string($this->dbObject->connection,$data['txt_comments']);
		$arr['report_code']=$data['report_code'];
		$arr['report_name']=mysqli_escape_string($this->dbObject->connection,$data['report_name']);
		$arr['category']=$data['category'];
		$arr['title_related_my_company']=$data['title_related_my_company'];
		$arr['created']=$data['created'];
		$arr['twitter_username']=mysqli_escape_string($this->dbObject->connection,$data['twitter_username']);
		$arr['linkedin_bio']=mysqli_escape_string($this->dbObject->connection,$data['linkedin_bio']);
		$arr['same_lead_report']=$data['same_lead_report'];
		$arr['same_lead_dif_report']=$data['same_lead_dif_report'];
		$arr['created_by']=isset($data['created_by'])?$data['created_by']:0;
		$arr['status']=$data['status'];
		$arr['lead_source']=(string) $data['lead_source'];

		$table = "leads";
		$memberDetailsId = $this->dbObject->insert($table, $arr);
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
		$currentmonth=date("m");
		$currentday=date("d");
		$startdate=date("Y-$currentmonth-01");
		$enddate=date("Y-$currentmonth-$currentday");
        $roleQuery ="Select count(*) as count from leads WHERE DATE(created) BETWEEN '$startdate' AND '$enddate'";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getCountOfPendingLeads(){
		$currentmonth=date("m");
		$currentday=date("d");
		$startdate=date("Y-$currentmonth-01");
		$enddate=date("Y-$currentmonth-$currentday");
        $roleQuery ="Select count(*) as count from leads where status = 0 AND DATE(created) BETWEEN '$startdate' AND '$enddate'";
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
        //$m_user="salesiarc123@gmail.com";
        //$m_pass="iarc@123";
	
	$m_user="notifications@industryarc.com";
        $m_pass="Xut41473";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.office365.com';
        $mail->Port = 587;
        $mail->Username = $m_user;
        $mail->Password = $m_pass;
        $mail->SetFrom($m_user, "IndustryArc");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        $mail->Send();
    }
     function MultiplesmtpMail($address,$subject,$message){
            require_once('../PHPMailer/class.phpmailer.php');
            //$m_user="salesiarc123@gmail.com";
            //$m_pass="iarc@123";
	    $m_user="notifications@industryarc.com";
            $m_pass="Xut41473";	
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.office365.com';
            $mail->Port = 587;
            $mail->Username = $m_user;
            $mail->Password = $m_pass;
            $mail->SetFrom($m_user, "IndustryArc");
            $mail->Subject = $subject;
            $mail->MsgHTML($message);
            foreach($address as $val){
               $mail->AddAddress($val);
            }
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
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
    function getAllleads(){
        if($this->leadGenChannel==""){
            $roleQuery = $this->dbObject->selectQuery('leads', '*', '', 'id', 'desc', '', '');
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        //echo $roleQuery;
        return $result;
    }
    function getAllleadsHaveFollowupDates(){
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT * FROM leads WHERE next_followup_date<>'0000-00-00 00:00:00' AND next_followup_date IS NOT NULL AND status=1 AND lead_stage_id IN (1,2,5) order by id desc";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) and 
                            next_followup_date<>'0000-00-00 00:00:00' AND next_followup_date IS NOT NULL
                              AND status=1 AND lead_stage_id IN (1,2,5) order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
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
    public function getnumSearchRecordsOfMyLeads($empId,$limit)
    {
        if($this->leadGenChannel=="") {
            $roleQuery ="Select count(*) as tot from leads where associated_id = $empId";
        }else {
            $roleQuery ="Select count(*) as tot from leads where lead_generation_channel_id in ($this->leadGenChannel) AND associated_id = $empId";
        }
            $result = $this->dbObject->getRow($roleQuery);
            $total_pages = ceil($result['tot'] / $limit);
            $data['total_pages']=$total_pages;
            $data['total']=$result['tot'];
            return $data;
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
    /*----------- contact  filters functions End-------------------*/
    function getCountOfPendingContactsByName($empId,$search_pending,$limit){
        if($this->leadGenChannel=="") {
            $query = "SELECT count(*) as tot FROM leads WHERE seo_associated_id = $empId AND status=1 AND associated_id = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%')";
        }else{
            $query = "SELECT count(*) as tot FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId AND status=1  AND associated_id = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%')";
        }
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
    }
    function getLeadBySeoIdPendingPagination($empId,$search_pending,$page,$limit)
    {
        if($this->leadGenChannel=="") {
            $query = "SELECT * FROM leads WHERE seo_associated_id = $empId  AND status = 1 AND associated_id = 0 AND 
         (fname LIKE '%{$search_pending}%' OR email LIKE '%{$search_pending}%') order by id desc ";
        }else{
            $query = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId  AND status = 1 AND associated_id = 0 AND 
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
            $roleQuery = "Select count(*) as tot from leads where seo_associated_id = $empId AND status=1 AND associated_id = 0";
        }else{
            $roleQuery = "Select count(*) as tot from leads where lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId AND status=1 AND associated_id = 0";
        }
        $result = $this->dbObject->getRow($roleQuery);
        $total_pages = ceil($result['tot'] / $limit);
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
    }
    public function getAllleadsPendingPagination($empId,$page,$recordsperpage){
         if($this->leadGenChannel=="") {
             $query = "select * from leads where seo_associated_id = $empId AND status=1 AND associated_id = 0  order by id desc ";
         }else{
             $query = "select * from leads where lead_generation_channel_id in ($this->leadGenChannel) AND seo_associated_id = $empId AND status=1 AND associated_id = 0  order by id desc ";
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
        $query=$query.$condition." order by created DESC";
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
            $roleQuery = "SELECT * FROM leads WHERE (created BETWEEN '$fromdate' AND '$todate') order by id desc";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (created BETWEEN '$fromdate' AND '$todate') order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
	
	public function getLeadsbyAssignFromAndToDate($associatedId,$fromdate,$todate){
		if($associatedId=="0"){
			$con = "";
		}else{
			$con = "AND associated_id=".$associatedId;
		}
		
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT * FROM leads WHERE (lead_assigned_date BETWEEN '$fromdate' AND '$todate') $con order by id desc";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (lead_assigned_date BETWEEN '$fromdate' AND '$todate') $con order by id desc";
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
        $whr = array('associated_id' => $associateId,'status'=>1);
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
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
        if ($data['createdf'] !="") {
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
        $query=$query.$condition."order by id desc ";
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;

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
		if ($data['assignedf'] !="") {
            $condition.="AND DATE(lead_assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
        }
        if ($data['last_activityf'] !="") {
            $condition.="AND DATE(last_activity) BETWEEN '".$data['last_activityf']."' AND '".$data['last_activityt']."' ";
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
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
            $condition.="AND lead_generation_channel_id = $channel ";
        }
        if ($data['associated_id'] !="") {
            $associatedid=$data['associated_id'];
            $condition.="AND associated_id = $associatedid ";
        }
        if ($data['createdf'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
        }
		if ($data['assignedf'] !="") {
            $condition.="AND DATE(lead_assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
        }
        if ($data['last_activityf'] !="") {
            $condition.="AND DATE(last_activity) BETWEEN '".$data['last_activityf']."' AND '".$data['last_activityt']."' ";
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
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
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
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

    function getRejectedLeads(){
        if($this->leadGenChannel==""){
            $query="select * from leads where status = 2 order by id desc ";
        }else{
            $query="select * from leads where lead_generation_channel_id in ($this->leadGenChannel) AND status = 2 order by id desc ";
        }
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getLostLeads(){
        if($this->leadGenChannel==""){
            $query="select * from leads where lead_stage_id = 6 order by id desc";
        }else{
            $query="select * from leads where lead_generation_channel_id in ($this->leadGenChannel) AND lead_stage_id = 6 order by id desc ";
        }
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
	
	function getAllInvoices(){
		$roleQuery = $this->dbObject->selectQuery('invoices', '*', '', 'id', 'desc', '', '');
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getThreeCXcalllogsByLeadId($leadid){
		$whr = array('lead_id' => $leadid);
		$roleQuery = $this->dbObject->selectQuery('3cx_calls', '*', $whr, 'id', 'DESC', '', '');
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getEmployeeByExtension($extension){
		$whr = array('extension' => $extension);
		$roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
		$result = $this->dbObject->getRow($roleQuery);
		return $result;
	}
	
	function getThreeCXcalllogsByPhoneNo($mobile){
		$callQuery = "SELECT * FROM `3cx_calls` WHERE phone LIKE '%$mobile%' ORDER BY id DESC";
		$result = $this->dbObject->getAllRows($callQuery);
		return $result;
	}
	
	function getEmployeeByteamId($teamid){
		$whr = array('team_id' => $teamid);
		$roleQuery = $this->dbObject->selectQuery('employees', '*', $whr, '', '', '', '');
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getCallLogsByExtensionAndDate($extension,$fromdate,$todate){
		$roleQuery = "SELECT * FROM 3cx_calls WHERE agent = $extension AND 
		date(created) BETWEEN '$fromdate' AND '$todate' ORDER By id DESC";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getLeadsFollowupsByLeadId($leadId,$mobile)
    {
		$notesQuery = "SELECT * from notes where lead_id=$leadId";
        $dataNotes = $this->dbObject->getAllRows($notesQuery);
		
		$twilioQuery = "SELECT * from call_logs where lead_id=$leadId";
        $dataTwilio = $this->dbObject->getAllRows($twilioQuery);
		if(strlen($mobile)>4){
			$threeCxQuery = "SELECT * from 3cx_calls where phone LIKE '%$mobile%'";
			$dataThreeCx = $this->dbObject->getAllRows($threeCxQuery);
			$result['threecx'] = $dataThreeCx;
		}else{
			$result['threecx'] = array();
		}
		
		$result['notes'] = $dataNotes;
		$result['twilio'] = $dataTwilio;		
		
        return $result;
    }
	
	/*Account functions*/
	
	function insertAccounts($data)
	{
		$table = "accounts";
		$accountId = $this->dbObject->insert($table, $data);
		return $accountId;
	}
	
	function getAllAccounts(){
		$roleQuery = $this->dbObject->selectQuery('accounts', '*', $whr, 'id', 'Desc', '', '');
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function UpdateAccountAssign($accId,$data){
		$table_name = "accounts";
		$search_by = array('id' => $accId);
		$status = $this->dbObject->update($table_name, $data, $search_by);
		return $status;
	}
	
	function getSalesManagerAndEmployees(){
		$domain=$_SESSION['domain'];
		// $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and domain = '$domain'";
		$roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and status = 1";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	function getAccountByaccountId($AccId){
		$whr = array('id' => $AccId);
		$roleQuery = $this->dbObject->selectQuery('accounts', '*', $whr, '', '', '', '');
		$result = $this->dbObject->getRow($roleQuery);
		return $result;
	}
	
	function getleadsByEmailId($company){
		$roleQuery="SELECT * FROM leads WHERE email LIKE '%@{$company}%'";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function MultipleAssignLeadsByIds($leadids,$assignto){
		$date = date("Y-m-d H:i:s");
		$roleQuery = "UPDATE leads set `associated_id`=$assignto,`lead_assigned_date`='$date' WHERE id IN ($leadids)";
		$result = $this->dbObject->execute($roleQuery);
		return $result;
	}
	
	function getBulkLeadsToAssign($data){
		$condition = "";
		if($data['department'] !="") {
		$condition.="AND department LIKE '%".$data['department']."%' ";
		}
		if($data['associated_id'] != ""){
			$associated_id=$data['associated_id'];
			$condition.="AND associated_id = $associated_id ";
		}
		if($data['stage'] !="") {
		$stage=$data['stage'];
		$condition.="AND lead_stage_id = $stage ";
		}
		if($data['channel'] !="") {
		$channel=$data['channel'];
		$condition.="AND lead_generation_channel_id = $channel ";
		}
		if ($data['ass_fromdate'] !="") {
		$condition.="AND DATE(lead_assigned_date) BETWEEN '".$data['ass_fromdate']."' AND '".$data['ass_todate']."' ";
		}
		if ($data['last_fromdate'] !="") {
		$condition.="AND DATE(last_activity) BETWEEN '".$data['last_fromdate']."' AND '".$data['last_todate']."' ";
		}
		if ($data['createdf'] !="") {
		$condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
		}
		$condition= ltrim($condition,"AND");
		if($condition !=""){
		$query = "SELECT * from leads WHERE ";
		}else{
		$query = "SELECT * from leads ";
		}
		$query=$query.$condition."order by id desc";
		$result = $this->dbObject->getAllRows($query);
		return $result;
	}
	
	function getAssignedLogsOfLead($leadid){
		$roleQuery="SELECT * FROM lead_assign_log WHERE lead_id = $leadid order by id desc";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getClosedLeadlist(){
		$roleQuery="SELECT * FROM leads WHERE lead_stage_id = 3 order by id desc";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getlostsalefeedback(){
		$roleQuery="SELECT * FROM lost_sale_feedback order by id desc";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function getreportfeedback(){
		$roleQuery="SELECT * FROM report_feedback order by id desc";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
	function get_client_ip(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP'])){
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		}else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		}else if(isset($_SERVER['REMOTE_ADDR'])){
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		}else{
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}
	
	function getclosedAmountByMonth(){
		$currentmonth=date("m");
		$currentday=date("d");
		$startdate=date("Y-$currentmonth-01");
		$enddate=date("Y-$currentmonth-$currentday");
        $roleQuery ="SELECT IF(SUM(lp.exp_deal_amount),SUM(lp.exp_deal_amount),'0') AS closedamt FROM leads l LEFT JOIN lead_pipeline lp ON l.id=lp.lead_id WHERE l.lead_stage_id=3 AND DATE(lp.created) BETWEEN '$startdate' AND '$enddate'";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
	
	function getLeadStagesReportForChart(){
		$currentmonth=date("m");
		$currentday=date("d");
		$startdate=date("Y-$currentmonth-01");
		$enddate=date("Y-$currentmonth-$currentday");
        $roleQuery ="SELECT lead_stage_id,COUNT(*) AS tot FROM leads WHERE DATE(created) BETWEEN '$startdate' AND '$enddate' GROUP BY lead_stage_id";
        //$roleQuery ="SELECT lead_stage_id,COUNT(*) AS tot FROM leads GROUP BY lead_stage_id";
        $result = $this->dbObject->getAllRows($roleQuery);
		$data = array();
		foreach($result as $row){
			$data[$row['lead_stage_id']]['tot'] = $row['tot'];
		}
        return $data;
    }
	
	function getLeadsVsSalesdata(){
		$lsQuery ="SELECT COUNT(*) AS tot,YEAR(created) AS yrs,DATE_FORMAT(created,'%b') AS `month`  FROM leads WHERE YEAR(created)=YEAR(NOW()) 
GROUP BY yrs,`month`";
		$result = $this->dbObject->getAllRows($lsQuery);
		$data = array();
		$i=0;
		foreach($result as $row){
			$month = $row['month'];
			$mQuery = "SELECT SUM(exp_deal_amount) AS totamt,YEAR(created) AS yrs,DATE_FORMAT(created,'%b') AS `month` FROM lead_pipeline 
WHERE lead_stage_id=3 AND YEAR(created)=YEAR(NOW()) AND DATE_FORMAT(created,'%b')='$month'";
			$mResult = $this->dbObject->getRow($mQuery);
			$data[$i]['year'] = $row['yrs'];
			$data[$i]['month'] = $row['month'];
			$data[$i]['totleads'] = $row['tot'];
			$data[$i]['totsales'] = ($mResult['totamt']!="")?$mResult['totamt']:0;
			$i++;
		}		
        return $data;
	}
	
	/*--------------------------Seo Report Links (30-05-2019)--------------------------*/
    function insertReports($data){
      $table = "seo_reports";
      $ReportId = $this->dbObject->insert($table, $data);
      return $ReportId;
    }
	
    function insertLinks($data){
        $table = "link_reports";
        $LinkId = $this->dbObject->insert($table, $data);
        return $LinkId;
    }
    function getSeoEmpReportsByEmpId($empid){
   //$roleQuery="SELECT * FROM link_reports lr LEFT JOIN seo_reports sr ON sr.id=lr.report_id WHERE sr.created_by = $empid";
     $roleQuery="SELECT * FROM seo_reports WHERE created_by = $empid AND status=1 order by created desc";
     $result = $this->dbObject->getAllRows($roleQuery);
     return $result;
    }
	
	function getSeoEmpSubmittedReportsByEmpId($empid){
     $roleQuery="SELECT * FROM `seo_submitted_reports` WHERE created_by = $empid AND status=1 order by created desc";
     $result = $this->dbObject->getAllRows($roleQuery);
     return $result;
    }
	
    function getAllSeoReports(){
       $roleQuery="SELECT * FROM seo_reports where status=1 order by created desc";
       $result = $this->dbObject->getAllRows($roleQuery);
       return $result;
    }
	
	function getAllSeoSubmittedReports(){
       $roleQuery="SELECT * FROM seo_submitted_reports where status=1 order by created desc";
       $result = $this->dbObject->getAllRows($roleQuery);
       return $result;
    }
    function getCountOfLinksByReportId($reportid){
      $roleQuery = "SELECT count(*) as total FROM link_reports where report_id = $reportid";
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
	function getCountOfSubmittedLinksByReportId($reportid){
      $roleQuery = "SELECT count(*) as total FROM link_submitted_reports where report_id = $reportid";
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
    function getdomainByUrl($check_url){
      $roleQuery="SELECT domain_authority FROM link_reports where url LIKE '%{$check_url}%'";
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
    function getSeoReportById($id){
      $whr = array('id' => $id);
      $roleQuery = $this->dbObject->selectQuery('seo_reports', '*', $whr, '', '', '', '');
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
	
	function getSeoSubmittedReportById($id){
      $whr = array('id' => $id);
      $roleQuery = $this->dbObject->selectQuery('seo_submitted_reports', '*', $whr, '', '', '', '');
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
    function getSeoLinksByReportId($reportid){
        $whr = array('report_id' => $reportid);
        $roleQuery = $this->dbObject->selectQuery('link_reports', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
	function getSeoSubmittedLinksByReportId($reportid){
        $whr = array('report_id' => $reportid);
        $roleQuery = $this->dbObject->selectQuery('link_submitted_reports', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
	function UpdateReportByReportId($reportid,$data){
		$table_name = "seo_reports";
		$search_by = array('id' => $reportid);
		$status = $this->dbObject->update($table_name, $data, $search_by);
		return $status;
	}
	function UpdateSubmittedReportByReportId($reportid,$data){
		$table_name = "seo_submitted_reports";
		$search_by = array('id' => $reportid);
		$status = $this->dbObject->update($table_name, $data, $search_by);
		return $status;
	}
    function UpdateLinksByLinkId($linkid, $data){
        $table_name = "link_reports";
        $search_by = array('id' => $linkid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }
	
	function UpdateSubmittedLinksByLinkId($linkid, $data){
        $table_name = "link_submitted_reports";
        $search_by = array('id' => $linkid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }
	
	function DeleteRecordByID($report_id,$data){
		$table_name = "seo_reports";
		$search_by = array('id' => $report_id);
		$result = $this->dbObject->update($table_name, $data, $search_by);
		return $result;
	}
	
	function DeleteSubmittedRecordByID($report_id,$data){
		$table_name = "seo_submitted_reports";
		$search_by = array('id' => $report_id);
		$result = $this->dbObject->update($table_name, $data, $search_by);
		return $result;
	}
	function CheckreportexitsByEmpId($report_code,$empid){
		$roleQuery="SELECT id FROM seo_reports WHERE report_code = '$report_code' AND created_by = $empid and status=1";
		$result = $this->dbObject->getRow($roleQuery);
		return $result;
	}
	
	function CheckSubmittedReportexitsByEmpId($report_code,$empid){
		$roleQuery="SELECT id FROM seo_submitted_reports WHERE report_code = '$report_code' AND created_by = $empid and status=1";
		$result = $this->dbObject->getRow($roleQuery);
		return $result;
	}
	
	function CheckSubmitedreportexitsByEmpId($report_code,$empid){
		$roleQuery="SELECT id FROM seo_submitted_reports WHERE report_code = '$report_code' AND created_by = $empid and status=1";
		$result = $this->dbObject->getRow($roleQuery);
		return $result;
	}
	
	function insertSubmittedReports($data){
      $table = "seo_submitted_reports";
      $ReportId = $this->dbObject->insert($table, $data);
      return $ReportId;
    }
	
	function insertSubmittedLinks($data){
        $table = "link_submitted_reports";
        $LinkId = $this->dbObject->insert($table, $data);
        return $LinkId;
    }
	
/*--------------------------Seo Report END Links (30-05-2019)--------------------------*/
	
	function getAllLeadsByAppliedfilter($data){
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
        if ($data['assignedf'] !="") {
            $condition.="AND DATE(lead_assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
        }
        if ($data['last_activityf'] !="") {
            $condition.="AND DATE(last_activity) BETWEEN '".$data['last_activityf']."' AND '".$data['last_activityt']."' ";
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
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
	
	/*--------------------------get activity pending lead lead for last one week (10/06/19)--------------------------*/
  function getallActiveLeadsByLastActivity(){
    $lastdate = date('Y-m-d', strtotime("-7 days"));
   $roleQuery = "SELECT id FROM leads where YEAR(created)>=2019 AND associated_id != 0 AND lead_stage_id IN (1,2,5) AND last_activity <= '$lastdate'";
   $result = $this->dbObject->getAllRows($roleQuery);
   return $result;
  }
   function checkLeadsInNotesByCreated($leadids){
     $lastdate = date('Y-m-d', strtotime("-7 days"));
     $roleQuery = "SELECT lead_id as id FROM notes where lead_id in ($leadids) AND created >= '$lastdate' GROUP BY lead_id ORDER BY id DESC";
     $result = $this->dbObject->getAllRows($roleQuery);
     return $result;
   }
   function checkLeadsIn3cxCallsByCreated($leadids){
      $lastdate = date('Y-m-d', strtotime("-7 days"));
      $roleQuery = "SELECT lead_id as id FROM 3cx_calls where lead_id in ($leadids) AND created >= '$lastdate' GROUP BY lead_id ORDER BY id DESC";
      $result = $this->dbObject->getAllRows($roleQuery);
     return $result;
   }
   function getEmpleadsActivityPending($associate_id,$leadids){
      $roleQuery = "SELECT id,fname,lname,email,mobile,associated_id,job_title,company,department,report_name,report_code,created FROM leads where associated_id = $associate_id AND id IN ($leadids) order by id desc";
      $result = $this->dbObject->getAllRows($roleQuery);
      return $result;
   }
   function getAllleadsActivityPending($finalids){
    $roleQuery = "SELECT id,fname,lname,email,mobile,associated_id,job_title,company,department,report_name,report_code,created FROM leads where id IN ($finalids) order by id desc";
    $result = $this->dbObject->getAllRows($roleQuery);
     return $result;
   }
   function getAllleadsActivityPendingByFilter($leadids,$data){
    $condition = "";
    if($data['associated_id'] != ""){
        $associated_id=$data['associated_id'];
        $condition.="AND associated_id = $associated_id ";
    }
    if ($data['createdf'] !="") {
      $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
    }
     $condition= ltrim($condition,"AND");
       if($condition !=""){
           $query = "SELECT id,fname,lname,email,mobile,associated_id,job_title,company,department,report_name,report_code,created from leads WHERE id IN ($leadids) AND ";
       }else{
           $query = "SELECT id,fname,lname,email,mobile,associated_id,job_title,company,department,report_name,report_code,created from leads WHERE id IN ($leadids) ";
       }
       $query=$query.$condition."order by id desc";
       $result = $this->dbObject->getAllRows($query);
       return $result;
   }
   function getEmpleadsActivityPendingByFilter($associate_id,$leadids,$data){
       $condition = "";
       if ($data['createdf'] !="") {
         $condition.="AND DATE(created) BETWEEN '".$data['createdf']."' AND '".$data['createdt']."' ";
       }
       $condition= ltrim($condition,"AND");
        if($condition !=""){
            $query = "SELECT id,fname,lname,email,mobile,job_title,company,department,report_name,report_code,created from leads WHERE associated_id = $associate_id AND id IN ($leadids) AND ";
        }else{
            $query = "SELECT id,fname,lname,email,mobile,job_title,company,department,report_name,report_code,created from leads WHERE associated_id = $associate_id AND id IN ($leadids) ";
        }
        $query=$query.$condition."order by id desc";
        $result = $this->dbObject->getAllRows($query);
        return $result;
      }
  /*--------------------------get activity pending lead lead for last one week END (10/06/19)--------------------------*/
	
	function getCountOfNotAssignLeadsByMonth(){
		$currentmonth=date("m");
		$currentday=date("d");
		$startdate=date("Y-$currentmonth-01");
		$enddate=date("Y-$currentmonth-$currentday");
        $roleQuery ="Select count(*) as count from leads where associated_id = 0 AND DATE(created) BETWEEN '$startdate' AND '$enddate'";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
	
	function getPublishedReportByReportCode($rcode)
    {
        $whr = array('report_code' => $rcode);
        $roleQuery = $this->dbObject->selectQuery('published_report', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
	
	function insertDownloadLogs($data){
        $table = "download_logs";
        $rs = $this->dbObject->insert($table, $data);
        return $rs;
    }
	
}
?>
