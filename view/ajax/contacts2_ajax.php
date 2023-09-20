<?php
session_start();
ini_set("display_errors",0);
 include_once('../../model/function.php');
 $functions = new functions();
	include_once('../../model/contacts2function.php');
 $contacts2functions = new contacts2functions();

if(isset($_POST['convert_contactid'])){
   $date = date("Y-m-d");
   $contactid =$_POST['convert_contactid'];
   $status= "1";
   $email=$_POST['email'];
   $phone=$_POST['phone'];
   $comments=$_POST['comments'];
   $data=array('email'=>$email,'phone'=>$phone,'status'=>$status,'comments'=>$comments,'updated_date'=>$date);
   //print_r($data);exit;
   $result = $contacts2functions->updateContactById($contactid,$data);
   $contactdetails=$contacts2functions->getContactDetailsById($contactid);
   if($result){
   	$data=array(
   	'fname'=>$contactdetails['firstname'],
   	'lname'=>$contactdetails['lastname'],
   	'company'=>$contactdetails['company'],
   	'job_title'=>$contactdetails['title'],
   	'department'=>$contactdetails['industry'],
   	'category'=>$contactdetails['industry'],
   	'email'=>$contactdetails['email'],
   	'mobile'=>$contactdetails['phone'],
   	'phone_number'=>$contactdetails['phone'],
   	'country'=>$contactdetails['country'],
   	'company_url'=>$contactdetails['company_domain'],
   	'created'=>$date,
   	'lead_generation_channel_id'=>"5",
   	'status'=>"1",
   	'lead_stage_id'=>"2",
   	'associated_id'=>$_SESSION['employee_id'],
   	'entry_point'=>"Added from contacts 2.0",
   	'txt_comments'=>$comments
   	);
   	$leadid=$contacts2functions->insertContact2Aslead($data);
    }
   echo $leadid;
}
if(isset($_POST['contact2commentid'])){
   $date = date("Y-m-d");
   $contactid =$_POST['contact2commentid'];
   $comments =$_POST['comments'];
   $status= "2";
   $data=array('comments'=>$comments,'status'=>$status,'updated_date'=>$date);
   $result =  $contacts2functions->updateContactById($contactid,$data);
   echo $result;
}
if(isset($_POST['assignvalues']) && $_POST['assignvalues'] != "" && $_POST['assignto'] != ""){
$assignids=$_POST['assignvalues'];
 //$removed = array_shift($assignids);
	$contactids = join(",",$assignids);
	$assignto=$_POST['assignto'];
	$result=$contacts2functions->MultipleAssignContacts2ByIds($contactids,$assignto);
	echo $result;
}
?>
