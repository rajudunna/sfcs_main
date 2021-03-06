<!--
Core Module:In this interface we can get module wise plan details for fabric issuing priority.

Description: We can allocate fabric based on the plan priority.

Changes Log:
-->
<?php
set_time_limit(2000);
include("dbconf.php"); 
include("functions.php"); 
$section_no=$_GET['section_no'];
header("Location:board_update_V2.php?section_no=$section_no");
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

<html>
<head>
<link rel="stylesheet" type="text/css" href="page_style.css" />
<title>Board Update</title>


<style>
body
{
	font-family: Century Gothic;
	font-size: 10px;
}
table{
	font-size:10px;
}
</style>
</head>
<body>
<?php


echo "<table>";
echo "<tr><th colspan=10>Production Plan for Section - $section_no</th><th colspan=6>".date("Y-m-d H:i")."</th></tr>";
echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th>Remarks</th></tr>";

$sqlx="select * from sections_db where sec_id>0 and sec_id=$section_no";
mysql_query($sqlx,$link) or exit("Sql Error".mysql_error());
$sql_resultx=mysql_query($sqlx,$link) or exit("Sql Error".mysql_error());
while($sql_rowx=mysql_fetch_array($sql_resultx))
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
		
		$sql1="SELECT * FROM plan_dash_doc_summ WHERE module=$module and order_tid is not null ORDER BY priority LIMIT 7";
		//echo $sql1."<br/>";
		mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		$sql_num_check=mysql_num_rows($sql_result1);
		while($sql_row1=mysql_fetch_array($sql_result1))
		{
			$cut_new=$sql_row1['act_cut_status'];
			$cut_input_new=$sql_row1['act_cut_issue_status'];
			$rm_new=strtolower(chop($sql_row1['rm_date']));
			$rm_update_new=strtolower(chop($sql_row1['rm_date']));
			$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
			$doc_no=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['total'];
			
			$cut_no=$sql_row1['acutno'];
			$color_code=$sql_row1['color_code'];
			
			$bundle_location="";
			if(sizeof(explode("$",$sql_row1['bundle_location']))>1)
			{
				$bundle_location=end(explode("$",$sql_row1['bundle_location']));
			}
			$fabric_location="";
			if(sizeof(explode("$",$sql_row1['plan_lot_ref']))>1)
			{
				$fabric_location=end(explode("$",$sql_row1['plan_lot_ref']));
			}
			
			//For Color Clubbing
			unset($club_c_code);
			$club_c_code=array();
			if($sql_row1['clubbing']>0)
			{
					
				$total_qty=0;
				$sql11="select order_col_des,color_code,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies as total from order_cat_doc_mk_mix where category in ($in_categories) and order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];
				//echo $sql11."<br/>";
				$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
				while($sql_row11=mysql_fetch_array($sql_result11))
				{
					$club_c_code[]=chr($sql_row11['color_code']).leading_zeros($sql_row1['acutno'],3);
					$total_qty+=$sql_row11['total'];
				}
			}
			else
			{
				$club_c_code[]=chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);
			}
			
			$club_c_code=array_unique($club_c_code);
			
			//echo "<td>"."Style:".$style."<br/>"."Schedule:".$schedule."<br/>"."Job:".chr($color_code).leading_zeros($cut_no,3)."<br/>"."Total Qty:".$total_qty."</td><td></td>";
echo "<td>".$style."<br/><strong>".$schedule."<br/>".implode(", ",$club_c_code)."</strong><br/>".$total_qty."</td><td>F.L.: $fabric_location<Br/>B.L.: $bundle_location</br></td>";

		}
		
		for($i=1;$i<=7-$sql_num_check;$i++)
		{
			echo "<td></td><td></td>";
		}
		echo "</tr>";
	}
}

echo "</table>";
?>
</body>

</html>
