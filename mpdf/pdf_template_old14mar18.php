<?php
global $mysqli;
$mysqli = new mysqli("mysql.marketintelreports.com","dbindustryarc1","Reset!2345","dbindustryarc");
if(isSet($_REQUEST['id']) && $_REQUEST['id']!=""){
$bannerStmt = $mysqli->prepare("SELECT inc_id, title, code, table_of_content, description FROM zsp_posts WHERE dup_inc_id=?");
$bannerStmt->bind_param('s',$_REQUEST['id']);
$bannerStmt->execute();
$bannerStmt->store_result();
if($bannerStmt->num_rows()>0){
$bannerStmt->bind_result($inc_cat_id, $title, $date, $table_of_content, $description);	
$bannerStmt->fetch();
$table_of_content=base64_decode($table_of_content);
$description=trim(base64_decode($description));
//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
$mysqli->close();
require_once 'vendor/autoload.php';

$mpdf = new mPDF('');

$mpdf->useFixedNormalLineHeight = false;

$mpdf->useFixedTextBaseline = false;

$mpdf->adjustFontDescLineheight = 1.14;

$html = '
<html>
<head>
<style>
body { font-family: DejaVuSansCondensed, sans-serif; font-size: 11pt; line-height:20px; }
p{ text-align:justify;	}
@page {
  size: auto;
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
}
@page chapter2 {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(header.png) 100% 0;
  margin:9% 5%;
}
@page noheader {
    odd-header-name: _blank;
    even-header-name: _blank;
    odd-footer-name: _blank;
    even-footer-name: _blank;
  background:url(background.png)  50% 0;
}
div.noheader {
    page-break-before: right;
    page: noheader;
}
div.chapter2 {
    page-break-before: right;
    page: chapter2;
}
div.hd {
    font-size:11px;color:#333;width:100%;padding-top:300px;font-weight:600;font-family:Open Sans;
}
div.hd2 {
    font-size:10px;color:#333;font-family:Open Sans;padding:top:50px;border-bottom:1pa solid #333;width:100%;float:left;
}
div.footerr {text-align:center;padding:20px 0;border-top:6px solid #4a9ee9;border-bottom:6px solid #4a9ee9;}
div.adr {padding:5px;font-size:16px;font-weight:bold;background-color:#336699;color:#fff;}
div.logo {width:35%;float:left;padding-top:30px;}
div.adrrr {width:65%;float:left;text-align:left;margin-left:30px;color:#336699;}
ul  {width:100%;float:left;padding-top:20px;line-height:20px;margin:0;}
ul li{width:100%;float:left;line-height:20px;padding:5px 0;}
</style>

</head>

<body>
<div class="noheader">
<div class="hd"><h2>'.$title.'</h2></div>
</div>

<htmlpagefooter name="Chapter2FooterOdd" style="display:none">
<div style="text-align: right; font-weight: bold; font-size: 8pt; font-style: italic;">www.industryarc.com</div>
</htmlpagefooter>
<htmlpagefooter name="Chapter2FooterEven" style="display:none">
<div style="font-weight: bold; font-size: 8pt; font-style: italic;">www.industryarc.com</div>
</htmlpagefooter>
<div class="chapter2">
<div class="hd2"><h2>TABLE OF CONTENTS</h2></div><p>'.$table_of_content.'</p></div>

<div class="chapter2">
<div class="hd2"><h2>REPORT DESCRIPTION</h2></div><p>'.$description.'</p></div>
</div>
<div class="chapter2">
<div class="hd2"><h2>RESEARCH METHODOLOGY</h2></div>
<p>The quantitative and qualitative data collected for the report is from a combination of secondary and primary sources. Research interviews were conducted with senior executives and/or mangers from this Industry. These Key Opinion Leaders (KOLs) were then provided a questionnaire to gather quantitative and qualitative inputs on their operations, performance, strategies and views on the overall market, including key developments and technology trends. Data from interviews is consolidated, checked for consistency and accuracy, and the final market numbers are again validated by IndustryARC consultants and experts. The global market was split by types and geography based on primary and secondary sources, understanding of the number of companies operating in each segment and KOL insights.</p>
<p>We have used various secondary sources such as directories, articles, white papers, newsletters, annual reports and paid databases such as OneSource, Hoovers and Factiva to identify and collect information for extensive technical and commercial study.</p>
<p>The market has then been forecast according to the developments, product launches, macro-economic factors, regulations, mergers, expansion plans, strategies & trends indicated by the sales of major players.</p>
<p>The key players in the market and its value chain were identified through secondary research and their market opinions were also gathered in an equivalent way through telephonic interviews and questionnaires. We have also studied the annual reports of these top market players. Interviews with key opinion leaders such as CE0s’, marketing managers, sales directors, managers, and product managers were used extensively in understanding the need and emergence of this market. We also have extensive database of contacts which were used to conduct primary interviews and to get their inputs using questionnaires.</p>
</div>

<div class="chapter2">
<div class="hd2"><h2>INDUSTRYARC SOLUTIONS</h2></div>
<p><i>We cater to the pain points of our clients by providing the following solutions, which are targeted and address key issues specifically. Each of the business verticals is helpful to a client at various stages of their operational, managerial and strategic level plans.</i></p>
<h4>Syndicate Reports and Consulting (SRC)</h4>
<p>1. Provide high quality analytical syndicated reports with key market insights, strategies and market forecasts for a specific industry or vertical of the clients. Constant tracking of industries and relations with experts helps us to predict and publish reports before our competitors as well as meet client needs proactively.</p>
<h4>Market Research and Data Analytics (MRDA)</h4>
<p>2. Provide pure play data analytics services for ad-hoc and long-term engagement projects of clients with market research layered into the analysis. We are the only global company to offer this combination one-stop service to clients. Redundancies generally seen by procuring data, analytics services from multiple vendors is overcome by our solution.</p>
<h4>Competitive Landscape Analysis (CLA)</h4>
<p>3. Provide company financial analysis, market share analysis, competitive landscape insights and market movements to clients. This is one of the most important pain point and key request from majority of our clients, for which we use our proprietary methodologies to provide accurate CLA data.</p>
<h4>Accelerated Business Development (ABD)</h4>
<p>4. Connect clients with their customers on a global scale by acting as an outsourced sales team on behalf of the client. This is a unique tri-party engagement model to benefit the client and their customer, and acts as a business development scale up at an international level.</p>
<h4>Market Intel Reports (MIR)</h4>
<p>5. Provide one-stop venue with a searchable syndicate reports database from global companies available to clients. This augments our offerings exponentially and also assists in studying global client needs at an in-depth level.</p>
</div>

<div class="chapter2">
<img src="11.png" width="100%"/>
</div>

<div class="chapter2">
<div class="hd2"><h2>About IndustryARC</h2></div>
<p>IndustryARC strategy studies primarily focuses on Cutting Edge Technologies and Newer Applications of the Market. Our Custom Research Services are designed to provide insights on the constant flux in the global demand-supply gap of markets. Our strong analyst team enables us to meet the client research needs at a very quick speed with a variety of options for your business.<BR><BR>We look forward to support the client to be able to better address customer needs; stay ahead in the market; become the top competitor and get real-time recommendations on business strategies and deals.</p>
<h2>WE WORK FOR YOU</h2>
<p>For IndustryARC, there exists no best customer. We do not choose. We only stay ready dawn or dusk to help out each client in the best way possible with a unique 24x365 support plan.</p>
<p>We suggest looking at the following benefits of relying on Professional Business Consulting and Custom Market Research Services to realize the unique strategic gains on offer:</p>
<ul><li>Strengthen and improve organizational performance</li>
<li>Strategic planning and analysing</li>
<li>Adoption of newer and cost-effective technologies</li>
<li>Become environmentally sustainable and profitable</li>
<li>Improve their training and certification procedures.</li>
<li>Planning for business automation.</li>
<li>Project facilitation and management.</li>
</ul>
</p>
<h2>OUR EXPERTISE</h2>
<p>Agriculture | Automotive | Energy and Power | Food & Beverage | Chemicals & Materials | Semiconductor & Electronics | Information Technology | Automation & Instrumentation | Consumer Products & Services | Life Sciences and Healthcare (Medical Devices and Pharmaceuticals)</p>
</div>

<div class="chapter2">
  <div class="hd2"><h2>CONTACT US</h2></div>
  <div class="footerr">
  <div class="logo"><img src="http://industryarc.com/images/logo.png" ></div>
    <div class="adrrr">
    <h2>IndustryARC</h2>
    <h3>India Sales Support (+91) 040-64621234<BR>
    U.S Sales Support +1 614-588-8538 (Ext-101)<BR>
    sales@industryarc.com<BR>
    www.industryarc.com</h3>
    </div>
  <BR>
  <div class="adr">Plot No.S-1, SYNO.1043 & 1048,<BR>2nd Floor, Phase-1 & 2, Opp. BSNL Office,<BR>KPHB Colony, Hyderabad Telangana - 500072</div>
  </div>
</div>

</body></html>';

$mpdf->WriteHTML($html);
$pdf_name=$_REQUEST['id']."_Report_Sample_".date('dmy').".pdf";
$mpdf->Output($pdf_name,"D");
$error="";
}else{
	echo $error="No data exists with this Report Code. Click <a href='http://industryarc.com/'>here</a> to go back to home page";
}
}else{
	echo $error="Did not find Report Code. Click <a href='http://industryarc.com/'>here</a> to go back to home page";
}
?>