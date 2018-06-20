<!--
Changes Log:

2014-03-20 / kirang/ Ticket #716563 : Add the chandrasekharka,venkataramak in $authorized Array 
service request #873936 /2014-12-18/ kirang:  Add the comments for authorization
-->
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>Weekly Delivery Dashboard - Packing</title>
<head>
<script type="text/javascript" src="datetimepicker_css.js"></script>
<script language="javascript" type="text/javascript"
		src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js', 3, 'R');?>"></script>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:1px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>

</head>
<body>
<?php

//$tid=$_GET["tid"];
//$schedule=$_GET["schedule"];
$permission = hasviewpermission($_GET['r']);
if(isset($_GET['schedule']))
{
	$schedule=$_GET['schedule'];
}
else
{
	$schedule=$_POST['dels'];
	//$division="All";
}


//$weeknumber = date("W"); 
//echo $weeknumber;
include("header.php");
// Ticket #716563 : Add the chandrasekharka,venkataramak in $authorized Array 
$authorized=array("rajasekhark","muralip","venkateshch","nagendrak","eswarammae","lakshmik","ganesht","prasadms","kirangr","chandrasekharka","venkataramak");  // authorization to add the schedules into IDS if any short shipment purpose.
$fg_authorized=array("baiidsfgw","kirangr"); // for FG IDS display screen need to apply only offered for schedules. 
$spc_users=array("amulyap","kirang","kirang","duminduw","sureshn","baifg"); // for any action like FG-Released/offered/M3 Reported.

//$authorized=array("kirang","kirang","amulyap","edwinr","sasidharch","lilanku","sureshn","rajasekhark","baifg","eswarammae","lakshmik","prasadms","muralip","venkateshch","srinivasaraoro","ganesht","nagendrak");

if(in_array($authorized,$permission))
{
	echo"<form action=\"status_update.php\" method=\"POST\">";
	echo"<table><tr><th>Status</th><td><select name=\"sta\">";
	echo"<option>Offered</option>";
	echo"</select></td>";
	echo"</tr></tr><th>Schedule</th><td><input type=\"text\" name=\"dels\" value=\"".$schedule."\" /></td></tr></table>";	
	echo"<input type=\"submit\" name=\"submit2\" value=\"Update\" />";
	echo"</form>";	
}
else if(in_array($authorized,$permission))
{
	echo"<form action=\"status_update.php\" method=\"POST\">";
	echo"<table><tr><th>Status</th><td><select name=\"sta\">";
	echo"<option>M3 Reported</option>";
	echo"</select></td>";
	echo"</tr></tr><th>Schedule</th><td><input type=\"text\" name=\"dels\" value=\"".$schedule."\" /></td></tr></table>";	
	echo"<input type=\"submit\" name=\"submit2\" value=\"Update\" />";
	echo"</form>";	
}
else if(in_array($authorized,$permission))
{
	echo"<form action=\"status_update.php\" method=\"POST\">";
	echo"<table><tr><th>Status</th><td><select name=\"sta\">";
	echo"<option></option>";
	echo"<option>FG-Released</option>";
	echo"<option>Offered</option>";
	echo"<option>M3 Reported</option>";
	echo"</select></td>";
	echo"</tr></tr><th>Schedule</th><td><input type=\"text\" name=\"dels\" value=\"".$schedule."\" /></td></tr></table>";	
	echo"<input type=\"submit\" name=\"submit2\" value=\"Update\" />";
	echo"</form>";	
}
else
{
	echo "<h2>You are not authorized to use this interface</h2>";
}


?>

<?php
if(isset($_POST["submit2"]))
{
	include("header.php");
	
	$weeknumber = date("W"); 
	//echo $weeknumber;

	$year =date("Y");
	$dates=array();
	for($day=1; $day<=7; $day++)
	{
	    $dates[]=date('Y-m-d',strtotime($year."W".$weeknumber.$day))."\n";
	}

	$start_date=min($dates);
	$end_date=max($dates);
	
	$schedules=$_POST["dels"];
	$sta=$_POST["sta"];
	
	//$sqlxrs="select * from weekly_delivery_status_finishing where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\"";
	$sqlxrs="select * from weekly_delivery_status_finishing where schedule=\"".$schedules."\"";
	//echo $sqlxrs;
	$resultxrs=mysqli_query($link, $sqlxrs) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowsxrs=mysqli_num_rows($resultxrs);
	while($rowxxs=mysqli_fetch_array($resultxrs))
	{
		$log_times=$rowxxs["log_time"];
		$status_ur=$rowxxs["status"];
	}
	
	if($status_ur == $sta)
	{
		if($sta == "M3 Reported")
		{
			$sql3="update weekly_delivery_status_finishing set dispatch_status=\"".date("Y-m-d H:i:s")."^".$username."\",log_time=\"$log_times\",status=\"".$sta."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		}
		
		if($sta == "Offered")
		{
			$sql3="update weekly_delivery_status_finishing set offered_status=\"".date("Y-m-d H:i:s")."^".$username."\",log_time=\"$log_times\",status=\"".$sta."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		}
		
		if($sta == "FG-Released")
		{
			$sql3="update weekly_delivery_status_finishing set log_time=\"$log_times&".$sta."^".date("Y-m-d H:i:s")."^".$username."\",status=\"FG*\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		}
		
	}
	else
	{
		if($sta == "M3 Reported")
		{
			$sql3="update weekly_delivery_status_finishing set dispatch_status=\"".date("Y-m-d H:i:s")."^".$username."\",log_time=\"$log_times&".$sta."^".date("Y-m-d H:i:s")."\",status=\"".$sta."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		}
		
		if($sta == "Offered")
		{
			$sql3="update weekly_delivery_status_finishing set offered_status=\"".date("Y-m-d H:i:s")."^".$username."\",log_time=\"$log_times&".$sta."^".date("Y-m-d H:i:s")."\",status=\"".$sta."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		}
		
		if($sta == "FG-Released")
		{
			$sql3="update weekly_delivery_status_finishing set log_time=\"$log_times&".$sta."^".date("Y-m-d H:i:s")."^".$username."\",status=\"FG*\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		}
	}
	
	//echo $sql3."<br>";
	mysqli_query($link, $sql3) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	
	/*if($sta == "Offered")
	{
		if($status_ur == "FG")
		{
			$sql31="update weekly_delivery_status_finishing set offered_status=\"".date("Y-m-d H:i:s")."^".$username."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
			mysql_query($sql31,$link) or die("Error22 = ".mysql_error());
			echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
		}
		else if($status_ur == "Offered")
		{
			echo "<h2>It is already $status_ur Reported.</h2>";
		}
		else
		{
			echo "<h2>Still it is in $status_ur status. You can only update FG Shchedules for Offered.</h2>";
		}		
	}*/
	
	if($sta == "FG-Released")
	{
		$sql31="update weekly_delivery_status_finishing set log_time=\"$log_times&".$sta."^".date("Y-m-d H:i:s")."^".$username."\",status=\"FG*\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		mysqli_query($link, $sql31) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql31;
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}
	
	if($sta == "Offered")
	{
		$sql31="update weekly_delivery_status_finishing set offered_status=\"".date("Y-m-d H:i:s")."^".$username."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
		mysqli_query($link, $sql31) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql31;
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";	
	}
	
	if($sta == "M3 Reported")
	{
		if($status_ur == "FCA" || $status_ur == "FCA\P")
		{
			$sql32="update weekly_delivery_status_finishing set dispatch_status=\"".date("Y-m-d H:i:s")."^".$username."\" where schedule=\"".$schedules."\" and ex_fact between \"".trim($start_date)."\" and \"".trim($end_date)."\" ";
			mysqli_query($link, $sql32) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
		}
		else if($status_ur == "M3 Reported")
		{
			echo "<h2>It is already $status_ur Reported.</h2>";
		}
		else
		{
			echo "<h2>Still it is in $status_ur status. You can only update FCA & FCA\P Shchedules for Dispatch.</h2>";
		}			
	}

//echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";

}
?>

</body>
</html>