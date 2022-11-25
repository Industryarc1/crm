<?php
session_start();
include_once('../model/function.php');
$functions = new functions();
if(isset($_GET['leadid']) && isset($_GET['colname']) ){
    $date = date("Y-m-d H:i:s");
    $leadid = $_GET['leadid'];
    $colname = $_GET['colname'];
    $value = $_GET['value'];
    $oldValueData = $functions->getleadbyId($leadid);
    $oldValue = $oldValueData[$colname];
    $data=array($colname=>$value,'last_activity'=>$date);
    $result=$functions->updateLeadDetailsByLeadId($leadid,$data);
    $leadTracks = array('lead_id'=>$leadid,'updated_by'=>$_SESSION['employee_id'],'updated_field'=>$colname,
        'old_value'=>$oldValue,'new_value'=>$value,'activity_time'=>$date);
    $functions->insertLeadUpdates($leadTracks);
    echo $oldValue;
}
/*if(isset($_GET['fname']) || isset($_GET['lname'])|| isset($_GET['email'])|| isset($_GET['jobtitle']) ||
    isset($_GET['phone']) || isset($_GET['reportcode']) || isset($_GET['company']) || isset($_GET['country'])) {*/
if(isset($_GET['filterleads'])){
     $fname=$_GET['fname'];
     $lname=$_GET['lname'];
     $email=$_GET['email'];
      $phone=$_GET['phone'];
      $reportcode=$_GET['reportcode'];
       $jobtitle=$_GET['jobtitle'];
       $company=$_GET['company'];
       $country=$_GET['country'];
       $data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone_number'=>$phone,
            'job_title'=>$jobtitle,'report_code'=>$reportcode,'company'=>$company,'country'=>$country);
       $result=$functions->getSearchData($data);
       print_r($result);
}
if(isset($_GET['leadid']) && isset($_GET['notes']) ) {
    $date = date("Y-m-d H:i:s");
    $leadid = $_GET['leadid'];
    $notes = $_GET['notes'];
     $data = array('lead_id'=>$leadid,'updated_by_id'=>$_SESSION['employee_id'],'note'=>$notes,'created'=>$date);
     $functions->insertNotes($data);
     echo "success";
}
if(isset($_GET['leadid']) && isset($_GET['assignto']) && isset($_GET['header']) && isset($_GET['task'])) {
    $date = date("Y-m-d H:i:s");
    $leadid = $_GET['leadid'];
    $assignto = $_GET['assignto'];
    $header = $_GET['header'];
    $type = rtrim(implode(',', $header), ',');
    $task = $_GET['task'];
    $ondate = date("Y-m-d H:i:s",strtotime($_GET['ondate']));
    $data = array('lead_id'=>$leadid,'assigned_to_id'=>$assignto,'assigned_by_id'=>$_SESSION['employee_id'],
        'header'=>$type,'task'=>$task,'date'=>$ondate,'created'=>$date);
    $functions->insertTasks($data);
    echo "success";
}
if(isset($_GET['leadid']) && isset($_GET['associateid'])){
    $leadid =$_GET['leadid'];
    $date = date("Y-m-d H:i:s");
    $associateId=$_GET['associateid'];
    $data=array('associated_id'=>$associateId,'lead_assigned_date'=>$date,'assigned_by'=>$_SESSION['employee_id']);
    $functions->updateLeadDetailsByLeadId($leadid,$data);

      $tomail =$functions->getToassignedmanageremail($associateId);
      $to =$tomail['email'];
      $subject='Assigned by lead';
      $message='<p>You are assigned by lead</p>';
      //$result=$functions->smtpMail($to,$subject,$message);
      echo 'success';
}
if(isset($_GET['leadid']) && isset($_GET['status'])){
    $leadid =$_GET['leadid'];
    $status=$_GET['status'];
    $leadDetails=$functions->getleadbyId($leadid);
    $empdetails=$functions->getEmployeeByEmpId($_SESSION['employee_id']);
    if($status == 1){
        $data=array('status'=>$status,'approved_by'=>$_SESSION['employee_id']);
        $subject='Approved by '.$empdetails['username'];
        $message='<div>'.$leadDetails['fname'].' is Approved by '.$empdetails['username'].'</div>';
    }else{
        $rejectnote=$_GET['rejectnote'];
        $data=array('status'=>$status,'rejection_note'=>$rejectnote,'rejected_by'=>$_SESSION['employee_id']);
        $subject='Rejected by '.$empdetails['username'];
        $message='<div>'.$leadDetails['fname'].' is Rejected by '.$empdetails['username'].
            '<p>Reason for rejection is '.$rejectnote.'</p></div>';
    }
    $functions->updateLeadDetailsByLeadId($leadid,$data);
    //$to='vishwadeep.singh@industryarc.com';
    $to='y.swapna.1994@gmail.com';
    $result=$functions->smtpMail($to,$subject,$message);
    echo 'success';
}
if(isset($_GET['leadid']) && isset($_GET['name']) && isset($_GET['address']) && isset($_GET['amount']) && isset($_GET['temptype'])) {
    $date = date("Y-m-d H:i:s");
    $leadid = $_GET['leadid'];
    $invoice_num=rand(100000, 999999);
    $code="IARC".$leadid.$invoice_num;
    $amount=$_GET['amount'];
    $paid_amount=$_GET['paid_amount'];
    $purchase_order=$_GET['purchase_order'];
    $name=$_GET['name'];
    $address=$_GET['address'];
    $temptype=$_GET['temptype'];
    $data=array('lead_id'=>$leadid,'invoice_num'=>$code,'amount'=>$amount,'paid_amount'=>$paid_amount,'purchase_order'=>$purchase_order,
        'name'=>$name,'address'=>$address,'created_by'=>$_SESSION['employee_id'],'invoice_template_id'=>$temptype,'created'=>$date);
    $invoice = $functions->InsertInvoice($data);
    $data1=array('invoice_id'=>$invoice);
    $functions->updateLeadDetailsByLeadId($leadid,$data1);
    echo "success";
}
if(isset($_GET['invoiceid']) && isset($_GET['editleadid']) && isset($_GET['editname']) && isset($_GET['editaddress']) && isset($_GET['editamount']) && isset($_GET['edittemptype'])) {
    $date = date("Y-m-d H:i:s");
    $leadid = $_GET['editleadid'];
    $invoice_num=rand(100000, 999999);
    $code="IARC".$leadid.$invoice_num;
    $invoiceid=$_GET['invoiceid'];
    $amount=$_GET['editamount'];
    $paid_amount=$_GET['editpaid_amount'];
    $purchase_order=$_GET['editpurchase_order'];
    $name=$_GET['editname'];
    $address=$_GET['editaddress'];
    $temptype=$_GET['edittemptype'];
    $data=array('lead_id'=>$leadid,'invoice_num'=>$code,'amount'=>$amount,'paid_amount'=>$paid_amount,'purchase_order'=>$purchase_order,
        'name'=>$name,'address'=>$address,'created_by'=>$_SESSION['employee_id'],'invoice_template_id'=>$temptype,'created'=>$date);
    $invoice = $functions->updateInvoiceById($invoiceid,$data);
    echo "success";
}
if(isset($_GET['taskid']) && isset($_GET['status']) && isset($_GET['remarks'])){
    $taskid=$_GET['taskid'];
    $status=$_GET['status'];
    $remarks=$_GET['remarks'];
    echo $remarks;
    $data=array('status'=>$status,'remarks'=>$remarks);
    $result=$functions->updateTaskById($taskid,$data);
     echo "success";
}
if(isset($_POST['deleteval'])){
    $deleteids=$_POST['deleteval'];
    $ids = join(",", $deleteids);
    $result=$functions->deleteLeadsByIds($ids);
    echo $result;
}
?>