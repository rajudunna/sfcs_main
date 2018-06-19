
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R') );  ?>

<script language="javascript">

	var state = 'none';
	function showhide(layer_ref) {
		if (state == 'block') {
			state = 'none';
		}
		else {
			state = 'block';
		}
		if (document.all) { //IS IE 4 or 5 (or 6 beta)
			eval( "document.all." + layer_ref + ".style.display = state");
		}
		if (document.layers) { //IS NETSCAPE 4 or below
			document.layers[layer_ref].display = state;
		}
		if (document.getElementById &&!document.all) {
			hza = document.getElementById(layer_ref);
			hza.style.display = state;
		}
	}
</script> 
<script language="Javascript" type="text/javascript">
	function gotolink(x) { 
		input.cartonid.value=x; 
	}
</script>

<div class="panel panel-primary">
	<div class="panel-heading">Ratio Packing List Generation</div>
	<div class="panel-body">
	<?php
		function check_style($string)
		{
			$check=0;
			for ($index=0;$index<strlen($string);$index++) {
		    	if(isNumber($string[$index]))
				{
					$nums .= $string[$index];
				}
		     	else    
				{
					$chars .= $string[$index];
					$check=$check+1;
					if($check==2)
					{
						break;
					}
				}
		       		
					
			}
			//echo "Chars: -$chars-<br>Nums: -$nums-";
			return $nums;
		}

		function isNumber($c) {
		    return preg_match('/[0-9]/', $c);
		}
	?> 

	<?php
		if(isset($_POST['style']))
		{
			$style=$_POST['style'];
		}
		else
		{
			$style=$_GET['style'];
		}

		if(isset($_POST['schedule']))
		{
			$schedule=$_POST['schedule'];
		}
		else
		{
			$schedule=$_GET['schedule'];
		}

		if(isset($_POST['color']))
		{
			$color=$_POST['color'];
		}
		else
		{
			$color=$_GET['color'];
		}

		if(isset($_POST['ratiopacksize']))
		{
			$ratiopacksize=$_POST['ratiopacksize'];
		}
		else
		{
			$ratiopacksize=$_GET['ratiopacksize'];
		}
		//echo "Hi".$ratiopacksize;
	?>

	<?php

		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		// echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$tran_order_tid=$sql_row['order_tid'];
			$order_date=$sql_row['order_date'];
			$order_div=$sql_row['order_div'];
			$order_po=$sql_row['order_po_no'];
			$color_code=$sql_row['color_code'];
			$order_color_des=$sql_row['order_color_des'];
			$style_id=$sql_row['style_id'];
			$packing_method=$sql_row['packing_method'];
			$buyer_code=substr($style,0,1);
			$carton_id=$sql_row['carton_id'];
			$carton_print_status=$sql_row['carton_print_status'];
			foreach($sizes_array as $key=>$value)
			{
				$all_sizes[$value] = "title_size_".$value;
				$all_size_values[$value] = "order_s_".$value;
				
				$final_size_values[$sql_row[$all_sizes[$value]]] = $sql_row[$all_size_values[$value]];
			}
				$final_size_values = array_filter($final_size_values);
				//var_dump($final_size_values);
		}
			//$o_total=($o_s_xs+$o_s_s+$o_s_m+$o_s_l+$o_s_xl+$o_s_xxl+$o_s_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
		// echo "<table>";
		// echo "<tr>";
		echo "<table class=\"table table-bordered\">";
		echo "<tr>";
		echo "<td class=\"heading\">Date</td><td>:</td><td class=\"content\">$order_date</td><td class=\"heading\">Division</td><td>:</td><td class=\"content\">$order_div</td><td class=\"heading\">PO</td><td>:</td><td class=\"content\">$order_po</td><td class=\"heading\">Packing Method</td><td>:</td><td class=\"content\">$packing_method</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"heading\">Style</td><td>:</td><td class=\"content\">$style</td><td class=\"heading\">Schedule</td><td>:</td><td class=\"content\">".$schedule.chr($color_code)."</td><td class=\"heading\">Color</td><td>:</td><td class=\"content\">$color</td><td class=\"heading\">User Style ID</td><td>:</td><td class=\"content\">$style_id</td>";
		echo "</tr>";
		echo "</table>";
		echo "</tr>";
		echo "<tr></br>";
		echo "<table class=\"table table-bordered\">";
		echo "<tr align=center class='warning'>
					<td class=\"heading2\" style='background-color:#337ab7;color:white;'>Sizes</td>";
					foreach($final_size_values as $key => $value)
					{
						echo "<td>$key</td>";
					}
		echo "<td>Total</td>";
		echo "</tr>";
		echo "<tr align=center class='warning'>
					<td>Quantity</td>";
					$o_total = 0;
					foreach($final_size_values as $key => $value)
					{
						echo "<td>$final_size_values[$key]</td>";
						$o_total += $final_size_values[$key];
					}
		echo "<td>$o_total</td>";
		echo "</tr>";
		echo "</table>";

		//echo "<input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable";
		//echo "<INPUT TYPE = \"Submit\" Name = \"Update\" VALUE = \"Update\">";
		//echo "</form>";


		$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and length(category)>0";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cat_ref=$sql_row['tid'];
		}


		if($_POST['submit'])
		{
			echo "<h1><font color=\"red\">Please wait while processing data!</font></h1>";
		}
		echo '<a href="#" onclick="showhide('."'div10'".');" class="btn btn-info"><i class="fa fa-list"></i>  Packing List</a>
		<div id="div10" style="display: none;">';
		echo "<div class='panel panel-primary'><div class='panel-body'>";
		include("main_interface_10_assort_rplg.php"); 
		echo "</div></div></div>"; 
		?>
	</div>
</div>