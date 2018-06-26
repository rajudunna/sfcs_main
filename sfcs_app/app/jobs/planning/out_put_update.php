
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

$plandoc_stat_log_cat_log_ref="temp_pool_db.".$username.date("YmdHis")."_"."plandoc_stat_log_cat_log_ref";

$sql="create  table $plandoc_stat_log_cat_log_ref ENGINE = MyISAM select order_del_no,doc_no,act_cut_status,doc_total,act_cut_issue_status,log_update,order_tid from bai_pro3.plandoc_stat_log_cat_log_ref";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

$packing_summary="temp_pool_db.".$username.date("YmdHis")."_"."packing_summary";

$sql="create  table $packing_summary ENGINE = MyISAM select order_del_no,carton_act_qty,status,disp_carton_no,container,lastup,order_col_des from bai_pro3.packing_summary";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error2z".mysqli_error($GLOBALS["___mysqli_ston"]));

$disp_mix_temp="temp_pool_db.".$username.date("YmdHis")."_"."disp_mix_temp";

$sql="CREATE  TABLE $disp_mix_temp(fca_app bigint, app bigint, scanned bigint, order_del_no bigint) ENGINE = MyISAM";
mysqli_query($link, $sql) or exit("Sql Error3z".mysqli_error($GLOBALS["___mysqli_ston"]));

//$sql="create table $disp_mix_temp select fca_app,app,scanned,order_del_no from bai_pro3.disp_mix";
$sql="insert into $disp_mix_temp select fca_app,app,scanned,order_del_no from bai_pro3.disp_mix";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error4z".mysqli_error($GLOBALS["___mysqli_ston"]));

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
$table_ref="bai_pro4.week_delivery_plan";
$table_ref2="bai_pro3.bai_orders_db";
$table_ref3="bai_pro3.bai_orders_db_confirm";
?>

<?php
set_time_limit(200000);
echo "<h2>Please wait while processing data!!</h2>";

$sections=array(1,2,3,4,5,6);
$sec_db=array("actu_sec1","actu_sec2","actu_sec3","actu_sec4","actu_sec5","actu_sec6");

$week_star= date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-date('w'), date('Y')));
$week_end= date('Y-m-d', mktime(0, 0, 0, date('m'), date("d") - date("w") + 6, date('Y')));

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
$sql="select schedule_no as sch from bai_pro4.week_delivery_plan_ref where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" order by left(style,1)";
//echo $sql;
$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	if($row["sch"]>0)
	{
		$sch_to_process[]=$row["sch"];
	}
	
}
$sql="select distinct order_del_no from bai_pro3.plandoc_stat_log_cat_log_ref where log_update>='$log_time_stamp' and length(trim(both from order_del_no))>0";
//echo $sql."<br/>";
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
$sql="truncate bai_pro3.disp_mix_temp";
//echo $sql."<br/>";
//mysql_query($sql,$link) or exit("Sql Error2.1".mysql_error());

$sql="insert into bai_pro3.disp_mix_temp select * from bai_pro3.disp_mix";
//echo $sql."<br/>";
//mysql_query($sql,$link) or exit("Sql Error2".mysql_error());

//input/output

$sql="select distinct ims_schedule from bai_pro3.ims_log where ims_log_date>='$log_time_stamp' and length(trim(both from ims_schedule))>0";
//echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	if($sql_row['ims_schedule']>0)
	{
		$sch_to_process[]=$sql_row['ims_schedule'];
	}
	
}

$sql="select distinct delivery from bai_pro.bai_log_buf where log_time>='$log_time_stamp' and length(trim(both from delivery))>0";
//echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['delivery']>0)
	{
		$sch_to_process[]=$sql_row['delivery'];
	}
	
}


$sql="select distinct ims_schedule from bai_pro3.ims_log_backup where ims_log_date>='$log_time_stamp' and length(trim(both from ims_schedule))>0";
//echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['ims_schedule']>0)
	{
		$sch_to_process[]=$sql_row['ims_schedule'];
	}
	
}

//FG
$sql="select distinct order_del_no from bai_pro3.packing_summary where lastup>='$log_time_stamp' and length(trim(both from order_del_no))>0";
//echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['order_del_no']>0)
	{
		$sch_to_process[]=$sql_row['order_del_no'];
	}
	
}

//FCA
$sql="select distinct schedule from bai_pro3.fca_audit_fail_db where lastup>='$log_time_stamp' and length(trim(both from schedule))>0";
//echo $sql."<br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['schedule']>0)
	{
		$sch_to_process[]=$sql_row['schedule'];
	}
	
}
//Ship
$sql="select distinct ship_schedule from bai_pro3.ship_stat_log where last_up>='$log_time_stamp' and length(trim(both from ship_schedule))>0";
//echo $sql."<br/>";
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
$sql="select speed_schedule from bai_pro3.speed_del_dashboard";
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

$sql="select order_tid as ssc_code_new, order_del_no as schedule_no,order_style_no as style,order_col_des as color from bai_pro3.bai_orders_db where order_del_no in (".implode(",",$sch_to_process).") order by order_del_no";

	//echo $sql;
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		//$ssc_code=substr($sql_row['ssc_code'],0,-9);
		$ssc_code=$sql_row['ssc_code_new'];

		//$ship_tid=$sql_row['ship_tid'];
		
		
		
		
		$schedule=$sql_row['schedule_no'];
		$style=$sql_row['style'];
		$color=$sql_row['color'];
		
		$ship_tid=0;
		$sqlx12="select ship_tid from bai_pro4.shipment_plan_ref where schedule_no=$schedule and color='$color' and style='$style'";

		$sql_resultx12=mysqli_query($link, $sqlx12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx12=mysqli_fetch_array($sql_resultx12))
		{
			$ship_tid=$sql_rowx12['ship_tid'];
		}
		
		//TO track schedules which are not in weekly delivery plan
		$schedule_db[]=$sql_row['schedule_no'];
		
		//LOG
		fwrite($fh1, ",".$sql_row['schedule_no']);
		
		//if($priority_check!=-1)
		
		//NEW ORDER QTY TRACK
		/* $sql1="select * from bai_pro4.shipfast_sum where shipment_plan_id=".$ship_tid;
		$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		while($sql_row1=mysql_fetch_array($sql_result1))
		{
			$size_xs1=$sql_row1['size_xs'];
			$size_s1=$sql_row1['size_s'];
			$size_m1=$sql_row1['size_m'];
			$size_l1=$sql_row1['size_l'];
			$size_xl1=$sql_row1['size_xl'];
			$size_xxl1=$sql_row1['size_xxl'];
			$size_xxxl1=$sql_row1['size_xxxl'];
			$size_s061=$sql_row1['size_s06'];
			$size_s081=$sql_row1['size_s08'];
			$size_s101=$sql_row1['size_s10'];
			$size_s121=$sql_row1['size_s12'];
			$size_s141=$sql_row1['size_s14'];
			$size_s161=$sql_row1['size_s16'];
			$size_s181=$sql_row1['size_s18'];
			$size_s201=$sql_row1['size_s20'];
			$size_s221=$sql_row1['size_s22'];
			$size_s241=$sql_row1['size_s24'];
			$size_s261=$sql_row1['size_s26'];
			$size_s281=$sql_row1['size_s28'];
			$size_s301=$sql_row1['size_s30'];
			
		}
		$order=$size_xs1+$size_s1+$size_m1+$size_l1+$size_xl1+$size_xxl1+$size_xxxl1+$size_s061+$size_s081+$size_s101+$size_s121+$size_s141+$size_s161+$size_s181+$size_s201+$size_s221+$size_s241+$size_s261+$size_s281+$size_s301; */

		$sql1="select original_order_qty,priority from bai_pro4.week_delivery_plan where shipment_plan_id=".$ship_tid;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$order=$sql_row1['original_order_qty'];
			$priority_check=$sql_row1['priority'];
		}
		
		//New to get 1% extra order qty 
		$sql1="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as order_qty from bai_pro3.bai_orders_db_confirm where order_tid=\"$ssc_code\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result1)>0)
		{
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				if($sql_row1['order_qty']>$order)
				{
					$order=$sql_row1['order_qty'];
					$sql1x="update bai_pro4.week_delivery_plan set original_order_qty=$order where shipment_plan_id=".$ship_tid;
					mysqli_query($link, $sql1x) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
		//New to get 1% extra order qty
		
		//Removed this condition to run this schedule for all deliveries 2012
		//if($priority_check!=-1)
		{
		
		//$order=$sql_row['order'];
		//NEW ORDER QTY TRACK
		
		//$sql1="select doc_no from plandoc_stat_log where order_tid=\"$ssc_code\"";
		$sql1="select doc_no from bai_pro3.plandoc_stat_log_cat_log_ref where order_tid=\"$ssc_code\"";
		//echo $sql1."<br/>";
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
		
		
		$size_xs=0;
		$size_s=0;
		$size_m=0;
		$size_l=0;
		$size_xl=0;
		$size_xxl=0;
		$size_xxxl=0;
		$size01 = 0;
		$size02 = 0;
		$size03 = 0;
		$size04 = 0;
		$size05 = 0;
		$size06 = 0;
		$size07 = 0;
		$size08 = 0;
		$size09 = 0;
		$size10 = 0;
		$size11 = 0;
		$size12 = 0;
		$size13 = 0;
		$size14 = 0;
		$size15 = 0;
		$size16 = 0;
		$size17 = 0;
		$size18 = 0;
		$size19 = 0;
		$size20 = 0;
		$size21 = 0;
		$size22 = 0;
		$size23 = 0;
		$size24 = 0;
		$size25 = 0;
		$size26 = 0;
		$size27 = 0;
		$size28 = 0;
		$size29 = 0;
		$size30 = 0;
		$size31 = 0;
		$size32 = 0;
		$size33 = 0;
		$size34 = 0;
		$size35 = 0;
		$size36 = 0;
		$size37 = 0;
		$size38 = 0;
		$size39 = 0;
		$size40 = 0;
		$size41 = 0;
		$size42 = 0;
		$size43 = 0;
		$size44 = 0;
		$size45 = 0;
		$size46 = 0;
		$size47 = 0;
		$size48 = 0;
		$size49 = 0;
		$size50 = 0;

		$qty_temp=0;

		//echo date("H:i:s");	
		$sql2="select bac_sec, coalesce(sum(bac_Qty),0) as \"qty\", coalesce(sum(size_xs),0) as \"size_xs\", coalesce(sum(size_s),0) as \"size_s\", coalesce(sum(size_m),0) as \"size_m\", coalesce(sum(size_l),0) as \"size_l\", coalesce(sum(size_xl),0) as \"size_xl\", coalesce(sum(size_xxl),0) as \"size_xxl\", coalesce(sum(size_xxxl),0) as \"size_xxxl\", coalesce(sum(size_s01),0) as \"size_s01\",coalesce(sum(size_s02),0) as \"size_s02\",coalesce(sum(size_s03),0) as \"size_s03\",coalesce(sum(size_s04),0) as \"size_s04\",coalesce(sum(size_s05),0) as \"size_s05\",coalesce(sum(size_s06),0) as \"size_s06\",coalesce(sum(size_s07),0) as \"size_s07\",coalesce(sum(size_s08),0) as \"size_s08\",coalesce(sum(size_s09),0) as \"size_s09\",coalesce(sum(size_s10),0) as \"size_s10\",coalesce(sum(size_s11),0) as \"size_s11\",coalesce(sum(size_s12),0) as \"size_s12\",coalesce(sum(size_s13),0) as \"size_s13\",coalesce(sum(size_s14),0) as \"size_s14\",coalesce(sum(size_s15),0) as \"size_s15\",coalesce(sum(size_s16),0) as \"size_s16\",coalesce(sum(size_s17),0) as \"size_s17\",coalesce(sum(size_s18),0) as \"size_s18\",coalesce(sum(size_s19),0) as \"size_s19\",coalesce(sum(size_s20),0) as \"size_s20\",coalesce(sum(size_s21),0) as \"size_s21\",coalesce(sum(size_s22),0) as \"size_s22\",coalesce(sum(size_s23),0) as \"size_s23\",coalesce(sum(size_s24),0) as \"size_s24\",coalesce(sum(size_s25),0) as \"size_s25\",coalesce(sum(size_s26),0) as \"size_s26\",coalesce(sum(size_s27),0) as \"size_s27\",coalesce(sum(size_s28),0) as \"size_s28\",coalesce(sum(size_s29),0) as \"size_s29\",coalesce(sum(size_s30),0) as \"size_s30\",coalesce(sum(size_s31),0) as \"size_s31\",coalesce(sum(size_s32),0) as \"size_s32\",coalesce(sum(size_s33),0) as \"size_s33\",coalesce(sum(size_s34),0) as \"size_s34\",coalesce(sum(size_s35),0) as \"size_s35\",coalesce(sum(size_s36),0) as \"size_s36\",coalesce(sum(size_s37),0) as \"size_s37\",coalesce(sum(size_s38),0) as \"size_s38\",coalesce(sum(size_s39),0) as \"size_s39\",coalesce(sum(size_s40),0) as \"size_s40\",coalesce(sum(size_s41),0) as \"size_s41\",coalesce(sum(size_s42),0) as \"size_s42\",coalesce(sum(size_s43),0) as \"size_s43\",coalesce(sum(size_s44),0) as \"size_s44\",coalesce(sum(size_s45),0) as \"size_s45\",coalesce(sum(size_s46),0) as \"size_s46\",coalesce(sum(size_s47),0) as \"size_s47\",coalesce(sum(size_s48),0) as \"size_s48\",coalesce(sum(size_s49),0) as \"size_s49\",coalesce(sum(size_s50),0) as \"size_s50\" from $bai_pro.bai_log where ims_doc_no in ($search_string) and bac_sec<>0 group by bac_sec";
		//echo $sql2."<br/>";
		mysqli_query($link, $sql2) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$size_xs+=$sql_row2['size_xs'];
			$size_s+=$sql_row2['size_s'];
			$size_m+=$sql_row2['size_m'];
			$size_l+=$sql_row2['size_l'];
			$size_xl+=$sql_row2['size_xl'];
			$size_xxl+=$sql_row2['size_xxl'];
			$size_xxxl+=$sql_row2['size_xxxl'];
			$size_s01+=$sql_row2['size_s01'];
			$size_s02+=$sql_row2['size_s02'];
			$size_s03+=$sql_row2['size_s03'];
			$size_s04+=$sql_row2['size_s04'];
			$size_s05+=$sql_row2['size_s05'];
			$size_s06+=$sql_row2['size_s06'];
			$size_s07+=$sql_row2['size_s07'];
			$size_s08+=$sql_row2['size_s08'];
			$size_s09+=$sql_row2['size_s09'];
			$size_s10+=$sql_row2['size_s10'];
			$size_s11+=$sql_row2['size_s11'];
			$size_s12+=$sql_row2['size_s12'];
			$size_s13+=$sql_row2['size_s13'];
			$size_s14+=$sql_row2['size_s14'];
			$size_s15+=$sql_row2['size_s15'];
			$size_s16+=$sql_row2['size_s16'];
			$size_s17+=$sql_row2['size_s17'];
			$size_s18+=$sql_row2['size_s18'];
			$size_s19+=$sql_row2['size_s19'];
			$size_s20+=$sql_row2['size_s20'];
			$size_s21+=$sql_row2['size_s21'];
			$size_s22+=$sql_row2['size_s22'];
			$size_s23+=$sql_row2['size_s23'];
			$size_s24+=$sql_row2['size_s24'];
			$size_s25+=$sql_row2['size_s25'];
			$size_s26+=$sql_row2['size_s26'];
			$size_s27+=$sql_row2['size_s27'];
			$size_s28+=$sql_row2['size_s28'];
			$size_s29+=$sql_row2['size_s29'];
			$size_s30+=$sql_row2['size_s30'];
			$size_s31+=$sql_row2['size_s31'];
			$size_s32+=$sql_row2['size_s32'];
			$size_s33+=$sql_row2['size_s33'];
			$size_s34+=$sql_row2['size_s34'];
			$size_s35+=$sql_row2['size_s35'];
			$size_s36+=$sql_row2['size_s36'];
			$size_s37+=$sql_row2['size_s37'];
			$size_s38+=$sql_row2['size_s38'];
			$size_s39+=$sql_row2['size_s39'];
			$size_s40+=$sql_row2['size_s40'];
			$size_s41+=$sql_row2['size_s41'];
			$size_s42+=$sql_row2['size_s42'];
			$size_s43+=$sql_row2['size_s43'];
			$size_s44+=$sql_row2['size_s44'];
			$size_s45+=$sql_row2['size_s45'];
			$size_s46+=$sql_row2['size_s46'];
			$size_s47+=$sql_row2['size_s47'];
			$size_s48+=$sql_row2['size_s48'];
			$size_s49+=$sql_row2['size_s49'];
			$size_s50+=$sql_row2['size_s50'];
	
			$bac_sec=$sql_row2['bac_sec'];
			$qty=$sql_row2['qty'];
			$qty_temp+=$sql_row2['qty'];
			
			$sql3="update $table_ref set actu_sec".$bac_sec."=$qty where shipment_plan_id=$ship_tid";
			mysqli_query($link, $sql3) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		
		$cut_total=0;
		$input_total=0;

		//SPEED - Online Status updates
		//echo "-".date("H:i:s");
		$sqlx1="select SUM(IF(act_cut_status=\"DONE\",doc_total,0)) AS \"cut_total\", SUM(IF(act_cut_issue_status=\"DONE\",doc_total,0)) AS \"input_total\" from bai_pro3.plandoc_stat_log_cat_log_ref where order_tid=\"$ssc_code\"";
		//echo $sql1."<br/>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error19".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$cut_total=$sql_rowx1['cut_total'];
			$input_total=$sql_rowx1['input_total'];
		}
		
		//Recut
		
		$sqlx1="select SUM(IF(act_cut_status=\"DONE\",actual_cut_qty,0)) AS \"cut_total\" from bai_pro3.recut_v2_summary where order_tid=\"$ssc_code\"";
		//echo $sql1."<br/>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$cut_total=$cut_total+$sql_rowx1['cut_total'];
		}
		
		//new for input to consider only given to module
		$input_total=0;
		$counter_check=0;
		$sqlx1="select coalesce(SUM(ims_qty),0) AS \"ims_qty\" from bai_pro3.ims_log where ims_style=\"$style\" and ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0";
		//echo $sql1."<br/>";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
		$counter_check+=mysqli_num_rows($sql_resultx1);
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$input_total+=$sql_rowx1['ims_qty'];
		}
		
		$sqlx1="select coalesce(SUM(ims_qty),0) AS \"ims_qty\" from bai_pro3.ims_log_backup where ims_style=\"$style\" and ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0";
		//echo $sql1."<br/>";
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
		$sqlx1="select fca_app,app,scanned from bai_pro3.disp_mix_temp where order_del_no=$schedule";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$pendingcarts=$sql_rowx1['pendingcarts'];		
		}
		
		//echo "-".date("H:i:s")."<br/";
		$sqlx1="select distinct container, sum(if(status is null and disp_carton_no=1,1,0)) as \"pendingcarts\" from $bai_pro3.packing_summary where order_del_no=$schedule and container>1";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$shipped=$sql_rowx1['shipped'];		
		}
		
		if($shipped>=$order and $status==1)
		{
			$status=-1;
		}
		
		
		// echo $order."-".$cut_total."-".$input_total."-".$qty_temp."-".$fgqty."-".$internal_audited."-".$status."<br/>";
		
	
		$query_add="";
		if($counter_check>0)
		{
			$query_add=", act_in=$input_total";
		}
		
		$sql32="update $table_ref set size_comp_xs='$size_xs', size_comp_s='$size_s', size_comp_m='$size_m', size_comp_l='$size_l', size_comp_xl='$size_xl', size_comp_xxl='$size_xxl', size_comp_xxxl='$size_xxxl', size_comp_s01='$size_s01', size_comp_s02='$size_s02', size_comp_s03='$size_s03', size_comp_s04='$size_s04', size_comp_s05='$size_s05', size_comp_s06='$size_s06', size_comp_s07='$size_s07', size_comp_s08='$size_s08', size_comp_s09='$size_s09', size_comp_s10='$size_s10', size_comp_s11='$size_s11', size_comp_s12='$size_s12', size_comp_s13='$size_s13', size_comp_s14='$size_s14', size_comp_s15='$size_s15', size_comp_s16='$size_s16', size_comp_s17='$size_s17', size_comp_s18='$size_s18', size_comp_s19='$size_s19', size_comp_s20='$size_s20', size_comp_s21='$size_s21', size_comp_s22='$size_s22', size_comp_s23='$size_s23', size_comp_s24='$size_s24', size_comp_s25='$size_s25', size_comp_s26='$size_s26', size_comp_s27='$size_s27', size_comp_s28='$size_s28', size_comp_s29='$size_s29', size_comp_s30='$size_s30', size_comp_s31='$size_s31', size_comp_s32='$size_s32', size_comp_s33='$size_s33', size_comp_s34='$size_s34', size_comp_s35='$size_s35', size_comp_s36='$size_s36', size_comp_s37='$size_s37', size_comp_s38='$size_s38', size_comp_s39='$size_s39', size_comp_s40='$size_s40', size_comp_s41='$size_s41', size_comp_s42='$size_s42', size_comp_s43='$size_s43', size_comp_s44='$size_s44', size_comp_s45='$size_s45', size_comp_s46='$size_s46', size_comp_s47='$size_s47', size_comp_s48='$size_s48', size_comp_s49='$size_s49', size_comp_s50='$size_s50', act_cut='$cut_total'".$query_add.", act_fca='$internal_audited', act_mca='$fcamca', act_fg='$fgqty', act_ship='$shipped', cart_pending='$pendingcarts', priority='$status' where shipment_plan_id=$ship_tid";
		// echo $sql32."-A<br/>";
		mysqli_query($link, $sql32) or exit("Sql Error28".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//TO Update Orders_db
		$sql31="update $table_ref2 set act_cut=$cut_total".$query_add.", act_fca=$internal_audited, act_mca=$fcamca, act_fg=$fgqty, act_ship=$shipped, cart_pending=$pendingcarts, priority=$status, output=$qty_temp where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		//echo $sql31."-A<br/>";
		mysqli_query($link, $sql31) or exit("Sql Error29".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql3="update $table_ref3 set act_cut=$cut_total".$query_add.", act_fca=$internal_audited, act_mca=$fcamca, act_fg=$fgqty, act_ship=$shipped, cart_pending=$pendingcarts, priority=$status, output=$qty_temp where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		//echo $sql3."-A<br/>";
		if($counter_check>0)
		{
			echo "query=".$query_add."<br>";
		}
		mysqli_query($link, $sql3) or exit("Sql Error30".mysqli_error($GLOBALS["___mysqli_ston"]));
		//To Update Orders_db
		
		}
		else
		{
			$sql3="update $table_ref set priority=6 where shipment_plan_id=$ship_tid";
		// echo $sql3."-B<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error31".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//TO Update Orders_db
			$sql3="update $table_ref2 set priority=6 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			//echo $sql3."-B<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql3="update $table_ref3 set priority=6 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			//echo $sql3."-B<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"]));
			//To Update Orders_db
		}
		
		}
			
	}
	
	fwrite($fh1, "\n"."Processing 2:");
	include("out_put_update_include.php");

	
}
print(memory_get_usage())."\n";
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>


