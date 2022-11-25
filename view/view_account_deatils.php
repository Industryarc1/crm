<?php
include('nav-head.php');
$AccId = base64_decode($_GET['acc_id']);
$accdetails=$accountsfunctions->getAccountByaccountId($AccId);
if($accdetails['website'] != ""){
 $website=$accdetails['website'];
  $parse = parse_url($website);
//echo $parse['host'];

if($parse['host']!= ""){
	$domain = preg_replace('/^www\./', '', $parse['host']);
}else{
	$domain = preg_replace('/^www\./', '', $parse['path']);
}
$web_leads=$accountsfunctions->getleadsByWebsite($domain);
$web_contacts=$accountsfunctions->getContactsByWebsite($domain);
}
//echo "<pre>";
//print_r($AccId);
//print_r($accdetails);
?>
<script>
    function updateacc(getid,str,col,id){
        $.ajax({
            type: "GET",
            url: 'ajax.php',
            data: ({accountid: getid,value:str,colname:col}),
            success: function(result){
                alert(col + " updated");
                document.getElementById(id).value = str;
                //window.location.reload();
            }
        });
    }
</script>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                 <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 style="font-family: sans-serif;">Company Name: <?php echo $accdetails['company_name'];?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label for="text-input" class="contact-label">Website</label>
                                        <input type="text" id="website" name="website" class="form-control contact-label" value="<?php echo $accdetails['website'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'website',this.id)">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input" class="contact-label">Employee size</label>
                                        <input type="text" id="employee_size" class="form-control contact-label" value="<?php echo $accdetails['employee_size'];?>" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input" class="contact-label">Total Revenue($ Million)</label>
                                        <input type="text" id="total_revenue" class="form-control contact-label" value="<?php echo $accdetails['total_revenue'];?>" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="text-input" class="contact-label">Phone Number</label>
                                        <input type="text" id="phone_number"  class="form-control contact-label" value="<?php echo $accdetails['phone_number'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'phone_number',this.id)">
                                    </div>

                                </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Country</label>
                                    <input type="text" id="country"  class="form-control contact-label" value="<?php echo $accdetails['country'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'country',this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">City</label>
                                    <input type="text" id="city"  class="form-control contact-label" value="<?php echo $accdetails['city'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'city',this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">State</label>
                                    <input type="text" id="state" class="form-control contact-label" value="<?php echo $accdetails['state'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'state',this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Postal code</label>
                                    <input type="text" id="postal_code" class="form-control contact-label" value="<?php echo $accdetails['postal_code'];?>">
                                </div>

                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Duns Number</label>
                                    <input type="text" id="duns_number" class="form-control contact-label" value="<?php echo $accdetails['duns_number'];?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Main Industry</label>
                                    <input type="text" id="main_industry" class="form-control contact-label" value="<?php echo $accdetails['main_industry'];?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Sub Industry</label>
                                    <input type="text" id="sub_industry" class="form-control contact-label" value="<?php echo $accdetails['sub_industry'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'sub_industry',this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Ownership Type</label>
                                    <input type="text" id="ownership_type" class="form-control contact-label" value="<?php echo $accdetails['ownership_type'];?>" readonly>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Assigned Date</label>
                                    <input type="text" id="assigned_date" class="form-control contact-label" value="<?php echo $accdetails['assigned_date'];?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Linkedin Profile</label>
                                    <input type="text" id="linkedin_profile"  class="form-control contact-label" value="<?php echo $accdetails['linkedin_profile'];?>" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'linkedin_profile',this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Business Description</label>
                                    <textarea id="business_des" class="form-control contact-label"><?php echo $accdetails['business_des'];;?></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class="contact-label">Address</label>
                                    <textarea id="address" class="form-control contact-label" onchange="updateacc(<?php echo $accdetails['id'];?>,this.value,'address',this.id)"><?php echo $accdetails['address'];;?></textarea>
                                </div>

                            </div>
                        </div>
                   </div>
                </div>
       </div>
</div>
        <ul class="nav nav-tabs" style="background: #ffffff;">
            <li><a data-toggle="tab" href="#leads" class="leads_inactive_tab active">Leads</a></li>
            <li><a data-toggle="tab" href="#contacts" class="leads_inactive_tab">Contacts</a></li>
        </ul>
        <?php if($web_leads == []){ ?>
        <h3 style=" text-align: center;margin-top: 20px;">No Matching leads</h3>
        <?php } ?>
        <div class="tab-content">
            <div id="leads" class="tab-pane fade in active">
          <?php if($web_leads != []){ ?>
            <div class="row" style="margin: 20px 10px;">
                <h4 style="margin-bottom:20px;">Inbound Leads for this Company</h4>
                <div class="col-sm-12" style="padding: 0;">
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data4" id="lead_datatable">
                            <thead>
                            <tr>
                                <th>Lead</th>
                                <th>Designation</th>
                                <th>Email </th>
                                <th>Phone Number</th>
                                <th>Department</th>
                                <th>Country</th>
                                <th>Entry Point</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($web_leads as $row){?>
                                <tr>
                                    <td><a href="contact_details.php?lead_id=<?php echo base64_encode($row['id']);?>"><?php echo $row['fname']." ".$row['lname'];?></a></td>
                                    <td><?php echo $row['job_title']?></td>
                                    <td><?php echo $row['email']?></td>
                                    <td><?php echo $row['phone_number']?></td>
                                    <td><?php echo $row['department']?></td>
                                    <td><?php echo $row['country']?></td>
                                    <td><?php echo $row['entry_point']?></td>
                                </tr>
                                <?php
                            }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                </div>
            </div>
            <?php } ?>
            </div>
            <div id="contacts" class="tab-pane fade">
           <?php if($web_contacts != []){ ?>
            <div class="row" style="margin: 20px 10px;">
                <h4 style="margin-bottom:20px;">Contacts for this Company</h4>
                <div class="col-sm-12" style="padding: 0;">
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data4" id="contact_datatable">
                            <thead>
                            <tr>
                                <th>Contact</th>
                                <th>Convert</th>
                                <th>Designation</th>
                                <th>Email </th>
                                <th>Phone Number</th>
                                <th>Company</th>
                                <th>Country</th>
                                <th>Url</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($web_contacts as $row){?>
                                <tr>
                                    <td><?php echo $row['f_name']." ".$row['l_name'];?></td>
                                    <td><button class="convert_as_lead" onclick="convertLead(<?php echo $row['id'];?>)" style="margin-left: 30px;" value="<?php echo $row['id'];?>">
                                            <i class="fa fa-plus-circle" style="font-size: 18px;"></i></button>
                                    </td>
                                    <td><?php echo $row['designation']?></td>
                                    <td><?php echo $row['email']?></td>
                                    <td><?php echo $row['phone_two']?></td>
                                    <td><?php echo $row['company']?></td>
                                    <td><?php echo $row['country']?></td>
                                    <td><?php echo $row['url']?></td>
                                </tr>
                                <?php
                            }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                </div>
            </div>
        <?php } ?>
            </div>
        </div>

    </div>
</div>

<?php include('nav-foot.php');?>
<script>
    $(document).ready(function() {
        $('#lead_datatable').DataTable({
            "pageLength": 10
        });
        $('#contact_datatable').DataTable({
            "pageLength": 10
        });
        /*$(".convert_as_lead").click(function () {
            var contact_id= $(this).val();
            alert("Convert contact as lead??");
            $.ajax({
                type: "POST",
                url: 'ajax.php',
                data: ({contact_id: contact_id}),
                success: function(result){
                     //console.log(result);
                     window.location.reload();
                }
            });
        });*/
    });
	
	function convertLead(value){
		var contact_id= value;
		//console.log(value);
		alert("Convert contact as lead??");
		$.ajax({
			type: "POST",
			url: 'ajax.php',
			data: ({contact_id: contact_id}),
			success: function(result){
				// console.log(result);
				window.location.reload();
			}
		});
	}
</script>