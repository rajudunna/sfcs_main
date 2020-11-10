<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
$plant_Code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

?>


<script type='text/javascript'>
function firstbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
}
function secondbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}

</script>


<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}

function check_all()
{
	var	style = $('#style').val();
	var	schedule = $('#schedule').val();
	var	color = $('#color').val();
	if(style === 'NIL' && schedule === 'NIL' && color === 'NIL'){
		sweetAlert('Please Select Style, Schedule and Color','','warning');
		return false;
	}
	else if(schedule === 'NIL' && color === 'NIL'){
		sweetAlert('Please Select Schedule and Color','','warning');
		return false;
	}
	else if(color === 'NIL'){
		sweetAlert('Please Select Color','','warning');
		return false;
	}
}
</script>

<style>

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
	td {
		font-weight:bold;
		color:black;
	}
	.form-control{
		min-width : 200px;
	}
	.BG {
	/* background-image:url(Diag.gif); */
	background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
	}
</style>
<?php
$get_style=$_GET['style'];
$get_schedule=$_GET['schedule']; 
$get_color=$_GET['color'];

if(isset($_POST['style']))
{
	$get_style=$_POST['style'];
}
if(isset($_POST['schedule']))
{
	$get_schedule=$_POST['schedule'];
}
if(isset($_POST['color']))
{
	$get_color=$_POST['color'];
}


?>
<div class="panel panel-primary">
<div class="panel-heading">Daily Rejection Detail Report - Style Level</div>
<div class="panel-body">
<form name="test" class="form-inline" method="post" action="?r=<?= $_GET['r'] ?>">
	<div class="row">
		<!-- <div class="col-md-1" class="alert alert-primary"><label><label></div> -->
		<div class="col-md-3 form-group">
			<label>Ex-Factory Start Date</label><br>
			<input  class="form-control" type="text" data-toggle='datepicker' id="dat1" name="sdate" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
		</div>
		<div class="col-md-3 form-group">
			<label>End Date</label><br>
			<input  class="form-control" type="text" data-toggle='datepicker' id="dat2" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
		</div>
		<div class="col-md-2 form-group">
			<br/>
			<input type="checkbox" class="checkbox" name="module" value="1" <?php if(isset($_POST['module'])) { echo "checked"; }?>>
			<label>Module</label>
		</div>
		<div class="col-md-2 form-group">
			<label class="checkbox-inline"></label><br/>
		 	<input type="submit" class="btn btn-primary" name="filter" onclick='return verify_date()' value="Filter">
		</div>
	</div>
	<br><br>
	<div class="row">
		<!-- <div class="col-md-1"></div> -->
		<div class="col-sm-3 form-group">
					<label for='style'>Select Style</label><br>
					<select required class='form-control' name='style' onchange='firstbox()' id='style'>
					<?php
						echo "<option value=\"NIL\" selected>NIL</option>";
						if($plant_code!=''){
							$result_mp_color_details=getMpColorDetail($plant_code);
							$style=$result_mp_color_details['style'];
						}
						foreach ($style as $style_value) {
							if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
							{ 
								echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
							} 
							else 
							{ 
								echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
							}
						}
					echo "</select>";
					?>	
				</div>
				<div class="col-sm-3 form-group">
					<label for='schedule'>Select Schedule</label><br>
					<select required class='form-control' name='schedule' onchange='secondbox();' id='schedule'>
					<?php
						echo "<option value=\"NIL\" selected>NIL</option>";	
						/*function to get schedule from getdata_bulk_schedules
						@params : plantcode,style
						@returns: schedule
						*/
						if($get_style!=''&& $plant_code!=''){
							$result_bulk_schedules=getBulkSchedules($get_style,$plant_code);
							$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
						} 
						foreach ($bulk_schedule as $bulk_schedule_value) {
							if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
							{ 
								echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
							} 
							else 
							{ 
								echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
							}
						}
						echo "</select>";
					?>
				</div>	
				<div class="col-sm-4 form-group">
					<label for='color'>Select Color:</label><br>
					<select required class='form-control' name='color' onchange='thirdbox();' id='color'>
					<?php
						echo "<option value=\"NIL\" selected>NIL</option>";
						/*function to get color from get_bulk_colors
						@params : plantcode,schedule
						@returns: color
						*/
						if($get_schedule!='' && $plant_code!=''){
							$result_bulk_colors=getBulkColors($get_schedule,$plant_code);
							$bulk_color=$result_bulk_colors['color_bulk'];
						}	
						foreach ($bulk_color as $bulk_color_value) {
							if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
							{ 
								echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
							} 
							else 
							{ 
								echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
							}
						}
						echo "</select>";
					?>
				</div>
			<div class="col-md-2">
			<label></label><br/>
			<input type="submit" class="btn btn-primary" value="Filter" name="filter2" id="filter2" onclick="return check_all();">
	</div>
</form>

<?php

	if(isset($_POST['filter']) or isset($_POST['filter2']))
	{		
		$sdate=$_POST['sdate'];
		$edate=$_POST['edate'];
		$module=$_POST['module'];
		$choice=1;		
		if($module>0)
		{
			$choice=2;
		}
		
		if(isset($_POST['filter2']))
		{
			$sch_db_grand=$_POST['schedule'];
			$sch_color=$_POST['color'];
			$choice=3;
		}
		else
		{
			$sql="
			SELECT DISTINCT SCHEDULE FROM $oms.oms_mo_details WHERE planned_delivery_date between '$sdate' and '$edate'";
			$sql_result=mysqli_query($link, $sql) or exit("Fetching Schedule Information".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sch_db_grand[]=$sql_row['SCHEDULE'];
			}
			$sch_db_grand="'" . implode ( "', '", $sch_db_grand ) . "'";
		}
		if(sizeof($sch_db_grand)>0)
		{
			//Getting Module information
			$qry_workstations="SELECT workstation_id,workstation_code, workstation_description FROM $pms.workstation WHERE is_active=1 AND plant_code='$plant_Code'";
			$workstations_result=mysqli_query($link_new, $qry_workstations) or exit("Sql Error at workstatsions".mysqli_error($GLOBALS["___mysqli_ston"]));
			$moduleId=array();
			$moduleCode=array();
			$workstations_result_num=mysqli_num_rows($workstations_result);
			if($workstations_result_num>0){
				while($workstations_row=mysqli_fetch_array($workstations_result))
				{
					$moduleId[]=$workstations_row['workstation_id'];	
					$moduleCode[$workstations_row['workstation_id']]=$workstations_row['workstation_code'];
				}
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
			$sql_rejection="SELECT * FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rh.schedule in ($sch_db_grand) AND rt.parent_barcode_type='PPLB' and rh.plant_code='".$plant_Code."' GROUP BY rt.reason_id";
			$sql_result=mysqli_query($link, $sql_rejection) or exit("Checking Rejection information".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<br/><hr/><br/><div class='table-responsive'><table class='table table-bordered'>";
				echo "<tr class='tblheading'>
				<th rowspan=2>Style</th>
				<th rowspan=2>Schedule</th>
				<th rowspan=2>Color</th>
				<th rowspan=2>Size</th>
				<th rowspan=2>Order Qty</th>
				<th rowspan=2>Module</th>
				<th rowspan=2>Output</th>
				<th rowspan=2 width=45>Reject<br/> Out</th>";
				for($i=0;$i<sizeof($depts);$i++)
				{
					echo "<th colspan=".$deptSize[$depts[$i]]." width=45>".$depts[$i]."</th>";
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
				if($choice == 3)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,schedule,size,SUM(good_quantity) AS output FROM $pts.transaction_log WHERE parent_barcode_type='PPLB' and schedule in ($sch_db_grand) and color = '$sch_color' and plant_code='".$plant_Code."' group by schedule,color,size";
				}
				else if($choice == 1)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,schedule,size,SUM(good_quantity) AS output FROM $pts.transaction_log WHERE parent_barcode_type='PPLB' and schedule in ($sch_db_grand)  and plant_code='".$plant_Code."' group by schedule,color,size";
				}
				else if($choice==2)
				{
					$sql="SELECT resource_id,operation as operation_id,style,color,schedule,size,SUM(good_quantity) AS output FROM $pts.transaction_log WHERE parent_barcode_type='PPLB' and schedule in ($sch_db_grand)  and plant_code='".$plant_Code."' group by schedule,color,size,resource_id";
				}
				$grand_reject=array();
				$grand_output=0;
				$sql_result=mysqli_query($link, $sql) or exit("Fetching Out put Information--".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$mod=$sql_row['resource_id'];
					$sw_out=$sql_row['output'];
					//Order_Qty Data
					$query="SELECT SUM(omd.mo_quantity) as qty FROM oms.oms_mo_details AS omd LEFT JOIN 
					oms.oms_products_info opi ON omd.mo_number=opi.mo_number WHERE omd.plant_code='".$plant_Code."' and omd.schedule='".$sql_row['schedule']."' AND opi.color_name='".$sql_row['color']."' AND opi.size_name='".$sql_row['size']."'";
					$sql_oms_result = mysqli_query($link_new, $query) or exit("Fetching order quantity" . mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($oms_row = mysqli_fetch_array($sql_oms_result)) {
						$order_qty = $oms_row['qty'];
					}
					echo "<tr>";
					echo "<td>".$sql_row['style']."</td>";
					echo "<td>".$sql_row['schedule']."</td>";
					echo "<td>".$sql_row['color']."</td>";
					echo "<td>".$sql_row['size']."</td>";
					echo "<td>".$order_qty."</td>";
					echo "<td>".$moduleCode[$sql_row['resource_id']]."</td>";
					echo "<td>".$sql_row['output']."</td>";
								
					if($choice==1 || $choice==3)
					{
						$sql1="SELECT reason_id,SUM(rh.total_rejection) AS qty FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rh.schedule='".$sql_row['schedule']."' and  fg_color = '".$sql_row['color']."' and size='".$sql_row['size']."' group by reason_id";
					}
					else
					{
						$sql1="SELECT reason_id,SUM(rh.total_rejection) AS qty FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE rh.schedule='".$sql_row['schedule']."' and  fg_color = '".$sql_row['color']."' and size='".$sql_row['size']."' and rt.workstation_id='".$mod."' group by reason_id";
					}
					//echo $sql1."<br>"; 
					$rej_qty=array();
					$sql_result1=mysqli_query($link, $sql1) or exit("Fetching Rejection Quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$rej_qty[$sql_row1['reason_id']]=$sql_row1['qty'];
					}

					if(sizeof($rej_qty)>0)
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
						$grand_reject[$depts[$jj]]=$grand_reject[$depts[$jj]]+$rejection;
					}	
					$grand_output=$grand_output+$sw_out;
				}	
				$grand_rejections=array_sum($grand_reject);			
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=6 bgcolor=#f47f7f>Total</td>";
				echo "<td>".$grand_output."</td>";
				echo "<td class=\"BG\">$span1".$grand_rejections."$span3$span2"; if($grand_output>0) { echo round(($grand_rejections/$grand_output)*100,1)."%"; } echo "$span3</td>";
				$bgcolor=" bgcolor=#FFEEDD ";
				for($j=0;$j<sizeof($depts);$j++)
				{
					echo "<td colspan=".$deptSize[$depts[$j]]." class=\"BG\ >$span1".$grand_reject[$depts[$j]]."$span3$span2"; if($grand_output>0) { echo round(($grand_reject[$depts[$j]]/$grand_output)*100,1)."%"; } echo "$span3</td>";
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
				echo "<br><br>";
				echo "<br><br>";
				echo " <div class='alert alert-info alert-dismissible'><h3>Rejections Not available in selected criteria.<br></h3>";		
				echo "</div>";
			}
		}	

	}

?>


