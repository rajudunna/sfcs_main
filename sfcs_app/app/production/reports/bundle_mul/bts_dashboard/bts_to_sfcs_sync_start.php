<?php
include("dbconf.php");
?>


<?php

//include("sesssion_track_new.php");


$sql="SELECT MIN((TIMESTAMPDIFF(MINUTE,updated_time_stamp,NOW()))) AS hrsdff FROM brandix_bts.`bts_to_sfcs_sync` WHERE sync_status=1";
$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$current_session=$sql_row2['hrsdff'];	
}


if($current_session>10)
{
	header("Location: bts_to_sfcs_sync.php");
}
else
{
	echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
}

?>