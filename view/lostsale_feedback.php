<?php
	include('nav-head.php');
	$LostSaleList = $functions->getlostsalefeedback();
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <h4 style="margin-bottom:10px;text-align:center;">Lost Sale Feedback</h4>
           <div class="row">
              <div class="col-md-12" style="padding:0;">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data4" id="datatable">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Reached Expectation</th>
                                <th>Understand Requirements</th>
                                <th>Reason</th>
                                <th>Submitted Date</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach($LostSaleList as $row){ ?>
                            <tr>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php if($row['reach_expectation'] == "1"){
                                 echo "YES";
                                 }else{
                                echo "NO";
                                }?></td>
                                <td><?php if($row['requirement_understand'] == "1"){
                                  echo "YES";
                                 }else{
                                 echo "NO";
                                 }?></td>
                                <td><?php echo $row['reason']; ?></td>
                                <td><?php echo $row['created']; ?></td>
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
