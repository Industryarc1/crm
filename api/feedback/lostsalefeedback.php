<?php
if(isset($_POST['token']) && $_POST['token']=="insertLostFeedback"){
		include_once('../../model/feedbackfunc.php');
		$functions = new feedbackfuncs();
		$date = date("Y-m-d H:i:s");
		$feedbackData = array('email'=>$_POST['email'],'reach_expectation'=>$_POST['expectation'],'requirement_understand'=>$_POST['reqrundstd'],'reason'=>$_POST['reason'],'created'=>$date);		
		$feedbackId = $functions->insertLostSaleFeedback($feedbackData);
		echo "Inserted";
}else{
	echo "failed";
}
?>