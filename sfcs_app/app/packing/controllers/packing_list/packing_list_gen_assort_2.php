<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php //include('../'.getFullURLLevel($_GET['r'],'functions.php',2,'R') ); This file contents was not used here ?>	

<?php
	$order_tid=$_GET['order_tid'];
	$cat_ref=$_GET['cat_ref'];
	$carton_id=$_GET['carton_id'];
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$color=$_POST['color'];

	$packpcs=array();
	$packpcs=explode(",",$_GET['packpcs']);

	$assortcolor=$_GET['assortcolor'];
	$packpcs_title=implode("$",$packpcs);
	/*
	$assortcolor_title=implode("$",$assortcolor);
	*/
	$assortcolor_title=$assortcolor;
	$label_title=$packpcs_title."*".$assortcolor_title;

	echo $label_title;


	echo "Packs:</br>";
	for($i=0;$i<sizeof($packpcs);$i++)
	{
		echo $packpcs[$i]."-".$assortcolor."<br/>";
	}


	$sum_of_assort_pcs=array_sum($packpcs);
	$assort_docket_db=array();

	echo $sum_of_assort_pcs."<br/>";
?>

<?php
	//Added code for avoiding the duplication of packing lists.
	$sql_group1="select tid from $bai_pro3.packing_summary where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	$sql_result_group1=mysqli_query($link, $sql_group1) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_rows=mysqli_num_rows($sql_result_group1);
	if($sql_rows > 0)
	{
		$url = getFullURL($_GET['r'],'error_packing_list.php','R');
		header("Location:$url");
	}

	for($mm=0;$mm<sizeof($packpcs);$mm++)
	{
		$sql_group="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"".$assortcolor."\"";
		echo $sql_group;
		mysqli_query($link, $sql_group) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result_group=mysqli_query($link, $sql_group) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_group=mysqli_fetch_array($sql_result_group))
		{
			$order_tid=$sql_row_group['order_tid'];
			
			$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\")";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$cat_ref=$sql_row['tid'];
			}
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\" and order_col_des=\"".$assortcolor."\" ";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_confirm=mysqli_num_rows($sql_result);

			if($sql_num_confirm>0)
			{
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\" 
				     and order_col_des=\"".$assortcolor."\"";
			}
			else
			{
				$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\" 
					  and order_col_des=\"".$assortcolor."\"";
			}

			mysqli_query($link, $sql) or exit("Sql Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$style=$sql_row['order_style_no']; //Style
				$color=$sql_row['order_col_des']; //color
				$division=$sql_row['order_div'];
				$delivery=$sql_row['order_del_no']; //Schedule
				$pono=$sql_row['order_po_no']; //po
				$color_code=$sql_row['color_code']; //Color Code
				$orderno=$sql_row['order_no']; 
				$o_xs=$sql_row['order_s_xs'];
				$o_s=$sql_row['order_s_s'];
				$o_m=$sql_row['order_s_m'];
				$o_l=$sql_row['order_s_l'];
				$o_xl=$sql_row['order_s_xl'];
				$o_xxl=$sql_row['order_s_xxl'];
				$o_xxxl=$sql_row['order_s_xxxl'];

				$order_date=$sql_row['order_date'];
				$order_joins=$sql_row['order_joins'];
	
				$o_s01=$sql_row['order_s_s01'];
				$o_s02=$sql_row['order_s_s02'];
				$o_s03=$sql_row['order_s_s03'];
				$o_s04=$sql_row['order_s_s04'];
				$o_s05=$sql_row['order_s_s05'];
				$o_s06=$sql_row['order_s_s06'];
				$o_s07=$sql_row['order_s_s07'];
				$o_s08=$sql_row['order_s_s08'];
				$o_s09=$sql_row['order_s_s09'];
				$o_s10=$sql_row['order_s_s10'];
				$o_s11=$sql_row['order_s_s11'];
				$o_s12=$sql_row['order_s_s12'];
				$o_s13=$sql_row['order_s_s13'];
				$o_s14=$sql_row['order_s_s14'];
				$o_s15=$sql_row['order_s_s15'];
				$o_s16=$sql_row['order_s_s16'];
				$o_s17=$sql_row['order_s_s17'];
				$o_s18=$sql_row['order_s_s18'];
				$o_s19=$sql_row['order_s_s19'];
				$o_s20=$sql_row['order_s_s20'];
				$o_s21=$sql_row['order_s_s21'];
				$o_s22=$sql_row['order_s_s22'];
				$o_s23=$sql_row['order_s_s23'];
				$o_s24=$sql_row['order_s_s24'];
				$o_s25=$sql_row['order_s_s25'];
				$o_s26=$sql_row['order_s_s26'];
				$o_s27=$sql_row['order_s_s27'];
				$o_s28=$sql_row['order_s_s28'];
				$o_s29=$sql_row['order_s_s29'];
				$o_s30=$sql_row['order_s_s30'];
				$o_s31=$sql_row['order_s_s31'];
				$o_s32=$sql_row['order_s_s32'];
				$o_s33=$sql_row['order_s_s33'];
				$o_s34=$sql_row['order_s_s34'];
				$o_s35=$sql_row['order_s_s35'];
				$o_s36=$sql_row['order_s_s36'];
				$o_s37=$sql_row['order_s_s37'];
				$o_s38=$sql_row['order_s_s38'];
				$o_s39=$sql_row['order_s_s39'];
				$o_s40=$sql_row['order_s_s40'];
				$o_s41=$sql_row['order_s_s41'];
				$o_s42=$sql_row['order_s_s42'];
				$o_s43=$sql_row['order_s_s43'];
				$o_s44=$sql_row['order_s_s44'];
				$o_s45=$sql_row['order_s_s45'];
				$o_s46=$sql_row['order_s_s46'];
				$o_s47=$sql_row['order_s_s47'];
				$o_s48=$sql_row['order_s_s48'];
				$o_s49=$sql_row['order_s_s49'];
				$o_s50=$sql_row['order_s_s50'];
			}

			//Assortment
			echo "Color:".$color."<br/>";
			echo "Assort Color:".$assortcolor."<br/>";
			//echo "Key:".array_search($color,$assortcolor);

			//$assort_pcs=$packpcs[array_search($color,$assortcolor)];
			$assort_pcs=$packpcs[$mm];
			$join_xs=0;
			$join_s=0;
			$join_schedule="";
			$join_check=0;
			if($order_joins!="0")
			{
				$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_joins\"";
				mysqli_query($link, $sql) or exit("Sql Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$join_xs=$sql_row['order_s_xs'];
					$join_s=$sql_row['order_s_s'];
					$join_schedule=$sql_row['order_del_no'].chr($sql_row['color_code']);
				}
				$join_check=1;
			}
				
			//$sql="select * from cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
			$sql="select * from $bai_pro3.cat_stat_log where tid=$cat_ref";
			echo $sql."<br>";
			mysqli_query($link, $sql) or exit("Sql Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$cid=$sql_row['tid'];
				$category=$sql_row['category'];
				$gmtway=$sql_row['gmtway'];
				$fab_des=$sql_row['fab_des'];
				$body_yy=$sql_row['catyy'];
				$waist_yy=$sql_row['waist_yy'];
				$leg_yy=$sql_row['leg_yy'];
				$purwidth=$sql_row['purwidth'];
				$compo_no=$sql_row['compo_no'];
				$strip_match=$sql_row['strip_match'];
				$gusset_sep=$sql_row['gusset_sep'];
				$patt_ver=$sql_row['patt_ver'];
				$col_des=$sql_row['col_des'];
			}

			$sql="select * from $bai_pro3.cuttable_stat_log where cat_id=$cid and order_tid=\"$order_tid\"";
			echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error7=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error7=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$excess=$sql_row['cuttable_percent'];
			}

			$sql="select sum(allocate_xs*plies) as \"cuttable_s_xs\", sum(allocate_s*plies) as \"cuttable_s_s\", sum(allocate_m*plies) as \"cuttable_s_m\", sum(allocate_l*plies) as \"cuttable_s_l\", sum(allocate_xl*plies) as \"cuttable_s_xl\", sum(allocate_xxl*plies) as \"cuttable_s_xxl\", sum(allocate_xxxl*plies) as \"cuttable_s_xxxl\", sum(allocate_s01*plies) as \"cuttable_s_s01\", sum(allocate_s02*plies) as \"cuttable_s_s02\", sum(allocate_s03*plies) as \"cuttable_s_s03\", sum(allocate_s04*plies) as \"cuttable_s_s04\", sum(allocate_s05*plies) as \"cuttable_s_s05\", sum(allocate_s06*plies) as \"cuttable_s_s06\", sum(allocate_s07*plies) as \"cuttable_s_s07\", sum(allocate_s08*plies) as \"cuttable_s_s08\", sum(allocate_s09*plies) as \"cuttable_s_s09\", sum(allocate_s10*plies) as \"cuttable_s_s10\", sum(allocate_s11*plies) as \"cuttable_s_s11\", sum(allocate_s12*plies) as \"cuttable_s_s12\", sum(allocate_s13*plies) as \"cuttable_s_s13\", sum(allocate_s14*plies) as \"cuttable_s_s14\", sum(allocate_s15*plies) as \"cuttable_s_s15\", sum(allocate_s16*plies) as \"cuttable_s_s16\", sum(allocate_s17*plies) as \"cuttable_s_s17\", sum(allocate_s18*plies) as \"cuttable_s_s18\", sum(allocate_s19*plies) as \"cuttable_s_s19\", sum(allocate_s20*plies) as \"cuttable_s_s20\", sum(allocate_s21*plies) as \"cuttable_s_s21\", sum(allocate_s22*plies) as \"cuttable_s_s22\", sum(allocate_s23*plies) as \"cuttable_s_s23\", sum(allocate_s24*plies) as \"cuttable_s_s24\", sum(allocate_s25*plies) as \"cuttable_s_s25\", sum(allocate_s26*plies) as \"cuttable_s_s26\", sum(allocate_s27*plies) as \"cuttable_s_s27\", sum(allocate_s28*plies) as \"cuttable_s_s28\", sum(allocate_s29*plies) as \"cuttable_s_s29\", sum(allocate_s30*plies) as \"cuttable_s_s30\", sum(allocate_s31*plies) as \"cuttable_s_s31\", sum(allocate_s32*plies) as \"cuttable_s_s32\", sum(allocate_s33*plies) as \"cuttable_s_s33\", sum(allocate_s34*plies) as \"cuttable_s_s34\", sum(allocate_s35*plies) as \"cuttable_s_s35\", sum(allocate_s36*plies) as \"cuttable_s_s36\", sum(allocate_s37*plies) as \"cuttable_s_s37\", sum(allocate_s38*plies) as \"cuttable_s_s38\", sum(allocate_s39*plies) as \"cuttable_s_s39\", sum(allocate_s40*plies) as \"cuttable_s_s40\", sum(allocate_s41*plies) as \"cuttable_s_s41\", sum(allocate_s42*plies) as \"cuttable_s_s42\", sum(allocate_s43*plies) as \"cuttable_s_s43\", sum(allocate_s44*plies) as \"cuttable_s_s44\", sum(allocate_s45*plies) as \"cuttable_s_s45\", sum(allocate_s46*plies) as \"cuttable_s_s46\", sum(allocate_s47*plies) as \"cuttable_s_s47\", sum(allocate_s48*plies) as \"cuttable_s_s48\", sum(allocate_s49*plies) as \"cuttable_s_s49\", sum(allocate_s50*plies) as \"cuttable_s_s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";


			mysqli_query($link, $sql) or exit("Sql Error8=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error8=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$c_xs=$sql_row['cuttable_s_xs'];
				$c_s=$sql_row['cuttable_s_s'];
				$c_m=$sql_row['cuttable_s_m'];
				$c_l=$sql_row['cuttable_s_l'];
				$c_xl=$sql_row['cuttable_s_xl'];
				$c_xxl=$sql_row['cuttable_s_xxl'];
				$c_xxxl=$sql_row['cuttable_s_xxxl'];
				$cuttable_total=$c_xs+$c_s+$c_m+$c_l+$c_xl+$c_xxl+$c_xxxl;
				
				$c_s01=$sql_row['cuttable_s_s01'];
				$c_s02=$sql_row['cuttable_s_s02'];
				$c_s03=$sql_row['cuttable_s_s03'];
				$c_s04=$sql_row['cuttable_s_s04'];
				$c_s05=$sql_row['cuttable_s_s05'];
				$c_s06=$sql_row['cuttable_s_s06'];
				$c_s07=$sql_row['cuttable_s_s07'];
				$c_s08=$sql_row['cuttable_s_s08'];
				$c_s09=$sql_row['cuttable_s_s09'];
				$c_s10=$sql_row['cuttable_s_s10'];
				$c_s11=$sql_row['cuttable_s_s11'];
				$c_s12=$sql_row['cuttable_s_s12'];
				$c_s13=$sql_row['cuttable_s_s13'];
				$c_s14=$sql_row['cuttable_s_s14'];
				$c_s15=$sql_row['cuttable_s_s15'];
				$c_s16=$sql_row['cuttable_s_s16'];
				$c_s17=$sql_row['cuttable_s_s17'];
				$c_s18=$sql_row['cuttable_s_s18'];
				$c_s19=$sql_row['cuttable_s_s19'];
				$c_s20=$sql_row['cuttable_s_s20'];
				$c_s21=$sql_row['cuttable_s_s21'];
				$c_s22=$sql_row['cuttable_s_s22'];
				$c_s23=$sql_row['cuttable_s_s23'];
				$c_s24=$sql_row['cuttable_s_s24'];
				$c_s25=$sql_row['cuttable_s_s25'];
				$c_s26=$sql_row['cuttable_s_s26'];
				$c_s27=$sql_row['cuttable_s_s27'];
				$c_s28=$sql_row['cuttable_s_s28'];
				$c_s29=$sql_row['cuttable_s_s29'];
				$c_s30=$sql_row['cuttable_s_s30'];
				$c_s31=$sql_row['cuttable_s_s31'];
				$c_s32=$sql_row['cuttable_s_s32'];
				$c_s33=$sql_row['cuttable_s_s33'];
				$c_s34=$sql_row['cuttable_s_s34'];
				$c_s35=$sql_row['cuttable_s_s35'];
				$c_s36=$sql_row['cuttable_s_s36'];
				$c_s37=$sql_row['cuttable_s_s37'];
				$c_s38=$sql_row['cuttable_s_s38'];
				$c_s39=$sql_row['cuttable_s_s39'];
				$c_s40=$sql_row['cuttable_s_s40'];
				$c_s41=$sql_row['cuttable_s_s41'];
				$c_s42=$sql_row['cuttable_s_s42'];
				$c_s43=$sql_row['cuttable_s_s43'];
				$c_s44=$sql_row['cuttable_s_s44'];
				$c_s45=$sql_row['cuttable_s_s45'];
				$c_s46=$sql_row['cuttable_s_s46'];
				$c_s47=$sql_row['cuttable_s_s47'];
				$c_s48=$sql_row['cuttable_s_s48'];
				$c_s49=$sql_row['cuttable_s_s49'];
				$c_s50=$sql_row['cuttable_s_s50'];
			}

		/* NEW 2010-05-22 */
	
			$newyy=0;
			$new_order_qty=0;
			$sql2="select * from $bai_pro3.maker_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";

			mysqli_query($link, $sql2) or exit("Sql Error9=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$mk_new_length=$sql_row2['mklength'];
				$new_allocate_ref=$sql_row2['allocate_ref'];
				
				$sql22="select * from $bai_pro3.allocate_stat_log where tid=$new_allocate_ref";
				mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row22=mysqli_fetch_array($sql_result22))
				{
					$new_plies=$sql_row22['plies'];
				}
				$newyy=$newyy+($mk_new_length*$new_plies);
			}
	
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error10=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_confirm=mysqli_num_rows($sql_result);
			
			if($sql_num_confirm>0)
			{
				$sql2="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
			}
			else
			{
				$sql2="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			}
			mysqli_query($link, $sql2) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$new_order_qty=$sql_row2['sum'];
			}
			
			$newyy2=$newyy/$new_order_qty;
			$savings_new=round((($body_yy-$newyy2)/$body_yy)*100,0);
			//echo "<td>".$savings_new."%</td>";
			/* NEW 2010-05-22 */

	?>


<?php  
 
	$sql="select * from $bai_pro3.carton_qty_chart where id=$carton_id";
	//echo "qury =".$sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$carton_xs=($sql_row['xs']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s=($sql_row['s']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_m=($sql_row['m']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_l=($sql_row['l']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_xl=($sql_row['xl']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_xxl=($sql_row['xxl']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_xxxl=($sql_row['xxxl']/$sum_of_assort_pcs)*$assort_pcs;
		
		$carton_s01=($sql_row['s01']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s02=($sql_row['s02']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s03=($sql_row['s03']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s04=($sql_row['s04']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s05=($sql_row['s05']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s06=($sql_row['s06']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s07=($sql_row['s07']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s08=($sql_row['s08']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s09=($sql_row['s09']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s10=($sql_row['s10']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s11=($sql_row['s11']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s12=($sql_row['s12']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s13=($sql_row['s13']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s14=($sql_row['s14']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s15=($sql_row['s15']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s16=($sql_row['s16']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s17=($sql_row['s17']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s18=($sql_row['s18']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s19=($sql_row['s19']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s20=($sql_row['s20']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s21=($sql_row['s21']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s22=($sql_row['s22']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s23=($sql_row['s23']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s24=($sql_row['s24']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s25=($sql_row['s25']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s26=($sql_row['s26']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s27=($sql_row['s27']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s28=($sql_row['s28']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s29=($sql_row['s29']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s30=($sql_row['s30']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s31=($sql_row['s31']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s32=($sql_row['s32']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s33=($sql_row['s33']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s34=($sql_row['s34']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s35=($sql_row['s35']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s36=($sql_row['s36']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s37=($sql_row['s37']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s38=($sql_row['s38']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s39=($sql_row['s39']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s40=($sql_row['s40']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s41=($sql_row['s41']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s42=($sql_row['s42']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s43=($sql_row['s43']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s44=($sql_row['s44']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s45=($sql_row['s45']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s46=($sql_row['s46']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s47=($sql_row['s47']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s48=($sql_row['s48']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s49=($sql_row['s49']/$sum_of_assort_pcs)*$assort_pcs;
		$carton_s50=($sql_row['s50']/$sum_of_assort_pcs)*$assort_pcs;
	}

	echo $carton_xs."<br/>";
	echo $carton_s."<br/>";
	echo $carton_m."<br/>";
	echo $carton_l."<br/>";
	echo $carton_xl."<br/>";
	echo $carton_xxl."<br/>";
	echo $carton_xxxl."<br/>"; 
 	$a_xs_tot=0;
	$a_s_tot=0;
	$a_m_tot=0;
	$a_l_tot=0;
	$a_xl_tot=0;
	$a_xxl_tot=0;
	$a_xxxl_tot=0;
	$plies_tot=0;
	$a_s01_tot=0;
	$a_s02_tot=0;
	$a_s03_tot=0;
	$a_s04_tot=0;
	$a_s05_tot=0;
	$a_s06_tot=0;
	$a_s07_tot=0;
	$a_s08_tot=0;
	$a_s09_tot=0;
	$a_s10_tot=0;
	$a_s11_tot=0;
	$a_s12_tot=0;
	$a_s13_tot=0;
	$a_s14_tot=0;
	$a_s15_tot=0;
	$a_s16_tot=0;
	$a_s17_tot=0;
	$a_s18_tot=0;
	$a_s19_tot=0;
	$a_s20_tot=0;
	$a_s21_tot=0;
	$a_s22_tot=0;
	$a_s23_tot=0;
	$a_s24_tot=0;
	$a_s25_tot=0;
	$a_s26_tot=0;
	$a_s27_tot=0;
	$a_s28_tot=0;
	$a_s29_tot=0;
	$a_s30_tot=0;
	$a_s31_tot=0;
	$a_s32_tot=0;
	$a_s33_tot=0;
	$a_s34_tot=0;
	$a_s35_tot=0;
	$a_s36_tot=0;
	$a_s37_tot=0;
	$a_s38_tot=0;
	$a_s39_tot=0;
	$a_s40_tot=0;
	$a_s41_tot=0;
	$a_s42_tot=0;
	$a_s43_tot=0;
	$a_s44_tot=0;
	$a_s45_tot=0;
	$a_s46_tot=0;
	$a_s47_tot=0;
	$a_s48_tot=0;
	$a_s49_tot=0;
	$a_s50_tot=0;

	$plies_tot=0;
	
	$ex_xs=0;
	$ex_s=0;
	$ex_m=0;
	$ex_l=0;
	$ex_xl=0;
	$ex_xxl=0;
	$ex_xxxl=0;
	
	$ex_s01_tot=0;
$ex_s02_tot=0;
$ex_s03_tot=0;
$ex_s04_tot=0;
$ex_s05_tot=0;
$ex_s06_tot=0;
$ex_s07_tot=0;
$ex_s08_tot=0;
$ex_s09_tot=0;
$ex_s10_tot=0;
$ex_s11_tot=0;
$ex_s12_tot=0;
$ex_s13_tot=0;
$ex_s14_tot=0;
$ex_s15_tot=0;
$ex_s16_tot=0;
$ex_s17_tot=0;
$ex_s18_tot=0;
$ex_s19_tot=0;
$ex_s20_tot=0;
$ex_s21_tot=0;
$ex_s22_tot=0;
$ex_s23_tot=0;
$ex_s24_tot=0;
$ex_s25_tot=0;
$ex_s26_tot=0;
$ex_s27_tot=0;
$ex_s28_tot=0;
$ex_s29_tot=0;
$ex_s30_tot=0;
$ex_s31_tot=0;
$ex_s32_tot=0;
$ex_s33_tot=0;
$ex_s34_tot=0;
$ex_s35_tot=0;
$ex_s36_tot=0;
$ex_s37_tot=0;
$ex_s38_tot=0;
$ex_s39_tot=0;
$ex_s40_tot=0;
$ex_s41_tot=0;
$ex_s42_tot=0;
$ex_s43_tot=0;
$ex_s44_tot=0;
$ex_s45_tot=0;
$ex_s46_tot=0;
$ex_s47_tot=0;
$ex_s48_tot=0;
$ex_s49_tot=0;
$ex_s50_tot=0;

	
	
//To identify the first cut no.	
$sql="select min(acutno) as firstcut from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$first_cut=$sql_row['firstcut'];
}
		
	
	
//$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno";
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref order by acutno";
echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_xs=$sql_row['a_xs'];
	$a_s=$sql_row['a_s'];
	$a_m=$sql_row['a_m'];
	$a_l=$sql_row['a_l'];
	$a_xl=$sql_row['a_xl'];
	$a_xxl=$sql_row['a_xxl'];
	$a_xxxl=$sql_row['a_xxxl'];
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies']; //20110911
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	$assort_docket_db[]=$docketno;
	
	$a_s01=$sql_row['a_s01'];
	$a_s02=$sql_row['a_s02'];
	$a_s03=$sql_row['a_s03'];
	$a_s04=$sql_row['a_s04'];
	$a_s05=$sql_row['a_s05'];
	$a_s06=$sql_row['a_s06'];
	$a_s07=$sql_row['a_s07'];
	$a_s08=$sql_row['a_s08'];
	$a_s09=$sql_row['a_s09'];
	$a_s10=$sql_row['a_s10'];
	$a_s11=$sql_row['a_s11'];
	$a_s12=$sql_row['a_s12'];
	$a_s13=$sql_row['a_s13'];
	$a_s14=$sql_row['a_s14'];
	$a_s15=$sql_row['a_s15'];
	$a_s16=$sql_row['a_s16'];
	$a_s17=$sql_row['a_s17'];
	$a_s18=$sql_row['a_s18'];
	$a_s19=$sql_row['a_s19'];
	$a_s20=$sql_row['a_s20'];
	$a_s21=$sql_row['a_s21'];
	$a_s22=$sql_row['a_s22'];
	$a_s23=$sql_row['a_s23'];
	$a_s24=$sql_row['a_s24'];
	$a_s25=$sql_row['a_s25'];
	$a_s26=$sql_row['a_s26'];
	$a_s27=$sql_row['a_s27'];
	$a_s28=$sql_row['a_s28'];
	$a_s29=$sql_row['a_s29'];
	$a_s30=$sql_row['a_s30'];
	$a_s31=$sql_row['a_s31'];
	$a_s32=$sql_row['a_s32'];
	$a_s33=$sql_row['a_s33'];
	$a_s34=$sql_row['a_s34'];
	$a_s35=$sql_row['a_s35'];
	$a_s36=$sql_row['a_s36'];
	$a_s37=$sql_row['a_s37'];
	$a_s38=$sql_row['a_s38'];
	$a_s39=$sql_row['a_s39'];
	$a_s40=$sql_row['a_s40'];
	$a_s41=$sql_row['a_s41'];
	$a_s42=$sql_row['a_s42'];
	$a_s43=$sql_row['a_s43'];
	$a_s44=$sql_row['a_s44'];
	$a_s45=$sql_row['a_s45'];
	$a_s46=$sql_row['a_s46'];
	$a_s47=$sql_row['a_s47'];
	$a_s48=$sql_row['a_s48'];
	$a_s49=$sql_row['a_s49'];
	$a_s50=$sql_row['a_s50'];
	$a_xs_tot=$a_xs_tot+($a_xs*$plies);
	$a_s_tot=$a_s_tot+($a_s*$plies);
	$a_m_tot=$a_m_tot+($a_m*$plies);
	$a_l_tot=$a_l_tot+($a_l*$plies);
	$a_xl_tot=$a_xl_tot+($a_xl*$plies);
	$a_xxl_tot=$a_xxl_tot+($a_xxl*$plies);
	$a_xxxl_tot=$a_xxxl_tot+($a_xxxl*$plies);
	
	$a_s01_tot=$a_s01_tot+($a_s01*$plies);
	$a_s02_tot=$a_s02_tot+($a_s02*$plies);
	$a_s03_tot=$a_s03_tot+($a_s03*$plies);
	$a_s04_tot=$a_s04_tot+($a_s04*$plies);
	$a_s05_tot=$a_s05_tot+($a_s05*$plies);
	$a_s06_tot=$a_s06_tot+($a_s06*$plies);
	$a_s07_tot=$a_s07_tot+($a_s07*$plies);
	$a_s08_tot=$a_s08_tot+($a_s08*$plies);
	$a_s09_tot=$a_s09_tot+($a_s09*$plies);
	$a_s10_tot=$a_s10_tot+($a_s10*$plies);
	$a_s11_tot=$a_s11_tot+($a_s11*$plies);
	$a_s12_tot=$a_s12_tot+($a_s12*$plies);
	$a_s13_tot=$a_s13_tot+($a_s13*$plies);
	$a_s14_tot=$a_s14_tot+($a_s14*$plies);
	$a_s15_tot=$a_s15_tot+($a_s15*$plies);
	$a_s16_tot=$a_s16_tot+($a_s16*$plies);
	$a_s17_tot=$a_s17_tot+($a_s17*$plies);
	$a_s18_tot=$a_s18_tot+($a_s18*$plies);
	$a_s19_tot=$a_s19_tot+($a_s19*$plies);
	$a_s20_tot=$a_s20_tot+($a_s20*$plies);
	$a_s21_tot=$a_s21_tot+($a_s21*$plies);
	$a_s22_tot=$a_s22_tot+($a_s22*$plies);
	$a_s23_tot=$a_s23_tot+($a_s23*$plies);
	$a_s24_tot=$a_s24_tot+($a_s24*$plies);
	$a_s25_tot=$a_s25_tot+($a_s25*$plies);
	$a_s26_tot=$a_s26_tot+($a_s26*$plies);
	$a_s27_tot=$a_s27_tot+($a_s27*$plies);
	$a_s28_tot=$a_s28_tot+($a_s28*$plies);
	$a_s29_tot=$a_s29_tot+($a_s29*$plies);
	$a_s30_tot=$a_s30_tot+($a_s30*$plies);
	$a_s31_tot=$a_s31_tot+($a_s31*$plies);
	$a_s32_tot=$a_s32_tot+($a_s32*$plies);
	$a_s33_tot=$a_s33_tot+($a_s33*$plies);
	$a_s34_tot=$a_s34_tot+($a_s34*$plies);
	$a_s35_tot=$a_s35_tot+($a_s35*$plies);
	$a_s36_tot=$a_s36_tot+($a_s36*$plies);
	$a_s37_tot=$a_s37_tot+($a_s37*$plies);
	$a_s38_tot=$a_s38_tot+($a_s38*$plies);
	$a_s39_tot=$a_s39_tot+($a_s39*$plies);
	$a_s40_tot=$a_s40_tot+($a_s40*$plies);
	$a_s41_tot=$a_s41_tot+($a_s41*$plies);
	$a_s42_tot=$a_s42_tot+($a_s42*$plies);
	$a_s43_tot=$a_s43_tot+($a_s43*$plies);
	$a_s44_tot=$a_s44_tot+($a_s44*$plies);
	$a_s45_tot=$a_s45_tot+($a_s45*$plies);
	$a_s46_tot=$a_s46_tot+($a_s46*$plies);
	$a_s47_tot=$a_s47_tot+($a_s47*$plies);
	$a_s48_tot=$a_s48_tot+($a_s48*$plies);
	$a_s49_tot=$a_s49_tot+($a_s49*$plies);
	$a_s50_tot=$a_s50_tot+($a_s50*$plies);

	$plies_tot=$plies_tot+$plies;	
	if($cutno==$first_cut)
	{
		$ex_xs=($c_xs-$o_xs-$join_xs);
		$ex_s=($c_s-$o_s-$join_s);
		$ex_m=($c_m-$o_m);
		$ex_l=($c_l-$o_l);
		$ex_xl=($c_xl-$o_xl);
		$ex_xxl=($c_xxl-$o_xxl);
		$ex_xxxl=($c_xxxl-$o_xxxl);
		$ex_s01=($c_s01-$o_s01);
		$ex_s02=($c_s02-$o_s02);
		$ex_s03=($c_s03-$o_s03);
		$ex_s04=($c_s04-$o_s04);
		$ex_s05=($c_s05-$o_s05);
		$ex_s06=($c_s06-$o_s06);
		$ex_s07=($c_s07-$o_s07);
		$ex_s08=($c_s08-$o_s08);
		$ex_s09=($c_s09-$o_s09);
		$ex_s10=($c_s10-$o_s10);
		$ex_s11=($c_s11-$o_s11);
		$ex_s12=($c_s12-$o_s12);
		$ex_s13=($c_s13-$o_s13);
		$ex_s14=($c_s14-$o_s14);
		$ex_s15=($c_s15-$o_s15);
		$ex_s16=($c_s16-$o_s16);
		$ex_s17=($c_s17-$o_s17);
		$ex_s18=($c_s18-$o_s18);
		$ex_s19=($c_s19-$o_s19);
		$ex_s20=($c_s20-$o_s20);
		$ex_s21=($c_s21-$o_s21);
		$ex_s22=($c_s22-$o_s22);
		$ex_s23=($c_s23-$o_s23);
		$ex_s24=($c_s24-$o_s24);
		$ex_s25=($c_s25-$o_s25);
		$ex_s26=($c_s26-$o_s26);
		$ex_s27=($c_s27-$o_s27);
		$ex_s28=($c_s28-$o_s28);
		$ex_s29=($c_s29-$o_s29);
		$ex_s30=($c_s30-$o_s30);
		$ex_s31=($c_s31-$o_s31);
		$ex_s32=($c_s32-$o_s32);
		$ex_s33=($c_s33-$o_s33);
		$ex_s34=($c_s34-$o_s34);
		$ex_s35=($c_s35-$o_s35);
		$ex_s36=($c_s36-$o_s36);
		$ex_s37=($c_s37-$o_s37);
		$ex_s38=($c_s38-$o_s38);
		$ex_s39=($c_s39-$o_s39);
		$ex_s40=($c_s40-$o_s40);
		$ex_s41=($c_s41-$o_s41);
		$ex_s42=($c_s42-$o_s42);
		$ex_s43=($c_s43-$o_s43);
		$ex_s44=($c_s44-$o_s44);
		$ex_s45=($c_s45-$o_s45);
		$ex_s46=($c_s46-$o_s46);
		$ex_s47=($c_s47-$o_s47);
		$ex_s48=($c_s48-$o_s48);
		$ex_s49=($c_s49-$o_s49);
		$ex_s50=($c_s50-$o_s50);

		// NEW CODE
		if($join_check==1)
		{
	  		//Floor Set
			//echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$join_xs."</td>";
	  		//echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$join_s."</td>";
	 		//echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($join_xs+$join_s)."</td>";
		}
		// NEW CODE
		 
		//XS
		 if(($a_xs*$plies)<$ex_xs)
		 { 
			 //echo "0"; 
			 $ex_xs=$ex_xs-($a_xs*$plies);
		 } 
		 else 
		 {
			 $temp=($a_xs*$plies)-$ex_xs;
			 
			 if($temp==0)
			 {
			 	$ex_xs=0;
			 }
			 if($temp>0)
			 {
			 if($temp<$carton_xs)
			 {
			 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",1,\"P\",$temp)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			 else
			 {
			 	if(is_float($temp/$carton_xs))
				{
					
					$l=1;
					while($temp>0)
					{
						if($temp>=$carton_xs)
						{
									
							$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",$l,\"F\",".($carton_xs).")";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						else
						{
							$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",$l,\"P\",".($temp).")";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						$l++;
						$temp=$temp-$carton_xs;
					}
				}
				else
				{
					for($i=1;$i<=($temp/$carton_xs);$i++)
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",$i,\"F\",$carton_xs)";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			 }
			 $ex_xs=0;
			 }
		 } 
		 
		 //S
		 if(($a_s*$plies)<$ex_s)
		 { 
			 //echo "0"; 
			 $ex_s=$ex_s-($a_s*$plies);
		 } 
		 else 
		 {
			 
			 $temp=($a_s*$plies)-$ex_s;
			 
			 if($temp==0)
			 {
			 	$ex_s=0;	
			 }
			 if($temp>0)
			 {
			 if($temp<$carton_s)
			 {
			 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",1,\"P\",$temp)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			 }
			 else
			 {
			 	if(is_float($temp/$carton_s))
				{
					$l=1;
					while($temp>0)
					{
						if($temp>=$carton_s)
						{
							$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",$l,\"F\",".($carton_s).")";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						else
						{
							$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",$l,\"P\",".($temp).")";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
						}
						$l++;
						$temp=$temp-$carton_s;
					}
				}
				else
				{
					for($i=1;$i<=($temp/$carton_s);$i++)
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",$i,\"F\",$carton_s)";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			 }
			 $ex_s=0;
			 }
		 }
		 
		 //M
 if(($a_m*$plies)<$ex_m)
 { 
	 //echo "0"; 
	 $ex_m=$ex_m-($a_m*$plies);
 } 
 else 
 {
	 
	 $temp=($a_m*$plies)-$ex_m;
	 
	 if($temp==0)
	 {
	 	$ex_m=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_m)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_m))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_m)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",$l,\"F\",".($carton_m).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				$l++;
				$temp=$temp-$carton_m;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_m);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",$i,\"F\",$carton_m)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_m=0; 
	 }
 }
 
 //L
 if(($a_l*$plies)<$ex_l)
 { 
	 //echo "0"; 
	 $ex_l=$ex_l-($a_l*$plies);
 } 
 else 
 {
	 
	 $temp=($a_l*$plies)-$ex_l;
	 
	 if($temp==0)
	 {
	 	$ex_l=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_l)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_l))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_l)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",$l,\"F\",".($carton_l).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				$l++;
				$temp=$temp-$carton_l;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_l);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",$i,\"F\",$carton_l)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_l=0;
	 }
 }
 
 //XL
 if(($a_xl*$plies)<$ex_xl)
 { 
	 //echo "0"; 
	 $ex_xl=$ex_xl-($a_xl*$plies);
 } 
 else 
 {
	 
	 $temp=($a_xl*$plies)-$ex_xl;
	 
	 if($temp==0)
	 {
	 	$ex_xl=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_xl)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xl))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xl)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",$l,\"F\",".($carton_xl).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
				
				$l++;
				$temp=$temp-$carton_xl;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xl);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",$i,\"F\",$carton_xl)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xl=0; 
	 }
 }
 
 //XXL
 if(($a_xxl*$plies)<$ex_xxl)
 { 
	 //echo "0"; 
	 $ex_xxl=$ex_xxl-($a_xxl*$plies);
 } 
 else 
 {
	 
	 $temp=($a_xxl*$plies)-$ex_xxl;
	 
	 if($temp==0)
	 {
	 	$ex_xxl=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_xxl)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xxl))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xxl)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",$l,\"F\",".($carton_xxl).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				$l++;
				$temp=$temp-$carton_xxl;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xxl);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",$i,\"F\",$carton_xxl)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xxl=0; 
	 }
 }
 
 //XXXL
 if(($a_xxxl*$plies)<$ex_xxxl)
 { 
	 //echo "0"; 
	 $ex_xxxl=$ex_xxxl-($a_xxxl*$plies);
 } 
 else 
 {
	 
	 $temp=($a_xxxl*$plies)-$ex_xxxl;
	 
	 if($temp==0)
	 {
	 	$ex_xxxl=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_xxxl)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xxxl))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xxxl)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",$l,\"F\",".($carton_xxxl).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				
				$l++;
				$temp=$temp-$carton_xxxl;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xxxl);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",$i,\"F\",$carton_xxxl)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xxxl=0;
	 }
 }
  //s01 

 if(($a_s01*$plies)<$ex_s01)
 { 
   
  $ex_s01=$ex_s01-($a_s01*$plies);
 } 
 else 
 {
  $temp=($a_s01*$plies)-$ex_s01;
  if($temp==0)
  {
   $ex_s01=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s01)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s01))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s01)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",$l,\"F\",".($carton_s01).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s01;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s01);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",$i,\"F\",$carton_s01)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s01=0;
  }
 }
//s02 

 if(($a_s02*$plies)<$ex_s02)
 { 
   
  $ex_s02=$ex_s02-($a_s02*$plies);
 } 
 else 
 {
  $temp=($a_s02*$plies)-$ex_s02;
  if($temp==0)
  {
   $ex_s02=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s02)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s02))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s02)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",$l,\"F\",".($carton_s02).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s02;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s02);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",$i,\"F\",$carton_s02)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s02=0;
  }
 }
//s03 

 if(($a_s03*$plies)<$ex_s03)
 { 
   
  $ex_s03=$ex_s03-($a_s03*$plies);
 } 
 else 
 {
  $temp=($a_s03*$plies)-$ex_s03;
  if($temp==0)
  {
   $ex_s03=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s03)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s03))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s03)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",$l,\"F\",".($carton_s03).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s03;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s03);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",$i,\"F\",$carton_s03)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s03=0;
  }
 }
//s04 

 if(($a_s04*$plies)<$ex_s04)
 { 
   
  $ex_s04=$ex_s04-($a_s04*$plies);
 } 
 else 
 {
  $temp=($a_s04*$plies)-$ex_s04;
  if($temp==0)
  {
   $ex_s04=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s04)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s04))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s04)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",$l,\"F\",".($carton_s04).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s04;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s04);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",$i,\"F\",$carton_s04)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s04=0;
  }
 }
//s05 

 if(($a_s05*$plies)<$ex_s05)
 { 
   
  $ex_s05=$ex_s05-($a_s05*$plies);
 } 
 else 
 {
  $temp=($a_s05*$plies)-$ex_s05;
  if($temp==0)
  {
   $ex_s05=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s05)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s05))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s05)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",$l,\"F\",".($carton_s05).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s05;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s05);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",$i,\"F\",$carton_s05)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s05=0;
  }
 }
//s06 

 if(($a_s06*$plies)<$ex_s06)
 { 
   
  $ex_s06=$ex_s06-($a_s06*$plies);
 } 
 else 
 {
  $temp=($a_s06*$plies)-$ex_s06;
  if($temp==0)
  {
   $ex_s06=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s06)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s06))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s06)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",$l,\"F\",".($carton_s06).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s06;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s06);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",$i,\"F\",$carton_s06)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s06=0;
  }
 }
//s07 

 if(($a_s07*$plies)<$ex_s07)
 { 
   
  $ex_s07=$ex_s07-($a_s07*$plies);
 } 
 else 
 {
  $temp=($a_s07*$plies)-$ex_s07;
  if($temp==0)
  {
   $ex_s07=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s07)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s07))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s07)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",$l,\"F\",".($carton_s07).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s07;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s07);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",$i,\"F\",$carton_s07)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s07=0;
  }
 }
//s08 

 if(($a_s08*$plies)<$ex_s08)
 { 
   
  $ex_s08=$ex_s08-($a_s08*$plies);
 } 
 else 
 {
  $temp=($a_s08*$plies)-$ex_s08;
  if($temp==0)
  {
   $ex_s08=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s08)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s08))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s08)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",$l,\"F\",".($carton_s08).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s08;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s08);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",$i,\"F\",$carton_s08)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s08=0;
  }
 }
//s09 

 if(($a_s09*$plies)<$ex_s09)
 { 
   
  $ex_s09=$ex_s09-($a_s09*$plies);
 } 
 else 
 {
  $temp=($a_s09*$plies)-$ex_s09;
  if($temp==0)
  {
   $ex_s09=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s09)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s09))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s09)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",$l,\"F\",".($carton_s09).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s09;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s09);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",$i,\"F\",$carton_s09)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s09=0;
  }
 }
//s10 

 if(($a_s10*$plies)<$ex_s10)
 { 
   
  $ex_s10=$ex_s10-($a_s10*$plies);
 } 
 else 
 {
  $temp=($a_s10*$plies)-$ex_s10;
  if($temp==0)
  {
   $ex_s10=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s10)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s10))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s10)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",$l,\"F\",".($carton_s10).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s10;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s10);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",$i,\"F\",$carton_s10)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s10=0;
  }
 }
//s11 

 if(($a_s11*$plies)<$ex_s11)
 { 
   
  $ex_s11=$ex_s11-($a_s11*$plies);
 } 
 else 
 {
  $temp=($a_s11*$plies)-$ex_s11;
  if($temp==0)
  {
   $ex_s11=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s11)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s11))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s11)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",$l,\"F\",".($carton_s11).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s11;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s11);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",$i,\"F\",$carton_s11)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s11=0;
  }
 }
//s12 

 if(($a_s12*$plies)<$ex_s12)
 { 
   
  $ex_s12=$ex_s12-($a_s12*$plies);
 } 
 else 
 {
  $temp=($a_s12*$plies)-$ex_s12;
  if($temp==0)
  {
   $ex_s12=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s12)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s12))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s12)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",$l,\"F\",".($carton_s12).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s12;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s12);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",$i,\"F\",$carton_s12)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s12=0;
  }
 }
//s13 

 if(($a_s13*$plies)<$ex_s13)
 { 
   
  $ex_s13=$ex_s13-($a_s13*$plies);
 } 
 else 
 {
  $temp=($a_s13*$plies)-$ex_s13;
  if($temp==0)
  {
   $ex_s13=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s13)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s13))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s13)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",$l,\"F\",".($carton_s13).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s13;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s13);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",$i,\"F\",$carton_s13)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s13=0;
  }
 }
//s14 

 if(($a_s14*$plies)<$ex_s14)
 { 
   
  $ex_s14=$ex_s14-($a_s14*$plies);
 } 
 else 
 {
  $temp=($a_s14*$plies)-$ex_s14;
  if($temp==0)
  {
   $ex_s14=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s14)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s14))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s14)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",$l,\"F\",".($carton_s14).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s14;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s14);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",$i,\"F\",$carton_s14)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s14=0;
  }
 }
//s15 

 if(($a_s15*$plies)<$ex_s15)
 { 
   
  $ex_s15=$ex_s15-($a_s15*$plies);
 } 
 else 
 {
  $temp=($a_s15*$plies)-$ex_s15;
  if($temp==0)
  {
   $ex_s15=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s15)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s15))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s15)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",$l,\"F\",".($carton_s15).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s15;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s15);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",$i,\"F\",$carton_s15)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s15=0;
  }
 }
//s16 

 if(($a_s16*$plies)<$ex_s16)
 { 
   
  $ex_s16=$ex_s16-($a_s16*$plies);
 } 
 else 
 {
  $temp=($a_s16*$plies)-$ex_s16;
  if($temp==0)
  {
   $ex_s16=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s16)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s16))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s16)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",$l,\"F\",".($carton_s16).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s16;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s16);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",$i,\"F\",$carton_s16)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s16=0;
  }
 }
//s17 

 if(($a_s17*$plies)<$ex_s17)
 { 
   
  $ex_s17=$ex_s17-($a_s17*$plies);
 } 
 else 
 {
  $temp=($a_s17*$plies)-$ex_s17;
  if($temp==0)
  {
   $ex_s17=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s17)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s17))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s17)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",$l,\"F\",".($carton_s17).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s17;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s17);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",$i,\"F\",$carton_s17)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s17=0;
  }
 }
//s18 

 if(($a_s18*$plies)<$ex_s18)
 { 
   
  $ex_s18=$ex_s18-($a_s18*$plies);
 } 
 else 
 {
  $temp=($a_s18*$plies)-$ex_s18;
  if($temp==0)
  {
   $ex_s18=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s18)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s18))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s18)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",$l,\"F\",".($carton_s18).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s18;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s18);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",$i,\"F\",$carton_s18)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s18=0;
  }
 }
//s19 

 if(($a_s19*$plies)<$ex_s19)
 { 
   
  $ex_s19=$ex_s19-($a_s19*$plies);
 } 
 else 
 {
  $temp=($a_s19*$plies)-$ex_s19;
  if($temp==0)
  {
   $ex_s19=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s19)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s19))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s19)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",$l,\"F\",".($carton_s19).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s19;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s19);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",$i,\"F\",$carton_s19)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s19=0;
  }
 }
//s20 

 if(($a_s20*$plies)<$ex_s20)
 { 
   
  $ex_s20=$ex_s20-($a_s20*$plies);
 } 
 else 
 {
  $temp=($a_s20*$plies)-$ex_s20;
  if($temp==0)
  {
   $ex_s20=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s20)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s20))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s20)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",$l,\"F\",".($carton_s20).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s20;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s20);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",$i,\"F\",$carton_s20)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s20=0;
  }
 }
//s21 

 if(($a_s21*$plies)<$ex_s21)
 { 
   
  $ex_s21=$ex_s21-($a_s21*$plies);
 } 
 else 
 {
  $temp=($a_s21*$plies)-$ex_s21;
  if($temp==0)
  {
   $ex_s21=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s21)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s21))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s21)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",$l,\"F\",".($carton_s21).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s21;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s21);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",$i,\"F\",$carton_s21)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s21=0;
  }
 }
//s22 

 if(($a_s22*$plies)<$ex_s22)
 { 
   
  $ex_s22=$ex_s22-($a_s22*$plies);
 } 
 else 
 {
  $temp=($a_s22*$plies)-$ex_s22;
  if($temp==0)
  {
   $ex_s22=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s22)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s22))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s22)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",$l,\"F\",".($carton_s22).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s22;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s22);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",$i,\"F\",$carton_s22)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s22=0;
  }
 }
//s23 

 if(($a_s23*$plies)<$ex_s23)
 { 
   
  $ex_s23=$ex_s23-($a_s23*$plies);
 } 
 else 
 {
  $temp=($a_s23*$plies)-$ex_s23;
  if($temp==0)
  {
   $ex_s23=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s23)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s23))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s23)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",$l,\"F\",".($carton_s23).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s23;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s23);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",$i,\"F\",$carton_s23)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s23=0;
  }
 }
//s24 

 if(($a_s24*$plies)<$ex_s24)
 { 
   
  $ex_s24=$ex_s24-($a_s24*$plies);
 } 
 else 
 {
  $temp=($a_s24*$plies)-$ex_s24;
  if($temp==0)
  {
   $ex_s24=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s24)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s24))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s24)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",$l,\"F\",".($carton_s24).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s24;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s24);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",$i,\"F\",$carton_s24)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s24=0;
  }
 }
//s25 

 if(($a_s25*$plies)<$ex_s25)
 { 
   
  $ex_s25=$ex_s25-($a_s25*$plies);
 } 
 else 
 {
  $temp=($a_s25*$plies)-$ex_s25;
  if($temp==0)
  {
   $ex_s25=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s25)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s25))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s25)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",$l,\"F\",".($carton_s25).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s25;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s25);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",$i,\"F\",$carton_s25)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s25=0;
  }
 }
//s26 

 if(($a_s26*$plies)<$ex_s26)
 { 
   
  $ex_s26=$ex_s26-($a_s26*$plies);
 } 
 else 
 {
  $temp=($a_s26*$plies)-$ex_s26;
  if($temp==0)
  {
   $ex_s26=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s26)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s26))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s26)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",$l,\"F\",".($carton_s26).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s26;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s26);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",$i,\"F\",$carton_s26)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s26=0;
  }
 }
//s27 

 if(($a_s27*$plies)<$ex_s27)
 { 
   
  $ex_s27=$ex_s27-($a_s27*$plies);
 } 
 else 
 {
  $temp=($a_s27*$plies)-$ex_s27;
  if($temp==0)
  {
   $ex_s27=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s27)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s27))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s27)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",$l,\"F\",".($carton_s27).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s27;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s27);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",$i,\"F\",$carton_s27)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s27=0;
  }
 }
//s28 

 if(($a_s28*$plies)<$ex_s28)
 { 
   
  $ex_s28=$ex_s28-($a_s28*$plies);
 } 
 else 
 {
  $temp=($a_s28*$plies)-$ex_s28;
  if($temp==0)
  {
   $ex_s28=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s28)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s28))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s28)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",$l,\"F\",".($carton_s28).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s28;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s28);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",$i,\"F\",$carton_s28)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s28=0;
  }
 }
//s29 

 if(($a_s29*$plies)<$ex_s29)
 { 
   
  $ex_s29=$ex_s29-($a_s29*$plies);
 } 
 else 
 {
  $temp=($a_s29*$plies)-$ex_s29;
  if($temp==0)
  {
   $ex_s29=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s29)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s29))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s29)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",$l,\"F\",".($carton_s29).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s29;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s29);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",$i,\"F\",$carton_s29)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s29=0;
  }
 }
//s30 

 if(($a_s30*$plies)<$ex_s30)
 { 
   
  $ex_s30=$ex_s30-($a_s30*$plies);
 } 
 else 
 {
  $temp=($a_s30*$plies)-$ex_s30;
  if($temp==0)
  {
   $ex_s30=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s30)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s30))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s30)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",$l,\"F\",".($carton_s30).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s30;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s30);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",$i,\"F\",$carton_s30)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s30=0;
  }
 }
//s31 

 if(($a_s31*$plies)<$ex_s31)
 { 
   
  $ex_s31=$ex_s31-($a_s31*$plies);
 } 
 else 
 {
  $temp=($a_s31*$plies)-$ex_s31;
  if($temp==0)
  {
   $ex_s31=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s31)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s31))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s31)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",$l,\"F\",".($carton_s31).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s31;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s31);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",$i,\"F\",$carton_s31)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s31=0;
  }
 }
//s32 

 if(($a_s32*$plies)<$ex_s32)
 { 
   
  $ex_s32=$ex_s32-($a_s32*$plies);
 } 
 else 
 {
  $temp=($a_s32*$plies)-$ex_s32;
  if($temp==0)
  {
   $ex_s32=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s32)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s32))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s32)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",$l,\"F\",".($carton_s32).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s32;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s32);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",$i,\"F\",$carton_s32)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s32=0;
  }
 }
//s33 

 if(($a_s33*$plies)<$ex_s33)
 { 
   
  $ex_s33=$ex_s33-($a_s33*$plies);
 } 
 else 
 {
  $temp=($a_s33*$plies)-$ex_s33;
  if($temp==0)
  {
   $ex_s33=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s33)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s33))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s33)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",$l,\"F\",".($carton_s33).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s33;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s33);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",$i,\"F\",$carton_s33)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s33=0;
  }
 }
//s34 

 if(($a_s34*$plies)<$ex_s34)
 { 
   
  $ex_s34=$ex_s34-($a_s34*$plies);
 } 
 else 
 {
  $temp=($a_s34*$plies)-$ex_s34;
  if($temp==0)
  {
   $ex_s34=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s34)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s34))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s34)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",$l,\"F\",".($carton_s34).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s34;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s34);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",$i,\"F\",$carton_s34)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s34=0;
  }
 }
//s35 

 if(($a_s35*$plies)<$ex_s35)
 { 
   
  $ex_s35=$ex_s35-($a_s35*$plies);
 } 
 else 
 {
  $temp=($a_s35*$plies)-$ex_s35;
  if($temp==0)
  {
   $ex_s35=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s35)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s35))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s35)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",$l,\"F\",".($carton_s35).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s35;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s35);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",$i,\"F\",$carton_s35)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s35=0;
  }
 }
//s36 

 if(($a_s36*$plies)<$ex_s36)
 { 
   
  $ex_s36=$ex_s36-($a_s36*$plies);
 } 
 else 
 {
  $temp=($a_s36*$plies)-$ex_s36;
  if($temp==0)
  {
   $ex_s36=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s36)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s36))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s36)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",$l,\"F\",".($carton_s36).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s36;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s36);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",$i,\"F\",$carton_s36)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s36=0;
  }
 }
//s37 

 if(($a_s37*$plies)<$ex_s37)
 { 
   
  $ex_s37=$ex_s37-($a_s37*$plies);
 } 
 else 
 {
  $temp=($a_s37*$plies)-$ex_s37;
  if($temp==0)
  {
   $ex_s37=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s37)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s37))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s37)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",$l,\"F\",".($carton_s37).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s37;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s37);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",$i,\"F\",$carton_s37)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s37=0;
  }
 }
//s38 

 if(($a_s38*$plies)<$ex_s38)
 { 
   
  $ex_s38=$ex_s38-($a_s38*$plies);
 } 
 else 
 {
  $temp=($a_s38*$plies)-$ex_s38;
  if($temp==0)
  {
   $ex_s38=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s38)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s38))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s38)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",$l,\"F\",".($carton_s38).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s38;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s38);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",$i,\"F\",$carton_s38)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s38=0;
  }
 }
//s39 

 if(($a_s39*$plies)<$ex_s39)
 { 
   
  $ex_s39=$ex_s39-($a_s39*$plies);
 } 
 else 
 {
  $temp=($a_s39*$plies)-$ex_s39;
  if($temp==0)
  {
   $ex_s39=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s39)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s39))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s39)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",$l,\"F\",".($carton_s39).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s39;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s39);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",$i,\"F\",$carton_s39)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s39=0;
  }
 }
//s40 

 if(($a_s40*$plies)<$ex_s40)
 { 
   
  $ex_s40=$ex_s40-($a_s40*$plies);
 } 
 else 
 {
  $temp=($a_s40*$plies)-$ex_s40;
  if($temp==0)
  {
   $ex_s40=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s40)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s40))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s40)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",$l,\"F\",".($carton_s40).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s40;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s40);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",$i,\"F\",$carton_s40)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s40=0;
  }
 }
//s41 

 if(($a_s41*$plies)<$ex_s41)
 { 
   
  $ex_s41=$ex_s41-($a_s41*$plies);
 } 
 else 
 {
  $temp=($a_s41*$plies)-$ex_s41;
  if($temp==0)
  {
   $ex_s41=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s41)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s41))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s41)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",$l,\"F\",".($carton_s41).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s41;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s41);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",$i,\"F\",$carton_s41)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s41=0;
  }
 }
//s42 

 if(($a_s42*$plies)<$ex_s42)
 { 
   
  $ex_s42=$ex_s42-($a_s42*$plies);
 } 
 else 
 {
  $temp=($a_s42*$plies)-$ex_s42;
  if($temp==0)
  {
   $ex_s42=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s42)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s42))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s42)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",$l,\"F\",".($carton_s42).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s42;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s42);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",$i,\"F\",$carton_s42)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s42=0;
  }
 }
//s43 

 if(($a_s43*$plies)<$ex_s43)
 { 
   
  $ex_s43=$ex_s43-($a_s43*$plies);
 } 
 else 
 {
  $temp=($a_s43*$plies)-$ex_s43;
  if($temp==0)
  {
   $ex_s43=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s43)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s43))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s43)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",$l,\"F\",".($carton_s43).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s43;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s43);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",$i,\"F\",$carton_s43)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s43=0;
  }
 }
//s44 

 if(($a_s44*$plies)<$ex_s44)
 { 
   
  $ex_s44=$ex_s44-($a_s44*$plies);
 } 
 else 
 {
  $temp=($a_s44*$plies)-$ex_s44;
  if($temp==0)
  {
   $ex_s44=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s44)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s44))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s44)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",$l,\"F\",".($carton_s44).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s44;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s44);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",$i,\"F\",$carton_s44)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s44=0;
  }
 }
//s45 

 if(($a_s45*$plies)<$ex_s45)
 { 
   
  $ex_s45=$ex_s45-($a_s45*$plies);
 } 
 else 
 {
  $temp=($a_s45*$plies)-$ex_s45;
  if($temp==0)
  {
   $ex_s45=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s45)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s45))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s45)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",$l,\"F\",".($carton_s45).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s45;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s45);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",$i,\"F\",$carton_s45)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s45=0;
  }
 }
//s46 

 if(($a_s46*$plies)<$ex_s46)
 { 
   
  $ex_s46=$ex_s46-($a_s46*$plies);
 } 
 else 
 {
  $temp=($a_s46*$plies)-$ex_s46;
  if($temp==0)
  {
   $ex_s46=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s46)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s46))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s46)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",$l,\"F\",".($carton_s46).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s46;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s46);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",$i,\"F\",$carton_s46)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s46=0;
  }
 }
//s47 

 if(($a_s47*$plies)<$ex_s47)
 { 
   
  $ex_s47=$ex_s47-($a_s47*$plies);
 } 
 else 
 {
  $temp=($a_s47*$plies)-$ex_s47;
  if($temp==0)
  {
   $ex_s47=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s47)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s47))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s47)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",$l,\"F\",".($carton_s47).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s47;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s47);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",$i,\"F\",$carton_s47)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s47=0;
  }
 }
//s48 

 if(($a_s48*$plies)<$ex_s48)
 { 
   
  $ex_s48=$ex_s48-($a_s48*$plies);
 } 
 else 
 {
  $temp=($a_s48*$plies)-$ex_s48;
  if($temp==0)
  {
   $ex_s48=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s48)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s48))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s48)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",$l,\"F\",".($carton_s48).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s48;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s48);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",$i,\"F\",$carton_s48)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s48=0;
  }
 }
//s49 

 if(($a_s49*$plies)<$ex_s49)
 { 
   
  $ex_s49=$ex_s49-($a_s49*$plies);
 } 
 else 
 {
  $temp=($a_s49*$plies)-$ex_s49;
  if($temp==0)
  {
   $ex_s49=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s49)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s49))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s49)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",$l,\"F\",".($carton_s49).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s49;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s49);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",$i,\"F\",$carton_s49)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s49=0;
  }
 }
//s50 

 if(($a_s50*$plies)<$ex_s50)
 { 
   
  $ex_s50=$ex_s50-($a_s50*$plies);
 } 
 else 
 {
  $temp=($a_s50*$plies)-$ex_s50;
  if($temp==0)
  {
   $ex_s50=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s50)
  {
 $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s50))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s50)
    {
       
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",$l,\"F\",".($carton_s50).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $l++;
    $temp=$temp-$carton_s50;
   }
  }
  else
  {
   for($i=1;$i<=($temp/$carton_s50);$i++)
   {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",$i,\"F\",$carton_s50)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s50=0;
  }
 }

  
  
 
 }
	else
	{
	
 
 //XS
 if(($a_xs*$plies)<$ex_xs)
 { 
	 //echo "0"; 
	 $ex_xs=$ex_xs-($a_xs*$plies);
 } 
 else 
 {
	 $temp=($a_xs*$plies)-$ex_xs;
	 
	 if($temp==0)
	 {
	 	$ex_xs=0;
	 }
	 if($temp>0)
	 {
	 if($temp<$carton_xs)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xs))
		{
			
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xs)
				{
							
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",$l,\"F\",".($carton_xs).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",$l,\"P\",".($temp).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				$l++;
				$temp=$temp-$carton_xs;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xs);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xs\",$i,\"F\",$carton_xs)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xs=0;
	 }
 } 
 
 //S
 if(($a_s*$plies)<$ex_s)
 { 
	 //echo "0"; 
	 $ex_s=$ex_s-($a_s*$plies);
 } 
 else 
 {
	 
	 $temp=($a_s*$plies)-$ex_s;
	 
	 if($temp==0)
	 {
	 	$ex_s=0;	
	 }
	 if($temp>0)
	 {
	 if($temp<$carton_s)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_s))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_s)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",$l,\"F\",".($carton_s).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",$l,\"P\",".($temp).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
				$l++;
				$temp=$temp-$carton_s;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_s);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s\",$i,\"F\",$carton_s)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_s=0;
	 }
 }
 
 //M
 if(($a_m*$plies)<$ex_m)
 { 
	 //echo "0"; 
	 $ex_m=$ex_m-($a_m*$plies);
 } 
 else 
 {
	 
	 $temp=($a_m*$plies)-$ex_m;
	 
	 if($temp==0)
	 {
	 	$ex_m=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_m)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_m))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_m)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",$l,\"F\",".($carton_m).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				$l++;
				$temp=$temp-$carton_m;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_m);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"m\",$i,\"F\",$carton_m)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_m=0; 
	 }
 }
 
 //L
 if(($a_l*$plies)<$ex_l)
 { 
	 //echo "0"; 
	 $ex_l=$ex_l-($a_l*$plies);
 } 
 else 
 {
	 
	 $temp=($a_l*$plies)-$ex_l;
	 
	 if($temp==0)
	 {
	 	$ex_l=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_l)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_l))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_l)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",$l,\"F\",".($carton_l).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				$l++;
				$temp=$temp-$carton_l;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_l);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"l\",$i,\"F\",$carton_l)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_l=0;
	 }
 }
 
 //XL
 if(($a_xl*$plies)<$ex_xl)
 { 
	 //echo "0"; 
	 $ex_xl=$ex_xl-($a_xl*$plies);
 } 
 else 
 {
	 
	 $temp=($a_xl*$plies)-$ex_xl;
	 
	 if($temp==0)
	 {
	 	$ex_xl=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_xl)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xl))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xl)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",$l,\"F\",".($carton_xl).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
				
				$l++;
				$temp=$temp-$carton_xl;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xl);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xl\",$i,\"F\",$carton_xl)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xl=0; 
	 }
 }
 
 //XXL
 if(($a_xxl*$plies)<$ex_xxl)
 { 
	 //echo "0"; 
	 $ex_xxl=$ex_xxl-($a_xxl*$plies);
 } 
 else 
 {
	 
	 $temp=($a_xxl*$plies)-$ex_xxl;
	 
	 if($temp==0)
	 {
	 	$ex_xxl=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_xxl)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xxl))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xxl)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",$l,\"F\",".($carton_xxl).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				$l++;
				$temp=$temp-$carton_xxl;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xxl);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxl\",$i,\"F\",$carton_xxl)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xxl=0; 
	 }
 }
 
 //XXXL
 if(($a_xxxl*$plies)<$ex_xxxl)
 { 
	 //echo "0"; 
	 $ex_xxxl=$ex_xxxl-($a_xxxl*$plies);
 } 
 else 
 {
	 
	 $temp=($a_xxxl*$plies)-$ex_xxxl;
	 
	 if($temp==0)
	 {
	 	$ex_xxxl=0;
	 }
	 
	 if($temp>0)
	 {
	 if($temp<$carton_xxxl)
	 {
	 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",1,\"P\",$temp)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 }
	 else
	 {
	 	if(is_float($temp/$carton_xxxl))
		{
			$l=1;
			while($temp>0)
			{
				if($temp>=$carton_xxxl)
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",$l,\"F\",".($carton_xxxl).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",$l,\"P\",".($temp).")";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				
				$l++;
				$temp=$temp-$carton_xxxl;
			}
		}
		else
		{
			for($i=1;$i<=($temp/$carton_xxxl);$i++)
			{
				$sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"xxxl\",$i,\"F\",$carton_xxxl)";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	 }
	 $ex_xxxl=0;
	 }
 }
 
  
  //s01
 if(($a_s01*$plies)<$ex_s01)
 { 
   $ex_s01=$ex_s01-($a_s01*$plies);
 } 
 else 
 {
  $temp=($a_s01*$plies)-$ex_s01;
  if($temp==0)
  {
   $ex_s01=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s01)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s01))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s01)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",$l,\"F\",".($carton_s01).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s01;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s01);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s01\",$i,\"F\",$carton_s01)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s01=0;
  }
 }
//s02
 if(($a_s02*$plies)<$ex_s02)
 { 
   $ex_s02=$ex_s02-($a_s02*$plies);
 } 
 else 
 {
  $temp=($a_s02*$plies)-$ex_s02;
  if($temp==0)
  {
   $ex_s02=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s02)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s02))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s02)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",$l,\"F\",".($carton_s02).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s02;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s02);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s02\",$i,\"F\",$carton_s02)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s02=0;
  }
 }
//s03
 if(($a_s03*$plies)<$ex_s03)
 { 
   $ex_s03=$ex_s03-($a_s03*$plies);
 } 
 else 
 {
  $temp=($a_s03*$plies)-$ex_s03;
  if($temp==0)
  {
   $ex_s03=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s03)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s03))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s03)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",$l,\"F\",".($carton_s03).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s03;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s03);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s03\",$i,\"F\",$carton_s03)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s03=0;
  }
 }
//s04
 if(($a_s04*$plies)<$ex_s04)
 { 
   $ex_s04=$ex_s04-($a_s04*$plies);
 } 
 else 
 {
  $temp=($a_s04*$plies)-$ex_s04;
  if($temp==0)
  {
   $ex_s04=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s04)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s04))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s04)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",$l,\"F\",".($carton_s04).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s04;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s04);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s04\",$i,\"F\",$carton_s04)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s04=0;
  }
 }
//s05
 if(($a_s05*$plies)<$ex_s05)
 { 
   $ex_s05=$ex_s05-($a_s05*$plies);
 } 
 else 
 {
  $temp=($a_s05*$plies)-$ex_s05;
  if($temp==0)
  {
   $ex_s05=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s05)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s05))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s05)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",$l,\"F\",".($carton_s05).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s05;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s05);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s05\",$i,\"F\",$carton_s05)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s05=0;
  }
 }
//s06
 if(($a_s06*$plies)<$ex_s06)
 { 
   $ex_s06=$ex_s06-($a_s06*$plies);
 } 
 else 
 {
  $temp=($a_s06*$plies)-$ex_s06;
  if($temp==0)
  {
   $ex_s06=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s06)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s06))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s06)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",$l,\"F\",".($carton_s06).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s06;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s06);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s06\",$i,\"F\",$carton_s06)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s06=0;
  }
 }
//s07
 if(($a_s07*$plies)<$ex_s07)
 { 
   $ex_s07=$ex_s07-($a_s07*$plies);
 } 
 else 
 {
  $temp=($a_s07*$plies)-$ex_s07;
  if($temp==0)
  {
   $ex_s07=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s07)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s07))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s07)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",$l,\"F\",".($carton_s07).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s07;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s07);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s07\",$i,\"F\",$carton_s07)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s07=0;
  }
 }
//s08
 if(($a_s08*$plies)<$ex_s08)
 { 
   $ex_s08=$ex_s08-($a_s08*$plies);
 } 
 else 
 {
  $temp=($a_s08*$plies)-$ex_s08;
  if($temp==0)
  {
   $ex_s08=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s08)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s08))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s08)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",$l,\"F\",".($carton_s08).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s08;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s08);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s08\",$i,\"F\",$carton_s08)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s08=0;
  }
 }
//s09
 if(($a_s09*$plies)<$ex_s09)
 { 
   $ex_s09=$ex_s09-($a_s09*$plies);
 } 
 else 
 {
  $temp=($a_s09*$plies)-$ex_s09;
  if($temp==0)
  {
   $ex_s09=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s09)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s09))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s09)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",$l,\"F\",".($carton_s09).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s09;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s09);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s09\",$i,\"F\",$carton_s09)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s09=0;
  }
 }
//s10
 if(($a_s10*$plies)<$ex_s10)
 { 
   $ex_s10=$ex_s10-($a_s10*$plies);
 } 
 else 
 {
  $temp=($a_s10*$plies)-$ex_s10;
  if($temp==0)
  {
   $ex_s10=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s10)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s10))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s10)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",$l,\"F\",".($carton_s10).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s10;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s10);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s10\",$i,\"F\",$carton_s10)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s10=0;
  }
 }
//s11
 if(($a_s11*$plies)<$ex_s11)
 { 
   $ex_s11=$ex_s11-($a_s11*$plies);
 } 
 else 
 {
  $temp=($a_s11*$plies)-$ex_s11;
  if($temp==0)
  {
   $ex_s11=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s11)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s11))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s11)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",$l,\"F\",".($carton_s11).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s11;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s11);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s11\",$i,\"F\",$carton_s11)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s11=0;
  }
 }
//s12
 if(($a_s12*$plies)<$ex_s12)
 { 
   $ex_s12=$ex_s12-($a_s12*$plies);
 } 
 else 
 {
  $temp=($a_s12*$plies)-$ex_s12;
  if($temp==0)
  {
   $ex_s12=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s12)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s12))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s12)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",$l,\"F\",".($carton_s12).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s12;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s12);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s12\",$i,\"F\",$carton_s12)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s12=0;
  }
 }
//s13
 if(($a_s13*$plies)<$ex_s13)
 { 
   $ex_s13=$ex_s13-($a_s13*$plies);
 } 
 else 
 {
  $temp=($a_s13*$plies)-$ex_s13;
  if($temp==0)
  {
   $ex_s13=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s13)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s13))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s13)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",$l,\"F\",".($carton_s13).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s13;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s13);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s13\",$i,\"F\",$carton_s13)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s13=0;
  }
 }
//s14
 if(($a_s14*$plies)<$ex_s14)
 { 
   $ex_s14=$ex_s14-($a_s14*$plies);
 } 
 else 
 {
  $temp=($a_s14*$plies)-$ex_s14;
  if($temp==0)
  {
   $ex_s14=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s14)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s14))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s14)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",$l,\"F\",".($carton_s14).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s14;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s14);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s14\",$i,\"F\",$carton_s14)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s14=0;
  }
 }
//s15
 if(($a_s15*$plies)<$ex_s15)
 { 
   $ex_s15=$ex_s15-($a_s15*$plies);
 } 
 else 
 {
  $temp=($a_s15*$plies)-$ex_s15;
  if($temp==0)
  {
   $ex_s15=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s15)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s15))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s15)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",$l,\"F\",".($carton_s15).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s15;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s15);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s15\",$i,\"F\",$carton_s15)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s15=0;
  }
 }
//s16
 if(($a_s16*$plies)<$ex_s16)
 { 
   $ex_s16=$ex_s16-($a_s16*$plies);
 } 
 else 
 {
  $temp=($a_s16*$plies)-$ex_s16;
  if($temp==0)
  {
   $ex_s16=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s16)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s16))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s16)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",$l,\"F\",".($carton_s16).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s16;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s16);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s16\",$i,\"F\",$carton_s16)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s16=0;
  }
 }
//s17
 if(($a_s17*$plies)<$ex_s17)
 { 
   $ex_s17=$ex_s17-($a_s17*$plies);
 } 
 else 
 {
  $temp=($a_s17*$plies)-$ex_s17;
  if($temp==0)
  {
   $ex_s17=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s17)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s17))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s17)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",$l,\"F\",".($carton_s17).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s17;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s17);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s17\",$i,\"F\",$carton_s17)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s17=0;
  }
 }
//s18
 if(($a_s18*$plies)<$ex_s18)
 { 
   $ex_s18=$ex_s18-($a_s18*$plies);
 } 
 else 
 {
  $temp=($a_s18*$plies)-$ex_s18;
  if($temp==0)
  {
   $ex_s18=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s18)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s18))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s18)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",$l,\"F\",".($carton_s18).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s18;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s18);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s18\",$i,\"F\",$carton_s18)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s18=0;
  }
 }
//s19
 if(($a_s19*$plies)<$ex_s19)
 { 
   $ex_s19=$ex_s19-($a_s19*$plies);
 } 
 else 
 {
  $temp=($a_s19*$plies)-$ex_s19;
  if($temp==0)
  {
   $ex_s19=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s19)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s19))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s19)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",$l,\"F\",".($carton_s19).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s19;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s19);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s19\",$i,\"F\",$carton_s19)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s19=0;
  }
 }
//s20
 if(($a_s20*$plies)<$ex_s20)
 { 
   $ex_s20=$ex_s20-($a_s20*$plies);
 } 
 else 
 {
  $temp=($a_s20*$plies)-$ex_s20;
  if($temp==0)
  {
   $ex_s20=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s20)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s20))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s20)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",$l,\"F\",".($carton_s20).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s20;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s20);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s20\",$i,\"F\",$carton_s20)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s20=0;
  }
 }
//s21
 if(($a_s21*$plies)<$ex_s21)
 { 
   $ex_s21=$ex_s21-($a_s21*$plies);
 } 
 else 
 {
  $temp=($a_s21*$plies)-$ex_s21;
  if($temp==0)
  {
   $ex_s21=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s21)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s21))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s21)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",$l,\"F\",".($carton_s21).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s21;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s21);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s21\",$i,\"F\",$carton_s21)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s21=0;
  }
 }
//s22
 if(($a_s22*$plies)<$ex_s22)
 { 
   $ex_s22=$ex_s22-($a_s22*$plies);
 } 
 else 
 {
  $temp=($a_s22*$plies)-$ex_s22;
  if($temp==0)
  {
   $ex_s22=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s22)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s22))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s22)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",$l,\"F\",".($carton_s22).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s22;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s22);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s22\",$i,\"F\",$carton_s22)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s22=0;
  }
 }
//s23
 if(($a_s23*$plies)<$ex_s23)
 { 
   $ex_s23=$ex_s23-($a_s23*$plies);
 } 
 else 
 {
  $temp=($a_s23*$plies)-$ex_s23;
  if($temp==0)
  {
   $ex_s23=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s23)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s23))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s23)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",$l,\"F\",".($carton_s23).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s23;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s23);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s23\",$i,\"F\",$carton_s23)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s23=0;
  }
 }
//s24
 if(($a_s24*$plies)<$ex_s24)
 { 
   $ex_s24=$ex_s24-($a_s24*$plies);
 } 
 else 
 {
  $temp=($a_s24*$plies)-$ex_s24;
  if($temp==0)
  {
   $ex_s24=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s24)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s24))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s24)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",$l,\"F\",".($carton_s24).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s24;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s24);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s24\",$i,\"F\",$carton_s24)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s24=0;
  }
 }
//s25
 if(($a_s25*$plies)<$ex_s25)
 { 
   $ex_s25=$ex_s25-($a_s25*$plies);
 } 
 else 
 {
  $temp=($a_s25*$plies)-$ex_s25;
  if($temp==0)
  {
   $ex_s25=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s25)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s25))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s25)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",$l,\"F\",".($carton_s25).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s25;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s25);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s25\",$i,\"F\",$carton_s25)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s25=0;
  }
 }
//s26
 if(($a_s26*$plies)<$ex_s26)
 { 
   $ex_s26=$ex_s26-($a_s26*$plies);
 } 
 else 
 {
  $temp=($a_s26*$plies)-$ex_s26;
  if($temp==0)
  {
   $ex_s26=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s26)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s26))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s26)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",$l,\"F\",".($carton_s26).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s26;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s26);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s26\",$i,\"F\",$carton_s26)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s26=0;
  }
 }
//s27
 if(($a_s27*$plies)<$ex_s27)
 { 
   $ex_s27=$ex_s27-($a_s27*$plies);
 } 
 else 
 {
  $temp=($a_s27*$plies)-$ex_s27;
  if($temp==0)
  {
   $ex_s27=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s27)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s27))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s27)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",$l,\"F\",".($carton_s27).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s27;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s27);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s27\",$i,\"F\",$carton_s27)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s27=0;
  }
 }
//s28
 if(($a_s28*$plies)<$ex_s28)
 { 
   $ex_s28=$ex_s28-($a_s28*$plies);
 } 
 else 
 {
  $temp=($a_s28*$plies)-$ex_s28;
  if($temp==0)
  {
   $ex_s28=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s28)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s28))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s28)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",$l,\"F\",".($carton_s28).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s28;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s28);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s28\",$i,\"F\",$carton_s28)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s28=0;
  }
 }
//s29
 if(($a_s29*$plies)<$ex_s29)
 { 
   $ex_s29=$ex_s29-($a_s29*$plies);
 } 
 else 
 {
  $temp=($a_s29*$plies)-$ex_s29;
  if($temp==0)
  {
   $ex_s29=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s29)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s29))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s29)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",$l,\"F\",".($carton_s29).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s29;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s29);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s29\",$i,\"F\",$carton_s29)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s29=0;
  }
 }
//s30
 if(($a_s30*$plies)<$ex_s30)
 { 
   $ex_s30=$ex_s30-($a_s30*$plies);
 } 
 else 
 {
  $temp=($a_s30*$plies)-$ex_s30;
  if($temp==0)
  {
   $ex_s30=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s30)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s30))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s30)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",$l,\"F\",".($carton_s30).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s30;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s30);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s30\",$i,\"F\",$carton_s30)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s30=0;
  }
 }
//s31
 if(($a_s31*$plies)<$ex_s31)
 { 
   $ex_s31=$ex_s31-($a_s31*$plies);
 } 
 else 
 {
  $temp=($a_s31*$plies)-$ex_s31;
  if($temp==0)
  {
   $ex_s31=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s31)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s31))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s31)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",$l,\"F\",".($carton_s31).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s31;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s31);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s31\",$i,\"F\",$carton_s31)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s31=0;
  }
 }
//s32
 if(($a_s32*$plies)<$ex_s32)
 { 
   $ex_s32=$ex_s32-($a_s32*$plies);
 } 
 else 
 {
  $temp=($a_s32*$plies)-$ex_s32;
  if($temp==0)
  {
   $ex_s32=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s32)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s32))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s32)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",$l,\"F\",".($carton_s32).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s32;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s32);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s32\",$i,\"F\",$carton_s32)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s32=0;
  }
 }
//s33
 if(($a_s33*$plies)<$ex_s33)
 { 
   $ex_s33=$ex_s33-($a_s33*$plies);
 } 
 else 
 {
  $temp=($a_s33*$plies)-$ex_s33;
  if($temp==0)
  {
   $ex_s33=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s33)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s33))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s33)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",$l,\"F\",".($carton_s33).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s33;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s33);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s33\",$i,\"F\",$carton_s33)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s33=0;
  }
 }
//s34
 if(($a_s34*$plies)<$ex_s34)
 { 
   $ex_s34=$ex_s34-($a_s34*$plies);
 } 
 else 
 {
  $temp=($a_s34*$plies)-$ex_s34;
  if($temp==0)
  {
   $ex_s34=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s34)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s34))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s34)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",$l,\"F\",".($carton_s34).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s34;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s34);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s34\",$i,\"F\",$carton_s34)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s34=0;
  }
 }
//s35
 if(($a_s35*$plies)<$ex_s35)
 { 
   $ex_s35=$ex_s35-($a_s35*$plies);
 } 
 else 
 {
  $temp=($a_s35*$plies)-$ex_s35;
  if($temp==0)
  {
   $ex_s35=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s35)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s35))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s35)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",$l,\"F\",".($carton_s35).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s35;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s35);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s35\",$i,\"F\",$carton_s35)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s35=0;
  }
 }
//s36
 if(($a_s36*$plies)<$ex_s36)
 { 
   $ex_s36=$ex_s36-($a_s36*$plies);
 } 
 else 
 {
  $temp=($a_s36*$plies)-$ex_s36;
  if($temp==0)
  {
   $ex_s36=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s36)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s36))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s36)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",$l,\"F\",".($carton_s36).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s36;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s36);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s36\",$i,\"F\",$carton_s36)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s36=0;
  }
 }
//s37
 if(($a_s37*$plies)<$ex_s37)
 { 
   $ex_s37=$ex_s37-($a_s37*$plies);
 } 
 else 
 {
  $temp=($a_s37*$plies)-$ex_s37;
  if($temp==0)
  {
   $ex_s37=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s37)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s37))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s37)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",$l,\"F\",".($carton_s37).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s37;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s37);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s37\",$i,\"F\",$carton_s37)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s37=0;
  }
 }
//s38
 if(($a_s38*$plies)<$ex_s38)
 { 
   $ex_s38=$ex_s38-($a_s38*$plies);
 } 
 else 
 {
  $temp=($a_s38*$plies)-$ex_s38;
  if($temp==0)
  {
   $ex_s38=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s38)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s38))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s38)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",$l,\"F\",".($carton_s38).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s38;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s38);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s38\",$i,\"F\",$carton_s38)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s38=0;
  }
 }
//s39
 if(($a_s39*$plies)<$ex_s39)
 { 
   $ex_s39=$ex_s39-($a_s39*$plies);
 } 
 else 
 {
  $temp=($a_s39*$plies)-$ex_s39;
  if($temp==0)
  {
   $ex_s39=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s39)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s39))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s39)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",$l,\"F\",".($carton_s39).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s39;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s39);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s39\",$i,\"F\",$carton_s39)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s39=0;
  }
 }
//s40
 if(($a_s40*$plies)<$ex_s40)
 { 
   $ex_s40=$ex_s40-($a_s40*$plies);
 } 
 else 
 {
  $temp=($a_s40*$plies)-$ex_s40;
  if($temp==0)
  {
   $ex_s40=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s40)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s40))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s40)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",$l,\"F\",".($carton_s40).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s40;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s40);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s40\",$i,\"F\",$carton_s40)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s40=0;
  }
 }
//s41
 if(($a_s41*$plies)<$ex_s41)
 { 
   $ex_s41=$ex_s41-($a_s41*$plies);
 } 
 else 
 {
  $temp=($a_s41*$plies)-$ex_s41;
  if($temp==0)
  {
   $ex_s41=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s41)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s41))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s41)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",$l,\"F\",".($carton_s41).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s41;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s41);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s41\",$i,\"F\",$carton_s41)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s41=0;
  }
 }
//s42
 if(($a_s42*$plies)<$ex_s42)
 { 
   $ex_s42=$ex_s42-($a_s42*$plies);
 } 
 else 
 {
  $temp=($a_s42*$plies)-$ex_s42;
  if($temp==0)
  {
   $ex_s42=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s42)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s42))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s42)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",$l,\"F\",".($carton_s42).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s42;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s42);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s42\",$i,\"F\",$carton_s42)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s42=0;
  }
 }
//s43
 if(($a_s43*$plies)<$ex_s43)
 { 
   $ex_s43=$ex_s43-($a_s43*$plies);
 } 
 else 
 {
  $temp=($a_s43*$plies)-$ex_s43;
  if($temp==0)
  {
   $ex_s43=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s43)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s43))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s43)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",$l,\"F\",".($carton_s43).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s43;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s43);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s43\",$i,\"F\",$carton_s43)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s43=0;
  }
 }
//s44
 if(($a_s44*$plies)<$ex_s44)
 { 
   $ex_s44=$ex_s44-($a_s44*$plies);
 } 
 else 
 {
  $temp=($a_s44*$plies)-$ex_s44;
  if($temp==0)
  {
   $ex_s44=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s44)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s44))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s44)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",$l,\"F\",".($carton_s44).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s44;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s44);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s44\",$i,\"F\",$carton_s44)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s44=0;
  }
 }
//s45
 if(($a_s45*$plies)<$ex_s45)
 { 
   $ex_s45=$ex_s45-($a_s45*$plies);
 } 
 else 
 {
  $temp=($a_s45*$plies)-$ex_s45;
  if($temp==0)
  {
   $ex_s45=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s45)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s45))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s45)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",$l,\"F\",".($carton_s45).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s45;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s45);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s45\",$i,\"F\",$carton_s45)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s45=0;
  }
 }
//s46
 if(($a_s46*$plies)<$ex_s46)
 { 
   $ex_s46=$ex_s46-($a_s46*$plies);
 } 
 else 
 {
  $temp=($a_s46*$plies)-$ex_s46;
  if($temp==0)
  {
   $ex_s46=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s46)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s46))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s46)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",$l,\"F\",".($carton_s46).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s46;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s46);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s46\",$i,\"F\",$carton_s46)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s46=0;
  }
 }
//s47
 if(($a_s47*$plies)<$ex_s47)
 { 
   $ex_s47=$ex_s47-($a_s47*$plies);
 } 
 else 
 {
  $temp=($a_s47*$plies)-$ex_s47;
  if($temp==0)
  {
   $ex_s47=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s47)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s47))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s47)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",$l,\"F\",".($carton_s47).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s47;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s47);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s47\",$i,\"F\",$carton_s47)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s47=0;
  }
 }
//s48
 if(($a_s48*$plies)<$ex_s48)
 { 
   $ex_s48=$ex_s48-($a_s48*$plies);
 } 
 else 
 {
  $temp=($a_s48*$plies)-$ex_s48;
  if($temp==0)
  {
   $ex_s48=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s48)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s48))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s48)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",$l,\"F\",".($carton_s48).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s48;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s48);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s48\",$i,\"F\",$carton_s48)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s48=0;
  }
 }
//s49
 if(($a_s49*$plies)<$ex_s49)
 { 
   $ex_s49=$ex_s49-($a_s49*$plies);
 } 
 else 
 {
  $temp=($a_s49*$plies)-$ex_s49;
  if($temp==0)
  {
   $ex_s49=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s49)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s49))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s49)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",$l,\"F\",".($carton_s49).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s49;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s49);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s49\",$i,\"F\",$carton_s49)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s49=0;
  }
 }
//s50
 if(($a_s50*$plies)<$ex_s50)
 { 
   $ex_s50=$ex_s50-($a_s50*$plies);
 } 
 else 
 {
  $temp=($a_s50*$plies)-$ex_s50;
  if($temp==0)
  {
   $ex_s50=0;
  }
  if($temp>0)
  {
  if($temp<$carton_s50)
  {
   $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",1,\"P\",$temp)";
  mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  }
  else
  {
   if(is_float($temp/$carton_s50))
  {
   
   $l=1;
   while($temp>0)
   {
    if($temp>=$carton_s50)
    {
       
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",$l,\"F\",".($carton_s50).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else 
    {
     $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",$l,\"P\",".($temp).")";
     mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    } 
    $l++;
    $temp=$temp-$carton_s50;
   }
  }
  else 
  {
   for($i=1;$i<=($temp/$carton_s50);$i++)
   {
    $sql="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$label_title\",\"$docketno\",\"s50\",$i,\"F\",$carton_s50)";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
  }
  }
  $ex_s50=0;
  }
 }

 
 }
 }

 	$sql="update $bai_pro3.bai_orders_db set carton_id=$carton_id where order_tid=\"$order_tid\" and order_col_des=\"".$assortcolor."\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=$carton_id where order_tid=\"$order_tid\" and order_col_des=\"".$assortcolor."\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

}
}
?>




<?php


$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"".$assortcolor."\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$o_xs+=$sql_row['order_s_xs'];
	$o_s+=$sql_row['order_s_s'];
	$o_m+=$sql_row['order_s_m'];
	$o_l+=$sql_row['order_s_l'];
	$o_xl+=$sql_row['order_s_xl'];
	$o_xxl+=$sql_row['order_s_xxl'];
	$o_xxxl+=$sql_row['order_s_xxxl'];
	$o_s_s01+=$sql_row['order_s_s01'];
	$o_s_s02+=$sql_row['order_s_s02'];
	$o_s_s03+=$sql_row['order_s_s03'];
	$o_s_s04+=$sql_row['order_s_s04'];
	$o_s_s05+=$sql_row['order_s_s05'];
	$o_s_s06+=$sql_row['order_s_s06'];
	$o_s_s07+=$sql_row['order_s_s07'];
	$o_s_s08+=$sql_row['order_s_s08'];
	$o_s_s09+=$sql_row['order_s_s09'];
	$o_s_s10+=$sql_row['order_s_s10'];
	$o_s_s11+=$sql_row['order_s_s11'];
	$o_s_s12+=$sql_row['order_s_s12'];
	$o_s_s13+=$sql_row['order_s_s13'];
	$o_s_s14+=$sql_row['order_s_s14'];
	$o_s_s15+=$sql_row['order_s_s15'];
	$o_s_s16+=$sql_row['order_s_s16'];
	$o_s_s17+=$sql_row['order_s_s17'];
	$o_s_s18+=$sql_row['order_s_s18'];
	$o_s_s19+=$sql_row['order_s_s19'];
	$o_s_s20+=$sql_row['order_s_s20'];
	$o_s_s21+=$sql_row['order_s_s21'];
	$o_s_s22+=$sql_row['order_s_s22'];
	$o_s_s23+=$sql_row['order_s_s23'];
	$o_s_s24+=$sql_row['order_s_s24'];
	$o_s_s25+=$sql_row['order_s_s25'];
	$o_s_s26+=$sql_row['order_s_s26'];
	$o_s_s27+=$sql_row['order_s_s27'];
	$o_s_s28+=$sql_row['order_s_s28'];
	$o_s_s29+=$sql_row['order_s_s29'];
	$o_s_s30+=$sql_row['order_s_s30'];
	$o_s_s31+=$sql_row['order_s_s31'];
	$o_s_s32+=$sql_row['order_s_s32'];
	$o_s_s33+=$sql_row['order_s_s33'];
	$o_s_s34+=$sql_row['order_s_s34'];
	$o_s_s35+=$sql_row['order_s_s35'];
	$o_s_s36+=$sql_row['order_s_s36'];
	$o_s_s37+=$sql_row['order_s_s37'];
	$o_s_s38+=$sql_row['order_s_s38'];
	$o_s_s39+=$sql_row['order_s_s39'];
	$o_s_s40+=$sql_row['order_s_s40'];
	$o_s_s41+=$sql_row['order_s_s41'];
	$o_s_s42+=$sql_row['order_s_s42'];
	$o_s_s43+=$sql_row['order_s_s43'];
	$o_s_s44+=$sql_row['order_s_s44'];
	$o_s_s45+=$sql_row['order_s_s45'];
	$o_s_s46+=$sql_row['order_s_s46'];
	$o_s_s47+=$sql_row['order_s_s47'];
	$o_s_s48+=$sql_row['order_s_s48'];
	$o_s_s49+=$sql_row['order_s_s49'];
	$o_s_s50+=$sql_row['order_s_s50'];
	
	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50;
}


//FOR ASSORTMENT
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
$carton_id=$_GET['carton_id'];
$style=$_GET['style'];
$schedule=$_GET['schedule'];


$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"".$assortcolor."\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$o_xs+=$sql_row['order_s_xs'];
	$o_s+=$sql_row['order_s_s'];
	$o_m+=$sql_row['order_s_m'];
	$o_l+=$sql_row['order_s_l'];
	$o_xl+=$sql_row['order_s_xl'];
	$o_xxl+=$sql_row['order_s_xxl'];
	$o_xxxl+=$sql_row['order_s_xxxl'];
	$o_s_s01+=$sql_row['order_s_s01'];
	$o_s_s02+=$sql_row['order_s_s02'];
	$o_s_s03+=$sql_row['order_s_s03'];
	$o_s_s04+=$sql_row['order_s_s04'];
	$o_s_s05+=$sql_row['order_s_s05'];
	$o_s_s06+=$sql_row['order_s_s06'];
	$o_s_s07+=$sql_row['order_s_s07'];
	$o_s_s08+=$sql_row['order_s_s08'];
	$o_s_s09+=$sql_row['order_s_s09'];
	$o_s_s10+=$sql_row['order_s_s10'];
	$o_s_s11+=$sql_row['order_s_s11'];
	$o_s_s12+=$sql_row['order_s_s12'];
	$o_s_s13+=$sql_row['order_s_s13'];
	$o_s_s14+=$sql_row['order_s_s14'];
	$o_s_s15+=$sql_row['order_s_s15'];
	$o_s_s16+=$sql_row['order_s_s16'];
	$o_s_s17+=$sql_row['order_s_s17'];
	$o_s_s18+=$sql_row['order_s_s18'];
	$o_s_s19+=$sql_row['order_s_s19'];
	$o_s_s20+=$sql_row['order_s_s20'];
	$o_s_s21+=$sql_row['order_s_s21'];
	$o_s_s22+=$sql_row['order_s_s22'];
	$o_s_s23+=$sql_row['order_s_s23'];
	$o_s_s24+=$sql_row['order_s_s24'];
	$o_s_s25+=$sql_row['order_s_s25'];
	$o_s_s26+=$sql_row['order_s_s26'];
	$o_s_s27+=$sql_row['order_s_s27'];
	$o_s_s28+=$sql_row['order_s_s28'];
	$o_s_s29+=$sql_row['order_s_s29'];
	$o_s_s30+=$sql_row['order_s_s30'];
	$o_s_s31+=$sql_row['order_s_s31'];
	$o_s_s32+=$sql_row['order_s_s32'];
	$o_s_s33+=$sql_row['order_s_s33'];
	$o_s_s34+=$sql_row['order_s_s34'];
	$o_s_s35+=$sql_row['order_s_s35'];
	$o_s_s36+=$sql_row['order_s_s36'];
	$o_s_s37+=$sql_row['order_s_s37'];
	$o_s_s38+=$sql_row['order_s_s38'];
	$o_s_s39+=$sql_row['order_s_s39'];
	$o_s_s40+=$sql_row['order_s_s40'];
	$o_s_s41+=$sql_row['order_s_s41'];
	$o_s_s42+=$sql_row['order_s_s42'];
	$o_s_s43+=$sql_row['order_s_s43'];
	$o_s_s44+=$sql_row['order_s_s44'];
	$o_s_s45+=$sql_row['order_s_s45'];
	$o_s_s46+=$sql_row['order_s_s46'];
	$o_s_s47+=$sql_row['order_s_s47'];
	$o_s_s48+=$sql_row['order_s_s48'];
	$o_s_s49+=$sql_row['order_s_s49'];
	$o_s_s50+=$sql_row['order_s_s50'];
	
	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50;
}


$packpcs=array();
$packpcs=explode(",",$_GET['packpcs']);
/*
$assortcolor=array();
$assortcolor=explode(",",$_GET['assortcolor']);
*/
$assortcolor=$_GET['assortcolor'];
$sum_of_assort_pcs=array_sum($packpcs);
echo $sum_of_assort_pcs;

for($i=0;$i<sizeof($packpcs);$i++)
{
	echo $packpcs[$i]."<br/>";
}


$sql="select * from $bai_pro3.carton_qty_chart where id=$carton_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$carton_xs=$sql_row['xs'];
	$carton_s=$sql_row['s'];
	$carton_m=$sql_row['m'];
	$carton_l=$sql_row['l'];
	$carton_xl=$sql_row['xl'];
	$carton_xxl=$sql_row['xxl'];
	$carton_xxxl=$sql_row['xxxl'];
	
		$carton_s01=$sql_row['s01'];
		$carton_s02=$sql_row['s02'];
		$carton_s03=$sql_row['s03'];
		$carton_s04=$sql_row['s04'];
		$carton_s05=$sql_row['s05'];
		$carton_s06=$sql_row['s06'];
		$carton_s07=$sql_row['s07'];
		$carton_s08=$sql_row['s08'];
		$carton_s09=$sql_row['s09'];
		$carton_s10=$sql_row['s10'];
		$carton_s11=$sql_row['s11'];
		$carton_s12=$sql_row['s12'];
		$carton_s13=$sql_row['s13'];
		$carton_s14=$sql_row['s14'];
		$carton_s15=$sql_row['s15'];
		$carton_s16=$sql_row['s16'];
		$carton_s17=$sql_row['s17'];
		$carton_s18=$sql_row['s18'];
		$carton_s19=$sql_row['s19'];
		$carton_s20=$sql_row['s20'];
		$carton_s21=$sql_row['s21'];
		$carton_s22=$sql_row['s22'];
		$carton_s23=$sql_row['s23'];
		$carton_s24=$sql_row['s24'];
		$carton_s25=$sql_row['s25'];
		$carton_s26=$sql_row['s26'];
		$carton_s27=$sql_row['s27'];
		$carton_s28=$sql_row['s28'];
		$carton_s29=$sql_row['s29'];
		$carton_s30=$sql_row['s30'];
		$carton_s31=$sql_row['s31'];
		$carton_s32=$sql_row['s32'];
		$carton_s33=$sql_row['s33'];
		$carton_s34=$sql_row['s34'];
		$carton_s35=$sql_row['s35'];
		$carton_s36=$sql_row['s36'];
		$carton_s37=$sql_row['s37'];
		$carton_s38=$sql_row['s38'];
		$carton_s39=$sql_row['s39'];
		$carton_s40=$sql_row['s40'];
		$carton_s41=$sql_row['s41'];
		$carton_s42=$sql_row['s42'];
		$carton_s43=$sql_row['s43'];
		$carton_s44=$sql_row['s44'];
		$carton_s45=$sql_row['s45'];
		$carton_s46=$sql_row['s46'];
		$carton_s47=$sql_row['s47'];
		$carton_s48=$sql_row['s48'];
		$carton_s49=$sql_row['s49'];
		$carton_s50=$sql_row['s50'];
}

$sizes_db=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18"
,"s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");

$order_qty_db=array($o_xs,$o_s,$o_m,$o_l,$o_xl,$o_xxl,$o_xxxl,$o_s01,$o_s02,$o_s03,$o_s04,$o_s05,$o_s06,$o_s07,$o_s08,$o_s09,$o_s10,$o_s11,$o_s12,$o_s13,$o_s14,$o_s15,$o_s16,$o_s17,$o_s18,$o_s19,$o_s20,$o_s21,$o_s22,$o_s23,$o_s24,$o_s25,$o_s26,$o_s27,$o_s28,$o_s29,$o_s30,$o_s31,$o_s32,$o_s33,$o_s34,$o_s35,$o_s36,$o_s37,$o_s38,$o_s39,$o_s40,$o_s41,$o_s42,$o_s43,$o_s44,$o_s45,$o_s46,$o_s47,$o_s48,$o_s49,$o_s50);

$carton_qty_db=array($carton_xs,$carton_s,$carton_m,$carton_l,$carton_xl,$carton_xxl,$carton_xxxl,$carton_s01,$carton_s02,$carton_s03,$carton_s04,$carton_s05,$carton_s06,$carton_s07,$carton_s08,$carton_s09,$carton_s10,$carton_s11,$carton_s12,$carton_s13,$carton_s14,$carton_s15,$carton_s16,$carton_s17,$carton_s18,$carton_s19,$carton_s20,$carton_s21,$carton_s22,$carton_s23,$carton_s24,$carton_s25,$carton_s26,$carton_s27,$carton_s28,$carton_s29,$carton_s30,$carton_s31,$carton_s32,$carton_s33,$carton_s34,$carton_s35,$carton_s36,$carton_s37,$carton_s38,$carton_s39,$carton_s40,$carton_s41,$carton_s42,$carton_s43,$carton_s44,$carton_s45,$carton_s46,$carton_s47,$carton_s48,$carton_s49,$carton_s50);

$tid_db=array();
$pack=implode(",",$assort_docket_db);
//echo "<br>Pack = ".$pack."<br>";
$sql="select * from $bai_pro3.pac_stat_log where doc_no in (".implode(",",$assort_docket_db).")";
echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid_db[]=$sql_row[	'tid'];
}

$completed_tid=array();
$completed_tid[]=0;

for($i=0;$i<sizeof($order_qty_db);$i++)
{
	if($order_qty_db[$i]>0)
	{
		$pack_assort_pcs=$carton_qty_db[$i]/$sum_of_assort_pcs;
		echo $pack_assort_pcs."<br/>";
		
		$sql="select * from $bai_pro3.pac_stat_log where tid in (".implode(",",array_diff($tid_db,$completed_tid)).") and size_code=\"".$sizes_db[$i]."\"";
		echo $sql."<br/>";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$total_docs=mysqli_num_rows($sql_result);
		
		echo "TOTAL DOCs:$total_docs";
	
		do
		{
			$temp_tid=array();
			$temp_docs=array();
			for($j=0;$j<sizeof($assortcolor);$j++)
			{
				echo $packpcs[$j]."<br/>";
				$temp_pack_qty=$pack_assort_pcs*$packpcs[$j];
				$sql="select * from $bai_pro3.packing_summary where tid in (".implode(",",array_diff($tid_db,$completed_tid)).") and size_code=\"".$sizes_db[$i]."\" and order_col_des=\"".$assortcolor."\" and carton_act_qty=".($pack_assort_pcs*$packpcs[$j])." limit 1";
 echo $sql."<br/>";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$temp_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$completed_tid[]=$sql_row['tid'];
					$temp_tid[]=$sql_row['tid'];
					$temp_docs[]=$sql_row['doc_no']."-".$sql_row['tid'];
					$total_docs--;
				}
				
				if($total_docs>0 and $temp_check==0)
				{
					$sql="select sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where tid in (".implode(",",array_diff($tid_db,$completed_tid)).") and size_code=\"".$sizes_db[$i]."\" and order_col_des=\"".$assortcolor."\"";
 					echo $sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$balance_qty=$sql_row['carton_act_qty'];	
					}
					
					if($balance_qty>$temp_pack_qty)
					{
						do
						{
						 	$sql="select * from $bai_pro3.packing_summary where tid in (".implode(",",array_diff($tid_db,$completed_tid)).") and size_code=\"".$sizes_db[$i]."\" and order_col_des=\"".$assortcolor."\" limit 1";
	 						echo $sql."<br/>";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								$completed_tid[]=$sql_row['tid'];
								$temp_tid[]=$sql_row['tid'];
								$temp_docs[]=$sql_row['doc_no']."-".$sql_row['tid'];
								$total_docs--;
								
								if($sql_row['carton_act_qty']>$temp_pack_qty)
								{
									$diff=$sql_row['carton_act_qty']-$temp_pack_qty;
									$sql1="update $bai_pro3.pac_stat_log set carton_act_qty=$temp_pack_qty where tid=".$sql_row['tid'];
									echo $sql1."<br/>";
									mysqli_query($link, $sql1) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									$sql1="insert into $bai_pro3.pac_stat_log (doc_no,remarks,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (".$sql_row['doc_no'].",\"".$sql_row['remarks']."\",\"".$sql_row['doc_no']."\",\"".$sql_row['size_code']."\",".($sql_row['carton_no']+1).",\"P\",$diff)";
									echo $sql1."<br/>";
									mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$tid_db[]=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
									$total_docs++;
								}
								
								$temp_pack_qty-=$sql_row['carton_act_qty'];
								
							}
						}while($temp_pack_qty>0);
					}
					else
					{
						$sql="select * from $bai_pro3.packing_summary where tid in (".implode(",",array_diff($tid_db,$completed_tid)).") and size_code=\"".$sizes_db[$i]."\" and order_col_des=\"".$assortcolor."\"";
 						echo $sql."<br/>";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$completed_tid[]=$sql_row['tid'];
							$temp_tid[]=$sql_row['tid'];
							$temp_docs[]=$sql_row['doc_no']."-".$sql_row['tid'];
							$total_docs--;
						}
					}					

				}
			}
			
			$sql="update $bai_pro3.pac_stat_log set doc_no_ref=\"".implode(",",$temp_docs)."\" where tid in(".implode(",",$temp_tid).")";
			echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			echo "TOTAL DOCs AFTER:$total_docs";
			
		}while($total_docs>0);
		
	}
}


?>


<?php
	
	$url= getFullURLLevel($_GET['r'],'test.php',0,'N');
	echo "<script type=\"text/javascript\"> 
				setTimeout(\"Redirect()\",3000); 
				function Redirect() {  
					location.href = \"$url\" 
				}
		   </script>";
 
?>
 
 