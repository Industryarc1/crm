<?php
include_once('../../model/olampmodel.php');
$oLampModel = new olampModels();
$leadId = $_GET['leadid'];
$leadInfo = $oLampModel->getLeadInfoByLeadId($leadId);
$jobTitle = strtolower($leadInfo['job_title']);
$email = $leadInfo['email'];
$entryPoint = $leadInfo['entry_point'];
$trmc = $leadInfo['title_related_my_company'];
$txtComments = strlen($leadInfo['txt_comments']);
$leadRevenue = $oLampModel->getLeadCompanyRevenueAndEmpSize($email);
$revenue = $leadRevenue['total_revenue'];
$empSize = $leadRevenue['employee_size'];

$getRevenuePoint = $oLampModel->getRevenuePoints($revenue);
$getEmpSizePoint = $oLampModel->getEmpSizePoints($empSize);
$getInqueryBeforePurchasePoint = ($entryPoint=="RBB" || $entryPoint=="Inquiry before Purchase" || $entryPoint=="Inquiry Before Buying")?5:0;

$getSeniorityPoint = 0;
if(preg_match('[director|vice president|president|ceo|chief]', $jobTitle)){
	$getSeniorityPoint = 5;
}elseif(preg_match('[manager]', $jobTitle)){
	$getSeniorityPoint = 2.5;
}else{
	$getSeniorityPoint = 1;
}

$getSampleBrochhurePoint = 0;
if(preg_match('[sample brochrue|sample brochure|sample request]', strtolower($entryPoint))){
	if($txtComments<5){
		$getSampleBrochhurePoint = 1;
	}else{
		if($trmc=="No"){
			$getSampleBrochhurePoint = 2.5;
		}else{
			$getSampleBrochhurePoint = 3.5;
		}		
	}
}else{
	$getSampleBrochhurePoint = 0;
}

$leadValue = $getRevenuePoint+$getEmpSizePoint+$getInqueryBeforePurchasePoint+$getSeniorityPoint+$getSampleBrochhurePoint;
$lqs = $leadValue*0.4;
$leadQualityEvolution = ($lqs<3)?"Low":(($lqs>=3 && $lqs<7)?"Med":"High");
//echo $leadQualityEvolution;
echo '{"leadquality":"'.$leadQualityEvolution.'","lqs":"'.$lqs.'"}';
?>