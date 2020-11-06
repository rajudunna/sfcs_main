<?php


include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
$plant_Code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

?>
<script>
function verify_dates(){
	
	var from = document.getElementById('demo1').value;
	var to =   document.getElementById('demo2').value;
	// alert(from+'  '+to );
	if(from > to){
		swal('End Date should not be less than Start Date','','warning');
		return false;
	}
	return true;
}
</script>
<style>
td {
	font-weight:bold;
	color:black;
}

table th
{
	border: 1px solid black;
	text-align: center;
	background-color: #003366;
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


.BG {
/* background-image:url($Diag); */
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
background-position:center middle;
}
</style>
<div class="panel panel-primary">
<div class="panel-heading">Daily Rejection Detail Report - Module Level</div>
<div class="panel-body">
		<form name="input" method="post" action="?r=<?= $_GET['r'] ?>">
			<div class="row">
				<div class="col-md-3">
					<label>Start Date:</label>
					<input id="demo1" type="text" data-toggle="datepicker" class="form-control" name="sdate" value=<?php if($sdate!="") { echo $sdate; } else { echo date("Y-m-d"); } ?>>
				</div>
				<div class="col-md-3">
					<label>End Date:</label>
					<input id="demo2" type="text" data-toggle="datepicker" class="form-control" name="edate" value=<?php if($edate!="") { echo $edate; } else { echo date("Y-m-d"); } ?>>
				</div>
				<div class='col-md-2'><label>Style Level</label><input type="checkbox" class="checkbox" name="style_level" value="1" <?php if(isset($_POST['style_level'])) { echo "checked"; }?>></div>
				<div class='col-md-1'><label>Shift Level </label><input type="checkbox" class="checkbox" name="shift_level" value="2" <?php if(isset($_POST['shift_level'])) { echo "checked"; }?>></div>
				<div class='col-md-2'><label>Section</label>
					<?php
						$section_dd = $_POST['section'];
						echo "<select name=\"section\" class='form-control'>";
						//echo "<option value=\"0\">All</option>";
						$departments=getSectionByDeptTypeSewing($plant_Code);
						foreach($departments as $department)    //section Loop -start
						{
							$sectionId=$department['sectionId'];
							$sectionCode=$department['sectionCode'];
					?>	<option <?php if ($section_dd==$sectionId) { ?>selected="selected"<?php } ?> value="<?php echo $sectionId; ?>">
								<?php echo $sectionCode; ?>
							</option>
					<?php			
						}
							echo "</select>";	
					?>
				</div><br/>
			<input type="submit" onclick="return verify_dates()" name="filter" value="Filter" class="btn btn-primary">
		</div>
		</form>

		<?php
		if(isset($_POST['filter']))
		{
			$sdate=$_POST['sdate'];
			$edate=$_POST['edate'];
			$style_level=$_POST['style_level'];
			$shift_level=$_POST['shift_level'];
			$section=$_POST['section'];
			//Getting Shift information
			$teamsData=getShifts($plant_Code);
			foreach($teamsData as $shifts)   
			{
				foreach($shifts as $shiftDetails)    
				{
					$shiftsIde[]=$shiftDetails['shift_id'];
					$shiftsInfo[]=$shiftDetails['shift_code'];
				}		
				
			}	
			$choice=0;
			
			if($style_level>0 and $shift_level>0)
			{
				$choice=3;
			}
			else
			{
				if($style_level==1)
				{
					$choice=1;
				}
				else
				{
					if($shift_level==2) {	$choice=2; }
				}
			}

			//Getting Module information
			$workstationsArray=getWorkstationsForSectionId($plant_Code, $section);
			foreach($workstationsArray as $workstations)
			{
				$moduleId[]=$workstations['workstationId'];	
				$moduleCode[$workstations['workstationId']]=$workstations['workstationCode'];
			}	
			//Getting Reson information
			$reasons_query = "SELECT distinct department_type from $mdm.reasons where reason_group = 'PRODUCTION' and is_active=1";
			$reasons_result = mysqli_query($link_new, $reasons_query);
			while($row = mysqli_fetch_array($reasons_result)) 
			{
				$depts[]=$row['department_type'];
				$dept_type=$row['department_type'];
				$rejectReasonarray=getRejectionReasons($dept_type);
				$i=0;
				foreach($rejectReasonarray as $Reason)
				{
					$reasonId[$dept_type][$i]=$Reason['reason_id'];	
					$reasonCode[$dept_type][$i]=$Reason['internal_reason_code'];	
					$reasonDesc[$dept_type][$i]=$Reason['internal_reason_description'];	
					$i++;					
				}
				$deptSize[$dept_type]=$i;
			}
			$sql_rejection="SELECT * FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rt.workstation_id in ('".implode("','",$moduleId)."') AND rt.created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 00:00:00' GROUP BY rt.reason_id";
			$sql_result=mysqli_query($link, $sql_rejection) or exit("Fetching Out put Information".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<br/><hr/><br/><div class='table-responsive'><table class='table table-bordered'>";
				echo "<tr class='tblheading'>
				<th rowspan=2>Module</th>
				<th rowspan=2>Shift</th>
				<th rowspan=2>Style</th>
				<th rowspan=2>Schedule</th>
				<th rowspan=2>Color</th>
				<th rowspan=2>Output</th>
				<th rowspan=2 width=45>Reject<br/> Out</th>";
				for($i=0;$i<sizeof($depts);$i++)
				{
					echo "<th colspan=".$deptSize[$dept_type]." width=45>".$depts[$i]."</th>";
				}
				echo "</tr>";
				echo "<tr class='tblheading'>";
				for($ii=0;$ii<sizeof($depts);$ii++)
				{
					for($iii=0;$iii<$deptSize[$depts[$ii]];$iii++)
					{
						echo "<th width=45>".$reasonDesc[$depts[$ii]][$iii]."</th>";
					}
				}				
				echo "</tr>";	
			
				if($choice==0)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,SUM(good_quantity) AS output FROM $pts.transaction_log WHERE created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' AND parent_barcode_type='PPLB' and resource_id in ('".implode("','",$moduleId)."') and plant_code='".$plant_Code."' group by resource_id";
				}

				if($choice==1)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,SUM(good_quantity) AS output, group_concat(distinct schedule) as schedule, group_concat(distinct color) as color FROM $pts.transaction_log WHERE created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' AND parent_barcode_type='PPLB' and resource_id in ('".implode("','",$moduleId)."') and plant_code='".$plant_Code."' group by style order by style";
				}

				if($choice==2)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,SUM(good_quantity) AS output,shift, group_concat(distinct schedule) as schedule, group_concat(distinct color) as color FROM $pts.transaction_log WHERE created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' AND parent_barcode_type='PPLB' and resource_id in ('".implode("','",$moduleId)."') and plant_code='".$plant_Code."' group by resource_id,shift order by resource_id,shift";
				}

				if($choice==3)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,SUM(good_quantity) AS output, group_concat(distinct schedule) as schedule, group_concat(distinct color) as color, style,resource_id,shift FROM $pts.transaction_log WHERE created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' AND parent_barcode_type='PPLB' and resource_id in ('".implode("','",$moduleId)."') and plant_code='".$plant_Code."' group by style,resource_id,shift order by resource_id,shift";
				}
				$grand_reject=array();
				$grand_output=0;
				$sql_result=mysqli_query($link, $sql) or exit("Fetching Out put Information".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$op = $sql_row['operation_id'];
					$mod=$sql_row['resource_id'];
					$shift=$sql_row['shift'];
					$schedule=$sql_row['schedule'];
					echo "<tr>";
					echo "<td>".$moduleCode[$sql_row['resource_id']]."</td>";
					echo "<td>".$sql_row['shift']."</td>";
					echo "<td>".$sql_row['style']."</td>";
					echo "<td>".$sql_row['schedule']."</td>";
					echo "<td>".$sql_row['color']."</td>";
					$sw_out=$sql_row['output'];
					
					if($choice==0)
					{
						$sql1="SELECT reason_id,SUM(rt.rejection_quantity) AS qty FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rt.workstation_id='$mod' AND rt.created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 00:00:00' GROUP BY rt.reason_id";
					}
					
					if($choice==1)
					{
						$sql1="SELECT reason_id,SUM(rt.rejection_quantity) AS qty FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rt.workstation_id='$mod' and rh.schedule in ($schedule) AND rt.created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 00:00:00' GROUP BY rt.reason_id";
					}
					
					if($choice==2)
					{
						// Shift not maintining
						$sql1="SELECT reason_id,SUM(rt.rejection_quantity) AS qty FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rt.workstation_id='$mod' and rh.schedule in ($schedule) AND rt.created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 00:00:00' GROUP BY rt.reason_id";
					}
					
					if($choice==3)
					{
						// Shift not maintining
						$sql1="SELECT reason_id,SUM(rt.rejection_quantity) AS qty FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rt.workstation_id='$mod' and rh.schedule in ($schedule) AND rt.created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 00:00:00' GROUP BY rt.reason_id";
					}
					$rej_qty=array();
					$sql_result1=mysqli_query($link, $sql1) or exit("Fetching Rejection Quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$rej_qty[$sql_row1['reason_id']]=$sql_row1['qty'];
					}
					if(size($rej_qty)>0)
					{
						$qms_qty=array_sum($rej_qty);
					}
					else
					{
						$qms_qty=0;
					}
					$span1='<p class="pull-left">';
					$span2='<p class="pull-right">';
					$span3='</p>';				
					echo "<td>".$sw_out."</td>";
					echo "<td class=\"BG\">$span1".$qms_qty."$span3$span2"; if($sw_out>0) { echo round(($qms_qty/$sw_out)*100,1)."%"; } echo "$span3</td>";
					$bgcolor=" bgcolor=#FFEEDD ";
					for($jj=0;$jj<sizeof($depts);$jj++)
					{
						$rejection=0;
						for($jjj=0;$jjj<$deptSize[$depts[$jj]];$jjj++)
						{							
							if($rej_qty[$reasonId[$depts[$jj]][$jjj]]!='')
							{
								echo "<td class=\"BG\" $bgcolor>$span1".$rej_qty[$reasonId[$depts[$jj]][$jjj]]."$span3$span2"; if($sw_out>0) { echo round(($rej_qty[$reasonId[$depts[$jj]][$jjj]]/$sw_out)*100,1)."%"; } echo "$span3</td>";
								$rejection=$rejection+$rej_qty[$reasonId[$depts[$jj]][$jjj]];	
							}
							else
							{
								echo "<td class=\"BG\" $bgcolor>$span10$span3$span2";  echo "0%";  echo "$span3</td>";	
								$rejection=$rejection+0;
							}						
						}
						if($jj/2==0)
						{
							$bgcolor=" bgcolor=white ";	
						}
						else
						{
							$bgcolor=" bgcolor=#FFEEDD ";
						}
						$grand_reject[$depts[$ii]]=$rejection;
					}
					$grand_output+=$grand_output+$sw_out;	
				}				
				echo "</tr>";			
				//Section Data
				$query="select section_name from $pms.sections where plant_code='$plant_code' and department_id='$section'";
				$sql_res = mysqli_query($link_new, $query) or exit("Fetching Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
				$sections_rows_num = mysqli_num_rows($sql_res);
				while ($sections_row = mysqli_fetch_array($sql_res)) {
					$section_display_name = $sections_row['section_name'];
				}
				
				echo "<tr >";
				echo "<td colspan=5 bgcolor=#f47f7f>$section_display_name</td>";
				echo "<td>".$grand_output."</td>";
				echo "<td class=\"BG\">$span1".$grand_rejections."$span3$span2"; if($grand_output>0) { echo round(($grand_rejections/$grand_output)*100,1)."%"; } echo "$span3</td>";
				$bgcolor=" bgcolor=#FFEEDD ";
				for($j=0;$j<sizeof($depts);$j++)
				{
					echo "<td  class=\"BG\ colspan=".$deptSize[$dept_type].">$span1".$grand_reject[$depts[$j]]."$span3$span2"; if($grand_output>0) { echo round(($grand_reject[$depts[$j]]/$grand_output)*100,1)."%"; } echo "$span3</td>";
					if($j/2==0)
					{
						$bgcolor=" bgcolor=white ";	
					}
					else
					{
						$bgcolor=" bgcolor=#FFEEDD ";
					}
				}		
				echo "</tr>";
				echo "</table></div>";
			}
			else
			{
				echo "<br><br>";
				echo " <div class='alert alert-info alert-dismissible'><h3>Rejections Not available in selected criteria.<br></h3>";		
				echo "</div>";
			}
		} 



?>

</div>
</div>
</div>