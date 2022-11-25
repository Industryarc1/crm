<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
ini_set('max_execution_time', 0);

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
//$columnIndex = $_POST['order'][0]['column']; // Column index
//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$search="";
if($searchValue !=""){
$search= " WHERE MATCH(f_name,l_name,company,country,designation,phone_two,email,city,state,linkedin_url,total_revenue,employee_size) AGAINST('".$searchValue."')";
/*$search="where f_name LIKE '".$searchValue."%'";
$search="where l_name LIKE '".$searchValue."%'";
$search.="OR designation LIKE '".$searchValue."%'";
$search.="OR country LIKE '".$searchValue."%'";
$search.="OR company LIKE '".$searchValue."%'";
$search.="OR phone_two LIKE '".$searchValue."%'";
$search.="OR email LIKE '".$searchValue."%'";*/
}


//$conn = mysqli_connect("localhost","mirdb","Mirgpc@123");
$conn = mysqli_connect("localhost","mirdb","=C#exAr9ex87t02gtVPr8HQmGpqnZxhg");

mysqli_select_db($conn,"iarc-crmdb-live");

$tnr=mysqli_query($conn,"select `f_name` from contacts ".$search);
$totalRecords= mysqli_num_rows($tnr);

$dd=mysqli_query($conn,"select `f_name`,`l_name`,`company`,`designation`,`email`,`country`,`phone_two`,`url`,`total_revenue`,`employee_size` from contacts ".$search." LIMIT ".$row." ,".$rowperpage." ");
$totalRecords1= mysqli_num_rows($dd);

$array=[];
while ($rows = mysqli_fetch_array($dd)) {
$array[] = array(
"f_name"=>$rows["f_name"],
"l_name"=>$rows["l_name"],
"email"=>$rows["email"],
"country"=>$rows["country"],
"company"=>$rows["company"],
"designation"=>$rows["designation"],
"phone_two"=>$rows["phone_two"],
"total_revenue"=>$rows["total_revenue"],
"employee_size"=>$rows["employee_size"],
"url"=>$rows["url"]
);

//$rows = array_map('utf8_encode', $rows);
//array_push($array,$rows);
}

$json_data = array(
"draw" => intval($draw),
"recordsTotal" => intval($totalRecords1),
"recordsFiltered" => intval($totalRecords),
"data" => $array // total data array
);
echo json_encode($json_data);
//echo json_encode($conn);
?>
