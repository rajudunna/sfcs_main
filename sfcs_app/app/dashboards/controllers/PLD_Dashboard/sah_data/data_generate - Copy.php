
<?php
$today=date("Y-m-d");
$start=date("Y-m-01");
$end=date("Y-m-31");
include"header.php";

$sections=array("1","2","3","4","5","6");
$plan_sah_mod=array("56537","56749","55651","53998","60211","46526");

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth) FROM grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$end."\"");
while($row=mysqli_fetch_array($sql))
{
	$act=ROUND($row["SUM(act_sth)"],0);
}


$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth),count(distinct date) as dat FROM grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".date("Y-m-d",strtotime('- 1 day'))."\"");
echo "SELECT SUM(act_sth),count(distinct date) as dat FROM grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".date("Y-m-d",strtotime('- 1 day'))."\"";
while($row=mysqli_fetch_array($sql))
{
	$act_ysd=ROUND($row["SUM(act_sth)"],0);
	$date_count=$row["dat"];
}

for($i=0;$i<sizeof($sections);$i++)
{	
	$sql_mod=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth) FROM grand_rep WHERE section=\"$i\" and DATE BETWEEN \"".$start."\" AND \"".date("Y-m-d",strtotime('- 1 day'))."\"");
	while($row_mod=mysqli_fetch_array($sql_mod))
	{
		$act_ysd_mod[]=ROUND($row_mod["SUM(act_sth)"],0);
	}	
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth) FROM grand_rep WHERE DATE=\"$today\"");
while($row=mysqli_fetch_array($sql))
{
	$today_act=round($row["SUM(act_sth)"],0);
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT count(DISTINCT(date)) as date FROM grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$end."\"");
while($row=mysqli_fetch_array($sql))
{
	$dates=$row["date"];
}

include"../sah_monthly_status/data.php";

$target=$fac_plan;
//$wor_days="27";
$wor_days=sizeof($date1);
$sah_dif=$target-$act;
$stnd_hrs=round($act,0);

if($date_count == 0)
{
	$date_count=1;
}

$table1="<table>";
$table1.="<tr><th>Sections</th><th>Plan SAH</th><th>Actual SAH</th><th>Avg/Day</th><th>Req/Day</th></tr>";
for($i=0;$i<sizeof($sections);$i++)
{
	$table1.="<tr>";
	$table1.="<td>Section-".($i+1)."</td>";
	$table1.="<td>".$plan_sah_mod[$i]."</td>";
	$table1.="<td>".$act_ysd_mod[$i]."</td>";
	$table1.="<td>".round($act_ysd_mod[$i]/$date_count,0)."</td>";
	$table1.="<td>".round((($plan_sah_mod[$i]-$act_ysd_mod[$i])/($wor_days-$date_count)),0)."</td>";
	$table1.="</tr>";
}
$table1.="</table>";
echo $table1;

$diff=$wor_days-$dates+1;
//echo $diff;
if(date("Y-m-d")=="2012-06-01")
{
	$act_ysd=0;
}

if($diff<=0)
{
	$div=1;
}
else
{
	if(date("Y-m-d")=="2012-06-01")
	{
		$div=$wor_days;
	}
	else
	{
		$div=$diff;
	}
}
//$avg=round((($target-$act_ysd)/($div)),0);
$avg=round($target-$act);
$data_sym="$";
$File = "data.php";
$fh = fopen($File, 'w') or die("can't open file");
$stringData = "<?php ".$data_sym."target=".$target."; ".$data_sym."sah_today=".$act."; ".$data_sym."sha_yesterday=".$act_ysd."; ".$data_sym."days=".$diff."; ".$data_sym."avg=".$avg."; ".$data_sym."table1=\"".$table1."\"; ?>";
fwrite($fh, $stringData);
fclose($fh);	

echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../IU_Clock/speed_clock.php\"; }</script>";

?>

