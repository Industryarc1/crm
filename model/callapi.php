<?php
class callapis
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }
	
	function insertCallLogs($data)
    {
		$table = "3cx_calls";
        $insertCallLogs = $this->dbObject->insert($table, $data);
        return $insertCallLogs;
    }
	
	function getLeadsData($mobile){
		$leadQuery = "SELECT * FROM leads WHERE REPLACE(REPLACE(REPLACE(phone_number, ' ', ''), '-', ''), '+', '') LIKE '%$mobile%' ORDER BY id DESC";
        $result = $this->dbObject->getRow($leadQuery);
        return $result;
	}
	
	function updateCallLogs($data){
		$table_name = "3cx_calls";
        $search_by = array('employee_id' => $empid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
	}

}
?>
