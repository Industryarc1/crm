<?php
include('nav-head.php');
error_reporting(0);
include_once('../model/zohofunction.php');
$zohofunctions = new zohofunctions();
$viewallinvoices=$zohofunctions->getAllContactDetails();
/*echo "<pre>";
print_r($viewallinvoices);exit;*/
?>

<!-- MAIN CONTENT-->
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>View Invoices</strong>
                            </div>
                        </div>
                    <table class="table table-responsivetable-borderless table-report" id="example">
                        <thead>
                        <tr>
                            <th>Contact Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Invoice Id</th>
                            <th>Invoice date</th>
                            <th>Due Date</th>
                            <th>Purchase Order</th>
                            <th>Item Name</th>
                            <th>Item Price</th>
                        </tr>
                        </thead>
                        <?php foreach($viewallinvoices as $row){?>
                            <tr>
                                <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                                <td><?php echo  $row['email'];?></td>
                                <td><?php echo  $row['phone'];?></td>
                                <td><?php echo  $row['invoice_id'];?></td>
                                <td><?php echo  $row['invoice_date'];?></td>
                                <td><?php echo  $row['due_date'];?></td>
                                <td><?php echo  $row['purchage_order'];?></td>
                                <td><?php echo  $row['name'];?></td>
                                <td><?php echo  $row['price'];?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <?php include('footer-right.php'); ?>
            </div>
        </div>
</div>
<?php include('nav-foot.php'); ?>
<script>
    $( document ).ready(function() {
        $('#example').DataTable( {
            //  "pageLength": 3,
            //"scrollY": 400,
            "ordering": false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print']
        });
    });
</script>
