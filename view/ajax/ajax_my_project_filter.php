<?php
session_start();
ini_set("display_errors",0);
include_once('../../model/function.php');
$functions = new functions();
include_once('../../model/projectfunction.php');
$projectfunctions = new projectfunctions();
$projectlists = array();
$emp_id=$_SESSION['employee_id'];
//$emp_id="5";
if(isset($_POST['filterMyProjects']) && $_POST['filterMyProjects'] != "") {
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
    $data=array('category_id'=>$proj_category,'project_id'=>$project_id,'status'=>$proj_status,'ass_fromdate'=>$proj_fromdate,
    'ass_todate'=>$proj_todate,'exp_fromdate'=>$proj_expected_fromdate,'exp_todate'=>$proj_expected_todate);
    $tasklists=$projectfunctions->getMyProjectTasksBySearchData($data,$emp_id);
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
                                  <!-- <th>Project</th>-->
                                <th>Category</th>
                                <th>Assigned Date</th>
                                <th>Expected Dealine</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach($tasklists as $row){ ?>
                            <tr>
                          <td><?php echo $row['task_name']; ?></td>
                           <!-- <td><?php
                           $proj=$projectfunctions->getProjectById($row['project_id']);
                           echo $proj['project_name'];
                           ?></td>-->
                           <td><?php
                           $cat=$projectfunctions->getCategoryById($row['category_id']);
                           echo $cat['category'];
                           ?></td>
                            <td><?php echo $row['assigned_date']; ?></td>
                            <td><?php
                              $date = date("Y-m-d");
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
                             <button class="edit_proj" data-toggle="modal" data-target="#edit_proj" value="<?php echo $row['id'];?>" style="margin:0 5px 0 5px;">
                             <i class="fas fa-info-circle" style="font-size: 16px;color: gray;"></i></button>
                             <button class="get_comments" data-toggle="modal" value="<?php echo $row['id'];?>" data-target="#get_comments" style="margin:0 5px 0 0;">
                             <i class="fas fa-comments" style="font-size: 17px;color: cornflowerblue;"></i></button>
                             <button class="send_reply" data-toggle="modal" value="<?php echo $row['id'];?>" data-target="#send_reply">
                             <i class="fas fa-reply" style="font-size: 17px;color: green;"></i></button>
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
  $('.get_comments').click(function() {
     var task_id = $(this).val();
       //console.log(task_id);
     $(".modal-body #task_id").val(task_id);
     $('#open_comment_modal').modal('show');
 });
 $('.send_reply').click(function() {
     var task_id = $(this).val();
       //console.log(task_id);
     $(".modal-body #task_id").val(task_id);
      $.ajax({
           type: "POST",
           url: 'ajax/project_ajax.php',
           cache: false,
           data: ({comment_task_id: task_id}),
           success: function(data){
            // console.log(data);
              $('#open_reply_modal').modal('show');
              $(".get_all_comments").html(data);
          }
       });
   });
 $('.edit_proj').click(function() {
      var task_id = $(this).val();
     //  console.log(task_id);
        $.ajax({
          type: "POST",
          url: 'ajax/project_ajax.php',
          data: ({edit_task_id: task_id}),
          success: function(result){
         // console.log(result);
              var obj=JSON.parse(result);
             $('#open_proj_modal').modal('show');
              $("#task_id").val(obj.id);
             $("#selectCategory").val(obj.category_id);
             $("#selectProject").val(obj.project_id);
             $("#taskname").val(obj.task_name);
             $("#exp_deadline").val(obj.expected_deadline);
             $("#description").val(obj.description);
            }
       });
   });
  });
 </script>
