<?php
session_start();
include_once('../model/function.php');
$functions = new functions();
$dates=array();
$empId=$_SESSION['employee_id'];

if($_SESSION['role_id'] == '1'){
    $followups = $functions->getAllleadsHaveFollowupDates();
}else{
    $followups=$functions->getLeadsbyAssociateId($empId);
}
$i=0;
foreach ($followups as $arr){
    $dates[$i]['id']=$arr['id'];
    //$dates[$i]['title']=$arr['company'];
    $dates[$i]['title']=$arr['fname']." ".$arr['lname'];
    //$dates[$i]['title']=array_map('utf8_encode',$arr['fname']);
    $dates[$i]['start']=$arr['next_followup_date'];
  /*  $employeename=$functions->getEmployeeByEmpId($arr['associated_id']);
    $dates[$i]['assigned_by']=$employeename['username'];*/
    $dates[$i]['description']="no desc";
    $dates[$i]['url']='contact_details.php?lead_id='.base64_encode($dates[$i]['id']);
    $i++;
}
//array_map('utf8_encode',$marca));
/* echo "<pre>";
print_r($dates);
exit(); */
if($_SESSION['role_id'] == '1'){
    $tasks=$functions->getAllTasks();
}else{
   $tasks=$functions->getTasksbByassignToId($empId);
}

foreach ($tasks as $tas){
    $dates[$i]['id']=$tas['lead_id'];
    $dates[$i]['title']='Tasks';
    $dates[$i]['start']=$tas['date'];
    $employeename=$functions->getEmployeeByEmpId($tas['assigned_by_id']);
    $dates[$i]['assigned_by']='By '.$employeename['username'];
    $dates[$i]['description']="NO";
    $dates[$i]['url']='assigned_to_me.php';
    $i++;
}
/* echo "<pre>";
print_r($dates); */

$jsonData = "[";
foreach($dates as $row) {
	$jsonData .= json_encode(array_map('utf8_encode',$row)).","; 
}
$jsonData = rtrim($jsonData,',');
$jsonData = $jsonData."]";
echo $jsonData;
//echo json_encode($dates);
?>


