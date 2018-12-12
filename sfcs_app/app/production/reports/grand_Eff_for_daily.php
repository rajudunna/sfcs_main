<!--
Date : 2014-01-18;
Task : Takes the Max output style buyer for buyer level calculations in Efficiency Report;
Ticket #815663
 -->
 <?php
$edate=$edate;
$sdate=$date;
$teams=$shifts_array;
$team_array=implode(",",$shifts_array);
$team = "'".str_replace(",","','",$team_array)."'"; 	
	
$sql222_new="select distinct bac_date from $bai_pro.bai_log_buf where bac_date between \"$sdate\" and \"$edate\"";
//echo $sql222_new;

$sql_result222_new=mysqli_query($link, $sql222_new) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row222_new=mysqli_fetch_array($sql_result222_new))
{
	$date=$sql_row222_new['bac_date'];

	$sql222="select distinct bac_sec from $bai_pro.bai_log_buf where bac_date=\"$date\"";
	//echo $sql222;
	$sql_result222=mysqli_query($link, $sql222) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row222=mysqli_fetch_array($sql_result222))
	{
		$sec=$sql_row222['bac_sec'];
		for($k=0;$k<sizeof($teams);$k++)
		{
			$shift=$teams[$k];
				        //Initial
			$mod_tot_pln_output=0;
			$mod_tot_act_output=0;
			$mod_tot_pln_clh=0;
			$mod_tot_act_clh=0;
			$mod_tot_pln_sth=0;
			$mod_tot_act_sth=0;
			//Initial
			$sql_new1="select distinct bac_no from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_sec=$sec  and bac_shift=\"$shift\"";
			//echo $sql_new1;

			$sql_result_new1=mysqli_query($link, $sql_new1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_new1=mysqli_fetch_array($sql_result_new1))
			{
				$module=$sql_row_new1['bac_no'];

				//COM: Production Total
				$sql2="select coalesce(sum(bac_qty),0) as \"sum\" from $bai_pro.bai_log_buf where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=\"$module\"";
				//echo $sql2;
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$act_output=$sql_row2['sum'];
				}

				$sql2="select COALESCE(sum(bac_qty),0) as \"sum\" from $bai_pro.bai_quality_log where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=\"$module\"";
				//echo $sql2;

				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$rework_qty=$sql_row2['sum'];
				}

				//COM: Styles
				$style_db=array();
				$buyer_db=array();
				//$sql2="select distinct bac_style  from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				$sql2="select distinct bac_style  from $bai_pro.bai_log_buf where bac_sec=$sec and bac_date=\"$date\" and bac_no=\"$module\"";
				//echo $sql2;
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$style_db[]=$sql_row2['bac_style'];
				}

				//$sql2="select distinct buyer  from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				$sql2="select distinct buyer  from $bai_pro.bai_log_buf where bac_sec=$sec and bac_date=\"$date\" and bac_no=\"$module\"";
				//echo $sql2;

				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$buyer_db[]=$sql_row2['buyer'];
				}
				$style_db_new=implode(",",$style_db);
				$buyer_db_new=implode(",",$buyer_db);

				//COM: Standard Hours
				$sql2="select coalesce(sum((bac_qty*smv)/60),0) as \"stha\" from $bai_pro.bai_log_buf where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=\"$module\"";
				//echo $sql2."<br>";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$act_sth=$sql_row2['stha'];
				}

				$work_hrs=0;
				$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift ='".$shift."'";
				// echo $sql_hr."<br>";
				$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if(mysqli_num_rows($sql_result_hr) >0)
				{
					while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
					{ 
						$work_hrs=$work_hrs+($sql_row_hr['end_time']-$sql_row_hr['start_time']);

					}
					$work_hours=$work_hrs-0.5;
					
				}else{
					$work_hours=7.5;
				}
				$hour_dur=0;
				//COM :Production Hours
				$current_date=date('Y-m-d');
				$current_hr=date('H');
				if($current_date==$date)
				{
					$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."' and  $current_hr between start_time and end_time";
					// echo $sql_hr."<br>";
					$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
					if(mysqli_num_rows($sql_result_hr) >0)
					{
						while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
						{ 
							$start_time=$sql_row_hr['start_time'];
							$end_time=$sql_row_hr['end_time'];
							$diff_time=$current_hr-$start_time;
							if($diff_time>3){
									$diff_time=$diff_time-0.5;
							}

							$hour_dur=$hour_dur+$diff_time;

						}
					}
					else
					{
						$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."' and $current_hr > end_time";
						// echo $sql_hr."<br>";
						$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
						// $hour_dur=$hour_dur+0;
						while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
						{ 
							$start_time=$sql_row_hr['start_time'];
							$end_time=$sql_row_hr['end_time'];
							if($end_time > $start_time){
								$diff_time=$end_time-$start_time;
							}
							else
							{
								$start=24-$start_time;
								$diff_time=$start+$end_time;
							}
							if($diff_time>3){
									$diff_time=$diff_time-0.5;
							}
							$hour_dur=$hour_dur+$diff_time;
						}
					}
					$hoursa_shift=$hour_dur;
				}
				else
				{
					$hoursa_shift=$work_hours;
				}	
				//COM: NOP and SMV Selection
				$max=0;
				$sql2="select bac_style,smv,nop, coalesce(sum(bac_qty),0) as \"qty\", couple,delivery,buyer from $bai_pro.bai_log_buf where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=\"$module\" group by bac_style,delivery";
				//echo $sql2."<br>";

				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					if($sql_row2['qty']>=$max)
					{
					//$style_code_new=$sql_row2['bac_style'];
					$delivery=$sql_row2['delivery'];
					$max=$sql_row2['qty'];
					$smv=$sql_row2['smv'];
					$nop=$sql_row2['nop'];
					//Created Max Buyer varial for capturing the max output style buyer
					//$max_buyer=$sql_row2['buyer'];
					//echo $delivery."-".$max."<br>";
					}
				//$max=$sql_row2['qty'];
				}

				$sql2="select bac_style,buyer from $bai_pro.bai_log_buf where bac_date=\"$date\" and buyer<>'' and bac_sec=$sec and bac_no=\"$module\" group by bac_style";
				//echo $sql2;
				//mysql_query($sql2,$link) or exit("Sql Error35".mysql_error());
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error35$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$style_db[]=$sql_row2['bac_style'];
					$max_buyer=$sql_row2['buyer'];
				}
				$style_code_new=implode(",",$style_db);
				//$max_buyer=implode(",",$buyer_db);

				//*********************Disable due to report discripency
				/*
				$sql13="select fix_nop as nop from pro_plan where mod_no=$module and date=\"".$date."\" and shift=\"".$shift."\"";
				$result13=mysql_query($sql13,$link) or exit("Sql Error".mysql_error());
				while($sql_row13=mysql_fetch_array($result13))
				{
				$nop=$sql_row13["nop"];
				}	

				//For Temp Check (Taking Allocated Operators as cadre to calculate Clock Hours)
				$sql13="select (avail_$shift-absent_$shift) as nop from pro_atten where module=$module and date=\"".$date."\"";
				$result13=mysql_query($sql13,$link) or exit("Sql Error".mysql_error());
				while($sql_row13=mysql_fetch_array($result13))
				{
				//$nop=$sql_row13["nop"];
				}		
				*/

				$days=0;
				$sql2="select days from $bai_pro.pro_style where style=\"$style_code_new\"";
				//echo $sql2;

				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$days=$sql_row2['days'];
				}

				//COM: Actual Clock Hours

				$act_clh=$nop*$hoursa_shift;

				//COM: PLAN

				//$sql2="select plan_eff, plan_pro, act_hours from pro_plan where sec_no=$sec and shift=\"$shift\" and date=\"$date\" and mod_no=$module";
				//Removed Section Criteria due to updation issues.
				$sql2="select plan_eff, plan_pro, act_hours from $bai_pro.pro_plan where sec_no=$sec and shift=\"$shift\" and date=\"$date\" and mod_no=\"$module\"";
				//echo $sql2."<br/>";

				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
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

				$sql2="select ((present+jumper)-absent) as nop FROM $bai_pro.pro_attendance where date='".$date."' and module=$module and shift='".$shift."'";
				$note.=$sql2."<br/>";
				//echo $sql2."<br>"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$act_nop=$sql_row2['nop'];
				}
				$act_clh=$act_nop*$hoursa_shift;


				$code=$date."-".$module."-".$shift;

				$sql2="insert ignore into $bai_pro.grand_rep(tid) values (\"$code\")";
				mysqli_query($link, $sql2) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));

				//$sql2="update grand_rep set date=\"$date\", module=$module, shift=\"$shift\", section=$sec, plan_out=$pln_output, act_out=$act_output, plan_clh=$pln_clh, act_clh=$act_clh, plan_sth=$pln_sth, act_sth=$act_sth, styles=\"$style_db_new\", smv=$smv, nop=$nop, buyer=\"$buyer_db_new\", days=$days, max_style=\"$style_code_new\", max_out=$max where tid=\"$code\"";

				//New code to extract values from existing

				if(date("Y-m-d")>"2014-06-30")
				{
					$pln_output=0;
					$pln_clh=0;
					$pln_sth=0;
					$sql2="select plan_eff, plan_pro, plan_sah,plan_clh from $bai_pro.pro_plan where sec_no=$sec and shift=\"$shift\" and date=\"$date\" and mod_no=\"$module\"";
					//echo $sql2;
					$note.=$sql2."<br/>";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				if($smv=='' && $nop=='')
				{
					$sql2="update $bai_pro.grand_rep set date=\"$date\", module=\"$module\", shift=\"$shift\", section=$sec, plan_out=$pln_output, act_out=$act_output, plan_clh=$pln_clh, act_clh=$act_clh, plan_sth=$pln_sth, act_sth=$act_sth, styles=\"$style_db_new\", smv='', nop='', buyer=\"$max_buyer\", days=$days, max_style=\"$delivery^$style_code_new\", max_out=$max,rework_qty=$rework_qty where tid=\"$code\"";
				}
				else
				{
					$sql2="update $bai_pro.grand_rep set date=\"$date\", module=\"$module\", shift=\"$shift\", section=$sec, plan_out=$pln_output, act_out=$act_output, plan_clh=$pln_clh, act_clh=$act_clh, plan_sth=$pln_sth, act_sth=$act_sth, styles=\"$style_db_new\", smv=$smv, nop=$nop, buyer=\"$max_buyer\", days=$days, max_style=\"$delivery^$style_code_new\", max_out=$max,rework_qty=$rework_qty where tid=\"$code\"";
				}
				mysqli_query($link, $sql2) or exit("Sql Error50".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));			

			} //Module		
		} //shift
	} //Section
} // Date



?>
