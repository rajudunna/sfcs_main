<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$mo_qty=array();
$Required_Qty=array();
$sql22="SELECT order_style_no,order_del_no,order_col_des,cs.order_tid,cs.compo_no as comp,cs.order_tid2 as tid2 FROM bai_pro3.bai_orders_db AS bd LEFT JOIN bai_pro3.cat_stat_log AS cs ON cs.order_tid=bd.order_tid ";
$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row22=mysqli_fetch_array($sql_result22))
{	
	$ssc_code2=$sql_row22['tid2'];
	$style=$sql_row22['order_style_no'];					
	$sch_no=$sql_row22['order_del_no'];					
	$color=$sql_row22['order_col_des'];					
	$compo_no=$sql_row22['comp'];					
	$tid2=$sql_row22['tid2'];		

	$order_yy=0;
	$sql312="select MO_NUMBER,MO_Qty,Required_Qty from $m3_inputs.order_details where Style='".$style."' and Schedule='".$sch_no."' and GMT_Color='".$color."' and Item_Code='".$compo_no."'";

	$sql_result312=mysqli_query($link, $sql312) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row312=mysqli_fetch_array($sql_result312))
	{
		$mo_qty[$sql_row312['MO_NUMBER']]=$sql_row312['MO_Qty'];
		$Required_Qty[]=$sql_row312['Required_Qty'];
	}	
	$order_yy=round(array_sum($Required_Qty)/array_sum($mo_qty),4);

	$sql3="update $bai_pro3.cat_stat_log set catyy=$order_yy where order_tid2='".$ssc_code2."'";
	echo $sql3."<br></br>";
	mysqli_query($link, $sql3) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	unset($mo_qty);
	unset($Required_Qty);	
}

?>