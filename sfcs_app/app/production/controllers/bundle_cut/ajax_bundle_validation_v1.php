<?php
//include("dbconf.php"); 
function bundle_quantity($bundle_barcode,$link)
{
	$bundle_details=explode("-",$bundle_barcode);
	$bundle_id = ltrim($bundle_details[0], '0');
	$operation_id = ltrim($bundle_details[1], '0');
	
	$docket=echo_title("tbl_miniorder_data","docket_number","bundle_number",$bundle_id,$link);
	
	$schedule=echo_title("tbl_cut_master","product_schedule","doc_num",$docket,$link);
	$emb_status=echo_title("tbl_orders_master","emb_status","product_schedule",$schedule,$link);
	//$barcode_exist=echo_title("tbl_miniorder_data","count(*)","bundle_number",$bundle_id,$link);
	$mini_ref=echo_title("tbl_miniorder_data","mini_order_ref","bundle_number",$bundle_id,$link);
	$check_doc=substr($docket,0,1);
//	if($check_doc == 'R')
	//{
	//	$docket_status=echo_title("bai_pro3.recut_v2","act_cut_status","doc_no",substr($docket,1,10),$link);
//	}
	//else
	//{
	//	$docket_status=echo_title("bai_pro3.plandoc_stat_log","act_cut_status","doc_no",$docket,$link);
	//}
	if($operation_id==1)
	{
		$bundle_size=echo_title("tbl_miniorder_data","size","bundle_number",$bundle_id,$link);
		$act_size=strtolower(echo_title("tbl_orders_size_ref","size_name","id",$bundle_size,$link));
		if($check_doc == 'R')
		{
			$docket_status=echo_title("bai_pro3.recut_v2","act_cut_status","doc_no",substr($docket,1,10),$link);
			$doc_id=substr($docket,1,10);
			$sql12="select ((a_".$act_size.")*a_plies) as sum_qty from bai_pro3.recut_v2 where doc_no='".$doc_id."'";
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($result12=mysqli_fetch_array($sql_result12))
			{
				$quantity_act=$result12['sum_qty'];	
			}
		}
		else
		{
			$docket_status=echo_title("bai_pro3.plandoc_stat_log","act_cut_status","doc_no",$docket,$link);
			$doc_id=$docket;
			$sql12="select ((a_".$act_size.")*a_plies) as sum_qty from bai_pro3.plandoc_stat_log where doc_no='".$doc_id."'";
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($result12=mysqli_fetch_array($sql_result12))
			{
				$quantity_act=$result12['sum_qty'];	
			}
		}
		$sql="select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_id."' and size='".$bundle_size."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($result=mysqli_fetch_array($sql_result))
		{
			$bundles[]=$result['bundle_number'];	
		}
		
		$sql12="select sum(quantity) as sum_qty from brandix_bts.bundle_transactions_20_repeat where operation_id='1' and bundle_id in (".implode(",",$bundles).")";
		$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($result12=mysqli_fetch_array($sql_result12))
		{
			$quantity_tmp=$result12['sum_qty'];	
		}
		$quantity_n=echo_title("tbl_miniorder_data","sum(quantity)","mini_order_ref=$mini_ref and bundle_number",$bundle_id,$link);
	/*	$sql12="select sum(quantity) as sum_qty from brandix_bts.tbl_miniorder_data where bundle_number in (".implode(",",$bundles).")";
		$sql_result12=mysql_query($sql12,$link) or exit("Sql Error-1".mysql_error());
		while($result12=mysql_fetch_array($sql_result12))
		{
			$quantity_org=$result12['sum_qty'];	
		}
	*/	
		$qty_tot=$quantity_tmp+$quantity_n;
		if($qty_tot<=$quantity_act)
		{
			$qty_new=1;
		}
		else
		{
			$qty_new=0;
		}
		
		
	}
	$bundle_ops_cnt=echo_title("bundle_transactions_20_repeat","count(*)","bundle_id",$bundle_id,$link);
	
	$order_id=echo_title("tbl_orders_ops_ref","ops_order","id",$operation_id,$link);
	
	if($emb_status==1)
	{
		$sql="select id, ops_order from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order<'".$order_id."' and id <= 7 ORDER BY ops_order DESC LIMIT 1";
		
		$sql1="select count(*) as cnt from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id <= 7";
		$ops_exist=echo_title("brandix_bts.tbl_orders_ops_ref","count(*)","id ='".$operation_id."' and default_operation='YES' and id<",7,$link);
	}
	else if($emb_status==0)
	{
		$sql="select id, ops_order from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order<'".$order_id."' and id in (1,2,3,4) ORDER BY ops_order DESC LIMIT 1";
		
		$sql1="select count(*) as cnt from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id in (1,2,3,4)";
		$ops_exist=echo_title("brandix_bts.tbl_orders_ops_ref","count(*)","id ='".$operation_id."' and default_operation='YES' and id<",4,$link);
	}
	else if($emb_status==2)
	{
		$sql="select id, ops_order from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order<'".$order_id."' and id not in (6,7) ORDER BY ops_order DESC LIMIT 1";
		
		$sql1="select count(*) as cnt from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and and id not in (6,7)";
		$ops_exist=echo_title("brandix_bts.tbl_orders_ops_ref","count(*)","id <> 7 and id<>6 and default_operation='YES' and id",$operation_id,$link);
	}
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($result1=mysqli_fetch_array($sql_result1))
	{
		$ops_cnt=$result['cnt'];	
	}
	
	if($order_id==1)
	{
		$ops_p=$result['id']=$order_id;	
	}
	else
	{
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($result=mysqli_fetch_array($sql_result))
		{
			$ops_p=$result['id'];	
			$ops_or=$result['ops_order'];	
		}
	}
	//echo "--".$ops_exist."--<br>";
	
	if(1 < $operation_id)
	{
		$barcode_p=echo_title("bundle_transactions_20_repeat","count(*)","operation_id='".$ops_p."' and bundle_id",$bundle_id,$link);
	}
	else
	{
		$barcode_p=100;
	}
	if($qty_new>0)
	{
		if($ops_exist<>0)
		{
			//if($docket_status=='DONE')
			//{
				if(0 < $barcode_p)
				{
					if($docket=='')
					{
						$ret_val='NA';
						return $ret_val;
					}
					else 
					{
						if($bundle_ops_cnt == $ops_cnt)
						{
							$ret_val='C';
							return $ret_val;			
						}
						else
						{
							if($operation_id==1)
							{
								$barcode_qty=echo_title("tbl_miniorder_data","sum(quantity)","mini_order_ref=$mini_ref and bundle_number",$bundle_id,$link);
								$ret_val=$barcode_qty;
								return $ret_val;
							}
							/*
							else if($operation_id==3)
							{
								$barcode_qty=echo_title("tbl_miniorder_data","sum(quantity)","mini_order_ref=$mini_ref and bundle_number",$bundle_id,$link);
								$ret_val=$barcode_qty;
								return $ret_val;
							}
							else if($emb_status==1 && ($operation_id==6 || $operation_id==7))
							{
								$barcode_qty=echo_title("bundle_transactions_20_repeat","quantity","operation_id=1 and bundle_id",$bundle_id,$link);
								$ret_val=$barcode_qty;
								return $ret_val;
							}
							*/
							else
							{
								$barcode_qty=echo_title("bundle_transactions_20_repeat","quantity","operation_id=$ops_p and bundle_id",$bundle_id,$link);
								$ret_val=$barcode_qty;
								return $ret_val;
							}
						}
					}	
				}
				else
				{
					$ret_val='PO';
					return $ret_val;
				}
			//}
			//else
			//{
			//	$ret_val='CS';
			//	return $ret_val;
			//}
		}
		else
		{	
			$ret_val='OPN';
			return $ret_val;
		}
	}
	else
	{
		$ret_val='QN';
		return $ret_val;
	}	
}
function bundle_ops_check($bundle_id,$operation_id,$link)
{

	$docket=echo_title("tbl_miniorder_data","docket_number","bundle_number",$bundle_id,$link);
	$schedule=echo_title("tbl_cut_master","product_schedule","doc_num",$docket,$link);
	$emb_status=echo_title("tbl_orders_master","emb_status","product_schedule",$schedule,$link);
	$order_id=echo_title("tbl_orders_ops_ref","ops_order","id",$operation_id,$link);

	if($emb_status==1)
	{
		$sql="select id, ops_order from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order>'".$order_id."' and id <= 7 ORDER BY ops_order*1 LIMIT 1";
		
		$sql1="select count(*) as cnt from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id <= 7";
	}
	else if($emb_status==0)
	{
		$sql="select id, ops_order from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order>'".$order_id."' and id in (1,2,3,4) ORDER BY ops_order*1 LIMIT 1";
		
		$sql1="select count(*) as cnt from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id in (1,2,3,4)";
	}
	else if($emb_status==2)
	{
		$sql="select id, ops_order from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and ops_order<'".$order_id."' and id not in (6,7) ORDER BY ops_order DESC LIMIT 1";
		
		$sql1="select count(*) as cnt from brandix_bts.tbl_orders_ops_ref where default_operation='YES' and and id not in (6,7)";
	}
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($result1=mysqli_fetch_array($sql_result1))
	{
		$ops_cnt=$result1['cnt'];	
	}
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($result=mysqli_fetch_array($sql_result))
	{
		$ops_p=$result['id'];	
		$ops_or=$result['ops_order'];	
	}
	
	$val=$ops_p."$".$ops_cnt;

	return $val;
}
?>