<?php
$url = getFullURL($_GET['r'],'monthly_sah_update.php','N');
//echo $url;
echo "<a id='view-btn' href='$url'>View</a>";
header("Location:".$url);
?>
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
	white-space:nowrap;
	background-color:#a0a0a4;
	}
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
<link href="../styles/sfcs_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page_heading"><span style="float: left"><h3>Monthly SAH and Working Days Updation Form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php include "data.php"; ?>
<!--<form name="form1" method="post" action="date_store.php?saving=1">-->
<form name="form1" method="post" action="date_store.php">
<table class=xl636518>
<?php
$m="2"; 

$date=date("Y-$m-1");
$weekday1 = date('l', strtotime($date));
//echo $weekday1;
echo "<tr class=xl636519><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th></tr>";
/*if($weekday1 == "Sunday")
{	
	echo "<tr class=xl636519><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th></tr>";
}
else if($weekday1 == "Monday")
{	
	echo "<tr class=xl636519><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>";	
}
else if($weekday1 == "Tuesday")
{	
	echo "<tr class=xl636519><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th></tr>";				
}
else if($weekday1 == "Wednesday")
{	
	echo "<tr class=xl636519><th>Wed</th><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th></tr>";				
}
else if($weekday1 == "Thursday")
{	
	echo "<tr class=xl636519><th>Thur</th><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th></tr>";				
}
else if($weekday1 == "Friday")
{	
	echo "<tr class=xl636519><th>Fri</th><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th></tr>";					
}
else if($weekday1 == "Saturday")
{	
	echo "<tr class=xl636519><th>Sat</th><th>Sun</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thur</th><th>Fri</th></tr>";					
}*/

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
//echo "<br>sunday =".sizeof($sun_sta);
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
		if($sun[$i] < 10)
		{
			if($sun_sta[$i] == "yes")
			{
				echo "<td>0".$sun[$i]."<input type=\"checkbox\" name=\"".$sun[$i]."\" checked=\"yes\" value=".$sun[$i]."></td>";
			}
			else
			{
				echo "<td>0".$sun[$i]."<input type=\"checkbox\" name=\"".$sun[$i]."\" value=".$sun[$i]."></td>";
			}
			
		}
		else
		{
			if($sun_sta[$i] == "yes")
			{
				echo "<td>".$sun[$i]."<input type=\"checkbox\" name=\"".$sun[$i]."\" checked=\"yes\" value=".$sun[$i]."></td>";
			}
			else
			{
				echo "<td>".$sun[$i]."<input type=\"checkbox\" name=\"".$sun[$i]."\" value=".$sun[$i]."></td>";
			}
		}
	}	
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($mon))
	{
		if($mon[$i] < 10)
		{
			
			if($mon_sta[$i] == "yes")
			{
				echo "<td>0".$mon[$i]."<input type=\"checkbox\" name=".$mon[$i]." checked=\"yes\" value=".$mon[$i]."></td>";
			}
			else
			{
				echo "<td>0".$mon[$i]."<input type=\"checkbox\" name=".$mon[$i]." value=".$mon[$i]."></td>";
			}
		}
		else
		{
			if($mon_sta[$i] == "yes")
			{
				echo "<td>".$mon[$i]."<input type=\"checkbox\" name=".$mon[$i]." checked=\"yes\" value=".$mon[$i]."></td>";
			}
			else
			{
				echo "<td>".$mon[$i]."<input type=\"checkbox\" name=".$mon[$i]." value=".$mon[$i]."></td>";
			}
		}
		
	}	
	else
	{
		echo "<td>-</td>";
	}
	
		
	if($i < sizeof($tue))
	{
		if($tue[$i] < 10)
		{
			if($tue_sta[$i] == "yes")
			{
				echo "<td>0".$tue[$i]."<input type=\"checkbox\" name=".$tue[$i]." checked=\"yes\" value=".$tue[$i]."></td>";
			}
			else
			{
				echo "<td>0".$tue[$i]."<input type=\"checkbox\" name=".$tue[$i]." value=".$tue[$i]."></td>";
			}
		}
		else
		{
			if($tue_sta[$i] == "yes")
			{
				echo "<td>".$tue[$i]."<input type=\"checkbox\" name=".$tue[$i]." checked=\"yes\" value=".$tue[$i]."></td>";
			}
			else
			{
				echo "<td>".$tue[$i]."<input type=\"checkbox\" name=".$tue[$i]." value=".$tue[$i]."></td>";
			}
		}
	}	
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($wed))
	{
		if($wed[$i] < 10)
		{
			if($wed_sta[$i] == "yes")
			{
				echo "<td>0".$wed[$i]."<input type=\"checkbox\" name=".$wed[$i]." checked=\"yes\" value=".$wed[$i]."></td>";
			}
			else
			{
				echo "<td>0".$wed[$i]."<input type=\"checkbox\" name=".$wed[$i]." value=".$wed[$i]."></td>";
			}
		}
		else
		{
			if($wed_sta[$i] == "yes")
			{
				echo "<td>".$wed[$i]."<input type=\"checkbox\" name=".$wed[$i]." checked=\"yes\" value=".$wed[$i]."></td>";
			}
			else
			{
				echo "<td>".$wed[$i]."<input type=\"checkbox\" name=".$wed[$i]." value=".$wed[$i]."></td>";
			}
		}
	}	
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($thr))
	{
		if($thr[$i] < 10)
		{
			if($thr_sta[$i] == "yes")
			{
				echo "<td>0".$thr[$i]."<input type=\"checkbox\" name=".$thr[$i]." checked=\"yes\" value=".$thr[$i]."></td>";
			}
			else
			{
				echo "<td>0".$thr[$i]."<input type=\"checkbox\" name=".$thr[$i]." value=".$thr[$i]."></td>";
			}
		}
		else
		{
			if($thr_sta[$i] == "yes")
			{
				echo "<td>".$thr[$i]."<input type=\"checkbox\" name=".$thr[$i]." checked=\"yes\" value=".$thr[$i]."></td>";
			}
			else
			{
				echo "<td>".$thr[$i]."<input type=\"checkbox\" name=".$thr[$i]." value=".$thr[$i]."></td>";
			}
		}
	}	
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($fri))
	{
		if($fri[$i] < 10)
		{
			if($fri_sta[$i] == "yes")
			{
				echo "<td>0".$fri[$i]."<input type=\"checkbox\" name=".$fri[$i]." checked=\"yes\" value=".$fri[$i]."></td>";
			}
			else
			{
				echo "<td>0".$fri[$i]."<input type=\"checkbox\" name=".$fri[$i]." value=".$fri[$i]."></td>";
			}
		}
		else
		{
			if($fri_sta[$i] == "yes")
			{
				echo "<td>".$fri[$i]."<input type=\"checkbox\" name=".$fri[$i]." checked=\"yes\" value=".$fri[$i]."></td>";
			}
			else
			{
				echo "<td>".$fri[$i]."<input type=\"checkbox\" name=".$fri[$i]." value=".$fri[$i]."></td>";
			}
		}
	}	
	else
	{
		echo "<td>-</td>";
	}
	
	
	if($i < sizeof($sat))
	{
		if($sat[$i] < 10)
		{
			if($sat_sta[$i] == "yes")
			{
				echo "<td>0".$sat[$i]."<input type=\"checkbox\" name=".$sat[$i]." checked=\"yes\" value=".$sat[$i]."></td>";
			}
			else
			{
				echo "<td>0".$sat[$i]."<input type=\"checkbox\" name=".$sat[$i]." value=".$sat[$i]."></td>";
			}
		}
		else
		{
			if($sat_sta[$i] == "yes")
			{
				echo "<td>".$sat[$i]."<input type=\"checkbox\" name=".$sat[$i]." checked=\"yes\" value=".$sat[$i]."></td>";
			}
			else
			{
				echo "<td>".$sat[$i]."<input type=\"checkbox\" name=".$sat[$i]." value=".$sat[$i]."></td>";
			}
		}
	}	
	else
	{
		echo "<td>-</td>";
	}
	
	echo "</tr>";
}
echo "</tr>";
?>

</table><br>
<table>
<tr><th class=xl636519>Monthly SAH :</th><td><input type="textbox" name="msh" size="10" value="<?php echo $fac_plan; ?>"/></td></tr>
<TR></TR><TR></TR><TR></TR><TR></TR><TR></TR>
<tr><td><input type="submit" value="Save This" name="submit"></td></tr>
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
			//echo $_POST[$i]."<br>";
		}
	}
	$plan_value=$_POST['msh'];
	$data_sym="$";
	//echo implode(",",$date_value)."<br>";
	
	$year=date("Y");
	$month=date("m");
	
	$plan_fac=$plan_value;
	
	$dates_all="";
	for($i=0;$i<sizeof($date_value);$i++)
	{
		if($date_value[$i]<10)
		{
			$dates_all[]="\"".$year."-".$month."-0".$date_value[$i]."\"";
		}
		else
		{
			$dates_all[]="\"".$year."-".$month."-".$date_value[$i]."\"";
		}
		
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
	header("Location: $dns_adr3/projects/beta/reports/Production_Live_Chart/Control_Room_Charts/Dash_Board_new.php");
}
?>
</body>
</html>
<script>
$(document).ready(function(){
	$('#view-btn').click();
});
</script>