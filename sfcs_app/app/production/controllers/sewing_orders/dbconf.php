<?php
    include($_SERVER['DOCUMENT_ROOT']."/ff/server/db_hosts.php");
    $database="brandix_bts";
    error_reporting(0);
    $link = mysqli_connect("$host_adr", "$host_adr_un", "$host_adr_pw", "$database");
	if($link->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}else{
		//echo "connection success";
	}
	$db     =   mysqli_select_db($con, $database);
	
	function connect()
	{
		$con    =   mysqli_connect($host,$host_adr_un,$host_adr_pw);
		if($con->connect_errno > 0){
			die('Unable to connect to database [' . $db->connect_error . ']');
		}else{
			echo "connection success";
		}
		$db     =   mysqli_select_db($con, $database);
		return $con;
	}
	function query($sql)
	{
		return mysqli_query(connect(),$sql);
	}
	function fetchAssoc($sql)
	{
		return mysqli_fetch_assoc($sql);
	}
?>