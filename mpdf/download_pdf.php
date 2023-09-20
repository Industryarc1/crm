<?php
global $mysqli;
ini_set("display_errors",0);
$mysqli = new mysqli("mysql.marketintelreports.com","dbindustryarc1","Reset!2345","dbindustryarc");
$bannerStmt = $mysqli->prepare("SELECT inc_id, title, code, table_of_content, description FROM zsp_posts WHERE dup_inc_id=?");
$bannerStmt->bind_param('s',$_GET['id']);
$bannerStmt->execute();
$bannerStmt->store_result();
if($bannerStmt->num_rows()>0){
	$bannerStmt->bind_result($inc_cat_id, $title, $date, $table_of_content, $description);	
	$bannerStmt->fetch();
}
$reportId = $_GET['id'];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
$ip_city = $addrDetailsArr['geoplugin_city'];
$ip_country = $addrDetailsArr['geoplugin_countryName'];

$stmtgCE1=$mysqli->prepare("SELECT prefix FROM zsp_location WHERE name=?");
$stmtgCE1->bind_param('s',$ip_country);
$stmtgCE1->execute();
$stmtgCE1->store_result();
$stmtgCE1->bind_result($ip_country_code);        
$stmtgCE1->fetch();

if(isset($_POST['download']) && $_POST['download']=="download"){
	$name = explode(" ",$_POST['fname']);
	$fname = $name['0'];
	$lname = $name['1'];
	$repId = $_POST['reportID'];
			$newpost = array('token'=>'deeptest',
			'f_name' => $fname,
			'l_name' => $lname,
			'company' =>  '',
			'job_title' => '',
			'phonenumber' => $_POST['ext']." ".$_POST['mobile'],
			'email' => $_POST['email'],
			'txtComments' => $_POST['cost'],
			'hidReportCode' => $_POST['reportCode'],
			'hidReportName' => $_POST['reportTitle'],
			'hidCatName' => '',
			'hidSubCatName' => '',
			'pub_date' =>  '',
			'noofpages' => '',
			'timezonepicker' => '',
			'entry_point' => 'Interest Download',
			'lead_generation_channel' => 'IARC-Inbound',
			//'lead_generation_channel' => 'MIR-Inbound',
			'txtAddress' => '',
			'txtState' => '',
			'txtCity' => '',
			'txtCountry' => $ip_country,
			'txtPincode' => '',
			'logo' => '',
			'speak_to_analyst' => '',
			'TitlesRelatedMyCompany' => '',
			'paymentOption' => '');
			
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, 'https://crm.industryarc.in/api/inbound-leads/inboundleads.php');
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($newpost));
		$response1 = curl_exec($ch2);
		curl_close($ch2);
		echo '<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-45676415-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "UA-45676415-1");
</script>
';
	echo '<script>window.location = "pdf_template_new.php?id='.$repId.'";</script>';
	echo '<script>window.location.href="download_pdf.php?id='.$repId.'";</script>';
	//echo "<script>window.open('https://industryarc.com/mpdf/pdf_template_new.php?id=$reportId', '_blank');</script>";
}
?>
	
 <html>
  <head>
	  <title>IndustryARC - Download Sample</title>	  
	  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
      
	  <style>
		body {
			background:#F8F8FF;
		}
		.form_bg {
			background-color:#eee;
			color:#666;
			padding:20px;
			border-radius:10px;
			position: absolute;
			border:1px solid #fff;
			margin: auto;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			width: 600px;
			height: auto;
		}
		.align-center {
			text-align:center;
		}
	  </style>
  </head>
  <body>
  
	<?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="Invalid Password"){ ?>
	<script>
			swal("Password Mismatch!", "Please enter your correct password", "error");
	</script>
	<?php } ?>
	
	<?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="User not exist"){ ?>
	<script>
			swal("Not Registered!", "Your are not registered with us", "error");
	</script>
	<?php } ?>
	
    <div class="container">
		<div class="row">		
			<div class="form_bg">
				<form method="post" action="download_pdf.php">
					<!--<h2 class="text-center">Download Report Content</h2>-->
					<div class="login-logo" style="text-align:center;">
					<a href="#">
					<!--<img src="images/icon/logo.png" alt="CoolAdmin">-->
					<img src="logo.png" style="width:150px;" alt="CoolAdmin">
					</a>
					</div>
					<br/>
					<div class="form-group">
						<span><b>Report :</b> </span> <?php echo $title; ?>
					</div>
					<div class="form-group">
						<input type="text" name="fname" class="form-control" placeholder="Name" required autofocus>
					</div>					
					<div class="form-group">
						<input type="text" name="email" class="form-control" placeholder="Email Id" required autofocus>
					</div>
					<div class="row form-group">
						<div class="col-md-3"><input type="text" name="ext" value="<?php echo $ip_country_code; ?>" class="form-control" placeholder="Extension" required autofocus></div>
						<div class="col-md-9"><input type="text" name="mobile" class="form-control" placeholder="Phone Number" required autofocus></div>
					</div>
					<div class="form-group">
						<label>Require Cost of the Report ?</label>
						<label><input type="radio" name="cost" value="Required Cost - Yes">Yes</label>
						<label><input type="radio" name="cost" value="Required Cost - No">No</label>
					</div>
					<br/>
					<div class="align-center">
						<button type="submit" name="download" value="download" class="btn btn-primary" id="download">Download Sample</button>
						<input type="hidden" name="reportID" value="<?php echo $reportId; ?>" class="form-control" />
						<input type="hidden" name="reportTitle" value="<?php echo $title; ?>" class="form-control" />
						<input type="hidden" name="reportCode" value="<?php echo $date; ?>" class="form-control" />
					</div>
				</form>
				<strong style="font-size:12px;">* Note : These details will be kept confidential. And will not be used for marketing purpose.</strong>
			</div>
		</div>
	</div>
  </body>
  </html>