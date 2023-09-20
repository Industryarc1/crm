<?php
session_start();
include_once('../../model/function.php');
$functions = new functions();
include_once('../../model/accountsfunction.php');
$accountsfunctions= new accountsfunctions();
include_once('../../model/projectfunction.php');
$projectfunctions = new projectfunctions();

if(isset($_POST['edit_task_id']) && $_POST['edit_task_id'] != ""){
    $task_id=$_POST['edit_task_id'];
    $result=$projectfunctions->getProjectTasksById($task_id);
    print_r(json_encode($result));
}
if(isset($_POST['del_task']) && $_POST['del_task']!= ""){
  $task_id=$_POST['del_task'];
  $result=$projectfunctions->deleteTaskById($task_id);
  echo $result;
}
if(isset($_POST['del_address']) && $_POST['del_address']!= ""){
  $address_id=$_POST['del_address'];
  $result=$projectfunctions->deleteIpAddressById($address_id);
  echo $result;
}
if(isset($_POST['task_id']) && $_POST['task_id']!= ""){
      $date = date("Y-m-d");
      $a = $_POST['assigned_to'];
      $emp_ids =implode(",",$a);
   			$data = array('category_id'=>$_POST['selectCategory'],'project_id'=>$_POST['selectProject'],'status'=>$_POST['status'],
   			'rating'=>$_POST['rating'],'assigned_to'=>$emp_ids,'assigned_by'=>$_SESSION['employee_id'],
   		 'expected_deadline'=>$_POST['exp_deadline'],'description'=>$_POST['description']);
     $task_id=$_POST['task_id'];
     $result=$projectfunctions->UpdateProjectTaskById($task_id,$data);
         $proj=$projectfunctions->getProjectById($_POST['selectProject']);
			      $cat=$projectfunctions->getCategoryById($_POST['selectCategory']);
			      $assigned_by=$functions->getEmployeeByEmpId($_SESSION['employee_id']);
			      $emps=$projectfunctions->getEmployeeByEmpIds($emp_ids);
			      $taskname=$projectfunctions->getProjectTasksById($task_id);
			      $cc_email=$assigned_by['email'];
			        //$cc_email="y.swapna.30@gmail.com";
		 	       //$address = array('y.swapna.1994@gmail.com','swapna.yarraguntla@industryarc.com');
		     	$address = array();
        foreach($emps as $emp){
          array_push($address, $emp['email']);
        }
         $subject='Updated Task has been Re-Assigned';
        	$message=' <div class="col-sm-3">
        	<h5>Dear Sales Team,</h5>
        	</div>
        	<div class="col-sm-8">
        	<div class="col-sm-8">
         <p><br>Below are the details of Updated task has been assigned to you.</p>
         <div class="row" style="border-radius:0.4em;font-family:Arial;font-size:13px;background-color:#eee">
         					<table width="100%" cellpadding="5" cellspacing="5">
         					<tr style="border-bottom:1px solid #CCC; ">
         					<td width="30%">Task </td>
         					<td width="1%">:</td>
         					<td width="68%">'.$taskname['task_name'].'</td>
         					</tr>
         					<tr>
         					<td width="30%">Project</td>
         					<td width="1%">:</td>
         					<td width="68%">'.$proj['project_name'].'</td>
         					</tr>
         						<tr>
              <td width="30%">Category </td>
              <td width="1%">:</td>
              <td width="68%">'.$cat['category'].'</td>
              </tr>
              <tr>
              <td width="30%">Assigned By</td>
              <td width="1%">:</td>
              <td width="68%">'.$assigned_by['firstname'].' '.$assigned_by['lastname'].'</td>
              </tr>
               <tr>
               <td width="30%">Expected Deadline</td>
              <td width="1%">:</td>
              <td width="68%">'.$_POST['exp_deadline'].'</td>
              </tr>
                <tr>
               <td width="30%">Description</td>
              <td width="1%">:</td>
              <td width="68%">'.$_POST['description'].'</td>
              </tr>
         					</table>
        	 </div>
        		</div>
        	<div class="col-sm-3">
        	<br>Regards,<br>
        	<strong>IndustryArc</strong>
        	</div>';
          $email = $projectfunctions->MultiplesmtpMail($address,$subject,$message,$cc_email);
        //  echo "success";
          //echo $result;
}
if(isset($_POST['leadid']) && $_POST['leadid']!= "" && $_POST['task_name']!= ""){
    $date = date("Y-m-d");
   $data = array('category_id'=>$_POST['category'],'task_name'=>$_POST['task_name'],'assigned_to'=>$_POST['assigned_to'],
   'assigned_by'=>$_SESSION['employee_id'],'assigned_date'=>$date,'created_date'=>$date,'expected_deadline'=>$_POST['exp_date'],
  		  'description'=>$_POST['description'],'lead_id'=>$_POST['leadid']);
    $result=$projectfunctions->insertProjectTask($data);
    echo $result;
}
if(isset($_POST['comments']) && $_POST['comments']!= ""){
   $date = date("Y-m-d");
   $data=array('task_id'=>$_POST['updatetask_id'],'comments'=>$_POST['comments'],'updated_by'=>$_SESSION['employee_id'],
   'created_date'=>$date);
   $result=$projectfunctions->insertProjectComments($data);
   echo $result;
}
if(isset($_POST['user_task_id']) && $_POST['user_comments']!= ""){
    $date = date("Y-m-d");
   $data=array('task_id'=>$_POST['user_task_id'],'user_status'=>$_POST['user_status'],'comments'=>$_POST['user_comments'],
   'updated_by'=>$_SESSION['employee_id'],'requested_deadline'=>$_POST['req_deadline'],'created_date'=>$date);
   //$task_id=$_POST['user_task_id'];
   $result=$projectfunctions->insertProjectComments($data);
   echo $result;
}
if(isset($_POST['comment_task_id']) && $_POST['comment_task_id']!= ""){
   $task_id=$_POST['comment_task_id'];
   $comments=$projectfunctions->getProjectCommentsByProjectId($task_id);
   foreach($comments as $row){
   $emp=$functions->getEmployeeByEmpId($row['updated_by']);
    echo '<div class="row"><div class="chat_box"><strong style="font-size: 12px;">'.$emp['firstname'].' '.$emp['lastname'].'</strong><div style="font-size:14px;">' .$row['comments'].'<span style="font-size: 10px;float:right">On Date: '.$row['created_date']. '</span></div></div></div>';
   }
  // print_r($comments);exit;
}
/*if(isset($_POST['task_id']) && isset($_POST['colname']) != ""){
	$date = date("Y-m-d H:i:s");
	$task_id = $_POST['task_id'];
	$colname = $_POST['colname'];
	$value = $_POST['value'];
	$data=array($colname=>$value);
	$result=$projectfunctions->UpdateProjectTaskById($task_id,$data);
	echo $result;
}*/
?>
