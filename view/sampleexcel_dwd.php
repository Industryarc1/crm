<?php
$dataHeader =[['Report Code','Website','Url','Type of Activity','Do Follow']];
$data =[['AGR 0009','theexpresswire.com','https://www.theexpresswire.com/pressrelease/Compensation-Management-Software-Market-Estimated-to-Reach-23-Million-by-2025_11848632','Paid Press Release','1']];
$result = array_merge($dataHeader,$data);
//print_r($dataHeader);exit;
array_to_csv_download($result,"sample.csv");

function array_to_csv_download($array, $filename = "sample.csv", $delimiter=",") {
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'";');
  $f = fopen('php://output', 'w');
      foreach ($array as $line) {
          fputcsv($f, $line, $delimiter);
      }
}
exit;
?>
