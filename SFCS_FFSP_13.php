<?php
$include_path=getenv('localhost/xampp/sfcs_main/configuration');
include($include_path.'\sfcs_app\common\config\config.php');

	$conn = odbc_connect($conn_string,$user_ms,$password_ms);
	error_reporting(0);

	
    $get_details="select order_style_no,order_del_no,order_col_des from bai_pro3.bai_orders_db_confirm";
	echo $get_details;
	$result=mysqli_query($link, $get_details) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row = mysqli_fetch_array($result))
	{
		$schedule =$row['order_del_no'];
		$color = $row['order_col_des'];
		$style= $row['order_style_no'];
	
		IF(strlen($color)>0)
		{
			
				$sqlstr='SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no IN ("'.$schedule.'") and 
				order_style_no IN ("'.$style.'") and IF(TRIM(BOTH FROM order_col_des) LIKE "%***%",SUBSTRING_INDEX(TRIM(BOTH FROM order_col_des),"***",-1),TRIM(BOTH FROM order_col_des))="'.$color.'" group by order_del_no order by order_del_no';
				echo $sqlstr."<br>";
		}
		ELSE
		{
			
				$sqlstr='SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no IN ("'.$schedule.'") group by order_del_no order by order_del_no';
				echo $sqlstr."<br>";
		}
		IF($lay_plan_status='1')
		{	
				$lay_plan_status='DONE';
				
		}	
		ELSE
		{	
				$lay_plan_status='NOT DONE';
			
		}		
				
		IF(strlen($color)>0)
		{	
				$sqlstr4='SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ("'.$schedule.'") and 
				order_style_no IN ("'.$style.'") and IF(TRIM(BOTH FROM order_col_des) LIKE "%***%",SUBSTRING_INDEX(TRIM(BOTH FROM order_col_des),"***",-1),TRIM(BOTH FROM order_col_des))= "'.$color.'" AND category IN ("Body","Front") AND plan_module>0';
				echo $sqlstr4."<br>";
		}	
		ELSE
		{	
				$sqlstr4='SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ("'.$schedule.'") AND category IN ("Body","Front") AND plan_module>0';
				echo $sqlstr4."<br>";
			
		}
		IF(strlen($color)>0)
		{	
				$sqlstr5='SELECT $pcd_date=min(production_date) FROM [BEB_DBS_RMW_0001].[dbo].[T_0001_002_FRPLAN] 
				where schedule="'.$schedule.'" and order_style_no = "'.$style.'" and color="'.$color.'"';
				echo $sqlstr5."<br>";
				
		}	
		ELSE
		{	
				$sqlstr5='SELECT $pcd_date=min(production_date) FROM [BEB_DBS_RMW_0001].[dbo].[T_0001_002_FRPLAN] where schedule="'.$schedule.'"';
				
		}
		IF($planned_jobs='')
		{
			$planned_jobs=0;
		}
		
		IF(strlen($color)>0)
		{
				$sqlstr='SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ("'.$schedule.'") and 
				order_style_no IN ("'.$style.'") and IF(TRIM(BOTH FROM order_col_des) LIKE "%***%",SUBSTRING_INDEX(TRIM(BOTH FROM order_col_des),"***",-1),TRIM(BOTH FROM order_col_des))="'.$color.'" AND category IN ("Body","Front")';
		}	
		ELSE
		{	
				$sqlstr='SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ("'.$schedule.'") AND category IN ("Body","Front")';
		}
		IF($total_jobs='')
		{
			$total_jobs=0;
		}
		
		IF(LEN($color)>0)
		{
				$sqlstr='SELECT cast(SUM(act_in) as signed) AS value FROM BAI_PRO3.bai_orders_db WHERE order_del_no IN ("'.$schedule.'") and 
				order_style_no IN ("'.$style.'") and IF(TRIM(BOTH FROM order_col_des) LIKE "%***%",SUBSTRING_INDEX(TRIM(BOTH FROM order_col_des),"***",-1),TRIM(BOTH FROM order_col_des))="'.$color.'" ';
		}	
		ELSE
			
				$sqlstr='SELECT cast(SUM(act_in) as signed) AS value FROM BAI_PRO3.bai_orders_db WHERE order_del_no IN ("'.$schedule.'")';
				
				
		IF($input_qty='')
		{
			$input_qty=0;
		}

		IF($input_qty>=$order_qty)
			
				$input_status='DONE';
			
		ELSE IF($input_qty>0)
			
				$input_status='PROGRESS';
			
		ELSE 
			 
				$input_status='PING';
				
		
		IF($color>0)
			
				$sqlstr='select min(ratio) as value from BAI_PRO3.allocate_stat_log where order_tid in (select order_tid from bai_pro3.bai_orders_db where order_del_no in ("'.$schedule.'") and 
				order_style_no IN ("'.$style.'") and IF(TRIM(BOTH FROM order_col_des) LIKE "%***%",SUBSTRING_INDEX(TRIM(BOTH FROM order_col_des),"***",-1),TRIM(BOTH FROM order_col_des))="'.$color.'")';
			
		ELSE
			
				$sqlstr='select min(ratio) as value from BAI_PRO3.allocate_stat_log where order_tid in (select order_tid from bai_pro3.bai_orders_db where order_del_no in ("'.$schedule.'"))';
			
		
		
		IF($color>0)
		{
				$sqlstr='SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no IN ("'.$schedule.'") and 
				order_style_no IN ("'.$style.'") and IF(TRIM(BOTH FROM order_col_des) LIKE "%***%",SUBSTRING_INDEX(TRIM(BOTH FROM order_col_des),"***",-1),TRIM(BOTH FROM order_col_des))="'.$color.'" group by order_del_no';
				echo $sqlstr."<br>";
		}			
		ELSE
		{
			
				$sqlstr='SELECT COUNT(DISTINCT order_del_no) as value FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no IN ("'.$schedule.'") group by order_del_no';
				echo $sqlstr."<br>";
		}	
		
		if($lay_done='1')
		{
		 $lay_done='DONE';
		}
		else
		{
		 $lay_done='NOT DONE';
		}
		
		$sqlc='SELECT $count1 as COUNT(*) FROM [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration WHERE Schedule=$schedule and ColorId=$color';
		print ("$count1");
		if($count1=0)
		{
			$sql2='insert [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration(Schedule,FactoryId,ColorId,PCD,LayPlanPrepStatusDesc,NoOfCutJobs,LayPlanGenerationStatusDesc,InputStatusDesc,NoOfJobsPlanned) values($schedule,$facility_code,$color,$pcd_date,$lay_done,CAST ($total_jobs as VARCHAR(MAX)),$lay_plan_status,CAST ($input_status as VARCHAR(MAX)),CAST ($planned_jobs as VARCHAR(MAX)))';
			echo $sql2."<br>";
			
		}
		else
		{	
			$sql2='update [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration set LayPlanGenerationStatusDesc=$lay_done,NoOfJobsPlanned=$planned_jobs,NoOfCutJobs=CAST ($total_jobs as VARCHAR(MAX)),LayPlanPrepStatusDesc=$lay_plan_status,InputStatusDesc=CAST ($input_status as VARCHAR(MAX)),PCD=$pcd_date where Schedule=$schedule AND ColorId=$color';
			echo $sql2."<br>";
			
		}		
		$i=$i1;
	}

?>