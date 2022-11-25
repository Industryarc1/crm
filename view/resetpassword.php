<?php
	include('nav-head.php');
	if(isset($_POST['Submit']) && $_POST['Submit']=="Update User"){
		$data = array('password'=>md5($_POST['password']));
		$updatePass = $functions->updateEmployeeById($_SESSION['employee_id'],$data);
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
                                        <strong>Change Password</strong>
                                    </div>
									<?php if(isset($updatePass)){ ?>
									<div class="card-header">
										<h4><p class="text-danger">Password Updated Successfully.</p></h4>
									</div>
									<?php } ?>
									
                                    <div class="card-body card-block">
                                        <form action="resetpassword.php" method="post" class="form-horizontal">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                            <input type="submit" name="Submit" value="Update User" class="btn btn-primary"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php include('footer-right.php'); ?>
                    </div>
                </div>
            </div>
<?php include('nav-foot.php'); ?>