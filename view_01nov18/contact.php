<?php
include('nav-head.php');
//$leads = $functions->getAllleads();
$getmanagers=$functions->getSalesManager();
$empId=$_SESSION['employee_id'];
$limit = 10;
$total_pages = $functions->getnumSearchRecordsPending($empId,$limit);
if (isset($_GET['page']) && $_GET['page']) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$leads = $functions->getAllleadsPendingPagination($empId,$page,$limit);

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
                                <input class="form-control" type="search" id="search_pending" placeholder="Search Here"/>
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
                <div class="col-sm-12" style="padding: 0;">
                    <!-- DATA TABLE-->
                    <div class="wrapper1">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
                        <table class="div2 table table-borderless table-data4 table-scroll-child">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <!--  <th>Job Title</th>
                                      <th>Company</th>-->
                                <th>Phone</th>
                                <th>Domain</th>
                                <th>Channel</th>
                                <th>Entry</th>
                                <th>Lead Status</th>
                                <th>Report Code</th>
                                <th>Created date</th>
                            </tr>
                            </thead>
                            <tbody id="filter-leads">
                            <?php foreach($leads as $lead){?>
                                <tr>
                                    <td>
                                        <div class="row" style="width: 200px;">
                                            <div class="col-sm-3 contact_profile-img-align"><?php echo ucfirst($lead['fname'][0]);?></div>
                                            <div class="col-sm-9"><a href="contact_details.php?lead_id=<?php echo base64_encode($lead['id']);?>"
                                                                     target="_blank"><?php echo $lead['fname']?></a>
                                                <div style="font-size: 12px;"><?php echo $lead['job_title']; ?></div>
                                                <div style="font-size: 12px;"><?php echo $lead['company']; ?></div>
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
                    <div style="text-align: center;">
                        <?php
                        $pagLink = "<nav><ul class='pagination light-theme simple-pagination'>";
                        for ($i=1; $i<=$total_pages; $i++) {
                            $pagLink .= "<li><a href='contacts.php?page=".$i."'>".$i."</a></li>";
                        };
                        echo $pagLink . "</ul></nav>";
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
                    hrefTextPrefix : 'contacts.php?page='
                });
                $("#getlimit").change(function(){
                    var limit = $('#getlimit').val();
                    console.log(limit);
                    $.ajax({
                        type: "GET",
                        url: 'contact.php',
                        data: ({limit:limit}),
                        success: function(result){
                            window.open("contact.php","_self")
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript" src="js/jquery.simplePagination.js"></script>
