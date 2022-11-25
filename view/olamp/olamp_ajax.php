<?php
if(isset($_POST['token']) && $_POST['token']=="chart-gen"){
	include_once('../../model/olampmodel.php');
	$oLampModel = new olampModels();
	$getCurrentMonthLeads = $oLampModel->getCurrentMonthLeadsDetails();
	$result = array();
	$lqsSum = 0;
	$i = 0;
	foreach($getCurrentMonthLeads as $row){
		$lqs=$oLampModel->getLeadQualityEvaluation($row['id']);
		$result[$lqs['leadquality']][] = $lqs['lqs'];
		$lqsSum = $lqs['lqs'] + $lqsSum;
		$i = $i + 1;
	}
	$avgLqs = $lqsSum/$i;

	$data = array();
	$data['Low'] = (isset($result['Low']))?count($result['Low']):0;
	$data['Med'] = (isset($result['Med']))?count($result['Med']):0;
	$data['High'] = (isset($result['High']))?count($result['High']):0;
	$data['avglqs'] = $avgLqs;
	$data['lqssum'] = $lqsSum;

	echo json_encode($data);
}else{
	echo '{"error":"Invalid"}';
}
?>