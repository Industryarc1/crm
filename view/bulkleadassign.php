<?php
include('nav-head.php');
$leadstages=$functions->getLeadStages();
$channels=$functions->getGenerationChannels();
$departments=$functions->getDepartmentLists();
$getmanagers=$functions->getAllSalesManager();
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <h4 style="margin-bottom: 10px;">Filter Lead Reports:</h4>
            <div class="row filters-card">
                <div class="col-lg-12">
                <div class="row" style="margin-bottom: 5px;">
                   <div class="col-sm-3">
                   <label style="margin:0px;font-size:14px;">Assigned From Date:</label>
                       <div class="input-group controls input-append date task_datetime">
                           <input  type="text" class="form-control date-align" name="date" id="ass_fromdate">
                           <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                       </div>
                   </div>
                    <div class="col-sm-3">
                        <label style="margin:0px;font-size:14px;">Assigned To Date:</label>
                        <div class="input-group controls input-append date task_datetime">
                            <input  type="text" class="form-control date-align" name="date" id="ass_todate">
                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                        </div>
                    </div>
                   <div class="col-sm-3">
                  <label style="margin:0px;font-size:14px;">LastActivity From Date:</label>
                      <div class="input-group controls input-append date task_datetime">
                          <input  type="text" class="form-control date-align" name="date" id="last_fromdate">
                          <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                      </div>
                  </div>
                   <div class="col-sm-3">
                       <label style="margin:0px;font-size:14px;">LastActivity To Date:</label>
                       <div class="input-group controls input-append date task_datetime">
                           <input  type="text" class="form-control date-align" name="date" id="last_todate">
                           <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                       </div>
                     </div>
                     </div>
                    <div class="row" style="margin-bottom: 5px;">
                       <div class="col-sm-3">
                       <label style="margin:0px;font-size:14px;">Created From Date:</label>
                           <div class="input-group controls input-append date task_datetime">
                               <input  type="text" class="form-control date-align" name="date" id="fromdate">
                               <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                           </div>
                       </div>
                        <div class="col-sm-3">
                            <label style="margin:0px;font-size:14px;">Created To Date:</label>
                            <div class="input-group controls input-append date task_datetime">
                                <input  type="text" class="form-control date-align" name="date" id="todate">
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                         <label style="margin:0px;font-size:14px;">Channel:</label>
                          <select class="form-control" id="channel" name="filter-control">
                           <option value="" selected disabled>Select Channel</option>
                           <?php foreach($channels as $channel){ ?>
                               <option class="option-display" value="<?php echo $channel['id']; ?>">
                                   <?php echo $channel['channel']; ?></option>
                           <?php } ?>
                       </select>
                        </div>
                         <div class="col-sm-3">
                         <label style="margin:0px;font-size:14px;">LeadStage:</label>
                          <select class="form-control" id="lead_stage" name="filter-control">
                          <option value="" selected disabled>Select stage</option>
                           <?php foreach($leadstages as $stage){ ?>
                               <option class="option-display" value="<?php echo $stage['id']; ?>">
                                   <?php echo $stage['stage']; ?></option>
                           <?php } ?>
                           </select>
                         </div>
                         </div>
                         <div class="row">
                          <div class="col-sm-4">
                         <label style="margin:0px;font-size:14px;">Department:</label>
                          <select class="form-control" id="department" name="filter-control">
                             <option value="" selected disabled>Select Department</option>
                             <?php foreach($departments as $department){ ?>
                                 <option class="option-display" value="<?php echo $department['name']; ?>">
                                     <?php echo $department['name']; ?></option>
                             <?php } ?>
                         </select>
                           </div>
                           <div class="col-sm-3">
                           <label style="margin:0px;font-size:14px;">AssignedTo:</label>
                               <select class="form-control" id="assign_person" name="filter-control">
                               <option value="" selected disabled>Select Here</option>
                               <?php foreach($getmanagers as $value){ ?>
                                 <option class="option-display" value="<?php echo $value['employee_id'];?>">
                                 <?php echo $value['email']; ?></option>
                               <?php } ?>
                               </select>
                           </div>
                           <div class="col-sm-3"></div>
                          <div class="col-sm-2">
                            <label></label>
                            <button class="btn btn-primary" id="reportSearch" style="margin-top: 14px;float:right;">Search</button>
                        </div>
                        </div>
                </div>
          </div>
            <div id="getreports">

            </div>

        </div>
    </div>
</div>
<?php include('nav-foot.php');?>
<script>
    $(document).ready(function() {
        $('#reportSearch').click(function() {
                var ass_fromdate = $("#ass_fromdate").val();
                var ass_todate = $("#ass_todate").val();
                var last_fromdate = $("#last_fromdate").val();
                var last_todate = $("#last_todate").val();
            var fromdate = $("#fromdate").val();
            var todate = $("#todate").val();
            var lead_stage=$("#lead_stage").val();
            var department = $("#department").val();
            var channel = $("#channel").val();
             var assign_person=$("#assign_person").val();
            $.ajax({
                type: "POST",
                url: 'get_bulk_leads.php',
                data: ({ass_fromdate:ass_fromdate,ass_todate:ass_todate,last_fromdate:last_fromdate,last_todate:last_todate,
                fromdate:fromdate,todate: todate,lead_stage:lead_stage,department:department,channel:channel,assign_person:assign_person}),
                success: function(result){
                    //console.log(result);
                    $("#getreports").html(result);
                }
            });
      });

    });
</script>
