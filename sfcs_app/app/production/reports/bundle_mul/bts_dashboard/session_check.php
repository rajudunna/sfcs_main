<?php

//include("sesssion_track_new.php");


$sql="select * from brandix_bts.snap_session_track where session_id=1";
$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$current_session=$sql_row2['session_status'];	
}


if($current_session=="on")
{
	//header("Location: dataprocess_status.php");
}

?>