<?php
include ("../../../../common/config/config.php");
$sec_x=$_GET['sec_x'];
?>
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<meta http-equiv="refresh" content="2700" >
<style>
iframe 
{
	height:100%;
	border: 0;
	overflow:auto;
}

body 
{
	zoom: 90%;
	overflow:auto;
	background-color:#eeeeee;
	color: #000000;
	font-family: Trebuchet MS;
}

table
{
	height:auto;
	
}
th
{
	height:370px;
}

td
{
	height:770px;
	vertical-align:top;
	
}

</style>
<title>Factory View Sec-<?php echo $sec_x; ?></title>
<body>

<?php

$time=date("H");

if($time < 12)
{
	$status="Good Morning....!";
}
else if($time >=12 and $time < 17)
{
	$status="Good Afternoon....!";
}
else if($time >=17 and $time <= 22)
{
	$status="Good Evening....!";
}
else
{
	$status="Good Night....!";
}


?>

<table class="table-bordered">
<tr>
<th colspan="7">

<iframe style="width: 1360px;" src="<?php echo $dns_adr3; ?>/projects/dashboards/production_kpi/sah_live_dashboard_cum.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no" ></iframe>

	<iframe style="width: 480px;" src="<?php echo $dns_adr3; ?>/projects/dashboards/production_kpi/sah_live_dashboard_guage.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no" ></iframe>
    <iframe style="width: 400px;" src="<?php echo $dns_adr3; ?>/projects/dashboards/production_kpi/vled.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no" ></iframe>
	<iframe style="width: 400px;" src="<?php echo $dns_adr3; ?>/projects/dashboards/production/section_kpi.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe>
	</th>
</tr>
<tr>
<td><iframe style="width: 260px;" src="<?php echo $dns_adr3; ?>/projects/beta/production_planning/fab_pps_dashboard_v2_live.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td><iframe style="width: 250px;" src="<?php echo $dns_adr3; ?>/projects/beta/Reports/tms_dashboard/tms_dashboard_v2_live.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td><iframe style="width: 250px;" src="<?php echo $dns_adr3; ?>/projects/beta/cut_plan_new/ims/cpanel/cpanel_main_live_dashboard.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td><iframe style="width: 250px;" src="<?php echo $dns_adr3; ?>/Projects/Beta/Reports/rework_dashboard/section_rls_live.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>


<td><iframe style="width: 250px;" src="<?php echo $dns_adr3; ?>/projects/beta/packing/packing/packing_dashboard_live_dashboard.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<!-- <td><iframe style="width: 200px;" src="<?php echo $dns_adr3; ?>/projects/Beta/Reports/Production_Live_Chart/Control_Room_Charts/Dash_Board_new.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td> -->
<td><iframe style="width: 250px;" src="<?php echo $dns_adr3; ?>/projects/dashboards/production_kpi/Attendance_live_dashboard.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td ><iframe style="width: 1200px; " src="<?php echo $dns_adr3; ?>/projects/dashboards/production_kpi/sah_live_dashboard_V2.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
</tr>
<!--<tr>
<td colspan="6">
<marquee><h1 style="font-size:60px;color:Yellow;"><?php echo $status; ?></h1></marquee>
</td>
</tr>-->
</table>

</body>
