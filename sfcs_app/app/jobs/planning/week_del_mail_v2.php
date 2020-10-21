<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
// for running these schedules in command prompt making entire code in single php file
error_reporting(0);
$plantcode=$_SESSION['plantCode'];
$date1=date("Y-m-d");
$weekday1 = strtolower(date('l', strtotime($date1)));
// $weekday1='monday';
// echo "Week = ".$weekday1;

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
			// set_time_limit(10000000);
			include($include_path.'\sfcs_app\common\config\config_jobs.php');
	
			
			$start_date_w=time();

			while((date("N",$start_date_w))!=1) 
			{
			$start_date_w=$start_date_w-(60*60*24); // define monday
			}
			$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

			$start_date_w=date("Y-m-d",$start_date_w);
			$end_date_w=date("Y-m-d",$end_date_w);
			
			//echo $start_date_w."--".$end_date_w;
			$date=date("Y-m-d");
			//$date="2012-08-19";
			$weekday = strtolower(date('l', strtotime($date)));
			// echo "Week = ".$weekday;
	
			$colspan=9;
			// if($weekday != "tuesday")
			// {
			// 	$colspan=11;
			// }

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
			  
			  // if($weekday != "tuesday")
			  // {
			  // 	$message.="<th >Shipped <br>Quantity(M3)</th>
			  // 	<th >Shipped <br>Quantity %</th>";
			  // }
			  
			  
			  $message.="</tr>";
			  //echo $message;exit;
			$x=0;
			$schedules=array();

			$sql="select order_code from $pps.monthly_production_plan where production_end_date between \"$start_date_w\" and \"$end_date_w\" and order_code!=\"NULL\" and plant_code='$plantcode' order by color,left(style,1) ";

			$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"]));

			$count_rows=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$schedules[]=$sql_row['order_code'];
				
			}

			$cost1="";
			$total_cost=0;
			if($count_rows > 0)
			{

			$total_sch=implode(",",$schedules);
			$total_sch=str_replace(",,",",",$total_sch);
			$sql="select * from $pps.mp_mo_qty where schedule in ($total_sch) and plant_code='$plantcode' group by schedule order by schedule desc";
			//echo "<br>".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$x=$x+1; 
				/*if($x%2==0)
				{
					$id="#D0D0D0";
				}
				else
				{
					$id="#ffffff";
				}*/
				$sch=$sql_row["schedule"];
				//getting buyer division
				$get_buyer_div_qry="SELECT buyer_desc FROM `oms_mo_details` WHERE schedule='$sch' and plant_code='$plantcode' GROUP BY schedule";
				$sql_result_qry=mysqli_query($link, $get_buyer_div_qry) or exit("Sql Error getting buyer desc =".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_desc=mysqli_fetch_array($sql_result_qry))
				{
					$buyerdesc=$sql_row_desc['buyer_desc'];
				}
				
				$message.="<tr style=\"background:green;\">";
				$message.="<td>$x</td>";
				$message.="<td>".$buyerdesc."</td>"; 
				// $message.="<td>".$sql_row["order_style_no"]."</td>"; 
				$message.="<td>".$sql_row["schedule"]."</td>";
				$message.="<td>".$sql_row["color"]."</td>";
				
				//getting total quantity
				$get_tot_qty_qry="SELECT SUM(quantity) as totqty FROM `mp_mo_qty` WHERE SCHEDULE='$sch' and plant_code='$plantcode' AND mp_qty_type='TOTAL_QUANTITY'";
				$sql_result_totqty=mysqli_query($link, $get_tot_qty_qry) or exit("Sql Error getting totqty =".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_totqty=mysqli_fetch_array($sql_result_totqty))
				{
					if($sql_row_totqty['totqty']>0)
					{
						$total=$sql_row_totqty['totqty'];
					}
					else
					{
						$total=0;
					}
					
				}
				
				$message.="<td>".$total."</td>";
				
				$order_qty_total=$order_qty_total+$total;
				
				//getting original quantity
				$get_tot_orgqty_qry="SELECT SUM(quantity) as orgqty FROM `mp_mo_qty` WHERE SCHEDULE='$sch' and plant_code='$plantcode' AND mp_qty_type='ORIGINAL_QUANTITY'";
				$sql_result_orgqty=mysqli_query($link, $get_tot_orgqty_qry) or exit("Sql Error getting orgqty =".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_orgqty=mysqli_fetch_array($sql_result_orgqty))
				{
					if($sql_row_orgqty['orgqty']>0)
					{
						$total_qty=$sql_row_orgqty['orgqty'];
					}
					else
					{
						$total_qty=0;
					}
					
				}
				$message.="<td>".$total_qty."</td>";
				
				$shipable_qty_total=$shipable_qty_total+$total_qty;
				
				$ext_qty=$total_qty-$total;	
				
				$extra_qty_total=$extra_qty_total+$ext_qty;
				
				$message.="<td>".$ext_qty."</td>";
				
				$extra_ship=round(($total_qty-$total)*100/$total,0);
					
				$color1="<font color=black>";
					
				if($extra_ship > 0)
				{
					$color1="<font color=red>";
				}
				
				$message.="<td>$color1".$extra_ship."%</td>";
				
				
			}
			$message.="<tr><th colspan=2 style='color:white;background:red;'>Total</th><td colspan=3>Schedules:".$x."</td><td>$order_qty_total</td><td>$shipable_qty_total</td><td>$extra_qty_total</td><td></td>";
			echo "</tr>";

			}
			else
			{
				$message.="<h2 align=\"center\">Selected period Dont have any schedules to shipment</h2>";
			}

			$message.="</table>";
			$message.='<br/>Message Sent Via:'.$plantcode;
			$message.="</body></html>";

			// echo $message;

			$to  = $week_del_mail_v2;
		
			$subject = $plantcode.' Weekly Delivery Plan Status';
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

