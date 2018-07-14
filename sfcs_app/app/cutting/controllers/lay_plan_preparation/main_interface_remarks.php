<!--
Code Module:To display the Sample Remarks

Description:Sample remarks will be shown here.

Changes Log:
-->
<?php

$sql="select remarks,binding_con from $bai_pro3.bai_orders_db_remarks where order_tid=\"$tran_order_tid\"";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row=mysqli_fetch_array($sql_result))
{
	$remarks_x=$sql_row['remarks'];
	$remarks_y=$sql_row['remarks'];
	$bind_con = $sql_row['binding_con'];
}
if(mysqli_num_rows($sql_result)==0)
{
	$remarks_y="N/A";	
	$bind_con = 0;
}
echo "<a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "edit_remarks.php", "N")."&tran_order_tid=".$tran_order_tid."&style=".$style."&schedule=".$schedule."&bind_con=".$bind_con."&remarks_x=".$remarks_x."&color=".$color."\">Click Here</a>";



?>
