<?php

//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

// include("dbconf.php"); 
// include("functions.php"); 
include("../../../../common/config/config.php");
include("../../../../common/config/functions.php");
	
	
	// remove docs
		$remove_docs=array();
		$sqlx="select doc_no from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
		mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{
		$remove_docs[]=$sql_rowx['doc_no'];
		}
		
		if(sizeof($remove_docs)>0)
		{
		
		$sqlx="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
		mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sqlx="insert ignore into $bai_pro3.fabric_priorities_backup select * from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$remove_docs).")";
		mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//Date : 2014-03-21
		//Due to color changing from yellow to green due to removing the job from fabric_priorities
		//Hidden the code
		//$sqlx="delete from fabric_priorities where doc_ref in (".implode(",",$remove_docs).")";
		//mysql_query($sqlx,$link) or exit("Sql Error".mysql_error());
		}
		
	//remove docs
		

	$list=$_POST['listOfItems'];
	//echo $list;
	$list_db=array();
	$list_db=explode(";",$list);
	
	//$sql="update plan_dashboard set priority=NULL"; // New 2011-01-04
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	$x=1;
	
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
		//module-doc_no
		
		if($items[0]=="allItems")
		{
			$sql="update $bai_pro3.plandoc_stat_log set plan_module=NULL where doc_no=".$items[1];
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="delete from $bai_pro3.plan_dashboard where doc_no=".$items[1];
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert ignore into $bai_pro3.fabric_priorities_backup select * from fabric_priorities where doc_ref=".$items[1];
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//Date : 2014-03-21
			//Due to color changing from yellow to green due to removing the job from fabric_priorities
			//Hidden the code
			//$sql="delete from fabric_priorities where doc_ref=".$items[1];
			//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			
			$sql1="delete from $bai_pro3.trims_dashboard where doc_ref=\"".$items[1]."\" and trims_status!=4";
			$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $items[1]."<br>";
		}
		else
		{
			$sql="insert ignore into $bai_pro3.plan_dashboard (doc_no) values (".$items[1].")";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res)>0)
			{
				$sql="update $bai_pro3.plan_dashboard set priority=$x, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where doc_no=".$items[1];
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$sql="update $bai_pro3.plan_dashboard set priority=$x, module=".$items[0]." where doc_no=".$items[1];
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			$sql1="select doc_ref from $bai_pro3.trims_dashboard where doc_ref=\"".$items[1]."\"";
			$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows=mysqli_num_rows($result);
			
			if($rows > 0)
			{
				$sql2="update $bai_pro3.trims_dashboard set module=".$items[0].",plan_time=\"".date("Y-m-d H:i:s")."\",priority=\"".$x."\" where doc_ref=".$items[1]."";
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$sql="insert into $bai_pro3.trims_dashboard(module,doc_ref,plan_time,priority) values(".$items[0].",".$items[1].",\"".date("Y-m-d H:i:s")."\",\"".$x."\")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//To update CPS dashboard (Fabric Priorties when module get changed)
			//2013-10-03 - KiranG
			$sql1="select doc_ref from $bai_pro3.fabric_priorities where doc_ref=\"".$items[1]."\" and module<>".$items[0];
			$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows_fab=mysqli_num_rows($result);
			
			if($rows_fab>0)
			{
				$sql2="update $bai_pro3.fabric_priorities set module=".$items[0]." where doc_ref=".$items[1];
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}		
			
			//To update CPS dashboard (Fabric Priorties when module get changed)
			
			
			$sql="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where plan_module is NULL and doc_no=".$items[1];
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$x++;
		}
	}
	
	// remove docs
		
		$remove_docs=array();
		$sqlx="select doc_no from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
		mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{
		$remove_docs[]=$sql_rowx['doc_no'];
		}
		
		if(sizeof($remove_docs)>0)
		{
		
		$sqlx="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
		mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="insert ignore into $bai_pro3.fabric_priorities_backup select * from fabric_priorities where doc_ref=".$items[1];
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sqlx="delete from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$remove_docs).")";
		mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
	//remove docs
	//Update dashboard information after limited period
	
	{
		$hour=date("H.i");
		//echo $hour;
		//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45))
		if(($hour>=7.45 and $hour<=9.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
		//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
		{
			
		}
		else
		{
			//Disabled on request
			//include("board_update_email.php");
		}
	}	
	//include("board_update_email.php");
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"pps_dashboard.php\"; }</script>";
	$fabdash= '/sfcsui/index.php?r='.base64_encode('/sfcs_app/app/dashboards/controllers/IPS/fab_pps_dashboard_v2.php');
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  window.location = \"sfcsui/index.php?r=$fabdash\"; }</script>";
	header('Location:'.$fabdash);

?>