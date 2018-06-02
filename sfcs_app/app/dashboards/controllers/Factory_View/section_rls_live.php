<?php
//KIRANG-2015-03-03 CR# 295
//Added per1 variable besides the image to show the rework % value.

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="refresh" content="120">
<title></title>
<meta name="" content="">

<style>
	body
{
	background-color:#eeeeee;
	color: #000000;
	font-family: Trebuchet MS;
}
	
	img{
		zoom: 75%;
	}
</style>
</head>
<body bgcolor="#ffffff">

<?php 
// error_reporting(0);
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
//$dt="2011-09-28";
$dt=date("Y-m-d");
$sec_x=$_GET['sec_x'];
$sql=mysqli_query($link, "select sec_id,sec_head,sec_mods from $bai_pro3.sections_db where sec_id=$sec_x");
while($result=mysqli_fetch_array($sql))
{
	$mods=$result["sec_mods"];
	$sec_id=$result["sec_id"];
	$head=$result["sec_head"];
}

echo '<div style="width:160px;background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
	echo "<p>";
echo "<table align=left><tr><th colspan=5><H2>RLS</H2></th></tr>";


for($i=1;$i<=16;$i++)
{
	if($i == 8 || $i == 16)
	{
		//echo "<th>".$i."</th>";
		//echo "<th>Shift Avg</th>";
	}
	else
	{
		//echo "<th>".$i."</th>";
	}
	
}


$modules=explode(",",$mods);
//echo sizeof($modules);

for($i=0;$i<sizeof($modules);$i++)
{
	$k=0;
	echo "<tr>";
	echo "<td>".$modules[$i]."</td>";
	//for($j=06;$j<=21;$j++)
	{		
	    $sql=mysqli_query($link, "select sum(bac_qty),bac_style,delivery,bac_shift,bac_stat from $bai_pro.bai_log_buf where bac_date=\"$dt\" and bac_no in ($mods)");
		while($result=mysqli_fetch_array($sql))
		{
			$val=$result["sum(bac_qty)"];
			$style=$result["bac_style"];
			$schdule=$result["delivery"];
			$shift=$result["bac_shift"];
			$stat=$result["bac_stat"];
		}
		
		$sql1=mysqli_query($link, "select sum(bac_qty) from $bai_pro.bai_quality_log where bac_date=\"$dt\" and bac_no in ($mods)");
		while($result1=mysqli_fetch_array($sql1))
		{
			$rew=$result1["sum(bac_qty)"];
		}
			
		if($rew == 0 && $val == 0)
		{
			$per=0;
		}
		else
		{
			$per=($rew/($rew+$val))*100;
		}
		
		$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schdule,80).str_pad("Output_Qty:".$val,80).str_pad("Rework_Qty:".$rew,80).str_pad("Rework % :".round($per,2),80).str_pad("Shift  :".$shift,80);
 
	    //$k=$k+1;
		//$l=$j+1;
		$k=8;
		if($k == 8 || $k == 16)
		{			
			
				$sta="06";
				$end="21";
			/*			
			if($stat == "Active")
			{
				if($val == "")
				{
					echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/imagesCA3H59TI.jpg\"></img></div></th>";
				}
				else
				{				    
						if($per<1)
						{
							echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/smiley_mood_happy_green.png\"></img></div></th>";
						}
						else if($per>=1 && $per<=2)
						{
							echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/es-smi-0060_200.jpg\"></img></div></th>";
						}
						else 
						{
							echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/frowny-face-clip-art.jpg\"></img></div></th>";
						}
				 }		
			}
			else if($stat == "Down")
			{
				echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/120px-Cross_mark_red_setting_white_smoke_svg.png\"></img></div></th>";
			}
			else
			{
				echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/imagesCA3H59TI.jpg\"></img></div></th>";
			} 
			*/
			$sql_stat=mysqli_query($link, "select count(bac_stat) from $bai_pro.bai_log_buf where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup between \"$dt $sta:00:00\" and \"$dt $end:00:00\" and bac_stat=\"Active\"");
            while($results=mysqli_fetch_array($sql_stat))
			{
				$stats=$results["count(bac_stat)"];
			}
			         
			$sql2=mysqli_query($link, "select sum(bac_qty),bac_style,delivery,bac_shift from $bai_pro.bai_log_buf where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup between \"$dt $sta:00:00\" and \"$dt $end:00:00\"");
			while($result2=mysqli_fetch_array($sql2))
			{
				$val1=$result2["sum(bac_qty)"];
				$style1=$result2["bac_style"];
				$schdule1=$result2["delivery"];
				$shift1=$result2["bac_shift"];
			}
			
			

			$sql11=mysqli_query($link, "select sum(bac_qty) from $bai_pro.bai_quality_log where bac_date=\"$dt\" and bac_no=\"$modules[$i]\" and bac_lastup between \"$dt $sta:00:00\" and \"$dt $end:00:00\"");
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
			$title1=str_pad("Output_Qty:".$val1,80).str_pad("Rework_Qty:".$rew1,80).str_pad("Rework % :".round($per1,2),80);
			$per1=round($per1,2);
			if($stats >= 1)
			{		
				if($val1 == "")
				{
					echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title1\"><img src=\"../../common/images/imagesCA3H59TI.jpg\"></img>$per1</div></th>";
				}
				else if($val1 == 0)
				{
					echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/orange_smiley_frown.png\"></img>$per1</div></th>";
				}
				else
				{			   
						if($per1<1)
						{
							echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title1\"><img src=\"../../common/images/smiley_mood_happy_green.png\"></img>$per1</div></th>";
						}
						else if($per1>=1 && $per1<=2)
						{
							echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title1\"><img src=\"../../common/images/es-smi-0060_200.jpg\"></img>$per1</div></th>";
						}
						else 
						{
							echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title1\"><blink><img src=\"../../common/images/frowny-face-clip-art.jpg\"></img></blink>$per1</div></th>";
						}								
				}
			}
			else
			{
				echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/120px-Cross_mark_red_setting_white_smoke_svg.png\"></img>$per1</div></th>";
			}
			        
		}
		else
		{
			//$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schdule,80).str_pad("Output_Qty:".$val,80).str_pad("Rework_Qty:".$rew,80).str_pad("Rework % :".round($per,2),80).str_pad("Shift :".$shift,80);;
/*
		    if($stat == "Active")
			{
				if($val == "")
				{
					echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/imagesCA3H59TI.jpg\"></img></div></th>";
				}
				else if($val == 0)
				{
					echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/orange_smiley_frown.png\"></img></div></th>";
				}
				else
				{
				    if($per<1)
					{
						echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/smiley_mood_happy_green.png\"></img></div></th>";
					}
					else if($per>=1 && $per<=2)
					{
						echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/es-smi-0060_200.jpg\"></img></div></th>";
					}
					else 
					{
						echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/frowny-face-clip-art.jpg\"></img></div></th>";
					}
				}
			}	
			else if($stat == "Down")
			{
				echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/120px-Cross_mark_red_setting_white_smoke_svg.png\"></img></div></th>";
			}
			else
			{
				echo "<th><div style=\"font-size:10px; text-align:center;\" title=\"$title\"><img src=\"../../common/images/imagesCA3H59TI.jpg\"></img></div></th>";
			}
*/
		}
	
	}
	echo "</tr>";
}

echo "</table>";
echo "</p>";
	echo '</div>';
?>
</body>
</html>