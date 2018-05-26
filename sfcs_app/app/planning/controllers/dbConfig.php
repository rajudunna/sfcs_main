<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

//DB details
$dbHost = $host_adr;
$dbUsername = $host_adr_un;
$dbPassword = $host_adr_pw;
$dbName = 'bai_pro2';

//Create connection and select DB for OOP
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}
//Create Connection for mysqli structurel concept

$link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to mysql: " . mysqli_connect_error();
}

