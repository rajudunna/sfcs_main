<?php
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'',4,'R'));
//error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);


// $database="brandix_bts";
// // echo $database;
// $user=$host_adr_un;
// $password=$host_adr_pw;
// $host=$host_adr;

// $link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
// mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


set_time_limit(60000);
	function echo_title($table_name,$field,$compare,$key,$link)
	{
		//GLOBAL $menu_table_name;
		//GLOBAL $link;
		$sql="select $field as result from $table_name where $compare='$key'";
		// echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			return $sql_row['result'];
		}
		((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
	}
	function echo_title_1($table_name,$field,$compare,$key,$link)
	{
		//GLOBAL $menu_table_name;
		//GLOBAL $link;
		$sql="select $field as result from $table_name where $compare in ($key)";
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