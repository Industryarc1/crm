<?php
//$amount=base64_decode($_GET['amtval']);
$amount="0.02";
//$txnid=base64_decode($_GET['txnid']);
$txnid="trn".rand(10000,99999);
//$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
$paypal_url='https://www.paypal.com/cgi-bin/webscr'; //Production

//$paypal_id='dispatch@industryarc.com'; // Business email ID
$paypal_id='dispatch@industryarc.com'; // Business email ID

?>
<html>
<body onload="document.frmPayPal.submit()">
<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal">
  <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="item_name" value="products">
	<input type="hidden" name="item_number" value="<?=$txnid?>">
	<input type="hidden" name="amount" value="<?=$amount?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="handling" value="0">
	<input type="hidden" name="cancel_return" value="https://crm.industryarc.in/api/paypal/status.php">
	<input type="hidden" name="return" value="https://crm.industryarc.in/api/paypal/status.php">
</form>
</body>
</html>