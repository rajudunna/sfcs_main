<?php
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include ("dbconf.php");
set_time_limit(2000);

?>



<html>
<head>
<!-- <link href="table_style.css" rel="stylesheet" type="text/css" /> -->

</head>
<body>

<?php

// $database2="bai_pro";
// $user2=$host_adr_un;
// $password2=$host_adr_pw;
// $host2=$host_adr;
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];


$link2= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host2, $user2, $password2)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $bai_pro) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"])); 


		$sql1="select * from $pps.movex_styles where plant_code='$plantcode'";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style_id=$sql_row1['style_id'];
			$mod_count=0;
			
			$date_check=date("Y-m-d");
			$sql="select max(date) as \"date\" from $pps.db_update_log where plant_code='$plantcode'";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$date_check=$sql_row['date'];
			}	

			$sql="select count(mod_no) as \"mod_count\" from $bai_pro.pro_mod where mod_date=\"$date_check\" and mod_style=\"$style_id\"";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$mod_count=$sql_row['mod_count'];
			} 
			$sql="update $pps.movex_styles set mod_count=$mod_count,updated_user='$username',updated_at='".date('Y-m-d')."'
			 where   plant_code='$plantcode' and style_id=\"$style_id\"";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
			
		}
		$url=getFullURLLevel($_GET['r'],'module_count.php',0,'N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
?>	

</body>
</html>


	