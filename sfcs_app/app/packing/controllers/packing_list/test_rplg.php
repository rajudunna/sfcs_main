
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R') );  ?>

<script>

	function firstbox()
	{
		var ajax_url ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value;Ajaxify(ajax_url);

	}

	function secondbox()
	{
		var ajax_url ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;Ajaxify(ajax_url);

	}

	function thirdbox()
	{
		var ajax_url ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
		Ajaxify(ajax_url);

	}
	function fourthbox()
	{
		var ajax_url ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&ratiopacksize="+document.test.ratiopacksize.value;
		Ajaxify(ajax_url);

	}
</script>

<div class="panel panel-primary">
	<div class="panel-heading">Ratio Packing List Generation</div>
	<div class="panel-body">
	<?php
		$style=$_GET['style'];
		$schedule=$_GET['schedule']; 
		$color=$_GET['color'];
		$ratiopacksize=$_GET['ratiopacksize'];
		//echo $style.$schedule.$color;
	?>
	<form name="test" action="<?php echo getFullURL($_GET['r'],'test_rplg.php','N'); ?>" method="post" class="form-inline">
	<?php
		echo "<div class='row'><div class='form-group'>";
		echo "<div class='col-md-2'><label>Select Style : </label>&nbsp;&nbsp;<select name=\"style\" onchange=\"firstbox();\" class=\"form-control\">";

	//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
	//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
	//{
		$sql="select distinct order_style_no from $bai_pro3.order_cat_doc_mix order by order_style_no";	
	//}
		mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		echo "<option value=\"NIL\" selected>NIL</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
			{
				echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
			}
		}
		echo "</select></div>";
	?>

	<?php

		echo "<div class='col-sm-2'>
				<label>Select Schedule :</label>&nbsp;&nbsp;
				<select name=\"schedule\" onchange=\"secondbox();\" class=\"form-control\"></div></div>";
		//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
		$sql="select distinct order_del_no from $bai_pro3.order_cat_doc_mix where order_style_no=\"$style\" order by order_del_no";	
		//echo $sql;
		//}
		mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		echo "<option value=\"NIL\" selected>NIL</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
			{
				echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
			}
		}
		echo "</select></div>";
	?>

	<?php
		$sql1="select count(order_col_des) as col_cnt from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		//	echo "query=".$sql1;
		mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$color_count=$sql_row1['col_cnt'];
			}
		//	echo "<br/>count=".$color_count;
		echo "<div class='col-md-3'>
				<label>Select Color :</label>&nbsp;&nbsp;<br/>
				<select name=\"color\" onchange=\"thirdbox();\" class=\"form-control\">";

		//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
			$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
		//}
		mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		echo "<option value=\"NIL\" selected>NIL</option>";
		if($color_count>'1')
		{
	?>
			<option value="0" <?php if($color=="0") { echo "selected"; } ?>>ALL</option>
	<?php
		}
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color) )
			{	
				echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
			}
			else
			{	
				echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
			}
		}
		echo "</select></div>";
		echo "<div class='col-md-3'><label> Select Ratio Packing Method: </label><select name=\"ratiopacksize\" onchange=\"fourthbox();\" class=\"form-control\">";
		echo "<option value=\"0\" selected>--select--</option>";
		if($ratiopacksize=='single')
		{
			echo "<option value=\"single\" selected> Single Size Multiple Colours </option>";
			echo "<option value=\"multiple\" > Multiple Sizes Multiple Colours </option>";
		}
		else if($ratiopacksize=='multiple')
		{
			echo "<option value=\"single\" > Single Size Multiple Colours </option>";
			echo "<option value=\"multiple\" selected> Multiple Sizes Multiple Colours </option>";
		}
		else
		{
			echo "<option value=\"single\" > Single Size Multiple Colours </option>";
			echo "<option value=\"multiple\" > Multiple Sizes Multiple Colours </option>";
		}

		echo "</select></div>";

		$sel_color=$color;
		echo "<div class='col-md-2'><input type=\"hidden\" name=\"sel_color\" value=\"".$sel_color."\" />";
		if($color=='0')
		{
			$sql="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			
		}
		else
		{
		$sql="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		}
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$order_tid=$sql_row['order_tid'];
		}



		$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\"  and length(category)>0 and purwidth>0";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$mo_status=$sql_row['mo_status'];
			//echo $mo_status;
		}

		//$sql_al="";

		$sql_plan="SELECT * FROM $bai_pro3.allocate_stat_log WHERE order_tid LIKE \"% ".$schedule."%\" ";
		//echo $sql_plan;
		if($mo_status=="Y")
		{
			echo "&nbsp;&nbsp;<label>MO Status  :</label>"."&nbsp;&nbsp;<span class='label label-success'><i class='fa fa-check-circle'></i>&nbsp;".$mo_status."es</span>";
			echo "&nbsp;&nbsp;<input type=\"submit\" value=\"submit\" name=\"submit\" class=\"btn btn-primary\">";	
		}
		else
		{
			echo "&nbsp;&nbsp;<label>MO Status  :</label>"."&nbsp;&nbsp;<span class='label label-danger'><i class='fa fa-times-circle'></i> No</span>";
					//echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";
		}
	?>
	<?php

			//Deleting wrongly generated list
			if($sel_color=='0')
			{
				
			if($schedule>0)
			{
				
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
				mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
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

					
				}
				
				$total_order_qtys=($o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);


				
				$sql="select tid as \"tid_db\", coalesce(carton_act_qty,0) as \"tot_carton_qty\" from $bai_pro3.packing_summary where order_del_no in ($schedule)";
			//echo $sql;
				$tid_db=array();
				mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
				$count=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$tid_db[]=$sql_row['tid_db'];
					$tot_carton_qty+=$sql_row['tot_carton_qty'];
				}
				
				$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule) and status=\"DONE\"";
				mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
				$done_count=mysqli_num_rows($sql_result);
				
				//echo "Carton Qty:".$tot_carton_qty."<br/>";
				//echo "Order Qty:".$total_order_qtys."<br/>";
				//echo "Scanned:".$done_count."<br/>";
				
				if(($total_order_qtys!=$tot_carton_qty) and $tot_carton_qty!=0 and $done_count==0)
				{
					
					$sql="insert into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
					mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
					
					$sql="delete from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
					//mysqli_query($link,$sql) or exit("Sql Error10".mysql_error());
					
					$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL where order_del_no in ($schedule)";
					mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error());
					
					//echo "<h2><font color=green>Successfully Done</font></h2>";
				}
				
			}
		}

		else
		{
				if($schedule>0)
			    {
				
					$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$sel_color\"";
					mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
					$sql_result=mysqli_query($link,$sql) or exit("Sql Error6".mysqli_error());
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
					}
			
				$total_order_qtys=($o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);


			
				$sql="select tid as \"tid_db\", coalesce(carton_act_qty,0) as \"tot_carton_qty\" from $bai_pro3.packing_summary where order_del_no in ($schedule) and order_col_des=\"$sel_color\"";
		
				$tid_db=array();
				mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
				$count=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$tid_db[]=$sql_row['tid_db'];
					$tot_carton_qty+=$sql_row['tot_carton_qty'];
				}
				
				$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule) and order_col_des=\"$sel_color\" and status=\"DONE\"";
				mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
				$done_count=mysqli_num_rows($sql_result);
				
				//echo "Carton Qty:".$tot_carton_qty."<br/>";
				//echo "Order Qty:".$total_order_qtys."<br/>";
				//echo "Scanned:".$done_count."<br/>";
			
				if(($total_order_qtys!=$tot_carton_qty) and $tot_carton_qty!=0 and $done_count==0)
				{
					
					$sql="insert into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
					mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
					
					$sql="delete from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
					//mysqli_query($link,$sql) or exit("Sql Error10".mysql_error());
					
					$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL where order_del_no in ($schedule) and order_col_des=\"$sel_color\" ";
					mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error());
					
					//echo "<h2><font color=green>Successfully Done</font></h2>";
				}
			
			}
		
		}
	?>
	</form>


	<?php
	if(isset($_POST['submit']))
	{
		$style=$_POST['style'];
		$color=$_POST['color'];
		$sel_color=$_POST['sel_color'];
		$schedule=$_POST['schedule'];
		$ratiopacksize = $_POST['ratiopacksize'];
		$main_interface = getFullURL($_GET['r'],'main_interface_rplg.php','N');
		$main_interface_assort = getFullURL($_GET['r'],'main_interface_assort_rplg.php','N');
		//$main_interface_assort_2 = getFullURL($_GET['r'],'main_interface_assort_2.php','N');
		//echo "<br/>style=".$style;
		//echo "<br/>schedule=".$schedule;
		//echo "<br/>colour=".$color;
		//echo "<br/>sel_color=".$sel_color;
		$sql="select order_div from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" ";
		mysqli_query($link,$sql) or exit("Sql Error12".mysqli_error());
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error12".mysqli_error());
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$customer=$sql_row['order_div'];
		}
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
		echo $customer;
		// echo "<br/>customer=".$customer;
		//$customer = 'VS';
		if($ratiopacksize!='0')
		{
			if($sel_color != "0")
			{
				//echo "working";
				//echo "color value==0";
				$sql1="select order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" limit 1 ";
				//echo "query=".$sql1;
				mysqli_query($link,$sql1) or exit("Sql Error12".mysqli_error());
					$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error12".mysqli_error());
					$sql_num_check=mysqli_num_rows($sql_result1);
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$ord_col=$sql_row1['order_col_des'];
					}
					switch ($customer)
					{
						case "VS":
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>"; //changes main_interface.php
							}
							//else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$main_interface&color=$ord_col&style=$style&schedule=$schedule\"; }</script>"; //changes main_interface.php
							}
							break;
						}
						
						case "DB":
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>";
							}
							//else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$main_interface_assort&color=$ord_col&style=$style&schedule=$schedule&ratiopacksize=$ratiopacksize\"; }</script>";
							}
							break;
						}
						
						case "M&":
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>";
							}
							//else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$main_interface_assort&color=$ord_col&style=$style&schedule=$schedule&ratiopacksize=$ratiopacksize\"; }</script>";
							}
							break;
						}
						
						case "T5":
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>";
							}
							//else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$main_interface_assort&color=$ord_col&style=$style&schedule=$schedule&ratiopacksize=$ratiopacksize\"; }</script>";
							}
							break;
						}
						case "CK":
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
							}
							//else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$main_interface_assort&color=$ord_col&style=$style&schedule=$schedule&ratiopacksize=$ratiopacksize\"; }</script>";
							}
							break;
						}
						
						case "LB":
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>";
							}
							//else
							{	
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort_lbi.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>";
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"http://bainet:8080/projects/beta/reports/LBI_Packing_List/lbi_packing_list_generation.php?color=$ord_col&style=$style&schedule=$schedule\"; }</script>";
							}
							break;
						}
						default:
						{
							//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
							{
								//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"main_interface_assort.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
							}
							//else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$main_interface_assort&color=$ord_col&style=$style&schedule=$schedule&ratiopacksize=$ratiopacksize\"; }</script>";
							}
							break;
						}
					}	
			}
		}
		else
		{
			echo "<script>swal('Warning','Ratio Packing Method Not Selected For This Schedule','danger')</script>";
			echo "<div class='alert alert-danger' role='alert'>Ratio Packing Method Not Selected For This Schedule</div>";
			//echo "<h2 style='color:Red;'></h2>";
		}
		
	}

	?>
	</div>
</div>