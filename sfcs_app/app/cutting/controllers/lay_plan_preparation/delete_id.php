<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>



<?php


$tran_order_tid=$_GET['tran_order_tid'];
//echo $tran_
$cat_ref=$_GET['cat_ref'];
$cuttable_ref=$_GET['cuttable_ref'];
$allocate_ref=$_GET['allocate_ref'];
$mk_ref=$_GET['mk_ref'];

//echo "<br/>".$tran_order_tid."--".$cat_ref."--".$cuttable_ref."--".$allocate_ref."--".$mk_ref."<br/>";

$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref=\"$allocate_ref\"";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check1=mysqli_num_rows($sql_result1);
//echo "<br/> no of rows: ".$sql_num_check1."<br/>";
if($sql_num_check1==0)
{
	// echo '<script>alert("delete");</script>';
	// $sql2="select tid from bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and tid=\"$allocate_ref\" and mk_status=\"3\"";	
	// echo $sql2;
	// $sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
	// $sql_num_check2=mysql_num_rows($sql_result2);
	// while($sql_row2=mysql_fetch_array($sql_result2))
	// {
		// $tid=$sql_row2['tid'];
	// }
	$sql3="delete FROM $bai_pro3.allocate_stat_log where tid=\"$allocate_ref\"";
	// echo "<br/>".$sql3."<br/>";
	mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql4="delete FROM $bai_pro3.maker_stat_log where allocate_ref=\"$allocate_ref\"";
	mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo "<br/>".$sql4."<br/>";
	echo "<script type=\"text/javascript\"> 
				sweetAlert('Deleted Successfully','','error');			
		  </script>";
}
else
{
	echo "<script type=\"text/javascript\"> 
				sweetAlert('Docket is Already Generated For this ID','','error');			
		  </script>";	
}


$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
		$color_back=$sql_row['order_col_des'];
		$style_back=$sql_row['order_style_no'];
		$schedule_back=$sql_row['order_del_no'];
}


echo "<script type=\"text/javascript\"> 
		setTimeout(\"Redirect()\",0); 
		function Redirect(){	 
				location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color_back&style=$style_back&schedule=$schedule_back\"; 
			}
	</script>";	
//echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "main_interface.php", "N")."&color=$color_back&style=$style_back&schedule=$schedule_back\"><<<<<< Click here to Go Back</a>";

?>
