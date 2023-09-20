<?php
session_start();
include_once('../model/mailsync.php');
$mailsyncs = new mailsyncs();
$emp_id=$_SESSION['employee_id'];
$email=$_SESSION['email'];
$leadMail = $_POST['leadMail'];
$leadId = $_POST['leadId'];
$username = $email;
$password =  base64_decode($_SESSION['mail_password']);
$date = date("Y-m-d H:i:s");
$oneMonth = date("j F Y", strtotime("-30 day"));

$hostname ="{imap-mail.outlook.com:993/ssl/novalidate-cert}Sent Items";
$inbox = imap_open($hostname,$username,$password) or die("Cannot connect to Mail: ".imap_last_error());
$emails = imap_search($inbox,'TO "'.$leadMail.'" SINCE "'.$oneMonth.'"');

if($emails) {
	$output = '';
	rsort($emails);
	foreach($emails as $email_number) {
		$overview = imap_fetch_overview($inbox,$email_number,0);
		$message = imap_fetchbody($inbox,$email_number,1);
		$body = quoted_printable_decode($message);
		
		$checkMailExist = $mailsyncs->checkExistingMail($leadId,$overview[0]->msgno,$overview[0]->udate);
		if(!$checkMailExist){
			$data = array('lead_id'=>$leadId,'employee_id'=>$emp_id,'from_mail'=>$overview[0]->from,'to_mail'=>$overview[0]->to,'subject_mail'=>$overview[0]->subject,'body'=>$body,'mail_date'=>$overview[0]->date,'message_id'=>$overview[0]->message_id,'uid'=>$overview[0]->uid,'msgno'=>$overview[0]->msgno,'udate'=>$overview[0]->udate,'syncdate'=>$date);
			$notesMailId = $mailsyncs->insertNotesMail($data);
			if($notesMailId){
				$data1 = array('lead_id'=>$leadId,'updated_by_id'=>$emp_id,'note'=>$body,'created'=>$date,'notes_mail_id'=>$notesMailId);
				$mailsyncs->insertNotesBySync($data1);
			}
		}
	}	
} 
imap_close($inbox);


$hostnameinbox ="{imap-mail.outlook.com:993/ssl/novalidate-cert}INBOX";
$inbox1 = imap_open($hostnameinbox,$username,$password) or die("Cannot connect to Mail: ".imap_last_error());
$emails1 = imap_search($inbox1,'FROM "'.$leadMail.'" TO "'.$username.'" SINCE "'.$oneMonth.'"');

if($emails1) {
	$output = '';
	rsort($emails1);
	foreach($emails1 as $email_number1) {
		$overview = imap_fetch_overview($inbox1,$email_number1,0);
		$message1 = imap_fetchbody($inbox1,$email_number1,1);
		$body = quoted_printable_decode($message1);
		
		$checkMailExist = $mailsyncs->checkExistingMail($leadId,$overview[0]->msgno,$overview[0]->udate);
		if(!$checkMailExist){
			$data = array('lead_id'=>$leadId,'employee_id'=>$emp_id,'from_mail'=>$overview[0]->from,'to_mail'=>$overview[0]->to,'subject_mail'=>$overview[0]->subject,'body'=>$body,'mail_date'=>$overview[0]->date,'message_id'=>$overview[0]->message_id,'uid'=>$overview[0]->uid,'msgno'=>$overview[0]->msgno,'udate'=>$overview[0]->udate,'syncdate'=>$date);
			$notesMailId = $mailsyncs->insertNotesMail($data);
			if($notesMailId){
				$data1 = array('lead_id'=>$leadId,'updated_by_id'=>$emp_id,'note'=>$body,'created'=>$date,'notes_mail_id'=>$notesMailId);
				$mailsyncs->insertNotesBySync($data1);
			}
		}		
	}	
} 
imap_close($inbox1);

echo "success";

?>