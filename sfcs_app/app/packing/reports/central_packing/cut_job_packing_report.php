<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 
include(getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R')); 
// $plant_code = $_SESSION['plantCode'];
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
    $vpo=$_GET["vpo"]; 
    $style=$_GET["style"];

    if ($_POST['style'])
    {
    	$vpo=$_POST["vpo"]; 
    	$style=$_POST["style"]; 
    }	
?> 
<html> 
<head> 
<style type="text/css"> 
	table {
		border-collapse: collapse;
		border-spacing: 0;
		border: 1px solid #ddd;
		display: block;
        overflow-x: auto;        
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	.red_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#ff3333';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	} 
	.blue_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#15a5f2';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	} 
	.pink_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#ff4da6';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	} 
	.green_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#1aff1a';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	}

	.btn-red{ 
		color: #FF3333; 
		background-color: #FF3333; 
		border-color: #FF3333; 
	} 
	.btn-pink { 
		color: #FF4DA6; 
		background-color: #FF4DA6; 
		border-color: #FF4DA6; 
	}
	.btn-light_green { 
		color: #1AFF1A; 
		background-color: #1AFF1A; 
		border-color: #1AFF1A; 
	} 
</style> 

<script>
	var url1 = '<?= getFullURL($_GET['r'],'cut_job_packing_report.php','N'); ?>';

	function firstbox() 
	{ 
	    window.location.href =url1+"&vpo="+document.test.vpo.value; 
	}
</script> 
</head>
<body>
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">Central Packing Summary Report</div>
        <div class="panel-body">
			<div class='col-md-9'>
				<form name="test" action="<?php $_GET['r'] ?>" method="POST" class='form-inline'> 
					<?php 
						echo "VPO: <select name=\"vpo\" required onchange=\"firstbox();\" class='form-control'>"; 
						$sql="	SELECT vpo FROM $oms.oms_mo_details WHERE po_number<>'' and plant_code='$plant_code' GROUP BY vpo "; 
					   
						$sql_result=mysqli_query($link, $sql) or exit("Error while getting vpo"); 
						$sql_num_check=mysqli_num_rows($sql_result); 

						echo "<option value='' selected>--Select--</option>"; 
						while($sql_row=mysqli_fetch_array($sql_result)) 
						{
							if(str_replace(" ","",$sql_row['vpo'])==str_replace(" ","",$vpo)) 
							{ 
								echo "<option value=\"".$sql_row['vpo']."\" selected>".$sql_row['vpo']."</option>"; 
							} 
							else 
							{ 
								echo "<option value=\"".$sql_row['vpo']."\">".$sql_row['vpo']."</option>"; 
							}
						} 
						echo "</select>"; 
						
						$sql1="SELECT mo_number FROM $oms.oms_mo_details WHERE po_number<>'' and plant_code='$plant_code' and vpo='$vpo'";     
				
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($sql_row1=mysqli_fetch_array($sql_result1)) 
						{ 
                          $mo_number=$sql_row1['mo_number'];
						}
						echo "Style: <select name=\"style\" required onchange=\"secondbox();\" class='form-control'>"; 
						$sql="select style from $oms.oms_products_info where mo_number='".$mo_number."' GROUP BY style order by style";    
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
						echo "<option value='' selected>--Select--</option>"; 
						while($sql_row=mysqli_fetch_array($sql_result)) 
						{ 
							if(str_replace(" ","",$sql_row['style'])==str_replace(" ","",$style)) 
							{ 
								echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>"; 
							} 
							else 
							{ 
								echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>"; 
							} 
						}
						echo "</select>"; 
					?> 
					<input type="submit" class="btn btn-success" name="submit" id="submit" value="Show">
				</form>
			</div>
			<div class='col-md-3'>
				<label>Legend:</label>
				<table class="table table-bordered"> 
					<tr> 
						<td>Sewing Input not given </td> 
						<td><a class='btn btn-red'>
							<!-- <div class="red_box" style="margin-left:15px;"></div> -->
						</td> 
					</tr> 
					<tr> 
						<td>Sewing Input given to the module </td> 
						<td><a class='btn btn-info'>
							<!-- <div class="blue_box" style="margin-left:15px;"></div> -->
						</td> 
					</tr> 
					<tr> 
						<td>Sewing Output completed </td> 
						<td><a class='btn btn-pink'>
							<!-- <div class="pink_box" style="margin-left:15px;"></div> -->
						</td> 
					</tr> 
					<tr> 
						<td>Central Packing In Area </td> 
						<td><div class='btn btn-light_green'></div>
							<!-- <div class="green_box" style="margin-left:15px;width:20px;padding-top:0px;"></div> -->
						</td> 
					</tr> 
				</table>
			</div>
			<?php 
			if(isset($_POST['submit'])) 
			{
			    $vpo=$_POST['vpo'];
				$style=$_POST['style'];
				$getschedule="select po_number,schedule from $oms.oms_mo_details where vpo='".$vpo."' and plant_code='$plant_code' group by schedule";
				$sql_result=mysqli_query($link, $getschedule) or exit("Error while getting schedules for the vpo1"); 
				while($sql_row=mysqli_fetch_array($sql_result)) 
			    { 
					$po_number[]=$sql_row['po_number']; 
								       
				}
				$po_num="'".implode("','",$po_number)."'";
				if($style!=''&& $plant_code!=''){
					$result_bulk_schedules=getBulkSchedules($style,$plant_code);
					$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
				}  
				

				echo "<h3><span class=\"label label-info\"><b>Style: ".$style." &nbsp&nbsp&nbsp&nbsp</b></span></h3>
				</br> <p style='font-size:20px;'><span class=\"label label-info\"><b>Schedules: ".implode(",",array_unique($bulk_schedule))."</b></span><br/></p>"; 
			    // Cut Level
				$cutnos=0; $size_array=array();
				$sub_po_query="select po_number FROM $pps.mp_sub_order WHERE master_po_number IN($po_num) and plant_code='$plant_code'"; 
				$sub_po_query_result=mysqli_query($link, $sub_po_query) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($sub_po_query_result_result_row=mysqli_fetch_array($sub_po_query_result)) 
			    { 
			        $sub_po_number[]=$sub_po_query_result_result_row['po_number']; 
				}
				$sub_po="'".implode("','",$sub_po_number)."'";
				$logical_bundle_query="select jm_cut_job_id,cut_number FROM $pps.jm_cut_job WHERE plant_code='$plant_code' AND po_number IN($sub_po)"; 
				
				$logical_bundle_query_result=mysqli_query($link, $logical_bundle_query) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($logical_bundle_query_result_row=mysqli_fetch_array($logical_bundle_query_result)) 
			    { 
					$jm_cut_job_id=$logical_bundle_query_result_row['jm_cut_job_id']; 
					$cut_number=$logical_bundle_query_result_row['cut_number']; 

					$query5="select jm_cut_bundle_id FROM $pps.jm_cut_bundle WHERE plant_code='$plant_code' AND jm_cut_job_id='$jm_cut_job_id'";
				
					$query4_result1=mysqli_query($link, $query5) or exit("Sql Error54".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query4_result_row1=mysqli_fetch_array($query4_result1)) 
					{ 
						$jm_cut_bundle_id[]=$query4_result_row1['jm_cut_bundle_id']; 
						
					}
					$jm_cut_bundle_id1="'".implode("','",$jm_cut_bundle_id)."'";
					$query6="select jm_ppb_id FROM $pps.jm_cut_bundle_details WHERE plant_code='$plant_code' AND jm_cut_bundle_id in($jm_cut_bundle_id1)";

					$query4_result11=mysqli_query($link, $query6) or exit("Sql Error51".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query4_result_row11=mysqli_fetch_array($query4_result11)) 
					{ 
						$jm_ppb_id[]=$query4_result_row11['jm_ppb_id']; 
						
					}

					$jm_ppb_id1="'".implode("','",$jm_ppb_id)."'";
					
					$query7="select jm_pplb_id,feature_value,fg_color,size,sum(quantity) as quantity FROM $pps.jm_product_logical_bundle WHERE jm_ppb_id in ($jm_ppb_id1)  and plant_code='$plant_code' group by feature_value,fg_color,size";
					
					$query4_result111=mysqli_query($link, $query7) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query4_result_row111=mysqli_fetch_array($query4_result111)) 
					{ 
						$jm_pplb_id[]=$query4_result_row111['jm_pplb_id']; 
						$schedule=$query4_result_row111['feature_value']; 
						$color=$query4_result_row111['fg_color']; 
						$size_array=$query4_result_row111['size']; 
						$original_quantity=$query4_result_row111['quantity']; 
						
					}
					$jm_pplb_id1="'".implode("','",$jm_pplb_id)."'";
					$query1="select jm_jg_header_id FROM $pps.jm_job_bundles WHERE jm_pplb_id in($jm_pplb_id1) and plant_code='$plant_code'";

					$query1_result=mysqli_query($link, $query1) or exit("Sql Error53".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query1_result_row=mysqli_fetch_array($query1_result)) 
					{ 
						$jm_jg_header_id1[]=$query1_result_row['jm_jg_header_id']; 
						

					}
					$jm_jg_header_id2="'".implode("','",$jm_jg_header_id1)."'";
					$query2="select job_number,jm_jg_header_id FROM $pps.jm_jg_header WHERE jm_jg_header_id in ($jm_jg_header_id2) and plant_code='$plant_code'"; 
					$query2_result=mysqli_query($link, $query2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query2_result_row=mysqli_fetch_array($query2_result)) 
					{ 
						$sewing_job_number=$query2_result_row['job_number']; 
					}
					$query3="select packing_method FROM $oms.oms_mo_details WHERE schedule ='$schedule' and plant_code='$plant_code'"; 
					$query1_result3=mysqli_query($link, $query3) or exit("Sql Error55".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query1_result_row3=mysqli_fetch_array($query1_result3)) 
					{ 
						$packing_method=$query1_result_row3['packing_method']; 
					}

				
				
						
						// if(sizeof($sew_job_rand)>0)
						// {
							echo "<div style='overflow-x:auto;'>";
							echo "<table border='1px'>"; 
							echo "<tr style='background-color:#1184AD;color:white;'>"; 
							echo "<th width=\"5%\" >Style</th>"; 
							echo "<th width=\"10%\">VPO#</th>"; 
							echo "<th width=\"5%\">Schedule</th>"; 
							echo "<th width=\"3%\">Color<br>Way</th>"; 
							echo "<th style='min-width: 300px'>Color Description</th>"; 
							echo "<th width=\"3%\">Cut Job#</th>"; 
						
							for ($i=0; $i < sizeof($size_array); $i++) 
							{  
								//echo $size_array[$i];
								echo "<th width=\"5%\" style='white-space: nowrap;'>".$size_array[$i]."</th>"; 
							}
							if($rows-sizeof($size_array)>0)
							{
								for ($i=0; $i < ($rows-sizeof($size_array)); $i++) 
								{  
									echo "<th width=\"5%\" style='white-space: nowrap;'>  </th>"; 
								}
							}	
							echo "</tr>"; 
							echo "</div>";
							echo "<tr height=20 style='height:15.0pt;'>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$style."</td>"; 
				            echo "<td height=20 style='height:15.0pt'>".$vpo."</td>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$schedule."</td>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$packing_method."</td>"; 
				            echo "<td style='min-width: 300px'>".str_replace(",","</br>",$color)."</td>"; 
				            echo "<td height=20 style='height:15.0pt'>".$cut_number."</td>";
						
							$sql13="SELECT  task_jobs_id from $tms.task_jobs where task_job_reference in($jm_jg_header_id2) and plant_code='$plant_code'"; 
							// echo $sql13."<br>";
							$result13=mysqli_query($link, $sql13) or die("Error-".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row13=mysqli_fetch_array($result13)) 
							{

							  $task_jobs_id=$sql_row13['task_jobs_id'];
							//   $sql14="SELECT SUM(IF(operation_code = 100, good_quantity+rejected_quantity, 0)) AS qty,SUM(IF(operation_code = 130, good_quantity+rejected_quantity, 0)) AS sew_qty,original_quantity,sum(good_quantity+rejected_quantity) as total_qty from $tms.task_job_status where task_jobs_id = '$task_jobs_id' and plant_code='$plant_code' "; 

							$qrytoGetMinOperation="SELECT sum(good_quantity) AS good_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('$task_jobs_id') AND plant_code='$plant_code' AND is_active=1 GROUP BY operation_seq ORDER BY operation_seq ASC LIMIT 0,1";
						
							$minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting min operations data for job');
							
								while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
									$minGoodQty=$minOperationResultRow['good_quantity'];
								}
							

					/**
					 * get MAX operation wrt jobs based on operation seq
					 */
					$qrytoGetMaxOperation="SELECT sum(good_quantity) AS good_quantity,
					sum(rejected_quantity) AS rejected_quantity,original_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('$task_jobs_id') AND plant_code='$plant_code' AND is_active=1 GROUP BY operation_seq ORDER BY operation_seq DESC LIMIT 0,1";
							$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting max operations data for job');
							
								while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
									$maxGoodQty=$maxOperationResultRow['good_quantity'];
									$maxRejQty=$maxOperationResultRow['rejected_quantity'];
									//$original_quantity=$maxOperationResultRow['original_quantity'];
								}
					
					
					$balance=$minGoodQty-($maxGoodQty+$maxRejQty);
							
							  $result14=mysqli_query($link, $sql14) or die("Error-".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row14=mysqli_fetch_array($result14)) 
								{
									$sewing_qty=$sql_row14['qty'];
									$sewing_out_qty=$sql_row14['sew_qty'];
									//$original_quantity=$sql_row14['original_quantity'];
									$total_qty=$sql_row14['total_qty'];


								}
							}
							
							for ($j=0; $j < sizeof($size_array); $j++) 
							{  
								//$pack_qty=$sew_job_pac[$sew_job_rand[$j]];
								$in_qty=$minGoodQty;
								$out_qty=$maxGoodQty+$maxRejQty;
								
								//echo $sew_job_no[$j]."--".$job_qty[$sew_job_rand[$j]]."--".$in_qty."--".$out_qty."--".$pack_qty."<br>";
								if($pack_qty=="")
								{
									$pack_qty=0;
								}
								
								if($in_qty=="")
								{
									$in_qty=0;
								}
								
								if($out_qty=="")
								{
									$out_qty=0;
								}
								//echo $pack_qty."--".$in_qty."---".$out_qty."<br>";
								$bac_col="#ff3333";
								
								// if($pack_qty>0 && ($pack_qty==$job_qty[$sew_job_rand[$j]]))
								// {
								// 	$bac_col='#1aff1a';
								// }
								
								if($out_qty>0 && ($out_qty==$original_quantity))
								{
									$bac_col='#ff4da6';
								}
								elseif($in_qty>0)
								{
									$bac_col='#15a5f2';
								}
								else
								{
									$bac_col='#ff3333';
								}
								echo "<td width=\"7%\" height=20 style='height:15.0pt;background-color:$bac_col;color:white;white-space: nowrap;'>Job# ".$sewing_job_number." </br> Qty# ".$original_quantity." </br> Cut# ".$cut_number." </br> Col# ".$packing_method."</td>";
							}
							if($rows-sizeof($size_array)>0)
							{
								for ($i=0; $i < ($rows-sizeof($size_array)); $i++) 
								{  
									echo "<td width=\"7%\" height=20 style='height:15.0pt;background-color:white;color:white;white-space: nowrap;'> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</br>  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</br>   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</br>  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>";	
								}
							}
							echo "</tr>";
							echo "</table>";
							echo "</div>";
							echo "<br>";
							echo "<br>";
						//}
						unset($sew_job_pac);
						unset($sew_job_out);
						unset($sew_job_in);
						unset($size_array);
						unset($sew_job_rand);
						unset($sew_job_no);
						unset($job_qty);
							
					// }
				}
			}	
			?>
		</div>
	</div>
</div>
</body> 
</html> 