<?php
global $mysqli;
$reportid =$_GET['reportid'];
//$reportid="15039";
//$mysqli = new mysqli("172.16.20.4","root","Devops@987","iarc-db");
$mysqli = new mysqli("mysql.marketintelreports.com","dbindustryarc1","Reset!2345","dbindustryarc");
$bannerStmt = $mysqli->prepare("SELECT inc_id, title, code, table_of_content,curl FROM zsp_posts WHERE dup_inc_id=?");
$bannerStmt->bind_param('s',$reportid);
$bannerStmt->execute();
$bannerStmt->store_result();
if($bannerStmt->num_rows()>0){
    $bannerStmt->bind_result($inc_cat_id, $title, $date, $table_of_content,$curl);
    $bannerStmt->fetch();
    $table_of_content=base64_decode($table_of_content);
    //echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
  if($reportid>=500000){
      $reportUrl="industryarc.com/Research/".$curl."-".$reportid."";
  }else{
      $reportUrl="industryarc.com/Report/".$reportid."/".$curl."";
  }
  $bannertwo=$mysqli->prepare("SELECT title,descr FROM zsp_prs WHERE FROM_BASE64(descr) LIKE '%".$reportUrl."%' AND MATCH(title) AGAINST(?) LIMIT 1");
  $bannertwo->bind_param('s',$title);
  $bannertwo->execute();
  $bannertwo->store_result();
      if($bannertwo->num_rows()>0){
      $bannertwo->bind_result($prtitle,$description);
      $bannertwo->fetch();
       $description=base64_decode($description);
      }
}
$mysqli->close();
$titleExtract = explode("Market", $prtitle);
$title = $titleExtract[0]." Market";
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <html>
    <head>
   <style>
    body {
     font-family:sans-serif;
      font-size: 15px;
      font-weight:500;
      text-align:justify;
      }
     p{
     font-family: Courier New;
     text-align:justify;
     line-height:21px;
     }
     li{
      font-family: Courier New;
     }
     @page { margin: 50px 0 0 0; }
      footer {
          position: fixed;
          bottom: 0cm;
          left: 0cm;
          right: 0cm;
          height: 50px;
          color: #ffffff;
          background-color: #1f4e78;
      }
      .page-number:after { content: counter(page); }
         h1.title_align{
         font-family:sans-serif;
         font-size:40px;
         color:#ffffff;
         font-weight:500;
         padding-top:70%;
         padding-bottom:5px;
         margin:0 80px;
         border-bottom:1px solid #ffffff;
       }
       h4.sub_title{
        font-weight:500;
        padding:10px 0;
        border-bottom:1px solid #ffffff;
        font-size:18px;
        color:#ffffff;
        margin:0 80px;
       }
       .banner{
         margin-top: -50px;
         background:url("img/banner.jpg");
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;
         background-color:#ffffff;
         height:1080px;
       }
       .contact_bg{
        margin-top: -50px;
        background:url("img/contact.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color:#ffffff;
        height:1080px;
       }
       .header{
          top:-50px;
          color: #ffffff;
          background:url("img/top.jpg");
          background-repeat: no-repeat;
          height:40px;
          position: relative;
          padding:20px;
          font-size:15px;
       }
       .page_num_align{
       height:50px;
       padding:0px 20px;
       background-color:#203864;
       text-align:center;
       }
      .image{
       position: relative;
       }
      .strip_content {
        color:white;
        position: absolute;
        top: 7;
        left: 30;
        font-size:18px;
      }
      div.sub_headers{
      margin:10px 0 5px -20px;
      font-size:16px;
      color:#BB5E13;
      }
  </style>
  </head>
  <body>


 <!---------1st page----------------------------------------->
<div class="banner">
<h1 class="title_align">'.$title.'</h1>
<h4 style="padding-top:8px;font-weight:500;font-size:18px; color:#ffffff;margin:0 80px;">By Materials, By Product, By Preparation Method, By Application and By</h4>
<h4 class="sub_title">Geography Analysis - Forecast 2019 - 2024 </h4>
<table width="100%" style="padding-top:10px;font-size:30px;margin:0 60px;">
  <tr>
    <td width="30%"><span style="font-size:18px;color:#ffffff;"><img src="img/world.png" width="20px;"> www.industryarc.com</span></td>
    <td width="60%"><span style="font-size:18px;color:#ffffff;"><img src="img/envelope.png" width="21px;"/> sales@industryarc.com</span></td>
  </tr>
</table>
<footer>
<table style="width:100%">
  <tr>
    <td width="90%" style="height:50px;padding:0px 20px;">'.$title.' 2019-2024</td>
    <td width="10%" class="page_num_align"><span class="page-number">0</span></td>
  </tr>
</table>
</footer>
</div>
 <!---------2nd page----------------------------------------->
  <p style="page-break-before: always;">
  <div class="header">Industry Market Research for Business Leaders,<br>Strategists, Decision Makers</div>
  <div class="container" style="margin:0px 80px 50px 80px;">
  <div class="image">
  <img src="img/strip.jpg" alt="" width="630px;" height="40px;"/>
  <div class="strip_content">Press Release</div>
  </div>
  <div style="margin:25px 0;font-size:14px;">'.$description.'</div>
  </div>
  <footer>
  <table style="width:100%">
    <tr>
      <td width="90%" style="height:50px;padding:0px 20px;">'.$title.'</td>
      <td width="10%" class="page_num_align"><span class="page-number">0</span></td>
    </tr>
  </table>
  </footer>
<!---------3nd page----------------------------------------->
<p style="page-break-before: always;">
  <div class="header">Industry Market Research for Business Leaders,<br>Strategists, Decision Makers</div>
  <div class="container" style="margin:0px 80px 50px 80px;">
  <div class="image">
  <img src="img/strip.jpg" alt="" width="630px;" height="40px;"/>
  <div class="strip_content">Table of Contents</div>
  </div>
  <div style="margin:25px 0;font-size:14px;">'.$table_of_content.'</div>
  </div>
  <footer>
  <table style="width:100%">
    <tr>
      <td width="90%" style="height:50px;padding:0px 20px;">'.$title.'</td>
      <td width="10%" class="page_num_align"><span class="page-number">0</span></td>
    </tr>
  </table>
  </footer>
  </p>
<!---------4th page----------------------------------------->
<p style="page-break-before: always;">
  <div class="header">Industry Market Research for Business Leaders,<br>Strategists, Decision Makers</div>
  <div class="container" style="margin:0px 80px 50px 80px;">
<div style="font-size:18px;font-weight:500;color:#000011;">IndustryARC Solutions</div>
<div style="font-size:16px;">
<p>We cater to the pain points of our clients by providing the following solutions, which are targeted and address key
 issues specifically. Each of the business verticals is helpful to a client at various stages of their operational,
 managerial and strategic level plans. </p>
<ol style="margin-left:-20px;">
<div class="sub_headers">Syndicate Reports and Consulting (SRC)</div>
<li>Provide high quality analytical syndicated reports with key market insights, strategies and market forecasts
for a specific industry or vertical of the clients. Constant tracking of industries and relations with experts helps
us to predict and publish reports before our competitors as well as meet client needs proactively.</li>
<div class="sub_headers">Market Research and Data Analytics (MRDA)</div>
<li>Provide pure play data analytics services for ad-hoc and long-term engagement projects of clients with market
research layered into the analysis. We are the only global company to offer this combination one-stop service to clients.
 Redundancies generally seen by procuring data, analytics services from multiple vendors is overcome by our solution. </li>
<div class="sub_headers">Competitive Landscape Analysis (CLA)</div>
<li>Provide company financial analysis, market share analysis, competitive landscape insights and market movements
to clients. This is one of the most important pain point and key request from majority of our clients, for which we
use our proprietary methodologies to provide accurate CLA data. </li>
<div class="sub_headers">Accelerated Business Development (ABD)</div>
<li>Connect clients with their customers on a global scale by acting as an outsourced sales team on behalf
 of the client. This is a unique tri-party engagement model to benefit the client and their customer, and acts as
 a business development scale up at an international level.</li>
<div class="sub_headers">Market Intel Reports (MIR)</div>
<li>Provide one-stop venue with a searchable syndicate reports database from global companies available to clients.
 This augments our offerings exponentially and also assists in studying global client needs at an in-depth level.</li>
</ol>
</div>
</div>
<footer>
 <table style="width:100%">
    <tr>
      <td width="90%" style="height:50px;padding:0px 20px;">'.$title.'</td>
      <td width="10%" class="page_num_align"><span class="page-number">0</span></td>
    </tr>
  </table>
</footer>
</p>
<!---------5th page----------------------------------------->
<p style="page-break-before: always;">
  <div class="header">Industry Market Research for Business Leaders,<br>Strategists, Decision Makers</div>
  <div class="container" style="margin:0px 80px 50px 80px;">
<div style="font-size:18px;color:#000011;">About IndustryARC</div>
<p>IndustryARC strategy studies primarily focuses on Cutting Edge Technologies and Newer Applications of the Market.
Our Custom Research Services are designed to provide insights on the constant flux in the global demand-supply gap
of markets. Our strong analyst team enables us to meet the client research needs at a very quick speed with a variety
of options for your business.</p>
<p>We look forward to support the client to be able to better address customer needs; stay ahead in the market;
become the top competitor and get real-time recommendations on business strategies and deals.</p>
<div style="font-size:18px;color:#000011;">We Work for You</div>
<p>For IndustryARC, we value every customer equally. We only stay ready to help each client in the best way possible
 with a unique 24x365 support plan.</p>
 <p>We suggest looking at the following benefits of relying on Professional Business Consulting and Custom Market
 Research Services to realize the unique strategic gains on offer: </p>
<ol>
  <li>Strengthen and improve organizational performance </li>
  <li>Strategic planning and analysing</li>
  <li>Adoption of newer and cost-effective technologies</li>
  <li>Become environmentally sustainable and profitable</li>
  <li>Improve their training and certification procedures.</li>
  <li>Planning for business automation.</li>
  <li>Project facilitation and management.</li>
</ol>
<div style="font-size:18px;color:#color:#000011;">Our Expertise</div>
<p>Agriculture | Automotive | Energy and Power | Food & Beverage | Chemicals & Materials | Semiconductor & Electronics |
Information Technology | Automation & Instrumentation  Consumer Products & Services | Life Sciences and Healthcare</p>
</div>
<footer>
<table style="width:100%">
    <tr>
      <td width="90%" style="height:50px;padding:0px 20px;">'.$title.'</td>
      <td width="10%" class="page_num_align"><span class="page-number">0</span></td>
    </tr>
  </table>
</footer>
</p>
<!---------last page----------------------------------------->
<p style="page-break-after: always;">
<div class="contact_bg"></div>
<footer>
<table style="width:100%">
    <tr>
      <td width="90%" style="height:50px;padding:0px 20px;">'.$title.'</td>
      <td width="10%" class="page_num_align"><span class="page-number">0</span></td>
    </tr>
  </table>
</footer>
</p>
  </body>';
$filename="SampleReport";
/* instantiate and use the dompdf class */
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
/* Render the HTML as PDF */
$dompdf->render();
$dompdf->stream($filename, array("Attachment" => 1));

?>
