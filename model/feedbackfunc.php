<?php
class feedbackfuncs
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }
	
	function insertReportFeedback($data)
    {
		$table = "report_feedback";
        $insertTest = $this->dbObject->insert($table, $data);
        return $insertTest;
    }
	
	function insertLostSaleFeedback($data)
    {
		$table = "lost_sale_feedback";
        $insertTest = $this->dbObject->insert($table, $data);
        return $insertTest;
    }
}
?>
