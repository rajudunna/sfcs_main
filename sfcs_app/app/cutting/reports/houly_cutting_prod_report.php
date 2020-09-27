<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
?>
	
</head>
<body>
<div class="panel panel-primary">
	<div class="panel-heading">Hourly Cutting Production Report</div>
	<div class="panel-body">
		<form method="post" class="form-inline" name="input" action="index.php?r=<?php echo $_GET['r']; ?>">
			<div class="form-group">
				<label for="date">Enter Date:</label>
				<input type="text" data-toggle="datepicker" id="from_date" class="form-control" name="from_date" size=12 value="<?php  if(isset($_POST['from_date'])) { echo $_POST['from_date']; } else { echo date("Y-m-d"); } ?>"> 
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Show</button>
		</form>
	
<?php

if(isset($_POST['submit']))
{
	$from_date=$_POST['from_date'];
	
	/**getting plant timings wrt plant*/
	$qryPlantTimings="SELECT plant_start_time,plant_end_time FROM $pms.plant WHERE plant_code='$plant_code' AND is_active=1";
	$PlantTimingsResult=mysqli_query($link_new, $qryPlantTimings) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$hrsNum=mysqli_num_rows($PlantTimingsResult);
	if($hrsNum>0){
		while($PlantTimingsRow=mysqli_fetch_array($PlantTimingsResult))
		{
			$plant_start_time=$PlantTimingsRow['plant_start_time'];
			$plant_end_time=$PlantTimingsRow['plant_end_time'];
		}
	}

	$total_hours = $plant_end_time - $plant_start_time;
	list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
	$hour_start = $hour + 1;
	?>
	<hr>
	<div class="panel panel-info">
		<div class="panel-heading"><center><h4><strong>Hourly Cutting Production Report for <?php echo $from_date;?></strong></h4></center></div>
			<style type="text/css">
				table, tr, th, td {
					text-align:center;
					color:black;
					border: 1px solid black;
					border-collapse: collapse;
				}
			</style>
			
		<?php
		echo "<div class=\"table-responsive\"><table class='table'><tr class='danger'><th rowspan=2>Cutting<br>Table</th><th colspan=$total_hours>Time</th><th rowspan=2>Cut Qty</th><th rowspan=2>$fab_uom</th><th rowspan=2># of Docket</th></tr>";
	   	echo "<tr class='warning'>";
	   	for ($i=0; $i < $total_hours; $i++)
		{
			$hour1=$hour++ + 1;
			$to_hour = $hour1.":".$minutes;
			echo "<th>$to_hour</th>";
			$hour_end = $hour1;
		}
		echo "</tr>";
		$grand_tot_no_of_doc=$grand_tot_cut_qty=0;
		$qryWorkstations="SELECT w.workstation_id,w.workstation_description FROM $pms.workstation w 
		LEFT JOIN $pms.workstation_type wt ON w.workstation_type_id=wt.workstation_type_id
		LEFT JOIN $pms.departments d ON d.department_id=wt.department_id WHERE w.plant_code='$plant_code' AND w.is_active=1";
		$workstationsResult=mysqli_query($link_new, $qryWorkstations) or exit("Error in Getting work stations".mysqli_error($GLOBALS["___mysqli_ston"]));
		$workstationsNum=mysqli_num_rows($workstationsResult);
		if($workstationsNum>0){
			while($workstationsRow=mysqli_fetch_array($workstationsResult))
			{
				
				$workstation_id=$workstationsRow['workstation_id'];
				$workstation_description=$workstationsRow['workstation_description'];
				echo "<tr><td>".$workstation_description."</td>";
				for ($val=$hour_start; $val <= $hour_end; $val++)
				{
					$qryLayAttributes="SELECT GROUP_CONCAT(DISTINCT(CONCAT('''', lp.jm_docket_line_id, '''' ))) AS docketLines,SUM(IF(lpa.attribute_name = 'FABRICRECEIVED', lpa.attribute_value,0)) AS fab,
					SUM(IF(attribute_name = 'DAMAGES', attribute_value,0)) AS damages,
					SUM(IF(attribute_name = 'SHORTAGES', attribute_value,0)) AS shortages 
					FROM $pps.lp_lay lp 
					LEFT JOIN $pps.lp_lay_attribute lpa ON lp.lp_lay_id=lpa.lp_lay_id 
					WHERE lp.workstation_id='$workstation_id' AND lp.is_active=1 AND 
					DATE(lpa.created_at)='2020-09-07' AND TIME(lpa.created_at) BETWEEN TIME('".($val-1).":00:00') AND TIME('".$val.":00:00')";
					$LayAttributesResult=mysqli_query($link_new, $qryLayAttributes) or exit("Error getting attributes".mysqli_error($GLOBALS["___mysqli_ston"]));
					$attributessNum=mysqli_num_rows($LayAttributesResult);
					if($attributessNum>0){			
						while($attributessResult=mysqli_fetch_array($LayAttributesResult))
						{	
							$docketLines=$attributessResult['docketLines'];
							$fabRecvd=$attributessResult['fabRecvd'];
							$damages=$attributessResult['damages'];
							$shortages=$attributessResult['shortages'];

								$fabTotal=$fabRecvd-($damages+$shortages);

								if($docketLines){
									/**
									 * getting dockets count and plies sum and ratio is
									*/
									$qrydockeInfo = "SELECT count(doc_line.docket_line_number) as doc_count, sum(doc_line.plies) as tot_plies,GROUP_CONCAT(DISTINCT(CONCAT('''',ratio_cg.ratio_id, '''' ))) AS ratio_id
									FROM $pps.jm_docket_lines doc_line 
									LEFT JOIN $pps.jm_dockets doc ON doc.jm_docket_id = doc_line.jm_docket_id
									LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = doc.ratio_comp_group_id
									WHERE doc_line.plant_code = '$plant_code' AND doc_line.jm_docket_line_id IN ($docketLines) AND doc_line.is_active=1";
									$qrydockeInfoResult=mysqli_query($link_new, $qrydockeInfo) or exit("Error getting docket info".mysqli_error($GLOBALS["___mysqli_ston"]));
									$dockeInfoNum=mysqli_num_rows($qrydockeInfoResult);
									if($dockeInfoNum>0){			
										while($dockeInfoResult=mysqli_fetch_array($qrydockeInfoResult))
										{	
											$doc_count=$dockeInfoResult['doc_count'];
											$tot_plies=$dockeInfoResult['tot_plies'];
											$ratio_id=$dockeInfoResult['ratio_id'];
										}
											// get the docket qty
											$size_ratio_sum = 0;
											$size_ratios_query = "SELECT sum(size_ratio) AS size_ratio FROM $pps.lp_ratio_size WHERE ratio_id IN ($ratio_id)";
											$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
											while($row = mysqli_fetch_array($size_ratios_result))
											{
												$size_ratio_sum += $row['size_ratio'];
											}

											//cut qty 
											$cut_qty=($tot_plies*$size_ratio_sum);
									}
								}else{
									$cut_qty=0;
								}
								
							
								$total_qty = 0;					
								$row = $cut_qty;
								$total_qty = $total_qty + $row;
								$tot_cut_qty += $total_qty;
								echo "<td>$row</td>";
								
								$doc_count+=$doc_count;
								$tot_fab+=$fabTotal;
								if ($tot_fab == "")
								{
									$tot_fab=0; 
								}					
						}
					}				
					
				}
				echo "<td>".$tot_cut_qty."</td><td>".$tot_fab."</td><td>".$doc_count."</td>";			
				echo "</tr>";
				$grand_tot_cut_qty=$grand_tot_cut_qty+$tot_cut_qty;
				$grand_tot_no_of_doc=$grand_tot_no_of_doc+$doc_count;
				$tot_yards=$tot_yards+$tot_fab;
				$tot_cut_qty = 0;
				$tot_fab = 0;
				$doc_count = 0;
			}
		}
		

		// Section A End
		echo "<tr class='danger'><th>Total:</th><th colspan=$total_hours></th><th>$grand_tot_cut_qty</th><th>$tot_yards</th><th>$grand_tot_no_of_doc</th></tr>";
		echo "</table></div>
	</div>";
}
		?>
		<div class="panel-body">
			</div>
		</div>
	</div>
</div>

</body>

</html>