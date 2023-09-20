<?php include('nav-head.php');
	$projects=$projectfunctions->getAllProjects();
 if(isset($_POST['Submit']) && $_POST['Submit']=="add_project"){
	  $date = date("Y-m-d");
			$data = array('project_name'=>$_POST['project_name'],'exp_delivery_date'=>$_POST['exp_delivery_date'],
			'created_by'=>$_SESSION['employee_id'],'created_date'=>$date);
		 	$projectId = $projectfunctions->insertProject($data);
		 		$projects=$projectfunctions->getAllProjects();
}
 ?>
   <!-- MAIN CONTENT-->
<div class="main-content">
   <div class="section__content section__content--p30">
       <div class="container-fluid">
           <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                      <div class="card-header">
                          <strong>Add Project Title</strong>
                      </div>
                 <?php if(isset($projectId) !=""){ ?>
                 <div class="card-header">
                  <h4><p class="text-danger">Project Title added Successfully.</p></h4>
                 </div>
                 <?php } ?>
                  <div class="card-body card-block">
                      <form action="add_project.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                         <div class="row form-group">
                              <div class="col col-md-3">
                                  <label for="text-input" class=" form-control-label">Project Name</label>
                              </div>
                              <div class="col-12 col-md-8">
                                  <input type="text" name="project_name" placeholder="Enter Project Name" class="form-control">
                              </div>
                             </div>
                                 <div class="row form-group">
                                   <div class="col col-md-3">
                                       <label for="text-input" class=" form-control-label">Expected Delivery Date</label>
                                   </div>
                                   <div class="col-12 col-md-8">
                                    <div class="input-group date dealclosure_date">
                                      <input type="text" class="form-control"  name="exp_delivery_date" placeholder="Enter Date">
                                      <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                                       </div>
                                   </div>
                              </div>
                                 <div class="row form-group" style="float: right;">
                                <button type="submit" class="btn btn-primary btn-sm" name="Submit" value="add_project">
                                  <i class="fa fa-dot-circle-o"></i> Submit
                                 </button>
                                </div>
                             </form>
                         </div>
                  </div>
               </div>
                <!------------------  DATA TABLE START---------------------------------->
                 <div class="table-responsive m-b-40">
                                   <table class="table table-borderless table-data4" id="datatable">
                                       <thead>
                                           <tr>
                                              <th>Project</th>
                                              <th>Expected Delivery Date</th>
                                               <th>Created By</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                        <?php foreach($projects as $row){ ?>
                                           <tr>
                                             <td><?php echo $row['project_name']; ?></td>
                                             <td><?php echo $row['exp_delivery_date']; ?></td>
                                             <td><?php
                                             $emp=$functions->getEmployeeByEmpId($row['created_by']);
                                              echo $emp['firstname']." ".$emp['lastname']; ?></td>
                                           </tr>
                                           <?php } ?>
                                       </tbody>
                                   </table>
                               </div>
               <!------------------ END DATA TABLE---------------------------------->
          </div>
      </div>
 </div>
<?php include('nav-foot.php');?>
