<?php
	include_once('../../model/callapi.php');
	$callApi = new callapis();
	$date = date('Y-m-d');
	
	//$data1 = array('log_test'=>$_GET['number'],'remark'=>$_GET['ext'],'created'=>$date);
	//$callApi->insertCallLogs($data1);
	
	$mobile = ltrim($_GET['number'],"011");
	$calllogs = $callApi->getLeadsData($mobile);
	$data = array_map('utf8_encode', $calllogs);
	echo '{"result":'.json_encode($data).'}';
?>