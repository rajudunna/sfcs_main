<?php

// Turn off all error reporting
error_reporting(0);
// Report simple running errors
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once($_SERVER['DOCUMENT_ROOT']."/configuration/API/confr.php");
$conf_tool = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");
$db_obj = $conf_tool->getDBConfig();
GLOBAL $link_ui;
GLOBAL $menu_table_name;
$menu_table_name = 'tbl_menu_list';
$database="central_administration_sfcs";
$user= $db_obj['db_user'];
$password=$db_obj['db_pass'];
$host= $db_obj['db_host'];
$link_ui = mysqli_connect("$host","$user","$password","$database",$db_obj['db_port']);
//echo $database;
// Check connection
 if (mysqli_connect_errno())
  {
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
  $link_ui = Null;
  } 

  $mssql = $conf_tool->getMssqlDBConfig();
  //var_dump($mssql);
?>

