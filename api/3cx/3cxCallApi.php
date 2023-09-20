<?php
	include_once('../../model/callapi.php');
	$callApi = new callapis();
	$date = date('Y-m-d H:i:s');
	
	$dt = new DateTime($_POST['Call_Start_Time']);
	$tz = new DateTimeZone('Asia/Kolkata'); // or whatever zone you're after
	$dt->setTimezone($tz);
	$callStart = $dt->format('Y-m-d H:i:s');
	$callTimings = $callStart." - to - ".$date;	
	
	$mobile = ltrim($_POST['phone'],"011");
	$mobile = ltrim($mobile,"+");
	$leadId = $callApi->getLeadsData($mobile);
	$data = array('lead_id'=>$leadId['id'],'phone'=>$_POST['phone'],'subject'=>$_POST['subject'],'status'=>$_POST['status'],'priority'=>$_POST['priority'],'description'=>$_POST['description'],'calltype'=>$_POST['calltype'],'call_status'=>$_POST['call'],'agent'=>$_POST['agent'],'duration'=>$_POST['Call_Duration'],'remark'=>$callTimings,'start'=>$_POST['Call_Start_Time'],'created'=>$date);
	$calllogs = $callApi->insertCallLogs($data);
	 
?>