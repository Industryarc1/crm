<?php
session_start();
ini_set("display_errors",0);
include_once('../../model/function.php');
$functions = new functions();
include_once('../../model/contacts2function.php');
$contacts2functions = new contacts2functions();
 $associate_id ="5";
 //$associate_id=$_SESSION['employee_id'];
if(isset($_POST['filter']) && isset($_POST['filter'])!= ""){
   $category=$_POST['category'];
   $level=$_POST['level'];
   $country=$_POST['country'];
    $data=array('category'=>$category,'managementlevel'=>$level,'country'=>$country);
    $Myconlists=$contacts2functions->getAllEmpContactsVersion2($associate_id,$data);
}
 //print_r($Myconlists);
 //exit;
?>
<!--------------- DATA TABLE------------------------->
        <div class="table-responsive m-b-40">
            <table class="table table-responsivetable-borderless table-report" id="contacttable">
                <thead>
                    <tr>
                      <th>FullName</th>
                      <th>Category</th>
                      <th>Levels</th>
                      <th>Industry</th>
                      <th>Company</th>
                      <th>Company Number</th>
                      <th>Website</th>
                      <th>Country</th>
                      <th>Title</th>
                      <th>TotalRevenue</th>
                      <th>EmployeeSize</th>
                      <th>Action</th>
                    </tr>
                </thead>
              <tbody>
               <?php foreach($Myconlists as $row){ ?>
                <tr>
              <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
              <td><?php echo $row['category']; ?></td>
              <td><?php echo $row['managementlevel']; ?></td>
              <td><?php echo $row['industry']; ?></td>
              <td><?php echo $row['company_name']; ?></td>
              <td><?php echo $row['company_phone']; ?></td>
              <td><?php echo $row['company_domain']; ?></td>
              <td><?php echo $row['country']; ?></td>
              <td><?php echo $row['title']; ?></td>
              <td><?php echo $row['company_revenue']; ?></td>
              <td><?php echo $row['company_employees']; ?></td>
              <td><?php
                if($row['status']==0){?>
                    <button style="width:22px;height:22px;" class="btn-status openconvert" data-toggle="modal" value="<?php echo $row['id'];?>" data-target="#openconvert"><i  style="color: green" class="fas fa-redo"></i></button>
                    <button style="width:22px;height:22px;" class="btn-status openreject" data-toggle="modal" value="<?php echo $row['id'];?>" data-target="#openreject"><i style="color: red" class="fas fa-times"></i></button>
               <?php }elseif($row['status'] == 2){
                   echo $row['comments'];
                 } else {
                    echo "Converted";
                 }?></td>
               </tr>
               <?php } ?>
              </tbody>
            </table>
        </div>
<!---------------- END DATA TABLE-->
<script>
$(document).ready(function() {
  $('#contacttable').DataTable({
      "ordering": false,
        "scrollX": true,
         "autoWidth": false
    });
    $("#contacttable").on("click", ".openconvert", function(){
            var contactid = $(this).val();
            console.log(contactid);
            $(".modal-body #app_id").val(contactid);
    });
    $("#contacttable").on("click", ".openreject", function(){
         var contactid = $(this).val();
         console.log(contactid);
         $(".modal-body #rej_id").val(contactid);
    });
});
</script>
