<?php
echo "<form name=\"input\" method=\"post\" action=\"index.php?r=".$_GET['r']."\">";

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
			foreach($sizes_array as $key=>$value)
			{
				$all_sizes[$value] = "title_size_".$value;
				$all_size_values[$value] = "order_s_".$value;
				
				$final_size_values[$sql_row[$all_sizes[$value]]] = $sql_row[$all_size_values[$value]];
				$tot_sizes[$value] =  $sql_row[$all_size_values[$value]];
			}
			$final_size_values = array_filter($final_size_values);
			$tot_sizes = array_filter($tot_sizes);
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

$sql2="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and category in (\"Body\",\"Front\")";
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$cat_ref=$sql_row2['tid'];
}
//echo "cat_ref=".$cat_ref."<br/>";
$cut_total_qty=0;
$sqla="SELECT  SUM(p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" GROUP BY doc_no";
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
			echo "<table class='table table-bordered'><tr class='tblheading'><th>Color</th>";
			foreach($final_size_values as $key => $value)
			{
				echo "<th>$key</th>";
			}
			echo "<th>Total</th></tr>";
			$sql2="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{			
				echo "<tr><td>".$sql_row2['order_col_des']."<input type=\"hidden\" name=\"assort_color[]\" value=\"".$sql_row2['order_col_des']."\"></td>";
				$o_total = 0;
				foreach($final_size_values as $key => $value)
				{
					echo "<td>$final_size_values[$key]</td>";
					$o_total += $final_size_values[$key];
				}
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
	$url = getFullURL($_GET['r'],'packing_list_gen_assort.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); 
				function Redirect() {  
					location.href = \"$url&order_tid=$order_tid&cat_ref=$cat_ref&carton_id=$cartonid&style=$style&schedule=$schedule&packpcs=$packpcs_check&assortcolor=$assort_color_check&ratiopacksize=$ratiopacksize\"; 
				}
		  </script>";
	
}

?>
