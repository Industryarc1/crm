<?php
class cronfunctions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }

    function getAllPendingLeads()
    {
        $leadsQuery = "SELECT * FROM leads WHERE `status`=0 AND DATE(created)>='2018-10-01' AND lead_stage_id IN (1,2,5) ORDER BY created DESC";
        $result = $this->dbObject->getAllRows($leadsQuery);
        return $result;
    }
	
	function getAllNotAssignedLeads(){
		$leadsQuery = "SELECT * FROM leads WHERE associated_id=0 AND `status`=1 AND lead_stage_id IN (1,2,5) AND DATE(created)>='2018-10-01' 
ORDER BY created DESC";
        $result = $this->dbObject->getAllRows($leadsQuery);
        return $result;
	}
	
	function smtpMail($to,$subject,$message){
        require_once('../../PHPMailer/class.phpmailer.php');
        $m_user="salesiarc123@gmail.com";
        $m_pass="iarc@123";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $m_user;
        $mail->Password = $m_pass;
        $mail->SetFrom($m_user, "CRM");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
		$mail->addCC('vishwadeep.singh@industryarc.com');
        $mail->Send();
    }
}
?>
