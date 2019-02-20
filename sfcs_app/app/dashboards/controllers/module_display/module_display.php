<html>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
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
	    var url = window.location.href+'&module='+module;
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
	        <select class="form-control mb-2 mr-sm-2" name="module" id='module'> 
<?php
            $sql = "SELECT module FROM $bai_pro.grand_rep";
$result = mysqli_query($link, $sql);
        while($row=mysqli_fetch_array($result))
{
	$module=$_POST['module'];
	if($module == '')
		$module = $_GET['module'];

	if($module ==  $row['module'])
		echo "<option value='". $row['module']."' selected>".$row['module'].'</option>';
	else	
    	echo "<option value='". $row['module']."'>".$row['module'].'</option>';
}

?>
</select>
    <input type="submit"  class="btn btn-primary mb-2" value="submit">
</form>
<?php
if(isset($_POST['module']))
{
	$module=$_POST['module'];
}elseif(isset($_GET['module']))
{
	$module=$_GET['module'];
}else{
	$module=1;
}


$date_check=date("Y-m-d");
$sql="select sum(bac_qty) as act_out,GROUP_CONCAT(DISTINCT bac_style) as styles from $bai_pro.bai_log_buf where bac_date='".$date_check."' and bac_no=$module";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
$sql11="select sum(plan_pro) as pro from $bai_pro.pro_plan_today where mod_no='$module'";
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row11=mysqli_fetch_array($sql_result11))
{
	$plan_out=$sql_row11['pro'];
}
$balance_out=($plan_out-$act_out)>0?($plan_out-$act_out):0;
$sql114="select sum(present+jumper) as atten from $bai_pro.pro_attendance where module='$module' and date='".$date_check."'";
$sql_result114=mysqli_query($link, $sql114) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
								echo "- ඉලක්කය"; }
								elseif($plant_location=='India'){	
								echo "- రోజు వారి టార్గెట్";				}
								else
								{
									
								}	?></mytag></td>
<td><mytag>Balance &nbsp;&nbsp; <?php if($plant_location=='Sri Lanka'){
								echo "- ඉතිරි"; }
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
								echo "- ක්රියාකරුවන්"; }
								elseif($plant_location=='India'){
								echo "- ఆపరేటర్లు";	
											}
								else
								{
									
								}	?></mytag></td>
<td><mytag>Achievement&nbsp;&nbsp; <?php if($plant_location=='Sri Lanka'){
								echo "- ජයග්රහණය"; }
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

$sql="select * from $bai_pro3.tbl_plant_timings";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$time_display[]=$sql_row['time_display'];
	$time_prefix[]=$sql_row['day_part'];
	$sql2="SELECT SUM(bac_qty) as outp FROM $bai_pro.bai_log_buf WHERE bac_date='".$date_check."' AND bac_no=$module and TIME(bac_lastup)>= TIME('".$sql_row['start_time']."') AND TIME(bac_lastup)< TIME('".$sql_row['end_time']."')";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		if($sql_row2['outp']<>'')
		{
			$act_out[$sql_row['time_display']]=$sql_row2['outp'];
		}
		else
		{
			$act_out[$sql_row['time_display']]=0;
		}	
	}
	
}
$sql1="select sum(plan_pro) as pro from $bai_pro.pro_plan_today where mod_no='$module'";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

?>

<table class='table' id='my_table'>
	<tr class='red'>
	<th class='left_head'>Hour</th>
	<?php
	for($i=0;$i<sizeof($time_display);$i++)
	{
		echo "<th>".$time_display[$i]." ".$time_prefix[$i]."</th>";
	}
	?>
	</tr>
	<tr>
		<th class='left_head'>Target PCs</th>
		<?php
		for($ii=0;$ii<sizeof($time_display);$ii++)
		{
			echo "<td>".$hourly_target."</td>";
		}
		?>		
	</tr>
	<tr>
		<th class='left_head'>Actual PCs</th>
		<?php
		for($iii=0;$iii<sizeof($time_display);$iii++)
		{
			echo "<td>".$act_out[$time_display[$iii]]."</td>";
		}
		?>
	</tr>
	<tr>
		<th class='left_head'>Balance</th>

<?php

for($j=0;$j<sizeof($time_display);$j++)
{
	$bg_color="bgcolor=\"black\"";		
	if($act_out[$time_display[$j]]==0)
	{
		$bg_color="bgcolor=\"red\"";
	}
	else
	{
		if($act_out[$time_display[$j]]>=$hourly_target)
		{
			$bg_color="bgcolor=\"green\"";
		}
		else
		{
			$bg_color="bgcolor=\"orange\"";
		}			
	}		
	echo "<td $bg_color>".(($hourly_target-$act_out[$time_display[$j]])>0?($hourly_target-$act_out[$time_display[$j]]):0)."</td>";
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