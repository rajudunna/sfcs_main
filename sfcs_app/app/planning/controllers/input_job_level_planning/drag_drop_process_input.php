<?php

//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

// include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 	


	$list=$_POST['listOfItems'];
	//echo $list."<br>";
	$list_db=array();
	$list_db=explode(";",$list);
	// var_dump($list_db);
	// die();
	//$sql="update plan_dashboard set priority=NULL"; // New 2011-01-04
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	
	$x=1;
	$x1=1;
	
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
		//module-doc_no
		
		if($items[0]=="allItems")
		{	
			$get_original_module="SELECT packing_summary_input.`doc_no`, packing_summary_input.`order_del_no`, plan_dashboard_input.`input_job_no_random_ref`, packing_summary_input.`input_job_no`, plan_dashboard_input.`input_module` FROM $bai_pro3.`plan_dashboard_input` LEFT JOIN $bai_pro3.`packing_summary_input` ON plan_dashboard_input.`input_job_no_random_ref`=packing_summary_input.`input_job_no_random` WHERE plan_dashboard_input. input_job_no_random_ref='".$items[1]."'";
			// echo $get_original_module.";<br>";
			$result_org_module=mysqli_query($link, $get_original_module) or die("Error while getting original module0");
			if (mysqli_num_rows($result_org_module) > 0)
			{
				while($sql_row_org_module=mysqli_fetch_array($result_org_module))
				{
					$doc_no=$sql_row_org_module["doc_no"];
					$order_del_no=$sql_row_org_module["order_del_no"];
					$input_job_no_random_ref=$sql_row_org_module["input_job_no_random_ref"];
					$input_job_no=$sql_row_org_module["input_job_no"];
					$original_module=$sql_row_org_module["input_module"];
				}

				$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no,  from_module, to_module, log_time) VALUES('".$doc_no."', '".$order_del_no."', '".$items[1]."', '".$input_job_no."',  '".$original_module."', 'No Module', NOW())";
				// echo $insert_log_query.";<br>";
				// die();
				mysqli_query($link, $insert_log_query) or die("Error while saving the track details1");
			}
			
			$sqly="SELECT group_concat(doc_no) as doc_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$items[1]."' ORDER BY acutno";
			//echo $sqly.";<br>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($resulty))
			{
				$doc_no_ref_input=$sql_rowy["doc_no"];
			}

			$org_docs=array();
			$org_docs[] = '-1';
			$sql="select * from $bai_pro3.plandoc_stat_log where doc_no in (".$doc_no_ref_input.")";
			//echo $sql."<br>";
			$resultr1=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowr1=mysqli_fetch_array($resultr1))
			{
				if($sql_rowr1["org_doc_no"]>1)
				{
					$org_docs[]=$sql_rowr1["org_doc_no"];
					//echo "Org--doc_no".$org_doc_no."<br>";
				}
			}

			$backup_query="INSERT INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref='".$items[1]."'";
			// echo $backup_query.";<br>";
			mysqli_query($link, $backup_query) or exit("Error while saving backup plan_dashboard_input_backup");

			$sql="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$items[1]."'";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$sql="delete from $bai_pro3.plan_dashboard where doc_no in (".$doc_no_ref_input.")";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$org_docs).")";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
		else
		{
			$get_original_module="SELECT packing_summary_input.`doc_no`, packing_summary_input.`order_del_no`, plan_dashboard_input.`input_job_no_random_ref`, packing_summary_input.`input_job_no`, plan_dashboard_input.`input_module` FROM $bai_pro3.`plan_dashboard_input` LEFT JOIN $bai_pro3.`packing_summary_input` ON plan_dashboard_input.`input_job_no_random_ref`=packing_summary_input.`input_job_no_random` WHERE plan_dashboard_input. input_job_no_random_ref='".$items[1]."'";
			// echo $get_original_module.";<br>";
			$result_org_module=mysqli_query($link, $get_original_module) or die("Error while getting original module1");
			if (mysqli_num_rows($result_org_module) > 0)
			{
				while($sql_row_org_module=mysqli_fetch_array($result_org_module))
				{
					$doc_no=$sql_row_org_module["doc_no"];
					$order_del_no=$sql_row_org_module["order_del_no"];
					$input_job_no_random_ref=$sql_row_org_module["input_job_no_random_ref"];
					$input_job_no=$sql_row_org_module["input_job_no"];
					$original_module=$sql_row_org_module["input_module"];
				}
				if ($original_module != $items[0])
				{
					$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no,  from_module, to_module, log_time) VALUES('".$doc_no."', '".$order_del_no."', '".$items[1]."', '".$input_job_no."', '".$original_module."', '".$items[0]."', NOW())";
					// echo $insert_log_query.";<br>";
					// die();
					mysqli_query($link, $insert_log_query) or die("Error while saving the track details2");
				}				
			} 
			else
			{
				$get_schedule="SELECT `order_del_no`, input_job_no FROM $bai_pro3.`packing_summary_input` WHERE input_job_no_random='".$items[1]."'";
				// echo $get_schedule.";<br>";
				$result_schedule=mysqli_query($link, $get_schedule) or die("Error while getting schedule No");
				while($sql_row_schedule=mysqli_fetch_array($result_schedule))
				{
					$order_del_no1=$sql_row_schedule["order_del_no"];
					$input_job_no1=$sql_row_schedule["input_job_no"];
				}
				$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no, from_module, to_module, log_time) VALUES('".$items[2]."', '".$order_del_no1."', '".$items[1]."', '".$input_job_no1."', 'No Module', '".$items[0]."', NOW())";
				// echo $insert_log_query.";<br>";
				// die();
				mysqli_query($link, $insert_log_query) or die("Error while saving the track details3 == ".$insert_log_query);
			}
			
			

			$sql="insert ignore into $bai_pro3.plan_dashboard_input (input_job_no_random_ref) values ('".$items[1]."')";
			///echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//echo mysql_insert_id($link);
			
			if(((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res)>0)
			{
				$sql="update $bai_pro3.plan_dashboard_input set input_priority=$x, input_module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where input_job_no_random_ref='".$items[1]."'";
				// echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$sql="update $bai_pro3.plan_dashboard_input set input_priority=$x, input_module="."'".$items[0]."'"." where input_job_no_random_ref='".$items[1]."'";
			//    echo $sql.";<br>";
				mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			$msc = microtime(true);
			//$sqly="SELECT GROUP_CONCAT(DISTINCT acutno) AS cut,input_job_no_random as job_ref,SUBSTRING_INDEX(order_joins,'J',-1) AS sch_club,order_del_no as del_no FROM packing_summary_input WHERE input_job_no_random='".$items[1]."' ORDER BY acutno";
			$sqly="SELECT GROUP_CONCAT(DISTINCT acutno) AS cut,input_job_no_random as job_ref,order_del_no as del_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$items[1]."' ORDER BY acutno";
			//echo $sqly."<br>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc = microtime(true) - $msc;
			//echo $msc . ' seconds'; // in seconds
			//echo ($msc * 1000) . ' milliseconds'."</br>";
			while($sql_rowy=mysqli_fetch_array($resulty))
			{
				$cutnos=$sql_rowy["cut"];
				$input_job_no_random_ref1=$sql_rowy["job_ref"];
				//$club_sch=$sql_rowy["sch_club"];
				$club_sch=0;
				$delv_no=$sql_rowy["del_no"];
			}
			
			// if($club_sch > 0)
			// {
				// $sqls="select order_tid from bai_orders_db where order_del_no=\"".$club_sch."\"";
			// }
			// else
			// {
				 $sqls="select order_tid from $bai_pro3.bai_orders_db where order_del_no=\"".$delv_no."\"";
			// }
			//echo $sqls.";<br>";
			$order_tid_ref=array();
			$results=mysqli_query($link, $sqls) or die("Error=$sqls".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rows=mysqli_fetch_array($results))
			{
				$order_tid_ref[]=$sql_rows["order_tid"];
			}
			
			for($ch=0;$ch<sizeof($order_tid_ref);$ch++) // Added by Chathuranga
			{
					
				$sqlr="select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid_ref[$ch]\" and category in ($in_categories)";
				///echo $sqlr.";<br>";
				$resultr=mysqli_query($link, $sqlr) or die("Error=$sqlr".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowr=mysqli_fetch_array($resultr))
				{
					$cat_ref1=$sql_rowr["tid"];
				}
				
				$dockets_ref=array();
				if($cutnos ==''){
					$cutnos = "' '";
				}

				$sqlz="select doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid_ref[$ch]\" and acutno in ($cutnos) and cat_ref=\"$cat_ref1\""; 
				//echo $sqlz.";<br>";
				$resultz=mysqli_query($link, $sqlz) or die("Error=$sqlz".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowz=mysqli_fetch_array($resultz))
				{
					$dockets_ref[]=$sql_rowz["doc_no"];
				}
				
				//echo "size=".sizeof($dockets_ref)."-".implode(",",$dockets_ref)."<br>";
				
				for($d=0;$d<sizeof($dockets_ref);$d++)
				{
					$sql="select *,GROUP_CONCAT(org_doc_no) as org_doc_no from $bai_pro3.plandoc_stat_log where doc_no='$dockets_ref[$d]'";
					//echo $sql."<br>";
					$resultr1=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowr1=mysqli_fetch_array($resultr1))
					{
						if($sql_rowr1["org_doc_no"]>1)
						{
							$org_doc_no=$sql_rowr1["org_doc_no"];
							//echo "Org--doc_no".$org_doc_no."<br>";
						}
						else
						{
							$org_doc_no=$dockets_ref[$d];
							//echo "M--doc_no".$org_doc_no."<br>";
						}	
					}				
					
					$sqlx="insert ignore into $bai_pro3.plan_dashboard(doc_no) values ('".$org_doc_no."')";
					///echo $sqlx.";<br>";
					mysqli_query($link, $sqlx) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					//echo mysql_insert_id($link);
					
					//if(mysql_insert_id($link)>0)
					{
						$sqlx1="update $bai_pro3.plan_dashboard set priority=$x1, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where doc_no='".$org_doc_no."'";
						//echo $sqlx1.";<br>";
						mysqli_query($link, $sqlx1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if($org_doc_no>1)
						{
							$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no='".$org_doc_no."'";
							//echo $sqlx1.";<br>";
							mysqli_query($link, $sqlx12) or exit("Sql Error62.1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no='".$org_doc_no."'";
							//echo $sqlx1.";<br>";
							mysqli_query($link, $sqlx12) or exit("Sql Error62.2".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo "Test---<br>";
						}
						else
						{
							//echo "Test---1<br>";
							$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no='".$org_doc_no."'";
							///echo $sqlx1.";<br>";
							mysqli_query($link, $sqlx12) or exit("Sql Error62.3".mysqli_error($GLOBALS["___mysqli_ston"]));
						}						
					}		
					/*else
					{
						$sqlx1="update plan_dashboard set priority=$x1, module=".$items[0]." where doc_no='".$org_doc_no."'";
						//echo $sqlx1."-".$items[2]."-".$items[1]."<br>";
						mysql_query($sqlx1,$link) or exit("Sql Error7".mysql_error());
					}*/						
					$x1++;
					$x++;
				}
			}
		}
	}
	
	// remove docs
	$remove_docs=array();
	$sqlx="select input_job_no_random_ref as doc_no from $bai_pro3.plan_dash_doc_summ_input where
	input_job_input_status(input_job_no_random)=\"DONE\"";
	//echo $sqlx;
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11.1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$remove_docs[]="'".$sql_rowx['doc_no']."'";
	}
	
	if(sizeof($remove_docs)>0)
	{
		$backup_query1="INSERT INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref in (".implode(",",$remove_docs).")";
		// echo $backup_query1.";<br>";
		mysqli_query($link, $backup_query1) or exit("Error while saving backup plan_dashboard_input_backup1");

		$sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_docs).")";
		//echo $sqlx.";<br>";
		mysqli_query($link, $sqlx) or exit("Sql Error11.2");
		// mysql_query($link,$sqlx) or exit("Sql Error12".mysql_error());	
	}

	//Update dashboard information after limited period
	{
		$hour=date("H.i");
		////echo $hour;
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
	echo "<h2 style='color:blue'>Sucessfully Updated... <br/> Please wait while redirect to IPS Dashboard....</h2>";
			// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"tms_dashboard_input_v22.php\"; }</script>";
		$url =getFullURLLevel($_GET['r'],'dashboards/controllers/IPS/tms_dashboard_input_v22.php',3,'N');
		
		
		echo"<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1); 
		function Redirect() {  
			location.href = '$url'; 
		}</script>";

?>