
<?php
$start_timestamp = microtime(true);
error_reporting(E_ALL & ~E_NOTICE);
include("ims_process_ses_track.php");
$time_diff=(int)date("YmdH")-$log_time;

if($log_time==0 or $time_diff>1)
{
	$myFile = "ims_process_ses_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=".(int)date("YmdH")."; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
?>

<?php $process_the_auto_process=1; //1-Yes ; 0-No; ?>

<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
<script language="javascript" type="text/javascript" src="check.js"></script>
<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>
    
</head>
<body onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">

<?php 
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\m3_bulk_or_proc.php');
	?>

<?php
//New Version 1.0 to Eliminate Duplicates
	if($process_the_auto_process==1)
	{
	echo "START:".date("H:i:s");	
	
	//SPEED PROCESS - START
	
	$bai_log_table_name="bai_pro.bai_log_buf";
	$date=date("Y-m-d");
	
		$sql11="select distinct(Hour(bac_lastup)) as \"time\" from ".$bai_log_table_name." where bac_date=\"$date\"";
$note = date("His").$sql11."<br/>";
		//uery($sql11,$link) or exit("Sql Error17".mysql_error());
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error17$sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$hoursa=mysqli_num_rows($sql_result11);

		if($hoursa==4 && ($section==3 || $section==4) )
		{
			$hoursa=$hoursa;	
		}
		else
		{
			if($hoursa>3)
			{
				$hoursa=$hoursa+0.5-1;	
			}
		}
		if($hoursa==11.5 && ($section==3 || $section==4) )
		{
			$hoursa=$hoursa;
		}	
		else
		{
		if($hoursa>7.5)
		{
			$hoursa=$hoursa+0.5-1;
		}
		}
	
	$sql="select speed_schedule from bai_pro3.speed_del_dashboard";
	$note.=date("His").$sql."<br/>";
	//mysql_query($sql,$link11) or exit("Sql Error18".mysql_error());
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error18$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$schedule=$sql_row['speed_schedule'];
		
		$sql1="select coalesce(sum(ims_qty),0) as \"ims_qty\", coalesce(sum(ims_pro_qty),0) as \"ims_pro_qty\" from bai_pro3.ims_log where ims_schedule=$schedule";
$note.=date("His").$sql1."<br/>";

		//mysql_query($sql1,$link11) or exit("Sql Error19".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error19$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$input=$sql_row1['ims_qty'];
			$output=$sql_row1['ims_pro_qty'];
		}
		
		$sql1="select coalesce(sum(ims_qty),0) as \"ims_qty\", coalesce(sum(ims_pro_qty),0) as \"ims_pro_qty\" from bai_pro3.ims_log_backup where ims_schedule=$schedule";
$note.=date("His").$sql1."<br/>";

		//mysql_query($sql1,$link) or exit("Sql Error20".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error20$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$input+=$sql_row1['ims_qty'];
			$output+=$sql_row1['ims_pro_qty'];
		}

		$sql1="select order_style_no, sum(if(order_no=1,(old_order_s_s01+old_order_s_s02+old_order_s_s03+old_order_s_s04+old_order_s_s05+old_order_s_s06+old_order_s_s07+old_order_s_s08+old_order_s_s09+old_order_s_s10+old_order_s_s11+old_order_s_s12+old_order_s_s13+old_order_s_s14+old_order_s_s15+old_order_s_s16+old_order_s_s17+old_order_s_s18+old_order_s_s19+old_order_s_s20+old_order_s_s21+old_order_s_s22+old_order_s_s23+old_order_s_s24+old_order_s_s25+old_order_s_s26+old_order_s_s27+old_order_s_s28+old_order_s_s29+old_order_s_s30+old_order_s_s31+old_order_s_s32+old_order_s_s33+old_order_s_s34+old_order_s_s35+old_order_s_s36+old_order_s_s37+old_order_s_s38+old_order_s_s39+old_order_s_s40+old_order_s_s41+old_order_s_s42+old_order_s_s43+old_order_s_s44+old_order_s_s45+old_order_s_s46+old_order_s_s47+old_order_s_s48+old_order_s_s49+old_order_s_s50+old_order_s_xs+old_order_s_s+old_order_s_m+old_order_s_l+old_order_s_xl+old_order_s_xxl+old_order_s_xxxl),(order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50+order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl))) as \"order_qty\" from bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
$note.=date("His").$sql1."<br/>";
		//mysql_query($sql1,$link11) or exit("Sql Error21".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error21$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$order_qty=$sql_row1['order_qty'];
			$order_style_no=$sql_row1['order_style_no'];
	
		}
		

		
		$sql1="select coalesce(sum((a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50+a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl)*a_plies),0) as \"cut_qty\" from bai_pro3.plandoc_stat_log where order_tid in (select order_tid from bai_pro3.bai_orders_db where order_del_no=\"$schedule\") and act_cut_status=\"DONE\" and cat_ref in (select tid from bai_pro3.cat_stat_log where order_tid in (select order_tid from bai_pro3.bai_orders_db where order_del_no=\"$schedule\") and category in (\"Body\",\"Front\"))";
$note.=date("His").$sql1."<br/>";
		//mysql_query($sql1,$link11) or exit("Sql Error22".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error22$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_qty=$sql_row1['cut_qty'];
		}
		
		// Avg PCS calculation
				
		//Today output
		$sql11="select coalesce(sum(bac_qty),0) as \"today_output\" from ".$bai_log_table_name." where bac_date=\"$date\" and delivery=$schedule";
$note.=date("His").$sql11."<br/>";
		//mysql_query($sql11,$link) or exit("Sql Error23".mysql_error());
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error23$sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$today_output=$sql_row11['today_output'];
		}
		
		
		if($hoursa>0)
		{
			$avg_pcs_per_hour=$today_output/$hoursa;
		}
		else
		{
			$avg_pcs_per_hour=$today_output/1;
		}
		
		// Avg PCS Calculaiton
		
		$lastup=date("Y-m-d H:i:s");
		
		$sql1="update bai_pro3.speed_del_dashboard set speed_act=\"$avg_pcs_per_hour\", speed_style=\"$order_style_no\", speed_cut_qty=\"$cut_qty\", speed_in_qty=\"$input\", speed_out_qty=\"$output\", speed_order_qty=\"$order_qty\", lastup=\"$lastup\" where speed_schedule=$schedule";

$note.=date("His").$sql1."<br/>";

		mysqli_query($link, $sql1) or exit("Sql Error24$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));

		
		// Hours completed calculation
		
				$total_hrs=0;
		
		$sql1="select distinct bac_date from ".$bai_log_table_name." where delivery=$schedule";
		$note.=date("His").$sql1."<br/>";
		//mysql_query($sql1,$link) or exit("Sql Error25".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error25$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$date_new=$sql_row1['bac_date'];
		
			$sql11="select distinct(Hour(bac_lastup)) as \"time\" from ".$bai_log_table_name." where bac_date=\"$date_new\" and delivery=$schedule";
$note.=date("His").$sql11."<br/>";
			//mysql_query($sql11,$link) or exit("Sql Error26".mysql_error());
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error26$sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$hoursa_new=mysqli_num_rows($sql_result11);
	
			if($hoursa_new==4 && ($section==3 || $section==4) )
			{
				$hoursa_new=$hoursa_new;	
			}
			else
			{
				if($hoursa_new>3)
				{
					$hoursa_new=$hoursa_new+0.5-1;	
				}
			}
			if($hoursa_new==11.5 && ($section==3 || $section==4) )
			{
				$hoursa_new=$hoursa_new;
			}	
			else
			{
			if($hoursa_new>7.5)
			{
				$hoursa_new=$hoursa_new+0.5-1;
			}
			}
			$total_hrs+=$hoursa_new;
		}
		
		$sql1="update bai_pro3.speed_del_dashboard set total_hrs=$total_hrs, today_hrs=$hoursa where speed_schedule=$schedule";

$note.=date("His").$sql1."<br/>";
		mysqli_query($link, $sql1) or exit("Sql Error27$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		// Hours completed calculation
					
	}
	
	//SPEED PROCESS - END
	
	
	
	//GRAND EFF UPDATE - START
	
	$edate=$date;
	$sdate=$date;
	$table_name="bai_pro.bai_log_buf";
	$table_name2="bai_pro.bai_quality_log";
	
	//To Speed up the process
	$sql="DROP TABLE IF EXISTS temp_pool_db.bai_log_buf_$username";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="DROP TABLE IF EXISTS temp_pool_db.bai_quality_log_$username";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	$sql="CREATE  TABLE temp_pool_db.bai_log_buf_$username ENGINE = MYISAM SELECT * FROM $table_name where bac_date between \"$sdate\" and \"$edate\"";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="CREATE  TABLE temp_pool_db.bai_quality_log_$username ENGINE = MYISAM SELECT * FROM $table_name2 where bac_date between \"$sdate\" and \"$edate\"";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));	
	
	$sql="truncate temp_pool_db.bai_log_buf_$username";
	//echo $sql."<br/>";
	//mysql_query($sql,$link) or exit("Sql Error14".mysql_error());
	
	$sql="insert into temp_pool_db.bai_log_buf_$username select * from $table_name where bac_date between \"$sdate\" and \"$edate\"";
	//mysql_query($sql,$link) or exit("Sql Error23".mysql_error());
	
	//NEW2011
	$sql="truncate temp_pool_db.bai_quality_log_$username";
	//echo $sql."<br/>";
	//mysql_query($sql,$link) or exit("Sql Error32".mysql_error());
	
	$sql="insert into temp_pool_db.bai_quality_log_$username select * from $table_name2 where bac_date between \"$sdate\" and \"$edate\"";
	//mysql_query($sql,$link) or exit("Sql Error41".mysql_error());
	
	
	$table_name="temp_pool_db.bai_log_buf_$username";
	$table_name2="temp_pool_db.bai_quality_log_$username";
	//To Speed up the process
	
	
//S:To avoid Duplicate Entry - 20150511 Kirang

$sql222_new="select distinct bac_date from $table_name where bac_date between \"$sdate\" and \"$edate\"";
//echo $sql222_new;
$note.=date("His").$sql222."<br/>";
//mysql_query($sql222_new,$link) or exit("Sql Error28".mysql_error());
$sql_result222_new=mysqli_query($link, $sql222_new) or exit("Sql Error28$sql222_new".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row222_new=mysqli_fetch_array($sql_result222_new))
{
	$date=$sql_row222_new['bac_date'];

	$sql222="select distinct bac_sec from $table_name where bac_date=\"$date\"";
	$note.=date("His").$sql222."<br/>";
	//echo $sql222;
	//mysql_query($sql222,$link) or exit("Sql Error29".mysql_error());
	$sql_result222=mysqli_query($link, $sql222) or exit("Sql Error29$sql222".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row222=mysqli_fetch_array($sql_result222))
	{
		$sec=$sql_row222['bac_sec'];
		
		$sql_new="select distinct bac_shift from $table_name where bac_date=\"$date\" and bac_sec=$sec";
		//echo $sql_new;
		$note.=date("His").$sql_new."<br/>";
		//mysql_query($sql_new,$link) or exit("Sql Error30".mysql_error());
		$sql_result_new=mysqli_query($link, $sql_new) or exit("Sql Error30$sql_new".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_new=mysqli_fetch_array($sql_result_new))
		{
			//Initial
			$mod_tot_pln_output=0;
			$mod_tot_act_output=0;
			$mod_tot_pln_clh=0;
			$mod_tot_act_clh=0;
			$mod_tot_pln_sth=0;
			$mod_tot_act_sth=0;
			
			//Initial
			
			
			$shift=$sql_row_new['bac_shift'];
			
			$sql_new1="select distinct bac_no from $table_name where bac_date=\"$date\" and bac_sec=$sec and bac_shift=\"$shift\"";
$note.=date("His").$sql_new1."<br/>";
			//echo $sql_new1;
			//mysql_query($sql_new1,$link) or exit("Sql Error31".mysql_error());
			$sql_result_new1=mysqli_query($link, $sql_new1) or exit("Sql Error31$sql_new1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_new1=mysqli_fetch_array($sql_result_new1))
			{
				$module=$sql_row_new1['bac_no'];

				//COM: Production Total
				$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_shift=\"$shift\" and bac_sec=$sec and bac_no=$module";
$note.=date("His").$sql2."<br/>";
				//echo $sql2;
				//mysql_query($sql2,$link) or exit("Sql Error32".mysql_error());
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error32$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$act_output=$sql_row2['sum'];
				}
				
				$sql2="select COALESCE(sum(bac_qty),0) as \"sum\" from $table_name2 where bac_date=\"$date\" and bac_shift=\"$shift\" and bac_sec=$sec and bac_no=$module";
$note.=date("His").$sql2."<br/>";
				//echo $sql2;
				//mysql_query($sql2,$link) or exit("Sql Error33".mysql_error());
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error33$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$rework_qty=$sql_row2['sum'];
				}
				
				//COM: Styles
				$style_db=array();
				$buyer_db=array();
				//$sql2="select distinct bac_style  from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				$sql2="select distinct bac_style  from $table_name where bac_date=\"$date\" and bac_sec=$sec and bac_no=$module";
$note.=date("His").$sql2."<br/>";
				//echo $sql2;
				//mysql_query($sql2,$link) or exit("Sql Error34".mysql_error());
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error34$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$style_db[]=$sql_row2['bac_style'];
				}
				
				//$sql2="select distinct buyer  from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				$sql2="select distinct buyer  from $table_name where bac_date=\"$date\" and bac_sec=$sec and bac_no=$module";
$note.=date("His").$sql2."<br/>";
				//echo $sql2;
				//mysql_query($sql2,$link) or exit("Sql Error35".mysql_error());
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error35$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$buyer_db[]=$sql_row2['buyer'];
				}
				$style_db_new=implode(",",$style_db);
				$buyer_db_new=implode(",",$buyer_db);
				
				
							
			
			//COM: Standard Hours
			$sql2="select sum((bac_qty*smv)/60) as \"stha\" from $table_name where bac_date=\"$date\" and bac_shift=\"$shift\" and bac_sec=$sec and bac_no=$module";
$note.=date("His").$sql2."<br/>";
			//echo $sql2;
			//mysql_query($sql2,$link) or exit("Sql Error36".mysql_error());
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error36".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$act_sth=$sql_row2['stha'];
			}
			
					
			//COM :Production Hours
			$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_date=\"$date\" and bac_shift=\"$shift\" and bac_sec=$sec and bac_no=$module";
$note.=date("His").$sql2."<br/>";
			//echo $sql2;
			//mysql_query($sql2,$link) or exit("Sql Error37".mysql_error());
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error37$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$hoursa=$sql_row2['hoursa'];
			}

			if($hoursa==4 && ($sec==3 || $sec==4) )
			{
				$hoursa=$hoursa;	
			}
			else
			{
				if($hoursa>3)
				{
					$hoursa=$hoursa+0.5-1;	
				}
			}

			if($hoursa==11.5 && ($sec==3 || $sec==4) )
			{
				$hoursa=$hoursa;
			}
			else
			{
				if($hoursa>7.5)
				{
					$hoursa=$hoursa+0.5-1;
				}
			}

			//COM: NOP and SMV Selection
			$max=0;
			$sql2="select bac_style,smv,nop, sum(bac_qty) as \"qty\", couple,delivery from $table_name where bac_date=\"$date\" and bac_shift=\"$shift\" and bac_sec=$sec and  bac_no=$module group by bac_style";
$note.=date("His").$sql2."<br/>";
			//echo $sql2;
			//mysql_query($sql2,$link) or exit("Sql Error38".mysql_error());
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error38$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				if($sql_row2['qty']>=$max)
				{
					$style_code_new=$sql_row2['bac_style'];
					$delivery=$sql_row2['delivery'];
					$max=$sql_row2['qty'];
					$smv=$sql_row2['smv'];
					$nop=$sql_row2['nop'];
				}
			}
			
			$days=0;
			$sql2="select days from bai_pro.pro_style_today where style=\"$style_code_new\"";
			$note.=date("His").$sql2."<br/>";
			//echo $sql2;
			//mysql_query($sql2,$link) or exit("Sql Error39".mysql_error());
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error39$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$days=$sql_row2['days'];
			}

			//COM: Actual Clock Hours

			$act_clh=$nop*$hoursa;

			//COM: PLAN
			
			$sql2="select plan_eff, plan_pro, act_hours from bai_pro.pro_plan_today where date=\"$date\" and shift=\"$shift\" and sec_no=$sec and   mod_no=$module";
$note.=date("His").$sql2."<br/>";
			//mysql_query($sql2,$link) or exit("Sql Error40".mysql_error());
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error40$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$pln_eff_a=$sql_row2['plan_eff'];
				$pln_output=$sql_row2['plan_pro'];
				$pln_hrs=$sql_row2['act_hours'];
			}

			//COM: Plan Clock Hours and Standara Hours
			$pln_clh=($pln_hrs*$nop);
			$pln_sth=($pln_output*$smv)/60;
			
			//New 2012-05-21 - Need to do since plan sah has to calculate based on the clock hours (updated in Plan).
			$pln_sth=($pln_clh*$pln_eff_a)/100;
			$act_clh=$pln_clh;
			
			//New 2013-07-27 for actula clock hours calculation
			$act_nop=0;
			$sql2="SELECT (avail_$shift-absent_$shift) as nop FROM bai_pro.pro_atten WHERE DATE='$date' AND module=$module";
$note.=date("His").$sql2."<br/>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error40$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$act_nop=$sql_row2['nop'];
			}
			$act_clh=$act_nop*$pln_hrs;
						
			$code=$date."-".$module."-".$shift;
			
			$sql2="insert ignore into bai_pro.grand_rep(tid) values (\"$code\")";
			$note.=date("His").$sql2."<br/>";
			mysqli_query($link, $sql2) or exit("Sql Error41$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//New code to extract values from existing
			
			if(date("Y-m-d")>"2014-06-30")
			{
				$pln_output=0;
				$pln_clh=0;
				$pln_sth=0;
				$sql2="select plan_eff, plan_pro, plan_sah,plan_clh from bai_pro.pro_plan where date=\"$date\" and shift=\"$shift\" and sec_no=$sec and   mod_no=$module";
				$note.=date("His").$sql2."<br/>";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error40$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$pln_output=$sql_row2['plan_pro'];
					
					$pln_clh=round($sql_row2['plan_clh'],2);
					$pln_sth=$sql_row2['plan_sah'];
					//echo $plan_sth."<br/>";
				}
				
				if(strlen($pln_clh)==0 or $pln_clh==NULL or $pln_clh=="")
				{
					$pln_clh=0;				
				}
			}
			
			//$sql2="update grand_rep set date=\"$date\", module=$module, shift=\"$shift\", section=$sec, plan_out=$pln_output, act_out=$act_output, plan_clh=$pln_clh, act_clh=$act_clh, plan_sth=$pln_sth, act_sth=$act_sth, styles=\"$style_db_new\", smv=$smv, nop=$nop, buyer=\"$buyer_db_new\", days=$days, max_style=\"$style_code_new\", max_out=$max where tid=\"$code\"";
			$sql2="update bai_pro.grand_rep set date=\"$date\", module=$module, shift=\"$shift\", section=$sec, plan_out=$pln_output, act_out=$act_output, plan_clh=$pln_clh, act_clh=$act_clh, plan_sth=$pln_sth, act_sth=$act_sth, styles=\"$style_db_new\", smv=$smv, nop=$nop, buyer=\"$buyer_db_new\", days=$days, max_style=\"$delivery^$style_code_new\", max_out=$max,rework_qty=$rework_qty where tid=\"$code\"";

			$note.=date("His").$sql2."<br/>";
			mysqli_query($link, $sql2) or exit("Sql Error42$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));			
		
		} //Module		
	} //Shift
	
} //Section
} // Date

//echo $note;
//E:To avoid Duplicate Entry - 20150511 Kirang
echo "END:".date("H:i:s");

	$myFile = "ims_process_ses_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=0; ?>";
	fwrite($fh, $stringData);
	fclose($fh);


 } 

//Auto Close
}

?>



<?php
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
?>
