<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
?>

<body>
		<div class="panel panel-primary">
			<div class="panel-body">
<?php
    //$order_tid=$_GET['order_tid'];
    $color=$_GET['color'];
    $style=$_GET['style'];
    $schedule=$_GET['schedule'];
    $club_status=$_GET['club_status'];
    // Schedule Clubbing with in the schedule
    if($club_status=='1')
    {
		$filename='schsplit';	
    	$order_join=substr($color,-1);
    	// $order_tid_new[]=array();
		$order_tid_cols[]=array();
		$order_tid_schs[]=array();
		$url_back = getFullURLLevel($_GET['r'], "schedule_clubbing/schedule_split_bek.php", "0", "N");
		$sql1="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_joins='J$order_join' and order_del_no='$schedule'";
    }	
    // Schedule Clubbing with in the Style
    else if($club_status=='2')
	{
		$filename='mixjobs';
		$order_join=$schedule;
		// $order_tid_new[]=array();
		$order_tid_cols[]=array();
		$order_tid_schs[]=array();
		$url_back = getFullURLLevel($_GET['r'], "schedule_club_style/mix_jobs.php", "0", "N");
		$sql1="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_joins='J$order_join'";
	}		
	$result1=mysqli_query($link, $sql1) or ("Sql error777".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($ss=mysqli_fetch_array($result1))
	{
		$order_tid_new[]=$ss["order_tid"];
		$order_tid_cols[]=$ss["order_col_des"];
		$order_tid_schs[]=$ss["order_del_no"];	
	}
	$impdata = implode(',',$order_tid_new);

	for($kk=0;$kk<sizeof($order_tid_new);$kk++)
	{
		$sql="SELECT * FROM $bai_pro3.bai_orders_db_confirm as bai_orders_db_confirm LEFT JOIN $bai_pro3.plandoc_stat_log as plandoc_stat_log ON plandoc_stat_log.order_tid=bai_orders_db_confirm.order_tid WHERE bai_orders_db_confirm.order_joins not in ('1','2') AND bai_orders_db_confirm.order_tid='".$order_tid_new[$kk]."' and bai_orders_db_confirm.order_del_no='".$order_tid_schs[$kk]."' and bai_orders_db_confirm.order_col_des='".$order_tid_cols[$kk]."' GROUP BY bai_orders_db_confirm.order_col_des";
		//HAVING plan_quantity>=confirm_order_quantity"; //this will validate whether layplan has > order quantity or not
		$result=mysqli_query($link, $sql) or ("Sql error777".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $result_3."ads";
		//$check1=mysqli_num_rows($result);
		$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
		$result2=mysqli_query($link, $sizesMasterQuery) or ("Sql error778".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sizes_tmp=array();
		while($s=mysqli_fetch_array($result2))
		{
			for ($i=0; $i < sizeof($sizes_array); $i++)
			{
				if($s['size_name'] == $sizes_title[$i])
				{
					$sizes_tmp[]=$s['id'];
				}
			}

		}				
		echo '<h3><font face="verdana" color="green">Please wait <br> Docket details are Synchronizing...</font></h3>';
		while($r=mysqli_fetch_array($result))
		{
			$order_tid=$r['order_tid'];
			$style_code=$r['order_style_no'];
			$product_schedule=$r['order_del_no'];
			$c_block=$r['zfeature'];
			$color_code=$r['order_col_des'];
			$bts_status=$r['bts_status'];
			$col_code=$r['color_code'];
			//get Style code from product Master
			$productsQuery=echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style_code,$link);
			if($productsQuery>0)
			{
				$style_id=$productsQuery;
			}
			else
			{
				$insertStyleCode="INSERT IGNORE INTO $brandix_bts.tbl_orders_style_ref(product_style) VALUES ('$style_code')";
				$result3=mysqli_query($link, $insertStyleCode) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$style_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			}
			//get Schedule code from product Master
			$productsQuery=echo_title("$brandix_bts.tbl_orders_master","id","ref_product_style='".$style_id."' and product_schedule",$product_schedule,$link);
			if($productsQuery>0 || $productsQuery!='')
			{
				$order_id=$productsQuery;
			}
			else
			{
				$insertOrdersMaster="INSERT INTO $brandix_bts.tbl_orders_master(ref_product_style, product_schedule,order_status) VALUES ('".$style_id."','".$product_schedule."', 'OPEN')";
				$result6=mysqli_query($link, $insertOrdersMaster) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$order_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			}
			for ($i=0; $i < sizeof($sizes_array); $i++)
			{
				$orderS="order_s_".$sizes_array[$i]."";
				$oldOrderS="old_order_s_".$sizes_array[$i]."";
				$test= 'title_size_'.$sizes_array[$i].'';
				if($r["order_s_".$sizes_array[$i].""]>0)
				{
					$insertSizesQuery="INSERT IGNORE INTO $brandix_bts.tbl_orders_sizes_master(parent_id, ref_size_name, size_title, order_quantity, order_act_quantity,order_col_des) VALUES ($order_id,'".$sizes_tmp[$i]."','".$r["title_size_".$sizes_array[$i].""]."','".$r["order_s_".$sizes_array[$i].""]."',".$r["order_s_".$sizes_array[$i].""].",'".$color_code."')";
					$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					//$sql11="insert ignore into $bai3_finishing.order_db (style_no, schedule_no, size_code, color, order_qty, output, c_block, ex_date) values ('".$style_code."', '".$product_schedule."', '".$r["title_size".$sizes_array[$i].""]."', '".$color_code."', '".$r["order_s_".$sizes_array[$i].""]."', '0', '".$c_block."', '".$r['order_date']."')";
					// echo $insertSizesQuery."</br>".$sql11;
				}
			}			
		}	
		//get Lay plan data from plandoc_stat_log table and insert it into tbl_cut_master and tbl_cut_size_master
		$layPlanQuery="SELECT plandoc_stat_log.*,cat_stat_log.category FROM $bai_pro3.plandoc_stat_log as plandoc_stat_log
		LEFT JOIN $bai_pro3.cat_stat_log as cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid
		WHERE cat_stat_log.category IN ($in_categories) AND  plandoc_stat_log.order_tid='$order_tid_new[$kk]'";
		//echo $layPlanQuery."<br>";
		$result7=mysqli_query($link, $layPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($l=mysqli_fetch_array($result7))
		{
			$doc_num=$l['doc_no'];
			$cut_num=$l['acutno'];
			$cut_status=$l['act_cut_status'];
			$planned_module=$l['plan_module'];
			if($planned_module==NULL)
			{
				$planned_module=0;
			}
			$request_time=$l['rm_date'];
			$issued_time=$l['date'];
			$planned_plies=$l['p_plies'];
			$actual_plies=$l['a_plies'];
			$plan_date=$l['date'];
			$cat_ref=$l['cat_ref'];
			$mk_ref=$l['mk_ref'];
			$cuttable_ref=$l['cuttable_ref'];
			//Insert data into layplan(tbl_cut_master) table
			$inserted_id_query1 = "select count(id) as id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
			$inserted_id_result1=mysqli_query($link, $inserted_id_query1) or ("Sql error1111");
			while($inserted_id_details1=mysqli_fetch_array($inserted_id_result1))
			{
				$layplan_id1=$inserted_id_details1['id'];
			}
			if($layplan_id1==0)
			{
				$insertLayPlanQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,request_time,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES	('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$request_time','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style_id,'$product_schedule',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
				// echo $insertLayPlanQuery."</br>";
				$result8=mysqli_query($link, $insertLayPlanQuery) or ("Sql error999".mysqli_error($GLOBALS["___mysqli_ston"]));
				$inserted_id_query = "select id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
				$inserted_id_result=mysqli_query($link, $inserted_id_query) or ("Sql error1111");
				while($inserted_id_details=mysqli_fetch_array($inserted_id_result))
				{
					$layplan_id=$inserted_id_details['id'];
				}
				//Insert data into layplan reference table (tbl_cut_size_master)
				for ($i=0; $i < sizeof($sizes_array); $i++)
				{
					if($l["p_".$sizes_array[$i].""]>0)
					{
					 	$insertLayplanItemsQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."','".$layplan_id."','".$sizes_tmp[$i]."','".$l["p_".$sizes_array[$i].""]."')";
						 // echo $insertLayplanItemsQuery."</br>";
					 	$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

					}
				}
			}
		}
		$update_query="update $bai_pro3.bai_orders_db_confirm set bts_status=2 where order_tid='".$order_tid_new[$kk]."'";
		$result10=mysqli_query($link, $update_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
			function Redirect() {
				location.href = \"".getFullURLLevel($_GET['r'], 'production/controllers/sewing_job/sewing_job_mo_fill.php',2,'N')."&order_tid_arr=$impdata&club=clubbing&process_name=cutting&filename=$filename\";
				}
			</script>";
	
    // echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
		// function Redirect() {
			// sweetAlert('Splitting Completed','','success');
			// location.href = \"".$url_back."&color=$color&style=$style&schedule=$schedule\";
			// }
		// </script>";	
?>
</div>
</div>
