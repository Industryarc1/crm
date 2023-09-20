<?php
	include('nav-head.php');
	$teamLists = $functions->getTeamLists();
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>Team</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php foreach($teamLists as $teamList){ ?>
                                            <tr>
                                                <td><?php echo $teamList['team']; ?></td>
                                                <td><?php echo $teamList['created']; ?></td>
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
