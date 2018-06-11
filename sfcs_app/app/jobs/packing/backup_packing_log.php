
<?php 
	$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');
	
	set_time_limit(90000);
	
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
	?>




<?php

	$date=date("Y-m-d",strtotime("-30 days"));
	$order_del_no_db=array();
	
	$sql1="select distinct order_del_no from bai_pro3.bai_orders_db_confirm where order_stat='CLOSED' and order_date<'$date'";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$order_del_no_db[]=$sql_row1['order_del_no'];
	}
	
	
	//new code to clean up bai_qms_db - 20151024 kirang
	$sqlx="delete from bai_pro.bai_log_buf where bac_date<'".date("Y-m-d",strtotime("-120 days"))."'";
	// echo $sqlx."<br/>";
	mysqli_query($link, $sqlx) or exit("Sql Error14-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql1="SELECT DISTINCT qms_schedule,MAX(log_date) FROM bai_pro3.bai_qms_db GROUP BY qms_schedule HAVING MAX(log_date)<'".date("Y-m-d",strtotime("-180 days"))."'";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		//if($sql_row1['order_del_no']>0)
		{
			$sqlx="insert ignore into bai_pro3.bai_qms_db_archive select * from bai_pro3.bai_qms_db where qms_schedule='".$sql_row1['qms_schedule']."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error14-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.bai_qms_db where qms_schedule='".$sql_row1['qms_schedule']."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error15-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
	}
	
	
	for($i=0;$i<sizeof($order_del_no_db);$i++)
	{
		$sqlx="INSERT IGNORE INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup SELECT * FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule='".$order_del_no_db[$i]."'";
		// echo $sqlx."<br/>";
		mysqli_query($link, $sqlx) or exit("Sql Error14-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(mysqli_affected_rows($link)>0)
		{
			$sqlx="DELETE FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule='".$order_del_no_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error15-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	
	//new code to clean up bai_qms_db - 20151024 kirang
	
	//TO delete Backlogs 2012-06-11
	$sql1="SELECT tid FROM bai_pro3.packing_summary where order_del_no is null";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$tid=$sql_row1['tid'];
		
		$sqlx="insert ignore into bai_pro3.pac_stat_log_backup select * from bai_pro3.pac_stat_log where tid=$tid";
		mysqli_query($link, $sqlx) or exit("Sql Error2-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(mysqli_affected_rows($link)>0)
		{
			$sqlx="delete from bai_pro3.pac_stat_log where tid=$tid";
			mysqli_query($link, $sqlx) or exit("Sql Error3-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	
		

		$sql1="SELECT lable_ids,order_del_no FROM bai_pro3.pack_to_be_backup where create_date<\"$date\" or create_date is null";

		//$sql1="SELECT GROUP_CONCAT(tid) as lable_ids,order_del_no FROM packing_summary WHERE order_del_no IN  (101323,101324) group by order_del_no";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error4-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$label_ids=$sql_row1['lable_ids'];
			$order_del_no=$sql_row1['order_del_no'];
			
			$temp=array();
			
			$sql121="SELECT tid FROM bai_pro3.packing_summary where order_del_no=".$order_del_no;
			$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error9-$sql121".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row121=mysqli_fetch_array($sql_result121))
			{
				$temp[]=$sql_row121['tid'];
			}
						
			$count=sizeof($temp);
			echo $count;
			
			$order_del_no_db[]=$sql_row1['order_del_no'];
			
			if( sizeof($temp)>0)
			{
				$sqlx="insert ignore into bai_pro3.pac_stat_log_backup select * from bai_pro3.pac_stat_log where tid in (".implode(",",$temp).")";
				mysqli_query($link, $sqlx) or exit("Sql Error5-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo "$".mysqli_affected_rows($link)."$";
				if($count==mysqli_affected_rows($link))
				{
				//echo "Label Id".$label_ids;
				$sqlx="delete from bai_pro3.pac_stat_log where tid in (".implode(",",$temp).")";
				mysqli_query($link, $sqlx) or exit("Sql Error6-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				if(mysqli_affected_rows($link)==$count)
				{
					echo "Success"."<br/>";
					
					$sqlx="insert ignore into bai_pro3.ims_log_backup_backup select * from bai_pro3.ims_log_backup where ims_schedule=$order_del_no";
					// echo $sqlx."<br/>";
					mysqli_query($link, $sqlx) or exit("Sql Error7-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(mysqli_affected_rows($link)>0)
					{
						$sqlx="delete from bai_pro3.ims_log_backup where ims_schedule=$order_del_no";
						// echo $sqlx."<br/>";
						mysqli_query($link, $sqlx) or exit("Sql Error8-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
			}
			unset($temp);																			
		}
		
		//To update effect this to other tables
		
		$order_del_no_db=array_unique($order_del_no_db);
		
		$order_tid_ref_db=array();
				
		for($i=0;$i<sizeof($order_del_no_db);$i++)
		{
			$sql1="SELECT distinct order_tid FROM bai_pro3.bai_orders_db where order_del_no=".$order_del_no_db[$i];
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error9-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$order_tid_ref_db[]=$sql_row1['order_tid'];
			}
			
			//FCA / Internal Audit
			$sqlx="insert ignore into bai_pro3.fca_audit_fail_db_archive select * from bai_pro3.fca_audit_fail_db where schedule=".$order_del_no_db[$i];
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error10-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.fca_audit_fail_db where schedule=".$order_del_no_db[$i];
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error11-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//Week_Shipment_Plan
			$sqlx="insert ignore into bai_pro4.shipment_plan_archive select * from bai_pro4.shipment_plan where schedule_no=".$order_del_no_db[$i];
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error12-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro4.shipment_plan where schedule_no=".$order_del_no_db[$i];
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error13-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//qms
			/*
			$sqlx="insert ignore into bai_pro3.bai_qms_db_archive select * from bai_pro3.bai_qms_db where qms_schedule=".$order_del_no_db[$i];
			echo $sqlx."<br/>";
			mysql_query($sqlx,$link) or exit("Sql Error14-$sqlx".mysql_error());
			
			if(mysql_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.bai_qms_db where qms_schedule=".$order_del_no_db[$i];
				echo $sqlx."<br/>";
				mysql_query($sqlx,$link) or exit("Sql Error15-$sqlx".mysql_error());
			}
			*/
		}
		
		//To delete from week_Delivery_plan
			unset($new_temp);
			$new_temp=array();
			$sql1="SELECT ref_id FROM bai_pro4.week_delivery_plan_ref where ship_tid is null";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error16-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				//$ref_id=$sql_row1['ref_id'];
				$new_temp[]=$sql_row1['ref_id'];
			}
			$ref_id=implode(",",$new_temp);
			
			if(strlen($ref_id)>0)
			{
				
			
			$sqlx="insert ignore into bai_pro4.week_delivery_plan_archive select * from bai_pro4.week_delivery_plan where ref_id in ($ref_id)";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error17-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro4.week_delivery_plan where ref_id in ($ref_id)";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error18-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			}
			
		
		$normal_doc_ref_db=array();
		$recut_doc_ref_db=array();
		$cat_ref_db=array();
		
		for($i=0;$i<sizeof($order_tid_ref_db);$i++)
		{
			//Orders
			$sqlx="insert ignore into bai_pro3.bai_orders_db_archive select * from bai_pro3.bai_orders_db where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error19-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.bai_orders_db where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error20-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			$sqlx="insert ignore into bai_pro3.bai_orders_db_confirm_archive select * from bai_pro3.bai_orders_db_confirm where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error21-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.bai_orders_db_confirm where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error22-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//Allocate
			$sqlx="insert ignore into bai_pro3.allocate_stat_log_archive  select * from bai_pro3.allocate_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error23-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.allocate_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error24-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//Cat Stat Log
			$sqlx="insert ignore into bai_pro3.cat_stat_log_archive select * from bai_pro3.cat_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error25-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.cat_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error26-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//Cuttable
			$sqlx="insert ignore into bai_pro3.cuttable_stat_log_archive  select * from bai_pro3.cuttable_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error27-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.cuttable_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error28-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}	
			
			//Maker
			$sqlx="insert ignore into bai_pro3.maker_stat_log_archive  select * from bai_pro3.maker_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error29-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.maker_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error30-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//Normal Docket
			$sql1="SELECT doc_no,cat_ref from bai_pro3.plandoc_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error31-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$normal_doc_ref_db[]=$sql_row1['doc_no'];
				$cat_ref_db[]=$sql_row1['cat_ref'];
			}
			
			//Recut Dockets
			$sql1="SELECT doc_no from bai_pro3.recut_v2 where order_tid='".$order_tid_ref_db[$i]."'";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error32-$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$recut_doc_ref_db[]=$sql_row1['doc_no'];
			}
			
			//Plandoc
			$sqlx="insert ignore into bai_pro3.plandoc_stat_log_archive  select * from  bai_pro3.plandoc_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error33-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.plandoc_stat_log where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error34-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//recut Plandoc
			$sqlx="insert ignore into bai_pro3.recut_v2_archive  select * from bai_pro3.recut_v2 where order_tid='".$order_tid_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error35-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.recut_v2 where order_tid='".$order_tid_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error36-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		$normal_doc_ref_db=array_unique($normal_doc_ref_db);
		for($i=0;$i<sizeof($normal_doc_ref_db);$i++)
		{
			//cut status
			$sqlx="insert ignore into bai_pro3.act_cut_status_archive  select * from  bai_pro3.act_cut_status where doc_no=".$normal_doc_ref_db[$i];
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error37-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.act_cut_status where doc_no=".$normal_doc_ref_db[$i];
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error38-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//cut issue status
			$sqlx="insert ignore into bai_pro3.act_cut_issue_status_archive  select * from  bai_pro3.act_cut_issue_status where doc_no=".$normal_doc_ref_db[$i];
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error39-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.act_cut_issue_status where doc_no=".$normal_doc_ref_db[$i];
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error40-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			//Trims
			$sqlx="insert ignore into bai_pro3.trims_dashboard_backup  select * from bai_pro3.trims_dashboard where doc_ref=".$normal_doc_ref_db[$i];
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error39-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.trims_dashboard where doc_ref=".$normal_doc_ref_db[$i];
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error40-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		$recut_doc_ref_db=array_unique($recut_doc_ref_db);
		for($i=0;$i<sizeof($recut_doc_ref_db);$i++)
		{
			//cut status
			$sqlx="insert ignore into bai_pro3.act_cut_status_recut_v2_archive  select * from  bai_pro3.act_cut_status_recut_v2 where doc_no=".$recut_doc_ref_db[$i];
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error41-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.act_cut_status_recut_v2 where doc_no=".$recut_doc_ref_db[$i];
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error42-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		//Maker Matrix
		$cat_ref_db=array_unique($cat_ref_db);
		for($i=0;$i<sizeof($cat_ref_db);$i++)
		{
			//Maker Matrix
			$sqlx="insert ignore into bai_pro3.marker_ref_matrix_archive select * from  bai_pro3.marker_ref_matrix where cat_ref='".$cat_ref_db[$i]."'";
			// echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error43-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_affected_rows($link)>0)
			{
				$sqlx="delete from bai_pro3.marker_ref_matrix where cat_ref='".$cat_ref_db[$i]."'";
				// echo $sqlx."<br/>";
				mysqli_query($link, $sqlx) or exit("Sql Error44-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		//$sqlx="flush table pac_stat_log";
		//$sql_resultx=mysql_query($sqlx,$link) or exit("Sql Error".mysql_error()); 
		
		//Removing Recuts below 30 days
		$sqlx="insert ignore into bai_pro3.recut_v2_archive  select * from bai_pro3.recut_v2 where date<'$date' and fabric_status<5";
		mysqli_query($link, $sqlx) or exit("Sql Error35-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_affected_rows($link)>0)
		{
			$sqlx="delete from bai_pro3.recut_v2 where date<'$date' and fabric_status<5";
			echo $sqlx."<br/>";
			mysqli_query($link, $sqlx) or exit("Sql Error36-$sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
print("Job Succesfully Completed")."\n";		
?>
<?php
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
?>
