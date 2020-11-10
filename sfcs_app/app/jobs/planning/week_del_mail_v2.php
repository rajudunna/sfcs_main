<?php
	$start_timestamp = microtime(true);
	$include_path=getenv('config_job_path');
	include($include_path.'\sfcs_app\common\config\config_jobs.php');
	// for running these schedules in command prompt making entire code in single php file
	error_reporting(0);
	if($_GET['plantCode']){
		$plant_code = $_GET['plantCode'];
	}else{
		$plant_code = $argv[1];
	}
	$date1=date("Y-m-d");
	$weekday1 = strtolower(date('l', strtotime($date1)));
	$message="<html>
	<head>
	<style type=\"text/css\">

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
		background-color: WHITE;
		color: BLACK;
		border: 1px solid #660000; 
		padding: 1px;
	white-space:nowrap; 
	text-align:right;
	}

	.highlight td
	{
		background-color: green;
		color: BLACK;
		border: 1px solid #660000; 
		padding: 1px;
	white-space:nowrap; 
	text-align:right;
	}

	</style>
	</head>
	<body>";
	
	$start_date_w=time();

	while((date("N",$start_date_w))!=1) 
	{
		$start_date_w=$start_date_w-(60*60*24); // define monday
	}
	$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

	$start_date_w=date("Y-m-d",$start_date_w);
	$end_date_w=date("Y-m-d",$end_date_w);

	$date=date("Y-m-d");
	$colspan=9;

	$order_qty_total=0;
	$shipable_qty_total=0;
	$extra_qty_total=0;
	$m3_shipable_qty_total=0;

	$message.="
	<table>
	<tr><td colspan=$colspan><center><u><strong>Weekly Delivery Plan Status</strong></u></center></td></tr>
	<tr bgcolor=\"yellow\">
	<th >Sno</th> 
	<th >Customer</th>
	<th >Schedule</th>
	<th >Color</th>
	<th >Order <br> Quantity</th>
	<th >Shippable <br> Quantity</th>
	<th >Extra Ship <br>Quantity</th>
	<th >Planned  <br> Extra %</th>";
	
	$message.="</tr>";
	//echo $message;exit;
	$x=0;
	$schedules=array();
	$sql_oms="SELECT 
	omd.buyer_desc AS buyer_Division,opi.style,omd.schedule,opi.color_name,
	SUM(omd.mo_quantity) AS qty FROM 
	$oms.oms_mo_details AS omd LEFT JOIN $oms.oms_products_info AS opi ON omd.mo_number=opi.mo_number where plant_code='".$plant_code."' and omd.planned_delivery_date between '".$start_date_w."' and '".$end_date_w."' GROUP BY opi.style,omd.SCHEDULE,opi.color_name";
	// $sql_oms="SELECT omd.planned_delivery_date,omd.buyer_desc AS buyer_Division,opi.style,omd.schedule,opi.color_name,
	// SUM(omd.mo_quantity) AS qty FROM 
	// oms.oms_mo_details AS omd LEFT JOIN oms.oms_products_info AS opi ON omd.mo_number=opi.mo_number 
	// WHERE plant_code='AIP' AND omd.schedule IN (SELECT SCHEDULE FROM `pps`.`mp_mo_qty` WHERE plant_code='AIP') GROUP BY opi.style,omd.SCHEDULE,opi.color_name";
	$sql_oms_result=mysqli_query($link, $sql_oms) or exit("Error While getting information from OMS".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_oms_result))
	{
		$style[]=$sql_row['style'];
		$buyer[]=$sql_row['buyer_Division'];
		$schedules[]=$sql_row['schedule'];
		$color[]=$sql_row['color_name'];
		$order_qty[$sql_row['schedule']][$sql_row['color_name']]=$sql_row['qty'];
	}
	
	$cost1="";
	$total_cost=0;
	if(sizeof($schedules) > 0)
	{
		for($i=0;$i<sizeof($schedules);$i++)
		{
			$x=$i+1; 
			$sch=$schedules[$i];
			$buyerdesc=$buyer[$i];				
			$message.="<tr style=\"background:green;\">";
			$message.="<td>$x</td>";
			$message.="<td>".$buyerdesc."</td>"; 
			$message.="<td>".$style[$i]."</td>"; 
			$message.="<td>".$schedules[$i]."</td>";
			$message.="<td>".$color[$i]."</td>";
			$message.="<td>".$order_qty[$schedules[$i]][$color[$i]]."</td>";				
			//getting Extra Ship quantity
			$extra_ship_qty=0;
			$get_tot_orgqty_qry="SELECT SUM(quantity) as orgqty FROM $pps.mp_mo_qty WHERE SCHEDULE='$sch' and color='".$color[$i]."' and plant_code='$plant_code' AND mp_qty_type='EXTRA_SHIPMENT'";
			$sql_result_orgqty=mysqli_query($link, $get_tot_orgqty_qry) or exit("Sql Error getting orgqty =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_orgqty=mysqli_fetch_array($sql_result_orgqty))
			{
				if($sql_row_orgqty['orgqty']>0)
				{
					$extra_ship_qty=$sql_row_orgqty['orgqty'];
				}
				else
				{
					$extra_ship_qty=0;
				}
				
			}
			$message.="<td>".($order_qty[$schedules[$i]][$color[$i]]+$extra_ship_qty)."</td>";
			$ext_qty=$extra_ship_qty;				
			$message.="<td>".$ext_qty."</td>";				
			$extra_ship=round(($extra_ship_qty*100)/$order_qty[$schedules[$i]][$color[$i]],0);					
			$color1="<font color=black>";					
			if($extra_ship > 0)
			{
				$color1="<font color=red>";
			}				
			$message.="<td>$color1".$extra_ship."%</td>";	
			$order_qty_total=$order_qty_total+$order_qty[$schedules[$i]][$color[$i]];			
			$shipable_qty_total=$order_qty_total+($order_qty[$schedules[$i]][$color[$i]]+$extra_ship_qty);			
			$extra_qty_total=$order_qty_total+$ext_qty;			
		}
		$message.="<tr><th colspan=2 style='color:white;background:red;'>Total</th><td colspan=3>Schedules:".$x."</td><td>$order_qty_total</td><td>$shipable_qty_total</td><td>$extra_qty_total</td><td></td>";
		echo "</tr>";
	}
	else
	{
		$message.="<h2 align=\"center\">Selected period Dont have any schedules to shipment</h2>";
	}

	$message.="</table>";
	$message.='<br/>Message Sent Via:'.$plant_code;
	$message.="</body></html>";

	// echo $message;

	$to  = $week_del_mail_v2;

	$subject = $plant_code.' Weekly Delivery Plan Status';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";

	a:
	if(mail($to, $subject, $message, $headers))
	{
		print("Mail Successfully Sent.")."\n";
	}
	else
	{
		goto a;
	}


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>

