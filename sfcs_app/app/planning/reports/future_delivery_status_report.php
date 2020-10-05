<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// include("header.php");
set_time_limit(60000);

function div_by_zero($arg)
{
	$arg1=1;
	if($arg==0 or $arg=='0' or $arg=='')
	{
		$arg1=1;
	}
	else
	{
		$arg1=$arg;
	}
	return $arg1;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<title>Future Delivery Status Report</title>
<meta name="" content="">
<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">

<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>




</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Future Delivery Status Report</div>
<div class="panel-body">
<div class="form-group">
<!--<div id="page_heading" style="left: 500px;"	><span style="float"><h3>Future Delivery Status Report</h3></span></div>-->
<?php
$table_flag = false;
	$sql="SELECT section_name FROM $pms.`sections` WHERE plant_code='$plantcode' AND is_active=1";
	$result=mysqli_query($link, $sql) or die ("sql error--s".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
    $section=array();   
    while($sql_row=mysqli_fetch_array($result))
	{
		$section[]=$sql_row["section_name"];		
 	}

	$numberofsecs=strtotime( "next monday" );
	$next_mon=date('Ymd', $numberofsecs);
	echo "<div class='table-responsive' id='main_content'>
	<table border='1px' cellpadding=\"0\" cellspacing=\"0\" class=\"mytable table table-bordered\" id=\"table1\">
	<tr class='info'>
		<th>Customer</th><th>Style</th><th>Schedule</th><th>Color</th><th>Order Qty</th><th>Output</th><th>Achievement %</th><th>FG Status</th><th>PED</th>";
	for($i=0;$i<sizeof($section);$i++)
	{		
		echo "<th>".$section[$i]."(Input)</th>"; 
		echo "<th>".$section[$i]."(Output)</th>"; 
	}	
	echo "</tr>";
	//getting deatils from oms_mo_details
	$get_po_sch_qry="SELECT mo_number,schedule,buyer_desc,po_number,mo_quantity,planned_delivery_date FROM $oms.`oms_mo_details` WHERE planned_delivery_date>='".$next_mon."' AND plant_code='$plantcode'";
	$get_po_sch_qry_result=mysqli_query($link, $get_po_sch_qry) or die ("sql error getting details from oms".$sql.mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($get_po_sch_row=mysqli_fetch_array($get_po_sch_qry_result))
	{
		$mo_number=$get_po_sch_row['mo_number'];
		$schedule=$get_po_sch_row['schedule'];
		$buyer_desc=$get_po_sch_row['buyer_desc'];
		$po_number=$get_po_sch_row['po_number'];
		$mo_quantity=$get_po_sch_row['mo_quantity'];
		$planned_delivery_date=$get_po_sch_row['planned_delivery_date'];
		
		
		//getting style and color for po_number
		$get_style_qry="SELECT style,color FROM pps.`mp_color_detail` WHERE plant_code='$plantcode' AND master_po_number='$po_number'";
		$get_style_qry_result=mysqli_query($link, $get_style_qry) or die ("sql error getting details of style and color".$sql.mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($get_style_col_row=mysqli_fetch_array($get_style_qry_result))
		{
			$style=$get_style_col_row['style'];
			$color=$get_style_col_row['color'];
		}
		//getting jm_product_logical_bundle_id
		$get_jplbid_qry="SELECT jm_pplb_id FROM $pps.`jm_product_logical_bundle` WHERE plant_code='$plantcode' AND feature_value='$schedule' AND po_number='$po_number'";
		$get_jplbid_qry_result=mysqli_query($link, $get_jplbid_qry) or die ("sql error getting details from jm_product_logical_bundle".$sql.mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($get_jplbid_row=mysqli_fetch_array($get_jplbid_qry_result))
		{
			$jm_pplb_id=$get_jplbid_row['jm_pplb_id'];
			
			//getting jm_job_bundle_id
			$get_jjbid_qry="SELECT jm_job_bundle_id FROM $pps.`jm_job_bundles` WHERE plant_code='$plantcode' AND jm_product_logical_bundle_id='$jm_pplb_id'";
			$get_jjbid_qry_result=mysqli_query($link, $get_jjbid_qry) or die ("sql error getting details from jm_job_bundles".$sql.mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($get_jjbid_row=mysqli_fetch_array($get_jjbid_qry_result))
			{
				$jm_job_bundle_id=$get_jjbid_row['jm_job_bundle_id'];
				
				//getting barcode_id
				$get_barcode_qry="SELECT barcode_id,parent_ext_ref_id FROM $pts.`barcode` WHERE external_ref_id='$jm_job_bundle_id' AND plant_code='$plantcode' AND barcode_type='PSLB'";
				$get_barcode_qry_result=mysqli_query($link, $get_barcode_qry) or die ("sql error getting details from barcode".$sql.mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($get_barcode_row=mysqli_fetch_array($get_barcode_qry_result))
				{
					$barcode_id=$get_barcode_row['barcode_id'];
					$parent_ext_ref_id=$get_barcode_row['parent_ext_ref_id'];
					
					//getting task job id
					$get_taskjobid_qry="SELECT task_jobs_id FROM $tms.`task_jobs` WHERE task_job_reference='$parent_ext_ref_id' AND plant_code='$plant_code'";
					$get_taskjobid_qry_result=mysqli_query($link, $get_taskjobid_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($get_taskjobid_qry_result_row=mysqli_fetch_array($get_taskjobid_qry_result))
					{
						$task_jobs_id=$get_taskjobid_qry_result_row['task_jobs_id'];
					}
					//getting min operation
					$qrytoGetMinOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
					$minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting min operations data for job');
					if(mysqli_num_rows($minOperationResult)>0)
					{
						while($minOperationResultRow = mysqli_fetch_array($minOperationResult))
						{
							$minOperation=$minOperationResultRow['operation_code'];
						}
					}
					
					//getting max operation
					$qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
					$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting max operations data for job');
					if(mysqli_num_rows($maxOperationResult)>0)
					{
						while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult))
						{
							$maxOperation=$maxOperationResultRow['operation_code'];
						}
					}
					
					//getting sections
					$sql_sec_qry="SELECT section_id FROM $pms.`sections` WHERE plant_code='$plantcode' AND is_active=1";
					$sql_sec_qry_result=mysqli_query($link, $sql_sec_qry) or die ("sql error while getting sections".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
					$sectionid=array();   
					while($sql_row_sec=mysqli_fetch_array($sql_sec_qry_result))
					{
						$sectionid[]=$sql_row_sec["section_id"];		
					}
					echo "<tr>";
					echo "<td>".$buyer_desc."</td>";
					echo "<td>".$style."</td>";
					echo "<td>".$schedule."</td>";
					echo "<td>".$color."</td>";
					echo "<td>".$mo_quantity."</td>";
					echo "<td>".$outputqty."</td>";
					echo "<td>".round($outputqty*100/$mo_quantity,2)."</td>";
					echo "<td>Sewing</td>";
					echo "<td>".$planned_delivery_date."</td>";
					
					for($j=0;$j<sizeof($sectionid);$j++)
					{
						//getting workstations against to the section
						$get_ws_qry="SELECT workstation_id FROM $pms.`workstation` WHERE plant_code='$plantcode' AND is_active=1 AND section_id='".$sectionid[$j]."'";
						$get_ws_qry_result=mysqli_query($link, $get_ws_qry) or die ("sql error while getting workstations".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
						$workstationid=array();   
						while($sql_row_ws=mysqli_fetch_array($get_ws_qry_result))
						{
							$workstationid[]=$sql_row_ws['workstation_id'];
						}
						$workstatid="'".implode("','",$workstationid)."'";
						
						//getting details from transaction_log for input
						$get_inpdet_qry="SELECT SUM(quantity) AS input FROM $pts.`transaction_log` WHERE barcode_id='$barcode_id' AND plant_code='$plantcode' AND resource_id IN ($workstatid) AND operation='$minOperation'";
						$get_inpdet_qry_result=mysqli_query($link, $get_inpdet_qry) or exit("Sql Error getting input".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($get_inpdet_qry_result_row=mysqli_fetch_array($get_inpdet_qry_result))
						{
							$inputqty=$get_inpdet_qry_result_row['input'];
						}
						
						//getting details from transaction_log for output
						$get_outdet_qry="SELECT SUM(quantity) AS output FROM $pts.`transaction_log` WHERE barcode_id='$barcode_id' AND plant_code='$plantcode' AND resource_id IN ($workstatid) AND operation='$maxOperation'";
						$get_outdet_qry_result=mysqli_query($link, $get_outdet_qry) or exit("Sql Error getting output".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($get_outdet_qry_result_row=mysqli_fetch_array($get_outdet_qry_result))
						{
							$outputqty=$get_outdet_qry_result_row['output'];
						}
						echo "<td>".$inputqty."</td>";
						echo "<td>".$outputqty."</td>";
						unset($workstationid);
					}
					unset($sectionid);
					echo "</tr>";
				}
			}
		}
	}
	echo "</table>";
	echo "</div>";
	
?>
<script language="javascript" type="text/javascript">

$('#reset_table1').addClass('btn btn-warning');
    var table6_Props =  {
                            rows_counter: true,
                            btn_reset: true,
                            // btn_reset_text: "Clear",
                            loader: true,
                            loader_text: "Filtering data..."
                        };
    setFilterGrid( "table1",table6_Props );
    $(document).ready(function(){
        $('#reset_table1').addClass('btn btn-warning btn-xs');
    });


</script> 
<style>
table{
    white-space:nowrap; 
    border-collapse:collapse;
    font-size:15px;
}
#reset_table1{
    width : 50px;
    color : #ec971f;
    margin-top : 10px;
    margin-left : 0px;
    margin-bottom:15pt;
}
</style>
</div>
</div>
</div>
</body>
</html>
