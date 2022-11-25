<?php
session_start();
include('../config.php');
ini_set("display_errors",0);
include_once('../model/accountsfunction.php');
include_once('../model/function.php');
$accountsfunctions= new accountsfunctions();
$functions= new functions();

if(isset($_POST['deal_filter']) && $_POST['deal_filter'] != "") {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $updated_by = $_POST['updated_by'];
    $data = array('from_date' => $from_date, 'to_date' => $to_date,
        'updated_by' => $updated_by);
    $deal_one_count = $accountsfunctions->getCountofAllSearchDealsByDealId($data, "1");
    $deal_two_count = $accountsfunctions->getCountofAllSearchDealsByDealId($data, "2");
    $deal_three_count = $accountsfunctions->getCountofAllSearchDealsByDealId($data, "3");
    $deal_four_count = $accountsfunctions->getCountofAllSearchDealsByDealId($data, "4");
    $deal_lost_count = $accountsfunctions->getCountofAllSearchDealsByDealId($data, "0");
    /*--------------------------all data-------------------------*/
    $deal_one=$accountsfunctions->getAllSearchDealsByDealId($data,"1");
    $deal_two=$accountsfunctions->getAllSearchDealsByDealId($data,"2");
    $deal_three=$accountsfunctions->getAllSearchDealsByDealId($data,"3");
    $deal_four=$accountsfunctions->getAllSearchDealsByDealId($data,"4");
    $deal_lost=$accountsfunctions->getAllSearchDealsByDealId($data,"0");
    /* echo "<pre>";
   print_r($deal_one_count['count']);
   exit;*/
}

if(isset($_POST['deal_emp_filter']) && $_POST['deal_emp_filter'] != "") {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $data = array('from_date' => $from_date, 'to_date' => $to_date);
    $empId=$_SESSION['employee_id'];
    $deal_one_count = $accountsfunctions->getCountofEmpSearchDealsByDealId($data, "1",$empId);
    $deal_two_count = $accountsfunctions->getCountofEmpSearchDealsByDealId($data, "2",$empId);
    $deal_three_count = $accountsfunctions->getCountofEmpSearchDealsByDealId($data, "3",$empId);
    $deal_four_count = $accountsfunctions->getCountofEmpSearchDealsByDealId($data, "4",$empId);
    $deal_lost_count = $accountsfunctions->getCountofEmpSearchDealsByDealId($data, "0",$empId);
    /*--------------------------all data-------------------------*/
    $deal_one=$accountsfunctions->getEmpSearchDealsByDealId($data,"1",$empId);
    $deal_two=$accountsfunctions->getEmpSearchDealsByDealId($data,"2",$empId);
    $deal_three=$accountsfunctions->getEmpSearchDealsByDealId($data,"3",$empId);
    $deal_four=$accountsfunctions->getEmpSearchDealsByDealId($data,"4",$empId);
    $deal_lost=$accountsfunctions->getEmpSearchDealsByDealId($data,"0",$empId);
   /* echo "<pre>";
   print_r($deal_one);
   exit;*/
}
?>
<!---------------------------------- filter deals ---------------------------->
<div class="container-fluid" style="background: #F3F5F6">
<div class="row" style="border: 1px solid #B9BABB">
    <div class="col-sm-7 five-three">
        <div class="row">
            <div class="col-sm-4 deal_header">
                Requirement Shared
                <span class="badge"><?php echo $deal_one_count['count']; ?></span>
            </div>
            <div class="col-sm-4 deal_header">
                Proposal sent
                <span class="badge"><?php echo $deal_two_count['count']; ?></span>
            </div>
            <div class="col-sm-4 deal_header">
                Quotation Approved
                <span class="badge"><?php echo $deal_three_count['count']; ?></span>
            </div><!-- end inner row -->
        </div>
    </div>
    <div class="col-sm-5 five-two">
        <div class="row">
            <div class="col-sm-6 deal_header">
                Deal Closed
                <span class="badge"><?php echo $deal_four_count['count']; ?></span>
            </div>
            <div class="col-sm-6 deal_header">
                Lost
                <span class="badge"><?php echo $deal_lost_count['count']; ?></span>
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
                foreach ($deal_one as $row){
                    $lead=$functions->getleadbyId($row['lead_id']);
                    $sum += $row['exp_deal_amount'];
                    ?>
                    <div class="deal_content">
                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                        &nbsp<strong>
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
                foreach ($deal_two as $row){
                    $lead=$functions->getleadbyId($row['lead_id']);
                    $sum += $row['exp_deal_amount'];?>
                    <div class="deal_content">
                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                        &nbsp<strong>
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
                foreach ($deal_three as $row){
                    $lead=$functions->getleadbyId($row['lead_id']);
                    $sum += $row['exp_deal_amount'];?>
                    <div class="deal_content">
                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                        &nbsp<strong>
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
                foreach ($deal_four as $row){
                    $lead=$functions->getleadbyId($row['lead_id']);
                    $sum += $row['exp_deal_amount'];?>
                    <div class="deal_content">
                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                        &nbsp<strong>
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
                foreach ($deal_lost as $row){
                    $lead=$functions->getleadbyId($row['lead_id']);
                    $sum += $row['exp_deal_amount'];?>
                    <div class="deal_content">
                        <i class="fa fa-user-circle" style="font-size: 16px;color: gray"></i>
                        &nbsp<strong>
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
<script>
    $(document).ready(function() {
      $('.deal_arrow').click(function () {
        var LeadId = $(this).data('id');
         $(".modal-body #LeadId").val(LeadId);
      });
    });
    </script>
