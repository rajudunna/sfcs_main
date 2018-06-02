<!--
Core Module:In this interface we can get module wise plan details for fabric issuing priority.

Description: We can allocate fabric based on the plan priority.

Changes Log:
-->
<?php
set_time_limit(2000);
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
$section_no=$_GET['section_no'];
?>


<?php

//New Implementation to restrict as per time lines to update Planning Board 20111211
	/* $hour=date("H");
	$restricted_hours=array(7,8,9,15,16);
	if(in_array($hour,$restricted_hours))
	{
		header("Location:time_out.php?msg=2");
	} */
	
	$hour=date("H.i");
		
	//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
	if(($hour>=7.45 and $hour<=9.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
	//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
	{
		//header("Location:time_out.php?msg=2");
	}
	else
	{
		
	}
	
?>


<link rel="stylesheet" type="text/css" href="page_style.css" />



<style>
body
{
	/* font-family: Century Gothic;
	font-size: 10px; */
}
table{
	font-size:10px;
}
</style>

<div class="panel panel-primary">
<div class="panel-heading">Board Update</div>
<div class="panel-body">

<?php

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<tr><th colspan=10>Production Plan for Section - $section_no</th><th colspan=20 style='text-align:left;'>Date : ".date("Y-m-d H:i")."</th></tr>";
echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th>Remarks</th><th>Priority 8</th><th>Remarks</th><th>Priority 9</th><th>Remarks</th><th>Priority 10</th><th>Remarks</th><th>Priority 11</th><th>Remarks</th><th>Priority 12</th><th>Remarks</th><th>Priority 13</th><th>Remarks</th><th>Priority 14</th><th>Remarks</th></tr>";

$sqlx="select * from $bai_pro3.sections_db where sec_id>0 and sec_id=$section_no";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	
	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		echo "<tr>";
		echo "<td>".$mods[$x]."</td>";
		echo "<td align=\"right\">Style:<br/>Schedule:<br/>Job:<br/>Total Qty:</td>";
		$module=$mods[$x];
		
		$sql1="SELECT * FROM $bai_pro3.recut_v2 WHERE plan_module=$module and cut_inp_temp is null and remarks in (\"Body\",\"Front\") LIMIT 14";
		//echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row11=mysqli_fetch_array($sql_result1))
		{
			$order_tid=$sql_row11['order_tid'];
			$total_qty=($sql_row11['a_xs']+$sql_row11['a_s']+$sql_row11['a_m']+$sql_row11['a_l']+$sql_row11['a_xl']+$sql_row11['a_xxl']+$sql_row11['a_xxxl']+$sql_row11['a_s01']+$sql_row11['a_s02']+$sql_row11['a_s03']+$sql_row11['a_s04']+$sql_row11['a_s05']+$sql_row11['a_s06']+$sql_row11['a_s07']+$sql_row11['a_s08']+$sql_row11['a_s09']+$sql_row11['a_s10']+$sql_row11['a_s11']+$sql_row11['a_s12']+$sql_row11['a_s13']+$sql_row11['a_s14']+$sql_row11['a_s15']+$sql_row11['a_s16']+$sql_row11['a_s17']+$sql_row11['a_s18']+$sql_row11['a_s19']+$sql_row11['a_s20']+$sql_row11['a_s21']+$sql_row11['a_s22']+$sql_row11['a_s23']+$sql_row11['a_s24']+$sql_row11['a_s25']+$sql_row11['a_s26']+$sql_row11['a_s27']+$sql_row11['a_s28']+$sql_row11['a_s29']+$sql_row11['a_s30']+$sql_row11['a_s31']+$sql_row11['a_s32']+$sql_row11['a_s33']+$sql_row11['a_s34']+$sql_row11['a_s35']+$sql_row11['a_s36']+$sql_row11['a_s37']+$sql_row11['a_s38']+$sql_row11['a_s39']+$sql_row11['a_s40']+$sql_row11['a_s41']+$sql_row11['a_s42']+$sql_row11['a_s43']+$sql_row11['a_s44']+$sql_row11['a_s45']+$sql_row11['a_s46']+$sql_row11['a_s47']+$sql_row11['a_s48']+$sql_row11['a_s49']+$sql_row11['a_s50'])*$sql_row11['a_plies'];
			
			$sql111="select order_style_no,order_del_no,order_col_des from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row111=mysqli_fetch_array($sql_result111))
			{
				$style=$sql_row111['order_style_no'];
				$schedule=$sql_row111['order_del_no'];
				$color=$sql_row111['order_col_des'];
			}
			
			
			
			//echo "<td>"."Style:".$style."<br/>"."Schedule:".$schedule."<br/>"."Job:".chr($color_code).leading_zeros($cut_no,3)."<br/>"."Total Qty:".$total_qty."</td><td></td>";
			echo "<td>".$style."<br/><strong>".$schedule."<br/>"."</strong><br/>".$total_qty."</td><td>F.L.: <Br/>B.L.: </br>Col:"."</br></td>";

		}
		
		for($i=1;$i<=14-$sql_num_check;$i++)
		{
			echo "<td></td><td></td>";
		}
		echo "</tr>";
	}
}

echo "</table>";
?>
</div>
</div>
</div>
