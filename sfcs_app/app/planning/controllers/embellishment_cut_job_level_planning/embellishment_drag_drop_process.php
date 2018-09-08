<?php

//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); 	
		// remove docs
		$remove_docs=array();
		$sqlx="select doc_no from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
		mysqli_query($link,$sqlx) or exit("Sql Error1".mysqli_error());
		$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error2".mysqli_error());
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{
			$remove_docs[]=$sql_rowx['doc_no'];
		}
		
		if(sizeof($remove_docs)>0)
		{
		
		$sqlx="delete from $bai_pro3.embellishment_plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
		mysqli_query($link,$sqlx) or exit("Sql Error3".mysqli_error());
		
		// $sqlx="insert ignore into $bai_pro3.fabric_priorities_backup select * from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$remove_docs).")";
		// mysqli_query($link,$sqlx) or exit("Sql Error4".mysqli_error());
		
		}
		
	//remove docs
		

	$list=$_POST['listOfItems'];
	//echo $list;
	$list_db=array();
	$list_db=explode(";",$list);
	
	$x=1;
	
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
		//module-doc_no
		
		if($items[0]=="allItems")
		{
			// $sql="update $bai_pro3.plandoc_stat_log set plan_module=NULL where doc_no=".$items[1];
			// mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error());
			
			$sql="delete from $bai_pro3.embellishment_plan_dashboard where doc_no=".$items[1];
			mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
			
			// $sql="insert ignore into $bai_pro3.fabric_priorities_backup select * from $bai_pro3.fabric_priorities where doc_ref=".$items[1];
			// mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
			
		}
		else
		{
			$sql="insert ignore into $bai_pro3.embellishment_plan_dashboard (doc_no) values (".$items[1].")";
			// echo $sql."<br>";
			mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
			
			if(mysqli_insert_id($link)>0)
			{
				$sql="update $bai_pro3.embellishment_plan_dashboard set priority=$x, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where doc_no=".$items[1];
				// echo $sql."<br>";
				mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
			}
			else
			{
				$sql="update $bai_pro3.embellishment_plan_dashboard set priority=$x, module=".$items[0]." where doc_no=".$items[1];
				// echo $sql."<br>";
				mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
			}
	
			//To update CPS dashboard (Fabric Priorties when module get changed)
			//2013-10-03 - KiranG
			$sql1="select doc_ref from $bai_pro3.fabric_priorities where doc_ref=\"".$items[1]."\" and module<>".$items[0];
			$result=mysqli_query($link,$sql1) or exit("Sql Error11".mysqli_error());
			$rows_fab=mysqli_num_rows($result);
			
			if($rows_fab>0)
			{
				$sql2="update $bai_pro3.fabric_priorities set module=".$items[0]." where doc_ref=".$items[1];
				mysqli_query($link,$sql2) or exit("Sql Error12".mysqli_error());
			}		
			
			//To update CPS dashboard (Fabric Priorties when module get changed)
			
			
			$sql="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where plan_module is NULL and doc_no=".$items[1];
			mysqli_query($link,$sql) or exit("Sql Error13".mysqli_error());
			
			$x++;
		}
	}
	
	// remove docs
		
		$remove_docs=array();
		$sqlx="select doc_no from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
		mysqli_query($link,$sqlx) or exit("Sql Error14".mysqli_error());
		$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error15".mysqli_error());
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{
			$remove_docs[]=$sql_rowx['doc_no'];
		}
		
		if(sizeof($remove_docs)>0)
		{
			
			$sqlx="delete from $bai_pro3.embellishment_plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
			mysqli_query($link,$sqlx) or exit("Sql Error16".mysqli_error());
		
			// $sql="insert ignore into $bai_pro3.fabric_priorities_backup select * from fabric_priorities where doc_ref=".$items[1];
			// mysqli_query($link,$sql) or exit("Sql Error17".mysqli_error());
			
			// $sqlx="delete from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$remove_docs).")";
			// mysqli_query($link,$sqlx) or exit("Sql Error18".mysqli_error());
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
			//include("board_update_email.php");
		}
	}	
	//include("board_update_email.php");
	// $rurl = getFullURLLevel($_GET['r'],'embellishment_fab_pps_dashboard_v2.php',0,'N');
	$url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/EMS_Dashboard/embellishment_dashboard_send_operation.php',3,'N');
		
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"pps_dashboard.php\"; }</script>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

?>