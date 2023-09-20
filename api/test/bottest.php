<?php
	include_once('../../model/testfunction.php');
	$testfunctions = new testfunctions();
	$date = date('Y-m-d H:i:s');
	//echo "<pre>";
	//print_r($_GET);
	//echo $_POST['name'];
	
	$dataArray1 = array('log_test'=>serialize($_REQUEST),'created'=>$date);
	$leadInfo1 = $testfunctions->insertTestData($dataArray1);
	
	/* $data = serialize($_GET);
	$dataArray = array('log_test'=>$data,'created'=>$date);
	$leadInfo = $testfunctions->insertTestData($dataArray);
	echo $leadInfo; */
	 
?>