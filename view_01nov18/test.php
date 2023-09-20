<?php
/*     session_start();
	include_once('../model/function.php');
	$functions = new functions();
    $email='monali@gmail.com';

	$whr=array('email'=>$email);
	$data=$functions->getleadbyFilter($whr);
	$arrCount = count($data);

	if($arrCount>=1){
		echo "Email exits"."<br>";
        $whr=array('email'=>$email,'report_code'=>'ITR 0071');
        $reportdata=$functions->getleadbyFilter($whr);
        $Count = count($reportdata);

        if($Count>=1){
            echo "with same report";
        }else{
            echo "with different report";
        }

	}else{
		echo "no";
	}
	echo "<pre>";
	//print_r($data);
//In function.php
function getleadbyFilter($whr)
{
    $roleQuery = $this->dbObject->selectQuery('leads', '*', $whr, '', '', '', '');
    $result = $this->dbObject->getAllRows($roleQuery);
    return $result;
}
*/?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style>
    tr {
        width: 100%;
        display: inline-table;
        height:60px;
  overflow-y: scroll;
    }

    table{
        height:300px;

    }
    tbody{
        overflow-y: scroll;
        height: 200px;
        width: 100%;
        position: absolute;
    }
</style>
<body>
<section class="">
    <div class="container">

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Col1</th>
                <th>Col2</th>
                <th>Col3</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>   <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>   <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>
            <tr>
                <td>info</td>
                <td>info</td>
                <td>info</td>
            </tr>


            </tbody>
        </table>
    </div>
</section>
</body>
<script>
    var tableOffset = $("#table-1").offset().top;
    var $header = $("#table-1 > thead").clone();
    var $fixedHeader = $("#header-fixed").append($header);

    $(window).bind("scroll", function() {
        var offset = $(this).scrollTop();

        if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
            $fixedHeader.show();
        }
        else if (offset < tableOffset) {
            $fixedHeader.hide();
        }
    });
</script>