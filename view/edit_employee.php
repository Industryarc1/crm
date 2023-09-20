<?php
include('nav-head.php');
$roleLists = $functions->getRoleLists();
$teamLists = $functions->getTeamLists();
$managerLists = $functions->getEmployeeListsByRoleId(3);
$EmpId = base64_decode($_GET['emp_id']);
$empdetails=$functions->getEmployeeByEmpId($EmpId);
if(isset($_POST['Submit']) && $_POST['Submit']=="edit emp"){
    $date = date("Y-m-d H:i:s");
    $data = array('firstname'=>$_POST['firstname'],'lastname'=>$_POST['lastname'],'mobile'=>$_POST['mobile'],'role_id'=>$_POST['role'],'team_id'=>$_POST['team'],'manager_id'=>$_POST['manager_id'],'domain'=>$_POST['domain'],'updated'=>$date,'mail_password'=>base64_encode($_POST['mail-password']),'extension'=>$_POST['extension']);
    // print_r($data);exit;
    $employeeId = $functions->updateEmployeeById($EmpId,$data);
}
//print_r($empdetails);exit;
?>
<!-- Edit MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Edit Employee</strong>
                        </div>
                        <?php if(isset($employeeId)){ ?>
                            <div class="card-header">
                                <h4><p class="text-danger">Employee updated Successfully.</p></h4>
                            </div>
                        <?php } ?>
                        <div class="card-body card-block">
                            <form action="edit_employee.php?emp_id=<?php echo base64_encode($EmpId);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">First Name</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="firstname" name="firstname" placeholder="First Name" class="form-control" value="<?php echo $empdetails['firstname'];?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Last Name</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="form-control" value="<?php echo $empdetails['lastname'];?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Username</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="username" name="username" placeholder="Enter Username" class="form-control" value="<?php echo $empdetails['username'];?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input" class="form-control-label">Email</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="email" id="email-input" name="email" placeholder="Enter Email" class="form-control" value="<?php echo $empdetails['email'];?>" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="email-input" class=" form-control-label">Mobile</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="mobile-input" name="mobile" placeholder="Enter Mobile" class="form-control" value="<?php echo $empdetails['mobile'];?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="selectSm" class="form-control-label">Role</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="role" id="Selectrole" class="form-control-sm form-control selectrole">
                                            <option value="">Please select</option>
                                            <?php foreach($roleLists as $role){ ?>
                                                <option value="<?php echo $role['role_id']; ?>" <?php if($empdetails['role_id'] == $role['role_id']){echo("selected");}?>><?php echo $role['role']; ?></option>
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
                                                    <option value="<?php echo $manager['employee_id']; ?>" <?php if($empdetails['manager_id'] == $manager['employee_id']){echo("selected");}?>><?php echo $manager['firstname']." ".$manager['lastname']." / ".$manager['email']; ?></option>
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
                                            <select name="team" id="Selectteam" class="form-control-sm form-control" value="<?php echo $empdetails['team_id'];?>">
                                                <option value="0">Please select</option>
                                                <?php foreach($teamLists as $team){ ?>
                                                    <option value="<?php echo $team['id']; ?>" <?php if($empdetails['team_id'] == $team['id']){echo("selected");}?>><?php echo $team['team']; ?></option>
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
                                            <select name="domain" id="Selectdomain" class="form-control-sm form-control" value="<?php echo $empdetails['domain'];?>">
                                                <option value="IARC" <?php if($empdetails['domain'] == 'IARC'){echo("selected");}?>>IARC</option>
                                                <option value="MIR" <?php if($empdetails['domain'] == 'MIR'){echo("selected");}?>>MIR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="row form-group">
									<div class="col col-md-3">
										<label for="selectSm" class="form-control-label">Extension</label>
									</div>
									<div class="col-12 col-md-9">
										<input type="text" id="extension" name="extension" value="<?php echo $empdetails['extension']; ?>" placeholder="Enter Extension" class="form-control">
									</div>
								</div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="password-input" class=" form-control-label">Set Mail Password</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="mail-password" name="mail-password" placeholder="Password" class="form-control" value="<?php echo base64_decode($empdetails['mail_password']);?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <button type="submit"  class="btn btn-primary btn-sm" name="Submit" value="edit emp">
                                        <i class="fa fa-dot-circle-o"></i> Update</button>
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
<?php
include('nav-foot.php');?>
