<?php
	include('nav-head.php');
	$managerLists = $functions->getEmployeeListsByRoleId(3);
	$countries=$functions->getCountries();
	if(isset($_POST['Submit']) && $_POST['Submit']=="add leads" && $_POST['firstname']!="" && $_POST['email']!="" ){
		$date = date("Y-m-d H:i:s");
		if($_SESSION['role']=="admin"){
			$associatedId = "";
			$managerId = $_POST['manager'];
			$leadGenerationChannelId = 5;
			$empData = $functions->getEmployeeByEmpId($managerId);
			$assignManager = $empData['email'];
			$departmentId = $empData['department_ids'];
			$departMentName = $functions->getDepartmentByDepartmentId($departmentId);
			$department = $departMentName['name'];			
		}		
		if($_SESSION['role']=="supervisor"){
			$associatedId = ""; 
			$managerId = $_POST['manager'];
			$leadGenerationChannelId = 5;
			$empData = $functions->getEmployeeByEmpId($managerId);
			$assignManager = $empData['email'];
			$departmentId = $empData['department_ids'];
			$departMentName = $functions->getDepartmentByDepartmentId($departmentId);
			$department = $departMentName['name'];
		}		
		if($_SESSION['role']=="manager" && $_SESSION['team']=="sales"){
			$associatedId = $_POST['manager'];
			$managerId = $_SESSION['employee_id'];
			$leadGenerationChannelId = 5;
			$empData = $functions->getEmployeeByEmpId($managerId);
			$assignManager = $empData['email'];
			$departmentId = $empData['department_ids'];
			$departMentName = $functions->getDepartmentByDepartmentId($departmentId);
			$department = $departMentName['name'];
		}		
		if($_SESSION['role']=="employee" && $_SESSION['team']=="seo"){
			$associatedId = "";
			$seoAssociatedId = $_SESSION['employee_id'];
			$empData = $functions->getEmployeeByEmpId($seoAssociatedId);
			$seoManagerId = $empData['manager_id'];
			$managerId = $_POST['manager'];
			$empData1 = $functions->getEmployeeByEmpId($managerId);
			$assignManager = $empData1['email'];
			$departmentId = $empData1['department_ids'];
			$departMentName = $functions->getDepartmentByDepartmentId($departmentId);
			$department = $departMentName['name'];
			if($_SESSION['domain']=="IARC"){
				$leadGenerationChannelId = 2;
			}else{
				$leadGenerationChannelId = 4;
			}			
		}
		
		$leadStageId = 2;
		
		$sameLeadWithSameReport = 0;
		$sameLeadWithDiffReport = 0;
		
		$data = array('associated_id'=>$associatedId,'seo_associated_id'=>$seoAssociatedId,'fname'=>$_POST['firstname'],'lname'=>$_POST['lastname'],'job_title'=>$_POST['jobtitle'],'email'=>$_POST['email'],'company'=>$_POST['company'],'company_url'=>$_POST['company_url'],'country'=>$_POST['country'],'phone_number'=>$_POST['phone'],'mobile'=>$_POST['mobile'],'lead_stage_id'=>$leadStageId,'lead_generation_channel_id'=>$leadGenerationChannelId,'lead_significance'=>$_POST['lead_significance'],'manager_id'=>$managerId,'seo_manager_id'=>$seoManagerId,'assign_manager'=>$assignManager,'department'=>$department,'entry_point'=>$_POST['request_type'],'txt_comments'=>$_POST['specific_req'],'report_code'=>$_POST['report_code'],'report_name'=>$_POST['report_name'],'category'=>$category,'title_related_my_company'=>$_POST['company_title'],'created'=>$date,'twitter_username'=>$_POST['twitter_username'],'same_lead_report'=>$sameLeadWithSameReport,'same_lead_dif_report'=>$sameLeadWithDiffReport,'created_by'=>$_SESSION['employee_id']);
		
		$leadId = $functions->insertLeads($data);
		
		$to="venkat@industryarc.com";
		//$to="y.swapna.1994@gmail.com";
		$subject="Lead Uploaded By Seo Team";
		$message=' <div class="col-sm-3">
		<h5>Dear Sales Team,</h5>
		</div>
		<div class="col-sm-8">
		<p><br>Below are the details of latest uploaded client by SEO team.</p>
		<div class="row" style="background-color:lightgrey;font-size: 13px;">
		<table>
		<tr>
		<th style="padding:5px;">First Name</th>
		<th>:</th>
		<td>'.$_POST['firstname'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Last Name</th>
		<th>:</th>
		<td>'.$_POST['lastname'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Email</th>
		<th>:</th>
		<td>'.$_POST['email'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Company</th>
		<th>:</th>
		<td>'.$_POST['company'].'</td>
		</tr> <tr>
		<th style="padding:5px;">Job Title</th>
		<th>:</th>
		<td>'.$_POST['jobtitle'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Country</th>
		<th>:</th>
		<td>'.$_POST['country'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Contact Number</th>
		<th>:</th>
		<td>'.$_POST['phone'].'</td>
		</tr>
		<tr>
		<th style="padding:5px;">Report name</th>
		<th>:</th>
		<td>'.$_POST['report_name'].'</td>
		</tr>
		</table>
		</div>
		</div>
		<div class="col-sm-3">
		<br>Thanks,<br>
		<strong>IndustryArc</strong>
		</div>';
		$email= $functions->smtpMail($to,$subject,$message);
        /*$adminCheck = $functions->checkEmployee($_POST['email']);
		if($adminCheck['employee_id']==""){		
			$date = date("Y-m-d H:i:s");
			$departments = implode(",",$_POST['department']);
			$data = array('firstname'=>$_POST['firstname'],'lastname'=>$_POST['lastname'],'username'=>$_POST['username'],'email'=>$_POST['email'],'password'=>md5($_POST['password']),'mobile'=>$_POST['mobile'],'created'=>$date,'created_by'=>$_SESSION['employee_id'],'updated'=>$date,'updated_by'=>$_SESSION['employee_id'],'role_id'=>$_POST['role'],'team_id'=>$_POST['team'],'department_ids'=>$departments,'status'=>1,'ip_address'=>$_SERVER['SERVER_ADDR'],'manager_id'=>$_POST['manager_id'],'domain'=>$_POST['domain']);
			//$leadId = $functions->insertLeads($data);
		}*/
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
                                        <strong>Add New Lead</strong>
                                    </div>
									<?php if(isset($leadId)){ ?>
									<div class="card-header">
										<h4><p class="text-danger">Lead Created Successfully.</p></h4>
									</div>
									<?php } ?>
									
                                    <div class="card-body card-block">
                                        <form action="add_contact.php" method="post" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">First Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="firstname" placeholder="First Name" class="form-control">
                                                </div>
                                            </div>
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Last Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="lastname" placeholder="Last Name" class="form-control">
                                                </div>
                                            </div>
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Job Title</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="jobtitle" placeholder="Enter Job Title" class="form-control">
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
                                                    <label for="selectSm" class=" form-control-label">Manager</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="manager" id="SelectLm" class="form-control-sm form-control">
                                                        <option value="">Please select</option>
														<?php foreach($managerLists as $managerList){ ?>
                                                        <option value="<?php echo $managerList['employee_id']; ?>"><?php echo $managerList['firstname']." ".$managerList['lastname']." / ".$managerList['email']; ?></option>
														<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Report Code</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="report_code" placeholder="Enter Code" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Report Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="report_name" placeholder="Enter Name" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Phone Number</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="phone" placeholder="Enter Phone Number" class="form-control">
                                                </div>
                                            </div>
                                           
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Mobile</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="mobile" placeholder="Enter Mobile Number" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Company Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="company" placeholder="Enter Company" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Company Url</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="company_url" placeholder="Enter Company Url" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Country</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select class="form-control" id="text-input" name="country">
                                                        <option value="">Select Country</option>
                                                        <?php foreach($countries as $country){ ?>
                                                            <option value="<?php echo $country['country']; ?>"><?php echo $country['country']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											<div class="row form-group">
                                                <div class="col col-md-8">
                                                    <label for="email-input" class=" form-control-label">Kindly Provide titles related to my company</label>
                                                </div>
                                                <div class="col-12 col-md-4">
													<label class="radio-inline">
													  <input type="radio" id="text-input" name="company_title" value="Yes" class="form-control">Yes
													</label>
													<label class="radio-inline">
													  <input type="radio" id="text-input" name="company_title" value="No" class="form-control" checked>No
													</label>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Specific Requirement</label>
                                                </div>
                                                <div class="col-12 col-md-9">
													<textarea name="specific_req" class="form-control" rows="4" ></textarea>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Request Type</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="request_type" id="SelectLm" class="form-control-sm form-control">
                                                        <option value="Sample Brochure">Sample Brochure</option>
                                                        <option value="Purchase Entry">Purchase Entry</option>
                                                        <option value="RPF">RPF</option>
                                                        <option value="RBB">RBB</option>
                                                        <option value="Subscriber">Subscriber</option>
                                                        <option value="Contact-us">Contact-us</option>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Lead Significance</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="lead_significance" id="SelectLm" class="form-control-sm form-control">
                                                        <option value="h.v">h.v</option>
                                                        <option value="m.v">m.v</option>
                                                        <option value="l.v">l.v</option>
                                                    </select>
                                                </div>
                                            </div>
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Twitter Username</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="twitter_username" placeholder="Enter Company Url" class="form-control">
                                                </div>
                                            </div>
											<div class="row form-group" style="float:right;padding-right: 20px;">
                                                <button type="submit" class="btn btn-primary" name="Submit" value="add leads">
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