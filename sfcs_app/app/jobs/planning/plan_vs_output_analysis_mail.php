<?php
$start_timestamp = microtime(true);
error_reporting(0);
$text="		
<html><head><style type='text/css'>
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

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color:white;
}


}

}
</style></head>
<body>";
?>


<?php
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$text.='<h3>Daily Plan Achievement Report</h3>';

$sdate=$edate=date('Y-m-d');

$section=0;

?>

<?php

// Table print

$module_db=array();
$sql_new1="select distinct module from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" order by module*1";
//echo $sql_new1;
$sql_result_new1=mysqli_query($link, $sql_new1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_new1=mysqli_fetch_array($sql_result_new1))
{
	$module_db[]=$sql_row_new1['module'];
}

$text.= "Date :".$sdate;
$text.= "<table border=1>";
$text.= "<tr class='tblheading'>";
$text.= "<th>Module</th>";
$text.= "<th>Style</th>";
$text.= "<th>FR Plan</th>";
$text.= "<th>Day Actual</th>";
$text.= "<th>Day(+/-)</th>";
$text.= "</tr>";


$sql222_new="select distinct date from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" order by date";
 // echo $sql222_new;

$sql_result222_new=mysqli_query($link, $sql222_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row222_new=mysqli_fetch_array($sql_result222_new))
{
	$date=$sql_row222_new['date'];

	// $text.= "<tr class='tblheading'>";
	$j=0;
	$check=0;
	for($i=0;$i<sizeof($module_db);$i++)
	{
		$mod=$module_db[$i];
		
		if($check==0)
		{
			$bgcolor="#ffffaa";	
			$check=1;
		}
		else
		{
			$bgcolor="#99ffee";
			$check=0;
		}
		
		$sql2="select styles, coalesce(sum(plan_out),0) as \"plan_out\",  coalesce(sum(act_out),0) as \"act_out\" from $bai_pro.grand_rep where date=\"$date\" and module=$mod group by module";
		//echo $sql2."<BR>";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$plan_output=round($sql_row2['plan_out'],0);
			$act_output=round($sql_row2['act_out'],0);
			$style=$sql_row2['styles'];

		}

		$text.= "<tr><td bgcolor=$bgcolor>$mod</td>";
		$text.= "<td bgcolor=$bgcolor>$style</td>";
		$text.= "<td bgcolor=$bgcolor>$plan_output</td>";
		$text.= "<td bgcolor=$bgcolor>$act_output</td>";
		$text.= "<td bgcolor=$bgcolor>".($act_output-$plan_output)."</td></tr>";
		$j++;
	}
	// $text.="</tr>";
	

}

$text.= "</table></body>
</html>";


// echo $text."<br>";


$to  = $plan_vs_output_analysis_mail;

$subject = 'Daily Plan Achievement Report';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
// $headers .= 'From: Shop Floor System Alert <bel_sfcs@brandix.com>'. "\r\n";
$headers .= $header_from. "\r\n";

	if($j > 0)
	{
		if(mail($to, $subject, $text, $headers))
		{
			print("mail sent Sucesssfully")."\n";
		}
		else
		{
			print("mail Failed")."\n";
		}
	}
	else
	{
		print("mail Not Send Becoz No Data Found ")."\n";
	}
	
?>


<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); 

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");


?>
