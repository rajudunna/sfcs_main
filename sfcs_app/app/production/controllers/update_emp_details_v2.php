<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	$plantcode=$_SESSION['plantCode'];
	$plantcode='Q01';
	$username=$_SESSION['userName'];
	if(isset($_POST['team'])) 
	{ 
	$team=$_POST['team'];
	$date=$_POST['dat'];
	$shift_start=$_POST['shift_start'];
	$shift_end=$_POST['shift_end'];
	}else{
	$team=$_GET['team'];
	$date=$_GET['dat'];
	$shift_start=$_GET['shift_start'];
	$shift_end=$_GET['shift_end'];
	}

?>

<script language="javascript" type="text/javascript" src="datetimepicker_css.js"></script>
<script>
function working_hours(id){
		var rowId = (id.split('working_hours_min-')[1] );
		var rowId1 = (id.split('adjustment_smo-')[1] );
		var rowId3 = (id.split('adjustment_smo-')[1] );
		var rowId4 = (id.split('working_hours_min-')[1] );

                       $('#working_hours_min-'+rowId).on('change', function() {
						 
							var adjustment1= $('#adjustment_smo-'+rowId).val();
							var work1= $('#working_hours_min-'+rowId).val();
							var type1= $('#adjustment_type-'+rowId).val();
							if(type1=='Negative'){
							var final_adjustment_min=Number(adjustment1)*Number(work1);
							$('#adjustment_min-'+rowId).val('-'+final_adjustment_min);
							var hours= $('#adjustment_min-'+rowId).val();
							var final_hours=Number(hours/60).toFixed(2);
							$('#adjustment_hours-'+rowId).val(final_hours);
							}
							if(type1=='Positive'){
							var final_adjustment_min=Number(adjustment1)*Number(work1);
							$('#adjustment_min-'+rowId).val(final_adjustment_min);
							var hours= $('#adjustment_min-'+rowId).val();
							var final_hours=Number(hours/60).toFixed(2);
							$('#adjustment_hours-'+rowId).val(final_hours);
							}	
							
							
					    });
					
					   $('#adjustment_smo-'+rowId1).on('change', function() {
						var work1= $('#working_hours_min-'+rowId1).val();
						 var adjustment1= $('#adjustment_smo-'+rowId1).val();
						 var type1= $('#adjustment_type-'+rowId1).val();
						 if(type1 =='Negative'){
						var final_adjustment_min=Number(adjustment1)*Number(work1);
						 $('#adjustment_min-'+rowId1).val('-'+final_adjustment_min);
						 var hours= $('#adjustment_min-'+rowId1).val();
						 var final_hours=Number(hours/60).toFixed(2);
						 $('#adjustment_hours-'+rowId1).val(final_hours);

						 }
						 if(type1 =='Positive'){
						 var final_adjustment_min=Number(adjustment1)*Number(work1);
						 $('#adjustment_min-'+rowId1).val(final_adjustment_min);
						 var hours= $('#adjustment_min-'+rowId1).val();
						 var final_hours=Number(hours/60).toFixed(2);
						 $('#adjustment_hours-'+rowId1).val(final_hours);
						 }
						 
				       });
					
	
}

</script>
<script type="text/javascript">

function check_hrs(){
	var shift_start=$('#shift_start').val();
	var shift_end=$('#shift_end').val();
	var team=$('#team').val();

	console.log(shift_start+'---'+shift_end);
	if(team=='' || shift_start=='' || shift_end=='' ){
		swal('Please Fill All Details','','warning');
		return false;
	}
	if(Number(shift_end) <= Number(shift_start))
	{
		swal('Please select Shift End Time more than Shift Start Time','','warning');
		$('#shift_end').val('');
		return false;
	}
	return true;
}

function adjustment_type(id){
	
	var rowId1 = (id.split('adjustment_type-')[1] );


		  $('#adjustment_type-'+rowId1).on('click', function() {
			
							var type= $(this).val();
							if(type=='Positive'){
								var adjustment_min = $('#adjustment_min-'+rowId1).val().replace(/[\-]+/, '');
								var adjustment_hours = $('#adjustment_hours-'+rowId1).val().replace(/[\-]+/, '');
								$('#adjustment_min-'+rowId1).val(adjustment_min);
								$('#adjustment_hours-'+rowId1).val(adjustment_hours);	
							}
							 if(type=='Negative'){
								var adjustment_min1 = $('#adjustment_min-'+rowId1).val().replace(/[\-]+/, '');
								var adjustment_hours1 = $('#adjustment_hours-'+rowId1).val().replace(/[\-]+/, '');
								$('#adjustment_min-'+rowId1).val('-'+adjustment_min1);
								$('#adjustment_hours-'+rowId1).val('-'+adjustment_hours1);
							}
							
							}); 
}


$(function(){
	

	today=new Date();
	var month,day,year;
	year=today.getFullYear();
	month=today.getMonth();
	date=today.getDate();	
	
$('.datepicker').datepicker({
	
	format: 'yyyy-mm-dd',
	endDate: '+0d',
	autoHide: true
});


});
 </script>
 
<?php //include("header_scripts.php"); 
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
</head>

<body>


<div class="panel panel-primary">
	<div class="panel-heading">Employee Attendance Update</div>
	<div class="panel-body">
		<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" >
		<input type="hidden" type="text" class="form-control" value="<?php echo $plantcode; ?>" id="plantcode" name="plantcode">
		<input type="hidden" type="text" class="form-control" value="<?php echo $username; ?>" id="username" name="username">
				<div class='col-md-2 col-sm-3 col-xs-12'>
					Select Date: <input id="demo1" type="text" class="form-control datepicker"  size="10" name="dat"  value=<?php if($date<>"") {echo $date; } else {echo date("Y-m-d");} ?>>
				</div>
			
				<div class='col-md-2 col-sm-3 col-xs-12'>
					Select Team : 
					<select name="team" id="team" class="select2_single form-control" required>
						<option value=''>Please Select</option>
						<?php 
						$shifts_query="select shift_id,shift_code FROM $pms.shifts where plant_code='$plantcode' order by shift_code*1";
						$sql_result12=mysqli_query($link, $shifts_query) or exit ("Sql Error1: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row11=mysqli_fetch_array($sql_result12))
						// for ($i=0; $i < sizeof($shifts_array); $i++)
						{
							$shift_id=$sql_row11['shift_id'];
							$shift_code=$sql_row11['shift_code'];
						?>
						<option  <?php echo 'value="'.$shift_id.'"'; if($team==$shift_id){ echo "selected";}   ?>><?php echo $shift_code ?></option>
						<?php 
										}
										
						?>
					</select>
				</div>
			

				<div class='col-md-2 col-sm-3 col-xs-12'>
				
						<?php 
					
					$query="select start_time FROM $pms.pro_atten_hours where shift='$shift' and plant_code='$plantcode' and date='$date'";
					$query_result=mysqli_query($link, $query) or exit ("Sql Error2: $query_result".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($query_result)==0)
					{
					$shift_start_time_query="select shift_start_time FROM $pms.shifts where shift_id='$shift' and plant_code='$plantcode'";
					$shift_start_time_query_result=mysqli_query($link, $shift_start_time_query) or exit ("Sql Error2: $shift_start_time_query_result".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row12=mysqli_fetch_array($shift_start_time_query_result))
					{
						$shift_start_time=$sql_row12['shift_start_time'];
						
                       
					}

				  }else{
					while($sql_row12=mysqli_fetch_array($query_result))
					{
						$shift_start_time=$sql_row12['start_time'];
						   
					}

				  }
						?>
					Select Shift Start Time: 
					<input name="shift_start" id="shift_start" class="select2_single form-control" value='<?php echo $shift_start_time; ?>' readonly>
			    </div>
				<div class='col-md-2 col-sm-3 col-xs-12'>
						<?php 

							$query1="select end_time FROM $pms.pro_atten_hours where shift='$shift' and plant_code='$plantcode' and date='$date'";
							$query_result1=mysqli_query($link, $query1) or exit ("Sql Error2: $query_result1".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($query_result1)==0)
							{
									$shift_end_time_query="select shift_end_time FROM $pms.shifts where shift_id='$shift' and plant_code='$plantcode'";
									$shift_end_time_query_result=mysqli_query($link, $shift_end_time_query) or exit ("Sql Error3: $shift_end_time_query_result".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row121=mysqli_fetch_array($shift_end_time_query_result))
									{
										$shift_end_time=$sql_row121['shift_end_time'];
										
									}

							}else{
								while($sql_row121=mysqli_fetch_array($query_result1))
								{
									$shift_start_time=$sql_row121['end_time'];
									
								}

							}
									
						?>
					Select Shift End Time:
					<input name="shift_end" id="shift_end" class="select2_single form-control" value='<?php echo $shift_end_time; ?>' readonly>
				</div>

				<div class='col-md-2 col-sm-3 col-xs-12'>
				<?php 
				$query2="select * FROM $pms.pro_atten_hours where shift='$shift' and plant_code='$plantcode' and date='$date'";
				$query_result2=mysqli_query($link, $query2) or exit ("Sql Error21: $query_result2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($query_result2)==0)
				{
									$shift_break_time_query="select break_time FROM $pms.shifts where shift_id='$shift' and plant_code='$plantcode'";
									$shift_break_time_query_result=mysqli_query($link, $shift_break_time_query) or exit ("Sql Error4: $shift_break_time_query_result".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row1211=mysqli_fetch_array($shift_break_time_query_result))
									{
										$break_time=$sql_row1211['break_time'];
										
									}


				}else{
					while($sql_row1211=mysqli_fetch_array($query_result2))
								{
									$shift_start_time=$sql_row1211['break_hours'];
									
								}
				}
									
						?>
					Break Hours(Min):
					<input name="break_hours" id="break_hours" class="break_hours form-control" value='<?php echo $break_time; ?>' readonly>
					
				</div>

			<div class='col-md-2 col-sm-3 col-xs-12' style='margin-top: 18px;'>
				<input type="submit" class="btn btn-primary" name="submit" onclick="return check_hrs();" value="Submit" id="filter"/> 
			</div>
			
		</form>
		<div class="ajax-loader" id="loading-image" style="display: none">
		<center><img src="<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',1,'R'); ?>" class="img-responsive" style="padding-top: 250px"/></center>
	</div>
		<br>	
<?php	
if(isset($_POST['submit']))
{

	$date=$_POST['dat'];
	$shift=$_POST['team'];
	$break_hours=$_POST['break_hours'];
	$shift_start_time=$_POST['shift_start'];
	$shift_end_time=$_POST['shift_end'];
	$now_date=date('Y-m-d');
	$prev_date = date('Y-m-d', strtotime($date .' -1 day'));

	$modules_array = array();	$modules_id_array=array();
	
	$get_modules = "SELECT DISTINCT workstation_description, workstation_id FROM $pms.`workstation` where plant_code='$plantcode'";
	$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules2: $get_modules");
	$count= mysqli_num_rows($modules_result);
	if(mysqli_num_rows($modules_result) > 0)
	{
		while($module_row=mysqli_fetch_array($modules_result))
		{
			$modules_array[]=$module_row['workstation_description'];
			$modules_array1[]=$module_row['workstation_id'];
			$modules_id_array[$module_row['workstation_description']]=$module_row['workstation_id'];
		}	
		$modules = implode("','", $modules_array);
		$modules_id = implode("','", $modules_array1);
		$sql1="SELECT * FROM $pms.pro_attendance WHERE plant_code='$plantcode' and DATE='$date' AND shift='$shift' AND module IN ('$modules_id') ";

		// $get_modules1 = "SELECT max(id) as max_id FROM $bai_pro3.`module_master` where status='Active'";
		// $modules_result1=mysqli_query($link, $get_modules1) or exit ("Error while fetching modules: $get_modules");
		
		// while($module_row1=mysqli_fetch_array($modules_result1))
		// 	{
		// 		$max_id=$module_row1['max_id'];
		// 	}

		// $sql1="SELECT * FROM $bai_pro.pro_attendance where  date='$date' AND shift='$shift' AND module IN ('$modules')  order by pro_attendance.module*1 ";
		
		echo "
		<table border=1 class='table table-bordered' id='dynamic_field'>
			<tr class='info' id='header'>
				<th style='text-align:center;'>Module</th>
				<th style='text-align:center;'>Present Emp</th>
				<th style='text-align:center;'>Jumper</th>
				<th style='text-align:center;'>Type</th>
				<th style='text-align:center;'>Adjustment SMO</th>
				<th style='text-align:center;'>Worked Minutes</th>
				<th style='text-align:center;'>Adjustment Minutes</th>
				<th style='text-align:center;'>Adjustment Hours</th><th></th>";
				$m=0;
				$n=0;
				$l=0;
				$a=0;
				$b=0;
				$c=0;
				$d=0;
				$e=0;$f=0;$g=0;$h=0;$p=0;$r=0;$x=0;$y=0;$t=0;$w=0;$m=0;$cd=0;
		$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error5: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result1);
				
				if($sql_num_check>0)
				{
					echo"</tr>";
					// $get_modules2 = "SELECT DISTINCT workstation_id,workstation_description FROM $pms.`workstation` where plant_code='$plantcode'";
					// $modules_result2=mysqli_query($link, $get_modules2) or exit ("Error while fetching modules1: $get_modules");
				
					// 	while($module_row2=mysqli_fetch_array($modules_result2))
					// 	{
							//$modules1=$module_row2['workstation_id'];
							//$workstation_description=$module_row2['workstation_description'];
							$sql4="SELECT * FROM $pms.pro_attendance left join $pms.pro_attendance_adjustment on pro_attendance_adjustment.module=pro_attendance.module where  pro_attendance.date='$date' AND pro_attendance.shift='$shift' AND pro_attendance.plant_code='$plantcode' and pro_attendance_adjustment.id = (select min(id) from $pms.pro_attendance_adjustment where pro_attendance_adjustment.module= pro_attendance.module and pro_attendance_adjustment.shift='$shift' AND pro_attendance_adjustment.DATE='$date' and pro_attendance_adjustment.plant_code='$plantcode')  group by pro_attendance_adjustment.id order by pro_attendance_adjustment.id";
							// echo $sql4;
						
						$sql_result2=mysqli_query($link, $sql4) or exit ("Sql Error6: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql_num_check3=mysqli_num_rows($sql_result2);
						// if($sql_num_check3>0)
						// {
					while($sql_row1=mysqli_fetch_array($sql_result2))
					{
						$atten_id=$sql_row1['atten_id'];
						$date=$sql_row1['date'];
						$shift=$sql_row1['shift'];
						$avail_av=$sql_row1['present'];
						$absent_ab=$sql_row1['absent'];
						$jumper=$sql_row1['jumper'];
						$break_hours=$sql_row1['break_hours'];
						$module1=$sql_row1['module'];
						

					
						// $sql3="SELECT * FROM $pms.pro_attendance_adjustment where  id = (select min(id) from $pms.pro_attendance_adjustment where module='$module2' AND shift='$shift' AND DATE='$date' and plant_code='$plantcode')";
						
						
						// $sql_result23=mysqli_query($link, $sql3) or exit ("Sql Error7: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						// while($sql_row2=mysqli_fetch_array($sql_result23))
						//  {
							$adjustment_type=$sql_row1['adjustment_type'];
							$adjustment_smo=$sql_row1['smo'];
							$working_hours_min=$sql_row1['smo_minutes'];
							$adjustment_min=$sql_row1['smo_adjustment_min'];
							$adjustment_hours=$sql_row1['smo_adjustment_hours'];
							

						// }
						
						$module_name_query="SELECT workstation_description,workstation_id FROM $pms.workstation where   workstation_id = '$module1'";
						$sql_result22=mysqli_query($link, $module_name_query) or exit ("Sql Error6: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row11=mysqli_fetch_array($sql_result22))
						{
							$workstation_description=$sql_row11['workstation_description'];
							$workstation_id=$sql_row11['workstation_id'];

						}

					
				// }else{
				// 	$avail_av='0';
				// 		$absent_ab='0';
				// 		$jumper='0';
				// }
					
					

							

							
						$fg=$n++;$abc=$a++;$mn=$m++;
						$lm=$l++;$bc=$b++;
						$wy=$w++;$ce=$c++;
						$tu=$t++;$dc=$d++;
						$ps=$p++;$eh=$e++;
						$rt=$r++;$fe=$f++;
						$xy=$x++;$gh=$g++;
						$yz=$y++;$hg=$h++; $acd=$cd++;

						$k=$workstation_id;
					
						echo "<tr id='dynamic$fg' class='dynamic-$lm'>
						<td> <input type='text' class='form-control' id='$k' value='$workstation_description' readonly> </td>";
								//<td>".$workstation_description."</td>"; 
								// if(in_array($authorized,$has_permission))
								// {
									$readonly = ''; ?>
									<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>" id="add_name">
								
													
								<input type="hidden"  name="count" id="count"  value=<?php echo $count ?>>
								<input type="hidden"  name="plantcode" id="plantcode"  value=<?php echo $plantcode; ?>>
								<input type="hidden"  name="username" id="username"  value=<?php echo $username; ?>>
								<input type="hidden"  name="rowcount" id="rowcount"  value=<?php echo $acd; ?>>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" readonly style="width: 100px;" value="<?php echo $avail_av; ?>" name="pra<?php echo $wy; ?>"  id="pra<?php echo $tu; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $jumper; ?>" name="jumper<?php echo $ps; ?>" id="jumper<?php echo $rt; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><select  id="adjustment_type<?php echo $xy; ?>" class="form-control" name="adjustment_type<?php echo $yz; ?>" >
								<option value="Positive" <?php if($adjustment_type == "Positive") { echo "SELECTED"; } ?>>Positive</option>
								<option value="Negative" <?php if($adjustment_type == "Negative") { echo "SELECTED"; } ?>>Negative</option>	
							     </select></td>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" <?php echo $readonly; ?> style="width: 130px;" value="<?php echo $adjustment_smo; ?>" name="adjustment_smo<?php echo $abc; ?>" id="adjustment_smo<?php echo $bc; ?>" onclick=" working_hours()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" <?php echo $readonly; ?> style="width: 130px;" value="<?php echo $working_hours_min; ?>" name="working_hours_min<?php echo $ce; ?>" id="working_hours_min<?php echo $dc; ?>" onclick=" working_hours()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $adjustment_min; ?>" name="adjustment_min<?php echo $eh; ?>" id="adjustment_min<?php echo $fe; ?>" readonly></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $adjustment_hours; ?>" name="adjustment_hours<?php echo $gh; ?>" id="adjustment_hours<?php echo $hg; ?>" readonly></td>
								<td><button type="button" name="add" id="add-<?php echo $mn; ?>" class="btn btn-success"> <span class="glyphicon glyphicon-plus"></span></button></td>  
								<?php
							echo"</tr>";
								}	
							
								echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
								echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
								echo "<input type=\"hidden\" name=\"shift_start_time\" value=\"$shift_start_time\">";
								echo "<input type=\"hidden\" name=\"shift_end_time\" value=\"$shift_end_time\">";	
								echo "<input type=\"hidden\" name=\"break_hours\" value=\"$break_hours\">";		
								//echo "<input type=\"hidden\" name=\"plantcode\" value=\"$plantcode\">";	
								//echo "<input type=\"hidden\" name=\"username\" value=\"$username\">";	
								
	
						// }
						// else
						// {
						// 	$readonly = 'readonly';
						// }
					
						// }
					echo "</table>";
		        // if(in_array($authorized,$has_permission))
				// 	{ ?>
					<?php
						
					?>	
					<?php
					   $get_working_days="select DATE_FORMAT(last_up,'%Y-%m-%d') AS last_up  FROM $pms.pro_attendance_adjustment  GROUP BY last_up ORDER BY last_up DESC LIMIT 1  ";
					   $result_get_working_day=mysqli_query($link, $get_working_days) or exit ("Sql Error8: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					   while($sql_row11=mysqli_fetch_array($result_get_working_day))
								 {
								 $final_date=$sql_row11['last_up'];
  
								 }
								
								if($date==$final_date || $now_date==$date){
									echo'<input type="submit" id="submit" class="btn btn-primary" value="Submit" >';
								}
					// }
				
					echo "</form>";
				}
				else
				{
					$m=0;
					$n=0;
					$l=0;
					$a=0;
					$b=0;
					$c=0;
					$d=0;
					$e=0;$f=0;$g=0;$h=0;$p=0;$r=0;$x=0;$y=0;$t=0;$w=0;$ab=0;$cd=0;
					for($i=1;$i<sizeof($modules_array);$i++) 
					{ 
						$k=$modules_array1[$i];
						?>
						<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>" id="add_name">
							<tr id='dynamic<?php echo $n++;  ?>' class='dynamic-<?php echo $l++;  ?>'>
								<td> <input type="text" class="form-control" id="<?php echo $k ?>" value="<?php echo trim($modules_array[$i]); ?>"  readonly> </td>
								<?php 
								while($sql_row1=mysqli_fetch_array($sql_result1))
								{
								$avail_av=$sql_row1['present'];
								}
						?>

						         <input type="hidden"  name="count" id="count"  value=<?php echo $count; ?>>
								 <input type="hidden"  name="plantcode" id="plantcode"  value=<?php echo $plantcode; ?>>
								 <input type="hidden"  name="username" id="username"  value=<?php echo $username; ?>>
								 <input type="hidden"  name="rowcount" id="rowcount"  value=<?php echo $cd++; ?>>
								<td><input type="text" onkeyup="validateQty1(event,this);" class="form-control" style="width: 100px;" readonly value="0" name="pra<?php echo $w++; ?>"  id="pra<?php echo $t++; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" onkeyup="validateQty1(event,this);"  class="form-control" style="width: 100px;"value="0" name="jumper<?php echo $p++; ?>" id="jumper<?php echo $r++; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><select class="form-control"name="adjustment_type<?php echo $x++; ?>" id="adjustment_type<?php echo $y++; ?>">
								<option value="Positive">Positive</option>
								<option value="Negative">Negative</option>
								</select></td>
								<td><span id="addsymbol"></span><input type="text" class="form-control" style="width: 140px;"value="0" name="adjustment_smo<?php echo $a++; ?>" id="adjustment_smo<?php echo $b++; ?>" onkeyup="validateQty1(event,this);"  onclick=" working_hours()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="working_hours_min<?php echo $c++; ?>" id="working_hours_min<?php echo $d++; ?>" onclick=" working_hours()" onkeyup="validateQty1(event,this);" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="adjustment_min<?php echo $e++; ?>" id="adjustment_min<?php echo $f++; ?>" readonly></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="adjustment_hours<?php echo $g++; ?>" id="adjustment_hours<?php echo $h++; ?>" readonly></td>
								
								<td><button type="button" name="add" id="add-<?php echo $m++; ?>" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>  
							</tr>
						<?php
					}
					echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
					echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
					echo "<input type=\"hidden\" name=\"shift_start_time\" value=\"$shift_start_time\">";
					echo "<input type=\"hidden\" name=\"shift_end_time\" value=\"$shift_end_time\">";
					echo "<input type=\"hidden\" name=\"break_hours\" value=\"$break_hours\">";
					// echo "<input type=\"hidden\" name=\"plantcode\" value=\"$plantcode\">";	
					// echo "<input type=\"hidden\" name=\"username\" value=\"$username\">";
					 ?>
					 </table>
					 <?php
					 
					 $get_working_days="select DATE_FORMAT(last_up,'%Y-%m-%d') AS last_up  FROM $pms.pro_attendance_adjustment  GROUP BY last_up ORDER BY last_up DESC LIMIT 1 ";
					
					 $result_get_working_day=mysqli_query($link, $get_working_days) or exit ("Sql Error9: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($sql_row11=mysqli_fetch_array($result_get_working_day))
							   {
							   $final_date=$sql_row11['last_up'];

							   }
							 
							   if($date==$final_date ||$now_date==$date){
								echo'<input type="submit" id="submit" class="btn btn-primary" value="Submit" >';
							   }
			
	
			         ?>	
				
				
		          
					</form>
					</div>
					</div>
					<?php
				}
	}
	else
	{
		echo "No Modules Available in Modules Master";
	}
}
?>
</body>
</html>
<script>  
$(document).ready(function(){  

   $('#team').on('change',function(){ 
	var date=$('#demo1').val();
	var plantcode=$('#plantcode').val();
	var shift = $('#team option:selected').val();
	var params =[shift,plantcode];

	$.ajax
			  ({
					type: "POST",

					url:"<?= getFullURLLevel($_GET['r'],'emp_attendance_repeated.php',0,'R'); ?>?r=gettimedate&params="+params,
					data: {},
				
						success: function(response)
					{	
						
						var data = jQuery.parseJSON(response);
						if(response.length >0)
						{
						var starttime = data[0]["shift_start_time"];
						var endtime = data[0]["shift_end_time"];
						var break_time = data[0]["break_time"];
						$("#shift_start").val(starttime);
						$("#shift_end").val(endtime);
						$("#break_hours").val(break_time);
						}

                         
					}
			  });

   });
		var date1=$('#demo1').val();
		var team = $('#team option:selected').val();
		var plantcode=$('#plantcode').val();
		var username=$('#username').val();
		var params1 =[date1,team,plantcode,username];
	
	   

			$.ajax
			  ({
					type: "POST",

					url:"<?= getFullURLLevel($_GET['r'],'emp_attendance_repeated.php',0,'R'); ?>?r=getshiftdata&params1="+params1,
					data: {},
						success: function(response)
					{	
					
				
						var data = jQuery.parseJSON(response);
						var $data = jQuery.parseJSON(response);		

						if(response.length >0)
						{
							for(var i=0;i<=data.length;i++)
							
							{
								
								 var adjustment_type=data[i]['adjustment_type'];
								if(adjustment_type=='Positive'){
								var	select='selected';
								}else{
									var select='';
								}
								if(adjustment_type=='Negative'){
								var	select1='selected';
								}else{
									var select1='';
								}

								var td1 =  $('#dynamic'+i).find("td:first").html();
								
								var add_row ='<tr id="row'+i+'" class="dynamic-'+i+'"><td>'+td1+'</td><input type="hidden"><input type="hidden" name="plantcode" id="plantcode" value='+plantcode+'><input type="hidden" name="username" id="username" value='+username+'><input type="hidden" name="rowcount" id="rowcount" value='+i+'><input type="hidden"><td><input type="hidden"></td><td><input type="hidden"></td><td><select style="width: 80px;"  class="form-control" name="adjustment_type'+i+'" id="adjustment_type-'+i+'" onchange="adjustment_type(this.id)"><option value="Positive" '+select+'>Positive</option><option value="Negative" '+select1+'>Negative</option></select></td><td><input type="text" class="form-control" style="width: 130px;"  name="adjustment_smo'+i+'" id="adjustment_smo-'+i+'" value='+data[i]['smo']+' onclick=" working_hours(this.id);" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control" style="width: 130px;"  name="working_hours_min'+i+'[]" id="working_hours_min-'+i+'"  value='+data[i]['smo_minutes']+' onclick=" working_hours(this.id);" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control"  style="width: 100px;"  name="adjustment_min'+i+'[]" id="adjustment_min-'+i+'" value='+data[i]['smo_adjustment_min']+' readonly></td><td><input type="text" class="form-control" style="width: 100px;" name="adjustment_hours'+i+'" id="adjustment_hours-'+i+'" value='+data[i]['smo_adjustment_hours']+' readonly></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><span class="glyphicon glyphicon-minus" ></span></button></td></tr>';
								$('#dynamic'+data[i]['parent_id']).after(add_row);
						
							}
		

						}

                   }

              });


	 
	         var rowCount = $('#dynamic_field tr').length;
			 var max_id=$('#count').val();
			 var k=0;
				for(var i=0; i<=max_id; i++){
					
					$('#add-'+i).click(function(){ 
						k++;
						var j='new'+k;
						var plantcode=$('#plantcode').val();
						var username=$('#username').val();
						var rowId = (this.id.split('add-')[1] );
						
						var td1 =  $('#dynamic'+rowId).find("td:first").html();
						$('#dynamic'+rowId).after('<tr id="row'+rowId+j+'" class="dynamic-'+rowId+'"><td>'+td1+'</td><input type="hidden"><input type="hidden" name="plantcode" id="plantcode" value='+plantcode+'><input type="hidden" name="username" id="username" value='+username+'><input type="hidden" name="rowcount" id="rowcount" value='+rowId+'><input type="hidden"><td><input type="hidden"></td><td><input type="hidden"></td><td><select class="form-control" name="adjustment_type'+rowId+'" id="adjustment_type-'+rowId+j+'" onchange="adjustment_type(this.id)"><option value="Positive">Positive</option><option value="Negative">Negative</option></select></td><td><input type="text" class="form-control" style="width: 140px;"  name="adjustment_smo'+rowId+'" id="adjustment_smo-'+rowId+j+'" value="0" onclick="working_hours(this.id)" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control" style="width: 100px;"  name="working_hours_min'+rowId+'[]" id="working_hours_min-'+rowId+j+'" onclick="working_hours(this.id)" value="0" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control"  style="width: 100px;"  name="adjustment_min'+rowId+'[]" id="adjustment_min-'+rowId+j+'" readonly></td><td><input type="text" class="form-control" style="width: 100px;" name="adjustment_hours'+rowId+'" id="adjustment_hours-'+rowId+j+'" readonly></td><td><button type="button" name="remove" id="'+rowId+j+'" class="btn btn-danger btn_remove" ><span class="glyphicon glyphicon-minus"></span></button></td></tr>'); 

						    $('#adjustment_smo-'+rowId+j).on('mouseenter', function() {
							var adjustment_smo=$(this).val();
							if(adjustment_smo==0){
								$(this).val('');
							}
							});
							
							$('#adjustment_smo-'+rowId+j).on('mouseleave', function() {
								
							var adjustment_smo=$(this).val();
							if(adjustment_smo==0){
								$(this).val('0');
							}
							$('#working_hours_min-'+rowId+j).on('mouseenter', function() {
							var working_hours_min=$(this).val();
							if(working_hours_min==0){
								$(this).val('');
							}
							});
							$('#working_hours_min-'+rowId+j).on('mouseleave', function() {
							var working_hours_min=$(this).val();
							if(working_hours_min==0){
								$(this).val('0');
							}
							});
						   
						}); 
					}); 
				}
				$(document).on('click', '.btn_remove', function(){  
					var button_id = $(this).attr("id");   
					$('#row'+button_id+'').remove();  
				});  
		
				$('#submit').click(function(){ 

				var tbl = $('#dynamic_field tr:has(td)').map(function(i, v) {
				var $td =  $('td input', this);
				var $td2 =  $('input', this);
				var $td1 =  $('td', this);
					return {
							// module:$(this).closest('tr').children('td:eq(0)').text().trim(),
							// 	present_emp: $td.eq(0).val(),
							// 	jumper: $td.eq(1).val(),
							// 	adjustment_type: $(this).find("select").val(),
							// 	adjustment_smo: $td.eq(2).val(),
							// 	working_min: $td.eq(3).val(),
							// 	adjustment_min: $td.eq(4).val(),
							// 	adjustment_hours: $td.eq(5).val()
							module:$('input', this).attr("id"),
								present_emp: $td.eq(1).val(),
								jumper: $td.eq(2).val(),
								plantcode:$td2.eq(2).val(),
							    username:$td2.eq(3).val(),
								adjustment_type: $(this).find("select").val(),
								adjustment_smo: $td.eq(3).val(),
								working_min: $td.eq(4).val(),
								adjustment_min: $td.eq(5).val(),
								adjustment_hours: $td.eq(6).val(),
								parent_id: $td2.eq(4).val(),
							//module:$td2.eq(0).att7r("id"),
						
								
								
											
							}
							}).get();
							var postData = JSON.stringify(tbl);
// alert(postData);
                   var module1 = $('input', this).attr("id");
				 
					
					
					var date1=$('#demo1').val();
					var team=$('#team').val();
					var plantcode=$('#plantcode').val();
					var url="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>";
					$.ajax({  
							url:url,  
							method:"POST",  
							data:{'data':postData,'date1':date1,'team':team,'module':module1,'plantcode':plantcode},  
							success:function(data)  
							{  
								
								
							} 
								
					});  

			 $('#loading-image').show();
             $('#submit').hide();	
			 $('#dynamic_field').hide();		
      });  
	  $('#dynamic_field tr').each(function() {
							var button_id1 = $(this).attr("class"); 	
							var rowId1= ($(this).attr('class').split('-')[1]);
							$(document).on('change','#adjustment_type'+rowId1,function(){
							var type= $(this).val();
							if(type=='Positive'){
								var adjustment_min = $('#adjustment_min'+rowId1).val().replace('-', '');
								var adjustment_hours = $('#adjustment_hours'+rowId1).val().replace('-', '');
								$('#adjustment_min'+rowId1).val(adjustment_min);
								$('#adjustment_hours'+rowId1).val(adjustment_hours);
							}
							 if(type=='Negative'){
								
								var adjustment_min1 = $('#adjustment_min'+rowId1).val();
								var adjustment_hours1 = $('#adjustment_hours'+rowId1).val();
								$('#adjustment_min'+rowId1).val('-'+adjustment_min1);
								$('#adjustment_hours'+rowId1).val('-'+adjustment_hours1);
							}
							
							}); 
						
							$('#adjustment_smo'+rowId1).on('change', function() {
							var adjustment1= $('#adjustment_smo'+rowId1).val();
							var work1= $('#working_hours_min'+rowId1).val();
							var type= $('#adjustment_type'+rowId1).val();
							if(type=='Negative'){
							var final_adjustment_min=Number(adjustment1)*Number(work1);
							$('#adjustment_min'+rowId1).val('-'+final_adjustment_min);
							var hours= $('#adjustment_min'+rowId1).val();
							var final_hours=Number(hours/60).toFixed(2);
							$('#adjustment_hours'+rowId1).val(final_hours);
							}
							if(type=='Positive'){
							var final_adjustment_min=Number(adjustment1)*Number(work1);
							$('#adjustment_min'+rowId1).val(final_adjustment_min);
							var hours= $('#adjustment_min'+rowId1).val();
							var final_hours=Number(hours/60).toFixed(2);
							$('#adjustment_hours'+rowId1).val(final_hours);
							}
							
						    });
						    $('#working_hours_min'+rowId1).on('change', function() {
							var adjustment1= $('#adjustment_smo'+rowId1).val();
							var work1= $('#working_hours_min'+rowId1).val();
							var type= $('#adjustment_type'+rowId1).val();
							if(type=='Negative'){
							var final_adjustment_min=Number(adjustment1)*Number(work1);
							$('#adjustment_min'+rowId1).val('-'+final_adjustment_min);
							var hours= $('#adjustment_min'+rowId1).val();
							var final_hours=Number(hours/60).toFixed(2);
							$('#adjustment_hours'+rowId1).val(final_hours);
							}
							if(type=='Positive'){
							var final_adjustment_min=Number(adjustment1)*Number(work1);
							$('#adjustment_min'+rowId1).val(final_adjustment_min);
							var hours= $('#adjustment_min'+rowId1).val();
							var final_hours=Number(hours/60).toFixed(2);
							$('#adjustment_hours'+rowId1).val(final_hours);
							}

						     });	
							$('#adjustment_smo'+rowId1).on('mouseenter', function() {
							var adjustment_smo=$(this).val();
							if(adjustment_smo==0){
								$(this).val('');
							}
							});
							
							$('#adjustment_smo'+rowId1).on('mouseleave', function() {
								
							var adjustment_smo=$(this).val();
							if(adjustment_smo==0){
								$(this).val('0');
							}
							});
						
							$('#working_hours_min'+rowId1).on('mouseenter', function() {
							var working_hours_min=$(this).val();
							if(working_hours_min==0){
								$(this).val('');
							}
							});
							$('#working_hours_min'+rowId1).on('mouseleave', function() {
							var working_hours_min=$(this).val();
							if(working_hours_min==0){
								$(this).val('0');
							}
							});
							$('#jumper'+rowId1).on('mouseenter', function() {
							var jumper=$(this).val();
							if(jumper==0){
								$(this).val('');
							}
							});
							$('#jumper'+rowId1).on('mouseleave', function() {
							var jumper=$(this).val();
							if(jumper==0){
								$(this).val('0');
							}
							});
							$('#pra'+rowId1).on('mouseenter', function() {
							var present=$(this).val();
							if(present==0){
								$(this).val('');
							}
							});
							$('#pra'+rowId1).on('mouseleave', function() {
							var present=$(this).val();
							if(present==0){
								$(this).val('0');
							}
							});
												 		
							
	                	
	  });
	 
		           
 });  

function validateQty1(e,t) 
{
	if(e.keyCode == 13)
			return;
		var p = String.fromCharCode(e.which);
		var c = /^[0-9]+$/;
		var v = document.getElementById(t.id);
		if( !(v.value.match(c)) && v.value!=null ){
			v.value = '';
			return false;
		}
		return true;
}
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
 </script>
