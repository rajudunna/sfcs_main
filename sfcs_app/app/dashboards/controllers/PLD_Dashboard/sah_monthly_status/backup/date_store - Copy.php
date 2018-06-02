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
<!--<form name="form1" method="post" action="date_store.php?saving=1">-->
<form name="form1" method="post" action="date_store.php">
<table class=xl636519>
<tr><th class=xl636519>Month Working Dates:</th><td><input type="textbox" name="mwd" size="75" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31"/></td></tr>
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
	
	$date_value = $_POST['mwd'];
	$plan_value=$_POST['msh'];
	$data_sym="$";
	//echo $data."<br>";
	
	$year=date("Y");
	$month=date("m");
	//$date_explode=explode(":",$data);
	//echo sizeof($date_explode)."<br>";
	//echo sizeof($date_explode)."---".$date_explode[0]."---".$date_explode[1]."---".$date_explode[2]."<br>";
	//$plan=explode(";",$date_explode[2]);
	//echo $plan[0]."<br>";
	$plan_fac=$plan_value;
	
	//$data_explode=explode(";",$date_explode[1]);
	$dates=explode(",",$date_value);
	
	$dates_all="";
	for($i=0;$i<sizeof($dates);$i++)
	{
		$dates_all[]="\"".$year."-".$month."-".$dates[$i]."\"";
	}
	$all_dates=implode(",",$dates_all);
	
	$dates_all1="";
	for($i=0;$i<sizeof($dates);$i++)
	{
		$dates_all1[]="\"".$dates[$i]."\"";
	}
	$all_dates1=implode(",",$dates_all1);
	
	$File = "data.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."date=array(".$all_dates."); ".$data_sym."date1=array(".$all_dates1."); ".$data_sym."fac_plan=\"".$plan_fac."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);	
	echo "Data Saved successfully!<br>";

}
?>
</body>
</html>