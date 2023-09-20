<?php
if(isset($_POST['token']) && $_POST['token']=="insertReportFeedback"){
		include_once('../../model/feedbackfunc.php');
		$functions = new feedbackfuncs();
		$date = date("Y-m-d H:i:s");
		$feedbackData = array('email'=>$_POST['email'],'quality'=>$_POST['quality'],'accuracy'=>$_POST['accuracy'],'insights_trendzs'=>$_POST['insightTrendz'],'improvements'=>$_POST['improvements'],'requirements'=>$_POST['requirements'],'testimonials'=>$_POST['testimoni'],'refers'=>$_POST['refer'],'created'=>$date);		
		$feedbackId = $functions->insertReportFeedback($feedbackData);
		echo "Inserted";
}else{
	echo "failed";
}
?>