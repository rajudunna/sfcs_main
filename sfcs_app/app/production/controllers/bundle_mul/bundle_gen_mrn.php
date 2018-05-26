<?php include("../../packing/dbconf2.php"); ?>
<?php include("../../packing/functions.php"); ?>	

<?php
set_time_limit("5000000");

if($_GET['ops']==1)
{
	$mini_order_id=$_GET['mini_order_num'];
	$mini_order_ref_id=$_GET['mini_order_ref'];
	?>
	<?php


	$html = '<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
	body {font-family: arial;
		font-size: 20px;
	}

	.new_td
	{
		font-size:20px;
	}

	.new_td2
	{
		font-size:22px;
		font-weight: bold;
	}

	.new_td3
	{
		font-size:22px;
		font-weight: bold;
	}

	table
	{
		margin-left:auto;
		margin-right:auto;
		margin-top:auto;
		margin-bottom:auto;
	}
	@page {
	margin-top: 10px; 

	}

	</style>
	</head>
	<body>';

	$operation_id=array();
	$operation_code=array();
	
	$sql="SELECT brandix_bts.tbl_min_ord_ref.ref_crt_schedule AS sch_id FROM brandix_bts.`tbl_miniorder_data` AS tbl_miniorder_data 
	LEFT JOIN brandix_bts.tbl_min_ord_ref AS tbl_min_ord_ref ON tbl_min_ord_ref.id=tbl_miniorder_data.mini_order_ref 
	where brandix_bts.tbl_miniorder_data.mini_order_ref='".$mini_order_ref_id."' group by sch_id";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rowval=mysqli_fetch_array($sql_result))
	{
		$sch_id=$rowval['sch_id'];
	}
	
	
		$sql1="select * from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id in (1) order by ops_order*1";
		
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result1))
	{
		$operation_id[]=$row1['id'];
		$operation_code[]=$row1['operation_code'];
	}
	
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
	where brandix_bts.tbl_miniorder_data.mini_order_num=".$mini_order_id." and brandix_bts.tbl_miniorder_data.mini_order_ref='".$mini_order_ref_id."' 
	 group by 
	 brandix_bts.tbl_orders_style_ref.product_style,brandix_bts.tbl_orders_master.product_schedule,brandix_bts.tbl_miniorder_data.color,brandix_bts.sizes.size_name
	 order by brandix_bts.tbl_miniorder_data.color,brandix_bts.tbl_miniorder_data.size";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo "<table>";
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
		//$col_code=$sql_row['col_code'];
		//$cut_code="A001";
		//$cut_code=$cut_num;
		
				
		for($ii=0;$ii<sizeof($operation_id);$ii++)
		{
			$i=$operation_id[$ii];
			$ops=$operation_code[$ii];
			
			{
				$barcode_value =str_pad($row2['bundle'],7,"0",STR_PAD_LEFT)."-".str_pad($i,2,"0",STR_PAD_LEFT);
				
				//$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.$barcode_value.'" type="C39" height="0.80" size="1.3" text="1"></td></tr>';
				$html.= '<tr><td>Style:  </td><td><b>'.$style.'</b></td><td>Schedule :</td><td><b>'.$schedule.'</b> </td>';
				$html.= '<td>Cut:<b>'.$cut_code.'--'.$docket_no.'</b></td><td>size : <b>'.$row2['size_title'].'--'.$sfcs_size.'</b></td><td>Qty:<b>'.$row2['quantity'].'</b></td><td>Op : <b>'.$ops.'</b></td>';
				//$html.= '<tr><td>Color</td><td class="new_td" colspan="4"><b>'.$color.'</b></td><td>M-'.$mini_order_id.'</td></tr></table></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr></table>';
				$html.= '<td>Color</td><td  class="new_td" colspan="2"><b>'.$color.'</b></td><td>M: '.$row2['mini_order_num'].'</td></td><td width="37px" text-rotate="90" align="center">'.$barcode_value.'</td></tr>';
				
			}
			
			
			//M3 BULK OR Reporting
			
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
			
	}
	
}

$html.='</table></body></html>';
	
	
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

echo $html;

header("location: bundle_ticket_mrn.php?style=$style_id&schedule=$schedule_id");

?>