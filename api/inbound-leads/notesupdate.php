<?php

if(isset($_POST['token']) && $_POST['token']=="deeptest"){
		include_once('../../model/function.php');
		$functions = new functions();		
		$notesData = array('lead_id'=>$_POST['leadid'],'note'=>$_POST['note'],'created'=>$_POST['notedate']);		
		$leadId = $functions->insertNotes($notesData);
		echo "Inserted - ".$leadId."<br>";
}else{
	echo "failed";
}
?>