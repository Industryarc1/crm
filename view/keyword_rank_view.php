<?php
session_start();
ini_set("display_errors",1);
if(isset($_GET['domain'])) {
    $projectid = $_GET['domain'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.brandoverflow.com/v1/rank-tracker/5f338dd76f4a210012e07b06Ep5BHTVSPPOvaAl3gI3erwL7bARKRG/$projectid",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$results = json_decode($response);
	$countArray = array();
	foreach($results->keywords as $row){
		$countArray[] = $row->organicStats->today;
	}
	$count = array_count_values($countArray);
}
?>

<table>
	<tr>
		<td><b>Top3 : </b>&nbsp;&nbsp; <?php echo (isset($count[1])?$count[1]:0)+(isset($count[2])?$count[2]:0)+(isset($count[3])?$count[3]:0);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><b>Top5 : </b>&nbsp;&nbsp;<?php echo (isset($count[4])?$count[4]:0)+(isset($count[5])?$count[5]:0);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><b>Top10 : </b>&nbsp;&nbsp;<?php echo (isset($count[6])?$count[6]:0)+(isset($count[7])?$count[7]:0)+(isset($count[8])?$count[8]:0)+(isset($count[9])?$count[9]:0)+(isset($count[10])?$count[10]:0);?></td>
	</tr>
</table>

<br>

<table class="table table-responsivetable table-report" id="example">
	<thead>
	<tr>
		<th>Keyword</th>
		<th>Today</th>
		<th>Yesterday</th>
		<th>Change</th>
		<th>Created</th>
		<th>Url</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($results->keywords as $result){?>
	<tr>
		<td><?php echo $result->keywordData; ?></td>
		<td><?php echo $result->organicStats->today; ?></td>
		<td><?php echo $result->organicStats->yesterday; ?></td>                 
		<td><?php echo $result->organicStats->change; ?></td>                 
		<td><?php echo $result->createdAt; ?></td>                 
		<td><?php echo $result->organicStats->url; ?></td>                 
	</tr>
	<?php } ?>
	</tbody>
</table>

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
