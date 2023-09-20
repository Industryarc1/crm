<?php
session_start();
include_once('../model/function.php');
$functions = new functions();
$dates=array();
$array = $functions->getAllleads();
$i=0;
foreach ($array as $arr){
    $dates[$i]['id']=$arr['id'];
    $dates[$i]['title']='Next followup';
    $dates[$i]['start']=$arr['next_followup_date'];
    $dates[$i]['description']=$arr['txt_comments'];
    $dates[$i]['url']='contact_details.php?lead_id='.base64_encode($dates[$i]['id']);
    $i++;
}
$tasks=$functions->getAllTasks();
foreach ($tasks as $tas){
    $dates[$i]['id']=$tas['lead_id'];
    $dates[$i]['title']='Tasks';
    $dates[$i]['start']=$tas['date'];
    $dates[$i]['description']=$tas['task'];
    $dates[$i]['url']='assigned_to_me.php';
    $i++;
}
echo json_encode($dates);
?>


