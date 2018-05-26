<?php
//include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
//include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
//$view_access=user_acl("SFCS_0291",$username,1,$group_id_sfcs);
?>
<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<br>

 <?php
 // include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R')); 
	//echo "<input type=\"submit\" value=\"Session Restore\" name=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';\"/>";
	//echo "<span id=\"msg\" style=\"display:none;\"><h5>Please Wait...<h5></span>";

?>


</form>
<?php
$status=$_GET['status'];
	if($status==2)
	{
		$mini_order_ref=$_GET['mini_order_ref'];
		$mini_order_num=$_GET['mini_order_num'];
		$sql="update $brandix_bts.tbl_miniorder_data set mini_order_status=NULL where mini_order_num='".$mini_order_num."' and mini_order_ref='".$mini_order_ref."'";
		$sql_result1=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}
	else if($status==1)
	{
		$doc=$_GET['doc_no'];
		$table_name="$bai_pro3.plandoc_stat_log";
		$sql11="select * from $table_name where org_doc_no='".$doc."'";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($sql_result11))
		{
			$doc_no[]=$row1['doc_no'];
		}
		$sql="update $brandix_bts.tbl_miniorder_data set mini_order_status=NULL where docket_number in (".implode(",",$doc_no).")";
		$sql_result1=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	}
?>