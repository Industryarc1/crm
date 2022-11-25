<?php
$leadGenerationChannel = array('1'=>'IARC-Inbound','2'=>'IARC-Seo','3'=>'MIR-Inbound','4'=>'MIR-Seo','5'=>'Outbound','6'=>'Outbound-Seo');
$taskstatus = array('0'=>'Pending','1'=>'In-Progress','2'=>'Cant be done','3'=>'Completed');
$leadStatus=array('0'=>'Pending','1'=>'Approved','2'=>'Rejected');
$leadCloumns=array('fname'=>'First Name','lname'=>'Last Name','job_title'=>'Job Title','email'=>'Email',
'phone_number'=>'Phone Number','lead_stage_id'=>'Lead stage','next_followup_date'=>'Next Followup','client_budget'=>'Estimated Client Budget','price_quoted'=>'Price Quoted','purchasing_time'=>'Purchasing TimeLine',
'approval_authority'=>'Approval Authority');
$leadStages=array('1'=>'Hot','2'=>'Cold','3'=>'Closed','4'=>'Dead','5'=>'Warm','6'=>'Lost','7'=>'Junk');
$dealStages=array('1'=>'Requirement Shared','2'=>'Proposal Sent','3'=>'Quotation Approved','4'=>'Deal Closed');
$department = array('38'=>'Agriculture','39'=>'Automotive','40'=>'Chemicals and Materials','41'=>'Energy and Power','42'=>'Food and Beverage','43'=>'Information and Communications Technology','44'=>'Lifesciences and Healthcare','45'=>'Electronics','46'=>'Automation and Instrumentation','47'=>'Consumer Products and Services','74'=>'Aerospace and Defense','144'=>'Education');

//echo "<pre>";
//print_r($_SERVER);exit;
	//define('LogoPath','http://'.$_SERVER['HTTP_HOST'].'/salon/admin/images/');
?>