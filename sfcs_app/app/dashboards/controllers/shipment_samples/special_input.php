<?php //include("../../dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); ?>


<?php

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

//Special Input Processing Block
{
	
	$sql="select * from $bai_pro3.menu_index where list_id=271";
	$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{
		$users=$row["auth_members"];
	}

	$auth_users=explode(",",$users);
	
		
	
	if(in_array($username,$auth_users))
	{
		if(isset($_POST['spreq']))
		{
			$module=$_GET['module'];
			//$reason=$_POST['reason'];
			$section=$_GET['section'];
			
			$module=$_POST['module'];
			//$reason=$_POST['reason'];
			$section=$_POST['section'];
			//$key=$_POST['key'];
			
			
			$sql="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name where section=$section GROUP BY section ORDER BY section + 0";
			//echo $sql;
			//$sql="select * from members where login=\"$password\"";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$mods=array();
				$mods=explode(",",$sql_row['sec_mods']);
			}
			if(in_array($module,$mods) and $sql_num_check>0) 
			{
				
			}
			else 
			{
				$sql_num_check=0;
			}
			
			
			$username_list=explode('\\',$_SERVER['REMOTE_USER']);
			$username=strtolower($username_list[1]);
			
			echo " Rows =".$sql_num_check;
			
			if($sql_num_check>0)
			{
				$sql="insert into $bai_pro3.ims_sp_db(module,req_user,status) values ($module,\"$username\",0)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$url = getFullURLLevel($_GET['r'],'cheat_system.php',0,'N');
				//header("Location:../cheat_system.php");
				echo "<script>
                        window.location.href = '$url';
				     </script>";
			}

			echo "<script type=\"text/javascript\"> window.close(); </script>";
		}
}
    
	else
	{
		echo "<h3>You are restricted for access this interface.</h3>";
		
	}
}	
?>
