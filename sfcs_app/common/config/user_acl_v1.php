<?php
function user_acl($page_id,$user_name,$fn_id,$group_id)
{	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$name=array();
	$view_id=1;
	$view=0;
	$controls=0;
	$sql_select="select sum(if(fn_id=".$fn_id.",1,0)) as 'controls_count', sum(if(fn_id=".$view_id.",1,0)) as 'view_control' from ".$central_administration_sfcs.".".$tbl_view_view_menu." where page_id='".$page_id."' and user_name='".$user_name."' and group_id=".$group_id;
	$sql_result_select=mysqli_query($link, $sql_select) or exit($sql_select.'<br/>Error in Query'.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	 //add line for branch test
	while($row_select=mysqli_fetch_array($sql_result_select))
	{		
		$view=$row_select['view_control'];
		$controls=$row_select['controls_count'];
		$name[]=strtolower($user_name);
		if($view>=1)
		{
			if($controls>=1)
			{
				$name[]=strtolower($user_name);
			}
		}
		else
		{
			$sql_select_role="select sum(if(fn_id=".$fn_id.",1,0)) as 'controls_count', sum(if(fn_id=".$view_id.",1,0)) as 'view_control' from ".$central_administration_sfcs.".".$view_menu_role." where page_id='".$page_id."' and username='".$user_name."' and group_id=".$group_id;
			
			$sql_result_select_role=mysqli_query($link, $sql_select_role) or exit('<br/>Error in Role Query :'.$sql_select_role.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row_select=mysqli_fetch_array($sql_result_select_role))
			{		
				$view=$row_select['view_control'];
				$controls=$row_select['controls_count'];
		
				if($view>=1)
				{
					if($controls>=1)
					{
						$name[]=$user_name;					
					}
				}		
				else
				{					
					//header("location:http://qcinet:8080/server/restricted.php");				
				}
			}
		}		
	}
	((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
	return $name;
}
?>

