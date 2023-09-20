<?php
	include('nav-head.php');
	$roleLists = $functions->getRoleLists();
	$teamLists = $functions->getTeamLists();
	$managerLists = $functions->getEmployeeListsByRoleId(3);
	$departmentLists = $functions->getDepartmentLists();
	if(isset($_POST['Submit']) && $_POST['Submit']=="add emp"){
		$adminCheck = $functions->checkEmployee($_POST['email']);
		if($adminCheck['employee_id']==""){		
			$date = date("Y-m-d H:i:s");
			$departments = implode(",",$_POST['department']);
			$extension = !empty($_POST['extension'])?$_POST['extension']:0;
			$data = array('firstname'=>$_POST['firstname'],'lastname'=>$_POST['lastname'],'username'=>$_POST['username'],'email'=>$_POST['email'],'password'=>md5($_POST['password']),'mobile'=>$_POST['mobile'],'created'=>$date,'created_by'=>$_SESSION['employee_id'],'updated'=>$date,'updated_by'=>$_SESSION['employee_id'],'role_id'=>$_POST['role'],'team_id'=>$_POST['team'],'department_ids'=>$departments,'status'=>1,'ip_address'=>$_SERVER['SERVER_ADDR'],'manager_id'=>$_POST['manager_id'],'domain'=>$_POST['domain'],'extension'=>$extension);
			$employeeId = $functions->insertEmployee($data);
			$to=$_POST['email'];
			$subject="Successfully Registered";
            $message='<div class="col-sm-3">
                    <h5>Dear '.$_POST['username'].',</h5>
                </div>
                 <div class="col-sm-8">
                    <p><br>You are succesfully registered in Crm Portal.Your Credentials are below:<br>
					<div>Url: <strong>https://crm.industryarc.in</strong></div>
					<div>UserName: <strong>'.$_POST['email'].'</strong></div>
					<div>Password: <strong>'.$_POST['password'].'</strong></div>
					</p>
                </div>
                <div class="col-sm-3">
                    <p><br>Regards,<br>
                        <strong>CRM PORTAL</strong></p>
                </div>';
			$email= $functions->smtpMail($to,$subject,$message);
		}
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
                                        <strong>Employee Registration</strong>
                                    </div>
                                     <?php if(isset($employeeId) != ""){ ?>
                                     <div class="card-header">
                                      <h4><p class="text-danger">Employee Registered Successfully.</p></h4>
                                     </div>
                                     <?php } ?>

                                     <?php if($adminCheck['employee_id'] !=""){ ?>
                                     <div class="card-header">
                                      <h4><p class="text-danger">Employee already Registered with Username : <?php echo $adminCheck['username']; ?> and Email : <?php echo $adminCheck['email']; ?>.</p></h4>
                                     </div>
                                     <?php } ?>
                                    <div class="card-body card-block">
                                        <form action="add_employee.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">First Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="firstname" name="firstname" placeholder="First Name" class="form-control">
                                                </div>
                                            </div>
											                                       <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Last Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="form-control">
                                                </div>
                                            </div>
										                                        	<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Username</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="username" name="username" placeholder="Enter Username" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="email-input" class=" form-control-label">Email</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="email" id="email-input" name="email" placeholder="Enter Email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="password-input" class=" form-control-label">Password</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="password" id="password-input" name="password" placeholder="Password" class="form-control">
                                                </div>
                                            </div>
											                              <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="email-input" class=" form-control-label">Mobile</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="mobile-input" name="mobile" placeholder="Enter Mobile" class="form-control">
                                                </div>
                                            </div>
										                                    	<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Role</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="role" id="Selectrole" class="form-control-sm form-control selectrole">
                                                        <option value="">Please select</option>
													                                   	<?php foreach($roleLists as $role){ ?>
                                                        <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role']; ?></option>
													                                                   	<?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                                <div class="hide-manager">
											                                                   <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Manager</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="manager_id" id="Selectmanager" class="form-control-sm form-control">
                                                        <option value="0">Please select</option>
                                                        <?php foreach($managerLists as $manager){ ?>
                                                        <option value="<?php echo $manager['employee_id']; ?>"><?php echo $manager['firstname']." ".$manager['lastname']." / ".$manager['email']; ?></option>
												                                                    		<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                                </div>
                                            <div class="hide-team">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Team</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="team" id="Selectteam" class="form-control-sm form-control">
                                                        <option value="0">Please select</option>
                                                        <?php foreach($teamLists as $team){ ?>
                                                        <option value="<?php echo $team['id']; ?>"><?php echo $team['team']; ?></option>
												                                                		<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="hide-domain">
											                                         <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Domain</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="domain" id="Selectdomain" class="form-control-sm form-control">
                                                        <option value="IARC">IARC</option>
                                                        <option value="MIR">MIR</option>
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                             <div class="row form-group">
                                              <div class="col col-md-3">
                                              <label for="selectSm" class=" form-control-label">Extension</label>
                                              </div>
                                              <div class="col-12 col-md-9">
                                              <input type="text" id="extension" name="extension" placeholder="Enter Extension" class="form-control">
                                              </div>
                                             </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="multiple-select" class=" form-control-label">Departments</label>
                                                </div>
                                                <div class="col col-md-9">
                                                    <select name="department[]" id="multiple-select" multiple="" class="form-control">
                                                        <?php foreach($departmentLists as $department){ ?>
                                                        <option value="<?php echo $department['department_id']; ?>"><?php echo $department['name']; ?></option>
													                                                   	<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											                                     <div class="row form-group">
                                                <button type="submit" class="btn btn-primary btn-sm" name="Submit" value="add emp">
													                                           <i class="fa fa-dot-circle-o"></i> Submit
												                                              </button>
                                            </div>
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
