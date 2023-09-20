<?php
	 include('nav-head.php');
    //LEADSTAGES=$functions->getLeadStages();
    $leadid = base64_decode($_GET['lead_id']);
		$getmanagers=$functions->getSalesManager();
	$categories=$projectfunctions->getAllCategories();
	$Dealstages=$accountsfunctions->getDealStages();
	$LEAD_STAGES=$functions->getLeadStages();
	$DealDetails=$accountsfunctions->getLeadPipelineByleadId($leadid);
    $leadLists = $functions->getleadbyId($leadid);
   $employeelist=$functions->getEmployeebyManagerId($_SESSION['employee_id']);
   $notes=$functions->getNotesbyLeadId($leadid);
   $valueupdates=$functions->getUpdatedvaluesbyleadId($leadid);
   $assign_logs=$functions->getAssignedLogsOfLead($leadid);
   //$ThreeCXcalllogs=$functions->getThreeCXcalllogsByLeadId($leadid);
   $threeCXmobile = str_replace(['+','-','.',' '],"",$leadLists['phone_number']);
   //echo strlen($leadLists['phone_number']);exit;
   if(strlen($leadLists['phone_number'])>5){
	   if($threeCXmobile!=""){
		   $ThreeCXcalllogs=$functions->getThreeCXcalllogsByPhoneNo($threeCXmobile);
	   }else{
		   $ThreeCXcalllogs=array();
	   }
   }else{
	   $ThreeCXcalllogs=array();
   }
   
   $followupsLeads = $functions->getLeadsFollowupsByLeadId($leadid,$threeCXmobile);
   
   $callLogs = $functions->getCallLogsByLeadId($leadid);
$fname=$leadLists['fname'];
$lname=$leadLists['lname'];
$company=$leadLists['company'];
$position=$leadLists['job_title'];
$email=$leadLists['email'];
$num=$leadLists['phone_number'];
$linkedin_bio=$leadLists['linkedin_bio'];
$country=$leadLists['country'];
$company_url=$leadLists['company_url'];
$report_title=$leadLists['report_name'];
$report_code=$leadLists['report_code'];
$industry=$leadLists['department'];
$request_type=$leadLists['entry_point'];
$status=$leadLists['status'];
$lead_status=$leadLists['lead_stage_id'];
$invoice_id=$leadLists['invoice_id'];
$lead_significance=$leadLists['lead_significance'];
$channel=$leadLists['lead_generation_channel_id'];
$lead_assign_date=$leadLists['lead_assigned_date'];
$created_date=$leadLists['created'];
$speak_to_analystt=$leadLists['speak_to_analyst'];
$next_followup_date=$leadLists['next_followup_date'];
$specific_requirement=$leadLists['txt_comments'];
$rejection_note=$leadLists['rejection_note'];
$title_related_my_company=$leadLists['title_related_my_company'];
$time_zone=$leadLists['timezonepicker'];
$leadsource=$leadLists['lead_source'];
$Invoicedata = $functions->getInvoiceById($invoice_id);
?>
<script>
function updatecol(getid,str,col,id){
    $.ajax({
        type: "GET",
        url: 'ajax.php',
        data: ({leadid: getid,value:str,colname:col}),
        success: function(result){
            alert(col + " updated");
            document.getElementById(id).value = str;
            if(str == 1){
                 $(".hide-close-leads").hide();
                 $(".hide-lost-leads").hide();
                 $(".hide-deal-leads").show();
            }
            if(str == 3){
                $(".hide-lost-leads").hide();
                $(".hide-deal-leads").hide();
                $(".hide-close-leads").show();
             }
            if(str == 6){
                $(".hide-deal-leads").hide();
                $(".hide-close-leads").hide();
                $(".hide-lost-leads").show();
            }
            $("#history").load("history.php?lead_id=<?php echo $leadid;?>&active=activity");
            //window.location.reload();
        }
    });
}

 function noteSave(leadid){
     var notes = document.getElementById("note").value;
     $.ajax({
         type: "POST",
         url: 'ajax.php',
         data: ({leadid: leadid,notes:notes}),
         success: function(result){
             alert("Notes inserted successfully");
             $("#history").load("history.php?lead_id=<?php echo $leadid;?>&active=notes");
         }
     });
 }
function noteSyncMail(leadid,mail){
    document.getElementById("loading").style.display = 'block';
    $.ajax({
        type: "POST",
        url: 'ajax_mailsync.php',
        data: ({leadId: leadid,leadMail:mail}),
        success: function(result){
            console.log(result);
            document.getElementById("loading").style.display = 'none';
            alert("Mail Synced in Notes Successfully");
            $("#history").load("history.php?lead_id=<?php echo $leadid;?>&active=notes");
        }
    });
}
function taskSave(leadid){
    var assigned_to = document.getElementById("task_assignto").value;
    var category = document.getElementById("selectCategory").value;
    var task_name = document.getElementById("task_name").value;
    var description = document.getElementById("task_description").value;
    var exp_date = document.getElementById("expected_date").value;
    var description =description.replace(/<\/?[^>]+(>|$)/g, "");
      //console.log(description);
   // console.log(category);
     $.ajax({
        type: "POST",
        url: 'ajax/project_ajax.php',
        data: ({leadid: leadid,assigned_to:assigned_to,category:category,task_name:task_name,
        description:description,exp_date:exp_date}),
          success: function(result){
            console.log(result);
            alert("Submitted successfully");
            window.location.reload();
        }
    });
}

</script>
<!-- MAIN CONTENT-->
<div class="main-content" xmlns="http://www.w3.org/1999/html">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="loading">
                                <img id="loading-image" src="images/loader.gif" alt="Loading..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <div class="profile-img-align"><?php echo ucfirst($fname[0]);?></div>
                                            </div>
                                            <div class="col-sm-5">
                                                <h4 style="font-family: sans-serif;"><?php echo $fname." ".$lname;?></h4>
                                                <div style="font-size: 14px;"><?php echo $position." ,".$company;?></div>
                                                <div style="font-size: 13px;"><?php echo $country;?></div>
                                            </div>
                                           <div class="col-sm-2"></div>
										   <div class="col-sm-2" style="float:right">
											 <a href="request_report.php?lead_id=<?php echo base64_encode($leadid);?>">
												  <button class="add-contact">Request Sample</button></a>
											</div>
                                            <?php if($_SESSION['role_id'] == 1){ ?>
                                           <div class="col-sm-2">
                                            <a href="deal_logs.php?lead_id=<?php echo base64_encode($leadid);?>"><button class="add-contact">Deal Logs</button></a>
                                           </div>
                                           <?php } ?>
                                        </div>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action=" " method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Name</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="firstname" name="firstname" placeholder="Firstname" class="form-control contact-label" value="<?php echo $fname.' '.$lname;?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">UTM Source</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="lead_source" name="utmsource" placeholder="" class="form-control contact-label" value="<?php echo $leadsource;?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Company</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="Company" name="Company" placeholder="Company" class="form-control contact-label" value="<?php echo $company;?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Position/Job Title</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="Position" name="Position" placeholder="Position" class="form-control contact-label" value="<?php echo $position;?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Email</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="form_email" name="email" placeholder="email" class="form-control contact-label" value="<?php echo $email;?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Contact Number</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="c_number" name="c_number" placeholder="contact number" class="form-control contact-label" value="<?php echo $num;?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Report Title</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="report_title" name="report_title" placeholder="Report Title" class="form-control contact-label" value="<?php echo $report_title;?>" readonly>
                                                </div>
                                              <div class="col-md-2">
                                               <label for="text-input" class="contact-label">Assigned To</label>
                                              </div>
                                              <div class="col-md-4">
                                              <?php $associatedname=$functions->getEmployeeByEmpId($leadLists['associated_id']); ?>
                                               <input type="text" id="assigned_to" name="assigned_to" class="form-control contact-label" value="<?php echo $associatedname['firstname'].' '.$associatedname['lastname']; ?>" readonly>
                                              </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Country</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="Country" name="Country" placeholder="Country" class="form-control contact-label" value="<?php echo $country;?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Lead Status</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="Lead_Status" name="Lead_Status" placeholder="Lead Status" class="form-control contact-label" value="<?php echo $leadStages[$lead_status];?>" readonly>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="button" class="btn btn-demo"  data-toggle="modal" data-target="#viewmodal">
                                                     View and edit all fields
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                   </div>
                            </div>
<!-- ---------------input formm---------------------------->
<?php if($assign_logs != []){ ?>
 <div class="col-lg-12">
  <div class="card">
    <h5 style="padding:8px;">Previously Assigned to</h5>
    <div style="padding:10px;">
       <?php foreach($assign_logs as $row){
       $empData = $functions->getEmployeeByEmpId($row['assign_to']);
       echo "<strong>".$empData['firstname'].' '.$empData['lastname']."</strong> (".$row['updated']."),";
       }?>
    </div>
</div>
</div>
 <?php } ?>
<!-----------------ASSIgned log list formm-------------------------- -->
                            <div class="col-lg-12">
                                <div class="card" style="margin-bottom: ">
                                        <div class="card-header"><strong>FollowUp</strong>
										
                                    <!--<?php if($invoice_id == 0){ ?>
                                    <button class="createinvoice-btn" id="openinvoice" data-toggle="modal"  data-target="#createinvoice" value="<?php echo $leadid;?>">Create Invoice</button>
                                       <?php }else{ ?>
                                        <button class="createinvoice-btn"><a href="invoice.php?invnum=<?php echo base64_encode($invoice_id);?>" style="color: #ffffff" target="_blank">View Invoice</a></button>
                                        <button class="editinvoice-btn" id="openeditinvoice" data-toggle="modal" data-target="#editinvoice" value="<?php echo $leadid;?>">Edit Invoice</button>
                                  <?php  } ?>-->
								                            </div>
                                <div class="card-editor">
                                 <ul class="nav nav-lg nav-tabs nav-tabs-solid nav-tabs-component nav-justified">
                                         <li><a data-toggle="tab" href="#home" class="active"><h5 class="rightsidetab">
                                        <i style=" padding-right: 5px; font-size: 12px; " class="fa fa-address-book"></i>NOTE</h5></a>
                                         </li>
                                         <li><a data-toggle="tab" href="#menu1"><h5 class="rightsidetab">
                                          <i style=" padding-right: 5px; font-size: 12px; " class="fa fa-envelope"></i>EMAIL</h5></a>
                                        </li>
                                          <li><a data-toggle="tab" href="#menu2">
                                            <h5 class="rightsidetab"><i style=" padding-right: 5px; font-size: 12px; " class="fa fa-phone"></i>CALL</h5></a>
                                          </li>
                                          <li><a data-toggle="tab" href="#menu3"><h5 class="rightsidetab">
                                        <i style=" padding-right: 5px; font-size: 12px; " class="fa fa-desktop"></i>TASK</h5></a>
                                         </li>
                                      <!--   <li><a data-toggle="tab" href="#menu4">
                                          <h5 class="rightsidetab"><i style=" padding-right: 5px; font-size: 12px; " class="fa fa-clock"></i>SCHEDULE</h5></a>
                                         </li>-->
                                       </ul>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">
                                             <textarea class="textarea" id="note" name="notes"></textarea>
                                        <button type="button" class="btn btn-primary note-save" onclick="noteSave(<?php echo $leadid;?>)">Save</button>
                                         <button type="button" class="btn btn-primary note-save"
                                                 onclick="noteSyncMail(<?php echo $leadid;?>,'<?php echo $email;?>')">Sync Mail</button>
                                            </div>
                                            <div id="menu1" class="tab-pane fade">
                                                <div class="textarea" style="padding: 10px;">
                                                    <div class="row form-email">
                                                        <label class="col-sm-2 contact-label" for="email">To:</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control contact-label">
                                                        </div>
                                                    </div>
                                                    <div class="row form-email">
                                                        <label class="col-sm-2 contact-label" for="email">From:</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control contact-label">
                                                        </div>
                                                    </div>
                                                    <div class="row form-email">
                                                        <label class="col-sm-2 contact-label" for="email">Subject:</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control contact-label">
                                                        </div>
                                                    </div>
                                                </div>
                                         <textarea class="textarea" id="sendemail" name="notes"></textarea>
                                            <button type="button" class="btn btn-primary note-save" onclick="mailSave(<?php echo $leadid;?>)">Save</button>
                                            </div>
                                            <div id="menu2" class="tab-pane fade">
                                                <!--<div class="textarea" style="padding: 30px;">
                                                    <div id="call-controls">
                                                        <input type="text" class="form-control" name="calling" id="phone-number" value="+"/>
                                                        <input type="hidden" class="form-control" name="lead" id="getleadid" value="<?php echo $leadid; ?>"/>
                                                        <button class="btn btn-success" id="button-call">Make Call</button>
                                                        <button class="btn btn-danger" id="button-hangup">End Call</button>
                                                    </div>
                                                    <div id="log"></div>
                                                </div>-->
                                            </div>
                                            <div id="menu3" class="tab-pane fade">
                                                <div class="textarea" style="padding: 10px;">
                                                    <div class="row form-email">
                                                        <label class="col-sm-3 contact-label" for="email">Assign To:</label>
                                                        <div class="col-sm-8" style="padding:0;">
                                                            <select class="form-control contact-label" id="task_assignto">
                                                                <option value="" selected disabled>Assign to</option>
                                                                 <?php foreach($getmanagers as $row){ ?>
                                                                    <option value="<?php echo $row['employee_id']; ?>">
                                                                   <?php echo $row['firstname']." ".$row['lastname']; ?></option>
                                                                  <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-email">
                                                        <label class="col-sm-3 contact-label" for="date">Type of Category:</label>
                                                        <div class="col-sm-8" style="padding:0;">
                                                            <select class="form-control subject" style="font-size: 14px;" id="selectCategory">
                                                                <option value="" selected disabled>Please select</option>
                                                                <?php foreach($categories as $row){ ?>
                                                               <option value="<?php echo $row['id']; ?>"><?php echo $row['category']; ?></option>
                                                               <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                  <div class="row form-email">
                                                      <label class="col-sm-3 contact-label" for="date">Task Name:</label>
                                                      <div class="col-sm-8" style="padding:0;">
                                                          <input type="text" name="task_name" placeholder="Enter task Name" class="form-control" id="task_name">
                                                      </div>
                                                   </div>
                                                    <div class="row form-email">
                                                        <label class="col-sm-3 contact-label" for="date">Expected Date:</label>
                                                        <div class="col-sm-8" style="padding:0;">
                                                            <div class="input-group controls input-append date task_datetime">
                                                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                                                <input  type="text" class="form-control date-align" name="date" id="expected_date">
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="textarea">
                                                   <label class="contact-label" style="padding-left:10px;">Description</label>
                                                 <textarea class="textarea" id="task_description" name="notes"></textarea>
                                                </div>
                                                <button type="button" class="btn btn-primary note-save" onclick="taskSave(<?php echo $leadid;?>)">Save</button>
                                            </div>
                                       <!--     <div id="menu4" class="tab-pane fade">
                                                <textarea class="textarea" id="schedule" name="notes"></textarea>
                                            </div>-->
                                        </div>
                                    </div>
                                 </div>
                                 <div  class="comments-card" id="history">
                                <ul class="nav nav-tabs" style="border-bottom: none!important;">
                                    <li><a data-toggle="tab" href="#notes" class="historymenu active">Notes</a></li>
                                    <li><a data-toggle="tab" href="#activity" class="historymenu">Activity Logs</a></li>
                                    <li><a data-toggle="tab" href="#calllog" class="historymenu">Call Logs</a></li>
									                       <li><a data-toggle="tab" href="#followup" class="historymenu">Follow Ups</a></li>
                                </ul>

<!-- -----------------------------------------text editor-------------------------- -->
                      <div class="col-sm-12 tab-content" style="margin-top: 10px;">
                                    <div id="notes" class="tab-pane fade in active">
                                        <?php foreach($notes as $note){
                                            $updatednotename=$functions->getEmployeeByEmpId($note['updated_by_id']);
                                            ?>
                                        <div class="comments-section">
                                            <?php  echo base64_decode($note['note']);?> By  <strong><?php  echo $updatednotename['firstname'];?></strong>
                                            <p class="created-date"><?php echo $note['created'];?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div id="activity" class="tab-pane fade">
                                        <?php foreach($valueupdates as $update){
                                            $updatedname=$functions->getEmployeeByEmpId($update['updated_by']);
                                            $newValue = ($update['updated_field'] == 'lead_stage_id' ? $leadStages[$update['new_value']] : $update['new_value']);
                                            $oldValue = ($update['updated_field'] == 'lead_stage_id' ? $leadStages[$update['old_value']] : $update['old_value']);
                                            ?>
                                        <div class="comments-section">
                                            <p><strong><?php echo $leadCloumns[$update['updated_field']];?></strong> Updated as
                                                <?php echo $newValue;?> From <?php  echo $oldValue;?>
                                                By  <strong><?php  echo $updatedname['firstname'];?></strong> On
                                                <?php  echo $update['activity_time'];?>  </p>
                                        </div>
                                        <?php } ?>
                         </div>
                            <div id="calllog" class="tab-pane fade">
                              <?php $i=0;foreach($ThreeCXcalllogs as $cxlogs){ ?>
                              <div class="comments-section">
                               <p>Phone Number: <strong><?php echo $cxlogs['phone'];?></strong><br>
                               Calltype: <strong><?php echo $cxlogs['calltype'];?></strong><br>
                               Description: <strong><?php echo $cxlogs['description'];?></strong><br>
                               Duration: <strong><?php echo $cxlogs['duration'];?></strong><br>
                               Called By : <strong><?php $callby=$functions->getEmployeeByExtension($cxlogs['agent']);
                               echo $callby['firstname'].' '.$callby['lastname'];?>
                               </strong><br>
                               <?php //include('3cxcall-record.php'); 
									$agent = $cxlogs['agent'];
									$start = $cxlogs['start'];
							   ?>
							   <?php if($cxlogs['calltype']!="Missed" && $cxlogs['calltype']!="Notanswered"){ ?>
							   <div id="insert-file<?php echo $i;?>"></div>
							   <script type="text/javascript">
								$(document).ready(function(){
									//alert('https://crm.industryarc.in/view/3cxcall-record.php?threeCXmobile=<?php echo $threeCXmobile; ?>&agent=<?php echo $agent; ?>&start=<?php echo $start; ?>');
									$('#insert-file<?php echo $i;?>').load('https://crm.industryarc.in/view/3cxcall-record.php?threeCXmobile=<?php echo $threeCXmobile; ?>&agent=<?php echo $agent; ?>&start=<?php echo $start; ?>');
								});
								</script>
							  <?php } ?>
                               <div style="float: right"> On <strong><?php echo $cxlogs['remark'];?></strong></div>
                               </p>
                              </div>
                              <?php $i++;} ?>
                              <?php foreach($callLogs as $calllog){?>
                                  <div class="comments-section">
                                      <!--Call Recording : <a href="<?php echo $calllog['recording'];?>" target="_blank"><?php echo $calllog['recording'];?></a>-->
                                      <p><?php echo $calllog['contact'];?></p>
                                      <audio controls>
                                          <source src='<?php echo $calllog['recording'];?>' type='audio/wav'>
                                          <source src='<?php echo $calllog['recording'].".mp3"; ?>' type='audio/mpeg'>
                                          Your browser does not support the audio tag.
                                      </audio>
                                      <p class="created-date"><?php echo $calllog['created'];?></p>
                                  </div>
                              <?php } ?>
                              </div>
                               <div id="followup" class="tab-pane fade">
                              <?php if($followupsLeads['notes'] != []){ ?>
                              <div class="comments-section">
                                <h4>Notes</h4>
                               <?php $i=1;
                                foreach ($followupsLeads['notes'] as $follownotes){ ?>
                                 <div><b><?php echo $i.". ";?></b>Created Date: <strong><?php echo $follownotes['created'];?></strong></div>
                               <?php $i++; } ?>
                              </div>
                              <?php } ?>
                              <?php if($followupsLeads['twilio'] != []){ ?>
                                <div class="comments-section">
                               <h4>Twilio Calls</h4>
                               <?php $j=1; foreach ($followupsLeads['twilio'] as $followtwilio){ ?>
                               <div><b><?php echo $j.". ";?></b>Created Date: <strong><?php echo $followtwilio['created'];?></strong></div>
                               <?php  $j++; } ?>
                              </div>
                              <?php } ?>
                              <?php if($followupsLeads['threecx'] != []){ ?>
                              <div class="comments-section">
                               <h4>3CX Calls</h4>
                               <?php $k=1; foreach ($followupsLeads['threecx'] as $followthreecx){ ?>
                               <div><b><?php echo $k.". ";?></b>Call Type: <strong><?php echo $followthreecx['calltype'];?></strong></div>
                               <div>Description: <strong><?php echo $followthreecx['description'];?></strong></div>
                               <div>Created Date: <strong><?php echo $followthreecx['created'];?></strong></div>
                               <?php $k++; } ?>
                              </div>
                              <?php } ?>
                             </div>
                              </div>
                           </div>
                       </div>
                        </div>
                       <?php include('footer-right.php'); ?>
                    </div>
                </div>
            </div>
<?php include('nav-foot.php'); ?>
<!-------------------------------------------------------------  page END-------------------------------------------------------------------------->
<!-- Edit Information    Modal -->
<div class="modal right fade" id="viewmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel2">Edit Lead Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">First Name</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="firstname" name="firstname" placeholder="Firstname" class="form-control contact-label" value="<?php echo $fname;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'fname',this.id)"></div>
                   </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Last Name</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="lastname" name="lastname" placeholder="Lastname" class="form-control contact-label" value="<?php echo $lname;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'lname',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Company</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Company" name="Company" placeholder="Company" class="form-control contact-label" value="<?php echo $company;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'company',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Position/Job Title</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Position" name="Position" placeholder="Position" class="form-control contact-label" value="<?php echo $position;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'job_title',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Email</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="form_email" name="email" placeholder="email" class="form-control contact-label" value="<?php echo $email;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'email',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Contact Number</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="c_number" name="c_number" placeholder="contact number" class="form-control contact-label" value="<?php echo $num;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'phone_number',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Linkedin BIO</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="linkedin_bio" name="linkedin_bio" placeholder="linkedin bio" class="form-control contact-label" value="<?php echo $linkedin_bio;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'linkedin_bio',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Company Url</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="c_url" name="c_url" placeholder="Company url" class="form-control contact-label" value="<?php echo $company_url;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'company_url',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Country</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Country" name="Country" placeholder="Country" class="form-control contact-label" value="<?php echo $country;?>" readonly
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'country',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Time Zone</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="timezone" name="timezone" placeholder="Time Zone" class="form-control contact-label" value="<?php echo $time_zone;?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Speak to Analyst</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Analyst" name="Analyst" placeholder="Analyst" class="form-control contact-label" value="<?php echo $speak_to_analystt;?>"
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'speak_to_analyst',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label for="text-input" class="contact-label">Kindly Provide Titles Related To My Company</label>
                    </div>
                    <div class="col-md-2 contact-label">
                        <input type="radio" id="text-input"  name="gender" value="Yes" <?php echo ($title_related_my_company =='Yes')?'checked':'' ?>>Yes<br>
                        <input type="radio"  id="text-input" name="gender" value="No"  <?php echo ($title_related_my_company =='No')?'checked':'' ?>> No</br>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Report Title</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="report_title" name="report_title" placeholder="Report Title" class="form-control contact-label" value="<?php echo $report_title;?>" onchange="updatecol(<?php echo $leadid;?>,this.value,'report_name',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Report Code</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="report_code" name="report_code" placeholder="Report code" class="form-control contact-label" value="<?php echo $report_code;?>" onchange="updatecol(<?php echo $leadid;?>,this.value,'report_code',this.id)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Industry</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Industry" name="Industry" placeholder="Industry type" class="form-control contact-label" value="<?php echo $industry;?>" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Specific Requirement</label>
                    </div>
                    <div class="col-md-7">
                        <textarea id="text-input" name="report_code" class="form-control contact-label"><?php echo $specific_requirement;?></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Request Type</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Request_Type" name="Request_Type" placeholder="Request Type" class="form-control contact-label" value="<?php echo $request_type;?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Status</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="Lead_Status" name="Lead_Status" placeholder="Lead Status" class="form-control contact-label" value="<?php echo $leadStatus[$status];?>" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Lead Status</label>
                    </div>
                    <div class="col-md-7">
                        <select id="lead_Stage" name="lead_Stage"  class="form-control contact-label" onchange="updatecol(<?php echo $leadid;?>,this.value,'lead_stage_id',this.id)">
                            <?php foreach($LEAD_STAGES as $value){ ?>
                            <option value="<?php echo $value['id'];?>" <?php if($value['id']==$lead_status){?>selected="selected"<?php } ?>><?php echo $value['stage']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
				</div>	
					<!------------------------------------------- Pipe Line Start---------------------------------------- -->
  <!------------------------------------------- Hot deal---------------------------------------- -->
                <div class="pipeline hide-deal-leads">
                    <input type="hidden" name="leadid" id="lead_id" value="<?php echo $leadid;?>"/>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Deal Value*</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group">
                            <input type="number" class="form-control contact-label"  id="deal_value" name="deal_value" placeholder="Deal Value" value="<?php echo $DealDetails['exp_deal_amount'];?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Deal Closure Date*</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group controls input-append date dealclosure_date">
                            <input type="text" class="form-control contact-label"  id="deal_date" name="deal_date" placeholder="Deal Closure" value="<?php echo $DealDetails['exp_deal_closure'];?>">
                            <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Deal Stage*</label>
                    </div>
                    <div class="col-md-7">
                        <select id="deal_stage" name="deal_stage" class="form-control contact-label">
                            <option value="" selected disabled>Select stage</option>
                            <option value="1" <?php if($DealDetails['deal_stage_id'] == 1){?>selected="selected"<?php } ?>>Requirement Shared</option>
                            <option value="2"  <?php if($DealDetails['deal_stage_id'] == 2){?>selected="selected"<?php } ?>>Proposal sent</option>
                            <option value="3" <?php if($DealDetails['deal_stage_id'] == 3){?>selected="selected"<?php } ?>>Quotation Approved</option>
                        </select>
                    </div>
                </div>
                 <div class="row">
                     <div class="col-md-9"></div>
                     <div class="col-md-2">
                         <button  class="btn add-contact" id="save_deal">Submit</button>
                     </div>
                 </div>
               </div>
  <!------------------------------------------- Close deal---------------------------------------- -->

                <div class="pipeline hide-close-leads">
                    <input type="hidden" name="leadid" id="lead_id" value="<?php echo $leadid;?>"/>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Closure Deal Value*</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group">
                            <input type="number" class="form-control contact-label"  id="deal_clz_value" name="deal_clz_value" placeholder="Deal Value" value="<?php echo $DealDetails['exp_deal_amount'];?>">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Deal Closure Date*</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group controls input-append date dealclosure_date">
                            <input type="text" class="form-control contact-label"  id="deal_clz_date" name="deal_clz_date" placeholder="Deal Closure" value="<?php echo $DealDetails['exp_deal_closure'];?>">
                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Deal Stage</label>
                    </div>
                    <div class="col-md-7">
                        <select id="deal_clz_stage" name="deal_clz_stage" class="form-control contact-label">
                            <option value="4" selected>Deal Closed</option>
                        </select>
                    </div>
                </div>
                 <div class="row">
                     <div class="col-md-9"></div>
                     <div class="col-md-2">
                         <button  class="btn add-contact" id="close_deal">Submit</button>
                     </div>
                 </div>
               </div>
  <!------------------------------------------- Lost  deal---------------------------------------- -->
                <div class="pipeline hide-lost-leads">
                    <input type="hidden" name="leadid" id="lead_id" value="<?php echo $leadid;?>"/>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="text-input" class="contact-label">Reason</label>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <select id="lost_reason" name="lost_reason" class="form-control contact-label">
								<option value="" selected disabled>Select reason</option>
								<option value="Data Quality Issue" <?php if($DealDetails['remarks'] == "Data Quality Issue"){?>selected="selected"<?php } ?>>Data Quality Issue</option>
								<option value="Budget Issue" <?php if($DealDetails['remarks'] == "Budget Issue"){?>selected="selected"<?php } ?>>Budget Issue</option>
								<option value="Approval Issues" <?php if($DealDetails['remarks'] == "Approval Issues"){?>selected="selected"<?php } ?>>Approval Issues</option>
								<option value="No Response" <?php if($DealDetails['remarks'] == "No Response"){?>selected="selected"<?php } ?>>No Response</option>
								<option value="My follow-up Issue" <?php if($DealDetails['remarks'] == "My follow-up Issue"){?>selected="selected"<?php } ?>>My follow-up Issue</option>
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-2">
                            <button  class="btn add-contact" id="lost_deal">Submit</button>
                        </div>
                    </div>
                </div>

 <!------------------------------------------- Pipe Line END------------------------------------------>
					
                
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Created Date</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group date">
                            <input type="text" class="form-control daterangesingle contact-label"  id="created_date" name="created_date" placeholder="Last Activity" value="<?php echo $created_date;?>" readonly>
                            <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Next Followup Date</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group controls input-append date nextfollowupdatepicker">
                            <input type="text" class="form-control contact-label" id="next_followup_date" name="next_followup_date" value="<?php echo $next_followup_date ?>"
                                   onchange="updatecol(<?php echo $leadid;?>,this.value,'next_followup_date',this.id)">
                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Lead Assign Date</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group date">
                            <input type="text" class="form-control daterangesingle contact-label" name="last_activity" value="<?php echo $lead_assign_date;?>" readonly>
                            <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Lead Significance</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="text-input" name="Lead Status"  class="form-control contact-label" value="<?php echo $lead_significance;?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Last Activity Date</label>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group date">
                            <input type="text" class="form-control daterangesingle contact-label"  value="2018-08-08 12:57:08" name="last_activity" placeholder="Last Activity" readonly>
                            <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Lead-Generation-Channel</label>
                    </div>
                    <div class="col-md-7">
                        <select id="channel" name="channel"  class="form-control contact-label" onchange="updatecol(<?php echo $leadid;?>,this.value,'lead_generation_channel_id',this.id)">
                            <?php foreach($leadGenerationChannel as $key => $value){ ?>
                                <option value="<?php echo $key;?>" <?php if($key== $channel){?>selected="selected"<?php } ?>><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                 <div class="row form-group">
                 <div class="col-md-4">
                  <label for="text-input" class="contact-label">Estimated Client Budget ($)</label>
                 </div>
                 <div class="col-md-7">
                  <div class="input-group">
                   <input type="text" id="client_budget" name="client_budget" placeholder="Client Budget"
                  class="form-control contact-label" value="<?php echo $leadLists['client_budget'];?>"
                  onchange="updatecol(<?php echo $leadid;?>,this.value,'client_budget',this.id)">
                  </div>
                 </div>
                </div>
                <div class="row form-group">
                 <div class="col-md-4">
                  <label for="text-input" class="contact-label">Price Quoted ($)</label>
                 </div>
                 <div class="col-md-7">
                  <div class="input-group">
                   <input type="text" id="price_quoted" name="price_quoted" placeholder="Price Quoted"
                  class="form-control contact-label" value="<?php echo $leadLists['price_quoted'];?>"
                  onchange="updatecol(<?php echo $leadid;?>,this.value,'price_quoted',this.id)">
                  </div>
                 </div>
                </div>
                <div class="row form-group">
                 <div class="col-md-4">
                  <label for="text-input" class="contact-label">Purchasing Timeline </label>
                 </div>
                 <div class="col-md-7">
                  <div class="input-group">
                   <input type="text" id="purchasing_time" name="purchasing_time" placeholder="Purchasing Time"
                  class="form-control contact-label" value="<?php echo $leadLists['purchasing_time'];?>"
                  onchange="updatecol(<?php echo $leadid;?>,this.value,'purchasing_time',this.id)">
                  </div>
                 </div>
                </div>
                <div class="row form-group">
                 <div class="col-md-4">
                  <label for="text-input" class="contact-label">Final Approval Authority</label>
                 </div>
                 <div class="col-md-7">
                  <div class="input-group">
                   <select id="approval_authority" name="approval_authority" class="form-control contact-label"
                   onchange="updatecol(<?php echo $leadid;?>,this.value,'approval_authority',this.id)">
                    <option value="CEO" <?php if("CEO" == $leadLists['approval_authority']){?>selected="selected"<?php } ?>>CEO</option>
                    <option value="Vice President" <?php if("Vice President" == $leadLists['approval_authority']){?>selected="selected"<?php } ?>>Vice President</option>
                    <option value="Director" <?php if("Director" == $leadLists['approval_authority']){?>selected="selected"<?php } ?>>Director</option>
                    <option value="Manager" <?php if("Manager" == $leadLists['approval_authority']){?>selected="selected"<?php } ?>>Manager</option>
                   </select>
                  </div>
                 </div>
                </div>
                <?php if($status== 2){ ?>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Rejection Note</label>
                    </div>
                    <div class="col-md-7">
                        <textarea id="text-input" name="rejection_note" class="form-control contact-label" disabled><?php echo $rejection_note;?></textarea>
                    </div>
                </div>
                <?php } ?>
                </form>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <!--  <button type="button" class="btn btn-primary" id="save-data" data-dismiss="modal">Save</button>-->
            </div><!-- modal-footer -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
<!-- end   modal -->
