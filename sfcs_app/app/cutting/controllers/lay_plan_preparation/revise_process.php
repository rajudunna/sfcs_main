<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions2.php',2,'R'));?>

<html>
<head>
<style>
div.block
{
	float: left;	
	padding: 30 px;
}
</style>

<script type="text/javascript" src="../../js/check.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>


<body onload="javascript:dodisable();">

<div class="panel panel-primary">
<div class="panel-heading">Revise Process</div>
<div class="panel-body">
<?php


$allocate_ref=$_GET['allocate_ref'];
$tran_order_tid=$_POST['tran_order_tid'];

$sql="update $bai_pro3.allocate_stat_log set mk_status=3 where tid=$allocate_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="select * from $bai_pro3.bai_orders_db where order_tid=(select order_tid from $bai_pro3.allocate_stat_log where tid=$allocate_ref)";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	$style=$sql_row['order_style_no'];
	$schedule=$sql_row['order_del_no'];
}

$rurl = getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=".$color."&style=".$style."&schedule=".$schedule;
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() { 
		Ajaxify('".$rurl."'); 
	 }</script>";


?>

</div></div>
</body>
</html>