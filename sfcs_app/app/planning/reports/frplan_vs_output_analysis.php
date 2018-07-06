<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
//$view_access=user_acl("SFCS_0042",$username,1,$group_id_sfcs);
?>

<?php

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



	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R') ?>"></script>
		<link rel="stylesheet" href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R') ?>" type="text/css" media="all" />
		
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
 top:85px;
 right:12px;
 width:auto;
float:right;
}
</style>
<?php 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],"dbconf5.php",'R')); ?>

<link rel="stylesheet" type="text/css" media="all" href="<?= '../'.getFullURLLevel($_GET['r'],'jsdatepick-calendar/jsDatePick_ltr.min.css',3,'R') ?>" />
<!--<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'jsdatepick-calendar/jsDatePick.min.1.3.js','R') ?>"></script>
<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'datetimepicker_css.js','R') ?>"></script>-->

<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
</head>
<div class='panel panel-primary'>
<div class='panel-heading'>
	<h3 class='panel-title'>FR Plan VS Actual Analysis</h3>
</div>
<div class='panel-body'>


<!--<div id="page_heading"><span style="float"><h3>FR - Daily Plan Achievement Report</h3></span><span style="float: right; margin-top: -20px"><b>?</b>&nbsp;</span></div>
-->
<form  method="POST" action='?r=<?= $_GET["r"] ?>'>

<?php
$sdate=$_POST['dat1'];
$edate=$_POST['dat2'];

?>
<div class="row">
<div class="col-sm-3">

<label>Start Date: </label><input id="demo1" class="form-control" type="text" data-toggle="datepicker" id="demo1" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>" required >

</div>
<div class="col-sm-3">
<label>End Date: </label><input id="demo2" class="form-control" type="text"  data-toggle="datepicker"  id="demo2" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>" required >
</div>

<input class='btn btn-primary'  type="submit" id="submit" name="submit" value="submit" onclick="return verify_date()"  style="margin-top:22px;" />
<a href="<?= getFullURLLevel($_GET['r'],'frplan_vs_output_analysis_sunday.php',0,'N') ?>" style="margin-top:22px;" class="btn btn-warning">History</a>

</div>
</form>
<hr/>


<?php


if(isset($_POST['submit']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$dates_between=array();
	$dates_between=getDaysInBetween($sdate,$edate);
	echo "<div class='table-responsive'>";
	echo "<table class='table' border=1 bgcolor='white'>";
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
	".implode(",",$query_code)." FROM $bai_pro4.fastreact_plan WHERE production_date BETWEEN '$sdate' AND '$edate' GROUP BY CONCAT(group_code,bai_pro4.uExtractNumberFromString(style),module) ORDER BY module,style) as t group by module";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_count[$sql_row['module']]=$sql_row['count'];
	}

	$mod_chk=0;
	$sql="SELECT group_code,bai_pro4.uExtractNumberFromString(style) as style,module,
	".implode(",",$query_code)."
	FROM $bai_pro4.fastreact_plan WHERE production_date BETWEEN '$sdate' AND '$edate' GROUP BY CONCAT(group_code,bai_pro4.uExtractNumberFromString(style),module) ORDER BY module,style";
	// echo $sql."<br>";
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
			$sql1="SELECT date,SUM(act_out) as output FROM $bai_pro.grand_rep WHERE DATE BETWEEN '$sdate' AND '$edate' AND module=$mod_chk GROUP BY date";
			// echo $sql1."<br>";
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
			$sql1="SELECT date,SUM(act_out) as output FROM $bai_pro.grand_rep WHERE DATE BETWEEN '$sdate' AND '$edate' AND module=$mod_chk GROUP BY date";
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

echo "</table></div>";
$table.="</table>";
}


?>

<div id="div-1a">
<form  name="input1" action="<?= getFullURLLevel($_GET['r'],'plan_vs_output_analysis_excel.php',0,'R') ?>" method="post">

<input type="hidden" name="table" value="<?php echo $table; ?>">
<input type="submit" name="submit1" class='btn btn-info pull-right' value="Export to Excel">
</form>
</div>
</div></div>

<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>

<script>

	function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		// d1 = new Date(val1);
		// d2 = new Date(val2);
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}
</script>











