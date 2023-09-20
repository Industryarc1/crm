<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$getmanagers=$functions->getSalesManager();
$leadGenerationChannel = array('1'=>'IARC-Inbound','2'=>'IARC-Seo','3'=>'MIR-Inbound','4'=>'MIR-Seo','5'=>'Outbound');
$leadStages=array('1'=>'Hot','2'=>'Cold','3'=>'Closed','4'=>'Dead','5'=>'Warm','6'=>'Lost','7'=>'Junk');
if(isset($_POST['fromdate']) && isset($_POST['todate'])){
  $ass_fromdate = $_POST['ass_fromdate'];
  $ass_todate =$_POST['ass_todate'];
  $last_fromdate = $_POST['last_fromdate'];
  $last_todate = $_POST['last_todate'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $leadstage = $_POST['lead_stage'];
    $department =$_POST['department'];
    $channel = $_POST['channel'];
    $assign_person= $_POST['assign_person'];
    $data=array('ass_fromdate'=>$ass_fromdate,'ass_todate'=>$ass_todate,'last_fromdate'=>$last_fromdate,'last_todate'=>$last_todate,
    'createdf'=>$fromdate,'createdt'=>$todate,'stage'=>$leadstage,'department'=>$department,'channel'=>$channel,
    'associated_id'=>$assign_person);
    $leads=$functions->getBulkLeadsToAssign($data);
    //print_r($leads);
   // exit;
}
?>
<div class="row" style="margin-top: 10px;">
<div class="row col-sm-12" style="margin-bottom: 10px;">
<div class="col-sm-4">
<label style="margin:0px;">Assign Associate:</label>
<select class="form-control" id="assoiateId" style="width: 100%">
<option value="" selected disabled>Select Here</option>
<?php foreach($getmanagers as $value){ ?>
<option value="<?php echo $value['employee_id'];?>"><?php echo $value['email']; ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-2">
<label></label>
<button class="btn btn-primary" id="bulkassign" style="margin-top:25px;">Assign All</button>
</div>
</div>
    <div class="col-sm-12" style="padding: 0;">
            <table class="table table-responsivetable-borderless table-report" id="example">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Profile</th>
                    <th>Assigned</th>
                    <th>Domain</th>
                    <th>Channel</th>
                    <th>Entry Point</th>
                    <th>Report Code</th>
                    <th>Created date</th>
				               	<th>Stages</th>
                    <th>Status</th>
                </tr>
                </thead>
                <?php foreach($leads as $lead){?>
                <tr>
					               <td><input class="lead_ids" type="hidden" value="<?php echo $lead['id']?>">
					               <?php echo $lead['fname']." ".$lead['lname'];?></td>
                    <td><?php echo $lead['job_title']?></td>
                    <td><?php $empData = $functions->getEmployeeByEmpId($lead['associated_id']);
                       if($lead['associated_id']!= 0){
                        echo $empData['firstname'].' '.$empData['lastname'];
                       }else{
                        echo "Unassigned";
                       }?>
                       </td>
                    <td><?php echo $lead['department']?></td>
                    <td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>
                    <td><?php echo $lead['entry_point']?></td>
                    <td><?php echo $lead['report_code']?></td>
                    <td><?php echo $lead['created']?></td>
					               <td><?php echo $leadStages[$lead['lead_stage_id']];?></td>
                    <td><?php
                        if($lead['status'] ==0){
                           echo "Pending";
                         }elseif($lead['status'] ==1){
                            echo "Approved";
                        }else{
                            echo "Rejected";
                        } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
     </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
		          "ordering": false
        });
       $('#bulkassign').click(function() {
       	alert("Are you sure to assign all these leads?");
          var leadids = [];
          $(".lead_ids" ).each(function() {
             leadids.push($(this).val());
          });
         var assign_to = $("#assoiateId").val();
         //console.log(leadids);
        	$.ajax({
             type: "POST",
             url: 'ajax.php',
             data: ({assignvalues: leadids,assignto:assign_to}),
             success: function(result){
                 //console.log(result);
              alert(":Assigned successfully");
              window.location.reload();
             }
        		});
        });
    });
</script>
