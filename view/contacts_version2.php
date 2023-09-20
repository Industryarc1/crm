<?php
	include('nav-head.php');
	include_once('../model/contacts2function.php');
 $contacts2functions = new contacts2functions();
 $getmanagers=$functions->getSalesManager();
	$Countries=$contacts2functions->getDistinctCountries();
	$Industries=$contacts2functions->getDistinctIndustries();
	$Companies=$contacts2functions->getDistinctCompanies();
 //print_r($Companies);exit;
 $limit = 100;
 if (isset($_GET['page']) && $_GET['page']) {
     $page = $_GET['page'];
 } else {
     $page = 1;
 }
 $contacts2Filter = 0;
 foreach($_SESSION['con2_filter'] as $key=>$value){
     if($value!="" || $value!=null){
         $contacts2Filter = 1;
         break;
     }
 }
 if($contacts2Filter == 1){
      $data=array('company_name'=> $_SESSION['con2_filter']['company_name'],'category'=> $_SESSION['con2_filter']['category'],
      'industry'=> $_SESSION['con2_filter']['industry'],'managementlevel'=> $_SESSION['con2_filter']['managementlevel'],
      'country'=>$_SESSION['con2_filter']['country'],'contacttype'=>$_SESSION['con2_filter']['contacttype']);
      $TotalContacts = $contacts2functions->getCountOfSearchDataInAllContacts2($data, $limit);
      $totrecords= $TotalContacts['total'];
      $total_pages=$TotalContacts['total_pages'];
      $contactsList = $contacts2functions->getSearchDataInAllContacts2Pagination($data, $page, $limit);
 }else{
     $TotalContacts = $contacts2functions->getTotalnumofSearchContacts2($limit);
     $totrecords = $TotalContacts['total'];
     $total_pages = $TotalContacts['total_pages'];
     $contactsList = $contacts2functions->getAllContacts2Pagination($page, $limit);
 }
 //	echo "<pre>";
 //	print_r($contactsList);
 //	exit();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
  <style>
  .dropdown-menu.show{
      overflow-y: scroll!important;
      height: 200px!important;
  }
  .multiselect-container>li>a>label{
    height:0!important;
  }
  </style>
   <!-- MAIN CONTENT-->
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row filters-card">
                <div class="col-lg-12">
                <div class="row">
                     <div class="col-sm-10"><strong>Apply Filters</strong></div>
                     <div class="col-sm-1">
                      <button class="btn btn-danger" type="button" id="remove_contacts2" style="font-size: 12px;padding: 5px 8px;margin-bottom:5px;">Remove</button>
                     </div>
                     <div class="col-sm-1">
                     <?php if($_SESSION['role_id']== 1 || $_SESSION['team_id']== 2){?>
                         <div class="hide-buttons">
                         <button class="btn btn-primary" style="font-size: 12px;" data-toggle="modal" data-target="#multi_assign">Assign</button>
                        </div>
                    <?php }?>
                    </div>
                 </div>
                  <div class="row">
                        <input type="hidden" value="1" id="filtercontacts2">
                       <input class="form-control" type="hidden"  id="category_s" value="<?php echo $_SESSION['con2_filter']['category'];?>"/>
                       <input class="form-control" type="hidden"  id="level_s" value="<?php echo $_SESSION['con2_filter']['managementlevel'];?>"/>
                        <input class="form-control" type="hidden" id="country_s" value="<?php echo $_SESSION['con2_filter']['country'];?>"/>
                        <input class="form-control" type="hidden" id="industry_s" value="<?php echo $_SESSION['con2_filter']['industry'];?>"/>
                       <input class="form-control" type="hidden"  id="company_name_s" value="<?php echo $_SESSION['con2_filter']['company_name'];?>"/>
                       <div class="col-sm-3">
                           <label class="control-label" for="search" style="margin: 0!important;">ContactType</label>
                            <select class="form-control" id="contacttype">
                            <?php if($_SESSION['con2_filter']['contacttype'] != ""){ ?>
                            <option value="0" <?php if($_SESSION['con2_filter']['contacttype'] == "0"){?>selected="selected"<?php } ?>>ALL</option>
                            <option value="1" <?php if($_SESSION['con2_filter']['contacttype'] == "1"){?>selected="selected"<?php } ?>>Assigned</option>
                            <option value="2" <?php if($_SESSION['con2_filter']['contacttype'] == "2"){?>selected="selected"<?php } ?>>NotAssigned</option>
                            <option value="3" <?php if($_SESSION['con2_filter']['contacttype'] == "3"){?>selected="selected"<?php } ?>>Outbound</option>
                            <option value="4" <?php if($_SESSION['con2_filter']['contacttype'] == "4"){?>selected="selected"<?php } ?>>Rejected</option>
                            <?php }else{ ?>
                              <option value="0">ALL</option>
                              <option value="1">Assigned</option>
                              <option value="2" selected>NotAssigned</option>
                              <option value="3">Outbound</option>
                              <option value="4">Rejected</option>
                            <?php }?>
                            </select>
                       </div>
                       <div class="col-sm-3">
                           <label class="control-label" for="search" style="margin: 0!important;">JobTitle</label>
                           <select class="form-control" name ="category[]" id="category" multiple="multiple">
                           <option value="Sales" <?php if($_SESSION['con2_filter']['category'] == "Sales"){?>selected="selected"<?php } ?>>Sales</option>
                           <option value="Business" <?php if($_SESSION['con2_filter']['category'] == "Business"){?>selected="selected"<?php } ?>>Business</option>
                           <option value="Director" <?php if($_SESSION['con2_filter']['category'] == "Director"){?>selected="selected"<?php } ?>>Director</option>
                           <option value="Marketting" <?php if($_SESSION['con2_filter']['category'] == "Marketting"){?>selected="selected"<?php } ?>>Marketting</option>
                           <option value="Marketting Intelligent" <?php if($_SESSION['con2_filter']['category'] == "Marketting Intelligent"){?>selected="selected"<?php } ?>>Marketting Intelligent</option>
                           </select>
                        </div>
                         <div class="col-sm-3">
                            <label class="control-label" for="search" style="margin: 0!important;">Levels</label>
                            <select class="form-control" name ="level[]" id="level" multiple="multiple">
                             <option value="C-Level" <?php if($_SESSION['con2_filter']['managementlevel'] == "C-Level"){?>selected="selected"<?php } ?>>C-Level</option>
                             <option value="VP-Level" <?php if($_SESSION['con2_filter']['managementlevel'] == "VP-Level"){?>selected="selected"<?php } ?>>VP-Level</option>
                             <option value="Director" <?php if($_SESSION['con2_filter']['managementlevel'] == "Director"){?>selected="selected"<?php } ?>>Director</option>
                             <option value="Manager" <?php if($_SESSION['con2_filter']['managementlevel'] == "Manager"){?>selected="selected"<?php } ?>>Manager</option>
                             <option value="Non-Manager" <?php if($_SESSION['con2_filter']['managementlevel'] == "Non-Manager"){?>selected="selected"<?php } ?>>Non-Manager</option>
                             </select>
                         </div>
                         <div class="col-sm-3">
                            <label class="control-label" for="search" style="margin: 0!important;">Country</label>
                            <select class="form-control" name ="country[]" id="country" multiple="multiple">
                            <?php foreach($Countries as $country) { ?>
                            <option value="<?php echo $country['country']; ?>" <?php if($_SESSION['con2_filter']['country'] == $country['country']){?>selected="selected"<?php } ?>> <?php echo $country['country']; ?></option>
                            <?php }?>
                            </select>
                         </div>
                   </div>
                    <div class="row">
                       <div class="col-sm-5">
                          <label class="control-label" for="search" style="margin: 0!important;">CompanyName</label>
                          <select class="form-control" id="company" name ="company[]" multiple="multiple">
                          <?php foreach($Companies as $row) { ?>
                          <option value="<?php echo $row['company_name']; ?>" <?php if($_SESSION['con2_filter']['company_name'] == $row['company_name']){?>selected="selected"<?php } ?>> <?php echo $row['company_name']; ?></option>
                          <?php }?>
                         </select>
                       </div>
                       <div class="col-sm-5">
                           <label class="control-label" for="search" style="margin: 0!important;">Industry</label>
                           <select class="form-control" id="industry" name ="industry[]" multiple="multiple">
                           <?php foreach($Industries as $row) { ?>
                           <option value="<?php echo $row['industry']; ?>" <?php if($_SESSION['con2_filter']['industry'] == $row['industry']){?>selected="selected"<?php } ?>> <?php echo $row['industry']; ?></option>
                           <?php }?>
                           </select>
                       </div>
                       <div class="col-sm-1"></div>
                       <div class="col-sm-1">
                          <label></label>
                           <button class="btn btn-primary" type="button" id="filter_contacts2" style="font-size: 12px; margin-top: 22px;">Search</button>
                        </div>
                    </div>
                 </div>
            </div>
            <!-- row end--->
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12" id="filter-contacts" style="padding:0!important">
                    <!-- DATA TABLE-->
                    <div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
                        <table class="div2 table table-borderless table-data4 table-scroll-child">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all" value="0"/>CheckAll</th>
                                <th>FullName</th>
                                <th>Category</th>
                                <th>Levels</th>
                                <th>Industry</th>
                                <th>Company</th>
                                <th>Company Number</th>
                                <th>Website</th>
                                <th>Country</th>
                                <th>Title</th>
                                <th>TotalRevenue</th>
                                <th>EmployeeSize</th>
                                <th>Assigned</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($contactsList as $row){ ?>
                                   <tr>
                                   <td>
                                     <input type="checkbox" class="checklead" value="<?php echo $row['id']?>"/>
                                    </td>
                                    <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['managementlevel']; ?></td>
                                    <td><?php echo $row['industry']; ?></td>
                                    <td><?php echo $row['company_name']; ?></td>
                                    <td><?php echo $row['company_phone']; ?></td>
                                    <td><?php echo $row['company_domain']; ?></td>
                                    <td><?php echo $row['country']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['company_revenue']; ?></td>
                                    <td><?php echo $row['company_employees']; ?></td>
                                    <td><?php if($row['assign_to'] == 0){
                                      echo "<strong>Not Assigned</strong>";
                                     }else{
                                     $associatedname=$functions->getEmployeeByEmpId($row['assign_to']);
                                      echo $associatedname['firstname'].' '.$associatedname['lastname'];
                                     }?></td>
                                  </tr>
                                  <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                    <div class="row">
                        <div class="col-sm-10">
                            <?php
                              $i=1;
                               $pagLink = "<nav><ul class='pagination light-theme simple-pagination'>
                                   <li><a href='contacts_version2.php?page= ".$i."'>Prev</a></li>
                                   <li><a href='contacts_version2.php?page=".$total_pages."'>Next</a></li>";
                                 echo $pagLink . "</ul></nav></div>";
                               echo "<div class='col-sm-2'><p style='float:right'>Records:
                             <strong>". $totrecords ."</strong></p></div>";
                            ?>
                        </div>
                    </div>
                  <!------------------- END DATA TABLE-->
                 </div>
              </div>
         </div>
     </div>
</div>
<?php include('nav-foot.php');?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
      <?php if($contacts2Filter == 1){?>
      $("#remove_contacts2").show();
      <?php }else {?>
      $("#remove_contacts2").hide();
      <?php } ?>
      $('.pagination').pagination({
            items: <?php echo $total_pages*$limit;?>,
            itemsOnPage: <?php echo $limit; ?>,
            cssStyle: 'light-theme',
            currentPage : <?php echo $page;?>,
            hrefTextPrefix : 'contacts_version2.php?page='
      });
     $('#category').multiselect({
          nonSelectedText:'---Select---',
          buttonWidth: '100%',
          enableHTML: true,
          buttonClass: 'btn btn-default-btn',
     });
     $('#level').multiselect({
         nonSelectedText:'---Select---',
         buttonWidth: '100%',
         enableHTML: true,
         buttonClass: 'btn btn-default-btn',
      });
      $('#country').multiselect({
          nonSelectedText:'---Select---',
          buttonWidth: '100%',
          enableHTML: true,
          buttonClass: 'btn btn-default-btn',
      });
      $('#industry').multiselect({
          nonSelectedText:'---Select---',
          buttonWidth: '100%',
          enableHTML: true,
          buttonClass: 'btn btn-default-btn',
      });
      $('#company').multiselect({
          nonSelectedText:'---Select---',
          buttonWidth: '100%',
          enableHTML: true,
          buttonClass: 'btn btn-default-btn',
      });
// store session values in multiselect dropdown -----------------------
    var data1= $("#category_s").val();
    var res1 = data1.replace(/'/g, "");
    var dataarray1 = res1.split(",");
    $("#category").val(dataarray1);
    $("#category").multiselect("refresh");

        var data2= $("#level_s").val();
        var res2 = data2.replace(/'/g, "");
        var dataarray2 = res2.split(",");
        $("#level").val(dataarray2);
        $("#level").multiselect("refresh");

            var data3= $("#country_s").val();
            var res3 = data3.replace(/'/g, "");
            var dataarray3 = res3.split(",");
            $("#country").val(dataarray3);
            $("#country").multiselect("refresh");

                var data4= $("#industry_s").val();
                var res4 = data4.replace(/'/g, "");
                var dataarray4 = res4.split(",");
                $("#industry").val(dataarray4);
                $("#industry").multiselect("refresh");

                    var data5= $("#company_name_s").val();
                    var res5 = data5.replace(/'/g, "");
                    var dataarray5 = res5.split(",");
                    $("#company").val(dataarray5);
                    $("#company").multiselect("refresh");
// --store session values in multiselect dropdown END -----------------------
      $("#filter_contacts2").click(function () {
          var filtercontacts2=$("#filtercontacts2").val();
          var page = $("#search_page").val();
          var company=$("#company").val();
          var category=$("#category").val();
          var country = $('#country').val();
          var level=$("#level").val();
          var industry=$("#industry").val();
           var contacttype=$("#contacttype").val();
          //console.log(category);
          //console.log(level);
          //console.log(country);
          //console.log(company);
           console.log(contacttype);
          $.ajax({
                type: "POST",
                url: 'ajax/ajax_allcontacts2.php',
                data: ({filtercontacts2:filtercontacts2,page:page,company:company,country:country,industry:industry,level:level,category:category,
                contacttype:contacttype}),
                   success: function(result){
                    //console.log(result);
                    $("#remove_contacts2").show();
                   $("#filter-contacts").html(result);
                }
            });
       });
      $('#remove_contacts2').click(function() {
          var removeFilter = "filterunset";
          var val =$(this).val();
          $.ajax({
              type: "POST",
              url: 'ajax.php',
              data: ({removeFilter:removeFilter}),
              success: function(result){
                 // console.log(result);
                 window.location.href = "contacts_version2.php";
              }
          });
     });
     $("#assign_contacts2").click(function(){
     if(confirm("Are you sure to assign these contacts?")) {
         var assign_val = [];
         $('.checklead:checkbox:checked').each(function(i){
          assign_val[i] = $(this).val();
         });
         var assignto=$("#assign_to").val();
         console.log(assign_val);
        // console.log(assignto);
         $.ajax({
            type: "POST",
            url: 'ajax/contacts2_ajax.php',
            data: ({assignvalues: assign_val,assignto:assignto}),
            success: function(result){
                console.log(result);
                alert("Assigned Successfully!!");
                window.location.reload();
            }
         });
     		}else{
     		return false;
     		}
     });
});
</script>
<script type="text/javascript" src="js/jquery.simplePagination.js"></script>
	<!--Multiple associate assign to Modal -->
			<div class="modal fade" id="multi_assign" role="dialog">
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
									<select class="select-modal-rows" id="assign_to" style="width: 100%">
										<?php foreach($getmanagers as $value){ ?>
											<option value="<?php echo $value['employee_id'];?>"><?php echo $value['email']." / ".$roles[$value['role_id']]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<label></label>
							<button type="button" class="btn btn-info" id="assign_contacts2" data-dismiss="modal">Assign</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end document----------------------------------------------------------------->
