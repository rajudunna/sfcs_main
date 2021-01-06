<?php

ini_set('max_execution_time', '50000');

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$create_new_table="CREATE TABLE `bai_pro3`.`tbl_carton_ready_archive` (PRIMARY KEY(`id`),KEY `mo_check`( `mo_no` , `operation_id` ))ENGINE=INNODB  COLLATE = latin1_swedish_ci COMMENT = '' SELECT `id`, `operation_id`, `mo_no`, `remaining_qty`, `cumulative_qty` FROM `bai_pro3`.`tbl_carton_ready` ";
$create_tbl_res = mysqli_query($link,$create_new_table);
if($create_tbl_res)
{
	echo "<b><h2 style='color:pink;'>Successfully Created and Inserted new table : </h2></b></br>";
}
$get_del_mos="SELECT DISTINCT mo_no,operation_id FROM `bai_pro3`.`tbl_carton_ready` WHERE mo_no IN (SELECT mo_number FROM `m3_inputs`.deleted_mos GROUP BY mo_number) GROUP BY mo_no";
$del_mo_result = mysqli_query($link,$get_del_mos);
$sql_num=mysqli_num_rows($del_mo_result);
if($sql_num>0)
{				
	while($row_mo = mysqli_fetch_array($del_mo_result))
	{

		$deleted_mo=$row_mo['mo_no'];
		$op_code=$row_mo['operation_id'];
		$deleted_mos[$op_code][]= $deleted_mo;
	}
}
$get_code51 = "TRUNCATE `bai_pro3`.`tbl_carton_ready`";
$bcd_result51 = mysqli_query($link,$get_code51);
$count_val = 0;$count_value=0;
$get_styles="select distinct(style) as style_val,color from brandix_bts.tbl_style_ops_master group by style_val,color";
$style_result = mysqli_query($link,$get_styles);
while($row1 = mysqli_fetch_array($style_result))
{

	$style=$row1['style_val'];
	$color=$row1['color'];
    $category='sewing';
	$get_last_opn_sewing = "SELECT tbl_style_ops_master.operation_code FROM brandix_bts.tbl_style_ops_master LEFT JOIN brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$category' ORDER BY CAST(tbl_style_ops_master.operation_order AS CHAR) DESC LIMIT 1";
	// echo $get_last_opn_sewing."<br/>";
	$result_last_opn_sewing=mysqli_query($link, $get_last_opn_sewing) or exit("error while fetching pre_op_code_b4_carton_ready");
	if (mysqli_num_rows($result_last_opn_sewing) > 0)
	{
		$final_op_code=mysqli_fetch_array($result_last_opn_sewing);
		$sewing_last_opn = $final_op_code['operation_code'];
	}
	if($sewing_last_opn)
	{
		echo $style."--".$color."---".$sewing_last_opn."<br/>";
		$get_mo="SELECT mo_no FROM `bai_pro3`.`mo_details` WHERE style = '$style'  AND color = '$color' ";
		// echo $get_mo;
		$mo_result = mysqli_query($link,$get_mo);
		while($row2 = mysqli_fetch_array($mo_result))
		{
			$mo_no_vals[]=$row2['mo_no'];
		}
		$result = array_filter($mo_no_vals); 
		// var_dump($result,count($mo_no_vals));
		if(count($mo_no_vals)>0)
		{
			$mo_no_values = "'" . implode ( "', '", $mo_no_vals ) . "'";
			$moq_query = "SELECT mo_no,sum(if(op_code=$sewing_last_opn,good_quantity,0)) as output,sum(if(op_code=200,good_quantity,0)) as carton from bai_pro3.mo_operation_quantites where mo_no in ($mo_no_values) and mo_no != '' group by mo_no";
			echo "<b>".$moq_query."</b><br/>";
			$moq_result = mysqli_query($link,$moq_query);
			while($row = mysqli_fetch_array($moq_result))
			{
				$mo_no = $row['mo_no'];
				$output = $row['output'];
				$carton = $row['carton'];
				$code = $sewing_last_opn;

				if($carton==0)
				{
					$remain=$output;
				}
				else
				{
					$remain = $output-$carton;
				}
				
				if($output > 0)
				{
					$insert_qry = "INSERT INTO `bai_pro3`.`tbl_carton_ready` (`operation_id`, `mo_no`, `remaining_qty`, `cumulative_qty`) VALUES ($code, '$mo_no', $remain, $output); ";
					// $qty_inserting = mysqli_query($link,$insert_qry) or exit("While inserting mo_operation_quantites".$insert_qry."<br/>".mysqli_error($GLOBALS["___mysqli_ston"]));
					$qty_inserting = mysqli_query($link,$insert_qry);
					if($qty_inserting)
					{
						$count_val++;
						echo "<h4 style='color:green;'>successfully inserted : </h4>".$count_val."-".$insert_qry."</br>";
						if($count_val == 1)
						{
							foreach ($deleted_mos as $op_code1 => $value1) 
							{
								foreach ($value1 as $value) 
								{
									$mo_no_val .= "'".$value."',";
								}
								$del_mo_val = rtrim($mo_no_val, ",");
								$moq_query_del = "SELECT mo_no,sum(if(op_code=$op_code1,good_quantity,0)) as output,sum(if(op_code=200,good_quantity,0)) as carton from bai_pro3.mo_operation_quantites where mo_no in ($del_mo_val) and mo_no != '' group by mo_no";
								echo $moq_query_del;
								$moq_res_del = mysqli_query($link,$moq_query_del);
								while($row_del = mysqli_fetch_array($moq_res_del))
								{
									$mo_no1 = $row_del['mo_no'];
									$output1 = $row_del['output'];
									$carton1 = $row_del['carton'];
									$code1 = $op_code1;

									if($carton1==0)
									{
										$remain1=$output1;
									}
									else
									{
										$remain1 = $output1-$carton1;
									}
									
									if($output1 > 0)
									{
										$insert_qry1 = "INSERT INTO `bai_pro3`.`tbl_carton_ready` (`operation_id`, `mo_no`, `remaining_qty`, `cumulative_qty`) VALUES ($code1, '$mo_no1', $remain1, $output1); ";
										$qty_inserting1 = mysqli_query($link,$insert_qry1);
										if($qty_inserting1)
										{
											$count_val++;
											echo "<h4 style='color:blue;'>successfully inserted : deleted mo's</h4>".$count_val."-".$insert_qry1."</br>";
										}
										else
										{
											$count_value++;
											echo "<h4 style='color:brown;'>Failed to insert : deleted mo's</h4>".$count_value."-".$insert_qry1."</br>";
										}
									}
								}
								unset($mo_no_val);
								unset($del_mo_val);
								unset($op_code1);
							}
						}
					}
					else
					{
						$count_value++;
						echo "<h4 style='color:red;'>Failed to insert : </h4>".$count_value."-".$insert_qry."</br>";
					}	
				}

			}
		}
		unset($mo_no_vals);
		unset($mo_no_values);
		unset($sewing_last_opn);
	}
}

echo "Script Completed Successfully";
?>