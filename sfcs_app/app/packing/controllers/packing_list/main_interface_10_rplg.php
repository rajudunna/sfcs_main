
<?php
	echo "<form name=\"input\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
	echo "<h2>Suggested Carton Qty</h2>";
	$sizes_array=array("xs","s","m","l","xl","xxl","xxxl","s06","s08","s10","s12","s14","s16","s18","s20","s22","s24","s26","s28","s30");
	for($q=0;$q<sizeof($sizes_array);$q++)
	{
		$sql6="select sum(order_s_".$sizes_array[$q].") as order_qty from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\" ";	
		//echo $sql6."<br>";
		$result6=mysqli_query($link, $sql6) or die("Error11 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row6=mysqli_fetch_array($result6))
		{		
			if($row6["order_qty"] > 0)
			{
				$sizes_all[]=$sizes_array[$q];
			}
		}
	}
	$sx=0;
	for($i=0;$i<sizeof($sizes_all);$i++)
	{
		$sql="select sum($sizes_all[$i]) as qty from $bai_pro3.carton_qty_chart where user_style=\"$style_id\" and buyer_identity like \"%$buyer_code%\" and status=0 group by id";
	//echo $sql;	
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if($sql_row["qty"]==0)
			{
				$sx=$sx+1;
			}
		}
	}

	$sql="select * from $bai_pro3.carton_qty_chart where user_style=\"$style_id\" and buyer_identity like \"%$buyer_code%\" and status=0";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	$x=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		if($sql_row['buyer_identity']=="M")
		{
			if($x==0)
			{
				echo "<table ><tr><th style='background-color:#29759C;'>Select</th><th style='background-color:#29759C;'>Packing Method</th><th style='background-color:#29759C;'>XS</th><th style='background-color:#29759C;'>S</th><th style='background-color:#29759C;'>M</th><th style='background-color:#29759C;'>L</th><th style='background-color:#29759C;'>XL</th><th style='background-color:#29759C;'>XXL</th><th style='background-color:#29759C;'>XXXL</th><th style='background-color:#29759C;'>06</th><th style='background-color:#29759C;'>08</th><th style='background-color:#29759C;'>10</th><th style='background-color:#29759C;'>12</th><th style='background-color:#29759C;'>14</th><th style='background-color:#29759C;'>16</th><th style='background-color:#29759C;'>18</th><th style='background-color:#29759C;'>20</th><th style='background-color:#29759C;'>22</th><th style='background-color:#29759C;'>24</th><th style='background-color:#29759C;'>26</th><th style='background-color:#29759C;'>28</th><th style='background-color:#29759C;'>30</th></tr>";
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
				echo "<table ><tr><th style='background-color:#29759C;'>Select</th><th style='background-color:#29759C;'>Packing Method</th><th style='background-color:#29759C;'>XS</th><th style='background-color:#29759C;'>S</th><th style='background-color:#29759C;'>M</th><th style='background-color:#29759C;'>L</th><th style='background-color:#29759C;'>XL</th><th style='background-color:#29759C;'>XXL</th><th style='background-color:#29759C;'>XXXL</th><th style='background-color:#29759C;'>06</th><th style='background-color:#29759C;'>08</th><th style='background-color:#29759C;'>10</th><th style='background-color:#29759C;'>12</th><th style='background-color:#29759C;'>14</th><th style='background-color:#29759C;'>16</th><th style='background-color:#29759C;'>18</th><th style='background-color:#29759C;'>20</th><th style='background-color:#29759C;'>22</th><th style='background-color:#29759C;'>24</th><th style='background-color:#29759C;'>26</th><th style='background-color:#29759C;'>28</th><th style='background-color:#29759C;'>30</th></tr>";
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
		
		
	$sql2="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and category in ($in_categories) and purwidth > 0";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$cat_ref=$sql_row2['tid'];
	}
		
	echo "</table>";

	$cut_total_qty=0;
	$sqla="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE cat_ref=\"$cat_ref\" GROUP BY doc_no";
	//echo $sqla."<br>";
	$resulta=mysqli_query($link, $sqla) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rowa=mysqli_fetch_array($resulta))
	{
		$cut_total_qty=$cut_total_qty+$rowa["doc_qty"];
	}
	//echo $cut_total_qty;
	if($cut_total_qty >= $o_total)
	{
		if($sql_num_check>=1 && $sx==0)
		{
			if($carton_id==0)
			{
				echo "<input type=\"hidden\" name=\"cartonid\" value=\"\"><input type=\"hidden\" name=\"order_tid\" value=\"$tran_order_tid\"><input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
				echo "<input type=\"submit\" name=\"submit\" value=\"Generate Packing List\">";
				//echo "<a href=\"packing/packing_list_gen.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\">Please generate Packing List</a>";
			}
			else
			{
				$url = getFullURL($_GET['r'],'packing_list_print_rplg.php','N');
				echo "<br/><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\" onclick=\"return popitup("."'"."packing_list_print_rplg.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create"."'".")\">Print Packing List </a><br/>";

				if($carton_print_status!=1)
				{
					$url = getFullURLLevel($_GET['r'],'reports/pdfs/labels_rplg.php',2,'R');
					echo "<a href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create"."'".")\">Print Labels </a><br/>";
				}
				else
				{
					echo "Carton Labels are already generated!! <br/>";
				}
				$url = getFullURL($_GET['r'],'packing_check_list_rplg.php','N');
				echo "<br/><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\" onclick=\"return popitup("."'"."packing_check_list_rplg.php?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create"."'".")\">Carton Track</a><br/>";
			}
		}
		else
		{
			echo "Wrong with carton qty updatation";
		}
	}
	else
	{
		echo "<h2>Still cutplan not yet generated. Please check with CAD team.</h2>";
	}


	echo "</form>";
?>

<?php
	if(isset($_POST['submit']))
	{
		$order_tid=$_POST['order_tid'];
		$cat_ref=$_POST['cat_ref'];
		$cartonid=$_POST['cartonid'];
		$url = getFullURL($_GET['r'],'packing_list_gen_rplg.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); 
				function Redirect() {  
					location.href = \"$url&order_tid=$order_tid&cat_ref=$cat_ref&carton_id=$cartonid\"; 
				}
			</script>";

	}

?>
