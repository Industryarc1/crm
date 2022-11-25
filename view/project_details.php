<?php
	 include('nav-head.php');
 $taskid = base64_decode($_GET['task_id']);
	$categories=$projectfunctions->getAllCategories();
	$getmanagers=$functions->getSalesManager();
	$projects=$projectfunctions->getAllProjects();
 $projdetails=$projectfunctions->getProjectTasksById($taskid);
 $comments=$projectfunctions->getProjectCommentsByProjectId($taskid);
   // print_r($task_logs);
   //exit;
?>
<script>
    function updatetask(getid,str,col,id){
     console.log(str);
        $.ajax({
            type: "POST",
            url: 'ajax/project_ajax.php',
            data: ({task_id: getid,value:str,colname:col}),
            success: function(result){
                //console.log(result);
                alert(id + " updated");
                document.getElementById(id).value = str;
            }
        });
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header">
                            <div class="row">
                               <div class="col-sm-10">
                               <input type="hidden" id="task_id" value="<?php echo $taskid;?>"/>
                               <input type="hidden" id="assign_to" value="<?php echo  $projdetails['assigned_to'];?>"/>
                                <h4 style="font-family: sans-serif;margin-top: 10px;">Task Name: <?php echo $projdetails['task_name'];?></h4>
                                </div>
                                <div class="col-sm-2">
                                <button class="add-contact" id="update_details">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-block">
                            <div class="row form-group">
                                    <div class="col-md-3">
                                        <label for="text-input" class="contact-label">Category</label>
                                         <select id="selectCategory" class="form-control contact-label">
                                           <option value="" selected disabled>Please select</option>
                                            <?php foreach($categories as $row){ ?>
                                              <option value="<?php echo $row['id'];?>" <?php if($projdetails['category_id']== $row['id']){?>selected="selected"<?php }?>><?php echo $row['category']; ?></option>
                                              <?php } ?>
                                          </select>
                                    </div>
                                  <div class="col-md-3">
                                      <label for="text-input" class="contact-label">Project</label>
                                      <select id="selectProject" class="form-control contact-label">
                                           <option value="" selected disabled>Please select</option>
                                           <?php foreach($projects as $row){ ?>
                                           <option value="<?php echo $row['id']; ?>" <?php if($projdetails['project_id']== $row['id']){?>selected="selected"<?php } ?>><?php echo $row['project_name']; ?></option>
                                           <?php } ?>
                                       </select>
                                   </div>
                                  <div class="col-md-3">
                                       <label for="text-input" class="contact-label">Status</label>
                                       <select class="form-control contact-label" id="status">
                                       <option value="" selected disabled>Please select</option>
                                       <option value="0" <?php if($projdetails['status']== "0"){?>selected="selected"<?php } ?>>Pending</option>
                                       <option value="1" <?php if($projdetails['status']== "1"){?>selected="selected"<?php } ?>>Completed</option>
                                       <option value="2" <?php if($projdetails['status']== "2"){?>selected="selected"<?php } ?>>Failed</option>
                                       </select>
                                   </div>
                                  <div class="col-md-3">
                                   <label for="text-input" class="contact-label">Assigned To</label>
                                    <select id="selectemployee" multiple="multiple" class="form-control contact-label">
                                     <?php foreach($getmanagers as $row){ ?>
                                      <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['firstname']." ".$row['lastname']; ?></option>
                                       <?php } ?>
                                    </select>
                                  </div>
                            </div>
                            <div class="row form-group">
                                 <div class="col-md-3">
                                      <label for="text-input" class="contact-label">Expected Deadline</label>
                                       <div class="input-group date dealclosure_date">
                                       <input type="text" class="form-control contact-label" id="exp_deadline" placeholder="Enter Date" value="<?php echo $projdetails['expected_deadline'];?>">
                                       <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                       </div>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="text-input" class="contact-label">Assigned Date*</label>
                                       <div class="input-group date">
                                       <input type="text" class="form-control contact-label"  placeholder="Enter Date" value="<?php echo $projdetails['assigned_date'];?>" readonly>
                                       <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                       </div>
                                  </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Assigned By*</label>
                                    <?php  $emp=$functions->getEmployeeByEmpId($projdetails['assigned_by']); ?>
                                    <input type="text" class="form-control contact-label" value="<?php echo $emp['firstname']." ".$emp['lastname'];?>" readonly>
                                </div>
                                  <div class="col-md-3">
                                     <label for="text-input" class="contact-label">Lead*</label>
                                       <?php  $lead=$functions->getLeadById($projdetails['lead_id']); ?>
                                     <input type="text" class="form-control contact-label" value="<?php echo $lead['fname']." ".$lead['lname'];?>" readonly>
                                  </div>
                            </div>
                           <div class="row form-group">
                             <div class="col-md-3">
                                 <label for="text-input" class="contact-label">Description</label>
                                 <textarea class="form-control contact-label" id="description"><?php echo $projdetails['description'];?></textarea>
                             </div>
                             <div class="col-md-3">
                                <label for="text-input" class="contact-label">Rating</label>
                                <input type="text" id="rating" class="form-control contact-label" value="<?php echo $projdetails['rating'];?>">
                             </div>
                           </div>
                       </div>
                     </div>
                       <h4 style="margin:15px;">Project Conversation:</h4>
   <!------------------------ DATA TABLE---------------------->
                   <div class="table-responsive m-b-40">
                       <table class="table table-borderless table-data4" id="datatable">
                          <thead>
                               <tr>
                                  <th>Updated By</th>
                                  <th>Created Date</th>
                                  <th>Requested DeadLine</th>
                                  <th>Comments</th>
                                  <th>User Status</th>
                               </tr>
                           </thead>
                           <tbody>
                            <?php foreach($comments as $row){ ?>
                               <tr>
                                <td><?php
                                 $emps=$functions->getEmployeeByEmpId($row['updated_by']);
                                  echo $emps['firstname']."<br>";
                                 ?></td>
                                 <td><?php echo $row['created_date']; ?></td>
                                  <td><?php echo $row['requested_deadline']; ?></td>
                                  <td><?php echo $row['comments']; ?></td>
                                   <td><?php
                                      $val=$row['user_status'];
                                      echo ($val == 0 ? "Pending" : ($val == 1 ? 'Completed' : 'Failed'));?>
                                   </td>
                               </tr>
                               <?php } ?>
                           </tbody>
                       </table>
                    </div>
<!------------------ END DATA TABLE---------------------------------->
                </div>
             </div>
       </div>
   </div>
</div>
<?php include('nav-foot.php');?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<script>
$(document).ready(function() {
   $('#selectemployee').multiselect({
              nonSelectedText:'------Assign To------',
              buttonWidth: '100%',
              buttonClass: 'btn btn-default-btn',
     });
     var data= $("#assign_to").val();
    // console.log(data);
     var dataarray=data.split(",");
     $("#selectemployee").val(dataarray);
     $("#selectemployee").multiselect("refresh")
});
</script>

