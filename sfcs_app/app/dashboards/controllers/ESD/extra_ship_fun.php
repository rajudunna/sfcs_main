<!--
CR: 207 extrashipment dashboard based on th IMS.
kirang /1-18-2015: To avoid the division by Zero error
-->
<?php
function ims_schedules($link,$section_mods)
{
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	$sch_count=0;
	$sql22="select count(distinct(ims_schedule)) as sum_sch from $bai_pro3.ims_log where ims_mod_no in ($section_mods)";
		//echo $sql22;
		// mysqli_query($link, $sql22) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$sche_sum=$sql_row22['sum_sch'];
			$sch_count+=$sch_count+$sche_sum;
		    
		}
		return $sch_count;
}

function ims_schedules_input($link,$section_mods)
{
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	$sel_sch=array();
	$sql23="select distinct(ims_schedule) as dist_schedules from $bai_pro3.ims_log where ims_mod_no in ($section_mods)";
	// echo $sql23 ."</br>";
	// mysqli_query($link, $sql23) or exit("Sql Error231".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result23=mysqli_query($link, $sql23) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
	while($sql_row23=mysqli_fetch_array($sql_result23))
	{
		$sel_schedules=$sql_row23['dist_schedules'];
		//$sel_sch=implode(",",$sel_schedules);	
		$sel_sch[]=$sel_schedules;	
	}
		//var_dump($sel_sch);
		$string1=implode(',',$sel_sch);
		$ord_qty=0;
        $ext_ord_qty=0;
		$ext_per_qty=0;
		$count=0;
		$tot_ext_ord_qty=0;
		$tot_act_cut=0;
		$tot_ord_qty=0;
		$tot_act_in=0;
		$tot_act_out=0;
		$Total_cut_aty=0;
		$tot_ims_input=0;
		$tot_ims_output=0;
		$fcount=0;
		unset($colour);
		// echo "<br/>schedule=".$string1;
		
			$sql24="select order_del_no,act_in,output,act_cut, order_s_xs, order_s_s, order_s_m, order_s_l, order_s_xl, order_s_xxl, order_s_xxxl, order_s_s01, order_s_s02, order_s_s03, order_s_s04, order_s_s05, order_s_s06, order_s_s07, order_s_s08, order_s_s09, order_s_s10, order_s_s11, order_s_s12, order_s_s13, order_s_s14, order_s_s15, order_s_s16, order_s_s17, order_s_s18, order_s_s19, order_s_s20, order_s_s21, order_s_s22, order_s_s23, order_s_s24, order_s_s25, order_s_s26, order_s_s27, order_s_s28, order_s_s29, order_s_s30, order_s_s31, order_s_s32, order_s_s33, order_s_s34, order_s_s35, order_s_s36, order_s_s37, order_s_s38, order_s_s39, order_s_s40, order_s_s41, order_s_s42, order_s_s43, order_s_s44, order_s_s45, order_s_s46, order_s_s47, order_s_s48, order_s_s49, order_s_s50, old_order_s_xs, old_order_s_s, old_order_s_m, old_order_s_l, old_order_s_xl, old_order_s_xxl, old_order_s_xxxl, old_order_s_s01, old_order_s_s02, old_order_s_s03, old_order_s_s04, old_order_s_s05, old_order_s_s06, old_order_s_s07, old_order_s_s08, old_order_s_s09, old_order_s_s10, old_order_s_s11, old_order_s_s12, old_order_s_s13, old_order_s_s14, old_order_s_s15, old_order_s_s16, old_order_s_s17, old_order_s_s18, old_order_s_s19, old_order_s_s20, old_order_s_s21, old_order_s_s22, old_order_s_s23, old_order_s_s24, old_order_s_s25, old_order_s_s26, old_order_s_s27, old_order_s_s28, old_order_s_s29, old_order_s_s30, old_order_s_s31, old_order_s_s32, old_order_s_s33, old_order_s_s34, old_order_s_s35, old_order_s_s36, old_order_s_s37, old_order_s_s38, old_order_s_s39, old_order_s_s40, old_order_s_s41, old_order_s_s42, old_order_s_s43, old_order_s_s44, old_order_s_s45, old_order_s_s46, old_order_s_s47, old_order_s_s48, old_order_s_s49, old_order_s_s50 from $bai_pro3.bai_orders_db_confirm where order_del_no in ('$string1')";
		// echo $sql24. "</br>";
		// mysqli_query($link, $sql24) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result24=mysqli_query($link, $sql24) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
		while($sql_row24=mysqli_fetch_array($sql_result24))
		{
			$order_s_xs=$sql_row24['order_s_xs'];
			$order_s_s=$sql_row24['order_s_s'];
			$order_s_m=$sql_row24['order_s_m'];
			$order_s_l=$sql_row24['order_s_l'];
			$order_s_xl=$sql_row24['order_s_xl'];
			$order_s_xxl=$sql_row24['order_s_xxl'];
			$order_s_xxxl=$sql_row24['order_s_xxxl'];
			$order_s_s01=$sql_row24['order_s_s01'];
			$order_s_s02=$sql_row24['order_s_s02'];
			$order_s_s03=$sql_row24['order_s_s03'];
			$order_s_s04=$sql_row24['order_s_s04'];
			$order_s_s05=$sql_row24['order_s_s05'];
			$order_s_s06=$sql_row24['order_s_s06'];
			$order_s_s07=$sql_row24['order_s_s07'];
			$order_s_s08=$sql_row24['order_s_s08'];
			$order_s_s09=$sql_row24['order_s_s09'];
			$order_s_s10=$sql_row24['order_s_s10'];
			$order_s_s11=$sql_row24['order_s_s11'];
			$order_s_s12=$sql_row24['order_s_s12'];
			$order_s_s13=$sql_row24['order_s_s13'];
			$order_s_s14=$sql_row24['order_s_s14'];
			$order_s_s15=$sql_row24['order_s_s15'];
			$order_s_s16=$sql_row24['order_s_s16'];
			$order_s_s17=$sql_row24['order_s_s17'];
			$order_s_s18=$sql_row24['order_s_s18'];
			$order_s_s19=$sql_row24['order_s_s19'];
			$order_s_s20=$sql_row24['order_s_s20'];
			$order_s_s21=$sql_row24['order_s_s21'];
			$order_s_s22=$sql_row24['order_s_s22'];
			$order_s_s23=$sql_row24['order_s_s23'];
			$order_s_s24=$sql_row24['order_s_s24'];
			$order_s_s25=$sql_row24['order_s_s25'];
			$order_s_s26=$sql_row24['order_s_s26'];
			$order_s_s27=$sql_row24['order_s_s27'];
			$order_s_s28=$sql_row24['order_s_s28'];
			$order_s_s29=$sql_row24['order_s_s29'];
			$order_s_s30=$sql_row24['order_s_s30'];
			$order_s_s31=$sql_row24['order_s_s31'];
			$order_s_s32=$sql_row24['order_s_s32'];
			$order_s_s33=$sql_row24['order_s_s33'];
			$order_s_s34=$sql_row24['order_s_s34'];
			$order_s_s35=$sql_row24['order_s_s35'];
			$order_s_s36=$sql_row24['order_s_s36'];
			$order_s_s37=$sql_row24['order_s_s37'];
			$order_s_s38=$sql_row24['order_s_s38'];
			$order_s_s39=$sql_row24['order_s_s39'];
			$order_s_s40=$sql_row24['order_s_s40'];
			$order_s_s41=$sql_row24['order_s_s41'];
			$order_s_s42=$sql_row24['order_s_s42'];
			$order_s_s43=$sql_row24['order_s_s43'];
			$order_s_s44=$sql_row24['order_s_s44'];
			$order_s_s45=$sql_row24['order_s_s45'];
			$order_s_s46=$sql_row24['order_s_s46'];
			$order_s_s47=$sql_row24['order_s_s47'];
			$order_s_s48=$sql_row24['order_s_s48'];
			$order_s_s49=$sql_row24['order_s_s49'];
			$order_s_s50=$sql_row24['order_s_s50'];

			$old_order_s_xs=$sql_row24['old_order_s_xs'];
			$old_order_s_s=$sql_row24['old_order_s_s'];
			$old_order_s_m=$sql_row24['old_order_s_m'];
			$old_order_s_l=$sql_row24['old_order_s_l'];
			$old_order_s_xl=$sql_row24['old_order_s_xl'];
			$old_order_s_xxl=$sql_row24['old_order_s_xxl'];
			$old_order_s_xxxl=$sql_row24['old_order_s_xxxl'];
			$old_order_s_s01=$sql_row24['old_order_s_s01'];
			$old_order_s_s02=$sql_row24['old_order_s_s02'];
			$old_order_s_s03=$sql_row24['old_order_s_s03'];
			$old_order_s_s04=$sql_row24['old_order_s_s04'];
			$old_order_s_s05=$sql_row24['old_order_s_s05'];
			$old_order_s_s06=$sql_row24['old_order_s_s06'];
			$old_order_s_s07=$sql_row24['old_order_s_s07'];
			$old_order_s_s08=$sql_row24['old_order_s_s08'];
			$old_order_s_s09=$sql_row24['old_order_s_s09'];
			$old_order_s_s10=$sql_row24['old_order_s_s10'];
			$old_order_s_s11=$sql_row24['old_order_s_s11'];
			$old_order_s_s12=$sql_row24['old_order_s_s12'];
			$old_order_s_s13=$sql_row24['old_order_s_s13'];
			$old_order_s_s14=$sql_row24['old_order_s_s14'];
			$old_order_s_s15=$sql_row24['old_order_s_s15'];
			$old_order_s_s16=$sql_row24['old_order_s_s16'];
			$old_order_s_s17=$sql_row24['old_order_s_s17'];
			$old_order_s_s18=$sql_row24['old_order_s_s18'];
			$old_order_s_s19=$sql_row24['old_order_s_s19'];
			$old_order_s_s20=$sql_row24['old_order_s_s20'];
			$old_order_s_s21=$sql_row24['old_order_s_s21'];
			$old_order_s_s22=$sql_row24['old_order_s_s22'];
			$old_order_s_s23=$sql_row24['old_order_s_s23'];
			$old_order_s_s24=$sql_row24['old_order_s_s24'];
			$old_order_s_s25=$sql_row24['old_order_s_s25'];
			$old_order_s_s26=$sql_row24['old_order_s_s26'];
			$old_order_s_s27=$sql_row24['old_order_s_s27'];
			$old_order_s_s28=$sql_row24['old_order_s_s28'];
			$old_order_s_s29=$sql_row24['old_order_s_s29'];
			$old_order_s_s30=$sql_row24['old_order_s_s30'];
			$old_order_s_s31=$sql_row24['old_order_s_s31'];
			$old_order_s_s32=$sql_row24['old_order_s_s32'];
			$old_order_s_s33=$sql_row24['old_order_s_s33'];
			$old_order_s_s34=$sql_row24['old_order_s_s34'];
			$old_order_s_s35=$sql_row24['old_order_s_s35'];
			$old_order_s_s36=$sql_row24['old_order_s_s36'];
			$old_order_s_s37=$sql_row24['old_order_s_s37'];
			$old_order_s_s38=$sql_row24['old_order_s_s38'];
			$old_order_s_s39=$sql_row24['old_order_s_s39'];
			$old_order_s_s40=$sql_row24['old_order_s_s40'];
			$old_order_s_s41=$sql_row24['old_order_s_s41'];
			$old_order_s_s42=$sql_row24['old_order_s_s42'];
			$old_order_s_s43=$sql_row24['old_order_s_s43'];
			$old_order_s_s44=$sql_row24['old_order_s_s44'];
			$old_order_s_s45=$sql_row24['old_order_s_s45'];
			$old_order_s_s46=$sql_row24['old_order_s_s46'];
			$old_order_s_s47=$sql_row24['old_order_s_s47'];
			$old_order_s_s48=$sql_row24['old_order_s_s48'];
			$old_order_s_s49=$sql_row24['old_order_s_s49'];
			$old_order_s_s50=$sql_row24['old_order_s_s50'];
	
			$act_in=$sql_row24['act_in'];
			$output=$sql_row24['output'];
			$act_cut=$sql_row24['act_cut'];
			$order_del_no=$sql_row24['order_del_no'];

			$ord_qty= $old_order_s_xs+ $old_order_s_s+ $old_order_s_m+ $old_order_s_l+ $old_order_s_xl+ $old_order_s_xxl+ $old_order_s_xxxl+ $old_order_s_s01+ $old_order_s_s02+ $old_order_s_s03+ $old_order_s_s04+ $old_order_s_s05+ $old_order_s_s06+ $old_order_s_s07+ $old_order_s_s08+ $old_order_s_s09+ $old_order_s_s10+ $old_order_s_s11+ $old_order_s_s12+ $old_order_s_s13+ $old_order_s_s14+ $old_order_s_s15+ $old_order_s_s16+ $old_order_s_s17+ $old_order_s_s18+ $old_order_s_s19+ $old_order_s_s20+ $old_order_s_s21+ $old_order_s_s22+ $old_order_s_s23+ $old_order_s_s24+ $old_order_s_s25+ $old_order_s_s26+ $old_order_s_s27+ $old_order_s_s28+ $old_order_s_s29+ $old_order_s_s30+ $old_order_s_s31+ $old_order_s_s32+ $old_order_s_s33+ $old_order_s_s34+ $old_order_s_s35+ $old_order_s_s36+ $old_order_s_s37+ $old_order_s_s38+ $old_order_s_s39+ $old_order_s_s40+ $old_order_s_s41+ $old_order_s_s42+ $old_order_s_s43+ $old_order_s_s44+ $old_order_s_s45+ $old_order_s_s46+ $old_order_s_s47+ $old_order_s_s48+ $old_order_s_s49+ $old_order_s_s50;

			$ext_ord_qty= $order_s_xs+ $order_s_s+ $order_s_m+ $order_s_l+ $order_s_xl+ $order_s_xxl+ $order_s_xxxl+ $order_s_s01+ $order_s_s02+ $order_s_s03+ $order_s_s04+ $order_s_s05+ $order_s_s06+ $order_s_s07+ $order_s_s08+ $order_s_s09+ $order_s_s10+ $order_s_s11+ $order_s_s12+ $order_s_s13+ $order_s_s14+ $order_s_s15+ $order_s_s16+ $order_s_s17+ $order_s_s18+ $order_s_s19+ $order_s_s20+ $order_s_s21+ $order_s_s22+ $order_s_s23+ $order_s_s24+ $order_s_s25+ $order_s_s26+ $order_s_s27+ $order_s_s28+ $order_s_s29+ $order_s_s30+ $order_s_s31+ $order_s_s32+ $order_s_s33+ $order_s_s34+ $order_s_s35+ $order_s_s36+ $order_s_s37+ $order_s_s38+ $order_s_s39+ $order_s_s40+ $order_s_s41+ $order_s_s42+ $order_s_s43+ $order_s_s44+ $order_s_s45+ $order_s_s46+ $order_s_s47+ $order_s_s48+ $order_s_s49+ $order_s_s50;			
		
			//$Total_cut_aty=$Total_cut_aty+$cut_qty;
			$sql1x="SELECT sum(sample) as sample FROM (select sum(ims_qty) as sample from $bai_pro3.ims_log where ims_schedule=\"$order_del_no\"  and ims_remarks in('SAMPLE')  union select sum(ims_qty) as sample from $bai_pro3.ims_log_backup where ims_schedule=\"$order_del_no\"  and ims_remarks in ('SAMPLE')) as g";
			$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error$sql1x".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1x=mysqli_fetch_array($sql_result1x))
			{
				$ims_sample=$sql_row1x['sample'];
			
				$sql2xy="select sum(balance) as balance, sum(input_qty) as input_qty, sum(output_qty) as output_qty from (select sum((ims_qty-ims_pro_qty)) as balance, sum(ims_qty) as input_qty, sum(ims_pro_qty) as output_qty from $bai_pro3.ims_log where ims_schedule=\"$order_del_no\" and ims_mod_no in ($section_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB') union select sum((ims_qty-ims_pro_qty)) as balance, sum(ims_qty) as input_qty, sum(ims_pro_qty) as output_qty from $bai_pro3.ims_log_backup where ims_schedule=\"$order_del_no\" and ims_mod_no in ($section_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB')) as t";
				//echo $sql2xy."<br/>";
				$sql_result2xy=mysqli_query($link, $sql2xy) or exit("Sql Error$sql2xy".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2xy=mysqli_fetch_array($sql_result2xy))
				{
					$loss_per=0;
					$balance_qty=$sql_row2xy['balance'];
					$ims_input=$sql_row2xy['input_qty'];
					$ims_output=$sql_row2xy['output_qty'];
					
					if(strlen($order_del_no)==0)
					{
						$order_del_no=0;
					}
					
					$sql223="SELECT sum((a_xs+ a_s+ a_m+ a_l+ a_xl+ a_xxl+ a_xxxl+ a_s01+ a_s02+ a_s03+ a_s04+ a_s05+ a_s06+ a_s07+ a_s08+ a_s09+ a_s10+ a_s11+ a_s12+ a_s13+ a_s14+ a_s15+ a_s16+ a_s17+ a_s18+ a_s19+ a_s20+ a_s21+ a_s22+ a_s23+ a_s24+ a_s25+ a_s26+ a_s27+ a_s28+ a_s29+ a_s30+ a_s31+ a_s32+ a_s33+ a_s34+ a_s35+ a_s36+ a_s37+ a_s38+ a_s39+ a_s40+ a_s41+ a_s42+ a_s43+ a_s44+ a_s45+ a_s46+ a_s47+ a_s48+ a_s49+ a_s50)*a_plies) as cut_qty FROM $bai_pro3.order_cat_doc_mix WHERE order_del_no in ($order_del_no) and category in (\"Body\",\"Front\")";
					//echo $sql223;
					// mysqli_query($link, $sql223) or exit("Sql Error232".mysqli_error($GLOBALS["___mysqli_ston"]));

					$sql_result223=mysqli_query($link, $sql223) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
					while($sql_row223=mysqli_fetch_array($sql_result223))
					{	
						$cut_qty_total=$sql_row223['cut_qty'];
						$cut_qty=$cut_qty_total-$ims_sample;
						
								
						$tot_ord_qty=$tot_ord_qty+$ord_qty;
						$tot_ext_ord_qty=$tot_ext_ord_qty+$ext_ord_qty;
						$tot_act_cut=$tot_act_cut+$cut_qty;
						$tot_ims_input=$tot_ims_input+$ims_input;
						$tot_ims_output=$tot_ims_output+$ims_output;
		                        
								
						if($ord_qty==0)
						{
							$ext_odr_qty_per=0;
						}
						else
						{
							$ext_odr_qty_per=round((($ext_ord_qty/$ord_qty)*100),2)-100;	
						}

						if($ims_input>0)
						{
							$loss=round((($balance_qty)/($ims_input)*100),2);
						}
						else
						{
						$loss=0;	
						}
							//	echo "<br/>Loss % =".$loss;

						if($ord_qty==0)
						{
							$ach_per=0;
						}
						else
						{
							$ach_per=round((((($cut_qty/$ord_qty)*100)-100)-$loss),2);	
						}
						
						
						if($ach_per<=0 || ($ims_input<=0 || $ims_output<=0))
						{
							$ach_per=0;
						}
								//echo "<br/>sample=".$ims_sample;
								//echo "<br/>total sample=".$tot_ims_sample;
								
					//			echo "<br/>schedule=".$order_del_no;
					//			echo "<br/>cutting=".$cut_qty." old ord qty=".$ord_qty." new ord qty=".$ext_ord_qty;
					//			echo "<br/>input=".$act_in."  output=".$output;
					//			echo "<br/>Ach%=".$ach_per;
					//			echo "<br/>ext order per%=".$ext_odr_qty_per; 
								
								
						if($ach_per>$ext_odr_qty_per)
						{
							$count++;
						}
			//			echo "<br/>count=".$count;
						//$fcount=$fcount+$count;
						if($ext_odr_qty_per>0)
						{
						$colour=round((($ach_per/$ext_odr_qty_per)*100),0);
						}
						else
						{
							$colour=0;
						}
					//			echo "<br/>colour %=".$colour;

					//			echo "<br/><br/>";
					//			unset($ext_odr_qty);
					//			unset($ach_per);
					//          unset($cut_qty);

					}
				}
			}
 		}
				//		echo "<br/><br/>";
				
			//	echo "<br/>all_old_order qty=".$tot_ord_qty;
			//	echo "<br/>all_ext_ord qty=".$tot_ext_ord_qty;
			//	echo "<br/>all_cut qty=".$tot_act_cut;
			//	echo "<br/>tot ims input=".$tot_ims_input;
			//	echo "<br/>tot ims output=".$tot_ims_output;
			//	echo "total cut qty=".$Total_cut_aty;
				if($tot_ord_qty)//if tot_ord_qty < 0 below statement works
				    $tot_ext_odr_qty_per=round((($tot_ext_ord_qty/$tot_ord_qty)*100),2)-100;

				if($tot_ims_input>0 && $tot_ims_output>0)
				{
				$tot_loss=round((($tot_ims_input-$tot_ims_output)/($tot_ims_input)*100),2);
				}
				else
				{
				$tot_loss=0;	
				}
                if($tot_ord_qty)//if tot_ord_qty < 0 below statement works 
				    $tot_ach_per=round((((($Total_cut_aty/$tot_ord_qty)*100)-100)-$tot_loss),2);
			
		//		echo "<br/> Total order%".$tot_ext_odr_qty_per;
		//		echo "<br/>total Ach%= ".$tot_ach_per;
				if($tot_ach_per<=0 || ($tot_act_in<=0 || $tot_act_out<=0) )
				{
					$tot_ach_per=0;
				}
		//	    echo "<br/>total count=".$fcount;
				return array($tot_ach_per,$count);
}


function ims_schedules_input2($link,$section_mods,$schedule_no)
{
	    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		$ord_qty=0;
        $ext_ord_qty=0;
		$ext_per_qty=0;
		$count=0;
		$tot_ext_ord_qty=0;
		$tot_act_cut=0;
		$tot_ord_qty=0;
		$tot_act_in=0;
		$tot_act_out=0;
		$fcount=0;
		unset($colour);
		//echo "<br/>schedule=".$string1;

		// $sql24="select order_style_no,act_in,output,act_cut,order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_s06,order_s_s08,order_s_s10,order_s_s12,order_s_s14,order_s_s16,order_s_s18,order_s_s20,order_s_s22,order_s_s24,order_s_s26,order_s_s28,order_s_s30,old_order_s_xs,old_order_s_s,old_order_s_m,old_order_s_l,old_order_s_xl,old_order_s_xxl,old_order_s_s06,old_order_s_s08,old_order_s_s10,old_order_s_s12,old_order_s_s14,old_order_s_s16,old_order_s_s18,old_order_s_s20,old_order_s_s22,old_order_s_s24,old_order_s_s26,old_order_s_s28,old_order_s_s30 from bai_pro3.bai_orders_db_confirm where order_del_no in ($schedule_no)";
		$sql24="select order_style_no,order_del_no,act_in,output,act_cut, order_s_xs, order_s_s, order_s_m, order_s_l, order_s_xl, order_s_xxl, order_s_xxxl, order_s_s01, order_s_s02, order_s_s03, order_s_s04, order_s_s05, order_s_s06, order_s_s07, order_s_s08, order_s_s09, order_s_s10, order_s_s11, order_s_s12, order_s_s13, order_s_s14, order_s_s15, order_s_s16, order_s_s17, order_s_s18, order_s_s19, order_s_s20, order_s_s21, order_s_s22, order_s_s23, order_s_s24, order_s_s25, order_s_s26, order_s_s27, order_s_s28, order_s_s29, order_s_s30, order_s_s31, order_s_s32, order_s_s33, order_s_s34, order_s_s35, order_s_s36, order_s_s37, order_s_s38, order_s_s39, order_s_s40, order_s_s41, order_s_s42, order_s_s43, order_s_s44, order_s_s45, order_s_s46, order_s_s47, order_s_s48, order_s_s49, order_s_s50, old_order_s_xs, old_order_s_s, old_order_s_m, old_order_s_l, old_order_s_xl, old_order_s_xxl, old_order_s_xxxl, old_order_s_s01, old_order_s_s02, old_order_s_s03, old_order_s_s04, old_order_s_s05, old_order_s_s06, old_order_s_s07, old_order_s_s08, old_order_s_s09, old_order_s_s10, old_order_s_s11, old_order_s_s12, old_order_s_s13, old_order_s_s14, old_order_s_s15, old_order_s_s16, old_order_s_s17, old_order_s_s18, old_order_s_s19, old_order_s_s20, old_order_s_s21, old_order_s_s22, old_order_s_s23, old_order_s_s24, old_order_s_s25, old_order_s_s26, old_order_s_s27, old_order_s_s28, old_order_s_s29, old_order_s_s30, old_order_s_s31, old_order_s_s32, old_order_s_s33, old_order_s_s34, old_order_s_s35, old_order_s_s36, old_order_s_s37, old_order_s_s38, old_order_s_s39, old_order_s_s40, old_order_s_s41, old_order_s_s42, old_order_s_s43, old_order_s_s44, old_order_s_s45, old_order_s_s46, old_order_s_s47, old_order_s_s48, old_order_s_s49, old_order_s_s50 from $bai_pro3.bai_orders_db_confirm where order_del_no in ($schedule_no)";
		//echo $sql24;
		// mysqli_query($link, $sql24) or exit("Sql Error24.1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result24=mysqli_query($link, $sql24) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
		while($sql_row24=mysqli_fetch_array($sql_result24))
		{
			$order_s_xs=$sql_row24['order_s_xs'];
			$order_s_s=$sql_row24['order_s_s'];
			$order_s_m=$sql_row24['order_s_m'];
			$order_s_l=$sql_row24['order_s_l'];
			$order_s_xl=$sql_row24['order_s_xl'];
			$order_s_xxl=$sql_row24['order_s_xxl'];
			$order_s_xxxl=$sql_row24['order_s_xxxl'];
			$order_s_s01=$sql_row24['order_s_s01'];
			$order_s_s02=$sql_row24['order_s_s02'];
			$order_s_s03=$sql_row24['order_s_s03'];
			$order_s_s04=$sql_row24['order_s_s04'];
			$order_s_s05=$sql_row24['order_s_s05'];
			$order_s_s06=$sql_row24['order_s_s06'];
			$order_s_s07=$sql_row24['order_s_s07'];
			$order_s_s08=$sql_row24['order_s_s08'];
			$order_s_s09=$sql_row24['order_s_s09'];
			$order_s_s10=$sql_row24['order_s_s10'];
			$order_s_s11=$sql_row24['order_s_s11'];
			$order_s_s12=$sql_row24['order_s_s12'];
			$order_s_s13=$sql_row24['order_s_s13'];
			$order_s_s14=$sql_row24['order_s_s14'];
			$order_s_s15=$sql_row24['order_s_s15'];
			$order_s_s16=$sql_row24['order_s_s16'];
			$order_s_s17=$sql_row24['order_s_s17'];
			$order_s_s18=$sql_row24['order_s_s18'];
			$order_s_s19=$sql_row24['order_s_s19'];
			$order_s_s20=$sql_row24['order_s_s20'];
			$order_s_s21=$sql_row24['order_s_s21'];
			$order_s_s22=$sql_row24['order_s_s22'];
			$order_s_s23=$sql_row24['order_s_s23'];
			$order_s_s24=$sql_row24['order_s_s24'];
			$order_s_s25=$sql_row24['order_s_s25'];
			$order_s_s26=$sql_row24['order_s_s26'];
			$order_s_s27=$sql_row24['order_s_s27'];
			$order_s_s28=$sql_row24['order_s_s28'];
			$order_s_s29=$sql_row24['order_s_s29'];
			$order_s_s30=$sql_row24['order_s_s30'];
			$order_s_s31=$sql_row24['order_s_s31'];
			$order_s_s32=$sql_row24['order_s_s32'];
			$order_s_s33=$sql_row24['order_s_s33'];
			$order_s_s34=$sql_row24['order_s_s34'];
			$order_s_s35=$sql_row24['order_s_s35'];
			$order_s_s36=$sql_row24['order_s_s36'];
			$order_s_s37=$sql_row24['order_s_s37'];
			$order_s_s38=$sql_row24['order_s_s38'];
			$order_s_s39=$sql_row24['order_s_s39'];
			$order_s_s40=$sql_row24['order_s_s40'];
			$order_s_s41=$sql_row24['order_s_s41'];
			$order_s_s42=$sql_row24['order_s_s42'];
			$order_s_s43=$sql_row24['order_s_s43'];
			$order_s_s44=$sql_row24['order_s_s44'];
			$order_s_s45=$sql_row24['order_s_s45'];
			$order_s_s46=$sql_row24['order_s_s46'];
			$order_s_s47=$sql_row24['order_s_s47'];
			$order_s_s48=$sql_row24['order_s_s48'];
			$order_s_s49=$sql_row24['order_s_s49'];
			$order_s_s50=$sql_row24['order_s_s50'];


			$old_order_s_xs=$sql_row24['old_order_s_xs'];
			$old_order_s_s=$sql_row24['old_order_s_s'];
			$old_order_s_m=$sql_row24['old_order_s_m'];
			$old_order_s_l=$sql_row24['old_order_s_l'];
			$old_order_s_xl=$sql_row24['old_order_s_xl'];
			$old_order_s_xxl=$sql_row24['old_order_s_xxl'];
			$old_order_s_xxxl=$sql_row24['old_order_s_xxxl'];
			$old_order_s_s01=$sql_row24['old_order_s_s01'];
			$old_order_s_s02=$sql_row24['old_order_s_s02'];
			$old_order_s_s03=$sql_row24['old_order_s_s03'];
			$old_order_s_s04=$sql_row24['old_order_s_s04'];
			$old_order_s_s05=$sql_row24['old_order_s_s05'];
			$old_order_s_s06=$sql_row24['old_order_s_s06'];
			$old_order_s_s07=$sql_row24['old_order_s_s07'];
			$old_order_s_s08=$sql_row24['old_order_s_s08'];
			$old_order_s_s09=$sql_row24['old_order_s_s09'];
			$old_order_s_s10=$sql_row24['old_order_s_s10'];
			$old_order_s_s11=$sql_row24['old_order_s_s11'];
			$old_order_s_s12=$sql_row24['old_order_s_s12'];
			$old_order_s_s13=$sql_row24['old_order_s_s13'];
			$old_order_s_s14=$sql_row24['old_order_s_s14'];
			$old_order_s_s15=$sql_row24['old_order_s_s15'];
			$old_order_s_s16=$sql_row24['old_order_s_s16'];
			$old_order_s_s17=$sql_row24['old_order_s_s17'];
			$old_order_s_s18=$sql_row24['old_order_s_s18'];
			$old_order_s_s19=$sql_row24['old_order_s_s19'];
			$old_order_s_s20=$sql_row24['old_order_s_s20'];
			$old_order_s_s21=$sql_row24['old_order_s_s21'];
			$old_order_s_s22=$sql_row24['old_order_s_s22'];
			$old_order_s_s23=$sql_row24['old_order_s_s23'];
			$old_order_s_s24=$sql_row24['old_order_s_s24'];
			$old_order_s_s25=$sql_row24['old_order_s_s25'];
			$old_order_s_s26=$sql_row24['old_order_s_s26'];
			$old_order_s_s27=$sql_row24['old_order_s_s27'];
			$old_order_s_s28=$sql_row24['old_order_s_s28'];
			$old_order_s_s29=$sql_row24['old_order_s_s29'];
			$old_order_s_s30=$sql_row24['old_order_s_s30'];
			$old_order_s_s31=$sql_row24['old_order_s_s31'];
			$old_order_s_s32=$sql_row24['old_order_s_s32'];
			$old_order_s_s33=$sql_row24['old_order_s_s33'];
			$old_order_s_s34=$sql_row24['old_order_s_s34'];
			$old_order_s_s35=$sql_row24['old_order_s_s35'];
			$old_order_s_s36=$sql_row24['old_order_s_s36'];
			$old_order_s_s37=$sql_row24['old_order_s_s37'];
			$old_order_s_s38=$sql_row24['old_order_s_s38'];
			$old_order_s_s39=$sql_row24['old_order_s_s39'];
			$old_order_s_s40=$sql_row24['old_order_s_s40'];
			$old_order_s_s41=$sql_row24['old_order_s_s41'];
			$old_order_s_s42=$sql_row24['old_order_s_s42'];
			$old_order_s_s43=$sql_row24['old_order_s_s43'];
			$old_order_s_s44=$sql_row24['old_order_s_s44'];
			$old_order_s_s45=$sql_row24['old_order_s_s45'];
			$old_order_s_s46=$sql_row24['old_order_s_s46'];
			$old_order_s_s47=$sql_row24['old_order_s_s47'];
			$old_order_s_s48=$sql_row24['old_order_s_s48'];
			$old_order_s_s49=$sql_row24['old_order_s_s49'];
			$old_order_s_s50=$sql_row24['old_order_s_s50'];
			$style=$sql_row24['order_style_no'];	
			$act_in=$sql_row24['act_in'];
			$output=$sql_row24['output'];
			$act_cut=$sql_row24['act_cut'];

			$ord_qty= $old_order_s_xs+ $old_order_s_s+ $old_order_s_m+ $old_order_s_l+ $old_order_s_xl+ $old_order_s_xxl+ $old_order_s_xxxl+ $old_order_s_s01+ $old_order_s_s02+ $old_order_s_s03+ $old_order_s_s04+ $old_order_s_s05+ $old_order_s_s06+ $old_order_s_s07+ $old_order_s_s08+ $old_order_s_s09+ $old_order_s_s10+ $old_order_s_s11+ $old_order_s_s12+ $old_order_s_s13+ $old_order_s_s14+ $old_order_s_s15+ $old_order_s_s16+ $old_order_s_s17+ $old_order_s_s18+ $old_order_s_s19+ $old_order_s_s20+ $old_order_s_s21+ $old_order_s_s22+ $old_order_s_s23+ $old_order_s_s24+ $old_order_s_s25+ $old_order_s_s26+ $old_order_s_s27+ $old_order_s_s28+ $old_order_s_s29+ $old_order_s_s30+ $old_order_s_s31+ $old_order_s_s32+ $old_order_s_s33+ $old_order_s_s34+ $old_order_s_s35+ $old_order_s_s36+ $old_order_s_s37+ $old_order_s_s38+ $old_order_s_s39+ $old_order_s_s40+ $old_order_s_s41+ $old_order_s_s42+ $old_order_s_s43+ $old_order_s_s44+ $old_order_s_s45+ $old_order_s_s46+ $old_order_s_s47+ $old_order_s_s48+ $old_order_s_s49+ $old_order_s_s50;

			$ext_ord_qty= $order_s_xs+ $order_s_s+ $order_s_m+ $order_s_l+ $order_s_xl+ $order_s_xxl+ $order_s_xxxl+ $order_s_s01+ $order_s_s02+ $order_s_s03+ $order_s_s04+ $order_s_s05+ $order_s_s06+ $order_s_s07+ $order_s_s08+ $order_s_s09+ $order_s_s10+ $order_s_s11+ $order_s_s12+ $order_s_s13+ $order_s_s14+ $order_s_s15+ $order_s_s16+ $order_s_s17+ $order_s_s18+ $order_s_s19+ $order_s_s20+ $order_s_s21+ $order_s_s22+ $order_s_s23+ $order_s_s24+ $order_s_s25+ $order_s_s26+ $order_s_s27+ $order_s_s28+ $order_s_s29+ $order_s_s30+ $order_s_s31+ $order_s_s32+ $order_s_s33+ $order_s_s34+ $order_s_s35+ $order_s_s36+ $order_s_s37+ $order_s_s38+ $order_s_s39+ $order_s_s40+ $order_s_s41+ $order_s_s42+ $order_s_s43+ $order_s_s44+ $order_s_s45+ $order_s_s46+ $order_s_s47+ $order_s_s48+ $order_s_s49+ $order_s_s50;


			$sql1x="SELECT sum(sample) as sample FROM (select sum(ims_qty) as sample from $bai_pro3.ims_log where ims_schedule=\"$schedule_no\"  and ims_remarks in('SAMPLE')  union select sum(ims_qty) as sample from $bai_pro3.ims_log_backup where ims_schedule=\"$schedule_no\"  and ims_remarks in ('SAMPLE')) as g";
			$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error$sql1x".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1x=mysqli_fetch_array($sql_result1x))
			{
				$ims_sample1=$sql_row1x['sample'];
				//    echo "<br/>smaple=".$ims_sample1;
				
				$sql2xy="select sum(balance) as balance, sum(input_qty) as input_qty, sum(output_qty) as output_qty from (select sum((ims_qty-ims_pro_qty)) as balance, sum(ims_qty) as input_qty, sum(ims_pro_qty) as output_qty from $bai_pro3.ims_log where ims_schedule=\"$schedule_no\" and ims_mod_no in ($section_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB') union select sum((ims_qty-ims_pro_qty)) as balance, sum(ims_qty) as input_qty, sum(ims_pro_qty) as output_qty from $bai_pro3.ims_log_backup where ims_schedule=\"$schedule_no\" and ims_mod_no in ($section_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB')) as t";
				//echo $sql2xy;
				$sql_result2xy=mysqli_query($link, $sql2xy) or exit("Sql Error$sql2xy".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2xy=mysqli_fetch_array($sql_result2xy))
				{
					$loss_per=0;
					$balance_qty=$sql_row2xy['balance'];
					$ims_input=$sql_row2xy['input_qty'];
					$ims_output=$sql_row2xy['output_qty'];
					
					
					$sql223="SELECT sum((a_xs+ a_s+ a_m+ a_l+ a_xl+ a_xxl+ a_xxxl+ a_s01+ a_s02+ a_s03+ a_s04+ a_s05+ a_s06+ a_s07+ a_s08+ a_s09+ a_s10+ a_s11+ a_s12+ a_s13+ a_s14+ a_s15+ a_s16+ a_s17+ a_s18+ a_s19+ a_s20+ a_s21+ a_s22+ a_s23+ a_s24+ a_s25+ a_s26+ a_s27+ a_s28+ a_s29+ a_s30+ a_s31+ a_s32+ a_s33+ a_s34+ a_s35+ a_s36+ a_s37+ a_s38+ a_s39+ a_s40+ a_s41+ a_s42+ a_s43+ a_s44+ a_s45+ a_s46+ a_s47+ a_s48+ a_s49+ a_s50)*a_plies) as cut_qty FROM $bai_pro3.order_cat_doc_mix WHERE order_del_no in ($schedule_no) and category in (\"Body\",\"Front\")";

					// mysqli_query($link, $sql223) or exit("Sql Error233".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result223=mysqli_query($link, $sql223) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
					while($sql_row223=mysqli_fetch_array($sql_result223))
					{	
							
						$cut_qty_total=$sql_row223['cut_qty'];
						$cut_qty=$cut_qty_total-$ims_sample1;
					
						//	echo "<br/>cut qty=".$cut_qty;
									
						$tot_ord_qty=$tot_ord_qty+$ord_qty;
						$tot_ext_ord_qty=$tot_ext_ord_qty+$ext_ord_qty;
						$tot_act_cut=$tot_act_cut+$cut_qty;
						$tot_ims_input=$tot_ims_input+$ims_input;
						$tot_ims_output=$tot_ims_output+$ims_output;
		                
						if($ord_qty==0)
						{
							$ext_odr_qty_per=0;
						}
						else
						{
							$ext_odr_qty_per=round((($ext_ord_qty/$ord_qty)*100),2)-100;	
						}
									

						if($ims_input>0)
						{
						$loss=round((($balance_qty)/($ims_input)*100),2);
						}
						else
						{
						$loss=0;	
						}
						//			echo "<br/>Loss % =".$loss;
									
						if($ord_qty==0)
						{
							$ach_per=0;
						}
						else
						{
							$ach_per=round((((($cut_qty/$ord_qty)*100)-100)-$loss),2);	
						}
						
						
						if($ach_per<=0.00 || ($ims_input<=0 || $ims_output<=0))
						{
							$ach_per=0;
						}
									
						//			echo "<br/>sample=".$ims_sample;
						//			echo "<br/>schedule=".$schedule_no;
						//			echo "<br/>balance=".$balance_qty;
						//			echo "<br/>ims input=".$ims_input;
						//			echo "<br/>ims output=".$ims_output;
						//			echo "<br/>cutting=".$cut_qty." old ord qty=".$ord_qty." new ord qty=".$ext_ord_qty;
						//			echo "<br/>input=".$act_in."  output=".$output;
						//			echo "<br/>ext order per%=".$ext_odr_qty_per; 
						//			echo "<br/>Ach%=".$ach_per;
									
						if($ach_per>$ext_odr_qty_per)
						{
							$count++;
						//				$fcount=$fcount+$count;
						}
						//			echo "<br/>2nd count=".$count;
						//			$fcount=$fcount+$count;
						if($ext_odr_qty_per>0)
						{
						$colour=round((($ach_per/$ext_odr_qty_per)*100),0);
						}
						else
						{
							$colour=0;
						}
						//		echo "<br/>colour %=".$colour;
								
						//		echo "<br/><br/>";
					
						//echo "<br/>final colour %=".$colour;
					}
				}
			}
		}		
			//echo "<br/>final count %=".$fcount;
			return array($colour,$style,$schedule_no,$ims_input,$ims_output,$cut_qty,$ord_qty,$ext_ord_qty,$ext_odr_qty_per,$loss,$ach_per);		
}

?>