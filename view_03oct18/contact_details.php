<?php
	 include('nav-head.php');
    $LEADSTAGES=$functions->getLeadStages();
    $leadid = base64_decode($_GET['lead_id']);
    $leadLists = $functions->getleadbyId($leadid);
   $employeelist=$functions->getEmployeebyManagerId($_SESSION['employee_id']);
   $notes=$functions->getNotesbyLeadId($leadid);
   $valueupdates=$functions->getUpdatedvaluesbyleadId($leadid);
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
            $("#history").load("history.php?lead_id=<?php echo $leadid;?>&active=activity");
            //window.location.reload();
        }
    });
}
 function noteSave(leadid){
     var notes = document.getElementById("note").value;
     $.ajax({
         type: "GET",
         url: 'ajax.php',
         data: ({leadid: leadid,notes:notes}),
         success: function(result){
             alert("Notes inserted successfully");
             $("#history").load("history.php?lead_id=<?php echo $leadid;?>&active=notes");
         }
     });
 }
function taskSave(leadid){
    var assignto_id = document.getElementById("assignto").value;
    var task = document.getElementById("task").value;
   // var header = document.getElementById("subject").value;
    var types = [];
    $.each($(".subject option:selected"), function(){
        types.push($(this).val());
    });
    //console.log(types);
    var ondate = document.getElementById("ondate").value;
/*   console.log(assignto_id);
    console.log(task);
    console.log(ondate);*/
    $.ajax({
        type: "GET",
        url: 'ajax.php',
        data: ({leadid: leadid,assignto:assignto_id,header:types,task:task,ondate:ondate}),
        success: function(result){
            console.log(result);
            alert("Task inserted successfully");
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
                                        </div>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action=" " method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">First Name</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="firstname" name="firstname" placeholder="Firstname" class="form-control contact-label" value="<?php echo $fname;?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="text-input" class="contact-label">Last Name</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="lastname" name="lastname" placeholder="Lastname" class="form-control contact-label" value="<?php echo $lname;?>" readonly>
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
                                                    <label for="text-input" class="contact-label">Next Followup Date</label>
                                                </div>
                                                <div class="col-md-4">
                                              <input type="text"  id="next_followup_date" name="next_followup_date" class="form-control contact-label" value="<?php echo $next_followup_date ?>" readonly">
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
                                   <!-- <div class="card-body card-block">
                                        <form action=" " method="post" enctype="multipart/form-data" class="form-horizontal">
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">First Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="firstname" name="firstname" placeholder="Firstname" class="form-control contact-label" value="<?php /*echo $fname;*/?>"
                                                    onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'fname',this.id)">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Last Name</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="lastname" name="lastname" placeholder="Lastname" class="form-control contact-label" value="<?php /*echo $lname;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'lname',this.id)">
                                                </div>
                                              </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Company</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="Company" name="Company" placeholder="Company" class="form-control contact-label" value="<?php /*echo $company;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'company',this.id)">
                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Position/Job Title</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="Position" name="Position" placeholder="Position" class="form-control contact-label" value="<?php /*echo $position;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'job_title',this.id)">
                                                </div>
                                              </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Email</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="form_email" name="email" placeholder="email" class="form-control contact-label" value="<?php /*echo $email;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'email',this.id)">
                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Contact Number</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="c_number" name="c_number" placeholder="contact number" class="form-control contact-label" value="<?php /*echo $num;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'mobile',this.id)">
                                                </div>
                                              </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Linkedin BIO</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="linkedin_bio" name="linkedin_bio" placeholder="linkedin bio" class="form-control contact-label" value="<?php /*echo $linkedin_bio;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'linkedin_bio',this.id)">
                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Company Url</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="c_url" name="c_url" placeholder="Company url" class="form-control contact-label" value="<?php /*echo $company_url;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'company_url',this.id)">
                                                </div>
                                              </div>

                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Country</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="Country" name="Country" placeholder="Country" class="form-control contact-label" value="<?php /*echo $country;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'country',this.id)">
                                                </div>
                                            </div>

                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Time Zone</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="timezone" name="timezone" placeholder="Time Zone" class="form-control contact-label">
                                                </div>
                                              </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Speak to Analyst</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="Analyst" name="Analyst" placeholder="Analyst" class="form-control contact-label" value="<?php /*echo $speak_to_analystt;*/?>"
                                                           onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'speak_to_analyst',this.id)">
                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-8">
                                                    <label for="text-input" class="contact-label">Kindly Provide Titles Related To My Company</label>
                                                </div>
                                                <div class="col-md-4 contact-label">
                                                          <input type="radio" id="text-input"  name="gender" value="yes">Yes<br>
                                                          <input type="radio"  id="text-input" name="gender" value="no"> No</br>
                                                </div>
                                              </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Report Title</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="report_title" name="report_title" placeholder="Report Title" class="form-control contact-label" value="<?php /*echo $report_title;*/?>">
                                                </div>
                                            </div>

                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Report Code</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="report_code" name="report_code" placeholder="Report code" class="form-control contact-label" value="<?php /*echo $report_code;*/?>">
                                                </div>
                                              </div>

                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Industry</label>
                                                </div>
                                                <div class="col-md-9">
                                                   <input type="text" id="Industry" name="Industry" placeholder="Industry type" class="form-control contact-label" value="<?php /*echo $industry;*/?>">
                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Specific Requirement</label>
                                                </div>
                                                <div class="col-md-9">
                                                       <textarea id="text-input" name="report_code" class="form-control contact-label"><?php /*echo $specific_requirement;*/?></textarea>
                                                </div>
                                              </div>

                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Request Type</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="Request_Type" name="Request_Type" placeholder="Request Type" class="form-control contact-label" value="<?php /*echo $request_type;*/?>">
                                                </div>
                                            </div>

                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Status</label>
                                                </div>
                                                <div class="col-md-9">
                                                       <input type="text" id="Lead_Status" name="Lead_Status" placeholder="Lead Status" class="form-control contact-label" value="<?php /*echo $leadStatus[$status];*/?>">
                                                </div>
                                              </div>

                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Lead Status</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select id="Lead_Status" name="Lead_Status"  class="form-control contact-label" onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'lead_stage_id',this.id)">
                                                        <?php /*foreach($LEADSTAGES as $value){ */?>
                                                            <option value="<?php /*echo $value['id'];*/?>" <?php /*if($value['id']==$lead_status){*/?>selected="selected"<?php /*} */?>><?php /*echo $value['stage']; */?></option>
                                                        <?php /*} */?>
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Created Date</label>
                                                </div>
                                                <div class="col-md-9">
                                                      <div class="input-group date">
                                           <input type="text" class="form-control daterangesingle contact-label"  id="created_date" name="created_date" placeholder="Last Activity" value="<?php /*echo $created_date;*/?>" readonly>
                                           <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                                </div>
                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Next Followup Date</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group controls input-append date nextfollowupdatepicker">
                                                   <input type="text" class="form-control contact-label" id="next_followup_date" name="next_followup_date" value="<?php /*echo $next_followup_date */?>"
                                                  onchange="updatecol(<?php /*echo $leadid;*/?>,this.value,'next_followup_date',this.id)">
                                                        <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                </div>
                                              </div>
                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Lead Assign Date</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group date">
                                           <input type="text" class="form-control daterangesingle contact-label" name="last_activity" value="<?php /*echo $lead_assign_date;*/?>" readonly>
                                           <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                                </div>
                                                </div>
                                            </div>

                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Lead Significance</label>
                                                </div>
                                                <div class="col-md-9">
                                                       <input type="text" id="text-input" name="Lead Status"  class="form-control contact-label" value="<?php /*echo $lead_significance;*/?>">
                                                </div>
                                              </div>


                                              <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Last Activity Date</label>
                                                </div>
                                                <div class="col-md-9">
                                            <div class="input-group date">
                                           <input type="text" class="form-control daterangesingle contact-label"  value="2018-08-08 12:57:08" name="last_activity" placeholder="Last Activity" readonly>
                                           <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                                </div>
                                              </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Lead-Generation-Channel</label>
                                                </div>
                                                <div class="col-md-9">
                                                       <input type="text" id="text-input" name="Lead Status"class="form-control contact-label" value="<?php /*echo $leadGenerationChannel[$channel];*/?>" readonly>
                                                </div>
                                              </div>
                                            <?php /*if($status== 2){ */?>
                                            <div class="row form-group">
                                                <div class="col-md-3">
                                                    <label for="text-input" class="contact-label">Rejection Note</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea id="text-input" name="rejection_note" class="form-control contact-label" disabled><?php /*echo $rejection_note;*/?></textarea>
                                                </div>
                                            </div>

                                            <?php /*} */?>
                                        </form>
                                    </div>-->
                                   </div>
                            </div>
<!-- ---------------input formm-------------------------- -->
                            <div class="col-lg-12">
                                <div class="card" style="margin-bottom: ">
                                        <div class="card-header"><strong>FollowUp</strong>
                                    <?php if($invoice_id == 0){ ?>
                                    <button class="createinvoice-btn" id="openinvoice" data-toggle="modal"  data-target="#createinvoice" value="<?php echo $leadid;?>">Create Invoice</button>
                                       <?php }else{ ?>
                                        <button class="createinvoice-btn"><a href="invoice.php?invnum=<?php echo base64_encode($invoice_id);?>" style="color: #ffffff" target="_blank">View Invoice</a></button>
                                        <button class="editinvoice-btn" id="openeditinvoice" data-toggle="modal" data-target="#editinvoice" value="<?php echo $leadid;?>">Edit Invoice</button>
                                  <?php  } ?> </div>
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
                                                <div class="textarea" style="padding: 30px;">
                                                    <div id="call-controls">
                                                        <input type="text" class="form-control" name="calling" id="phone-number" value="+"/>
                                                        <input type="hidden" class="form-control" name="lead" id="getleadid" value="<?php echo $leadid; ?>"/>
                                                        <button class="btn btn-success" id="button-call">Make Call</button>
                                                        <button class="btn btn-danger" id="button-hangup">End Call</button>
                                                    </div>
                                                    <div id="log"></div>
                                                </div>
                                            </div>
                                            <div id="menu3" class="tab-pane fade">
                                                <div class="textarea" style="padding: 10px;">
                                                    <div class="row form-email">
                                                        <label class="col-sm-3 contact-label" for="email">Assign To:</label>
                                                        <div class="col-sm-8" style="padding:0;">
                                                            <select class="form-control contact-label" id="assignto">
                                                                <option selected>Assign to</option>
                                                                <?php foreach($employeelist as $list){ ?>
                                                                    <option value="<?php echo $list['employee_id'];?>">
                                                                        <?php echo $list['firstname'].' / '.$list['email']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-email">
                                                        <label class="col-sm-3 contact-label" for="date">Type oF Task:</label>
                                                        <div class="col-sm-8" style="padding:0;">
                                                            <select class="form-control subject" style="font-size: 14px;" id="subject"  multiple="multiple" size="3">
                                                                <option value=" " disabled>Type of task</option>
                                                                <option value="Calling">Calling</option>
                                                                <option value="Mailing">Mailing</option>
                                                                <option value="Meeting Setup">Meeting Setup</option>
                                                                <option value="Price Quote">Price Quote</option>
                                                                <option value="Invoice">Invoice</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-email">
                                                        <label class="col-sm-3 contact-label" for="date">On Date:</label>
                                                        <div class="col-sm-8" style="padding:0;">
                                                            <div class="input-group controls input-append date task_datetime">
                                                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                                                <input  type="text" class="form-control date-align" name="date" id="ondate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="textarea">
                                                    <textarea class="textarea" id="task" name="notes"></textarea>
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
                                </ul>

<!-- -----------------------------------------text editor-------------------------- -->
                      <div class="col-sm-12 tab-content" style="margin-top: 10px;">
                                    <div id="notes" class="tab-pane fade in active">
                                        <?php foreach($notes as $note){
                                            $updatednotename=$functions->getEmployeeByEmpId($note['updated_by_id']);
                                            ?>
                                        <div class="comments-section">
                                            <?php  echo $note['note'];?> By  <strong><?php  echo $updatednotename['firstname'];?></strong>
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
                                    </div>
                                 </div>
                            </div>
                        </div>
                       <?php include('footer-right.php'); ?>
                    </div>
                </div>
            </div>
<?php include('nav-foot.php'); ?>
<script type="text/javascript" src="http://media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>
<script src="../twilio/quickstart.js"></script>
<!--  Create Invoice Modal -->
<div class="modal fade" id="createinvoice" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" style="font-size: 15px;">Invoice</p>
                <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="leadid" id="leadid" value=""/>
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Name:</label></div>
                    <div class="col-sm-7 form-group"><input type="text" class="form-control" id="name"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Address:</label></div>
                    <div class="col-sm-7 form-group"><textarea class="form-control" id="address"></textarea></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Amount:</label></div>
                    <div class="col-sm-7 form-group"><input type="number" class="form-control" id="amount"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Paid Amount:</label></div>
                    <div class="col-sm-7 form-group"><input type="number" class="form-control" id="paid_amount"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Purchase Order:</label></div>
                    <div class="col-sm-7 form-group"><input type="text" class="form-control" id="purchase_order"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Select Template:</label></div>
                    <div class="col-sm-7 form-group">
                        <select  class="form-control" id="temptype" style="font-size: 14px">
                            <option value="1">Template-1</option>
                            <option value="2">Template-2</option>
                            <option value="3">Template-3</option>
                           </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label></label>
                <button type="button" class="btn btn-success" id="create_invoice" data-dismiss="modal">Create</button>
            </div>
        </div>
    </div>
</div>
<!-- end document-->
<!--  Edit Invoice Modal -->
<div class="modal fade" id="editinvoice" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" style="font-size: 15px;">Edit Invoice</p>
                <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="leadid" id="editleadid" value=""/>
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Name:</label></div>
                    <div class="col-sm-7 form-group"><input type="text" class="form-control" id="editname" value="<?php echo $Invoicedata['name'];?>"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Address:</label></div>
                    <div class="col-sm-7 form-group"><textarea class="form-control" id="editaddress"><?php echo $Invoicedata['address'];?></textarea></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Amount:</label></div>
                    <div class="col-sm-7 form-group"><input type="number" class="form-control" id="editamount" value="<?php echo $Invoicedata['amount'];?>"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Paid Amount:</label></div>
                    <div class="col-sm-7 form-group"><input type="number" class="form-control" id="editpaid_amount" value="<?php echo $Invoicedata['paid_amount'];?>"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Purchase Order:</label></div>
                    <div class="col-sm-7 form-group"><input type="text" class="form-control" id="editpurchase_order" value="<?php echo $Invoicedata['purchase_order'];?>"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Select Template:</label></div>
                    <div class="col-sm-7 form-group">
                        <select  class="form-control" id="edittemptype" style="font-size: 14px">
                            <option value="1" <?php if($Invoicedata['invoice_template_id'] == '1'){echo("selected");}?>>Template-1</option>
                            <option value="2" <?php if($Invoicedata['invoice_template_id'] == '2'){echo("selected");}?>>Template-2</option>
                            <option value="3" <?php if($Invoicedata['invoice_template_id'] == '3'){echo("selected");}?>>Template-3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label></label>
                <button type="button" class="btn btn-success" id="edit_invoice" data-dismiss="modal" value="<?php echo $invoice_id;?>">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- end document-->

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
                               onchange="updatecol(<?php echo $leadid;?>,this.value,'mobile',this.id)">
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
                        <input type="text" id="report_title" name="report_title" placeholder="Report Title" class="form-control contact-label" value="<?php echo $report_title;?>" readonly>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="text-input" class="contact-label">Report Code</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="report_code" name="report_code" placeholder="Report code" class="form-control contact-label" value="<?php echo $report_code;?>" readonly>
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
                        <select id="Lead_Status" name="Lead_Status"  class="form-control contact-label" onchange="updatecol(<?php echo $leadid;?>,this.value,'lead_stage_id',this.id)">
                            <?php foreach($LEADSTAGES as $value){ ?>
                            <option value="<?php echo $value['id'];?>" <?php if($value['id']==$lead_status){?>selected="selected"<?php } ?>><?php echo $value['stage']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
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
                        <input type="text" id="text-input" name="Lead Status"class="form-control contact-label" value="<?php echo $leadGenerationChannel[$channel];?>" readonly>
                    </div>
                </div>
                <?php if($status== 2){ ?>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label for="text-input" class="contact-label">Rejection Note</label>
                    </div>
                    <div class="col-md-9">
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