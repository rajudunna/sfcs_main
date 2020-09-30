<script>
	function printPage(printContent) { 
		var display_setting="toolbar=yes,menubar=yes,scrollbars=yes,width=1050, height=600"; 
		var printpage=window.open("","",display_setting); 
		printpage.document.open(); 
		printpage.document.write('<html><head><title>Print Page</title></head>'); 
		printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>'); 
		printpage.document.close(); 
		printpage.focus(); 
	}
</script>
<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
<title>Job Wise</title>
<body>
<?php 
    include("../../../../common/config/config.php");
	include("../../../../common/config/functions.php");
	include("../../../../common/config/functions_v2.php");
	include("../../../../common/config/enums.php");
	$schedule=$_GET["schedule"];
	$jm_jg_header_id=$_GET['jm_jg_header_id'];
	$plant_code=$_GET['plant_code'];
    if (isset($_GET['seq_no']))
    {
    	$seq_no = $_GET['seq_no'];
    }
    // $schedule_split=explode(",",$schedule); 
    //echo $schedule;
    error_reporting(0);
	if($schedule==''){
		echo "<script>alert('There are no schedules');
				window.close();
			</script>";
	} else {
		?>
		<br><center><a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)" class="btn btn-warning">Print</a></center><br>
		<div id="printsection">
			<style>
		        table, th, td
		        {
		            border: 1px solid black;
		            border-collapse: collapse;
		            background-color: transparent;
		        }
		        body
		        {
		            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		        }
			</style>
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Ratio Sheet (Sewing Job wise)</b></div>
				<div class="panel-body">	
					<div id="upperbody">				

						<div style="float:right"><img src="<?= $logo ?>" width="200" height="60"></div>

						<?php
						    //get po and master po
							$qry_get_podetails="SELECT master_po_number,po_number FROM $pps.jm_job_header LEFT JOIN $pps.jm_jg_header on jm_jg_header.jm_job_header=jm_job_header.jm_job_header_id WHERE jm_jg_header_id='".$jm_jg_header_id."' and jm_jg_header.plant_code='$plant_code'";
							//echo $qry_get_podetails;
							$get_podetails_result=mysqli_query($link_new, $qry_get_podetails) or exit("Sql Error at qry_get_podetails".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($po_details_row=mysqli_fetch_array($get_podetails_result))
							{
							  $masterponumber=$po_details_row['master_po_number'];
							  $po_number=$po_details_row['po_number'];
							}

                            /**
							 * Function to get style,color,schedule wrt ponumber
							 * @param:ponumber,plancode
							 * @return:style,color,schedule
							*/
							$result_data=getStyleColorSchedule($po_number,$plant_code);
							$main_style=$result_data['style_bulk'];
							$main_schedule=$result_data['schedule_bulk'];
							$main_color=$result_data['color_bulk'];
						
							// $sql2="select distinct packing_mode as mode from $bai_pro3.packing_summary_input where order_del_no in (".$schedule.") and pac_seq_no=$seq_no";

							// $result2=mysqli_query($link, $sql2) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
							// while($row2=mysqli_fetch_array($result2))
							// {
							// 	$packing_mode=$row2["mode"];
							// }
							$disStyle = implode(',',$main_style);
                            $joinSch = implode(',',$main_schedule);
							$disColor = implode(',',$main_color);
						?>

						<div style="float:left">
							<table class='table table-bordered' style="font-size:11px;font-family:verdana;text-align:left;">
							<tr><th>Style </th><td>:</td> <td><?php echo $disStyle;?></td></tr>
							<tr><th>Schedule </th> <td>:</td> <td><?php echo $joinSch;?></td></tr>
							<tr><th>Color </th> <td>:</td> <td><?php echo $disColor;?></td></tr>
							<!-- <tr><th>Sewing Job Model </th> <td>:</td> <td><b><?php echo $operation[$packing_mode];?></b></td></tr> -->
							</table>
						</div>
					</div><br><br><br><br><br><br><br><br>
					<?php 
					//Getting sample details here  By SK-07-07-2018 == Start
					// $sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id in (select id from brandix_bts.tbl_orders_master where product_schedule='$schedule')";
					// // echo $sewing_jobratio_sizes_query.'<br>';
					// $sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
					// while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
					// {
					// 	$ref_size = $sewing_jobratio_color_details['size'];
					// 	$size_main = explode(",",$ref_size);
					// 	// var_dump($size);
					// }
					// $sizeofsizes=sizeof($size_main);
					// $sample_qty = array();
					// echo "<br>
					// <span><strong><u>Sample Quantites size wise:</u><strong></span><div class='row'>
					// <div class='col-md-12 table-responsive'>
					// 	<table class=\"table table-bordered\">
					// 		<tr class=\"info\">
					// 			<th>Colors</th>";
					// 			for ($i=0; $i < sizeof($size_main); $i++)
					// 			{
					// 				echo "<th>$size_main[$i]</th>";
					// 			}	
					// 			echo "<th>Total</th>
					// 		</tr>";
					// 		for ($j=0; $j < sizeof($new_col); $j++)
					// 		{
					// 			$tot_sample = 0;
					// 			echo "<tr>
					// 				<td>$new_col[$j]</td>";
					// 			for($kk=0;$kk<sizeof($size_main);$kk++)
					// 			{
					// 				$getpackqty="SELECT input_qty FROM bai_pro3.sp_sample_order_db 
					// 				WHERE order_tid = '".$new_order_tid[$j]."' AND size='$size_main[$kk]'";
					// 				$packqtyrslt=mysqli_query($link, $getpackqty) or exit("Error while getting parent id");
					// 				if(mysqli_num_rows($packqtyrslt) > 0)
					// 				{
					// 					$pack_row=mysqli_fetch_array($packqtyrslt);
					// 					echo "<td>".$pack_row['input_qty']."</td>";
					// 					$tot_sample = $tot_sample + $pack_row['input_qty'];
					// 				}
					// 				else
					// 				{
					// 					echo "<td>0</td>";
					// 					$tot_sample = $tot_sample + 0;
					// 				}
					// 			}
					// 			echo "<td>$tot_sample</td>
					// 			</tr>";
					// 		}
					// 	echo "</table>
					// </div>";

					?>

					<br>
					<?php
						$style=implode("','" , $main_style);
						$schedule=implode(',',$main_schedule);
						$color=implode("','" , $main_color);
						$size_total_qty=[];
						$sql="SELECT GROUP_CONCAT(DISTINCT jm_job_bundles.size) as size FROM $pps.`jm_job_bundles` LEFT JOIN $pps.`jm_product_logical_bundle` ON jm_job_bundles.`jm_product_logical_bundle_id`=jm_product_logical_bundle.jm_product_logical_bundle_id WHERE feature_value in($schedule) AND jm_job_bundles.fg_color in ('".implode("','" , $main_color)."') AND jm_job_bundles.plant_code='$plant_code'";
						$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($sql_result))
						{
							$size_code=$row['size'];
							$size_main = explode(",",$size_code);
						}
						
						echo "<div class='row'>";
						echo "<div class='col-md-12'>";
						echo "<div class='table-responsive'>";
						echo "<table class=\"gridtable\">"; 
						echo "<table class=\"table table-bordered\">";
						echo "<tr><thead>";
						echo "<th>Style</th>";
						echo "<th>PO#</th>";
						echo "<th>VPO#</th>";
						echo "<th>Schedule</th>";
						echo "<th>Destination</th>";
						echo "<th>Color</th>";
						echo "<th>Cut Job#</th>";
						echo "<th>Delivery Date</th>";
						echo "<th>Sewing Job#</th>";
						
						for($i=0;$i<sizeof($size_main);$i++)
						{
							echo "<th align=\"center\">".$size_main[$i]."</th>";
						}
						echo "<th>Total</th>";
						echo "</thead></tr>";
						$tasktype=TaskTypeEnum::PLANNEDSEWINGJOB;
						//get jobs from po_number
						$job_number=array();
						$get_jobs="SELECT job_number,jm_jg_header_id FROM $pps.`jm_job_header` LEFT JOIN $pps.`jm_jg_header` ON jm_jg_header.jm_job_header = jm_job_header.jm_job_header_id WHERE po_number='$po_number' AND jm_jg_header.plant_code='$plant_code' AND job_group_type='$tasktype'";
						$result22=mysqli_query($link, $get_jobs) or die("Error8-".$get_jobs."-".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($result22))
						{
						   $job_number[$sql_row['job_number']]=$sql_row['jm_jg_header_id'];
						}   
						//to get destination
						$get_destination="SELECT destination,vpo,planned_delivery_date FROM $oms.oms_mo_details WHERE schedule in ($schedule) AND plant_code='$plant_code'";
						$sql_result1=mysqli_query($link, $get_destination) or die("Error".$get_destination.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row1=mysqli_fetch_array($sql_result1))
						{
							$destination=$row1['destination'];
							$vpo=$row1['vpo'];
							$planned_delivery_date=$row1['planned_delivery_date'];
						}
						//To get PO Description
						$result_po_des=getPoDetaials($po_number,$plant_code);
						$po_des=$result_po_des['po_description'];
						
						foreach($job_number as $sew_num=>$value)
		                {
							//get_task_job_id
							$get_task_job_id="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$value' and plant_code='$plant_code'";
							$sql_result21=mysqli_query($link, $get_task_job_id) or die("Error".$get_task_job_id.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row21=mysqli_fetch_array($sql_result21))
							{
                                $task_job_id=$row21['task_jobs_id'];
							}

							//get cutjob
							$job_detail_attributes = [];
							$qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id ='$task_job_id' and plant_code='$plant_code'";
							$qry_toget_style_sch_result = mysqli_query($link, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($row22 = mysqli_fetch_array($qry_toget_style_sch_result)) {
								$job_detail_attributes[$row22['attribute_name']] = $row22['attribute_value'];
							}
							$cut_no = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
							echo "<tr height=20 style='height:15.0pt; background-color:$bg_color1;'>";
							echo "<td height=20 style='height:15.0pt'>".$style."</td>";
							echo "<td height=20 style='height:15.0pt'>$po_des</td>";
							echo "<td height=20 style='height:15.0pt'>$vpo</td>";
							echo "<td height=20 style='height:15.0pt'>".$schedule."</td>";
							echo "<td height=20 style='height:15.0pt'>$destination</td>";
							echo "<td height=20 style='height:15.0pt'>".$color."</td>";
							echo "<td height=20 style='height:15.0pt'>".$cut_no."</td>";
							echo "<td height=20 style='height:15.0pt'>".$planned_delivery_date."</td>";
							echo "<td height=20 style='height:15.0pt'>".$sew_num."</td>";
							for($i=0;$i<sizeof($size_main);$i++)
							{
							  $get_quantity="SELECT ROUND(SUM(quantity),0) AS quantity FROM $pps.`jm_job_bundles` LEFT JOIN $pps.`jm_jg_header` ON jm_jg_header.jm_jg_header_id = jm_job_bundles.`jm_jg_header_id` WHERE size='".$size_main[$i]."' AND job_number='$sew_num' AND fg_color IN ('".implode("','" , $main_color)."') AND jm_jg_header.plant_code='$plant_code' AND job_group_type='$tasktype'";
							  $sql_result2=mysqli_query($link, $get_quantity) or die("Error".$get_quantity.mysqli_error($GLOBALS["___mysqli_ston"]));
							  while($row2=mysqli_fetch_array($sql_result2))
							  {
								$size_quantity=$row2["quantity"];
							  }
							  if($size_quantity > 0){
								echo "<td class=xl787179 align=\"center\">".$size_quantity."</td>";
								$total_qty1=$total_qty1+$size_quantity;
								$size_total_qty[$size_main[$i]] +=$size_quantity;
								$size_total_qty['total'] +=$size_quantity;
							  }else
							  {
								echo "<td class=xl787179 align=\"center\">0</td>";
								$total_qty1=$total_qty1+0;
							  }
							  
							}
							echo "<td align=\"center\">".$total_qty1."</td>";
							$total_qty1=0;
							echo "</tr>";	
						}	
						
						$o_total=0;
						$o_s=0;
						echo "<tr>";
						echo "<th colspan=9  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;font-size:14px;\"> Total</th>";
						for ($i=0; $i < sizeof($size_main); $i++)
						{ 
							if ($size_total_qty[$size_main[$i]]!=0)
							{
								echo "<th align=\"center\" style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">".$size_total_qty[$size_main[$i]]."</th>";
							}
							else
							{
								echo "<th align=\"center\" style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">0</th>";
							}
						}
							
						echo "<th  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">".$size_total_qty['total']."</th>";
						echo "</tr>";

						echo "</table></div></div></div></div><br>";
					?>
				</div>
		    </div>
		</div>
		<?php
	}
?>