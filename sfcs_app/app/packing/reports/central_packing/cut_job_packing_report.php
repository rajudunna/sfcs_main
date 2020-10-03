<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
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
						$sql="select vpo from $oms.oms_mo_details where plant_code='$plant_code' and vpo!='' group by vpo order by vpo";     
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
						
						$sql1="select mo_number from $oms.oms_mo_details where vpo='".$vpo."' and plant_code='$plant_code'";     
				
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
			
				// $getschedule="select order_del_no,packing_method,group_concat(trim(order_col_des)) as cols,group_concat(order_col_des) as cols_new from $bai_pro3.bai_orders_db_confirm where vpo='".$vpo."' and order_style_no='".$style."' group by order_del_no,packing_method"; 
				$sql_result=mysqli_query($link, $getschedule) or exit("Error while getting schedules for the vpo1"); 
				while($sql_row=mysqli_fetch_array($sql_result)) 
			    { 
			        $po_number[]=$sql_row['po_number']; 
			         $schedule1[]=$sql_row['schedule']; 
			       
				}
				$po_num="'".implode("','",$po_number)."'";
				
			    //echo "<h3><span class=\"label label-info\"><b>Style: ".$style." &nbsp&nbsp&nbsp&nbsp Schedules: ".substr(implode(",",$schedule),0,-1)."</b></span></h3><br/>"; 
			    echo "<h3><span class=\"label label-info\"><b>Style: ".$style." &nbsp&nbsp&nbsp&nbsp Schedules: ".implode(",",array_unique($schedule1))."</b></span></h3><br/>"; 
			    // Cut Level
				$cutnos=0; $size_array=array();
				$sub_po_query="select po_number FROM $pps.mp_sub_order WHERE master_po_number IN($po_num) and plant_code='$plant_code'"; 
				$sub_po_query_result=mysqli_query($link, $sub_po_query) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($sub_po_query_result_result_row=mysqli_fetch_array($sub_po_query_result)) 
			    { 
			        $sub_po_number[]=$sub_po_query_result_result_row['po_number']; 
				}
				$sub_po="'".implode("','",$sub_po_number)."'";
				$logical_bundle_query="select fg_color,feature_value,jm_cut_bundle_detail_id,jm_product_logical_bundle_id,jm_cut_job_id FROM $pps.jm_product_logical_bundle WHERE po_number IN($sub_po) and plant_code='$plant_code' group by jm_cut_job_id"; 
				$logical_bundle_query_result=mysqli_query($link, $logical_bundle_query) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($logical_bundle_query_result_row=mysqli_fetch_array($logical_bundle_query_result)) 
			    { 
					$color=$logical_bundle_query_result_row['fg_color']; 
					$schedule=$logical_bundle_query_result_row['feature_value']; 
					$jm_cut_bundle_detail_id=$logical_bundle_query_result_row['jm_cut_bundle_detail_id'];
					$jm_cut_bundle_detail_id1[]=$logical_bundle_query_result_row['jm_cut_bundle_detail_id'];
					// $jm_product_logical_bundle_id=$logical_bundle_query_result_row['jm_product_logical_bundle_id'];
					$jm_cut_job_id=$logical_bundle_query_result_row['jm_cut_job_id'];

					$query4="select size,jm_product_logical_bundle_id FROM $pps.jm_product_logical_bundle WHERE fg_color='$color' and feature_value='$schedule' and jm_cut_job_id='$jm_cut_job_id' and plant_code='$plant_code'";
					$query4_result=mysqli_query($link, $query4) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query4_result_row=mysqli_fetch_array($query4_result)) 
					{ 
						$size_array[]=$query4_result_row['size']; 
						$jm_product_logical_bundle_id1[]=$query4_result_row['jm_product_logical_bundle_id']; 
					}
					$jm_product_logical_bundle_id="'".implode("','",$jm_product_logical_bundle_id1)."'";
					//$size_array[]=$logical_bundle_query_result_row['size'];

					$query1="select jm_jg_header_id FROM $pps.jm_job_bundles WHERE jm_product_logical_bundle_id in($jm_product_logical_bundle_id) and plant_code='$plant_code'";
					$query1_result=mysqli_query($link, $query1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query1_result_row=mysqli_fetch_array($query1_result)) 
					{ 
						$jm_jg_header_id1=$query1_result_row['jm_jg_header_id']; 
					
						$query2="select job_number,jm_jg_header_id FROM $pps.jm_jg_header WHERE jm_jg_header_id ='$jm_jg_header_id1' and plant_code='$plant_code'"; 
					$query2_result=mysqli_query($link, $query2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query2_result_row=mysqli_fetch_array($query2_result)) 
					{ 
						$sewing_job_number1=$query2_result_row['job_number']; 
						$sewing_job_number=$query2_result_row['job_number']; 

						$jm_jg_header_id1=$query2_result_row['jm_jg_header_id'];
						$jm_jg_header_id12[]=$query2_result_row['jm_jg_header_id'];
					}
					}
					
					$jm_jg_header_id123="'".implode("','",$jm_jg_header_id12)."'";
					$query3="select packing_method FROM $oms.oms_mo_details WHERE schedule ='$schedule' and plant_code='$plant_code'"; 
					$query1_result3=mysqli_query($link, $query3) or exit("Sql Error55".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($query1_result_row3=mysqli_fetch_array($query1_result3)) 
					{ 
						$packing_method=$query1_result_row3['packing_method']; 
					}
					
					
					$cut_job_query="select cut_number FROM $pps.jm_cut_job WHERE jm_cut_job_id ='$jm_cut_job_id' and plant_code='$plant_code'"; 
					$cut_job_query_result=mysqli_query($link, $cut_job_query) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($cut_job_query_result_row=mysqli_fetch_array($cut_job_query_result)) 
					{ 
						$cut_number=$cut_job_query_result_row['cut_number']; 
					}
			    



				// $cutno="select max(acutno) as cutno FROM bai_pro3.packing_summary_input WHERE order_del_no IN(".implode(",",$schedule).")"; 
			    // $cut_result=mysqli_query($link, $cutno) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    // while($cut_result_row=mysqli_fetch_array($cut_result)) 
			    // { 
			    //     $cutnos=$cut_result_row['cutno']; 
			    // }
				// $cutno1="SELECT COUNT(DISTINCT input_job_no) AS cnt FROM bai_pro3.packing_summary_input WHERE order_del_no IN(".implode(",",$schedule).") GROUP BY order_del_no,acutno ORDER BY cnt DESC LIMIT 1";				
			    // $cut_result1=mysqli_query($link, $cutno1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    // while($cut_result_row1=mysqli_fetch_array($cut_result1)) 
			    // { 
			    //     $rows=$cut_result_row1['cnt']; 
			    // } 	
			    // for ($ii=1; $ii <=$cutnos; $ii++) 
				// {				
					// for($iii=0;$iii<sizeof($schedule);$iii++)
					// {				
						//echo $cols_new[$iii]."<br>";
						//echo str_replae(",","','",$cols_new[$iii])."<br>";
						
						// $sizeqry="select input_job_no,input_job_no_random,m3_size_code,sum(carton_act_qty) as qty FROM bai_pro3.packing_summary_input WHERE order_del_no='".$schedule[$iii]."' and order_col_des in ('".str_replace(",","','",$cols_new[$iii])."') and acutno='$ii' group by input_job_no order by input_job_no*1";
						// //echo $sizeqry."<br>";
						// $sizerslt=mysqli_query($link, $sizeqry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						// while($sizerow=mysqli_fetch_array($sizerslt)) 
						// { 
						 	
						// 	$job_qty[$sizerow['input_job_no_random']]=$sizerow['qty'];
						// 	$sew_job_rand[]=$sizerow['input_job_no_random'];
						// 	$sew_job_no[]=$sizerow['input_job_no'];
						// }
						
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
							// echo "<div style=\"overflow:scroll; width:100%\">";
						
						// $jm_jg_header_id12="'".implode("','",$jm_jg_header_id1)."'";
						// $sewing_job_number1="'".implode("','",$sewing_job_number)."'";
					
							// $ops="select * from $brandix_bts.tbl_ims_ops where appilication in ('IPS','IMS','Carton_Ready')";
							// $ops_result=mysqli_query($link, $ops) or exit("Error while getting schedules for the vpo"); 
							// while($row_result=mysqli_fetch_array($ops_result)) 
							// { 
							// 	if($row_result['appilication']=='IPS')
							// 	{
							// 		if($row_result['operation_code'] == 'Auto'){
										
							// 			foreach(explode(",",$cols[$iii]) as $col_new){
							// 				$get_ips_op = get_ips_operation_code($link,$style,$col_new);
							// 				$ops_code[]=$get_ips_op['operation_code'];
							// 			}
							// 		} else {
							// 			$ops_code[] = $row_result['operation_code'];
							// 		}
							// 		// var_dump(array_unique($ops_code));
							// 		$query_val .= "sum(if(operation_id IN ('".implode(',',array_unique($ops_code))."'),recevied_qty,0)) AS in_qty,"; 
							// 	}
							// 	else if($row_result['appilication']=='IMS')
							// 	{
							// 		$query_val .= "sum(if(operation_id='".$row_result['operation_code']."',recevied_qty,0)) AS out_qty,";
							// 	}
							// 	else if($row_result['appilication']=='Carton_Ready')
							// 	{
							// 		$query_val .= "sum(if(operation_id='".$row_result['operation_code']."',recevied_qty,0)) AS pac_qty,";
							// 	}
							// }

							// var_dump($query_val);

							$sql13="SELECT  task_jobs_id from $tms.task_jobs where task_job_reference in($jm_jg_header_id123) and plant_code='$plant_code'"; 
							// echo $sql13."<br>";
							$result13=mysqli_query($link, $sql13) or die("Error-".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row13=mysqli_fetch_array($result13)) 
							{

							  $task_jobs_id=$sql_row13['task_jobs_id'];
							  $sql14="SELECT SUM(IF(operation_code = 100, good_quantity+rejected_quantity, 0)) AS qty,SUM(IF(operation_code = 130, good_quantity+rejected_quantity, 0)) AS sew_qty,original_quantity,sum(good_quantity+rejected_quantity) as total_qty from $tms.task_job_transaction where task_jobs_id = '$task_jobs_id' and plant_code='$plant_code' "; 
							
							  $result14=mysqli_query($link, $sql14) or die("Error-".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row14=mysqli_fetch_array($result14)) 
								{
									$sewing_qty=$sql_row14['qty'];
									$sewing_out_qty=$sql_row14['sew_qty'];
									$original_quantity=$sql_row14['original_quantity'];
									$total_qty=$sql_row14['total_qty'];


								}
							}





							// while($sql_row13=mysqli_fetch_array($result13)) 
							// {						
							// 	$sew_job_pac[$sql_row13['input_job_no_random_ref']]=$sql_row13['pac_qty'];
							// 	$sew_job_out[$sql_row13['input_job_no_random_ref']]=$sql_row13['out_qty'];
							// 	$sew_job_in[$sql_row13['input_job_no_random_ref']]=$sql_row13['in_qty'];
							// }
					
							for ($j=0; $j < sizeof($size_array); $j++) 
							{  
								//$pack_qty=$sew_job_pac[$sew_job_rand[$j]];
								$in_qty=$sewing_qty;
								$out_qty=$sewing_out_qty;
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
								echo "<td width=\"7%\" height=20 style='height:15.0pt;background-color:$bac_col;color:white;white-space: nowrap;'>Job# ".$sewing_job_number." </br> Qty# ".$total_qty." </br> Cut# ".$cut_number." </br> Col# ".$packing_method."</td>";
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
							
					}
				//}
			}	
			?>
		</div>
	</div>
</div>
</body> 
</html> 