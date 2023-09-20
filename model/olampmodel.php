<?php
class olampModels
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
    }
	
	function getLeadQualityEvaluation($leadId){
		$leadInfo = $this->getLeadInfoByLeadId($leadId);
		$jobTitle = strtolower($leadInfo['job_title']);
		$email = $leadInfo['email'];
		$entryPoint = $leadInfo['entry_point'];
		$trmc = $leadInfo['title_related_my_company'];
		$txtComments = strlen($leadInfo['txt_comments']);
		$leadRevenue = $this->getLeadCompanyRevenueAndEmpSize($email);
		$revenue = $leadRevenue['total_revenue'];
		$empSize = $leadRevenue['employee_size'];

		$getRevenuePoint = $this->getRevenuePoints($revenue);
		$getEmpSizePoint = $this->getEmpSizePoints($empSize);
		$getInqueryBeforePurchasePoint = ($entryPoint=="RBB" || $entryPoint=="Inquiry before Purchase" || $entryPoint=="Inquiry Before Buying")?5:0;

		$getSeniorityPoint = 0;
		if(preg_match('[director|vice president|president|ceo|chief]', $jobTitle)){
			$getSeniorityPoint = 5;
		}elseif(preg_match('[manager]', $jobTitle)){
			$getSeniorityPoint = 2.5;
		}else{
			$getSeniorityPoint = 1;
		}

		$getSampleBrochhurePoint = 0;
		if(preg_match('[sample brochrue|sample brochure|sample request]', strtolower($entryPoint))){
			if($txtComments<5){
				$getSampleBrochhurePoint = 1;
			}else{
				if($trmc=="No"){
					$getSampleBrochhurePoint = 2.5;
				}else{
					$getSampleBrochhurePoint = 3.5;
				}		
			}
		}else{
			$getSampleBrochhurePoint = 0;
		}

		$leadValue = $getRevenuePoint+$getEmpSizePoint+$getInqueryBeforePurchasePoint+$getSeniorityPoint+$getSampleBrochhurePoint;
		$lqs = $leadValue*0.4;
		$leadQualityEvolution = ($lqs<3)?"Low":(($lqs>=3 && $lqs<7)?"Med":"High");
		return array("leadquality"=>$leadQualityEvolution,"lqs"=>$lqs);
	}

    function getLeadCompanyRevenueAndEmpSize($emailId){
       $email = explode("@",$emailId);
       $emailc = explode(".",$email[1]);
	   $company = $emailc[0];
	   $accQuery = "SELECT employee_size, total_revenue FROM accounts WHERE company_name LIKE '%{$company}%' ORDER BY total_revenue DESC LIMIT 1";
	   $accResult = $this->dbObject->getRow($accQuery);
	   return $accResult;
    }
	
	function getLeadInfoByLeadId($leadId){
	   $whr = array('id'=>$leadId);
       $leadQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
       $leadData = $this->dbObject->getRow($leadQuery);
       return $leadData;
	}
	
	function getRevenuePoints($revenue){
		$points = 0;
		if($revenue > 0 && $revenue < 100){
			$points = 1;
		}elseif($revenue >= 100 && $revenue < 500){
			$points = 2.5;
		}elseif($revenue >= 500 && $revenue < 1000){
			$points = 3.5;
		}elseif($revenue >= 1000){
			$points = 5;
		}
		return $points;
	}
	
	function getEmpSizePoints($empSize){
		$points = 0;
		if($empSize > 0 && $empSize < 50){
			$points = 1;
		}elseif($empSize >= 50 && $empSize < 250){
			$points = 2.5;
		}elseif($empSize >= 250 && $empSize < 500){
			$points = 3.5;
		}elseif($empSize >= 1000){
			$points = 5;
		}
		return $points;
	}
	
	function getPipeLineDataByLeadId($leadId){
	    $whr = array('lead_id'=>$leadId);
        $pipeLineQuery = $this->dbObject->selectQuery('lead_pipeline', '*', $whr, '', '', '', '');
        $pipeLineData = $this->dbObject->getRow($pipeLineQuery);
		$data = array();
		$data['final_lead_stage'] = $pipeLineData['lead_stage_id'];
		$data['final_deal_amount'] = $pipeLineData['exp_deal_amount'];
		$data['final_deal_closure'] = $pipeLineData['exp_deal_closure'];
		$data['final_deal_stage'] = $pipeLineData['deal_stage_id'];
		$data['final_remarks'] = $pipeLineData['remarks'];
		if($pipeLineData['id']!=""){
			$whrlog = array('lead_pipeline_id'=>$pipeLineData['id']);
			$pipeLineLogQuery = $this->dbObject->selectQuery('lead_pipeline_log', '*', $whrlog, 'updated_date', 'ASC', '', '');
			$pipeLineLogData = $this->dbObject->getRow($pipeLineLogQuery);
			$data['lead_stage'] = $pipeLineLogData['lead_stage_id'];
			$data['deal_amount'] = $pipeLineLogData['exp_deal_amount'];
			$data['deal_closure'] = $pipeLineLogData['exp_deal_closure'];
			$data['deal_stage'] = $pipeLineLogData['deal_stage_id'];
			$data['remarks'] = $pipeLineLogData['remarks']; 
		}
		//echo "<pre>";
		//print_r($data);exit;
        return $data;
	}
	
	function getLeadsbyAssigntoAssignFromAndToDate($fromdate,$todate,$assignto){
        if($this->leadGenChannel==""){
            $roleQuery = "SELECT * FROM leads WHERE (lead_assigned_date BETWEEN '$fromdate' AND '$todate') and associated_id=$assignto order by id desc";
        }else{
            $roleQuery = "SELECT * FROM leads WHERE lead_generation_channel_id in ($this->leadGenChannel) AND (lead_assigned_date BETWEEN '$fromdate' AND '$todate') and associated_id=$assignto order by id desc";
        }
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
	
	function getNotesByLeadId($leadId){
       $leadQuery = "select count(*) as tot from notes where lead_id=".$leadId;
       $leadData = $this->dbObject->getRow($leadQuery);
       return $leadData;
	}
	
	function get3CXCallsByLeadId($leadId){
       $leadQuery = "select count(*) as tot from 3cx_calls where lead_id=".$leadId;
       $leadData = $this->dbObject->getRow($leadQuery);
       return $leadData;
	}
	
	function get3CXCallsByPhoneNumber($phone){
	   $leadQuery = "select count(*) as tot from 3cx_calls where phone like '%{$phone}%'";
       $leadData = $this->dbObject->getRow($leadQuery);
       return $leadData;
	}
	
	function getCurrentMonthLeadsDetails(){
		$currentmonth=date("m");
		$currentday=date("d");
		$startdate=date("Y-$currentmonth-01");
		$enddate=date("Y-$currentmonth-$currentday");
        $roleQuery ="SELECT id FROM leads WHERE DATE(created) BETWEEN '$startdate' AND '$enddate'";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }

}
?>

