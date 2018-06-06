
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0068",$username,1,$group_id_sfcs); 
?>

<!---<div id="page_heading"><span style="float"><h3>Module/Style Downtime Report</h3></span><span style="float"><b>?</b>&nbsp;</span></div> -->

<div class="panel panel-primary">
<!-- <div class="panel-heading">Module/Style Downtime Report</div> -->
<div class="panel-heading">Module Downtime Report</div>
<div class="panel-body">

<?php

$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));
$month=date("m", mktime(0,0,0,date("m") ,date("d"),date("Y")));


	
	echo "<div class='table-responsive'><table id=\"info\" class=\"table table-bordered\">";
	echo "<tr style='background-color:#286090;color:white;'><th>Mod No</th><th>Style</th><th>Status</th>";

	$sql="select * from $bai_pro.down_deps order by dep_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<th>".$sql_row['dep_name']."</th>";
	}

	echo "<th>Total (Min)</th><th>Off Std. HRS</th></tr>";
	
	$sql="select distinct mod_no from $bai_pro.pro_mod where month(mod_date)=$month ORDER BY mod_no*1";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod=$sql_row['mod_no'];
		echo "<tr><td rowspan=2>".$mod."</td>";
		
/* NEW */
$styledb="";
		$stylecount=0;
		
		$sql2="select count(distinct style) as \"count\" from $bai_pro.down_log where mod_no=$mod and date=\"$date\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$stylecount=$sql_row2['count'];
		}

		if($stylecount>1)
		{
			$sql2="select distinct style from $bai_pro.down_log where mod_no=$mod and date=\"$date\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$styledb=$styledb.$sql_row2['style']."/";
			}
			$styledb=substr_replace($styledb ,"",-1);
		}
		else
		{
			$sql2="select distinct style from $bai_pro.down_log where mod_no=$mod and date=\"$date\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$styledb=$styledb.$sql_row2['style'];
			}
		}

/* NEW  END */

		
		echo "<td>".$styledb."</td>";
		echo "<td bgcolor=#66ff00>Today</td>";
	
		$total=0;

		$sql3="select * from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$dep=$sql_row3['dep_id'];
	
			$sql2="select sum(dtime) as \"sum\" from $bai_pro.down_log where mod_no=$mod and date=\"$date\" and department=\"$dep\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$sum=$sql_row2['sum'];
				if($sum==0)
				{
					$sum=0;
				}
				echo "<td>".round($sum,2)."</td>";	
				$total=$total+$sum;
			}	
		}
		echo "<td>".round($total,2)."</td>";
		echo "<td>".round(($total/60),2)."</td></tr>";




/* NEW */
$styledb="";
		$stylecount=0;
		
		$sql2="select count(distinct style) as \"count\" from $bai_pro.down_log where mod_no=$mod and month(date)=$month";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$stylecount=$sql_row2['count'];
		}

		if($stylecount>1)
		{
			$sql2="select distinct style from $bai_pro.down_log where mod_no=$mod and month(date)=$month";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$styledb=$styledb.$sql_row2['style']."/";
			}
			$styledb=substr_replace($styledb ,"",-1);
		}
		else
		{
			$sql2="select distinct style from $bai_pro.down_log where mod_no=$mod and month(date)=$month";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$styledb=$styledb.$sql_row2['style'];
			}
		}

/* NEW  END */


	
		
		echo "<tr><td>".$styledb."</td>";
		echo "<td bgcolor=#99ffff>MTD</td>";
		$total=0;

		$sql3="select * from $bai_pro.down_deps order by dep_id";
		mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$dep=$sql_row3['dep_id'];
	
			$sql2="select sum(dtime) as \"sum\" from $bai_pro.down_log where mod_no=$mod and month(date)=$month and department=\"$dep\"";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$sum=$sql_row2['sum'];
				if($sum==0)
				{
					$sum=0;
				}
				echo "<td bgcolor=#99ffff>".round($sum,2)."</td>";	
				$total=$total+$sum;
			}	
		}
		echo "<td bgcolor=#99ffff>".round($total,2)."</td>";
		echo "<td bgcolor=#99ffff>".round(($total/60),2)."</td></tr>";
	
	}
	echo "</table></div>";



?>

</div>
</div>
</div>
