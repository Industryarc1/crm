<?php
$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
if(isset($_POST['email']) && preg_match($regex, $_POST['email']) && $_POST['email']!=""){
		include_once('../../model/function.php');
		$functions = new functions();
		$date = date("Y-m-d H:i:s");
		
		$name = explode(" ",$_POST['name']);
		$fname = $name[0];
		$lname = $name[1];
		
		$whr=array('email'=>$_POST['email']);
	   $exitdata=$functions->getleadbyFilter($whr);
	   
	   $diffReportLeadIds = "";
		foreach($exitdata as $row1){
			$diffReportLeadIds = $row1['id'];
		}
		
	   $arrCount = count($exitdata);
	   if($arrCount>=1){
			$sameLeadWithSameReport = 0;
			$sameLeadWithDiffReport = $diffReportLeadIds;
	   }else{
		  $sameLeadWithSameReport = 0;
		  $sameLeadWithDiffReport = 0;
	   }	   
		
		//if(isset($_POST['lead_generation_channel']) && $_POST['lead_generation_channel']=="IARC-Inbound"){
			$leadGenerationChannelId = 1;
		//}elseif(isset($_POST['lead_generation_channel']) && $_POST['lead_generation_channel']=="MIR-Inbound"){
			//$leadGenerationChannelId = 3;
		//}
		
		$leadStageId = 2;
		
		$data = array('associated_id'=>0,'seo_associated_id'=>0,'fname'=>$fname,'lname'=>$lname,'job_title'=>'','email'=>$_POST['email'],'company'=>'','company_url'=>'','phone_number'=>$_POST['mobile'],'mobile'=>$_POST['mobile'],'lead_stage_id'=>$leadStageId,'lead_generation_channel_id'=>$leadGenerationChannelId,'lead_significance'=>'m.v','department'=>'','entry_point'=>'QurioBot','txt_comments'=>$_POST['requirements']."<br>".$_POST['comments']."<br>Urgency : ".$_POST['urgency'],'report_code'=>'','report_name'=>$_POST['report']." - ".$_POST['regional'],'category'=>'','sub_category'=>'','title_related_my_company'=>'','created'=>$date,'same_lead_report'=>$sameLeadWithSameReport,'same_lead_dif_report'=>$sameLeadWithDiffReport,'country'=>'');
		
		$leadId = $functions->insertLeads($data);
		echo $leadId;
		
		$to="sales@industryarc.com";
		//$to="vishwadeep.singh@industryarc.com";
        $subject="Lead From ChatBot";
        $message=' <div class="col-sm-3">
                    <h5>Dear Sales Team,</h5>
                </div>
                 <div class="col-sm-8">
                    <p><br>Below are the details of client who came from chatbot.</p>
                     <div class="row" style="border-radius:0.4em;font-family:Arial;font-size:13px;background-color:#eee">
					<table width="100%" cellpadding="5" cellspacing="5">
					<tr style="border-bottom:1px solid #CCC; ">
					<td width="20%">First Name</td>
					<td width="1%">:</td>
					<td width="78%">'.$fname.'</td>
					</tr>
					<tr>
					<td width="20%">Last Name</td>
					<td width="1%">:</td>
					<td width="78%">'.$lname.'</td>
					</tr>
					<tr>
					<td width="20%">Email</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['email'].'</td>
					</tr>
					<tr>
					<td width="20%">Contact Number</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['mobile'].'</td>
					</tr>
					<tr>
					<td width="20%">Interest</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['report'].'</td>
					</tr>
					<tr>
					<td width="20%">Regional</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['regional'].'</td>
					</tr>
					<tr>
					<td width="20%">Requirement</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['requirements'].'</td>
					</tr>
					<tr>
					<td width="20%">Comments</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['comments'].'</td>
					</tr>
					<tr>
					<td width="20%">Urgency</th>
					<td width="1%">:</td>
					<td width="78%">'.$_POST['urgency'].'</td>
					</tr>

					</table>
					</div>
                </div>
                <div class="col-sm-3">
                    <br>Thanks,<br>
                   <strong>IndustryArc</strong>
                </div>';
		
		require_once('../../PHPMailer/class.phpmailer.php');
        $m_user="salesiarc123@gmail.com";
        $m_pass="iarc@123";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $m_user;
        $mail->Password = $m_pass;
        $mail->SetFrom($m_user, "IndustryArc");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        $mail->AddBCC("vishwadeep.singh@industryarc.com");
        $mail->Send();
}else{
	echo "failed";
}
?>