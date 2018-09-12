<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(1000000);

$sql="SELECT order_style_no,order_col_des,REPLACE(order_tid,' ','')AS order_tid FROM $bai_pro3.bai_orders_db GROUP BY order_style_no,order_col_des ORDER BY order_style_no,order_col_des";
// echo $sql;
$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result))
{
	$style=$sql_row["order_style_no"];
	$color=$sql_row["order_col_des"];
	$order_tid_new = $sql_row['order_tid'];
	//$bundle_creation_data_check="select * from $brandix_bts.tbl_style_ops_master where style='".$style."' and color='".$color."' ";
	$bundle_creation_data_check = "select * from $bai_pro3.plandoc_stat_log where REPLACE(order_tid,' ','') ='".$order_tid_new."'";
	$bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
	//echo $bundle_creation_data_check.'</br>';
	if(mysqli_num_rows($bundle_creation_data_check_result)==0)
	{
		$tbl_style_ops_master_delete="delete from $brandix_bts.tbl_style_ops_master where style='".$style."' and color='".$color."' ";
		mysqli_query($link, $tbl_style_ops_master_delete) or exit("Sql Error tbl_style_ops_master_delete".mysqli_error($GLOBALS["___mysqli_ston"]));
		$select_default_operations="select * from $brandix_bts.default_operation_workflow";
		$select_default_operations_result=mysqli_query($link, $select_default_operations) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($select_default_operations_row=mysqli_fetch_array($select_default_operations_result))
		{
			//getting m3_smv from schedule_oprations_master
			$ops_code = $select_default_operations_row['operation_code'];
			$qty_to_fetch_m3_smv = "SELECT * FROM `$bai_pro3`.`schedule_oprations_master` WHERE style = '$style' AND Description='$color' AND OperationNumber = '$ops_code' LIMIT 0,1";
			if($ops_code == 130)
			{
				echo $qty_to_fetch_m3_smv.'</br>';
			}
			$select_qty_to_fetch_m3_smv=mysqli_query($link, $qty_to_fetch_m3_smv) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($select_qty_to_fetch_m3_smv)==0)
			{
				$m3_smv = '0.00';
			}
			else
			{
				while($select_qty_to_fetch_m3_smv_row=mysqli_fetch_array($select_qty_to_fetch_m3_smv))
				{
					$m3_smv = $select_qty_to_fetch_m3_smv_row['SMV']; 
				}
			}
			$tbl_style_ops_master_insert="insert ignore $brandix_bts.tbl_style_ops_master(parent_id,operation_name,operation_order,style,color, operation_code,default_operration,ops_sequence,barcode,ops_dependency,smv,m3_smv) values('".$select_default_operations_row['id']."','".$select_default_operations_row['operation_name']."','".$select_default_operations_row['operation_order']."','".$style."','".$color."','".$select_default_operations_row['operation_code']."','".$select_default_operations_row['default_operration']."','".$select_default_operations_row['ops_sequence']."','".$select_default_operations_row['barcode']."','".$select_default_operations_row['ops_dependency']."','".$m3_smv."','".$m3_smv."')";
			echo "1=".$tbl_style_ops_master_insert."<br>";
			mysqli_query($link, $tbl_style_ops_master_insert) or exit("Sql Error tbl_style_ops_master_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"ssc_porcess4.php\"; }</script>";
print( "Operations Successfully Integrated")."\n";
print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>


