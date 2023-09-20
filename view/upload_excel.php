<?php

 include('nav-head.php');
 include('csvreader/Csvreader.php');
 $csvreader = new Csvreader();
 if(isset($_POST['Submit']) && $_POST['Submit']=="export"){
     $date = date("Y-m-d");
     $filename = $_FILES["file"]["name"];
      $result = $csvreader->parse_file($_FILES["file"]["tmp_name"]);
      //echo "<pre>";
     //print_r($result);
     if($result != []){  // excel data has been read
         foreach($result as $row){
           $reportcode=$row['Report Code'];
		   $domainCode = explode(" ",$reportcode);
           $urldata =array('url'=>$row['Url'],'activity_type'=>$row['Type of Activity'],'follow_link'=>$row['Do Follow'],
           'website'=>$row['Website']);
             $post = array('token'=>'GetReportByReportCode','code' => $reportcode);
               $ch1 = curl_init();
               curl_setopt($ch1, CURLOPT_URL, 'https://www.industryarc.com/api/check_title.php');
               curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($post));
               $response = curl_exec($ch1);
               curl_close($ch1);
               $array = json_decode($response);
               //echo $response;
               //echo $array->code;
              if($array != ""){
                 $report_code = $array->code;// Report code matches
                 $empid = $_SESSION['employee_id'];
                 $reportexits = $functions->CheckSubmittedReportexitsByEmpId($report_code,$empid);
                    if($reportexits != []){
                       $reportId=$reportexits['id'];// Report code exits for that employee
                    }else{
                        $data=array('report_code'=>$array->code,'report_url'=>$array->title_url,'report_title'=>$array->title,
                        'created_by'=>$_SESSION['employee_id'],'created'=>$date,'status'=>1,'domain'=>$domainCode[0]);
                         $reportId=$functions->insertSubmittedReports($data);// report code inserts
                    }
                   // echo $reportId;
                   // print_r($urldata);
                     if($reportId){
                            $links = array_merge(['report_id'=>$reportId],$urldata,['created'=>$date]);
                            $linkId = $functions->insertSubmittedLinks($links);
                         $output =" Urls Successfully Inserted...";// Urls  inserted..
                     }else{
                      $output = "Urls Fail to Insert...";// Urls unable to insert
                     }
              }else{
                $output = "Report Code (".$reportcode .") doesnot match!!!";// code doesnot match with api
              }
         }
     }else{
       $output = "Something went wrong in Excel";// excel file no read
     }
     echo $output;
 }
 //EOF
?>
 <!-- MAIN CONTENT-->
<div class="main-content">
   <div class="section__content section__content--p30">
       <div class="container-fluid">
           <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-header">
                       <div class="row">
                           <?php if(isset($linkId) != 0){ ?>
                             <div class="col-md-10">
                             <h4><p class="text-danger">Uploaded Successfully.</p></h4>
                            </div>
                          <?php }else{ ?>
                           <div class="col-md-10">
                            <h4>Excel Upload</h4>
                          </div>
                         <?php }?>
                       </div>
                    </div>
               <form action="upload_excel.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="card-body card-block" style="border-bottom:1px solid gray;">
                      <div class="row form-group">
                         <div class="col col-md-3"></div>
                          <div class="col col-md-6">
                             <div class="row form-group">
                                  <div class="col col-md-4">
                                  <strong for="text-input" style="margin: 0!important;">Upload Excel:</strong>
                                  </div>
                                   <div class="col col-md-8">
                                   <input type="file" name="file" id="file" required>
                                   </div>
                               </div>
                                <div class="row form-group">
                                   <div class="col col-md-4">
                                   <strong for="text-input" style="margin: 0!important;">Import :</strong>
                                   </div>
                                   <div class="col col-md-8">
                                   <a href="sampleexcel_dwd.php">Download SAMPLESHEET</a>
                                   </div>
                                </div>
                          </div>
                        </div>
                        <div class="row form-group">
                           <span>Note:
                           1.Send Correct format of REPORT CODES (CMR 0004) and Activity types.<br>
                           2.Save Do follow as 1(Yes) and 0(No).</span>
                           <strong><?php echo $output;?></strong>
                        </div>
                     </div>
                         <div class="row form-group">
                          <div class="col col-md-10"></div>
                           <div class="col col-md-2" style="top:10px;">
                             <button type="submit" class="btn btn-primary" style="float: right;margin-right: 15px;" name="Submit"
                              value="export">Submit</button>
                          </div>
                     </div>
               </form>
                  </div>
               </div>
          </div>
      </div>
 </div>
 <!---->
<?php include('nav-foot.php');?>
<script>
$(document).ready(function() {
   $('#verify').click(function() {
     var report_code=$("#report_code").val();
     //console.log(report_code);
       if(report_code == ""){
         alert("Please enter report code?");
       }else{
       alert("Please wait to check Report Code");
       $.ajax({
          type: "POST",
          url: 'ajax.php',
          dataType: 'json',
          data: ({report_code:report_code}),
          success: function(result){
            console.log(result);
            if(result != null){
              $("#report_url").val(result.title_url);
              $("#report_title").val(result.title);
              $('#show_report').show();
           }else{
             alert("Report Code doesnot Match !!!");
           }
          }
        });
      }
  });
});
</script>

