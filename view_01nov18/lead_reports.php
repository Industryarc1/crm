<?php
include('nav-head.php');
?>
<link type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
<link type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css" rel="stylesheet">
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
<!--pagination-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<!-- buttons display-->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<!-- excel-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<!-- pdf-->
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<!-- print-->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
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