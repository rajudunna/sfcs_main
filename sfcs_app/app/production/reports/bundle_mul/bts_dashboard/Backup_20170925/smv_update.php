
<?php
include("dbconf.php");
?>

<?php
$sql="select * from $view_set_2_snap where smv=0";
$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//echo mysql_num_rows($sql_result2);

while($sql_row2=mysqli_fetch_array($sql_result2))
{

	//$smv=echo_title("bai_pro3.bai_orders_db_confirm","smv","order_col_des='".$sql_row2['tbl_orders_sizes_master_order_col_des']."' and order_del_no",$sql_row2['tbl_orders_master_product_schedule'],$link);
	
	$sql13="select smv from bai_pro3.bai_orders_db_confirm where order_col_des='".$sql_row2['tbl_orders_sizes_master_order_col_des']."' and order_del_no='".$sql_row2['tbl_orders_master_product_schedule']."'";
	$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row13=mysqli_fetch_array($sql_result13))
	{
		$smv=$sql_row13['smv'];
	}
	//echo $sql_row2['tbl_orders_master_product_schedule']."--".$smv."<br>";	
	if($smv>0)
	{
		$sql1="update $view_set_2_snap set smv='".$smv."' where tbl_orders_sizes_master_id='".$sql_row2['tbl_orders_sizes_master_id']."'";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql1."<br>";
		$sql2="select * from $view_set_snap_1_tbl where view_set_2_snap_smv=0 and bundle_transactions_20_repeat_operation_id=4 and tbl_miniorder_data_color='".$sql_row2['tbl_orders_sizes_master_order_col_des']."' and tbl_orders_master_product_schedule='".$sql_row2['tbl_orders_master_product_schedule']."'";
		$sql_result3=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql2."<br>"; 	
		//echo mysql_num_rows($sql_result3)."<br>";
		
		if(mysqli_num_rows($sql_result3)>0)
		{
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$sah=round(($sql_row3['bundle_transactions_20_repeat_quantity']*$smv)/60,2);
				$sql3="update $view_set_snap_1_tbl set sah='".$sah."',view_set_2_snap_smv='".$smv."' where bundle_transactions_20_repeat_bundle_barcode='".$sql_row3['bundle_transactions_20_repeat_bundle_barcode']."'";
				$sql_result4=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			}
		}
		$sql21="select * from bai_pro.bai_log where smv=0 and bac_qty<>0 and delivery='".$sql_row2['tbl_orders_master_product_schedule']."' and color='".$sql_row2['tbl_orders_sizes_master_order_col_des']."'";
		$sql_result31=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql2."<br>"; 	
		//echo mysql_num_rows($sql_result3)."<br>";
		
		if(mysqli_num_rows($sql_result31)>0)
		{
			while($sql_row31=mysqli_fetch_array($sql_result31))
			{
				//$sah=round(($sql_row3['bundle_transactions_20_repeat_quantity']*$smv)/60,2);
				$sql31="update bai_pro.bai_log set smv='".$smv."' where smv=0 and bac_qty<>0 and delivery='".$sql_row2['tbl_orders_master_product_schedule']."' and color='".$sql_row2['tbl_orders_sizes_master_order_col_des']."'";
				$sql_result41=mysqli_query($link, $sql31) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql32="update bai_pro.bai_log_buf set smv='".$smv."' where smv=0 and bac_qty<>0 and delivery='".$sql_row2['tbl_orders_master_product_schedule']."' and color='".$sql_row2['tbl_orders_sizes_master_order_col_des']."'";
				$sql_result42=mysqli_query($link, $sql32) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			}
		}
	}
	
}

$bundle_id=array();
$sql2="select bai_pro_ref from bai_pro3.ims_log where ims_status='EPR'";
//echo $sql2."<br>";
$sql_result3=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result3)>0)
{
	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		$bundle_id[]=$sql_row3['bai_pro_ref'];
	}
}
//echo sizeof($bundle_id)."<br>";
$bundle_id_tmp=array();
$sql2="select * from brandix_bts.bundle_transactions_20_repeat where operation_id='2' and bundle_id in (".implode(",",$bundle_id).")";
//echo $sql2."<br>";
$sql_result3=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result3)>0)
{
	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		$bundle_id_tmp[]=$sql_row3['bundle_id'];
	}
	$sql3="insert ignore into bai_pro3.ims_log_ems select * from bai_pro3.ims_log where bai_pro_ref in (".implode(",",$bundle_id_tmp).")";
$sql_result4=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//echo $sql3."<br>";
$sql3="delete from bai_pro3.ims_log where bai_pro_ref in (".implode(",",$bundle_id_tmp).")";
$sql_result4=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

//echo $sql3."<br>";
echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";

?>