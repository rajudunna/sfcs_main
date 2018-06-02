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
<!--<tr><th>Weeks</th></tr>--><tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr>
<!--<tr><th class=xl636519>Month Working Dates:</th></tr>-->
<?php
$k=0;
for($i=1;$i<=31;$i++)
{	
	//echo date("Y-m-$i");
	if(in_array("$i",$date1))
	{
		//$check="yes";
		//echo $i."---".$check."<br>";
		$date=date("Y-m-$i");
		$weekday1 = date('l', strtotime($date));
		$k=$k+1;
		echo $k;
		echo $weekday1;
		if($weekday1 == "sunday")
		{
			//echo "<tr><td>$i<input type=\"checkbox\" name=".$i." checked=\"yes\" value=".$i."></td></tr>";			
			echo "<table class=xl636519><tr><td>$i<input type=\"checkbox\" name=".$i." checked=\"yes\" value=".$i."></td></tr></table>";				
		}
		else
		{
			if($k%8 == 0)
			{
				echo "<tr><td>$i<input type=\"checkbox\" name=".$i." checked=\"yes\" value=".$i."></td><tr>";
			}
			else
			{
				echo "<td>$i<input type=\"checkbox\" name=".$i." checked=\"yes\" value=".$i."></td>";
			}
		}
		
		//echo "<td>$i<input type=\"checkbox\" name=".$i." checked=\"yes\" value=".$i."></td>";
	}
	else
	{
		//$check="";
		//echo $i."---".$check."<br>";
		$date=date("Y-m-$i");
		$weekday1 = date('l', strtotime($date));
		$k=$k+1;
		echo $k;
		echo $weekday1;
		if($k%8 == 0)
		{
			echo "<td>$i<input type=\"checkbox\" name=".$i."  value=".$i."></td>";
		}
		else
		{
			echo "<td>$i<input type=\"checkbox\" name=".$i."  value=".$i."></td>";
		}
	}
	
}
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
	//header("Location:http://bainet:8080/projects/beta/reports/Production_Live_Chart/Control_Room_Charts/Dash_Board_new.php");
}
?>
</body>
</html>