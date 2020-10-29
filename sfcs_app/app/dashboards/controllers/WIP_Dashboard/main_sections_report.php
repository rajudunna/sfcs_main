<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
// error_reporting(0);
$plantcode = $_session['plantCode'];
$plantcode ='AIP';
$username =  $_session['userName'];

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
	$datetime1 = date_create($date_1);
	$datetime2 = date_create($date_2);
	$interval = date_diff($datetime1, $datetime2);
	return $interval->format($differenceFormat);
}
?>

<html>

<head>
<title>Section Report</title>
<style>
	body{ font-family:calibri; }
</style>

<style>

a {text-decoration: none;}

.blue {
	background: #66DDAA;
}

.atip
{
	color:black;
}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid #337ab7;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid #337ab7;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
{
	border-bottom: 3px solid white;
	padding-bottom: 5px;
	padding-top: 5px;
}

.panel-heading
{
	text-align:center;
	border-bottom: 3px solid black;
}


select{
    margin-top: 16px;
	margin-right: 5px;
}

.panel-primary{
	margin-right: -50px;
}

</style>

<script type="text/javascript" src="../../../../common/js/jquery.js"></script> 
<script src="../../../../common/js/jquery.min.js"></script>


</head>

<body>

<?php
$operation=$_GET['operations'];
$department='SEWING';

$result_worksation_id=getWorkstations($department,$plantcode);
$modules=$result_worksation_id['workstation_codes'];

?>

<?php
		
            echo "<div class='panel-body'>";
				// $sql="SELECT GROUP_CONCAT(quote(`module_name`) ORDER BY module_name+0 ASC ) AS sec_mods, GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC ) AS sec_mod_val,section AS se_cid FROM $bai_pro3.`module_master` GROUP BY section ORDER BY section + 0";
				// //echo  $sql;
				// $sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row=mysqli_fetch_array($sql_result))
				// {
				// 	$sec_mods1[]=$sql_row['sec_mods'];
				// 	$sec_mods[]=$sql_row['sec_mod_val'];
				// }


				// $modules=array();
				//$modules=explode(",",$sec_mods);
				// $modules=implode(",",$sec_mods);
				
				// die();
				echo "<div class='table-responsive'>";
				echo "<input id='excel' type='button'  class='btn btn-success' value='Export To Excel' onclick='getCSVData()'>";
						echo "<table class=\"table table-bordered\" id=\"table1\"> 
							<tr>
								<th>Module</th>
								<th>Bundle No</th>
								<th>Style</th>
								<th>Schedule</th>
								<th>Color</th>
								<th>Input Job No</th>
								<th>Cut No</th>
								<th>Size</th>
								<th>Previous Operation Quantity</th>
								<th>Current Operation ($operation) Quantity</th>
								<th>Rejected Qty</th>
								<th>Balance</th>
								<th>Remarks</th>
								<th>Age</th>
								<th>WIP</th>
							</tr>";
		$toggle=0;
		$j=1;


		foreach($modules as $key => $module)
		{
			var_dump($module);

			$rowcount_check=0;
			$jobsArray = getJobsForWorkstationIdTypeSewing($plantcode,$key,'');
			// var_dump($module);
			foreach($jobsArray as $job){
				// var_dump($job);
				        /**getting style,colr attributes using taskjob id */
				$job_detail_attributes = [];
				$qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id='".$job['taskJobId']."' and plant_code='$plantcode' and is_active=1";
				// echo $qry_toget_style_sch."</br>";
				$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
					$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
				}
				
				
				$style = $job_detail_attributes[$sewing_job_attributes['style']];
				$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
				$color = $job_detail_attributes[$sewing_job_attributes['color']];
				$cutjobno = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
				$remarks = $job_detail_attributes[$sewing_job_attributes['remarks']];
				$conumber = $job_detail_attributes[$sewing_job_attributes['cono']];
				$docket_number = $job_detail_attributes[$sewing_job_attributes['docketno']];
				$job_num = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
				$masterponumber = $job_detail_attributes[$sewing_job_attributes['masterponumber']];
					   //To get finished_good_id
				if($masterponumber ==''){
				$get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND plant_code='$plantcode' limit 1";
				}else{
					$get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND master_po='$masterponumber' AND plant_code='$plantcode' limit 1";
				}
					// echo $get_details."<br/>";
				$sql_result11=mysqli_query($link_new, $get_details) or exit("Sql Error get_details123".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row_main=mysqli_fetch_array($sql_result11))
				{
					$fg_good_id= $row_main['finished_good_id'];   
				}


				   
				$previous_operation=[];
				$get_operations="SELECT previous_operation FROM $pts.fg_operation WHERE finished_good_id='$fg_good_id'  AND plant_code='$plantcode' and operation_code='$operation'";
				// echo $get_operations;
				$sql_result12=mysqli_query($link_new, $get_operations) or exit("Sql Error get_operations".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($sql_result12))
				{
					$previous_operation[]=$row1['previous_operation'];
				}
				if(sizeof($previous_operation) >0){
					$previous_op = "'" . implode( "','", $previous_operation) . "'";
				}
				// var_dump($previous_op);


					// die();
					
				$bundlesQry = "select GROUP_CONCAT(CONCAT('''', jm_pplb_id, '''' ))AS jmBundleIds,bundle_number,size,fg_color,quantity from $pps.jm_job_bundles where jm_jg_header_id ='".$job['taskJobRef']."'";
				$bundlesResult=mysqli_query($link_new, $bundlesQry) or exit("Bundles not found".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo $bundlesQry;
			
				if(isset($_POST['submit']))
				{
					$input_selection=$_POST['input_selection'];
					if($input_selection=='input_wise'){
						$bundlesQry.=" GROUP BY jm_jg_header_id,size";
					}
					if($input_selection=='bundle_wise'){
						$bundlesQry.=" GROUP BY jm_job_bundle_id,size";
					}
				}
				else
				{
					$bundlesQry.=" GROUP BY jm_job_bundle_id,size";
				}
				while($bundleRow=mysqli_fetch_array($bundlesResult))
				{
					// echo $bundleRow['bundle_number']."</br>";
					// echo $bundleRow['size']."</br>";
					// echo $bundleRow['fg_color']."</br>";
					// echo $bundleRow['quantity']."</br>";
					// Call pts barcode table
					$jmBundleIds=$bundleRow['jmBundleIds'];
					//var_dump($jmBundleIds);
					if($jmBundleIds!=''){
					
					/**getting barcode ids from barcode*/
						$barcodesQry = "select GROUP_CONCAT(CONCAT('''', barcode, '''' ))AS barcode from $pts.barcode where external_ref_id IN ($jmBundleIds) and barcode_type='PPLB' and plant_code='$plantcode' AND is_active=1";
						// echo "</br>bundle : ".$barcodesQry."</br>";
						if(isset($_POST['submit']))
						{
							// echo "test";
							$input_selection=$_POST['input_selection'];
							if($input_selection=='input_wise'){
								$barcodesQry.=" ";
							}
							if($input_selection=='bundle_wise'){
								$barcodesQry.=" GROUP BY barcode";
							}
						}
						else
						{
							// echo "test";

							$barcodesQry.=" GROUP BY barcode";
						}
						$barcodeResult=mysqli_query($link_new, $barcodesQry) or exit("Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
						$originalBarcode=array();
						$barcodeId=array();
						while($barcodeRow=mysqli_fetch_array($barcodeResult))
						{   
							$Original_barcode=$barcodeRow['barcode'];
							// var_dump($Original_barcode);
							//$barcodeId[] = $barcodeRow['barcode_id'];
							if($Original_barcode!=''){
								
								$transactionsQry = "select parent_barcode,parent_job,sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity,operation,DATE(created_at) as input_date,DATEDIFF(NOW(), created_at) AS days from $pts.transaction_log where parent_barcode IN ($Original_barcode) GROUP BY operation";
								//echo $transactionsQry;
								$transactionsResult=mysqli_query($link_new, $transactionsQry) or exit("Transactions not found".mysqli_error($GLOBALS["___mysqli_ston"]));
								$rejQtyOps=array();
								while($transactionRow=mysqli_fetch_array($transactionsResult)) {
									
									/** getting input and out put based on operations*/
									if($minOperation==$transactionRow['operation']){
										$inputQty=$transactionRow['good_quantity'];
										$age=$transactionRow['days'];
									}
									if($maxOperation==$transactionRow['operation']){
										$outputQty=$transactionRow['good_quantity'];
										/**rejected qty for output */
										$outputRejQty=$transactionRow['rejected_quantity'];
									}
									$rejQtyOps[$transactionRow['operation']] = $transactionRow['rejected_quantity'];   
									$parent_barcode = $transactionRow['parent_barcode'];   
									$sewingjobno = $transactionRow['parent_job'];   
								}
								

								
			
								if($rowcount_check==1)
								{	
									if($row_counter == 0)
									echo "<tr class=\"$tr_color\" class=\"new\">
									<td style='border-top:1.5pt solid #fff;'>$module</td>";
									else 
									echo "<tr class=\"$tr_color\"  class=\"new\"><td></td>";
									
									// if($new_module == $old_module)
									//     echo "<td></td>";
								
									if(isset($_POST['submit']))
									{
										$input_selection=$_POST['input_selection'];
										if($input_selection=='bundle_wise'){
											echo "<td>$$parent_barcode</td>";
										}
									}else{
										echo "<td>$$parent_barcode</td>";
									}
								
									echo "<td>$style</td>
									<td>$schedule</td>
									<td>$color</td>
									<td>".$sewingjobno."</td>
									<td>".$cutjobno."</td>
									<td>".$bundleRow['size']."</td>
									<td>$previous_ops_qty</td>
									<td>$current_ops_qty</td>";
									echo "<td>$rejected</td>";
									
									echo "<td>".($previous_ops_qty-($current_ops_qty+$rejected))."</td>
									<td>$remarks</td><td>$aging</td>";
									//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
								
									if($rowcount_check==1)
									{
										echo "<td style='border-top:1.5pt solid #fff;'>$balance</td>";
									}
									$rowcount_check=0;
									$row_counter++;
									echo "</tr>";
								}
								else
								{			
									if($row_counter == 0)
									echo "<tr class=\"$tr_color\"  class=\"new\"><td>$module</td>";
									else 
									echo "<tr class=\"$tr_color\"  class=\"new\"><td></td>";
									$row_counter++;
									
									if(isset($_POST['submit']))
									{
										$input_selection=$_POST['input_selection'];
										if($input_selection=='bundle_wise'){
											echo "<td>$parent_barcode</td>";
											echo "<td>$style</td>";
										}
										if($input_selection=='input_wise'){
										echo "<td>$style</td>";
										}	
									}else{
										echo "<td>$parent_barcode</td>";
										echo "<td>$style</td>";
									}
									echo"<td>$schedule</td>
									<td>$color</td>
									<td>".$sewingjobno."</td>
									<td>".$cutjobno."</td>
									<td>".$bundleRow['size']."</td>
									<td>$previous_ops_qty</td>
									<td>$current_ops_qty</td>";
									echo "<td>$rejected</td>";	                          			
									echo "<td>".($previous_ops_qty-($current_ops_qty+$rejected))."</td>
									<td>$remarks</td>";
									echo "<td>$aging</td>";
									//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
									//if($row_counter > 0)
									echo "<td class=\"$tr_color\" ></td>";
									
									echo "</tr>";
								}
							
							$j++;				
						}
					}
				}
			}
		}
	}	
	echo "</table></div></div>";
	    // echo '<script type="text/javascript">getCSVData();</script>';
	    // echo"<script>alert(143);</script>";

	    
		
		?>
<script language="javascript">

function getCSVData() {
	$('.blue').css("background-color", "#fff");	
	$('tr').css("border", "0.5pt solid black");	
  $('table').attr('border', '1');
  $('table').removeClass('table-bordered');
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
    var table = document.getElementById('table1').innerHTML;
    // $('thead').css({"background-color": "blue"});
    var ctx = {worksheet: name || 'Sections Report', table : table}
    //window.location.href = uri + base64(format(template, ctx))
    var link = document.createElement("a");
    link.download = "Sections Report.xls";
    link.href = uri + base64(format(template, ctx));
    link.click();
    $('table').attr('border', '0');
    $('table').addClass('table-bordered');
    $('.blue').css("background-color", "#66DDAA");
    $('.blue').css("border", "0px solid black");
    // window.close ();	
}
</script>
</body>
</html>