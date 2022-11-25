<?php
	include('nav-head.php');
	if(isset($_POST['Submit']) && $_POST['Submit']=="add team"){	
		$date = date("Y-m-d H:i:s");
		$data = array('team'=>$_POST['team'],'created'=>$date);
		$teamId = $functions->insertTeam($data);
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
                                        <strong>Team</strong>
                                    </div>
									<?php if(isset($teamId)){ ?>
									<div class="card-header">
										<h4><p class="text-danger">Team created successfully</p></h4>
									</div>
									<?php } ?>
                                    <div class="card-body card-block">
                                        <form action="add_team.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Team</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="team" placeholder="Team" class="form-control">
                                                </div>
                                            </div>
											<div class="row form-group">
                                                <button type="submit" class="btn btn-primary btn-sm" name="Submit" value="add team">
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