<?php  
$start_timestamp = microtime(true);
set_time_limit(90000);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

?>

<?php

$text="
<html><head><style type='text/css'>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}


	
</style></head>
<body>";
?>
<?php
$text.="<h3>Orders Summary Report</h3>";
$sdate=$edate=date("Y-m-d");

$order="(order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50)";


$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty,  sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_pro3.bai_orders_db_confirm where order_date between '$sdate' and '$edate' group by concat(order_del_no,order_col_des) union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty,  sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from $bai_pro3.bai_orders_db_confirm_archive where order_date between '$sdate' and '$edate' group by concat(order_del_no,order_col_des)";
	


	$text.= "<table id=\"example1\">";
	$text.= "<tr class='tblheading'>
	<th>Order Date</th>
	<th>Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Order</th>
	<th>Cut</th>
	<th>Balance To Cut</th>
	<th>In</th>
	<th>Balance To In</th>
	<th>Out</th>
	<th>Balance To Out</th>
	<th>Plan Module</th>
	
</tr>";
	
	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($sql_row=mysqli_fetch_array($sql_result))
	{

			$text.= "<tr>";
			$text.= "<td>".$sql_row['order_date']."</td>";
			$text.= "<td>".$sql_row['order_style_no']."</td>";
			$text.= "<td>".$sql_row['order_del_no']."</td>";
			$text.= "<td>".$sql_row['order_col_des']."</td>";
			$sql1="select group_concat(distinct(bac_no) order by bac_no) as bac_no from $bai_pro.bai_log_buf where delivery='".$sql_row['order_del_no']."' and color='".$sql_row['order_col_des']."'";
		 
		 // echo $sql1;
		 $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $module = mysqli_fetch_row($sql_result1);
			$text.= "<td>".$sql_row['orderqty']."</td>";
			$text.= "<td>".$sql_row['act_cut']."</td>";
			$text.= "<td>".($sql_row['orderqty']-$sql_row['act_cut'])."</td>";
			$text.= "<td>".$sql_row['act_in']."</td>";
			$text.= "<td>".($sql_row['act_cut']-$sql_row['act_in'])."</td>";
			$text.= "<td>".$sql_row['output']."</td>";
			$text.= "<td>".($sql_row['act_in']-$sql_row['output'])."</td>";
			$text.= "<td>".$module[0]."</td>";
			
			$text.= "</tr>";
	}
	$text.= "</table></body></html>";

// echo $text;


$to=$order_summary_report;


$subject = 'Order Summary Report';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
// $headers .= 'From: Shop Floor System Alert <bel_sfcs@brandix.com>'. "\r\n";
$headers .=$header_from. "\r\n";

	
		if(mail($to, $subject, $text, $headers))
		{
			print("mail sent successfully")."\n";
		}
		else
		{
			print("mail failed")."\n";
		}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
	
?>

