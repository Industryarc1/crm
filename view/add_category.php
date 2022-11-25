<?php	include('nav-head.php');
	$categories=$projectfunctions->getAllCategories();

if(isset($_POST['Submit']) && $_POST['Submit']=="add_category"){
	  $date = date("Y-m-d");
			$data = array('category'=>$_POST['Category'],'created_by'=>$_SESSION['employee_id'],
				'created_date'=>$date);
			$categoryId = $projectfunctions->insertCategory($data);
			$categories=$projectfunctions->getAllCategories();
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
                          <strong>Add Category</strong>
                      </div>
                 <?php if(isset($categoryId) !=""){ ?>
                 <div class="card-header">
                  <h4><p class="text-danger">Category added Successfully.</p></h4>
                 </div>
                 <?php } ?>
                  <div class="card-body card-block">
                      <form action="add_category.php" method="post" enctype="multipart/form-data" class="form-horizontal">

                         <div class="row form-group">
                              <div class="col col-md-3">
                                  <label for="text-input" class=" form-control-label">Category Name</label>
                              </div>
                              <div class="col-12 col-md-8">
                                  <input type="text" id="Category" name="Category" placeholder="Enter Category Name" class="form-control">
                              </div>
                             </div>
                                 <div class="row form-group" style="float: right;">
                                <button type="submit" class="btn btn-primary btn-sm" name="Submit" value="add_category">
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
                                                             <th>Category</th>
                                                             <th>Created By</th>
                                                           </tr>
                                                      </thead>
                                                      <tbody>
                                                       <?php foreach($categories as $row){ ?>
                                                          <tr>
                                                            <td><?php echo $row['category']; ?></td>
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
