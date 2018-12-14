<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R') );    ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'session_track.php',0,'R') );    ?>

<?
	$view_access=user_acl("SFCS_0116",$username,1,$group_id_sfcs); 
?>


<style>
.button {
  -webkit-appearance: button;
  -moz-appearance: button;
  appearance: button;
}

</style>
<script language="javascript">


function popup(Site)
{
	window.close();
	window.open(Site,'PopupName',
	'toolbar=no,statusbar=yes,menubar=yes,location=no,scrollbars=yes,resizable=yes,width=775,height=700');
}

// end -->
</script>

<div class="panel panel-primary">
	<div class="panel-body">
<?php



if(isset($_POST['clearsession']))
{
	$myFile = "sesssion_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."current_session_user=''; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	// echo "username".$username;
	$sql="SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
			//  for multiuser session enable
			$sql="DROP TABLE IF EXISTS $temp_pool_db.ims_log_packing_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="DROP TABLE IF EXISTS $temp_pool_db.packing_summary_tmp_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			$sql="CREATE  TABLE $temp_pool_db.ims_log_packing_v3_$username SELECT * FROM $bai_pro3.packing_dashboard_new2";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="CREATE  TABLE $temp_pool_db.packing_summary_tmp_v3_$username SELECT * FROM $bai_pro3.packing_summary where order_del_no in (select order_del_no from $bai_pro3.packing_pending_schedules)";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="truncate $temp_pool_db.ims_log_packing_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert into $temp_pool_db.ims_log_packing_v3_$username select * from $bai_pro3.packing_dashboard_new2";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//NEW2011
			$sql="truncate $temp_pool_db.packing_summary_tmp_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert into $temp_pool_db.packing_summary_tmp_v3_$username select * from $bai_pro3.packing_summary where order_del_no in (select order_del_no from $bai_pro3.packing_pending_schedules)";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
			//NEW2011
			
			//  for multiuser session enable
			$sql="SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ";
			///echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="truncate $temp_pool_db.ims_log_packing_v3_$username";
	// echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="truncate $temp_pool_db.packing_summary_tmp_v3_$username";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error31".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if(isset($_POST['clearsessioncontinue']))
{	
	$myFile = "sesssion_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."current_session_user=''; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	// echo $username;
	$sql="truncate $temp_pool_db.ims_log_packing_v3_$username";
	// echo "Sqls ".$sql."<br/>";
	
	mysqli_query($link, $sql) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="truncate $temp_pool_db.packing_summary_tmp_v3_$username";
	mysqli_query($link, $sql) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$current_session_user="stop";
}

//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user='';
}
//Exemption Handling

if(strlen($current_session_user)>0 and $current_session_user!="stop")
{
	echo "<div class='alert alert-danger' role='alert'>This session is currently operating by $current_session_user, Please contact user to unlock his session.</div>";
	$username='ber_databasesvc'; 
	if($current_session_user==$username)
	{
		echo '<form method="post" name="form" action="'.getFullURL($_GET['r'],'packing_check_point_gateway.php','N').'">';
			echo '<input type="submit" name="clearsession" value="Clear Session and Continue" class="btn btn-primary">&nbsp;&nbsp;';
			echo '<input type="submit" name="clearsessioncontinue" value="Clear Session and Stop" class="btn btn-danger">';
			echo "<br/><br/><div class='well well-sm'>Note: <br/>Clear my session and continue option used to clear your current session and load latest data. <br/>Clear my session and stop option used to clear your current session and allows other user to open his session.</div>";
		echo '</form>';
	}
}
else
{
	$url = getFullURL($_GET['r'],'packing_check_point_handover_select.php','N');
	echo "<div class='alert alert-success' role='alert'>$username  Session Cleared Successfully</div>";
	<button onclick="location.href = '<?php echo $url;?>'; return false;" class="btn btn-warning">Click here to go Back</button>
<?php	

}

//Exemption Handling
if($session_login_fg_carton_scan==1)
{
	$current_session_user='';
}
//Exemption Handling

if(isset($_POST['clearsession']) or strlen($current_session_user)==0)
{
	$myFile = "sesssion_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."current_session_user='$username'; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	
	
	ob_end_flush();
	flush();
	usleep(10);

		//New Code
		//  for multiuser session enable
			$sql="SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
			//  for multiuser session enable
			$sql="DROP TABLE IF EXISTS $temp_pool_db.ims_log_packing_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="DROP TABLE IF EXISTS $temp_pool_db.packing_summary_tmp_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			$sql="CREATE  TABLE $temp_pool_db.ims_log_packing_v3_$username SELECT * FROM $bai_pro3.packing_dashboard_new2";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="CREATE  TABLE $temp_pool_db.packing_summary_tmp_v3_$username SELECT * FROM $bai_pro3.packing_summary where order_del_no in (select order_del_no from $bai_pro3.packing_pending_schedules)";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="truncate $temp_pool_db.ims_log_packing_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert into $temp_pool_db.ims_log_packing_v3_$username select * from $bai_pro3.packing_dashboard_new2";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//NEW2011
			$sql="truncate $temp_pool_db.packing_summary_tmp_v3_$username";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert into $temp_pool_db.packing_summary_tmp_v3_$username select * from $bai_pro3.packing_summary where order_del_no in (select order_del_no from $bai_pro3.packing_pending_schedules)";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
			//NEW2011
			
			//  for multiuser session enable
			$sql="SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ";
			///echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
			//  for multiuser session enable
		
		//New Code
		

	echo '<div class="alert alert-success" role="alert">Successfully Updated.</div>';
	

	
	$url = getFullURL($_GET['r'],'packing_check_point_v1.php','N');
	//echo $url;
	echo "<script type=\"text/javascript\"> 
			setTimeout(\"Redirect()\",30); 
			function Redirect() { 
				popup('$url'); 
			}
		  </script>";

}
?>
</div>
</div>



