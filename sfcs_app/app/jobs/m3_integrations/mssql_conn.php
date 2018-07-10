<?php
    $host = "localhost";
	$user = "BAISFCS";
	$password = "lan@col3";
	$database =  "UAT";
	$port = 50000;
	$conn_string = "DRIVER={iSeries Access ODBC Driver};System=10.227.38.36;Uid=".$user.";Pwd=".$password.";";
    $conn = odbc_connect($conn_string,$user,$password);
    if(!$conn)
    {
        echo "Connection Failed";
    }
?>