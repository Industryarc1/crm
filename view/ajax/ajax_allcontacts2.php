<?php
session_start();
ini_set("display_errors",0);
 include_once('../../model/function.php');
 $functions = new functions();
	include_once('../../model/contacts2function.php');
 $contacts2functions = new contacts2functions();
$contactsList = array();
$limit = 100;
$page = 1;
if(isset($_POST['filtercontacts2']) && $_POST['filtercontacts2']!= ""){
 $company=$_POST['company'];
 $category=$_POST['category'];
 $industry=$_POST['industry'];
 $level=$_POST['level'];
 $country = $_POST['country'];
 $contacttype =$_POST['contacttype'];
 $not_assigned = $_POST['not_assigned'];
      if($company != ""){
       $company="'".implode("','", $_POST['company'])."'";
      }
      if($category != ""){
       $category="'".implode("','", $_POST['category'])."'";
      }
      if($industry != ""){
       $industry="'".implode("','", $_POST['industry'])."'";
      }
      if($level != ""){
       $level="'".implode("','", $_POST['level'])."'";
      }
      if($country != ""){
       $country="'".implode("','", $_POST['country'])."'";
      }
  //$country=join("','",$_POST['country']);
        $_SESSION['con2_filter']['company_name']=$company;
        $_SESSION['con2_filter']['category']=$category;
        $_SESSION['con2_filter']['industry']=$industry;
        $_SESSION['con2_filter']['country']=$country;
        $_SESSION['con2_filter']['managementlevel']=$level;
        $_SESSION['con2_filter']['contacttype']=$contacttype;
    $data=array('company_name'=>$company,'category'=>$category,'industry'=>$industry,'country'=>$country,'managementlevel'=>$level,
    'contacttype'=> $contacttype);
    $TotalContacts = $contacts2functions->getCountOfSearchDataInAllContacts2($data, $limit);
    $totrecords= $TotalContacts['total'];
    $total_pages=$TotalContacts['total_pages'];
    $contactsList = $contacts2functions->getSearchDataInAllContacts2Pagination($data, $page, $limit);
}
//	echo "<pre>";
//print_r($contactsList);
//exit();
?>
  <!-- DATA TABLE-->
  <div class="wrapper2 table-responsive m-b-40 table-scroll-parent">
    <table class="div2 table table-borderless table-data4 table-scroll-child">
        <thead>
        <tr>
            <th><input type="checkbox" id="check_all" value="0"/></th>
            <th>FullName</th>
            <th>Category</th>
            <th>Levels</th>
            <th>Industry</th>
            <th>Company</th>
            <th>Company Number</th>
            <th>Website</th>
            <th>Country</th>
            <th>Title</th>
            <th>TotalRevenue</th>
            <th>EmployeeSize</th>
            <th>Assigned</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($contactsList as $row){ ?>
               <tr>
               <td>
                 <input type="checkbox" class="checklead" value="<?php echo $row['id']?>"/>
               </td>
                <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['managementlevel']; ?></td>
                <td><?php echo $row['industry']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['company_phone']; ?></td>
                <td><?php echo $row['company_domain']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['company_revenue']; ?></td>
                <td><?php echo $row['company_employees']; ?></td>
                <td><?php if($row['assign_to'] == 0){
                    echo "<strong>Not Assigned</strong>";
                   }else{
                   $associatedname=$functions->getEmployeeByEmpId($row['assign_to']);
                    echo $associatedname['firstname'].' '.$associatedname['lastname'];
                   }?></td>
              </tr>
              <?php } ?>
        </tbody>
    </table>
  </div>
  <!-- END DATA TABLE-->
  <div class="row">
    <div class="col-sm-10">
        <?php
          $i=1;
           $pagLink = "<nav><ul class='pagination light-theme simple-pagination'>
               <li><a href='contacts_version2.php?page= ".$i."'>Prev</a></li>
               <li><a href='contacts_version2.php?page=".$total_pages."'>Next</a></li>";
             echo $pagLink . "</ul></nav></div>";
           echo "<div class='col-sm-2'><p style='float:right'>Records:
         <strong>". $totrecords ."</strong></p></div>";
        ?>
    </div>
  </div>
<!-- END pagination TABLE-->

<script type="text/javascript">
 $(document).ready(function() {
        $('.pagination').pagination({
            items: <?php echo $total_pages*$limit;?>,
            itemsOnPage: <?php echo $limit; ?>,
            cssStyle: 'light-theme',
            currentPage : <?php echo $page;?>,
            hrefTextPrefix : 'contacts_version2.php?page='
        });
        $("#check_all").click(function () {
        		$('input:checkbox').not(this).prop('checked', this.checked);
        			if($(':checkbox:checked').length > 0){
        			$(".hide-buttons").show();
        		}else{
        			$(".hide-buttons").hide();
        		}
        	});
 });
</script>
 <script type="text/javascript" src="js/jquery.simplePagination.js"></script>
