<html>
<head>
<style id="Book1_6519_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl636519
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:right;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl636518
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}	

-->
</style>
</head>
<body>
<?php include "data.php"; ?>
<!--<form name="form1" method="post" action="date_store.php?saving=1">-->
<form name="form1" method="post" action="date_store.php">
<table class=xl636519>
<?php
$m="12"; 

$date=date("Y-$m-1");
$weekday1 = date('l', strtotime($date));
echo $weekday1;
if($weekday1 == "Sunday")
{	
	echo "<tr><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th></tr>";
}
else if($weekday1 == "Monday")
{	
	echo "<tr><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>";	
}
else if($weekday1 == "Tuesday")
{	
	echo "<tr><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th></tr>";				
}
else if($weekday1 == "Wednesday")
{	
	echo "<tr><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th></tr>";				
}
else if($weekday1 == "Thursday")
{	
	echo "<tr><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th></tr>";				
}
else if($weekday1 == "Friday")
{	
	echo "<tr><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th></tr>";					
}
else if($weekday1 == "Saturday")
{	
	echo "<tr><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th></tr>";					
}

?>
<!--<tr><th>Weeks</th></tr>-->
<!--<tr><th class=xl636519>Month Working Dates:</th></tr>-->
<?php
$k=0;
//$m="3";
//$sun="";
for($i=1;$i<=31;$i++)
{	
	//echo date("Y-m-$i");
	if(in_array("$i",$date1))
	{
		$date=date("Y-$m-$i");
		$weekday1 = date('l', strtotime($date));
		$k=$k+1;
		//echo $k;
		//echo $weekday1;
		if($weekday1 == "Sunday")
		{	
			$sun[]=$i;
			$sun_sta[]="yes";				
		}
		else if($weekday1 == "Monday")
		{	
			$mon[]=$i;
			$mon_sta[]="yes";				
		}
		else if($weekday1 == "Tuesday")
		{	
			$tue[]=$i;
			$tue_sta[]="yes";				
		}
		else if($weekday1 == "Wednesday")
		{	
			$wed[]=$i;
			$wed_sta[]="yes";				
		}
		else if($weekday1 == "Thursday")
		{	
			$thr[]=$i;
			$thr_sta[]="yes";				
		}
		else if($weekday1 == "Friday")
		{	
			$fri[]=$i;
			$fri_sta[]="yes";				
		}
		else if($weekday1 == "Saturday")
		{	
			$sat[]=$i;
			$sat_sta[]="yes";				
		}


	}
	else
	{
		$date=date("Y-$m-$i");
		$weekday1 = date('l', strtotime($date));
		$k=$k+1;
		//echo $k;
		//echo $weekday1;
		if($weekday1 == "Sunday")
		{	
			$sun[]=$i;
			$sun_sta[]="";				
		}
		else if($weekday1 == "Monday")
		{	
			$mon[]=$i;
			$mon_sta[]="";				
		}
		else if($weekday1 == "Tuesday")
		{	
			$tue[]=$i;
			$tue_sta[]="";				
		}
		else if($weekday1 == "Wednesday")
		{	
			$wed[]=$i;
			$wed_sta[]="";				
		}
		else if($weekday1 == "Thursday")
		{	
			$thr[]=$i;
			$thr_sta[]="";				
		}
		else if($weekday1 == "Friday")
		{	
			$fri[]=$i;
			$fri_sta[]="";				
		}
		else if($weekday1 == "Saturday")
		{	
			$sat[]=$i;
			$sat_sta[]="";				
		}
	}
	
}
$j=0;
//echo "<br>sunday =".sizeof($sun);
//echo "<br>monday =".sizeof($mon);
//echo "<br>tuesday =".sizeof($tue);
//echo "<br>wednesday =".sizeof($wed);
//echo "<br>thursday =".sizeof($thr);
//echo "<br>friday =".sizeof($fri);
//echo "<br>saturday =".sizeof($sat);
echo "<tr>";
for($i=0;$i<5;$i++)
{	
	echo "<tr>";
	
	if($i < sizeof($sun))
	{
		echo "<td>".$sun[$i]."</td>";
	}	
	else if($i > sizeof($sun))
	{
		echo "<td>".$sun[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($mon))
	{
		echo "<td>".$mon[$i]."</td>";
	}	
	else if($i > sizeof($mon))
	{
		echo "<td>".$mon[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
		
	if($i < sizeof($tue))
	{
		echo "<td>".$tue[$i]."</td>";
	}	
	else if($i > sizeof($tue))
	{
		echo "<td>".$tue[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($wed))
	{
		echo "<td>".$wed[$i]."</td>";
	}	
	else if($i > sizeof($wed))
	{
		echo "<td>".$wed[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($thr))
	{
		echo "<td>".$thr[$i]."</td>";
	}	
	else if($i > sizeof($thr))
	{
		echo "<td>".$thr[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($fri))
	{
		echo "<td>".$fri[$i]."</td>";
	}	
	else if($i > sizeof($fri))
	{
		echo "<td>".$fri[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($sat))
	{
		echo "<td>".$sat[$i]."</td>";
	}	
	else if($i > sizeof($sat))
	{
		echo "<td>".$sat[$i]."</td>";
	}
	else
	{
		echo "<td>-</td>";
	}
	
	echo "</tr>";
}
echo "</tr>";
?>

</table>
<table>
<tr><th class=xl636519>Monthly SAH :</th><td><input type="textbox" name="msh" size="10" value=""/></td></tr>
<tr><td><input type="submit" value="Save" name="submit"></td></tr>
</table>
</form>
<p>

<!--<a href="data.php"><b>VIEW</b></a>-->

</p>

<?php
if(isset($_POST["submit"]))
{
	$i=2;
	for($i=1;$i<=31;$i++)
	{
		if(!empty($_POST[$i]))
		{
			$date_value[]=$_POST[$i];
		}
	}
	$plan_value=$_POST['msh'];
	$data_sym="$";
	echo implode(",",$date_value)."<br>";
	
	$year=date("Y");
	$month=date("m");
	
	$plan_fac=$plan_value;
	
	$dates_all="";
	for($i=0;$i<sizeof($date_value);$i++)
	{
		$dates_all[]="\"".$year."-".$month."-".$date_value[$i]."\"";
	}
	$all_dates=implode(",",$dates_all);
	
	$dates_all1="";
	for($i=0;$i<sizeof($date_value);$i++)
	{
		$dates_all1[]="\"".$date_value[$i]."\"";
	}
	$all_dates1=implode(",",$dates_all1);
	
	$File = "data.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."date=array(".$all_dates."); ".$data_sym."date1=array(".$all_dates1."); ".$data_sym."fac_plan=\"".$plan_fac."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);	
	echo "Data Saved successfully!<br>";
	header("Location:http://bainet:8080/projects/beta/reports/Production_Live_Chart/Control_Room_Charts/Dash_Board_new.php");
}
?>
</body>
</html>