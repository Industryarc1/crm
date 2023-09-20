<?php
include('nav-head.php');
	$categories=$projectfunctions->getAllCategories();
	$projects=$projectfunctions->getAllProjects();
	$emp_id=$_SESSION['employee_id'];
	//$emp_id="5";
$ProjectFilter = 0;
foreach($_SESSION['proj_filter'] as $key=>$value){
    if($value!="" || $value!=null){
        $ProjectFilter = 1;
        break;
    }
}
 if($ProjectFilter == 1) {
  $data=array('category_id'=>$_SESSION['proj_filter']['category'],
              'project_id'=>$_SESSION['proj_filter']['project'],
              'status'=>$_SESSION['proj_filter']['status'],
              'ass_fromdate'=>$_SESSION['proj_filter']['fromdate'],
              'ass_todate'=>$_SESSION['proj_filter']['todate']
              );
  $tasklists=$projectfunctions->getMyProjectTasksBySearchData($data,$emp_id);
 }else{
   $tasklists=$projectfunctions->getAssignedProjectTasksByEmpId($emp_id);
 }
/*echo "<pre>";
print_r($tasklists);
exit();*/
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p20">
        <div class="container-fluid">
                <div class="col-md-12">
                   <div class="row">
                      <div class="col-md-9" id="filter-projects">
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
                </div>
                  <div class="col-md-3 filters-card">
                   <label style="margin:0;">Apply Filters :
                  <button class="btn btn-danger" id="remove_proj_filter" style="font-size: 12px;margin-left: 30px;margin-bottom: 5px;padding:3px;">RemoveFilter</button>
                  </label>
                   <select class="form-control contact-label selectfilter" id="filtervalue">
                               <option value=" " selected disabled>select filter</option>
                               <option value="1">By Category</option>
                               <option value="2">By Project</option>
                               <option value="3">Status</option>
                               <option value="4">Assigned Date</option>
                               <option value="5">Expected Date</option>
                               </select>
                             <div class="close-input" id="5">
                               <span style="font-size: 12px;width: 100%;">Expected From date</span>
                                <div class="input-group controls input-append date filter_datetime">
                                   <input  type="text" class="filter-control-cal date-align" name="filter-control" id="exp_from_date" value="<?php echo $_SESSION['proj_filter']['exp_fromdate']; ?>">
                                   <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    <button type="button" class="filter-close">&times;</button>
                                </div>
                                 <span style="font-size: 12px;width: 100%;">Expected To date</span>
                                 <div class="input-group controls input-append date filter_datetime">
                                     <input  type="text" class="filter-control-cal date-align" name="filter-control" id="exp_to_date" value="<?php echo $_SESSION['proj_filter']['exp_todate']; ?>">
                                     <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                      <button type="button" class="filter-close">&times;</button>
                                 </div>
                             </div>
                             <div class="close-input" id="4">
                             <span style="font-size: 12px;width: 100%;">From date</span>
                              <div class="input-group controls input-append date filter_datetime">
                                 <input  type="text" class="filter-control-cal date-align" name="filter-control" id="ass_from_date" value="<?php echo $_SESSION['proj_filter']['fromdate']; ?>">
                                 <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                  <button type="button" class="filter-close">&times;</button>
                              </div>
                               <span style="font-size: 12px;width: 100%;">To date</span>
                               <div class="input-group controls input-append date filter_datetime">
                                   <input  type="text" class="filter-control-cal date-align" name="filter-control" id="ass_to_date" value="<?php echo $_SESSION['proj_filter']['todate']; ?>">
                                   <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    <button type="button" class="filter-close">&times;</button>
                               </div>
                              </div>
                               <div class="row close-input" id="1">
                               <span style="font-size: 12px;width: 100%;">Category</span>
                               <select class="filter-control" id="fcategory">
                                 <option value="" selected disabled>Please select</option>
                                 <?php foreach($categories as $row){ ?>
                                 <option value="<?php echo $row['id'];?>" <?php if($_SESSION['proj_filter']['category']== $row['id']){?>selected="selected"<?php } ?>><?php echo $row['category']; ?></option>
                                 <?php } ?>
                                </select>
                                  <button type="button" class="filter-close">&times;</button>
                             </div>
                              <div class="row close-input" id="2">
                                  <span style="font-size: 12px;width: 100%;">Project</span>
                                  <select class="filter-control" id="Fproject">
                                    <option value="" selected disabled>Please select</option>
                                     <?php foreach($projects as $row){ ?>
                                     <option value="<?php echo $row['id']; ?>" <?php if($_SESSION['proj_filter']['project']== $row['id']){?>selected="selected"<?php } ?>><?php echo $row['project_name']; ?></option>
                                     <?php } ?>
                                   </select>
                                     <button type="button" class="filter-close">&times;</button>
                                </div>
                                  <div class="row close-input" id="3">
                                    <span style="font-size: 12px;width: 100%;">Status</span>
                                    <select class="filter-control" id="proj_status">
                                       <option value="" selected disabled>Please select</option>
                                       <option value="0" <?php if($_SESSION['proj_filter']['status']== "0"){?>selected="selected"<?php } ?>>Pending</option>
                                       <option value="1" <?php if($_SESSION['proj_filter']['status']== "1"){?>selected="selected"<?php } ?>>Completed</option>
                                       <option value="2" <?php if($_SESSION['proj_filter']['status']== "2"){?>selected="selected"<?php } ?>>Failed</option>
                                     </select>
                                     <button type="button" class="filter-close">&times;</button>
                                  </div>
                                  <div class="close-input" style="float:right">
                                  <button type="button" class="btn btn-success" id="emp_project_filter"
                                  style="font-size: 14px;padding: 2px 8px;">Filter</button>
                                  </div>
                             </div>
                      </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<?php include('nav-foot.php');?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<script>
$(document).ready(function() {
 <?php if($ProjectFilter == 1){?>
    $("#remove_proj_filter").show();
    <?php } else {?>
    $("#remove_proj_filter").hide();
 <?php } ?>
 <?php if($_SESSION['proj_filter']['category'] != null){?>
       $('#1').show();
 <?php }?>
 <?php if($_SESSION['proj_filter']['project'] != null){?>
       $('#2').show();
 <?php }?>
 <?php if($_SESSION['proj_filter']['status'] != null){?>
        $('#3').show();
 <?php }?>
 <?php if($_SESSION['proj_filter']['fromdate'] != null){?>
        $('#4').show();
  <?php }?>
  <?php if($_SESSION['proj_filter']['exp_fromdate'] != null){?>
        $('#5').show();
  <?php }?>
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
<!--update comments project to Modal -->
    <div class="modal fade" id="open_comment_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" style="font-size: 15px">Update Task</p>
                    <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                   <div class="row form-group">
                    <input type="hidden" name="task_id" id="task_id" value=""/>
                       <div class="col-md-4">
                           <label for="text-input" class="form-control-label">Status</label>
                       </div>
                       <div class="col-md-8">
                             <select name="task_status" id="user_status" class="form-control-sm form-control">
                              <option value="" selected disabled>Please select</option>
                              <option value="0">Pending</option>
                              <option value="1">Completed</option>
                            </select>
                       </div>
                   </div>
                   <div class="row form-group">
                     <div class="col-md-5">
                         <label for="text-input" class="form-control-label">Request Deadline<br><span style="font-size:12px;">(if needed*)</span></label>
                        </div>
                        <div class="col-md-7">
                         <div class="input-group date dealclosure_date">
                           <input type="text" class="form-control-sm form-control"  id="req_deadline"placeholder="Enter Date">
                           <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                      </div>
                     <div class="row form-group">
                          <div class="col-md-4">
                                <label for="text-input" class=" form-control-label">Comments</label>
                            </div>
                            <div class="col-md-8">
                            <textarea id="user_comments" class="form-control" col="3"></textarea>
                            </div>
                       </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="user_commnets">Submit</button>
                </div>
            </div>
        </div>
    </div>
<!---------------------- end document------------------------------------------>
<!--get comments project to Modal -->
    <div class="modal fade" id="open_reply_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" style="font-size: 15px">Conversation</p>
                    <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                   <input type="hidden" name="task_id" id="task_id" value=""/>
                   <div class="get_all_comments">
                   </div>
                     <div class="row">
                           <div class="col-md-12">
                             <strong style="font-size: 14px;">Comment:</strong>
                             <textarea id="comments" class="form-control" size="3"></textarea>
                         </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save_comments">Submit</button>
                </div>
            </div>
        </div>
    </div>
<!---------------------- end document------------------------------------------>

<!-- project Details to Modal -->
    <div class="modal fade" id="open_proj_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" style="font-size: 15px">Task Details</p>
                    <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                   <div class="row form-group">
                    <input type="hidden" name="task_id" id="task_id" value=""/>
                       <div class="col-md-4">
                           <label for="text-input" class=" form-control-label">Select Category</label>
                       </div>
                       <div class="col-md-8">
                            <select name="selectCategory" id="selectCategory" class="form-control-sm form-control">
                              <option value="" selected disabled>Please select</option>
                                <?php foreach($categories as $row){ ?>
                                   <option value="<?php echo $row['id']; ?>" disabled><?php echo $row['category']; ?></option>
                                   <?php } ?>
                               </select>
                       </div>
                   </div>
                     <div class="row form-group">
                        <div class="col-md-4">
                            <label for="text-input" class=" form-control-label">Select project</label>
                        </div>
                        <div class="col-md-8">
                              <select name="selectProject" id="selectProject" class="form-control-sm form-control">
                              <option value="" selected disabled>Please select</option>
                                <?php foreach($projects as $row){ ?>
                                   <option value="<?php echo $row['id']; ?>" disabled><?php echo $row['project_name']; ?></option>
                                   <?php } ?>
                               </select>
                        </div>
                     </div>
                <div class="row form-group">
                   <div class="col-md-4">
                           <label for="text-input" class=" form-control-label">Task Name</label>
                       </div>
                       <div class="col-md-8">
                           <input type="text" id="taskname" name="taskname" class="form-control" style="padding: 5px;font-size: 14px;" readonly>
                       </div>
                   </div>
                  <div class="row form-group">
                      <div class="col-md-5">
                             <label for="text-input" class=" form-control-label">Expected Deadline</label>
                         </div>
                         <div class="col-md-7">
                          <div class="input-group date">
                            <input type="text" class="form-control contact-label"  id="exp_deadline" readonly>
                             <span class="input-group-addon"><i class="fas fa-calendar"></i> </span>
                             </div>
                         </div>
                       </div>
                       <div class="row form-group">
                          <div class="col-md-4">
                                <label for="text-input" class=" form-control-label">Description</label>
                            </div>
                            <div class="col-md-8">
                            <textarea id="description"  class="form-control" col="3" disabled></textarea>
                            </div>
                       </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
<!---------------------- end document------------------------------------------>


