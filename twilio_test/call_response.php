<?php
include_once('../model/function.php');
$functions = new functions();
$date = date("Y-m-d H:i:s");

$date = date("Y-m-d H:i:s");
$data = array('lead_id'=>$_GET['LeadId'],'contact'=>$_GET['contact'],'call_sid'=>$_POST['CallSid'],'recording'=>$_POST['RecordingUrl'],'recording_sid'=>$_POST['RecordingSid'],'created'=>$date); 
$functions->insertCallLogs($data);
?>