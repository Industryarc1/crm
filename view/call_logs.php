<?php
session_start();
ini_set("display_errors",0);
include('nav-head.php');
$salespersons=$functions->getEmployeeByteamId(2);

?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row filters-card">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-5">
                            <label>Select the Name</label>
                          <select class="form-control" id="extension">
                              <option value="" selected disabled>Select name</option>
                              <?php foreach ($salespersons as $row){ ?>
                              <option value="<?php echo $row['extension']; ?>"><?php echo $row['email']; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                        <div class="col-sm-3">
                            <label>From:</label>
                            <div class="input-group controls input-append date task_datetime">
                                <input  type="text" class="form-control date-align" name="date" id="fromdate">
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>To:</label>
                            <div class="input-group controls input-append date task_datetime">
                                <input  type="text" class="form-control date-align" name="date" id="todate">
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <label></label>
                            <button class="btn btn-primary" id="LogSearch">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="getcalllogs">

            </div>
        </div>
    </div>
</div>
<?php
include('nav-foot.php');?>
<script>
    $(document).ready(function() {
        $('#LogSearch').click(function() {
            var extension =$("#extension").val();
            var fromdate = $("#fromdate").val();
            var todate = $("#todate").val();
       /*     console.log(extension);
            console.log(fromdate);
            console.log(todate);*/
            $.ajax({
                type: "GET",
                url: 'view_call_logs.php',
                data: ({extension:extension,fromdate:fromdate,todate: todate}),
                success: function(result){
                    // console.log(result);
                    $("#getcalllogs").html(result);
                }
            });
        });

    });
</script>