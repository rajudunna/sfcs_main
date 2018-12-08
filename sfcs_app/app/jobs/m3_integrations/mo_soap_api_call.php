<?php
/*
	=========== Create By Chandu =============
	Created at : 08-09-2018
	Updated at : 10-09-2018
	Input : Call SOAP URL.
	Output : Save the response in mo_details,order_details&shipment_plan tables in m3_inputs database.
*/
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);

	// include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
	error_reporting(E_ALL);
	//var_dump($link);
	$headerbody = array("user"=>$api_username,"password"=>$api_password,"company"=>$company_no);
	$header = new SOAPHeader("http://lawson.com/ws/credentials", "lws", $headerbody);
	$soap_client = new SoapClient( $api_hostname.":".$api_port_no."/lws-ws/lwsprd/SFCS?wsdl",array("login" => $api_username,"password" => $api_password));
	$soap_client->__setSoapHeaders($header);
	try{
		$to = date('Ymd',  strtotime('+3 month'));
		$from = date('Ymd',  strtotime('-1 month'));
		$result2 = $soap_client->MOData(array('Facility'=>$global_facility_code,'FromDate'=>$from,'ToDate'=>$to));
		$i=1;
		$new_ids = [];
		echo "From Date:<b>".date('Y-m-d',strtotime($from))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To date:<b>".date('Y-m-d',strtotime($to))."</b><br/>";
		echo "<table>";
		echo "<tr><th>S.NO</th><th>MONUMBER</th><th>MOQTY</th><th>STARTDATE</th><th>VPO</th><th>COLORNAME</th><th>COLOURDESC</th><th>SIZENAME</th><th>SIZEDESC</th><th>ZNAME</th><th>ZDESC</th><th>SCHEDULE</th><th>STYLE</th><th>PRODUCT</th><th>PRDNAME</th><th>PRDDESC</th><th>REFERENCEORDER</th><th>REFORDLINE</th><th>MOSTS</th><th>MAXOPERATIONSTS</th><th>COPLANDELDATE</th><th>COREQUESTEDDELDATE</th></tr>";
		foreach(($result2->new1Collection)->new1Item as $value){
			// echo "<tr>";
			// 	echo "<td>".$i++."</td>";
			// 	echo "<td>".$value->MONUMBER."</td>";
			// 	echo "<td>".$value->MOQTY."</td>";
			// 	echo "<td>".$value->STARTDATE."</td>";
			// 	echo "<td>".$value->VPO."</td>";
			// 	echo "<td>".$value->COLORNAME."</td>";
			// 	echo "<td>".$value->COLOURDESC."</td>";
			// 	echo "<td>".$value->SIZENAME."</td>";
			// 	echo "<td>".$value->SIZEDESC."</td>";
			// 	echo "<td>".$value->ZNAME."</td>";
			// 	echo "<td>".$value->ZDESC."</td>";
			// 	echo "<td>".$value->SCHEDULE."</td>";
			// 	echo "<td>".$value->STYLE."</td>";
			// 	echo "<td>".$value->PRODUCT."</td>";
			// 	echo "<td>".$value->PRDNAME."</td>";
			// 	echo "<td>".$value->PRDDESC."</td>";
			// 	echo "<td>".$value->REFERENCEORDER."</td>";
			// 	echo "<td>".$value->REFORDLINE."</td>";
			// 	echo "<td>".$value->MOSTS."</td>";
			// 	echo "<td>".$value->MAXOPERATIONSTS."</td>";
			// 	echo "<td>".$value->COPLANDELDATE."</td>";
			// 	echo "<td>".$value->COREQUESTEDDELDATE."</td>";
			// echo "</tr>";
			$ins_qry = "
			INSERT IGNORE INTO $m3_inputs.mo_details
            (`MONUMBER`, `MOQTY`, `STARTDATE`, `VPO`, `COLORNAME`, `COLOURDESC`, `SIZENAME`, `SIZEDESC`, `ZNAME`, `ZDESC`, `SCHEDULE`, `STYLE`, `PRODUCT`, `PRDNAME`, `PRDDESC`, `REFERENCEORDER`, `REFORDLINE`, `MOSTS`, `MAXOPERATIONSTS`, `COPLANDELDATE`, `COREQUESTEDDELDATE`) VALUES ('".$value->MONUMBER."','".$value->MOQTY."','".date('Y-m-d',strtotime($value->STARTDATE))."','".$value->VPO."','".$value->COLORNAME."','".$value->COLOURDESC."','".$value->SIZENAME."','".$value->SIZEDESC."','".$value->ZNAME."','".$value->ZDESC."','".$value->SCHEDULE."','".$value->STYLE."','".$value->PRODUCT."','".$value->PRDNAME."','".$value->PRDDESC."','".$value->REFERENCEORDER."','".$value->REFORDLINE."','".$value->MOSTS."','".$value->MAXOPERATIONSTS."','".date('Y-m-d',strtotime($value->COPLANDELDATE))."','".date('Y-m-d',strtotime($value->COREQUESTEDDELDATE))."')";
			$ins_qry1 = "INSERT IGNORE INTO $bai_pro3.mo_details(`date_time`, `mo_no`, `mo_quantity`, `style`, `schedule`, `color`, `size`, `destination`, `zfeature`, `item_code`, `ops_master_status`, `product_sku`) VALUES ('".date('Y-m-d H:i:s')."','".$value->MONUMBER."','".$value->MOQTY."','".$value->STYLE."','".$value->SCHEDULE."','".$value->COLOURDESC."','".$value->SIZENAME."','','".$value->ZNAME."','','','".$value->PRODUCT."')";
			$result = mysqli_query($link, $ins_qry) or exit("Sql Error Insert m3_inputs.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
			$result1 = mysqli_query($link, $ins_qry1) or exit("Sql Error Insert bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($result){
				//$new_ids[] = mysqli_insert_id($link);
			}
		}
		echo "</table>";
		// if(count($new_ids)>0){
		// 	foreach($new_ids as $idps){
		// 		$qry_mo_details = "select * from `m3_inputs`.`mo_details` where id = ".$idps;
		// 		$result_mo_details = mysqli_query($link, $qry_mo_details) or exit("Sql Error Get mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 		$mo_details_row = mysqli_fetch_array($result_mo_details);

		// 		$ins_order_details = "INSERT INTO `m3_inputs`.`order_details`(`Facility`, `Customer_Style_No`, `CPO_NO`, `VPO_NO`, `CO_no`, `Style`, `Schedule`, `Manufacturing_Schedule_no`, `MO_Split_Method`, `MO_Released_Status_Y_N`, `GMT_Color`, `GMT_Size`, `GMT_Z_Feature`, `Graphic_Number`, `CO_Qty`, `MO_Qty`, `PCD`, `Plan_Delivery_Date`, `Destination`, `Packing_Method`, `Item_Code`, `Item_Description`, `RM_Color_Description`, `Order_YY_WO_Wastage`, `Wastage`, `Required_Qty`, `UOM`, `MO_NUMBER`, `SEQ_NUMBER`, `time_stamp`) VALUES ('".$conf_tool->get('plantcode')."','','','".$mo_details_row['VPO']."','','".$mo_details_row['STYLE']."','".$mo_details_row['SCHEDULE']."','','','','".$mo_details_row['COLORNAME']."','".$mo_details_row['SIZENAME']."','".$mo_details_row['ZNAME']."','','','".$mo_details_row['MOQTY']."','','".date('Y-m-d',strtotime($mo_details_row['COPLANDELDATE']))."','','','".$mo_details_row['PRODUCT']."','".$mo_details_row['PRDDESC']."','".$mo_details_row['COLOURDESC']."','','','','','".$mo_details_row['MONUMBER']."','','')";
		// 		$res_order_details = mysqli_query($link, $ins_order_details) or exit("Sql Error Insert Order Details".mysqli_error($GLOBALS["___mysqli_ston"]));

		// 		$ins_shipment_details = "INSERT INTO `m3_inputs`.`shipment_plan`(`Customer_Order_No`, `CO_Line_Status`, `Ex_Factory`, `Order_Qty`, `Mode`, `Destination`, `Packing_Method`, `FOB_Price_per_piece`, `MPO`, `CPO`, `DBFDST`, `Size`, `HMTY15`, `ZFeature`, `MMBUAR`, `Style_No`, `Product`, `Buyer_Division`, `Buyer`, `CM_Value`, `Schedule_No`, `Colour`, `Alloc_Qty`, `Dsptched_Qty`, `BTS_vs_Ord_Qty`, `BTS_vs_FG_Qty`, `time_stamp`) VALUES ('".$mo_details_row['REFERENCEORDER']."','','".$mo_details_row['COPLANDELDATE']."','".$mo_details_row['MOQTY']."','','','','','','','','".$mo_details_row['SIZENAME']."','','".$mo_details_row['ZNAME']."','','".$mo_details_row['STYLE']."','".$mo_details_row['PRODUCT']."','','','','".$mo_details_row['SCHEDULE']."','".$mo_details_row['COLORNAME']."','','','','','')";
		// 		$res_shipment_details = mysqli_query($link, $ins_shipment_details) or exit("Sql Error Insert Shipment Details".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	}
		// }
	}
	catch(Exception $e){
		var_dump($e->getMessage());
	}
?>

