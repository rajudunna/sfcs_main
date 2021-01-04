<?php  
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
	//$has_permission=haspermission($_GET['r']);
	$plantcode=$_SESSION['plantCode'];
	$plantcode='Q01';
	$username=$_SESSION['userName'];
?> 
<script type="text/javascript"> 
 
function check_data(i,j) 
{
	var fr_qty=Number(document.getElementById("fr"+j).value);
	var val1=Number(i);
	if(val1>0)
	{
		if(val1<fr_qty)
		{
			document.getElementById("row_val"+j).style.backgroundColor="red";
		}
		else
		{
			document.getElementById("row_val"+j).style.backgroundColor="";
		}
	}
	else
	{
		document.getElementById("row_val"+j).style.backgroundColor="";
	}		
} 
function check_stat(i,j) 
{
	var fr_qty=Number(document.getElementById("fr"+j).value);
	var lfr=Number(document.getElementById("lfr"+j).value);
	var lfr_ori=Number(document.getElementById("lfr_ori"+j).value);
	if (i=='NIL' )
	{
		document.getElementById("lfr"+j).value = lfr_ori;
		document.getElementById("row_val"+j).style.backgroundColor="";
	}
	else
	{
		if(lfr<fr_qty)
		{
			if(i=='NIL')
			{	
				document.getElementById("row_val"+j).style.backgroundColor="red";
			}
			else
			{
				document.getElementById("row_val"+j).style.backgroundColor="";
			}	
		}
	}
}

function check_tot() 
{ 	
	var mod_list=Number(document.getElementById("tot_mod").value);
	var status=0;
	var checkn=1;
	for(var k=0;k<mod_list;k++)
	{		
		var lfr=Number(document.getElementById("lfr"+k).value);
		var fr_qty=Number(document.getElementById("fr"+k).value);
		var ln_reas=document.getElementById("line_reson"+k).value;

		if(lfr>0)
		{
			if(lfr<fr_qty)
			{
				if(ln_reas=='NIL')
				{

					status=1;
				}
			}
			checkn=0;
		}
	}	
	if(checkn==1)
	{
		sweetAlert('Please Fill Any module Forecast!','','warning');
		return false;
	}
	else if(status==1)
	{
		sweetAlert('Please select the reasons if Forecast is less than Plan Qty!!','','warning');
		return false;
	}
	else if(status==0)
	{
		return true;
	}
	
}  

 </script> 


<link href="back_end_style.css" rel="stylesheet" type="text/css" media="all" /> 
</head> 

<body> 
<div class="panel panel-primary"> 
<div class="panel-heading">Module Wise Forecast Qty Details</div> 
<div class="panel-body"> 

<form method="POST" action="#"> 
<table class="table table-bordered"> 
<div class="form-group col-sm-3">
<label for="date">Date: </label>
						<input type="text" id="date" data-toggle="datepicker" name="date" class="form-control" value="<?php  if(isset($_POST['date'])) { echo $_POST['date']; } else { echo date("Y-m-d"); } ?>"  required> 
</div>
<div class='col-sm-3'>
						<br>
						<input type="submit" name="submit" id="submit" value="Show" class="btn btn-primary">
					</div>
				</form>	
<?php
if(isset($_POST['submit']))
{
	$today=$_POST['date'];
	$split_date=explode("-",$today);
	$year=$split_date[0];
	$month=$split_date[1];
	$department_type="SEWING";
	$reason_type="SEWING";
	$reason_group="LINE";
	$result_worksation_id=getWorkstations($department_type,$plantcode);
	$workstations=$result_worksation_id['workstation'];

	if(sizeof($workstations)>0){
				/** validation for selected month plan available or not */
			$qry_monthly_plan="SELECT monthly_pp_up_log_id FROM $pps.`monthly_production_plan_upload_log` WHERE year='$year' AND month='$month' AND plant_code='$plantcode'";
			$monthly_plan_result=mysqli_query($link_new, $qry_monthly_plan) or exit("Sql Error at workstatsions".mysqli_error($GLOBALS["___mysqli_ston"]));
			$monthly_plan_num=mysqli_num_rows($monthly_plan_result);
			if($monthly_plan_num>0){
				while($monthly_plan_row=mysqli_fetch_array($monthly_plan_result))
				{
					$monthly_pp_up_log_id=$monthly_plan_row['monthly_pp_up_log_id'];
				}
		?>			
		<form method="POST" action="#" onsubmit="return check_tot()"> 
			<div style="width:500px;margin-left:auto;margin-right:auto;"> 
			<div class="row"> 
			<div class="col-md-1"></div> 
			<div class="col-md-8" style='max-height:600px;overflow-y:scroll;'> 
				<table class="table table-bordered"> 
				<tr> 
				<th> Module </th> 
				<th> FR Plan </th> 
				<th> Quantity (Forecast) </th> 
				<th> Reason </th> 
				</tr> 
		<?php  
			$frv=array(); 
			$frv_id=array(); 
			$mod_names=array();
			/** function to get work stations department sewing type
			 * @param:department_type(sewing)
			 * @return:workstations
			 */
			foreach($workstations as $work_id=>$work_des)
			{
				$mod_names[]=$work_id;
				$getPlannedQty="SELECT pp_log_id,planned_qty AS qty FROM $pps.monthly_production_plan WHERE monthly_pp_up_log_id='$monthly_pp_up_log_id' AND planned_date='$today' AND row_name='$work_des'";
				$getPlannedQty_result=mysqli_query($link_new, $getPlannedQty) or exit("Sql Error at workstatsions".mysqli_error($GLOBALS["___mysqli_ston"]));
				$getPlannedQty_num=mysqli_num_rows($getPlannedQty_result);
				if($getPlannedQty_num>0){
					while($workstations_row=mysqli_fetch_array($getPlannedQty_result))
					{
						$frv[$work_id]=$workstations_row['qty'];
						$frv_id[$work_id]=$workstations_row['pp_log_id'];
					}
				}
				else 
				{ 
					$frv[$work_id]=0;
					$frv_id[$work_id]=0;			
				}
				$sql12="SELECT qty,reason FROM $pps.line_forecast WHERE date='$today' AND module='".$work_id."' AND plant_code='".$plantcode."'";
				$result12=mysqli_query($link, $sql12) or exit("Sql Error at line_forecast " . mysqli_error($GLOBALS["___mysqli_ston"])); 
				if(mysqli_num_rows($result12)) 
				{ 
					while($row12=mysqli_fetch_array($result12))
					{				
						$lfr_qty[$work_id]=$row12['qty'];
						$lfr_reason[$work_id]=$row12['reason'];
					}			
				} 
				else 
				{ 
					$lfr_qty[$work_id]=0;
				}
			}
			
			for($i=0;$i<sizeof($mod_names);$i++) 
			{ 
			?> 
			<tr id="row_val<?php echo $i; ?>"> 
				<td> 
				<?php
					echo $workstations[$mod_names[$i]];			 
				
				?> 
				<input type="hidden" value="<?php echo $mod_names[$i]; ?>" name="module[<?php echo $i; ?>]" id="module<?php echo $i; ?>" value='<?php echo $mod_names[$i];  ?>'>
				<input type="hidden" value="<?php echo $frv_id[$mod_names[$i]];  ?>" name="fr_id[<?php echo $i; ?>]" id="fr_id<?php echo $i; ?>">		
				</td> 
				<td> 
				<input type="hidden" name="fr[<?php echo $i; ?>]" id="fr<?php echo $i; ?>" value='<?php echo $frv[$mod_names[$i]];  ?>'> 
				<?php  echo $frv[$mod_names[$i]];  ?> 
				</td> 
				<td> 
				<input type="text" value="<?php echo $lfr_qty[$mod_names[$i]]; ?>" class="integer form-control" onfocus="if(this.value==0){this.value=''}" onblur="javascript: if(this.value==''){this.value=0;}" name="lfr[<?php echo $i; ?>]" id="lfr<?php echo $i; ?>" onchange="check_data(this.value,<?php echo $i; ?>)"> 
				<input type="hidden" value="<?php echo $lfr_qty[$mod_names[$i]]; ?>" name="lfr_ori[<?php echo $i; ?>]" id="lfr_ori<?php echo $i; ?>">
				</td> 
				<td>         
				<?php 
				echo "<select name='line_reson[".$i."]' class='form-control' id='line_reson".$i."' onchange='check_stat(this.value,$i)'>";
				$qryLineReasons="SELECT internal_reason_description FROM $mdm.reasons WHERE department_type='$reason_type' and reason_group = '$reason_group'"; 
				echo "<option value='NIL'>Select Reason</option>";
				$ResultLineReasons=mysqli_query($link_new, $qryLineReasons) or exit("Sql Error at line Reasons" . mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row=mysqli_fetch_array($ResultLineReasons)) 
				{
					if ($lfr_reason[$mod_names[$i]] == $row["internal_reason_description"])
					{
						$selected = 'selected';
					} else {
						$selected = '';
					}
					echo "<option value='".$row["internal_reason_description"]."' $selected>".$row["internal_reason_description"]."</option>";	
				} 
				echo "</select>";
				?> 
				</td>              
			</tr> 
			
		<?php 
		}
		?>
			</table>
			<input type="hidden" value="<?php echo sizeof($mod_names); ?>" name="tot_mod" id="tot_mod">
			<input type="hidden" value="<?php echo $today; ?>" name="daten" id="daten">
			<?php
			if(array_sum($lfr_qty)==0 || in_array($update,$has_permission))
			{
				?>
				<div class='col-sm-3'><br>
				<input type="submit" name="update" id="update" value="Update" class="btn btn-primary">
				</div>	
				<?php
			}
			?>		
		</div>	
		<form> 
		<?php
		}else{
			echo "<script>sweetAlert('No plan for selected month.','','info');</script>";
			}
	}else{
		echo "<script>sweetAlert('No Workstations Found.','','info');</script>";
	}
}
	
if(isset($_POST['update']))
{
	$daten=$_POST['daten'];
	$fr_id=$_POST['fr_id'];
	$fc_qty=$_POST['lfr'];
	$fr_qty=$_POST['fr'];
	$fr_mod=$_POST['module'];
	$fr_reason=$_POST['line_reson'];
	for($i=0;$i<sizeof($fr_mod);$i++)
	{
		if($fr_qty[$i]>0 && $fc_qty[$i]>0)
		{
			$sql1="select * from  $pps.`line_forecast` where date='$daten' and module='$fr_mod[$i]' and plant_code='$plantcode'";
			$result1=mysqli_query($link, $sql1) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows=mysqli_num_rows($result1);
			if($rows==0)
			{
				$sql="INSERT INTO $pps.`line_forecast` (`forcast_id`, `module`, `qty`, `date`, `reason`,plant_code,created_user,updated_user) VALUES ('$fr_id[$i]', '$fr_mod[$i]', '$fc_qty[$i]', '$daten', '$fr_reason[$i]', '$plantcode', '$username', '$username')";
				$result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
			else
			{
				$sql="update $pps.`line_forecast` set qty ='$fc_qty[$i]', reason ='$fr_reason[$i]', updated_user ='$username',updated_at=NOW() where module ='$fr_mod[$i]' and  date ='$daten' and plant_code ='$plantcode'";
				$result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"]));	
				
			}
			
		}
	}
	echo "<script>sweetAlert('Successfully Forecast Updated.','','success');</script>";
}
 ?> 
     



</div> 
</div> 
</div> 
<script type="text/javascript">
	var EndDate_datePicker = new Date();
	EndDate_datePicker.setDate(EndDate_datePicker.getDate()+1);

	$('[data-toggle="datepicker"]').datepicker({
		format: 'yyyy-mm-dd',
		endDate: EndDate_datePicker,
	});
</script>