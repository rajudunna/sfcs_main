<html>
<head>

<?php  
error_reporting(0);
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$plant_code=$_SESSION['plantCode'];
$cache_date="previous_week";
$cachefile = $cache_date."html";

/* if (file_exists($cachefile)) {

	include($cachefile);

	exit;

} */
ob_start();
?>

<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>

<script type="text/javascript" src="/sfcs_app/common/js/table2CSV.js" ></script>

<script>
	function downloadFile(fileName, urlData) {
	    var aLink = document.createElement('a');
	    aLink.download = fileName;
	    aLink.href = urlData;
	    var event = new MouseEvent('click');
	    aLink.dispatchEvent(event);
	   }
	function getCSVData() {
		var data = $('#example').table2CSV({delivery: 'value',filename: 'previous_week.csv'});
        downloadFile('previous_week.csv', 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data));

	}
</script>
<style>
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
}


}

}
</style>


</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading"></diV>
<div class="panel-body">
<?php

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);



// if(in_array($username,$author_id_db))


//if(isset($_POST['filter']) or isset($_POST['filter2']))
{
	
	$start_date_w=time();
	
	while((date("N",$start_date_w))!=1) {
	$start_date_w=$start_date_w-(60*60*24); // define monday
	}
	$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

	$start_date_w=date("Y-m-d",$start_date_w);
	$end_date_w=date("Y-m-d",$end_date_w);
	
	$sdate=date("Y-m-d",strtotime("-7 days",strtotime($start_date_w)));
	$edate=date("Y-m-d",strtotime("-7 days",strtotime($end_date_w)));
	
	//$sdate="2012-11-26";
	//$edate="2012-12-01";
	
	echo "<h2><b>LU:".date("Y-m-d H:i:s")."</b></h2>";
	echo '<form action="export_excel1.php" method ="post" > 
<input type="hidden" name="csv_text" id="csv_text">
<input type="button" class="btn btn-xs btn-success" value="Export to Excel" onclick="getCSVData()">
</form>';
	echo "<div  class=\"table-responsive\"><table id=\"example\" table align=\"left\" class=\"table table-bordered\">";
	echo "<tr>
	<th>Division</th>
	<th>FG Status</th>
	<th>Ex-Factory</th>
	<th>Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Section</th>
	<th>Size</th>
	<th>Total Order <br/>Quantity</th>
	<th>Total Cut <br/>Quantity</th>
	<th>Total Input <br/>Quantity</th>
	<th>Total Sewing Out <br/>Quantity</th>
	<th>Total FG <br/>Quantity</th>
	<th>Total FCA <br/>Quantity</th>";
	//echo "<th>Total MCA <br/>Quantity</th>";
	
	// echo "<th>Total Shipped <br/>Quantity</th>
	echo"<th>Rejected <br/>Quantity</th>
	<th>Sample <br/>Quantity</th>";
	// <th>Good Panel <br/>Quantity</th>
	// <th>Out of Ratio <br/>Quantity</th>
	// <th>Total Missing<br/>Panels</th>
	echo"<th class=\"total\" style='background-color:#29759C;'>Sewing <br/>Missing</th>";
	// <th class=\"total\" style='background-color:#29759C;'>Panel Room <br/>Missing</th>
	echo"<th class=\"total\" style='background-color:#29759C;'>Cutting <br/>Missing</th>
</tr>";
$sdate=date('Ymd', strtotime($sdate));
$edate=date('Ymd', strtotime($edate));
	// if(isset($_POST['filter2']))
	// {
	// 	$sch_db=$_POST['schedule'];
	// 	$sql="select style,schedule_no,color,ssc_code_new,priority,buyer_division,ex_factory_date_new,sections from bai_pro4.bai_cut_to_ship_ref where schedule_no=\"$sch_db\" order by ex_factory_date_new";
	// }
	// else
	// {
		$Qry_get_buyer_division="SELECT buyer_desc,planned_delivery_date,po_number,mo_number FROM $oms.oms_mo_details WHERE planned_delivery_date between '20180101' and '20210101' AND plant_code='$plant_code' AND is_active=1 order by planned_delivery_date";
		//  echo $Qry_get_buyer_division;
		$result1 = $link->query($Qry_get_buyer_division);
		while($row1 = $result1->fetch_assoc())
		{
			
			$po_number[]=$row1['po_number'];
			$mo_number=$row1['mo_number'];
			
		}
		$po_number1="'".implode("','",$po_number)."'";
			$get_sub_po_number="SELECT po_number,master_po_number FROM $pps.`mp_sub_order` WHERE master_po_number  in($po_number1) AND plant_code='$plant_code' AND is_active=1";
			// echo $get_sub_po_number;
			$sql_result22=mysqli_query($link, $get_sub_po_number) or die("Error2".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row22=mysqli_fetch_array($sql_result22))
			{
				$sub_po_number[]=$row22['po_number'];
				$po_num[]=$row22['master_po_number'];
			} 
			$sub_po_number1="'".implode("','",$sub_po_number)."'";
			$po_num1="'".implode("','",$po_num)."'";
		
			$qry_get_sch_col="SELECT schedule,color FROM $pps.`mp_sub_mo_qty` LEFT JOIN $pps.`mp_mo_qty` ON mp_sub_mo_qty.`mp_mo_qty_id`= mp_mo_qty.`mp_mo_qty_id`
			WHERE po_number in ($sub_po_number1) AND mp_sub_mo_qty.plant_code='$plant_code' group by schedule,color";
			
			$qry_get_sch_col_result=mysqli_query($link_new, $qry_get_sch_col) or exit("Sql Error at qry_get_sch_col".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($qry_get_sch_col_result))
			{
			$schedule=$row['schedule'];
			$color=trim($row['color']);
			
			//$color_bulk=array_unique($color);
			//To get style
			$qry_get_style="SELECT style FROM $pps.`mp_mo_qty` LEFT JOIN $pps.`mp_color_detail` ON mp_color_detail.`master_po_details_id`=mp_mo_qty.`master_po_details_id` WHERE mp_mo_qty.color ='$color' and mp_color_detail.plant_code='$plant_code' group by style";
			
			$qry_get_style_result=mysqli_query($link_new, $qry_get_style) or exit("Sql Error at qry_get_style".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($qry_get_style_result))
			{
			$style=$row1['style'];
			}  

			$sql2="SELECT mo_quantity AS quantity,planned_delivery_date,buyer_desc FROM $oms.`oms_mo_details` WHERE schedule='$schedule' AND plant_code='$plant_code' AND is_active=1";
			$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
		
			while($row2=mysqli_fetch_array($sql_result2))
			{
				$total_order_qty=$row2['quantity'];
				$planned_delivery_date=$row2['planned_delivery_date'];
				$buyer_desc=$row2['buyer_desc'];
			} 
			 //get jm_jg_header_id
			$job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
			$Qry_get_header_id="SELECT jm_jg_header_id FROM $pps.jm_jg_header LEFT JOIN $pps.jm_job_header on jm_job_header.jm_job_header_id = jm_jg_header.jm_job_header WHERE master_po_number in($po_num1) AND po_number in ($sub_po_number1) AND jm_jg_header.job_group_type='$job_group_type' AND jm_job_header.plant_code='$plant_code' AND jm_job_header.is_active=1";
			
			$result2 = $link->query($Qry_get_header_id);
			while($row2 = $result2->fetch_assoc())
			{
			$jm_jg_header_id[]=$row2['jm_jg_header_id'];
			}
			$jm_jg_header_id1="'".implode("','",$jm_jg_header_id)."'";
			//Get task_job_ids
			$Qry_get_task_jobid="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference in($jm_jg_header_id1) AND plant_code='$plant_code' AND is_active=1";

			$result3 = $link->query($Qry_get_task_jobid);
			while($row3 = $result3->fetch_assoc())
			{
			$task_jobs_id[]=$row3['task_jobs_id'];
			}
			$task_jobs_id1="'".implode("','",$task_jobs_id)."'";
			        //To get cutting operation
			$category=OperationCategory::CUTTING;
			$Qry_get_cut_ops="SELECT operation_code FROM $pms.`operation_mapping` WHERE operation_name='$category' AND plant_code='$plant_code' AND is_active=1";
			$result4 = $link->query($Qry_get_cut_ops);
			while($row4 = $result4->fetch_assoc())
			{
				$cut_operation=$row4['operation_code'];
			}
			$pack_operation='200';
			$qrytoGetMinOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id in ($task_jobs_id1) AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
			
			$minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
			
			if(mysqli_num_rows($minOperationResult)>0){
				while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
					$minOperation=$minOperationResultRow['operation_code'];
				}
			}

			 /**
         * getting min and max operations
         */
		$qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id in($task_jobs_id1) AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
		$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
	
        if(mysqli_num_rows($maxOperationResult)>0){
            while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                $maxOperation=$maxOperationResultRow['operation_code'];
            }
		}
	
		$get_details="SELECT style,schedule,color,size,resource_id,sum(if(operation=".$minOperation.",good_quantity,0)) as input_quantity,sum(if(operation=".$maxOperation.",good_quantity,0)) as output_quantity,sum(if(operation=".$cut_operation.",good_quantity,0)) as cut_quantity,sum(if(operation=".$pack_operation.",good_quantity,0)) as fg_quantity,sum(rejected_quantity) as rejected_qty FROM $pts.transaction_log WHERE style='$style' AND schedule='$schedule' AND color='$color' AND plant_code='$plant_code' AND is_active=1 GROUP BY size";
		//echo $get_details;
        $result5 = $link->query($get_details);
        while($row5 = $result5->fetch_assoc())
        {
            $sizes=$row5['$row5'];
            $input_quantity=$row5['input_quantity'];
            $output_quantity=$row5['output_quantity'];
			$cut_quantity=$row5['cut_quantity'];
			$fg_quantity=$row5['fg_quantity'];
			$rejected_qty=$row5['rejected_qty'];
			
			if($cut_quantity ==0)
			{
				$status='RM';
			} else if($cut_quantity !=0)
			{
				$status='CUT';
			} else if($input_quantity > 0 || $output_quantity > 0)
			{
                $status='SEWING';
			} else if($fg_quantity > 0)
			{
				$status='FG';
			}
              
            
		}  
		echo "<tr>";
		echo "<td>".$buyer_desc."</td>";
		echo "<td>".$status."</td>";
		echo "<td>".$planned_delivery_date."</td>";
		// echo "<td><a href=\"pop_report.php?style=$style&schedule=$schedule&color=$color\" onclick=\"Popup=window.open('pop_report.php?style=$style&schedule=$schedule&color=$color"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$sql_row['style']."</a></td>";
		echo "<td>".$style."</td>";
		echo "<td>".$schedule."</td>";
		echo "<td>".$color."</td>";
		echo "<td></td>";
		echo "<td>".$sizes."</td>";
		echo "<td>".$total_order_qty."</td>";
		echo "<td>".$cut_quantity."</td>";
		echo "<td>".$input_quantity."</td>";
		echo "<td>".$output_quantity."</td>";
		echo "<td>".$fg_quantity."</td>";
		echo "<td>0</td>";
		echo "<td>".$rejected_qty."</td>";
		echo "<td>0</td>";
		echo "<td>0</td>";
		echo "<td>0</td>";
	
		echo "</tr>"; 
			
		}

}
echo "</table></div>";

?>





<?php

$cachefile = $path."/packing/reports/".$cache_date.'.html';
// open the cache file "cache/home.html" for writing
$fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
fwrite($fp, ob_get_contents());
// close the file
fclose($fp);
// Send the output to the browser
ob_end_flush();


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("</br></br></br></br>Execution took ".$duration." milliseconds.");
?>
</div></div>
</body>
</html>