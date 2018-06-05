<!-- <style type="text/css" media="screen">
body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
th
{
    background-color: #003366;
    color: WHITE;
    border-bottom: 5px solid white;
    border-top: 5px solid white;
    padding: 5px;
    white-space:nowrap;
    border-collapse:collapse;
    font-family:Calibri;
    font-size:110%;
	text-align:center;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
	border:1px;
}
th{ background-color:#003366; color:#000000; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style> -->

<?php

include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
error_reporting(0);
$start=$_GET['dat1'];
$end=$_GET['dat2'];
$sec=$_GET['sec'];
$cat=$_GET['cat'];

// echo $start."---".$end;
include("../".getFullURL($_GET['r'],'exp_mod_main.php',0,'R'));

$sql1_query = "select sec_mods from $bai_pro3.sections_db where sec_id='$sec'";
$sql1=mysqli_query($link, $sql1_query) or exit("sql1_query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//var_dump($sql1_query);
while($row1=mysqli_fetch_array($sql1))
{
	$sections = $row1['sec_mods']; 
}

$secs=explode(",",$sections);
//print_r($secs);
$i=1;
if(mysqli_num_rows($sql1)> 0) {
echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>";
echo "<tr>";
echo "<th style=\"background-color:#29759C; color:white;\">Module</th>";
echo "<th style=\"background-color:#29759C; color:white;\">Style</th>";
echo "<th style=\"background-color:#29759C; color:white;\">Details</th>";

$pre_date="";

$start_date = $start; 
$pre_date = date ("Y-m-d", strtotime ("-1 day", strtotime($start_date))); 
$check_date = $pre_date; 
$end_date = $end;

$i=0; 
while ($check_date != $end_date) 
{ 
	
	$check_date = date ("Y-m-d", strtotime ("+1 day", strtotime($check_date))); 
	$weekday = date('l', strtotime($check_date));
	//$l=$k+$l;
	$sql_op=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where date='$check_date' and section='$sec'") or exit("sql_op Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo "select sum(act_out) from $bai_pro.grand_rep where date='$check_date' and section='$sec'"."<br>";
	while($row_op=mysqli_fetch_array($sql_op))
	{
		$output1=$row_op["sum(act_out)"];
	} 
	/*if($output1 >= 0)
	{
		$dates[]=$check_date;
	}*/
	
	//echo "size=".sizeof($dates);
	
	if($weekday == "Saturday")
	{
		
		echo "<th style=\"background-color:#29759C; color:white;\">".$check_date."</th>";
		echo "<th style=\"background-color:#29759C; color:white;\">Week Avg</th>";
		$dates[]=$check_date;
	}
	else
	{		
		
	  	$sql=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where date='$check_date' and section='$sec'") or exit("sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo "select sum(act_out) from $bai_pro.grand_rep where date='$check_date' and section='$sec'<br>";
		
		while($row=mysqli_fetch_array($sql))
		{
			$output=$row["sum(act_out)"];
		} 
		
		if($weekday == "Sunday")
		{
			if($output > 0 )
			{
				echo "<th style=\"background-color:#29759C; color:white;\">".$check_date."</th>";	
				$dates[]=$check_date;
			}
		}		
		else 
		{
			
			echo "<th style=\"background-color:#29759C; color:white;\">".$check_date."</th>";
			
			$dates[]=$check_date;	
			
		}
		
	}	
}  
$day_avgs=0;
$day_output=0;
$day_dtime_total=0;
$p=0;
$r=0;
$x=0;
/*for($k=0;$k<sizeof($dates);$k++)
{
	echo $dates[$k]."<br>";
}*/

//$date=date("$start",strtotime("1 day"));
//echo "<th>".$date."</th>";
echo "</tr>";

for($i=0;$i<sizeof($secs);$i++)
{
    
	$sql2=mysqli_query($link, "select distinct(styles) from $bai_pro.grand_rep where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module ") or exit("sql2 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($sql2))
	{
	    echo "<tr>";
		echo "<th rowspan='3' style=\"background-color:#00ffff;\">".$secs[$i]."</th>";
	    echo "<th rowspan='3' style=\"background-color:#00ffff;\">".$row2['styles']."</th>";
		echo "<th style=\"background-color:#C4BD97;\">Eff</th>";
		
		for($k=0;$k<sizeof($dates);$k++)
		{
			$weekday1 = date('l', strtotime($dates[$k]));
			$sql17=mysqli_query($link, "select count(module) from $bai_pro.grand_rep where section='$sec' and module='".$secs[$i]."' AND date='".$dates[$k]."' and styles='".$row2['styles']."'")  or exit("sql17 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row17=mysqli_fetch_array($sql17))
			{
				$count=$row17["count(module)"];
				//echo "count = ".$count;
			}
			if($count !=0)
			{
				$sql15=mysqli_query($link, "select distinct(nop) from $bai_pro.grand_rep where section='$sec' and module='".$secs[$i]."' AND date='".$dates[$k]."' and styles='".$row2['styles']."'") or exit("sql15 Error".mysqli_error($GLOBALS["___mysqli_ston"]));  			
				while($row15=mysqli_fetch_array($sql15))
				{
					$nop=$row15['nop'];	
				}	
				
				$sql16=mysqli_query($link, "select distinct(smv) from $bai_pro.grand_rep where section='$sec' and module='".$secs[$i]."' AND date='".$dates[$k]."' and styles='".$row2['styles']."' order by module ") or exit("sql16 Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row16=mysqli_fetch_array($sql16))
				{
					$smv=$row16['smv'];
				}
			}	
			else
			{
				$nop=0;
				$smv=0;
			}
			
			
			if($weekday1 == "Saturday")
			{
				$sql4=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$k]."' and section='$sec'") or exit("sql14 Error".mysqli_error($GLOBALS["___mysqli_ston"]));  
				while($row4=mysqli_fetch_array($sql4))
				{
					$output=$row4['sum(act_out)'];
					$day_avg=round(($output*$smv*100)/(60*15*$nop),0);
					echo "<th style=\"background-color:#c0dcc0;\">".round($day_avg,0)."</th>";
				}
								
				$avg=0;
				$rlimit=$r+1;
				$avg=round(($day_avgs+$day_avg)/$rlimit,0);
				
				/*for($i=0;$i<sizeof($day_avgs);$i++)
				{
					$avg=$avg+$day_avgs[$i];
				}*/
				
				echo "<th style=\"background-color:#99AADD;\">".round($avg)."</th>";           
				$day_avgs=0;
				$avg=0;
				$r=0;
				$rlimit=0;
			}
			else 
			{
				$sql41=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$k]."' and section='$sec'") or exit("sql41 Error".mysqli_error($GLOBALS["___mysqli_ston"]));  
				while($row41=mysqli_fetch_array($sql41))
				{
					$output1=$row41['sum(act_out)'];
					$day_avg1=round(($output1*$smv*100)/(60*15*$nop),0);
					if($dates[$k] != $end_date)
					{
						$day_avgs=$day_avgs+$day_avg1;
						$r=$r+1;
					}
					else
					{
						$day_avgs=0;
						$r=0;
					}
					
					echo "<th style=\"background-color:#c0dcc0;\">".round($day_avg1,0)."</th>";
					//echo "<th>".$dates[$k]."</th>";
				}
			}
		}
		echo "<tr>";	
		
			
		echo "<th style=\"background-color:#C4BD97;\">Avg</th>";
		for($l=0;$l<sizeof($dates);$l++)
		{
			$weekday2 = date('l', strtotime($dates[$l]));
			
			if($weekday2 == "Saturday")
			{
				$sql42=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$l]."' and section='$sec'") or exit("sql42 Error".mysqli_error($GLOBALS["___mysqli_ston"]));  
				while($row42=mysqli_fetch_array($sql42))
				{
					$output=round($row42['sum(act_out)']/15,0);
					echo "<th style=\"background-color:#c0dcc0;\">".round($output,0)."</th>";
				}
				
				$limit=$p+1;
				//echo $limit;
				
				$week_output=round(($day_output+$output)/$limit,0);;
				
				echo "<th style=\"background-color:#99AADD;\">".$week_output."</th>";
				
				$day_output=0;
				$week_output=0;
				$p=0;	
				$limit=0;
			}
			else
			{
				$sql43=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$l]."' and section='$sec'") or exit("sql43 Error".mysqli_error($GLOBALS["___mysqli_ston"]));  
				while($row43=mysqli_fetch_array($sql43))
				{
					$output1=round($row43['sum(act_out)']/15,0);
					if($dates[$l] != $end_date)
					{
						$day_output=$day_output+$output1;
						$p=$p+1;
						//echo $p;
					}
					else
					{
						$day_output=0;
						$p=0;
					}
					//$day_output=$day_output+$output1;
					echo "<th style=\"background-color:#c0dcc0;\">".round($output1,0)."</th>";
				}	
			}	
		}
		echo "</tr>";
		echo "<tr>";		
		echo "<th style=\"background-color:#C4BD97;\">LostHrs</th>";
		for($l=0;$l<sizeof($dates);$l++)
		{
			$weekday3 = date('l', strtotime($dates[$l]));
			$sql44=mysqli_query($link, "select sum(dtime) from $bai_pro.down_log where style='".$row2['styles']."' and mod_no='".$secs[$i]."' and date='".$dates[$l]."' and section='$sec'") or exit("sql44 Error".mysqli_error($GLOBALS["___mysqli_ston"]));        
            while($row44=mysqli_fetch_array($sql44))
			{
				if($weekday3 == "Saturday")
				{					
					$day_dtime=$row44['sum(dtime)']/60;
					$week_dtime_total=$day_dtime_total+$day_dtime;
					$xlimit=$x+1;
					echo "<th style=\"background-color:#c0dcc0;\">".round($day_dtime,0)."</th>";
					echo "<th style=\"background-color:#99AADD;\">".round($week_dtime_total/$xlimit,0)."</th>";	
					$x=0;
					$xlimit=0;
					$day_dtime_total=0;
				}
				else
				{
					$day_dtime1=$row44['sum(dtime)']/60;
					
					if($dates[$l] != $end_date)
					{
						$day_dtime_total=$day_dtime_total+$day_dtime1;	
						$x=$x+1;
					}
					else
					{
						$day_dtime_total=0;
						$x=0;
					}
					
					echo "<th style=\"background-color:#c0dcc0;\">".round($day_dtime1,0)."</th>"; 				
				}
			}
			
		}
		
		echo "</tr>";
	}
}

echo "</table></div>";
}
else{
	echo "<div class='alert alert-danger' role='alert' style='text-align:center;text-weight:bold;' >No data found!</div>";
}

?>