<?php
include('nav-head.php');
$LEADSTAGES=$functions->getLeadStages();
$channels=$functions->getGenerationChannels();
$countries=$functions->getCountries();
$departments=$functions->getDepartmentLists();
$getmanagers=$functions->getSalesManager();
$empId=$_SESSION['employee_id'];
$limit = 10;
if (isset($_GET['page']) && $_GET['page']) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$leadFilter = 0;
foreach($_SESSION['my_filter'] as $key=>$value){
    if($value!="" || $value!=null){
        $leadFilter = 1;
        break;
    }
}
if($_SESSION['my_lead']== "" || $_SESSION['my_lead'] == null){
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
                $Records=$functions->getCountOfSearchDataInMyContacts($empId,$data,$limit);
                $totrecords= $Records['total'];
                $total_pages=$Records['total_pages'];
                $leads = $functions->getSearchDataInMyContactsPagination($empId,$data,$page,$limit);
            }else {
                $Records = $functions->getnumSearchRecordsOfMyLeads($empId, $limit);
                $totrecords= $Records['total'];
                $total_pages=$Records['total_pages'];
                $leads = $functions->getMyLeadsPagination($empId, $page, $limit);
            }
}else{
    $myname=$_SESSION['my_lead'];
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
/*echo "<pre>";
print_r($leads);
exit();*/
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
                                <input class="form-control" type="search" id="search_mycontacts" placeholder="Search Here" value="<?php echo $_SESSION['my_lead'];?>"/>
                                <input class="form-control" type="hidden" id="search_page" value="<?php echo $_GET['page'];?>"/>
                                <span class="input-group-addon"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="padding: 0;">
                            <button class="add-contact" data-toggle="modal" data-target="#openfilter">
                                Add filter</button>
                            <button class="btn btn-danger" id="removefilter" style="font-size: 12px;padding:5px;" value="2">
                                Remove filter</button>
                        </div>
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
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Phone</th>
                                <th>Domain</th>
                                <th>Channel</th>
                                <th>Entry Point</th>
                                <th>UTM Source</th>
                                <th>Lead Associate</th>
                                <th>Lead Status</th>
                                <th>Report Code</th>
                                <th>Published</th>
                                <th>Forcast</th>
                                <th>Base year</th>
                                <th>Region</th>
                                <th>Created Date</th>
                                <th>Assigned Date</th>
                                <th>Last Activity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  if(!empty($leads)){
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
                                        <td><?php echo $leadGenerationChannel[$lead['lead_generation_channel_id']];?></td>
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
										
                                        <?php $pubReport = $functions->getPublishedReportByReportCode($lead['report_code']); ?>
										<?php if(!empty($pubReport)){ ?>
										<td style="color:#0b8d15;"><a href="<?php echo $pubReport['url']; ?>" target="_blank"><b><?php echo $lead['report_code']?></b></a></td>
                                        <td>Published</td>
                                        <td><?php echo $pubReport['forcast']?></td>
                                        <td><?php echo $pubReport['base_year']?></td>
                                        <td><?php echo $pubReport['region']?></td>
										<?php }else{ ?>
										<td><?php echo $lead['report_code']?></td>
                                        <td>UnPulished</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
										<?php } ?>
										
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
                </div>
            </div>
        </div>
        <?php include('nav-foot.php');?>
        <script type="text/javascript">
            $(document).ready(function(){
                <?php if($_SESSION['my_lead'] != "" || $leadFilter == 1){?>
                            $("#removefilter").show();
                        <?php }else {?>
                            $("#removefilter").hide();
                        <?php } ?>
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
                            <input type="hidden" value="1" id="filterleads">
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
                                <span style="font-size: 10px;width: 100%;">Next Followup date</span>
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
                                    <?php foreach($LEADSTAGES as $value){ ?>
                                   <option class="option-display" value="<?php echo $value['id'];?>">
                                   <?php echo $value['stage']; ?></option>
                                   <?php } ?>
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
                        <button type="button" class="btn btn-primary btn-search" id="filter_mycontacts" data-dismiss="modal">Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end document-->
    </div>
</div>
