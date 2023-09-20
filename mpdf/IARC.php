<?php
// if (!isset($_REQUEST['html'])) { $_REQUEST['html'] = ''; }
require_once 'vendor/autoload.php';
// include("../mpdf.php");
$mpdf=new mPDF(''); 
//==============================================================
$mpdf->SetHeader('<img src="header.png" class="" alt="">');

$mpdf->SetFooter('Document Title');

$mpdf->defaultheaderfontsize=10;

$mpdf->defaultheaderfontstyle='B';

$mpdf->defaultheaderline=0;

$mpdf->defaultfooterfontsize=10;

$mpdf->defaultfooterfontstyle='BI';

$mpdf->defaultfooterline=0;
$html = '
<style>
@page {
  size: auto;
  odd-header-name: html_myHeader1;
  even-header-name: html_myHeader2;
  odd-footer-name: html_myFooter1;
  even-footer-name: html_myFooter2;
}
@page chapter {
    odd-header-name: html_Chapter2HeaderOdd;
    even-header-name: html_Chapter2HeaderEven;
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
}
@page noheader {
    odd-header-name: _blank;
    even-header-name: _blank;
    odd-footer-name: _blank;
    even-footer-name: _blank;
}
@page :first {
  margin: 10%; 
  padding:10% 0;
  margin-header: 5mm;
  margin-footer: 5mm;
  background:url(background.png)  50% 0 repeat;
}
div.chapter {
    page-break-before: right;
    page: chapter;
}
div.noheader {
    page-break-before: right;
    page: noheader;
}
.shadowtitle {margin-top:300px;}
.shadowtitle h3 {color:#333;}
</style>
<body>
<div class="noheader">
<h3 style="width:100%;float:left;margin-top:300px;">Wearable Medical Devices Market: By Type (Therapeutic Wearable Devices, Diagnostic Devices, Vital Sign Monitoring Devices, Others) Application (Home Health Care, Remote Patient Monitoring, Fitness And Sports, Others) & Geography-Forecast (2017-2022)</h3>
</div>

<htmlpageheader name="Chapter2HeaderOdd" style="display:none">

<div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">Chapter 2</div>

</htmlpageheader>

<htmlpageheader name="Chapter2HeaderEven" style="display:none">

<div style="border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">Chapter 2</div>

</htmlpageheader>

<htmlpagefooter name="Chapter2FooterOdd" style="display:none">

<div style="text-align: right; font-weight: bold; font-size: 8pt; font-style: italic;">Chapter 2 Footer</div>

</htmlpagefooter>

<htmlpagefooter name="Chapter2FooterEven" style="display:none">

<div style="font-weight: bold; font-size: 8pt; font-style: italic;">Chapter 2 Footer</div>

</htmlpagefooter>
';
//==============================================================
// if (isset($_REQUEST['html']) && $_REQUEST['html']) { echo $html; exit; }
//==============================================================
$mpdf->WriteHTML($html);
$mpdf->Output(); 
exit;
?>