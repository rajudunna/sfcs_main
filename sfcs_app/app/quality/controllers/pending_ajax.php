<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$schedule=$_POST['get_id'];
$color=$_POST['color'];

	$sql1="select count(order_col_des) as col_cnt from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
	//	echo "query=".$sql1;
		mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$color_count=$sql_row1['col_cnt'];
			}
echo "Select Color: <select name=\"color\"  required>";
$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";

// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
if($color_count>1)
{
echo "<option value=\"0\" selected>All</option>";
}	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color) )
{
	
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
		
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}

echo "</select>";


?>
