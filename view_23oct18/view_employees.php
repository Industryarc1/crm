<?php
	include('nav-head.php');
	$employeeLists = $functions->getEmployeeLists();
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data4">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>status</th>
                                                <th>Role</th>
                                                <th>Team</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php foreach($employeeLists as $empList){ ?>
                                            <tr>
                                                <td><?php echo $empList['name']; ?></td>
                                                <td><?php echo $empList['email']; ?></td>
                                                <td><?php echo $empList['mobile']; ?></td>
                                                <td><?php echo $empList['status']; ?></td>
                                                <td><?php echo $empList['role']; ?></td>
                                                <td><?php echo $empList['team']; ?></td>
              <td><a  style="color: red" href="edit_employee.php?emp_id=<?php echo base64_encode($empList['employee_id']);?>">Edit</a></td>
                                            </tr>
										<?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                        <?php include('footer-right.php'); ?>
                    </div>
                </div>
            </div>
<?php include('nav-foot.php'); ?>
