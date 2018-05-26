<?php include("../../packing/dbconf2.php"); ?>
<?php include("../../packing/functions.php"); ?>	

<?php
set_time_limit("5000000");

if($_GET['ops']==2)
{
	$mini_order_id=$_GET['mini_order_num'];
	$doc_id=$_GET['doc_no'];
	$table_name="bai_pro3.plandoc_stat_log";
	$sql11="select * from $table_name where org_doc_no='".$doc_id."'";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result11))
	{
		$doc_no[]=$row1['doc_no'];
	}
	$sql1="select * from tbl_cut_master where doc_num in (".implode(",",$doc_no).")";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result1))
	{
		$schedule_temp[]=$row['product_schedule'];
	}
	for($i=0;$i<sizeof($doc_no);$i++)
	{	
		$sql="SELECT brandix_bts.tbl_orders_style_ref.id AS style_id,brandix_bts.tbl_orders_style_ref.product_style,brandix_bts.tbl_orders_master.product_schedule, brandix_bts.tbl_orders_master.id as schedule_id,
		 brandix_bts.tbl_miniorder_data.id,brandix_bts.tbl_miniorder_data.mini_order_ref, brandix_bts.tbl_miniorder_data.mini_order_num,
		 brandix_bts.tbl_miniorder_data.bundle_number AS bundle,brandix_bts.tbl_miniorder_data.cut_num,brandix_bts.tbl_miniorder_data.color,
		 brandix_bts.tbl_miniorder_data.color AS color_code,brandix_bts.tbl_orders_sizes_master.size_title, brandix_bts.sizes.size_name AS size,
		 brandix_bts.sizes.id AS size_id,brandix_bts.tbl_miniorder_data.bundle_number,sum(brandix_bts.tbl_miniorder_data.quantity) AS quantity,
		 brandix_bts.tbl_miniorder_data.docket_number AS docket_number,
		 brandix_bts.tbl_miniorder_data.planned_module AS planned_module,
		 brandix_bts.tbl_miniorder_data.plan_date AS plan_date 	 
		 FROM brandix_bts.`tbl_miniorder_data` AS tbl_miniorder_data 
		 LEFT JOIN brandix_bts.tbl_orders_size_ref sizes ON sizes.id=brandix_bts.tbl_miniorder_data.size 
		 LEFT JOIN brandix_bts.tbl_min_ord_ref AS tbl_min_ord_ref ON tbl_min_ord_ref.id=brandix_bts.tbl_miniorder_data.mini_order_ref 
		 LEFT JOIN brandix_bts.`tbl_orders_master` AS tbl_orders_master ON `tbl_orders_master`.`id`=brandix_bts.tbl_min_ord_ref.ref_crt_schedule 
		 LEFT JOIN brandix_bts.tbl_orders_style_ref AS tbl_orders_style_ref ON tbl_orders_style_ref.id=brandix_bts.tbl_min_ord_ref.ref_product_style 
		LEFT JOIN brandix_bts.`tbl_orders_sizes_master` AS tbl_orders_sizes_master ON `tbl_orders_master`.`id`=brandix_bts.tbl_orders_sizes_master.parent_id AND tbl_miniorder_data.color=brandix_bts.tbl_orders_sizes_master.order_col_des AND tbl_miniorder_data.size=brandix_bts.tbl_orders_sizes_master.ref_size_name
		where brandix_bts.tbl_miniorder_data.mini_order_num=".$mini_order_id." and brandix_bts.tbl_miniorder_data.docket_number='".$doc_no[$i]."' 
		 group by 
		 brandix_bts.tbl_orders_style_ref.product_style,brandix_bts.tbl_orders_master.product_schedule,brandix_bts.tbl_miniorder_data.color,brandix_bts.sizes.size_name
		 order by brandix_bts.tbl_miniorder_data.color,brandix_bts.tbl_miniorder_data.size";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//echo "<table>";
		while($row2=mysqli_fetch_array($sql_result))
		{	
			$style_id=$row2['style_id'];
			$style=$row2['product_style'];
			$schedule=$row2['product_schedule'];
			$schedule_id=$row2['schedule_id'];
			$color=$row2['color'];
			$cut_code=$row2['cut_num'];
			$docket_no=$row2['docket_number'];
			$sfcs_size=$row2['size'];
			$sql="	INSERT INTO `m3_bulk_ops_rep_db`.`m3_sfcs_tran_log` 
					(`sfcs_date`, 
					`sfcs_style`, 
					`sfcs_schedule`, 
					`sfcs_color`, 
					`sfcs_size`, 
					`m3_size`, 
					`sfcs_doc_no`, 
					`sfcs_qty`, 
					`sfcs_log_user`, 
					 `m3_op_code`, 
					`sfcs_job_no`, 
					`sfcs_mod_no`, 
					`sfcs_shift`, 
					`m3_op_des`, 
					`sfcs_tid_ref`
					)
					VALUES
					(NOW(), 
					'$style', 
					'$schedule', 
					'$color', 
					'$sfcs_size', 
					'".$row2['size_title']."', 
					'$docket_no', 
					'".$row2['quantity']."', 
					USER(), 
					'1', 
					'$cut_code', 
					'".$row2['planned_module']."', 
					'".substr($row2['plan_date'],10)."', 
					'MRN_RE01', 
					'".$row2['mini_order_num']."' 
					)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		//$schedule = echo_title("brandix_bts.tbl_cut_master","product_schedule","doc_num",$doc_no[$i],$link);
		$sql="select Cust_order from bai_pro2.shipment_plan where style_no='$style' and schedule_no='$schedule'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($sql_result))
		{
			$cust_order_no=$row2['Cust_order'];
		}
		
		if(mysqli_num_rows($sql_result)==0)
		{
			$sql="select Cust_order from bai_pro2.shipment_plan_summ where style_no='$style' and schedule_no='$schedule'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($sql_result))
			{
				$cust_order_no=$row2['Cust_order'];
			}
		}
		
		$sql="INSERT INTO `m3_bulk_ops_rep_db`.`m3_sfcs_mrn_log` 
		(
		`sfcs_style`, 
		`sfcs_schedule`, 
		`minord_no`, 
		`inserted_time` ,
		customer_order
		
		)
		VALUES
		(
		'$style', 
		'$schedule', 
		'$mini_order_id', 
		now(),
		'$cust_order_no'
		)
		";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		header("location: bundle_ticket_mrn.php?style=$style_id&schedule=$schedule_id");
	}
}	

	
	

?>