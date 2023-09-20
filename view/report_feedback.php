<?php
	include('nav-head.php');
	$ReportFeedbackList = $functions->getreportfeedback();
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <h4 style="margin-bottom:10px;text-align:center;">Report Feedback</h4>
           <div class="row">
              <div class="col-md-12" style="padding:0;">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data4" id="datatable">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Quality</th>
                                <th>Accuracy</th>
                                <th>InsightTrendz</th>
                                <th>Testimonial</th>
                                <th>Refer</th>
                                <th>Submitted Date</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach($ReportFeedbackList as $row){ ?>
                            <tr>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['quality']; ?></td>
                                <td><?php echo $row['accuracy']; ?></td>
                                 <td><?php echo $row['insights_trendzs']; ?></td>
                                 <td><?php if( $row['testimonials'] != ""){
                                 echo $row['testimonials'];
                                  }else{
                                  echo "---";
                                  }?></td>
                                 <td><?php if($row['refers']== "1"){
                                 echo "YES";
                                 }else{
                                 echo "NO";
                                 }?></td>
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
