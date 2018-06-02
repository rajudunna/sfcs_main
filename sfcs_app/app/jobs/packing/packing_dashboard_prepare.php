<?php
	$start_timestamp = microtime(true);

	include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');
	
	function leading_zeros($value, $places){
	    if(is_numeric($value)){
	        for($x = 1; $x <= $places; $x++){
	            $ceiling = pow(10, $x);
	            if($value < $ceiling){
	                $zeros = $places - $x;
	                for($y = 1; $y <= $zeros; $y++){
	                    $leading .= "0";
	                }
	            $x = $places + 1;
	            }
	        }
	        $output = $leading . $value;
	    }
	    else{
	        $output = $value;
	    }
	    return $output;
	}
	
	
	//NEW to reset all pending cartons
	//$sql="update pac_stat_log set disp_carton_no=NULL";
	$sql="update bai_pro3.pac_stat_log set disp_carton_no=NULL where status='DONE' and disp_carton_no=1";
	$res=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res)
	{
		print("Updated pac_stat_log Table Successfully")."\n";
	}
	//New to reset all pending cartons

	
	$sql1="truncate bai_pro3.ims_log_packing";
	mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql2="insert into bai_pro3.ims_log_packing select * from bai_pro3.packing_dashboard_new2";
	$res1=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res1)
	{
		print("Updated ims_log_packing Table Successfully")."\n";
	}
	$sql3="truncate bai_pro3.packing_summary_tmp_v1";
	mysqli_query($link, $sql3) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql4="insert into bai_pro3.packing_summary_tmp_v1 select * from bai_pro3.packing_summary where 
	order_del_no in (select order_del_no from bai_pro3.packing_pending_schedules)";
	// echo $sql4;
	$res2=mysqli_query($link, $sql4) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res2)
	{
		print("Updated packing_summary_tmp_v1 Table Successfully")."\n";
	}
	//NEW2011
	
	//Schedules to process (For speeding operations)
	
	//input/output
	
	//New Code to speedup process
	$sch_to_process=array();
	//$log_time_stamp="2012-03-22 06:00:00";
	include("time_stamp.php");
	$write='<?php $log_time_stamp="'.date("Y-m-d H").':00:00"; ?>';

	$sql5="select distinct ims_schedule from bai_pro3.ims_log where ims_log_date>='$log_time_stamp'";
	// echo $sql5."<br/>";
	$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row5=mysqli_fetch_array($sql_result5))
	{
		$sch_to_process[]=$sql_row5['ims_schedule'];
	}
	
	$sql6="select distinct ims_schedule from bai_pro3.ims_log_backup where ims_log_date>='$log_time_stamp'";
	// echo $sql6."<br/>";
	$sql_result6=mysqli_query($link, $sql6) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row6=mysqli_fetch_array($sql_result6))
	{
		$sch_to_process[]=$sql_row6['ims_schedule'];
	}
	
	//$sch_to_process=array("138915","138922","141082","141082","142873","141097","132275","128618","138943","126111","138952");
	//Schedules to process
if(sizeof($sch_to_process)>0)
{

	$doc_refs=array();
	$styles=array();
	$schedules=array();
	$sizes=array();
	$disp_carton_no=array();
	//$sql1="SELECT DISTINCT doc_no_ref,order_style_no,order_del_no,size_code,disp_carton_no FROM packing_summary_tmp_v1 WHERE disp_carton_no is NULL and (STATUS IS null or left(status,1)=\"E\") and order_del_no=42834";
$sql1="SELECT DISTINCT doc_no_ref,order_style_no,order_del_no,size_code,disp_carton_no FROM bai_pro3.packing_summary_tmp_v1 WHERE order_del_no in (".implode(",",$sch_to_process).") and disp_carton_no is NULL and (STATUS IS null or left(status,1)=\"E\")";

	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$doc_refs[]=$sql_row1['doc_no_ref'];
		$styles[]=$sql_row1['order_style_no'];
		$schedules[]=$sql_row1['order_del_no'];
		$sizes[]=$sql_row1['size_code'];
		$disp_carton_no[]=$sql_row1['disp_carton_no'];
	}
	
	for($j=0;$j<sizeof($doc_refs);$j++)
	{
		$temp=array();
		$temp=explode(",",$doc_refs[$j]);
		$temp1=array();
		for($i=0;$i<sizeof($temp);$i++)
		{
			$temp_x=array();
			$temp_x=explode("-",$temp[$i]);
			$temp1[]=$temp_x[0];
		}
		
		$qty_breakup=array();
		$color_group=array();
		$sql="select sum(carton_act_qty) as \"carton_act_qty\",order_col_des from bai_pro3.packing_summary_tmp_v1 where doc_no_ref=\"".$doc_refs[$j]."\" and size_code=\"".$sizes[$j]."\" group by order_col_des";
 		//$sql="select sum(carton_act_qty) as \"carton_act_qty\",order_col_des from packing_summary_tmp_v1 where doc_no_ref=\"".$doc_refs[$j]."\" group by order_col_des"; //20111213
		// echo $sql."<br/>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$range_count=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$qty_breakup[]=$sql_row['carton_act_qty'];
			$color_group[]=$sql_row['order_col_des'];
		}
		
		$test=1; //false
 		
		for($i=0;$i<$range_count;$i++)
		{
			$carton_qty_completed=0;
			$received_qty=0;

	$sql="select coalesce(ims_pro_qty_cumm,0) as \"completed\" from bai_pro3.ims_log_packing where ims_style=\"".$styles[$j]."\" and ims_schedule=".$schedules[$j]." and ims_color=\"".$color_group[$i]."\" and ims_size=\"a_".$sizes[$j]."\" and ims_doc_no in (".implode(",",$temp1).")";
			// echo $sql."<br/>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$carton_qty_completed=$sql_row['completed'];
			}
			

	$sql="select coalesce(sum(ims_pro_qty),0) as \"completed\" from bai_pro3.ims_log where ims_style=\"".$styles[$j]."\" and ims_schedule=".$schedules[$j]." and ims_color=\"".$color_group[$i]."\" and ims_size=\"a_".$sizes[$j]."\" and ims_doc_no in (".implode(",",$temp1).")";
			// echo $sql."<br/>";
			
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$carton_qty_completed+=$sql_row['completed'];
			}
			

			$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from bai_pro3.packing_summary_tmp_v1 where order_style_no=\"".$styles[$j]."\" and order_del_no=".$schedules[$j]." and order_col_des=\"".$color_group[$i]."\" and (status=\"DONE\" or disp_carton_no=1) and size_code=\"".$sizes[$j]."\" and doc_no in (".implode(",",$temp1).")";
 			// echo $sql."<br/>";
		
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$received_qty=$sql_row['received'];
			}
			
			/*$sql="select coalesce(sum(carton_act_qty),0) as \"received\" from packing_dashboard_temp where ims_style=\"".$styles[$j]."\" and ims_schedule=".$schedules[$j]." and ims_color=\"".$color_group[$i]."\" and status=\"DONE\" and size_code=\"".$sizes[$j]."\" and doc_no in (".implode(",",$temp1).")";
 			//echo $sql."<br/>";
			mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$received_qty+=$sql_row['received'];
			} */
			
			if($carton_qty_completed>=($qty_breakup[$i]+$received_qty))
			{
				$test=0; //true
			}
			else
			{
				$test=1;
				break;
			}
		}
		if($test==0)
		{
			
			/*$sql="SELECT ims_mod_no, MAX(ims_log_date) AS ims_log_date FROM 
(SELECT ims_mod_no,ims_log_date FROM ims_log_backup_t2 WHERE ims_doc_no IN (".implode(",",$temp1).") UNION SELECT ims_mod_no,ims_log_date FROM ims_log_backup_t1 WHERE ims_doc_no IN (".implode(",",$temp1).")) AS t";
 			echo $sql;
			mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$mod_no=$sql_row['ims_mod_no'];
				$ims_log_date=$sql_row['ims_log_date'];
			}
			
			
			$sql="select tid,doc_no,size_code,carton_act_qty,lastup,remarks,doc_no_ref,order_style_no,order_del_no,order_col_des from packing_summary_tmp_v1 where doc_no_ref=\"".$doc_refs[$j]."\"";
 			echo $sql;
			mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$a1=$sql_row['tid'];
				$a2=$sql_row['doc_no'];
				$a3=$sql_row['size_code'];
				$a4=$sql_row['carton_act_qty'];
				$a5=$sql_row['lastup'];
				$a6=$sql_row['remarks'];
				$a7=$sql_row['doc_no_ref'];
				$a8=$sql_row['order_style_no'];
				$a9=$sql_row['order_del_no'];
				$a10=$sql_row['order_col_des'];

			}
				
			$sql="insert into packing_dashboard_temp (tid,doc_no,size_code,carton_act_qty,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,ims_mod_no,ims_log_date) values ($a1,\"$a2\",\"$a3\",$a4,\"$a5\",\"$a6\",\"$a7\",\"$a8\",\"$a9\",\"$a10\",$mod_no,\"$ims_log_date\")";
echo $sql;
			mysql_query($sql,$link) or exit("Sql Error".mysql_error()); */
			
			$sql="update bai_pro3.pac_stat_log set disp_carton_no=1 where doc_no_ref=\"".$doc_refs[$j]."\" and size_code=\"".$sizes[$j]."\"";
			//$sql="update pac_stat_log set disp_carton_no=1 where doc_no_ref=\"".$doc_refs[$j]."\""; //20111213
			$res3=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if($res3)
			{
				print("Updated pac_stat_log table Successfully")."\n";
			}
			$sql="update bai_pro3.packing_summary_tmp_v1 set disp_carton_no=1 where doc_no_ref=\"".$doc_refs[$j]."\"  and size_code=\"".$sizes[$j]."\"";
			//$sql="update packing_summary_tmp_v1 set disp_carton_no=1 where doc_no_ref=\"".$doc_refs[$j]."\""; //20111213

			$res4=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if($res4)
			{
				print("Updated packing_summary_tmp_v1 table Successfully")."\n";
			}
		}
		else
		{
			if($disp_carton_no[$j]>=1)
			{
				//NEW Implementation for Clearing existing things.
				$sql="update bai_pro3.pac_stat_log set disp_carton_no=NULL where doc_no_ref=\"".$doc_refs[$j]."\" and size_code=\"".$sizes[$j]."\"";

				//$sql="update pac_stat_log set disp_carton_no=1 where doc_no_ref=\"".$doc_refs[$j]."\""; //20111213
				$res5=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if($res5)
				{
					print("Updated pac_stat_log table Successfully")."\n";
				}
			}
		}
	}
	
	//NEW2011
	//NEW ADD 2011-07-14
	$sql1="truncate bai_pro3.packing_dashboard_temp";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql1="insert into bai_pro3.packing_dashboard_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from bai_pro3.packing_dashboard";
	$res6=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res6)
	{
		print("Updated pac_stat_log table Successfully")."\n";
	}
	//NEW ADD 2011-07-14
	
	
	
	//SPEED DEL UPDATES
	$sql="select speed_schedule from bai_pro3.speed_del_dashboard";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$schedule=$sql_row['speed_schedule'];
		
		$fcamca=0;
		$fgqty=0;
		$internal_audited=0;
		$pendingcarts=0;

		$sql1="select fca_app,app,scanned from bai_pro3.disp_mix where order_del_no=$schedule";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$fcamca=$sql_row1['app'];
			$fgqty=$sql_row1['scanned'];
			$internal_audited=$sql_row1['fca_app'];	
		}
		
		$sql1="select sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from bai_pro3.packing_summary where order_del_no=$schedule and container=1";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$pendingcarts=$sql_row1['pendingcarts'];		
		}
		
		
		$sql1="select distinct container, sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from bai_pro3.packing_summary where order_del_no=$schedule and container>1";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$pendingcarts+=$sql_row1['pendingcarts'];		
		}
		
		$sql1="update bai_pro3.speed_del_dashboard set audited=$fcamca, fgqty=$fgqty, pending_carts=$pendingcarts, internal_audited=$internal_audited where speed_schedule=$schedule";

		$res7=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res7)
		{
			print("Updated speed_del_dashboard table Successfully")."\n";
		}
	}
	//SPEED DEL UPDATES
	
	
}	
	
	print("Job Completed")."\n";	
	
	
	//To Write File
	$myFile = "time_stamp.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = $write;
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	echo date("Y-m-d H:i:s");

?>

<?php
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
?>
