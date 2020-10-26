<?php  
$start_timestamp = microtime(true);
set_time_limit(90000);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$plant_code=$_SESSION['plantCode'];

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
$sdate=$edate='20200714';

$email_validate=0;
$cut_operation=15;
$sew_in_op=100;
$sew_out_op=130;
$operation_code_array=[15,100,130];


$sql="SELECT po_number,schedule,planned_cut_date FROM $oms.oms_mo_details where planned_cut_date between  '$sdate' and '$edate' and po_number !='' and plant_code='$plant_code' group by po_number";
	

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
		$po_number=$sql_row['po_number'];
		$schedule=$sql_row['schedule'];
		$order_date=$sql_row['planned_cut_date'];
		$sql1="SELECT style,color,master_po_details_id FROM $pps.mp_color_detail where master_po_number='$po_number' group by style,color";
		// echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$row_count++;
			$style=$sql_row1['style'];
			$color=$sql_row1['color'];
			$master_po_details_id=$sql_row1['master_po_details_id'];
			// var_dump($style,$color,$schedule,$po_number,"<br>");
			$sql2="SELECT sum(quantity) as order_qty FROM $pps.mp_mo_qty where master_po_details_id='$master_po_details_id' and mp_qty_type='ORIGINAL_QUANTITY' group by schedule,color";
			// echo $sql2."<br/>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$order_qty=$sql_row2['order_qty'];
			}
			$finished_good_id=[];
			$sql3="SELECT finished_good_id FROM $pts.finished_good WHERE  master_po ='$po_number' AND style='$style' AND color='$color' AND SCHEDULE='$schedule'";
			// echo $sql3."<br/>";

			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$finished_good_id[]=$sql_row3['finished_good_id'];
			}
			$cut_qty=0;
			$sew_in=0;
			$sew_out=0;

			if(sizeof($finished_good_id) >0){
				$finished_good_ids = "'" . implode( "','", $finished_good_id) . "'";
				$operation_codes = "'" . implode( "','", $operation_code_array) . "'";


				$sql4="SELECT SUM(IF(operation_code=$cut_operation,1,0)) AS cut_qty,SUM(IF(operation_code=$sew_in_op,1,0)) AS sew_in,SUM(IF(operation_code=$sew_out_op,1,0)) AS sew_out FROM $pts.fg_operation WHERE finished_good_id IN ($finished_good_ids) AND operation_code IN ($operation_codes) AND required_components=completed_components";
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$cut_qty=(int)$sql_row4['cut_qty'];
					$sew_in=(int)$sql_row4['sew_in'];
					$sew_out=(int)$sql_row4['sew_out'];
				}
			}
				
			$text.="<tr>";
			$text.="<td>".$order_date."</td>";
			$text.="<td>".$style."</td>";
			$text.="<td>".$schedule."</td>";
			$text.="<td>".$color."</td>";
			$text.="<td>".$order_qty."</td>";
			$text.="<td>".$cut_qty."</td>";
			$text.="<td>".($order_qty-$cut_qty)."</td>";
			$text.="<td>".$sew_in."</td>";
			$text.="<td>".($order_qty-$sew_in)."</td>";

			$text.="<td>".$sew_out."</td>";
			$text.="<td>".($order_qty-$sew_out)."</td>";

			$text.="<td>".$module."</td>";
			$text.="</tr>";
			
			$email_validate++;
		}
			
	}
	$text.= "</table></body></html>";

// echo $text;

$to=$order_summary_report;


$subject = 'Order Summary Report';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
// $headers .=$header_from. "\r\n";

	if($email_validate >0)
	{
		if(mail($to, $subject, $text, $headers))
		{
			print("mail sent successfully")."\n";
		}
		else
		{
			print("mail failed")."\n";
		}
		
	}else
	{
		print("mail Not Send Due to data not found")."\n";
	}
	
		

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
	
?>

