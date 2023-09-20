<?php
	include('nav-head.php');
	if(isset($_POST['Submit']) && $_POST['Submit']=="get report"){
		$reportcode= $_POST['reportcode'];
		$post = array('token'=>'GetReportByReportCodeForBackendUpdate',
		'code' => $reportcode);
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL, 'https://www.industryarc.com/api/check_title.php');
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($post));
		$response = curl_exec($ch1);
		curl_close($ch1);
		$reportData = json_decode($response);
	}
	if(isset($_POST['Submit']) && $_POST['Submit']=="update report"){
		$postData = array('token'=>'updatereportfromcrm',
		'code' => $_POST['reportcode'],'inc_id' => $_POST['inc_id'],'cat' => $_POST['cat'],'region_type' => $_POST['region_type'],'title' => $_POST['title'],'breadcrumbs' => $_POST['breadcrumbs'],'slp' => $_POST['slp'],'clp' => $_POST['clp'],'status' => $_POST['status'],'curl' => $_POST['curl'],'metatitle' => $_POST['metatitle'],'metakeyword' => $_POST['metakeyword'],'metadesc' => $_POST['metadesc'],'seokeyword' => $_POST['seokeyword'],'atag' => $_POST['atag'],'toc' => base64_encode($_POST['toc']),'lotlof' => base64_encode($_POST['lotlof']),'description' => base64_encode($_POST['rdesc']));

		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL, 'https://www.industryarc.com/api/updatefromcrm.php');
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($postData));
		$result = curl_exec($ch1);
		curl_close($ch1);
		//exit;
	}
?>
<script src="js/iarcback.js" type="text/javascript"></script>
<script type="text/javascript">
	//bkLib.onDomLoaded(nicEditors.allTextAreas);
	bkLib.onDomLoaded(function(){
          var myNicEditor = new nicEditor();
		  myNicEditor.setPanel('toc1');
          myNicEditor.addInstance('toc');
		  myNicEditor.setPanel('lotlof1');
          myNicEditor.addInstance('lotlof');
		  myNicEditor.setPanel('rdesc1');
          myNicEditor.addInstance('rdesc');
    });
	
	function removekeyword(){
		var keyword1 = document.getElementById('dkey').value;
		var keyword = new RegExp(keyword1, "gi");
		var title = document.getElementById('title').value;
		var url = document.getElementById('curl').value;
		var metatitle = document.getElementById('metatitle').value;
		var metadesc = document.getElementById('metadesc').value;
		var toc = document.getElementById('toc').value;
		var lotlof = document.getElementById('lotlof').value;
		document.getElementById('title').value = title.replace(keyword, "");
		document.getElementById('curl').value = url.replace(keyword, "");
		document.getElementById('metatitle').value = metatitle.replace(keyword, "");
		document.getElementById('metadesc').value = metadesc.replace(keyword, "");	
		//document.getElementById('toc').value = toc.replace(keyword, "");
		nicEditors.findEditor('toc').setContent(toc.replace(keyword, ""));
		//document.getElementById('lotlof').value = lotlof.replace(keyword, "");
		nicEditors.findEditor('lotlof').setContent(lotlof.replace(keyword, ""));
		var metadesc1 = document.getElementById('metadesc').value;
		alert("Removed Successfully");
	}
</script>
<!-- MAIN CONTENT-->
<div class="main-content">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">                            
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<strong>IARC BACKEND</strong>
						</div>
						 <?php if($result == "Updated"){ ?>
						 <div class="card-header">
						  <h4><p class="text-danger">Report Updated Successfully</p></h4>
						 </div>
						 <?php } ?>
						 <?php if($result == "failed"){ ?>
						 <div class="card-header">
						  <h4><p class="text-danger">Report Update Failed</p></h4>
						 </div>
						 <?php } ?>
						<div class="card-body card-block">
						<form action="iarc_backend.php" method="post" enctype="multipart/form-data" class="form-horizontal">
							<div class="row form-group">								
									<div class="col col-md-6">
										<input type="text" id="reportcode" name="reportcode" placeholder="Report Code" class="form-control">
									</div>
									<div class="col col-md-3">
										<button type="submit" class="btn btn-primary btn-sm" name="Submit" value="get report"><i class="fa fa-dot-circle-o"></i> Report</button>
									</div>								
							</div>
							</form>
						</div>
					<?php if(!empty($reportData)){ ?>
						<div class="card-body card-block">
							<form action="iarc_backend.php" method="post" enctype="multipart/form-data" class="form-horizontal">
							<input type="hidden" id="inc_id" name="inc_id"  value="<?php echo $reportData->inc_id; ?>">
							<input type="hidden" id="cat" name="cat"  value="<?php echo $reportData->cat; ?>">
							<input type="hidden" id="region_type" name="region_type"  value="<?php echo $reportData->region_type; ?>">
							
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="text-input" class=" form-control-label">Delete Keyword</label>
									</div>
									<div class="col-12 col-md-8">
										<input type="text" id="dkey" name="dkey"  value="" class="form-control">
									</div>
									<div class="col-12 col-md-2">
										<div class="btn btn-primary btn-sm" name="Submit" id="rmKey" onclick="removekeyword();" >Remove</div>
									</div>
								</div>
								
							    <div class="row form-group">
									<div class="col col-md-2">
										<label for="text-input" class=" form-control-label">Report Code</label>
									</div>
									<div class="col-12 col-md-10">
										<input type="text" id="reportcode" name="reportcode"  value="<?php echo $reportData->code; ?>" placeholder="Report code" class="form-control">
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="text-input" class=" form-control-label">Report ID</label>
									</div>
									<div class="col-12 col-md-10">
										<input type="text" id="reportid" name="reportid"  value="<?php echo $reportData->dup_inc_id; ?>" placeholder="Report Id" class="form-control">
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="text-input" class=" form-control-label">Title</label>
									</div>
									<div class="col-12 col-md-10">
										<textarea id="title" name="title" class="form-control" rows="4"><?php echo $reportData->title; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="text-input" class=" form-control-label">Breadcrumbs</label>
									</div>
									<div class="col-12 col-md-10">
										<input type="text" id="breadcrumbs" name="breadcrumbs" value="<?php echo $reportData->cbreadcrumb; ?>" placeholder="breadcrumbs" class="form-control">
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">SLP</label>
									</div>
									<div class="col-12 col-md-10">
										<input type="text" id="slp" name="slp" value="<?php echo $reportData->slp; ?>" placeholder="Enter slp" class="form-control">
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">CLP</label>
									</div>
									<div class="col-12 col-md-10">
										<input type="text" id="clp" name="clp" value="<?php echo $reportData->clp; ?>" placeholder="Enter clp" class="form-control">
									</div>
								</div>
								<!--<div class="row form-group">
									<div class="col col-md-3">
										<label for="email-input" class=" form-control-label">Status</label>
									</div>
									<div class="col-12 col-md-9">
										Active <input type="radio" id="status" name="status" value="1" <?php //if($reportData->status==1){echo "checked";} ?>>
										Inactive <input type="radio" id="status" name="status" value="0" <?php //if($reportData->status==0){echo "checked";} ?>>
									</div>
								</div>-->
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="selectSm" class=" form-control-label">Status</label>
									</div>
									<div class="col-12 col-md-10">
										<select name="status" id="status" class="form-control-sm form-control">
											<option value="0" <?php if($reportData->status==0){echo "selected";} ?>>Inactive</option>
											<option value="1" <?php if($reportData->status==1){echo "selected";} ?>>Active</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">URL</label>
									</div>
									<div class="col-12 col-md-10">
										<input type="text" id="curl" name="curl" value="<?php echo $reportData->curl; ?>" placeholder="Enter curl" class="form-control">
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">Meta Title</label>
									</div>
									<div class="col-12 col-md-10">
										<textarea id="metatitle" name="metatitle" class="form-control" rows="4"><?php echo $reportData->meta_title; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">Meta keyword</label>
									</div>
									<div class="col-12 col-md-10">
										<textarea id="metakeyword" name="metakeyword" class="form-control" rows="4"><?php echo $reportData->meta_keywords; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">Meta Desc</label>
									</div>
									<div class="col-12 col-md-10">
										<textarea id="metadesc" name="metadesc" class="form-control" rows="4"><?php echo $reportData->meta_descr; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">Seo Keyword</label>
									</div>
									<div class="col-12 col-md-10">
										<textarea id="seokeyword" name="seokeyword" class="form-control" rows="4"><?php echo $reportData->seo_keyword; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">Alt Tag</label>
									</div>
									<div class="col-12 col-md-10">
										<textarea id="atag" name="atag" class="form-control" rows="4"><?php echo $reportData->atag; ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">Report Description</label>
									</div>
									<div class="col-12 col-md-10">
										<div id="rdesc1"></div>
										<textarea id="rdesc" name="rdesc" class="form-control" rows="4"><?php echo base64_decode($reportData->description); ?></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">TOC</label>
									</div>
									<div class="col-12 col-md-10">
										<div id="toc1"></div>
										<textarea id="toc" name="toc" class="form-control" rows="4"><?php echo base64_decode($reportData->table_of_content); ?></textarea>
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col col-md-2">
										<label for="email-input" class=" form-control-label">LOTLOF</label>
									</div>
									<div class="col-12 col-md-10">
										<div id="lotlof1"></div>
										<textarea id="lotlof" name="lotlof" class="form-control" rows="4"><?php echo base64_decode($reportData->taf_new); ?></textarea>
									</div>
								</div>
								

									
								<div class="row form-group">
									<button type="submit" class="btn btn-primary btn-sm" name="Submit" value="update report"><i class="fa fa-dot-circle-o"></i> Submit</button>
								</div>
							</form>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>			
						
		   <?php include('footer-right.php'); ?>
		</div>
	</div>
</div>
<?php include('nav-foot.php'); ?>