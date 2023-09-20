<?php
include('nav-head.php');
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid" style="margin:50px;">
            <div style="margin-bottom: 10px;font-size:25px;">Generate Report Sample Pdf:</div>
             <div class="row">
                <div class="col-lg-8 filters-card" style="padding:10px;">
                       <div class="form-group">
                         <strong>Report Ids:(Multiple)</strong>
                        <input type="text" class="form-control" name="reportids" id="reportids">
                        </div>
                        <button class="btn btn-primary" id="generate">Generate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('nav-foot.php');?>
<script>
    $(document).ready(function() {
        $('#generate').click(function() {
            var reportid = $("#reportids").val();
            window.open("dompdf.php?reportid="+reportid, '_blank');
           // window.location.href= "dompdf.php?reportid="+reportid;
        });

    });
</script>
