<?php


if(isset($_GET['tid']))
{
	$tid=$_GET['tid']; 
}
?>

<style>
body{
	font-family:arial;
}
</style>

<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));



//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);


?>
<div class="panel panel-primary">
<div class="panel-heading"><b>Delete Transaction</b></div>
<div class="panel-body">
<form name="test"  action="index.php?r=<?php echo $_GET['r']; ?>" method="post">
<input type="hidden" name="tid" value="<?php echo $tid; ?>">

<!-- <h2><font color="red">Are you sure to delete this entry?</font></h2> -->

<?php
	// if($date==date("Y-m-d"))
	// {
	// 	echo '<input type="hidden" name="pw" value="123" size="5">';
	// 	echo '<input type="submit" class="btn btn-danger" name="yes"  value="YES">   <input type="submit" class="btn btn-info"  name="no" value="NO">';
		
	// }
	// else
	// {
	// 	echo '<input type="hidden" name="pw" value="'.$username.'" size="5">   ';
	// 	echo '<input type="submit" class="btn btn-danger" name="yes" value="YES">   <input type="submit" class="btn btn-info"  name="no" value="NO">';
	// }
?>



</form>
</div>
</div>


<?php

// if(isset($_POST['yes']))
// {
	//	if(($_POST['pw']=="123" or strtolower($_POST['pw'])=="senthoorans" or strtolower($_POST['pw'])=="kirang" or strtolower($_POST['pw'])=="arunag" or strtolower($_POST['pw'])=="kirang" or strtolower($_POST['pw'])=="pavanir"))
		
	// if(in_array($username,$authorised_access))
	// {

		// $tid=$_POST['tid'];
		
		$sql_insert_backup="insert into $bai_pro.down_log_deleted select * from $bai_pro.down_log where tid=".$tid;
		//echo $sql_insert_backup;
		mysqli_query($link, $sql_insert_backup) or exit("Sql Error in backup".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql_delete_log="insert into $bai_pro.down_log_changes(tid_ref,username,operation) value(".$tid.",'".$username."','delete')";
		mysqli_query($link, $sql_delete_log) or exit("Sql Error Edit".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql33="delete from $bai_pro.down_log where tid=".$tid;
		mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$url = getFullURL($_GET['r'],'down_time_log.php','N');
		echo "<script>sweetAlert('Deleted Successfully','','success')</script>";
		echo("<script>location.href = '".getFullURLLevel($_GET['r'],'down_time_log_V2.php',0,'N')."';</script>");
			// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect() {  window.close();}</script>";
	// }
	// else
	// {
	// 	echo "<h2><font color=red>You are not authorised to delete this transaction.</font></h2>";
	// }
// }


// if(isset($_POST['no']))
// {
// 	echo "<script>sweetAlert(' Not Deleted','','info')</script>";

// 	$url = getFullURL($_GET['r'],'down_time_log.php','N');
// 	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect() {  window.close();}</script>";
// }


?>




