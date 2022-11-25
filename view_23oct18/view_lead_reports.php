<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$leadGenerationChannel = array('1'=>'IARC-Inbound','2'=>'IARC-Seo','3'=>'MIR-Inbound','4'=>'MIR-Seo','5'=>'Outbound');
if(isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
    $todate = date("Y-m-d",strtotime($_GET['todate']));
    $leads=$functions->getLeadsbyFromAndToDate($fromdate,$todate);
}
?>
<div class="row" style="margin-top: 30px;">
    <div class="col-sm-12" style="padding: 0;">
            <table class="table table-responsivetable-borderless table-report" id="example">
                <thead>
                <tr>
                    <th style="width: 100px;">Profile</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Phone</th>
                    <th>Domain</th>
                    <th>Channel</th>
                    <th>Report Code</th>
                    <th>Created date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <?php foreach($leads as $lead){?>
                <tr>
                     <td><strong><?php echo $lead['fname']?></strong><br>
                         <strong>JOB:</strong><?php echo $lead['job_title']?><br>
                        <strong>Company:</strong> <?php echo $lead['company']?>
                    </td>
                    <td><?php echo $lead['email']?></td>
                    <td><?php echo $lead['country']?></td>
                    <td><?php echo $lead['phone_number']?></td>
                    <td><?php echo $lead['department']?></td>
                    <td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>
                    <td><?php echo $lead['report_code']?></td>
                    <td><?php echo $lead['created']?></td>
                    <td><?php
                        if($lead['status'] ==0){
                           echo "Pending";
                         }elseif($lead['status'] ==1){
                            echo "Approved";
                        }else{
                            echo "Rejected";
                        }
                        ?></td>
                </tr>
                <?php } ?>
            </table>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#example').DataTable( {
           // "pageLength": 10,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print']
        });
    });
</script>