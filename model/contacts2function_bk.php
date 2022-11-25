<?php
class contacts2functions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
        //echo $this->leadGenChannel;
        //exit;
    }
    /*    ===================================new function=====================================*/
    function getTotalnumofSearchContacts2($limit){
           $roleQuery = "Select count(id) as total from zoominfo_leads where assign_to = 0 ORDER BY id DESC";
           $result = $this->dbObject->getRow($roleQuery);
           $total_pages = ceil($result['total'] / $limit);
           $data['total_pages']=$total_pages;
           $data['total']=$result['total'];
           return $data;
     }
     function getAllContacts2Pagination($page,$limit){
             $query="select * from zoominfo_leads where assign_to = 0 ORDER BY id DESC ";
             $srt= $page-1;
             $startIndex = $srt*$limit;
             $maxLimit = $limit;
             $condition="LIMIT ".$startIndex.", ".$maxLimit;
             $query= $query.$condition;
             $result = $this->dbObject->getAllRows($query);
             return $result;
     }
    function getCountOfSearchDataInAllContacts2($data, $limit){
        $condition = "";
        if ($data['company_name'] !="") {
            $condition.="AND company_name IN (".$data['company_name'].") ";
        }
        if ($data['category'] !="") {
            $condition.="AND category IN (".$data['category'].") ";
        }
        if ($data['industry'] !="") {
            $condition.="AND industry IN (".$data['industry'].") ";
        }
        if ($data['managementlevel'] !="") {
            $condition.="AND managementlevel IN (".$data['managementlevel'].") ";
        }
        if ($data['country'] !="") {
           $condition.="AND country IN (".$data['country'].") ";
        }
        if ($data['contacttype'] != "") {
              if($data['contacttype'] == 1){
                $condition.="AND assign_to != 0 ";
              }elseif($data['contacttype'] == 2){
                $condition.="AND assign_to = 0 ";
              }elseif($data['contacttype'] == 3){
                $condition.="AND assign_to != 0 AND status =1 ";
              }elseif($data['contacttype'] == 4){
                $condition.="AND assign_to != 0 AND status =2 ";
              }else{
               $condition.="";
              }
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            $query = "SELECT count(*) as tot FROM zoominfo_leads WHERE ";
        }else{
            $query = "SELECT count(*) as tot FROM zoominfo_leads ";
        }
        $query=$query.$condition;
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
    }
    function getSearchDataInAllContacts2Pagination($data,$page, $limit){
        $condition = "";
        if ($data['company_name'] !="") {
            $condition.="AND company_name IN (".$data['company_name'].") ";
        }
        if ($data['category'] !="") {
            $condition.="AND category IN (".$data['category'].") ";
        }
        if ($data['industry'] !="") {
            $condition.="AND industry IN (".$data['industry'].") ";
        }
        if ($data['managementlevel'] !="") {
            $condition.="AND managementlevel IN (".$data['managementlevel'].") ";
        }
        if ($data['country'] !="") {
           $condition.="AND country IN (".$data['country'].") ";
        }
        if ($data['contacttype'] != "") {
              if($data['contacttype'] == 1){
                $condition.="AND assign_to != 0 ";
              }elseif($data['contacttype'] == 2){
                $condition.="AND assign_to = 0 ";
              }elseif($data['contacttype'] == 3){
                $condition.="AND assign_to != 0 AND status =1 ";
              }elseif($data['contacttype'] == 4){
                $condition.="AND assign_to != 0 AND status =2 ";
              }else{
               $condition.="";
              }
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            $query = "SELECT * FROM zoominfo_leads WHERE ";
        }else{
            $query = "SELECT * FROM zoominfo_leads ";
        }
        $query=$query.$condition;
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $countlimit=" LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$countlimit;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getEmpContactsVersion2ByEmpId($empId){
        $roleQuery = "SELECT * FROM zoominfo_leads WHERE assign_to = $empId order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
     function updateContactById($contactid,$data){
       $table_name = "zoominfo_leads";
       $search_by = array('id' => $contactid);
       $status = $this->dbObject->update($table_name, $data, $search_by);
       return $status;
     }
     function MultipleAssignContacts2ByIds($contactids,$assignto){
			$assignBy = $_SESSION['employee_id'];
     		$roleQuery = "UPDATE zoominfo_leads set `assign_to`=$assignto,assign_by=$assignBy WHERE id IN ($contactids)";
     		$result = $this->dbObject->execute($roleQuery);
     		return $result;
     	}
     	function getDistinctCountries(){
        $roleQuery = "SELECT DISTINCT country FROM zoominfo_leads where country != ''";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
     	}
     	function getDistinctIndustries(){
         $roleQuery = "SELECT DISTINCT industry FROM zoominfo_leads where industry != ''";
         $result = $this->dbObject->getAllRows($roleQuery);
         return $result;
      }
      function getDistinctCompanies(){
           $roleQuery = "SELECT DISTINCT company_name FROM zoominfo_leads where company_name != ''";
           $result = $this->dbObject->getAllRows($roleQuery);
           return $result;
      }
      function getContactDetailsById($contactid){
        $whr = array('id' => $contactid);
        $roleQuery = $this->dbObject->selectQuery('zoominfo_leads', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
      }
      function insertContact2Aslead($data){
        $table = "leads";
        $leadId = $this->dbObject->insert($table, $data);
        return $leadId;
      }
     function getAllEmpContactsVersion2($associate_id,$data){
      $condition = "";
      if ($data['category'] !="") {
          $condition.="AND category LIKE '%".$data['category']."%' ";
      }
      if ($data['managementlevel'] !="") {
          $condition.="AND managementlevel LIKE '%".$data['managementlevel']."%' ";
      }
      if ($data['country'] !="") {
         $condition.="AND country LIKE '%".$data['country']."%' ";
      }
      $condition= ltrim($condition,"AND");
        if($condition!=""){
            $query = "SELECT * FROM zoominfo_leads WHERE assign_to = $associate_id AND ";
        }else{
            $query = "SELECT * FROM zoominfo_leads WHERE assign_to = $associate_id ";
        }
         $query=$query.$condition."order by id desc";
         $result = $this->dbObject->getAllRows($query);
         return $result;
      }
	  
	    /*    ===================================contacts version2 end  function=====================================*/
      /*    ===================================request report functions(18/06/19)=====================================*/
      function insertRequestReports($data){
        $table = "request_report";
        $requestId = $this->dbObject->insert($table, $data);
        return $requestId;
      }
     function getALLPendingRequestReports(){
        $roleQuery = "SELECT * FROM request_report where status in (0,1) and api_call = 1 order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
      }
      function getPendingRequestReportsByEmp($EmpId){
        $roleQuery = "SELECT * FROM request_report where requested_by = $EmpId and status in (0,1) and api_call = 1 order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
      }
      function getALLCompletedRequestReports(){
        $roleQuery = "SELECT * FROM request_report where status = 2 and api_call = 1 order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
      }
      function getCompletedRequestReportsByEmp($EmpId){
        $roleQuery = "SELECT * FROM request_report where requested_by = $EmpId and status = 2 and api_call = 1 order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
      }
      function insertRequestLogs($data){
        $table = "request_report_logs";
        $requestlogId = $this->dbObject->insert($table, $data);
        return $requestlogId;
      }
      function updateRequestReportsById($requestId,$data){
         $table_name = "request_report";
         $search_by = array('id' => $requestId);
         $status = $this->dbObject->update($table_name, $data, $search_by);
         return $status;
      }
      function getRequestReportById($reqid){
          $roleQuery = "SELECT * FROM request_report where id = $reqid";
          $result = $this->dbObject->getRow($roleQuery);
          return $result;
      }
      function getRequestReportLogsById($reqid){
        $roleQuery = "SELECT * FROM request_report_logs where req_id = $reqid";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
      }
     function getLeadStageByStageId($stageid){
     $roleQuery = "SELECT * FROM lead_stages where id = $stageid";
     $result = $this->dbObject->getRow($roleQuery);
     return $result;
    }
		
    function getleadIdbyreqId($requestId){
     $roleQuery = "SELECT * FROM request_report where id = $requestId";
     $result = $this->dbObject->getRow($roleQuery);
     return $result;
    }
	
	function cleanData($data){
     return $this->dbObject->clean_sql($data);
    }

		function SendCCMail($to,$subject,$message,$cc){
			  require_once('../PHPMailer/class.phpmailer.php');
			  $m_user = "industryarc@rediffmail.com";
			  //$m_user="salesrequest19@gmail.com";
			  //$m_user="salesiarc123@gmail.com";
			  //$m_pass="Iarc@123";
			  $m_pass="I@rc@5224";	
			  $mail = new PHPMailer();
			  $mail->IsSMTP();
			  $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
			  $mail->SMTPAuth = true; // authentication enabled
			  //$mail->SMTPSecure = 'ssl';
			  $mail->SMTPSecure = false;
			  $mail->Host = 'smtp.rediffmail.com';
			  $mail->Port = 25;
			  $mail->Username = $m_user;
			  $mail->Password = $m_pass;
			  $mail->SetFrom($m_user, "IndustryArc");
			  $mail->Subject = $subject;
			  $mail->AddCC($cc);
			  $mail->AddBCC("vishwadeep.singh@industryarc.com");
			  $mail->AddBCC("sasikanth.vankamamidi@industryarc.com");
			  $mail->MsgHTML($message);
			  $mail->AddAddress($to);
			  $mail->Send();
		}
}
?>
