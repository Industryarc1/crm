<?php
if(isset($_POST['token']) && $_POST['token']=="updatereq"){
		include_once('../../model/contacts2function.php');
	    $contacts2functions = new contacts2functions();
		$requestId = $_POST['crm_id'];
		$date = date("Y-m-d H:i:s");
		$esttimeline = $_POST['est_timeline'];
		$estresources = $_POST['est_resource'];
		$estprjcost = $_POST['est_cost'];
		$updatedata=array('est_prj_timeline'=>$esttimeline,'est_resources'=>$estresources,'est_prj_cost'=>$estprjcost);
		$updatereqId = $contacts2functions->updateRequestReportsById($requestId,$updatedata);
		if($updatereqId){
		   echo "Updated";
		}else{
		   echo "Not Updated";
		}
}else{
   	echo "failed";
}
?>
