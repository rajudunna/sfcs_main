<?php

// Turn off all error reporting
error_reporting(0);
// Report simple running errors
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
GLOBAL $link_ui;
GLOBAL $menu_table_name;
$menu_table_name = 'tbl_menu_list';
$database="central_administration_sfcs";
$user= 'baiall';
$password='baiall';
$host= '192.168.0.110';
$link_ui = mysqli_connect("$host","$user","$password","$database",'3326');
//echo $database;
// Check connection
 if (mysqli_connect_errno())
  {
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
  $link_ui = Null;
  } 
  //testing dev master
  $username_list=explode('\\',$_SERVER['REMOTE_USER']);
  $user=$username=strtolower($username_list[1]);
?>

