<?php

$MERCHANT_KEY = "149788";
$txnid="trn".rand(10000,99999);
$chkName="vishwadeep singh";
$chkEmail="vishwadeep.singh@industryarc.com";
$chkPhone="9000728610";
$delcharges1="0.02";

?>
<html>

<body onLoad="document.customerData.submit()">
    <form method="post" name="customerData" action="ccavRequestHandler.php">

<input type="hidden" name="tid" value="<?=$txnid?>"/>
<input type="hidden" name="merchant_id" value="<?=$MERCHANT_KEY ?>" />
<input type="hidden" name="order_id" value="<?=$txnid?>" />
<input type="hidden" name="amount" value="<?=$delcharges1?>" />
<input type="hidden" name="currency" value="USD" />

<input type="hidden" name="redirect_url" value="https://crm.industryarc.in/api/ccavenue/ccavResponseHandler.php" />

<input type="hidden" name="cancel_url" value="https://crm.industryarc.in/api/ccavenue/ccavResponseHandler.php" />

<input type="hidden" name="language" value="EN" />
<input type="hidden" name="billing_name" value="<?=$chkName?>" />
<input type="hidden" name="billing_email" value="<?=$chkEmail?>" />
<input type="hidden" name="billing_tel" value="<?=$chkPhone?>" />

	</form>
</body>
</html>