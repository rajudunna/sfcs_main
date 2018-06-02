<?php 

include"header.php";

$exit_date="";
$status="";
$start_iu_dates[]="2010-11-11";

$start_iu_date="2010-11-11";
$check_date=$start_iu_date;
$end_date=date("Y-m-d");

while ($check_date <= $end_date) 
{    
	$check_date=date ("Y-m-d", strtotime ("+7 day", strtotime($check_date)));
	$start_iu_dates[]=$check_date;
}
//echo "Size = ".sizeof($start_iu_dates)." --- ".$start_iu_dates[3];
for($i=0;$i<sizeof($start_iu_dates);$i++)
{
	$j=$i+1;
	//echo "week = ".$j." date = ".$start_iu_dates[$i]."<br>";
}
$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT exit_date FROM disp_db WHERE disp_note_no IN ( SELECT DISTINCT(DISP_NOTE_NO) FROM ship_stat_log WHERE ship_style LIKE \"%ES%\" OR ship_style LIKE \"%QS%\")");

while($row=mysqli_fetch_array($sql))
{
	$exit=explode(" ",$row["exit_date"]);
	$exit_date[]=$exit[0];
	$exit_time[]=$exit[1];
}
//echo sizeof($exit_date);

for($j=0;$j<sizeof($exit_date);$j++)
{
	//echo $exit_date[$j]."---".$exit_time[$j]."<br>";
	if(date('l',strtotime($exit_date[$j])) == "Thursday")
	{
		if($exit_time[$j] <= "12:00:00")
		{
			$status[]="W";
		}
		else
		{
			$status[]="L";
		}
	}
	else if(date('l',strtotime($exit_date[$j])) == "Wednesday")
	{
		$status[]="W";
	}
	else
	{
		$status[]="L";
	}
}

for($k=0;$k<sizeof($status);$k++)
{
	echo $exit_date[$k]."---".$exit_time[$k]."---".$status[$k]."<br>";
}	
/*$status=array();
for($i=0;$i<sizeof($start_iu_dates);$i++)
{
	$iu_date=$start_iu_dates[$i];
	if(in_array($iu_date,$exit_date) or in_array(date ("Y-m-d", strtotime ("-1 day", strtotime($iu_date)),$exit_date))) 
	{
		if(in_array($iu_date,$exit_date))
		{
			if($exit_time[array_search($iu_date,$exit_date)] < "12:00:00")
			{
				$status[]="W";
			}
			else
			{
				$status[]="L";
			}
		}
		else
		{
			$status[]="L";
		}
	}
	else
	{
		$status[]="L";
	}
				
}*/

?>
