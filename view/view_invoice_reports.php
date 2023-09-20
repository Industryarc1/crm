<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$taskstatus = array('0'=>'Pending','1'=>'In-Progress','2'=>'Cant be done','3'=>'Completed');
if(isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
    $_SESSION['invoice_fromdate']=$fromdate;
    $todate = date("Y-m-d",strtotime($_GET['todate']));
    $_SESSION['invoice_todate']=$todate;
    $invoices=$functions->getInvoicebyFromAndToDate($fromdate,$todate);
}
?>
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
                            <button class="btn btn-success" style="font-size: 12px;padding: 5px;" id="openupdateinvoice"
                                    data-toggle="modal" data-target="#updateinvoice" value="<?php echo $invoice['id'];?>">Update</button>
                        <?php }else{
                            echo "Paid";
                        }?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#example').DataTable( {
            // "pageLength": 10,
            dom: 'Bfrtip',
            buttons: ['copy','excel','pdf']
        });
    });
</script>
