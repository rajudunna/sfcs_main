<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="refresh" content="120">
<title></title>
<meta name="" content="">
<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
	
</head>
<body bgcolor="#ffffff">

<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); ?>


<?php
	if(isset($_GET['module']))
	{
		$module=$_GET['module'];
	}
	else
	{
		$module=1;
	}
	?>
<?php 
//$dt="2012-01-28";
$dt=date("Y-m-d");
$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sec_id,sec_head,sec_mods from $bai_pro3.sections_db where sec_id=1");
while($result=mysqli_fetch_array($sql))
{
	$mods=$result["sec_mods"];
	$sec_id=$result["sec_id"];
	$head=$result["sec_head"];
}

$mods=$module;
echo "<table align=center><tr><th colspan=5></th></tr>";


for($i=1;$i<=16;$i++)
{
	if($i == 8 || $i == 16)
	{
		echo "<th>".$i."</th>";
		echo "<th>Shift Avg</th>";
	}
	else
	{
		echo "<th>".$i."</th>";
	}
	
}

echo "</tr>";

$modules=explode(",",$mods);
//echo sizeof($modules);

for($i=0;$i<sizeof($modules);$i++)
{
	$k=0;
	echo "<tr>";
	//echo "<th>".$modules[$i]."</th>";
	for($j=06;$j<=21;$j++)
	{		
	    $sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(bac_qty),bac_style,delivery,bac_shift,bac_stat from $bai_pro.bai_log_buf where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup=\"$dt $j:00:00\"");
		while($result=mysqli_fetch_array($sql))
		{
			$val=$result["sum(bac_qty)"];
			$style=$result["bac_style"];
			$schdule=$result["delivery"];
			$shift=$result["bac_shift"];
			$stat=$result["bac_stat"];
		}
		
		$sql1=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(bac_qty) from $bai_pro.bai_quality_log where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup=\"$dt $j:00:00\"");
		while($result1=mysqli_fetch_array($sql1))
		{
			$rew=$result1["sum(bac_qty)"];
		}
			//echo $rew;
		if($rew == 0 && $val == 0)
		{
			$per=0;
		}
		else
		{
			$per=($rew/($rew+$val))*100;
		}
		
		$title=str_pad("Style:".$style,80)."\n".str_pad("Schedule:".$schdule,80)."\n".str_pad("Output_Qty:".$val,80)."\n".str_pad("Rework_Qty:".$rew,80)."\n".str_pad("Rework % :".round($per,2),80)."\n".str_pad("Shift  :".$shift,80);
 
	    $k=$k+1;
		$l=$j+1;
		if($k == 8 || $k == 16)
		{			
			if($k==8)
			{
				$sta="06";
				$end="13";
			}
			else if($k==16)
			{
				$sta="14";
				$end="21";
			}
			
			if($stat == "Active")
			{
				if($val == "")
				{
					echo "<th><div style=\"border-style:solid;border-width:2px;border-color:black;font-size:12px;width:28px;height:28px;background-color:white;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
				}
				else
				{				    
						if($per<1)
						{
							echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:green;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
						}
						else if($per>=1 && $per<=2)
						{
							echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:yellow;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
						}
						else 
						{
							echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:red;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
						}
				 }		
			}
			else if($stat == "Down")
			{
				echo "<th><div style=\"font-size:12px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/4.jpg\"></img></div></th>";
			}
			else
			{
				echo "<th><div style=\"border-style:solid;border-width:2px;border-color:black;font-size:12px;width:28px;height:28px;background-color:white;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
			} 
			
			$sql_stat=mysqli_query($GLOBALS["___mysqli_ston"], "select count(bac_stat) from $bai_pro.bai_log_buf where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup between \"$dt $sta:00:00\" and \"$dt $end:00:00\" and bac_stat=\"Active\"");
            while($results=mysqli_fetch_array($sql_stat))
			{
				$stats=$results["count(bac_stat)"];
			}
			         
			$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(bac_qty),bac_style,delivery,bac_shift from $bai_pro.bai_log_buf where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup between \"$dt $sta:00:00\" and \"$dt $end:00:00\"");
			while($result2=mysqli_fetch_array($sql2))
			{
				$val1=$result2["sum(bac_qty)"];
				$style1=$result2["bac_style"];
				$schdule1=$result2["delivery"];
				$shift1=$result2["bac_shift"];
			}
			
			

			$sql11=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(bac_qty) from $bai_pro.bai_quality_log where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup between \"$dt $sta:00:00\" and \"$dt $end:00:00\"");
//echo "select sum(bac_qty) from $table1.$database1 where bac_date=\"$dt\" and bac_no=\"$i\" and bac_lastup \"$dt $sta:00:00\" and \"$dt $end:00:00\"";
			while($result11=mysqli_fetch_array($sql11))
			{
				$rew1=$result11["sum(bac_qty)"];
			}	
			if($rew1 == 0 && $val1 == 0)
			{
				$per1=0;
			}
			else
			{
				$per1=($rew1/($rew1+$val1))*100;
			}
			$title1=str_pad("Output_Qty:".$val1,80).str_pad("Rework_Qty:".$rew1,80).str_pad("Rework % :".round($per1,2),80).str_pad("Shift :".$shift1,80);;

			if($stats >= 1)
			{		
				if($val1 == "")
				{
					echo "<th><div style=\"border-style:solid;border-width:2px;border-color:black;font-size:12px;width:28px;height:28px;background-color:white;color:black;\" title=\"$title1\"><center>".$rew1."</center></div></th>";
				}
				else if($val1 == 0)
				{
					echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:orange;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
				}
				else
				{			   
						if($per1<1)
						{
							echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:green;color:black;\" title=\"$title1\"><center>".$rew1."</center></div></th>";
						}
						else if($per1>=1 && $per1<=2)
						{
							echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:yellow;color:black;\" title=\"$title1\"><center>".$rew1."</center></div></th>";
						}
						else 
						{
							echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:red;color:black;\" title=\"$title1\"><center>".$rew1."</center></div></th>";
						}								
				}
			}
			else
			{
				echo "<th><div style=\"font-size:12px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/4.jpg\"></img></div></th>";
			}
			        
		}
		else
		{
			//$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schdule,80).str_pad("Output_Qty:".$val,80).str_pad("Rework_Qty:".$rew,80).str_pad("Rework % :".round($per,2),80).str_pad("Shift :".$shift,80);;

		    if($stat == "Active")
			{
				if($val == "")
				{
					echo "<th><div style=\"border-style:solid;border-width:2px;border-color:black;font-size:12px;width:28px;height:28px;background-color:white;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
				}
				else if($val == 0)
				{
					echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:orange;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
				}
				else
				{
				    if($per<1)
					{
						echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:green;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
					}
					else if($per>=1 && $per<=2)
					{
						echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:yellow;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
					}
					else 
					{
						echo "<th><div style=\"font-size:12px;width:28px;height:28px;background-color:red;color:black;\" title=\"$title\"><center>".$rew."</center></div></th>";
					}
				}
			}	
			else if($stat == "Down")
			{
				echo "<th><div style=\"font-size:12px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/4.jpg\"></img></div></th>";
			}
			else
			{
				echo "<th><div align=\"center\"  style=\"border-style:solid;border-width:2px;border-color:black;display:table-cell;vertical-align:middle;font-size:12px;width:28px;height:28px;background-color:white;color:black;\" title=\"$title\">".$rew."</div></th>";
				//echo "<th><div  align='center' style='background:red; display:table-cell; width:28px; height:28px; vertical-align:middle;'>1 </div></th>";
			}
		}
	
	}
	echo "</tr>";
}

echo "</table>";
?>
</body>
</html>