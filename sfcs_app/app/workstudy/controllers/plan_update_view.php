
<html>
<head>
<style>
body{
	font-family: Trebuchet MS;
}

th,td
{
	text-align:center;
}
</style>
<?php
// include();
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
  $view_access=user_acl("SFCS_0170",$username,1,$group_id_sfcs); 
$auth_users=user_acl("SFCS_0170",$username,7,$group_id_sfcs);
$super_user=user_acl("SFCS_0170",$username,33,$group_id_sfcs); 
$has_permission = haspermission($_GET['r']);
?>
</head>
<body>
	<div class="panel panel-primary" id="main_div">
	<div class="panel-heading">View Plan Efficiency</div>
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
				<b>View Plan Review</b>
				<span align='right' style='margin-left:750px;'><?php $date ?></span>
			</div>
			<div class='panel-body' style='overflow: scroll;height: 616px;'>
			<form method="post" action="<?php echo getFullURL($_GET['r'], "plan_update_v2.php", "N"); ?>">
			<?php
			   '<input type="text" name="date_ref" value="'.$date.'" size="8"/>';  
			  
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
						$selectRes1=mysqli_query($link,$table_data1) or exit($table_data."Error at something");
						$num_rows = mysqli_num_rows($selectRes1);
						$j=0;
						echo '<input type="hidden" id="outer_hid" value="'.$num_rows.'">';
						echo '<input type="hidden" id="actyhrs" name="act_hours" value=7.5>';
						echo '<input type="hidden" id="shift_details" value="'.implode(",",$shifts_array).'">';
						while($row1 = mysqli_fetch_assoc($selectRes1))
						{  			
							
							$mod_number=$row1['module_name'];
							$sec_no=$row1['section'];
							echo "<tr id='aa".$j."'>";
							echo '<td>'.$mod_number.'</td>';
							echo '<td>'.$sec_no.'</td>';

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
							echo '<td>'.$nop.'</td>';
							echo '<td>'.$eff.'</td>';
							echo '<td>'.$pro.'</td>';
							echo '<td>'.$sah.'</td>';
							echo '<td>'.$pchrs.'</td>';
							echo '<td>7.5</td>';
							
						}
						
							echo "</tr>";
							$j++;
						}
					
					
					?> 
				</tr>
             
				</table>
				</div>
			</form>
			</div>
		  </div>
		</div>
			<?php
			  }
			?>     
			</body>
</html>