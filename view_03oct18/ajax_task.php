<?php
session_start();
include('../config.php');
include_once('../model/function.php');
$functions = new functions();
$assigned_by_id=$_SESSION['employee_id'];

$assigned_by = array();
if(isset($_GET['status'])){
    $status=$_GET['status'];
    if($status == 'all'){
        $assigned_by = $functions->getTasksbByassignById($assigned_by_id);
    }else{
        $assigned_by = $functions->getTasksByStatusAndId($assigned_by_id,$status);
    }
}
if(!empty($assigned_by)){
foreach($assigned_by as $value){
 ?>
    <tr>
        <td><?php  echo $value['header'];?></td>
        <td><?php  echo $value['task'];?></td>
        <td><?php echo $value['date'];?></td>
        <td><?php echo $taskstatus[$value['status']];?></td>
    </tr>
<?php }
}
else{
    echo "<tr><td>Task not Found</td>
<td></td><td></td><td></td></tr>";
}?>