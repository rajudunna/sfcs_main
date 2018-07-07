<title>POP: Input Panel Availability Report</title>
<style>
	td,th{ color : #000;}
	b{ text-align:center;}
</style>	
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
$cutting_mail = $conf1->get('cutting_mail');
$view_access=user_acl("SFCS_0008",$username,1,$group_id_sfcs);
?>
<?php
$message= '';
function div_by_zero1($arg)
{
	$arg1=1;
	if($arg==0 or $arg=='0' or $arg=='')
	{
		$arg1=1;
	}
	else
	{
		$arg1=$arg;
	}
	return $arg1;
}

$date=date("Y-m-d H:i");
$date2=date("Y-m-d");
$message.= "<div class='panel panel-primary'>
			<div class='panel-heading'>
				<b>Input Availability Forecast Report</b>
			</div>
			<div class='panel-body'>";
$message.= "<div class='col-sm-12' style='overflow-y:scroll;max-height:600px;'>";
$message.= "<table class='table table-bordered table-responsive'>";
$message.= "<tr class='info'><th colspan=8><b class='text-danger'>Hourly Input Availability Report</b></th><th colspan=6><b class='text-danger'>".$date."</b></th></tr>";
$message.= "<tr class='danger'>
				<th>Section</th>
				<th>Mod#</th>
				<th>Style</th>
				<th>Schedule</th>
				<th>Color</th>
				<th>Jobs</th>
				<th>Available Qty<br> FAB(pcs)</th>
				<th>Available Qty<br> CUT</th>
				<th>Plan<br>Target/Hr</th>
				<th>Available <br>Hrs FAB</th>
				<th>Available<br> Hrs CUT</th>
				<th>Req. Time</th>
				<th>Sewing WIP</th>
				<th>Availble<br>Hrs WIP</th>
			</tr>";

//To use this interface for both alert mail and user view.
$sqlx="select * from $bai_pro3.sections_db where sec_id > 0";


if(!isset($_GET['alertfilter']))
{
	$sqlx="select * from $bai_pro3.sections_db where sec_id>0 and sec_id in (2,6)";
	echo "<script>alert();</script>";	
}



$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	
	$mods=array();
	$mods=explode(",",$section_mods);
	
	$total=0;
	$total1=0;
	$plan_tgt=0;
	$wip=0;
	$wip1=0;
	$total11=0;
	$total12=0;
	$total13=0;
	$total14=0;
	$total15=0;
	$total16=0;
	for($x=0;$x<sizeof($mods);$x++)
	{
		$module=$mods[$x];
		$total=0;
		$total1=0;
		$plan_tgt=0;
		$wip=0;
		$wip1=0;
		$total11=0;
		$total12=0;
		$total13=0;
		$total14=0;
		$total15=0;
		$total16=0;
		$clubbing=0;
		$sql1="SELECT group_concat(order_style_no SEPARATOR '<br/>') as style, group_concat(order_del_no SEPARATOR ',') as schedule, group_concat(order_col_des SEPARATOR '<br/>') as color, group_concat(concat(char(color_code),acutno) SEPARATOR '<br/>') as jobs, sum(total) as total,group_concat(doc_no SEPARATOR ',') as doc_no,acutno FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='DONE' group by module";
		// echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result1)>0)
		{
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$clubbing=$sql_row1['clubbing'];
				$schedule=$sql_row1['schedule'];
				$doc_no=$sql_row1['doc_no'];
				$club_docs=array();
				
				//echo  $clubbing."<br/>";
				$sql123="SELECT group_concat(order_style_no SEPARATOR '<br/>') as style, group_concat(order_del_no SEPARATOR ',') as schedule, group_concat(order_col_des SEPARATOR '<br/>') as color, group_concat(concat(char(color_code),acutno) SEPARATOR '<br/>') as jobs, sum(total) as total,clubbing,group_concat(doc_no SEPARATOR ',') as doc_no,acutno FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='DONE' and clubbing=0 group by module";
				//echo $sql12."<br>";
				$sql_result123=mysqli_query($link, $sql123) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row123=mysqli_fetch_array($sql_result123))
				{
					$total11=$sql_row123['total'];
				}	
				
				
				//echo "total11=". $total11."<br/>";
				
				$sql12="SELECT group_concat(order_style_no SEPARATOR '<br/>') as style, group_concat(order_del_no SEPARATOR ',') as schedule, group_concat(order_col_des SEPARATOR '<br/>') as color, group_concat(concat(char(color_code),acutno) SEPARATOR '<br/>') as jobs, sum(total) as total,clubbing,group_concat(doc_no SEPARATOR ',') as doc_no,acutno FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='DONE' and clubbing!=0 group by module";
				//echo $sql12."<br>";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row12=mysqli_fetch_array($sql_result12))
				{
					$clubbing=$sql_row12['clubbing'];
					$docc_no=$sql_row12['doc_no'];
				}	
				//echo $clubbing."<br/>";
				if($clubbing>0 && $docc_no>0)
				{
					
					$sql212="SELECT group_concat(doc_ref separator ',') as docref1 FROM $bai_pro3.fabric_priorities where doc_ref_club in (".$docc_no.")";
					$sql_result212=mysqli_query($link, $sql212) or exit("Sql Error3".$sql212);
					while($sql_row212=mysqli_fetch_array($sql_result212))
					{
						$club_doc_ref1=$sql_row212['docref1'];
					}
					$total12=0;
					$sql11="select (p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where category in ($in_categories) and order_del_no in ($schedule) and act_cut_status='DONE' and clubbing=$clubbing and doc_no in($club_doc_ref1)";
					// echo $sql11;
					$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error3".$sql11);
					while($sql_row11=mysqli_fetch_array($sql_result11))
					{
						$total12+=$sql_row11['total'];
					} 
					
					//echo "total12=".$total12."<br/>";
				}
				//echo "total13=". $total11."--".$total12."--".$total."<br/>";
				$total=$total11+$total12;
				
				$sql11="select (sum(plan_pro)/15) as plan_pro from $bai_pro.pro_plan_today where mod_no=$module and date='$date2'";
				//echo $sqll;
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$plan_tgt=round(($sql_row11['plan_pro']*1.1),0);
				}
				
				$sql11="select sum(ims_qty-ims_pro_qty) as wip from $bai_pro3.ims_log where ims_mod_no=$module";
				//echo $sqll;
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$wip=$sql_row11['wip'];
				}
				$c_doc_no=0;
				$sql2="SELECT  sum(total) as total,group_concat(doc_no separator ',') as doc_no  FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='' and fabric_status=5 and clubbing=0 group by module";
				//echo $sql2."<br/>";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($sql_result2))
					{
						$total13=$row1['total'];
						
					}
				
				//echo $c_doc_no."-".sizeof($c_doc_no)."<br/>";
				//echo $sql2."<br/>";
				//echo $clubbing."<br/>";
				$sql212="SELECT  sum(total) as total,group_concat(doc_no separator ',') as doc_no  FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='' and fabric_status=5 and clubbing!=0 group by module";
					$sql_result212=mysqli_query($link, $sql212) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row212=mysqli_fetch_array($sql_result212))
					{
						$c_doc_no=$row212['doc_no'];
					}
				
				if($clubbing>0 && $c_doc_no>0)
				{
					
					$sql21="SELECT group_concat(doc_ref separator ',') as docref FROM $bai_pro3.fabric_priorities where doc_ref_club in ($c_doc_no)";
					$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error3".$sql21);
					//echo $sql21."<br/>";
					while($sql_row21=mysqli_fetch_array($sql_result21))
					{
						$club_doc_ref=$sql_row21['docref'];
					}
						//echo $club_doc_ref."-".sizeof($club_doc_ref)."<br/>";
					$total14=0;
					$sql22="select (p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where category in ($in_categories) and cut_inp_temp is null and act_cut_status='' and doc_no in ($club_doc_ref) group by doc_no";
					$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error4".$sql22);
					//echo $sql22."<br/>";
					while($sql_row22=mysqli_fetch_array($sql_result22))
					{
						$total14+=$sql_row22['total'];
					}
					
					
				}
				$total1=$total13+$total14;
				$add=0;
				if($plan_tgt>0)
				{
				
				if(date("Y-m-d",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))!=date("Y-m-d") )
				{
					$add=8*(((strtotime(date("Y-m-d",(strtotime($date)+(60*60*round(($total/$plan_tgt),0))+(60*60*8))))-strtotime(date("Y-m-d")))/ (60 * 60 * 24))+0);
					//echo $module."$".((strtotime(date("Y-m-d",(strtotime($date)+(60*60*round(($total/$plan_tgt),0))+(60*60*8))))-strtotime(date("Y-m-d")))/ (60 * 60 * 24))."<br/>";
				}
				}
				else
				{
					$add=0;
				}
				/* if(date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))<=6 and date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))>0 and date("Y-m-d",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))!=date("Y-m-d"))
				{
					$add=2+date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)));
				}
				else
				{
					if((date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))>=22  or date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))==0) and date("Y-m-d",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))==date("Y-m-d"))
					{
						$add=6+(24-date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0))));
					}
					else
					{
						if(date("Y-m-d",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))!=date("Y-m-d") and date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))>6)
						{
							$add=(date("H",strtotime($date)+(60*60*round(($total/$plan_tgt),0)-6)));
						}
					}
				}
				echo $module."-".$add."<br/>"; */
				$res=$wip/div_by_zero1($plan_tgt);
				$wip1=round(($res),0);
				
				if($plan_tgt>0)
				{
					$message.= "<tr><td>$section</td><td>$module</td><td>".$sql_row1['style']."</td><td>".$sql_row1['schedule']."</td><td>".$sql_row1['color']."</td><td>".$sql_row1['jobs']."</td><td>$total1</td><td >$total</td><td>$plan_tgt</td><td>".round(($total1/div_by_zero1($plan_tgt)),0)."</td><td>".round(($total/div_by_zero1($plan_tgt)),0)."</td><td>".date("Y-m-d H",strtotime($date)+(60*60*round(($total/$plan_tgt)+$add,0))).":00</td><td>$wip</td><td>$wip1</td></tr>";
				}
				else
				{
					$message.= "<tr><td>$section</td><td>$module</td><td>".$sql_row1['style']."</td><td>".$sql_row1['schedule']."</td><td>".$sql_row1['color']."</td><td>".$sql_row1['jobs']."</td><td>$total1</td><td>$total</td><td>$plan_tgt</td><td>".round(($total1/div_by_zero1($plan_tgt)),0)."</td><td>0</td><td>".date("Y-m-d H",strtotime($date)+(60*60*1)).":00</td><td>$wip</td><td>$wip1</td></tr>";
				}
			}
		}
		else
		{
			$clubbing=0;
			$sql131="SELECT group_concat(order_style_no SEPARATOR '<br/>') as style, group_concat(order_del_no SEPARATOR ',') as schedule, group_concat(order_col_des SEPARATOR '<br/>') as color, group_concat(concat(char(color_code),acutno) SEPARATOR '<br/>') as jobs,clubbing FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='' group by module";
		
			//echo $sql131."<br>";
			$sql_result131=mysqli_query($link, $sql131) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row131=mysqli_fetch_array($sql_result131))
			{
				$clubbing=$sql_row131['clubbing'];
			}
			$sql11="select sum(ims_qty-ims_pro_qty) as wip from $bai_pro3.ims_log where ims_mod_no=$module";
			//echo $sqll;
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$wip=$sql_row11['wip'];
			}
			
			$sql11="select (sum(plan_pro)/15) as plan_pro from $bai_pro.pro_plan_today where mod_no=$module  and date='$date2'";
			//echo $sqll;
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$plan_tgt=round(($sql_row11['plan_pro']*1.1),0);
			}
			$c_doc_no=0;
			$sql23="SELECT  sum(total) as total,group_concat(doc_no separator ',') as doc_no FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='' and fabric_status=5 and clubbing=0 group by module";
			//echo $sql23."<br/>";
			$sql_result2=mysqli_query($link, $sql23) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($sql_result2))
			{
				$total15=$row1['total'];
			}
			
			$sql232="SELECT  sum(total) as total,group_concat(doc_no separator ',') as doc_no FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module and cut_inp_temp is null and act_cut_status='' and fabric_status=5 and clubbing!=0 group by module";
			//echo $sql23."<br/>";
			$sql_result232=mysqli_query($link, $sql232) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row232=mysqli_fetch_array($sql_result232))
			{
				$c_doc_no=$row232['doc_no'];
			}
			if($clubbing>0 && $c_doc_no>0)
				{
					$sql21="SELECT group_concat(doc_ref separator ',') as docref FROM $bai_pro3.fabric_priorities where doc_ref_club in ($c_doc_no)";
					$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error3".$sql21);
					//echo $sql21."<br/>";
					while($sql_row21=mysqli_fetch_array($sql_result21))
					{
						$club_doc_ref=$sql_row21['docref'];
					}
						//echo $club_doc_ref."-".sizeof($club_doc_ref)."<br/>";
					$total16=0;	
					$sql22="select (p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where category in ($in_categories) and cut_inp_temp is null and act_cut_status='' and doc_no in ($club_doc_ref) group by doc_no";
					$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error4".$sql22);
					//echo $sql22."<br/>";
					while($sql_row22=mysqli_fetch_array($sql_result22))
					{
						$total16+=$sql_row22['total'];
					}	
				}
			$total1=$total15+$total16;
			$res=$wip/div_by_zero1($plan_tgt);
			$wip1=round(($res),0);			
			$message.= "<tr><th align=left>$section</th><th align=left>$module</th><td></td><td></td><td></td><td></td><td>$total1</td><td>0</td><td>$plan_tgt</td><td>".round(($total1/div_by_zero1($plan_tgt)),0)."</td><td>0</td><td>Critical</td><td>$wip</td><td>$wip1</td></tr>";
		}
	}
}

$message.= "</table>
</div>";
// $message.= '<br/><br/>Message Sent via: http://bffnet';
$message.='
</html>';


//$to  = 'SenthooranS@brandix.com,gayanl@brandix.com,DuminduW@brandix.com,NalakaSB@brandix.com,ChandrasekharD@brandix.com,RanjanG@brandix.com,NihalS@brandix.com,SajithA@brandix.com,brandixalerts@schemaxtech.com';
//$to  = 'fazlulr@brandix.com,brandixalerts@schemaxtech.com';
//$to  = 'rajesh.nalam@schemaxtech.com';

// subject
$to = $cutting_mail;
$subject = 'Hourly Input Availability Report';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to. "\r\n";
$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
//$headers .= 'Cc: YasanthiN@brandix.com' . "\r\n";


// if(!isset($_GET['alertfilter']))
// {
// // Mail it
// mail($to, $subject, $message, $headers);
// $self_page = 'index.php?r='.$_GET['r'];
// //echo $message;
// echo "<script> 
// 		setTimeout('CloseWindow()',100); 
// 		function CloseWindow(){ 
// 			window.open('$self_page','Input Availability forecast',''); 
// 			window.close(); 
// 		} 
// 	  </script>";

// }
// else
// {
// 	echo $message;
// }
echo $message;
?>
</div><!-- panel body -->
</div><!--  panel -->
</div>

