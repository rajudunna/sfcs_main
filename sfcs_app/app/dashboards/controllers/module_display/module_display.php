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


<?php
if(isset($_GET['module']))
{
	$module=$_GET['module'];
}
else
{
	$module=1;
}



$sql="select sum(plan_out) as plan_out,sum(act_out) as act_out,nop,styles from $bai_pro.grand_rep where date=CURDATE() and module='$module'";
//$sql="select sum(plan_out) as plan_out,sum(act_out) as act_out,nop,styles from bai_pro.grand_rep where date='2017-11-08' and module=$module";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$plan_out=$sql_row['plan_out'];
	$act_out=$sql_row['act_out'];
	$balance_out=($plan_out-$act_out)>0?($plan_out-$act_out):0;
	$nop=$sql_row['nop'];
	$styles=$sql_row['styles'];
}

if($plan_out==0 or $act_out==0)
{

$sql="select sum(plan_pro) as plan_out from $bai_pro.pro_plan_today where date=CURDATE() and mod_no='$module'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$plan_out=$sql_row['plan_out'];
	}
	$sql="select sum(bac_Qty) as act_out,max(nop) as nop,group_concat(distinct bac_style) as styles from $bai_pro.bai_log_buf where bac_date=CURDATE() and bac_no='$module'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$act_out=$sql_row['act_out'];
		$balance_out=($plan_out-$act_out)>0?($plan_out-$act_out):0;
		$nop=$sql_row['nop'];
		$styles=$sql_row['styles'];
	}
	
	if($nop=='')
	{
		$nop=0;
	}
	if($act_out=='')
	{
		$act_out=0;
	}
}

//echo $sql;
?>
<div class='dashboard col-sm-12'>
<table>
<tr>
<td colspan=2><h1>Module - <?php echo $module; ?></h1></td>
</tr>

<tr>
<td><mytag>Target &nbsp;&nbsp;- ඉලක්කය</mytag></td>
<td><mytag>Balance &nbsp;&nbsp;- ඉතිරි</mytag></td>
</tr>

<tr>
<td><h5><font color=#0080ff><?php if($plan_out){ echo $plan_out; }else{ echo '0';} ?></font></h5></td>
<td><h5><font color=#0080ff><?php echo $balance_out; ?></font></h5></td>
</tr>


<td colspan=2></td>
<td colspan=2></td>


<tr>
<td><mytag>Operators &nbsp;&nbsp;- ක්රියාකරුවන්</mytag></td>
<td><mytag>Achievement&nbsp;&nbsp;- ජයග්රහණය</mytag></td>
</tr>

<tr>
<td><h5><font color=#0080ff><?php if($nop) echo $nop; else echo '0'; ?></h5></td>
<td><h5><font color=#0080ff><?php if($act_out) echo $act_out; else echo '0'; ?></h5></td>
</tr>

<tr><td colspan=2><h3>Running Styles <?php echo str_replace('0,','',$styles); ?></h3></td></tr>

</table>
</div>
<?php

$plan_out=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

$sql="select * from $bai_pro.pro_plan_today where date=CURDATE() and mod_no='$module'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$hourly_target=round($sql_row['plan_pro']/8,0);
	if($sql_row['shift']=='A')
	{
		$plan_out[6]=$hourly_target + ($sql_row['plan_pro']-(round($sql_row['plan_pro']/8,0)*8));
		$plan_out[7]=$hourly_target;
		$plan_out[8]=$hourly_target;
		$plan_out[9]=$hourly_target;
		$plan_out[10]=$hourly_target;
		$plan_out[11]=$hourly_target;
		$plan_out[12]=$hourly_target;
		$plan_out[13]=$hourly_target;

		
	}
	if($sql_row['shift']=='B')
	{
		$plan_out[14]=$hourly_target  + ($sql_row['plan_pro']-(round($sql_row['plan_pro']/8,0)*8));
		$plan_out[15]=$hourly_target;
		$plan_out[16]=$hourly_target;
		$plan_out[17]=$hourly_target;
		$plan_out[18]=$hourly_target;
		$plan_out[19]=$hourly_target;
		$plan_out[20]=$hourly_target;
		$plan_out[21]=$hourly_target;

	}
	$hourly_target=0;
}

$act_out=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

$sql="SELECT HOUR(bac_lastup) AS hr, SUM(bac_qty) as outp FROM $bai_pro.bai_log_buf WHERE bac_date=CURDATE() AND bac_no='$module' GROUP BY HOUR(bac_lastup)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$act_out[$sql_row['hr']]=$sql_row['outp'];
	$current_hour=$sql_row['hr'];
}

?>

<table class='table' id='my_table'>
	<tr class='red'>
		<th class='left_head'>Hour</th>
		<th>06-07</th>
		<th>07-08</th>
		<th>08-09</th>
		<th>09-10</th>
		<th>10-11</th>
		<th>11-12</th>
		<th>12-13</th>
		<th>13-14</th>
		<th>14-15</th>
		<th>15-16</th>
		<th>16-17</th>
		<th>17-18</th>
		<th>18-19</th>
		<th>19-20</th>
		<th>20-21</th>
		<th>21-22</th>

	</tr>
	<tr>
		<th class='left_head'>Target PCs</th>
		<td><?php echo $plan_out[6]; ?></td>
		<td><?php echo $plan_out[7]; ?></td>
		<td><?php echo $plan_out[8]; ?></td>
		<td><?php echo $plan_out[9]; ?></td>
		<td><?php echo $plan_out[10]; ?></td>
		<td><?php echo $plan_out[11]; ?></td>
		<td><?php echo $plan_out[12]; ?></td>
		<td><?php echo $plan_out[13]; ?></td>
		<td><?php echo $plan_out[14]; ?></td>
		<td><?php echo $plan_out[15]; ?></td>
		<td><?php echo $plan_out[16]; ?></td>
		<td><?php echo $plan_out[17]; ?></td>
		<td><?php echo $plan_out[18]; ?></td>
		<td><?php echo $plan_out[19]; ?></td>
		<td><?php echo $plan_out[20]; ?></td>
		<td><?php echo $plan_out[21]; ?></td>
	</tr>
	<tr>
		<th class='left_head'>Actual PCs</th>
		<td><?php echo $act_out[6]; ?></td>
		<td><?php echo $act_out[7]; ?></td>
		<td><?php echo $act_out[8]; ?></td>
		<td><?php echo $act_out[9]; ?></td>
		<td><?php echo $act_out[10]; ?></td>
		<td><?php echo $act_out[11]; ?></td>
		<td><?php echo $act_out[12]; ?></td>
		<td><?php echo $act_out[13]; ?></td>
		<td><?php echo $act_out[14]; ?></td>
		<td><?php echo $act_out[15]; ?></td>
		<td><?php echo $act_out[16]; ?></td>
		<td><?php echo $act_out[17]; ?></td>
		<td><?php echo $act_out[18]; ?></td>
		<td><?php echo $act_out[19];; ?></td>
		<td><?php echo $act_out[20]; ?></td>
		<td><?php echo $act_out[21]; ?></td>
	</tr>
	<tr>
		<th class='left_head'>Balance</th>

<?php

for($i=6;$i<=21;$i++)
{
		$bg_color="bgcolor=\"black\"";
		
		if($i<=$current_hour)
		{
			
			if($act_out[$i]==0)
			{
				$bg_color="bgcolor=\"red\"";
			}
			else
			{
				if($act_out[$i]>=$plan_out[$i])
				{
					$bg_color="bgcolor=\"green\"";
				}
				else
				{
					$bg_color="bgcolor=\"orange\"";
				}
				
			}
		}
		
		echo "<td $bg_color>".(($plan_out[$i]-$act_out[$i])>0?($plan_out[$i]-$act_out[$i]):0)."</td>";
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