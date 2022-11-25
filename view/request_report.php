<?php
	include_once('nav-head.php');
	//to insert dat in request reports
	include_once('../model/contacts2function.php');
 $contacts2functions = new contacts2functions();
 $leadid = base64_decode($_GET['lead_id']);
 $company=$functions->getleadbyId($leadid);
 $departments=$functions->getDepartmentLists();
 $EmpDetails =$functions->getEmployeeByEmpId($_SESSION['employee_id']);
 $today = date('Y-m-d');
$nextdate = date('Y-m-d', strtotime($today . ' +5 Weekday'));
$fourdays = date('Y-m-d', strtotime($today . ' +4 Weekday'));
$threedays = date('Y-m-d', strtotime($today . ' +3 Weekday'));
$twodays = date('Y-m-d', strtotime($today . ' +2 Weekday'));
$oneday = date('Y-m-d', strtotime($today . ' +1 Weekday'));
	if(isset($_POST['Submit']) && $_POST['Submit']=="request_report" && $_POST['request_report']!= " " ){
 	   $date = date("Y-m-d H:i:s");
 	   $report_type =implode(",",$_POST['report_type']);
 	   $data = array('lead_id'=>$_POST['lead_id'],
 	                 'company'=>$_POST['company'],
 	                 'priority'=>$_POST['priority'],
                   'report_type'=>$report_type,
                   'title_name'=>$_POST['title_name'],
                   'department'=>$_POST['department'],
                   'deadline'=>$_POST['deadline'],
                   'comments'=>$_POST['comments'],
                   'filepath'=>$_POST['filepath'],
                   'requested_by'=>$_SESSION['employee_id'],
                   'created'=>$date);
     $reqId = $contacts2functions->insertRequestReports($data);
     if($reqId != 0){
      $UniqueId = "RR".$reqId;
      $employee = $functions->getEmployeeByEmpId($_SESSION['employee_id']);
      $post = array(
              'requestId' => $reqId,
              'uniqueId'=> $UniqueId,
              'company'=>$_POST['company'],
              'priority'=>$_POST['priority'],
              'report_type'=>$_POST['report_type'],
              'title_name'=>$_POST['title_name'],
              'department'=>$_POST['department'],
              'deadline'=>$_POST['deadline'],
              'comments'=>$contacts2functions->cleanData($_POST['comments']),
              'filepath'=>$_POST['filepath'],
              'requested_by'=>$employee['firstname']." ".$employee['lastname'],
              'created'=>$date
             );
         $ch1 = curl_init();
         curl_setopt($ch1, CURLOPT_URL, 'http://182.73.4.147/rtts/API/requesteddata');
         curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($post));
         $response = curl_exec($ch1);
         curl_close($ch1);
       //  print_r($post);exit;
         if($response == "Done"){
             $updatedata = array('unique_id'=>$UniqueId,'api_call'=> 1);
             $updateresult = $contacts2functions->updateRequestReportsById($reqId,$updatedata);
              $to = "rm@industryarc.com";
              $cc="mkt@industryarc.com";
              $formatdate = date("d-m-Y",strtotime($_POST['deadline']));
              //$to ="y.swapna.1994@gmail.com";
              // $cc ="swapna.yarraguntla@industryarc.com";
				          $subject='Sales Request - '.$UniqueId.' - '.$_POST['company'].' - '.$_POST['priority'].'';
              	$message=' <div class="col-sm-3">
              	<h4>Dear Team,</h4>
              	</div>
              	<div class="col-sm-8">
              	<p><br>You got a new request from '.$EmpDetails['firstname'].' '.$EmpDetails['lastname'].'.</p>
                <div class="row" style="background-color:#eeeee;font-size: 13px;">
                 <table>
                 <tr>
                 <th style="padding:5px;">Company Name</th>
                 <th>:</th>
                 <td>'.$_POST['company'].'</td>
                 </tr>
                 <tr>
                 <th style="padding:5px;">RequestId</th>
                 <th>:</th>
                 <td>'.$UniqueId.'</td>
                 </tr>
                 <tr>
                 <th style="padding:5px;">Title</th>
                 <th>:</th>
                 <td>'.$_POST['title_name'].'</td>
                 </tr>
                 <tr>
                 <th style="padding:5px;">Department</th>
                 <th>:</th>
                 <td>'.$_POST['department'].'</td>
                 </tr>
                 <tr>
                  <th style="padding:5px;">Priority</th>
                  <th>:</th>
                  <td>'.$_POST['priority'].'</td>
                  </tr>
                 <tr>
                 <th style="padding:5px;">Deadline</th>
                 <th>:</th>
                 <td>'.$formatdate.'</td>
                 </tr>
                  <tr>
                  <th style="padding:5px;">Request Type</th>
                  <th>:</th>
                  <td>'.$report_type.'</td>
                  </tr>
                   <tr>
                  <th style="padding:5px;">Comments</th>
                  <th>:</th>
                  <td>'.$_POST['comments'].'</td>
                  </tr>
                 </table>
                 </div>
                </div>
              	<div class="col-sm-3">
              	<br>Thanks,<br>
              	<strong>'.$EmpDetails['firstname'].' '.$EmpDetails['lastname'].'</strong><br>
              	<strong>IndustryARC</strong>
              	</div>';
              	$result = $contacts2functions->SendCCMail($to,$subject,$message,$cc);
              	echo "Success";
               //print_r($result);
         }else{
              echo 'failed to call Api';
         }
      }
        // echo $result;
         //print_r($post);
         // exit;
 }
 ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
 .multiselect-container {
     width: 100%;
 }
 <!-- MAIN CONTENT-->
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                   <div class="card">
                       <div class="card-header">
                           <strong>Send Research Request </strong>
                       </div>
                  <?php if(isset($updateresult) != 0){ ?>
                  <div class="card-header">
                   <h4><p class="text-danger">Request sent Successfully.</p></h4>
                  </div>
                  <?php } ?>
                      <div class="card-body card-block">
                             <form action="request_report.php?lead_id=<?php echo base64_encode($leadid);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                               <div class="row form-group">
                               <input type="hidden" id="lead_id" name="lead_id" value="<?php echo $leadid; ?>"/>
                                   <div class="col col-md-6">
                                       <label for="text-input" class=" form-control-label">Company Name *</label>
                                        <input type="text" id="company" name="company" class="form-control" value="<?php echo $company['company'];?>" placeholder="Enter company name" required>
                                    </div>
                                   <div class="col col-md-6">
                                      <label for="text-input" class=" form-control-label">Department *</label>
                                      <select id="department" name="department" class="form-control" required>
                                      <option value="" selected disabled>Select stage</option>
                                        <?php foreach($departments as $row) { ?>
                                        <option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
                                        <?php }?>
                                      </select>
                                   </div>
                                </div>
                                <div class="row form-group">
                                   <div class="col col-md-6">
                                       <label for="text-input" class=" form-control-label">Title Name *</label>
                                        <input type="text" id="title_name" name="title_name" placeholder="Enter Title Name" class="form-control" required>
                                    </div>
                                   <div class="col col-md-6">
                                      <label for="text-input" class="form-control-label">Priority *</label>
                                       <select id="priority" name="priority" class="form-control priority" required>
                                           <option value="" selected disabled>Select stage</option>
                                           <option value="p1">Priority 1(least)</option>
                                           <option value="p2">Priority 2</option>
                                           <option value="p3">Priority 3</option>
                                           <option value="p4">Priority 4</option>
                                           <option value="p5">Priority 5(first)</option>
                                       </select>
                                   </div>
                                </div>
                                <div class="row form-group">
                                     <div class="col col-md-6">
                                         <label for="text-input" class=" form-control-label">Request Type *</label>
                                          <select id="report_type" name="report_type[]" class="form-control country" multiple required>
                                          <!-- <option value="" selected disabled>Select stage</option>-->
                                           <option  value="Full Report Publishing">Full Report Publishing</option>
                                           <option id="theSelect" value="Table of Contents">Table of Contents</option>
                                           <option id="theSelect" value="Samples Tables">Samples Tables</option>
                                           <option id="theSelect" value="Proposal">Proposal</option>
                                           <option id="theSelect" value="Data Points">Data Points</option>
                                           <option id="theSelect" value="Sample Extract">Sample Extract</option>
                                           <option id="theSelect" value="Consultant">Consultant</option>
                                          </select>
                                      </div>
                                     <div class="col col-md-6">
                                        <label for="text-input" class="form-control-label">Expected Deadline *</label>
                                        <div class="input-group controls input-append date">
                                          <input type="text" class="form-control pick_date" name="deadline" id="deadline">
                                          <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                        </div>
                                     </div>
                                </div>
                                 <div class="row form-group">
                                     <div class="col col-md-6">
                                         <label for="text-input" class="form-control-label">Comments</label>
                                         <textarea class="form-control" id="comments" name="comments" col="5"></textarea>
                                      </div>
                                     <div class="col col-md-6">
                                        <label for="text-input" class=" form-control-label">File Path</label>
                                         <input type="text" id="filepath" name="filepath" placeholder="Enter File path" class="form-control">
                                     </div>
                                </div>
                                  <div class="row form-group" style="float: right;">
                                        <button type="submit" class="btn btn-primary btn-sm" name="Submit" value="request_report">
                                         <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                 </div>
                             </form>
                      </div>
                  </div>
            </div>
         </div>
    </div>
 </div>
<?php include('nav-foot.php');?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
          var date = new Date();
       $('#report_type').multiselect({
           nonSelectedText:'---Select---',
           buttonWidth: '100%',
           enableHTML: true,
           buttonClass: 'btn btn-default-btn',
      });
      $('.pick_date').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: date,
            minView: 2
           });
       $("select.country").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
         if(selectedCountry == "Full Report Publishing"){
                $("input[type=checkbox]:not(:checked)").attr("disabled", "disabled");
                $("#report_type").val('Full Report Publishing');
                $("#deadline").val('<?php echo $nextdate; ?>');
                $("#deadline").prop("readonly", true);
                $("#deadline").removeClass("pick_date");
                //$("#deadline").attr("date","text");
                //$('.pick_date').datetimepicker('remove');
                //$('.pick_date').datetimepicker('destroy');
             }else {
                $("input[type=checkbox]:not(:checked)").attr("disabled",false);
                //$("#deadline").val(' ');
                $("#deadline").prop('readonly', false)
             }
       });
      $("select.priority").change(function(){
        var selectedpriority =$(this).children("option:selected").val();
        console.log(selectedpriority);
        if(selectedpriority == "p1") {
          $("#deadline").val('<?php echo $nextdate; ?>');
        } else if(selectedpriority == "p2"){
          $("#deadline").val('<?php echo $fourdays; ?>');
        } else if(selectedpriority == "p3") {
          $("#deadline").val('<?php echo $threedays; ?>');
        } else if(selectedpriority == "p4") {
          $("#deadline").val('<?php echo $twodays; ?>');
        } else if(selectedpriority == "p5") {
           $("#deadline").val('<?php echo $oneday; ?>');
        }
     });
 });
 </script>
