<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$taskstatus = array('0'=>'Pending','1'=>'In-Progress','2'=>'Cant be done','3'=>'Completed');
if(isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
    $todate = date("Y-m-d",strtotime($_GET['todate']));
    $tasks=$functions->getTasksbyFromAndToDate($fromdate,$todate);
}
?>
<div class="row" style="margin-top: 30px;">
    <div class="col-sm-12" style="padding: 0;">
        <table class="table table-responsivetable-borderless table-report" id="example">
            <thead>
            <tr>
                <th>Lead</th>
                <th>AssignBy</th>
                <th>AssignTo</th>
                <th>OnDate</th>
                <th>Header</th>
                <th>Task</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
            </thead>
            <?php foreach($tasks as $task){?>
                <tr>
                    <td><strong><?php $lead=$functions->getleadbyId($task['lead_id']);
                                       echo $lead['fname']." ".$lead['lname'];?></strong></td>
                    <td><?php $empby=$functions->getEmployeeByEmpId($task['assigned_by_id']);
                               echo $empby['firstname']." ".$empby['lastname'];;?></td>
                    <td><?php $empto=$functions->getEmployeeByEmpId($task['assigned_to_id']);
                               echo  $empto['firstname']." ".$empto['lastname'];;?></td>
                    <td><?php echo $task['date']?></td>
                    <td><?php echo $task['header']?></td>
                    <td><?php echo $task['task']?></td>
                    <td><?php echo $taskstatus[$task['status']]?></td>
                    <td><?php echo $task['created']?></td>
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