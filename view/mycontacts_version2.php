<?php
	include('nav-head.php');
	include_once('../model/contacts2function.php');
$contacts2functions = new contacts2functions();
$Countries=$contacts2functions->getDistinctCountries();
$Industries=$contacts2functions->getDistinctIndustries();
$Companies=$contacts2functions->getDistinctCompanies();
 $empId=$_SESSION['employee_id'];
  //$empId= 5;
	$Myconlists= $contacts2functions->getEmpContactsVersion2ByEmpId($empId);
	//echo "<pre>";
//	print_r($MyconTwo);
//	exit();
?>
<!-- MAIN CONTENT-->
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
           <h4 style="margin-bottom: 10px;text-align:center;">Assigned Contacts 2.0</h4>
            <div class="row filters-card" style="margin: 10px 0;">
               <div class="col-lg-12">
                   <div class="row">
                       <div class="col-sm-3">
                         <label class="control-label" for="search" style="margin: 0!important;">JobTitle</label>
                          <select class="form-control" name ="category" id="category">
                          <option value="" selected disabled>Select here</option>
                          <option value="Sales">Sales</option>
                          <option value="Business" >Business</option>
                          <option value="Director">Director</option>
                          <option value="Marketting">Marketting</option>
                          <option value="Marketting Intelligent">Marketting Intelligent</option>
                          </select>
                       </div>
                         <div class="col-sm-3">
                           <label class="control-label" for="search" style="margin: 0!important;">Levels</label>
                          <select class="form-control" name ="level" id="level">
                          <option value="" selected disabled>Select here</option>
                           <option value="C-Level" >C-Level</option>
                           <option value="VP-Level">VP-Level</option>
                           <option value="Director">Director</option>
                           <option value="Manager">Manager</option>
                           <option value="Non-Manager">Non-Manager</option>
                           </select>
                        </div>
                       <div class="col-sm-3">
                            <label class="control-label" for="search" style="margin: 0!important;">Country</label>
                            <select class="form-control" name ="country" id="country">
                            <option value="" selected disabled>Select here</option>
                            <?php foreach($Countries as $country) { ?>
                            <option value="<?php echo $country['country']; ?>"><?php echo $country['country']; ?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                           <label></label>
                           <button class="btn btn-primary" type="button" id="search_contacts2" style="font-size: 12px;">Search</button>
                       </div>
                   </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="getcontacts">
<!--------------- DATA TABLE------------------------->
                    <div class="table-responsive m-b-40">
                        <table class="table table-responsivetable-borderless table-report" id="contacttable">
                            <thead>
                                <tr>
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
                                  <th>Action</th>
                                </tr>
                            </thead>
                          <tbody>
                           <?php foreach($Myconlists as $row){ ?>
                            <tr>
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
                          <td><?php
                            if($row['status']==0){?>
                                <button style="width:22px;height:22px;" class="btn-status openconvert" data-toggle="modal" value="<?php echo $row['id'];?>" data-target="#openconvert"><i  style="color: green" class="fas fa-redo"></i></button>
                                <button style="width:22px;height:22px;" class="btn-status openreject" data-toggle="modal" value="<?php echo $row['id'];?>" data-target="#openreject"><i style="color: red" class="fas fa-times"></i></button>
                           <?php }elseif($row['status'] == 2){
                               echo $row['comments'];
                             } else {
                                echo "Converted";
                             }?></td>
                           </tr>
                           <?php } ?>
                          </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                    </div>
                </div>
             </div>
            <?php include('nav-foot.php'); ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
  $('#contacttable').DataTable({
      "ordering": false,
        "scrollX": true,
         "autoWidth": false
    });
    $("#convertaslead").click(function(){
      if(confirm("Are you sure you want to make it as Lead?")) {
        var contactid = $("#app_id").val();
        var email = $("#contact_email").val();
        var phone = $("#contact_phone").val();
        var comments = $("#contact_comment").val();
        //console.log(contactid);
         //console.log(email);
        $.ajax({
             type: "POST",
             url: 'ajax/contacts2_ajax.php',
             data: ({email:email,phone:phone,comments:comments,convert_contactid:contactid}),
             success: function(result){
              console.log(result);
              alert("Successfully converted as lead!!");
              window.location.reload();
          }
        });
      }else{
        return false;
      }
    });
     $("#contacttable").on("click", ".openconvert", function(){
            var contactid = $(this).val();
            console.log(contactid);
            $(".modal-body #app_id").val(contactid);
        });
    $("#contacttable").on("click", ".openreject", function(){
         var contactid = $(this).val();
         console.log(contactid);
         $(".modal-body #rej_id").val(contactid);
    });
    $("#save_comment").click(function(){
      var contactid = $("#rej_id").val();
      var comments = $("#comment").val();
      //console.log(comments);
      $.ajax({
         type: "POST",
         url: 'ajax/contacts2_ajax.php',
         data: ({contact2commentid:contactid,comments:comments}),
         success: function(result){
          console.log(result);
           alert("Commented!!");
           window.location.reload();
         }
      });
    });
    $("#search_contacts2").click(function(){
     var filter= "1";
       var category = $("#category").val();
       var level = $("#level").val();
       var country = $("#country").val();
       $.ajax({
              type: "POST",
              url: 'ajax/ajax_empcontacts2.php',
              data: ({filter:filter,category:category,level:level,country:country}),
              success: function(result){
               //console.log(result);
               $("#getcontacts").html(result)
              }
        });
    });
});
</script>
 <!-- Rejection comment Modal ----------------->
            <div class="modal fade" id="openreject" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong class="modal-title" style="font-size: 15px;">Comments</strong>
                            <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="contactid" id="rej_id" value=""/>
                                <div class="col-sm-4 form-group"><label for="usr" style="font-size: 14px">Comments:</label></div>
                                <div class="col-sm-7 form-group">
                                   <textarea class="form-control" rows="2" id="comment"></textarea></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label></label>
                            <button type="button" class="btn btn-danger" id="save_comment" data-dismiss="modal">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
<!-- end of Modal-------------------------->
 <!-- convert as lead Modal ----------------->
            <div class="modal fade" id="openconvert" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <strong class="modal-title" style="font-size: 15px;">Comments</strong>
                            <button type="button" class="close" id="mymodal" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="contactid" id="app_id" value=""/>
                                 <div class="col-sm-4 form-group">
                                  <label for="usr" style="font-size: 14px">Email:</label></div>
                                  <div class="col-sm-7 form-group">
                                  <input type="email" class="form-control" id="contact_email" placeholder="Enter email"></div>
                            </div>
                            <div class="row">
                                 <div class="col-sm-4 form-group">
                                 <label for="usr" style="font-size: 14px">Phonenumber:</label></div>
                                 <div class="col-sm-7 form-group">
                                 <input type="number" class="form-control" id="contact_phone" placeholder="Enter number"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                <label for="usr" style="font-size: 14px">Comments:</label></div>
                                <div class="col-sm-7 form-group">
                                <textarea class="form-control" rows="2" id="contact_comments"></textarea></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label></label>
                            <button type="button" class="btn btn-danger" id="convertaslead" data-dismiss="modal">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
<!-- end of Modal-------------------------->
