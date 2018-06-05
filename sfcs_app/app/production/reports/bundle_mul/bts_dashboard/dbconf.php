<?php
include($_SERVER['DOCUMENT_ROOT']."/server/db_hosts.php");
set_time_limit(30000);
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$database="brandix_bts_uat";

$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;


$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="select * from snap_session_track where session_id=1";
$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$swap_status=$sql_row2['swap_status'];	
	
	$view_set_6_snap=$sql_row2["6_snap"];
	$view_set_5_snap=$sql_row2["5_snap"];
	$view_set_4_snap=$sql_row2["4_snap"];
	$view_set_3_snap=$sql_row2["3_snap"];
	$view_set_2_snap=$sql_row2["2_snap"];
	$view_set_1_snap=$sql_row2["1_snap"];
	$view_set_snap_1_tbl=$sql_row2["0_tbl_snap"];
}

function echo_title($table_name,$field,$compare,$key,$link)
	{
		//GLOBAL $menu_table_name;
		//GLOBAL $link;
		$sql="select $field as result from $table_name where $compare='$key'";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			return $sql_row['result'];
		}
		((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
	}

function leading_zeros($value, $places){
// Function written by Marcus L. Griswold (vujsa)
// Can be found at http://www.handyphp.com
// Do not remove this header!
$leading='';
    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    return $output;
}
?>