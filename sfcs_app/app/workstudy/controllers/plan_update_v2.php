<html>
<head>
<?php
// include();
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
  $view_access=user_acl("SFCS_0170",$username,1,$group_id_sfcs); 
$auth_users=user_acl("SFCS_0170",$username,7,$group_id_sfcs);
$super_user=user_acl("SFCS_0170",$username,33,$group_id_sfcs); 
$has_permission = haspermission($_GET['r']);
?>
<style>
body{
	font-family: Trebuchet MS;
}
#bottom_div{
	margin: 5px 0 0 0;
    float: right;
}
th,td
{
	text-align:center;
}
table input{
		border: none;
	background: #c6c6cc;
    color: black;
    text-align: center;
	}


.hidet{
	/* display:none; */
}
#top_div{
	float: right;
    margin: 8px 0 0 0;
}
</style>
<script>
function enableButton() 
{
	// auto_cal_clh(x);
	
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

function auto_cal_clh(){
	var first_val=document.getElementById("outer_hid").value;
	var shift_val=document.getElementById("shift_details").value;
	
	var shift_det = shift_val.split(",");
	// alert(first_val);
	for(var ii=0;ii<first_val;ii++)
	{
	
		for(var i=0;i<shift_det.length;i++)
		{
			
			var a_val=document.getElementById("an_"+shift_det[i]+"_"+ii).value;
			// alert(a_val);
			var b_val=document.getElementById("ah_"+shift_det[i]+"_"+ii).value;
			
			var res=a_val*b_val;
			document.getElementById("ac_"+shift_det[i]+"_"+ii).value=res;
		}
	}
	swal('Clock hours Updated.....!','','success');
}

</script>

</head>
<body>
	<div class="panel panel-primary" id="main_div">
	<div class="panel-heading">Update Plan Efficiency</div>
		<div class="panel-body">
		<form method="post" name="test" id="update_form">
			<div class="row">
				<div class="col-md-3"><label>Select Date </label>
					<input type="text" data-toggle="datepicker" onchange="return verify_date();"  class="form-control" id="dat1" name="date" value="<?php  if(isset($_POST['date'])) { echo $_POST['date']; } else { echo date("Y-m-d"); } ?>"></div>
					<div class="col-md-2" style="padding-top: 20px;"><input type="submit" id='btn'  class="btn btn-primary" value="Submit" name="submit" id='sub'>
				</div	>
			</div>
		</form>
	</div>
	</div>
	<br/>
	<?php 
	
	    if(isset($_POST['submit']))
		{
		  $date=$_POST['date'];	
	
		  ?>
		<div class='row'>
		  <div class='panel panel-primary'>
			<div class='panel-heading'>
				<b>Daily Plan Updation Interface</b>
			</div>
			<div class='panel-body' style='overflow: scroll;height: 616px;'>
			<form method="post" action="<?php echo getFullURL($_GET['r'], "plan_update_v2.php", "N"); ?>">
			<?php
			 echo '<input type="hidden" name="date_ref" value="'.$date.'" size="8"/>';  
			    echo '<p align=right><strong><a class="btn btn-primary btn-xs" href="'.getFullURL($_GET['r'], "plan_update_view.php", "N").'">Plan Review >><strong></a></p>';

			?>

			<table style="padding:0" class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'>
				<thead>
                	<tr>
					 <th rowspan="2">Module</th>
                     <th rowspan="2">Section</th>
					<?php 

						$ab="";
						foreach ($shifts_array as $key => $value) {
							echo "<th colspan='6'>Team {$value}</th>";
							$ab.="<th>Fixed NOP</th>
							<th>Plan Eff</th>
							<th>Plan Pro</th>
							<th>Plan Sah</th>
							<th>Plan Clock Hours</th> 
							<th>Plan Hours</th>";
						}	
						echo "</tr><tr>".$ab."</tr>";
						// $shif_codes=implode(',',$shifts_array); 
						// echo "dflshdsfl".$shif_codes; 
						
					?>
				  </tr>
				  </thead>
					 <?php 
					 $table_data="select * from bai_pro.`tbl_freez_plan_log` where date='$date'";
						//  echo  $table_data."<br>";
						$selectRes=mysqli_query($link,$table_data) or exit($table_data."Error at something");
						while( $row = mysqli_fetch_assoc( $selectRes ))
						{
						
							$data_array_eff[$row['mod_no']][$row['shift']] = $row['plan_eff'];
							$data_array_pro[$row['mod_no']][$row['shift']] = $row['plan_pro'];
							$data_array_pchrs[$row['mod_no']][$row['shift']] = $row['plan_clh'];
							$data_array_sah[$row['mod_no']][$row['shift']] = $row['plan_sah'];
							$data_array_nop[$row['mod_no']][$row['shift']] = $row['nop'];
							$data_array_mod[]=$row['mod_no'];					
						}	
					
						$table_data1="select * from bai_pro3.`module_master` where status='Active' order by module_name*1";
					// echo $table_data1.'<br>';
						$selectRes1=mysqli_query($link,$table_data1) or exit($table_data."Error at something");
						$num_rows = mysqli_num_rows($selectRes1);
						$j=0;
						echo '<input type="hidden" id="outer_hid" value="'.$num_rows.'">';
						echo '<input type="hidden" id="actyhrs" name="act_hours" value="'.$plant_hours.'">';
						echo '<input type="hidden" id="shift_details" value="'.implode(",",$shifts_array).'">';
						while($row1 = mysqli_fetch_assoc($selectRes1))
						{  			
							
							$mod_number=$row1['module_name'];
							$sec_no=$row1['section'];
							echo "<tr id='aa".$j."'>";
							echo '<td>'.$mod_number.'<input type="hidden" id="hidden" name="mod_no[]" value="'.$mod_number.'"></td>';
							echo '<td>'.$sec_no.'<input type="hidden" name="sec_no[]" class= "integer" value="'.$sec_no.'" size="3"></td>';

							// echo "<td>".$row1['section']."</td>";
							for($ii=0; $ii< count($shifts_array); $ii++){
							if($data_array_nop[$row1['module_name']][$shifts_array[$ii]]!=''){
							$nop=$data_array_nop[$row1['module_name']][$shifts_array[$ii]];
							}else{
								$nop=0;	
							}	
					
							if($data_array_eff[$row1['module_name']][$shifts_array[$ii]]!=''){
								$eff=$data_array_eff[$row1['module_name']][$shifts_array[$ii]];
								}else{
									$eff=0;	
								}
								
							// $eff=$data_array_eff[$row1['module_name']][$shifts_array[$ii]];
							if($data_array_pro[$row1['module_name']][$shifts_array[$ii]]!=''){
								$pro=$data_array_pro[$row1['module_name']][$shifts_array[$ii]];
								}else{
									$pro=0;	
								}
								if($data_array_sah[$row1['module_name']][$shifts_array[$ii]]){
									$sah=$data_array_sah[$row1['module_name']][$shifts_array[$ii]];
								}else{
									$sah=0;
								}
								if($data_array_pchrs[$row1['module_name']][$shifts_array[$ii]]){
									$pchrs=$data_array_pchrs[$row1['module_name']][$shifts_array[$ii]];
								}else{
									$pchrs=0;
								}
							
							
							$quotes = "''";
							echo '<td><input type="text" onfocus="if(this.value==0){this.value='.$quotes.'}" onblur="javascript: if(this.value=='.$quotes.'){this.value=0;}" class= "integer" id='."'an_$shifts_array[$ii]_".$j."'".' name="nop_'.$shifts_array[$ii].'[]" value="'.$nop.'"></td>';
							echo '<td><input type="text" onfocus="if(this.value==0){this.value='.$quotes.'}" onblur="javascript: if(this.value=='.$quotes.'){this.value=0;}" class= "float" name="eff_'.$shifts_array[$ii].'[]" value="'.$eff.'" size="4"></td>';
							echo '<td><input type="text" onfocus="if(this.value==0){this.value='.$quotes.'}" onblur="javascript: if(this.value=='.$quotes.'){this.value=0;}" class= "float" name="pro_'.$shifts_array[$ii].'[]" value="'.$pro.'" size="4"></td>';
							echo '<td><input type="text" onfocus="if(this.value==0){this.value='.$quotes.'}" onblur="javascript: if(this.value=='.$quotes.'){this.value=0;}" class= "float" name="sah_'.$shifts_array[$ii].'[]" value="'.$sah.'" size="4"></td>';
							echo '<td><input type="text" onfocus="if(this.value==0){this.value='.$quotes.'}" onblur="javascript: if(this.value=='.$quotes.'){this.value=0;}" class= "float" id='."'ac_$shifts_array[$ii]_".$j."'".' name="ach_'.$shifts_array[$ii].'[]" value="'.$pchrs.'" size="4"></td>';
							echo '<td><input type="text" onfocus="if(this.value==0){this.value='.$quotes.'}" onblur="javascript: if(this.value=='.$quotes.'){this.value=0;}" class= "float" id='."'ah_$shifts_array[$ii]_".$j."'".' value="'.$plant_hours.'" name="plant_'.$shifts_array[$ii].'[]" size="4"></td>';
							
						}
						
							echo "</tr>";
							$j++;
						}
					
					
					?> 
				</tr>
             
				</table>
				<br/><br/><div id="bottom_div"><p style="cursor: pointer;" onclick="auto_cal_clh();">Click here >>> Auto Calculate Plan Clock<<< </p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">&nbsp;Enable&nbsp;&nbsp;&nbsp;<INPUT TYPE = "Submit" class="btn btn-primary btn-xs" name = "update" id="update" VALUE = "Update" disabled></div></div>
				</div>
			</form>
			</div>
		  </div>
		</div>
			<?php
			  }
			?>     

			<?php 
				if(isset($_POST['update']))
				 {
					
					$date_sub=$_POST['date_ref'];	
					// echo $date_sub;
					
					$module=$_POST['mod_no'];	
					$section=$_POST['sec_no'];		
					// echo implode(",",$section);
					
					// $act_hours=$_POST['act_hours'];
					$plan_eff=$_POST['plan_eff'];
					$plan_pro=$_POST['plan_pro'];
					$plan_sah=$_POST['plan_sah'];
					$plan_clh=$_POST['plan_clh'];
				
					for($i=0;$i<sizeof($module);$i++)
					{
						
					
						for($x = 0; $x < count($shifts_array); $x++)
						{
						
							//  var_dump($_POST['plan_eff_'.$module[$i].'_'.$shifts_array[$x].''])."</br>";
							$nop=$_POST['nop_'.$shifts_array[$x].''];
							$eff=$_POST['eff_'.$shifts_array[$x].''];
								
							$plant_hrs=$_POST['plant_'.$shifts_array[$x].''];
							$pro=$_POST['pro_'.$shifts_array[$x].''];
						
							$sah=$_POST['sah_'.$shifts_array[$x].''];
						
							$clh=$_POST['ach_'.$shifts_array[$x].''];
							
							// $act_hours=$_POST['act_hours'];
							// echo $act_hours;
							// echo "Test=".$module[$i]."-".$shifts_array[$x]."-".implode(",",$nop)."<br>";
						
							$plan_tag=$date_sub."-".$module[$i]."-".$shifts_array[$x];
						
							if($date_sub==date('Y-m-d'))
							{			
								
								$sql1="insert ignore into bai_pro.`pro_plan_today` (plan_tag) values (\"$plan_tag\")";
									// echo $sql1."<br>";		
								mysqli_query($link, $sql1) or exit("Sql Error512".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql12="update bai_pro.`pro_plan_today` set sec_no='".$section[$i]."', date=\"$date_sub\", mod_no='".$module[$i]."', shift=\"$shifts_array[$x]\", plan_eff='".$eff[$i]."',  plan_pro='".$pro[$i]."', fix_nop='".$nop[$i]."', plan_clh='".$clh[$i]."',plan_sah='".$sah[$i]."',act_hours='".$plant_hrs[$i]."' where plan_tag=\"".$plan_tag."\"";
								// echo "first----:".$sql2."<br>";
								mysqli_query($link, $sql12) or exit("Sql Error6 $sql12".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								// $sql123="insert ignore into bai_pro.`pro_plan_today` (plan_tag) values (\"$plan_tag\")";
								// mysqli_query($link, $sql123) or exit("Sql Error513".mysqli_error($GLOBALS["___mysqli_ston"]));
								// // echo "second----:".$sql12."<br>";			
								// $sql121="update bai_pro.`pro_plan_today` set sec_no='".$section[$i]."', date=\"$date_sub\", mod_no='".$module[$i]."', shift=\"$shifts_array[$x]\", plan_eff='".$eff[$i]."',  plan_pro='".$pro[$i]."', fix_nop='".$nop[$i]."', plan_clh='".$clh[$i]."',plan_sah='".$sah[$i]."', act_hours='$plant_hrs'where plan_tag=\"".$plan_tag."\"";
								// // echo "third----".$sql1212."<br>";
								// mysqli_query($link, $sql121) or exit("Sql Error6 $sql121".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							}
							else
							{
								// var_dump($eff);
								// echo $module[$i].$shifts_array[$x]."<br/>";
								$sql12="insert ignore into bai_pro.`pro_plan`(plan_tag) values (\"$plan_tag\")";
								// echo "2ndfist".$sql12."<br>";	
								mysqli_query($link, $sql12) or exit("Sql Error514".mysqli_error($GLOBALS["___mysqli_ston"]));
										
								$sql1212="update bai_pro.`pro_plan` set sec_no='".$section[$i]."', date=\"$date_sub\", mod_no='".$module[$i]."', shift=\"$shifts_array[$x]\", plan_eff='".$eff[$i]."',plan_pro='".$pro[$i]."', fix_nop='".$nop[$i]."', plan_clh='".$clh[$i]."',plan_sah='".$sah[$i]."',act_hours='".$plant_hrs[$i]."' where plan_tag=\"".$plan_tag."\"";
								// echo "second seco".$sql1212."<br>";
								mysqli_query($link, $sql1212) or exit("Sql Error6 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));								
								// echo "Test=".implode(",",$eff[$i])."<br>";
							}
						}
					
					}
			
					echo "<script>swal('Successfully Updated','','success');</script>";
					$url=getFullURL($_GET['r'],'plan_update_v2.php','N');
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"$url\"; }</script>";
				 }
				 
			?>
	
 </body>
</html>