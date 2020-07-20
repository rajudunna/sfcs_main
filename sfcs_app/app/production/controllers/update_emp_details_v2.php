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

 function working_hours(){
	var table = document.getElementById('dynamic_field');
	var rowLength = table.rows.length;
		
		$('#dynamic_field tr').each(function() {
		var button_id1 = $(this).attr("class"); 
		
		var rowId1= ($(this).attr('class').split('-')[1]);
		var table1= $('.dynamic-'+rowId1).length;
	    var rowLength = table1.length;
		 var adjustment= $('#adjustment_smo-'+rowId1).val();
		 //alert(table1);
		 var work= $('#working_hours_min-'+rowId1).val();
		 var adjustment1= $('#adjustment_smo'+rowId1).val();
		 var work1= $('#working_hours_min'+rowId1).val();
		 var final_adjustment_min_add=Number(adjustment)*Number(work);
		 var final_adjustment_min=Number(adjustment1)*Number(work1);
		 $('#adjustment_min'+rowId1).val(final_adjustment_min);
		 $('#adjustment_min-'+rowId1).val(final_adjustment_min_add);
		 var hours= $('#adjustment_min'+rowId1).val();
		 var hours1= $('#adjustment_min-'+rowId1).val();
		 var final_hours=Number(hours/60).toFixed(2);
		 var final_hours1=Number(hours1/60).toFixed(2);
		 $('#adjustment_hours'+rowId1).val(final_hours);
		 $('#adjustment_hours-'+rowId1).val(final_hours1);
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
					$sql1="select DISTINCT time_value as plant_time FROM $bai_pro3.tbl_plant_timings";
					$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$plant_timings_array[]=$sql_row1['plant_time'];
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
						<option  <?php echo 'value="'.$plant_timings_array[$i].'"'; if($shift_start==$plant_timings_array[$i]){ echo "selected";}   ?>><?php echo $plant_timings_array[$i] ?></option>
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
						<option  <?php echo 'value="'.$plant_timings_array[$i].'"'; if($shift_end==$plant_timings_array[$i]){ echo "selected";}   ?>><?php echo $plant_timings_array[$i] ?></option>
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
	$next_date = date('Y-m-d', strtotime($date .' +1 day'));
	$modules_array = array();	$modules_id_array=array();
	$get_modules = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1;";
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

		 $sql1="SELECT *,pro_attendance.module as module_name FROM bai_pro.pro_attendance LEFT JOIN bai_pro.pro_attendance_adjustment 
		 ON pro_attendance.module=pro_attendance_adjustment.module  AND pro_attendance.shift=pro_attendance_adjustment.shift  WHERE  pro_attendance_adjustment.id IN (SELECT MIN(id) FROM bai_pro.pro_attendance_adjustment WHERE module=pro_attendance.module AND shift='$shift' AND DATE='$date' ) and pro_attendance.date='$date' AND pro_attendance.shift='$shift' AND pro_attendance.module IN ('$modules') GROUP BY pro_attendance.module order by pro_attendance.module*1 ";
		//echo $sql1;
		echo "
		<table border=1 class='table table-bordered' id='dynamic_field'>
			<tr class='info' id='header'>
				<th style='text-align:center;'>Module</th>
				<th style='text-align:center;'>Present Emp</th>
				<th style='text-align:center;'>Jumper</th>
				<th style='text-align:center;'>Type</th>
				<th style='text-align:center;'>Adjustment SMO</th>
				<th style='text-align:center;'>Working Hours(min)</th>
				<th style='text-align:center;'>Adjustment(min)</th>
				<th style='text-align:center;'>Adjustment Hours</th><th></th>";
				$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result1);
				if($sql_num_check>0)
				{
					//echo "<th>Total</th>
					echo"</tr>";
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$atten_id=$sql_row1['atten_id'];
						$date=$sql_row1['date'];
						$avail_av=$sql_row1['present'];
						$absent_ab=$sql_row1['absent'];
						$jumper=$sql_row1['jumper'];
						$adjustment_type=$sql_row1['adjustment_type'];
						$break_hours=$sql_row1['break_hours'];
						$adjustment_smo=$sql_row1['smo'];
						$working_hours_min=$sql_row1['smo_minutes'];
						$adjustment_min=$sql_row1['smo_adjustment_min'];
						$adjustment_hours=$sql_row1['smo_adjustment_hours'];
						$module=$sql_row1['module_name'];
						$k=$modules_id_array[$module];
						echo "<tr id='dynamic$k' class='dynamic-$k'>
								<td>".$module."</td>"; 
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
								<input type="hidden"  name="count" id="count"  value=<?php echo $k ?>>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $avail_av; ?>" name="pra<?php echo $k; ?>"  id="pra<?php echo $k; ?>"></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $jumper; ?>" name="jumper<?php echo $k; ?>" id="jumper<?php echo $k; ?>"></td>
								<td><select  id="adjustment_type<?php echo $k; ?>" class="form-control" name="adjustment_type<?php echo $k; ?>" >
								<option value="Positive" <?php if($adjustment_type == "Positive") { echo "SELECTED"; } ?>>Positive</option>
								<option value="Negative" <?php if($adjustment_type == "Negative") { echo "SELECTED"; } ?>>Negative</option>	
							     </select></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 130px;" value="<?php echo $adjustment_smo; ?>" name="adjustment_smo<?php echo $k; ?>" id="adjustment_smo<?php echo $k; ?>" onchange=" working_hours()"></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 130px;" value="<?php echo $working_hours_min; ?>" name="working_hours_min<?php echo $k; ?>" id="working_hours_min<?php echo $k; ?>" onchange=" working_hours()"></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $adjustment_min; ?>" name="adjustment_min<?php echo $k; ?>" id="adjustment_min<?php echo $k; ?>" readonly></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 100px;" value="<?php echo $adjustment_hours; ?>" name="adjustment_hours<?php echo $k; ?>" id="adjustment_hours<?php echo $k; ?>" readonly></td>
								<td><button type="button" name="add" id="add-<?php echo $k; ?>" class="btn btn-success"> <span class="glyphicon glyphicon-plus"></span></button></td>  
								<?php
							echo"</tr>";
					}
		        if(in_array($authorized,$has_permission))
					{ ?>
					<?php
						
					?>	
					<?php
					  $get_working_days="select *  FROM $pms.plant_calendar where plant_code='$facility_code' and calendar_date>=\"$next_date\"  and day_status='Working Day' limit 1";
					  
					  $result_get_working_day=mysqli_query($link, $get_working_days) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					  while($sql_row11=mysqli_fetch_array($result_get_working_day))
								{
								$final_date=$sql_row11['calendar_date'];

								}
								
								if($now_date==$final_date || $now_date==$date){
									echo'<tr>
									<th colspan=9><input type="submit" id="submit" class="btn btn-primary" value="Submit" onclick="disableButton()"> </th>
									 </tr>';
								}
					
			           ?>	
						
						 <?php
					}
					echo "</table>";
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

						         <input type="hidden"  name="count" id="count"  value=<?php echo $count; ?>>
								<td><input type="text" class="form-control" style="width: 100px;" value="0" name="pra<?php echo $k; ?>"  id="pra<?php echo $k; ?>"></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="jumper<?php echo $k; ?>" id="jumper<?php echo $k; ?>"></td>
								<td><select class="form-control"name="adjustment_type<?php echo $k; ?>" id="adjustment_type<?php echo $k; ?>">
								<option value="Positive">Positive</option>
								<option value="Negative">Negative</option>
								</select></td>
								<td><input type="text" class="form-control" style="width: 140px;"value="0" name="adjustment_smo<?php echo $k; ?>" id="adjustment_smo<?php echo $k; ?>"></td>
								<td><input type="text" class="form-control" style="width: 100px;"value="0" name="working_hours_min<?php echo $k; ?>" id="working_hours_min<?php echo $k; ?>" onchange=" working_hours()"></td>
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
					 <?php
					 
					 $get_working_days="select *  FROM $pms.plant_calendar where plant_code='$facility_code' and calendar_date>=\"$next_date\"  and day_status='Working Day' limit 1";
					 $result_get_working_day=mysqli_query($link, $get_working_days) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($sql_row11=mysqli_fetch_array($result_get_working_day))
							   {
							   $final_date=$sql_row11['calendar_date'];

							   }
							    
							   if($now_date==$final_date ||$now_date==$date){
								   echo'<tr>
								   <th colspan=9><input type="submit" id="submit" class="btn btn-primary" value="Submit" onclick="disableButton()"> </th>
									</tr>';
							   }
			
	
			         ?>	
				
				
		          </table>
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
					//console.log(response);
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

								//$('#adjustment_type-'+data[i]['id']).val(data[i]['adjustment_type']);
								
								var add_row ='<tr id="row'+data[i]['id']+'" class="dynamic-'+data[i]['id']+'"><td>'+data[i]['module']+'</td></td><td><input type="hidden"></td><td><input type="hidden"></td><td><select class="form-control" name="adjustment_type'+data[i]['module']+'" id="adjustment_type-'+data[i]['id']+'"><option value="Positive" '+select+'>Positive</option><option value="Negative" '+select1+'>Negative</option></select></td><td><input type="text" class="form-control" style="width: 130px;"  name="adjustment_smo'+data[i]['smo']+'" id="adjustment_smo-'+data[i]['module']+'" value='+data[i]['smo']+' onchange=" working_hours()"></td><td><input type="text" class="form-control" style="width: 130px;"  name="working_hours_min'+data[i]['smo_minutes']+'[]" id="working_hours_min-'+data[i]['module']+'" onchange=" working_hours()" value='+data[i]['smo_minutes']+' onchange=" working_hours()"></td><td><input type="text" class="form-control"  style="width: 100px;"  name="adjustment_min'+data[i]['smo_adjustment_min']+'[]" id="adjustment_min-'+data[i]['module']+'" value='+data[i]['smo_adjustment_min']+' readonly></td><td><input type="text" class="form-control" style="width: 100px;" name="adjustment_hours'+data[i]['smo_adjustment_hours']+'" id="adjustment_hours-'+data[i]['module']+'" value='+data[i]['smo_adjustment_hours']+' readonly></td><td><button type="button" name="remove" id="'+data[i]['id']+'" class="btn btn-danger btn_remove"><span class="glyphicon glyphicon-minus"></span></button></td><td style="visibility:hidden;">'+data[i]['module']+'</td></tr>';

								$('#dynamic'+data[i]['id']).after(add_row);
						
							}
		

						}

                   }

              });


	 
	         var rowCount = $('#dynamic_field tr').length;
				for(var i=0; i<=rowCount-2; i+=1){
					$('#add-'+i).click(function(){  
						var td1 =  $(this).closest('tr').children('td:eq(0)').text().trim();
						var rowId = (this.id.split('add-')[1] );
						$('#dynamic'+rowId).after('<tr id="row'+rowId+'" class="dynamic-'+rowId+'"><td>'+td1+'</td></td><td><input type="hidden"></td><td><input type="hidden"></td><td><select class="form-control" name="adjustment_type'+rowId+'" id="adjustment_type-'+rowId+'"><option value="Positive">Positive</option><option value="Negative">Negative</option></select></td><td><input type="text" class="form-control" style="width: 140px;"  name="adjustment_smo'+rowId+'" id="adjustment_smo-'+rowId+'" value="0"></td><td><input type="text" class="form-control" style="width: 100px;"  name="working_hours_min'+rowId+'[]" id="working_hours_min-'+rowId+'" onchange="working_hours()" value="0"></td><td><input type="text" class="form-control"  style="width: 100px;"  name="adjustment_min'+rowId+'[]" id="adjustment_min-'+rowId+'" readonly></td><td><input type="text" class="form-control" style="width: 100px;" name="adjustment_hours'+rowId+'" id="adjustment_hours-'+rowId+'" readonly></td><td><button type="button" name="remove" id="'+rowId+'" class="btn btn-danger btn_remove"><span class="glyphicon glyphicon-minus"></span></button></td><td style="visibility:hidden;">'+rowId+'</td></tr>'); 

						    $('#adjustment_smo-'+rowId).on('mouseenter', function() {
							var adjustment_smo=$(this).val();
							if(adjustment_smo==0){
								$(this).val('');
							}
							});
							
							$('#adjustment_smo-'+rowId).on('mouseleave', function() {
								
							var adjustment_smo=$(this).val();
							if(adjustment_smo==0){
								$(this).val('0');
							}
							$('#working_hours_min-'+rowId).on('mouseenter', function() {
							var working_hours_min=$(this).val();
							if(working_hours_min==0){
								$(this).val('');
							}
							});
							$('#working_hours_min-'+rowId).on('mouseleave', function() {
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
							//alert(postData);

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
		
      });  
	  $('#dynamic_field tr').each(function() {
							var button_id1 = $(this).attr("class"); 	
							var rowId1= ($(this).attr('class').split('-')[1]);
							// $(document).on('change','#adjustment_type'+rowId1,function(){
							// var adjustment_smo=$('#adjustment_smo'+rowId1).val();
							// var type= $(this).val();
							// if(type=='Positive'){
							// 	$('#adjustment_smo'+rowId1).val('+'+adjustment_smo);
							// }
							//  if(type=='Negative'){
							
							// 	$('#adjustment_smo'+rowId1).val('-'+adjustment_smo);
							// }
							
							// }); 	
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

//  $('#submit').on('click', function(){
                
//                 $('#submit').attr("disabled", true);
				
//             });
 </script>