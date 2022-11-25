<?php
	include('nav-head.php');
 $reportid = base64_decode($_GET['report_id']);
	$report = $functions->getSeoReportById($reportid);
	$Links = $functions->getSeoLinksByReportId($reportid);
	//print_r($Links);exit;
if(isset($_POST['Submit']) && $_POST['Submit']=="edit_report_link"){
 	   $date = date("Y-m-d");
     $links = $_POST['link'];
    // print_r($links);
      foreach($links as $row){
        if($row['id']){
           $linkid=$row['id'];
          	$data = array_merge($row,['created'=>$date]);
           $linkId = $functions->UpdateLinksByLinkId($linkid,$data);
        }else{
         	$data = array_merge(['report_id'=>$reportid],$row,['created'=>$date]);
          $linkId = $functions->insertLinks($data);
        }
      }
	   $reportdata = array('created'=>$date);
       $reportupdate=$functions->UpdateReportByReportId($reportid,$reportdata);
    //echo $linkId;
     if($linkId){
     	$Links = $functions->getSeoLinksByReportId($reportid);
     }
}
?>
<style>
.append_div{
    padding: 10px 20px;
    background: #eeee;
    border-bottom: 1px solid;
    }
</style>
<script>
 function check(val){
 alert("Please wait to check Url");
  var check_url = document.getElementsByName("link["+val+"][url]")[0].value;
  //console.log(check_url);
    $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: 'json',
            data: ({check_url:check_url}),
            success: function(result){
              console.log(result);
              if(result != null){
                $("input[name='link["+val+"][domain_authority]'").val(result.domain_authority);
               }else{
                alert("Domain Authority not defined");
               }
            // $('#show_report').show();
            }
     });
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
                      <div class="row">
                      <?php if(isset($linkId) != ""){ ?>
                         <div class="col-md-10">
                         <h4><p class="text-danger">Links Updated Successfully.</p></h4>
                        </div>
                      <?php }else{ ?>
                       <div class="col-md-10">
                        <h4>Edit Report Links</h4>
                      </div>
                     <?php }?>
                      </div>
                   </div>
               <form action="edit_links.php?report_id=<?php echo base64_encode($reportid);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                             <div class="col col-md-6">
                             <label for="text-input" style="margin: 0!important;">Report Url :</label>
                             <input type="text" name="report_url"  class="form-control" value="<?php echo $report['report_url']; ?>" readonly>
                             </div>
                              <div class="col col-md-1" style="padding: 0!important;top: 25px;">
                              <button type="button" class="btn btn-primary add_url"><i class="fa fa-plus"> Add Url</i></button>
                             </div>
                        </div>
                    </div>
                    <div class="append_div">
                     <?php
                     $i=1;
                     foreach($Links as $link){ ?>
                     <div id="append_url">
                     <div class="row form-group">
                       <input type="hidden" name="link[<?php echo $i;?>][id]" value="<?php echo $link['id']; ?>" class="form-control">
                        <div class="col col-md-5">
                        <label for="text-input" style="margin: 0!important;">Url :</label>
                        <input type="text" name="link[<?php echo $i;?>][url]" value="<?php echo $link['url']; ?>" class="form-control">
                        </div>
                       <div class="col col-md-3">
                         <label for="text-input" style="margin: 0!important;">Type of Activity</label>
                          <select name="link[<?php echo $i;?>][activity_type]" class="form-control activity_type">
                          <option value="" selected disabled>Select Here</option>
                          <option value="Bookmark Site" <?php if($link['activity_type'] == "Bookmark Site"){?>selected="selected"<?php } ?>>Bookmark Site</option>
                          <option value="Free Press Release" <?php if($link['activity_type'] == "Free Press Release"){?>selected="selected"<?php } ?>>Free Press Release</option>
                          <option value="Paid Press Release" <?php if($link['activity_type'] == "Paid Press Release"){?>selected="selected"<?php } ?>>Paid Press Release</option>
                          <option value="Premium Paid Press Release" <?php if($link['activity_type'] == "Premium Paid Press Release"){?>selected="selected"<?php } ?>>Premium Paid Press Release</option>
                          <option value="Directory" <?php if($link['activity_type'] == "Directory"){?>selected="selected"<?php } ?>>Directory</option>
                          <option value="Pdf Submission" <?php if($link['activity_type'] == "Pdf Submission"){?>selected="selected"<?php } ?>>Pdf Submission</option>
                          <option value="Image Submission" <?php if($link['activity_type'] == "Image Submission"){?>selected="selected"<?php } ?>>Image Submission</option>
                          <option value="Social Media" <?php if($link['activity_type'] == "Social Media"){?>selected="selected"<?php } ?>>Social Media</option>
                          </select>
                        </div>
                        <div class="col col-md-2">
                          <label for="text-input" style="margin: 0!important;">D.A <i  onclick='check(<?php echo $i;?>)' class="fas fa-check-circle " style="color:green;"></i></label>
                          <input type="number" name="link[<?php echo $i;?>][domain_authority]" value="<?php echo $link['domain_authority']; ?>" min="1" max="100" class="form-control domain_authority">
                          </div>
                        <div class="col col-md-2">
                         <label for="text-input" style="margin: 0!important;">Do follow Link</label>
                         <select name="link[<?php echo $i;?>][follow_link]" class="form-control follow_link">
                          <option value="" selected disabled>Select</option>
                           <option value="1" <?php if($link['follow_link'] == 1){?>selected="selected"<?php } ?>>Yes</option>
                           <option value="0" <?php if($link['follow_link'] == 0){?>selected="selected"<?php } ?>>No</option>
                        </select>
                        </div>
                       </div>
                     </div>
                     <?php $i++;
                     } ?>
                      </div>
                       <div class="row form-group">
                        <div class="col col-md-11"></div>
                         <div class="col col-md-1" style="top:10px;">
                         <button type="submit" class="btn btn-primary" style="float: right;margin-right: 15px;" name="Submit" value="edit_report_link">Save</button>
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
  $('.add_url').click(function() {
        var add = $("div#append_url").length;
        var newrow = add + 1;
       //console.log(newrow);
        var mark="<div id='append_url'>" +
                  "<div class='row form-group'>" +
                      "<div class='col col-md-5'>" +
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
                        "<option value='Premium Paid Press Release'>Premium Paid Press Release</option>" +
                        "<option value='Directory'>Directory</option>" +
                        "<option value='Pdf Submission'>Pdf Submission</option>" +
                        "<option value='Image Submission'>Image Submission</option>" +
                         "<option value='Social Media'>Social Media</option>" +
                        "</select>" +
                      "</div>" +
                       " <div class='col col-md-2'>" +
                       " <label for='text-input' style='margin: 0!important;'>D.A <i onclick='check("+newrow+")' class='fas fa-check-circle DA_check' style='color:green;'></i></label>" +
                       " <input type='number' name='link["+newrow+"][domain_authority]' placeholder='Only number' min='1' max='100' class='form-control domain_authority' required>" +
                       " </div>" +
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
           $(".append_div").append(mark);
    });

});
</script>
