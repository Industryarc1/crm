<?php
session_start();
include_once('../model/function.php');
$functions = new functions();
include_once('../model/accountsfunction.php');
$accountsfunctions= new accountsfunctions();
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
if(isset($_POST['leadid']) && isset($_POST['notes']) ) {
    $date = date("Y-m-d H:i:s");
    $leadid = $_POST['leadid'];
    $notes = $_POST['notes'];
     $data = array('lead_id'=>$leadid,'updated_by_id'=>$_SESSION['employee_id'],'note'=>base64_encode($notes),'created'=>$date);
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
		$getleaddetails=$functions->getleadbyId($leadid);
		$employeename=$functions->getEmployeeByEmpId($_SESSION['employee_id']);
		$to =$tomail['email'];
		$subject='Lead Assigned';
		// $message='<p>You are assigned by lead</p>';
		$message=' <div class="col-sm-3">
		<h5>Dear '.$tomail['firstname'].' '.$tomail['lastname'].',</h5>
		</div>
		<div class="col-sm-8">
		<p><br>Below lead is assigned to you by '.$employeename['firstname'].' '.$employeename['lastname'].' </p>
		<div class="row" style="background-color:lightgrey;font-size: 13px;">
		<table>
		<tr>
		<th style="padding:5px;">First Name</th>
		<th>:</th>
		<td>'.$getleaddetails['fname'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Last Name</th>
		<th>:</th>
		<td>'.$getleaddetails['lname'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Email</th>
		<th>:</th>
		<td>'.$getleaddetails['email'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Company</th>
		<th>:</th>
		<td>'.$getleaddetails['company'].'</td>
		</tr> <tr>
		<th style="padding:5px;">Job Title</th>
		<th>:</th>
		<td>'.$getleaddetails['job_title'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Contact Number</th>
		<th>:</th>
		<td>'.$getleaddetails['phone_number'].'</td>
		</tr>
		</table>
		</div>
		</div>
		<div class="col-sm-3">
		<br>Thanks,<br>
		<strong>IndustryArc</strong>
		</div>';
      $result=$functions->smtpMail($to,$subject,$message);
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
    $to='vishwadeep.singh@industryarc.com';
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

if(isset($_POST['emp_status']) && isset($_POST['emp_id'])){
	$empId=$_POST['emp_id'];
	$status=$_POST['emp_status'];
	$data=array('status'=>$status);
	$result=$functions->UpdateEployeeStatus($empId,$data);
	echo $result;
}
if(isset($_POST['removeFilter'])){
     unset($_SESSION['filter']);
     unset($_SESSION['acc_filter']);
     unset($_SESSION['proj_filter']);
     unset($_SESSION['account']);
     unset($_SESSION['my_filter']);
     unset($_SESSION['lead']);
     unset($_SESSION['my_lead']);
     unset($_SESSION['limit']);
     unset($_SESSION['invoice_fromdate']);
     unset($_SESSION['invoice_todate']);
}

if(isset($_GET['invoiceid']) && isset($_GET['paidamount']) && isset($_GET['paytype'])){
	$date = date("Y-m-d H:i:s");
    $invoiceid = $_GET['invoiceid'];
	$data=array('paid_amount'=>$_GET['paidamount'], 'transaction_id'=>$_GET['transactionid'],'payment_type'=>$_GET['paytype'],
	'remarks'=>$_GET['remarks']);
	$invoice = $functions->updateInvoiceById($invoiceid,$data);
	echo "success";
}

if(isset($_GET['invoiceid']) && $_GET['invoiceid']!=""){
	$invoiceid=$_GET['invoiceid'];
	$data=$functions->getInvoiceById($invoiceid);
	print_r(json_encode($data));
}

if(isset($_POST['multiple_accIds']) && $_POST['assign_to']!=""){
	$date = date("Y-m-d H:i:s");
	$accids=$_POST['multiple_accIds'];
	$accIds=join(",",$accids);
	$assign_to=$_POST['assign_to'];
	$result=$accountsfunctions->UpdateAccountByultipleAssignIds($accIds,$assign_to,$date);
	//echo $result;
	$tomail =$functions->getToassignedmanageremail($assign_to);
	// $getAccountdetails=$accountsfunctions->getAccountByaccountId($accId);
	$to =$tomail['email'];
	$subject='Account has been Assigned';
	// $message='<p>You are assigned by lead</p>';
	$message=' <div class="col-sm-3">
	<h5>Dear '.$tomail['firstname'].' '.$tomail['lastname'].',</h5>
	</div>
	<div class="col-sm-8">
	<p><br>Accounts has been assigned to you.Please check your dashboard.</p>
	</div>
	<div class="col-sm-3">
	<br>Thanks,<br>
	<strong>IndustryArc</strong>
	</div>';
	$result=$functions->smtpMail($to,$subject,$message);
	echo 'success';
}
if(isset($_POST['accId']) && $_POST['assign_to']!=""){
	$accId=$_POST['accId'];
	$date = date("Y-m-d H:i:s");
	$assign_to=$_POST['assign_to'];
	$data=array('assign_to'=>$assign_to,'assigned_date'=>$date);
	$result=$accountsfunctions->UpdateAccountByAssignId($accId,$data);
	//echo $result;
	$tomail =$functions->getToassignedmanageremail($assign_to);
	$getAccountdetails=$accountsfunctions->getAccountByaccountId($accId);
	$to =$tomail['email'];
	$subject='Account has been Assigned';
	// $message='<p>You are assigned by lead</p>';
	$message=' <div class="col-sm-3">
	<h5>Dear '.$tomail['firstname'].' '.$tomail['lastname'].',</h5>
	</div>
	<div class="col-sm-8">
	<p><br>Below Account is assigned to you.</p>
	<div class="row" style="background-color:lightgrey;font-size: 13px;">
	<table>
	<tr>
	<th style="padding:5px;">Company Name</th>
	<th>:</th>
	<td>'.$getAccountdetails['company_name'].'</td>
	</tr>
	<tr>
	<th style="padding:5px;">Country</th>
	<th>:</th>
	<td>'.$getAccountdetails['country'].'</td>
	</tr>
	<tr>
	<th style="padding:5px;">Industry</th>
	<th>:</th>
	<td>'.$getAccountdetails['main_industry'].'</td>
	</tr>
	<tr>
	<th style="padding:5px;">Total Revenue($ Million)</th>
	<th>:</th>
	<td>'.$getAccountdetails['total_revenue'].'</td>
	</tr> <tr>
	<th style="padding:5px;">Employee Size</th>
	<th>:</th>
	<td>'.$getAccountdetails['employee_size'].'</td>
	</tr>
	</table>
	</div>
	</div>
	<div class="col-sm-3">
	<br>Thanks,<br>
	<strong>IndustryArc</strong>
	</div>';
	$result=$functions->smtpMail($to,$subject,$message);
	echo 'success';
}

if(isset($_GET['accountid']) && isset($_GET['colname']) ){
	$date = date("Y-m-d H:i:s");
	$accountid = $_GET['accountid'];
	$colname = $_GET['colname'];
	$value = $_GET['value'];
	$data=array($colname=>$value);
	$result=$accountsfunctions->updateAccountDetailsByAccountId($accountid,$data);
	echo $result;
}

if(isset($_POST['contact_id']) && $_POST['contact_id'] != "" ){
	$contactid= $_POST['contact_id'];
	$contactdetails=$accountsfunctions->getContactsById($contactid);
	$date = date("Y-m-d H:i:s");
	$data=array(
	'fname'=>$contactdetails['f_name'],
	'lname'=>$contactdetails['l_name'],
	'company'=>$contactdetails['company'],
	'job_title'=>$contactdetails['designation'],
	'email'=>$contactdetails['email'],
	'mobile'=>$contactdetails['phone_one'],
	'phone_number'=>$contactdetails['phone_two'],
	'country'=>$contactdetails['country'],
	'company_url'=>$contactdetails['url'],
	'linkedin_bio'=>$contactdetails['linkedin_url'],
	'created'=>$date,
	'lead_generation_channel_id'=>"5",
	'status'=>"1",
	'lead_stage_id'=>"2",
	'associated_id'=>$_SESSION['employee_id'],
	'entry_point'=>"Added from contacts"
	);
	$leadid=$accountsfunctions->insertContactAslead($data);
	if($leadid != ""){
		$status=array('status'=>"1");
		$result=$accountsfunctions->UpdateContactById($status,$contactid);
	}
	echo $result;
}

if(isset($_POST['deal_amount']) && $_POST['deal_amount'] != "" && $_POST['deal_date'] != "" && $_POST['deal_stage'] != "" ) {
	$leadid = $_POST['lead_id'];
	$lead_stage_id = $_POST['lead_stage_id'];
	$deal_value = $_POST['deal_amount'];
	$deal_date = $_POST['deal_date'];
	$deal_stage = $_POST['deal_stage'];
	$date = date("Y-m-d H:i:s");
	$updated_by = $_SESSION['employee_id'];
	$ifexits = $accountsfunctions->CheckleadidInPipeline($leadid);
	// print_r($ifexits);
	if($ifexits['count'] == 0){
	$data=array(
	'lead_id'=>$leadid,
	'lead_stage_id'=>$lead_stage_id,
	'updated_by'=>$updated_by,
	'exp_deal_amount'=>$deal_value,
	'exp_deal_closure'=>$deal_date,
	'deal_stage_id'=>$deal_stage,
	'created'=>$date
	);
	$result=$accountsfunctions->insertPipeline($data);
	}else{
	$data=array(
	'lead_stage_id'=>$lead_stage_id,
	'updated_by'=>$updated_by,
	'exp_deal_amount'=>$deal_value,
	'exp_deal_closure'=>$deal_date,
	'deal_stage_id'=>$deal_stage
	);
	$result=$accountsfunctions->UpdatePipeline($leadid,$data);
	}
	echo $result;
}
if(isset($_POST['reason']) && $_POST['reason'] != "") {
	$leadid = $_POST['lead_id'];
	$lead_stage_id = $_POST['lead_stage_id'];
	$reason = $_POST['reason'];
	$date = date("Y-m-d H:i:s");
	$updated_by = $_SESSION['employee_id'];
	$ifexits = $accountsfunctions->CheckleadidInPipeline($leadid);
	if($ifexits['count'] == 0){
	$data=array(
	'lead_id'=>$leadid,
	'lead_stage_id'=>$lead_stage_id,
	'updated_by'=>$updated_by,
	'deal_stage_id'=>"0",
	'remarks'=>$reason,
	'created'=>$date
	);
	$result=$accountsfunctions->insertPipeline($data);
	}else{
	$data=array(
	'lead_stage_id'=>$lead_stage_id,
	'updated_by'=>$updated_by,
	'deal_stage_id'=>"0",
	'remarks'=>$reason
	);
	$result=$accountsfunctions->UpdatePipeline($leadid,$data);
	}
	echo $result;
}

if(isset($_POST['Lead_deal_Id']) && $_POST['Lead_deal_Id'] != "" && $_POST['Deal_Stage'] != ""){
   $Deal_lead_id=$_POST['Lead_deal_Id'];
   $deal_stage_id=$_POST['Deal_Stage'];
   $lost_reason=$_POST['lost_reason'];
   $updated_by = $_SESSION['employee_id'];
   if($deal_stage_id == 4){
             $leaddata= array('lead_stage_id'=> "3");
             $updateLead=$functions->updateLeadDetailsByLeadId($Deal_lead_id,$leaddata);
             $data = array('lead_stage_id'=> "3",'updated_by'=>$updated_by,'deal_stage_id'=> $deal_stage_id);
             $result=$accountsfunctions->UpdatePipeline($Deal_lead_id,$data);
   } elseif ($deal_stage_id == 0){
        $leaddata= array('lead_stage_id'=>"6");
        $updateLead=$functions->updateLeadDetailsByLeadId($Deal_lead_id,$leaddata);
        $data = array('lead_stage_id'=> "6",'deal_stage_id'=> $deal_stage_id,'updated_by'=>$updated_by,
        'remarks'=>$lost_reason);
        $result=$accountsfunctions->UpdatePipeline($Deal_lead_id,$data);
   }else{
          $data=array('deal_stage_id'=>$deal_stage_id);
         $result=$accountsfunctions->UpdatePipeline($Deal_lead_id,$data);
   }
   echo $result;
}

if(isset($_POST['assignvalues']) && $_POST['assignvalues'] != "" && $_POST['assignto'] != ""){
	$assignids=$_POST['assignvalues'];
	$leadids = join(",", $assignids);
	$assignto=$_POST['assignto'];
	$result=$functions->MultipleAssignLeadsByIds($leadids,$assignto);
	echo $result;
}

?>
