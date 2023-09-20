<?php include('nav-head.php');
$assigned_to_id=$_SESSION['employee_id'];
$assigned_to=$functions->getTasksbByassignToId($assigned_to_id);

?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-sm-12">
                <h4>Tasks - Assigned to Me:</h4>
                <table class="table table-borderless table-data4 table-scroll-child" style="margin-top: 10px;">
                    <thead>
                    <tr>
                        <th>Header</th>
                        <th>Tasks</th>
                        <th>On date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($assigned_to as $value){?>
                        <tr>
                            <td><?php echo str_replace(',','<br>',$value['header']);?></td>
                            <td><?php  echo $value['task'];?></td>
                            <td><?php echo $value['date'];?></td>
                            <td><?php if($value['status']== 0){?>
                                <button class="btn-remarks openremarks"
                                        data-toggle="modal" value="<?php echo $value['id'];?>" data-target="#remarks"><i  style="padding-right: 5px;" class="fas fa-pencil-alt"></i>Remarks</button>
                            <?php } else { ?>
                                <p><?php echo $value['remarks'];?></p>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include('nav-foot.php');?>
    <!--  Create Remarks Modal -->
    <div class="modal fade" id="remarks" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" style="font-size: 15px;">Remarks</p>
                    <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="taskid" id="taskid" value=""/>
                        <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Remarks:</label></div>
                        <div class="col-sm-7 form-group"><textarea class="form-control" id="text_remark"></textarea></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Status:</label></div>
                        <div class="col-sm-7 form-group">
                            <select  class="form-control" id="status" style="font-size: 14px">
                                <?php foreach($taskstatus as $key => $val){ ?>
                                    <option value="<?php echo $key;?>"><?php echo $val; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="remark" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end document-->
