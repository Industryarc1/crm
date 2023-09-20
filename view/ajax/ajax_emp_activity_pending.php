<?php
session_start();
ini_set("display_errors",0);
include_once('../../model/function.php');
$functions = new functions();
$getmanagers=$functions->getSalesManager();
$associate_id ="150";
//$associate_id=$_SESSION['employee_id'];
if(isset($_POST['leadids']) && isset($_POST['leadids'])!= ""){
    $leadids=$_POST['leadids'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $data=array('createdf'=>$fromdate,'createdt'=>$todate);
    $Leads=$functions->getEmpleadsActivityPendingByFilter($associate_id,$leadids,$data);
}
// print_r($Leads);
 //exit;
?>
  <!-- DATA TABLE-->
<div class="table-responsive m-b-40">
  <table class="table table-responsivetable-borderless table-report" id="example">
      <thead>
          <tr>
             <th>Full Name</th>
             <th>Email</th>
             <th>Phone</th>
             <th>Jobtitle</th>
             <th>Company</th>
             <th>Department</th>
             <th>Report Code</th>
             <th>Created</th>
          </tr>
      </thead>
      <tbody>
   <?php foreach($Leads as $row){ ?>
            <tr>
            <td><a href="contact_details.php?lead_id=<?php echo base64_encode($row['id']);?>"
             target="_blank"><?php echo $row['fname']." ".$row['lname']; ?></a></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['mobile']; ?></td>
            <td><?php echo $row['job_title']; ?></td>
            <td><?php echo $row['company']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['report_code']; ?></td>
             <td><?php echo $row['created']; ?></td>
           </tr>
           <?php } ?>
      </tbody>
  </table>
</div>
<!-- END DATA TABLE-->
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "ordering": false,
        "scrollX": true,
        "autoWidth": false
    });
});
</script>
