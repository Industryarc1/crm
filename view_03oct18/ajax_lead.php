<?php
session_start();
ini_set("display_errors",0);
include('../config.php');
include_once('../model/function.php');
$functions = new functions();
//$leadGenerationChannel = array('1'=>'IARC-Inbound','2'=>'IARC-Seo','3'=>'MIR-Inbound','4'=>'MIR-Seo','5'=>'Outbound');
$getmanagers=$functions->getSalesManager();
$leads = array();
if(isset($_GET['name'])){
    $name=$_GET['name'];
    $leads = $functions->getLeadByNameOrEmail($name);
}
if(isset($_GET['myname'])){
    $myname=$_GET['myname'];
    $empId=$_SESSION['employee_id'];
    $leads = $functions->getmyLeadByNameOrEmail($empId,$myname);
}
if(isset($_GET['filterleads'])){
    $fname=$_GET['fname'];
    $lname=$_GET['lname'];
    $email=$_GET['email'];
    $phone=$_GET['phone'];
    $reportcode=$_GET['reportcode'];
    $jobtitle=$_GET['jobtitle'];
    $company=$_GET['company'];
    $country=$_GET['country'];
    $data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone_number'=>$phone,
        'job_title'=>$jobtitle,'report_code'=>$reportcode,'company'=>$company,'country'=>$country);
    $leads=$functions->getSearchData($data);
}
if(isset($_GET['status'])){
    $status=$_GET['status'];
    if($status == 'all'){
     $leads = $functions->getAllleads();
    }else{
     $leads = $functions->getLeadsByStatus($status);
    }
}

if(isset($_GET['stage'])){
	$stage=$_GET['stage'];
	if($stage == '0'){
	$leads = $functions->getAllleads();
	}else{
	$leads = $functions->getLeadsByLeadStages($stage);
	}
}
//echo "<pre>";
//print_r($leads);
//exit;
if(!empty($leads)){
foreach($leads as $lead){
    ?>
    <tr>
        <td><input type="checkbox" class="checklead" value="<?php echo $lead['id']?>"/></td>
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
<!--        <td><?php /*echo $lead['job_title']*/?></td>
        <td><?php /*echo $lead['company']*/?></td>-->
        <td><?php echo $lead['phone_number']?></td>
        <td><?php echo $lead['department']?></td>
        <td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>
        <td>
            <?php if($lead['associated_id']== 0){?>
                <?php if($lead['status']== 1) {?>
                    <button class="btn assign-btn openassign" data-toggle="modal" data-id="<?php echo $lead['id'];?>"
                            data-target="#assignassociate">Assign</button>
                <?php }else {
                    echo "---";
                }?>
            <?php }else{
                $associatedname=$functions->getEmployeeByEmpId($lead['associated_id']);
                echo $associatedname['firstname'].' '.$associatedname['lastname'];
            }
            ?>
        </td>
		<td><?php echo $leadStages[$lead['lead_stage_id']];?></td>
        <td><?php echo $lead['report_code']?></td>
        <td><?php echo $lead['created']?></td>
        <td>
            <?php if($lead['lead_assigned_date'] == null){
                echo "--";
            }else{
                echo $lead['lead_assigned_date'];
            } ?>
        </td>
        <td><?php if($lead['last_activity'] == null){
                echo "--";
            }else{
                echo $lead['last_activity'];
            } ?>
        </td>
        <td style="width: 130px;"><?php
            if($lead['status'] ==0){?>
               <!-- <input type="hidden" name="leadId" class="leadId" value="<?php /*echo $lead['id'];*/?>"/>-->
                <button class="btn-status accept" value="<?php echo $lead['id'];?>"><i  style="color: green" class="fas fa-check"></i></button>
                <button class="btn-status openreject" data-toggle="modal" value="<?php echo $lead['id'];?>" data-target="#openreject"><i style="color: red" class="fas fa-times"></i></button>
            <?php }elseif($lead['status'] ==1){
                echo "Approved";
            }else{
                echo "Rejected";
            }
            ?></td>
    </tr>
    <?php
}?>
<script>
    $(document).ready(function() {
        $(".checklead").click(function() {
            $(".hide-buttons").toggle();
        });
        $('.openassign').click(function () {
            var myBookId = $(this).data('id');
            // console.log(myBookId);
            $(".modal-body #bookId").val(myBookId);
        });
        $('.accept').click(function () {
            var leadid = $(this).val();
            var status = '1';
            Updatestatus(leadid, status);
        });
        $('.openreject').click(function () {
            var myleadId = $(this).val();
            // console.log(myleadId);
            $(".modal-body #leadid").val(myleadId);
        });
        function Updatestatus(leadid,status,note) {
            $.ajax({
                type: "GET",
                url: 'ajax.php',
                data: ({leadid: leadid,status:status,rejectnote:note}),
                success: function(result){
                    alert("updated successfully");
                    window.location.reload();
                }
            });
        }
    });
</script>
<?php
}
else{
    echo "<tr><td></td><td></td><td></td><td></td><td>Data not Found</td><td></td><td></td><td></td>
<td></td><td></td><td></td><td></td></tr>";
}?>