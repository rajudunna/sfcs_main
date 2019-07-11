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
	$pre_op_code = 0;
	
	//To get default Operations
    $get_operations_workflow= "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE tor.display_operations='yes' 
	GROUP BY tsm.operation_code ORDER BY tsm.operation_order*1";
	//echo $get_operations_workflow."<br>";
    $result1 = $link->query($get_operations_workflow);
    $op_count = mysqli_num_rows($result1);
    if($op_count>0)
    {
        while($row3 = $result1->fetch_assoc())
        {
            $operation_code[] = $row3['operation_code'];
        }
    }
	
	$operation_codes_str = implode(',',$operation_code);
    //To get operation names
    $get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($operation_codes_str) order by field(operation_code,$operation_codes_str)";
	//echo $get_ops_query."<br>";
    $ops_query_result=$link->query($get_ops_query);
    $op_count = mysqli_num_rows($ops_query_result);
    if($op_count >0)
    {       
        while ($row4 = $ops_query_result->fetch_assoc())
        {
            $opertion_names[]= ['op_name'=>$row4['operation_name'],'op_code'=>$row4['operation_code']];
            $ops_get_code[$row4['operation_code']] = $row4['operation_name'];
        }
    }
	
    $today=date("Y-m-d");
	$get_style_wip_data="select style,schedule,color,size FROM $brandix_bts.open_style_wip where style<>'' and status='open' group by style,schedule,color,size";
	//echo $get_style_wip_data."<br>";
	$get_style_data_result =$link->query($get_style_wip_data);
	while ($row1 = $get_style_data_result->fetch_assoc())
	{
		$style = $row1['style'];
		$schedule = $row1['schedule'];
		$color = $row1['color'];
		$size = $row1['size'];
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
        //$operations = implode(',',$operation);	
		
        $get_qty_data = "select COALESCE(SUM(good_qty),0) as good_qty,COALESCE(SUM(rejected_qty),0) as rejected_qty,operation_code From $brandix_bts.open_style_wip where style='$style' and schedule='$schedule' and color='$color' and size='$size' group by operation_code";
		//echo $get_qty_data."<br>";
        $get_qty_result =$link->query($get_qty_data);
        while ($row2 = $get_qty_result->fetch_assoc())
        {
            $main_good_qty[$row2['operation_code']] = $row2['good_qty'];
            $main_rejected_qty[$row2['operation_code']] = $row2['rejected_qty'];
        }
        
        $get_temp_data ="select COALESCE(SUM(recevied_qty),0) as good_qty,COALESCE(SUM(rejected_qty),0) as rejected_qty,operation_id From $brandix_bts.bundle_creation_data_temp Where style='$style' and schedule='$schedule' and color='$color' and size_title='$size' and date(scanned_date) = '$today' group by operation_id";
		//echo $get_temp_data."<br>";
        $get_temp_data_result =$link->query($get_temp_data);
        while ($row = $get_temp_data_result->fetch_assoc())
        {
            $bcd_good_qty1[$row['operation_id']] = $row['good_qty'];
            $bcd_rejected_qty1[$row['operation_id']] = $row['rejected_qty'];
        }
		//To caliculate WIP
		$bcd_data_query = "SELECT COALESCE(SUM(recevied_qty),0) as recevied,operation_id,COALESCE(sum(rejected_qty),0) as rejection from $brandix_bts.bundle_creation_data_temp where style='$style' and schedule ='$schedule' and color='$color' and size_title='$size' group by operation_id";
		//echo $bcd_data_query."<br>";
		$bcd_get_result =$link->query($bcd_data_query);
		while ($row6 = $bcd_get_result->fetch_assoc())
		{
			$bcd_rec[$row6['operation_id']] = $row6['recevied'];
			$bcd_rej[$row6['operation_id']] = $row6['rejection'];
		}
		//To get default Operations for WIP
		$get_operations_workflow_wip="SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
		LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style' AND color='$color' AND tor.display_operations='yes' GROUP BY tsm.operation_code ORDER BY tsm.operation_order*1";
		//echo $get_operations_workflow_wip."<bR>";
		$result123 = $link->query($get_operations_workflow_wip);
		$op_count1 = mysqli_num_rows($result123);
		if($op_count1>0)
		{
			while($row345 = $result123->fetch_assoc())
			{
				$operation_code1[] = $row345['operation_code'];
			}
		}
		$i=1;		
		foreach ($operation_code1 as $key => $value) 
		{
			$diff = 0;
			if($i == 1)
			{
				$diff = $order_qty -($bcd_rec[$value]+$bcd_rej[$value]);
				if($diff < 0)
				{
					$diff = 0;
				}	
				$wip[$value] = $diff;				
			}
			else
			{   
				$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$value'";
				//echo $ops_seq_check."<bR>";
				$result_ops_seq_check = $link->query($ops_seq_check);
				while($row7 = $result_ops_seq_check->fetch_assoc()) 
				{
					$ops_seq = $row7['ops_sequence'];
					$seq_id = $row7['id'];
					$ops_order = $row7['operation_order'];
				}
				 
				$post_ops_check = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
				LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND CAST(tsm.operation_order AS CHAR) < '$ops_order' GROUP BY tsm.operation_code ORDER BY tsm.operation_order*1 DESC limit 1";
				//echo $post_ops_check."<br>";
				$result_post_ops_check = $link->query($post_ops_check);
				$row8 = mysqli_fetch_array($result_post_ops_check);
				$pre_op_code = $row8['operation_code'];
				$diff= $bcd_rec[$pre_op_code] - ($bcd_rec[$value]+$bcd_rej[$value]);
				if($diff < 0)  
				{
					$diff = 0;
				}
				$wip[$value] = $diff;
			}
			if(strlen($ops_get_code[$value]) > 0)
			{
				$single_data['good'.$value] = $main_good_qty[$value]+$bcd_good_qty1[$value];
				$single_data['rej'.$value] = $main_rejected_qty[$value]+$bcd_rejected_qty1[$value];
				$single_data['wip'.$value]= $wip[$value];
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
		unset($bcd_rec);
		unset($bcd_rej);
		unset($wip);
    }
	$result['main_data'] = $main_data;
   	$result['operations'] = $opertion_names;
	echo json_encode($result);
       
?>