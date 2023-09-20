<?php
	include('nav-head.php');
	$ClosedLeadLists = $functions->getClosedLeadlist();
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <h4 style="margin-bottom:10px;text-align:center;">Closed Leads List</h4>
           <div class="row">
              <div class="col-md-12" style="padding:0;">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data4" id="datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Country</th>
                                <th>Domain</th>
                                <th>Report Code</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach($ClosedLeadLists as $row){ ?>
                            <tr>
                                <td><?php echo $row['fname']." ".$row['fname']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                 <td><?php echo $row['country']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <td><?php if($row['report_code'] == ""){
                                   echo "--Not Defined--";
                                 }else{
                                  echo $row['report_code'];
                                 } ?></td>
                                <td><?php echo $row['created']; ?></td>
                                <td><button class="btn btn-success" style="font-size: 12px;padding:5px;" data-toggle="modal"
value="<?php echo base64_encode($row['email']);?>" data-target="#getlink" onclick="getemail(this.value)">GetLink</button></td>
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
function getemail(email){
	var reportlink = "https://feedback.industryarc.com/reportfeedback.php?auth=" + email;
	$(".modal-body #copylink").val(reportlink);
}
</script>
<!-- FEEDBACK LINK Modal -->
  <div class="modal fade" id="getlink" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         <h4 class="modal-title">Report Feedback Link</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
             <div class="col-sm-12">
             <label class="control-label" for="search">Copy Link</label>
             <input type="text" class="form-control" style="font-size:14px;" id="copylink" value=" " readonly/>
             </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
 </div>
