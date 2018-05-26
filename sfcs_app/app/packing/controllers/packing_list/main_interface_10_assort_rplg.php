<?php
echo "<form name=\"input\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";

$sql121="select ratio_packing_method from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error121".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row121=mysqli_fetch_array($sql_result121))
		{
			$ratio_packing_method=$sql_row121['ratio_packing_method'];
		}
	//echo "ration_oack_size:".$ratiopacksize;
	if($ratio_packing_method=='')
	{
		if($ratiopacksize=='single')
		{
			$ratio_pack='Single Size Multiple Colours Ratio Packing';
		}
		else if($ratiopacksize=='multiple')
		{
			$ratio_pack='Multiple Sizes Multiple Colours Ratio Packing';
		}
	}
	else
	{
		
		if($ratio_packing_method=='single')
		{
			$ratio_pack='Single Size Multiple Colours Ratio Packing';
		}
		else if($ratio_packing_method=='multiple')
		{
			$ratio_pack='Multiple Sizes Multiple Colours Ratio Packing';
		}
	}

echo "<div class='alert alert-success' role='alert'>Ratio Packing Method:&nbsp&nbsp&nbsp<b>$ratio_pack.</b></div>";
echo "<h3>Carton Ratio Quantities: </h3>";
//$packpcs=array();
//$assort_color=array();
$sql1="SELECT * FROM $bai_pro3.ratio_input_update where schedule=\"$schedule\" ";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error:$sql1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check1=mysqli_num_rows($sql_result1);
				
		if($sql_num_check1>0)
		{
			echo "<table class='table table-border'>";
			echo "<tr class='tblheading'><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Ratio Quantity</th><th>User Name</th> <th>Log Time</th></tr>";
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$ratio_style=$sql_row1['style'];
				$ratio_schedule=$sql_row1['schedule'];
				$ratio_color=$sql_row1['color'];
				$ratio_size=$sql_row1['size'];
				$ratio_qty=$sql_row1['ratio_qty'];
				$username=$sql_row1['username'];
				$log_time=$sql_row1['log_time'];
				$sql="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no=$schedule";
				//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error:$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					
					$size01 = $sql_row['title_size_s01'];
					$size02 = $sql_row['title_size_s02'];
					$size03 = $sql_row['title_size_s03'];
					$size04 = $sql_row['title_size_s04'];
					$size05 = $sql_row['title_size_s05'];
					$size06 = $sql_row['title_size_s06'];
					$size07 = $sql_row['title_size_s07'];
					$size08 = $sql_row['title_size_s08'];
					$size09 = $sql_row['title_size_s09'];
					$size10 = $sql_row['title_size_s10'];
					$size11 = $sql_row['title_size_s11'];
					$size12 = $sql_row['title_size_s12'];
					$size13 = $sql_row['title_size_s13'];
					$size14 = $sql_row['title_size_s14'];
					$size15 = $sql_row['title_size_s15'];
					$size16 = $sql_row['title_size_s16'];
					$size17 = $sql_row['title_size_s17'];
					$size18 = $sql_row['title_size_s18'];
					$size19 = $sql_row['title_size_s19'];
					$size20 = $sql_row['title_size_s20'];
					$size21 = $sql_row['title_size_s21'];
					$size22 = $sql_row['title_size_s22'];
					$size23 = $sql_row['title_size_s23'];
					$size24 = $sql_row['title_size_s24'];
					$size25 = $sql_row['title_size_s25'];
					$size26 = $sql_row['title_size_s26'];
					$size27 = $sql_row['title_size_s27'];
					$size28 = $sql_row['title_size_s28'];
					$size29 = $sql_row['title_size_s29'];
					$size30 = $sql_row['title_size_s30'];
					$size31 = $sql_row['title_size_s31'];
					$size32 = $sql_row['title_size_s32'];
					$size33 = $sql_row['title_size_s33'];
					$size34 = $sql_row['title_size_s34'];
					$size35 = $sql_row['title_size_s35'];
					$size36 = $sql_row['title_size_s36'];
					$size37 = $sql_row['title_size_s37'];
					$size38 = $sql_row['title_size_s38'];
					$size39 = $sql_row['title_size_s39'];
					$size40 = $sql_row['title_size_s40'];
					$size41 = $sql_row['title_size_s41'];
					$size42 = $sql_row['title_size_s42'];
					$size43 = $sql_row['title_size_s43'];
					$size44 = $sql_row['title_size_s44'];
					$size45 = $sql_row['title_size_s45'];
					$size46 = $sql_row['title_size_s46'];
					$size47 = $sql_row['title_size_s47'];
					$size48 = $sql_row['title_size_s48'];
					$size49 = $sql_row['title_size_s49'];
					$size50 = $sql_row['title_size_s50'];
					$flag = $sql_row['title_flag'];
				}
				
				if($ratio_size=='s01'){$ratio_size=$size01;}
				if($ratio_size=='s02'){$ratio_size=$size02;}
				if($ratio_size=='s03'){$ratio_size=$size03;}
				if($ratio_size=='s04'){$ratio_size=$size04;}
				if($ratio_size=='s05'){$ratio_size=$size05;}
				if($ratio_size=='s06'){$ratio_size=$size06;}
				if($ratio_size=='s07'){$ratio_size=$size07;}
				if($ratio_size=='s08'){$ratio_size=$size08;}
				if($ratio_size=='s09'){$ratio_size=$size09;}
				if($ratio_size=='s10'){$ratio_size=$size10;}
				if($ratio_size=='s11'){$ratio_size=$size11;}
				if($ratio_size=='s12'){$ratio_size=$size12;}
				if($ratio_size=='s13'){$ratio_size=$size13;}
				if($ratio_size=='s14'){$ratio_size=$size14;}
				if($ratio_size=='s15'){$ratio_size=$size15;}
				if($ratio_size=='s16'){$ratio_size=$size16;}
				if($ratio_size=='s17'){$ratio_size=$size17;}
				if($ratio_size=='s18'){$ratio_size=$size18;}
				if($ratio_size=='s19'){$ratio_size=$size19;}
				if($ratio_size=='s20'){$ratio_size=$size20;}
				if($ratio_size=='s21'){$ratio_size=$size21;}
				if($ratio_size=='s22'){$ratio_size=$size22;}
				if($ratio_size=='s23'){$ratio_size=$size23;}
				if($ratio_size=='s24'){$ratio_size=$size24;}
				if($ratio_size=='s25'){$ratio_size=$size25;}
				if($ratio_size=='s26'){$ratio_size=$size26;}
				if($ratio_size=='s27'){$ratio_size=$size27;}
				if($ratio_size=='s28'){$ratio_size=$size28;}
				if($ratio_size=='s29'){$ratio_size=$size29;}
				if($ratio_size=='s30'){$ratio_size=$size30;}
				if($ratio_size=='s31'){$ratio_size=$size31;}
				if($ratio_size=='s32'){$ratio_size=$size32;}
				if($ratio_size=='s33'){$ratio_size=$size33;}
				if($ratio_size=='s34'){$ratio_size=$size34;}
				if($ratio_size=='s35'){$ratio_size=$size35;}
				if($ratio_size=='s36'){$ratio_size=$size36;}
				if($ratio_size=='s37'){$ratio_size=$size37;}
				if($ratio_size=='s38'){$ratio_size=$size38;}
				if($ratio_size=='s39'){$ratio_size=$size39;}
				if($ratio_size=='s40'){$ratio_size=$size40;}
				if($ratio_size=='s41'){$ratio_size=$size41;}
				if($ratio_size=='s42'){$ratio_size=$size42;}
				if($ratio_size=='s43'){$ratio_size=$size43;}
				if($ratio_size=='s44'){$ratio_size=$size44;}
				if($ratio_size=='s45'){$ratio_size=$size45;}
				if($ratio_size=='s46'){$ratio_size=$size46;}
				if($ratio_size=='s47'){$ratio_size=$size47;}
				if($ratio_size=='s48'){$ratio_size=$size48;}
				if($ratio_size=='s49'){$ratio_size=$size49;}
				if($ratio_size=='s50'){$ratio_size=$size50;}

				//$packpcs[]=$ratio_qty;
				//$assort_color[]=$ratio_color;
				
				echo "<input type=\"hidden\" name=\"packpcs[]\" value=\"$ratio_qty\">";
				echo "<tr><td>$ratio_style</td><td>$ratio_schedule</td><td>$ratio_color</td><td>$ratio_size</td><td>$ratio_qty</td><td>$username</td><td>$log_time</td></tr>";
			}
			
			echo "</table>";
		}
	else
	{
			echo "<div class='alert alert-success' role='alert'>Carton Ratio Quantities not updated for this schedule... <br/> First please enter the Carton Ratio Quantities for this schedule..</div>";
			//echo "<h2 style='color:Red;' > Carton Ratio Quantities not updated for this schedule... <br/> First please enter the Carton Ratio Quantities for this schedule..</h2>";
	}
	
	
/*	$sql="select * from carton_qty_chart where user_style=\"$style_id\" and buyer_identity like \"%$buyer_code%\" and status=0";
//echo $sql;
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);
$x=0;
while($sql_row=mysql_fetch_array($sql_result))
{
	if($sql_row['buyer_identity']=="M")
	{
		if($x==0)
		{
			echo "<table><tr class='tblheading'><th>Select</th><th>Packing Method</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>06</th><th>08</th><th>10</th><th>12</th><th>14</th><th>16</th><th>18</th><th>20</th><th>22</th><th>24</th><th>26</th><th>28</th><th>30</th></tr>";
		}
		
		echo "<tr>";
		echo "<td><input type=\"radio\" name=\"radiobutton[]\" value=\"".$sql_row['id']."\" onClick=\"gotolink(".$sql_row['id'].")\"></td>";
		echo "<td>".$sql_row['packing_method']."</td>";
		echo "<td>".$sql_row['xs']."</td>";
		echo "<td>".$sql_row['s']."</td>";
		echo "<td>".$sql_row['m']."</td>";
		echo "<td>".$sql_row['l']."</td>";
		echo "<td>".$sql_row['xl']."</td>";
		echo "<td>".$sql_row['xxl']."</td>";
		echo "<td>".$sql_row['xxxl']."</td>";
		echo "<td>".$sql_row['s06']."</td>";
		
		echo "<td>".$sql_row['s08']."</td>";
		echo "<td>".$sql_row['s10']."</td>";
		echo "<td>".$sql_row['s12']."</td>";
		echo "<td>".$sql_row['s14']."</td>";
		echo "<td>".$sql_row['s16']."</td>";
		echo "<td>".$sql_row['s18']."</td>";
		echo "<td>".$sql_row['s20']."</td>";
		echo "<td>".$sql_row['s22']."</td>";
		echo "<td>".$sql_row['s24']."</td>";
		echo "<td>".$sql_row['s26']."</td>";
		echo "<td>".$sql_row['s28']."</td>";
		echo "<td>".$sql_row['s30']."</td>";
		echo "</tr>";
	}
	else
	{
		if($x==0)
		{
			echo "<table><tr class='tblheading'><th>Select</th><th>Packing Method</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>06</th><th>08</th><th>10</th><th>12</th><th>14</th><th>16</th><th>18</th><th>20</th><th>22</th><th>24</th><th>26</th><th>28</th><th>30</th></tr>";
		}
		echo "<tr>";
		echo "<td><input type=\"radio\" name=\"radiobutton[]\" value=\"".$sql_row['id']."\" onClick=\"gotolink(".$sql_row['id'].")\"></td>";
		echo "<td>".$sql_row['packing_method']."</td>";
		echo "<td>".$sql_row['xs']."</td>";
		echo "<td>".$sql_row['s']."</td>";
		echo "<td>".$sql_row['m']."</td>";
		echo "<td>".$sql_row['l']."</td>";
		echo "<td>".$sql_row['xl']."</td>";
		echo "<td>".$sql_row['xxl']."</td>";
		echo "<td>".$sql_row['xxxl']."</td>";
		echo "<td>".$sql_row['s06']."</td>";
		echo "<td>".$sql_row['s08']."</td>";
		echo "<td>".$sql_row['s10']."</td>";
		echo "<td>".$sql_row['s12']."</td>";
		echo "<td>".$sql_row['s14']."</td>";
		echo "<td>".$sql_row['s16']."</td>";
		echo "<td>".$sql_row['s18']."</td>";
		echo "<td>".$sql_row['s20']."</td>";
		echo "<td>".$sql_row['s22']."</td>";
		echo "<td>".$sql_row['s24']."</td>";
		echo "<td>".$sql_row['s26']."</td>";
		echo "<td>".$sql_row['s28']."</td>";
		echo "<td>".$sql_row['s30']."</td>";
		echo "</tr>";
	}
	$carton_id_new_create=$sql_row['id'];
	$x++;
}
*/	
$sql2="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and category in (\"Body\",\"Front\")";
mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$cat_ref=$sql_row2['tid'];
}
//echo "cat_ref=".$cat_ref."<br/>";
$cut_total_qty=0;
$sqla="SELECT  SUM(p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM 
	$bai_pro3.plandoc_stat_log WHERE order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" GROUP BY doc_no";
//echo $sql."<br>";
$resulta=mysqli_query($link, $sqla) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($rowa=mysqli_fetch_array($resulta))
{
	$cut_total_qty=$cut_total_qty+$rowa["doc_qty"];
}

//echo "order qty=".$o_total."<br/>";
//echo "total doc qty=".$cut_total_qty."<br/>";
//echo "old order qty total=".$old_ord_total."<br/>";

echo "<input type=\"hidden\" name=\"cartonid\" value=\"\">
<input type=\"hidden\" name=\"order_tid\" value=\"$tran_order_tid\">
<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";

echo "<input type=\"hidden\" name=\"style\" value=\"$style\">
<input type=\"hidden\" name=\"schedule\" value=\"$schedule\">
<input type=\"hidden\" name=\"ratiopacksize\" value=\"$ratiopacksize\">
<input type=\"hidden\" name=\"packpcs[]\" value=\"$packpcs\">
<input type=\"hidden\" name=\"assort_color[]\" value=\"$assort_color\">
";
if($cut_total_qty >= $o_total)
{

$sql4="select * from $bai_pro3.packing_summary where order_del_no=\"$schedule\"";
// echo "Sql4:".$sql4."<br/>";
$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowsy=mysqli_num_rows($sql_result4);
	
echo "</table>";
//echo "num check rows:".$sql_num_check1."-- carton_id: ".$carton_id."-- rowsy==".$rowsy;
if($sql_num_check1>=1)
{
	
	if($rowsy==0)
	{
		echo "<table class='table-border'><tr class='tblheading'><th>Color</th><th>$size01 </th><th>$size02 </th><th>$size03 </th><th>$size04 </th><th>$size05 </th><th>$size06 </th><th>$size07 </th><th>$size08 </th><th>$size09 </th><th>$size10 </th><th>$size11 </th><th>$size12 </th><th>$size13 </th><th>$size14 </th><th>$size15 </th><th>$size16 </th><th>$size17 </th><th>$size18 </th><th>$size19 </th><th>$size20 </th><th>$size21 </th><th>$size22 </th><th>$size23 </th><th>$size24 </th><th>$size25 </th><th>$size26 </th><th>$size27 </th><th>$size28 </th><th>$size29 </th><th>$size30 </th><th>$size31 </th><th>$size32 </th><th>$size33 </th><th>$size34 </th><th>$size35 </th><th>$size36 </th><th>$size37 </th><th>$size38 </th><th>$size39 </th><th>$size40 </th><th>$size41 </th><th>$size42 </th><th>$size43 </th><th>$size44 </th><th>$size45 </th><th>$size46 </th><th>$size47 </th><th>$size48 </th><th>$size49 </th><th>$size50 </th><th >Total</th></tr>";
		$sql2x="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		mysqli_query($link, $sql2x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2x=mysqli_query($link, $sql2x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2x=mysqli_fetch_array($sql_result2x))
		{
			$o_s_xs=$sql_row2x['order_s_xs'];
			$o_s_s=$sql_row2x['order_s_s'];
			$o_s_m=$sql_row2x['order_s_m'];
			$o_s_l=$sql_row2x['order_s_l'];
			$o_s_xl=$sql_row2x['order_s_xl'];
			$o_s_xxl=$sql_row2x['order_s_xxl'];
			$o_s_xxxl=$sql_row2x['order_s_xxxl'];
			
			$o_s_s01=$sql_row2x['order_s_s01'];
			$o_s_s02=$sql_row2x['order_s_s02'];
			$o_s_s03=$sql_row2x['order_s_s03'];
			$o_s_s04=$sql_row2x['order_s_s04'];
			$o_s_s05=$sql_row2x['order_s_s05'];
			$o_s_s06=$sql_row2x['order_s_s06'];
			$o_s_s07=$sql_row2x['order_s_s07'];
			$o_s_s08=$sql_row2x['order_s_s08'];
			$o_s_s09=$sql_row2x['order_s_s09'];
			$o_s_s10=$sql_row2x['order_s_s10'];
			$o_s_s11=$sql_row2x['order_s_s11'];
			$o_s_s12=$sql_row2x['order_s_s12'];
			$o_s_s13=$sql_row2x['order_s_s13'];
			$o_s_s14=$sql_row2x['order_s_s14'];
			$o_s_s15=$sql_row2x['order_s_s15'];
			$o_s_s16=$sql_row2x['order_s_s16'];
			$o_s_s17=$sql_row2x['order_s_s17'];
			$o_s_s18=$sql_row2x['order_s_s18'];
			$o_s_s19=$sql_row2x['order_s_s19'];
			$o_s_s20=$sql_row2x['order_s_s20'];
			$o_s_s21=$sql_row2x['order_s_s21'];
			$o_s_s22=$sql_row2x['order_s_s22'];
			$o_s_s23=$sql_row2x['order_s_s23'];
			$o_s_s24=$sql_row2x['order_s_s24'];
			$o_s_s25=$sql_row2x['order_s_s25'];
			$o_s_s26=$sql_row2x['order_s_s26'];
			$o_s_s27=$sql_row2x['order_s_s27'];
			$o_s_s28=$sql_row2x['order_s_s28'];
			$o_s_s29=$sql_row2x['order_s_s29'];
			$o_s_s30=$sql_row2x['order_s_s30'];
			$o_s_s31=$sql_row2x['order_s_s31'];
			$o_s_s32=$sql_row2x['order_s_s32'];
			$o_s_s33=$sql_row2x['order_s_s33'];
			$o_s_s34=$sql_row2x['order_s_s34'];
			$o_s_s35=$sql_row2x['order_s_s35'];
			$o_s_s36=$sql_row2x['order_s_s36'];
			$o_s_s37=$sql_row2x['order_s_s37'];
			$o_s_s38=$sql_row2x['order_s_s38'];
			$o_s_s39=$sql_row2x['order_s_s39'];
			$o_s_s40=$sql_row2x['order_s_s40'];
			$o_s_s41=$sql_row2x['order_s_s41'];
			$o_s_s42=$sql_row2x['order_s_s42'];
			$o_s_s43=$sql_row2x['order_s_s43'];
			$o_s_s44=$sql_row2x['order_s_s44'];
			$o_s_s45=$sql_row2x['order_s_s45'];
			$o_s_s46=$sql_row2x['order_s_s46'];
			$o_s_s47=$sql_row2x['order_s_s47'];
			$o_s_s48=$sql_row2x['order_s_s48'];
			$o_s_s49=$sql_row2x['order_s_s49'];
			$o_s_s50=$sql_row2x['order_s_s50'];
			
			$old_ord_total=($o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
		}
		$sql2="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$o_s_xs=$sql_row2['order_s_xs'];
			$o_s_s=$sql_row2['order_s_s'];
			$o_s_m=$sql_row2['order_s_m'];
			$o_s_l=$sql_row2['order_s_l'];
			$o_s_xl=$sql_row2['order_s_xl'];
			$o_s_xxl=$sql_row2['order_s_xxl'];
			$o_s_xxxl=$sql_row2['order_s_xxxl'];
			$o_s_s01=$sql_row2['order_s_s01'];
			$o_s_s02=$sql_row2['order_s_s02'];
			$o_s_s03=$sql_row2['order_s_s03'];
			$o_s_s04=$sql_row2['order_s_s04'];
			$o_s_s05=$sql_row2['order_s_s05'];
			$o_s_s06=$sql_row2['order_s_s06'];
			$o_s_s07=$sql_row2['order_s_s07'];
			$o_s_s08=$sql_row2['order_s_s08'];
			$o_s_s09=$sql_row2['order_s_s09'];
			$o_s_s10=$sql_row2['order_s_s10'];
			$o_s_s11=$sql_row2['order_s_s11'];
			$o_s_s12=$sql_row2['order_s_s12'];
			$o_s_s13=$sql_row2['order_s_s13'];
			$o_s_s14=$sql_row2['order_s_s14'];
			$o_s_s15=$sql_row2['order_s_s15'];
			$o_s_s16=$sql_row2['order_s_s16'];
			$o_s_s17=$sql_row2['order_s_s17'];
			$o_s_s18=$sql_row2['order_s_s18'];
			$o_s_s19=$sql_row2['order_s_s19'];
			$o_s_s20=$sql_row2['order_s_s20'];
			$o_s_s21=$sql_row2['order_s_s21'];
			$o_s_s22=$sql_row2['order_s_s22'];
			$o_s_s23=$sql_row2['order_s_s23'];
			$o_s_s24=$sql_row2['order_s_s24'];
			$o_s_s25=$sql_row2['order_s_s25'];
			$o_s_s26=$sql_row2['order_s_s26'];
			$o_s_s27=$sql_row2['order_s_s27'];
			$o_s_s28=$sql_row2['order_s_s28'];
			$o_s_s29=$sql_row2['order_s_s29'];
			$o_s_s30=$sql_row2['order_s_s30'];
			$o_s_s31=$sql_row2['order_s_s31'];
			$o_s_s32=$sql_row2['order_s_s32'];
			$o_s_s33=$sql_row2['order_s_s33'];
			$o_s_s34=$sql_row2['order_s_s34'];
			$o_s_s35=$sql_row2['order_s_s35'];
			$o_s_s36=$sql_row2['order_s_s36'];
			$o_s_s37=$sql_row2['order_s_s37'];
			$o_s_s38=$sql_row2['order_s_s38'];
			$o_s_s39=$sql_row2['order_s_s39'];
			$o_s_s40=$sql_row2['order_s_s40'];
			$o_s_s41=$sql_row2['order_s_s41'];
			$o_s_s42=$sql_row2['order_s_s42'];
			$o_s_s43=$sql_row2['order_s_s43'];
			$o_s_s44=$sql_row2['order_s_s44'];
			$o_s_s45=$sql_row2['order_s_s45'];
			$o_s_s46=$sql_row2['order_s_s46'];
			$o_s_s47=$sql_row2['order_s_s47'];
			$o_s_s48=$sql_row2['order_s_s48'];
			$o_s_s49=$sql_row2['order_s_s49'];
			$o_s_s50=$sql_row2['order_s_s50'];
			
			$o_total=($o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
			
			echo "<tr><td>".$sql_row2['order_col_des']."<input type=\"hidden\" name=\"assort_color[]\" value=\"".$sql_row2['order_col_des']."\"></td>";

			
			echo "<td class=\"sizes\">$o_s_s01</td>";
			echo "<td class=\"sizes\">$o_s_s02</td>";
			echo "<td class=\"sizes\">$o_s_s03</td>";
			echo "<td class=\"sizes\">$o_s_s04</td>";
			echo "<td class=\"sizes\">$o_s_s05</td>";
			echo "<td class=\"sizes\">$o_s_s06</td>";
			echo "<td class=\"sizes\">$o_s_s07</td>";
			echo "<td class=\"sizes\">$o_s_s08</td>";
			echo "<td class=\"sizes\">$o_s_s09</td>";
			echo "<td class=\"sizes\">$o_s_s10</td>";
			echo "<td class=\"sizes\">$o_s_s11</td>";
			echo "<td class=\"sizes\">$o_s_s12</td>";
			echo "<td class=\"sizes\">$o_s_s13</td>";
			echo "<td class=\"sizes\">$o_s_s14</td>";
			echo "<td class=\"sizes\">$o_s_s15</td>";
			echo "<td class=\"sizes\">$o_s_s16</td>";
			echo "<td class=\"sizes\">$o_s_s17</td>";
			echo "<td class=\"sizes\">$o_s_s18</td>";
			echo "<td class=\"sizes\">$o_s_s19</td>";
			echo "<td class=\"sizes\">$o_s_s20</td>";
			echo "<td class=\"sizes\">$o_s_s21</td>";
			echo "<td class=\"sizes\">$o_s_s22</td>";
			echo "<td class=\"sizes\">$o_s_s23</td>";
			echo "<td class=\"sizes\">$o_s_s24</td>";
			echo "<td class=\"sizes\">$o_s_s25</td>";
			echo "<td class=\"sizes\">$o_s_s26</td>";
			echo "<td class=\"sizes\">$o_s_s27</td>";
			echo "<td class=\"sizes\">$o_s_s28</td>";
			echo "<td class=\"sizes\">$o_s_s29</td>";
			echo "<td class=\"sizes\">$o_s_s30</td>";
			echo "<td class=\"sizes\">$o_s_s31</td>";
			echo "<td class=\"sizes\">$o_s_s32</td>";
			echo "<td class=\"sizes\">$o_s_s33</td>";
			echo "<td class=\"sizes\">$o_s_s34</td>";
			echo "<td class=\"sizes\">$o_s_s35</td>";
			echo "<td class=\"sizes\">$o_s_s36</td>";
			echo "<td class=\"sizes\">$o_s_s37</td>";
			echo "<td class=\"sizes\">$o_s_s38</td>";
			echo "<td class=\"sizes\">$o_s_s39</td>";
			echo "<td class=\"sizes\">$o_s_s40</td>";
			echo "<td class=\"sizes\">$o_s_s41</td>";
			echo "<td class=\"sizes\">$o_s_s42</td>";
			echo "<td class=\"sizes\">$o_s_s43</td>";
			echo "<td class=\"sizes\">$o_s_s44</td>";
			echo "<td class=\"sizes\">$o_s_s45</td>";
			echo "<td class=\"sizes\">$o_s_s46</td>";
			echo "<td class=\"sizes\">$o_s_s47</td>";
			echo "<td class=\"sizes\">$o_s_s48</td>";
			echo "<td class=\"sizes\">$o_s_s49</td>";
			echo "<td class=\"sizes\">$o_s_s50</td>";
			echo "<td class=\"sizes\">".$o_total."</td></tr>";
		}
		echo "</table>";
		
		
		
		echo "<input type=\"submit\" name=\"submit\" value=\"Generate Ratio Packing List\">";
		//echo "<a href=\"packing/packing_list_gen.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\">Please generate Packing List</a>";
	}
	else
	{
		
		if($ratio_packing_method=='single')
		{
			$url = getFullURL($_GET['r'],'packing_list_print_assort_rplg.php','N');
			echo "<br/><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."packing_list_print_assort_rplg.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\">Print Packing List </a><br/>";

			if($carton_print_status!=1)
			{
				$url = getFullURLLevel($_GET['r'],'reports/pdfs/labels_assort_v2_rplg',2,'R');
				echo "<a href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\">Print Labels 4\"x2\"</a><br/>";
			}
			else
			{
				echo "Carton Labels are already generated!! <br/>";
			}
			
			$url = getFullURL($_GET['r'],'packing_check_list_assort_rplg.php','N');
			echo "<br/><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."packing_check_list_assort_rplg.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\">Carton Track</a><br/>";
		}
		else if($ratio_packing_method=='multiple')
		{
			$url = getFullURL($_GET['r'],'packing_list_print_assort_multiple_rplg.php','N');
			echo "<br/><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."packing_list_print_assort_multiple_rplg.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\">Print Packing List </a><br/>";

			if($carton_print_status!=1)
			{
				$url = getFullURLLevel($_GET['r'],'reports/pdfs/labels_assort_v2_multiple_rplg',2,'R');
				echo "<a href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\">Print Labels 4\"x2\"</a><br/>";
			}
			else
			{
				echo "Carton Labels are already generated!! <br/>";
			}
			$url = getFullURL($_GET['r'],'packing_check_list_assort_multiple_rplg.php','N');
			echo "<br/><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."packing_check_list_assort_multiple_rplg.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\">Carton Track</a><br/>";
			
		
		}
	}
}
else
{
	//echo "Wrong with Ratio quantity. ";
}
}
else
{
	echo "<h2>Still Cut Plan not yet generated. Please check with CAD team.</h2>";
}

echo "</form>";
?>

<?php

if(isset($_POST['submit']))
{
	$order_tid=$_POST['order_tid'];
	$cat_ref=$_POST['cat_ref'];
	$cartonid=$_POST['cartonid'];
	$packpcs=$_POST['packpcs'];
	$assort_color=$_POST['assort_color'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$ratiopacksize=$_POST['ratiopacksize'];
	
	$packpcs_new=array();
	for($i=0;$i<sizeof($packpcs);$i++)
	{
		$packpcs_new[]=$packpcs[$i];	
	}
	$packpcs_check=implode(",",$packpcs_new);
	
	$assort_color_new=array();
	for($i=0;$i<sizeof($assort_color);$i++)
	{
		$assort_color_new[]=$assort_color[$i];	
	}
	$assort_color_check=implode(",",$assort_color_new);
	
	//echo "<br/>".$order_tid."--".$cat_ref."--".$cartonid."--".$packpcs."--".$assort_color."--".$style."--".$schedule."--".$packpcs_check."--".$assort_color_check;
	$url = getFullURL($_GET['r'],'packing_list_gen_assort_rplg.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); 
				function Redirect() {  
					location.href = \"$url&order_tid=$order_tid&cat_ref=$cat_ref&carton_id=$cartonid&style=$style&schedule=$schedule&packpcs=$packpcs_check&assortcolor=$assort_color_check&ratiopacksize=$ratiopacksize\"; 
				}
		  </script>";
	
}

?>
