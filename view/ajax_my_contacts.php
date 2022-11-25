<?php
session_start();
include('../config.php');
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$empId=$_SESSION['employee_id'];
$leads = array();
$limit = 10;
$page = 1;
$leadFilter = 0;
foreach($_SESSION['my_filter'] as $key=>$value){
    if($value!="" || $value!=null){
        $leadFilter = 1;
        break;
    }
}
if(isset($_POST['myname'])){
    $myname=$_POST['myname'];
    $_SESSION['my_lead']=$myname;
        if($leadFilter == 1){
            $data=array('company'=>$_SESSION['my_filter']['company'],
                'country'=>$_SESSION['my_filter']['country'],
                'job_title'=>$_SESSION['my_filter']['jobtitle'],
                'phone_number'=> $_SESSION['my_filter']['phone'],
                'report_code'=>$_SESSION['my_filter']['reportcode'],
                'department'=>$_SESSION['my_filter']['department'],
                'status'=>$_SESSION['my_filter']['status'],
                'lead_stage_id'=>$_SESSION['my_filter']['stages'],
                'createdf'=>$_SESSION['my_filter']['createdf'],
                'createdt'=>$_SESSION['my_filter']['createdt'],
                'next_followup_date'=>$_SESSION['my_filter']['nextfollowup'],
                'lead_generation_channel_id'=>  $_SESSION['my_filter']['çhannel'],
                'associated_id'=>$_SESSION['my_filter']['associateid']);
            $Records=$functions->getCountOfMyLeadsByNameAndSearchData($empId,$data,$myname,$limit);
            $totrecords= $Records['total'];
            $total_pages=$Records['total_pages'];
            $leads = $functions->getMyleadsByNameAndSearchDataPagination($empId,$data,$myname,$page,$limit);
        }else {
            $Records = $functions->getnumSearchRecordsOfMyLeadsByMyName($empId, $myname, $limit);
            $totrecords= $Records['total'];
            $total_pages=$Records['total_pages'];
            $leads = $functions->getmyLeadsByNamePagination($empId, $myname, $page, $limit);
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
    $channel =$_POST['çhannel'];
    $associatedid =$_POST['associateid'];

    $_SESSION['my_filter']['company']=$company;
    $_SESSION['my_filter']['country']=$country;
    $_SESSION['my_filter']['jobtitle']=$jobtitle;
    $_SESSION['my_filter']['phone']=$phone;
    $_SESSION['my_filter']['reportcode']=$reportcode;
    $_SESSION['my_filter']['department']=$department;
    $_SESSION['my_filter']['status']=$status;
    $_SESSION['my_filter']['stages']=$stage;
    $_SESSION['my_filter']['createdf']=$createdf;
    $_SESSION['my_filter']['createdt']=$createdt;
    $_SESSION['my_filter']['nextfollowup']=$nextfollowup;
    $_SESSION['my_filter']['çhannel']=$channel;
    $_SESSION['my_filter']['associateid']=$associatedid;
    $data=array('company'=>$company,'country'=>$country,'job_title'=>$jobtitle,'phone_number'=>$phone,
        'report_code'=>$reportcode,'department'=>$department,'status'=>$status,
        'lead_stage_id'=>$stage,'createdf'=>$createdf,'createdt'=>$createdt,'next_followup_date'=>$nextfollowup,
        'lead_generation_channel_id'=>$channel,'associated_id'=>$associatedid);
        if($_SESSION['my_lead']== "" || $_SESSION['my_lead'] == null) {
            $Records = $functions->getCountOfSearchDataInMyContacts($empId, $data, $limit);
            $totrecords= $Records['total'];
            $total_pages=$Records['total_pages'];
            $leads = $functions->getSearchDataInMyContactsPagination($empId, $data, $page, $limit);
        }else{
            $Records=$functions->getCountOfMyLeadsByNameAndSearchData($empId,$data,$myname,$limit);
            $totrecords= $Records['total'];
            $total_pages=$Records['total_pages'];
            $leads = $functions->getMyleadsByNameAndSearchDataPagination($empId,$data,$myname,$page,$limit);
        }
}
/*echo "<pre>";
print_r($leads);
exit();*/
?>

<!-- DATA TABLE-->
<div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
    <table class="div2 table table-borderless table-data4 table-scroll-child">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Phone</th>
            <th>Domain</th>
            <!--<th>Channel</th>-->
            <th>Entry Point</th>
            <th>Lead Associate</th>
            <th>Lead Status</th>
            <th>Report Code</th>
            <th>Created Date</th>
            <th>Assigned Date</th>
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
                            <div style="font-size: 12px;"><?php echo $lead['job_title']; ?></div>
                            <div style="font-size: 12px;"><?php echo $lead['company']; ?></div>
                        </div>
                    </div>
                </td>
                <td><?php echo $lead['email']?></td>
                <td><?php echo $lead['country']?></td>
                <td><?php echo $lead['phone_number']?></td>
                <td><?php echo $lead['department']?></td>
                <!--<td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>-->
                <td><?php echo $lead['entry_point']?></td>
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
                            <button class="reassign-btn openassign" data-toggle="modal" data-id="<?php echo $lead['id'];?>"
                                    data-target="#assignassociate"><img src="images/icon/reassign.jpg"></button>
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
    $pagLink = "<nav><ul class='pagination light-theme simple-pagination'>";
    for ($i=1; $i<=$total_pages; $i++) {
        $pagLink .= "<li><a href='my_contacts.php?page=".$i."'>".$i."</a></li>";
    };
    echo $pagLink . "</ul></nav></div>";
    echo "<div class='col-sm-2'><p style='float:right'>Records:
                            <strong>". $totrecords ."</strong></p></div>";
    ?>
</div>
<!-- END DATA TABLE-->
<script type="text/javascript">
    //jquery.noconflict();
    $(document).ready(function(){
        $('.pagination').pagination({
            items: <?php echo $total_pages*$limit;?>,
            itemsOnPage: <?php echo $limit; ?>,
            cssStyle: 'light-theme',
            currentPage : <?php echo $page;?>,
            hrefTextPrefix : 'my_contacts.php?page='
        });
    });
</script>
<script type="text/javascript" src="js/jquery.simplePagination.js"></script>
