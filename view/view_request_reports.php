<?php
	include('nav-head.php');
  $reqid = base64_decode($_GET['req_id']);
 	//to get logs data of request reports
 	include_once('../model/contacts2function.php');
  $contacts2functions = new contacts2functions();
  //to get data of request reports by id
  $Presentstatus =$contacts2functions->getRequestReportById($reqid);
 	//to get logs data of request reports by id
 // $req_logs=$contacts2functions->getRequestReportLogsById($reqid);
 ?>
  <!-- MAIN CONTENT-->
  <div class="main-content" xmlns="http://www.w3.org/1999/html">
     <div class="section__content">
        <div class="container-fluid">
           <h4 style="margin:15px;">Request Report Details :</h4>
           <div class="row filters-card">
              <div class="col-md-12">Report Status : <strong>
                 <?php if($Presentstatus['status'] == 2){
                       echo "Graphics Work Completed";
                   }else if($Presentstatus['status'] == 1){
                        echo "Research Work Completed";
                   }else{
                        echo "Initiated";
                 }?></strong></div>
              <?php if($Presentstatus['status'] == 2){ ?>
              <div class="col-md-12">Remarks: <strong><?php echo $Presentstatus['remarks']; ?></strong></div>
              <?php } ?>
			  <div class="col-md-12">Request Id: <strong><?php echo $Presentstatus['unique_id']; ?></strong></div>
              <div class="col-md-12">Company: <strong><?php echo $Presentstatus['company']; ?></strong></div>
			  <div class="col-md-12">Title: <strong><?php echo $Presentstatus['title_name']; ?></strong></div>
              <div class="col-md-12">Department: <strong><?php echo $Presentstatus['department']; ?></strong></div>
              <div class="col-md-12">Priority: <strong><?php echo $Presentstatus['priority']; ?></strong></div>
              <div class="col-md-12">Deadline: <strong><?php
                 $date= date("Y-m-d");
                 if(strtotime($date) >= strtotime($Presentstatus['deadline'])){
                    echo "<b style='color:red;'>".$Presentstatus['deadline']."</b>";
                 }else{
                   echo $Presentstatus['deadline'];
                 }?></strong></div>
			<div class="col-md-12">Comments: <strong><?php echo $Presentstatus['comments']; ?></strong></div>
              <?php if($Presentstatus['remarks']!="" || $Presentstatus['remarks']!=null){ ?>
              <div class="col-md-12">Title:  <strong><?php echo $Presentstatus['title_name']; ?></strong></div>
              <div class="col-md-12">RequestType: <strong><?php echo $Presentstatus['report_type']; ?></strong></div>
              <div class="col-md-12">Created On : <strong><?php echo $Presentstatus['created']; ?></strong></div>
			  <div class="col-md-12">Estimated Timeline:  <strong><?php echo $Presentstatus['est_prj_timeline']; ?></strong></div>
              <div class="col-md-12">Estimated Resources: <strong><?php echo $Presentstatus['est_resources']; ?></strong></div>
              <div class="col-md-12">Estimated Cost : <strong><?php echo $Presentstatus['est_prj_cost']; ?></strong></div>
              <?php } ?>
           </div>
          <!--<h4 style="margin:15px;">Request Logs:</h4>
          <?php
              foreach ($req_logs as $row){ ?>
			  <div class="row filters-card">
              <div class="col-md-9">
                 Remarks : <strong><?php echo $row['remarks']; ?></strong>
              </div>
              <div class="col-md-3">
                 Update Date : <strong><?php echo $row['created']; ?></strong>
              </div>
           </div>-->
           <?php } ?>
        </div>
     </div>
  </div>
  </div>
  </div>
  <?php include('nav-foot.php'); ?>