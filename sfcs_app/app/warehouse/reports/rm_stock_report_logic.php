<?php
error_reporting(0);
set_time_limit(900000);
ini_set('memory_limit', '-1');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$location='';
$lot_no='';
$style_no='';
$batch_no='';
$item='';
$item_desc='';
$item_name='';
$boxno='';
$ref3='';
$qty_rec='';
$qty_issued='';
$qty_return='';
$qty_balance='';
$shade='';
$invoice='';
$status='';
$grn_date='';
$remarks='';
$tid='';
$product='';
$buyer='';
$supplier='';
$main_data = [];
$stock_report_inventory="select * FROM $bai_rm_pj1.stock_report_inventory where tid >0 and product_group IN ('".implode("', '", $stock_report_product_group_array)."')";
$stock_report_inventory_result =$link->query($stock_report_inventory);
while ($sql_row1 = $stock_report_inventory_result->fetch_assoc())
{
    $lot_no=trim($sql_row1['lot_no']);
	$qty_rec=$sql_row1['qty_rec'];
	$qty_issued=$sql_row1['qty_issued'];
	$qty_return=$sql_row1['qty_ret'];
	$style_no=$sql_row1['style_no'];
	$qty_balance=$sql_row1['balance'];
	$status=trim($sql_row1['status']);
	$location=trim($sql_row1['ref1']);
	$boxno=trim($sql_row1['ref2']);
	$tid=$sql_row1['tid'];
	
	$item=trim($sql_row1['item']);
	$ref3=trim($sql_row1['ref3']);


	$item_name=trim(str_replace('"',"",$sql_row1['item_name']));
	$item_name=trim(str_replace("'","",$item_name));
	$item_desc=trim(str_replace('"',"",$sql_row1['item_desc']));

	$batch_no=trim($sql_row1['batch_no']);

	$pkg_no=trim($sql_row1['pkg_no']);
	$remarks=trim($sql_row1['remarks']);
	$grn_date=$sql_row1['grn_date'];
	$tid=$sql_row1['tid'];
	$product=$sql_row1['product_group'];
	$supplier=$sql_row1['supplier'];
    $buyer=$sql_row1['buyer'];
	$log_time=$sql_row1['log_time'];
    
	
	$sql1x="select ref4,inv_no from $bai_rm_pj1.sticker_ref where tid=$tid";
    $sql_result1x =$link->query($sql1x);
    while ($row = $sql_result1x->fetch_assoc())
	{
		$shade=$row["ref4"];
		$invoice=$row["inv_no"];
    }
    $current_date=date('Y-m-d');
    $sqly="select sum(qty_issued) as qty FROM `bai_rm_pj1`.`store_out` where log_stamp > \"$log_time\" and tran_tid=\"$tid\" and date=\"$current_date\" and tran_tid >0  group by tran_tid";
    $sql_result1y =$link->query($sqly);
    if(mysqli_num_rows($sql_result1y)> 0) {
        while ($rowy = $sql_result1y->fetch_assoc())
        {
            $qty_issued=$qty_issued+$rowy["qty"];
            $qty_balance=$qty_rec+$qty_return- $qty_issued;
		}
    }
 
    $single_data = ["location"=>$location,"lotno"=>$lot_no,"style"=>$style_no,"batchno"=>$batch_no,"sku"=>$item,"itemdescription"=>$item_desc,"itemname"=>$item_name,"box_roll_no"=>$boxno,"measuredwidth"=>$ref3,"receivedqty"=>$qty_rec,"issuedqty"=>$qty_issued,"returnqty"=>$qty_return,"balanceqty"=>$qty_balance,"shade"=>$shade,"invoice"=>$invoice,"status"=>$status,"grndate"=>$grn_date,"remarks"=>$remarks,"labelid"=>$tid,"productgroup"=>$product,"buyer"=>$buyer,"supplier"=>$supplier];

    array_push($main_data,array_map('utf8_encode', $single_data));
    unset($single_data);
}

$result1['main_data'] = $main_data;

echo json_encode($result1);


?>