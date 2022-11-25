<?php
include('nav-head.php');
$getmanagers=$functions->getAllSalesManager();
//echo "<pre>";
$leadids=$functions->getallActiveLeadsByLastActivity();
$leadarray=array_column($leadids, 'id');
//print_r($leadarray);exit;
$ids =implode(", ", array_column($leadids, 'id'));
$notes =$functions->checkLeadsInNotesByCreated($ids);
$notearray=array_column($notes, 'id');
$calls =$functions->checkLeadsIn3cxCallsByCreated($ids);
$callarray=array_column($calls, 'id');
//print_r($notearray);
//print_r($callarray);
$finalLeadsId = array_diff($leadarray,$notearray);
$finalLeadsId = array_diff($finalLeadsId,$callarray);
//print_r(sizeof($finalLeadsId));
$finalleads =implode(", ",$finalLeadsId);
//echo $finalids;
$Leads = $functions->getAllleadsActivityPending($finalleads);
//print_r($Leads);
//exit;
?>
<style>
.date-align{
font-size:15px!important;
}
</style>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
          <h4 style="margin-bottom: 10px;text-align:center;">Activity Pending Leads</h4>
                      <div class="row filters-card" style="margin: 10px 0;">
                          <div class="col-lg-12">
                              <div class="row">
                               <div class="col-sm-4">
                               <input type="hidden" value="<?php echo $finalleads; ?>" id="leadids">
                                    <label style="margin:0px;font-size:14px;">AssignedTo:</label>
                                    <select class="form-control" id="assign_person" name="filter-control">
                                    <option value="" selected disabled>Select Here</option>
                                    <?php foreach($getmanagers as $value){ ?>
                                      <option class="option-display" value="<?php echo $value['employee_id'];?>">
                                      <?php echo $value['email']; ?></option>
                                    <?php } ?>
                                    </select>
                                 </div>
                                   <div class="col-sm-3">
                                     <label style="margin:0px;font-size:14px;">Created From Date:</label>
                                         <div class="input-group controls input-append date task_datetime">
                                             <input  type="text" class="form-control date-align" name="date" id="fromdate">
                                             <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                         </div>
                                    </div>
                                   <div class="col-sm-3">
                                      <label style="margin:0px;font-size:14px;">Created To Date:</label>
                                      <div class="input-group controls input-append date task_datetime">
                                          <input  type="text" class="form-control date-align" name="date" id="todate">
                                          <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                      </div>
                                   </div>
                                  <div class="col-sm-1">
                                  <label></label>
                                      <button class="btn btn-primary" id="leadSearch">Search</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div id="getleads">
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">
                        <table class="table table-responsivetable-borderless table-report" id="example">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Jobtitle</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                     <th>Report Code</th>
                                     <th>AssignedTo</th>
                                     <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                         <?php foreach($Leads as $row){ ?>
                                  <tr>
                                  <td><a href="contact_details.php?lead_id=<?php echo base64_encode($row['id']);?>"
                                   target="_blank"><?php echo $row['fname']." ".$row['lname']; ?></a></td>
                                  <td><?php echo $row['email']; ?></td>
                                  <td><?php echo $row['mobile']; ?></td>
                                  <td><?php echo $row['job_title']; ?></td>
                                  <td><?php echo $row['company']; ?></td>
                                  <td><?php echo $row['department']; ?></td>
                                  <td><?php echo $row['report_code']; ?></td>
                                  <td><?php
                                   $associatedname=$functions->getEmployeeByEmpId($row['associated_id']);
                                   echo $associatedname['firstname'].' '.$associatedname['lastname']; ?></td>
                                   <td><?php echo $row['created']; ?></td>
                                 </tr>
                                 <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('nav-foot.php'); ?>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
      "ordering": false,
        "scrollX": true
    } );
    $("#leadSearch").click(function(){
        var leadids =  $("#leadids").val();
        var assign_person=$("#assign_person").val();
        var fromdate = $("#fromdate").val();
        var todate = $("#todate").val();
        //console.log(leadids);
        //console.log(fromdate);
          $.ajax({
                type: "POST",
                url: 'ajax/ajax_activity_pending.php',
                data: ({ leadids:leadids,fromdate:fromdate,todate: todate,assign_person:assign_person}),
                success: function(result){
                    //console.log(result);
                    $("#getleads").html(result);
                }
          });
    });
});
</script>
