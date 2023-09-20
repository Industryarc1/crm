<?php
	include('nav-head.php');
 if($_SESSION['role_id'] == 4 && $_SESSION['team_id'] == 1){
 $reports=$functions->getSeoEmpReportsByEmpId($_SESSION['employee_id']);
 }else{
 $reports=$functions->getAllSeoReports();
 }
//	$Links = $functions->getEmpLinkReportsByEmpId($_SESSION['employee_id']);
//	print_r($Links);exit;
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row m-t-30">
                <div class="col-md-12">
                <h4 style="text-align:center;">Submitted Reports</h4>
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">
                        <table class="table table-responsivetable-borderless table-report" id="datatable">
                            <thead>
                                <tr>
                                    <th>Report Code</th>
                                    <th>Report Title</th>
                                    <th>Created On</th>
                                    <th>Url Activity</th>
                                    <?php if($_SESSION['role_id'] == 1){ ?>
                                    <th>Submitted By</th>
                                    <th>Action</th>
                                    <?php }else{ ?>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                        <?php foreach($reports as $row){ ?>
                                <tr>
                                  <td><?php echo $row['report_code']; ?></td>
                                  <td><?php echo $row['report_title']; ?></td>
                                  <td><?php echo $row['created']; ?></td>
                                   <td><?php
                                    $tot=$functions->getCountOfLinksByReportId($row['id']);
                                     echo $tot['total']; ?></td>
                                <?php if($_SESSION['role_id'] == 1){ ?>
                                   <td>
                                   <?php $empname=$functions->getEmployeeByEmpId($row['created_by']);
                                   echo $empname['firstname']." ".$empname['lastname'];
                                   ?>
                                   </td>
                                  <td><a href="view_links.php?report_id=<?php echo base64_encode($row['id']);?>"
                                  target="_blank">View</a></td>
                                 <?php }else{ ?>
                                 <td>
                                 <a href="edit_links.php?report_id=<?php echo base64_encode($row['id']);?>"
                                 target="_blank" style="color: green;"><i class="fas fa-edit"
                                 style="font-size: 14px;color: green;"></i> Edit</a>
                                 </td>
                                 <td>
                                  <button type="button" class="delete"  value="<?php echo $row['id'];?>" style="font-size: 12px;color: red;">
                                  <i class="fas fa-trash" style="font-size: 14px;color: red;"></i> Delete</button>
                                  </td>
                                 <?php } ?>
                                </tr>
                                 <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('nav-foot.php'); ?>
<script>
$(document).ready(function() {
   $("#datatable").on("click", ".delete", function(){
	   //alert("Delete");
     if(confirm("Are you sure you want delete?")) {
       var delete_report=$(this).val();
        // console.log(delete_report);
           $.ajax({
               type: "POST",
               url: 'ajax.php',
               data: ({delete_report:delete_report}),
               success: function(result){
                 console.log(result);
                 window.location.reload();
               }
           });
      }else{
       return false;
      }
   });
});
</script>
