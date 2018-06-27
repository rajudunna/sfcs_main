<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
// for running these schedules in command prompt making entire code in single php file
error_reporting(0);
$date1=date("Y-m-d");
$weekday1 = strtolower(date('l', strtotime($date1)));
$weekday1='monday';
// echo "Week = ".$weekday1;

if($weekday1 != "tuesday")
{
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
			$start_date_w='2017-09-05';
			$end_date_w="2017-10-05";
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
			  <th >Style</th>
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

			$sql="select schedule_no from $bai_pro4.week_delivery_plan_ref where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" and schedule_no!=\"NULL\" order by color,left(style,1) ";

			$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"]));

			$count_rows=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$schedules[]=$sql_row['schedule_no'];
				
			}

			$cost1="";
			$total_cost=0;
			if($count_rows > 0)
			{

			$total_sch=implode(",",$schedules);
			$total_sch=str_replace(",,",",",$total_sch);
			$sql="select * from bai_pro3.bai_orders_db_confirm where order_del_no in ($total_sch) order by order_div,order_del_no desc";
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
				
				$message.="<tr style=\"background:green;\">";
				$order_tid=$sql_row["order_tid"];
				$sch=$sql_row["order_del_no"];
				$sch_color=$sql_row["order_col_des"];
				$message.="<td>$x</td>";
				$message.="<td>".$sql_row["order_div"]."</td>"; 
				$message.="<td>".$sql_row["order_style_no"]."</td>"; 
				$message.="<td>".$sql_row["order_del_no"]."</td>";
				$message.="<td>".$sql_row["order_col_des"]."</td>";
				$total=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"]+$sql_row["old_order_s_xxl"]+$sql_row["old_order_s_xxxl"]+$sql_row["old_order_s_s01"]+$sql_row["old_order_s_s02"]+$sql_row["old_order_s_s03"]+$sql_row["old_order_s_s04"]+$sql_row["old_order_s_s05"]+$sql_row["old_order_s_s06"]+$sql_row["old_order_s_s07"]+$sql_row["old_order_s_s08"]+$sql_row["old_order_s_s09"]+$sql_row["old_order_s_s10"]+$sql_row["old_order_s_s11"]+$sql_row["old_order_s_s12"]+$sql_row["old_order_s_s13"]+$sql_row["old_order_s_s14"]+$sql_row["old_order_s_s15"]+$sql_row["old_order_s_s16"]+$sql_row["old_order_s_s17"]+$sql_row["old_order_s_s18"]+$sql_row["old_order_s_s19"]+$sql_row["old_order_s_s20"]+$sql_row["old_order_s_s21"]+$sql_row["old_order_s_s22"]+$sql_row["old_order_s_s23"]+$sql_row["old_order_s_s24"]+$sql_row["old_order_s_s25"]+$sql_row["old_order_s_s26"]+$sql_row["old_order_s_s27"]+$sql_row["old_order_s_s28"]+$sql_row["old_order_s_s29"]+$sql_row["old_order_s_s30"]+$sql_row["old_order_s_s31"]+$sql_row["old_order_s_s32"]+$sql_row["old_order_s_s33"]+$sql_row["old_order_s_s34"]+$sql_row["old_order_s_s35"]+$sql_row["old_order_s_s36"]+$sql_row["old_order_s_s37"]+$sql_row["old_order_s_s38"]+$sql_row["old_order_s_s39"]+$sql_row["old_order_s_s40"]+$sql_row["old_order_s_s41"]+$sql_row["old_order_s_s42"]+$sql_row["old_order_s_s43"]+$sql_row["old_order_s_s44"]+$sql_row["old_order_s_s45"]+$sql_row["old_order_s_s46"]+$sql_row["old_order_s_s47"]+$sql_row["old_order_s_s48"]+$sql_row["old_order_s_s49"]+$sql_row["old_order_s_s50"];
				$message.="<td>".$total."</td>";
				
				$order_qty_total=$order_qty_total+$total;
				
				$total_qty=$sql_row["order_s_xs"]+$sql_row["order_s_s"]+$sql_row["order_s_m"]+$sql_row["order_s_l"]+$sql_row["order_s_xl"]+$sql_row["order_s_xxl"]+$sql_row["order_s_xxxl"]+$sql_row["order_s_s01"]+$sql_row["order_s_s02"]+$sql_row["order_s_s03"]+$sql_row["order_s_s04"]+$sql_row["order_s_s05"]+$sql_row["order_s_s06"]+$sql_row["order_s_s07"]+$sql_row["order_s_s08"]+$sql_row["order_s_s09"]+$sql_row["order_s_s10"]+$sql_row["order_s_s11"]+$sql_row["order_s_s12"]+$sql_row["order_s_s13"]+$sql_row["order_s_s14"]+$sql_row["order_s_s15"]+$sql_row["order_s_s16"]+$sql_row["order_s_s17"]+$sql_row["order_s_s18"]+$sql_row["order_s_s19"]+$sql_row["order_s_s20"]+$sql_row["order_s_s21"]+$sql_row["order_s_s22"]+$sql_row["order_s_s23"]+$sql_row["order_s_s24"]+$sql_row["order_s_s25"]+$sql_row["order_s_s26"]+$sql_row["order_s_s27"]+$sql_row["order_s_s28"]+$sql_row["order_s_s29"]+$sql_row["order_s_s30"]+$sql_row["order_s_s31"]+$sql_row["order_s_s32"]+$sql_row["order_s_s33"]+$sql_row["order_s_s34"]+$sql_row["order_s_s35"]+$sql_row["order_s_s36"]+$sql_row["order_s_s37"]+$sql_row["order_s_s38"]+$sql_row["order_s_s39"]+$sql_row["order_s_s40"]+$sql_row["order_s_s41"]+$sql_row["order_s_s42"]+$sql_row["order_s_s43"]+$sql_row["order_s_s44"]+$sql_row["order_s_s45"]+$sql_row["order_s_s46"]+$sql_row["order_s_s47"]+$sql_row["order_s_s48"]+$sql_row["order_s_s49"]+$sql_row["order_s_s50"];
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
				
				//shipemet details
				
				$sql4="SELECT SUM(ship_s_xs),SUM(ship_s_s),SUM(ship_s_m),SUM(ship_s_l),SUM(ship_s_xl),SUM(ship_s_xxl),SUM(ship_s_xxxl),SUM(ship_s_s01),SUM(ship_s_s02),SUM(ship_s_s03),SUM(ship_s_s04),SUM(ship_s_s05),SUM(ship_s_s06),SUM(ship_s_s07),SUM(ship_s_s08),SUM(ship_s_s09),SUM(ship_s_s10),SUM(ship_s_s11),SUM(ship_s_s12),SUM(ship_s_s13),SUM(ship_s_s14),SUM(ship_s_s15),SUM(ship_s_s16),SUM(ship_s_s17),SUM(ship_s_s18),SUM(ship_s_s19),SUM(ship_s_s20),SUM(ship_s_s21),SUM(ship_s_s22),SUM(ship_s_s23),SUM(ship_s_s24),SUM(ship_s_s25),SUM(ship_s_s26),SUM(ship_s_s27),SUM(ship_s_s28),SUM(ship_s_s29),SUM(ship_s_s30),SUM(ship_s_s31),SUM(ship_s_s32),SUM(ship_s_s33),SUM(ship_s_s34),SUM(ship_s_s35),SUM(ship_s_s36),SUM(ship_s_s37),SUM(ship_s_s38),SUM(ship_s_s39),SUM(ship_s_s40),SUM(ship_s_s41),SUM(ship_s_s42),SUM(ship_s_s43),SUM(ship_s_s44),SUM(ship_s_s45),SUM(ship_s_s46),SUM(ship_s_s47),SUM(ship_s_s48),SUM(ship_s_s49),SUM(ship_s_s50)  FROM $bai_pro3.ship_stat_log WHERE ship_schedule=\"$sch\" and ship_status=\"2\"";
				//echo $sql4;
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$total_rows=mysqli_num_rows($sql_result4);
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$ship_total=$sql_row4["SUM(ship_s_xs)"]+$sql_row4["SUM(ship_s_s)"]+$sql_row4["SUM(ship_s_m)"]+$sql_row4["SUM(ship_s_l)"]+$sql_row4["SUM(ship_s_xl)"]+$sql_row4["SUM(ship_s_xxl)"]+$sql_row4["SUM(ship_s_xxxl)"]+$sql_row4["SUM(ship_s_s01)"]+$sql_row4["SUM(ship_s_s02)"]+$sql_row4["SUM(ship_s_s03)"]+$sql_row4["SUM(ship_s_s04)"]+$sql_row4["SUM(ship_s_s05)"]+$sql_row4["SUM(ship_s_s06)"]+$sql_row4["SUM(ship_s_s07)"]+$sql_row4["SUM(ship_s_s08)"]+$sql_row4["SUM(ship_s_s09)"]+$sql_row4["SUM(ship_s_s10)"]+$sql_row4["SUM(ship_s_s11)"]+$sql_row4["SUM(ship_s_s12)"]+$sql_row4["SUM(ship_s_s13)"]+$sql_row4["SUM(ship_s_s14)"]+$sql_row4["SUM(ship_s_s15)"]+$sql_row4["SUM(ship_s_s16)"]+$sql_row4["SUM(ship_s_s17)"]+$sql_row4["SUM(ship_s_s18)"]+$sql_row4["SUM(ship_s_s19)"]+$sql_row4["SUM(ship_s_s20)"]+$sql_row4["SUM(ship_s_s21)"]+$sql_row4["SUM(ship_s_s22)"]+$sql_row4["SUM(ship_s_s23)"]+$sql_row4["SUM(ship_s_s24)"]+$sql_row4["SUM(ship_s_s25)"]+$sql_row4["SUM(ship_s_s26)"]+$sql_row4["SUM(ship_s_s27)"]+$sql_row4["SUM(ship_s_s28)"]+$sql_row4["SUM(ship_s_s29)"]+$sql_row4["SUM(ship_s_s30)"]+$sql_row4["SUM(ship_s_s31)"]+$sql_row4["SUM(ship_s_s32)"]+$sql_row4["SUM(ship_s_s33)"]+$sql_row4["SUM(ship_s_s34)"]+$sql_row4["SUM(ship_s_s35)"]+$sql_row4["SUM(ship_s_s36)"]+$sql_row4["SUM(ship_s_s37)"]+$sql_row4["SUM(ship_s_s38)"]+$sql_row4["SUM(ship_s_s39)"]+$sql_row4["SUM(ship_s_s40)"]+$sql_row4["SUM(ship_s_s41)"]+$sql_row4["SUM(ship_s_s42)"]+$sql_row4["SUM(ship_s_s43)"]+$sql_row4["SUM(ship_s_s44)"]+$sql_row4["SUM(ship_s_s45)"]+$sql_row4["SUM(ship_s_s46)"]+$sql_row4["SUM(ship_s_s47)"]+$sql_row4["SUM(ship_s_s48)"]+$sql_row4["SUM(ship_s_s49)"]+$sql_row4["SUM(ship_s_s50)"];
					//$message.="<td>".round($ship_total,0)."</td>";
				}
			}
			$message.="<tr><th colspan=2 style='color:white;background:red;'>Total</th><td colspan=3>Schedules:".$x."</td><td>$order_qty_total</td><td>$shipable_qty_total</td><td>$extra_qty_total</td><td></td>";
			echo "</tr>";

			}
			else
			{
				$message.="<h2 align=\"center\">Selected period Dont have any schedules to shipment</h2>";
			}

			$message.="</table>";
			$message.='<br/>Message Sent Via:'.$plant_name;
			$message.="</body></html>";

			// echo $message;

			$to  = $week_del_mail_v2;
		
			$subject = 'BEK Weekly Delivery Plan Status';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
			$headers .= $header_from. "\r\n";


				a:
				if(mail($to, $subject, $message, $headers))
				{
					print("Mail Successfully Sent.")."\n";
				}
				else
				{
					goto a;
				}

}
else
{

			include("material_requirement.php");
			// set_time_limit(10000000);
			//echo "welcome";exit;
			$message="<html>
			<head>
			<style type=\"text/css\">

			body
			{
				font-family: Calibri;
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
			include($include_path.'\sfcs_app\common\config\config_jobs.php');

			$start_date_w=time();

			while((date("N",$start_date_w))!=1) 
			{
			$start_date_w=$start_date_w-(60*60*24); // define monday
			}
			$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

			$start_date_w=date("Y-m-d",$start_date_w);
			$end_date_w=date("Y-m-d",$end_date_w);
		
			$date=date("Y-m-d");
			$weekday = strtolower(date('l', strtotime($date)));
			$colspan=14;
			$order_qty_total=0;
			$shipable_qty_total=0;
			$extra_qty_total=0;
			$m3_shipable_qty_total=0;
			$total_issued_yards=0;
			$total_allocated_yards=0;
			
			$message.="
			<table>
			 <tr><td colspan=$colspan><center><u><strong>Weekly Delivery Plan Status</strong></u></center></td></tr>
			  <tr>
			  <th bgcolor=\"yellow\">Sno</th> 
			  <th bgcolor=\"yellow\">Customer</th>
			  <th bgcolor=\"yellow\">Style</th>
			  <th bgcolor=\"yellow\">Schedule</th>
			  <th bgcolor=\"yellow\">Color</th>
			  <th bgcolor=\"yellow\">Order <br> Quantity</th>
			  <th bgcolor=\"yellow\">Shippable <br> Quantity</th>
			  <th bgcolor=\"yellow\">Extra Ship <br>Quantity</th>
			  <th bgcolor=\"yellow\">Planned  <br> Extra %</th>";
			  
			  // if($weekday != "tuesday")
			  // {
			  	$message.="<th bgcolor=\"yellow\">Shipped <br>Quantity(M3)</th>
			  	<th bgcolor=\"yellow\">Shipped <br>Quantity %</th>";
			  // }
			  
			  $message.="<th bgcolor=\"yellow\">Allocated <br> Yards</th>";
			  $message.="<th bgcolor=\"yellow\">Issued <br>Yards</th>";
			  $message.="<th bgcolor=\"yellow\">Extra Yards <br> Issued</th>";
			  
			  $message.="</tr>";
			$x=0;
			
			$schedules=array();
			$sql="select DISTINCT schedule_no from $bai_pro4.week_delivery_plan_ref where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\" and schedule_no!=\"\" order by color,left(style,1)";
			// echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count_rows=mysqli_num_rows($sql_result);
			
			
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$schedules[]=$sql_row['schedule_no'];
			}

			$cost1="";
			$total_cost=0;

			if($count_rows > 0)
			{

			$total_sch=implode(",",$schedules);

			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no in ($total_sch) order by order_div,order_del_no desc";
			// echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_nos=array();
				$x=$x+1; 
			
				$message.="<tr>";
				$order_tid=$sql_row["order_tid"];
				$sch=$sql_row["order_del_no"];
				$sch_color=$sql_row["order_col_des"];
				$style=$sql_row["order_style_no"];
				$message.="<td>$x</td>";
				$message.="<td>".$sql_row["order_div"]."</td>"; 
				$message.="<td>".$sql_row["order_style_no"]."</td>"; 
				$message.="<td>".$sql_row["order_del_no"]."</td>";
				$message.="<td>".$sql_row["order_col_des"]."</td>";
				$total=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"]+$sql_row["old_order_s_xxl"]+$sql_row["old_order_s_xxxl"]+$sql_row["old_order_s_s01"]+$sql_row["old_order_s_s02"]+$sql_row["old_order_s_s03"]+$sql_row["old_order_s_s04"]+$sql_row["old_order_s_s05"]+$sql_row["old_order_s_s06"]+$sql_row["old_order_s_s07"]+$sql_row["old_order_s_s08"]+$sql_row["old_order_s_s09"]+$sql_row["old_order_s_s10"]+$sql_row["old_order_s_s11"]+$sql_row["old_order_s_s12"]+$sql_row["old_order_s_s13"]+$sql_row["old_order_s_s14"]+$sql_row["old_order_s_s15"]+$sql_row["old_order_s_s16"]+$sql_row["old_order_s_s17"]+$sql_row["old_order_s_s18"]+$sql_row["old_order_s_s19"]+$sql_row["old_order_s_s20"]+$sql_row["old_order_s_s21"]+$sql_row["old_order_s_s22"]+$sql_row["old_order_s_s23"]+$sql_row["old_order_s_s24"]+$sql_row["old_order_s_s25"]+$sql_row["old_order_s_s26"]+$sql_row["old_order_s_s27"]+$sql_row["old_order_s_s28"]+$sql_row["old_order_s_s29"]+$sql_row["old_order_s_s30"]+$sql_row["old_order_s_s31"]+$sql_row["old_order_s_s32"]+$sql_row["old_order_s_s33"]+$sql_row["old_order_s_s34"]+$sql_row["old_order_s_s35"]+$sql_row["old_order_s_s36"]+$sql_row["old_order_s_s37"]+$sql_row["old_order_s_s38"]+$sql_row["old_order_s_s39"]+$sql_row["old_order_s_s40"]+$sql_row["old_order_s_s41"]+$sql_row["old_order_s_s42"]+$sql_row["old_order_s_s43"]+$sql_row["old_order_s_s44"]+$sql_row["old_order_s_s45"]+$sql_row["old_order_s_s46"]+$sql_row["old_order_s_s47"]+$sql_row["old_order_s_s48"]+$sql_row["old_order_s_s49"]+$sql_row["old_order_s_s50"];
				$message.="<td>".$total."</td>";
				
				$order_qty_total=$order_qty_total+$total;
				
				$total_qty=$sql_row["order_s_xs"]+$sql_row["order_s_s"]+$sql_row["order_s_m"]+$sql_row["order_s_l"]+$sql_row["order_s_xl"]+$sql_row["order_s_xxl"]+$sql_row["order_s_xxxl"]+$sql_row["order_s_s01"]+$sql_row["order_s_s02"]+$sql_row["order_s_s03"]+$sql_row["order_s_s04"]+$sql_row["order_s_s05"]+$sql_row["order_s_s06"]+$sql_row["order_s_s07"]+$sql_row["order_s_s08"]+$sql_row["order_s_s09"]+$sql_row["order_s_s10"]+$sql_row["order_s_s11"]+$sql_row["order_s_s12"]+$sql_row["order_s_s13"]+$sql_row["order_s_s14"]+$sql_row["order_s_s15"]+$sql_row["order_s_s16"]+$sql_row["order_s_s17"]+$sql_row["order_s_s18"]+$sql_row["order_s_s19"]+$sql_row["order_s_s20"]+$sql_row["order_s_s21"]+$sql_row["order_s_s22"]+$sql_row["order_s_s23"]+$sql_row["order_s_s24"]+$sql_row["order_s_s25"]+$sql_row["order_s_s26"]+$sql_row["order_s_s27"]+$sql_row["order_s_s28"]+$sql_row["order_s_s29"]+$sql_row["order_s_s30"]+$sql_row["order_s_s31"]+$sql_row["order_s_s32"]+$sql_row["order_s_s33"]+$sql_row["order_s_s34"]+$sql_row["order_s_s35"]+$sql_row["order_s_s36"]+$sql_row["order_s_s37"]+$sql_row["order_s_s38"]+$sql_row["order_s_s39"]+$sql_row["order_s_s40"]+$sql_row["order_s_s41"]+$sql_row["order_s_s42"]+$sql_row["order_s_s43"]+$sql_row["order_s_s44"]+$sql_row["order_s_s45"]+$sql_row["order_s_s46"]+$sql_row["order_s_s47"]+$sql_row["order_s_s48"]+$sql_row["order_s_s49"]+$sql_row["order_s_s50"];
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
				
				//shipemet details
				
				$sql4="SELECT SUM(ship_s_xs),SUM(ship_s_s),SUM(ship_s_m),SUM(ship_s_l),SUM(ship_s_xl),SUM(ship_s_xxl),SUM(ship_s_xxxl),SUM(ship_s_s01),SUM(ship_s_s02),SUM(ship_s_s03),SUM(ship_s_s04),SUM(ship_s_s05),SUM(ship_s_s06),SUM(ship_s_s07),SUM(ship_s_s08),SUM(ship_s_s09),SUM(ship_s_s10),SUM(ship_s_s11),SUM(ship_s_s12),SUM(ship_s_s13),SUM(ship_s_s14),SUM(ship_s_s15),SUM(ship_s_s16),SUM(ship_s_s17),SUM(ship_s_s18),SUM(ship_s_s19),SUM(ship_s_s20),SUM(ship_s_s21),SUM(ship_s_s22),SUM(ship_s_s23),SUM(ship_s_s24),SUM(ship_s_s25),SUM(ship_s_s26),SUM(ship_s_s27),SUM(ship_s_s28),SUM(ship_s_s29),SUM(ship_s_s30),SUM(ship_s_s31),SUM(ship_s_s32),SUM(ship_s_s33),SUM(ship_s_s34),SUM(ship_s_s35),SUM(ship_s_s36),SUM(ship_s_s37),SUM(ship_s_s38),SUM(ship_s_s39),SUM(ship_s_s40),SUM(ship_s_s41),SUM(ship_s_s42),SUM(ship_s_s43),SUM(ship_s_s44),SUM(ship_s_s45),SUM(ship_s_s46),SUM(ship_s_s47),SUM(ship_s_s48),SUM(ship_s_s49),SUM(ship_s_s50)  FROM $bai_pro3.ship_stat_log WHERE ship_schedule=\"$sch\" and ship_status=\"2\"";
				//echo $sql4;
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$total_rows=mysqli_num_rows($sql_result4);
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$ship_total=$sql_row4["SUM(ship_s_xs)"]+$sql_row4["SUM(ship_s_s)"]+$sql_row4["SUM(ship_s_m)"]+$sql_row4["SUM(ship_s_l)"]+$sql_row4["SUM(ship_s_xl)"]+$sql_row4["SUM(ship_s_xxl)"]+$sql_row4["SUM(ship_s_xxxl)"]+$sql_row4["SUM(ship_s_s01)"]+$sql_row4["SUM(ship_s_s02)"]+$sql_row4["SUM(ship_s_s03)"]+$sql_row4["SUM(ship_s_s04)"]+$sql_row4["SUM(ship_s_s05)"]+$sql_row4["SUM(ship_s_s06)"]+$sql_row4["SUM(ship_s_s07)"]+$sql_row4["SUM(ship_s_s08)"]+$sql_row4["SUM(ship_s_s09)"]+$sql_row4["SUM(ship_s_s10)"]+$sql_row4["SUM(ship_s_s11)"]+$sql_row4["SUM(ship_s_s12)"]+$sql_row4["SUM(ship_s_s13)"]+$sql_row4["SUM(ship_s_s14)"]+$sql_row4["SUM(ship_s_s15)"]+$sql_row4["SUM(ship_s_s16)"]+$sql_row4["SUM(ship_s_s17)"]+$sql_row4["SUM(ship_s_s18)"]+$sql_row4["SUM(ship_s_s19)"]+$sql_row4["SUM(ship_s_s20)"]+$sql_row4["SUM(ship_s_s21)"]+$sql_row4["SUM(ship_s_s22)"]+$sql_row4["SUM(ship_s_s23)"]+$sql_row4["SUM(ship_s_s24)"]+$sql_row4["SUM(ship_s_s25)"]+$sql_row4["SUM(ship_s_s26)"]+$sql_row4["SUM(ship_s_s27)"]+$sql_row4["SUM(ship_s_s28)"]+$sql_row4["SUM(ship_s_s29)"]+$sql_row4["SUM(ship_s_s30)"]+$sql_row4["SUM(ship_s_s31)"]+$sql_row4["SUM(ship_s_s32)"]+$sql_row4["SUM(ship_s_s33)"]+$sql_row4["SUM(ship_s_s34)"]+$sql_row4["SUM(ship_s_s35)"]+$sql_row4["SUM(ship_s_s36)"]+$sql_row4["SUM(ship_s_s37)"]+$sql_row4["SUM(ship_s_s38)"]+$sql_row4["SUM(ship_s_s39)"]+$sql_row4["SUM(ship_s_s40)"]+$sql_row4["SUM(ship_s_s41)"]+$sql_row4["SUM(ship_s_s42)"]+$sql_row4["SUM(ship_s_s43)"]+$sql_row4["SUM(ship_s_s44)"]+$sql_row4["SUM(ship_s_s45)"]+$sql_row4["SUM(ship_s_s46)"]+$sql_row4["SUM(ship_s_s47)"]+$sql_row4["SUM(ship_s_s48)"]+$sql_row4["SUM(ship_s_s49)"]+$sql_row4["SUM(ship_s_s50)"];
					
				}
				
				//M3 shipment quantity
				// if($weekday != "tuesday")
			 //  	{
					$sql5="SELECT SUM(ship_qty) FROM $bai_pro2.style_status_summ WHERE sch_no=\"$sch\" and color=\"".$sch_color."\"";
					$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$total_rows1=mysqli_num_rows($sql_result5);
					while($sql_row5=mysqli_fetch_array($sql_result5))
					{
						$m3_total=$sql_row5["SUM(ship_qty)"];
						$message.="<td>".round($m3_total,0)."</td>";
						$m3_shipable_qty_total=$m3_shipable_qty_total+$m3_total;
					}
					
					$m3_ship=100+round(($m3_total-$total)*100/$total,0);
					$color="<font color=black>";
					
					if($m3_ship > 100)
					{
						$color="<font color=red>";
					}
					if($m3_total=='' || $m3_ship==''){
						$message.="<td>$color 0%</td>";
					}else{
						$message.="<td>$color".$m3_ship."%</td>";
					}
					
				// }
				
				$sql_yy="select catyy,tid,compo_no from $bai_pro3.cat_stat_log where order_tid=\"".$order_tid."\" and (category=\"Body\" or category=\"Front\")";
				$sql_result_yy=mysqli_query($link, $sql_yy) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$total_rows_yy=mysqli_num_rows($sql_result_yy);
				while($sql_row_yy=mysqli_fetch_array($sql_result_yy))
				{
					$cat_yy=$sql_row_yy["catyy"];
					$cat_tid=$sql_row_yy["tid"];
					$compo_no=$sql_row_yy["compo_no"];		
				}
				
				
				$allocated_yards_m3=m3_alloc_qty($style,$sch,$compo_no);
				
				$allocated_yards=$allocated_yards_m3["allocated"];
				$issued_yards=$allocated_yards_m3["issued"];
				
				$message.="<td>".round($allocated_yards,2)."</td>";
				$total_allocated_yards=$total_allocated_yards+$allocated_yards;
				
				$message.="<td>".round($issued_yards,2)."</td>";
				$total_issued_yards=$total_issued_yards+$issued_yards;
				

				
				if($allocated_yards > 0)
				{
					if(($allocated_yards-$issued_yards) >= 0)
					{
						$message.="<td>0</td>";
					}
					else
					{
						$message.="<td>".(round(($allocated_yards-$issued_yards),2)*-1)."</td>";
					}		
				}
				else
				{
					$message.="<td>0</td>";
				}
				
				unset($doc_nos);
			}

			$message.="<tr><th colspan=2 style='color:white;background:red;'>Total</th><td colspan=3>Schedules:".$x."</td><td>$order_qty_total</td><td>$shipable_qty_total</td><td>$extra_qty_total</td><td></td>";
			// if($weekday != "tuesday")
			// {
				$message.="<td>TESST $m3_shipable_qty_total</td><td></td>";
			// }  	
			$message.="<td>".round($total_allocated_yards,2)."</td>";
			$message.="<td>".round($total_issued_yards,2)."</td>";
			$extra_issued_yards=($total_allocated_yards-$total_issued_yards);
			if($extra_issued_yards > 0)
			{
				$message.="<td>".round($extra_issued_yards,2)."</td>";
			}
			else
			{
				$message.="<td>".round(($extra_issued_yards*-1),2)."</td>";
			}

				
			echo "</tr>";

			}
			else
			{
				$message.="<h2 align=\"center\">Selected period Dont have any schedules to shipment</h2>";
			}

			$message.="</table>";
			$message.='<br/>Message Sent Via: '.$plant_name;
			$message.="</body></html>";

			echo $message;//exit;

			$myFile1 = "Weekly_Delivery_Plan_Status.xls";
			unlink($myFile1);
			$fh1 = fopen($myFile1, 'w') or die("can't open file");
			$stringData1=$message;
			fwrite($fh1, $stringData1);
			fclose($fh1);


				function email_attachment($to_email, $email, $subject,$our_email_name, $our_email, $file_location, $default_filetype='application/zip')
				{

					$email = '<font face="arial">' . $email . '</font>';
					$fileatt = $file_location;
					// if(function_exists(mime_content_type)){
					// 	$fileatttype = mime_content_type($file_location);
					// }else{
					// 	$fileatttype = $default_filetype;
					// }
					$fileatttype = $default_filetype;
					$fileattname =basename($file_location);
					//prepare attachment
					$file = fopen( $fileatt, 'rb' );
					$data = fread( $file, filesize( $fileatt ) );
					fclose( $file );
					$data = chunk_split( base64_encode( $data ) );
					//create mime boundary
					$semi_rand = md5( time() );
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
					//create email  section
					$message = "This is a multi-part message in MIME format.\n\n" .
					"--{$mime_boundary}\n" .
					"Content-type: text/html; charset=us-ascii\n" .
					"Content-Transfer-Encoding: 7bit\n\n" .
					$email . "\n\n";
					 //create attachment section
					$message .= "--{$mime_boundary}\n" .
					 "Content-Type: {$fileatttype};\n" .
					 " name=\"{$fileattname}\"\n" .
					 "Content-Disposition: attachment;\n" .
					 " filename=\"{$fileattname}\"\n" .
					 "Content-Transfer-Encoding: base64\n\n" .
					 $data . "\n\n" .
					 "--{$mime_boundary}--\n";
					 //headers
					$exp=explode('@', $our_email);
					$domain = $exp[1];
					$headers = "From: $our_email_name<$our_email>" . "\n";
					$headers .= "Reply-To: $our_email"."\n";
					$headers .= "Return-Path: $our_email" . "\n";	// these two to set reply address
					$headers .= "Message-ID: <".time()."@" . $domain . ">"."\n";
					$headers .= "X-Mailer: Edmonds Commerce Email Attachment Function"."\n";		  // These two to help avoid spam-filters
					$headers .= "Date: ".date("r")."\n";
					$headers .= "MIME-Version: 1.0\n" .
									"Content-Type: multipart/mixed;\n" .
									" boundary=\"{$mime_boundary}\"";
					mail($to_email,$subject,$message, $headers, '-f ' . $our_email) or die ('<h3 style="color: red;">Mail Failed</h3>');
					//echo "<script>window.close();</script>";
				}
				$subject='Dear All, <br/><br/> Please Find The Weekly Delivery Plan Status Report of This Week. <br/><br/> Message Sent Via:'.$plant_name;
				$to=$week_del_mail_v2;
				email_attachment($to,$subject,' Weekly Delivery Plan Status Report','Shop Floor System Alert', 'ravindranath.yrr35@gmail.com', 'Weekly_Delivery_Plan_Status.xls', $default_filetype='application/zip');

}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>

