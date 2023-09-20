<?php
include('nav-head.php');
$countries=$functions->getCountries();
if(isset($_POST['Submit']) && $_POST['Submit']=="add accounts" && $_POST['company']!="" && $_POST['country']!="" ){
    $date = date("Y-m-d H:i:s");
	$assignToId = ($_SESSION['role_id'] == 4 && $_SESSION['team_id']== 2) ? $_SESSION['employee_id']:0;
	
    $data = array('company_name'=>$_POST['company'],'website'=>$_POST['website'],
        'employee_size'=>$_POST['emp_size'],'total_revenue'=>$_POST['total_revenue'],'assign_to'=>$assignToId,
        'num_of_locations'=>$_POST['no_of_locations'],'ceo_of_company'=>$_POST['ceo_of_company'],
        'linkedin_profile'=>$_POST['linkedin_profile'],'country'=>$_POST['country'],'created'=>$date,
        'created_by'=>$_SESSION['employee_id'],'status'=>0);
    $AccountId = $accountsfunctions->insertAccounts($data);
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
                                <strong>Add New Account</strong>
                            </div>
                              <?php if(isset($AccountId)!= ""){ ?>
                              <div class="card-header">
                                  <h4><p class="text-danger">Account Created Successfully.</p></h4>
                              </div>
                            <?php }?>
                            <div class="card-body card-block">
                                <form action="add_account.php" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Company Name</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="company" placeholder="Company name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class="form-control-label">Website</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="email-input" name="website" placeholder="Website Url" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class="form-control-label">Employee Size</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="emp_size" placeholder="Enter Employee Size" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Total Revenue(in $ Million)</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="total_revenue" placeholder="Total revenue" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Number of Locations</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="no_of_locations" placeholder="no of locations" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Ceo of Company</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="ceo_of_company" placeholder="Enter name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">LinkedIn Profile</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="linkedin_profile" placeholder="Enter linkedin" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class="form-control-label">Country</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select class="form-control" id="text-input" name="country">
                                                <option value="">Select Country</option>
                                                <?php foreach($countries as $country){ ?>
                                                    <option value="<?php echo $country['country'];?>"><?php echo $country['country']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="float:right;padding-right: 20px;">
                                        <button type="submit" class="btn btn-primary" name="Submit" value="add accounts">
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
