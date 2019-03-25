<html>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
if(isset($_POST['module_name']))
{
	$module=$_POST['module_name'];
	$shifts=$_POST['shifts'];
}	
else
{
	$module=1;
	$shifts=implode("','",$shifts_array);
}

?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="180">
<style>
    body { margin:0;padding:0; background-color: black; color: white;}
	table {zoom: 93%; width:100%; text-align: center; margin:0;padding:0; border-spacing:0; border-collapse:collapse;}

	td {zoom: 140%; width:auto; text-align: center; border:1px solid black; margin:0;padding:0px; border-spacing:0; border-collapse:collapse;}
	h2 {zoom: 170%;}
	h5 {zoom: 450%;}
	h1 {border: 1px solid black; }
	h3 {border: 1px solid black; zoom: 190%; }
	
	img { zoom: 30%;}
</style>
<script >

setTimeout(function(){
	    var module = document.getElementById('module').value; 
        var originalURL = window.location.href;
	    var alteredURL = originalURL.split('&');
	    var url = alteredURL[0]+'&module_name='+module;
	    if(module){
	        window.location.href = url;    
	    }
	},120000);
</script>
</head>
<div class="panel panel-primary"> <div class="panel-heading"><h4 class="panel-title">Endline Dashboard</h4></div></div>
	<form id="2" class="form-inline" role="form" method="post" action="<?= $action_url ?>" onsubmit="return function">
		<style>
		form {color: black;}
	</style>
		<label for="module" class="mb-2 mr-sm-2">Module: </label>
	        <select class="form-control mb-2 mr-sm-2" name="module_name" id='module'> 
<?php
            $sql = "SELECT module_name FROM $bai_pro3.module_master ORDER BY module_name *'1'" ;
$result = mysqli_query($link, $sql);
        while($row=mysqli_fetch_array($result))
{
	$module=$_POST['module_name'];
	if($module == '')
		$module = $_GET['module_name'];

	if($module ==  $row['module_name'])
		echo "<option value='". $row['module_name']."' selected>".$row['module_name'].'</option>';
	else	
    	echo "<option value='". $row['module_name']."'>".$row['module_name'].'</option>';
}

?>
</select>
&nbsp&nbsp
<label for="module" class="mb-2 mr-sm-2">Shift: </label>
	     		<select class='form-control' id='module' name='shifts' >
				<?php if($shifts ==  $shift)
					echo "<option value=".implode("','",$shifts_array)." selected>ALL</option>";
                    else
					echo "<option value=".implode("','",$shifts_array).">ALL</option>";
                    foreach($shifts_array as $shift){
					if($shifts ==  $shift)
						echo "<option value='$shift' selected>$shift</option>";
					else
						echo "<option value='$shift' >$shift</option>";		
                  }
					?>

</select>
    <input type="submit"  class="btn btn-primary mb-2" value="submit">
</form>
<?php
if(isset($_POST['module_name']))
{
	$module=$_POST['module_name'];
	$shifts=$_POST['shifts'];
}	
else
{
	$module=1;
	$shifts=implode("','",$shifts_array);
}
$date_check=date("Y-m-d");
$sql1="select * from $bai_pro.pro_atten_hours where date='".$date_check."' and shift in ('".$shifts."') order by start_time";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result1)>0)
{
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$start=$sql_row1['start_time'];
		$end=$sql_row1['end_time'];
		for($i=$start;$i<$end;$i++)
		{
			$hours_main[]=$i;
		}		
	}
}
$sql="select sum(bac_qty) as act_out,GROUP_CONCAT(DISTINCT bac_style) as styles from $bai_pro.bai_log_buf where bac_date='".$date_check."' and bac_no=$module and bac_shift in ('".$shifts."')";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$act_out=$sql_row['act_out'];
		$styles=$sql_row['styles'];
	}
}
else
{
	$act_out=0;
	$styles='';
}
$sql11="select sum(plan_pro) as pro from $bai_pro.pro_plan_today where mod_no='$module' and shift in ('".$shifts."')";
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row11=mysqli_fetch_array($sql_result11))
{
	$plan_out=$sql_row11['pro'];
}
$balance_out=($plan_out-$act_out)>0?($plan_out-$act_out):0;
$sql114="select (SUM(present+jumper)-SUM(absent)) as atten from $bai_pro.pro_attendance where module='$module' and date='".$date_check."' and  shift in ('".$shifts."')";
$sql_result114=mysqli_query($link, $sql114) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row114=mysqli_fetch_array($sql_result114))
{
	if($sql_row114['atten']<>'')
	{
		$nop=$sql_row114['atten'];
	}
	else
	{
		$nop=0;
	}	
}

?>
<div class='dashboard col-sm-12'>
<table>
<tr>
<td colspan=2><h1>Module - <?php echo $module; ?></h1></td>
</tr>

<tr>
<td><mytag>Target &nbsp;&nbsp; <?php if($plant_location=='Sri Lanka'){
								echo "- ඉලක්කය "; }
								elseif($plant_location=='India'){	
								echo "- రోజు వారి టార్గెట్";				}
								else
								{
									
								}	?></mytag></td>
<td><mytag>Balance &nbsp;&nbsp; <?php if($plant_location=='Sri Lanka'){
								echo "- ඉතිරිය"; }
								elseif($plant_location=='India'){	
									echo "- కుట్టవలసిన పీసులు";		}
								else
								{
									
								}	?></mytag></td>
</tr>

<tr>
<td><h5><font color=#0080ff><?php if($plan_out){ echo $plan_out; }else{ echo '0';} ?></font></h5></td>
<td><h5><font color=#0080ff><?php echo $balance_out; ?></font></h5></td>
</tr>


<td colspan=2></td>
<td colspan=2></td>


<tr>
<td><mytag>Operators &nbsp;&nbsp; <?php if($plant_location=='Sri Lanka'){
								echo "- ක්‍රියාකරුවන් "; }
								elseif($plant_location=='India'){
								echo "- ఆపరేటర్లు";	
											}
								else
								{
									
								}	?></mytag></td>
<td><mytag>Achievement&nbsp;&nbsp; <?php if($plant_location=='Sri Lanka'){
								echo "- ජයග්‍රහණය"; }
								elseif($plant_location=='India'){	
								echo "- కుట్టిన పీసులు";			}
								else
								{
									
								}	?></mytag></td>
</tr>

<tr>
<td><h5><font color=#0080ff><?php if($nop) echo $nop; else echo '0'; ?></h5></td>
<td><h5><font color=#0080ff><?php if($act_out) echo $act_out; else echo '0'; ?></h5></td>
</tr>

<tr><td colspan=2><h3>Running Styles <?php echo str_replace('0,','',$styles); ?></h3></td></tr>

</table>
</div>
<?php
$time_display=array();
$act_out=array();
$time_prefix=array();
$tot_plant_working_hrs=sizeof($hours_main);
$sql1="select sum(plan_pro) as pro from $bai_pro.pro_plan_today where mod_no='$module' and shift in ('".$shifts."')";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	if($tot_plant_working_hrs>0 && $sql_row1['pro']>0)
	{
		$hourly_target=round($sql_row1['pro']/$tot_plant_working_hrs,0);		
	}
	else
	{
		$hourly_target=0;
	}	
}
for($j=0;$j<sizeof($hours_main);$j++)
{
	$hourly_targets[$hours_main[$j]]=$hourly_target;
	$sql="select * from $bai_pro3.tbl_plant_timings where time_value='".$hours_main[$j]."'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$time_value[] = $sql_row['time_value'];
		$time_display[$sql_row['time_value']]=$sql_row['time_display'];
		$time_prefix[$sql_row['time_value']]=$sql_row['day_part'];
		$sql2="SELECT SUM(bac_qty) as outp FROM $bai_pro.bai_log_buf WHERE bac_date='".$date_check."' AND bac_no=$module and Hour(bac_lastup)>= Hour('".$sql_row['start_time']."') AND Hour(bac_lastup)< Hour('".$sql_row['end_time']."')";
		//echo $sql2;
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['outp']<>'')
			{
				$act_out[$sql_row['time_value']]=$sql_row2['outp'];
			}
			else
			{
				$act_out[$sql_row['time_value']]=0;
			}	
		}
	}
}
	

?>

<table class='table' id='my_table'>
	<tr class='red'>
	<th class='left_head'>Hour</th>
	<?php
	foreach($time_value as $hour){
		echo "<th>".$time_display[$hour]." ".$time_prefix[$hour]."</th>";
	}
	?>
	</tr>
	<tr>
		<th class='left_head'>Target PCs</th>
		<?php
		foreach($time_value as $hour){	
				if($hourly_targets[$hour]=='')
				{
					$hourly_targets[$hour]=0;
				}
				echo "<td>".$hourly_targets[$hour]."</td>";		
		}
		?>		
	</tr>
	<tr>
		<th class='left_head'>Actual PCs</th>
		<?php
		foreach($time_value as $hour){
			echo "<td>".$act_out[$hour]."</td>";
		}
		?>
	</tr>
	<tr>
		<th class='left_head'>Balance</th>

<?php

foreach($time_value as $hour)
{
	$bg_color="bgcolor=\"black\"";		
	if($act_out[$hour]==0)
	{
		$bg_color="bgcolor=\"red\"";
	}
	else
	{
		if($act_out[$hour]>=$hourly_targets[$hour])
		{
			$bg_color="bgcolor=\"green\"";
		}
		else
		{
			$bg_color="bgcolor=\"orange\"";
		}			
	}		
	echo "<td $bg_color>".(($hourly_targets[$hour]-$act_out[$hour])>0?($hourly_targets[$hour]-$act_out[$hour]):0)."</td>";
}

?>
</tr>

</table>
</div>



<style>
.dashboard{
	background : #000;
}
mytag{
	font-size : 30px;
}
.red{
	color : #0080ff;
	font-weight : bold;
}
#my_table{
	background : #995688;
	background: linear-gradient(to bottom, #323232 0%, #3F3F3F 40%, #1C1C1C 150%), linear-gradient(to top, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.25) 200%);
 	background-blend-mode: multiply;
}
.left_head{
	color : #00ff80;
	font-weight : bold;
}
</style>