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
//echo "SELECT * FROM disp_db WHERE disp_note_no IN ( SELECT DISTINCT(DISP_NOTE_NO) FROM ship_stat_log WHERE ship_style LIKE \"%ES%\" OR ship_style LIKE \"%QS%\")";

while($row=mysqli_fetch_array($sql))
{
	$exit=explode(" ",$row["exit_date"]);
	$exit_date[]=$exit[0];
	$exit_time[]=$exit[1];
	//echo "Ddate = ".$row["exit_date"]."<br>";
}

//echo sizeof($exit_date)."<br>";
$status=array();
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
					/*if($i<20)	
					{
						echo $iu_date."---0---".$status[$i]."<br>";
					}
					else
					{
						$j=$i-19;
						echo $iu_date."---".$exit_date[$j]."---".$status[$i]."<br>";
					}*/
	//echo $iu_date."---".$exit_date[$i]."---".$status[$i]."<br>";
	/*$exit_date_time=explode(" ",$exit_date[$i]);
	//echo " Sno = ".($i+1)." DATE-TIME = ".$exit_date[$i]." - Date = ".$exit_date_time[0]." - Time = ".$exit_date_time[1]."<br>";
    
	if($exit_date_time[1] <= "12:00:00")
	{
		$x=$x+1;
		//echo $x."---".$exit_date_time[1]."<br>";
		$status[]="W";
	}
	else
	{
		$x=$x+1;
		//echo $x."---".$exit_date_time[1]."<br>";
		$status[]="L";
	}*/
}


	$i=0;
	$x=1;
	$m=1;
	do
	{
		$temp= "<chart palette='1'  winColor='00CC33' lossColor='FF0000' caption='".($i+1)."-".($i+12)."' showValue='0' subcaption='' canvasLeftMargin='70'>";
		$temp.=  "<dataset>";
		for($x=1;$x<=12;$x++)
		{
			
			if($i<sizeof($status))
			{
					if($i<=20)
					{
						$temp.= "<set value='w' />";
					}
					else
					{
						$temp.= "<set value='".$status[$i]."' />";
					}
					
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

		
		/* $temp= "<chart palette='1'  winColor='00CC33' lossColor='FF0000' caption='1-12' subcaption='' canvasLeftMargin='70'>";
		$temp.=  "<dataset>";
		for($i=0;$i<sizeof($status);$i++)
		{
			$temp.= "<set value='".$status[$i]."' />";
		}
		$temp.= "</dataset>";	
		$temp.= "</chart>"; */

//header("Location:../number_boards/monthly_board.php");
ext1:
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../number_boards/monthly_board.php\"; }</script>";



?>
