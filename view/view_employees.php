<?php
	include('nav-head.php');
	$employeeLists = $functions->getEmployeeLists();
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data4" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>status</th>
                                                <th>Role</th>
                                                <th>Team</th>
                                                <th>Domain</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										                               <?php foreach($employeeLists as $empList){ ?>
                                            <tr>
                                                <td><?php echo $empList['name']; ?></td>
                                                <td><?php echo $empList['email']; ?></td>
                                                <td><?php echo $empList['mobile']; ?></td>
                                                <td><?php if($empList['status'] == 0){ ?>
													<div class="status-checkbox">
													<button class="emp-status" value="1" data-id="<?php echo $empList['employee_id']; ?>">
													<i class="far fa-circle status-checkbox-color"></i></button>
													</div>
													<?php }else { ?>
													<div class="status-checkbox">
													<button class="emp-status" value="0" data-id="<?php echo $empList['employee_id']; ?>">
													<i class="fas fa-check-circle status-checkbox-color"></i></button>
													</div>
													<?php } ?></td>
                                                <td><?php echo $empList['role']; ?></td>
                                                <td><?php echo $empList['team']; ?></td>
                                                <td><?php echo $empList['domain']; ?></td>
              <td><a style="color: red" href="edit_employee.php?emp_id=<?php echo base64_encode($empList['employee_id']);?>">Edit</a></td>
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
<script>
$(document).ready(function() {
	$("#datatable").on("click", ".emp-status", function(){
		var empstatus= $(this).val();
		var emp_id = $(this).data('id');
		$.ajax({
			type: "POST",
			url: 'ajax.php',
			data: ({emp_status: empstatus,emp_id:emp_id}),
			success: function(result){
				//alert("updated successfully");
				window.location.reload();
			}
		});
	});
});
</script>
