<?php
//echo "<pre>";
//print_r($leadStageForChart);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChartStage);
google.charts.setOnLoadCallback(drawChartLeadSales);
google.charts.setOnLoadCallback(drawChartLeadQuality);

function drawChartStage() {
	var data = google.visualization.arrayToDataTable([
		['Lead Stages','Total'],
		['Other',<?php echo ($leadStageForChart[0]['tot'])?$leadStageForChart[0]['tot']:0;?>],
		['Hot',<?php echo ($leadStageForChart[1]['tot'])?$leadStageForChart[1]['tot']:0;?>],
		['Cold',<?php echo ($leadStageForChart[2]['tot'])?$leadStageForChart[2]['tot']:0;?>],
		['Closed',<?php echo ($leadStageForChart[3]['tot'])?$leadStageForChart[3]['tot']:0;?>],
		['Dead',<?php echo ($leadStageForChart[4]['tot'])?$leadStageForChart[4]['tot']:0;?>],
		['Warm',<?php echo ($leadStageForChart[5]['tot'])?$leadStageForChart[5]['tot']:0;?>],
		['Lost',<?php echo ($leadStageForChart[6]['tot'])?$leadStageForChart[6]['tot']:0;?>],
		['Junk',<?php echo ($leadStageForChart[7]['tot'])?$leadStageForChart[7]['tot']:0;?>]
	]);

	var options = {
	  title: 'Lead Status',
	  width: 550,
      height: 350
	};

	var chart = new google.visualization.PieChart(document.getElementById('leadStatus'));

	chart.draw(data, options);
}

function drawChartLeadSales() {
	var data = google.visualization.arrayToDataTable([
          ['Month', 'Leads', 'Sales ($)'],
          ['Jan',  <?php echo ($leadsSalesForChart[0]['totleads']!="")?$leadsSalesForChart[0]['totleads']:0; ?>,<?php echo ($leadsSalesForChart[0]['totsales']!="")?$leadsSalesForChart[0]['totsales']:0; ?>],
          ['Feb',  <?php echo ($leadsSalesForChart[1]['totleads']!="")?$leadsSalesForChart[1]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[1]['totsales']!="")?$leadsSalesForChart[1]['totsales']:0; ?>],
          ['Mar',  <?php echo ($leadsSalesForChart[2]['totleads']!="")?$leadsSalesForChart[2]['totleads']:0; ?>,       <?php echo ($leadsSalesForChart[2]['totsales']!="")?$leadsSalesForChart[2]['totsales']:0; ?>],
          ['Apr',  <?php echo ($leadsSalesForChart[3]['totleads']!="")?$leadsSalesForChart[3]['totleads']:0; ?>,       <?php echo ($leadsSalesForChart[3]['totsales']!="")?$leadsSalesForChart[3]['totsales']:0; ?>],
          ['May',  <?php echo ($leadsSalesForChart[4]['totleads']!="")?$leadsSalesForChart[4]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[4]['totsales']!="")?$leadsSalesForChart[4]['totsales']:0; ?>],
          ['Jun',  <?php echo ($leadsSalesForChart[5]['totleads']!="")?$leadsSalesForChart[5]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[5]['totsales']!="")?$leadsSalesForChart[5]['totsales']:0; ?>],
          ['July',  <?php echo ($leadsSalesForChart[6]['totleads']!="")?$leadsSalesForChart[6]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[6]['totsales']!="")?$leadsSalesForChart[6]['totsales']:0; ?>],
          ['Aug',  <?php echo ($leadsSalesForChart[7]['totleads']!="")?$leadsSalesForChart[7]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[7]['totsales']!="")?$leadsSalesForChart[7]['totsales']:0; ?>],
          ['Sep',  <?php echo ($leadsSalesForChart[8]['totleads']!="")?$leadsSalesForChart[8]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[8]['totsales']!="")?$leadsSalesForChart[8]['totsales']:0; ?>],
          ['Oct',  <?php echo ($leadsSalesForChart[9]['totleads']!="")?$leadsSalesForChart[9]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[9]['totsales']!="")?$leadsSalesForChart[9]['totsales']:0; ?>],
          ['Nov',  <?php echo ($leadsSalesForChart[10]['totleads']!="")?$leadsSalesForChart[10]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[10]['totsales']!="")?$leadsSalesForChart[10]['totsales']:0; ?>],
          ['Dec',  <?php echo ($leadsSalesForChart[11]['totleads']!="")?$leadsSalesForChart[11]['totleads']:0; ?>,      <?php echo ($leadsSalesForChart[11]['totsales']!="")?$leadsSalesForChart[11]['totsales']:0; ?>]
        ]);

        var options = {
          title: 'Leads vs Sales',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
		  series: {0: {targetAxisIndex:0},
                   1:{targetAxisIndex:1},
                   2:{targetAxisIndex:1},
                  }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('leadCount'));
        chart.draw(data, options);
}

function drawChartLeadQuality() {
	var token = "chart-gen";
	$.ajax({
         type: "POST",
         url: 'olamp/olamp_ajax.php',
         data: ({token: token}),
         success: function(result){
			 let obj = JSON.parse(result);
			 $("#leadLqs").html(Math.floor(obj.avglqs*100)/100);
			 var data = google.visualization.arrayToDataTable([
						['Lead Quality','Total'],
						['Low',obj.Low],
						['Med',obj.Med],
						['Hig',obj.High]
					]);

					var options = {
					  title: 'Lead Quality',
							width: 550,
						height: 400
					};
					var chart = new google.visualization.PieChart(document.getElementById('leadQuality'));
					chart.draw(data, options);
         }
     });	
}

</script>