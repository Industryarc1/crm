<?php
session_start();
include('../config.php');
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$leads = array();
if($_SESSION['limit']==""){
    $limit = 10;
}else{
    $limit  = $_SESSION['limit'];
}
$page = 1;
$leadFilter = 0;
foreach($_SESSION['filter'] as $key=>$value){
    if($value!="" || $value!=null){
        $leadFilter = 1;
        break;
    }
}
if(isset($_POST['name'])){
    $name=$_POST['name'];
    $_SESSION['lead']=$name;
    if($leadFilter == 1){
        $data=array('company'=>$_SESSION['filter']['company'],
            'country'=>$_SESSION['filter']['country'],
            'job_title'=>$_SESSION['filter']['jobtitle'],
            'phone_number'=> $_SESSION['filter']['phone'],
            'report_code'=>$_SESSION['filter']['reportcode'],
            'department'=>$_SESSION['filter']['department'],
            'status'=>$_SESSION['filter']['status'],
            'lead_stage_id'=>$_SESSION['filter']['stages'],
            'createdf'=>$_SESSION['filter']['createdf'],
            'createdt'=>$_SESSION['filter']['createdt'],
            'next_followup_date'=>$_SESSION['filter']['nextfollowup'],
            'lead_generation_channel_id'=>  $_SESSION['filter']['çhannel'],
            'associated_id'=>$_SESSION['filter']['associateid'],
            'assignedf'=>$_SESSION['filter']['assignedf'],
             'assignedt'=>$_SESSION['filter']['assignedt'],
             'last_activityf'=>$_SESSION['filter']['last_activityf'],
             'last_activityt'=>$_SESSION['filter']['last_activityt']);
        $Records=$functions->getCountOfAllLeadsByNameAndSearchData($data,$name,$limit);
        $totrecords= $Records['total'];
        $total_pages=$Records['total_pages'];
        $leads=$functions->getAllleadsByNameAndSearchDataPagination($data,$name,$page,$limit);
    }else {
        $Records = $functions->getnumSearchRecordsOfAllLeadsByName($name, $limit);
        $totrecords= $Records['total'];
        $total_pages=$Records['total_pages'];
        $leads = $functions->getAllLeadsByNamePagination($name,$page, $limit);
    }
}
if(isset($_POST['filterleads']) && $_POST['filterleads']!=""){
    $company=$_POST['company'];
    $country=$_POST['country'];
    $jobtitle=$_POST['jobtitle'];
    $phone=$_POST['phone'];
    $reportcode=$_POST['reportcode'];
    $department=$_POST['department'];
    $status=$_POST['status'];
    $stage=$_POST['stages'];
    $createdf = $_POST['createdf'];
    $createdt = $_POST['createdt'];
    $nextfollowup = $_POST['nextfollowup'];
    $channel =$_POST['channel'];
    $associatedid =$_POST['associateid'];
    $assignedf = $_POST['assignedf'];
    $assignedt = $_POST['assignedt'];
     $last_activityf = $_POST['last_activityf'];
     $last_activityt = $_POST['last_activityt'];

      $_SESSION['filter']['company']=$company;
      $_SESSION['filter']['country']=$country;
      $_SESSION['filter']['jobtitle']=$jobtitle;
      $_SESSION['filter']['phone']=$phone;
      $_SESSION['filter']['reportcode']=$reportcode;
      $_SESSION['filter']['department']=$department;
      $_SESSION['filter']['status']=$status;
      $_SESSION['filter']['stages']=$stage;
      $_SESSION['filter']['createdf']=$createdf;
      $_SESSION['filter']['createdt']=$createdt;
      $_SESSION['filter']['nextfollowup']=$nextfollowup;
      $_SESSION['filter']['çhannel']=$channel;
      $_SESSION['filter']['associateid']=$associatedid;
        $_SESSION['filter']['assignedf']=$assignedf;
        $_SESSION['filter']['assignedt']=$assignedt;
        $_SESSION['filter']['last_activityf']=$last_activityf;
        $_SESSION['filter']['last_activityt']=$last_activityt;

    $data=array('company'=>$company,'country'=>$country,'job_title'=>$jobtitle,'phone_number'=>$phone,
    'report_code'=>$reportcode,'department'=>$department,'status'=>$status,'lead_stage_id'=>$stage,
    'createdf'=>$createdf,'createdt'=>$createdt,'next_followup_date'=>$nextfollowup,'lead_generation_channel_id'=>$channel,
    'associated_id'=>$associatedid,'assignedf'=>$assignedf,'assignedt'=>$assignedt,'last_activityf'=>$last_activityf,
    'last_activityt'=>$last_activityt);
  if($_SESSION['lead']== "" || $_SESSION['lead'] == null) {
      $Records = $functions->getCountOfSearchDataInAllContacts($data, $limit);
      $totrecords= $Records['total'];
      $total_pages=$Records['total_pages'];
      $leads = $functions->getSearchDataInAllContactsPagination($data, $page, $limit);
  }else{
      $name = $_SESSION['lead'];
      $Records=$functions->getCountOfAllLeadsByNameAndSearchData($data,$name,$limit);
      $totrecords= $Records['total'];
      $total_pages=$Records['total_pages'];
      $leads=$functions->getAllleadsByNameAndSearchDataPagination($data,$name,$page,$limit);
  }
}
/*echo "<pre>";
print_r($total_pages);
exit();*/
?>

<!-- DATA TABLE-->
<div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
    <table class="div2 table table-borderless table-data4 table-scroll-child">
        <thead>
        <tr>
            <th><input type="checkbox" id="check_all"/></th>
            <th>Name</th>
            <th>Job</th>
            <th>Email</th>
            <th>Country</th>
            <th>Phone</th>
            <th>Domain</th>
            <?php //if($_SESSION['role_id']== 1){?><th>Channel</th><?php //} ?>
            <th>Entry Point</th>
			<th>UTM Source</th>
            <th>Lead Associate</th>
            <th>Lead Status</th>
            <th>Report Code</th>
            <th>Created date</th>
            <th>Assigned date</th>
            <th>Last Activity</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($leads)){
            foreach($leads as $lead){?>
                <tr>
                    <td>
                        <input type="checkbox" class="checklead" value="<?php echo $lead['id']?>"/></td>
                    <td>
                        <div class="row" style="width: 200px;">
                            <div class="col-sm-3 contact_profile-img-align" style="position: unset"><?php echo ucfirst($lead['fname'][0]);?></div>
                            <div class="col-sm-9" style="position: unset"><a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                                                             target="_blank"><?php echo $lead['fname']?></a>
                                <!--<div style="font-size: 12px;"><?php echo $lead['job_title']; ?></div>-->
                                <div style="font-size: 12px;"><?php echo $lead['company']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $lead['job_title']?></td>
                    <td><?php echo $lead['email']?></td>
                    <td><?php echo $lead['country']?></td>
                    <td><?php echo $lead['phone_number']?></td>
                    <td><?php echo $lead['department']?></td>
                    <?php i//f($_SESSION['role_id']== 1){?><td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td><?php //} ?>
                    <td><?php echo $lead['entry_point']?></td>
					<td><?php echo $lead['lead_source']?></td>
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
                    <td><?php
                        if($lead['status'] ==0){?>
                            <button class="btn-status accept" value="<?php echo $lead['id'];?>"><i  style="color: green" class="fas fa-check"></i></button>
                            <button class="btn-status openreject" data-toggle="modal" value="<?php echo $lead['id'];?>" data-target="#openreject"><i style="color: red" class="fas fa-times"></i></button>
                        <?php }elseif($lead['status'] ==1){
                            echo "Approved";
                            if($lead['associated_id']!="0"){?>
                                <!--<button class="reassign-btn openassign" data-toggle="modal" data-id="<?php echo $lead['id'];?>"
                                        data-target="#assignassociate"><img src="images/icon/reassign.jpg"></button>-->
								<span class="openassign" data-toggle="modal" data-id="<?php echo $lead['id'];?>" data-target="#assignassociate" style="background-color:powderblue;">ReAssign</span>
                            <?php }
                        }else{
                            echo "Rejected";
                        }
                        ?></td>
                </tr>
                <?php
            }
        }
        else{
            echo "<tr></tr><tr><td></td><td></td><td></td><td></td><td>Data not Found</td><td></td><td></td><td></td>
           <td></td><td></td><td>Data not Found</td><td></td><td></td><td></td></tr><tr></tr>";
        }?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-10">
        <?php
        $i=1;
		$pagLink = "<nav><ul class='pagination light-theme simple-pagination'>
		<li><a href='contacts.php?page= ".$i."'>Prev</a></li>
		<li><a href='contacts.php?page=".$total_pages."'>Next</a></li>";
		echo $pagLink . "</ul></nav></div>";
        echo "<div class='col-sm-2'><p style='float:right'>
          Records:<strong>". $totrecords ."</strong></p></div>";
        ?>
    </div>
<!-- END DATA TABLE-->
<script>
    $(document).ready(function() {
        $(".checklead").click(function() {
            if($(':checkbox:checked').length > 0){
                $(".hide-buttons").show();
            }else{
                $(".hide-buttons").hide();
            }
        });
        $("#delete").click(function () {
            //alert("Are you sure to delete these leads?");
            var val = [];
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
            $.ajax({
                type: "POST",
                url: 'ajax.php',
                data: ({deleteval: val}),
                success: function(result){
                    //console.log(result);
                    window.location.reload();
                }
            });
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
<script type="text/javascript">
    //jquery.noconflict();
    $(document).ready(function(){
        $('.pagination').pagination({
            items: <?php echo $total_pages*$limit;?>,
            itemsOnPage: <?php echo $limit; ?>,
            cssStyle: 'light-theme',
            currentPage : <?php echo $page;?>,
            hrefTextPrefix : 'contacts.php?page='
        });
    });
</script>
<script type="text/javascript" src="js/jquery.simplePagination.js"></script>
