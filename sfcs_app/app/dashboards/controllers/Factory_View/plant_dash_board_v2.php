<?php
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
include("../../../../common/config/config.php");
$sec_x=$_GET['sec_x'];
?>

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
<table class="table-bordered">
<tr>
<th colspan="7">

<iframe style="width: 1360px;" src="sah_live_dashboard_cum.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no" ></iframe>

	<iframe style="width: 480px;" src="sah_live_dashboard_guage.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no" ></iframe>
    <iframe style="width: 400px;" src="vled.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no" ></iframe>
	<iframe style="width: 400px;" src="section_kpi.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe>
	</th>
</tr>
<tr>
<td><iframe style="width: 260px;" src="fab_pps_dashboard_v2_live.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td><iframe style="width: 250px;" src="tms_dashboard_v2_live.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td><iframe style="width: 250px;" src="cpanel_main_live_dashboard.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td><iframe style="width: 250px;" src="section_rls_live.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>


<td><iframe style="width: 250px;" src="packing_dashboard_live_dashboard.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<!-- <td><iframe style="width: 200px;" src="<?php echo $dns_adr3; ?>/projects/Beta/Reports/Production_Live_Chart/Control_Room_Charts/Dash_Board_new.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td> -->
<td><iframe style="width: 250px;" src="Attendance_live_dashboard.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
<td ><iframe style="width: 1200px; " src="sah_live_dashboard_V2.php?sec_x=<?php echo $sec_x."&rand=".rand(); ?>" frameborder="no"> </iframe></td>
</tr>
</table>

</body>
