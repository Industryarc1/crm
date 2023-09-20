<?php
session_start();
include('../config.php');
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$empId=$_SESSION['employee_id'];
$leads = array();
$limit = 10;

if(isset($_POST['name'])){
    $search_pending=$_POST['name'];
    $_SESSION['pending_lead']=$search_pending;
    if (isset($_POST['page']) && $_POST['page']) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }
    $Records=$functions->getCountOfPendingContactsByName($empId,$search_pending,$limit);
    $totrecords= $Records['total'];
    $total_pages=$Records['total_pages'];
    $leads = $functions->getLeadBySeoIdPendingPagination($empId,$search_pending,$page,$limit);
}
/*echo "<pre>";
print_r($total_pages);
exit;*/
?>
<!-- DATA TABLE-->
<div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
    <table class="div2 table table-borderless table-data4 table-scroll-child">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Phone</th>
            <th>Domain</th>
            <th>Channel</th>
            <th>Entry Point</th>
            <th>Lead Status</th>
            <th>Report Code</th>
            <th>Created date</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($leads)){
        foreach($leads as $lead){?>
            <tr>
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
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-sm-10">
        <?php
        $pagLink = "<nav><ul class='pagination light-theme simple-pagination'>";
        for ($i=1; $i<=$total_pages; $i++) {
            $pagLink .= "<li><a href='contact.php?page=".$i."'>".$i."</a></li>";
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
            hrefTextPrefix : 'contact.php?page='
        });
    });
</script>