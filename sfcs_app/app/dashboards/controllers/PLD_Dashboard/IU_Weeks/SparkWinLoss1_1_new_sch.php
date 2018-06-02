<?php 
$start_timestamp = microtime(true);

include("header_sch.php");

$exit_date="";
$status="";
$start_iu_dates[]="2012-01-19";

$start_iu_date="2012-01-19";
$check_date=$start_iu_date;
$end_date=date("Y-m-d");

while ($check_date <= $end_date) 
{    
	$check_date=date ("Y-m-d", strtotime ("+7 day", strtotime($check_date)));
	$start_iu_dates[]=$check_date;
}
//echo "Size = ".sizeof($start_iu_dates)." --- ".$start_iu_dates[3]."<br>";
for($i=0;$i<sizeof($start_iu_dates);$i++)
{
	$j=$i+1;
	echo "week = ".$j." date = ".$start_iu_dates[$i]." day = ".date('l',strtotime($start_iu_dates[$i]))."<br>";
}

$status=array();


//$sql=mysql_query("select exit_date FROM disp_db WHERE disp_note_no IN ( select DISTINCT(DISP_NOTE_NO) FROM ship_stat_log WHERE ship_style LIKE \"%ES%\" OR ship_style LIKE \"%QS%\") AND create_date BETWEEN \"2011-04-01\" AND \"2012-02-22\"");

// $sql=mysqli_query($GLOBALS["___mysqli_ston"], "select DISTINCT(SUBSTRING_INDEX(exit_date,\" \",1)) as date,SUBSTRING_INDEX(exit_date,\" \",-1) as time FROM disp_db WHERE disp_note_no IN ( select DISTINCT(DISP_NOTE_NO) FROM ship_stat_log WHERE ship_style LIKE \"%ES%\" OR ship_style LIKE \"%QS%\" OR ship_style LIKE \"%Y%\") AND create_date BETWEEN \"2012-01-19\" AND \"$end_date\" GROUP BY exit_date");
$sql="select DISTINCT(SUBSTRING_INDEX(exit_date,\" \",1)) as date,SUBSTRING_INDEX(exit_date,\" \",-1) as time FROM bai_pro3.disp_db WHERE disp_note_no IN ( select DISTINCT(DISP_NOTE_NO) FROM bai_pro3.ship_stat_log WHERE ship_style LIKE \"%ES%\" OR ship_style LIKE \"%QS%\" OR ship_style LIKE \"%Y%\") AND create_date BETWEEN \"2012-01-19\" AND \"$end_date\" GROUP BY exit_date";
$sql_result=mysqli_query($con,$sql);
// echo $sql;


$count=mysqli_num_rows($sql_result);

echo "rows =".$count;

if($count > 0)
{

while($row=mysqli_fetch_array($sql_result))
{
	$exit_date[]=$row["date"];
	$exit_time[]=$row["time"];
}

echo sizeof($exit_date)."---".sizeof($exit_time);
//echo "<br>dates=".sizeof($exit_date)."<br>";

for($y=0;$y<sizeof($exit_date);$y++)
{
	echo "<br>".$exit_date[$y]." --- ".$exit_time[$y]." --- ".date('l',strtotime($exit_date[$y]))."<br>";
}


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

echo "<br>status=".sizeof($status);

for($x=0;$x<sizeof($exit_date);$x++)
{
	echo $status[$x]."<br>";
}


$i=60;
$j=0;
	$x=1;
	$m=1;
	do
	{
		$temp= "<chart palette='1'  winColor='00CC33' lossColor='FF0000' caption='".($i+1)."-".($i+12)."' showValue='0' subcaption='' canvasLeftMargin='70'>";
		$temp.=  "<dataset>";
		for($x=1;$x<=12;$x++)
		{
			
			if($j<sizeof($status))
			{
				$temp.= "<set value='".$status[$j]."' />";
			}
			else
			{
				$temp.= "</dataset>";	
				$temp.= "</chart>";
				
				//To Write File
				$myFile = "spark$m"."_include.php";
				$fh = fopen($myFile, 'w') or die("can't open file");
				$stringData="<?php echo \"";
				$stringData.=$temp;
				$stringData.="\"; ?>";
				
				fwrite($fh, $stringData);
				fclose($fh);
				//To Write File
				//exit;
				goto ext1;
			}
			$j=$j+1;
			$i=$i+1;
		}
		$temp.= "</dataset>";	
		$temp.= "</chart>";
		
		//To Write File
		$myFile = "spark$m"."_include.php";
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData="<?php echo \"";
		$stringData.=$temp;
		$stringData.="\"; ?>";
		
		fwrite($fh, $stringData);
		fclose($fh);
		//To Write File
		$m++;
		

}while($i<sizeof($status));

ext1: echo "";
}
else
{
	print("No data for process")."\n";
}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>
