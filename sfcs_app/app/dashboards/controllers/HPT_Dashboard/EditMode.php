
<!--
Ticket#915423Date:2014-01-23/Task:Added Hourly Efficiency tag in Hourly Production Dashboard
-->
<?php
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	// $view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs);
	$dat=date("Y-m-d");
	$present_time=date("H")-6;
?>
<meta http-equiv="refresh" content="60">

<style type="text/css">
div.ex
{
padding:10px;
border:1px solid black;
margin:0px;
background:red;
color:white;
}
div.fx
{
padding:10px;
border:1px solid black;
margin:0px;
background:green;
color:white;
}

</style>


<style>
body
{
	background:#ffffff;
}
a
{
	color:#000000;
}
</style>
<script type="text/javascript" src=<?= getFullURLLevel($_GET['r'],'common/js/Charts/FusionCharts.js',4,'R'); ?>></script>
<script language="javascript">
	//FC_ChartUpdated method is called when user has changed dial value.
	function FC_ChartUpdated(DOMId){
		//Check if DOMId is that of the chart we want
		if (DOMId=="ChId1")
		{
			//Get reference to the chart
			var chartRef = getChartFromId(DOMId);
			//Get the current value
			var dialValue = chartRef.getData(1);			
			//You can also use getDataForId method as commented below, to get the dial value.
			//var dialValue = chartRef.getDataForId("CS");				
			//Update display
			var divToUpdate = document.getElementById("contentDiv");
			divToUpdate.innerHTML = "<span class='text'>Your satisfaction index: <B>" + Math.round(dialValue) + "%</B></span>";
			
		}
	}	
</script>
<style type="text/css">
.text{
	font-family:Arial, Helvetica, sans-serif;
	font-size:10pt;
}
</style>
<BODY>

<?php

	$present_time_new=$present_time;
	$sql1=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"1\"");
	while($row1=mysqli_fetch_array($sql1))
	{
		$time1=$row1["max(bac_lastup)"];
	}
	$time_split1=explode(" ",$time1);
	//echo "Time=".sizeof($time_split1);
	if(sizeof($time_split1) == 2)
	{
		/*
		$clock1=$time_split1[1];

		$clock_split1=explode(":",$clock1);

		$hour1=$clock_split1[0]-5;
		*/
		$sql2=mysqli_query($link, "SELECT SUM(plan_pro) FROM $bai_pro.pro_plan WHERE DATE=\"$dat\" and sec_no=\"1\"");
		while($row2=mysqli_fetch_array($sql2))
		{
			$plan=$row2["SUM(plan_pro)"]/16;
		}

		$sql=mysqli_query($link, "SELECT SUM(act_out) FROM $bai_pro.grand_rep WHERE DATE=\"$dat\" and section=\"1\"");
		while($row=mysqli_fetch_array($sql))
		{
			$act=$row["SUM(act_out)"]/16;
		}

		$sql1=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"1\"");
		while($row1=mysqli_fetch_array($sql1))
		{
			$time=$row1["max(bac_lastup)"];
		}

		$time_split=explode(" ",$time);
		$clock=$time_split[1];

		$clock_split=explode(":",$clock);

		$hour=$clock_split[0];

		//echo "Hour = ".$hour;

		$hour_value=$hour-6;

		$act_val=round($act,0)*$hour_value;
		$plan_val=round($plan,0)*$hour_value;

		$hour1=round(($act_val/div_by_zero($plan_val))*16,2);

		//echo "Hour = ".$hour1;
	}
	else
	{
		$hour1=0;
	}

	if($hour1 == $present_time_new)
	{
		$sec1="fx";
	}
	else
	{
		$sec1="ex";
	}



	$sql2=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"2\"");
	while($row2=mysqli_fetch_array($sql2))
	{
		$time2=$row2["max(bac_lastup)"];
	}

	$time_split2=explode(" ",$time2);
	if(sizeof($time_split2) == 2)
	{
		/*
		$clock2=$time_split2[1];

		$clock_split2=explode(":",$clock2);

		$hour2=$clock_split2[0]-5;
		*/
		$sql2=mysqli_query($link, "SELECT SUM(plan_pro) FROM $bai_pro.pro_plan WHERE DATE=\"$dat\" and sec_no=\"2\"");
		while($row2=mysqli_fetch_array($sql2))
		{
			$plan=$row2["SUM(plan_pro)"]/16;
		}

		$sql=mysqli_query($link, "SELECT SUM(act_out) FROM $bai_pro.grand_rep WHERE DATE=\"$dat\" and section=\"2\"");
		while($row=mysqli_fetch_array($sql))
		{
			$act=$row["SUM(act_out)"]/16;
		}

		$sql1=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"2\"");
		while($row1=mysqli_fetch_array($sql1))
		{
			$time=$row1["max(bac_lastup)"];
		}

		$time_split=explode(" ",$time);
		$clock=$time_split[1];

		$clock_split=explode(":",$clock);

		$hour=$clock_split[0];

		//echo "Hour-2--1 = ".$hour."<br>";

		$hour_value=$hour-6;
		//echo $act."-".$plan."<br>";
		$act_val=round($act,0)*$hour_value;
		$plan_val=round($plan,0)*$hour_value;

		$hour2=round(($act_val/div_by_zero($plan_val))*16,2);
		//echo "Hour-2 = ".$hour2;
	}
	else
	{
		$hour2=0;
	}

	if($hour2 == $present_time_new)
	{
		$sec2="fx";
	}
	else
	{
		$sec2="ex";
	}


	$sql3=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"3\"");
	while($row3=mysqli_fetch_array($sql3))
	{
		$time3=$row3["max(bac_lastup)"];
	}

	$time_split3=explode(" ",$time3);
	if(sizeof($time_split3) == 2)
	{
		/*
			$clock3=$time_split3[1];

			$clock_split3=explode(":",$clock3);

			$hour3=$clock_split3[0]-5;
		*/
		$sql2=mysqli_query($link, "SELECT SUM(plan_pro) FROM $bai_pro.pro_plan WHERE DATE=\"$dat\" and sec_no=\"3\"");
		while($row2=mysqli_fetch_array($sql2))
		{
			$plan=$row2["SUM(plan_pro)"]/16;
		}

		$sql=mysqli_query($link, "SELECT SUM(act_out) FROM $bai_pro.grand_rep WHERE DATE=\"$dat\" and section=\"3\"");
		while($row=mysqli_fetch_array($sql))
		{
			$act=$row["SUM(act_out)"]/16;
		}

		$sql1=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"3\"");
		while($row1=mysqli_fetch_array($sql1))
		{
			$time=$row1["max(bac_lastup)"];
		}

		$time_split=explode(" ",$time);
		$clock=$time_split[1];

		$clock_split=explode(":",$clock);

		$hour=$clock_split[0];

		//echo "Hour = ".$hour;

		$hour_value=$hour-6;

		$act_val=round($act,0)*$hour_value;
		$plan_val=round($plan,0)*$hour_value;

		$hour3=round(($act_val/div_by_zero($plan_val))*16,2);
		//echo "Hour = ".$hour3;
	}
	else
	{
		$hour3=0;
	}

	if($hour3 == $present_time_new)
	{
		$sec3="fx";
	}
	else
	{
		$sec3="ex";
	}
?>

<table align="center">

<tr>
<th colspan="2">

<img src= "<?= getFullURLLevel($_GET['r'],'common/images/focus_logo.gif',2,'R');?>" alt='focus_logo' >
</th>
<th colspan="7">
<div id="chart1div">
  This text is replaced by the Flash movie.
</div>

<script type="text/javascript">

   var charts_url_01 = '<?= getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>';
   var chart1 = new FusionCharts(charts_url_01, "ChId1", "750", "250", "0", "1");
   var data_url = '<?= getFullURL($_GET['r'],'Data.php','R'); ?>';
   chart1.setDataURL(data_url);
   chart1.render("chart1div");
</script>
<DIV id="contentDiv">
<?php 
$main_he_url= getFullURLLevel($_GET['r'],'hourly_Eff_test.php',0,'R'); ?>
	<span class='text'><h3 style="color:red;">Factory<?php echo "&nbsp;&nbsp;&nbsp;<a href=\"$main_he_url\" onclick=\"Popup=window.open('$main_he_url"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?></h3></span>
</DIV>
</th>
</tr>
<tr>
	<th>
	<!--section 1-->
	<div id="chart2div">
	  This text is replaced by the Flash movie.
	</div>
	<DIV id="contentDiv">
		<span class='text'>
	<?php 
	$he_url = getFullURLLevel($_GET['r'],'sec_rep.php',0,'R');
	$heff_url = getFullURLLevel($_GET['r'],'Hourly_Eff_Live.php',0,'R');
	// echo $he_url.'==_=='.$heff_url;
	
	?>
	<h3 style="color:red;">Section - 1&nbsp;&nbsp;<?php echo "<a href=\" $he_url?section=1\" onclick=\"Popup=window.open('$he_url?section=1"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">PB </a>&nbsp;&nbsp;<a href=\"$heff_url?sec_x=1\" onclick=\"Popup=window.open('$heff_url?sec_x=1"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?>
	<?php echo "<div class=".$sec1.">".$hour1."/".$present_time_new."</div>";?>
	</h3></span>
	</DIV>
	<script type="text/javascript">
	   var charts_url_11 = '<?= "..".getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>';
	   var chart2 = new FusionCharts(charts_url_11, "ChId1", "350", "180", "0", "1");
	   var data1_url = '<?= getFullURL($_GET['r'],'Data1.php','R'); ?>';
	   chart2.setDataURL(data1_url);
	   chart2.render("chart2div");
	</script>

	</th><th></th><th></th><th></th>
	<!--section 2-->
	<th>
	<div id="chart3div">
	  This text is replaced by the Flash movie.
	</div>

	<script type="text/javascript">
	   var charts_url_1 = '<?= "..".getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>';
	   var chart3 = new FusionCharts(charts_url_1, "ChId1", "350", "180", "0", "1");
	   var data2_url = '<?= getFullURL($_GET['r'],'Data2.php','R'); ?>';
	   chart3.setDataURL(data2_url);
	   chart3.render("chart3div");
	</script>
	<DIV id="contentDiv">
		<span class='text'><h3 style="color:red;">Section - 2&nbsp;&nbsp;<?php echo "<a href=\"$he_url?section=2\" onclick=\"Popup=window.open('$he_url?section=2"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">PB </a>&nbsp;&nbsp;<a href=\"$heff_url?sec_x=2\" onclick=\"Popup=window.open('$heff_url?sec_x=2"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?><?php echo "<div class=".$sec2.">".$hour2."/".$present_time_new."</div>";?></h3></span>
	</DIV>
	</th>
	<th></th><th></th><th></th>

	<!--section 3-->
	<th>
	<div id="chart4div">
	  This text is replaced by the Flash movie.
	</div>

	<script type="text/javascript">
	   var charts_url = '<?= "..".getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>';
	   var chart4 = new FusionCharts(charts_url, "ChId1", "350", "180", "0", "1");
	   var data3_url = '<?= getFullURL($_GET['r'],'Data.php','R'); ?>';
	   chart4.setDataURL(data3_url);
	   chart4.render("chart4div");
	</script>
	<DIV id="contentDiv">
		<span class='text'><h3 style="color:red;">Section - 3&nbsp;&nbsp;<?php echo "<a href=\"$he_url?section=3\" onclick=\"Popup=window.open('$he_url?section=3"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">PB </a>&nbsp;&nbsp;<a href=\"$heff_url?sec_x=3\" onclick=\"Popup=window.open('$heff_url?sec_x=3"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?><?php echo "<div class=".$sec3.">".$hour3."/".$present_time_new."</div>";?></h3></span>
	</DIV>
	</th>
</tr>
<tr>
	<th>
	<?php
	/*
	<!--section 4-->
	<div id="chart5div">
	  This text is replaced by the Flash movie.
	</div>

	<script type="text/javascript">
	   var chart5 = new FusionCharts("../Charts/AngularGauge.swf", "ChId1", "350", "180", "0", "1");
	   chart5.setDataURL("Data4.php");
	   chart5.render("chart5div");
	</script>
	<DIV id="contentDiv">
		<span class='text'><h3 style="color:red;">Section - 4&nbsp;&nbsp;<?php echo "<a href=\"http://bai3net:8080/projects/alpha/anu/ims/sec_rep.php?section=4\" onclick=\"Popup=window.open('http://bai3net:8080/projects/alpha/anu/ims/sec_rep.php?section=4"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">PB </a>&nbsp;&nbsp;<a href=\"http://bai3net:8080/projects/alpha/anu/new_int_v5/Hourly_Eff_Live.php?sec_x=4\" onclick=\"Popup=window.open('http://bai3net:8080/projects/alpha/anu/new_int_v5/Hourly_Eff_Live.php?sec_x=4"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?><?php echo "<div class=".$sec4.">".$hour4."/".$present_time_new."</div>";?></h3></span>
	</DIV>
	</th>
	<th></th><th></th><th></th>
	<th>
	<!--section 5-->
	<div id="chart6div">
	  This text is replaced by the Flash movie.
	</div>

	<script type="text/javascript">
	   var chart6 = new FusionCharts("../Charts/AngularGauge.swf", "ChId1", "350", "180", "0", "1");
	   chart6.setDataURL("Data5.php");
	   chart6.render("chart6div");
	</script>
	<DIV id="contentDiv">
		<span class='text'><h3 style="color:red;">Section - 5&nbsp;&nbsp;<?php echo "<a href=\"http://bai3net:8080/projects/alpha/anu/ims/sec_rep.php?section=5\" onclick=\"Popup=window.open('http://bai3net:8080/projects/alpha/anu/ims/sec_rep.php?section=5"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">PB </a>&nbsp;&nbsp;<a href=\"http://bai3net:8080/projects/alpha/anu/new_int_v5/Hourly_Eff_Live.php?sec_x=5\" onclick=\"Popup=window.open('http://bai3net:8080/projects/alpha/anu/new_int_v5/Hourly_Eff_Live.php?sec_x=5"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?><?php echo "<div class=".$sec5.">".$hour5."/".$present_time_new."</div>";?></h3></span>
	</DIV>
	</th>
	<th></th><th></th><th></th>
	<th>
	<!--section 6-->


	<div id="chart7div">
	  This text is replaced by the Flash movie.
	</div>

	<script type="text/javascript">
	   var chart7 = new FusionCharts("../Charts/AngularGauge.swf", "ChId1", "350", "180", "0", "1");
	   chart7.setDataURL("Data6.php");
	   chart7.render("chart7div");
	</script>
	<DIV id="contentDiv">
		<span class='text'><h3 style="color:red;">Section - 6&nbsp;&nbsp;<?php echo "<a href=\"http://bai3net:8080/projects/alpha/anu/ims/sec_rep.php?section=6\" onclick=\"Popup=window.open('http://bai3net:8080/projects/alpha/anu/ims/sec_rep.php?section=6"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">PB </a>&nbsp;&nbsp;<a href=\"http://bai3net:8080/projects/alpha/anu/new_int_v5/Hourly_Eff_Live.php?sec_x=6\" onclick=\"Popup=window.open('http://bai3net:8080/projects/alpha/anu/new_int_v5/Hourly_Eff_Live.php?sec_x=6"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">HE </a>";?><?php echo "<div class=".$sec6.">".$hour6."/".$present_time_new."</div>";?></h3></span>
	</DIV>
	</th>
	*/
	?>
</tr>
</table>
</BODY>
