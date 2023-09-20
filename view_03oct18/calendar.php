<?php
include('nav-head.php');
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="col-lg-12" style="padding: 20px;background: #ffffff">
            <div id='calendar'>

            </div>
        </div>
    </div>
</div>
<?php include('nav-foot.php'); ?>
<!--<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            </div>
            <div id="modalBody" class="modal-body">
            </div>
            <a href="" id="eventUrl">Click Here</a>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary"><a id="eventUrl" target="_blank">Event Page</a></button>
            </div>
        </div>
    </div>
</div>-->

<div id="eventContent" title="Event Details" style="display:none;">
    Start: <span id="startTime"></span><br>
     <p id="eventInfo"></p>
    <p><strong><a id="eventLink" href="" target="_blank">Open</a></strong></p>
</div>