
<?php

$database="brandix_bts";
$user="baiall";
$password="baiall";
$host="baidbsrv04";

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

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

	$color=$_GET['color'];
	$size=$_GET['size'];
	$mno=$_GET['mno'];
	$mi=$_GET['mi'];
	$val=$_GET['count'];
	$line_num=$_GET['module'];
	if($val>0)
	{
		$sql="update brandix_bts.tbl_miniorder_data set planned_module=0 where color='".$color."' and size=$size and mini_order_num=$mno and mini_order_ref=$mi and planned_module=$line_num";	
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql="update brandix_bts.tbl_miniorder_data set planned_module=$line_num where color='".$color."' and size=$size and mini_order_num=$mno and mini_order_ref=$mi and (planned_module=0 or planned_module is NULL) order by bundle_number limit $val";	
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		$check_qty= echo_title("brandix_bts.tbl_miniorder_data","sum(quantity)","color='".$color."' and size=$size and mini_order_num=$mno and mini_order_ref=$mi and planned_module",$line_num,$link);	
		echo $check_qty;
	}
	else
	{
		$sql="update brandix_bts.tbl_miniorder_data set planned_module=0 where color='".$color."' and size=$size and mini_order_num=$mno and mini_order_ref=$mi and planned_module=$line_num";
		$result=mysqli_query($link, $sql) or exit("Sql Error2".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		$check_qty= echo_title("brandix_bts.tbl_miniorder_data","sum(quantity)","color='".$color."' and size=$size and mini_order_num=$mno and mini_order_ref=$mi and planned_module",$line_num,$link);	
		if($check_qty>0)
		{
			$check_qty;
		}
		else
		{
			$check_qty=0;
		}
		echo $check_qty;
	}

	
	
	
?>			