<?php

//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

// include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
$log="";
$log.='<table border=1><tr><th>Query</th><th>Start Time</th><th>End Time</th><th>Difference</th></tr>';	
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
			$get_original_module="SELECT packing_summary_input.`doc_no`, packing_summary_input.`order_del_no`, plan_dashboard_input.`input_job_no_random_ref`, packing_summary_input.`input_job_no`, plan_dashboard_input.`input_module` FROM $bai_pro3.`plan_dashboard_input` LEFT JOIN $bai_pro3.`packing_summary_input` ON plan_dashboard_input.`input_job_no_random_ref`=packing_summary_input.`input_job_no_random` WHERE plan_dashboard_input. input_job_no_random_ref='".$items[1]."' group by plan_dashboard_input.input_job_no_random_ref";
			// echo $get_original_module.";<br>";
			$log.="<tr><th>".$get_original_module."</th>";
			$msc1=microtime(true);
			$log.="<th>".$msc1."</th>";
			$result_org_module=mysqli_query($link, $get_original_module) or die("Error while getting original module0");
			$msc2=microtime(true);
			$log.="<th>".$msc2."</th>";
			$msc3=$msc2-$msc1;
			$log.="<th>".$msc3."</th></tr>";

			if (mysqli_num_rows($result_org_module) > 0)
			{
				$log.="<tr><th>While Loop1 </th>";
				$msc4=microtime(true);
				$log.="<th>".$msc4."</th>";
				while($sql_row_org_module=mysqli_fetch_array($result_org_module))
				{
					$doc_no=$sql_row_org_module["doc_no"];
					$order_del_no=$sql_row_org_module["order_del_no"];
					$input_job_no_random_ref=$sql_row_org_module["input_job_no_random_ref"];
					$input_job_no=$sql_row_org_module["input_job_no"];
					$original_module=$sql_row_org_module["input_module"];
				}
				$msc5=microtime(true);
				$log.="<th>".$msc5."</th>";
				$msc6=$msc5-$msc4;
				$log.="<th>".$msc6."</th></tr>";
				$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no,  from_module, to_module, username, log_time) VALUES('".$doc_no."', '".$order_del_no."', '".$items[1]."', '".$input_job_no."',  '".$original_module."', 'No Module', '".$userName."', NOW())";
				 //echo $insert_log_query.";<br>";
				 //die();
				$log.="<tr><th>".$insert_log_query."</th>";
				$msc7=microtime(true);
				$log.="<th>".$msc7."</th>";
				mysqli_query($link, $insert_log_query) or die("Error while saving the track details1");
				$msc8=microtime(true);
				$log.="<th>".$msc8."</th>";
				$msc9=$msc8-$msc7;
				$log.="<th>".$msc9."</th></tr>";
			}
			$exisitng_docs = [];
			$sqly="SELECT group_concat(distinct doc_no) as doc_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='".$items[1]."' ORDER BY doc_no";
			//echo $sqly.";<br>";
			$log.="<tr><th>".$sqly."</th>";
			$msc10=microtime(true);
			$log.="<th>".$msc10."</th>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc11=microtime(true);
			$log.="<th>".$msc11."</th>";
			$msc12=$msc11-$msc10;
			$log.="<th>".$msc12."</th></tr>";
			$log.="<tr><th>While Loop2</th>";
			$msc13=microtime(true);
			$log.="<th>".$msc13."</th>";
			while($sql_rowy=mysqli_fetch_array($resulty))
			{
				$doc_no_ref_input=$sql_rowy["doc_no"]; 
			}
			$msc14=microtime(true);
			$log.="<th>".$msc14."</th>";
			$msc15=$msc14-$msc13;
			$log.="<th>".$msc15."</th></tr>";
			$incoming_docs = explode(',',$doc_no_ref_input);
			$fabric_status_query = "SELECT doc_ref from $bai_pro3.fabric_priorities where doc_ref IN ($doc_no_ref_input)";
			$log.="<tr><th>".$fabric_status_query."</th>";
			$msc16=microtime(true);
			$log.="<th>".$msc16."</th>";
			$fabric_status_result = mysqli_query($link,$fabric_status_query);
			$msc17=microtime(true);
			$log.="<th>".$msc17."</th>";
			$msc18=$msc17-$msc16;
			$log.="<th>".$msc18."</th>";
			$log.="<tr><th>While Loop3</th>";
			$msc19=microtime(true);
			$log.="<th>".$msc19."</th>";
			while($rowfs = mysqli_fetch_array($fabric_status_result)){
				$exisitng_docs[] = $rowfs['doc_ref'];
			}
			$msc20=microtime(true);
			$log.="<th>".$msc20."</th>";
			$msc21=$msc20-$msc19;
			$log.="<th>".$msc21."</th></tr>";
			$log.="<tr><th>Array Difference</th>";
			$msc22=microtime(true);
			$log.="<th>".$msc22."</th>";
			$diff_docs = array_diff($incoming_docs,$exisitng_docs);
			$doc_no_ref_input = implode(',',$diff_docs);
			$msc23=microtime(true);
			$log.="<th>".$msc23."</th>";
			$msc24=$msc23-$msc22;
			$log.="<th>".$msc24."</th></tr>";
			if($doc_no_ref_input == '')
				$doc_no_ref_input = 1;
			unset($diff_docs);
			unset($exisitng_docs);
			unset($incoming_docs);
			$org_docs=array();
			$org_docs[] = '-1';
			$sql="select org_doc_no from $bai_pro3.plandoc_stat_log where doc_no in (".$doc_no_ref_input.")";
			//echo $sql."</th>";
			$log.="<tr><th>".$sql."</th>";
			$msc25=microtime(true);
			$log.="<th>".$msc25."</th>";
			$resultr1=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc26=microtime(true);
			$log.="<th>".$msc26."</th>";
			$msc27=$msc26-$msc25;
			$log.="<th>".$msc27."</th></tr>";
			$log.="<tr><th>While Loop4<br>";
			$msc28=microtime(true);
			$log.="<th>".$msc28."</th>";
			while($sql_rowr1=mysqli_fetch_array($resultr1))
			{
				if($sql_rowr1["org_doc_no"]>1)
				{
					$org_docs[]=$sql_rowr1["org_doc_no"];
				}
			}
			$msc29=microtime(true);
			$log.="<th>".$msc29."</th>";
			$msc30=$msc29-$msc28;
			$log.="<th>".$msc30."</th></tr>";
			$sql="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$items[1]."'";
			// echo $sql.";<br>";
			$log.="<tr><th>".$sql."</th>";
			$msc31=microtime(true);
			$log.="<th>".$msc31."</th>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc32=microtime(true);
			$log.="<th>".$msc32."</th>";
			$msc33=$msc32-$msc31;
			$log.="<th>".$msc33."</th></tr>";
			$plan_moduleqry="update $bai_pro3.plandoc_stat_log set plan_module= NULL where doc_no in (".$doc_no_ref_input.")";
			$log.="<tr><th>".$plan_moduleqry."</th>";
			$msc34=microtime(true);
			$log.="<th>".$msc34."</th>";
			$plan_moduleqry_result=mysqli_query($link, $plan_moduleqry) or exit("plan_moduleqry update error first".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc35=microtime(true);
			$log.="<th>".$msc35."</th>";
			$msc36=$msc35-$msc34;
			$log.="<th>".$msc36."</th></tr>";
			$sql="delete from $bai_pro3.plan_dashboard where doc_no in (".$doc_no_ref_input.")";
			// echo $sql.";<br>";
			$log.="<tr><th>".$sql."</th>";
			$msc37=microtime(true);
			$log.="<th>".$msc37."</th>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc38=microtime(true);
			$log.="<th>".$msc38."</th>";
			$msc39=$msc38-$msc37;
			$log.="<th>".$msc39."</th></tr>";
			$sql="delete from $bai_pro3.cutting_table_plan where doc_no_ref in (".$doc_no_ref_input.")";
			// echo $sql.";<br>";
			$log.="<tr><th>".$sql."</th>";
			$msc40=microtime(true);
			$log.="<th>".$msc40."</th>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc41=microtime(true);
			$log.="<th>".$msc41."</th>";
			$msc42=$msc41-$msc40;
			$log.="<th>".$msc42."</th></tr>";
			$plan_moduleqry1="update $bai_pro3.plandoc_stat_log set plan_module= NULL where doc_no in (".implode(",",$org_docs).")";
			$log.="<tr><th>".$plan_moduleqry1."</th>";
			$msc43=microtime(true);
			$log.="<th>".$msc43."</th>";
			$plan_moduleqry_result1=mysqli_query($link, $plan_moduleqry1) or exit("plan_moduleqry update error second".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc44=microtime(true);
			$log.="<th>".$msc44."</th>";
			$msc45=$msc44-$msc43;
			$log.="<th>".$msc45."</th></tr>";
			$sql="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$org_docs).")";
			// echo $sql.";<br>";
			$log.="<tr><th>".$sql."</th>";
			$msc46=microtime(true);
			$log.="<th>".$msc46."</th>";
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc47=microtime(true);
			$log.="<th>".$msc47."</th>";
			$msc48=$msc47-$msc46;
			$log.="<th>".$msc48."</th></tr>";
		}
		else
		{
			$get_original_module="SELECT packing_summary_input.`doc_no`, packing_summary_input.`order_del_no`, plan_dashboard_input.`input_job_no_random_ref`, packing_summary_input.`input_job_no`, plan_dashboard_input.`input_module` FROM $bai_pro3.`plan_dashboard_input` LEFT JOIN $bai_pro3.`packing_summary_input` ON plan_dashboard_input.`input_job_no_random_ref`=packing_summary_input.`input_job_no_random` WHERE plan_dashboard_input. input_job_no_random_ref='".$items[1]."' group by plan_dashboard_input.input_job_no_random_ref";
			$log.="<tr><th>".$get_original_module."</th>";
			$msc49=microtime(true);
			$log.="<th>".$msc49."</th>";
			$result_org_module=mysqli_query($link, $get_original_module) or die("Error while getting original module1");
			$msc50=microtime(true);
			$log.="<th>".$msc50."</th>";
			$msc51=$msc50-$msc49;
			$log.="<th>".$msc51."</th></tr>";
			if (mysqli_num_rows($result_org_module) > 0)
			{
				$log.="<tr><th>While Loop4</th>";
				$msc52=microtime(true);
				$log.="<th>".$msc52."</th>";
				while($sql_row_org_module=mysqli_fetch_array($result_org_module))
				{
					$doc_no=$sql_row_org_module["doc_no"];
					$order_del_no=$sql_row_org_module["order_del_no"];
					$input_job_no_random_ref=$sql_row_org_module["input_job_no_random_ref"];
					$input_job_no=$sql_row_org_module["input_job_no"];
					$original_module=$sql_row_org_module["input_module"];
				}
				$msc53=microtime(true);
				$log.="<th>".$msc53."</th>";
				$msc54=$msc53-$msc52;
				$log.="<th>".$msc54."</th></tr>";
				if ($original_module != $items[0])
				{
					$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no,  from_module, to_module, username, log_time) VALUES('".$doc_no."', '".$order_del_no."', '".$items[1]."', '".$input_job_no."', '".$original_module."', '".$items[0]."', '".$userName."', NOW())";
					//echo $insert_log_query.";<br>";
					// die();
					$log.="<tr><th>".$insert_log_query."</th>";
					$msc55=microtime(true);
					$log.="<th>".$msc55."</th>";
					mysqli_query($link, $insert_log_query) or die("Error while saving the track details2");
					$msc56=microtime(true);
					$log.="<th>".$msc56."</th>";
					$msc57=$msc56-$msc55;
					$log.="<th>".$msc57."</th></tr>";
					$insert_qry1="insert into $bai_pro3.job_transfer_details (sewing_job_number,transfered_module,status) values (".$items[1].",".$items[0].",'P')";
					$log.="<tr><th>".$insert_log_query."</th>";
					$msc58=microtime(true);
					$log.="<th>".$msc58."</th>";
					mysqli_query($link, $insert_qry1)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$msc59=microtime(true);
					$log.="<th>".$msc59."</th>";
					$msc60=$msc59-$msc58;
					$log.="<th>".$msc60."</th></tr>";
				}				
			} 
			else
			{
				$get_schedule="SELECT `order_del_no`, input_job_no FROM $bai_pro3.`packing_summary_input` WHERE input_job_no_random='".$items[1]."' GROUP BY input_job_no_random";
				// echo $get_schedule.";<br>";
				$log.="<tr><th>".$get_schedule."</th>";
				$msc61=microtime(true);
				$log.="<th>".$msc61."</th>";
				$result_schedule=mysqli_query($link, $get_schedule) or die("Error while getting schedule No");
				$msc62=microtime(true);
				$log.="<th>".$msc62."</th>";
				$msc63=$msc62-$msc61;
				$log.="<th>".$msc63."</th></tr>";
				$log.="<tr><th>While Loop5</th>";
				$msc64=microtime(true);
				$log.="<th>".$msc64."</th>";
				while($sql_row_schedule=mysqli_fetch_array($result_schedule))
				{
					$order_del_no1=$sql_row_schedule["order_del_no"];
					$input_job_no1=$sql_row_schedule["input_job_no"];
				}
				$msc65=microtime(true);
				$log.="<th>".$msc65."</th>";
				$msc66=$msc65-$msc64;
				$log.="<th>".$msc66."</th></tr>";
				$insert_log_query="INSERT INTO $bai_pro3.jobs_movement_track (doc_no, schedule_no, input_job_no_random, input_job_no, from_module, to_module, username, log_time) VALUES('".$items[2]."', '".$order_del_no1."', '".$items[1]."', '".$input_job_no1."', 'No Module', '".$items[0]."', '".$userName."', NOW())";
				$log.="<tr><th>".$insert_log_query."</th>";
				$msc67=microtime(true);
				$log.="<th>".$msc."</th>";
				mysqli_query($link, $insert_log_query) or die("Error while saving the track details3 == ".$insert_log_query);
				$msc68=microtime(true);
				$log.="<th>".$msc68."</th>";
				$msc69=$msc68-$msc67;
				$log.="<th>".$msc69."</th></tr>";
			   // echo $insert_log_query.";<br>";
					
			}			

			$sql="insert ignore into $bai_pro3.plan_dashboard_input (input_job_no_random_ref) values ('".$items[1]."')";
			//echo $sql.";<br>";
			$log.="<tr><th>".$sql."</th>";
			$msc70=microtime(true);
			$log.="<th>".$msc70."</th>";
			mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc71=microtime(true);
			$log.="<th>".$msc71."</th>";
			$msc72=$msc71-$msc70;
			$log.="<th>".$msc72."</th></tr>";
			if(((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res)>0)
			{
				$sql="update $bai_pro3.plan_dashboard_input set input_priority=$x, input_module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where input_job_no_random_ref='".$items[1]."'";
				//echo $sql;
				$log.="<tr><th>".$sql."</th>";
				$msc73=microtime(true);
				$log.="<th>".$msc73."</th>";
				mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc74=microtime(true);
				$log.="<th>".$msc74."</th>";
				$msc75=$msc74-$msc73;
				$log.="<th>".$msc75."</th></tr>";
			}
			else
			{

				$sql="update $bai_pro3.plan_dashboard_input set input_priority=$x, input_module="."'".$items[0]."'"." where input_job_no_random_ref='".$items[1]."'";
				$log.="<tr><th>".$sql."</th>";
				$msc76=microtime(true);
				$log.="<th>".$msc76."</th>";
				mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc77=microtime(true);
				$log.="<th>".$msc77."</th>";
				$msc78=$msc77-$msc76;
				$log.="<th>".$msc78."</th></tr>";
			}
					
			$dockets_ref=array();
			$sqly="SELECT GROUP_CONCAT(DISTINCT doc_no) AS doc,GROUP_CONCAT(DISTINCT acutno) AS cut,input_job_no_random as job_ref FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$items[1]."' ORDER BY acutno";
			$log.="<tr><th>".$sqly."</th>";
			$msc79=microtime(true);
			$log.="<th>".$msc79."</th>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc80=microtime(true);
			$log.="<th>".$msc80."</th>";
			$msc81=$msc80-$msc79;
			$log.="<th>".$msc81."</th></tr>";
		
			
			while($sql_rowy=mysqli_fetch_array($resulty))
			{			
				$input_job_no_random_ref1=$sql_rowy["job_ref"];
				$dockets_ref=explode(",",$sql_rowy["doc"]);
				$cut_ref=explode(",",$sql_rowy["cut"]);
				$sql123="select GROUP_CONCAT(DISTINCT org_doc_no) AS doc,GROUP_CONCAT(DISTINCT acutno) AS cut from $bai_pro3.plandoc_stat_log where doc_no in (".$sql_rowy["doc"].") and org_doc_no>1";
				$log.="<tr><th>".$sql123."</th>";
				$msc82=microtime(true);
				$log.="<th>".$msc82."</th>";
				$resultr1123=mysqli_query($link, $sql123) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc83=microtime(true);
				$log.="<th>".$msc83."</th>";
				$msc84=$msc83-$msc82;
				$log.="<th>".$msc84."</th></tr>";
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

			$sql12="select order_del_no,clubbing from bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.plandoc_stat_log AS psl,bai_pro3.cat_stat_log AS csl WHERE bodc.order_tid=psl.order_tid AND bodc.order_tid=csl.order_tid AND psl.order_tid=csl.order_tid AND psl.doc_no in (".implode(",",$dockets_ref).") and csl.clubbing>0 and csl.category in ($in_categories) group by csl.clubbing";
			$log.="<tr><th>".$sql12."</th>";
			$msc85=microtime(true);
			$log.="<th>".$msc85."</th>";
			$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
			$msc86=microtime(true);
			$log.="<th>".$msc86."</th>";
			$msc87=$msc86-$msc85;
			$log.="<th>".$msc87."</th></tr>";
			if(mysqli_num_rows($resultr112)>0)
			{
				while($sql_rowr112=mysqli_fetch_array($resultr112))
				{
					$schedule=$sql_rowr112['order_del_no'];
					$club=$sql_rowr112['clubbing'];
					$sql121="SELECT doc_no FROM bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.plandoc_stat_log AS psl,bai_pro3.cat_stat_log AS csl
					WHERE bodc.order_tid=psl.order_tid AND psl.order_tid=csl.order_tid AND bodc.order_del_no='".$schedule."' AND psl.doc_no NOT IN (".implode(",",$dockets_ref).") AND psl.acutno IN (".implode(",",$cut_ref).") AND bodc.order_tid=csl.order_tid AND csl.clubbing=".$club." AND csl.category IN ($in_categories)";
					$log.="<tr><th>".$sql121."</th>";
					$msc88=microtime(true);
					$log.="<th>".$msc88."</th>";
					$resultr1121=mysqli_query($link, $sql121) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					$msc89=microtime(true);
					$log.="<th>".$msc89."</th>";
					$msc90=$msc89-$msc88;
					$log.="<th>".$msc90."</th></tr>";
					while($sql_rowr1121=mysqli_fetch_array($resultr1121))
					{
						$dockets_ref[]=$sql_rowr1121['doc_no'];
					}	
				}
			}
			for($d=0;$d<sizeof($dockets_ref);$d++)
			{
				$sql12="select * from $bai_pro3.cutting_table_plan where doc_no=".$dockets_ref[$d]."";
				$log.="<tr><th>".$sql12."</th>";
					$msc91=microtime(true);
					$log.="<th>".$msc91."</th>";
				$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc92=microtime(true);
				$log.="<th>".$msc92."</th>";
					$msc93=$msc92-$msc91;
					$log.="<th>".$msc93."</th></tr>";
				if(mysqli_num_rows($resultr112)==0)
				{
					$sql_map_table="select mapped_cut_table from $bai_pro3.module_master where module_name=".$items[0]." and status='Active'";
					$log.="<tr><th>".$sql_map_table."</th>";
					$msc94=microtime(true);
					$log.="<th>".$msc94."</th>";
					$sql_map_table_res=mysqli_query($link, $sql_map_table) or exit("Sql error sql_map_table".mysqli_error($GLOBALS["___mysqli_ston"]));
					$msc95=microtime(true);
					$log.="<th>".$msc95."</th>";
					$msc96=$msc95-$msc94;
					$log.="<th>".$msc96."</th></tr>";
					if(mysqli_num_rows($sql_map_table_res)>0)
					{
						while($sql_map_table_res_row=mysqli_fetch_array($sql_map_table_res))
						{
							$mapped_cut_table=$sql_map_table_res_row["mapped_cut_table"];
						}
					
						if($mapped_cut_table != NULL)
						{
							$sql12="select tbl_id from $bai_pro3.tbl_cutting_table where tbl_name='$mapped_cut_table'";
							$log.="<tr><th>".$sql12."</th>";
							$msc97=microtime(true);
							$log.="<th>".$msc97."</th>";
							$resultr112=mysqli_query($link, $sql12) or exit("Sql Error5 == ".$sql12.' == '.mysqli_error($GLOBALS["___mysqli_ston"]));
							$msc98=microtime(true);
							$log.="<th>".$msc98."</th>";
							$msc99=$msc98-$msc97;
							$log.="<th>".$msc99."</th></tr>";
							while($sql_row12=mysqli_fetch_array($resultr112))
							{
								$tbl_id=$sql_row12["tbl_id"];
							}
							$insert_log_query="INSERT INTO $bai_pro3.cutting_table_plan (doc_no,priority,dashboard_ref,cutting_tbl_id,doc_no_ref,username, log_time) VALUES('".$dockets_ref[$d]."', '".$x."','IPS','".$tbl_id."','".implode(",",$dockets_ref)."','".$userName."', NOW())";
							$log.="<tr><th>".$insert_log_quer."</th>";
							$msc100=microtime(true);
							$log.="<th>".$msc100."</th>";
							mysqli_query($link, $insert_log_query) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
							$msc101=microtime(true);
							$log.="<th>".$msc101."</th>";
							$msc102=$msc101-$msc100;
							$log.="<th>".$msc102."</th></tr>";
						}
					}
				}				
				$sqlx="insert ignore into $bai_pro3.plan_dashboard(doc_no) values ('".$dockets_ref[$d]."')";
				$log.="<tr><th>".$sqlx."</th>";
				$msc103=microtime(true);
				$log.="<th>".$msc103."</th>";
				mysqli_query($link, $sqlx) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc104=microtime(true);
				$log.="<th>".$msc104."</th>";
				$msc105=$msc104-$msc103;
				$log.="<th>".$msc105."</th></tr>";
	
				$sqlx1="update $bai_pro3.plan_dashboard set priority=$x1, module=".$items[0].", log_time=\"".date("Y-m-d H:i:s")."\" where doc_no=".$dockets_ref[$d]."";
				$log.="<tr><th>".$sqlx1."</th>";
				$msc106=microtime(true);
				$log.="<th>".$msc106."</th>";
				mysqli_query($link, $sqlx1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc107=microtime(true);
				$log.="<th>".$msc107."</th>";
				$msc108=$msc107-$msc106;
				$log.="<th>".$msc108."</th></tr>";
				
				$sql43="select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no=".$dockets_ref[$d]."";
				$log.="<tr><th>".$sql43."</th>";
				$msc109=microtime(true);
				$log.="<th>".$msc109."</th>";
				$resultr43=mysqli_query($link, $sql43) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$msc110=microtime(true);
				$log.="<th>".$msc110."</th>";
				$msc111=$msc110-$msc109;
				$log.="<th>".$msc111."</th></tr>";
				if(mysqli_num_rows($resultr43)>0)
				{
					while($sql_rowr43=mysqli_fetch_array($resultr43))
					{						
						$sqlx12332="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no=".$sql_rowr43['doc_no']."";
						$log.="<tr><th>".$sqlx12332."</th>";
						$msc112=microtime(true);
						$log.="<th>".$msc112."</th>";
						mysqli_query($link, $sqlx12332) or exit("Sql Error62.2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$msc113=microtime(true);
						$log.="<th>".$msc113."</th>";
						$msc114=$msc113-$msc112;
						$log.="<th>".$msc114."</th></tr>";
					}
					$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no=".$dockets_ref[$d]."";
					$log.="<tr><th>".$sqlx12."</th>";
						$msc115=microtime(true);
						$log.="<th>".$msc115."</th>";
					mysqli_query($link, $sqlx12) or exit("Sql Error62.1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$msc116=microtime(true);
					$log.="<th>".$msc116."</th>";
						$msc117=$msc116-$msc115;
						$log.="<th>".$msc117."</th></tr>";
				}
				else
				{
					$sqlx12="update $bai_pro3.plandoc_stat_log set plan_module=".$items[0]." where doc_no=".$dockets_ref[$d]."";
					$log.="<tr><th>".$sqlx12."</th>";
						$msc118=microtime(true);
						$log.="<th>".$msc118."</th>";
					mysqli_query($link, $sqlx12) or exit("Sql Error62.3".mysqli_error($GLOBALS["___mysqli_ston"]));
					$msc119=microtime(true);
					$log.="<th>".$msc119."</th>";
						$msc120=$msc119-$msc118;
						$log.="<th>".$msc120."</th></tr>";
				}							
				$x1++;
				$x++;
			}
			unset($dockets_ref);		
		}		
	}
	echo '<div class="alert alert-success"><h2>Sucessfully Updated... <br/> Please wait while we redirect to IPS Dashboard....</h2></div>';
	

	$include_path=getenv('config_job_path');
	$directory = $include_path.'\sfcs_app\app\planning\controllers\input_job_level_planning\\'.'log';
	if (!file_exists($directory)) {
		mkdir($directory, 0777, true);
	}
	$file_name_string = $userName.'_'.date("Y-m-d-H-i-s").'.html';
	$my_file=$include_path.'\sfcs_app\app\planning\controllers\input_job_level_planning\\'.'log\\'.$file_name_string;
	$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
	$file_data_request = $log;
	fwrite($handle,"\n".$file_data_request); 

	fclose($handle); 

	echo "<h2>Sucessfully Updated... <br/> Please wait while redirect to IPS Dashboard....</h2>";
	$url =getFullURLLevel($_GET['r'],'dashboards/controllers/IPS/tms_dashboard_input_v22.php',3,'N');
	echo"<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1); 
	function Redirect() {  
		location.href = '$url'; 
	}</script>";
	// echo $log;

?>