<?php
$bai_rm_pj1="bai_rm_pj1";
$m3_inputs="m3_inputs";
	$hst = "127.0.0.1:3335";
	$username = "baiall";
	$pass = "baiall";
	$link = mysqli_connect($hst, $username, $pass);
	if(!$link)
	{
		echo "Connection Failed";
	}
?>