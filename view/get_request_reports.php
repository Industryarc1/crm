<?php
	include('nav-head.php');
	//to get data in request reports
	include_once('../model/contacts2function.php');
 $contacts2functions = new contacts2functions();
 $EmpId=$_SESSION['employee_id'];
 //print_r($EmpId);exit;
  if($_SESSION['role_id'] == 4 && $_SESSION['team_id'] == 2){
     $PendingReports=$contacts2functions->getPendingRequestReportsByEmp($EmpId);
     $CompletedReports=$contacts2functions->getCompletedRequestReportsByEmp($EmpId);
  }else{
     $PendingReports= $contacts2functions->getALLPendingRequestReports();
     $CompletedReports=$contacts2functions->getALLCompletedRequestReports();
  }
// echo "<pre>";
 //print_r($PendingReports);
 //print_r($EmpId);exit;
 ?>
<!-- MAIN CONTENT-->
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
           <h4 style="margin-bottom: 10px;text-align:center;">Requested Reports</h4>
            <div class="row" style="margin: 10px 0;">
               <div class="col-lg-12">
                <ul class="nav nav-tabs" style="background: #ffffff;margin-bottom:10px;">
                   <li><a data-toggle="tab" href="#pending" class="leads_inactive_tab active" style="width: 488px!important;">Pending</a></li>
                   <li><a data-toggle="tab" href="#completed" class="leads_inactive_tab" style="width: 488px!important;">Completed</a></li>
                </ul>
        <!---------------- Tab view ---------------->
                <div class="tab-content">
                   <div id="pending" class="tab-pane fade in active">
                   <!--------------- DATA TABLE------------------------->
                         <div class="table-responsive m-b-40">
                             <table class="table table-responsivetable-borderless table-report" id="pending_datatable">
                                 <thead>
                                     <tr>
                                       <th>RequestId</th>
                                       <th>Lead Name</th>
                                       <th>Company</th>
                                       <th>Title</th>
                                       <?php if($_SESSION['role_id']== 1 || ($_SESSION['role_id']== 3 && $_SESSION['team_id']== 2)){?>
                                       <th>RequestedBy</th>
                                       <?php }?>
                                       <th>Priority</th>
                                       <th>Deadline</th>
                                       <th>ReportType</th>
                                       <th>Status</th>
                                       <!--<th>Remarks</th>-->
                                     </tr>
                                 </thead>
                               <tbody>
                                <?php foreach($PendingReports as $row){ ?>
                                 <tr>
                                  <td><?php echo $row['unique_id']; ?></td>
                               <td><a href="view_request_reports.php?req_id=<?php echo base64_encode($row['id']);?>"  target="_blank">
                                 <?php $leads=$functions->getleadbyId($row['lead_id']);
                                   echo $leads['fname']." ".$leads['lname']; ?></a></td>
                               <td><?php echo $row['company']; ?></td>
                               <td><?php echo $row['title_name']; ?></td>
                               <?php if($_SESSION['role_id']== 1 || ($_SESSION['role_id']== 3 && $_SESSION['team_id']== 2)){?>
                                <td><?php
                                $EmpDetails =$functions->getEmployeeByEmpId($row['requested_by']);
                                echo $EmpDetails['firstname'].' '.$EmpDetails['lastname']; ?>
                                </td>
                                <?php }?>
                               <td><?php echo $row['priority']; ?></td>
                               <td><?php
                                $date= date("Y-m-d");
                                if(strtotime($date) >= strtotime($row['deadline'])){
                                   echo "<b style='color:red;'>".$row['deadline']."</b>";
                                }else{
                                  echo $row['deadline'];
                                }
                                ?></td>
                               <td><?php echo $row['report_type']; ?></td>
                               <td><?php if($row['status'] == 2){
                                    echo "Graphics Work Completed";
                                }else if($row['status'] == 1){
                                     echo "Research Work Completed";
                                 }else{
                                     echo "Initiated";
                                 }?></td>
                                <!--<td><?php echo $row['remarks']; ?></td>-->
                                </tr>
                                <?php } ?>
                               </tbody>
                             </table>
                         </div>
                   <!-- END DATA TABLE-->
                       </div>
                        <div id="completed" class="tab-pane fade">
                   <!--------------- DATA TABLE------------------------->
                           <div class="table-responsive m-b-40">
                               <table class="table table-responsivetable-borderless table-report" id="completed_datatable">
                                   <thead>
                                       <tr>
                                         <th>RequestId</th>
                                         <th>Lead Name</th>
                                         <th>Company</th>
                                         <th>Title</th>
                                         <?php if($_SESSION['role_id']== 1 || ($_SESSION['role_id']== 3 && $_SESSION['team_id']== 2)){?>
                                         <th>RequestedBy</th>
                                         <?php }?>
                                         <th>Priority</th>
                                         <th>Deadline</th>
                                         <th>ReportType</th>
                                         <th>Status</th>
                                         <th>Remarks</th>
                                       </tr>
                                   </thead>
                                 <tbody>
                                  <?php foreach($CompletedReports as $row){ ?>
                                   <tr>
                                    <td><?php echo $row['unique_id']; ?></td>
                                 <td><a href="view_request_reports.php?req_id=<?php echo base64_encode($row['id']);?>"  target="_blank">
                                   <?php $leads=$functions->getleadbyId($row['lead_id']);
                                     echo $leads['fname']." ".$leads['lname']; ?></a></td>
                                 <td><?php echo $row['company']; ?></td>
                                 <td><?php echo $row['title_name']; ?></td>
                                 <?php if($_SESSION['role_id']== 1 || ($_SESSION['role_id']== 3 && $_SESSION['team_id']== 2)){?>
                                  <td><?php
                                  $EmpDetails =$functions->getEmployeeByEmpId($row['requested_by']);
                                  echo $EmpDetails['firstname'].' '.$EmpDetails['lastname']; ?>
                                  </td>
                                  <?php }?>
                                 <td><?php echo $row['priority']; ?></td>
                                 <td><?php
                                  $date= date("Y-m-d");
                                  if(strtotime($date) >= strtotime($row['deadline'])){
                                     echo "<b style='color:red;'>".$row['deadline']."</b>";
                                  }else{
                                    echo $row['deadline'];
                                  }
                                  ?></td>
                                 <td><?php echo $row['report_type']; ?></td>
                                 <td><?php if($row['status'] == 2){
                                         echo "Graphics Work Completed";
                                     }else if($row['status'] == 1){
                                          echo "Research Work Completed";
                                      }else{
                                          echo "Initiated";
                                      }?></td>
                                  <td><?php echo $row['remarks']; ?></td>
                                  </tr>
                                  <?php } ?>
                                 </tbody>
                               </table>
                           </div>
                     <!-- END DATA TABLE-->
                        </div>
                    </div>
                <!---------------- Tab view END---------------->
               </div>
            </div>
       </div>
   </div>
</div>
<?php include('nav-foot.php'); ?>
<script>
$(document).ready(function() {
    $('#pending_datatable').DataTable({
        "pageLength": 10,
         "ordering": false,
         "scrollX": false,
    });
    $('#completed_datatable').DataTable({
        "pageLength": 10,
         "ordering": false,

    });
});
</script>
