
<?php
	$order_tid=$_GET['order_tid'];
	$cat_ref=$_GET['cat_ref'];
	$carton_id=$_GET['carton_id'];
?>

<?php

	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_confirm=mysqli_num_rows($sql_result);

	if($sql_num_confirm>0)
	{
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	}
	else
	{
		$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	}
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['order_style_no']; //Style
		$color=$sql_row['order_col_des']; //color
		$division=$sql_row['order_div'];
		$delivery=$sql_row['order_del_no']; //Schedule
		$schedule=$sql_row['order_del_no'];
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
		$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl;
		$order_date=$sql_row['order_date'];
		$order_joins=$sql_row['order_joins'];
		
				$o_s06=$sql_row['order_s_s06'];
				$o_s08=$sql_row['order_s_s08'];
				$o_s10=$sql_row['order_s_s10'];
				$o_s12=$sql_row['order_s_s12'];
				$o_s14=$sql_row['order_s_s14'];
				$o_s16=$sql_row['order_s_s16'];
				$o_s18=$sql_row['order_s_s18'];
				$o_s20=$sql_row['order_s_s20'];
				$o_s22=$sql_row['order_s_s22'];
				$o_s24=$sql_row['order_s_s24'];
				$o_s26=$sql_row['order_s_s26'];
				$o_s28=$sql_row['order_s_s28'];
				$o_s30=$sql_row['order_s_s30'];
	}

	$join_xs=0;
	$join_s=0;
	$join_schedule="";
	$join_check=0;
	if($order_joins!="0")
	{
		$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_joins\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$join_xs=$sql_row['order_s_xs'];
			$join_s=$sql_row['order_s_s'];
			$join_schedule=$sql_row['order_del_no'].chr($sql_row['color_code']);
		}
		$join_check=1;
	}

		
	$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref and category in (\"Body\",\"Front\")";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$excess=$sql_row['cuttable_percent'];
	}

	$sql="select sum(allocate_xs*plies) as \"cuttable_s_xs\", sum(allocate_s*plies) as \"cuttable_s_s\", sum(allocate_m*plies) as \"cuttable_s_m\", sum(allocate_l*plies) as \"cuttable_s_l\", sum(allocate_xl*plies) as \"cuttable_s_xl\", sum(allocate_xxl*plies) as \"cuttable_s_xxl\", sum(allocate_xxxl*plies) as \"cuttable_s_xxxl\", sum(allocate_s06*plies) as \"cuttable_s_s06\", sum(allocate_s08*plies) as \"cuttable_s_s08\", sum(allocate_s10*plies) as \"cuttable_s_s10\", sum(allocate_s12*plies) as \"cuttable_s_s12\", sum(allocate_s14*plies) as \"cuttable_s_s14\", sum(allocate_s16*plies) as \"cuttable_s_s16\", sum(allocate_s18*plies) as \"cuttable_s_s18\", sum(allocate_s20*plies) as \"cuttable_s_s20\", sum(allocate_s22*plies) as \"cuttable_s_s22\", sum(allocate_s24*plies) as \"cuttable_s_s24\", sum(allocate_s26*plies) as \"cuttable_s_s26\", sum(allocate_s28*plies) as \"cuttable_s_s28\", sum(allocate_s30*plies) as \"cuttable_s_s30\" from allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";

	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		$c_s06=$sql_row['cuttable_s_s06'];
		$c_s08=$sql_row['cuttable_s_s08'];
		$c_s10=$sql_row['cuttable_s_s10'];
		$c_s12=$sql_row['cuttable_s_s12'];
		$c_s14=$sql_row['cuttable_s_s14'];
		$c_s16=$sql_row['cuttable_s_s16'];
		$c_s18=$sql_row['cuttable_s_s18'];
		$c_s20=$sql_row['cuttable_s_s20'];
		$c_s22=$sql_row['cuttable_s_s22'];
		$c_s24=$sql_row['cuttable_s_s24'];
		$c_s26=$sql_row['cuttable_s_s26'];
		$c_s28=$sql_row['cuttable_s_s28'];
		$c_s30=$sql_row['cuttable_s_s30'];
	}

	/* NEW 2010-05-22 */
		
		$newyy=0;
		$new_order_qty=0;
		$sql2="select * from $bai_pro3.maker_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";

		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_confirm=mysqli_num_rows($sql_result);
		
		if($sql_num_confirm>0)
		{
			$sql2="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		}
		else
		{
			$sql2="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		}
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		$carton_s06=$sql_row['s06'];
		$carton_s08=$sql_row['s08'];
		$carton_s10=$sql_row['s10'];
		$carton_s12=$sql_row['s12'];
		$carton_s14=$sql_row['s14'];
		$carton_s16=$sql_row['s16'];
		$carton_s18=$sql_row['s18'];
		$carton_s20=$sql_row['s20'];
		$carton_s22=$sql_row['s22'];
		$carton_s24=$sql_row['s24'];
		$carton_s26=$sql_row['s26'];
		$carton_s28=$sql_row['s28'];
		$carton_s30=$sql_row['s30'];
	}

	/* echo $carton_xs."<br/>";
	echo $carton_s."<br/>";
	echo $carton_m."<br/>";
	echo $carton_l."<br/>";
	echo $carton_xl."<br/>";
	echo $carton_xxl."<br/>";
	echo $carton_xxxl."<br/>"; */

	 
	 	$a_xs_tot=0;
		$a_s_tot=0;
		$a_m_tot=0;
		$a_l_tot=0;
		$a_xl_tot=0;
		$a_xxl_tot=0;
		$a_xxxl_tot=0;
		$plies_tot=0;
		
		$a_s06_tot=0;
		$a_s08_tot=0;
		$a_s10_tot=0;
		$a_s12_tot=0;
		$a_s14_tot=0;
		$a_s16_tot=0;
		$a_s18_tot=0;
		$a_s20_tot=0;
		$a_s22_tot=0;
		$a_s24_tot=0;
		$a_s26_tot=0;
		$a_s28_tot=0;
		$a_s30_tot=0;
		$plies_tot=0;
		
		$ex_xs=0;
		$ex_s=0;
		$ex_m=0;
		$ex_l=0;
		$ex_xl=0;
		$ex_xxl=0;
		$ex_xxxl=0;
		
		$ex_s06_tot=0;
		$ex_s08_tot=0;
		$ex_s10_tot=0;
		$ex_s12_tot=0;
		$ex_s14_tot=0;
		$ex_s16_tot=0;
		$ex_s18_tot=0;
		$ex_s20_tot=0;
		$ex_s22_tot=0;
		$ex_s24_tot=0;
		$ex_s26_tot=0;
		$ex_s28_tot=0;
		$ex_s30_tot=0;
		
		
	//To identify the first cut no.	
	$sql="select min(acutno) as firstcut from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{	
		$first_cut=$sql_row['firstcut'];
	}
		
		
	//$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno"; EXCEPTION FOR PILOT
	$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref order by acutno";
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
		
		$a_s06=$sql_row['a_s06'];
	$a_s08=$sql_row['a_s08'];
	$a_s10=$sql_row['a_s10'];
	$a_s12=$sql_row['a_s12'];
	$a_s14=$sql_row['a_s14'];
	$a_s16=$sql_row['a_s16'];
	$a_s18=$sql_row['a_s18'];
	$a_s20=$sql_row['a_s20'];
	$a_s22=$sql_row['a_s22'];
	$a_s24=$sql_row['a_s24'];
	$a_s26=$sql_row['a_s26'];
	$a_s28=$sql_row['a_s28'];
	$a_s30=$sql_row['a_s30'];

		
		$a_xs_tot=$a_xs_tot+($a_xs*$plies);
		$a_s_tot=$a_s_tot+($a_s*$plies);
		$a_m_tot=$a_m_tot+($a_m*$plies);
		$a_l_tot=$a_l_tot+($a_l*$plies);
		$a_xl_tot=$a_xl_tot+($a_xl*$plies);
		$a_xxl_tot=$a_xxl_tot+($a_xxl*$plies);
		$a_xxxl_tot=$a_xxxl_tot+($a_xxxl*$plies);
		
		$a_s06_tot=$a_s06_tot+($a_s06*$plies);
	$a_s08_tot=$a_s08_tot+($a_s08*$plies);
	$a_s10_tot=$a_s10_tot+($a_s10*$plies);
	$a_s12_tot=$a_s12_tot+($a_s12*$plies);
	$a_s14_tot=$a_s14_tot+($a_s14*$plies);
	$a_s16_tot=$a_s16_tot+($a_s16*$plies);
	$a_s18_tot=$a_s18_tot+($a_s18*$plies);
	$a_s20_tot=$a_s20_tot+($a_s20*$plies);
	$a_s22_tot=$a_s22_tot+($a_s22*$plies);
	$a_s24_tot=$a_s24_tot+($a_s24*$plies);
	$a_s26_tot=$a_s26_tot+($a_s26*$plies);
	$a_s28_tot=$a_s28_tot+($a_s28*$plies);
	$a_s30_tot=$a_s30_tot+($a_s30*$plies);

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
		
			$ex_s06=($c_s06-$o_s06);
			$ex_s08=($c_s08-$o_s08-$join_s08);
		$ex_s10=($c_s10-$o_s10-$join_s10);
		$ex_s12=($c_s12-$o_s12);
		$ex_s14=($c_s14-$o_s14);
		$ex_s16=($c_s16-$o_s16);
		$ex_s18=($c_s18-$o_s18);
		$ex_s20=($c_s20-$o_s20);
		$ex_s22=($c_s22-$o_s22);
		$ex_s24=($c_s24-$o_s24);
		$ex_s26=($c_s26-$o_s26);
		$ex_s28=($c_s28-$o_s28);
		$ex_s30=($c_s30-$o_s30);
		
		
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",$l,\"F\",".($carton_xs).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",$i,\"F\",$carton_xs)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.$bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",$l,\"F\",".($carton_s).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",$i,\"F\",$carton_s)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",$l,\"F\",".($carton_m).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",$i,\"F\",$carton_m)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",$l,\"F\",".($carton_l).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",$i,\"F\",$carton_l)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",$l,\"F\",".($carton_xl).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",$i,\"F\",$carton_xl)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",$l,\"F\",".($carton_xxl).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",$i,\"F\",$carton_xxl)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",$l,\"F\",".($carton_xxxl).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",$i,\"F\",$carton_xxxl)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_xxxl=0;
		 }
	 }
	 
	  
	  //s06
	 if(($a_s06*$plies)<$ex_s06)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",$l,\"F\",".($carton_s06).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",$i,\"F\",$carton_s06)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s06=0;
		 }
	 } 
	 
	 //s08
	 if(($a_s08*$plies)<$ex_s08)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",$l,\"F\",".($carton_s08).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",$i,\"F\",$carton_s08)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s08=0;
		 }
	 } 
	 
	 //s10
	 if(($a_s10*$plies)<$ex_s10)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",$l,\"F\",".($carton_s10).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",$i,\"F\",$carton_s10)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s10=0;
		 }
	 } 
	 
	 //s12
	 if(($a_s12*$plies)<$ex_s12)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",$l,\"F\",".($carton_s12).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",$i,\"F\",$carton_s12)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s12=0;
		 }
	 } 
	 
	 //s14
	 if(($a_s14*$plies)<$ex_s14)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",$l,\"F\",".($carton_s14).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",$i,\"F\",$carton_s14)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s14=0;
		 }
	 } 
	 
	 //s16
	 if(($a_s16*$plies)<$ex_s16)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",$l,\"F\",".($carton_s16).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",$i,\"F\",$carton_s16)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s16=0;
		 }
	 } 
	 
	 //s18
	 if(($a_s18*$plies)<$ex_s18)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",$l,\"F\",".($carton_s18).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",$i,\"F\",$carton_s18)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s18=0;
		 }
	 } 
	 
	 //s20
	 if(($a_s20*$plies)<$ex_s20)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",$l,\"F\",".($carton_s20).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",$i,\"F\",$carton_s20)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s20=0;
		 }
	 } 
	 
	 //s22
	 if(($a_s22*$plies)<$ex_s22)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",$l,\"F\",".($carton_s22).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",$i,\"F\",$carton_s22)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s22=0;
		 }
	 } 
	 
	 
	 //s24
	 if(($a_s24*$plies)<$ex_s24)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",$l,\"F\",".($carton_s24).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",$i,\"F\",$carton_s24)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s24=0;
		 }
	 } 
	 
	 
	 //s26
	 if(($a_s26*$plies)<$ex_s26)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",$l,\"F\",".($carton_s26).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",$i,\"F\",$carton_s26)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s26=0;
		 }
	 } 
	 
	 
	 //s28
	 if(($a_s28*$plies)<$ex_s28)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",$l,\"F\",".($carton_s28).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",$i,\"F\",$carton_s28)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s28=0;
		 }
	 } 
	 
	 //s30
	 if(($a_s30*$plies)<$ex_s30)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",$l,\"F\",".($carton_s30).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",$i,\"F\",$carton_s30)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s30=0;
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",$l,\"F\",".($carton_xs).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xs\",$i,\"F\",$carton_xs)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",$l,\"F\",".($carton_s).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s\",$i,\"F\",$carton_s)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",$l,\"F\",".($carton_m).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"m\",$i,\"F\",$carton_m)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",$l,\"F\",".($carton_l).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"l\",$i,\"F\",$carton_l)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",$l,\"F\",".($carton_xl).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xl\",$i,\"F\",$carton_xl)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",$l,\"F\",".($carton_xxl).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxl\",$i,\"F\",$carton_xxl)";
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",1,\"P\",$temp)";
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
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",$l,\"F\",".($carton_xxxl).")";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"xxxl\",$i,\"F\",$carton_xxxl)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_xxxl=0;
		 }
	 }
	 
	  
	  //s06
	 if(($a_s06*$plies)<$ex_s06)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",$l,\"F\",".($carton_s06).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s06\",$i,\"F\",$carton_s06)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s06=0;
		 }
	 } 
	 
	 //s08
	 if(($a_s08*$plies)<$ex_s08)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",$l,\"F\",".($carton_s08).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s08\",$i,\"F\",$carton_s08)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s08=0;
		 }
	 } 
	 
	 //s10
	 if(($a_s10*$plies)<$ex_s10)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",$l,\"F\",".($carton_s10).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s10\",$i,\"F\",$carton_s10)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s10=0;
		 }
	 } 
	 
	 //s12
	 if(($a_s12*$plies)<$ex_s12)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",$l,\"F\",".($carton_s12).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s12\",$i,\"F\",$carton_s12)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s12=0;
		 }
	 } 
	 
	 //s14
	 if(($a_s14*$plies)<$ex_s14)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",$l,\"F\",".($carton_s14).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s14\",$i,\"F\",$carton_s14)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s14=0;
		 }
	 } 
	 
	 //s16
	 if(($a_s16*$plies)<$ex_s16)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",$l,\"F\",".($carton_s16).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s16\",$i,\"F\",$carton_s16)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s16=0;
		 }
	 } 
	 
	 //s18
	 if(($a_s18*$plies)<$ex_s18)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",$l,\"F\",".($carton_s18).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s18\",$i,\"F\",$carton_s18)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s18=0;
		 }
	 } 
	 
	 //s20
	 if(($a_s20*$plies)<$ex_s20)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",$l,\"F\",".($carton_s20).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s20\",$i,\"F\",$carton_s20)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s20=0;
		 }
	 } 
	 
	 //s22
	 if(($a_s22*$plies)<$ex_s22)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",$l,\"F\",".($carton_s22).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s22\",$i,\"F\",$carton_s22)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s22=0;
		 }
	 } 
	 
	 
	 //s24
	 if(($a_s24*$plies)<$ex_s24)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",$l,\"F\",".($carton_s24).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s24\",$i,\"F\",$carton_s24)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s24=0;
		 }
	 } 
	 
	 
	 //s26
	 if(($a_s26*$plies)<$ex_s26)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",$l,\"F\",".($carton_s26).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s26\",$i,\"F\",$carton_s26)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s26=0;
		 }
	 } 
	 
	 
	 //s28
	 if(($a_s28*$plies)<$ex_s28)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",$l,\"F\",".($carton_s28).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s28\",$i,\"F\",$carton_s28)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s28=0;
		 }
	 } 
	 
	 //s30
	 if(($a_s30*$plies)<$ex_s30)
	 { 
		 //echo "0"; 
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
		 	$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",1,\"P\",$temp)";
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
								
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",$l,\"F\",".($carton_s30).")";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",$l,\"P\",".($temp).")";
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
					$sql="insert into $bai_pro3.pac_stat_log (doc_no,doc_no_ref,size_code,carton_no,carton_mode,carton_act_qty) values (\"$docketno\",\"$docketno\",\"s30\",$i,\"F\",$carton_s30)";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		 }
		 $ex_s30=0;
		 }
	 } 
	 
	 }
	}
 ?>
 
<?php
	$sql="update $bai_pro3.packing_summary set doc_no_ref=concat(doc_no,\"-\",tid) where order_del_no=".$delivery;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 
 	$sql="update $bai_pro3.bai_orders_db set carton_id=$carton_id where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=$carton_id where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
?>



<?php
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../main_interface_rplg.php?color=$color&style=$style&schedule=$delivery\"; }</script>";
 
 ?>
 