
<?php 

// include"header.php";
// include"downtimeperperiode.php"; 
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURL($_GET['r'],'downtimeperperiode.php','R'));

?>
<div id="Book1_7326" align=center x:publishsource="Excel">

<?php

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
//echo $username;
/*if($username == "kirang")
{*/
?>

<div class="panel panel-primary">
<div class="panel-body">
<h2 align="center" class='label label-warning'><b>Department DownTime For Sections</b></h2>
<hr/>

<div class="table-responsive">
<table class="table table-bordered">
 <col width=103 style='mso-width-source:userset;mso-width-alt:3766;width:77pt'>
 <col width=86 span=6 style='mso-width-source:userset;mso-width-alt:3145;
 width:65pt'>
 <col width=66 style='mso-width-source:userset;mso-width-alt:2413;width:50pt'>
 <col width=86 style='mso-width-source:userset;mso-width-alt:3145;width:65pt'>
 <tr height=40 style='height:30.0pt'>
  <td height=40 class=xl637326 width=103 style='height:30.0pt;width:77pt; '>Deprtment Name</td>
  <?php
        $sec_id=array();
		$sql="SELECT sec_id as sec_id FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
		//echo $sql;
		$result7=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($result7))
		{
			$sec_id[]=$sql_row["sec_id"];
			//$sql_mod[]=$sql_row["mods"];
		}
		for($i=0;$i<sizeof($sec_id);$i++)
		{
			$sql12="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=".$sec_id[$i];
			$result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row12=mysqli_fetch_array($result12))
			{
				$section_display_name=$sql_row12["section_display_name"];
			}

			echo "<td class=xl647326 width=86 style='border-left:none;width:65pt;'>".$section_display_name."</td>";
		}
		
  echo "<td class=xl637326 width=66 style='border-left:none;width:50pt;'>Today Total</td>";
  echo "<td class=xl637326 width=86 style='border-left:none;width:65pt;'>CUM LOST HRS</td>";
 echo "</tr>";
 


$stodat=date("Y-m-01");
$etodat=$_GET["edat"];

$sdat=$_GET["sdat"];
$edat=$_GET["edat"];

$edat_explode=explode("-",$edat);
$m=$edat_explode[1];
$d=$edat_explode[2];
//echo "Month = ".$m;

$sql="select * from $bai_pro.down_deps";
$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$dep_id=$row["dep_id"];
	$dep_name=$row["dep_name"];
	echo "<tr height=20 style='height:15.0pt'>";
	echo "<td class=xl687325 width=86 style='width:65pt;'>".$dep_name."</td>";
	
		
	for($i=0;$i<sizeof($sec_id);$i++)
	{
		$sql1="select sum(dtime) from $bai_pro.down_log where section=".$sec_id[$i]." and department=".$dep_id." and date=\"".$edat."\"";
		//echo $sql1.";</br>";
		$result1=mysqli_query($link, $sql1) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($result1))
		{
			echo "<td class=xl687325 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
		}	
	}
	
	$sql1="select sum(dtime) from $bai_pro.down_log where section in (".implode(",",$sec_id).") and department=".$dep_id." and date=\"".$edat."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
	}
	
	$sql1="select sum(dtime) from $bai_pro.down_log where section in (".implode(",",$sec_id).") and department=".$dep_id." and date between \"".date("Y-$m-01")."\" and \"".date("Y-$m-$d")."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
	}
	
	echo "</tr>";	
}

echo "<tr><td class=xl637326 style='height:15.0pt;border-top:none'>Today Lost Hrs</td>";

for($i=0;$i<sizeof($sec_id);$i++)
{
	$sql1="select sum(dtime) from $bai_pro.down_log where section=".$sec_id[$i]." and date=\"".$edat."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$lost_day_sec[]=round($row1["sum(dtime)"]/60,0);
		echo "<td class=xl637326 style='height:15.0pt;border-top:none'>".round($row1["sum(dtime)"]/60,0)."</td>";
	}	
}

$sql1="select sum(dtime) from $bai_pro.down_log where section in (".implode(",",$sec_id).") and date=\"".$edat."\"";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	$total_dtime=round($row1["sum(dtime)"]/60,0);
	echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
}	

$sql1="select sum(dtime) from $bai_pro.down_log where section in (".implode(",",$sec_id).") and date between \"".date("Y-$m-01")."\" and \"".date("Y-$m-$d")."\"";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
}	

echo "</tr>";

//cumlative of loast hours of this month

echo "<tr><td class=xl637326 style='height:15.0pt;border-top:none'>CUM LOST HRS</td>";

for($i=0;$i<sizeof($sec_id);$i++)
{
	$sql1="select sum(dtime) from $bai_pro.down_log where section=".$sec_id[$i]." and date between \"".date("Y-$m-01")."\" and \"".date("Y-$m-$d")."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td class=xl637326 style='height:15.0pt;border-top:none'>".round($row1["sum(dtime)"]/60,0)."</td>";
	}	
}

$sql1="select sum(dtime) from $bai_pro.down_log where section in (".implode(",",$sec_id).") and date between \"".date("Y-$m-01")."\" and \"".date("Y-$m-$d")."\"";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
}		

//extra added
$sql1="select sum(dtime) from $bai_pro.down_log where section in (".implode(",",$sec_id).") and date between \"".date("Y-$m-01")."\" and \"".date("Y-$m-$d")."\"";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(dtime)"]/60,0)."</td>";
}	

echo "</tr>";

//clock hours of today

echo "<tr><td class=xl637326 style='height:15.0pt;border-top:none'>Today Clock Hrs</td>";

for($i=0;$i<sizeof($sec_id);$i++)
{
	$sql1="select sum(act_clh) from $bai_pro.grand_rep where section=".$sec_id[$i]." and date between \"".$etodat."\" and \"".$etodat."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$clh_sec[]=round($row1["sum(act_clh)"],0);
		echo "<td class=xl637326 style='height:15.0pt;border-top:none'>".round($row1["sum(act_clh)"],0)."</td>";
	}	
}

$sql1="select sum(act_clh) from $bai_pro.grand_rep where date between \"".$etodat."\" and \"".$etodat."\"";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	$total_clh=round($row1["sum(act_clh)"],0);
	echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(act_clh)"],0)."</td>";
}	
//extra added

$sql1="select sum(act_clh) from $bai_pro.grand_rep where date between \"".$etodat."\" and \"".$etodat."\"";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	$total_clh=round($row1["sum(act_clh)"],0);
	echo "<td class=xl667326 width=86 style='width:65pt;'>".round($row1["sum(act_clh)"],0)."</td>";
}		

echo "</tr>";

//Total Lost time %

echo "<tr height=20 style='height:15.0pt'><td class=xl637326>Total Lost Time%</td>";

for($i=0;$i<sizeof($clh_sec);$i++)
{
	//$lost_per=$lost_per+round($lost_day_sec[$i]*100/$clh_sec[$i],2);
	if($clh_sec[$i] == 0)
	{
		echo "<td class=xl637326 style='height:15.0pt;border-top:none'>0%</td>";
		$lost_per=$lost_per+0;
	}
	else
	{
		echo "<td class=xl637326 style='height:15.0pt;border-top:none'>".round($lost_day_sec[$i]*100/$clh_sec[$i],2)."%</td>";
		$lost_per=$lost_per+round($lost_day_sec[$i]*100/$clh_sec[$i],2);
	}
	//echo "<td class=xl667326 width=86 style='width:65pt;'>".round($lost_day_sec[$i]*100/$clh_sec[$i],2)."%</td>";
}

echo "<td class=xl667326 width=86 style='width:65pt;'>".round($lost_per/6,2)."%</td>";
//extra added
echo "<td class=xl667326 width=86 style='width:65pt;'>".round($lost_per/6,2)."%</td>";

echo "</tr>";

/*}
else
{
	echo "<br/><br/><br/><h2 style=\"color:black;\"> The webpage under construction. Please wait for some time to view the webpage</h2> ";
}*/

?>
</table>
</div>
</div>
</div>
</div>

