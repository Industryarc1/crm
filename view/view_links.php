<?php
	include('nav-head.php');
 $reportid = base64_decode($_GET['report_id']);
	$report = $functions->getSeoReportById($reportid);
	$Links = $functions->getSeoLinksByReportId($reportid);
	?>
	<style>
 .append_div{
     padding: 10px 20px;
     background: #eeee;
     border-bottom: 1px solid;
     }
 </style>
 <!-- MAIN CONTENT-->
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                   <div class="card">
                   <div class="card-header">
                       <div class="row">
                        <div class="col-md-8">
                         <h4>Submitted Report Links</h4>
                       </div>
                        <div class="col-md-4">
                          <h4>Submitted By: <?php $empname=$functions->getEmployeeByEmpId($report['created_by']);
                           echo $empname['firstname']." ".$empname['lastname'];?></h4>
                        </div>
                       </div>
                    </div>
                <form action=" " method="post" enctype="multipart/form-data" class="form-horizontal">
                     <div class="card-body card-block" style="border-bottom:1px solid gray;">
                         <div class="row form-group">
                               <div class="col col-md-2">
                               <label for="text-input" style="margin: 0!important;">Report Code:</label>
                               <input type="text" name="report_code" class="form-control" value="<?php echo $report['report_code']; ?>" readonly>
                               </div>
                               <div class="col col-md-3">
                               <label for="text-input" style="margin: 0!important;">Report Title :</label>
                               <input type="text" name="report_title"  class="form-control" value="<?php echo $report['report_title']; ?>" readonly>
                              </div>
                              <div class="col col-md-7">
                              <label for="text-input" style="margin: 0!important;">Report Url :</label>
                              <input type="text" name="report_url"  class="form-control" value="<?php echo $report['report_url']; ?>" readonly>
                              </div>
                         </div>
                     </div>
                     <div class="append_div">
                      <?php
                      $i=1;
                      foreach($Links as $link){ ?>
                      <div class="row form-group">
                        <input type="hidden" name="link[<?php echo $i;?>][id]" value="<?php echo $link['id']; ?>" class="form-control">
                         <div class="col col-md-5">
                         <label for="text-input" style="margin: 0!important;">Url :</label>
                         <input type="text" name="link[<?php echo $i;?>][url]" value="<?php echo $link['url']; ?>" class="form-control" readonly>
                         </div>
                        <div class="col col-md-3">
                          <label for="text-input" style="margin: 0!important;">Type of Activity</label>
                          <input type="text" name="link[<?php echo $i;?>][activity_type]" value="<?php echo $link['activity_type']; ?>" class="form-control" readonly>
                         </div>
                         <div class="col col-md-2">
                           <label for="text-input" style="margin: 0!important;">D.A</label>
                           <input type="number" name="link[<?php echo $i;?>][domain_authority]" value="<?php echo $link['domain_authority']; ?>" class="form-control" readonly>
                           </div>
                         <div class="col col-md-2">
                          <label for="text-input" style="margin: 0!important;">Do follow Link</label>
                          <?php if($link['follow_link'] == 1){
                            $value= "Yes";
                            }else{
                            $value = "No";
                           } ?>
                          <input type="text" name="link[<?php echo $i;?>][follow_link]" value="<?php echo $value; ?>" class="form-control" readonly>
                         </div>
                        </div>
                      <?php $i++;
                      } ?>
                       </div>
                </form>
                </div>
              </div>
           </div>
       </div>
  </div>
  <!---->
 <?php include('nav-foot.php');?>
