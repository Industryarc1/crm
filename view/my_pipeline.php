<?php
include('nav-head.php');
$empId=$_SESSION['employee_id'];
 $Dealstages=$accountsfunctions->getDealStages();
$emp_deal_one_count=$accountsfunctions->getCountofEmpDealsByDealId("1",$empId);
$emp_deal_two_count=$accountsfunctions->getCountofEmpDealsByDealId("2",$empId);
$emp_deal_three_count=$accountsfunctions->getCountofEmpDealsByDealId("3",$empId);
$emp_deal_four_count=$accountsfunctions->getCountofEmpDealsByDealId("4",$empId);
$emp_deal_lost_count=$accountsfunctions->getCountofEmpDealsByDealId("0",$empId);
/*--------------------------all data-------------------------*/
$emp_deal_one=$accountsfunctions->getEmpDealsByDealId("1",$empId);
$emp_deal_two=$accountsfunctions->getEmpDealsByDealId("2",$empId);
$emp_deal_three=$accountsfunctions->getEmpDealsByDealId("3",$empId);
$emp_deal_four=$accountsfunctions->getEmpDealsByDealId("4",$empId);
$emp_deal_lost=$accountsfunctions->getEmpDealsByDealId("0",$empId);
/*echo "<pre>";
print_r($deal_one);
exit;*/
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content">
        <div class="container-fluid"  style="margin-bottom: 10px;">
            <div class="row filters-card">
                <div class="col-md-3">
                    <label style="margin-bottom: 0">From Date:</label>
                    <div class="input-group controls input-append date task_datetime">
                        <input  type="text" class="form-control date-align" name="date" id="from_date"">
                        <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label style="margin-bottom: 0">To Date:</label>
                    <div class="input-group controls input-append date task_datetime">
                        <input  type="text" class="form-control date-align" name="date" id="to_date"">
                        <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label></label>
                    <button class="btn btn-primary" style="margin-top: 20px;" id="deal_emp_filter">Filter</button>
                </div>
            </div>
        </div>
        <h3 style="margin-bottom: 5px;">My Deals :</h3>
        <div id="filter_deals">
            <!------------------------ filter deals ---------------------------->
            <div class="container-fluid" style="background: #F3F5F6">
                <div class="row" style="border: 1px solid #B9BABB">
                    <div class="col-sm-7 five-three">
                        <div class="row">
                            <div class="col-sm-4 deal_header">
                                Requirement Shared
                                <span class="badge"><?php echo $emp_deal_one_count['count']; ?></span>
                            </div>
                            <div class="col-sm-4 deal_header">
                                Proposal sent
                                <span class="badge"><?php echo $emp_deal_two_count['count']; ?></span>
                            </div>
                            <div class="col-sm-4 deal_header">
                                Quotation Approved
                                <span class="badge"><?php echo $emp_deal_three_count['count']; ?></span>
                            </div><!-- end inner row -->
                        </div>
                    </div>
                    <div class="col-sm-5 five-two">
                        <div class="row">
                            <div class="col-sm-6 deal_header">
                                Deal Closed
                                <span class="badge"><?php echo $emp_deal_four_count['count']; ?></span>
                            </div>
                            <div class="col-sm-6 deal_header">
                                Lost
                                <span class="badge"><?php echo $emp_deal_lost_count['count']; ?></span>
                            </div>
                        </div><!-- end inner row -->
                    </div>
                </div>
                <div class="row" style="height:400px;overflow:auto;">
                    <div class="col-sm-7 five-three">
                        <div class="row" style="height: 400px;">
                            <div class="col-sm-4 deal_text">
                                <?php
                                $sum = 0;
                                foreach ($emp_deal_one as $row){
                                    $lead=$functions->getleadbyId($row['lead_id']);
                                    $sum += $row['exp_deal_amount'];
                                    ?>
                                    <div class="deal_content">
                                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                                        <strong>
                                            <a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                               target="_blank"><?php echo $lead['fname']." ".$lead['lname'];?></a>
                                        </strong>
                                        <span style="float: right">$<?php echo $row['exp_deal_amount']; ?></span>
                                           <div class="row">
                                            <div class="col-md-10"><?php echo $lead['email']; ?></div>
                                           <div class="col-md-2"><i class="fas fa-arrow-circle-right deal_arrow"
                                            data-toggle="modal" data-id="<?php echo $row['lead_id'];?>" data-target="#DealModal"></i></div>
                                          </div>
                                    </div>

                                <?php } ?>
                                <div class="deal_total">
                                    Total:&nbsp&nbsp$<?php echo $sum; ?>
                                </div>
                            </div>
                            <div class="col-sm-4 deal_text">
                                <?php
                                $sum = 0;
                                foreach ($emp_deal_two as $row){
                                    $lead=$functions->getleadbyId($row['lead_id']);
                                    $sum += $row['exp_deal_amount'];?>
                                    <div class="deal_content">
                                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                                       <strong>
                                            <a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                               target="_blank"><?php echo $lead['fname']." ".$lead['lname'];?></a>
                                        </strong>
                                        <span style="float: right">$<?php echo $row['exp_deal_amount']; ?></span>
                                         <div class="row">
                                          <div class="col-md-10"><?php echo $lead['email']; ?></div>
                                             <div class="col-md-2"><i class="fas fa-arrow-circle-right deal_arrow"
                                               data-toggle="modal" data-id="<?php echo $row['lead_id'];?>" data-target="#DealModal"></i></div>
                                           </div>
                                    </div>
                                <?php } ?>
                                <div class="deal_total">
                                    Total:&nbsp&nbsp$<?php echo $sum; ?>
                                </div>
                            </div>
                            <div class="col-sm-4 deal_text">
                                <?php
                                $sum = 0;
                                foreach ($emp_deal_three as $row){
                                    $lead=$functions->getleadbyId($row['lead_id']);
                                    $sum += $row['exp_deal_amount'];?>
                                    <div class="deal_content">
                                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                                        <strong>
                                            <a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                               target="_blank"><?php echo $lead['fname']." ".$lead['lname'];?></a>
                                        </strong>
                                        <span style="float: right">$<?php echo $row['exp_deal_amount']; ?></span>
                                         <div class="row">
                                          <div class="col-md-10"><?php echo $lead['email']; ?></div>
                                        <div class="col-md-2"><i class="fas fa-arrow-circle-right deal_arrow"
                                        data-toggle="modal" data-id="<?php echo $row['lead_id'];?>" data-target="#DealModal"></i></div>
                                      </div>
                                    </div>
                                <?php } ?>
                                <div class="deal_total">
                                    Total:&nbsp&nbsp$<?php echo $sum; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 five-two">
                        <div class="row" style="height: 400px;">
                            <div class="col-sm-6 deal_text">
                                <?php
                                $sum = 0;
                                foreach ($emp_deal_four as $row){
                                    $lead=$functions->getleadbyId($row['lead_id']);
                                    $sum += $row['exp_deal_amount'];?>
                                    <div class="deal_content">
                                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                                        <strong>
                                            <a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                               target="_blank"><?php echo $lead['fname']." ".$lead['lname'];?></a>
                                        </strong>
                                        <span style="float: right">$<?php echo $row['exp_deal_amount']; ?></span>
                                       <div class="row">
                                       <div class="col-md-12"><?php echo $lead['email']; ?></div>
                                       </div>
                                    </div>
                                <?php } ?>
                                <div class="deal_total">
                                    Total:&nbsp&nbsp$<?php echo $sum; ?>
                                </div>
                            </div>
                            <div class="col-sm-6 deal_text">
                                <?php
                                $sum = 0;
                                foreach ($emp_deal_lost as $row){
                                    $lead=$functions->getleadbyId($row['lead_id']);
                                    $sum += $row['exp_deal_amount'];?>
                                    <div class="deal_content">
                                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                                       <strong>
                                            <a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                               target="_blank"><?php echo $lead['fname']." ".$lead['lname'];?></a>
                                        </strong>
                                        <span style="float: right;font-size: 12px;">
                                       <?php if($row['exp_deal_amount'] != ""){
                                          echo "$".$row['exp_deal_amount'];
                                          }else{
                                            echo "$0";
                                             }?>
                                        </span>
                                        <div class="row">
                                        <div class="col-md-12"><?php echo $lead['email']; ?></div>
                                         </div>
                                    </div>
                                <?php } ?>
                                <div class="deal_total">
                                    Total:&nbsp&nbsp$<?php echo $sum; ?>
                                </div>
                            </div>
                        </div><!-- end inner row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('nav-foot.php'); ?>
<script>
    $(document).ready(function() {
        $("#deal_emp_filter").click(function () {
            var deal_emp_filter="1";
            var from_date=$("#from_date").val();
            var to_date=$("#to_date").val();
            //console.log(from_date);
            $.ajax({
                type: "POST",
                url: 'ajax_deal_filter.php',
                data: ({deal_emp_filter:deal_emp_filter,from_date: from_date,to_date:to_date}),
                success: function(result){
                    // console.log(result);
                    $("#filter_deals").html(result);
                }
            });
        });
          $('.deal_arrow').click(function () {
          var LeadId = $(this).data('id');
            $(".modal-body #LeadId").val(LeadId);
           });
      });
</script>
<!-- The Modal -->
<div class="modal" id="DealModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Deal Stages</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
               <div class="row">
                <input type="hidden" name="LeadId" id="LeadId" value=""/>
                        <div class="col-sm-10 form-group">
                            <label for="usr" style="font-size: 15px;">Deal Stage:</label>
                            <select class="select-modal-rows select_deal" id="deal_id" style="width: 100%">
                            <option value="" selected disabled>Select Stage</option>
                                <?php foreach($Dealstages as $value){ ?>
                                    <option value="<?php echo $value['id'];?>"><?php echo $value['stage'] ?></option>
                                <?php } ?>
                                <option value="0">Deal Lost</option>
                            </select>
                        </div>
              </div>
                <div class="row hide_lost_reason" style="display:none">
                      <div class="col-sm-10 form-group">
                        <label for="usr" style="font-size: 15px;">Lost Reason:*</label>
                         <select id="deal_lost" name="deal_lost" class="form-control contact-label">
                                    <option value="" selected disabled>Select reason</option>
                                    <option value="Data Quality Issue">Data Quality Issue</option>
                                    <option value="Budget Issue">Budget Issue</option>
                                    <option value="Approval Issues">Approval Issues</option>
                                   <option value="No Response">No Response</option>
                                    <option value="My follow-up Issue">My follow-up Issue</option>
                           </select>
                  </div>
              </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="change_pipeline" data-dismiss="modal">Save</button>
      </div>
    </div>
  </div>
</div>