<?php
class testfunctions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }
	
	function getLeadsFollowupsByLeadId($leadId,$mobile)
    {
		$notesQuery = "SELECT * from notes where lead_id=$leadId";
        $dataNotes = $this->dbObject->getAllRows($notesQuery);
		
		$twilioQuery = "SELECT * from call_logs where lead_id=$leadId";
        $dataTwilio = $this->dbObject->getAllRows($twilioQuery);
		
		$threeCxQuery = "SELECT * from 3cx_calls where phone LIKE '%$mobile%'";
        $dataThreeCx = $this->dbObject->getAllRows($threeCxQuery);
		
		$result['notes'] = $dataNotes;
		$result['twilio'] = $dataTwilio;
		$result['threecx'] = $dataThreeCx;
		
        return $result;
    }
	
	function insertTestData($data)
    {
		$table = "logs_test";
        $insertTest = $this->dbObject->insert($table, $data);
        return $insertTest;
    }
}
?>
