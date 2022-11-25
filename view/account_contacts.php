<?php
	include('nav-head.php');
	//$contactsList = $accountsfunctions->getallAccountContacts();
	//echo "<pre>";
	//print_r($contactsList);
	//exit();
?>
<script>

</script>
<!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content">
                    <div class="container-fluid">
                     <h2 style="text-align:center;">All Contacts</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data4" id="contacttable">
                                        <thead>
                                            <tr>
                                                <th>FirstName</th>
                                                <th>LastName</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Company</th>
                                                <th>Designation</th>
                                                <th>TotalRevenue</th>
                                                <th>EmployeeSize</th>
                                                <th>Country</th>
                                                <th>Url</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                        <?php include('nav-foot.php'); ?>
                    </div>
                </div>
            </div>
<script>
$(document).ready(function() {
    refreshTable();
});
function refreshTable(){
var table= $('#contacttable').DataTable({
    //dom: 'Bfrtip',
    "columnDefs": [
    {"className": "dt-center", "targets": "_all"}
    ],
    //destroy: true,
    "pageLength" : 10,
    "ordering": false,
    //"order": [[ 0, 'desc' ]],
    "order": [[ 0, 'asc' ]],
    "filter": true,
    "searching": true,
    "scrollX": true,
    //"bLengthChange": false,
    "columns": [
    { "data" : "f_name"},
    { "data" : "l_name"},
    { "data" : "email"},
    { "data" : "phone_two"},
    { "data" : "company"},
    { "data" : "designation"},
    { "data" : "total_revenue"},
    { "data" : "employee_size"},
    { "data" : "country"},
    { "data" : "url"}
    ],
    "processing": true,
    "serverSide": true,
        "ajax": {
         url : "ajax/ajax_contacts_data.php",
         type : 'POST'
        }
    });
}
</script>
