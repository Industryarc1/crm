<?php
include('nav-head.php');
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
if($_SESSION['invoice_fromdate'] != "" && $_SESSION['invoice_todate'] != "") {
    $fromdate= $_SESSION['invoice_fromdate'];
    $todate = $_SESSION['invoice_todate'];
    $invoices=$functions->getInvoicebyFromAndToDate($fromdate,$todate);
}else{
    $invoices = $functions->getAllInvoices();
}
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <h4 style="margin-bottom: 10px;">Filter Invoice Reports:</h4>
            <div class="row filters-card">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-1">
                            <label>From:</label>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group controls input-append date task_datetime">
                                <input  type="text" class="form-control date-align" name="date" id="fromdate" value="<?php echo $_SESSION['invoice_fromdate'];?>">
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <label>To:</label>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group controls input-append date task_datetime">
                                <input  type="text" class="form-control date-align" name="date" id="todate" value="<?php echo $_SESSION['invoice_todate'];?>">
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary" id="reportSearch">Search</button>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <?php if($_SESSION['invoice_fromdate'] != ""){ ?>
                            <button class="btn btn-primary" id="remove_invoicefilter">Remove Filter</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="getreports">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-12" style="padding: 0;">
                        <table class="table table-responsivetable-borderless table-report" id="example">
                            <thead>
                            <tr>
                                <th>Lead</th>
                                <th>Invoice No.</th>
                                <th>Purchase Order</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Amount</th>
                                <th>Paid amount</th>
                                <th>Created By</th>
                                <th>Created</th>
                                <th>Update</th>
                            </tr>
                            </thead>
                            <?php foreach($invoices as $invoice){?>
                                <tr>
                                    <td><strong><?php $lead=$functions->getleadbyId($invoice['lead_id']);
                                            echo $lead['fname']." ".$lead['lname'];?></strong></td>
                                    <td><a href="invoice.php?invnum=<?php echo base64_encode($invoice['id']);?>"
                                           target="_blank"><?php echo $invoice['invoice_num'];?></a></td>
                                    <td><?php echo $invoice['purchase_order'];?></td>
                                    <td><?php echo $invoice['name']?></td>
                                    <td><?php echo $invoice['address']?></td>
                                    <td><?php echo $invoice['amount']?></td>
                                    <td><?php echo $invoice['paid_amount']?></td>
                                    <td><?php $emp=$functions->getEmployeeByEmpId($invoice['created_by']);
                                        echo $emp['firstname']." ".$emp['lastname'];?></td>
                                    <td><?php echo $invoice['created']?></td>
                                    <td>
                                        <?php if($invoice['amount'] != $invoice['paid_amount']) {?>
                                            <button class="btn btn-success openupdateinvoice" style="font-size: 12px;padding: 5px;"
                                                    data-toggle="modal" value="<?php echo $invoice['id'];?>">Update</button>
                                        <?php }else{
                                            echo "Paid";
                                        }?>

                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
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
        $('#example').DataTable( {
            // "pageLength": 10,
            dom: 'Bfrtip',
            buttons: ['copy','excel','pdf']
        });
        $('#reportSearch').click(function() {
            var fromdate = $("#fromdate").val();
            var todate = $("#todate").val();
            $.ajax({
                type: "GET",
                url: 'view_invoice_reports.php',
                data: ({fromdate:fromdate,todate: todate}),
                success: function(result){
                    // console.log(result);
                    $("#getreports").html(result);
                }
            });
        });

    });
</script>
<!-- update Invoice Modal -->
<div class="modal fade" id="updateinvoice" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" style="font-size: 15px;">Update Invoice</p>
                <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="invoiceid" id="invoiceid" value=""/>
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Paid Amount:</label></div>
                    <div class="col-sm-7 form-group"><input type="number" class="form-control" id="update_paidamount"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Transaction Id:</label></div>
                    <div class="col-sm-7 form-group"><input type="text" class="form-control" id="transaction_id"></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Payment:</label></div>
                    <div class="col-sm-7 form-group">
                        <select  class="form-control" id="paytype" style="font-size: 14px">
                            <option value="" selected hidden>Select Payment Type</option>
                            <option value="Bank Deposit">Bank Deposit</option>
                            <option value="Paypal">Paypal</option>
                            <option value="CCavenue">CCavenue</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Remarks:</label></div>
                    <div class="col-sm-7 form-group"><input type="text" class="form-control" id="remarks"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" style="font-size: 12px;padding: 5px;"
                        id="update_invoice" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- end document-->