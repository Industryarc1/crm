<?php
include('nav-head.php');
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
$countries=$functions->getCountries();
$getmanagers = $accountsfunctions->getSalesManagerAndEmployees();
if($_SESSION['account'] == "" || $_SESSION['account'] == null){
    if($accountFilter == 1){
        $data=array('company_name'=> $_SESSION['acc_filter']['company'],'country'=> $_SESSION['acc_filter']['country'],
            'total_revenue'=> $_SESSION['acc_filter']['revenue'],'main_industry'=> $_SESSION['acc_filter']['industry'],
            'assignedf'=> $_SESSION['acc_filter']['assignedf'],'assignedt'=> $_SESSION['acc_filter']['assignedt'],
            'assign_to'=> $_SESSION['acc_filter']['assign_to']);
        $TotalAccounts = $accountsfunctions->getCountOfSearchDataInAllAccounts($data, $limit);
        $totrecords= $TotalAccounts['total'];
        $total_pages=$TotalAccounts['total_pages'];
        $accounts = $accountsfunctions->getSearchDataInAllAccountsPagination($data, $page, $limit);
    }else{
        $TotalAccounts = $accountsfunctions->getTotalnumofSearchAccounts($limit);
        $totrecords = $TotalAccounts['total'];
        $total_pages = $TotalAccounts['total_pages'];
        $accounts = $accountsfunctions->getAllAccountsPagination($page, $limit);
    }
}else {
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
        $TotalAccounts = $accountsfunctions->getCountOfAllAccountsByValueAndSearchData($data, $value, $limit);
        $totrecords = $TotalAccounts['total'];
        $total_pages = $TotalAccounts['total_pages'];
        $accounts = $accountsfunctions->getAllAccountsByValueAndSearchDataPagination($data, $value, $page, $limit);
    }else{
        $TotalAccounts = $accountsfunctions->getTotalAccountsBySearchValue($value, $limit);
        $totrecords = $TotalAccounts['total'];
        $total_pages = $TotalAccounts['total_pages'];
        $accounts = $accountsfunctions->getAllAccountsBySearchValuePagination($value, $page, $limit);
    }
}
/*$accounts= $accountsfunctions->getAllAccounts();
echo "<pre>";
print_r($accounts);
exit;*/
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row filters-card">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-4" style="padding: 0;">
                            <label class="control-label" for="search" style="margin: 0!important;">Search by CompanyName</label>
                            <div class="input-group" style="width: 300px!important;">
                                <input class="form-control" type="search" id="search_account" placeholder="Search Here" value="<?php echo $_SESSION['account']; ?>"/>
                                <input class="form-control" type="hidden" id="search_page" value="<?php echo $_GET['page'];?>"/>
                                <span class="input-group-addon"><i class="fas fa-search"></i> </span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <?php if($accountFilter == 1){
                                echo "Applied Filters are:";
                                foreach($_SESSION['acc_filter'] as $key=>$value){
                                    echo '<strong>'.$value.'</strong> ';
                                }
                            } ?>
                        </div>
                        <div class="col-sm-2">
                            <div class="hide-buttons">
                                <button class="add-contact" data-toggle="modal" data-target="#mul_assign">AssignTo</button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-danger" id="remove_acc_filter" style="font-size: 12px;padding:7px;margin-top:2px;float:right;" value="1">Remove filter</button>
                            <button class="add_filter" data-toggle="modal" data-target="#accountfilter">Add Filters</button>
                        </div>
                        <div class="col-sm-2">
                            <a href="add_account.php">
                                <button class="add-contact">Add Account
                                <i style="padding-left: 5px;font-size: 10px;" class="fas fa-plus"></i></button></a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12" id="filter-accounts">
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
                        <!-- END DATA TABLE-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('nav-foot.php');?>
    <script type="text/javascript">
        $(document).ready(function() {
            <?php if($accountFilter == 1 || $_SESSION['account'] != ""){?>
            $("#remove_acc_filter").show();
            <?php }else {?>
            $("#remove_acc_filter").hide();
            <?php } ?>
            $('.pagination').pagination({
                items: <?php echo $total_pages*$limit;?>,
                itemsOnPage: <?php echo $limit; ?>,
                cssStyle: 'light-theme',
                currentPage : <?php echo $page;?>,
                hrefTextPrefix : 'accounts.php?page='
            });
            $('.assign_acc').click(function () {
                var accid = $(this).data('id');
               // console.log(accid);
                $(".modal-body #accId").val(accid);
            });

        });
    </script>
<script type="text/javascript" src="js/jquery.simplePagination.js"></script>
<!-- multiple assign to Modal -->
    <div class="modal fade" id="mul_assign" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" style="font-size: 15px">Assign To</p>
                    <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10 form-group">
                            <label for="usr" style="font-size: 12px">Assign to:</label>
                            <select class="select-modal-rows" id="mul_assignedid" style="width: 100%">
                                <?php foreach($getmanagers as $value){ ?>
                                    <option value="<?php echo $value['employee_id'];?>"><?php echo $value['email']." / ".$roles[$value['role_id']]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label></label>
                    <button type="button" class="btn btn-info" id="assign_account" data-dismiss="modal">Assign</button>
                </div>
            </div>
        </div>
    </div>
<!-- end document----------------------------------------------------------------->

<!-- single assign to Modal ---------------------------------------------->
<div class="modal fade" id="assign_to" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" style="font-size: 15px">Assign To</p>
                <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="accId" id="accId" value=""/>
                    <div class="col-sm-10 form-group">
                        <label for="usr" style="font-size: 12px">Assign to:</label>
                        <select class="select-modal-rows" id="assignedid" style="width: 100%">
                            <?php foreach($getmanagers as $value){ ?>
                                <option value="<?php echo $value['employee_id'];?>"><?php echo $value['email']." / ".$roles[$value['role_id']]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label></label>
                <button type="button" class="btn btn-primary" id="single_assign" data-dismiss="modal">Assign</button>
            </div>
        </div>
    </div>
</div>
<!-- end document-->

<!-- Account filter Modal ---------------------------------------------------->
<div class="modal right fade" id="accountfilter" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 300px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 15px;">
                <p class="modal-title" style="font-size: 15px;">Filters</p>
                <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row"style="font-size: 14px;width: 100%;">
                    <label>Filter Accounts by:</label>
                    <input type="hidden" value="1" id="filteraccounts">
                    <input type="text" class="form-control contact-label" placeholder="Select the filter" id="filter">
                    <div style="width: 100%">
                        <select class="form-control contact-label selectfilter" size="5" id="filtervalue">
                           <!-- <option value="1">Company</option>-->
                            <option value="2">Country</option>
                            <option value="3">Industry</option>
                          <!--  <option value="4">Sub Industry</option>-->
                            <option value="5">Select Revenue</option>
                            <option value="6">AssignedTo</option>
                            <option value="7">Assigned Date</option>
                        </select>
                    </div>
                    <div class="row close-input" id="7">
                        <span style="font-size: 10px;width: 100%;">From date</span>
                        <div class="input-group controls input-append date filter_datetime">
                            <input  type="text" class="filter-control-cal date-align" name="filter-control" id="assignedf">
                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            <button type="button" class="filter-close">&times;</button>
                        </div>
                        <span style="font-size: 10px;width: 100%;">To date</span>
                        <div class="input-group controls input-append date filter_datetime">
                            <input  type="text" class="filter-control-cal date-align" name="filter-control" id="assignedt">
                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            <button type="button" class="filter-close">&times;</button>
                        </div>
                    </div>
                    <div class="row close-input" id="1">
                        <span style="font-size: 10px;width: 100%;">Company</span>
                        <input type="text" class="filter-control" placeholder="Type here" name="filter-control" id="company">
                        <button type="button" class="filter-close">&times;</button>
                    </div>
                    <div class="row close-input" id="2">
                        <span style="font-size: 10px;width: 100%;">Country</span>
                        <select class="filter-control" id="country" name="filter-control" value="<?php echo $_SESSION['filter']['country']; ?>">
                            <option value="" selected disabled>Select Country</option>
                            <?php foreach($countries as $country) { ?>
                                <option class="option-display" value="<?php echo $country['country']; ?>">
                                    <?php echo $country['country']; ?></option>
                            <?php }?>
                        </select>
                        <button type="button" class="filter-close">&times;</button>
                    </div>
                    <div class="row close-input" id="3">
                        <span style="font-size: 10px;width: 100%;">Industry</span>
                        <input type="text" class="filter-control" placeholder="Type here" name="filter-control" id="industry">
                        <button type="button" class="filter-close">&times;</button>
                    </div>
                    <div class="row close-input" id="5">
                         <span style="font-size: 10px;width: 100%;">Total Revenue(in $ Million)</span>
                            <div class="col-sm-5" style="padding: 0;">
                                <span style="font-size:9px;">From Million</span>
                                <input type="number" class="filter-control-sm" name="filter-control" id="from_revenue">
                            </div>
                           <div class="col-sm-5">
                                <span style="font-size:9px;">To Million</span>
                                <input type="number" class="filter-control-sm" name="filter-control" id="to_revenue">
                            </div>
                     <!--   <select class="filter-control" id="revenue" name="filter-control">
                            <option value="" selected disabled>Select Range</option>
                            <option class="option-display" value="100 AND 500">$100 to $500 Million</option>
                            <option class="option-display" value="501 AND 1000">$501 to $1000 Million</option>
                            <option class="option-display" value="1001 AND 5000">$1001 to $5000 Million</option>
                            <option class="option-display" value="5001 AND 10000">$5001 to $10000 Million</option>
                            <option class="option-display" value="10001 AND 50000">$10001 to $50000 Million</option>
                            <option class="option-display" value="50001 AND 100000">$50001 to $100000 Million</option>
                            <option class="option-display" value="100001 AND 500000">$100001 to $500000 Million</option>
                        </select>-->
                        <button type="button" class="filter-close" style="margin-top: 20px;">&times;</button>
                    </div>
                    <div class="row close-input" id="6">
                        <span style="font-size: 10px;width: 100%;">AssignedTo</span>
                        <select class="filter-control" id="assign_acc" name="filter-control">
                            <option value="" selected disabled>Select</option>
                            <?php foreach($getmanagers as $value){ ?>
                                <option class="option-display" value="<?php echo $value['employee_id'];?>">
                                    <?php echo $value['email']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="button" class="filter-close">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="height: 70px;">
                <button type="button" class="btn btn-primary btn-search" id="searchaccounts" data-dismiss="modal">Filter</button>
            </div>
        </div>
    </div>
</div>
<!-- end document-->
