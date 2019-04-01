<?php

//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

// include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 	
$userName = getrbac_user()['uname'];

	
	$list=$_POST['listOfItems'];
	$list_db=array();
	$list_db=explode(";",$list);
	//var_dump($list_db);
	$x=1;
	$x1=1;
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
		
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

				$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no,  from_module, to_module, username, log_time) VALUES('".$doc_no."', '".$order_del_no."', '".$items[1]."', '".$input_job_no."',  '".$original_module."', 'No Module', '".$userName."', NOW())";
				 //echo $insert_log_query.";<br>";
				 //die();
				mysqli_query($link, $insert_log_query) or die("Error while saving the track details1");
			}
			$exisitng_docs = [];
			$sqly="SELECT group_concat(doc_no) as doc_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$items[1]."' ORDER BY acutno";
			//echo $sqly.";<br>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($resulty))
			{
				$doc_no_ref_input=$sql_rowy["doc_no"]; 
			}
			$incoming_docs = explode(',',$doc_no_ref_input);
			$fabric_status_query = "SELECT doc_ref from $bai_pro3.fabric_priorities where doc_ref IN ($doc_no_ref_input)";
			$fabric_status_result = mysqli_query($link,$fabric_status_query);
			while($rowfs = mysqli_fetch_array($fabric_status_result)){
				$exisitng_docs[] = $rowfs['doc_ref'];
			}
			$diff_docs = array_diff($incoming_docs,$exisitng_docs);
			$doc_no_ref_input = implode(',',$diff_docs);
			if($doc_no_ref_input == '')
				$doc_no_ref_input = 1;
			unset($diff_docs);
			unset($exisitng_docs);
			unset($incoming_docs);
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
				}
			}
			
			$sql="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$items[1]."'";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$plan_moduleqry="update $bai_pro3.plandoc_stat_log set plan_module= NULL where doc_no in (".$doc_no_ref_input.")";
			$plan_moduleqry_result=mysqli_query($link, $plan_moduleqry) or exit("plan_moduleqry update error first".mysqli_error($GLOBALS["___mysqli_ston"]));

			$sql="delete from $bai_pro3.plan_dashboard where doc_no in (".$doc_no_ref_input.")";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql="delete from $bai_pro3.cutting_table_plan where doc_no_ref in (".$doc_no_ref_input.")";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$plan_moduleqry1="update $bai_pro3.plandoc_stat_log set plan_module= NULL where doc_no in (".implode(",",$org_docs).")";
			$plan_moduleqry_result1=mysqli_query($link, $plan_moduleqry1) or exit("plan_moduleqry update error second".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$org_docs).")";
			// echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
		else
		{
			$get_original_module="SELECT packing_summary_input.`doc_no`, packing_summary_input.`order_del_no`, plan_dashboard_input.`input_job_no_random_ref`, packing_summary_input.`input_job_no`, plan_dashboard_input.`input_module` FROM $bai_pro3.`plan_dashboard_input` LEFT JOIN $bai_pro3.`packing_summary_input` ON plan_dashboard_input.`input_job_no_random_ref`=packing_summary_input.`input_job_no_random` WHERE plan_dashboard_input. input_job_no_random_ref='".$items[1]."'";
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
					$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no,  from_module, to_module, username, log_time) VALUES('".$doc_no."', '".$order_del_no."', '".$items[1]."', '".$input_job_no."', '".$original_module."', '".$items[0]."', '".$userName."', NOW())";
					//echo $insert_log_query.";<br>";
					// die();
					mysqli_query($link, $insert_log_query) or die("Error while saving the track details2");

					$insert_qry1="insert into $bai_pro3.job_transfer_details (sewing_job_number,transfered_module,status) values (".$items[1].",".$items[0].",'P')";
					mysqli_query($link, $insert_qry1)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no, from_module, to_module, username, log_time) VALUES('".$items[2]."', '".$order_del_no1."', '".$items[1]."', '".$input_job_no1."', 'No Module', '".$items[0]."', '".$userName."', NOW())";
				mysqli_query($link, $insert_log_query) or die("Error while saving the track details3 == ".$insert_log_query);
			   // echo $insert_log_query.";<br>";
					
			}			

			$sql="insert ignore into $bai_pro3.plan_dashboard_input (input_job_no_random_ref) values ('".$items[1]."')";
			//echo $sql.";<br>";
			mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res)>0)
			{
				$sql="update $bai_pro3.plan_dashboard_input set input_priority=$x, input_module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where input_job_no_random_ref='".$items[1]."'";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$sql="update $bai_pro3.plan_dashboard_input set input_priority=$x, input_module="."'".$items[0]."'"." where input_job_no_random_ref='".$items[1]."'";
				mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			$msc = microtime(true);			
			$dockets_ref=array();
			$sqly="SELECT GROUP_CONCAT(DISTINCT doc_no) AS doc,GROUP_CONCAT(DISTINCT acutno) AS cut,input_job_no_random as job_ref FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$items[1]."' ORDER BY acutno";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc = microtime(true) - $msc;
			while($sql_rowy=mysqli_fetch_array($resulty))
			{			
				$input_job_no_random_ref1=$sql_rowy["job_ref"];
				$dockets_ref=explode(",",$sql_rowy["doc"]);
				$cut_ref=explode(",",$sql_rowy["cut"]);
				$sql123="select GROUP_CONCAT(DISTINCT org_doc_no) AS doc,GROUP_CONCAT(DISTINCT acutno) AS cut from $bai_pro3.plandoc_stat_log where doc_no in (".$sql_rowy["doc"].") and org_doc_no>1";
				$resultr1123=mysqli_query($link, $sql123) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowr1123=mysqli_fetch_array($resultr1123))
				{
					if($sql_rowr1123["doc"]<>'' && $sql_rowr1123["cut"]<>'')
					{
						unset($dockets_ref);
						unset($cut_ref);
						$dockets_ref=explode(",",$sql_rowr1123["doc"]);
						$cut_ref=explode(",",$sql_rowr1123["cut"]);
					}					
				}
			}
			$sql12="select order_del_no,clubbing from $bai_pro3.order_cat_doc_mk_mix where doc_no in (".implode(",",$dockets_ref).") and clubbing>0 and category in ($in_categories) group by clubbing";
			
			$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($resultr112)>0)
			{
				while($sql_rowr112=mysqli_fetch_array($resultr112))
				{
					$schedule=$sql_rowr112['order_del_no'];
					$club=$sql_rowr112['clubbing'];
					$sql121="select * from $bai_pro3.order_cat_doc_mk_mix where doc_no not in (".implode(",",$dockets_ref).") and acutno in (".implode(",",$cut_ref).") and clubbing='".$club."' and order_del_no='".$schedule."' and category in ($in_categories)";
					$resultr1121=mysqli_query($link, $sql121) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowr1121=mysqli_fetch_array($resultr1121))
					{
						$dockets_ref[]=$sql_rowr1121['doc_no'];
					}	
				}
			}
			for($d=0;$d<sizeof($dockets_ref);$d++)
			{
				$sql12="select * from $bai_pro3.cutting_table_plan where doc_no='".$dockets_ref[$d]."'";
				$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($resultr112)==0)
				{
					$sql_map_table="select * from $bai_pro3.module_master where module_name=".$items[0]." and status='Active'";
					$sql_map_table_res=mysqli_query($link, $sql_map_table) or exit("Sql error sql_map_table".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_map_table_res)>0)
					{
						while($sql_map_table_res_row=mysqli_fetch_array($sql_map_table_res))
						{
							$mapped_cut_table=$sql_map_table_res_row["mapped_cut_table"];
						}
					
						if($mapped_cut_table != NULL)
						{
							$sql12="select * from $bai_pro3.tbl_cutting_table where tbl_name='$mapped_cut_table'";

							$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row12=mysqli_fetch_array($resultr112))
							{
								$tbl_id=$sql_row12["tbl_id"];
							}
							$insert_log_query="INSERT INTO $bai_pro3.cutting_table_plan (doc_no,priority,dashboard_ref,cutting_tbl_id,doc_no_ref,username, log_time) VALUES('".$dockets_ref[$d]."', '".$x."','IPS','".$tbl_id."','".implode(",",$dockets_ref)."','".$userName."', NOW())";
							mysqli_query($link, $insert_log_query) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				}				
				$sqlx="insert ignore into $bai_pro3.plan_dashboard(doc_no) values ('".$dockets_ref[$d]."')";
				mysqli_query($link, $sqlx) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sqlx1="update $bai_pro3.plan_dashboard set priority=$x1, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where doc_no='".$dockets_ref[$d]."'";
				mysqli_query($link, $sqlx1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql43="select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no=".$dockets_ref[$d]."";
				$resultr43=mysqli_query($link, $sql43) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($resultr43)>0)
				{
					while($sql_rowr43=mysqli_fetch_array($resultr43))
					{						
						$sqlx12332="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no='".$sql_rowr43['doc_no']."'";
						mysqli_query($link, $sqlx12332) or exit("Sql Error62.2".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no='".$dockets_ref[$d]."'";
					mysqli_query($link, $sqlx12) or exit("Sql Error62.1".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no='".$dockets_ref[$d]."'";
					mysqli_query($link, $sqlx12) or exit("Sql Error62.3".mysqli_error($GLOBALS["___mysqli_ston"]));
				}							
				$x1++;
				$x++;
			}
			unset($dockets_ref);		
		}		
	}
	$application='IPS';			
	$scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
	// echo $scanning_query;
	$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($scanning_result))
	{
		$operation_name=$sql_row['operation_name'];
		$operation_code=$sql_row['operation_code'];
	}
	$remove_docs=array();

	$sqlx="select input_job_no_random_ref as doc_no from $bai_pro3.plan_dashboard_input";
	//echo $sqlx;
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11.1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$job_status=job_rec_status($sql_rowx['doc_no'],$operation_code);
		if($job_status=='DONE')
		{
			$remove_docs[]="'".$sql_rowx['doc_no']."'";
		}
	}	
	if(sizeof($remove_docs)>0)
	{
		$sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_docs).")";
		//echo $sqlx.";<br>";
		mysqli_query($link, $sqlx) or exit("Sql Error11.2");
	}
	echo '<div class="alert alert-success"><h2>Sucessfully Updated... <br/> Please wait while we redirect to IPS Dashboard....</h2></div>';
	//echo "<h2>Sucessfully Updated... <br/> Please wait while redirect to IPS Dashboard....</h2>";
	$url =getFullURLLevel($_GET['r'],'dashboards/controllers/IPS/tms_dashboard_input_v22.php',3,'N');
	echo"<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1); 
	function Redirect() {  
		location.href = '$url'; 
	}</script>";

?>