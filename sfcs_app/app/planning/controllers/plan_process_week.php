<?php
//service request #109481 // kirang // 2015-05-07 // Sections Allocation Has Been Mapped With Sections DB Database.
set_time_limit(100000);
?>

<html>
<head>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
</head>
<body>

<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 

$sql3="INSERT IGNORE INTO $bai_pro4.SHIPMENT_PLAN(order_no, delivery_no, del_status, mpo, cpo, buyer, product, buyer_division, style, schedule_no, color, size, z_feature, ord_qty, ex_factory_date, MODE, destination, packing_method, fob_price_per_piece, cm_value, ssc_code, week_code, STATUS, ssc_code_new, order_embl_a, order_embl_b, order_embl_c, order_embl_d, order_embl_e, order_embl_f, order_embl_g, order_embl_h, ssc_code_week_plan, cw_check) SELECT Customer_Order_No,Customer_Order_No AS A1,CO_Line_Status,MPO,CPO,Buyer,Product,Buyer_Division,Style_No,Schedule_No,Colour,CONCAT('size_',LOWER(Size)),ZFeature,Order_Qty,DATE_FORMAT(Ex_Factory,'%Y-%m-%d') AS Ex_Factory,MODE,Destination,Packing_Method,FOB_Price_per_piece,0,CONCAT(Style_No,Schedule_No,Colour,'-',Ex_Factory),WEEK(DATE_FORMAT(Ex_Factory,'%Y-%m-%d')) AS WEEK_NO,0,CONCAT(Style_No,Schedule_No,Colour),EMB_A,EMB_B,EMB_C,EMB_D,EMB_E,EMB_F,EMB_G,EMB_H,CONCAT(Style_No,Schedule_No,Colour,CONCAT('size_',Size),Ex_Factory),1 FROM m3_inputs.shipment_plan";
echo $sql3;
mysqli_query($link, $sql3) or exit("Sql Error38=".$sql3."-".mysqli_error($GLOBALS["___mysqli_ston"]));



$sql1="SELECT sec_mods as sections FROM $bai_pro3.sections_db WHERE sec_id > 0 group by sec_id order by sec_id ";
echo $sql1."<br>";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$sections[]=$sql_row1["sections"];
}

//$sections=array("1,2,3,4,5,6,7,8,9,10,11,12","13,14,15,16,17,18,19,20,21,22,23,24","25,26,27,28,29,30,31,32,33,34,35,36","37,38,39,40,41,42,43,44,45,46,47,48","49,50,51,52,53,54,55,56,57,58,59,60","61,62,63,64,65,66,67,68,69,70,71,72");
//$sections=array($sections_list);
	$sec_db=array("plan_sec1","plan_sec2","plan_sec3","plan_sec4","plan_sec5","plan_sec6");
	echo "Please wait while processing data - Final Phase<br>";
	$sql="truncate table $bai_pro4.shipfast_sum";
	mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="update $bai_pro4.shipment_plan set status=0";
	mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="select distinct ssc_code, ship_tid from $bai_pro4.shipment_plan where cw_check=1 group by ssc_code";
	// echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code'];
		$ship_tid=$sql_row['ship_tid'];
		
		$sql1="select style,schedule_no,color,ex_factory_date from $bai_pro4.shipment_plan where cw_check=1 and ssc_code=\"$ssc_code\"";
		echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style=trim($sql_row1['style']);
			$sch_no=trim($sql_row1['schedule_no']);
			$color=trim($sql_row1['color']);
			$ex_factory_date=$sql_row1['ex_factory_date'];
		}
			
		/*$sql2="select min(production_date) as \"production_start_date\", max(production_date) as \"production_end_date\", coalesce(tid,0) as \"tid\" from fastreact_plan where style=\"$style\" and schedule=\"$sch_no\" and color like \"%".substr($color,0,14)."%\" and delivery_date=\"$ex_factory_date\""; */
		//New to avoid errors.
		$sql2="select min(production_date) as \"production_start_date\", max(production_date) as \"production_end_date\", coalesce(tid,0) as \"tid\" from $bai_pro4.fastreact_plan where schedule=\"$sch_no\"";
		// echo $sql2."--xx<br/>";
		//echo $sql2."<br/>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$production_start_date=$sql_row2['production_start_date'];
			$production_end_date=$sql_row2['production_end_date'];
			$fastreact_plan_id=$sql_row2['tid'];
		}
			
		
			
		//if($fastreact_plan_id>=0)
		{
		
			$sql2="insert into $bai_pro4.shipfast_sum (shipment_plan_id,fastreact_plan_id,plan_start_date,plan_comp_date) values ($ship_tid,$fastreact_plan_id,\"$production_start_date\",\"$production_end_date\")";
			echo $sql2."<br/>";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			
			
			//$sql1="select distinct size, coalesce(sum(ord_qty),0) as \"qty\" from shipment_plan where ssc_code=\"$ssc_code\" group by size";
			//with ref murali feed back on 2011-05-17 due to double qty in db due to multiple vpo of the same schedule. added cw_check for error correction

			$sql1="select distinct size, coalesce(sum(ord_qty),0) as \"qty\" from $bai_pro4.shipment_plan where  cw_check=1 and ssc_code=\"$ssc_code\" and cw_check=1 group by size";
			echo $sql1."<br/>";
			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$size=$sql_row1['size'];
				$qty=$sql_row1['qty'];	
				
				if($qty>0 and strlen($size)>0)
				{
					$sql3="update $bai_pro4.shipfast_sum set ".$size."=$qty where tid=$iLastid";
					echo $sql3."<br/>";
					mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
				
			
			$sql3="update $bai_pro4.shipment_plan set status=1 where ssc_code=\"$ssc_code\"";
			echo $sql3."<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			for($i=0;$i<sizeof($sections);$i++)
			{
				
				//$sql2="select coalesce(sum(qty),0) as \"qty\" from fastreact_plan where style=\"$style\" and schedule=\"$sch_no\" and color like \"%".substr($color,0,14)."%\" and delivery_date=\"$ex_factory_date\" and module in (".$sections[$i].")";
$sql2="select coalesce(sum(qty),0) as \"qty\" from $bai_pro4.fastreact_plan where schedule=\"$sch_no\" and delivery_date=\"$ex_factory_date\" and module in (".$sections[$i].")";
echo $sql2."<br/>";
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$qty=$sql_row2['qty'];
				}
								
				$sql3="update $bai_pro4.shipfast_sum set ".$sec_db[$i]."=$qty where tid=$iLastid";
				// echo $sql3."<br/>";
				mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		// else
		// {
			// $sql2="insert into shipfast_sum (shipment_plan_id) values ($ship_tid)";
			// echo $sql2."<br/>";
			// mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
			// $iLastid=mysql_insert_id($link);
			
			
			// $sql1="select distinct size, coalesce(sum(ord_qty),0) as \"qty\" from shipment_plan where cw_check=1 and  ssc_code=\"$ssc_code\" group by size";
			// mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
			// $sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
			// while($sql_row1=mysql_fetch_array($sql_result1))
			// {
				// $size=$sql_row1['size'];
				// $qty=$sql_row1['qty'];
		
				// if($qty>0 and strlen($size)>0)
				// {
				
				// $sql3="update shipfast_sum set ".$size."=$qty where tid=$iLastid";
				// mysql_query($sql3,$link) or exit("Sql Error".mysql_error());
				
				// }
			// }
				
			
			// $sql3="update shipment_plan set status=1 where ssc_code=\"$ssc_code\"";
			// mysql_query($sql3,$link) or exit("Sql Error".mysql_error());
		// }
	}
		
	
//MAIL UPDATE
{
	$message= '<html><head><style type="text/css">

body
{
	font-family: arial;
	font-size:12px;
	color:black;
}
table
{
	border-collapse:collapse;
	white-space:nowrap; 
}
th
{
	color: black;
 	border: 1px solid #660000; 
	white-space:nowrap; 
	padding-left: 10px;
	padding-right: 10px;
}

td
{
	color: BLACK;
 	border: 1px solid #660000; 
	padding: 1px;
	white-space:nowrap; 
	text-align:right;
}

.green
{
	border: 0;

}

.red
{
	border: 0;

}

.yash
{
	border: 0;

}
</style></head><body>';

$message.="Dear All,<br/><br/>
The 2 Weeks Plan Schedules had been updated in FSP Status in BAINet.<br/><br/>";

$message.='<br/>Message Sent Via: http://bainet';
$message.="</body></html>";

$to  = 'BAIPlanningTeam@brandix.com,BAIManufacturingTeam@brandix.com,BAISupplyChainTeam@brandix.com,brandixalerts@schemaxtech.com, brandixalerts@schemaxtech.com';
//$to  = 'brandixalerts@schemaxtech.com';
	$subject = 'BAI 2 Weeks Plan Update';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: <BAIPlanningTeam@brandix.com>; <BAIManufacturingTeam@brandix.com>; <BAISupplyChainTeam@brandix.com>'. "\r\n";
//$headers .= 'To: <brandixalerts@schemaxtech.com>;'. "\r\n";
	$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
	
	//mail($to, $subject, $message, $headers);
}


//MAIL UPDATE					
						
echo "Successfully Updates - Final Phase - <font color=green><h2>You may now proceed for updating weekly delivery plan in new window, since backup of this operaitons take little time.</h2></font>";		
// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"delivery_schedules/week_delivery_plan_cache_truncate.php\"; }</script>";
?>

</body>
</html>


	