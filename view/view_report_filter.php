<?php
session_start();
ini_set("display_errors",0);
//include_once('../model/function.php');
//$functions = new functions();

if(isset($_POST['apitok']) && $_POST['apitok']=="getReport") {
    $fromdate = !empty($_POST['fromdate'])?date("Y-m-d",strtotime($_POST['fromdate'])):'';
    $todate = !empty($_POST['todate'])?date("Y-m-d",strtotime($_POST['todate'])):'';
	//$status = !empty($_POST['status'])?$_POST['status']:'';
	$status = $_POST['status'];
	$lotlof = !empty($_POST['lotlof'])?$_POST['lotlof']:'';
	$toc = !empty($_POST['toc'])?$_POST['toc']:'';
	$rdesc = !empty($_POST['rdesc'])?$_POST['rdesc']:'';
	$title = !empty($_POST['title'])?$_POST['title']:'';
	$domainid = !empty($_POST['domainid'])?$_POST['domainid']:'';
	$post = array('token'=>'GetIarcReportData','status'=>$status,'lotlof'=>$lotlof,'toc'=>$toc,'rdesc'=>$rdesc,'title'=>$title,'department_id'=>$domainid,'fromdate'=>$fromdate,'todate'=>$todate);
	//print_r($post);exit;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.industryarc.com/api/iarcReportCrm.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	$response = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($response,true);
	//echo "<pre>";
	//print_r($result);
    //exit;
}
?>
<div class="row" style="margin-top: 10px;">
    <div class="col-sm-12" style="padding: 0;">
            <table class="table table-responsivetable-borderless table-report" id="example">
                <thead>
                <tr>
					<th>ID</th>
                    <th>Domain</th>
                    <th>Title</th>
                    <th>Code</th>
					<th>Active</th>
                    <th>Description</th>
                    <th>Toc</th>
                    <th>LotLof</th>
                    <th>Update Date</th>
                    <th>Meta Title</th>
                    <th>Meta Keyword</th>
                    <th>Meta Description</th>
                    <th>Breadcrumbs</th>
                    <th>Seo Keyword</th>
                    <th>URL</th>
                </tr>
                </thead>
                <?php foreach($result['data'] as $row){?>
                <tr>
					<td><?php echo $row['dup_inc_id']?></td>
					<td><?php echo $row['name']?></td>
                    <td><?php echo $row['title']?></td>
                    <td><?php echo $row['code']?></td>
                    <td><?php echo $row['status']?></td>
                    <td><?php echo $row['descp']?></td>
                    <td><?php echo $row['toc']?></td>
                    <td><?php echo $row['table_and_figure']?></td>
                    <td><?php echo $row['updated_date']?></td>
                    <td><?php echo $row['meta_title']?></td>
                    <td><?php echo $row['meta_keywords']?></td>
                    <td><?php echo $row['meta_descr']?></td>
                    <td><?php echo $row['cbreadcrumb']?></td>
                    <td><?php echo $row['seo_keyword']?></td>
                    <td><?php echo $row['title_url']?></td>
                </tr>
                <?php } ?>
            </table>
    </div>
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