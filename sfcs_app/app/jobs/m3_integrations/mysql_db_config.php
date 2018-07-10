<?php
	$hst = "127.0.0.1:3335";
	$username = "baiall";
	$pass = "baiall";
	$my_conn = mysqli_connect($hst, $username, $pass);
	if(!$my_conn)
	{
		echo "Connection Failed";
	}
?>