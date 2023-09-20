<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
$invoiceid = base64_decode($_GET['invnum']);
$Invoice = $functions->getInvoiceById($invoiceid);
$bal= $Invoice['amount'] - $Invoice['paid_amount'];
$qty="1";
$total=$qty *$Invoice['amount'];
$date= date('d M Y', strtotime($Invoice['created']));
$duedate=date('d M Y',strtotime( $Invoice['created']. ' + 4 days'));
$report=$functions->getleadbyId($Invoice['lead_id']);

?>
<link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
<link href="css/custom.css" rel="stylesheet" media="all">
    <div class="main-content" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="section__content section__content--p30">
            <div class="container-fluid" style="padding-bottom: 30px;">
               <div class="container invoice-sheet">
                  <div class="row" style="margin-bottom: 30px;">
                      <div class="col-sm-10">
                          <img class="invoice-logo" src="images/icon/Big_Logo.png">
                          <div class="title-invoice">Furion Analytics Research and Consulting LLP </>
                           <div class="address-invoice">Flat 202, Lotus Pond Building<br>
                                Gafoor Nagar, Madhapur<br>
                                Hyderabad  500081<br>
                                India  <br>
                                GSTIN: 36AADFF5978R1ZH</div>
                      </div>
                  </div>
                      <div class="col-sm-2">
                          <h2 class="invoice-title">Invoice</h2>
                          <div class="invoice-id">#<?php echo $Invoice['invoice_num'];?></div>
                          <h5 style="margin-top: 20px;float: right">Balance Due<br>
                              <span style="float: right">$<?php echo $bal?></span></h5>
                      </div>
               </div>
                   <div class="row">
                       <div class="col-sm-8"></div>
                       <div class="row col-sm-4" style="padding: 0;">
                           <div class="col-sm-6 invoice-spacing">Invoice  Date:</div>
                           <div class="col-sm-6 invoice-spacing"><?php echo $date;?></div>
                       </div>
                   </div>
                <div class="row" style="margin-bottom: 20px">
                       <div class="col-sm-5">
                           <div class="invoice-report">
                               Bill To<br>
                               <strong><?php echo $Invoice['name'];?></strong><br>
                               <?php echo $Invoice['address'];?>
                           </div>
                       </div>
                    <div class="col-sm-3"></div>
                       <div class="row col-sm-4">
                           <div class="col-sm-6">
                               <p  class="invoice-spacing">Terms:</p>
                               <p  class="invoice-spacing">Due Date:</p>
                               <p  class="invoice-spacing">P.O.#:</p>
                               </div>
                           <div class="col-sm-6" style="padding-right: 0;">
                               <p  class="invoice-spacing">Net Due on Receipt</p>
                               <p  class="invoice-spacing"><?php echo $duedate;?></p>
                               <p  class="invoice-spacing"><?php echo $Invoice['purchase_order'];?></p>
                              </div>
                       </div>
                   </div>

<div class="row" style="margin-bottom: 20px">
<div class="col-sm-12">
      <div class="row table-head">
        <div class="col-sm-1 table-space">#</div>
        <div class="col-sm-8 table-space">Item & Description</div>
        <div class="col-sm-1 table-space">Qty</div>
        <div class="col-sm-1 table-space">Rate</div>
        <div class="col-sm-1 table-space">Amount</div>
    </div>
    <div class="row table_data">
        <div class="col-sm-1 table-space">1</div>
        <div class="col-sm-8 table-space"><?php echo $report['report_name'];?><br>
            <!--<div style="color: grey">Custom Study on Aircraft Seating Material Market - By Material Type</div>--></div>
        <div class="col-sm-1 table-space"><?php echo $qty;?>.00</div>
        <div class="col-sm-1 table-space"><?php echo $Invoice['amount'];?>.00</div>
        <div class="col-sm-1 table-space"><?php echo $total;?>.00</div>
    </div>
 </div>
</div>
 <div class="row">
 <div class="col-sm-8"></div>
     <div class="row col-sm-4">
         <div class="col-sm-6">
             <p  class="invoice-spacing">Sub Total:</p>
             <p  class="invoice-spacing">Total:</p>
             <p  class="invoice-spacing">Payment made:</p>
         </div>
         <div class="col-sm-6">
             <p  class="invoice-spacing"><?php echo $total;?>.00</p>
             <p  class="invoice-spacing">$<?php echo $total?>.00</p>
             <p  class="invoice-spacing">(-)<?php echo $Invoice['paid_amount'];?>.00</p>
         </div>
     </div>
 </div>
     <div class="row" style="margin-bottom: 40px;">
         <div class="col-sm-7"></div>
         <div class="row col-sm-5 bal-amount">
             <div class="col-sm-6">
             <p  class="invoice-spacing">Balance Due:</p>
             </div>
             <div class="col-sm-6">
                 <p  class="invoice-spacing">$<?php echo $bal;?></p>
             </div>
           </div>
          </div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-8">
               <div class="payment-title">Payment Details</div>
                        <div class="invoice-spacing-payment">
                            IGST @ 0%<br>
                            Supply Meant for Export Under Letter of Undertaking Without Payment of Integrated Tax<br>
                            Vide Serial No.33/2017 dated 31/07/2017.
                      </div>
                        <p style="font-size: 12px">Thanks for your business.</p>
                </div>
               </div>
                <div class="row payment-data">
                    <div class="col-sm-3">Bank Wire Transfer:</div>
                    <div class="col-sm-9"></div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">Beneficiary Name:</div>
                    <div class="col-sm-9">Furion Analytics Research & Consulting LLP</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">Beneficiary Bank:</div>
                    <div class="col-sm-9">Citibank India</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">Beneficiary:</div>
                    <div class="col-sm-9">A/C NO:   0124325552</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">Beneficiary Bank SWIFT Code:</div>
                    <div class="col-sm-9">CITIINBX</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">Bank Address:</div>
                    <div class="col-sm-9">Citibank NA, Queens Plaza, SP Road, Secunderabad.  Andhra Pradesh, India 500003</div>
                </div>
                <div class="row payment-data" style="margin-top: 10px;"><div class="col-sm-3">Additional Details:</div></div>
                <div class="row payment-data">
                    <div class="col-sm-3">Routing Number (USD):</div>
                    <div class="col-sm-9">021000089</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">IBAN number (Swiss Franc):</div>
                    <div class="col-sm-9">CH1289095000010570109</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">IBAN number (Euro):</div>
                    <div class="col-sm-9">GB68CITI18500805501024</div>
                </div>
                <div class="row payment-data">
                    <div class="col-sm-3">IBAN number (GBP):</div>
                    <div class="col-sm-9">GB90CITI18500800600091</div>
                </div>

                <div class="row payment-data" style="margin-top: 10px;">
                    <div class="col-sm-3">Terms & Conditions:</div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                       <p class="content-payment"> 1. The domain name IndustryARC (hereinafter referred to as “Industryarc.com”) is owned by
                           Furion Analytics Research & Consulting LLP a company incorporated under the Companies Act, 2013 with its registered office at Flat # 202, H.No. 1-89/2/1, 2nd Fl, Lotus Pond Apt, Gafoor Nagar, Near Durgam Cheruvu, Madhapur, Hyderabad - 500081, Telangana, INDIA (hereinafter referred to as “IndustryARC”).</p>
                        <p class="content-payment">This content is published in accordance with the provisions of Rule 3(1) of the
                            Information Technology (Intermediaries guidelines) Rules, 2011 that require publishing the rules and
                            regulations & privacy policy.</p>
                        <p class="content-payment"> 2. You agree not to resell, duplicate, reproduce or exploit any part of the
                            data/report you receive from us without the express written permission of Furion Analytics Research and
                            Consulting LLP.</p>
                        <p class="content-payment"> 3. Delivery of Report: In case of online download, the report will be delivered
                            to you by email within 48 hours of receipt of payment. In case of a customized version, report delivery
                            timeline will be indicated to the client over an e-mail.</p>
                        <p class="content-payment">4. Warranties: Furion Analytics Research and Consulting LLP, its affiliates and
                            its sponsors are neither responsible nor liable for any direct, indirect, incidental, consequential,
                            special, exemplary, punitive, or other damages arising out of or relating in any way to your use of our research. Findings, conclusions and recommendations in the Product are based on information gathered in good faith from both primary and secondary sources, whose accuracy we are not always in a position to guarantee.You assume sole responsibility for the selection, suitability and use of the Product and acknowledge that except as stated above we do not provide any additional warranties or guarantees relating to the Product.</p>
                        <p class="content-payment">5. A fee for late payment will be assessed equal to the lower of one and one
                            half percent (1.5%) per month and the maximum permitted by law. In addition you agree that all sales
                            are final and that you may not request for a refund. Kindly read all the information about the report before placing your order. Cancellation of orders will not be accepted after the payment has been made and the report has been dispatched. We reserve the right, for any reason whatsoever, to withhold delivery of the Product to you until payment has been received in full.</p>
                        <p class="content-payment"> 6. All our customers are entitled to receive a 10% free customization in the
                            report based on their specific requirements pertaining to the markets discussed in the report, once the
                            report is purchased. However, complexity of your requirement and time taken will be purely judged by our
                            analyst and IndustryARC will have the final say regarding the same.</p>
                        <p class="content-payment"> 7. By Signing this invoice you agree to all the terms and conditions mentioned in
                            this invoice (1-6) and also agree to all our terms on the web link http://industryarc.com/term-and-conditions.php</p>
                        <p class="content-payment">I agree to the standard terms & conditions, payment terms, refund terms, delivery
                            timeline in this invoice and wish to place an order.
                        </p>
                    </div>
                </div>
                <div class="row pay-sign">
                    <div class="col-sm-6">Customer Person In--charge & Position: </div>
                    <div class="col-sm-6">Publisher Person In--charge & Position:</div>
                </div>
                <div class="row  pay-sign">
                    <div class="col-sm-6">(Digital signature / Handwritten Signature):  </div>
                    <div class="col-sm-6">(Digital signature / Handwritten Signature):  </div>
                </div>




            </div>
        </div>
    </div>
