<?php
	include_once('../../model/testfunction.php');
	$testfunctions = new testfunctions();
	$date = date('Y-m-d H:i:s');
	
	$leadId = "18124";
	$leadInfo = $testfunctions->getLeadsFollowupsByLeadId($leadId,'9000728610');
	echo "<pre>";
	print_r($leadInfo);
	 
?>