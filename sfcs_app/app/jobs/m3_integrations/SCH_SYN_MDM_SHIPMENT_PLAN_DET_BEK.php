<?php
	include('mssql_conn.php');
	error_reporting(E_ALL & ~E_NOTICE);
	if($conn)
	{
		include('mysql_db_config.php');
		$curr_date = date(Ymd);
		$query_text = "CALL BAISFCS.RPT_BLI_SHIPMENT_PLAN_FOR_A_SELECTED_PERIOD('200','%','EKG','EKG','".$curr_date."','".$curr_date."')";
		$result = odbc_exec($conn, $query_text);

		$trunc_ship = "TRUNCATE TABLE m3_inputs.shipment_plan";
		$res_trunc_ship = mysqli_query($my_conn, $trunc_ship);
		while($row = odbc_fetch_array($result))
		{
			$oborno = str_replace('"', '\"', $row['OBORNO']);
			$oborst = str_replace('"', '\"', $row['OBORST']);
			$oblded = str_replace('"', '\"', $row['OBLDED']);
			$urtrqt = str_replace('"', '\"', $row['URTRQT']);
			$obmodl = str_replace('"', '\"', $row['OBMODL']);
			$obadid	= str_replace('"', '\"', $row['OBADID']);
			$obtepa = str_replace('"', '\"', $row['OBTEPA']);
			$obsapr = str_replace('"', '\"', $row['OBSAPR']);
			$obcuor = str_replace('"', '\"', $row['OBCUOR']);
			$oayref = str_replace('"', '\"', $row['OAYREF']);
			$dbfdst = str_replace('"', '\"', $row['DBFDST']);
			$hmtx15 = str_replace('"', '\"', $row['HMTX15']);
			$hmty15 = str_replace('"', '\"', $row['HMTY15']);
			$hmtz15 = str_replace('"', '\"', $row['HMTZ15']);
			$mmbuar = str_replace('"', '\"', $row['MMBUAR']);
			$mmhdpr = str_replace('"', '\"', $row['MMHDPR']);
			$cttx401 = str_replace('"', '\"', $row['CTTX401']);
			$cttx402 = str_replace('"', '\"', $row['CTTX402']);
			$okcunm = str_replace('"', '\"', $row['OKCUNM']);
			$odsapr = str_replace('"', '\"', $row['ODSAPR']);
			$schd_no = str_replace('"', '\"', $row['SCHEDULE_NO']);
			$pftx30 = str_replace('"', '\"', $row['PFTX30']);
			$aa = str_replace('"', '\"', $row['A']);
			$bb = str_replace('"', '\"', $row['B']);
			$cc = str_replace('"', '\"', $row['C']);
			$dd = str_replace('"', '\"', $row['D']);
			$ee = str_replace('"', '\"', $row['E']);
			$ff = str_replace('"', '\"', $row['F']);
			$gg = str_replace('"', '\"', $row['G']);
			$hh = str_replace('"', '\"', $row['H']);
			$obalqt = str_replace('"', '\"', $row['OBALQT']);
			$obplqt = str_replace('"', '\"', $row['OBPLQT']);
			$obdlqt = str_replace('"', '\"', $row['OBDLQT']);
			$obivqt = str_replace('"', '\"', $row['OBIVQT']);

			$sql_insert_ship = "INSERT INTO m3_inputs.shipment_plan (Customer_Order_No, CO_Line_Status, Ex_Factory, Order_Qty, Mode, Destination, Packing_Method, FOB_Price_per_piece, MPO, CPO, DBFDST, Size, HMTY15, ZFeature, MMBUAR, Style_No, Product,Buyer_Division, Buyer, CM_Value, Schedule_No, Colour, EMB_A, EMB_B, EMB_C, EMB_D, EMB_E, EMB_F, EMB_G, EMB_H, Alloc_Qty, Dsptched_Qty, BTS_vs_Ord_Qty, BTS_vs_FG_Qty) VALUES (\"".$oborno."\", \"".$oborst."\", \"".$oblded."\", \"".$urtrqt."\", \"".$obmodl."\", \"".$obadid."\", \"".$obtepa."\", \"".$obsapr."\", \"".$obcuor."\", \"".$oayref."\", \"".$dbfdst."\", \"".$hmtx15."\", \"".$hmty15."\", \"".$hmtz15."\", \"".$mmbuar."\", \"".$mmhdpr."\", \"".$cttx401."\", \"".$cttx402."\", \"".$okcunm."\", \"".$odsapr."\", \"".$schd_no."\", \"".$pftx30."\", \"".$aa."\", \"".$bb."\", \"".$cc."\", \"".$dd."\", \"".$ee."\", \"".$ff."\", \"".$gg."\", \"".$hh."\", \"".$obalqt."\", \"".$obplqt."\", \"".$obdlqt."\", \"".$obivqt."\")";
			$res_insert_ship = mysqli_query($my_conn, $sql_insert_ship);

		}
		echo "<br>Executed Successfully<br>";
	}
	else
	{
		echo "Connection Failed";
	}
?>