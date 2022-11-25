<?php
class projectfunctions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
        //echo $this->leadGenChannel;
        //exit;
    }
    function insertIpAddress($data){
      $table = "ip_address";
      $IpaddressId = $this->dbObject->insert($table, $data);
      return $IpaddressId;
    }
    function getAllipAddress(){
       $roleQuery = $this->dbObject->selectQuery('ip_address', '*', $whr, '', '', '', '');
       $result = $this->dbObject->getAllRows($roleQuery);
       return $result;
    }
    function deleteIpAddressById($id){
      $value = array('id' => $id);
      $table_name = "ip_address";
      $status = $this->dbObject->delete($table_name, $value);
      return $status;
    }
    function insertProject($data){
        $table = "project_titles";
        $projectId = $this->dbObject->insert($table, $data);
        return $projectId;
    }
    function insertCategory($data){
      $table = "project_category";
      $categoryId = $this->dbObject->insert($table, $data);
      return $categoryId;
    }
    function insertProjectTask($data){
      $table = "project_tasks";
      $taskId = $this->dbObject->insert($table, $data);
      return $taskId;
     }
    function insertProjectComments($data){
       $table = "project_comments";
       $commentId = $this->dbObject->insert($table, $data);
       return $commentId;
    }
     function getProjectCommentsByProjectId($task_id){
        $roleQuery="select * from project_comments where task_id = $task_id order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
     }
     function getAllProjects(){
       $roleQuery = $this->dbObject->selectQuery('project_titles', '*', '', '', '', '', '');
       $result = $this->dbObject->getAllRows($roleQuery);
       return $result;
     }
    function getProjectById($id){
       $roleQuery="select * from project_titles where id = $id";
       $result = $this->dbObject->getRow($roleQuery);
       return $result;
    }
    function getAllCategories(){
       $roleQuery = $this->dbObject->selectQuery('project_category', '*', $whr, '', '', '', '');
       $result = $this->dbObject->getAllRows($roleQuery);
       return $result;
    }
    function getCategoryById($id){
      $roleQuery="select category from project_category where id = $id";
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
    function getAllProjectTasks(){
       $roleQuery = $this->dbObject->selectQuery('project_tasks', '*', $whr, 'id', 'DESC', '', '');
       $result = $this->dbObject->getAllRows($roleQuery);
       return $result;
    }
    function getEmployeeByEmpIds($ids){
      $roleQuery="select * from employees where employee_id IN ($ids)";
      $result = $this->dbObject->getAllRows($roleQuery);
      return $result;
    }
    function getProjectTasksById($task_id){
      $roleQuery="select * from project_tasks where id = $task_id";
      $result = $this->dbObject->getRow($roleQuery);
      return $result;
    }
    function deleteTaskById($task_id){
      $value = array('id' => $task_id);
      $table_name = "project_tasks";
      $status = $this->dbObject->delete($table_name, $value);
      return $status;
    }
    function UpdateProjectTaskById($task_id,$data){
      $table_name = "project_tasks";
      $search_by = array('id' => $task_id);
      $status = $this->dbObject->update($table_name, $data, $search_by);
      return $status;
    }
    function getAllProjectTasksBySearchData($data){
       $condition = "";
      if ($data['category_id'] !="") {
          $condition.="AND category_id = ".$data['category_id']." ";
      }
      if ($data['project_id'] !="") {
          $condition.="AND project_id = ".$data['project_id']." ";
      }
      if ($data['status'] !="") {
         $condition.="AND status = ".$data['status']." ";
      }
      if ($data['ass_fromdate'] !="") {
          $condition.="AND DATE(assigned_date) BETWEEN '".$data['ass_fromdate']."' AND '".$data['ass_todate']."' ";
      }
      if ($data['exp_fromdate'] !="") {
          $condition.="AND DATE(expected_deadline) BETWEEN '".$data['exp_fromdate']."' AND '".$data['exp_todate']."' ";
       }
      $condition= ltrim($condition,"AND");
      if($condition !=""){
          $query = "SELECT * from project_tasks WHERE ";
      }else{
          $query = "SELECT * from project_tasks";
      }
      $query=$query.$condition." order by id desc";
      $result = $this->dbObject->getAllRows($query);
      return $result;
    }
    function getAssignedProjectTasksByEmpId($emp_id){
     $roleQuery = "select * from project_tasks WHERE CONCAT(',', assigned_to, ',') LIKE '%,{$emp_id},%' order by id desc";
     $result = $this->dbObject->getAllRows($roleQuery);
     return $result;
    }
    function getMyProjectTasksBySearchData($data,$emp_id){
    $condition = "";
          if ($data['category_id'] !="") {
              $condition.="AND category_id = ".$data['category_id']." ";
          }
          if ($data['project_id'] !="") {
              $condition.="AND project_id = ".$data['project_id']." ";
          }
          if ($data['status'] !="") {
             $condition.="AND status = ".$data['status']." ";
          }
          if ($data['ass_fromdate'] !="") {
              $condition.="AND DATE(assigned_date) BETWEEN '".$data['ass_fromdate']."' AND '".$data['ass_todate']."' ";
          }
          if ($data['exp_fromdate'] !="") {
            $condition.="AND DATE(expected_deadline) BETWEEN '".$data['exp_fromdate']."' AND '".$data['exp_todate']."' ";
           }
          $condition= ltrim($condition,"AND");
          if($condition !=""){
              $query = "SELECT * from project_tasks WHERE CONCAT(',', assigned_to, ',') LIKE '%,{$emp_id},%' AND ";
          }else{
              $query = "SELECT * from project_tasks WHERE CONCAT(',', assigned_to, ',') LIKE '%,{$emp_id},%' ";
          }
          $query=$query.$condition." order by id desc";
          $result = $this->dbObject->getAllRows($query);
          return $result;
    }
      function getCountOfPendingProjects(){
       $roleQuery ="Select count(*) as count from project_tasks where status = 0";
       $result = $this->dbObject->getRow($roleQuery);
       return $result;
      }
      function getCountOfCompletedProjects(){
          $roleQuery ="Select count(*) as count from project_tasks where status = 1";
          $result = $this->dbObject->getRow($roleQuery);
          return $result;
      }
     function getCountOfFailedProjects(){
         $roleQuery ="Select count(*) as count from project_tasks where status = 2";
         $result = $this->dbObject->getRow($roleQuery);
         return $result;
     }
      function MultiplesmtpMail($address,$subject,$message,$cc_email){
                 require_once('../../PHPMailer/class.phpmailer.php');
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
                 $mail->SetFrom($m_user, "IndustryArc");
                 $mail->Subject = $subject;
                   //$this->mail->AddBCC($bcc_email);
                  // $this->mail->AddReplyTo($reply_email);
                  // $this->mail->ClearAddresses();
                 $mail->AddCC($cc_email);
                 $mail->MsgHTML($message);
                 foreach($address as $val){
                    $mail->AddAddress($val);
                 }
                 $mail->Send();
    }
	
	function MultiplesmtpMaila($address,$subject,$message,$cc_email){
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
                 $mail->SetFrom($m_user, "IndustryArc");
                 $mail->Subject = $subject;
                   //$this->mail->AddBCC($bcc_email);
                  // $this->mail->AddReplyTo($reply_email);
                  // $this->mail->ClearAddresses();
                 $mail->AddCC($cc_email);
                 $mail->MsgHTML($message);
                 foreach($address as $val){
                    $mail->AddAddress($val);
                 }
                 $mail->Send();
    }
	
	function getmytodaypendingProjects($empid){
		$roleQuery ="SELECT * FROM project_tasks WHERE CONCAT(',', assigned_to, ',') LIKE '%,{$empid},%' AND STATUS = 0 AND expected_deadline = DATE(NOW())";
		$result = $this->dbObject->getAllRows($roleQuery);
		return $result;
	}
	
    /* function getProjectTasklogsById($taskid){
         $roleQuery="select * from project_task_log where project_task_id = $taskid";
         $result = $this->dbObject->getAllRows($roleQuery);
         return $result;
   }*/
}
?>

