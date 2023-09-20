<?php
include('nav-head.php');
error_reporting(0);
include_once('../model/zohofunction.php');
$zohofunctions = new zohofunctions();
$arrCurrencyList = $zohofunctions->getCurrencyList();
$currencyNotIn = array('AUD','CAD','CNY','INR','GBP','ZAR');

if(empty($_SESSION['zoho_ref_token'])){
    //header("Location: https://accounts.zoho.com/oauth/v2/auth?response_type=code&client_id=1000.XLPQ2G9GFRJNDF7V8LCFS56Y24PVJC&scope=ZohoBooks.fullaccess.all&redirect_uri=https://crm.industryarc.in/api/zoho/authtoken.php&state=production&prompt=consent&access_type=offline");
    echo '<script type="text/javascript">
           window.location = "https://accounts.zoho.com/oauth/v2/auth?response_type=code&client_id=1000.XLPQ2G9GFRJNDF7V8LCFS56Y24PVJC&scope=ZohoBooks.fullaccess.all&redirect_uri=https://crm.industryarc.in/api/zoho/authtoken.php&state=production&prompt=consent&access_type=offline"
      </script>';
    die();
}
//echo "<pre>";
//print_r($_SESSION);
//print_r($arrCurrencyList);exit;
?>

<!-- MAIN CONTENT-->
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form id="customerDetail" action="zoho_ajax.php" method="post">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add New Invoice</strong>
                        </div>
                    <div class="card-body card-block">
                        <input type="hidden" name="contact_type">
                        <input type="hidden" name="is_portal_enabled">
                        <input type="hidden" name="payment_terms">
                        <input type="hidden" name="payment_terms_label">
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <label for="text-input" class="contact-label">Contact Name *</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="contact_name" name="contact_name" placeholder="Contact name" class="form-control contact-label">
                                </div>
                                <div class="col-md-2">
                                    <label for="text-input" class="contact-label">Company Name</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="company_name" name="company_name" placeholder="Company name" class="form-control contact-label">
                                </div>
                            </div>
                            <div class="row form-group">
                                <!--<div class="col-md-2">
                                    <label for="text-input" class="contact-label">Website</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="website" name="website" placeholder="Website" class="form-control contact-label">
                                </div>-->
								<div class="col-md-2">
                                    <label for="text-input" class="contact-label">Purchase Order</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="purchase_order" name="purchase_order" placeholder="Purchase Order" class="form-control contact-label">
                                </div>
                                <div class="col-md-2">
                                    <label for="text-input" class="contact-label">Currency Id *</label>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control contact-label" id="currency_id" name="currency_id">
                                        <!--<option value ="544119000000000097">USD- Dollars</option>-->
                                      <?php
                                       foreach($arrCurrencyList as $currency){
										   if(!in_array($currency['currency_code'],$currencyNotIn)){
                                          ?>
                                            <option value="<?= $currency['currency_id'];?>" <?php if($currency['currency_code']=='USD'){echo "selected";}?>><?= $currency['currency_name_formatted'];?></option>
                                          <?php
										   }
                                       }
                                      ?>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="row form-group">
                                <div class="col-md-2">
                                    <label for="text-input" class="contact-label">Notes</label>
                                </div>
                                <div class="col-md-4">
                                    <textarea id="notes" name="notes" class="form-control contact-label" size="4"></textarea>
                                </div>
                            </div>-->
                    </div>
                    </div>
                    <!-- ---------------billing formm-------------------------- -->
                    <div class="card">
                        <div class="card-header">
                            <strong>Billing Address</strong>
                        </div>
                        <div class="card-body card-block">
                            <input type="hidden" id ="billing_attention" name="billing_address[attention]" value="">
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Address *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <textarea id="billing_address[address]" name="billing_address[address]" class="form-control contact-label" size="4"></textarea>
                                    </div>

                                   <!-- <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Country </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[country]" name="billing_address[country]" placeholder="country" class="form-control contact-label">
                                    </div>-->
                                </div>
                                <!--<div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">City </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[city]" name="billing_address[city]" placeholder="City" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">State </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[state]" name="billing_address[state]" placeholder="state" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Street</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[street2]" name="billing_address[street2]" placeholder="street" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">State Code </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[state_code]" name="billing_address[state_code]"  class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Fax</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[fax]" name="billing_address[fax]" placeholder="" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Zip </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[zip]" name="billing_address[zip]" placeholder="" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Phone</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="billing_address[phone]" name="billing_address[phone]" placeholder="" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="text-input" class="contact-label"><b>Shipping Address is same as Billing Address?</b></label>
                                    </div>
                                    <div class="col-md-1" style="padding-top: 8px;">
                                        <input type="checkbox" id="sameShipAddr" name="sameShipAddr" class="form-control">
                                    </div>
                                </div>-->
                        </div>
                    </div>
                    <!-- ---------------shipping formm-------------------------- -->

                    <!--<div class="card">
                        <div class="card-header">
                            <strong>Shipping Address</strong>
                        </div>
                        <div id="shippingAddr">
                        <div class="card-body card-block">
                            <input type="hidden" id ="shipping_attention" name="shipping_address[attention]" value="">
                            <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Address *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <textarea id="shipping_address[address]" name="shipping_address[address]" class="form-control contact-label" size="4"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Country </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[country]" name="shipping_address[country]" placeholder="Country" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">City </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[city]" name="shipping_address[city]" placeholder="City" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">State </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[state]" name="shipping_address[state]" placeholder="state" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Street </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[street2]" name="shipping_address[street2]" placeholder="street" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">State Code </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[state_code]" name="shipping_address[state_code]" placeholder="" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Fax</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[fax]" name="shipping_address[fax]" placeholder="" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Zip </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[zip]" name="shipping_address[zip]" placeholder="" class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Phone</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="shipping_address[phone]" name="shipping_address[phone]" placeholder="" class="form-control contact-label">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- ---------------contact formm-------------------------- -->
                    <div class="card">
                        <div class="card-header">
                            <strong>Contact Person Info</strong>
                        </div>
                        <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Mr / Mrs</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="contact_persons[salutation]" name="contact_persons[salutation]"  class="form-control contact-label">
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">First Name *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="contact_persons[first_name]" name="contact_persons[first_name]"  class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Last Name *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="contact_persons[last_name]" name="contact_persons[last_name]"  class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Email *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="email" id="contact_persons[email]" name="contact_persons[email]"  class="form-control contact-label">
                                    </div>
                                </div>
                                <!--<div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Phone</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="contact_persons[phone]" name="contact_persons[phone]" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Mobile</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="contact_persons[mobile]" name="contact_persons[mobile]"  class="form-control contact-label">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Designation </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="contact_persons[designation]" name="contact_persons[designation]" class="form-control contact-label">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Department </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="contact_persons[department]" name="contact_persons[department]" class="form-control contact-label">
                                    </div>
                                </div>-->
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Is Primary Contact</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="contact_persons[is_primary_contact]" value="true" checked>
                                        <input type="hidden" name="contact_persons[skype]" value="Zoho">
                                        <input type="hidden" name="contact_persons[enable_portal]" value=true>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- ---------------item formm-------------------------- -->
                    <div class="card">
                        <div class="card-header">
                            <strong>Item Details</strong>
                        </div>
                        <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Item Name *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <!--<input type="text" id="item_details[name]" name="item_details[name]" class="form-control contact-label">-->
										<textarea id="item_details[name]" name="item_details[name]" class="form-control contact-label" size="4"></textarea>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Item Rate *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" id="item_details[rate]" name="item_details[rate]" class="form-control contact-label">
                                    </div>
                                </div>
								
								<div class="row form-group">                                    
									<div class="col-md-2">
                                        <label for="text-input" class="contact-label">Due Date *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" id="inovice_details[due_date]" name="inovice_details[due_date]" class="form-control contact-label">
                                    </div>
                                </div>

                        </div>
                    </div>
                    <!-- ---------------invoice  formm-------------------------- -->
                    <!--<div class="card">
                        <div class="card-header">
                            <strong>Invoice Details</strong>
                        </div>
                        <div class="card-body card-block">
                            <input type="hidden" name="inovice_details[invoice_number]">                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Inovice Discount</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="inovice_details[discount]" name="inovice_details[discount]"  class="form-control contact-label">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="text-input" class="contact-label">Due Date *</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" id="inovice_details[due_date]" name="inovice_details[due_date]" class="form-control contact-label">
                                    </div>
                                </div>
                        </div>
                    </div>-->
                    <!-- ---------------end  formmsssssssssss-------------------------- -->
                    <button type="submit" class="btn btn-primary" style="float: right">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
            <?php include('footer-right.php'); ?>
        </div>
    </div>
<?php include('nav-foot.php'); ?>
<script>
    $(document).ready(function(){
        $("#sameShipAddr").click(function() {
            if (this.checked) {
                $("#shippingAddr").hide();
                $("#sameShipAddr").val(true);
            }else{
                $("#shippingAddr").show();
                $("#sameShipAddr").val('');
            }
        });
    });
    $("#customerDetail").submit(function(){
        var contactName = $("input[name=contact_name]").val();
        if(contactName!=''){
            $("#billing_attention").val(contactName);
            $("#shipping_attention").val(contactName);
        }
    });

</script>