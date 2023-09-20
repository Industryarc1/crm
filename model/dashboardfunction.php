<?php
class dashboardfunctions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }
	
	function getLeads($start,$rowperpage,$columnName,$columnSortOrder,$searchValue,$todate,$fromdate)
    {
		$orderBy = " ORDER BY $columnName $columnSortOrder";
		$limit = " LIMIT $start,$rowperpage";
		$con = "";		

		if($fromdate!=""){
			if($searchValue != ""){
				$con = " WHERE MATCH (fname,lname,company,email,mobile,department,country) AGAINST ('%$searchValue%') and date(created) between '$fromdate' and '$todate'";
			}else{
				$con = " WHERE date(created) between '$fromdate' and '$todate'";
			}
		}else{
			if($searchValue != ""){
				$con = " WHERE MATCH (fname,lname,company,email,mobile,department,country) AGAINST ('%$searchValue%')";
			}else{
				$con = "";
			}
		}
		
		$leadQuery = "SELECT fname,lname,company,job_title,email,phone_number,mobile,department,country FROM leads";
		$leadQuery = $leadQuery.$con.$orderBy.$limit;
        $result = $this->dbObject->getAllRows($leadQuery);
		
		//$leadCount = "SELECT count(*) as tot FROM leads";
        //$count = $this->dbObject->getRow($leadCount);
		
		$leadQuery1 = "SELECT fname,lname,company,job_title,email,phone_number,mobile,department,country FROM leads";
		$leadQuery2 = $leadQuery1.$con.$orderBy;
		$result1 = $this->dbObject->getAllRows($leadQuery2);
		
		$data['total'] = count($result1);
		$data['searchTotal'] = count($result1);
		$data['result'] = $result;
		
        return $data;
    }
	
	function getLeadsGroupByCountry()
    {
		$leadQuery = "SELECT country,COUNT(*) AS tot FROM leads where country<>'' GROUP BY country ORDER BY tot DESC LIMIT 10";
        $result = $this->dbObject->getAllRows($leadQuery);
        return $result;
    }
	
	function getLeadsGroupByCountryByDate($data)
    {
		$fromdate = $data['from_date'];
		$todate = $data['to_date'];
		$leadQuery = "SELECT country,COUNT(*) AS tot FROM leads where country<>'' and date(created) between '$fromdate' and '$todate' GROUP BY country ORDER BY tot DESC LIMIT 10";
        $result = $this->dbObject->getAllRows($leadQuery);
        return $result;
    }
	
	function getLeadsGroupByDomain()
    {
		$leadQuery = "SELECT department,COUNT(*) as tot from leads GROUP BY department";
        $result = $this->dbObject->getAllRows($leadQuery);
        return $result;
    }
	
	function getLeadsGroupByDomainByDate($data)
    {
		$fromdate = $data['from_date'];
		$todate = $data['to_date'];
		$leadQuery = "SELECT department,COUNT(*) as tot from leads where date(created) between '$fromdate' and '$todate' GROUP BY department";
        $result = $this->dbObject->getAllRows($leadQuery);
        return $result;
    }
	
	function getAllLeadsCount()
    {
		$leadQuery = "SELECT COUNT(*) as tot from leads";
        $result = $this->dbObject->getRow($leadQuery);
        return $result;
    }

    function getLeadsByFilterData($filter)
    {
		$cond = "";
		if($filter['company']){
			$company = $filter['company'];
			$cond .= "AND company like '%$company%'";
		}
		if($filter['job']){
			$job = $filter['job'];
			$cond .= "AND job_title like '%$job%'";
		}
		if($filter['domain']){
			$domain = $filter['domain'];
			$cond .= "AND department like '%$domain%'";
		}
		if($filter['country']){
			$country = $filter['country'];
			$cond .= "AND country like '%$country%'";
		}
		$cond = ltrim($cond,"AND");
		if($cond != ""){
			$leadQuery = "SELECT fname,lname,company,job_title,email,phone_number,mobile,department,country FROM leads where ".$cond;
		}else{
			$leadQuery = "SELECT fname,lname,company,job_title,email,phone_number,mobile,department,country FROM leads";
		}
        $result = $this->dbObject->getAllRows($leadQuery);
        return $result;
    }

}
?>
