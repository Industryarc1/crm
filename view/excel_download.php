<?php
session_start();
ini_set("display_errors",0);
include('../config.php');
include_once('../model/function.php');
$functions = new functions();

$leads = array();
$data=array('company'=>$_SESSION['filter']['company'],
            'country'=>$_SESSION['filter']['country'],
            'job_title'=>$_SESSION['filter']['jobtitle'],
            'phone_number'=> $_SESSION['filter']['phone'],
            'report_code'=>$_SESSION['filter']['reportcode'],
            'department'=>$_SESSION['filter']['department'],
            'status'=>$_SESSION['filter']['status'],
            'lead_stage_id'=>$_SESSION['filter']['stages'],
            'createdf'=>$_SESSION['filter']['createdf'],
            'createdt'=>$_SESSION['filter']['createdt'],
            'next_followup_date'=>$_SESSION['filter']['nextfollowup'],
            'lead_generation_channel_id'=>  $_SESSION['filter']['çhannel'],
            'associated_id'=>$_SESSION['filter']['associateid'],
              'assignedf'=>$_SESSION['filter']['assignedf'],
              'assignedt'=>$_SESSION['filter']['assignedt'],
              'last_activityf'=>$_SESSION['filter']['last_activityf'],
               'last_activityt'=>$_SESSION['filter']['last_activityt']);

$leads=$functions->getAllLeadsByAppliedfilter($data);
$dataBody = [];
$i = 1;
foreach($leads as $row){

$associatedname=$functions->getEmployeeByEmpId($row['associated_id']);

    $dataBody[] = [$row['fname'],$row['lname'],$row['email'],$row['phone_number'],$row['mobile'],$row['job_title'],
    $leadStatus[$row['status']],$associatedname['firstname'].' '.$associatedname['lastname'],$leadStages[$row['lead_stage_id']],
    $leadGenerationChannel[$row['lead_generation_channel_id']],$row['country'], $row['department'],$row['report_code'],
    $row['report_name'],$row['entry_point'],$row['lead_assigned_date'],$row['created'],$row['next_followup_date'],
    $row['last_activity'],$row['pub_date'],$row['linkedin_bio'],$row['company_url'],$row['txt_comments']];
}

$downloadtime = date("Y-m-d");
$download_logs = array("type"=>"LEADS","emp_id"=>$_SESSION['employee_id'],"emp_name"=>$_SESSION['name'],"records"=>count($dataBody),"datetime"=>$downloadtime);
$functions->insertDownloadLogs($download_logs);

$dataHeader =[['FirstName','LastName','Email','Phone Number','Mobile','Job Title','Status','AssignedTo','Stage','Generation Channel',
'Country','Department','ReportCode','ReportName','Entry Point','Assigned Date','Created date','NextFollowUp Date','LastActivity Date',
'Publish Date','LinkedIn Bio','Company Url','Comments']];
$result = array_merge($dataHeader,$dataBody);

array_to_csv_download($result,"leads.csv");
function array_to_csv_download($array, $filename = "Lead_data.csv", $delimiter=",") {
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'";');
  $f = fopen('php://output', 'w');
      foreach ($array as $line) {
          fputcsv($f, $line, $delimiter);
      }
}
exit;
?>
