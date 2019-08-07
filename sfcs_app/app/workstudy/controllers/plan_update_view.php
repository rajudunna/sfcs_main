
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
		  if($date==date('Y-m-d')){
			$sql_query="select * from `bai_pro`.`pro_plan_today` where date='$date' group by mod_no,shift";
			$selectRes=mysqli_query($link,$sql_query) or exit($sql_query."Error at something");
		}else{
		$sql_query="select * from `bai_pro`.`pro_plan` where date='$date' group by mod_no,shift";
		$selectRes=mysqli_query($link,$sql_query) or exit($sql_query."Error at something");
		}
		$count=mysqli_num_rows($selectRes);
               if($count<=0){
				echo "<div class='row'>
				<div class='panel panel-primary'>
				  <div class='panel-heading' style='text-align:center;'>
					  <b>Sorry....There is No plan in this Date</b>";
					
			   }else{
		while( $row = mysqli_fetch_assoc( $selectRes ))
		{
			$mod_no[]=$row['mod_no'];
			$sec_no[]=$row['sec_no'];
		$nop[$row['mod_no']][$row['shift']]=$row;
		
		}
		$mod_no=array_unique($mod_no);
		  ?>
		  
		<div class='row'>
		  <div class='panel panel-primary'>
			<div class='panel-heading'>
				<b>View Plan Review</b>
				<span align='right' style='margin-left:750px;'><?php $date ?></span>
			</div>
			<div class='panel-body' style='overflow: scroll;height: 616px;'>
			<?php
			  echo '<input type="hidden" name="date_ref" value="'.$date.'" size="8"/>';  
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
					 
					//$nop=json_encode($nop);
					//var_dump($nop[2]['A']['sec_no']);
					$table_row1='';
					foreach ($mod_no as $key => $module) {
						$table_row1 .='<tr><td>'.$module.'</td><td>'.$sec_no[$key].'</td>';
						foreach ($shifts_array as $shifts_key => $shifts_value) {
						  $table_row1 .='<td>'.$nop[$module][$shifts_value]['fix_nop'].
						  '</td><td>'.$nop[$module][$shifts_value]['plan_eff'].'</td><td>'.$nop[$module][$shifts_value]['plan_pro'].
						  '</td><td>'.$nop[$module][$shifts_value]['plan_sah'].'</td><td>'.$nop[$module][$shifts_value]['plan_clh'].
						  '</td><td>'.$nop[$module][$shifts_value]['act_hours'].'</td>';
					     }
						$table_row1 .='</tr>';
					}

				echo $table_row1;
				?>
				</table>
				</div>
			</div>
		  </div>
		</div>
			<?php
			  }
			}
			?>     
			</body>
   </html>