<?php	include('nav-head.php');
if(isset($_POST['Submit']) && $_POST['Submit']=="report_link" && $_POST['report_code']!= " " ){
	   $date = date("Y-m-d H:i:s");
    $links = $_POST['link'];
     $reportexits = $functions->CheckSubmitedreportexitsByEmpId($_POST['report_code'],$_SESSION['employee_id']);
    //print_r($reportexits);
    if($reportexits != []){
       $reportId=$reportexits['id'];// Report code exits for that employee
     }else{
	  $domainCode = explode(" ",$_POST['report_code']);
      $data=array('report_code'=>strtoupper($_POST['report_code']),'report_url'=>$_POST['report_url'],'report_title'=>$_POST['report_title'],
      'created_by'=>$_SESSION['employee_id'],'created'=>$date,'status'=>1,'domain'=>$domainCode[0]);
      $reportId=$functions->insertSubmittedReports($data);
     }
    if($reportId){
       foreach($links as $row){
      				$links = array_merge(['report_id'=>$reportId],$row,['created'=>$date]);
      				$linkId = $functions->insertSubmittedLinks($links);
       }
       $result = $linkId;
    }else{
     $result = " Urls Failed to insert";
    // echo "Failed";
    }
    // exit;
}
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
                             <div class="col-md-10">
                                <?php if(isset($linkId) != 0){ ?>
                                <h4><p class="text-danger">Links added Successfully.</p></h4>
                                 <?php }else{ ?>
                                 <h4>Url Submission</h4>
                                  <?php }?>
                              </div>
                            <div class="col-md-2">
                            <a href="upload_excel.php" target="_blank"><strong style="color:red;">Bulk Upload</strong></a>
                            </div>
                      </div>
                   </div>
               <form action="seo_report_submission.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="card-body card-block" style="border-bottom:1px solid gray;">
                        <div class="row form-group">
                              <div class="col col-md-4">
                              <label for="text-input" style="margin: 0!important;">Report Code:</label>
                              <input type="text" name="report_code" id="report_code" placeholder="Report Code" class="form-control" required>
                              </div>
                              <div class="col col-md-2" style="padding: 0!important;top: 25px;">
                              <button type="button" class="btn btn-primary" id="verify"><i class="fa fa-check"> Verify</i></button>
                              </div>
                              <div class="col col-md-5"></div>
                            <!--  <div class="col col-md-3">
                              <label for="text-input" style="margin: 0!important;">Domain Authority</label>
                              <input type="number" id="domain_authority" name="domain_authority" placeholder="Only number" class="form-control">
                              </div>-->
                               <div class="col col-md-1" style="padding: 0!important;top: 25px;">
                               <button type="button" class="btn btn-primary add_url"><i class="fa fa-plus"> Add Url</i></button>
                              </div>
                        </div>
                        <div class="row form-group" style="display:none;" id="show_report">
                            <div class="col col-md-7">
                            <label for="text-input" style="margin: 0!important;">Report Url :</label>
                            <input type="text"  name="report_url" id="report_url" class="form-control" value="" required>
                            </div>
                            <div class="col col-md-5">
                            <label for="text-input" style="margin: 0!important;">Report Title :</label>
                            <input type="text" name="report_title" id="report_title" class="form-control" value="" required>
                           </div>
                        </div>
                    </div>
                    <div class="append_div">
                        <div id="append_div">
                         <div class="row form-group">
							<div class="col col-md-3">
                             <label for="text-input" style="margin: 0!important;">Website :</label>
                             <input type="text" name="link[1][website]" placeholder="Enter Website" class="form-control Website" required>
                             </div>
                             <div class="col col-md-4">
                             <label for="text-input" style="margin: 0!important;">Url :</label>
                             <input type="text" name="link[1][url]" placeholder="Enter Url" class="form-control url" required>
                             </div>
                            <div class="col col-md-3">
                              <label for="text-input" style="margin: 0!important;">Type of Activity</label>
                               <select name="link[1][activity_type]" class="form-control activity_type" required>
                               <option value="" selected disabled>Select Here</option>
                               <option value="Bookmark Site">Bookmark Site</option>
                               <option value="Free Press Release">Free Press Release</option>
                               <option value="Paid Press Release">Paid Press Release</option>
                               <option value="Premium Paid Press Release">Premium Paid Press Release</option>
                               <option value="Directory">Directory</option>
                               <option value="Pdf Submission">Pdf Submission</option>
                               <option value="Image Submission">Image Submission</option>
                                <option value="Social Media">Social Media</option>
                               </select>
                             </div>
                             <div class="col col-md-2">
                              <label for="text-input" style="margin: 0!important;">Do follow Link</label>
                              <select name="link[1][follow_link]" class="form-control follow_link" required>
                               <option value="" selected disabled>Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                             </select>
                             </div>
                           <!--  <div class="col col-md-1">
                             <button type="button" class="url-close">&times;</button>
                             </div>-->
                         </div>
                      </div>
                      </div>
                         <div class="row form-group">
                          <div class="col col-md-10"></div>
                           <div class="col col-md-2" style="top:10px;">
                                <button type="submit" class="btn btn-primary" style="float: right;margin-right: 15px;"
                                name="Submit" value="report_link">Submit</button>
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
  $('.add_url').click(function() {
        var add = $("div#append_div").length;
        var newrow = add + 1;
    //    console.log(newrow);
        var mark="<div id='append_div'>" +
           "<div class='row form-group'>" +
			   "<div class='col col-md-3'>" +
               "<label for='text-input' style='margin: 0!important;'>Website :</label>" +
               "<input type='text' name='link["+newrow+"][website]' placeholder='Enter Website' class='form-control' required>" +
               "</div>" +
               "<div class='col col-md-4'>" +
               "<label for='text-input' style='margin: 0!important;'>Url :</label>" +
               "<input type='text' name='link["+newrow+"][url]' placeholder='Enter Url' class='form-control' required>" +
               "</div>" +
              "<div class='col col-md-3'>" +
                "<label for='text-input' style='margin: 0!important;'>Type of Activity</label>" +
                 "<select name='link["+newrow+"][activity_type]' class='form-control' required>" +
                 "<option value='' selected disabled>Select Here</option>" +
                 "<option value='Bookmark Site'>Bookmark Site</option>" +
                 "<option value='Free Press Release'>Free Press Release</option>" +
                 "<option value='Paid Press Release'>Paid Press Release</option>" +
                 "<option value='Premium Paid PressRelease'>Premium Paid Press Release</option>" +
                 "<option value='Directory'>Directory</option>" +
                 "<option value='Pdf Submission'>Pdf Submission</option>" +
                 "<option value='Image Submission'>Image Submission</option>" +
                  "<option value='Social Media'>Social Media</option>" +
                 "</select>" +
               "</div>" +
               "<div class='col col-md-2'>" +
                "<label for='text-input' style='margin: 0!important;'>Do follow Link</label>" +
                "<select name='link["+newrow+"][follow_link]' class='form-control' required>" +
                 "<option value='' selected disabled>Select Here</option>" +
                  "<option value='1'>Yes</option>" +
                  "<option value='0'>No</option>" +
               "</select>" +
               "</div>" +
           "</div>" +
        "</div>";
    $("#append_div").append(mark);
  });
});
</script>

