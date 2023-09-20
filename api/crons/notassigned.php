<?php
include_once('../../model/cronfunction.php');
$cronfunctions = new cronfunctions();
$leadGenerationChannel = array('1'=>'IARC-Inbound','2'=>'IARC-Seo','3'=>'MIR-Inbound','4'=>'MIR-Seo','5'=>'Outbound');
$date = date("Y-m-d H:i:s");
$pendingleads = $cronfunctions->getAllNotAssignedLeads();
$leadCount = count($pendingleads);
$message = "Hi All,<br>
Please find below the Not Assigned Leads (".$leadCount.").<br><br>
<table style='100%' border=1>
  <tr>
    <th>Fname</th>
    <th>Lname</th> 
    <th>Email</th>
    <th>Company</th>
    <th>Jobtitle</th>
    <th>Domain</th>
    <th>Channel</th>
    <th>Created</th>
  </tr>
";

//echo "<pre>";
foreach($pendingleads as $pendingLead){
	$message .= "<tr>
    <td>".$pendingLead['fname']."</td>
    <td>".$pendingLead['lname']."</td>
    <td>".$pendingLead['email']."</td>
    <td>".$pendingLead['company']."</td>
    <td>".$pendingLead['job_title']."</td>
    <td>".$pendingLead['department']."</td>
    <td>".$leadGenerationChannel[$pendingLead['lead_generation_channel_id']]."</td>
    <td>".$pendingLead['created']."</td>
  </tr>";
}

$message .= "</table></body></html>";
$to = "mkt@industryarc.com";
$subject = "Not Assigned Leads";
$message = $message;
$cronfunctions->smtpMail($to,$subject,$message);
?>