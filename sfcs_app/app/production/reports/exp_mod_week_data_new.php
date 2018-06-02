<?php set_time_limit(1000000); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title></title>
<style type="text/css" media="screen">
body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#000000; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
<script type="text/javascript" src="datetimepicker_css.js"></script>
</head>
<body>

<?php

include"header.php";
include"exp_mod_main.php";

$start=$_GET['dat1'];
$end=$_GET['dat2'];
$sec=$_GET['sec'];
//echo $start."---".$end;
$sql1=mysqli_query($GLOBALS["___mysqli_ston"], "select sec_mods from $database1.$table2 where sec_id='$sec'");
while($row1=mysqli_fetch_array($sql1))
{
	$sections = $row1['sec_mods']; 
	//echo "<br>Date = ".$row['date'];//$weekday1 = date('l', strtotime($date));
}

$secs=explode(",",$sections);

//$date=date("$start",strtotime("1 day"));
$i=1;
echo "<table border=1px class=\"mytable1\">";
echo "<tr>";
echo "<th style=\"background-color:#66FFDD;\">Module</th>";
echo "<th style=\"background-color:#66FFDD;\">Style</th>";
echo "<th style=\"background-color:#66FFDD;\">Details</th>";

$pre_date="";

$start_date = $start; 
$pre_date = date ("Y-m-d", strtotime ("-1 day", strtotime($start_date))); 
//echo $pre_date;
$check_date = $pre_date; 
$end_date = $end;

$dates="";
 
$i=0; 
while ($check_date != $end_date) 
{ 
    
	$check_date = date ("Y-m-d", strtotime ("+1 day", strtotime($check_date))); 
	$weekday = date('l', strtotime($check_date));
	//$l=$k+$l;
	
	$sql_op=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_out) from $database.$table1 where date='$check_date' and section='$sec'");
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
	  	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_out) from $database.$table1 where date='$check_date' and section='$sec'"); 
		//echo "select sum(act_out) from $database.$table1 where date='$check_date' and section='$sec'<br>";
		while($row=mysqli_fetch_array($sql))
		{
			$output=$row["sum(act_out)"];
		} 
		if($weekday == "Sunday")
		{
			if($output > 0 )
			{
				echo "<th style=\"background-color:#66FFDD;\">".$check_date."</th>";	
				$dates[]=$check_date;
			}
		}		
		else 
		{
			echo "<th style=\"background-color:#66FFDD;\">".$check_date."</th>";
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
    $sql21=mysqli_query($GLOBALS["___mysqli_ston"], "select COUNT(DISTINCT(styles)) from $database.$table1 where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module ");
	while($row21=mysqli_fetch_array($sql21))
	{
		$no=$row21['COUNT(DISTINCT(styles))'];
	}	
	echo $no."<br>";
	$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct(styles) from $database.$table1 where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module ");
echo "select distinct(styles) from $database.$table1 where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module<br>";
	while($row2=mysqli_fetch_array($sql2))
	{
	    
		echo "<tr>";
		echo "<th rowspan='".($no*3)."' style=\"background-color:#00ffff;\">".$secs[$i]."</th>";
	    echo "<th rowspan='3' style=\"background-color:#00ffff;\">".$row2['styles']."</th>";
		echo "<th style=\"background-color:#C4BD97;\">Eff</th>";
		
		for($k=0;$k<sizeof($dates);$k++)
		{
			$weekday1 = date('l', strtotime($dates[$k]));
			$sql17=mysqli_query($GLOBALS["___mysqli_ston"], "select count(module) from $database.$table1 where section='$sec' and module='".$secs[$i]."' AND date='".$dates[$k]."' and styles='".$row2['styles']."'");
			while($row17=mysqli_fetch_array($sql17))
			{
				$count=$row17["count(module)"];
				//echo "count = ".$count;
			}
			if($count !=0)
			{
				$sql15=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct(nop) from $database.$table1 where section='$sec' and module='".$secs[$i]."' AND date='".$dates[$k]."' and styles='".$row2['styles']."'");  			
				while($row15=mysqli_fetch_array($sql15))
				{
					$nop=$row15['nop'];	
				}	
				
				$sql16=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct(smv) from $database.$table1 where section='$sec' and module='".$secs[$i]."' AND date='".$dates[$k]."' and styles='".$row2['styles']."' order by module "); 
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
					$sql4=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_out) from $database.$table1 where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$k]."' and section='$sec'");  
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
				$sql41=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_out) from $database.$table1 where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$k]."' and section='$sec'");  
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
				$sql42=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_out) from $database.$table1 where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$l]."' and section='$sec'");  
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
				$sql43=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_out) from $database.$table1 where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$dates[$l]."' and section='$sec'");  
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
			$sql44=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(dtime) from $database.down_log where style='".$row2['styles']."' and mod_no='".$secs[$i]."' and date='".$dates[$l]."' and section='$sec'");        
            while($row44=mysqli_fetch_array($sql44))
			{
				if($weekday3 == "Saturday")
				{					
					$day_dtime=$row44['sum(dtime)']/60;
					$week_dtime_total=$day_dtime_total+$day_dtime;
					$xlimit=$x+1;
					echo "<th style=\"background-color:#c0dcc0;\">".$day_dtime."</th>";
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
					
					echo "<th style=\"background-color:#c0dcc0;\">".$day_dtime1."</th>"; 				
				}
			}
			
		}
		
		echo "</tr>";
	}
}

echo "</table>";


?>

</body>
</html>