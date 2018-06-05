<?php
	echo "<form name=\"input\" method=\"post\" action='#'>";
	echo "<h4><b>Suggested Carton Qty</b></h4><hr>";
	$sql="select * from $bai_pro3.carton_qty_chart where user_style=\"$style_id\" and status=0";
	mysqli_query($link, $sql) or exit("Sql Errork".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Errorl".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	$x=0;
	$radio = 0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		foreach ($sizes_array as $key => $value)
		{
			$all_sizes[$value] = "title_size_".$value;
			$all_size_values[$value] = "order_s_".$value;
			// $final_size_values[$sql_row[$all_sizes[$value]]] = $sql_row[$all_size_values[$value]];
			$qty_final[$value] = $sql_row[$sizes_array[$key]];
			$sizes_headers[$sizes_array[$key]] = $sql_row[$sizes_array[$key]];
			$filtering_function = array_filter($sizes_headers);
		}
		
		if($sql_row['packing_method'] != null)
		{
			if($x==0)
			{
				
				echo "<div class='table-responsive'><table class='table table-bordered'><tr class='tblheading'><th style='width:10px;'>Select</th><th>Packing Method</th>";
				foreach($final_size_values as $key=>$value)
				{
					echo "<th>$key</th>";
				}
				echo "</tr>";
				
			}
			echo "<tr>";
			echo "<td><input type=\"radio\" id=\"radio_btn_$radio\" class=\"radiobutton\" name=\"radiobutton[]\" value=\"".$sql_row['id']."\" onClick=\"gotolink(".$sql_row['id'].")\"></td>";
			$radio++;
			echo "<td>".$sql_row['packing_method']."</td>";
			foreach($tot_sizes as $key=>$value)
			{
				// if($filtering_function[$key] != null)
				// {
				echo "<td>$qty_final[$key]</td>";
				// }
			}
			echo "</tr>";
			$carton_id_new_create=$sql_row['id'];
			$x++;
		}	

	// }
	}
	echo "</table></div><br>";
	$sql2="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and category in (\"Body\",\"Front\")";
	mysqli_query($link, $sql2) or exit("Sql Errora".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Errorb".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$cat_ref=$sql_row2['tid'];
	}
	$cut_total_qty=0;
	foreach ($sizes_array as $key => $value)
	{
		$order = 'p_'.$sizes_array[$key];
		$sqla="SELECT $order*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE cat_ref=\"$cat_ref\" GROUP BY doc_no";
		// echo $sqla;
		$resulta=mysqli_query($link, $sqla) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rowa=mysqli_fetch_array($resulta))
		{
			$cut_total_qty=$cut_total_qty+$rowa["doc_qty"];
		}	
		// $al_sizes[$value] = "title_size_".$value;
		// $al_size_values[$value] = "order_s_".$value;
		// $final_size_value[$sql_row[$al_sizes[$value]]] = $sql_row[$al_size_values[$value]];
	}
	// var_dump($final_size_values);
	// die();
	// $final_size_value = array_filter($final_size_value);
	// $sqla="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM plandoc_stat_log WHERE cat_ref=\"$cat_ref\" GROUP BY doc_no";
	//echo $sql."<br>";
	// $resulta=mysqli_query($link, $sqla) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($rowa=mysqli_fetch_array($resulta))
	// {
	// $cut_total_qty=$cut_total_qty+$rowa["doc_qty"];
	// }

	if($cut_total_qty >= $o_total)
	{
		$sql4="select * from $bai_pro3.packing_summary where order_del_no=\"$schedule\"";
		$sql_result4=mysqli_query($link, $sql4) or exit("Sql Errord".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowsy=mysqli_num_rows($sql_result4);
		if($sql_num_check>=1)
		{
			if($carton_id==0 || $rowsy==0)
			{
				echo "<input type=\"hidden\" name=\"cartonid\" value=\"\"><input type=\"hidden\" name=\"order_tid\" value=\"$tran_order_tid\"><input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
				echo "<input type=\"hidden\" name=\"style\" value=\"$style\">
				<input type=\"hidden\" name=\"schedule\" value=\"$schedule\">";
				$col_des=$color;	
				echo "<table class='table table-bordered'><tr class='tblheading'><th>Color</th><th>Assortment pcs in Pack</th>";
				foreach($final_size_values as $key=>$value)
				{
					echo "<th>$key</th>";
				}
				echo "<th >Total</th></tr>";
				$sql2="select * from bai_orders_db_confirm where $filter_joins order_del_no=\"$schedule\"";
				$sql_result2=mysqli_query($link,$sql2) or exit("Sql Errord".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$o_total=0;
					echo "<tr><td>".$sql_row2['order_col_des']."</td><td><input type=\"text\" name=\"packpcs[]\" value=\"1\"><input type=\"hidden\" name=\"assort_color[]\" value=\"".$sql_row2['order_col_des']."\"></td>";
					foreach($filtering_function as $key=>$value)
					{
						echo "<td class=\"sizes\">".$sql_row2["order_s_".$key.""]."</td>";
						$o_total+=$sql_row2["order_s_".$key.""];
					}					
					echo "<td class=\"sizes\">".$o_total."</td></tr>";
				}
				echo "</table>";
				echo "<input type=\"submit\" name=\"submit\" value=\"Generate Packing List\" class=\"btn btn-primary\" onclick=\"return validate_form();\">";
			}
			else
			{
				$url = getFullURL($_GET['r'],'packing_list_print_assort.php','R');
				echo "<div class='row'><div class='col-md-2'><a class=\"btn btn-warning btn-xs\" href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>  Print Packing List </a>";
				$url = getFullURL($_GET['r'],'packing_check_list_assort.php','R');
				echo "</div><div class='col-md-2'><a class=\"btn btn-warning btn-xs\" href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>  Carton Track</a></div></div>";
				if($carton_print_status!=1)
				{
					$url = getFullURLLevel($_GET['r'],'common/lib/mpdf7/labels_assort_v2.php',4,'R');
					echo "<div class='row'><div class='col-md-2'><a class=\"btn btn-warning btn-xs\" href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>  Print Labels 4\"x2\"</a><br/>";
					$url = getFullURLLevel($_GET['r'],'common/lib/mpdf7/labels_assort_v1.php',4,'R');
					echo "</div><div class='col-md-2'><a class=\"btn btn-warning btn-xs\" href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>  Print Labels 2.5\"x1\"</a><br/>";
					$url = getFullURLLevel($_GET['r'],'reports/pdfs/labels_assort_track_2.php','R');
					echo "</div><div class='col-md-2' style='display:none;'><a class=\"btn btn-warning btn-xs\" href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>  Track Labels 2.5\"x1\"</a><br/></div></div>";
				}
				else
				{
					echo '<div class="alert alert-warning" role="alert">Carton Labels are already generated!!</div><br/>';
				}
			}
		}
		else
		{
			echo '<div class="alert alert-danger" role="alert">Wrong with carton qty updatation</div>';
		}
	}
	else
	{
		echo '<div class="alert alert-info" role="alert">Still cutplan not yet generated. Please check with CAD team.</div>';
		//echo "<h2>Still cutplan not yet generated. Please check with CAD team.</h2>";
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
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	//$color_ref=$_POST['color'];
	$packpcs_new=array();
	for($i=0;$i<sizeof($packpcs);$i++)
	{
	$packpcs_new[]=$packpcs[$i];	
	}
	$packpcs_check=implode(",",$packpcs_new);

	$assort_color_new=array();
	// for($i1=0;$i1<sizeof($assort_color);$i1++)
	// {
	// 	echo "Color=".$assort_color[$i1]."<br>";
	// 	$assort_color_new[]=$assort_color[$i1];	
	// }

	//$sql4="select order_col_des from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"".$color_ref."\"";
	$sql4="select order_col_des from $bai_pro3.bai_orders_db_confirm where $filter_joins order_del_no=\"$schedule\"";
	//echo $sql4."<br>";
	$sql_result4=mysqli_query($link, $sql4) or exit("Sql Errord".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rowsy=mysqli_fetch_array($sql_result4))
	{
		$assort_color_new[]=$rowsy["order_col_des"];	
	}

	$assort_color_check=implode(",",$assort_color_new);
	//echo "COlor=".$assort_color_check."<br>";
	$sql2="select packing_method from $bai_pro3.carton_qty_chart where id='$cartonid'";
	// mysqli_query($link, $sql2) or exit("Sql Errorg".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Errorh".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$packing_method=check_style($sql_row2['packing_method']);
	}
	//echo $assort_color_check."<br>";
	if(array_sum($packpcs)==$packing_method)
	{
		$url = getFullURL($_GET['r'],'packing_list_gen_assort.php','N');			
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url&order_tid=$order_tid&cat_ref=$cat_ref&carton_id=$cartonid&assortcolor=$assort_color_check&style=$style&schedule=$schedule&packpcs=$packpcs_check\"; }</script>";
	}
	else
	{
		echo '<div class="alert alert-warning" role="alert">Please check packing pcs quantity.</div>';
		//echo "Please check packing pcs quantity.";
	}
	

}

?>

</div>

<style>
th,td{
	text-align:center;
}
</style>
<script language="javascript">
	function validate_form(){
		// $("input[name='radiobutton']").each(
			// function(){
			// 	if($(this).find('input[type="radio"]:checked').length > 0)
			// 	{
			// 		alert("checked");
			// 	}else
			// 	{
			// 		alert("not checked");
			// 	} 
			// });
		// );
		var flag = false;
		for (let index = 0; index < $(".radiobutton").length; index++) {
			console.log($('#radio_btn_'+index).is(':checked'));
			if($('#radio_btn_'+index).is(':checked')){
				return true;
				flag = true;
			}else{
				flag = false;
			}			
		}
		console.log(flag);
		if(flag){
			return true;
		}else{
			sweetAlert('Please check packing pcs quantity.','','warning');
			return false;
		}
	}
</script>