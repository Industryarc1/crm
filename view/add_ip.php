<?php	include('nav-head.php');
$ipaddress = $projectfunctions->getAllipAddress();
if(isset($_POST['Submit']) && $_POST['Submit']=="add_ip_address"){
	  $date = date("Y-m-d");
			$data = array('location'=>$_POST['location'],'ip_address'=>$_POST['ip_address'],'added_by'=>$_SESSION['employee_id'],
				'created'=>$date);
		$IpAaddressId = $projectfunctions->insertIpAddress($data);
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
                          <strong>Add Ip Address</strong>
                      </div>
                 <?php if(isset($IpAaddressId) !=""){ ?>
                 <div class="card-header">
                  <h4><p class="text-danger">Ip Address added Successfully.</p></h4>
                 </div>
                 <?php
                  	} ?>
                  <div class="card-body card-block">
                      <form action="add_ip.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                               <div class="col col-md-5">
                                  <label for="text-input" style="margin: 0!important;">Location</label>
                                  <input type="text" id="location" name="location" placeholder="Enter Location" class="form-control">
                               </div>
                              <div class="col col-md-5">
                                  <label for="text-input" style="margin: 0!important;">Ip Address</label>
                                  <input type="text" id="ip_address" name="ip_address" placeholder="Enter Ip" class="form-control">
                              </div>
                               <div class="col col-md-2" style="top: 25px;">
                                <button type="submit" class="btn btn-primary" name="Submit" value="add_ip_address">
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
                                                             <th>Location</th>
                                                              <th>Ip Address</th>
                                                              <th>Created By</th>
                                                              <th>Delete</th>
                                                           </tr>
                                                      </thead>
                                                      <tbody>
                                                       <?php foreach($ipaddress as $row){ ?>
                                                          <tr>
                                                            <td><?php echo $row['location']; ?></td>
                                                            <td><?php echo $row['ip_address']; ?></td>
                                                            <td><?php
                                                            $emp=$functions->getEmployeeByEmpId($row['added_by']);
                                                             echo $emp['firstname']." ".$emp['lastname']; ?></td>
                                                            <td>
                                                            <button class="del_address" value="<?php echo $row['id'];?>">
                                                            <i class="fas fa-trash-alt" style="font-size: 16px;color: red;margin-left:25px;"></i></button>
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
<?php include('nav-foot.php');?>

