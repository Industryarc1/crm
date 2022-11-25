<?php
session_start();
include('../config.php');
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
include_once('../model/accountsfunction.php');
$accountsfunctions= new accountsfunctions();
$accounts = array();
$limit = 10;
if (isset($_GET['page']) && $_GET['page']) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$accountFilter = 0;
foreach($_SESSION['acc_filter'] as $key=>$value){
    if($value!="" || $value!=null){
        $accountFilter = 1;
        break;
    }
}
if(isset($_POST['value']) && $_POST['value']!="") {
        $_SESSION['account'] = $_POST['value'];
        $value = $_SESSION['account'];
       if($accountFilter == 1) {
           $data = array('company' => $_SESSION['acc_filter']['company'],
               'country' => $_SESSION['acc_filter']['country'],
               'from_revenue' => $_SESSION['acc_filter']['from_revenue'],
               'to_revenue' => $_SESSION['acc_filter']['to_revenue'],
               'main_industry' => $_SESSION['acc_filter']['industry'],
               'assignedf' => $_SESSION['acc_filter']['assignedf'],
               'assignedt' => $_SESSION['acc_filter']['assignedt'],
               'assign_to' => $_SESSION['acc_filter']['assign_to']);
         $TotalAccounts=$accountsfunctions->getCountOfAllAccountsByValueAndSearchData($data,$value,$limit);
         $totrecords= $TotalAccounts['total'];
         $total_pages=$TotalAccounts['total_pages'];
         $accounts=$accountsfunctions->getAllAccountsByValueAndSearchDataPagination($data,$value,$page,$limit);
       }else{
            $TotalAccounts = $accountsfunctions->getTotalAccountsBySearchValue($value, $limit);
            $totrecords = $TotalAccounts['total'];
            $total_pages = $TotalAccounts['total_pages'];
            $accounts = $accountsfunctions->getAllAccountsBySearchValuePagination($value, $page, $limit);
       }
}
if(isset($_POST['filteraccounts']) && $_POST['filteraccounts']!=""){
    $company=$_POST['company'];
    $country=$_POST['country'];
    $industry=$_POST['industry'];
    $from_revenue=$_POST['from_revenue'];
    $to_revenue=$_POST['to_revenue'];
    $assignedf = $_POST['assignedf'];
    $assignedt = $_POST['assignedt'];
    $assign_to =$_POST['assign_to'];
    $_SESSION['acc_filter']['company']=$company;
    $_SESSION['acc_filter']['country']=$country;
    $_SESSION['acc_filter']['industry']=$industry;
    $_SESSION['acc_filter']['from_revenue']=$from_revenue;
    $_SESSION['acc_filter']['to_revenue']=$to_revenue;
    $_SESSION['acc_filter']['assignedf']=$assignedf;
    $_SESSION['acc_filter']['assignedt']=$assignedt;
    $_SESSION['acc_filter']['assign_to']=$assign_to;
    $data=array('company_name'=>$company,'country'=>$country,'from_revenue'=>$from_revenue,'to_revenue'=>$to_revenue,
        'main_industry'=>$industry,'assignedf'=>$assignedf,'assignedt'=>$assignedt,'assign_to'=>$assign_to);
    if($_SESSION['account']== "" || $_SESSION['account'] == null) {
        $TotalAccounts = $accountsfunctions->getCountOfSearchDataInAllAccounts($data, $limit);
        $totrecords= $TotalAccounts['total'];
        $total_pages=$TotalAccounts['total_pages'];
        $accounts = $accountsfunctions->getSearchDataInAllAccountsPagination($data, $page, $limit);
    }else{
        $value = $_SESSION['account'];
        $TotalAccounts=$accountsfunctions->getCountOfAllAccountsByValueAndSearchData($data,$value,$limit);
        $totrecords= $TotalAccounts['total'];
        $total_pages=$TotalAccounts['total_pages'];
        $accounts=$accountsfunctions->getAllAccountsByValueAndSearchDataPagination($data,$value,$page,$limit);
    }
}
/*echo "<pre>";
print_r($TotalAccounts);
exit;*/
?>
<!-- DATA TABLE-->
<div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
    <table class="div2 table table-borderless table-data4 table-scroll-child">
        <thead>
        <tr>
            <th>Select All <input type="checkbox" id="check_all"/></th>
            <th>Company Name</th>
            <th>Assign To</th>
            <th>Employee Size</th>
            <th>Country</th>
            <th>Industry</th>
            <th>Total Revenue($ Million)</th>
            <th>Website</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($accounts as $row){?>
            <tr>
                <td style="padding-left: 50px;!important;">
                    <input type="checkbox" name="account_ids" class="checklead" value="<?php echo $row['id']?>"/>
                </td>
                <td><?php
                    $string = preg_replace('/[^A-Za-z0-9 \-]/', '', $row['company_name']); ?>
                    <a target="_blank" href="view_account_deatils.php?acc_id=<?php echo base64_encode($row['id']);?>">
                        <?php echo $string; ?></a>
                </td>
                <td>
                    <?php if($row['assign_to']== 0){?>
                        <button class="btn assign-btn assign_acc" data-toggle="modal" data-id="<?php echo $row['id'];?>"
                                data-target="#assign_to">Assign</button>
                    <?php }else{
                        $associatedname=$functions->getEmployeeByEmpId($row['assign_to']);
                        echo $associatedname['firstname'].' '.$associatedname['lastname'];?>
                        <button class="reassign-btn assign_acc" data-toggle="modal" data-id="<?php echo $row['id'];?>"
                                data-target="#assign_to">
                            <img src="images/icon/reassign.jpg"></button>
                    <?php  }
                    ?>
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
<div class="row">
    <div class="col-sm-10">
        <?php
        $i=1;
        $pagLink = "<nav><ul class='pagination light-theme simple-pagination'>
                                   <li><a href='accounts.php?page= ".$i."'>Prev</a></li>
                                   <li><a href='accounts.php?page=".$total_pages."'>Next</a></li>";
        echo $pagLink . "</ul></nav></div>";
        echo "<div class='col-sm-2'><p style='float:right'>Records:
                            <strong>". $totrecords ."</strong></p></div>";
        ?>
    </div>
</div>
    <!-- END DATA TABLE-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.pagination').pagination({
                items: <?php echo $total_pages*$limit;?>,
                itemsOnPage: <?php echo $limit; ?>,
                cssStyle: 'light-theme',
                currentPage : <?php echo $page;?>,
                hrefTextPrefix : 'accounts.php?page='
            });
            $('.assign_acc').click(function () {
                var accid = $(this).data('id');
                 console.log(accid);
                $(".modal-body #accId").val(accid);
            });
            $("#check_all").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
                if($(':checkbox:checked').length > 0){
                    $(".hide-buttons").show();
                }else{
                    $(".hide-buttons").hide();
                }
            });
        });
    </script>
<script type="text/javascript" src="js/jquery.simplePagination.js"></script>