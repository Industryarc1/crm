<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
if(isset($_GET['extension']) && isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $extension = $_GET['extension'];
    $fromdate = date("Y-m-d", strtotime($_GET['fromdate']));
    $todate = date("Y-m-d", strtotime($_GET['todate']));
    $calllogs=$functions->getCallLogsByExtensionAndDate($extension,$fromdate,$todate);
}
?>
<div class="row" style="margin-top: 10px;">
    <div class="col-sm-12" style="padding: 0;">
        <table class="table table-responsivetable-borderless table-report" id="example">
            <thead>
            <tr>
                <th style="width: 100px;">Lead</th>
                <th>Phone</th>
                <th>Call type</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Call status</th>
                <th>Created</th>
            </tr>
            </thead>
            <?php foreach($calllogs as $call){?>
                <tr>
                    <td><?php if($call['lead_id'] == 0){
					echo "Unknown Lead"; 
					}else { ?>
					<strong><?php $lead=$functions->getleadbyId($call['lead_id']);
					echo $lead['fname']." ".$lead['lname'];?></strong>
					<?php } ?></td>
                    <td><?php echo $call['phone']; ?></td>
                    <td><?php echo $call['calltype']; ?></td>
                    <td><?php echo $call['description']; ?></td>
                    <td><?php echo $call['duration']; ?></td>
                    <td><?php echo $call['call_status']; ?></td>
                    <td><?php echo $call['created']?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#example').DataTable( {
            // "pageLength": 10,
			"ordering": false
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print']
        });
    });
</script>