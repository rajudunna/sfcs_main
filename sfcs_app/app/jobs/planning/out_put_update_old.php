
<?php
$start_timestamp = microtime(true);
//CR# 203 / KiranG 2014-08-10
//Added new query to filer all schedule irrespective of weekly shipment plan.

ini_set('mysql.connect_timeout', 3000);
ini_set('default_socket_timeout', 3000);

?>

<?php
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	

//temp pool

// $plandoc_stat_log_cat_log_ref="temp_pool_db.".$username.date("YmdHis")."_"."plandoc_stat_log_cat_log_ref";

// $sql="create  table $plandoc_stat_log_cat_log_ref ENGINE = MyISAM select order_del_no,doc_no,act_cut_status,doc_total,act_cut_issue_status,log_update,order_tid from bai_pro3.plandoc_stat_log_cat_log_ref";
// //echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

// $packing_summary="temp_pool_db.".$username.date("YmdHis")."_"."packing_summary";

// $sql="create  table $packing_summary ENGINE = MyISAM select order_del_no,carton_act_qty,status,disp_carton_no,container,lastup,order_col_des from bai_pro3.packing_summary";
// //echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error2z".mysqli_error($GLOBALS["___mysqli_ston"]));

// $disp_mix_temp="temp_pool_db.".$username.date("YmdHis")."_"."disp_mix_temp";

// $sql="CREATE  TABLE $disp_mix_temp(fca_app bigint, app bigint, scanned bigint, order_del_no bigint) ENGINE = MyISAM";
// mysqli_query($link, $sql) or exit("Sql Error3z".mysqli_error($GLOBALS["___mysqli_ston"]));

// //$sql="create table $disp_mix_temp select fca_app,app,scanned,order_del_no from bai_pro3.disp_mix";
// $sql="insert into $disp_mix_temp select fca_app,app,scanned,order_del_no from bai_pro3.disp_mix";
// //echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error4z".mysqli_error($GLOBALS["___mysqli_ston"]));

//LOG
$myFile1 = "time_stamp_log.php";
$fh1 = fopen($myFile1, 'w') or die("can't open file");


$log_write="";
fwrite($fh1, $log_write);

?>


<?php
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

//echo date("Y-m-d",$end_date_w)."<br/>";
//echo date("Y-m-d",$start_date_w);
//$start_date_w=date("Y-m-d",$start_date_w);
//$end_date_w=date("Y-m-d",$end_date_w);

$start_date_w=date("Y-m-d",($start_date_w-(60*60*24*7)));
$end_date_w=date("Y-m-d",($end_date_w+(60*60*24*6)));

//$start_date_w=date("Y-m-d",strtotime($start_date_w,"-7 days"));
//$end_date_w=date("Y-m-d",strtotime($end_date_w,"+7 days"));

//$start_date_w="2011-10-01";
//$end_date_w="2011-12-31";

?>

<?php

$weeknumber = date("W"); 
//echo $weeknumber;

$year =date("Y");
$dates=array();
for($day=1; $day<=7; $day++)
{
    $dates[]=date('Y-m-d',strtotime($year."W".$weeknumber.$day))."\n";
}

$start_date=min($dates);
$end_date=max($dates);

?>



<body>

<?php

//set_time_limit(90000);
$table_ref="$bai_pro4.week_delivery_plan";
$table_ref2="$bai_pro3.bai_orders_db";
$table_ref3="$bai_pro3.bai_orders_db_confirm";
?>

<?php
set_time_limit(200000);
echo "<h2>Please wait while processing data!!</h2>";

// $sections=array(1,2,3,4,5,6);
// $sec_db=array("actu_sec1","actu_sec2","actu_sec3","actu_sec4","actu_sec5","actu_sec6");

// $week_star= date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-date('w'), date('Y')));
// $week_end= date('Y-m-d', mktime(0, 0, 0, date('m'), date("d") - date("w") + 6, date('Y')));

//echo date("H:i:s");
echo "Please wait while processing data!!";
	
	//$sql="select ssc_code_new,ship_tid from shipment_plan where ship_tid in (select shipment_plan_id from $table_ref) and ex_factory_date between \"$week_start\" and \"$week_end\"";
//$sql="select (size_xs+size_s+size_m+size_l+size_xl+size_xxl+size_xxxl+size_s06+size_s08+size_s10+size_s12+size_s14+size_s16+size_s18+size_s20+size_s22+size_s24+size_s26+size_s28+size_s30) as \"order\", ssc_code_new,ship_tid,schedule_no from shipment_plan_ref where ship_tid in (select shipment_plan_id from $table_ref)";

//$sql="select ord_qty_new as \"order\", ssc_code_new,ship_tid,schedule_no from shipment_plan_ref where ship_tid in (select shipment_plan_id from $table_ref) order by schedule_no";

//TO track schedules which are not in weekly delivery plan

//New Code to speedup process
$sch_to_process=array();

include("time_stamp.php");
//plan/cut/
//$log_time_stamp="2012-10-22 06:00:00";
$write='<?php $log_time_stamp="'.date("Y-m-d H").':00:00"; ?>';
//$log_time_stamp="2013-04-12 06:00:00";

//Added for avoiding dataloss in weekly delivery report
//2013-05-27
$sql="select schedule_no as sch from $bai_pro4.week_delivery_plan_ref where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" order by left(style,1)";
// echo $sql."<br/>";
$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	if($row["sch"]>0)
	{
		$sch_to_process[]=$row["sch"];
	}
	
}
$sql="select distinct order_del_no from $bai_pro3.plandoc_stat_log_cat_log_ref where log_update>='$log_time_stamp' and length(trim(both from order_del_no))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['order_del_no']>0)
	{
		$sch_to_process[]=$sql_row['order_del_no'];
	}
	
}

//$sch_to_process[]="83893";
//$sch_to_process[]="86582";

//To transfer Dispatch details to temp table
// $sql="truncate $bai_pro3.disp_mix_temp";
//echo $sql."<br/>";
//mysql_query($sql,$link) or exit("Sql Error2.1".mysql_error());

// $sql="insert into $bai_pro3.disp_mix_temp select * from bai_pro3.disp_mix";
//echo $sql."<br/>";
//mysql_query($sql,$link) or exit("Sql Error2".mysql_error());

//input/output

$sql="select distinct ims_schedule from $bai_pro3.ims_log where ims_log_date>='$log_time_stamp' and length(trim(both from ims_schedule))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	if($sql_row['ims_schedule']>0)
	{
		$sch_to_process[]=$sql_row['ims_schedule'];
	}
	
}

$sql="select distinct delivery from $bai_pro.bai_log_buf where log_time>='$log_time_stamp' and length(trim(both from delivery))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['delivery']>0)
	{
		$sch_to_process[]=$sql_row['delivery'];
	}
	
}


$sql="select distinct ims_schedule from $bai_pro3.ims_log_backup where ims_log_date>='$log_time_stamp' and length(trim(both from ims_schedule))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['ims_schedule']>0)
	{
		$sch_to_process[]=$sql_row['ims_schedule'];
	}
	
}

//FG
$sql="select distinct order_del_no from $bai_pro3.packing_summary where lastup>='$log_time_stamp' and length(trim(both from order_del_no))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['order_del_no']>0)
	{
		$sch_to_process[]=$sql_row['order_del_no'];
	}
	
}

//FCA
$sql="select distinct schedule from $bai_pro3.fca_audit_fail_db where lastup>='$log_time_stamp' and length(trim(both from schedule))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['schedule']>0)
	{
		$sch_to_process[]=$sql_row['schedule'];
	}
	
}
//Ship
$sql="select distinct ship_schedule from $bai_pro3.ship_stat_log where last_up>='$log_time_stamp' and length(trim(both from ship_schedule))>0";
// echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['ship_schedule']>0)
	{
		$sch_to_process[]=$sql_row['ship_schedule'];
	}
	
}

$sch_to_process=array_unique($sch_to_process);

//New Code to speedup process
$schedule_db=array();


//To update Speed Deliveries
$sql="select speed_schedule from $bai_pro3.speed_del_dashboard";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['speed_schedule']>0)
	{
		$schedule_db[]=$sql_row['speed_schedule'];
		$sch_to_process[]=$sql_row['speed_schedule'];
	}
	
}

//LOG
$log_write.="\nTotal Schedules Process:$username-".date("Y-m-d H:i:s");
$log_write.="\n".implode(",",$sch_to_process);
$log_write.="\nActual Process:$username-".date("Y-m-d H:i:s");
fwrite($fh1, $log_write);


//$sql="select ord_qty_new as \"order\", ssc_code_new,ship_tid,schedule_no,style,color from shipment_plan_ref where ship_tid in (select ship_tid from week_delivery_plan_ref where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\") order by schedule_no";
if(sizeof($sch_to_process)>0)
{

//$sql="select ord_qty_new as \"order\", ssc_code_new,ship_tid,schedule_no,style,color from shipment_plan_ref where schedule_no in (".implode(",",$sch_to_process).") order by schedule_no";

	$sql="select order_tid as ssc_code_new, order_del_no as schedule_no,order_style_no as style,order_col_des as color from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$sch_to_process).") order by order_del_no";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ssc_code=$sql_row['ssc_code_new'];
		$schedule=$sql_row['schedule_no'];
		$style=$sql_row['style'];
		$color=$sql_row['color'];
		
		// $ship_tid=0;
		// $sqlx12="select ship_tid from $bai_pro4.shipment_plan_ref where schedule_no=$schedule and color='$color' and style='$style'";

		// $sql_resultx12=mysqli_query($link, $sqlx12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_rowx12=mysqli_fetch_array($sql_resultx12))
		// {
		// 	$ship_tid=$sql_rowx12['ship_tid'];
		// }
		
		//TO track schedules which are not in weekly delivery plan
		$schedule_db[]=$sql_row['schedule_no'];
		
		//LOG
		fwrite($fh1, ",".$sql_row['schedule_no']);

		// $sql1="select original_order_qty,priority from $bai_pro4.week_delivery_plan where shipment_plan_id=".$ship_tid;
		// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1=mysqli_fetch_array($sql_result1))
		// {
		// 	$order=$sql_row1['original_order_qty'];
		// 	$priority_check=$sql_row1['priority'];
		// }
		
		//New to get 1% extra order qty 
		$sql1="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as order_qty from $bai_pro3.bai_orders_db_confirm where order_tid=\"$ssc_code\"";
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
        // echo $sql1."<br>";
        
		if(mysqli_num_rows($sql_result1)>0)
		{
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
					$order=$sql_row1['order_qty'];
			}
		}
		//New to get 1% extra order qty
		
		//Removed this condition to run this schedule for all deliveries 2012
		//if($priority_check!=-1)
		{
		
		//$order=$sql_row['order'];
		//NEW ORDER QTY TRACK
		
		//$sql1="select doc_no from plandoc_stat_log where order_tid=\"$ssc_code\"";
		$sql1="select doc_no from $bai_pro3.plandoc_stat_log_cat_log_ref where order_tid=\"$ssc_code\"";
		// echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$count_check=mysqli_num_rows($sql_result1);
		if($count_check>0)
		{

		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$arr[]=$sql_row1['doc_no'];
		}
		$search_string=implode(",",$arr);
		unset($arr);
		
		

		$qty_temp=0;

		//echo date("H:i:s");	
		$sql2="select bac_sec, coalesce(sum(bac_Qty),0) as \"qty\"  from $bai_pro.bai_log where delivery=\"".$schedule."\" and color=\"".$color."\" and bac_sec<>0  group by bac_sec";
		// echo "</br>".$sql2."<br/>";
		mysqli_query($link, $sql2) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$bac_sec=$sql_row2['bac_sec'];
			$qty=$sql_row2['qty'];
			$qty_temp+=$sql_row2['qty'];
		}
		
		$cut_total=0;
		$input_total=0;

		//SPEED - Online Status updates
		//echo "-".date("H:i:s");
		$sqlx1="select SUM(IF(act_cut_status=\"DONE\",doc_total,0)) AS \"cut_total\", SUM(IF(act_cut_issue_status=\"DONE\",doc_total,0)) AS \"input_total\" from $bai_pro3.plandoc_stat_log_cat_log_ref where order_tid=\"$ssc_code\"";
        //echo $sql1."<br/>";
        // echo $sqlx1."<br>";
        
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error19".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$cut_total=$sql_rowx1['cut_total'];
			$input_total=$sql_rowx1['input_total'];
		}
		
		//Recut
		
		$sqlx1="select SUM(IF(act_cut_status=\"DONE\",actual_cut_qty,0)) AS \"cut_total\" from $bai_pro3.recut_v2_summary where order_tid=\"$ssc_code\"";
        //echo $sql1."<br/>";
        // echo $sqlx1."<br>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$cut_total=$cut_total+$sql_rowx1['cut_total'];
		}
		
		//new for input to consider only given to module
		$input_total=0;
		$counter_check=0;
		$sqlx1="select coalesce(SUM(ims_qty),0) AS \"ims_qty\" from $bai_pro3.ims_log where ims_style=\"$style\" and ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0";
        //echo $sql1."<br/>";
        // echo $sqlx1."<br>";
        
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter_check+=mysqli_num_rows($sql_resultx1);
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$input_total+=$sql_rowx1['ims_qty'];
		}
		
		$sqlx1="select coalesce(SUM(ims_qty),0) AS \"ims_qty\" from $bai_pro3.ims_log_backup where ims_style=\"$style\" and ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0";
        //echo $sql1."<br/>";
        // echo $sqlx1."<br>";
        
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter_check+=mysqli_num_rows($sql_resultx1);
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$input_total+=$sql_rowx1['ims_qty'];
		}
		//new for input to consider only given to module
		
		$fcamca=0;
		$fgqty=0;
		$internal_audited=0;
		$pendingcarts=0;
		
		//echo "-".date("H:i:s");
		$sqlx1="select fca_app,app,scanned from $bai_pro3.disp_mix_temp where order_del_no=$schedule";
        $sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
        // echo $sqlx1."<br>";
        
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$fcamca=$sql_rowx1['app'];
			$fgqty=$sql_rowx1['scanned'];
			$internal_audited=$sql_rowx1['fca_app'];	
		}
		
		//Exception to check M&S
		// if(substr($style,0,1)=="M")
		// {
		// 	//$sqlx1="select coalesce(sum(carton_act_qty),0) as scanned from $packing_summary where doc_no in ($search_string) and status=\"DONE\"";
		// 	$sqlx1="select coalesce(sum(carton_act_qty),0) as scanned from bai_pro3.packing_summary where trim(BOTH from order_del_no)=\"".trim($schedule)."\" and trim(BOTH from order_col_des)=\"".trim($color)."\" and status=\"DONE\"";
		// 	echo "test:".$sqlx1."<br/>";
		// 	$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		// 	{
		// 		$fgqty=$sql_rowx1['scanned'];
		// 	}
		// }
		
		//echo "-".date("H:i:s");
		$sqlx1="select sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from $bai_pro3.packing_summary where order_del_no=$schedule and container=1";
        $sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
        // echo $sqlx1."<br>";
        
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$pendingcarts=$sql_rowx1['pendingcarts'];		
		}
		
		//echo "-".date("H:i:s")."<br/";
		$sqlx1="select distinct container, sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from $bai_pro3.packing_summary where order_del_no=$schedule and container>1";
        $sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
        // echo $sqlx1."<br>";
        
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$pendingcarts+=$sql_rowx1['pendingcarts'];		
		}
		
				
		//SPEED - Online Status updates
		
		// echo $schedule."-".$status."-";
		
		$status=6; //RM
		if($cut_total==0)
		{
			$status=6; //RM
		}
		else
		{
			if($cut_total>0 and $input_total==0)
			{
				$status=5; //Cutting
			}
			else
			{
				if($input_total>0)
				{
					$status=4; //Sewing
				}
			}
		}
		
		//Exception to check M&S
		// if(substr($style,0,1)=="M")
		// {
		// 	if($qty_temp>=$fgqty and $qty_temp>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
		// 	{
		// 		$status=2; //FG
		// 		if($internal_audited>=$fgqty)
		// 		{
		// 			$status=1;
		// 		}
		// 	} 
		// 	if($qty_temp>=$order and $qty_temp>0 and $fgqty<$order)
		// 	{
		// 		$status=3; //packing
		// 	}
		// }
		// else
		// {
			if($qty_temp>=$fgqty and $qty_temp>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
			{
				$status=2; //FG
				if($internal_audited==$fgqty)
				{
					$status=1;
				}
			} 
			if($qty_temp>=$order and $qty_temp>0 and $fgqty<$order)
			{
				$status=3; //packing
			}
		// }
		
		
		//to update dispatch status (as per internal system)
        $sqlx1="select COALESCE(sum(shipped),0) as \"shipped\" from $bai_pro3.bai_ship_cts_ref where ship_style=\"$style\" and ship_schedule=\"$schedule\"";
        // echo $sqlx1."<br>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$shipped=$sql_rowx1['shipped'];		
		}
		
		if($shipped>=$order and $status==1)
		{
			$status=-1;
		}
		
		
		echo $order."-".$cut_total."-".$input_total."-".$qty_temp."-".$fgqty."-".$internal_audited."-".$status."<br/>";
		
	
		$query_add="";
		if($counter_check>0)
		{
			$query_add=", act_in=$input_total";
		}
		
		//TO Update Orders_db
		$sql31="update $table_ref2 set act_cut=$cut_total".$query_add.", act_fca=$internal_audited, act_mca=$fcamca, act_fg=$fgqty, act_ship=$shipped, cart_pending=$pendingcarts, priority=$status, output=$qty_temp where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		// echo $sql31."-A<br/>";
		mysqli_query($link, $sql31) or exit("Sql Error29".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql3="update $table_ref3 set act_cut=$cut_total".$query_add.", act_fca=$internal_audited, act_mca=$fcamca, act_fg=$fgqty, act_ship=$shipped, cart_pending=$pendingcarts, priority=$status, output=$qty_temp where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		// echo $sql3."-A<br/>";
		if($counter_check>0)
		{
			echo "query=".$query_add."<br>";
		}
		mysqli_query($link, $sql3) or exit("Sql Error30".mysqli_error($GLOBALS["___mysqli_ston"]));
		//To Update Orders_db
		
		}
		else
		{
			//TO Update Orders_db
			$sql3="update $table_ref2 set priority=6 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			// echo $sql3."-B<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql3="update $table_ref3 set priority=6 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			// echo $sql3."-B<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"]));
			//To Update Orders_db
		}
		
		}
			
	}
	
	fwrite($fh1, "\n"."Processing 2:");
	include("out_put_update_include_old.php");
}
print(memory_get_usage())."\n";
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>


