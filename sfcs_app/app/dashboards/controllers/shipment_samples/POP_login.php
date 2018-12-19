<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
//include("../../dbconf.php"); 

//If admin uses his password then, that item will go as exempted.

//Authorisation for transfering input from one module to another was enabled. -KiranG - 20131216

?>

<?php
 	
	if(isset($_POST['submit']))
	{

	$module_ref=$_POST['module'];
	$password=$_POST['key'];
	$tid=$_POST['radio'];
	$section_ids=$_POST['section_ids'];
	$option_val1=$_POST['option'];
	
			
	$sql="SELECT section_head AS sec_head,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section = $section_ids GROUP BY section ORDER BY section + 0";
	//$sql="select * from members where login=\"$password\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mods=array();
		$mods=explode(",",$sql_row['sec_mods']);
	}
	if(in_array($module_ref,$mods) and $sql_num_check>0)
	{
		
	}
	else
	{
		$sql_num_check=0;
	}

	// $sql="select * from $bai_pro3.sections_db where sec_head=\"Admin\"";
	$sql="SELECT section_head AS sec_head,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section_head = \"Admin\"";
	//$sql="select * from members where login=\"$password\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$admin_check=mysqli_num_rows($sql_result);

	if($admin_check>0 and $option_val1=="input_remove" )
	{
	
		$sql="update $bai_pro3.ims_log set ims_status=\"DONE\" where tid='$tid'";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo "<script type=\"text/javascript\"> window.close(); </script>";

	}
	else
	{

	if($sql_num_check>0)	
	{
		//Restrict Module Transfer for selected users only.
		$url = getFullURL($_GET['r'],'ims_edit_process_v1.php','R');
		echo $url;
		die();
		if(isset($_POST['radio']) and $option_val1=="input_transfer")
		{
			
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); 
			       function Redirect() {  
			       	   location.href = \"$url&tid=$tid&module=$module_ref\"; 
			       	}
			      </script>";
			
		}
		else
		{
			//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../ims.php?module=$module_ref\"; }</script>";	
			echo "<strong>You are not authorised to access this interface.</strong>";
		}
	}
	else
	{
		echo "<strong>You are not authorised to access this interface.</strong>";
		echo "<script type=\"text/javascript\"> window.close(); </script>";
	}
	}
}
	
?>