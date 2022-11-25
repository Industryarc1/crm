<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if(isset($_POST['token']) && $_POST['token']=="deeptest"){
		include_once('../../model/function.php');
		$functions = new functions();
		$date = date("Y-m-d H:i:s");
		
		$whr=array('email'=>$_POST['email']);
	   $exitdata=$functions->getleadbyFilter($whr);
	   
	   $diffReportLeadIds = "";
		foreach($exitdata as $row1){
			$diffReportLeadIds = $row1['id'];
		}
		
	   $arrCount = count($exitdata);
	   if($arrCount>=1){
			$whr=array('email'=>$_POST['email'],'report_code'=>$_POST['hidReportCode']);
			$reportdata=$functions->getleadbyFilter($whr);

			$sameReportLeadIds = "";
			foreach($reportdata as $row){
				$sameReportLeadIds = $row['id'];
			}

			$Count = count($reportdata);
			if($Count>=1){
				$sameLeadWithSameReport = $sameReportLeadIds;
				$sameLeadWithDiffReport = 0;
			}else{
				$sameLeadWithSameReport = 0;
				$sameLeadWithDiffReport = $diffReportLeadIds;
			}
	   }else{
		  $sameLeadWithSameReport = 0;
		  $sameLeadWithDiffReport = 0;
	   }	   
		
		$leadSource = !empty($_POST['lead_source'])?$_POST['lead_source']:'';
		
		if(isset($_POST['lead_generation_channel']) && $_POST['lead_generation_channel']=="IARC-Inbound"){
			if($leadSource!=''){
				$leadGenerationChannelId = 6;
			}else{
				$leadGenerationChannelId = 1;
			}
		}elseif(isset($_POST['lead_generation_channel']) && $_POST['lead_generation_channel']=="MIR-Inbound"){
			$leadGenerationChannelId = 3;
		}
		
		$leadStageId = 2;		
		
		$data = array('associated_id'=>0,'seo_associated_id'=>0,'fname'=>$_POST['f_name'],'lname'=>$_POST['l_name'],'job_title'=>$_POST['job_title'],'email'=>$_POST['email'],'company'=>$_POST['company'],'company_url'=>$_POST['company_url'],'phone_number'=>$_POST['phonenumber'],'mobile'=>$_POST['phonenumber'],'lead_stage_id'=>$leadStageId,'lead_generation_channel_id'=>$leadGenerationChannelId,'lead_significance'=>'m.v','manager_id'=>'','seo_manager_id'=>'','assign_manager'=>'','department'=>$_POST['hidCatName'],'entry_point'=>$_POST['entry_point'],'txt_comments'=>$_POST['txtComments'],'report_code'=>$_POST['hidReportCode'],'report_name'=>$_POST['hidReportName'],'category'=>$_POST['hidCatName'],'sub_category'=>$_POST['hidSubCatName'],'title_related_my_company'=>$_POST['TitlesRelatedMyCompany'],'created'=>$date,'twitter_username'=>'','same_lead_report'=>$sameLeadWithSameReport,'same_lead_dif_report'=>$sameLeadWithDiffReport,'country'=>$_POST['txtCountry'],'no_of_pages'=>$_POST['noofpages'],'pub_date'=>$_POST['pub_date'],'timezonepicker'=>$_POST['timezonepicker'],'speak_to_analyst'=>$_POST['speak_to_analyst'],'status'=>1,'lead_source'=>$leadSource);
		
		$leadId = $functions->insertLeads($data);
		echo $leadId;
}else{
	echo "failed";
}
?>