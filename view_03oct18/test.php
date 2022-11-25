<?php
	include_once('../model/function.php');
	$functions = new functions();
	//$filter = "";
	$filter = array('email'=>'deep2@gmail.com');
	$data = $functions->getLeadByLeadFilter($filter);
	$arrCount = count($data);
	
	if($arrCount>=1){
		echo "yes";
	}else{
		echo "no";
	}
	
	echo "<pre>";
	print_r($data);
?>