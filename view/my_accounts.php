<?php
include('nav-head.php');
$my_accounts=$accountsfunctions->getassignedAccounts();
//print_r($my_accounts);exit;
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row filters-card">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-10" style="margin-top:10px;"><h4>Assigned Accounts are:</h4></div>
                        <div class="col-md-2" style="float:right"><a href="add_account.php">
                         <button class="add-contact">Add Account<i style="padding-left: 5px;font-size: 10px;" class="fas fa-plus"></i></button></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-12">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">

                    <table class="table table-borderless table-data4"  id="example">
                        <thead>
                        <tr>
                            <th>Company </th>
                            <th>Employee size</th>
                            <th>Country</th>
                            <th>Industry</th>
                            <th>Total revenue</th>
                            <th>Website</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($my_accounts as $row){?>
                            <tr>
                                <td><?php
                                    $string = preg_replace('/[^A-Za-z0-9 \-]/', '', $row['company_name']); ?>
                                    <a target="_blank" href="view_account_deatils.php?acc_id=<?php echo base64_encode($row['id']);?>">
                                        <?php echo $string; ?></a>
                                </td>
                                <td><?php echo $row['employee_size']?></td>
                                <td><?php echo $row['country']?></td>
                                <td><?php echo $row['main_industry']?></td>
                                <td><?php echo $row['total_revenue']?></td>
                                <td><?php echo $row['website']?></td>
                            </tr>
                            <?php
                        }?>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->
            </div>
        </div>
    </div>
</div>
<?php include('nav-foot.php');?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            "pageLength": 10
        });
    });
    </script>

