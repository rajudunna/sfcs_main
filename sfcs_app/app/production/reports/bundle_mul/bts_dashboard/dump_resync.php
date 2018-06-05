<?php
include("dbconf.php");
set_time_limit("500000");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<title>Data Dumping</title>
<style>
	<style>
body
{
	font-family:Arial;
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
	font-family:Arial;
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


h2
{
	font-family:Arial;
}
h1{
	font-family:Arial;
}
h3{
	font-family:Arial;
}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:25px;
 right:0;
 width:auto;
float:right;
}
</style>
	

<script src="js/jquery.min1.7.1.js"></script>
<script src="ddtf.js"></script>


<link rel="stylesheet" type="text/css" media="all" href="jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsdatepick-calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>
<h2>Missing Dump Data</h2>

<form method="POST" action="dump_resync.php" name="input">

<?php

?>
Start Date: <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>"> End Date: <input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="edate" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>">
<input type="submit" name="submit" value="submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"/>


</form>

<span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span>

<?php


if(isset($_POST['submit']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	
	echo $sdate."--".$edate."<br>";
	//$hour=HOUR(CURTIME()); 
	//SET @hoursdiff=(SELECT (TIMESTAMPDIFF(MINUTE,time_stamp,NOW())) AS hrsdff FROM `snap_session_track` WHERE session_id=1); 
	//SET @swap_session_status=(SELECT session_status FROM snap_session_track WHERE session_id='1'); 
	//SET @last_id_orders=(SELECT MAX(tbl_orders_sizes_master_id) FROM view_set_2_snap); 
	//SET @last_id_mini=(SELECT MAX(tbl_miniorder_data_id) FROM view_set_3_snap); 
	//SET @last_id_tran=(SELECT MAX(bundle_transactions_20_repeat_id) FROM view_set_snap_1_tbl WHERE bundle_transactions_20_repeat_operation_id='4'); 
	$last_id_orders=echo_title("brandix_bts_uat.view_set_2_snap","MAX(tbl_orders_sizes_master_id)","1",1,$link);
	$last_id_mini=echo_title("brandix_bts_uat.view_set_3_snap","MAX(tbl_miniorder_data_id)","1",1,$link);
	$last_id_tran=echo_title("brandix_bts_uat.view_set_snap_1_tbl","MAX(bundle_transactions_20_repeat_id)","bundle_transactions_20_repeat_operation_id",4,$link);
	$last_id_ini=echo_title("brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles","MAX(id)","1",1,$link);
	//SELECT MAX(id) FROM bundle_transactions_20_repeat_virtual_snap_ini_bundles);
	
	$sql="UPDATE `brandix_bts_uat`.snap_session_track SET session_status ='on',swap_status ='run1' WHERE session_id=1"; 
	$result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql2="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_1_snap` SELECT * FROM `brandix_bts`.`view_set_1` where date(bundle_transactions_date_time) between '".$sdate."' and '".$edate."'"; 
	$result1=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql12="UPDATE `brandix_bts_uat`.snap_session_track SET fg_last_updated_tid ='1' WHERE session_id=1";
	$result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
		 
	$sql3="INSERT IGNORE INTO brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles SELECT @s:=@s+1 id,1 AS parent_id,bundle_number AS bundle_barcode,quantity,bundle_number AS bundle_id,5 AS operation_id,0 AS rejection_qty, 0 AS act_module FROM brandix_bts.tbl_miniorder_data,(SELECT @s:=MAX(id) FROM brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles) AS s"; 
	$result3=mysqli_query($link, $sql3) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql13="UPDATE snap_session_track SET fg_last_updated_tid ='2' WHERE session_id=1";
	$result13=mysqli_query($link, $sql13) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	$sql4="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_1_snap` SELECT * FROM `brandix_bts_uat`.`view_set_1_virtual` WHERE bundle_transactions_20_repeat_id > '".$last_id_ini."'"; 
	$result4=mysqli_query($link, $sql4) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql14="UPDATE snap_session_track SET fg_last_updated_tid ='3' WHERE session_id=1";
	$result14=mysqli_query($link, $sql14) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 	
	
	$sql5="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_2_snap` SELECT * FROM `brandix_bts`.`view_set_2`";
	$result5=mysqli_query($link, $sql5) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql15="UPDATE snap_session_track SET fg_last_updated_tid ='4' WHERE session_id=1";
	$result15=mysqli_query($link, $sql15) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql6="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_3_snap` SELECT * FROM `brandix_bts`.`view_set_3` WHERE date(tbl_miniorder_data_date_time) between '".$sdate."' and '".$edate."'";
	$result6=mysqli_query($link, $sql6) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql16="UPDATE snap_session_track SET fg_last_updated_tid ='5' WHERE session_id=1";
	$result16=mysqli_query($link, $sql16) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
	$sql7="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_snap_1_tbl` SELECT * FROM `brandix_bts_uat`.`view_set_snap_1_backup` WHERE bundle_transactions_20_repeat_operation_id = '5' AND bundle_transactions_20_repeat_id > '".$last_id_ini."'"; 
	$result7=mysqli_query($link, $sql7) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql17="UPDATE snap_session_track SET fg_last_updated_tid ='6' WHERE session_id=1";
	$result17=mysqli_query($link, $sql17) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 	
	
	$sql8="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_snap_1_tbl` SELECT * FROM `brandix_bts_uat`.`view_set_snap_1_backup` WHERE date(bundle_transactions_date_time) between '".$sdate."' and '".$edate."'";
	$result8=mysqli_query($link, $sql8) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql1511="UPDATE snap_session_track SET time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='4') WHERE session_id=1"; 
	$result1511=mysqli_query($link, $sql1511) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql18="UPDATE snap_session_track SET fg_last_updated_tid ='7' WHERE session_id=1";
	$result18=mysqli_query($link, $sql18) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));  
	
	$sql9="DELETE FROM `brandix_bts_uat`.`view_set_4_snap` WHERE DATE between '".$sdate."' and '".$edate."'"; 
	$result9=mysqli_query($link, $sql9) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql19="UPDATE snap_session_track SET fg_last_updated_tid ='8' WHERE session_id=1";
	$result19=mysqli_query($link, $sql19) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
	$sql10="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_4_snap` SELECT * FROM `brandix_bts`.`view_set_4` where date between '".$sdate."' and '".$edate."'";
	$result10=mysqli_query($link, $sql10) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	$sql20="UPDATE snap_session_track SET fg_last_updated_tid ='9' WHERE session_id=1";
	$result20=mysqli_query($link, $sql20) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql11="DELETE FROM `brandix_bts_uat`.`view_set_5_snap` WHERE LOG_DATE between '".$sdate."' and '".$edate."'"; 
	$result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql21="UPDATE snap_session_track SET fg_last_updated_tid ='10' WHERE session_id=1";
	$result21=mysqli_query($link, $sql21) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql121="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_5_snap` SELECT * FROM `brandix_bts`.`view_set_5` WHERE LOG_DATE between '".$sdate."' and '".$edate."'"; 
	$result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql22="UPDATE snap_session_track SET fg_last_updated_tid ='11' WHERE session_id=1";
	$result22=mysqli_query($link, $sql22) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql131="DELETE FROM `brandix_bts_uat`.`view_set_6_snap` WHERE DATE between '".$sdate."' and '".$edate."'";  
	$result131=mysqli_query($link, $sql131) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql23="UPDATE snap_session_track SET fg_last_updated_tid ='12' WHERE session_id=1";
	$result23=mysqli_query($link, $sql23) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql141="INSERT IGNORE INTO `brandix_bts_uat`.`view_set_6_snap` SELECT * FROM `brandix_bts`.`view_set_6` where DATE between '".$sdate."' and '".$edate."'";  
	$result141=mysqli_query($link, $sql141) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql24="UPDATE snap_session_track SET fg_last_updated_tid ='13' WHERE session_id=1";
	$result24=mysqli_query($link, $sql24) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
	$sql151="UPDATE snap_session_track SET session_status='off',swap_status='over',time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='4') WHERE session_id=1"; 
	$result151=mysqli_query($link, $sql151) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql25="UPDATE snap_session_track SET fg_last_updated_tid ='14' WHERE session_id=1";
	$result25=mysqli_query($link, $sql25) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";

}
?>


</body>
</html>
