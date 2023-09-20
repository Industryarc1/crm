<?php
session_start();
ini_set("display_errors",0);
include_once('../../model/function.php');
$functions = new functions();
include_once('../../model/projectfunction.php');
$projectfunctions = new projectfunctions();
$projectlists = array();

if(isset($_POST['filterProjects']) && $_POST['filterProjects'] != "") {
    $proj_category= $_POST['FCategory'];
    $project_id= $_POST['Fproject'];
    $proj_status= $_POST['proj_status'];
    $proj_fromdate = $_POST['ass_fromdate'];
    $proj_todate = $_POST['ass_todate'];
    $proj_expected_fromdate=$_POST['exp_fromdate'];
    $proj_expected_todate=$_POST['exp_todate'];
      $_SESSION['proj_filter']['category']=$proj_category;
      $_SESSION['proj_filter']['project']=$project_id;
      $_SESSION['proj_filter']['status']=$proj_status;
      $_SESSION['proj_filter']['fromdate']=$proj_fromdate;
      $_SESSION['proj_filter']['todate']=$proj_todate;
      $_SESSION['proj_filter']['exp_fromdate']=$proj_expected_fromdate;
      $_SESSION['proj_filter']['exp_todate']=$proj_expected_todate;

    $data=array('category_id'=>$proj_category,'project_id'=>$project_id,'status'=>$proj_status,
            'ass_fromdate'=>$proj_fromdate,'ass_todate'=>$proj_todate,'exp_fromdate'=>$proj_expected_fromdate,
            'exp_todate'=>$proj_expected_todate);
    $tasklists=$projectfunctions->getAllProjectTasksBySearchData($data);
}
/*echo "<pre>";
print_r($tasklists);
exit();*/
?>
 <!------------------------ DATA TABLE---------------------->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data4" id="datatable">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                 <!--<th>Project</th>-->
                                <th>Category</th>
                                 <!-- <th>Assigned To</th>-->
                                <th>Assigned Date</th>
                                <th>Expected Dealine</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach($tasklists as $row){ ?>
                            <tr>
                              <td><a href="project_details.php?task_id=<?php echo base64_encode($row['id']);?>"
                               target="_blank"><?php echo $row['task_name']; ?></a></td>
                               <!--<td><?php
                              $proj=$projectfunctions->getProjectById($row['project_id']);
                              echo $proj['project_name'];
                              ?></td>-->
                              <td><?php
                              $cat=$projectfunctions->getCategoryById($row['category_id']);
                              echo $cat['category'];
                              ?></td>
                           <!--   <td><?php
                              $emps=$projectfunctions->getEmployeeByEmpIds($row['assigned_to']);
                              foreach($emps as $emp){
                               echo $emp['firstname']."<br>";
                              }
                              ?></td>-->
                              <td><?php echo $row['assigned_date']; ?></td>
                               <td><?php
                                 $date= date("Y-m-d");
                                 if(strtotime($date) >= strtotime($row['expected_deadline'])){
                                    echo "<b style='color:red;'>".$row['expected_deadline']."</b>";
                                 }else{
                                   echo $row['expected_deadline'];
                                 }
                                 ?></td>
                               <td><?php
                                  $val=$row['status'];
                                  echo ($val == 0 ? "Pending" : ($val == 1 ? 'Completed' : 'Failed'));?>
                               </td>
                               <td>
                              <button class="get_comments" data-toggle="modal" value="<?php echo $row['id'];?>"
                              data-target="#get_comments" style="margin:0 10px 0 10px;"><i class="fas fa-reply"
                              style="font-size: 17px;color: green;"></i></button>
                                <button class="del_project" value="<?php echo $row['id'];?>">
                                <i class="fas fa-trash-alt" style="font-size: 16px;color: red;"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
 <!------------------ END DATA TABLE---------------------------------->
<script>
$(document).ready(function() {
     $('#datatable').DataTable({
         "ordering": false
       });
    $('.del_project').click(function(){
          var value=$(this).val();
          //console.log(value);
          alert("Are you sure to delete these project?");
          $.ajax({
             type: "POST",
             url: 'ajax/project_ajax.php',
             data: ({del_project: value}),
             success: function(result){
             //console.log(result);
             window.location.reload();
             }
           });
     });
    $('.get_comments').click(function() {
          var task_id = $(this).val();
          console.log(task_id);
          $(".modal-body #task_id").val(task_id);
         $.ajax({
                  type: "POST",
                  url: 'ajax/project_ajax.php',
                  cache: false,
                  data: ({comment_task_id: task_id}),
                  success: function(data){
                    console.log(data);
                     $('#open_proj_modal').modal('show');
                     $(".get_all_comments").html(data);
                 }
             });
     });
});
</script>
