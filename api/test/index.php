<?php
//$link = "https://202.153.37.102:4434/3CXRecordings/120/";
$link = "http://infyglow.com:10234/3CXRecordings/120/";
//$link = "http://172.16.16.2:10234/3CXRecordings/120/";
error_reporting(E_ALL);
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

$farray = preg_grep("/.*_120-.*919000728610_20181213.*/", $aLinks);
echo "<pre>";
//print_r($files);
//print_r( $aLinks );
print_r ($farray);

?>
<?php foreach($farray as $row){ ?>
<audio controls="true" autoplay="true">
    <source src="<?php echo $link.$row;?>" type="audio/wav" />   
</audio>
<?php } ?>