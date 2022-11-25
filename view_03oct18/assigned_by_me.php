<?php include('nav-head.php');
$assigned_by_id=$_SESSION['employee_id'];
$assigned_by=$functions->getTasksbByassignById($assigned_by_id);
/*print_r($assigned_by);*/
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4"><h4>Tasks - Assigned by Me:</h4></div>
                    <div class="col-sm-6"></div>
                    <div class="col-sm-2">
                        <select class="form-control tasktype" style="border: none;" id="tasktype">
                            <option value="all">All types</option>
                            <?php foreach($taskstatus as $key => $val){ ?>
                                <option value="<?php echo $key;?>"><?php echo $val; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <table class="table table-borderless table-data4 table-scroll-child" style="margin-top: 10px;">
                    <thead>
                    <tr>
                        <th>Header</th>
                        <th>tasks</th>
                        <th>On date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="filter-tasks">
                     <?php foreach($assigned_by as $value){?>
                        <tr>
                        <td><?php echo str_replace(',','<br>',$value['header']);?></td>
                        <td><?php  echo $value['task'];?></td>
                        <td><?php echo $value['date'];?></td>
                        <td><?php echo $taskstatus[$value['status']];?></td>
                        </tr>
                     <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
<?php include('nav-foot.php');?>