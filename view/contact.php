<?php
include('nav-head.php');
//$leads = $functions->getAllleads();
$getmanagers=$functions->getSalesManager();
$empId=$_SESSION['employee_id'];
$limit = 10;
if (isset($_GET['page']) && $_GET['page']) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
if($_SESSION['pending_lead']== "" || $_SESSION['pending_lead'] == null) {
    $Records = $functions->getnumSearchRecordsPending($empId,$limit);
    $totrecords= $Records['total'];
    $total_pages=$Records['total_pages'];
$leads = $functions->getAllleadsPendingPagination($empId, $page, $limit);
}else{
    $search_pending=$_SESSION['pending_lead'];
    $Records=$functions->getCountOfPendingContactsByName($empId,$search_pending,$limit);
    $totrecords= $Records['total'];
    $total_pages=$Records['total_pages'];
    $leads = $functions->getLeadBySeoIdPendingPagination($empId,$search_pending,$page,$limit);
}
/*echo "<pre>";
print_r($total_pages);
exit;*/
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row filters-card">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-1"><label class="control-label" for="search">Filter</label></div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input class="form-control" type="search" id="search_pending" placeholder="Search Here" value="<?php echo $_SESSION['pending_lead'];?>"/>
                                <input class="form-control" type="hidden" id="search_page" value="<?php echo $_GET['page'];?>"/>
                                <span class="input-group-addon"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-2"><a href="add_contact.php" style="float: right;">
                                <button class="add-contact">Add Contact<i style="padding-left: 5px;font-size: 12px;" class="fas fa-plus"></i></button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12" style="padding: 0;" id="filter-leads">
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
                            <?php foreach($leads as $lead){?>
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
                </div>
            </div>
        </div>
        <?php
        include('nav-foot.php');?>
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
 <script type="text/javascript" src="js/jquery.simplePagination.js"></script>
