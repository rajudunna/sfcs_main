<!--
CR -Sawing out Reporting Process in BEK .
Report for date range (Excel extraction)
-->
<!--
CR -Sawing out Reporting Process in BEK .
Report for date range
-->


<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: solid black;
	text-align: right;
white-space:nowrap; 
text-align:left;
}

table th
{
	border: solid black;
	text-align: center;
    	background-color: RED;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>


<?php 
 include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  



	    if($_GET['schedule']){
			$dat1=$_GET['sdate'];	
			$dat2=$_GET['edate'];
			$sch=$_GET['schedule'];
		
		}else{
		    $dat1=$_GET['sdate'];	
			$dat2=$_GET['edate'];
			$sch="";
		
		}
		if($sch==""){
		
			$table='';	
			$table.="<table border=1>";
			$table.="<tr><td colspan=13><h2><center><strong>Sewing Out Report</strong></center></h2></td></tr>";
			$table.="<tr><td colspan=13>For the period: $dat1 to $dat2</td></tr></table>";
		
			//echo "<right><strong><a href=\"sawing_out_excel.php?sdate=$dat1&edate=$dat2\">Export to Excel</a></strong></right>";	
			$sql="SELECT * FROM $bai_pro3.pac_stat_log where status=\"DONE\" AND scan_date BETWEEN '$dat1' AND '$dat2'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
		}else if($sch !=""){
						
			$table.="<table border=1>";
			$table.="<tr><td colspan=11><h2><center><strong>Daily Production Status Report</strong></center></h2></td></tr>";
			$table.="<tr><td colspan=11>For the period: $dat1 to $dat2</td></tr>";
			$table.="<tr><td colspan=11>Schedule: $sch</td></tr></table>";
		
			//echo "<right><strong><a href=\"sawing_out_excel.php?sdate=$dat1&edate=$dat2&schedule=$sch\">Export to Excel</a></strong></right>";
			$sql="SELECT * FROM $bai_pro3.pac_stat_log where status=\"DONE\"  AND schedule='$sch' AND scan_date BETWEEN '$dat1' AND '$dat2'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
		
		}


		$table.="<table id='table5' border=1>
					<tr>
						<th>Barcode ID</th>
						<th>Date and Time</th>
						<th>Style</th>
						<th>Schedule</th>
						<th>Color</th>
						<th>Size</th>
						<th>Qty</th>
					</tr>";

					while($rows=mysqli_fetch_array($sql_result))
					{
						$dat=$rows['scan_date'];
						$bid=$rows['pac_stat_id'];
						
						$style=$rows['style'];
						$schedule=$rows['schedule'];
						$color=$rows['color'];

						$size=$rows['size_code'];
						$qty=$rows['carton_act_qty'];
						$size_tit=$rows['size_tit'];
						
						$sql="SELECT title_size_".$size." as size FROM $bai_pro3.bai_orders_db WHERE order_del_no=\"$schedule\" AND order_col_des=\"$color\"";
						// echo $sql;
						$sql_result1=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($title_size = mysqli_fetch_array($sql_result1))
						{	
							// echo "size".$title_size["size"];
							$title_size_ref=$title_size["size"];
						}
						
						$table.="<tr>";
						$table.="<td>$bid</td>";
						$table.="<td>$dat</td>";
						$table.="<td>$style</td>";
						$table.="<td>$schedule</td>";
						$table.="<td>$color</td>";
						$table.="<td>".$title_size_ref."</td>";
						$table.="<td>$qty</td>";
						$table.="</tr>";
					}
	$table.="</table>";
	    header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=sawing_out_report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	echo $table;
?>	