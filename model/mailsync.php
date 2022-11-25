<?php
class mailsyncs
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }

    function checkExistingMail($leadId,$msgNo,$uDate)
    {
        $whr = array('lead_id' => $leadId,'msgno'=>$msgNo,'udate'=>$uDate);
        $notesQuery = $this->dbObject->selectQuery('notes_mail', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($notesQuery);
        return $result;
    }
	
	function insertNotesMail($data)
    {
        $table = "notes_mail";
		//$data['body'] = base64_decode($data['body']);
        $notesMailId = $this->dbObject->insert($table, $data);
        return $notesMailId;
    }
	
	function insertNotesBySync($data)
    {
        $table = "notes";
		//$data['body'] = base64_decode($data['body']);
        $notesId = $this->dbObject->insert($table, $data);
        return $notesId;
    }
}
?>
