<?php
    //$host = "10.227.220.238";
    //$host = "10.227.50.15";
    $host = "10.227.221.25";
	$user = "BAISFCS";
	//$password = "lan@col3";
	$password = "fcs@m3pr";
	//$database =  "UAT";
	$database =  "M3_Production";
	$port = 50000;
	//$conn_string = "DRIVER={iSeries Access ODBC Driver};System=10.227.38.36;Uid=".$user.";Pwd=".$password.";";
	$conn_string = "DRIVER={iSeries Access ODBC Driver};System=10.227.40.10;Uid=".$user.";Pwd=".$password.";";
    $conn = odbc_connect($conn_string,$user,$password);
    if(!$conn)
    {
        echo "Connection Failed";
    }
?>