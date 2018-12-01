<!--
Date : 2014-01-18;
Task : Created File for Generate Automatic Buyer Level Calculation on Effciency Report;
Ticket #815663

//Change Request#145/kirang/2014-08-13/Round up the values up to 2 decimals in efficiency, SAH and Grand efficiency report//service request #466334/ 2014-08-18 / kirang / Actual Eff % taken from Actual Clock hours.  
 -->
<?php
//echo "DB name : ".$bai_pro."</br>";
$sql="select * from $bai_pro.unit_db where unit_id='Factory'";
mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$sec_code=$sql_row['unit_members'];
}
//Takes the Buyer names in selected time period
$sql_buyer="select distinct buyer as buyer from $bai_pro.grand_rep where date between \"$date\" and \"$edate\" order by buyer";
$sql_result_buyer=mysqli_query($link, $sql_buyer) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_buyer=mysqli_fetch_array($sql_result_buyer))
{
	$buyer_sel=$sql_row_buyer['buyer'];
	$x_sec_divs=0;
	$h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
	$h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24);
	$avail_A=0;
	$avail_B=0;
	$absent_A=0;
	$absent_B=0;
	$totalmodules=0;
	$operatorssum=0;
	$rew_A=0;
	$rew_B=0;
	$auf_A=0;
	$auf_B=0;
	$pclha_total=0;
	$pclhb_total=0;
	$pstha_total=0;
	$psthb_total=0;

	$offsthb_sum=0;
	$offstha_sum=0;

	$avail_A_clk=0;
	$avail_B_clk=0;
	$absent_A_clk=0;
	$absent_B_clk=0;
	$act_clock_hrs1=0;

	$sql="select distinct module from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in(".$sec_code.") and date between \"$date\" and \"$edate\" order by module";
	//echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$peff_a_total=0;
	$peff_b_total=0;
	$peff_g_total=0;
	$ppro_a_total=0;
	$ppro_b_total=0;
	$ppro_g_total=0;
	$clha_total=0;
	$clhb_total=0;
	$clhg_total=0;
	$stha_total=0;
	$sthb_total=0;
	$sthg_total=0;
	$effa_total=0;
	$effb_total=0;
	$effg_total=0;

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod=$sql_row['module'];
		$style=$sql_row['mod_style'];
		$max=0;
		$sql2="select smv,nop,styles, SUBSTRING_INDEX(max_style,'^',-1) as style_no, buyer, days, act_out from $bai_pro.grand_rep where shift=\"A\" AND buyer=\"$buyer_sel\" and module=$mod and date between \"$date\" and \"$edate\"";
		//echo $sql2."-".$mod."=".$buyer_sel."<br>";
		mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			if($sql_row2['act_out']>$max)
			{
				$max=$sql_row2['act_out'];
				$smv=$sql_row2['smv'];
				$nop=round($sql_row2['nop'],0);
				//$total_nop=$total_nop+$nop;
			}
			else
			{
				$smv=$sql_row2['smv'];
				$nop=round($sql_row2['nop'],0);
				//$total_nop=$total_nop+$nop;
			}		
		
			$styledb=$sql_row2['styles'];
			$styledb_no=$sql_row2['style_no'];
			//echo $styledb;
			$buyerdb=$sql_row2['buyer'];
			$age=$sql_row2['days'];
		}
		
		//echo $nop."<br>";
		$grand_total_nop_x=$grand_total_nop_x+$nop;

		$sqlA="select sum(present+jumper) as avail_A,sum(absent) as absent_A from $bai_pro.pro_attendance where module=$mod and shift=\"A\" and  date in (\"".implode('","',$date_range)."\")";
		$sql_resultA=mysqli_query($link, $sqlA) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowA=mysqli_fetch_array($sql_resultA))
		{
			$avail_A=$avail_A+$sql_rowA['avail_A'];
			$avail_A_clk=$sql_rowA['avail_A'];
			$absent_A=$absent_A+$sql_rowA['absent_A'];
			$absent_A_clk=$sql_rowA['absent_A'];
		}

		$sqlB="select sum(present+jumper) as avail_B,sum(absent) as absent_B from $bai_pro.pro_attendance where module=$mod and shift=\"B\" and  date in (\"".implode('","',$date_range)."\")";
		$sql_resultB=mysqli_query($link, $sqlB) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowB=mysqli_fetch_array($sql_resultB))
		{
			$avail_B=$avail_B+$sql_rowB['avail_B'];
			$avail_B_clk=$sql_rowB['avail_B'];
			$absent_B=$absent_B+$sql_rowB['absent_B'];
			$absent_B_clk=$sql_rowB['absent_B'];
		}
		
		$sql132="select act_hours as hrs from $bai_pro.pro_plan where mod_no=$mod and shift=\"A\" and date between \"$date\" and \"$edate\" ";
		//echo $sql132."<br>";
		$result132=mysqli_query($link, $sql132) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row132=mysqli_fetch_array($result132))
		{
			$act_hrsa1=$sql_row132["hrs"];
			//echo $act_hrsa."-".($sql_row2['avail_A']-$sql_row2['absent_A'])."<br>";	
		}

		$sql133="select act_hours as hrs from $bai_pro.pro_plan where mod_no=$mod and shift=\"B\" and date between \"$date\" and \"$edate\" ";
		//echo $sql133."<br>";
		$result133=mysqli_query($link, $sql133) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row133=mysqli_fetch_array($result133))
		{
			$act_hrsb1=$sql_row133["hrs"];	
			//echo $act_hrsb."<br>";
		}
					
		$act_clock_hrs1=$act_clock_hrs1+($act_hrsa1*($avail_A_clk-$absent_A_clk))+($act_hrsb1*($avail_B_clk-$absent_B_clk));

		$sql_num_check=mysqli_num_rows($sql_result2);

		$sql2="select avg(rew_A) as \"rew_A\", avg(rew_B) as \"rew_B\", sum(auf_A) as \"auf_A\", sum(auf_B) as \"auf_B\" from $bai_pro.pro_quality where module=$mod and date between \"$date\" and \"$edate\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{

			$rew_A=$rew_A+round($sql_row2['rew_A'],0);
			$rew_B=$rew_B+round($sql_row2['rew_B'],0);


			$auf_A=$auf_A+$sql_row2['auf_A'];
			$auf_B=$auf_B+$sql_row2['auf_B'];

		}

		$sql_num_check=mysqli_num_rows($sql_result2);

		$gtotal=0;
		$atotal=0;
		$btotal=0;

		/* GRAND REP INCLUDE */
		$stha=0;
		$clha=0;
		$effa=0;
		$sthb=0;
		$clhb=0;
		$effb=0;
		$peff_a=0;
		$peff_b=0;
		$ppro_a=0;
		$ppro_b=0;
		$pclha=0;
		$pclhb=0;
		$pstha=0;
		$psthb=0;
		$pstha_fac_total=0;
		$psthb_fac_total=0;
	
	
		$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and module=$mod and date between \"$date\" and \"$edate\" and shift=\"A\"";
		mysqli_query($link, $sql2) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$atotal=$sql_row2['act_out'];
			$stha=$sql_row2['act_sth'];
			$clha=$sql_row2['act_clh'];
			
			$pclha=$sql_row2['plan_clh'];
			$pstha=$sql_row2['plan_sth'];		
			$peff_a=($pstha/$pclha)*100;
			$ppro_a=$sql_row2['plan_out'];
			$effa=($stha/$pclha)*100;
		}
		
		$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and module=$mod and date between \"$date\" and \"$edate\" and shift=\"B\"";
		mysqli_query($link, $sql2) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$btotal=$sql_row2['act_out'];
			$sthb=$sql_row2['act_sth'];
			$clhb=$sql_row2['act_clh'];
			
			$pclhb=$sql_row2['plan_clh'];
			$psthb=$sql_row2['plan_sth'];			
			$peff_b=($psthb/$pclhb)*100;
			$ppro_b=$sql_row2['plan_out'];
			$effb=($sthb/$pclhb)*100;
		}
		
		$sql2="select avg(nop) as \"nop\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and module=$mod and date in (\"".implode('","',$date_range)."\")";
		mysqli_query($link, $sql2) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error19".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$nop=$sql_row2['nop'];
			$operatorssum=$operatorssum+$nop;
		}
	
		/* GRAND REP INCLUDE */

		$offstha=0;
		$offsthb=0;

		$sql2="select sum(dtime) as \"offstha\" from $bai_pro.down_log where shift=\"A\" and date between \"$date\" and \"$edate\" and mod_no=$mod";
		mysqli_query($link, $sql2) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$offstha=$sql_row2['offstha'];
		}

		if($offstha==NULL)
		{
			$offstha=0;
		}
		$offstha_sum=$offstha_sum+$offstha;

		$sql2="select sum(dtime) as \"offsthb\" from $bai_pro.down_log where shift=\"B\" and date between \"$date\" and \"$edate\" and mod_no=$mod";
		mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$offsthb=$sql_row2['offsthb'];
		}

		if($offsthb==NULL)
		{
			$offsthb=0;
		}

		$offsthb_sum=$offsthb_sum+$offsthb;

		$pclha_total=$pclha_total+$pclha;
		$pclhb_total=$pclhb_total+$pclhb;

		$pstha_total=$pstha_total+round($pstha,$decimal_factor);
		$psthb_total=$psthb_total+round($psthb,$decimal_factor);

		$peff_a_total=$peff_a_total+$peff_a;
		$peff_b_total=$peff_b_total+$peff_b;
		$peff_g_total=$peff_a_total+$peff_b_total;

		$ppro_a_total=$ppro_a_total+$ppro_a;
		$ppro_b_total=$ppro_b_total+$ppro_b;
		$ppro_g_total=$ppro_a_total+$ppro_b_total;

		$clha_total=$clha_total+$clha;
		$clhb_total=$clhb_total+$clhb;
		$clhg_total=$clha_total+$clhb_total;

		$stha_total=$stha_total+round($stha,2);
		$sthb_total=$sthb_total+round($sthb,2);
		$sthg_total=$stha_total+$sthb_total;

		$effa_total=$effa_total+round(($effa*100),2);
		$effb_total=$effb_total+round(($effb*100),2);
		$effg_total=$effa_total+$effb_total;

		$totalmodules=$totalmodules+1;
	}

	$total=0;
	$btotal=0;
	$atotal=0;
	$pclha=0;
	$pclhb=0;
	$pstha=0;
	$psthb=0;
	//$phours=7.5;
	$peff_a_total=0;
	$peff_b_total=0;
	
	$sql2x="select ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and module in (92) and date between \"$date\" and \"$edate\" and shift=\"A\"";
	//echo $sql2x;
	$sql_result2x=mysqli_query($link, $sql2x) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2x=mysqli_fetch_array($sql_result2x))
	{
		$clha_92=$sql_row2x['act_clh'];			
		$pclha_92=$sql_row2x['plan_clh'];
	}
	
	$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"A\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$atotal=$sql_row2['act_out'];
		$stha=$sql_row2['act_sth'];
		$clha=$sql_row2['act_clh']-$clha_92;
		
		$pclha=$sql_row2['plan_clh']-$pclha_92;
		$pstha=$sql_row2['plan_sth'];		
		$peff_a=($pstha/$pclha)*100;
		$ppro_a=$sql_row2['plan_out'];
		$effa=($stha/$pclha)*100;
	}
	
	if($buyer_name == "ALL")
	{
		$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"A\" group by date,module";
	}
	else
	{
		$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"A\" group by date,module";
	//echo $sql2;	
	}
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error29".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$pstha_fac_total=$pstha_fac_total+round($sql_row2['plan_sth'],$decimal_factor);	
	}
	
	$sql2x="select  ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and module in (92) and date between \"$date\" and \"$edate\" and shift=\"B\"";
	$sql_result2x=mysqli_query($link, $sql2x) or exit("Sql Error31".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2x=mysqli_fetch_array($sql_result2x))
	{
		$clhb_92=$sql_row2x['act_clh'];			
		$pclhb_92=$sql_row2x['plan_clh'];
	}
	
	$sql2="select  sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\"  from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"B\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$btotal=$sql_row2['act_out'];
		$sthb=$sql_row2['act_sth'];
		$clhb=$sql_row2['act_clh']-$clhb_92;
		
		$pclhb=$sql_row2['plan_clh']-$pclhb_92;
		$psthb=$sql_row2['plan_sth'];			
		$peff_b=($psthb/$pclhb)*100;
		$ppro_b=$sql_row2['plan_out'];
		$effb=($sthb/$pclhb)*100;
	}
	
	if($buyer_name == "ALL")
	{
		$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"B\" group by date,module";
	}
	else
	{
		$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where buyer=\"$buyer_sel\" and section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"B\" and buyer like \"%".$buyer_name."%\" group by date,module";
	//echo $sql2;	
	}
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error35".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$psthb_fac_total=$psthb_fac_total+round($sql_row2['plan_sth'],0);	
	}
		
	$total=$atotal+$btotal;



	$table_temp="<tr height=22 style='mso-height-source:userset;height:16.5pt'>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td colspan=3 rowspan=2 height=44 class=xl15326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;   border-bottom:1.0pt solid black;height:33.0pt'>$buyer_sel</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td rowspan=2 height=44 class=xl15326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;   border-bottom:1.0pt solid black;height:33.0pt'></td>";
	echo $table_temp;
	$table.=$table_temp;

	$table_temp="<td height=44 class=xl15326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;   border-bottom:1.0pt solid black;height:16.5pt'></td>";
	echo $table_temp;
	$table.=$table_temp;
	//if($i2 == 6)
	//{
	$x_sec_divs=$x_sec_divs+1;
	/*}
	else
	{
	$div=1;
	}*/
	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round($grand_total_nop_x,0)."</td>";
	echo $table_temp;
	$table.=$table_temp;

	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".($avail_A-$absent_A)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".($avail_B-$absent_B)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	/* $table_temp="<td class=xl15326424>".$absent_A."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl15326424>".$absent_B."</td>";
	echo $table_temp;
	$table.=$table_temp;

	if($avail_A>0)
	{
	$table_temp="<td class=xl16726424>".round(($absent_A/$avail_A)*100,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	}
	else
	{
	$table_temp="<td class=xl16726424>0%</td>";
	echo $table_temp;
	$table.=$table_temp;
	}

	if($avail_B>0)
	{
	$table_temp="<td class=xl16726424>".round(($absent_B/$avail_B)*100,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	}
	else
	{
	$table_temp="<td class=xl16726424>0%</td>";
	echo $table_temp;
	$table.=$table_temp;
	}*/

	$table_temp="<td class=xl16726424 style='background-color:#5A5A5A'>".round($rew_A/$totalmodules,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl16726424 style='background-color:#5A5A5A'>".round($rew_B/$totalmodules,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$auf_A."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$auf_B."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($pclha_total,$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($pclhb_total,$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;


	$table_temp="<td rowspan=2 class=xl15926424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".round(($ppro_a_total+$ppro_b_total),0)."</td>";
	echo $table_temp;
	$table.=$table_temp;



	$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$atotal."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$btotal."</td>";
	echo $table_temp;
	$table.=$table_temp;


	$table_temp="<td rowspan=2 class=xl15926424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".($pstha_fac_total+$psthb_fac_total)."</td>";
	echo $table_temp;
	$table.=$table_temp;



	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".($pstha_fac_total)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round($stha_total,$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".($psthb_fac_total)."</td>";
	echo $table_temp;
	$table.=$table_temp;


	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round($sthb_total,$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;





	$peffresulta=0;
	$peffresultb=0;

	if($ppro_a_total>0 && $pclha>0)
	{
		$peffresulta=(round(($pstha_total/$pclha_total)*100,0));
	}

	if($ppro_b_total>0 && $pclhb>0)
	{
		$peffresultb=(round(($psthb_total/$pclhb_total)*100,0));
	}

	if(($pclha_total+$pclhb_total)>0)
	{

		$table_temp="<td rowspan=2 class=xl16126424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".round((($pstha_total+$psthb_total)/($pclha_total+$pclhb_total))*100,0)."%</td>";
		echo $table_temp;
		$table.=$table_temp;
	}
	else
	{
		$table_temp="<td rowspan=2 class=xl15326424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>0%</td>";
		echo $table_temp;
		$table.=$table_temp;
	}

	$xa=0;
	$xb=0;
	if($clha_total>0)
	{
		$xa=round(($stha_total/$pclha_total)*100,2);
	}


	if($clhb_total>0)
	{
		$xb=round(($sthb_total/$pclhb_total)*100,2);
	}

	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round($ppro_a_total,0)."</td>";
	echo $table_temp;
	$table.=$table_temp;
    $table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round($peffresulta,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	/*$table_temp="<td class=xl9826424>".round($xa,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;*/
	//$table_temp="<td class=xl9826424>".$xa_actual."%</td>";
	$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round(($stha/(($avail_A-$absent_A)*7.5))*100,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	/*$table_temp="<td class=xl15326424>".($clha)."</td>";
	echo $table_temp;
	$table.=$table_temp;*/
	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round($ppro_b_total,0)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round($peffresultb,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
		/*$table_temp="<td class=xl9826424>".round($xb,0)."%</td>";
		echo $table_temp;
	$table.=$table_temp;*/
		//$table_temp="<td class=xl9826424>".$xb_actual."%</td>";
	$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round(($sthb/(($avail_B-$absent_B)*7.5))*100,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	/*$table_temp="<td class=xl15326424>".($clhb)."</td>";
	echo $table_temp;
	$table.=$table_temp;*/

	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round(($offstha_sum/60),2)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl15326424 style='background-color:#5A5A5A'>".round(($offsthb_sum/60),2)."</td>";
	echo $table_temp;
	$table.=$table_temp;

	//$table.=$table_temp;

	$table_temp="</tr>";
	echo $table_temp;
	$table.=$table_temp;

	/* NEW START 20100223 */

	$table_temp="<tr height=22 style='mso-height-source:userset;height:16.5pt'>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td height=44 class=xl15326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;   border-bottom:1.0pt solid black;height:16.5pt'></td>";
	echo $table_temp;
	$table.=$table_temp;

	$table_temp="<td height=22 class=xl9726424 style='background-color:#5A5A5A' style='height:16.5pt'>".round($grand_total_nop_x,0)."</td>";
	echo $table_temp;
	$table.=$table_temp;

	$table_temp="<td colspan=2 class=xl9726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>".($avail_A+$avail_B-$absent_A-$absent_B)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	/* $table_temp="<td colspan=2 class=xl9726424 style='border-right:1.0pt solid black;  border-left:none'>".($absent_A+$absent_B)."</td>";
	echo $table_temp;
	$table.=$table_temp;



	if(($avail_A+$avail_B)>0)
	{
	$table_temp="<td colspan=2 class=xl16726424 style='border-right:1.0pt solid black;  border-left:none'>".round((($absent_A+$absent_B)/($avail_A+$avail_B))*100,0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	}
	else
	{
	$table_temp="<td colspan=2 class=xl16726424 style='border-right:1.0pt solid black;  border-left:none'>0%</td>";
	echo $table_temp;
	$table.=$table_temp;
	}
	*/

	$table_temp="<td colspan=2 class=xl16726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>".round((($rew_A/$totalmodules+$rew_B/$totalmodules)/2),0)."%</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td colspan=2 class=xl9726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>".($auf_A+$auf_B)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	//$table_temp="<td colspan=1 class=xl9726424 style='border-right:1.0pt solid black;  border-left:none'>A=".round((($avail_A+$avail_B-$absent_A-$absent_B+64)*7.5),0)."</td>";
	$table_temp="<td colspan=1 class=xl9726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>A=".round($act_clock_hrs1,$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td colspan=1 class=xl9726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>P=".round(($pclha_total+$pclhb_total),$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td colspan=2 class=xl9926424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>".($atotal+$btotal)."</td>";
	echo $table_temp;
	$table.=$table_temp;



	$table_temp="<td colspan=3 class=xl16326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>Actual std hrs =</td>";
	echo $table_temp;
	$table.=$table_temp;
	$table_temp="<td class=xl16326424 style='background-color:#5A5A5A'>".round(($stha_total+$sthb_total),$decimal_factor)."</td>";
	echo $table_temp;
	$table.=$table_temp;

	$table_temp="<td colspan=2 class=xl16326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>Act EFF % =</td>";
	echo $table_temp;
	$table.=$table_temp;
	/*$table_temp="<td class=xl9726424>&nbsp;</td>";
	echo $table_temp;
	$table.=$table_temp;*/
	// Actual Eff % taken from Actual Clock hours.
	if(($clha_total+$clhb_total)>0)
	{
		$table_temp="<td colspan=4 class=xl17326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black'>".round((($stha_total+$sthb_total)/($clha_total+$clhb_total))*100,0)."%</td>";
		echo $table_temp;
		$table.=$table_temp;
	}
	else
	{
		$table_temp="<td colspan=4 class=xl18926424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black'>0%</td>";
		echo $table_temp;
		$table.=$table_temp;
	}

	/*$table_temp="<td colspan=2 class=xl18926424 style='border-right:1.0pt solid black;  border-left:none'></td>";
	echo $table_temp;
	$table.=$table_temp;*/

	$table_temp="<td colspan=2 class=xl18926424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>".round(($offstha_sum+$offsthb_sum)/60,2)."</td>";
	echo $table_temp;
	$table.=$table_temp;


	//$table.=$table_temp;
	$table_temp="</tr>";
	echo $table_temp;
	$table.=$table_temp;
	/* NEW END 20100223 */


	// $table_temp="</table>";


	$table_temp="<tr height=21 style='mso-height-source:userset;height:15.75pt'>
	<td height=21 class=xl955896 style='height:15.75pt'></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	<td class=xl955896></td>
	</tr>";
	echo $table_temp;
	$table.=$table_temp;
	$grand_total_nop_x=0; 
 $table_temp="</tr>";
 echo $table_temp;
	$table.=$table_temp;
/* NEW END 20100223 */


// $table_temp="</table>";


// $table_temp="<tr height=21 style='mso-height-source:userset;height:15.75pt'>
//   <td height=21 class=xl955896 style='height:15.75pt'></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   <td class=xl955896></td>
//   </tr>";
//   echo $table_temp;
// 	$table.=$table_temp;
  $grand_total_nop_x=0; 
}
/* }  NEW */
?>


