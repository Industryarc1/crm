<?php
	include_once('../../model/dashboardfunction.php');
	$dashFunc = new dashboardfunctions();
	if(isset($_POST['token'])){	
		if($_POST['token']=="getLeadsData"){
			$draw = $_POST['draw'];
			$start = $_POST['start'];
			$rowperpage = $_POST['length']; // Rows display per page
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = $_POST['search']['value']; // Search value
			$todate = $_POST['todate'];
			$fromDate = $_POST['fromdate'];
			
			$leadsData = $dashFunc->getLeads($start,$rowperpage,$columnName,$columnSortOrder,$searchValue,$todate,$fromDate);			
			$array=array();
			foreach($leadsData['result'] as $row)
			{
				$row = array_map('utf8_encode', $row);
				array_push($array,$row);
			}
			//header("Access-Control-Allow-Origin: *");
			//header("Content-Type: application/json; charset=UTF-8");
			$json_data = array(
					"draw"            => intval($draw),   
					"recordsTotal"    => intval($leadsData['total']),  
					"recordsFiltered" => intval($leadsData['searchTotal']),
					"data"            => $array   // total data array
					);
			echo json_encode($json_data);
		}
		
		if($_POST['token']=="getLeadByCountry"){
			$date = date('Y-m-d');
			$last = $_POST['number'];			
			$dateArray = array('1'=>'day','2'=>'week','3'=>'month','4'=>'year');
			$dateFil = $dateArray[$_POST['duration']];
			$fromDate = date('Y-m-d', strtotime("- $last $dateFil"));
			$datefilter = array('from_date'=>$fromDate,'to_date'=>$date);
			if($_POST['number']==""){
				$leadsByCountry = $dashFunc->getLeadsGroupByCountry();
			}else{
				$leadsByCountry = $dashFunc->getLeadsGroupByCountryByDate($datefilter);
			}
			
			$array=array();
			foreach($leadsByCountry as $row)
			{
				$row = array_map('utf8_encode', $row);
				array_push($array,$row);
			}			
			echo json_encode($array);
		}
		
		if($_POST['token']=="getLeadByCountryByDateFilter"){
			$date = date('Y-m-d');
			$todate = $_POST['todate'];
			$fromDate = $_POST['fromdate'];
			$datefilter = array('from_date'=>$fromDate,'to_date'=>$todate);
			if($_POST['fromdate']==""){
				$leadsByCountry = $dashFunc->getLeadsGroupByCountry();
			}else{
				$leadsByCountry = $dashFunc->getLeadsGroupByCountryByDate($datefilter);
			}
			
			$array=array();
			foreach($leadsByCountry as $row)
			{
				$row = array_map('utf8_encode', $row);
				array_push($array,$row);
			}			
			echo json_encode($array);
		}
		
		if($_POST['token']=="getLeadByDomain"){
			$date = date('Y-m-d');
			$last = $_POST['number'];			
			$dateArray = array('1'=>'day','2'=>'week','3'=>'month','4'=>'year');
			$dateFil = $dateArray[$_POST['duration']];
			$fromDate = date('Y-m-d', strtotime("- $last $dateFil"));
			$datefilter = array('from_date'=>$fromDate,'to_date'=>$date);
			if($_POST['number']==""){
				$leadsByDomain = $dashFunc->getLeadsGroupByDomain();
			}else{
				$leadsByDomain = $dashFunc->getLeadsGroupByDomainByDate($datefilter);
			}
			
			$array=array();
			foreach($leadsByDomain as $row)
			{
				$row = array_map('utf8_encode', $row);
				array_push($array,$row);
			}			
			echo json_encode($array);
		}
		
		if($_POST['token']=="getLeadByDomainByDateFilter"){
			$date = date('Y-m-d');
			$todate = $_POST['todate'];
			$fromDate = $_POST['fromdate'];
			$datefilter = array('from_date'=>$fromDate,'to_date'=>$todate);
			if($_POST['fromdate']==""){
				$leadsByDomain = $dashFunc->getLeadsGroupByDomain();
			}else{
				$leadsByDomain = $dashFunc->getLeadsGroupByDomainByDate($datefilter);
			}
			
			$array=array();
			foreach($leadsByDomain as $row)
			{
				$row = array_map('utf8_encode', $row);
				array_push($array,$row);
			}			
			echo json_encode($array);
		}
		
		if($_POST['token']=="getLeadsCount"){
			$leadsCount = $dashFunc->getAllLeadsCount();
			$array=array();
			$row = array_map('utf8_encode', $leadsCount);
			array_push($array,$row);			
			echo json_encode($array);
		}
		
	}else{
		echo "failed";
	}
?>