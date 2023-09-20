<?php
session_start();
error_reporting(0);
include_once('../model/zohofunction.php');
$zohofunctions = new zohofunctions();

if(isset($_POST['contact_name']) && isset($_POST['company_name'])) {
    $arrInputs = [];
    if(isset($_POST['contact_type']) && isset($_POST['is_portal_enabled'])){
        $arrInputs['contact_details']=[
            'contact_name'=>$_POST['contact_name'],
            'company_name'=>$_POST['company_name'],
            'website'=>$_POST['website'],
            'purchase_order'=>$_POST['purchase_order'],
            'notes'=>$_POST['notes'],
            'currency_id'=>$_POST['currency_id'],
            'contact_type'=>"customer",
            'is_portal_enabled'=>true,
            'payment_terms'=>15,
            'payment_terms_label'=>"Net 15",
            'billing_address'=>$_POST['billing_address'],
            'shipping_address'=>(!empty($_POST['sameShipAddr']) && $_POST['sameShipAddr']==true)?$_POST['billing_address']:$_POST['shipping_address'],
            'contact_persons'=>[$_POST['contact_persons']],
        ];
        //echo '<pre>';print_r($arrInputs);exit;
    }
    if(isset($_POST['item_details']) && !empty($_POST['item_details'])){
        $arrInputs['item_details']=[
            'name'=>$_POST['item_details']['name'],
            'rate'=>$_POST['item_details']['rate'],
        ];
    }
    if(isset($_POST['inovice_details']) && !empty($_POST['inovice_details'])){
        $arrInputs['inovice_details']=[
            'invoice_number'=>$_POST['inovice_details']['invoice_number'],
            'discount'=>$_POST['inovice_details']['discount'],
            'due_date'=>date('Y-m-d',strtotime($_POST['inovice_details']['due_date'])),
        ];
    }
    //echo '<pre>';
    //print_r($arrInputs);
    $zohofunctions->createZohoContact($arrInputs);
    //print_r($zohofunctions);exit;
}
?>