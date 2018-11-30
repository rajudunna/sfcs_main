<?php 

$sql="select * from $bai_pro.unit_db where unit_id=\"Factory\""; 
// echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
 $sec_code=$sql_row['unit_members']; 
} 



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



    $sql="select distinct mod_no from $bai_pro.pro_mod where mod_sec in(".$sec_code.") and mod_date between \"$date\" and \"$edate\" order by mod_no"; 
	// echo $sql."<br>";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 


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
        $mod=$sql_row['mod_no']; 
        $style=$sql_row['mod_style']; 
         
        $max=0; 
        $sql2="select smv,nop,styles, SUBSTRING_INDEX(max_style,'^',-1) as style_no, buyer, days, act_out from $grand_rep where module=$mod and date between \"$date\" and \"$edate\""; 
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
         
         
        $grand_total_nop_x=$grand_total_nop_x+$nop; 

         

        $sql2="select sum(avail_A) as \"avail_A\", sum(avail_B) as \"avail_B\", sum(absent_A) as \"absent_A\", sum(absent_B) as \"absent_B\" from $bai_pro.pro_atten where module=$mod and date in (\"".implode('","',$date_range)."\")"; 
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row2=mysqli_fetch_array($sql_result2)) 
        { 
            $avail_A=$avail_A+$sql_row2['avail_A'];
			$avail_A_clk=$sql_row2['avail_A'];
			$avail_B=$avail_B+$sql_row2['avail_B'];
			$avail_B_clk=$sql_row2['avail_B'];
			$absent_A=$absent_A+$sql_row2['absent_A'];
			$absent_A_clk=$sql_row2['absent_A'];
			$absent_B=$absent_B+$sql_row2['absent_B'];
			$absent_B_clk=$sql_row2['absent_B'];
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
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
         
         
            $sql2="select sum(act_out) as \"act_out\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_clh) as \"plan_clh\", sum(plan_sth) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"A\""; 
            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
             
            $sql2="select sum(act_out) as \"act_out\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_clh) as \"plan_clh\", sum(plan_sth) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"B\""; 
            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
             
            $sql2="select avg(nop) as \"nop\" from $grand_rep where module=$mod and date in (\"".implode('","',$date_range)."\")"; 
            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row2=mysqli_fetch_array($sql_result2)) 
            { 
                $nop=$sql_row2['nop']; 
                $operatorssum=$operatorssum+$nop; 
            } 
         
            /* GRAND REP INCLUDE */ 

        $offstha=0; 
        $offsthb=0; 

        $sql2="select sum(dtime) as \"offstha\" from $bai_pro.down_log where shift=\"A\" and date between \"$date\" and \"$edate\" and mod_no=$mod"; 
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

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
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

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

        $pstha_total=$pstha_total+round($pstha,0); 
        $psthb_total=$psthb_total+round($psthb,0); 

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
         
         
        $sql2="select sum(act_out) as \"act_out\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_clh) as \"plan_clh\", sum(plan_sth) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $grand_rep where section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"A\""; 
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
         
        $sql2="select  sum(act_out) as \"act_out\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_clh) as \"plan_clh\", sum(plan_sth) as \"plan_sth\", sum(plan_out) as \"plan_out\"  from $grand_rep where section in ($sec_code) and date between \"$date\" and \"$edate\" and shift=\"B\"";
        mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
        $total=$atotal+$btotal; 
     
         
     
        $table_temp="<tr height=22 style='mso-height-source:userset;height:16.5pt'>"; 
        echo $table_temp; 
    $table.=$table_temp; 
  $table_temp="<td colspan=5 rowspan=2 height=44 class=xl15326424 style='border-right:1.0pt solid black;   border-bottom:1.0pt solid black;height:33.0pt'>Factory</td>"; 
echo $table_temp; 
    $table.=$table_temp; 

        if($i2 == 6) 
        { 
            $div=2; 
        } 
        else 
        { 
            $div=1; 
        } 
         $table_temp="<td class=xl15326424>".round($grand_total_nop_x,0)."</td>"; 
         echo $table_temp; 
    $table.=$table_temp; 

          $table_temp="<td class=xl15326424>".($avail_A-$absent_A)."</td>"; 
          echo $table_temp; 
    $table.=$table_temp; 
  $table_temp="<td class=xl15326424>".($avail_B-$absent_B)."</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 
  // $table_temp="<td class=xl15326424>".$absent_A."</td>"; 
  // echo $table_temp; 
    // $table.=$table_temp; 
  // $table_temp="<td class=xl15326424>".$absent_B."</td>"; 
  // echo $table_temp; 
    // $table.=$table_temp; 

        // if($avail_A>0) 
        // { 
             // $table_temp="<td class=xl15326424>".round(($absent_A/$avail_A)*100,0)."%</td>"; 
             // echo $table_temp; 
    // $table.=$table_temp; 
        // } 
        // else 
        // { 
            // $table_temp="<td class=xl15326424>0%</td>"; 
            // echo $table_temp; 
    // $table.=$table_temp; 
        // } 

        // if($avail_B>0) 
        // { 
            // $table_temp="<td class=xl15326424>".round(($absent_B/$avail_B)*100,0)."%</td>"; 
            // echo $table_temp; 
    // $table.=$table_temp; 
        // } 
        // else 
        // { 
            // $table_temp="<td class=xl15326424>0%</td>"; 
            // echo $table_temp; 
    // $table.=$table_temp; 
        // } 

         $table_temp="<td class=xl15326424>".round($rew_A/$totalmodules,0)."%</td>"; 
         echo $table_temp; 
    $table.=$table_temp; 
            $table_temp="<td class=xl15326424>".round($rew_B/$totalmodules,0)."%</td>"; 
            echo $table_temp; 
    $table.=$table_temp; 
              $table_temp="<td class=xl15326424>".$auf_A."</td>"; 
              echo $table_temp; 
    $table.=$table_temp; 
                $table_temp="<td class=xl15326424>".$auf_B."</td>"; 
                echo $table_temp; 
    $table.=$table_temp; 
                  $table_temp="<td class=xl15326424>".round($pclha_total,0)."</td>"; 
                  echo $table_temp; 
    $table.=$table_temp; 
                    $table_temp="<td class=xl15326424>".round($pclhb_total,0)."</td>"; 
                    echo $table_temp; 
    $table.=$table_temp; 


          $table_temp="<td rowspan=2 class=xl15326424 style='border-bottom:1.0pt solid black'>".round(($ppro_a_total+$ppro_b_total),0)."</td>"; 
         echo $table_temp; 
    $table.=$table_temp; 



  $table_temp="<td class=xl15326424>".$atotal."</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 
    $table_temp="<td class=xl15326424>".$btotal."</td>"; 
    echo $table_temp; 
    $table.=$table_temp; 
   
         
          $table_temp="<td rowspan=2 class=xl15326424 style='border-bottom:1.0pt solid black'>".($pstha_total+$psthb_total)."</td>"; 
          echo $table_temp; 
    $table.=$table_temp; 

         
         
          $table_temp="<td class=xl15326424>".($pstha_total)."</td>"; 
          echo $table_temp; 
    $table.=$table_temp; 
            $table_temp="<td class=xl15326424>".round($stha_total,0)."</td>"; 
            echo $table_temp; 
    $table.=$table_temp; 
              $table_temp="<td class=xl15326424>".($psthb_total)."</td>"; 
              echo $table_temp; 
    $table.=$table_temp; 

         
         $table_temp="<td class=xl15326424>".round($sthb_total,0)."</td>"; 
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

$table_temp="<td rowspan=2 class=xl16126424 style='border-bottom:1.0pt solid black'>".round((($pstha_total+$psthb_total)/($pclha_total+$pclhb_total))*100,0)."%</td>"; 
echo $table_temp; 
    $table.=$table_temp; 
} 
else 
{ 
$table_temp="<td rowspan=2 class=xl16126424 style='border-bottom:1.0pt solid black'>0%</td>"; 
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





    $table_temp="<td class=xl15326424>".round($ppro_a_total,0)."</td>"; 
    echo $table_temp; 
    $table.=$table_temp; 
    $table_temp="<td class=xl15326424>".round($peffresulta,0)."%</td>"; 
    echo $table_temp; 
    $table.=$table_temp; 
      $table_temp="<td class=xl15326424>".round($xa,0)."%</td>"; 
      // echo $table_temp; 
    $table.=$table_temp; 
        $table_temp="<td class=xl15326424>".$xa_actual."%</td>"; 
        echo $table_temp; 
    $table.=$table_temp; 
          $table_temp="<td class=xl15326424>".round($ppro_b_total,0)."</td>"; 
          echo $table_temp; 
    $table.=$table_temp; 
            $table_temp="<td class=xl15326424>".round($peffresultb,0)."%</td>"; 
            echo $table_temp; 
    $table.=$table_temp; 
              $table_temp="<td class=xl15326424>".round($xb,0)."%</td>"; 
              // echo $table_temp; 
    $table.=$table_temp; 
                $table_temp="<td class=xl15326424>".$xb_actual."%</td>"; 
                echo $table_temp; 
    $table.=$table_temp; 
               




    $table_temp="<td class=xl15326424>".round(($offstha_sum/60),2)."</td>"; 
    echo $table_temp; 
    $table.=$table_temp; 
    $table_temp="<td class=xl15326424>".round(($offsthb_sum/60),2)."</td>"; 
    echo $table_temp; 
    $table.=$table_temp; 
$table_temp="<td class=xl15326424></td>"; 
// echo $table_temp; 
    $table.=$table_temp; 

$table_temp="</tr>"; 
echo $table_temp; 
    $table.=$table_temp; 

/* NEW START 20100223 */ 

$table_temp="<tr height=22 style='mso-height-source:userset;height:16.5pt'>"; 
echo $table_temp; 
    $table.=$table_temp; 

  $table_temp="<td height=22 class=xl15326424 style='height:16.5pt'>".round($grand_total_nop_x,0)."</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 

$table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".($avail_A+$avail_B-$absent_A-$absent_B)."</td>"; 
echo $table_temp; 
    $table.=$table_temp; 
    $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".($absent_A+$absent_B)."</td>"; 
    // echo $table_temp; 
    $table.=$table_temp; 
     


if(($avail_A+$avail_B)>0) 
{ 
$table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".round((($absent_A+$absent_B)/($avail_A+$avail_B))*100,0)."%</td>"; 
// echo $table_temp; 
    $table.=$table_temp; 
} 
else 
{ 
    $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>0%</td>"; 
    // echo $table_temp; 
    $table.=$table_temp; 
} 


 $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".round((($rew_A/$totalmodules+$rew_B/$totalmodules)/2),0)."%</td>"; 
echo $table_temp; 
    $table.=$table_temp; 
    $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".($auf_A+$auf_B)."</td>"; 
    echo $table_temp; 
    $table.=$table_temp; 
//   $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".round(($pclha_total+$pclhb_total),0)."</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 
    $table_temp="<td colspan=1 class=xl9726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>A=".round($act_clock_hrs1,$decimal_factor)."</td>";
    echo $table_temp;
      $table.=$table_temp;
    $table_temp="<td colspan=1 class=xl9726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;  border-left:none'>P=".round(($pclha_total+$pclhb_total),$decimal_factor)."</td>";
    echo $table_temp;
      $table.=$table_temp;
  $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".($atotal+$btotal)."</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 



  $table_temp="<td colspan=3 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>Actual std hrs =</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 
  $table_temp="<td class=xl15326424>".round(($stha_total+$sthb_total),0)."</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 

  $table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>Act EFF % =</td>"; 
  echo $table_temp; 
    $table.=$table_temp; 
  // $table_temp="<td class=xl15326424>&nbsp;</td>"; 
  // echo $table_temp; 
    // $table.=$table_temp; 
if(($pclha_total+$pclhb_total)>0) 
{ 
$table_temp="<td colspan=4 class=xl17326424 style='border-right:1.0pt solid black'>".round((($stha_total+$sthb_total)/($pclha_total+$pclhb_total))*100,0)."%</td>"; 
echo $table_temp; 
    $table.=$table_temp; 
} 
else 
{ 
$table_temp="<td colspan=4 class=xl15326424 style='border-right:1.0pt solid black'>0%</td>"; 
echo $table_temp; 
    $table.=$table_temp; 
} 
$table_temp="<td colspan=2 class=xl15326424 style='border-right:1.0pt solid black;  border-left:none'>".round(($offstha_sum+$offsthb_sum)/60,2)."</td>"; 
echo $table_temp; 
    $table.=$table_temp; 

  $table_temp="<td class=xl15326424></td>"; 
  // echo $table_temp; 
    $table.=$table_temp; 
 $table_temp="</tr>"; 
 echo $table_temp; 
    $table.=$table_temp; 
/* NEW END 20100223 */ 


// $table_temp="</table>"; 


$table_temp="<tr height=21 style='mso-height-source:userset;height:15.75pt'> 
  <td height=21 class=xl15326424 style='height:15.75pt'></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  <td class=xl15326424></td> 
  </tr>"; 
  // echo $table_temp; 
    $table.=$table_temp;
$grand_total_nop_x=0; 
/* }  NEW */ 
?> 