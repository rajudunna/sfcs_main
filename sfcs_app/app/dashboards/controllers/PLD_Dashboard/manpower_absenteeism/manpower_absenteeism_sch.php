<?php 
$start_timestamp = microtime(true);

//#953482 changes main sql query to increase the performance
include("dbconf_sch.php");
set_time_limit(6000000);
$active_status=array("11","13","30","35","40","45","50","55"); //30-tc shift allocated,35-Eligible for production,40=tc to pc approval,45-given on roll emp,50,55-full scale emp,11-pregnent,12-kept in remider,13,14-Inactive,17-long absentism
$emp_active_status=array("11","45","50","55"); //30,35,40,45,50,55,11,12-kept in remider,14-Inactive,17-long absentism //removed 13-on long leave & 40- HOD approval for tc to PC on 2014-08-13 based on confirmation from venkatesh

//$prev_date=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
$prev_date=date("Y-m-d");
$date=$prev_date;
$year=date("yy",strtotime($date));
$month=date("M",strtotime($date));
?>


<?php
function divi($arg)
{
	if($arg==0)
	{
		return 1;
	}
	else
	{
		return $arg;	
	}
}

//===========================================Create mysql functions for requirement===========================================
/*
	//create fun_in_time for current day
	$sql="DROP function IF EXISTS `bai_hr_database`.`fun_in_time`";
	mysql_query($sql,$link) or exit("Sql Error_function".mysql_error());
	
	$sql="CREATE DEFINER=`bainet`@`%` FUNCTION `bai_hr_database`.`fun_in_time`(`id` VARCHAR(100)) RETURNS varchar(200) CHARSET latin1
	    DETERMINISTIC
	BEGIN
		DECLARE RET VARCHAR(200);
		SELECT in_time INTO RET FROM bai_hr_tna_em_$year.$month WHERE emp_id=id and date='$date';
		RETURN RET;
	    END ";
		
//		echo $sql."<br>";
	mysql_query($sql,$link) or exit("Sql Error_function".mysql_error());*/
//===========================================================================================================================================
$team_m='';$team_e='';
	
   $team_m='';$team_e='';
	$where_a="(in_time between '$date 05:00:00' and '$date 07:00:00') and team";
	$where_b="(in_time between '$date 05:00:00' and '$date 07:00:00') and team";
	$a_count=echo_title("bai_hr_tna_em_".date("yy.M",strtotime($date)),"count(*)",$where_a,'A',$link);
	$b_count=echo_title("bai_hr_tna_em_".date("yy.M",strtotime($date)),"count(*)",$where_b,'B',$link);

	if($a_count>$b_count)
	{
		$team_m='A';
	}
	else{
		$team_m='B';
	}

	if($team_m=='A')
	{
		$team_e='B';
	}
	else
	{
		$team_e='A';
	}
  //=====================================================================================================
$in_time="bai_hr_tna_em_$year.$month.in_time";
$out_time="bai_hr_tna_em_$year.$month.out_time";

$sql_indirect="SELECT daily_emp_alloc.grade AS 'grade', 
SUM(IF((UCASE(daily_emp_alloc.emp_alloc_team_ref) = '$team_m'),1,0)) AS 't_a', 
SUM(IF((UCASE(daily_emp_alloc.emp_alloc_team_ref = '$team_m') AND DATE($in_time)='$date'),1,0)) AS 'A',  
SUM(IF((UCASE(daily_emp_alloc.emp_alloc_team_ref) = '$team_e'),1,0)) AS 't_b', 
SUM(IF((UCASE(daily_emp_alloc.emp_alloc_team_ref = '$team_e') AND DATE($in_time)='$date'),1,0)) AS 'B',  
SUM(IF((UCASE(daily_emp_alloc.emp_alloc_team_ref) = 'G'),1,0)) AS 't_g', 
SUM(IF((UCASE(daily_emp_alloc.emp_alloc_team_ref = 'G') AND DATE($in_time)='$date'),1,0)) AS 'G'
FROM bai_hr_database.daily_emp_alloc join bai_hr_tna_em_$year.$month on bai_hr_tna_em_$year.$month.emp_id=bai_hr_database.daily_emp_alloc.emp_id_ref WHERE bai_hr_tna_em_$year.$month.date='$date' AND daily_emp_alloc.grade_code in ('1','2') AND w_status in (".implode(",",$emp_active_status).") AND daily_emp_alloc.emp_type='Employee' 
GROUP BY daily_emp_alloc.grade_code ORDER BY daily_emp_alloc.grade_code";

echo "<br>".$sql_indirect;
$sql_result=mysqli_query($link, $sql_indirect) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$i=1;
$a_p=$a_a=$a_t=0;
$b_p=$b_a=$b_t=0;
$g_p=$g_a=$g_t=0;
$c_p=$c_a=$c_t=0;
$time_limit='14.29'; // to eliminate afternoon shift before aftrnoon shift start

$table1="<table class='wip'>";
$grade_arr=array();
$team_tot=array();
$team_abs=array();
$team_present=array();
$x=array();
$count=0;
$x[0][0]="#";
$x[1][0]="Total $team_m:";
$x[2][0]="Absent:";
$x[3][0]="Absent %:";
if(date("H.i")>=$time_limit)
{
$x[4][0]="Total $team_e:";
$x[5][0]="Absent";
$x[6][0]="Absent %:";   
}
$count=0;
while($sql_row=(mysqli_fetch_array($sql_result)))
{
	$count++;
	$x[0][$count]=$sql_row['grade'];
	$x[1][$count]=$sql_row['t_a'];
	$x[2][$count]=$sql_row['t_a']-$sql_row['A'];
	$x[3][$count]=round((($sql_row['t_a']-$sql_row['A'])*100/divi($sql_row['t_a'])),1);
   if(date("H.i")>=$time_limit)
   {
      $x[4][$count]=$sql_row['t_b'];
   	$x[5][$count]=$sql_row['t_b']-$sql_row['B'];	
   	$x[6][$count]=round((($sql_row['t_b']-$sql_row['B'])*100/divi($sql_row['t_b'])),1);      
   }
	
}

for($i=0;$i<7;$i++)
	{
		$table1.="<tr>";
	for($j=0;$j<=$count;$j++)
	{
	
		$table1.="<td  align='right'>".$x[$i][$j]."</td>";
	}
	$table1.="</tr>";
	}


$table1.='</table>';
$message=$summary.$message;

echo $table1;
//Writing file
$myFile = "manpower_absenteeism_include.php";
$fh = fopen($myFile, 'w') or die("can't open file");

	$stringData = "<?php $"."table1=\"";
	$stringData.=$table1. "\"; echo $"."table1; ?>";
	fwrite($fh, $stringData);

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
