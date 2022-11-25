<?php
global $mysqli;
$mysqli = new mysqli("34.90.23.238","iarcgpc","Iarcgpc@123","iarcdb-live");
if(isSet($_REQUEST['id']) && $_REQUEST['id']!=""){
$bannerStmt = $mysqli->prepare("SELECT inc_id, title, code, table_of_content, description FROM zsp_posts WHERE dup_inc_id=?");
$bannerStmt->bind_param('s',$_REQUEST['id']);
$bannerStmt->execute();
$bannerStmt->store_result();
if($bannerStmt->num_rows()>0){
$bannerStmt->bind_result($inc_cat_id, $title, $date, $table_of_content, $description);	
$bannerStmt->fetch();
$table_of_content=base64_decode($table_of_content);
	$keyword1 = "Startup companies Scenario";
	$keyword2 = "Market Entry Scenario";
	$keyword3 = "Competition landscape";
	$keyword4 = "Company List by Country";
	$keyword5 = "-Methodology";
	//$premium = ' <span title="Premium Section"> <img src="new_template/design1/premium.jpg"></span>';
	$premium = '  <span style="background-color:red;border-radius: 25px;height:20px;width:80px;">&nbsp;<font color="white">Premium</font></span>';
	//$premium = ' <font style="color:red;" >Premium</font>';
	if(strpos($table_of_content,$keyword1)){
		$pos = strpos($table_of_content,$keyword1)+strlen($keyword1);
		$table_of_content= substr_replace($table_of_content,$premium,$pos,0);
	}
	if(strpos($table_of_content,$keyword2)){
		$pos = strpos($table_of_content,$keyword2)+strlen($keyword2);
		$table_of_content= substr_replace($table_of_content,$premium,$pos,0);
	}
	if(strpos($table_of_content,$keyword3)){
		$pos = strpos($table_of_content,$keyword3)+strlen($keyword3);
		$table_of_content= substr_replace($table_of_content,$premium,$pos,0);
	}
	if(strpos($table_of_content,$keyword4)){
		$pos = strpos($table_of_content,$keyword4)+strlen($keyword4);
		$table_of_content= substr_replace($table_of_content,$premium,$pos,0);
	}
	if(strpos($table_of_content,$keyword5)){
		$pos = strpos($table_of_content,$keyword5)+strlen($keyword5);
		$table_of_content= substr_replace($table_of_content,$premium,$pos,0);
	}
$description=trim(base64_decode($description));
//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
$mysqli->close();
require_once 'vendor/autoload.php';

$mpdf = new mPDF('');

$mpdf->useFixedNormalLineHeight = false;

$mpdf->useFixedTextBaseline = false;

$mpdf->adjustFontDescLineheight = 1.14;

if($description!=""){
	$html1 = '<div class="chapterreportdescription">
<div class="hd2"><h2>REPORT DESCRIPTION</h2></div><p>'.$description.'</p></div>
</div>';
}else{
	$html1 = "";
}

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
@page chapterTable {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/blank page.png) 100% 0;
  margin:9% 5%;
}
@page chapterreportdescription {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/blank page.png) 100% 0;
  margin:9% 5%;
}
@page chaptersecondarysource {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_03.png) 100% 0;
  margin:9% 5%;
}
@page chapterresearchm1 {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_04.png) 100% 0;
  margin:9% 5%;
}
@page chapterresearchm2 {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_05.png) 100% 0;
  margin:9% 5%;
}
@page chapterindussol {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_07.png) 100% 0;
  margin:9% 5%;
}
@page chapterclientelec {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_08.png) 100% 0;
  margin:9% 5%;
}
@page chapterclientfood {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_09.png) 100% 0;
  margin:9% 5%;
}
@page chapterclientlife {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_10.png) 100% 0;
  margin:9% 5%;
}
@page chapterclientchem {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_11.png) 100% 0;
  margin:9% 5%;
}
@page chapteraboutiarc {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_12.png) 100% 0;
  margin:9% 5%;
}
@page chaptercontact {
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_13.png) 100% 0;
  margin:9% 5%;
}

@page noheader {
    odd-header-name: _blank;
    even-header-name: _blank;
    odd-footer-name: _blank;
    even-footer-name: _blank;
  background:url(new_template/design1/Bio-plastics Market TOC2_Page_01.png)  50% 0;
}
div.noheader {
    page-break-before: right;
    page: noheader;
}
div.chapterTable {
    page-break-before: right;
    page: chapterTable;
}
div.chapterresearchm1 {
    page-break-before: right;
    page: chapterresearchm1;
}
div.chapterresearchm2 {
    page-break-before: right;
    page: chapterresearchm2;
}
div.chapterindussol {
    page-break-before: right;
    page: chapterindussol;
}
div.chapterclientelec {
    page-break-before: right;
    page: chapterclientelec;
}
div.chapterclientfood {
    page-break-before: right;
    page: chapterclientfood;
}
div.chapterclientlife {
    page-break-before: right;
    page: chapterclientlife;
}
div.chapterclientchem {
    page-break-before: right;
    page: chapterclientchem;
}
div.chapteraboutiarc {
    page-break-before: right;
    page: chapteraboutiarc;
}
div.chaptercontact {
    page-break-before: right;
    page: chaptercontact;
}
div.chapterreportdescription {
    page-break-before: right;
    page: chapterreportdescription;
}
div.chaptersecondarysource {
    page-break-before: right;
    page: chaptersecondarysource;
}
div.hd {
    font-size:11px;color:#ffffff;width:100%;padding-top:600px;font-weight:600;font-family:Open Sans;
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
<div style="text-align: right; font-weight: bold; font-size: 8pt; font-style: italic;"></div>
</htmlpagefooter>
<htmlpagefooter name="Chapter2FooterEven" style="display:none">
<div style="font-weight: bold; font-size: 8pt; font-style: italic;"></div>
</htmlpagefooter>
<div class="chapterTable">
<div class="hd2" ><h2>TABLE OF CONTENTS</h2></div><p>'.$table_of_content.'</p></div>

'.$html1.'

<div class="chaptersecondarysource">
<div class="hd2"></div>
</div> 

<div class="chapterresearchm1">
<div class="hd2"></div>
</div>

<div class="chapterresearchm2">
<div class="hd2"></div>
</div>

<div class="chapterindussol">
<div class="hd2"></div>
</div>

<div class="chapterclientelec">
<div class="hd2"></div>
</div>
<div class="chapterclientfood">
<div class="hd2"></div>
</div>
<div class="chapterclientlife">
<div class="hd2"></div>
</div>
<div class="chapterclientchem">
<div class="hd2"></div>
</div>

<div class="chapteraboutiarc">
<div class="hd2"></div>
</div>

<div class="chaptercontact">
  <div class="hd2"></div>
</div>

</body></html>';

//echo $html;
//exit;

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