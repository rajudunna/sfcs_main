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
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>


<?php

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
		
		
			$table.="<table border=1>";
			$table.="<tr><td colspan=13><h2><center><strong>Sewing Out Report</strong></center></h2></td></tr>";
			$table.="<tr><td colspan=13>For the period: $dat1 to $dat2</td></tr></table>";
		
			//echo "<right><strong><a href=\"sawing_out_excel.php?sdate=$dat1&edate=$dat2\">Export to Excel</a></strong></right>";	
			$sql="SELECT * FROM $bai_pro3.pac_sawing_out where outs='1' AND scan_date BETWEEN '$dat1' AND '$dat2'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
		}else if($sch !=""){
						
			$table.="<table border=1>";
			$table.="<tr><td colspan=11><h2><center><strong>Daily Production Status Report</strong></center></h2></td></tr>";
			$table.="<tr><td colspan=11>For the period: $dat1 to $dat2</td></tr>";
			$table.="<tr><td colspan=11>Schedule: $sch</td></tr></table>";
		
			//echo "<right><strong><a href=\"sawing_out_excel.php?sdate=$dat1&edate=$dat2&schedule=$sch\">Export to Excel</a></strong></right>";
			$sql="SELECT * FROM $bai_pro3.pac_sawing_out where outs='1' AND schedule='$sch' AND scan_date BETWEEN '$dat1' AND '$dat2'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
		
		}


		$table.="<table id='table5' border=1>
		<tr><th>Barcode ID</th>
		<th>Date and Time</th>
		<th>Module</th>
		<th>Section</th>
		<th>Shift</th>
		<th>User Style</th>
		<th>Movex Style</th>
		<th>Schedule</th>
		<th>Color</th>
		<th>Cut Job No</th>
		<th>Input Job No</th>
		<th>Size</th>
		<th>Qty</th>
		</tr>";
	?>	
	<?php
		while($rows=mysqli_fetch_array($sql_result)){
	$dat=$rows['scan_date'];
	$module=$rows['module'];
	$bid=$rows['tid'];
	
	$sql1="SELECT section_id FROM $bai_pro3.plan_modules WHERE module_id='$module'";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));	
	$rows1=mysqli_fetch_array($sql_result1);
	$sec_id=$rows1['section_id'];
	
	$shift='A';
	$ustyle=$rows['style'];
	$mstyle=$rows['style'];
	$schedule=$rows['schedule'];
	$color=$rows['color'];
	$doc_no=$rows['doc_no'];
	$sql2="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_row2=mysqli_fetch_array($sql_result2);
				
					$order_tid=$sql_row2['order_tid'];
					$cutno=$sql_row2['acutno'];
					
	$sql3="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
    $sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_row3=mysqli_fetch_array($sql_result3);
	$sql4="select * from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"$order_tid\"";
	$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_row4=mysqli_fetch_array($sql_result4);
	$color_code=$sql_row3['color_code'];
	$cut_job=chr($color_code).'00'.$cutno;
	$job_no='J00'.$rows['input_job_number'];
	$size=$rows['size'];
	$qty=$rows['qty'];
	
	$table.="<tr>";
	$table.="<td>$bid</td>";
	$table.="<td>$dat</td>";
	$table.="<td>$module</td>";
	$table.="<td>$sec_id</td>";
	$table.="<td>$shift</td>";
	$table.="<td>$ustyle</td>";
	$table.="<td>$mstyle</td>";
	$table.="<td>$schedule</td>";
	$table.="<td>$color</td>";
	$table.="<td>$cut_job</td>";
	$table.="<td>$job_no</td>";
	$table.="<td>$size</td>";
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


	