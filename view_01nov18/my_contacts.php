<?php
include('nav-head.php');
//$leads = $functions->getAllleads();
$channels=$functions->getGenerationChannels();
$countries=$functions->getCountries();
$departments=$functions->getDepartmentLists();
$getmanagers=$functions->getSalesManager();
$empId=$_SESSION['employee_id'];
$limit = 10;
$total_pages = $functions->getnumSearchRecordsOfMyLeads($empId,$limit);
if (isset($_GET['page']) && $_GET['page']) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$leads = $functions->getMyLeadsPagination($empId,$page,$limit);
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
                                <input class="form-control" type="search" id="search_mycontacts" placeholder="Search Here"/>
                                <span class="input-group-addon"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding: 0;">
                            <button class="add-contact" data-toggle="modal" data-target="#openfilter">
                                Add filter</button>
                            <button class="btn btn-danger" id="removefilter" style="font-size: 12px;padding:5px;">
                                Remove filter</button>
                        </div>
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
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <!--  <th>Job Title</th>
                                      <th>Company</th>-->
                                <th>Country</th>
                                <th>Phone</th>
                                <th>Domain</th>
                                <th>Channel</th>
                                <th>Entry</th>
                                <th>Lead Associate</th>
                                <th>Lead Status</th>
                                <th>Report Code</th>
                                <th>Created date</th>
                                <th>Assigned date</th>
                                <th>Last Activity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="filter-leads">
                            <?php foreach($leads as $lead){?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checklead" value="<?php echo $lead['id']?>"/></td>
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
                                    <td><?php echo $lead['phone_number']?></td>
                                    <td><?php echo $lead['department']?></td>
                                    <td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>
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
                    hrefTextPrefix : 'my_contacts.php?page='
                });
                $("#getlimit").change(function(){
                    var limit = $('#getlimit').val();
                    console.log(limit);
                    $.ajax({
                        type: "GET",
                        url: 'my_contacts.php',
                        data: ({limit:limit}),
                        success: function(result){
                            window.location.reload();
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript" src="js/jquery.simplePagination.js"></script>
        <!-- assign associate Modal -->
        <div class="modal fade" id="assignassociate" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" style="font-size: 15px">Modal Lead</p>
                        <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="bookId" id="bookId" value=""/>
                            <div class="col-sm-6 form-group">
                                <label for="usr" style="font-size: 12px">Assign Associate:</label>
                                <select class="select-modal-rows" id="assoiateId" style="width: 100%">
                                    <?php foreach($getmanagers as $value){ ?>
                                        <option value="<?php echo $value['employee_id'];?>"><?php echo $value['email']." / ".$roles[$value['role_id']]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label></label>
                        <button type="button" class="btn btn-primary" id="assign" data-dismiss="modal">Assign</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end document-->

        <!-- Rejection Notes Modal -->
        <div class="modal fade" id="openreject" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" style="font-size: 15px;">Rejected</p>
                        <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="leadid" id="leadid" value=""/>
                            <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Rejection Note:</label></div>
                            <div class="col-sm-7 form-group"><textarea class="form-control" rows="4" id="comment"></textarea></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label></label>
                        <button type="button" class="btn btn-danger" id="reject" data-dismiss="modal">Reject</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end document-->

        <!-- Lead filter Modal -->
        <div class="modal right fade" id="openfilter" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="width: 300px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="padding-bottom: 15px;">
                        <p class="modal-title" style="font-size: 15px;">Filters</p>
                        <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row"style="font-size: 14px;width: 100%;">
                            <label>Filter Leads by:</label>
                            <input type="hidden" value="2" id="filterleads">
                            <input type="text" class="form-control contact-label" placeholder="Select the filter" id="filter">
                            <div style="width: 100%">
                                <select class="form-control contact-label selectfilter" size="5" id="filtervalue">
                                    <option value="1">Company</option>
                                    <option value="2">Country</option>
                                    <option value="3">JobTitle</option>
                                    <option value="4">Department</option>
                                    <option value="5">Phone</option>
                                    <option value="6">Report Code</option>
                                    <option value="7">Lead Status</option>
                                    <option value="8">Lead Stages</option>
                                    <option value="9">Created</option>
                                    <option value="10">Next followup</option>
                                    <!--<option value="11">Channel</option>
                                    <option value="12">AssignedTo</option>-->
                                </select>
                            </div>
                            <div class="row close-input" id="9">
                                <span style="font-size: 10px;width: 100%;">From date</span>
                                <div class="input-group controls input-append date filter_datetime">
                                    <input  type="text" class="filter-control-cal date-align" name="filter-control" id="createdf">
                                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    <button type="button" class="filter-close">&times;</button>
                                </div>
								<span style="font-size: 10px;width: 100%;">To date</span>
                                <div class="input-group controls input-append date filter_datetime">
                                    <input  type="text" class="filter-control-cal date-align" name="filter-control" id="createdt">
                                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    <button type="button" class="filter-close">&times;</button>
                                </div>
                            </div>
                            <div class="row close-input" id="10">
                                <span style="font-size: 10px;width: 100%;">Followup date</span>
                                <div class="input-group controls input-append date filter_datetime">
                                    <input  type="text" class="filter-control-cal date-align" name="filter-control" id="nextfollowup">
                                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    <button type="button" class="filter-close">&times;</button>
                                </div>
                            </div>
                            <div class="row close-input" id="1">
                                <span style="font-size: 10px;width: 100%;">Company</span>
                                <input type="text" class="filter-control" placeholder="Type here" name="filter-control" id="company">
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="2">
                                <span style="font-size: 10px;width: 100%;">Country</span>
                                <select class="filter-control" id="country" name="filter-control">
                                    <option value="" selected disabled>Select Country</option>
                                    <?php foreach($countries as $country){ ?>
                                        <option class="option-display" value="<?php echo $country['country']; ?>">
                                            <?php echo $country['country']; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="3">
                                <span style="font-size: 10px;width: 100%;">Job Title</span>
                                <input type="text" class="filter-control" placeholder="Type here" name="filter-control" id="jobtitle">
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="4">
                                <span style="font-size: 10px;width: 100%;">Department</span>
                                <select class="filter-control" id="department" name="filter-control">
                                    <option value="" selected disabled>Select Country</option>
                                    <?php foreach($departments as $department){ ?>
                                        <option class="option-display" value="<?php echo $department['name']; ?>">
                                            <?php echo $department['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="5">
                                <span style="font-size: 10px;width: 100%;">Phone Number</span>
                                <input type="number" class="filter-control" placeholder="Type here" name="filter-control" id="phone">
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="6">
                                <span style="font-size: 10px;width: 100%;">Report Code</span>
                                <input type="text" class="filter-control" placeholder="Type here" name="filter-control" id="reportcode">
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="7">
                                <span style="font-size: 10px;width: 100%;">Lead Status</span>
                                <select class="filter-control" id="status" name="filter-control">
                                    <option value="" selected disabled>Select Status</option>
                                    <option class="option-display" value="0">Seo Pending</option>
                                    <option class="option-display" value="1">Seo Approve</option>
                                    <option class="option-display" value="2">Seo Reject</option>
                                </select>
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="8">
                                <span style="font-size: 10px;width: 100%;">Lead Stages</span>
                                <select class="filter-control" id="stages" name="filter-control">
                                    <option value="" selected disabled>Select Stages</option>
                                    <option class="option-display" value="1">Hot</option>
                                    <option class="option-display" value="2">Cold</option>
                                    <option class="option-display" value="3">Closed</option>
                                    <option class="option-display" value="4">Dead</option>
                                    <option class="option-display" value="5">Warm</option>
                                    <option class="option-display" value="6">Lost</option>
                                </select>
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="11">
                                <span style="font-size: 10px;width: 100%;">Channel</span>
                                <select class="filter-control" id="channel" name="filter-control">
                                    <option value="" selected disabled>Select Channel</option>
                                    <?php foreach($channels as $channel){ ?>
                                        <option class="option-display" value="<?php echo $channel['id']; ?>">
                                            <?php echo $channel['channel']; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                            <div class="row close-input" id="12">
                                <span style="font-size: 10px;width: 100%;">AssignedTo</span>
                                <select class="filter-control" id="assignid" name="filter-control">
                                    <option value="" selected disabled>Select</option>
                                    <?php foreach($getmanagers as $value){ ?>
                                        <option class="option-display" value="<?php echo $value['employee_id'];?>">
                                            <?php echo $value['email']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="filter-close">&times;</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="height: 70px;">
                        <button type="button" class="btn btn-primary btn-search" id="searchleads" data-dismiss="modal">Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end document-->
    </div>
</div>