<?php
session_start();
 include ('../config.php');
include_once('../model/function.php');
$functions = new functions();
$leadid = $_GET['lead_id'];
if($_GET['active'] == 'activity'){
    $notesActive = "";
    $activityHis = "in active";
    $note="";
    $activity="active";
}else{
    $notesActive = "in active";
    $activityHis = "";
    $note="active";
    $activity="";
}
$notes=$functions->getNotesbyLeadId($leadid);
$valueupdates=$functions->getUpdatedvaluesbyleadId($leadid);
$callLogs = $functions->getCallLogsByLeadId($leadid);
?>
<ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#notes" class="historymenu <?php echo $note;?>">Notes</a></li>
    <li><a data-toggle="tab" href="#activity" class="historymenu <?php echo $activity;?>">Activity</a></li>
    <li><a data-toggle="tab" href="#calllog" class="historymenu">Call Logs</a></li>
</ul>

<!-- ---------------text editor-------------------------- -->
<div class="col-sm-10 tab-content" style="margin-top: 10px;">
<div id="notes" class="tab-pane fade <?php echo $notesActive; ?>">
    <?php foreach($notes as $note){
        $updatednotename=$functions->getEmployeeByEmpId($note['updated_by_id']);
        ?>
        <div class="comments-section">
            <?php  echo $note['note'];?>  By  <strong><?php  echo $updatednotename['firstname'];?></strong>
            <p class="created-date"><?php echo $note['created'];?></p>
        </div>
    <?php } ?>
</div>
<div id="activity" class="tab-pane fade <?php echo $activityHis; ?>">
    <!--   <strong>Updates</strong>-->
    <?php foreach($valueupdates as $update){
        $updatedname=$functions->getEmployeeByEmpId($update['updated_by']);
        $newValue = ($update['updated_field'] == 'lead_stage_id' ? $leadStages[$update['new_value']] : $update['new_value']);
        $oldValue = ($update['updated_field'] == 'lead_stage_id' ? $leadStages[$update['old_value']] : $update['old_value']);
        ?>
        <div class="comments-section">
            <p><strong><?php echo $leadCloumns[$update['updated_field']];?></strong> Updated as
                <?php echo $newValue;?> From <?php  echo $oldValue;?>
                By  <strong><?php  echo $updatedname['firstname'];?></strong> On
                <?php  echo $update['activity_time'];?>  </p>
        </div>
    <?php } ?>
</div>
    <div id="calllog" class="tab-pane fade">
        <?php foreach($callLogs as $calllog){?>
            <div class="comments-section">
                <!--Call Recording : <a href="<?php echo $calllog['recording'];?>" target="_blank"><?php echo $calllog['recording'];?></a>-->
                <p><?php echo $calllog['contact'];?></p>
                <audio controls>
                    <source src='<?php echo $calllog['recording'];?>' type='audio/wav'>
                    <source src='<?php echo $calllog['recording'].".mp3"; ?>' type='audio/mpeg'>
                    Your browser does not support the audio tag.
                </audio>
                <p class="created-date"><?php echo $calllog['created'];?></p>
            </div>
        <?php } ?>
    </div>
</div>