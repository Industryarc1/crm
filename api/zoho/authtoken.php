<?php
session_start();
$code = $_GET['code'];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token?client_id=1000.XLPQ2G9GFRJNDF7V8LCFS56Y24PVJC&grant_type=authorization_code&client_secret=89dac74ab85a58803068afe725469b358e641d2613&redirect_uri=https://crm.industryarc.in/api/zoho/authtoken.php&code='.$code,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(),
));

$response = curl_exec($curl);
curl_close($curl);
$resultrf = json_decode($response,true);

$refToken = $resultrf['refresh_token'];
$emp_id = $_SESSION['employee_id'];
$updateemp = array("zoho_ref_token"=>$refToken);

if(!empty($refToken)){
    include_once('../../model/function.php');
    $functions = new functions();
    $functions->UpdateEployeeStatus($emp_id, $updateemp);
    $_SESSION['zoho_ref_token'] = $refToken;
    echo '<script type="text/javascript">
           window.location = "https://crm.industryarc.in/view/zoho_books.php"
      </script>';
      die();
}else{
    echo '<script type="text/javascript">
           window.location = "https://crm.industryarc.in"
      </script>';
      die();
}

	
/* https://accounts.zoho.com/oauth/v2/auth
?response_type=code&
client_id=1000.XLPQ2G9GFRJNDF7V8LCFS56Y24PVJC&
scope=ZohoBooks.fullaccess.all,ZohoBooks.contacts.CREATE&
redirect_uri=https://crm.industryarc.in/api/zoho/authtoken.php&state=testing&
prompt=consent&access_type=offline	*/

/* 
https://accounts.zoho.com/oauth/v2/token?
client_id=1000.XLPQ2G9GFRJNDF7V8LCFS56Y24PVJC&
grant_type=authorization_code&
client_secret=89dac74ab85a58803068afe725469b358e641d2613&
redirect_uri=https://crm.industryarc.in/api/zoho/authtoken.php&
code=1000.b64892e0d650b8dc3d2796150c0667f8.572eb6458116b8ccc8bf8830aedd645b	
*/

/*

https://accounts.zoho.com/oauth/v2/token?refresh_token=1000.36c695a40ba44c4d0880131f5a2ea951.4fddf3304bee8cd87ed5f89592df136f&client_id=1000.XLPQ2G9GFRJNDF7V8LCFS56Y24PVJC&client_secret=89dac74ab85a58803068afe725469b358e641d2613&redirect_uri=https://crm.industryarc.in/api/zoho/accesstoken.php&grant_type=authorization_code
	
*/
?>