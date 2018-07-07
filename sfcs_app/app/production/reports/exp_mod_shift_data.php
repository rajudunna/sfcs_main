<style>
th
{
    background-color: #003366;
    color: WHITE;
    border-bottom: 5px solid white;
    border-top: 5px solid white;
    padding: 5px;
    white-space:nowrap;
    border-collapse:collapse;
    text-align:center;
    font-family:Calibri;
    font-size:110%;

}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
td {
	color:black;
	font-size:12px;
	font-weight:bold;
    text-align:center;
}
</style>

<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'exp_mod_main.php',0,'R')); 


$start=$_GET['dat1'];
$end=$_GET['dat2'];
$sec=$_GET['sec'];
$cat=$_GET['cat'];


$sql="select distinct(date) from $bai_pro.grand_rep where section='$sec' AND  date between '$start' and '$end' order by date";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result))
{
	$date[] = $row['date']; 
	//echo "<br>Date = ".$row['date'];//$weekday1 = date('l', strtotime($date));
}

$sql1=mysqli_query($link, "select sec_mods from $bai_pro3.sections_db where sec_id='$sec'") or exit("sql1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($sql1))
{
	$sections = $row1['sec_mods']; 
	//echo "<br>Date = ".$row['date'];//$weekday1 = date('l', strtotime($date));
}
$secs=explode(",",$sections);
//echo sizeof($secs);
for($i=0;$i<sizeof($date);$i++)
{
	$date1 = $date[$i]; 
	$weekday1 = date('l', strtotime($date1));
	//echo "<br>week =".$weekday1." Date = ".$date[$i]."<br>";
}


$sql=mysqli_query($link, "select distinct(date) from $bai_pro.grand_rep where section='$sec' AND  date between '$start' and '$end' order by date") or exit("sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql)> 0){
		echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>";
		echo "<tr class='tblheading' style='color:white;' >";
		echo "<th style=\"background-color:#29759C;color:white;\">Module</th>";
		echo "<th style=\"background-color:#29759C;color:white;\">Style</th>";
		echo "<th style=\"background-color:#29759C;color:white;\">Details</th>";
	
while($row=mysqli_fetch_array($sql))
{
	$date = $row['date']; 
	$weekday = date('l', strtotime($date));
	//$l=$k+$l;
	if($weekday == "Saturday")
	{
		echo "<th style=\"background-color:#29759C; color:white;\">".$row['date']."</th>";
		echo "<th style=\"background-color:#29759C; color:white;\">Week Avg</th>";
	}
	else
	{		
	  	echo "<th style=\"background-color:#29759C; color:white;\">".$row['date']."</th>";		
	}	

}

$out=0;
$out1=0;
$out3=0;
$out5=0;
$k=0;
$j=0;
$t=1;
$s=1;
$p=0;
$r=1;
$act_hoursx=0;
$act_hours=0;


/*$sql1=mysql_query("select distinct(module) from $database.$table1 where section='$sec' AND date between '$start' and '$end' order by module ");
while($row1=mysql_fetch_array($sql1))
{ */
for($i=0;$i<sizeof($secs);$i++)
{
	 $sql2=mysqli_query($link, "select distinct(styles) from $bai_pro.grand_rep where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module ") or exit("sql2 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//echo "select distinct(styles) from $database.$table1 where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module";
	while($row2=mysqli_fetch_array($sql2))
	{
	    echo "<tr>";
		echo "<td rowspan=2 style=\"background-color:#00ffff;\">".$secs[$i]."</td>";
	    echo "<td rowspan=2 style=\"background-color:#00ffff;\">".$row2['styles']."</td>";	
		
		echo "<td style=\"background-color:#C4BD97;\">A SHIFT</td>";
		
		$sql3=mysqli_query($link, "select distinct(date) from $bai_pro.grand_rep where section='$sec' AND  date between '$start' and '$end' order by date") or exit("sql3 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($sql3))
		{
		
			$sql4=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$row3['date']."' and section='$sec' AND shift=\"A\"") or exit("sql4 Error".mysqli_error($GLOBALS["___mysqli_ston"]));   
     
            while($row4=mysqli_fetch_array($sql4))
			{
				$date1 = $row3['date']; 
				$weekday1 = date('l', strtotime($date1));
				$sqlxx4=mysqli_query($link, "select act_hours from $bai_pro.pro_plan where mod_no='".$secs[$i]."' and date='".$row3['date']."' and sec_no='$sec' AND shift=\"A\"") or exit("sqlxx4 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rowxx4=mysqli_fetch_array($sqlxx4))
				{	
					$act_hoursx=$rowxx4["act_hours"];
				}	
								
				if($weekday1 != "Saturday")
				{					
					$k=$k+1;
					$ou=$row4['sum(act_out)'];
					$tot=($ou/$act_hoursx);
					$out=$out+($ou/$act_hoursx);
					echo "<td style=\"background-color:#c0dcc0;\">".round($tot,0)."</td>";		
				}
				else
				{
					$t=$k+$t;
					$ou1=$row4['sum(act_out)'];
					$tot=($ou1/$act_hoursx);
					$out2=$out+($ou1/$act_hoursx);	
					echo "<td style=\"background-color:#c0dcc0;\">".round($tot,0)."</td>";		
					echo "<td style=\"background-color:#99AADD;\">".round($out2/$t,0)."</td>";
					$t=0;
					$out=0;						
					$k=1;
					//$out2=0;	
				}
				
			}  
		}
		echo "</tr>";
		
		echo "<tr>";	
		echo "<td style=\"background-color:#C4BD97;\">B SHIFT</td>";
		
		$sql3=mysqli_query($link, "select distinct(date) from $bai_pro.grand_rep where section='$sec' AND  date between '$start' and '$end' order by date") or exit("sql3 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($sql3))
		{
		
			$sql4=mysqli_query($link, "select sum(act_out) from $bai_pro.grand_rep where styles='".$row2['styles']."' and module='".$secs[$i]."' and date='".$row3['date']."' and section='$sec' AND shift=\"B\"") or exit("sql4 Error".mysqli_error($GLOBALS["___mysqli_ston"]));   
     
            while($row4=mysqli_fetch_array($sql4))
			{
				$date1 = $row3['date']; 
				$weekday1 = date('l', strtotime($date1));
				$sqlx4=mysqli_query($link, "select act_hours from $bai_pro.pro_plan where mod_no='".$secs[$i]."' and date='".$row3['date']."' and sec_no='$sec' AND shift=\"B\"") or exit("sqlx4 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rowx4=mysqli_fetch_array($sqlx4))
				{	
					$act_hours=$rowx4["act_hours"];
				}			
				if($weekday1 != "Saturday")
				{					
					$k=$k+1;
					$ou=$row4['sum(act_out)'];
					$tot=($ou/$act_hours);
					$out=$out+($ou/$act_hours);
					echo "<td style=\"background-color:#c0dcc0;\">".round($tot,0)."</td>";		
				}
				else
				{
					$t=$k+$t;
					$ou1=$row4['sum(act_out)'];
					$tot=($ou1/$act_hours);
					$out2=$out+($ou1/$act_hours);	
					echo "<td style=\"background-color:#c0dcc0;\">".round($tot,0)."</td>";		
					echo "<td style=\"background-color:#99AADD;\">".round($out2/$t,0)."</td>";
					$t=0;
					$out=0;						
					$k=1;
					//$out2=0;	
				}
				
			}  
		}
		echo "</tr>";
    }
}

echo "</tr>";

echo "</table></div><br/></div>";
	}
	else {
		echo "<div class='alert alert-danger' role='alert' style='text-align:center;text-weight:bold;' >No data found!</div>";
	}
?>
