<?php
session_start();
include('../config.php');
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$getmanagers=$functions->getSalesManager();
$leads = array();
if(isset($_GET['name'])){
    $search_pending=$_GET['name'];
    $empId=$_SESSION['employee_id'];
    $leads = $functions->getLeadBySeoIdPending($empId,$search_pending);
}
/*echo "<pre>";
print_r($leads);*/
if(!empty($leads)){
foreach($leads as $lead){
?>
    <tr>
        <td>
            <div class="row" style="width: 200px;">
                <div class="col-sm-3 contact_profile-img-align"><?php echo ucfirst($lead['fname'][0]);?></div>
                <div class="col-sm-9"><a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                         target="_blank"><?php echo $lead['fname']?></a>
                    <div style="font-size: 12px;"><?php echo $lead['job_title']; ?></div>
                </div>
            </div>
        </td>
        <td><?php echo $lead['email']?></td>
        <td><?php echo $lead['country']?></td>
        <!-- <td><?php /*echo $lead['job_title']*/?></td>
        <td><?php /*echo $lead['company']*/?></td>-->
        <td><?php echo $lead['phone_number']?></td>
        <td><?php echo $lead['department']?></td>
        <td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>
		<td><?php echo $lead['entry_point']?></td>
        <td><?php echo $leadStages[$lead['lead_stage_id']];?></td>
        <td><?php echo $lead['report_code']?></td>
        <td><?php echo $lead['created']?></td>
    </tr>
    <?php
}
}
else{
    echo "<tr><td></td><td></td><td></td><td></td><td>Data not Found</td><td></td><td></td><td></td>
<td></td><td></td></tr>";
}?>
