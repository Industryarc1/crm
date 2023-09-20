<?php
include('nav-head.php');
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <h4 style="margin-bottom: 10px;">Filter Lead Reports:</h4>
            <div class="row filters-card">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-1">
                            <label>From:</label>
                        </div>
                       <div class="col-sm-3">
                           <div class="input-group controls input-append date task_datetime">
                               <input  type="text" class="form-control date-align" name="date" id="fromdate">
                               <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                           </div>
                       </div>
                        <div class="col-sm-1">
                            <label>To:</label>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group controls input-append date task_datetime">
                                <input  type="text" class="form-control date-align" name="date" id="todate">
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary" id="reportSearch">Search</button>
                        </div>
                        </div>
                </div>
          </div>
            <div id="getreports">

            </div>

        </div>
    </div>
</div>
<?php
include('nav-foot.php');?>
<script>
    $(document).ready(function() {
        $('#reportSearch').click(function() {
            var fromdate = $("#fromdate").val();
            var todate = $("#todate").val();
            $.ajax({
                type: "GET",
                url: 'view_lead_reports.php',
                data: ({fromdate:fromdate,todate: todate}),
                success: function(result){
                   // console.log(result);
                    $("#getreports").html(result);
                }
            });
        });

    });
</script>
