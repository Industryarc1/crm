<?php
try {
//$extension=$cxlogs['agent'];
$extension=$_GET['agent'];
$threeCXmobile = $_GET['threeCXmobile'];
$start = $_GET['start'];
//$link = "https://202.153.37.102:4434/3CXRecordings/$extension/";
$link = "http://infyglow.com:10234/3CXRecordings/$extension/";
//$link = "http://172.16.16.2:10234/3CXRecordings/$extension/";
$sHTML = file_get_contents($link);
$oDOMDoc = new DOMDocument();
$oDOMDoc->loadHTML($sHTML);
$oDOMNodes = $oDOMDoc->getElementsByTagName('a');
$aLinks = array();
for( $i = 0 ; $i <= $oDOMNodes->length ; $i++ )
{
    $oDOMNode = $oDOMNodes->item( $i );
    if( is_object($oDOMNode) && $oDOMNode->hasAttribute('href') )
    {
        $aLinks[] = $oDOMNode->getAttribute('href');
    }
}

$dt = new DateTime($start);
$dateStr = $dt->format('YmdH');
$farray = preg_grep("/.*_".$extension."-.*".$threeCXmobile."_".$dateStr.".*/", $aLinks);
echo "<pre>";
echo $extension."<br>";
echo $threeCXmobile."<br>";
echo $start."<br>";
print_r($farray);exit;
?>
<?php foreach($farray as $row){ ?>
<audio controls="true" >
    <source src="<?php echo $link.$row;?>" type="audio/wav" />   
</audio>
<?php }
}catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
?>