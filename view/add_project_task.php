<?php
	include('nav-head.php');
	ini_set("display_errors",1);
	$categories=$projectfunctions->getAllCategories();
	$projects=$projectfunctions->getAllProjects();
	$getmanagers=$functions->getSalesManager();
if(isset($_POST['Submit']) && $_POST['Submit']=="add_project_task" && $_POST['task_name']!= "" ){
	   $date = date("Y-m-d");
    $a = $_POST['selectemployee'];
    $emp_ids =implode(",",$a);
   	$data = array('category_id'=>$_POST['selectCategory'],'project_id'=>$_POST['selectProject'],
   	'task_name'=>$_POST['task_name'],'assigned_to'=>$emp_ids,'assigned_by'=>$_SESSION['employee_id'],
				'assigned_date'=>$date,'created_date'=>$date,'expected_deadline'=>$_POST['exp_deadline'],
		  'description'=>$_POST['description']);
			  $taskId = $projectfunctions->insertProjectTask($data);

			      $proj=$projectfunctions->getProjectById($_POST['selectProject']);
			      $cat=$projectfunctions->getCategoryById($_POST['selectCategory']);
			      $assigned_by=$functions->getEmployeeByEmpId($_SESSION['employee_id']);
			      $emps=$projectfunctions->getEmployeeByEmpIds($emp_ids);
			      $cc_email=$assigned_by['email'];
		 	    //$address = array('y.swapna.1994@gmail.com','y.swapna.30@gmail.com','swapna.yarraguntla@industryarc.com');
		     	$address = array();
        foreach($emps as $emp){
          array_push($address, $emp['email']);
        }
        //print_r($address);exit;
         $subject='Task has been Assigned';
        	$message=' <div class="col-sm-3">
        	<h5>Dear Sales Team,</h5>
        	</div>
        	<div class="col-sm-8">
        	<div class="col-sm-8">
         <p><br>Below are the details of task has been assigned to you.</p>
         <div class="row" style="border-radius:0.4em;font-family:Arial;font-size:13px;background-color:#eee">
         					<table width="100%" cellpadding="5" cellspacing="5">
         					<tr style="border-bottom:1px solid #CCC; ">
         					<td width="30%">Task </td>
         					<td width="1%">:</td>
         					<td width="68%">'.$_POST['task_name'].'</td>
         					</tr>
         					<tr>
         					<td width="30%">Project </td>
         					<td width="1%">:</td>
         					<td width="68%">'.$proj['project_name'].'</td>
         					</tr>
         						<tr>
              <td width="30%">Category </td>
              <td width="1%">:</td>
              <td width="68%">'.$cat['category'].'</td>
              </tr>
               <tr>
              <td width="30%">Assigned By</td>
              <td width="1%">:</td>
              <td width="68%">'.$assigned_by['firstname'].' '.$assigned_by['lastname'].'</td>
              </tr>
               <tr>
               <td width="30%">Expected Deadline</td>
              <td width="1%">:</td>
              <td width="68%">'.$_POST['exp_deadline'].'</td>
              </tr>
                <tr>
               <td width="30%">Description</td>
              <td width="1%">:</td>
              <td width="68%">'.$_POST['description'].'</td>
              </tr>
         					</table>
        	 </div>
        		</div>
        	<div class="col-sm-3">
        	<br>Regards,<br>
        	<strong>IndustryArc</strong>
        	</div>';
          $email= $projectfunctions->MultiplesmtpMaila($address,$subject,$message,$cc_email);
        echo "success";
}
 ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
   <!-- MAIN CONTENT-->
<div class="main-content">
   <div class="section__content section__content--p30">
       <div class="container-fluid">
           <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                      <div class="row card-header" style="margin:0!important;">
                      <div class="col-lg-8" style="margin-top:10px;">
                          <strong>Add Project Task</strong>
                       </div>
                      <?php if(isset($taskId) !=""){ ?>
                        <div class="col-lg-8" style="margin-top:10px;">
                         <h4><p class="text-danger">Task added and assigned Successfully.</p></h4>
                        </div>
                      <?php } ?>
                       <div class="col-lg-4">
                       <button class="add-contact"> <a href="add_project.php" style="color:#FFFFFF">Add project</a></button>
                       <button class="add-contact"> <a href="add_category.php" style="color:#FFFFFF">Add Category</a></button>
                       </div>
                  </div>
                  <div class="card-body card-block">
                      <form action="add_project_task.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                              <div class="col col-md-3">
                                  <label for="text-input" class=" form-control-label">Select Category</label>
                              </div>
                              <div class="col-12 col-md-8">
                                    <select name="selectCategory" class="form-control-sm form-control">
                                    <option value="" selected disabled>Please select</option>
                                     <?php foreach($categories as $row){ ?>
                                       <option value="<?php echo $row['id']; ?>"><?php echo $row['category']; ?></option>
                                       <?php } ?>
                                   </select>
                              </div>
                          </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class="form-control-label">Select Project</label>
                            </div>
                            <div class="col-12 col-md-8">
                                  <select name="selectProject" class="form-control-sm form-control">
                                  <option value="" selected disabled>Please select</option>
                                   <?php foreach($projects as $row){ ?>
                                     <option value="<?php echo $row['id']; ?>"><?php echo $row['project_name']; ?></option>
                                     <?php } ?>
                                 </select>
                            </div>
                        </div>
                         <div class="row form-group">
                              <div class="col col-md-3">
                                  <label for="text-input" class="form-control-label">Task Name</label>
                              </div>
                              <div class="col-12 col-md-8">
                                  <input type="text" name="task_name" placeholder="Enter Project Name"
                                  class="form-control-sm form-control">
                              </div>
                           </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Assign To</label>
                                </div>
                               <div class="col-12 col-md-8">
                                   <select name="selectemployee[]" id="selectemployee"
                                   multiple="multiple" class="form-control-sm form-control">
                                      <?php foreach($getmanagers as $row){ ?>
                                       <option value="<?php echo $row['employee_id']; ?>">
                                         <?php echo $row['firstname']." ".$row['lastname']; ?></option>
                                        <?php } ?>
                                      </select>
                                  </div>
                            </div>
                            <div class="row form-group">
                              <div class="col col-md-3">
                                  <label for="text-input" class=" form-control-label">Expected Deadline</label>
                              </div>
                              <div class="col-12 col-md-8">
                               <div class="input-group date dealclosure_date">
                                 <input type="text" class="form-control contact-label"  name="exp_deadline" placeholder="Enter Date">
                                 <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                  </div>
                              </div>
                            </div>
                            <div class="row form-group">
                                   <div class="col col-md-3">
                                       <label for="text-input" class=" form-control-label">Description</label>
                                   </div>
                                   <div class="col-12 col-md-8">
                                   <textarea name="description" class="form-control" col="3"></textarea>
                                   </div>
                              </div>
                                 <div class="row form-group" style="float: right;">
                                <button type="submit" class="btn btn-primary btn-sm" name="Submit" value="add_project_task">
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
<script>
$(document).ready(function() {
   $('#selectemployee').multiselect({
             nonSelectedText:'------Assign To------',
              buttonWidth: '100%',
              enableHTML: true,
             buttonClass: 'btn btn-default-btn',
     });
});
</script>
