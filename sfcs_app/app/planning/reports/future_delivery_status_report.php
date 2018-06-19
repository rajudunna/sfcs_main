<?php 
//CR#886/ kirang / 2015-03-17 / Future Delivery status Report. - To Track the future deliveries.
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
//$view_access=user_acl("SFCS_0100",$username,1,$group_id_sfcs); 


include("header.php");
set_time_limit(60000);

function div_by_zero($arg)
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<title>Future Delivery Status Report</title>
<meta name="" content="">
<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
<!--<link href="style.css" rel="stylesheet" type="text/css" />-->
<!--<script type="text/javascript" src="datetimepicker_css.js"></script>
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>-->
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R') ?>" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?= getFullURL($_GET['r'],'datetimepicker_css.js','R')?>"></script>-->
<script type="text/javascript" src="<?= getFullURL($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>


</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Future Delivery Status Report</div>
<div class="panel-body">
<div class="form-group">
<!--<div id="page_heading" style="left: 500px;"	><span style="float"><h3>Future Delivery Status Report</h3></span></div>-->
<?php
$table_flag = false;
	$sql="select * from $bai_pro3.sections_db where sec_id>0";
	$result=mysqli_query($link, $sql) or die ("sql error--s".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
    $section=array();   
    while($sql_row=mysqli_fetch_array($result))
	{
		$section[]=$sql_row["sec_mods"];		
 	}
	$iii=1;
	$numberofsecs=strtotime( "next monday" );
	$next_mon=date('Y-m-d', $numberofsecs);
	$ims_log="$bai_pro3.ims_log";
	$ims_log_backup="$bai_pro3.ims_log_backup";
	$orders_db="$bai_pro3.bai_orders_db";
	$bai_orders_db_confirm="$bai_pro3.bai_orders_db";
//	$section1=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
//	$section2=array(17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);
//	$section3=array(33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48);
//	$section4=array(49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64);
	$sizes=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
	$sql11="select * from $bai_orders_db_confirm where order_date >='".$next_mon."'order by order_date";
	//echo $sql11."<br>";
	$result= mysqli_query($link, $sql11) or die("sql error--11".$sql11.mysqli_error($GLOBALS["___mysqli_ston"]));
	$no_of_rows = mysqli_num_rows($result);
	if($no_of_rows > 0){  
		echo "<div class='table-responsive' id='main_content'>
		<table border='1px' cellpadding=\"0\" cellspacing=\"0\" class=\"mytable\" id=\"table1\">
		<tr>
			<th>Customer</th><th>Style</th><th>Schedule</th><th>Color</th><th>Order Qty</th><th>Output</th><th>Achievement %</th><th>FG Status</th><th>Ex factory</th><th>PED</th>";
		for($i=0;$i<sizeof($section);$i++)
		{	
			//echo "sadfasdf--"."</br>";	
			echo "<th>Section-".$iii."(Input)</th>"; 
			echo "<th>Section-".$iii."(Output)</th>"; 
			$iii++;
		}	
		//	echo "<th colspan=2>Section 1 </th><th colspan=2>Section 2</th><th colspan=2>Section 3</th><th colspan=2>Section 4</th>
		echo "</tr>";
		// echo "<tr>";
		// for($i3=0;$i3<sizeof($section);$i3++)
		// {			
		// 	echo "<th>input</th><th>Output</th>"; 
		// }
		// echo "</tr>";
		//$sql11="select * from $orders_db where order_date >='".$next_mon."' order by order_date";

		while($sql_rowxx=mysqli_fetch_array($result))
		{
			$order_tid=$sql_rowxx['order_tid'];
			$color=$sql_rowxx['order_col_des'];
			$ex_factory=$sql_rowxx['order_date'];
			$style=$sql_rowxx['order_style_no'];	
			$schedule=$sql_rowxx['order_del_no'];	
		
			$o_xs=$sql_rowxx['old_order_s_xs'];
			$o_s=$sql_rowxx['old_order_s_s'];
			$o_m=$sql_rowxx['old_order_s_m'];
			$o_l=$sql_rowxx['old_order_s_l'];
			$o_xl=$sql_rowxx['old_order_s_xl'];
			$o_xxl=$sql_rowxx['old_order_s_xxl'];
			$o_xxxl=$sql_rowxx['old_order_s_xxxl'];			
			$o_s01=$sql_rowxx['old_order_s_s01'];
			$o_s02=$sql_rowxx['old_order_s_s02'];
			$o_s03=$sql_rowxx['old_order_s_s03'];
			$o_s04=$sql_rowxx['old_order_s_s04'];
			$o_s05=$sql_rowxx['old_order_s_s05'];
			$o_s06=$sql_rowxx['old_order_s_s06'];
			$o_s07=$sql_rowxx['old_order_s_s07'];
			$o_s08=$sql_rowxx['old_order_s_s08'];
			$o_s09=$sql_rowxx['old_order_s_s09'];
			$o_s10=$sql_rowxx['old_order_s_s10'];
			$o_s11=$sql_rowxx['old_order_s_s11'];
			$o_s12=$sql_rowxx['old_order_s_s12'];
			$o_s13=$sql_rowxx['old_order_s_s13'];
			$o_s14=$sql_rowxx['old_order_s_s14'];
			$o_s15=$sql_rowxx['old_order_s_s15'];
			$o_s16=$sql_rowxx['old_order_s_s16'];
			$o_s17=$sql_rowxx['old_order_s_s17'];
			$o_s18=$sql_rowxx['old_order_s_s18'];
			$o_s19=$sql_rowxx['old_order_s_s19'];
			$o_s20=$sql_rowxx['old_order_s_s20'];
			$o_s21=$sql_rowxx['old_order_s_s21'];
			$o_s22=$sql_rowxx['old_order_s_s22'];
			$o_s23=$sql_rowxx['old_order_s_s23'];
			$o_s24=$sql_rowxx['old_order_s_s24'];
			$o_s25=$sql_rowxx['old_order_s_s25'];
			$o_s26=$sql_rowxx['old_order_s_s26'];
			$o_s27=$sql_rowxx['old_order_s_s27'];
			$o_s28=$sql_rowxx['old_order_s_s28'];
			$o_s29=$sql_rowxx['old_order_s_s29'];
			$o_s30=$sql_rowxx['old_order_s_s30'];
			$o_s31=$sql_rowxx['old_order_s_s31'];
			$o_s32=$sql_rowxx['old_order_s_s32'];
			$o_s33=$sql_rowxx['old_order_s_s33'];
			$o_s34=$sql_rowxx['old_order_s_s34'];
			$o_s35=$sql_rowxx['old_order_s_s35'];
			$o_s36=$sql_rowxx['old_order_s_s36'];
			$o_s37=$sql_rowxx['old_order_s_s37'];
			$o_s38=$sql_rowxx['old_order_s_s38'];
			$o_s39=$sql_rowxx['old_order_s_s39'];
			$o_s40=$sql_rowxx['old_order_s_s40'];
			$o_s41=$sql_rowxx['old_order_s_s41'];
			$o_s42=$sql_rowxx['old_order_s_s42'];
			$o_s43=$sql_rowxx['old_order_s_s43'];
			$o_s44=$sql_rowxx['old_order_s_s44'];
			$o_s45=$sql_rowxx['old_order_s_s45'];
			$o_s46=$sql_rowxx['old_order_s_s46'];
			$o_s47=$sql_rowxx['old_order_s_s47'];
			$o_s48=$sql_rowxx['old_order_s_s48'];
			$o_s49=$sql_rowxx['old_order_s_s49'];
			$o_s50=$sql_rowxx['old_order_s_s50'];

			
			
			$m3_qty=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;
			$doc_no=array();
			$section_in=array();
			$section_in1=array();
			$section_out=array();
			$section_out1=array();
			$input=array();
			$output=array();
			$j1=0;$j2=0;$j11=0;$j12=0;$output1=0;;$count=0;$temp=0;
			$customer1=substr($style,0,1);
			if($customer1=='P' or $customer1=='K')
			{
				$customer='VS Pink';
			}
			else if($customer1=='L' or $customer1=='O')
			{
				$customer='VS Logo';
			}
			else if($customer1=='U' or $customer1=='G')
			{
				$customer='Glamour';
			}
			else if($customer1=='M')
			{
				$customer='M&S';
			}
			else if($customer1=='Y')
			{
				$customer='LBI';
			}
			$sql2="select tid from $bai_pro3.cat_stat_log where order_tid='".$order_tid."' and category in ('body','front')";
			$result2=mysqli_query($link, $sql2) or die("sql error--2".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($result2)>0)
			{ 
				while($row1=mysqli_fetch_array($result2))
				{
					$cat_ref=$row1["tid"];
				}
				$sql3="select * from $bai_pro3.plandoc_stat_log where cat_ref='".$cat_ref."'";
				$result3=mysqli_query($link, $sql3) or die("sql error--3".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql31="select * from bai_pro3.plandoc_stat_log where cat_ref='".$cat_ref."' and act_cut_issue_status='DONE' "; 
				$result31=mysqli_query($link, $sql31) or die("sql error--31".$sql31.mysqli_error($GLOBALS["___mysqli_ston"]));
				$j1=mysqli_num_rows($result3);
				$j2=mysqli_num_rows($result31);
				if($j1==$j2)
				{
					while($row2=mysqli_fetch_array($result3))
					{
						$doc_no[]=$row2["doc_no"];
					}
				//	$n=0;
					for($jj=0;$jj<sizeof($section);$jj++)
					{
						$sql8="select * from $ims_log where ims_schedule='".$schedule."' and ims_color='".$color."' and ims_remarks !='sample' and ims_mod_no in (".$section[$jj].")";
						$sql9="select * from $ims_log_backup where ims_schedule='".$schedule."' and ims_color='".$color."' and ims_remarks !='sample' and ims_mod_no in (".$section[$jj].")";
						$result8=mysqli_query($link, $sql8) or die("sql error--8".$sql8.mysqli_error($GLOBALS["___mysqli_ston"]));
						$result9=mysqli_query($link, $sql9) or die("sql error--9".$sql9.mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($result8)>0)
						{
							$sql1="select sum(ims_pro_qty) as ims_pro_qty,sum(ims_qty) as ims_qty from $ims_log where ims_schedule='".$schedule."' and ims_color='".$color."' and ims_remarks !='sample' and ims_mod_no in(".$section[$jj].")";
							$result1=mysqli_query($link, $sql1) or die("sql error--1".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_rowx1=mysqli_fetch_array($result1))
							{
							
								$section_in[]=$sql_rowx1['ims_qty'];
								$section_out[]=$sql_rowx1['ims_pro_qty'];
							}
						}
						else
						{
							$section_in[]=0;
							$section_out[]=0;
						}
						if(mysqli_num_rows($result9)>0)
						{
							$sql12="select sum(ims_pro_qty) as ims_pro_qty,sum(ims_qty) as ims_qty from $ims_log_backup where ims_schedule='".$schedule."' and ims_color='".$color."' and ims_remarks !='sample' and ims_mod_no in (".$section[$jj].")";
							$result12=mysqli_query($link, $sql12) or die("sql error--12".$sql12.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_rowx=mysqli_fetch_array($result12))
							{
								$section_in1[]=$sql_rowx['ims_qty'];
								$section_out1[]=$sql_rowx['ims_pro_qty'];
							}
						}
						else
						{
							$section_in1[]=0;
							$section_out1[]=0;
						}	
					}
					for($kk=0;$kk<sizeof($section_in);$kk++)
					{
						
						$input[]=($section_in[$kk]+$section_in1[$kk]);
						$output[]=($section_out[$kk]+$section_out1[$kk]);
						$output1+=($section_out[$kk]+$section_out1[$kk]);
						//echo "section-".$kk."<--->".$section_in[$kk]."<---->".$section_in1[$kk]."<br>";
						//echo "section-".$kk."<--->".$section_out[$kk]."<---->".$section_out1[$kk]."<br>";
						//echo $output1."<br>";
					}
			//	echo "------------------------------".$schedule."<br>";
					for($i=0;$i<sizeof($sizes);$i++)
					{
						$sql21="select * from $ims_log where ims_schedule='".$schedule."' and ims_style='".$style."' and ims_color='".$color."' and ims_size= 'a_".$sizes[$i]."'";
						$sql22="select * from $ims_log_backup where ims_schedule='".$schedule."' and ims_style='".$style."' and ims_color='".$color."' and ims_size= 'a_".$sizes[$i]."'";
						$result21=mysqli_query($link, $sql21) or die("sql error--1-".$sql21.mysqli_error($GLOBALS["___mysqli_ston"]));
						$result22=mysqli_query($link, $sql22) or die("sql error--2-".$sql22.mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if(mysqli_num_rows($result21)>0)
						{
							$sql211="select sum(ims_pro_qty) as output11 from $ims_log where ims_schedule='".$schedule."' and ims_style='".$style."' and ims_color='".$color."' and ims_size= 'a_".$sizes[$i]."'";
							$result211=mysqli_query($link, $sql211) or die("sql error--1-".$sql211.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($val1=mysqli_fetch_array($result211))
							{
								$out11=$val1["output11"];
							}
						}
						else
						{
							$out11=0;
						}
						
						if(mysqli_num_rows($result22)>0)
						{
							$sql222="select sum(ims_pro_qty) as output22 from $ims_log_backup where ims_schedule='".$schedule."' and ims_style='".$style."' and ims_color='".$color."' and ims_size= 'a_".$sizes[$i]."'";
							$result222=mysqli_query($link, $sql222) or die("sql error--2-".$sql222.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($val2=mysqli_fetch_array($result222))
							{
								$out22=$val2["output22"];
							}
						}
						else
						{
							$out22=0;
						}
						
						$out=$out11+$out22;
						$sql23="select sum(order_s_".$sizes[$i].") as order_qty from $bai_orders_db_confirm where order_del_no='".$schedule."' and order_style_no='".$style."' and order_col_des='".$color."'";
						$result23=mysqli_query($link, $sql23) or die("sql error--3-".$sql23.mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if(mysqli_num_rows($result23)>0)
						{
							$sql233="select sum(order_s_".$sizes[$i].") as order_qty from $bai_orders_db_confirm where order_del_no='".$schedule."' and order_style_no='".$style."' and order_col_des='".$color."'";
							$result233=mysqli_query($link, $sql233) or die("sql error--3-".$sql233.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($val3=mysqli_fetch_array($result233))
							{
								$order=$val3["order_qty"];
							}
						}
						else
						{
							$order=0;						
						}
						//echo $out11."<-->".$out22."<-->".$order."<--->".$sizes[$i]."<br>";
						if($order <= $out)
						{
							$count++;
						}
							
					}
				//	echo"-----------------------------------------------";
				//	echo $temp."<<><>>".$count."--".$schedule."<br>";
				
					if((sizeof($sizes)) == $count)
					{
						if(sizeof($doc_no)>0)
						{
							$query1=implode(",",$doc_no);
							$sql5="select * from $bai_pro3.pac_stat_log where doc_no in ($query1)"; 
							$sql51="select * from $bai_pro3.pac_stat_log where doc_no in ($query1) and status='Done'"; 
							
							//echo $sql5."</br>"; 
							//echo $sql51."</br>"; 
							$result5=mysqli_query($link, $sql5) or die("sql error--5".$sql5.mysqli_error($GLOBALS["___mysqli_ston"]));
							$result51=mysqli_query($link, $sql51) or die("sql error--51".$sql51.mysqli_error($GLOBALS["___mysqli_ston"]));
							$j11=mysqli_num_rows($result5);
							$j12=mysqli_num_rows($result51);
							if($j11==$j12)
							{
								$status='FG Received';
							}
							else
							{
								$status='Packing';
							}	
						}
						else
						{		
							
							$status='Cut Plan not Generated';
						}
					}
					else
					{
						$status="Sewing";
					}	
					$sql14="select max(bac_date) as date1 from $bai_pro.bai_log where delivery='".$schedule."' and bac_qty>0";
					$result14=mysqli_query($link, $sql14) or die("sql error--PED--".$sql14.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row11=mysqli_fetch_array($result14))
					{
					//$bac_no=$row11["bac_no"];
						$ped=$row11["date1"];
					
					}
					$table_flag = true;
					//	echo "<tr><td>".$customer."</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$order_qty."</td><td>".$output."</td><td>".$status."</td><td>".$ex_factory."</td><td></td><td>".$section1_inp."</td><td>".$section1_out."</td><td>".$section2_inp."</td><td>".$section2_out."</td><td>".$section3_inp."</td><td>".$section3_out."</td><td>".$section4_inp."</td><td>".$section4_out."</td><td>".$act_cut_qty."--".$plan_act_qty."--".$input."--".$output."--".$fg."</td></tr>";		
					// echo '<tr></tr>';
					echo "<tr><td>".$customer."</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$m3_qty."</td><td>".$output1."</td><td>".round($output1*100/div_by_zero($m3_qty),2)."%<td>".$status."</td><td>".$ex_factory."</td><td>".$ped."</td>";
					for($j1=0;$j1<sizeof($input);$j1++)
					{
						echo "<td>".$input[$j1]."</td><td>".$output[$j1]."</td>";
					}
					echo "</tr>";
					unset($doc_no);
					unset($section_in);
					unset($section_in1);
					unset($section_out);
					unset($section_out1);
					unset($input);
					unset($output);
					//echo "<td>".$section1_inp."</td><td>".$section1_out."</td><td>".$section2_inp."</td><td>".$section2_out."</td><td>".$section3_inp."</td><td>".$section3_out."</td><td>".$section4_inp."</td><td>".$section4_out."</td></tr>";				
					//	$status='';		
				}	
			}
		}		
		echo "</table>";
		echo "</div>";
	}
	if(!$table_flag){
		echo '<div class="alert alert-error">
			<strong>Info!</strong> No Data Found.
		</div>';
		echo "<script>$('#main_content').hide();</script>";
	}
?>
<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_7: "select",
	sort_select: true,
	btn_reset: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
</script> 
</div>
</div>
</div>
</body>
</html>
