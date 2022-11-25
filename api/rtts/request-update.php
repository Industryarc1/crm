<?php
if(isset($_POST['token']) && $_POST['token']=="requestupdate"){
	  include_once('../../model/function.php');
	  $functions = new functions();
		 include_once('../../model/contacts2function.php');
	    $contacts2functions = new contacts2functions();
		$requestId = $_POST['crm_id'];
		$date = date("Y-m-d H:i:s");
		$remarks = addslashes($_POST['remarks']);
		$status = $_POST['status'];
		$insertData = array('req_id'=>$requestId,'remarks'=>$remarks,'created'=>$date);		
		$reqlogId = $contacts2functions->insertRequestLogs($insertData);
		$updatedata=array('remarks'=>$remarks,'status'=>$status);
		$updatereqId = $contacts2functions->updateRequestReportsById($requestId,$updatedata);
		if($reqlogId != ""){
		     $leadid = $contacts2functions->getleadIdbyreqId($requestId);
		     $leaddetails = $functions->getleadbyId($leadid['lead_id']);
		     $stage = $contacts2functions->getLeadStageByStageId($leaddetails['lead_stage_id']);
		    // $stage = array('stage'=>$stage['stage']);
		     echo $stage['stage'];
			// print_r($stage);
			// echo "Inserted - ".$reqlogId."<br>";
		}else{
		   echo "Not Inserted";
		}
}else{
   	echo "failed";
}
?>
