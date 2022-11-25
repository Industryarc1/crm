<?php
require_once 'vendor/autoload.php';

$mpdf = new mPDF();

// Write some HTML code:
$mpdf->Image('00.jpg',0,0,210,297,'jpg','',true, false);

$mpdf->WriteHTML('<h1>Hello World</h1><br><p>My first PDF with mPDF</p>');

// Output a PDF file directly to the browser
$mpdf->Output();
?>
