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
$stock_report_inventory="select * FROM $bai_rm_pj1.stock_report_inventory";
$stock_report_inventory_result =$link->query($stock_report_inventory);
while ($sql_row1 = $stock_report_inventory_result->fetch_assoc())
{
    $lot_no=trim($sql_row1['lot_no']);
	// $qty_rec=$sql_row1['qty_rec'];
	// $qty_issued=$sql_row1['qty_issued'];
	// $qty_return=$sql_row1['qty_ret'];
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

	//For #2711 we will show roll remarks in report if remarks are null/empty values
	if($remarks==''){
		$remarks=trim($sql_row1['roll_remarks']);
		if($remarks==''){
			$qry_get_rol="SELECT roll_remarks FROM $bai_rm_pj1.stock_report WHERE tid=$tid";
			$sql_result1x =$link->query($qry_get_rol);
			if(mysqli_num_rows($sql_result1x)> 0){
				while ($row = $sql_result1x->fetch_assoc())
				{
					$remarks=$row["roll_remarks"];
				}
			}

	 	}
	}
	
	
	$sql1x="select qty_rec,qty_issued,qty_return,ref4,qty_ret,inv_no,ref1,ref3 from $bai_rm_pj1.sticker_ref where tid=$tid";
	$sql_result1x =$link->query($sql1x);
	if(mysqli_num_rows($sql_result1x)> 0) {
		while ($row = $sql_result1x->fetch_assoc())
		{
			$qty_rec=$row['qty_rec'];
			$qty_issued=$row['qty_issued'];
			$qty_return=$row['qty_ret'];
			$shade=$row["ref4"];
			$invoice=$row["inv_no"];
			$location=trim($row['ref1']);
			$ref3=trim($row['ref3']);
		}
	}
    $current_date=date('Y-m-d');
    $sqly="select sum(ROUND(qty_issued,2)) as qty FROM `bai_rm_pj1`.`store_out` where log_stamp > \"$log_time\" and tran_tid=\"$tid\" and date=\"$current_date\" ";
    $sql_result1y =$link->query($sqly);
    if(mysqli_num_rows($sql_result1y)> 0) {
        while ($rowy = $sql_result1y->fetch_assoc())
        {
            $qty_issued=$qty_issued+$rowy["qty"];
            $qty_balance=$qty_rec+$qty_return- $qty_issued;
		}
	}

	$sql_mrn="SELECT sum(ROUND(iss_qty,2)) as mrn_qty FROM `bai_rm_pj2`.`mrn_out_allocation`  WHERE  lable_id = \"$tid\" and DATE(log_time)=\"$current_date\" GROUP BY lable_id";
    $sql_result_mrn =$link->query($sql_mrn);
    if(mysqli_num_rows($sql_result_mrn)> 0) {
        while ($row_mrn = $sql_result_mrn->fetch_assoc())
        {
            $qty_issued=$qty_issued+$row_mrn["mrn_qty"];
            $qty_balance=$qty_rec+$qty_return - $qty_issued;
		}
	}
	
	$sqlz="select sum(ROUND(qty_returned,2)) as qty FROM `bai_rm_pj1`.`store_returns` where log_stamp > \"$log_time\" and tran_tid=\"$tid\" and date=\"$current_date\"";
    $sql_result1z =$link->query($sqlz);
    if(mysqli_num_rows($sql_result1z)> 0) {
        while ($rowz = $sql_result1z->fetch_assoc())
        {
            $qty_return=$qty_return+$rowz["qty"];
            $qty_balance=$qty_rec+$qty_return- $qty_issued;
		}
    }
	$qty_balance=round($qty_balance,2);
	
	$single_data = ["location"=>$location,"lotno"=>$lot_no,"style"=>$style_no,"batchno"=>$batch_no,"sku"=>$item,"itemdescription"=>$item_desc,"itemname"=>$item_name,"box_roll_no"=>$boxno,"measuredwidth"=>$ref3,"receivedqty"=>$qty_rec,"issuedqty"=>$qty_issued,"returnqty"=>$qty_return,"balanceqty"=>$qty_balance,"shade"=>$shade,"invoice"=>$invoice,"status"=>$status,"grndate"=>$grn_date,"remarks"=>$remarks,"labelid"=>$tid,"productgroup"=>$product,"buyer"=>$buyer,"supplier"=>$supplier];
    if($qty_balance > 0)
	{
		array_push($main_data,array_map('utf8_encode', $single_data));
	    unset($single_data);
	}
    

   
	


}

$qry_max="SELECT MAX(tid) AS tid FROM bai_rm_pj1.stock_report_inventory";
$qry_max_result =$link->query($qry_max);
while ($sql_max_row1 = $qry_max_result->fetch_assoc())
{
	$max_id=$sql_max_row1['tid'];
}
if($max_id>0){
		$stock_report_inventory="select * FROM $bai_rm_pj1.stock_report WHERE tid>$max_id";
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

			//For #2711 we will show roll remarks in report if remarks are null/empty values
			if($remarks==''){
				$remarks=trim($sql_row1['roll_remarks']);
			}
			
			$sql1x="select ref4,inv_no,ref1,ref3 from $bai_rm_pj1.sticker_ref where tid=$tid";
			$sql_result1x =$link->query($sql1x);
			if(mysqli_num_rows($sql_result1x)> 0) {
				while ($row = $sql_result1x->fetch_assoc())
				{
					$shade=$row["ref4"];
					$invoice=$row["inv_no"];
					$location=trim($row['ref1']);
					$ref3=trim($row['ref3']);
				}
			}
			$current_date=date('Y-m-d');
			$sqly="select sum(ROUND(qty_issued,2)) as qty FROM `bai_rm_pj1`.`store_out` where log_stamp > \"$log_time\" and tran_tid=\"$tid\" and date=\"$current_date\" ";
			$sql_result1y =$link->query($sqly);
			if(mysqli_num_rows($sql_result1y)> 0) {
				while ($rowy = $sql_result1y->fetch_assoc())
				{
					$qty_issued=$qty_issued+$rowy["qty"];
					$qty_balance=$qty_rec+$qty_return- $qty_issued;
				}
			}
			

			$sql_mrn="SELECT sum(ROUND(iss_qty,2)) as mrn_qty FROM `bai_rm_pj2`.`mrn_out_allocation`  WHERE  lable_id = \"$tid\" and DATE(log_time)=\"$current_date\" GROUP BY lable_id";
			$sql_result_mrn =$link->query($sql_mrn);
			if(mysqli_num_rows($sql_result_mrn)> 0) {
				while ($row_mrn = $sql_result_mrn->fetch_assoc())
				{
					$qty_issued=$qty_issued+$row_mrn["mrn_qty"];
					$qty_balance=$qty_rec+$qty_return- $qty_issued;
				}
			}

			$sqlz="select sum(ROUND(qty_returned,2)) as qty FROM `bai_rm_pj1`.`store_returns` where log_stamp > \"$log_time\" and tran_tid=\"$tid\" and date=\"$current_date\"";
			$sql_result1z =$link->query($sqlz);
			if(mysqli_num_rows($sql_result1z)> 0) {
				while ($rowz = $sql_result1z->fetch_assoc())
				{
					$qty_return=$qty_return+$rowz["qty"];
					$qty_balance=$qty_rec+$qty_return- $qty_issued;
				}
			}
			$qty_balance=round($qty_balance,2);
			$single_data = ["location"=>$location,"lotno"=>$lot_no,"style"=>$style_no,"batchno"=>$batch_no,"sku"=>$item,"itemdescription"=>$item_desc,"itemname"=>$item_name,"box_roll_no"=>$boxno,"measuredwidth"=>$ref3,"receivedqty"=>$qty_rec,"issuedqty"=>$qty_issued,"returnqty"=>$qty_return,"balanceqty"=>$qty_balance,"shade"=>$shade,"invoice"=>$invoice,"status"=>$status,"grndate"=>$grn_date,"remarks"=>$remarks,"labelid"=>$tid,"productgroup"=>$product,"buyer"=>$buyer,"supplier"=>$supplier];

			array_push($main_data,array_map('utf8_encode', $single_data));
			unset($single_data);
			


		}
}

$result1['main_data'] = $main_data;
echo json_encode($result1);


?>