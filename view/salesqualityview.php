<?php
session_start();
ini_set("display_errors",0);
include_once('../model/function.php');
$functions = new functions();
include_once('../model/olampmodel.php');
$olampModel = new olampModels();
$pipeLineDealStages = array('0'=>'Lost','1'=>'requiremnet shared','2'=>'Proposal Shared','3'=>'Quotation Approved','4'=>'Deal Closed');
$leadStages=array('1'=>'Hot','2'=>'Cold','3'=>'Closed','4'=>'Dead','5'=>'Warm','6'=>'Lost','7'=>'Junk');
//$pipeLineData = $olampModel->getPipeLineDataByLeadId(18174);
if(isset($_GET['fromdate']) && isset($_GET['todate']) && isset($_GET['assignedto'])){
    $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
    $todate = date("Y-m-d",strtotime($_GET['todate']));
	$assignTo = $_GET['assignedto'];
    $leads=$olampModel->getLeadsbyAssigntoAssignFromAndToDate($fromdate,$todate,$assignTo);
}
?>
<div class="row" style="margin-top: 10px;">
    <div class="col-sm-12" style="padding: 0;">
            <table class="table table-responsivetable-borderless table-report" id="example">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Ranking</th>
                    <th>LQS</th>
                    <th>Days-Assigned</th>
                    <th>Sample Shared</th>
                    <th>Mails</th>
                    <th>Calls</th>
                    <!--<th>Scheduled Call</th>-->
                    <th>EST Budget</th>
                    <th>Price Quoted</th>
                    <th>Purchasing Time</th>
                    <th>Final Approval</th>
					<th>B Score</th>
                    <th>Cold</th>                    
                    <th>Dead</th>
                    <th>Warm</th>
                    <th>Closed</th>
                    <th>C Score</th>
                    <th>B + C</th>
					<th>Lead Score</th>
                </tr>
                </thead>
                <?php 
				$lqsTot = 0; $bScoreTot = 0; $cScoreTot = 0; $totScoreTot = 0;
				foreach($leads as $lead){
					$threeCXmobile = str_replace(['+','-','.',' '],"",$lead['phone_number']);					
					if(strlen($lead['phone_number'])>5){
					   if($threeCXmobile!=""){
						   $noCalls = $olampModel->get3CXCallsByPhoneNumber($threeCXmobile);
					   }else{
						   $noCalls['tot'] = 0;
					   }
				   }else{
					   $noCalls['tot'] = 0;
				   }
				   
					$pipeLineData = $olampModel->getPipeLineDataByLeadId($lead['id']);
					$noMails = $olampModel->getNotesByLeadId($lead['id']);
					$stagePointCold=0;$stagePointDead=0;$stagePointWarm=0;$stagePointClosed=0;
					if($lead['lead_stage_id']==5){$stagePointWarm=4;}
					if($lead['lead_stage_id']==3){$stagePointClosed=10;}
					$mailPoint = 0; $callPoints = 0; $estBudgetPoint = 0; $finalDealAmtPoint = 0; $finalDealClosurePoint = 0;
					$approvalAuthpoint = 0;
					if($noMails['tot']!="" || $noMails['tot']!="0"){$mailPoint=2*$noMails['tot'];}
					if($noCalls['tot']!="" || $noCalls['tot']!="0"){$callPoints=2*$noCalls['tot'];}
					if($pipeLineData['deal_amount']!=""){$estBudgetPoint=1;}
					if($pipeLineData['final_deal_amount']!=""){$finalDealAmtPoint=4;}
					if($pipeLineData['final_deal_closure']!=""){$finalDealClosurePoint=2;}
					if($lead['approval_autority']!=""){$approvalAuthpoint=1;}
					
					$dealStage = ($pipeLineData['deal_stage']!="")?$pipeLineData['deal_stage']:$pipeLineData['final_deal_stage'];
				?>
                <tr>
					<td><?php echo $lead['fname']." ".$lead['lname'];?></td>
                    <td><?php echo $lead['email']?></td>
                    <td><?php $lqs=$olampModel->getLeadQualityEvaluation($lead['id']);echo $lqs['leadquality'];?></td>
                    <td><?php echo $lqs['lqs'];?></td>
                    <td><?php echo $datediff = round((time()-strtotime($lead['lead_assigned_date']))/(60*60*24));?></td>
                    <td><?php echo $pipeLineDealStages[$dealStage]; ?></td>
                    <td><?php echo $noMails['tot'];?></td>
                    <td><?php echo $noCalls['tot'];?></td>
                    <!--<td><?php echo "Scheduled Call";?></td>-->
                    <td><?php echo $pipeLineData['deal_amount'];?></td>
                    <td><?php echo $pipeLineData['final_deal_amount'];?></td>
                    <td><?php echo $pipeLineData['final_deal_closure'];?></td>
                    <td><?php echo $lead['approval_autority'];?></td>
					<td><?php echo $bScore = $mailPoint+$callPoints+$estBudgetPoint+$finalDealAmtPoint+$finalDealClosurePoint+$approvalAuthpoint;?></td>
					<td><?php echo $stagePointCold;?></td>
					<td><?php echo $stagePointDead;?></td>
					<td><?php echo $stagePointWarm;?></td>
					<td><?php echo $stagePointClosed;?></td>
					<td><?php echo $cScore = $stagePointCold+$stagePointDead+$stagePointWarm+$stagePointClosed;?></td>
					<td><?php echo $totScore = $bScore+$cScore;?></td>
					<td><?php echo $lScore = floor((($bScore+$cScore)/$lqs['lqs'])*100)/100;?></td>                    
                </tr>
                <?php 
					$lqsTot = $lqsTot + $lqs['lqs'];
					$bScoreTot = $bScoreTot + $bScore;
					$cScoreTot = $cScoreTot + $cScore;
					$totScoreTot = $totScoreTot + $lScore;
				} 
				?>
            </table>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
	Total B Score : <?php echo $bScoreTot; ?> <br>
	Total C Score : <?php echo $cScoreTot; ?> <br>
	Total LQS : <?php echo $lqsTot; ?> <br>
	Total Score((B+C)/LQS) : <?php echo floor((($bScoreTot+$cScoreTot)/$lqsTot)*100)/100; ?> 
</div>
<script>
    $( document ).ready(function() {
        $('#example').DataTable( {
           // "pageLength": 10,
		   //"order": [[ 9, "desc" ]],
		   "ordering": false,
		   "scrollX": true,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','pdf','print']
        });
    });
</script>