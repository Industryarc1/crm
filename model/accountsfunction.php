<?php
class accountsfunctions
{
    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->dbObject = new databaseQuery();
        //echo $this->leadGenChannel;
        //exit;
    }
    /*    ===================================new function=====================================*/
    function insertAccounts($data){
        $table = "accounts";
        $accountId = $this->dbObject->insert($table, $data);
        return $accountId;
    }
    function getAllAccounts(){
        $roleQuery = "select `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry`,`assign_to` from accounts";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function UpdateAccountByultipleAssignIds($accIds,$assign_to,$date){
        $roleQuery = "UPDATE accounts set `assign_to`=$assign_to,`assigned_date`='$date' WHERE id IN ($accIds)";
        $result = $this->dbObject->execute($roleQuery);
        return $result;
    }
    function UpdateAccountByAssignId($accId,$data){
        $table_name = "accounts";
        $search_by = array('id' => $accId);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }
    function getSalesManagerAndEmployees(){
        $domain=$_SESSION['domain'];
        // $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and domain = '$domain'";
        $roleQuery="select * from employees where role_id in (3,4) and team_id = 2 and status = 1";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getAccountByaccountId($AccId){
        $whr = array('id' => $AccId);
        $roleQuery = $this->dbObject->selectQuery('accounts', '*', $whr, '', '', '', '');
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getleadsByEmailId($company){
        $roleQuery="SELECT * FROM leads WHERE  email LIKE '%@{$company}%'";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getleadsByWebsite($website){
        $roleQuery="SELECT * FROM leads WHERE  email LIKE '%@{$website}%' order by id desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getTotalAccounts(){
        $roleQuery=" SELECT count(id) as total FROM accounts";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getTotalnumofSearchAccounts($limit){
        $roleQuery = "Select count(id) as total from accounts ORDER BY id DESC";
        $result = $this->dbObject->getRow($roleQuery);
        $total_pages = ceil($result['total'] / $limit);
        $data['total_pages']=$total_pages;
        $data['total']=$result['total'];
        return $data;
    }
    function getAllAccountsPagination($page,$limit){
        $query="select `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry`,`assign_to` from accounts ORDER BY id DESC ";
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $condition="LIMIT ".$startIndex.", ".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function updateAccountDetailsByAccountId($accountid,$data){
        $table_name = "accounts";
        $search_by = array('id' => $accountid);
        $status = $this->dbObject->update($table_name, $data, $search_by);
        return $status;
    }
    function getTotalAccountsBySearchValue($value,$limit){
        //$query = "SELECT * FROM leads WHERE (company_name LIKE '%{$value}%' OR country LIKE '%{$name}%' OR main_industry LIKE '%{$value}%' OR sub_industry LIKE '%{$value}%')";
       // $query = "SELECT count(id) as total FROM accounts WHERE MATCH(company_name) AGAINST ('$value' IN NATURAL LANGUAGE MODE)";
        $query="SELECT COUNT(id) AS total FROM accounts WHERE company_name LIKE '%{$value}%' ORDER BY id DESC";
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['total'] / $limit);
        $data['total_pages']=$total_pages;
        $data['total']=$result['total'];
        return $data;
    }
    function getAllAccountsBySearchValuePagination($value, $page, $limit){
        $query = "SELECT `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry`,`assign_to` FROM accounts WHERE company_name LIKE '%{$value}%' ORDER BY id DESC";
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $condition=" LIMIT ".$startIndex.", ".$maxLimit;
        $query= $query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getassignedAccounts(){
        $id=$_SESSION['employee_id'];
        $roleQuery="select `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry` from accounts
          where assign_to = $id";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getCountOfSearchDataInAllAccounts($data, $limit){
        $condition = "";
        if ($data['company_name'] !="") {
            $condition.="AND company_name LIKE '%".$data['company_name']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['main_industry'] !="") {

            $condition.="AND main_industry LIKE '%".$data['main_industry']."%' ";
        }
        if ($data['from_revenue'] !="") {
            $condition.="AND total_revenue >= ".$data['from_revenue']." ";
        }
        if ($data['to_revenue'] !="") {
            $condition.="AND total_revenue <= ".$data['to_revenue']." ";
            //  $condition.="AND total_revenue BETWEEN ".$data['total_revenue']." ";
        }
        if ($data['assign_to'] !="") {
            $assign_to= $data['assign_to'];
            $condition.="AND assign_to = $assign_to ";
        }
        if ($data['assignedf'] !="") {
            $condition.="AND DATE(assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            $query = "SELECT count(*) as tot FROM accounts WHERE ";
        }else{
            $query = "SELECT count(*) as tot FROM accounts ";
        }
        $query=$query.$condition;
        $result = $this->dbObject->getRow($query);
        $total_pages = ceil($result['tot'] / $limit);
        $data['total_pages']=$total_pages;
        $data['total']=$result['tot'];
        return $data;
    }
    function getSearchDataInAllAccountsPagination($data, $page, $limit){
        $condition = "";
        if ($data['company_name'] !="") {
            $condition.="AND company_name LIKE '%".$data['company_name']."%' ";
        }
        if ($data['country'] !="") {

            $condition.="AND country LIKE '%".$data['country']."%' ";
        }
        if ($data['main_industry'] !="") {

            $condition.="AND main_industry LIKE '%".$data['main_industry']."%' ";
        }
        if ($data['from_revenue'] !="") {
            $condition.="AND total_revenue >= ".$data['from_revenue']." ";
        }
        if ($data['to_revenue'] !="") {
            $condition.="AND total_revenue <= ".$data['to_revenue']." ";
            //  $condition.="AND total_revenue BETWEEN ".$data['total_revenue']." ";
        }
        if ($data['assign_to'] !="") {
            $assign_to= $data['assign_to'];
            $condition.="AND assign_to = $assign_to ";
        }
        if ($data['assignedf'] !="") {
            $condition.="AND DATE(assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
        }
        $condition= ltrim($condition,"AND");
        if($condition!=""){
            $query = "SELECT `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry` FROM accounts WHERE ";
        }else{
            $query = "SELECT `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry` FROM accounts ";
        }
        $query=$query.$condition;
        $srt= $page-1;
        $startIndex = $srt*$limit;
        $maxLimit = $limit;
        $countlimit=" LIMIT ".$startIndex.",".$maxLimit;
        $query= $query.$countlimit;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getContactsByWebsite($website){
        $roleQuery="SELECT * FROM contacts WHERE  email LIKE '%@{$website}%'";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
     function getCountOfAllAccountsByValueAndSearchData($data,$value,$limit){
         $condition = "";
         if ($data['company_name'] !="") {
             $condition.="AND company_name LIKE '%".$data['company_name']."%' ";
         }
         if ($data['country'] !="") {

             $condition.="AND country LIKE '%".$data['country']."%' ";
         }
         if ($data['main_industry'] !="") {

             $condition.="AND main_industry LIKE '%".$data['main_industry']."%' ";
         }
         if ($data['from_revenue'] !="") {
             $condition.="AND total_revenue >= ".$data['from_revenue']." ";
         }
         if ($data['to_revenue'] !="") {
             $condition.="AND total_revenue <= ".$data['to_revenue']." ";
             //  $condition.="AND total_revenue BETWEEN ".$data['total_revenue']." ";
         }
         if ($data['assign_to'] !="") {
             $assign_to= $data['assign_to'];
             $condition.="AND assign_to = $assign_to ";
         }
         if ($data['assignedf'] !="") {
             $condition.="AND DATE(assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
         }
         if($value){
             $condition.="AND company_name LIKE '%{$value}%' ";
         }
         $condition= ltrim($condition,"AND");
         if($condition!=""){
             $query = "SELECT count(*) as tot FROM accounts WHERE ";
         }else{
             $query = "SELECT count(*) as tot FROM accounts ";
         }
         $query=$query.$condition;
         $result = $this->dbObject->getRow($query);
         $total_pages = ceil($result['tot'] / $limit);
         $data['total_pages']=$total_pages;
         $data['total']=$result['tot'];
         return $data;
     }
     function getAllAccountsByValueAndSearchDataPagination($data,$value,$page,$limit){
         $condition = "";
         if ($data['company_name'] !="") {
             $condition.="AND company_name LIKE '%".$data['company_name']."%' ";
         }
         if ($data['country'] !="") {

             $condition.="AND country LIKE '%".$data['country']."%' ";
         }
         if ($data['main_industry'] !="") {

             $condition.="AND main_industry LIKE '%".$data['main_industry']."%' ";
         }
         if ($data['from_revenue'] !="") {
             $condition.="AND total_revenue >= ".$data['from_revenue']." ";
         }
         if ($data['to_revenue'] !="") {
             $condition.="AND total_revenue <= ".$data['to_revenue']." ";
             //  $condition.="AND total_revenue BETWEEN ".$data['total_revenue']." ";
         }
         if ($data['assign_to'] !="") {
             $assign_to= $data['assign_to'];
             $condition.="AND assign_to = $assign_to ";
         }
         if ($data['assignedf'] !="") {
             $condition.="AND DATE(assigned_date) BETWEEN '".$data['assignedf']."' AND '".$data['assignedt']."' ";
         }
         if($value){
             $condition.="AND company_name LIKE '%{$value}%' ";
         }
         $condition= ltrim($condition,"AND");
         if($condition!=""){
             $query = "SELECT `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry` FROM accounts WHERE ";
         }else{
             $query = "SELECT `id`,`company_name`,`website`,`employee_size`,`total_revenue`,`country`,`main_industry` FROM accounts ";
         }
         $query=$query.$condition;
         $srt= $page-1;
         $startIndex = $srt*$limit;
         $maxLimit = $limit;
         $countlimit=" LIMIT ".$startIndex.",".$maxLimit;
         $query= $query.$countlimit;
         $result = $this->dbObject->getAllRows($query);
         return $result;
     }
      function getContactsById($contactid){
          $whr = array('id' => $contactid);
          $roleQuery = $this->dbObject->selectQuery('contacts', '*', $whr, '', '', '', '');
          $result = $this->dbObject->getRow($roleQuery);
          return $result;
      }
      function insertContactAslead($data){
          $table = "leads";
          $leadId = $this->dbObject->insert($table, $data);
          return $leadId;
      }
       function UpdateContactById($data,$contactid){
           $table_name = "contacts";
           $search_by = array('id' => $contactid);
           $status = $this->dbObject->update($table_name, $data, $search_by);
           return $status;
       }
       function getDealStages(){
           $roleQuery = $this->dbObject->selectQuery('deal_stages', '*', $whr, '', '', '', '');
           $result = $this->dbObject->getAllRows($roleQuery);
           return $result;
       }
       function CheckleadidInPipeline($leadid){
           $roleQuery="SELECT count(*) as count FROM lead_pipeline WHERE `lead_id` = $leadid";
           $result=$this->dbObject->getRow($roleQuery);
           return $result;
       }
       function insertPipeline($data){
           $table = "lead_pipeline";
           $memberDetailsId = $this->dbObject->insert($table, $data);
           return $memberDetailsId;
       }
       function UpdatePipeline($leadid,$data){
           $table_name = "lead_pipeline";
           $search_by = array('lead_id' => $leadid);
           $status = $this->dbObject->update($table_name, $data, $search_by);
           return $status;
       }
        function getLeadPipelineByleadId($leadid){
            $whr = array('lead_id' => $leadid);
            $roleQuery = $this->dbObject->selectQuery('lead_pipeline', '*', $whr, '', '', '', '');
            $result = $this->dbObject->getRow($roleQuery);
            return $result;
        }
        function getCountofDealsByDealId($deal_id){
            $roleQuery="select count(*) as count from lead_pipeline where deal_stage_id = $deal_id and exp_deal_amount IS NOT NULL";
            $result = $this->dbObject->getRow($roleQuery);
            return $result;
        }
        function getDealsByDealId($deal_id){
            $roleQuery="select * from lead_pipeline where deal_stage_id = $deal_id and exp_deal_amount IS NOT NULL order by created desc limit 0,30";
            $result = $this->dbObject->getAllRows($roleQuery);
            return $result;
        }
        function getCountofAllSearchDealsByDealId($data,$deal_id){
            $condition = "";
            if ($data['from_date'] !="") {
                $condition.="AND DATE(created) BETWEEN '".$data['from_date']."' AND '".$data['to_date']."' ";
            }
            if ($data['updated_by'] !="") {
                $condition.="AND updated_by = ".$data['updated_by']." ";
            }
            $condition= ltrim($condition,"AND");
            if($condition !=""){
                $query = "SELECT count(*) as count from lead_pipeline WHERE deal_stage_id = $deal_id AND ";
            }else{
                $query = "SELECT count(*) as count from lead_pipeline WHERE deal_stage_id = $deal_id order by created desc limit 0,30";
            }
            $query=$query.$condition;
            $result = $this->dbObject->getRow($query);
            return $result;
        }
    function getAllSearchDealsByDealId($data,$deal_id){
        $condition = "";
        if ($data['from_date'] !="") {
            $condition.="AND DATE(created) BETWEEN '".$data['from_date']."' AND '".$data['to_date']."' ";
        }
       if ($data['updated_by'] !="") {
          $condition.="AND updated_by = ".$data['updated_by']." ";
        }
        $condition= ltrim($condition,"AND");
        if($condition !=""){
            $query = "SELECT * from lead_pipeline WHERE deal_stage_id = $deal_id AND ";
        }else{
            $query = "SELECT * from lead_pipeline WHERE deal_stage_id = $deal_id ";
        }
        $query=$query.$condition;
        $result = $this->dbObject->getAllRows($query);
        return $result;
    }
    function getCountofEmpDealsByDealId($deal_id,$empid){
      $roleQuery="SELECT COUNT(*) AS count FROM lead_pipeline lp LEFT JOIN leads l ON l.id=lp.lead_id WHERE lp.deal_stage_id = $deal_id AND l.associated_id = $empid";
       // $roleQuery="select count(*) as count from lead_pipeline where deal_stage_id = $deal_id AND updated_by = $empid";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getEmpDealsByDealId($deal_id,$empid){
       $roleQuery="SELECT lp.id,lp.lead_id,lp.updated_by,lp.exp_deal_amount,lp.exp_deal_closure,lp.deal_stage_id,lp.remarks FROM lead_pipeline lp LEFT JOIN leads l ON l.id=lp.lead_id WHERE lp.deal_stage_id = $deal_id AND l.associated_id = $empid order by lp.created desc limit 0,30";
        //$roleQuery="select * from lead_pipeline where deal_stage_id = $deal_id AND updated_by = $empid";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getDealByLeadId($leadid){
        $roleQuery="select * from lead_pipeline where lead_id = $leadid";
        $result = $this->dbObject->getRow($roleQuery);
        return $result;
    }
    function getDealLogsOfDealId($deal_id){
        $roleQuery="select * from lead_pipeline_log where lead_pipeline_id = $deal_id order by updated_date Desc";
        $result = $this->dbObject->getAllRows($roleQuery);
        return $result;
    }
    function getCountofEmpSearchDealsByDealId($data,$deal_id,$empid){
               $condition = "";
                if ($data['from_date'] !="") {
                    $condition.="AND DATE(lp.created) BETWEEN '".$data['from_date']."' AND '".$data['to_date']."' ";
                }
                $condition= ltrim($condition,"AND");
                if($condition !=""){
                    $query = "SELECT COUNT(*) as count FROM lead_pipeline lp LEFT JOIN leads l ON l.id=lp.lead_id WHERE lp.deal_stage_id = $deal_id AND lp.exp_deal_amount IS NOT NULL AND l.associated_id = $empid AND ";
                }else{
                    $query = "SELECT COUNT(*) as count FROM lead_pipeline lp LEFT JOIN leads l ON l.id=lp.lead_id WHERE lp.deal_stage_id = $deal_id AND lp.exp_deal_amount IS NOT NULL AND l.associated_id = $empid ";
                }
                $query=$query.$condition;
                $result = $this->dbObject->getRow($query);
                return $result;
    }
    function getEmpSearchDealsByDealId($data,$deal_id,$empid){
                        $condition = "";
                        if ($data['from_date'] !="") {
                            $condition.="AND DATE(lp.created) BETWEEN '".$data['from_date']."' AND '".$data['to_date']."' ";
                        }
                        $condition= ltrim($condition,"AND");
                        if($condition !=""){
                            $query = "SELECT lp.id,lp.lead_id,lp.updated_by,lp.exp_deal_amount,lp.exp_deal_closure,lp.deal_stage_id,lp.remarks FROM lead_pipeline lp LEFT JOIN leads l ON l.id=lp.lead_id WHERE lp.deal_stage_id = $deal_id AND lp.exp_deal_amount IS NOT NULL AND l.associated_id = $empid AND ";
                        }else{
                            $query = "SELECT lp.id,lp.lead_id,lp.updated_by,lp.exp_deal_amount,lp.exp_deal_closure,lp.deal_stage_id,lp.remarks FROM lead_pipeline lp LEFT JOIN leads l ON l.id=lp.lead_id WHERE lp.deal_stage_id = $deal_id AND lp.exp_deal_amount IS NOT NULL AND l.associated_id = $empid order by lp.created desc limit 0,30";
                        }
                        $query=$query.$condition;
                        $result = $this->dbObject->getAllRows($query);
     return $result;
     }
}
?>