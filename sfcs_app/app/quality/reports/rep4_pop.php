<!--
Change Log:

2014-12-3 / kirang / service request #268415 : Added new rejection details In report level 

2015-02-04 / kirang / Service Request #241090 / Added the Machine damages to correct the data accuracy. 

2016-01-18/Naresh B/SR#65771237 /Module numbers are not in order in rejection summary report
-->
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php  include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

//$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");
$reasons=array("Miss Yarn","Fabric Holes","Slub","F.Yarn","Stain Mark","Color Shade","Heat Seal","Trim","Panel Un-Even","Stain Mark","Strip Match","Cut Damage","Heat Seal","M' ment Out","Un Even","Shape Out Leg","Shape Out waist","Shape Out","Stain Mark","With out Label","Trim shortage","Sewing Excess","Cut Holes","Slip Stitch’s","Oil Marks","Others EMB","Foil Defects","Embroidery","Print","Sequence","Bead","Dye","wash");


?>

<html>
<head>

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

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


.BG {
background-image:url(Diag.gif);
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
}
</style>

</head>
<body>



<?php

if(isset($_GET['section']))
{
	
	$sdate=$_GET['sdate'];
	$edate=$_GET['edate'];
	$team=str_replace("*","'",$_GET['team']);

	
	echo "<h3><u>Module Breakup of Section -".$_GET['section']."</u></h3>";
	echo "<table class='tblheading'>";
	echo "<tr>";
	echo "<th>Module</th>";
	echo "<th>Output</th>";
	echo "<th>Rework</th>";
	echo "<th>%</th>";
	echo "<th>Rejection</th>";
	echo "<th>Fabric</th>";
	echo "<th>Cutting</th>";
	echo "<th>Sewing</th>";
	echo "<th>Trim Shortage</th>";
	echo "<th>Sewing Excess</th>";
	echo "<th>Embellishment</th>";
	echo "<th>Machine</th>";
	echo "<th>%</th>";
	echo "</tr>";
	$fab_tot=0;
	$cut_tot=0;
	$sew_tot=0;
	$emb_tot=0;
	$out_tot=0;
	$mac_tot=0;
	$qms_tot=0;
	$sew_exces_tot=0;
	$trim_tot=0;
	$rework_tot=0;
	//2016-01-18/Naresh B/SR#65771237 
	$sql="select sum(act_out) as \"output\", sum(rework_qty) as \"rework\", group_concat(distinct module) as \"module\",section from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" and section=".$_GET['section']." and shift in ($team) group by module*1";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['module']."</td>";
		echo "<td>".$sql_row['output']."</td>";
		$qms_qty=0;
		
		$sql1="select group_concat(ref1 SEPARATOR \"$\") as \"ref1\", sum(qms_qty) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and substring_index(remarks,\"-\",1)=\"".$sql_row['module']."\" and log_date between \"$sdate\" and \"$edate\" and substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in ($team)";
		//echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$vals=array();
			for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
			
			$temp=array();
			$temp=explode("$",str_replace(",","$",$sql_row1['ref1']));
			
			for($i=0;$i<sizeof($temp);$i++)
			{
				if(strlen($temp[$i])>0)
				{
					$temp2=array();
					$temp2=explode("-",$temp[$i]);
					$x=$temp2[0];
					$vals[$x]+=$temp2[1];
				}
			}
						
			$fab_tot= $fab_tot + ($vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16]);
			$cut_tot= $cut_tot + ($vals[6]+$vals[7]+$vals[8]);
			$sew_tot= $sew_tot + ($vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]);
			$trim_tot= $trim_tot + ($vals[21]+$vals[20]);
			$sew_exces_tot= $sew_exces_tot + ($vals[22]);
			$emb_tot= $emb_tot + ($vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32]);
			$mac_tot= $mac_tot + ($vals[23]+$vals[24]+$vals[25]);
			
			$fab_tot_mod= ($vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16]);
			$cut_tot_mod= ($vals[6]+$vals[7]+$vals[8]);
			$sew_tot_mod= ($vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]);
			$trim_tot_mod= ($vals[21]+$vals[20]);
			$sew_exces_tot_mod= ($vals[22]);
			$emb_tot_mod= ($vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32]);
			$mac_tot_mod= ($vals[23]+$vals[24]+$vals[25]);
			
			$qms_qty= $vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16]+$vals[6]+$vals[7]+$vals[8]+$vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22]+$vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32]+$vals[23]+$vals[24]+$vals[25];
			//$qms_qty=array_sum($vals);
			//$qms_tot= $qms_tot + $sql_row1['qms_qty'];
		}
		
		$out_tot = $out_tot + $sql_row['output'];
		$rework_tot=$rework_tot+$sql_row['rework'];
		echo "<td>".$sql_row['rework']."</td>";
		if($sql_row['output']>0)
		{
			echo "<td>".round(($sql_row['rework']/$sql_row['output'])*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "<td>".$qms_qty."</td>";
		echo "<td>".$fab_tot_mod."</td>";
		echo "<td>".$cut_tot_mod."</td>";
		echo "<td>".$sew_tot_mod."</td>";
		echo "<td>".$trim_tot_mod."</td>";
		echo "<td>".$sew_exces_tot_mod."</td>";
		echo "<td>".$emb_tot_mod."</td>";
		echo "<td>".$mac_tot_mod."</td>";
		
		if($sql_row['output']>0)
		{
			echo "<td>".round(($qms_qty/$sql_row['output'])*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "</tr>";
	} 
	$qms_tot= $sew_tot+$fab_tot+$emb_tot+$cut_tot+$mac_tot+$trim_tot+$sew_exces_tot;
	$bgcolor="#99EEEE";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Sewing</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$sew_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($sew_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Fabric</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$fab_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($fab_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Cutting</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$cut_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($cut_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Embellishment</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$emb_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($emb_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Machine</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$mac_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($mac_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}

		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Sewing Excess</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$sew_exces_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($sew_exces_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}

		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Trim Shortage</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$trim_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($trim_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}

		echo "</tr>";
		
		
		echo "<tr bgcolor=\"yellow\">";
		echo "<td>Grand Total</td>";
		echo "<td>$out_tot</td>";
		echo "<td>$rework_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($rework_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "<td>$qms_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($qms_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
echo "</table>";


}

if(isset($_GET['style']))
{
	
	$sdate=$_GET['sdate'];
	$edate=$_GET['edate'];
	$style_input=$_GET['style'];
	$delivery_input=$_GET['delivery'];
	$team=str_replace("*","'",$_GET['team']);

	
	echo "<h3>Module Breakup of Style -".$_GET['style']."</h3>";
	echo "<table>";
	echo "<tr>";
	echo "<th>Module</th>";
	echo "<th>Output</th>";
	echo "<th>Rework</th>";
	echo "<th>%</th>";
	echo "<th>Rejection</th>";
	echo "<th>%</th>";
	echo "</tr>";
	$fab_tot=0;
	$cut_tot=0;
	$sew_tot=0;
	$emb_tot=0;
	$out_tot=0;
	$qms_tot=0;
	$mac_tot=0;
	$rework_tot=0;
	//2016-01-18/Naresh B/SR#65771237 
	$sql="select sum(bac_qty) as \"output\", bac_no as \"module\" from $bai_pro.bai_log where bac_date between \"$sdate\" and \"$edate\" and bac_style='".$style_input."' and delivery in (".$_GET['delivery'].") and bac_shift in ($team) group by module*1";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['module']."</td>";
		echo "<td>".$sql_row['output']."</td>";
		$qms_qty=0;
		
		$sql1="select group_concat(ref1 SEPARATOR \"$\") as \"ref1\", sum(qms_qty) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and substring_index(remarks,\"-\",1) in (".$sql_row['module'].") and qms_schedule in (".$_GET['delivery'].") and log_date between \"$sdate\" and \"$edate\" and substring_index(substring_index(remarks,\"-\",2),\"-\",-1)in ($team)";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$vals=array();
			for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
			
			$temp=array();
			$temp=explode("$",str_replace(",","$",$sql_row1['ref1']));
			
			for($i=0;$i<sizeof($temp);$i++)
			{
				if(strlen($temp[$i])>0)
				{
					$temp2=array();
					$temp2=explode("-",$temp[$i]);
					$x=$temp2[0];
					$vals[$x]+=$temp2[1];
				}
			}
			
			$fab_tot= $fab_tot + ($vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16]);
			$cut_tot= $cut_tot + ($vals[6]+$vals[7]+$vals[8]);
			$sew_tot= $sew_tot + ($vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22]);
			$emb_tot= $emb_tot + ($vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32]);
			$mac_tot= $mac_tot + ($vals[23]+$vals[24]+$vals[25]);
			$qms_qty= $vals[0]+$vals[1]+$vals[2]+$vals[3]+$vals[4]+$vals[5]+$vals[15]+$vals[16]+$vals[6]+$vals[7]+$vals[8]+$vals[9]+$vals[11]+$vals[12]+$vals[17]+$vals[18]+$vals[19]+$vals[13]+$vals[10]+$vals[20]+$vals[21]+$vals[22]+$vals[14]+$vals[26]+$vals[27]+$vals[28]+$vals[29]+$vals[30]+$vals[31]+$vals[32]+$vals[23]+$vals[24]+$vals[25];
			
			//$qms_qty=array_sum($vals);
			//$qms_tot= $qms_tot + $sql_row1['qms_qty'];
		}
		
		$out_tot = $out_tot + $sql_row['output'];
		
		$rework=0;
		$sql1="select COALESCE(sum(bac_qty),0) as \"rework\" from $bai_pro.bai_quality_log where delivery in (".$_GET['delivery'].") and bac_no in (".$sql_row['module'].") and bac_date between \"$sdate\" and \"$edate\" and bac_shift in ($team)";
//echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$rework=$sql_row1['rework'];
			$rework_tot= $rework_tot + $rework;
		}
		
		echo "<td>".$rework."</td>";
		if($sql_row['output']>0)
		{
			echo "<td>".round(($rework/$sql_row['output'])*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "<td>".$qms_qty."</td>";
		if($sql_row['output']>0)
		{
			echo "<td>".round(($qms_qty/$sql_row['output'])*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "</tr>";
	} 
	$qms_tot=$sew_tot+$emb_tot+$cut_tot+$fab_tot+$mac_tot;
	$bgcolor="#99EEEE";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Sewing</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$sew_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($sew_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Fabric</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$fab_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($fab_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Cutting</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$cut_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($cut_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Embellishment</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$emb_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($emb_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		

		echo "</tr>";
		
		echo "<tr bgcolor=\"$bgcolor\">";
		echo "<td>Machine</td>";
		echo "<td>$out_tot</td>";
		echo "<td colspan=2></td>";
		echo "<td>$mac_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($mac_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}

		echo "</tr>";
		
		echo "<tr bgcolor=\"yellow\">";
		echo "<td>Grand Total</td>";
		echo "<td>$out_tot</td>";
		echo "<td>$rework_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($rework_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		echo "<td>$qms_tot</td>";
		if($out_tot>0)
		{
			echo "<td>".round(($qms_tot/$out_tot)*100,2)."%</td>";
		}
		else
		{
			echo "<td>0%</td>";
		}
		
		echo "</tr>";
echo "</table>";


}

?>

</body>
</html>