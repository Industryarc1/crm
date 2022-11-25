<?php
//$config = require '..\config.php';
class zohofunctions {
    public $config;
    private $organizationId;
    private $authToken;

    function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        include_once('databasequery.php');
        $this->config = include('../zoho_config.php');
        $this->dbObject = new databaseQuery();
        $this->organizationId = !empty($this->config['params']['organization_id'])?$this->config['params']['organization_id']:NULL;
        $this->authToken = !empty($this->config['params']['authtoken'])?$this->config['params']['authtoken']:NULL;
    /*    $this->organizationId = '641397164';
        $this->authToken = '4424484bc5710ff36f9b4a09b33c93f9';*/
    }

    function test(){
        echo $this->organizationId;exit;
        $sql = "select * from zoho_contacts";
        return $this->dbObject->getAllRows($sql);
    }

    function getCurrencyList(){
        $urlAuthKeys = "?organization_id=".$this->organizationId."&authtoken=".$this->authToken;
        $apiUrl = "https://books.zoho.com/api/v3/settings/currencies".$urlAuthKeys;
        //print_r($apiUrl); die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//Set to return data to string ($response)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization : Zoho-authtoken 4424484bc5710ff36f9b4a09b33c93f9',
                'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' )
        );
        curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams
        //curl_setopt($ch, CURLOPT_POST, true);
        $response = curl_exec($ch);
        $arrData = json_decode($response,true);
          //print_r($arrData); die;
       // $jsondata = file_get_contents($apiUrl);
       // $arrData= json_decode($jsondata,true);
        return !empty($arrData['currencies'])?$arrData['currencies']:[];
    }

    function createZohoContact($arrInputs=[]){
        $urlAuthKeys = "?organization_id=".$this->organizationId."&authtoken=".$this->authToken;
        $apiUrl = "https://books.zoho.com/api/v3/contacts".$urlAuthKeys;
        if(isset($arrInputs['contact_details']) && !empty($arrInputs['contact_details'])){
            $input = "JSONString=".urlencode(json_encode($arrInputs['contact_details']));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//Set to return data to string ($response)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization : Zoho-authtoken '.$this->authToken.'',
                    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' )
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS,$input);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams
            curl_setopt($ch, CURLOPT_POST, true);//Regular post
            $response = curl_exec($ch);
            $arrResponce = json_decode($response,true);
            //echo '<pre>';print_r($arrResponce);exit;
            $arrResponce = isset($arrResponce['contact'])?$arrResponce['contact']:[];
            $arrZohoContactPrsn = [
                'zoho_contact_person_id'=>!empty($arrResponce['contact_persons'][0]['contact_person_id'])?$arrResponce['contact_persons'][0]['contact_person_id']:NULL,
                'zoho_contact_id'=>!empty($arrResponce['contact_id'])?$arrResponce['contact_id']:NULL,
                'first_name'=>!empty($arrResponce['contact_persons'][0]['first_name'])?$arrResponce['contact_persons'][0]['first_name']:NULL,
                'last_name'=>!empty($arrResponce['contact_persons'][0]['last_name'])?$arrResponce['contact_persons'][0]['last_name']:NULL,
                'email'=>!empty($arrResponce['contact_persons'][0]['email'])?$arrResponce['contact_persons'][0]['email']:NULL,
                'phone'=>!empty($arrResponce['contact_persons'][0]['phone'])?$arrResponce['contact_persons'][0]['phone']:NULL,
                'mobile'=>!empty($arrResponce['contact_persons'][0]['mobile'])?$arrResponce['contact_persons'][0]['mobile']:NULL,
            ];
            $arrZohoContacts=[
                'zoho_contact_id'=>!empty($arrResponce['contact_id'])?$arrResponce['contact_id']:NULL,
                'name'=>!empty($arrResponce['contact_name'])?$arrResponce['contact_name']:NULL,
                'designation'=>!empty($arrResponce['contact_designation'])?$arrResponce['contact_designation']:NULL,
                'company'=>!empty($arrResponce['company_name'])?$arrResponce['company_name']:NULL,
                'location'=>!empty($arrResponce['contact_location'])?$arrResponce['contact_location']:NULL,
                'email'=>!empty($arrResponce['contact_email'])?$arrResponce['contact_email']:NULL,
                'phone'=>!empty($arrResponce['contact_phone'])?$arrResponce['contact_phone']:NULL,
                'address'=>!empty($arrResponce['contact_address'])?$arrResponce['contact_address']:NULL,
                'gst_number'=>!empty($arrResponce['contact_gst_number'])?$arrResponce['contact_gst_number']:NULL,
                'purchage_order'=>!empty($arrResponce['contact_purchage_order'])?$arrResponce['contact_purchage_order']:NULL,
                'do_creation'=>!empty($arrResponce['contact_do_creation'])?$arrResponce['contact_do_creation']:NULL,
                'status'=>1,
            ];
            if($arrZohoContactPrsn['zoho_contact_person_id'] == "" || $arrZohoContacts['zoho_contact_id']== ""){
                $msg = "Failed To insert at contact!!!";
                echo '<script>alert("'.$msg.'");</script>';
                die;
            }else{
                $resTbl1 = $this->dbObject->insert('zoho_contact_person',$arrZohoContactPrsn);
                $resTbl2 = $this->dbObject->insert('zoho_contacts',$arrZohoContacts);
            }
        }
        $otherParams = [
            'customer_id'=>$arrResponce['contact_id'],
            'contact_persons'=>[$arrResponce['contact_persons'][0]['contact_person_id']],
        ];
        $this->createZohoItems($arrInputs,$otherParams);
    }

    function createZohoItems($arrInputs,$otherParams){
        $urlAuthKeys = "?organization_id=".$this->organizationId."&authtoken=".$this->authToken;
        $apiUrl = "https://books.zoho.com/api/v3/items".$urlAuthKeys;
        $itemName = $arrInputs['item_details']['name'];
        $sql= "SELECT * FROM `zoho_items` WHERE name ='".$itemName."'";
        $itemDetails = $this->dbObject->getRow($sql);
        if(!empty($arrInputs['item_details']) && empty($itemDetails)){
            $input = "JSONString=".urlencode(json_encode($arrInputs['item_details']));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//Set to return data to string ($response)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization : Zoho-authtoken '.$this->authToken.'',
                    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' )
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS,$input);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams

            curl_setopt($ch, CURLOPT_POST, true);//Regular post
            //$error=curl_error($ch);echo'<pre>';print_r($error); die;
            $response = curl_exec($ch);
            $arrResponce = json_decode($response,true);
         /*    echo '<pre>';
             print_r($arrResponce);exit;*/
            $arrZohoItems=[
                'zoho_item_id'=>!empty($arrResponce['item']['item_id'])?$arrResponce['item']['item_id']:NULL,
                'name'=>!empty($arrResponce['item']['name'])?$arrResponce['item']['name']:NULL,
                'price'=>!empty($arrResponce['item']['rate'])?$arrResponce['item']['rate']:NULL,
                'do_creation'=>!empty($arrResponce['item']['do_creation'])?$arrResponce['item']['do_creation']:NULL,
                'status'=>1,
            ];
            if($arrZohoItems['zoho_item_id'] == "" || $arrZohoItems['price'] == ""){
                $msg = "Failed To insert at items!!!";
                echo '<script>alert("'.$msg.'");</script>';
                die;
            }else{
                $resdata = $this->dbObject->insert('zoho_items',$arrZohoItems);
            }
            $otherParams2=['line_items'=>[['item_id'=>$arrResponce['item']['item_id']]]];

        }else if(isset($arrInputs['item_details']) && !empty($itemDetails)){
            $otherParams2=['line_items'=>[['item_id'=>$itemDetails['zoho_item_id']]]];
        }
        $otherParams = array_merge($otherParams,$otherParams2);
        $this->createZohoInovice($arrInputs,$otherParams);
    }

    function createZohoInovice($arrInputs,$otherParams){
        $invoiceNumber = $this->getInvoiceNumber();
        $invoiceDetails = !empty($arrInputs['inovice_details'])?$arrInputs['inovice_details']:[];
        $arrData = [
            'customer_id'=>$otherParams['customer_id'],
            'contact_persons'=>$otherParams['contact_persons'],
            //'invoice_number'=>$invoiceNumber,
            'template_id'=>"544119000000017001",
            'discount'=>$invoiceDetails['discount'],
            'reference_number'=>$arrInputs['contact_details']['purchase_order'],
            'is_discount_before_tax'=>true,
            'salesperson_name'=>$_SESSION['name'],
            'gst_treatment'=>'overseas',
            'discount_type'=>'entity_level',
            'is_inclusive_tax'=>false,
            'due_date'=>$invoiceDetails['due_date'],
            'line_items'=>$otherParams['line_items'],
			'exchange_rate'=> 1,
            'payment_options' => Array (
                'payment_gateways' => Array (
                    '0' => Array (
                        'configured' => 1,
                        'additional_field1' => 'standard',
                        'gateway_name' => 'paypal',
                    ),
                ),
            ),
            'shipping_charge' =>'' ,
            /*'payment_gateways' => Array (
                '0' => Array (
                    'configured' => 1,
                    'additional_field1' => 'standard',
                    'gateway_name' => 'paypal',
                ),
            ),
            'gateway_name' => 'paypal',
            'additional_field1' => 'standard',
            'send' => 1,*/

        ];
       // echo "<pre>";
        //print_r($arrData); echo "</pre>";die;
        $urlAuthKeys = "?organization_id=".$this->organizationId."&authtoken=".$this->authToken;
        $apiUrl = "https://books.zoho.com/api/v3/invoices".$urlAuthKeys;
        if(isset($arrData) && !empty($arrData)){
            $input = "JSONString=".urlencode(json_encode($arrData));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//Set to return data to string ($response)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization : Zoho-authtoken '.$this->authToken.'',
                    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' )
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS,$input);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams
            curl_setopt($ch, CURLOPT_POST, true);//Regular post

            $response = curl_exec($ch);
            $arrResponce = json_decode($response,true);
           //echo "<pre>";
		   //print_r($arrData);
           //print_r($arrResponce); die;
            $arrZohoInvoice=[
                'zoho_invoice_id'=>'',
                'invoice_id'=>$arrResponce['invoice']['invoice_id'],
                'zoho_contact_id'=>$arrResponce['invoice']['customer_id'],
                'invoice_date'=>$arrResponce['invoice']['date'],
                'due_date'=>$arrResponce['invoice']['due_date'],
                'email'=>$arrResponce['invoice']['contact_persons_details'][0]['email'],
                'phone'=>$arrResponce['invoice']['contact_persons_details'][0]['phone'],
                'source'=>'',
                'address'=>json_encode($arrResponce['invoice']['billing_address']),
                'gst_number'=>$arrResponce['invoice']['invoice_id'],
                'purchage_order'=>$arrResponce['invoice']['invoice_id'],
                'discount'=>$arrResponce['invoice']['discount'],
                'do_creation'=>'',
                'status'=>1,
                'invoice_number'=>$arrResponce['invoice']['invoice_number'],
            ];
            $arrZohoInvoiceContactPersons=[
                'invoice_id'=>$arrResponce['invoice']['invoice_id'],
                'contact_person_id'=>$arrResponce['invoice']['contact_persons_details'][0]['contact_person_id'],
            ];
            $arrZohoInvoiceItems = [
                'zoho_item_id'=>$arrResponce['invoice']['line_items'][0]['item_id'],
                'zoho_invoice_id'=>$arrResponce['invoice']['invoice_id'],
            ];
            if($arrZohoInvoice['invoice_id'] == "" || $arrZohoInvoiceContactPersons['contact_person_id'] == "" ||
                $arrZohoInvoiceItems['zoho_item_id'] == ""){
                $msg = "Failed To insert at Invoice!!!";
                echo '<script>alert("'.$msg.'");</script>';
                die;
            }else{
                $resTbl1 = $this->dbObject->insert('zoho_invoice',$arrZohoInvoice);
                $resTbl2 = $this->dbObject->insert('zoho_invoice_contact_persons',$arrZohoInvoiceContactPersons);
                $resTbl3 = $this->dbObject->insert('zoho_invoice_items',$arrZohoInvoiceItems);
            }
        }
        if(isset($arrResponce['code']) && $arrResponce['code']==0){
            $arrEmailParams=[
                'send_from_org_email_id'=>false,
                'to_mail_ids'=>[$arrResponce['invoice']['contact_persons_details'][0]['email']],
                //'cc_mail_ids'=>!empty($this->config['params']['invoice_cc_mail_ids'])?$this->config['params']['invoice_cc_mail_ids']:[],
                'cc_mail_ids'=>['mkt@industryarc.com',$_SESSION['email']],
                'invoice_number'=>$arrResponce['invoice']['invoice_number'],
                'invoice_id'=>$arrResponce['invoice']['invoice_id'],
                'invoice_url'=> $arrResponce['invoice']['invoice_url'],
                'invoice_date'=>date("d-M-Y",strtotime($arrResponce['invoice']['date'])),
                'amount'=>$arrResponce['invoice']['currency_symbol'].$arrResponce['invoice']['total'],
            ];
            $this->emailInovice($arrEmailParams);
        }
        //$msg = "record saved successfully";
        // echo '<script>alert("'.$msg.'");</script>';
        // echo '<script>window.location.href="listContacts.php";</script>';
    }

    function getInvoiceNumber(){
        $sql = "SELECT invoice_number FROM zoho_invoice ORDER BY invoice_number DESC LIMIT 1";
        $preInvoiceNo = $this->dbObject->getRow($sql);
        if(isset($preInvoiceNo['invoice_number']) && !empty($preInvoiceNo['invoice_number'])){
            $arrStr= explode('-',$preInvoiceNo['invoice_number']);
            list($strPrefix,$value) = $arrStr;
            $nxtValue=$value+1;
            $invoiceNo = "IARC-".str_pad($nxtValue,9,0,STR_PAD_LEFT );//str_pad($string, $length, $pad_string, $pad_type)
        }else{
            $invoiceNo = "IARC-000000001";
        }
        return $invoiceNo;
    }

    function emailInovice($arrEmailParams=[]){
        $apiInputData = [
            'send_from_org_email_id'=>$arrEmailParams['send_from_org_email_id'],
            'to_mail_ids'=>$arrEmailParams['to_mail_ids'],
            'cc_mail_ids'=>$arrEmailParams['cc_mail_ids'],
            'subject'=>"Invoice from IndustryARC (Invoice#: ".$arrEmailParams['invoice_number'].")",
            'body'=>"Dear Customer,         <br><br><br><br>Thanks for your business.         <br><br><br><br>The invoice ".$arrEmailParams['invoice_number']." is attached with this email. You can choose the easy way out and <a href=".$arrEmailParams['invoice_url'].">pay online for this invoice.</a>         <br><br>Here's an overview of the invoice for your reference.         <br><br><br><br>Invoice Overview:         <br><br>Invoice  : ".$arrEmailParams['invoice_number']."         <br><br>Date : ".$arrEmailParams['invoice_date']."         <br><br>Amount : ".$arrEmailParams['amount']."         <br><br><br><br>It was great working with you. Looking forward to working with you again.<br><br><br>\Regards<br>\IndustryArc<br>\",",
        ];

        $urlAuthKeys = "?organization_id=".$this->organizationId."&authtoken=".$this->authToken;
        $apiUrl = "https://books.zoho.com/api/v3/invoices/".$arrEmailParams['invoice_id']."/email".$urlAuthKeys;

        if(isset($apiInputData) && !empty($apiInputData)){
            $input = "JSONString=".urlencode(json_encode($apiInputData));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);//Set to return data to string ($response)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization : Zoho-authtoken '.$this->authToken.'',
                    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' )
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS,$input);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams
            curl_setopt($ch, CURLOPT_POST, true);//Regular post

            $response = curl_exec($ch);
            // $arrResponce = json_decode($response,true);
            // echo '<pre>';print_r($arrResponce);exit;
        }
        $msg = "record saved successfully";
        echo '<script>alert("'.$msg.'");</script>';
        echo '<script>window.location.href="view_zoho_books.php";</script>';
    }

    function getAllContactDetails(){
        $sql = "SELECT zcp.first_name,zcp.last_name,zcp.email,zcp.phone,zi.invoice_id,zi.invoice_date,
         zi.due_date,zi.purchage_order,zt.name,zt.price 
         FROM `zoho_contact_person` zcp INNER JOIN `zoho_invoice_contact_persons` zicp ON zicp.contact_person_id=zcp.zoho_contact_person_id
         LEFT JOIN `zoho_invoice` zi ON zi.invoice_id=zicp.invoice_id LEFT JOIN `zoho_invoice_items` zit ON zit.zoho_invoice_id=zi.invoice_id
         LEFT JOIN `zoho_items` zt ON zt.zoho_item_id=zit.zoho_item_id ";
        $res = $this->dbObject->getAllRows($sql);
        return $res;
    }
}
?>
