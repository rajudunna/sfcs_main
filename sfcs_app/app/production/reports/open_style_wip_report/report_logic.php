<?php
	error_reporting(0);
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$sum ='';
	$asum ='';  
	foreach($sizes_array as $size)
	{
		$sum.= $size." + ";
		$asum.= "order_s_".$size." + ";
	}
	$operation_code = [];
	$opertion_names = [];
	$wip_quantity = [];
	$main_quantity = [];
	$wip = [];
	$operation = [];
	$style = '';
	$schedule = '';
	$color = '';
	$size = '';
	$order_qty = '';
	$cono = '';
	$ops_seq = '';
	$seq_id = '';
	$ops_order = '';
	$main_good_qty =[];
	$main_rejected_qty = [];
	$bcd_good_qty1 = [];
	$bcd_rejected_qty1 = [];
	$main_data = [];
	$order_tid_wip = [];
	$pre_op_code = 0;
	//To get default Operations
    $get_operations_workflow= "SELECT tsm.operation_code AS operation_code,tor.operation_name AS operation_name FROM $brandix_bts.default_operation_workflow tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tsm.operation_code=tor.operation_code WHERE tor.display_operations='yes' 
	GROUP BY tsm.operation_code ORDER BY LENGTH(tsm.operation_order)";
	$result1 = $link->query($get_operations_workflow);
    $op_count = mysqli_num_rows($result1);
    if($op_count>0)
    {
        while($row3 = $result1->fetch_assoc())
        {
            $operation_code[] = $row3['operation_code'];
			$opertion_names[] = ['op_name'=>$row3['operation_name'],'op_code'=>$row3['operation_code']];
            $ops_get_code[$row3['operation_code']] = $row3['operation_name'];
        }
	}
	
	$operation_codes_str = implode(',',$operation_code);
    //To get operation names
    $get_ops_query = "SELECT operation_code FROM $brandix_bts.tbl_style_ops_master where operation_code not in ($operation_codes_str) group by operation_code";
	$ops_query_result=$link->query($get_ops_query);
    $op_count1 = mysqli_num_rows($ops_query_result);
    if($op_count1 >0)
    {       
        while ($row4 = $ops_query_result->fetch_assoc())
        {
            $get_operations_workflow1= "SELECT operation_name as operation_name FROM $brandix_bts.tbl_orders_ops_ref where operation_code=".$row4['operation_code']." and display_operations='yes'";
			$result1 = $link->query($get_operations_workflow1);
			$op_count12 = mysqli_num_rows($result1);
			if($op_count12 >0)
			{ 
				while($row31 = $result1->fetch_assoc())
				{
					$operation_code[] = $row4['operation_code'];
					$opertion_names[] = ['op_name'=>$row31['operation_name'],'op_code'=>$row4['operation_code']];
					$ops_get_code[$row4['operation_code']] = $row31['operation_name'];
				}
			}			
        }
    }
	$today=date("Y-m-d");
	$get_temp_qry ="select style,schedule,color,size_title From $brandix_bts.bundle_creation_data_temp Where  date_time between '$today 00:00:00' and '$today 23:59:59' group by style,schedule,color,size_title ";
	$get_temp_data_res =$link->query($get_temp_qry);
	while ($temp_res = $get_temp_data_res->fetch_assoc())
	{
		$style1 = $temp_res['style'];
		$schedule1 = $temp_res['schedule'];
		$color1 = $temp_res['color'];
		$size1 = $temp_res['size_title'];
		$order_tid_wip[] = $style1."-".$schedule1."-".$color1."-".$size1;
	}
	$get_style_wip_data="select style,schedule,color,size FROM $brandix_bts.open_style_wip where style<>'' and status='open' group by style,schedule,color,size";
	//echo $get_style_wip_data."<br>";
	$get_style_data_result =$link->query($get_style_wip_data);
	while ($row1 = $get_style_data_result->fetch_assoc())
	{
		$style = $row1['style'];
		$schedule = $row1['schedule'];
		$color = $row1['color'];
		$size = $row1['size'];
		$order_tid_wip[] = $style."-".$schedule."-".$color."-".$size;
	}
	$final = array_unique($order_tid_wip);
	foreach ($final as $key => $value) 
	{
		$val = explode("-", $value);
		// var_dump($val);
		$style = $val[0];
		$schedule = $val[1];
		$color = $val[2];
		$size = $val[3];
		//$operation[] = $row1['operation_code'];
		$get_size_title = "SELECT order_quantity FROM $brandix_bts.`tbl_orders_sizes_master` AS ch LEFT JOIN $brandix_bts.`tbl_orders_master` AS p ON p.id=ch.parent_id 
		WHERE p.product_schedule='$schedule' AND ch.order_col_des='$color' AND ch.size_title='$size' limit 1";
		//echo $get_size_title."<br>";
		$get_size_title_result =$link->query($get_size_title);
		while ($row110 = $get_size_title_result->fetch_assoc())
		{
			$order_qty = $row110['order_quantity']; 
		}
		//To get Order Qty
		$get_order_qty="select co_no from $bai_pro3.bai_orders_db_confirm where order_style_no='$style' and order_del_no='$schedule' and order_col_des='$color' ";
		//echo $get_order_qty."<br>";
		$get_order_result =$link->query($get_order_qty);
		while ($row5 = $get_order_result->fetch_assoc())
		{
			$cono = $row5['co_no'];
		}
		
		foreach ($operation_code as $key => $value) 
		{
			$main_good_qty[$value] = 0;
			$main_rejected_qty[$value] = 0;
			$bcd_good_qty1[$value] = 0;
			$bcd_rejected_qty1[$value] = 0;
			$bcd_rec[$value] =0;
			$bcd_rej[$value] =0;
		}
		$single_data = ['style'=>$style,'schedule'=>$schedule,'color'=>$color,'size'=>$size,'cono'=>$cono,'orderqty'=>$order_qty];
		
		$get_qty_data = "select COALESCE(SUM(good_qty),0) as good_qty,COALESCE(SUM(rejected_qty),0) as rejected_qty,operation_code From $brandix_bts.open_style_wip where style='$style' and schedule='$schedule' and color='$color' and size='$size' group by operation_code";
		//echo $get_qty_data."<br>";
		$get_qty_result =$link->query($get_qty_data);
		while ($row2 = $get_qty_result->fetch_assoc())
		{
			$main_good_qty[$row2['operation_code']] = $row2['good_qty'];
			$main_rejected_qty[$row2['operation_code']] = $row2['rejected_qty'];
		}
		
		$get_temp_data ="select COALESCE(SUM(recevied_qty),0) as good_qty,COALESCE(SUM(rejected_qty),0) as rejected_qty,operation_id From $brandix_bts.bundle_creation_data_temp Where style='$style' and schedule='$schedule' and color='$color' and size_title='$size' and date(date_time) = '$today' group by operation_id";
		//echo $get_temp_data."<br>";
		$get_temp_data_result =$link->query($get_temp_data);
		while ($row = $get_temp_data_result->fetch_assoc())
		{
			$bcd_good_qty1[$row['operation_id']] = $row['good_qty'];
			$bcd_rejected_qty1[$row['operation_id']] = $row['rejected_qty'];
		}

		//To get default Operations for WIP
		$get_operations_workflow_wip="SELECT tsm.operation_code AS operation_code,tsm.operation_order AS operation_order FROM $brandix_bts.tbl_style_ops_master tsm 
		LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style' AND color='$color' AND tor.display_operations='yes' GROUP BY tsm.operation_code ORDER BY LENGTH(tsm.operation_order)";
		//echo $get_operations_workflow_wip."<bR>";
		$result123 = $link->query($get_operations_workflow_wip);
		$op_count1 = mysqli_num_rows($result123);
		if($op_count1>0)
		{
			while($row345 = $result123->fetch_assoc())
			{
				$operation_code1[] = $row345['operation_code'];
				$ops_order1[$row345['operation_code']] = $row345['operation_order'];
			}
		}
		$i=1;		
		foreach ($operation_code1 as $key => $value) 
		{
			$diff = 0;
			$good = 0;
			$bad = 0;
			$pre_qty = 0;
			$good=$main_good_qty[$value]+$bcd_good_qty1[$value];
			$bad=$main_rejected_qty[$value]+$bcd_rejected_qty1[$value];
			if($i == 1)
			{
				$diff = $order_qty -($good+$bad);
				if($diff < 0)
				{
					$diff = 0;
				}			
			}
			else
			{   
				$post_ops_check = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
				LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND CAST(tsm.operation_order AS CHAR) < '$ops_order1[$value]' GROUP BY tsm.operation_code ORDER BY LENGTH(tsm.operation_order) DESC limit 1";
				$result_post_ops_check = $link->query($post_ops_check);
				$row8 = mysqli_fetch_array($result_post_ops_check);
				$pre_op_code = $row8['operation_code'];
				$pre_qty = $main_good_qty[$pre_op_code]+$bcd_good_qty1[$pre_op_code];
				$diff = $pre_qty - ($good+$bad);
				if($diff < 0)  
				{
					$diff = 0;
				}
			}
			if(strlen($ops_get_code[$value]) <> '')
			{
				$single_data['good'.$value] = $good;
				$single_data['rej'.$value] = $bad;
				$single_data['wip'.$value]= $diff;
			}
			$i++;
		}
		$i=0;
		array_push($main_data,$single_data);
		unset($operation_code1);
		unset($single_data);
		unset($main_good_qty);
		unset($main_rejected_qty);
		unset($bcd_good_qty1);
		unset($bcd_rejected_qty1);
	}
	$result['main_data'] = $main_data;
	$result['operations'] = $opertion_names;
	echo json_encode($result);
	
?>