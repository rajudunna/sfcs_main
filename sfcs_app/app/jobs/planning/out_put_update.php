
<?php
$start_timestamp = microtime(true);
//CR# 203 / KiranG 2014-08-10
//Added new query to filer all schedule irrespective of weekly shipment plan.

ini_set('mysql.connect_timeout', 3000000);
ini_set('default_socket_timeout', 3000000);

error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	

$table_ref="$bai_pro4.week_delivery_plan";
$table_ref2="$bai_pro3.bai_orders_db";
$table_ref3="$bai_pro3.bai_orders_db_confirm";

$weeknumber = date("W"); 

$year =date("Y");
$dates=array();
for($day=1; $day<=7; $day++)
{
    $dates[]=date('Y-m-d',strtotime($year."W".$weeknumber.$day))."\n";
}

$start_date=min($dates);
$end_date=max($dates);
$sql_sec="select sec_id,sec_mods from bai_pro3.sections_db where sec_id !=0";
$sql_result_sec=mysqli_query($link, $sql_sec) or exit("Sql Error sec=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_sec=mysqli_fetch_array($sql_result_sec))
{
	$module=$sql_row_sec['sec_mods'];
	$sec_id=$sql_row_sec['sec_id'];
	$update_sec="Update bai_pro.bai_log set bac_sec=$sec_id where bac_no in ($module)";
	// echo $update_sec."<br>";
	$sql_res=mysqli_query($link, $update_sec) or exit("Sql Error sec 1=".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$sql="select ship_tid,schedule_no,color,size from $bai_pro4.shipment_plan where ex_factory_date between \"".trim($start_date)."\" and  \"".trim($end_date)."\" order by schedule_no*1,color,size";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$schedule=$sql_row["schedule_no"];
	$color=$sql_row["color"];
	$size=$sql_row["size"];
	$ship_tid=$sql_row["ship_tid"];
	
	$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."'";
	// echo $sql1."<br>";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result1) > 0)
	{	
		for($i=0;$i<sizeof($sizes_array);$i++)
		{
			$sql2="select title_size_".$sizes_array[$i]." as size_ref,order_tid,order_s_".$sizes_array[$i]." order_qty from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$color."'";
			// echo $sql2."<br>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$size_ref=$sql_row2["size_ref"];
				$order_tid=$sql_row2["order_tid"];
				$order_qty=$sql_row2["order_qty"];
			}
			
			if($size_ref==$size)
			{
				$size_data=$size_ref;
				$size_data_ref=$sizes_array[$i];
				break;
			}
		}
		
		
		$update_order_qty="update bai_pro4.week_delivery_plan set original_order_qty='".$order_qty."' where shipment_plan_id='".$ship_tid."'";
		echo $update_order_qty."<br>";
		$update_data=mysqli_query($link, $update_order_qty) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($update_data){
			print("Updated week_delivery_plan Successfully")."\n";
		}
		
		$sql5="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\")";
		// echo $sql5."<br>";
		$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo mysqli_num_rows($sql_result5)."<br>";
		if(mysqli_num_rows($sql_result5) > 0)
		{
			while($sql_row5=mysqli_fetch_array($sql_result5))
			{	
				$cat_ref=$sql_row5["tid"];
				$cut_total=0;
				$sql3="select p_".$size_data_ref."*a_plies as cut_total from $bai_pro3.plandoc_stat_log where cat_ref='".$cat_ref."' and act_cut_status=\"DONE\" group by doc_no";
				// echo $sql3."<br/>";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$cut_total=$cut_total+$sql_row3['cut_total'];
				}
				
				$sql4="select p_".$size_data_ref."*a_plies as cut_total from $bai_pro3.recut_v2 where cat_ref='".$cat_ref."' and act_cut_status=\"DONE\" group by doc_no";
				// echo $sql4."<br/>";
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$cut_total=$cut_total+$sql_row4['cut_total'];
				}
				
				$input_total=0;
				$output_total=0;
				$sql5="select coalesce(SUM(ims_qty),0) AS input from $bai_pro3.ims_log where ims_schedule='".$schedule."' and ims_color='".$color."'  and ims_size='a_".$size_data_ref."'";
				// echo $sql5."<br/>";
				$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row5=mysqli_fetch_array($sql_result5))
				{
					$input_total=$input_total+$sql_row5['input'];
				}
				
				$sql6="select coalesce(SUM(ims_qty),0) AS input from $bai_pro3.ims_log_backup where ims_schedule='".$schedule."' and ims_color='".$color."'  and ims_size='a_".$size_data_ref."'";
				// echo $sql6."<br/>";
				$sql_result6=mysqli_query($link, $sql6) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row6=mysqli_fetch_array($sql_result6))
				{
					$input_total=$input_total+$sql_row6['input'];
				}
				$fcamca=0;
				$sql7="select coalesce(SUM(pcs),0) as qty from $bai_pro3.fca_audit_fail_db where schedule=$schedule and size='".$size_data_ref."' and tran_type in (1,2) and pcs > 0";
				$sql_result7=mysqli_query($link, $sql7) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row7=mysqli_fetch_array($sql_result7))
				{
					$fcamca=$sql_row7['qty'];
				}
				
				$sql8="select COALESCE(sum(ship_s_".$size_data_ref."),0) as \"shipped\" from $bai_pro3.ship_stat_log where ship_schedule='".$schedule."' and ship_color='".$color."'";
				$sql_result8=mysqli_query($link, $sql8) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row8=mysqli_fetch_array($sql_result8))
				{
					$shipped=$sql_row8['shipped'];		
				}
				
				$sql9="select sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\",SUM(IF(status=\"DONE\",carton_act_qty,0)) as fgqty from $bai_pro3.packing_summary where order_del_no=$schedule and order_col_des='".$color."' and size_code='".$size_data_ref."'";
				$sql_result9=mysqli_query($link, $sql9) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row9=mysqli_fetch_array($sql_result9))
				{
					$pendingcarts=$sql_row9['pendingcarts'];	
					$fgqty=$sql_row9['fgqty'];
				}

				$sql10="select bac_sec,COALESCE(SUM(bac_qty),0) AS output FROM $bai_pro.bai_log WHERE delivery=$schedule and color='".$color."' AND size_".$size_data_ref." >0  GROUP BY bac_no";
				$sql_result10=mysqli_query($link, $sql10) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				// echo $sql10."<br>";
				while($sql_row10=mysqli_fetch_array($sql_result10))
				{
					$bac_sec=$sql_row10['bac_sec'];	
					$output_total=$sql_row10['output'];
					$sql11="update $table_ref set actu_sec".$bac_sec."='".$output_total."' where shipment_plan_id='".$ship_tid."'";
					// echo $sql11."------A<br/>";
					$updated_data1=mysqli_query($link, $sql11) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
					if($updated_data1){
						print("Updated Quantity in ".$table_ref."successfully")."\n" ;
					}
				}

			}
		}	
		
		// echo $schedule."-".$color."-".$ship_tid."-".$size_data."-".$size_ref."-".$size."-".$size_data_ref."-".$order_tid."-".$order_qty."-".$cut_total."-".$input_total."-".$output_total."-".$fcamca."-".$shipped."-".$pendingcarts."<br>";
		
		$sql32="update $table_ref set size_comp_".$size_data_ref."='".$output_total."',act_cut='".$cut_total."',act_in='".$input_total."',act_fca='".$fcamca."', act_mca='".$fcamca."', act_fg='".$fgqty."', act_ship='".$shipped."', cart_pending='".$pendingcarts."' where shipment_plan_id='".$ship_tid."'";
		// echo $sql32."------A<br/>";
		$updated_data=mysqli_query($link, $sql32) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($updated_data){
			print("Updated ".$table_ref."successfully")."\n";
		}
	}
}

// print(memory_get_usage())."\n";
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>


