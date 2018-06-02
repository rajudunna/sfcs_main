
<?php
$start_timestamp = microtime(true);
error_reporting(0);
//To extract date between two given dates
function getDaysInBetween($start, $end) {
 // Vars
 $day = 86400; // Day in seconds
 $format = 'Y-m-d'; // Output format (see PHP date funciton)
 $sTime = strtotime($start); // Start as time
 $eTime = strtotime($end); // End as time
 $numDays = round(($eTime - $sTime) / $day) + 1;
 $days = array();

 // Get days
 for ($d = 0; $d < $numDays; $d++) {
  $days[] = date($format, ($sTime + ($d * $day)));
 }

 // Return days
 return $days;
} 
?>


			
<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:110px;
 right:0;
 width:auto;
float:right;
}
</style>




<?php 
include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');

?>

<div id="page_heading"><span style="float: left"><h3>FR - Daily Plan Achievement Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<?php
$sdate=$_POST['dat1'];
$edate=$_POST['dat2'];
$section=$_POST['section'];
?>
<?php
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

$sdate=date("Y-m-d",$start_date_w);
$edate=date("Y-m-d",$end_date_w);


$dates_between=array();
$dates_between=getDaysInBetween($sdate,$edate);
	
echo "<table  border=1 bgcolor='white'>";
$table.="<h2>Daily FR Plan Achievement Report</h2><table border=1>";

echo "<tr class='tblheading'>";
$table.="<tr>";
echo "<th>Module</th>";
$table.="<th>Module</th>";
echo "<th>Buyer Division</th>";
$table.="<th>Buyer Division</th>";
echo "<th>Style</th>";
$table.="<th>Style</th>";


$query_code=array();
$plan_tot=array();
$act_tot=array();
for($i=0;$i<sizeof($dates_between);$i++)
{
	echo "<th>".$dates_between[$i]."</th>";
	$table.="<th>".$dates_between[$i]."</th>";
	$query_code[]="SUM(IF(production_date='".$dates_between[$i]."',qty,0)) AS '".$dates_between[$i]."'";
	$plan_tot[$i]=0;
	$act_tot[$dates_between[$i]]=0;
}

echo "</tr>";
$table.="</tr>";

$mod_count=array();
$sql="select module,count(module) as count from (SELECT group_code,bai_pro4.uExtractNumberFromString(style) as style,module,
".implode(",",$query_code)." FROM bai_pro4.fastreact_plan WHERE production_date BETWEEN '$sdate' AND '$edate' GROUP BY CONCAT(group_code,bai_pro4.uExtractNumberFromString(style),module) ORDER BY module,style) as t group by module";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mod_count[$sql_row['module']]=$sql_row['count'];
}

$mod_chk=0;
$sql="SELECT group_code,bai_pro4.uExtractNumberFromString(style) as style,module,
".implode(",",$query_code)."
FROM bai_pro4.fastreact_plan WHERE production_date BETWEEN '$sdate' AND '$edate' GROUP BY CONCAT(group_code,bai_pro4.uExtractNumberFromString(style),module) ORDER BY module,style";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$check=0;
	if($mod_chk!=$sql_row['module']){
		//To Merge Cells
		$check=1;
		
		if($mod_chk!=0 and $mod_chk!=$sql_row['module'])
		{
			
			//Actual output
			$sql1="SELECT date,SUM(act_out) as output FROM bai_pro.grand_rep WHERE DATE BETWEEN '$sdate' AND '$edate' AND module=$mod_chk GROUP BY date";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$key=array_search($sql_row1['date'],$dates_between);
				$act_tot[$key]=$sql_row1['output'];
			}
			
			
			//Plan
			echo "<tr bgcolor='#33CCEE'>";
			$table.="<tr bgcolor='#33CCEE'>";
			echo "<td>Plan</td><td>".array_sum($plan_tot)."</td>";
			$table.="<td>Plan</td><td>".array_sum($plan_tot)."</td>";
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				echo "<td>".$plan_tot[$i]."</td>";
				$table.="<td>".$plan_tot[$i]."</td>";
			}	
					
			echo "</tr>";
			$table.="</tr>";
			
			//Actual
			echo "<tr bgcolor='#99FFCC'>";
			$table.="<tr bgcolor='#99FFCC'>";
			echo "<td>Actual</td><td>".array_sum($act_tot)."</td>";
			$table.="<td>Actual</td><td>".array_sum($act_tot)."</td>";
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				echo "<td>".$act_tot[$i]."</td>";
				$table.="<td>".$act_tot[$i]."</td>";
			}	
					
			echo "</tr>";
			$table.="</tr>";
			
			//Variation
			echo "<tr bgcolor='#FFFF66'>";
			$table.="<tr bgcolor='#FFFF66'>";
			echo "<td>Variation</td><td>".(array_sum($act_tot)-array_sum($plan_tot))."</td>";
			$table.="<td>Variation</td><td>".(array_sum($act_tot)-array_sum($plan_tot))."</td>";
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				echo "<td>".($act_tot[$i]-$plan_tot[$i])."</td>";
				$table.="<td>".($act_tot[$i]-$plan_tot[$i])."</td>";
			}	
					
			echo "</tr>";
			$table.="</tr>";
			
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				$plan_tot[$i]=0;
				$act_tot[$dates_between[$i]]=0;
			}
		}
		
		$mod_chk=$sql_row['module'];
	}
	
	
	echo "<tr>";
	$table.="<tr>";
	
	if($check==1){
		echo "<td rowspan=".($mod_count[$mod_chk]+3).">$mod_chk</td><td>".$sql_row['group_code']."</td><td>".$sql_row['style']."</td>";
		$table.="<td rowspan=".($mod_count[$mod_chk]+3).">$mod_chk</td><td>".$sql_row['group_code']."</td><td>".$sql_row['style']."</td>";
	}else{
		echo "<td>".$sql_row['group_code']."</td><td>".$sql_row['style']."</td>";
		$table.="<td>".$sql_row['group_code']."</td><td>".$sql_row['style']."</td>";
	}
	
		
	for($i=0;$i<sizeof($dates_between);$i++)
	{
		echo "<td>".$sql_row[$dates_between[$i]]."</td>";
		$table.="<td>".$sql_row[$dates_between[$i]]."</td>";
		$plan_tot[$i]+=$sql_row[$dates_between[$i]];
	}	
	
	echo "</tr>";
	$table.="</tr>";
}


{
			
			//Actual output
			$sql1="SELECT date,SUM(act_out) as output FROM bai_pro.grand_rep WHERE DATE BETWEEN '$sdate' AND '$edate' AND module=$mod_chk GROUP BY date";
			//echo $sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$key=array_search($sql_row1['date'],$dates_between);
				$act_tot[$key]=$sql_row1['output'];
			}
			
			
			//Plan
			echo "<tr bgcolor='#33CCEE'>";
			$table.="<tr bgcolor='#33CCEE'>";
			echo "<td>Plan</td><td>".array_sum($plan_tot)."</td>";
			$table.="<td>Plan</td><td>".array_sum($plan_tot)."</td>";
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				echo "<td>".$plan_tot[$i]."</td>";
				$table.="<td>".$plan_tot[$i]."</td>";
			}	
					
			echo "</tr>";
			$table.="</tr>";
			
			//Actual
			echo "<tr bgcolor='#99FFCC'>";
			$table.="<tr bgcolor='#99FFCC'>";
			echo "<td>Actual</td><td>".array_sum($act_tot)."</td>";
			$table.="<td>Actual</td><td>".array_sum($act_tot)."</td>";
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				echo "<td>".$act_tot[$i]."</td>";
				$table.="<td>".$act_tot[$i]."</td>";
			}	
					
			echo "</tr>";
			$table.="</tr>";
			
			//Variation
			echo "<tr bgcolor='#FFFF66'>";
			$table.="<tr bgcolor='#FFFF66'>";
			echo "<td>Variation</td><td>".(array_sum($act_tot)-array_sum($plan_tot))."</td>";
			$table.="<td>Variation</td><td>".(array_sum($act_tot)-array_sum($plan_tot))."</td>";
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				echo "<td>".($act_tot[$i]-$plan_tot[$i])."</td>";
				$table.="<td>".($act_tot[$i]-$plan_tot[$i])."</td>";
			}	
					
			echo "</tr>";
			$table.="</tr>";
			
			
			for($i=0;$i<sizeof($dates_between);$i++)
			{
				$plan_tot[$i]=0;
				$act_tot[$dates_between[$i]]=0;
			}
		}

echo "</table>";
$table.="</table>";

?>
<?php
$date=date("Y-m-d");
$file_name=$path.'/planning/reports/'.$date.'.htm';
// saving captured output to file
file_put_contents($file_name,$table);
// end buffering and displaying page
ob_end_flush();

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." Seconds.");


?>
<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>

