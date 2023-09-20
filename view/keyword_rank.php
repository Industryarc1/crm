
<?php
include('nav-head.php');
?>
<div class="main-content" xmlns="http://www.w3.org/1999/html">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <h4 style="margin-bottom: 10px;">Filter Keyword Ranking:</h4>
            <div class="row filters-card">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-1">
                            <label>Project:</label>
                        </div>
                       <div class="col-sm-3">
                           <div class="input-group controls">							   
							   <select class="form-control" id="domainprj">
									<option value="">Select Project</option>
									<option value="5f64d609ba6d740012230057">RD-Automotive-US</option>
									<option value="5f65195fb7b77400118f692e">RD-A&I-US</option>
									<option value="5f69eaf7d968000011e05fa6">RD-Aerospace and Defense-US</option>
									<option value="5f68f636ae48db001127ef6c">RD-Electronics-US</option>
									<option value="5f7d91674401da0011db50af">RD-Chemicals-US</option>
									<option value="5f7dc58065deb600114f09c8">RD-Life Sciences and Healthcare-US</option>
									<option value="5f7dd4034401da0011db5a4e">RD-Agriculture-US</option>
									<option value="5f7dd6b597bb7600112f32c0">RD-Consumer Products-US</option>
									<option value="5f7dd80b4401da0011db5be6">RD-Education-US</option>
									<option value="5f7dda7597bb7600112f33ba">RD-Energy and Power-US</option>
									<option value="5f7f55594401da0011db6278">RD-FnB-US</option>
									<option value="5f8009f74401da0011db677d">RD-ICT-US</option>
									<option value="5f60c9bfe5ffbb0011012839">PerRD-Keywords-from-April</option>
								</select>
                           </div>
                       </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary" id="keywordSearch">Search</button>
                        </div>
                   </div>				   
                </div>				
          </div>		  
        </div>
		
		<br>
		<div id="getKeywords"></div>
	  
    </div>
</div>
<?php
include('nav-foot.php');?>
<script>
    $(document).ready(function() {
        $('#keywordSearch').click(function() {
            var domainprjid = $("#domainprj").val();
			if(domainprjid==''){alert("Please select project");exit;}			
			$("#getKeywords").html("Please wait for response");
            $.ajax({
                type: "GET",
                url: 'keyword_rank_view.php',
                data: ({domain:domainprjid}),
                success: function(result){
                   // console.log(result);
                    $("#getKeywords").html(result);
                }
            });
        });

    });
</script>
