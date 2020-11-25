<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    $has_permission=haspermission($_GET['r']);
	$team=$_POST['team'];
	$date=$_POST['dat'];
	$shift_start=$_POST['shift_start'];
	$shift_end=$_POST['shift_end'];
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
		<form method="POST" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" >
				<div class='col-md-2 col-sm-3 col-xs-12'>
					Select Date: <input id="demo1" type="text" class="form-control datepicker"  size="10" name="dat"  value=<?php if($date<>"") {echo $date; } else {echo date("Y-m-d");} ?>>
				</div>
			
				<div class='col-md-2 col-sm-3 col-xs-12'>
					Select Team : 
					<select name="team" id="team" class="select2_single form-control" required>
						<option value=''>Please Select</option>
						<?php 
						for ($i=0; $i < sizeof($shifts_array); $i++)
						{
						?>
						<option  <?php echo 'value="'.$shifts_array[$i].'"'; if($team==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
						<?php 
										}
										
						?>
					</select>
				</div>
				<?php
					$plant_timings_array=array();
					$sql1="select time_value as plant_time,start_time,end_time FROM $bai_pro3.tbl_plant_timings order by time_value*1";
					$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$value='';
						$plant_timings_array[]=$sql_row1['plant_time'];
						$plant_timings_start[]=$sql_row1['start_time'];
						$data=explode(":",$sql_row1['end_time']);
						for($i=0;$i<sizeof($data);$i++)
						{
							if($i==0)
							{
								$value .= $data[$i];
							}
							else
							{
								if($data[$i]=='59')
								{									
									$value .= ":00";
								}
								else
								{
									$value .= ":".($data[$i]+1);
								}								
							}
						}
						$plant_timings_end[]=$value;
					}
				?>

				<div class='col-md-2 col-sm-3 col-xs-12'>
					Select Shift Start Time: 
					<select name="shift_start" id="shift_start"  class="select2_single form-control" required>
						<option value=''>Please Select</option>
						<?php 
							for ($i=0; $i < sizeof($plant_timings_array); $i++)
							{
						?>
						<option  <?php echo 'value="'.$plant_timings_array[$i].'"'; if($shift_start==$plant_timings_array[$i]){ echo "selected";}   ?>><?php echo $plant_timings_start[$i]; ?></option>
						<?php 
							}
						?>
					</select>
			    </div>
				<div class='col-md-2 col-sm-3 col-xs-12'>
					Select Shift End Time:
					<select name="shift_end" id="shift_end" class="select2_single form-control" onchange="return check_hrs();" required>
						<option value=''>Please Select</option>
						<?php 
							for ($i=0; $i < sizeof($plant_timings_array); $i++)
							{
								?>
						<option  <?php echo 'value="'.$plant_timings_array[$i].'"'; if($shift_end==$plant_timings_array[$i]){ echo "selected";}   ?>><?php echo $plant_timings_end[$i]; ?></option>
								<?php 
							}
						?>
					</select>
				</div>

				<div class='col-md-2 col-sm-3 col-xs-12'>
					Break Hours(Min):
					<input name="break_hours" id="break_hours" class="break_hours form-control" value='<?php echo $breakhours; ?>' readonly>
					
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
	
	$get_modules = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1";
	$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
	$count= mysqli_num_rows($modules_result);
	if(mysqli_num_rows($modules_result) > 0)
	{
		while($module_row=mysqli_fetch_array($modules_result))
		{
			$modules_array[]=$module_row['module_name'];
			$modules_id_array[$module_row['module_name']]=$module_row['id'];
		}
	
		$modules = implode("','", $modules_array);

		$get_modules1 = "SELECT max(id) as max_id FROM $bai_pro3.`module_master` where status='Active'";
		$modules_result1=mysqli_query($link, $get_modules1) or exit ("Error while fetching modules: $get_modules");
		
		while($module_row1=mysqli_fetch_array($modules_result1))
			{
				$max_id=$module_row1['max_id'];
			}

		$sql1="SELECT * FROM $bai_pro.pro_attendance where  date='$date' AND shift='$shift' AND module IN ('$modules')  order by pro_attendance.module*1 ";
		
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
		$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result1);
				if($sql_num_check>0)
				{
					echo"</tr>";
					$get_modules2 = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1";
					$modules_result2=mysqli_query($link, $get_modules2) or exit ("Error while fetching modules: $get_modules");
					
						while($module_row2=mysqli_fetch_array($modules_result2))
						{
							$modules1=$module_row2['module_name'];
							$sql4="SELECT * FROM $bai_pro.pro_attendance where  date='$date' AND shift='$shift' AND module = '$modules1'  order by pro_attendance.module*1 ";
						
						$sql_result2=mysqli_query($link, $sql4) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql_num_check3=mysqli_num_rows($sql_result2);
						if($sql_num_check3>0)
						{
					while($sql_row1=mysqli_fetch_array($sql_result2))
					{
						$atten_id=$sql_row1['atten_id'];
						$date=$sql_row1['date'];
						$shift=$sql_row1['shift'];
						$avail_av=$sql_row1['present'];
						$absent_ab=$sql_row1['absent'];
						$jumper=$sql_row1['jumper'];
						$break_hours=$sql_row1['break_hours'];
						$module=$sql_row1['module'];

					}
				}else{
					$avail_av='0';
						$absent_ab='0';
						$jumper='0';
				}
					
					

							$sql3="SELECT * FROM $bai_pro.pro_attendance_adjustment where id in(SELECT MIN(id) FROM $bai_pro.pro_attendance_adjustment WHERE module='$module' AND shift='$shift' AND DATE='$date' ) order by module*1 ";
							//echo $sql3;
							$sql_result2=mysqli_query($link, $sql3) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row2=mysqli_fetch_array($sql_result2))
					         {
								$adjustment_type=$sql_row2['adjustment_type'];
								$adjustment_smo=$sql_row2['smo'];
								$working_hours_min=$sql_row2['smo_minutes'];
								$adjustment_min=$sql_row2['smo_adjustment_min'];
								$adjustment_hours=$sql_row2['smo_adjustment_hours'];

							 }
							

							
						
						$k=$modules_id_array[$modules1];
						echo "<tr id='dynamic$k' class='dynamic-$k'>
								<td>".$modules1."</td>"; 
								if(in_array($authorized,$has_permission))
								{
									$readonly = ''; ?>
									<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>" id="add_name">
									<?php
										echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
										echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
										echo "<input type=\"hidden\" name=\"shift_start_time\" value=\"$shift_start_time\">";
										echo "<input type=\"hidden\" name=\"shift_end_time\" value=\"$shift_end_time\">";	
										echo "<input type=\"hidden\" name=\"break_hours\" value=\"$break_hours\">";		
								}
								else
								{
									$readonly = 'readonly';
								}
							?>						
								<input type="hidden"  name="count" id="count"  value=<?php echo $max_id ?>>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" readonly style="width: 100px;" value="<?php echo $avail_av; ?>" name="pra<?php echo $k; ?>"  id="pra<?php echo $k; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $jumper; ?>" name="jumper<?php echo $k; ?>" id="jumper<?php echo $k; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><select  id="adjustment_type<?php echo $k; ?>" class="form-control" name="adjustment_type<?php echo $k; ?>" >
								<option value="Positive" <?php if($adjustment_type == "Positive") { echo "SELECTED"; } ?>>Positive</option>
								<option value="Negative" <?php if($adjustment_type == "Negative") { echo "SELECTED"; } ?>>Negative</option>	
							     </select></td>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" <?php echo $readonly; ?> style="width: 130px;" value="<?php echo $adjustment_smo; ?>" name="adjustment_smo<?php echo $k; ?>" id="adjustment_smo<?php echo $k; ?>" onclick=" working_hours()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" onkeyup="validateQty1(event,this);" <?php echo $readonly; ?> style="width: 130px;" value="<?php echo $working_hours_min; ?>" name="working_hours_min<?php echo $k; ?>" id="working_hours_min<?php echo $k; ?>" onclick=" working_hours()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $adjustment_min; ?>" name="adjustment_min<?php echo $k; ?>" id="adjustment_min<?php echo $k; ?>" readonly></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $adjustment_hours; ?>" name="adjustment_hours<?php echo $k; ?>" id="adjustment_hours<?php echo $k; ?>" readonly></td>
								<td><button type="button" name="add" id="add-<?php echo $k; ?>" class="btn btn-success"> <span class="glyphicon glyphicon-plus"></span></button></td>  
								<?php
							echo"</tr>";
							
						}
					echo "</table>";
		        if(in_array($authorized,$has_permission))
					{ ?>
					<?php
						
					?>	
					<?php
					   $get_working_days="SELECT date AS pre_date,SUM(present) AS present FROM $bai_pro.pro_attendance WHERE date<DATE(NOW()) GROUP BY date HAVING present>0 ORDER BY date DESC LIMIT 1";
					   $result_get_working_day=mysqli_query($link, $get_working_days) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					   while($sql_row11=mysqli_fetch_array($result_get_working_day))
								 {
								 $final_date=$sql_row11['pre_date'];
  
								 }
								
								if($date==$final_date || $now_date==$date){
									echo'<input type="submit" id="submit" class="btn btn-primary" value="Submit" >';
								}
								echo $final_date;
					}
				
					echo "</form>";
				}
				else
				{
					
					for($i=0;$i<sizeof($modules_array);$i++) 
					{ 
						$k=$modules_id_array[$modules_array[$i]];
						?>
						<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>" id="add_name">
							<tr id='dynamic<?php echo $k; ?>' class='dynamic-<?php echo $k; ?>'>
								<td> <?php echo trim($modules_array[$i]); ?> </td>
								<?php 
								while($sql_row1=mysqli_fetch_array($sql_result1))
								{
								$avail_av=$sql_row1['present'];
								}
						?>

						         <input type="hidden"  name="count" id="count"  value=<?php echo $max_id; ?>>
								<td><input type="text" onkeyup="validateQty1(event,this);" class="form-control" style="width: 100px;" readonly value="0" name="pra<?php echo $k; ?>"  id="pra<?php echo $k; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" onkeyup="validateQty1(event,this);"  class="form-control" style="width: 100px;"value="0" name="jumper<?php echo $k; ?>" id="jumper<?php echo $k; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><select class="form-control"name="adjustment_type<?php echo $k; ?>" id="adjustment_type<?php echo $k; ?>">
								<option value="Positive">Positive</option>
								<option value="Negative">Negative</option>
								</select></td>
								<td><span id="addsymbol"></span><input type="text" class="form-control" style="width: 140px;"value="0" name="adjustment_smo<?php echo $k; ?>" id="adjustment_smo<?php echo $k; ?>" onkeyup="validateQty1(event,this);"  onclick=" working_hours()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="working_hours_min<?php echo $k; ?>" id="working_hours_min<?php echo $k; ?>" onclick=" working_hours()" onkeyup="validateQty1(event,this);" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="adjustment_min<?php echo $k; ?>" id="adjustment_min<?php echo $k; ?>" readonly></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="adjustment_hours<?php echo $k; ?>" id="adjustment_hours<?php echo $k; ?>" readonly></td>
								<td><button type="button" name="add" id="add-<?php echo $k; ?>" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>  
							</tr>
						<?php
					}
					echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
					echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
					echo "<input type=\"hidden\" name=\"shift_start_time\" value=\"$shift_start_time\">";
					echo "<input type=\"hidden\" name=\"shift_end_time\" value=\"$shift_end_time\">";
					echo "<input type=\"hidden\" name=\"break_hours\" value=\"$break_hours\">";
					 ?>
					 </table>
					 <?php
					 $get_working_days="SELECT date AS pre_date,SUM(present) AS present FROM $bai_pro.pro_attendance WHERE date<DATE(NOW()) GROUP BY date HAVING present>0 ORDER BY date DESC LIMIT 1";
					 // var_dump($get_working_days);
					 $result_get_working_day=mysqli_query($link, $get_working_days) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($sql_row11=mysqli_fetch_array($result_get_working_day))
							   {
							   $final_date=$sql_row11['pre_date'];

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
	var shift = $('#team option:selected').text();
	var params =[shift,date];

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
						var starttime = data[0]["start_time"];
						var endtime = data[0]["end_time"];
						$("#shift_start").val(starttime);
						$("#shift_end").val(endtime);
						}

                         
					}
			  });

   });
		var date1=$('#demo1').val();
		var team = $('#team option:selected').text();
		var params1 =[date1,team];
	
	   

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
							for(var i=0;i<data.length;i++)
							
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

								
								var add_row ='<tr id="row'+data[i]['id']+i+'" class="dynamic-'+data[i]['id']+'"><td>'+data[i]['module']+'</td></td><td><input type="hidden"></td><td><input type="hidden"></td><td><select class="form-control" name="adjustment_type'+data[i]['module']+'" id="adjustment_type-'+data[i]['id']+i+'" onchange="adjustment_type(this.id)"><option value="Positive" '+select+'>Positive</option><option value="Negative" '+select1+'>Negative</option></select></td><td><input type="text" class="form-control" style="width: 130px;"  name="adjustment_smo'+data[i]['smo']+'" id="adjustment_smo-'+data[i]['id']+i+'" value='+data[i]['smo']+' onclick=" working_hours(this.id);" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control" style="width: 130px;"  name="working_hours_min'+data[i]['smo_minutes']+'[]" id="working_hours_min-'+data[i]['id']+i+'"  value='+data[i]['smo_minutes']+' onclick=" working_hours(this.id);" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control"  style="width: 100px;"  name="adjustment_min'+data[i]['smo_adjustment_min']+'[]" id="adjustment_min-'+data[i]['id']+i+'" value='+data[i]['smo_adjustment_min']+' readonly></td><td><input type="text" class="form-control" style="width: 100px;" name="adjustment_hours'+data[i]['smo_adjustment_hours']+'" id="adjustment_hours-'+data[i]['id']+i+'" value='+data[i]['smo_adjustment_hours']+' readonly></td><td><button type="button" name="remove" id="'+data[i]['id']+i+'" class="btn btn-danger btn_remove"><span class="glyphicon glyphicon-minus" ></span></button></td><td style="visibility:hidden;">'+data[i]['module']+'</td></tr>';

								$('#dynamic'+data[i]['id']).after(add_row);
						
							}
		

						}

                   }

              });


	 
	         var rowCount = $('#dynamic_field tr').length;
			 var max_id=$('#count').val();
			
			 var k=2;
				for(var i=0; i<=max_id; i+=1){
					
					$('#add-'+i).click(function(){ 
						k++;
						var j='new'+k;
						var td1 =  $(this).closest('tr').children('td:eq(0)').text().trim();
						var rowId = (this.id.split('add-')[1] );
						$('#dynamic'+rowId).after('<tr id="row'+rowId+j+'" class="dynamic-'+rowId+'"><td>'+td1+'</td></td><td><input type="hidden"></td><td><input type="hidden"></td><td><select class="form-control" name="adjustment_type'+rowId+'" id="adjustment_type-'+rowId+j+'" onchange="adjustment_type(this.id)"><option value="Positive">Positive</option><option value="Negative">Negative</option></select></td><td><input type="text" class="form-control" style="width: 140px;"  name="adjustment_smo'+rowId+'" id="adjustment_smo-'+rowId+j+'" value="0" onclick="working_hours(this.id)" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control" style="width: 100px;"  name="working_hours_min'+rowId+'[]" id="working_hours_min-'+rowId+j+'" onclick="working_hours(this.id)" value="0" onkeypress="return isNumberKey(event)"></td><td><input type="text" class="form-control"  style="width: 100px;"  name="adjustment_min'+rowId+'[]" id="adjustment_min-'+rowId+j+'" readonly></td><td><input type="text" class="form-control" style="width: 100px;" name="adjustment_hours'+rowId+'" id="adjustment_hours-'+rowId+j+'" readonly></td><td><button type="button" name="remove" id="'+rowId+j+'" class="btn btn-danger btn_remove" ><span class="glyphicon glyphicon-minus"></span></button></td><td style="visibility:hidden;">'+rowId+'</td></tr>'); 

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
				var $td1 =  $('td', this);
		
					return {
							module:$(this).closest('tr').children('td:eq(0)').text().trim(),
								present_emp: $td.eq(0).val(),
								jumper: $td.eq(1).val(),
								adjustment_type: $(this).find("select").val(),
								adjustment_smo: $td.eq(2).val(),
								working_min: $td.eq(3).val(),
								adjustment_min: $td.eq(4).val(),
								adjustment_hours: $td.eq(5).val()
								
											
							}
							}).get();
							var postData = JSON.stringify(tbl);

                   var module1 = $(this).closest('tr').children('td:eq(0)').text();
				 
					
					
					var date1=$('#demo1').val();
					var team=$('#team').val();
					var url="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>";
					$.ajax({  
							url:url,  
							method:"POST",  
							data:{'data':postData,'date1':date1,'team':team,'module':module1},  
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
							//alert(adjustment1);
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