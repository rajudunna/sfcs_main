<!--<?php $styles_list=array("'P','K'","'L','O'","'M'","'G','U'"); $styles_names=array("Pink","Logo","M&S","Glamor"); $style_auth=array("rajanaa","srikanthb","kiranm","srikanthb"); ?> -->
<?php
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
$sql="select * from $bai_pro3.buyer_style";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$styles_list=array();
$style_auth=array();
$styles_names=array();
while($sql_row=mysqli_fetch_array($sql_result))
{
$styles_list[]=$sql_row["buyer_identity"];
$styles_names[]=$sql_row['buyer_name'];
$style_auth[]=$sql_row['user_list'];
}
?>