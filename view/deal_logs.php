<?php
include('nav-head.php');
$leadid = base64_decode($_GET['lead_id']);

$present_deal=$accountsfunctions->getDealByLeadId($leadid);
$deal_logs=$accountsfunctions->getDealLogsOfDealId($present_deal['id']);
/*echo "<pre>";
print_r($present_deal);
print_r($deal_logs);
exit;*/
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content">
   <div class="container-fluid">
     <h4 style="margin:15px;">Present Stage :</h4>
     <div class="row filters-card">
      <div class="col-md-3">Lead Stage : <strong><?php echo $leadStages[$present_deal['lead_stage_id']]; ?></strong></div>
      <div class="col-md-3">Updated By : <strong><?php
      $empid=$functions->getEmployeeByEmpId($present_deal['updated_by']);
      echo $empid['firstname']." ".$empid['lastname']; ?></strong></div>
       <div class="col-md-3">Deal closure Date: <strong><?php echo $present_deal['exp_deal_closure']; ?></strong></div>
       <div class="col-md-3"> Deal Stage : <strong><?php echo $dealStages[$present_deal['deal_stage_id']]; ?></strong></div>
       <div class="col-md-3">Deal Amount: <strong>$<?php echo $present_deal['exp_deal_amount']; ?></strong></div>
       <div class="col-md-3">Created Date : <strong><?php echo $present_deal['created']; ?></strong></div>
        <?php if($present_deal['remarks']!="" || $present_deal['remarks']!=null){ ?>
         <div class="col-md-3">Remarks: <strong><?php echo $present_deal['remarks']; ?></strong></div>
        <?php } ?>
      </div>
                <h4 style="margin:15px;">Deal logs:</h4>
<?php
foreach ($deal_logs as $row){ ?>
  <div class="row filters-card">
   <div class="col-md-3">
     Lead Stage : <strong><?php echo $leadStages[$row['lead_stage_id']]; ?></strong>
     </div>
   <div class="col-md-3">
   Update By : <strong><?php
     $empid=$functions->getEmployeeByEmpId($present_deal['updated_by']);
       echo $empid['firstname']." ".$empid['lastname'];?></strong>
   </div>
 <div class="col-md-3">
   Update Date : <strong><?php echo $row['updated_date']; ?></strong>
   </div>
    <div class="col-md-3">
    Deal Stage : <strong><?php echo $dealStages[$row['deal_stage_id']]; ?></strong>
      </div>
       <div class="col-md-3">
        Expected Deal Amount: <strong><?php echo $row['exp_deal_amount']; ?></strong>
         </div>
          <div class="col-md-3">
          Expected Deal Closure:<strong><?php echo $row['exp_deal_closure']; ?></strong>
            </div>
             <?php if($present_deal['remarks']!="" || $present_deal['remarks']!=null){ ?>
             <div class="col-md-3">
              Remarks : <strong><?php echo $row['remarks']; ?></strong>
               </div>
        <?php } ?>
</div>
 <?php } ?>
</div>
    </div>
    </div>
 </div>
</div>
<?php include('nav-foot.php'); ?>
