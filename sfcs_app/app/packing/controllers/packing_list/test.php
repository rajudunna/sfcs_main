<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	      ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));	  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));	  ?>
<?php //include("menu_content.php"); This file was not used here ?>

<script>
	function firstbox()
	{
		window.location.href ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value
	}

	function secondbox()
	{
		window.location.href ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
	}

	function thirdbox()
	{
		window.location.href ="?r=<?= $_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
	}
</script>

<script type="text/javascript">
	function check_style()
	{
		var style_chk=document.getElementById('style').value;
		if(style_chk=='NIL')
		{
			sweetAlert('Please select style first','','warning')
			return false;
		}
		else
		{
			return true;
		}
	}

	function check_style_sch()
	{
		var style_chk=document.getElementById('style').value;
		var schedule_chk=document.getElementById('schedule').value;
		if(style_chk=='NIL')
		{
			sweetAlert('Please select style first','','warning')
			return false;
		}
		else if(schedule_chk=='NIL')
		{
			sweetAlert('Please select schedule','','warning')
			return false;
		}
		else
		{
			return true;
		}
	}
</script>


<div class="panel panel-primary">
	<div class="panel-heading">Packing List </div>
	<div class="panel-body">
	<?php
		$style=$_GET['style'];
		$schedule=$_GET['schedule']; 
		$color=$_GET['color'];
	?>

	<form name="test" action="<?php echo getFullURL($_GET['r'],'test.php','N'); ?>" method="post" class="form-inline">
	<?php
		echo "<div class='form-group'>
				<label>Select Style : </label>&nbsp;&nbsp;
				<select name=\"style\" id=\"style\"  onchange=\"firstbox();\" class=\"form-control\">";

		$sql="select distinct order_style_no from $bai_pro3.order_cat_doc_mix  order by order_style_no";	

		mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		echo "<option value=\"NIL\" selected>NIL</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
			{
				echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
			}else{
				echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
			}
		}

		echo "</select></div>";
	?>

	<?php
		echo "<div class='form-group'>&nbsp;&nbsp;
			  <label>Select Schedule :</label>&nbsp;&nbsp;
			  <select name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" onclick=\"return check_style();\" 
			  class=\"form-control\">";

		$sql="select distinct order_del_no from $bai_pro3.order_cat_doc_mix where order_style_no=\"$style\" order by order_del_no";	
		mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		echo "<option value=\"NIL\" selected>NIL</option>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
			{
				echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
			}else{
				echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
			}
		}


		echo "</select></div>";
	?>

	<?php
		$sql1="select count(order_col_des) as col_cnt from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and order_del_no=\"$schedule\"";		
		mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$color_count=$sql_row1['col_cnt'];
			}
			$sql12="select count(order_col_des) as col_cnts from $bai_pro3.packing_summary where order_del_no=\"$schedule\"";		
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result12);
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$check_stat=$sql_row12['col_cnts'];
			}
		echo "<div class='form-group'>&nbsp;&nbsp;
			  <label>Select Color  :</label>&nbsp;&nbsp;
			  <select name=\"color\" id=\"color\" onchange=\"thirdbox();\" onclick=\"return check_style_sch();\" 
			  class=\"form-control\">";

		$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and 
			  order_del_no=\"$schedule\"";

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
				}else{
						
					echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
				}
			}

		echo "</select></div>";

		$sel_color=$color;
		echo "<input type=\"hidden\" name=\"sel_color\" value=\"".$sel_color."\" />";
		if($color=='0')
		{
			$sql="select order_tid from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			
		}else{
			$sql="select order_tid from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		}
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
			
		}

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
			$sql="select * from $bai_pro3.bai_orders_db_confirm where $filter_joins  order_del_no=\"$schedule\"";
			mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				foreach ($sizes_array as $key => $value)
				{
					$order = 'order_s_'.$sizes_array[$key];
					$total_order_qtys += $sql_row[$order];
				}
				// $o_xs+=$sql_row['order_s_xs'];
				// $o_s+=$sql_row['order_s_s'];
				// $o_m+=$sql_row['order_s_m'];
				// $o_l+=$sql_row['order_s_l'];
				// $o_xl+=$sql_row['order_s_xl'];
				// $o_xxl+=$sql_row['order_s_xxl'];
				// $o_xxxl+=$sql_row['order_s_xxxl'];
				
				// $o_s_s01+=$sql_row['order_s_s01'];
				// $o_s_s02+=$sql_row['order_s_s02'];
				// $o_s_s03+=$sql_row['order_s_s03'];
				// $o_s_s04+=$sql_row['order_s_s04'];
				// $o_s_s05+=$sql_row['order_s_s05'];
				// $o_s_s06+=$sql_row['order_s_s06'];
				// $o_s_s07+=$sql_row['order_s_s07'];
				// $o_s_s08+=$sql_row['order_s_s08'];
				// $o_s_s09+=$sql_row['order_s_s09'];
				// $o_s_s10+=$sql_row['order_s_s10'];
				// $o_s_s11+=$sql_row['order_s_s11'];
				// $o_s_s12+=$sql_row['order_s_s12'];
				// $o_s_s13+=$sql_row['order_s_s13'];
				// $o_s_s14+=$sql_row['order_s_s14'];
				// $o_s_s15+=$sql_row['order_s_s15'];
				// $o_s_s16+=$sql_row['order_s_s16'];
				// $o_s_s17+=$sql_row['order_s_s17'];
				// $o_s_s18+=$sql_row['order_s_s18'];
				// $o_s_s19+=$sql_row['order_s_s19'];
				// $o_s_s20+=$sql_row['order_s_s20'];
				// $o_s_s21+=$sql_row['order_s_s21'];
				// $o_s_s22+=$sql_row['order_s_s22'];
				// $o_s_s23+=$sql_row['order_s_s23'];
				// $o_s_s24+=$sql_row['order_s_s24'];
				// $o_s_s25+=$sql_row['order_s_s25'];
				// $o_s_s26+=$sql_row['order_s_s26'];
				// $o_s_s27+=$sql_row['order_s_s27'];
				// $o_s_s28+=$sql_row['order_s_s28'];
				// $o_s_s29+=$sql_row['order_s_s29'];
				// $o_s_s30+=$sql_row['order_s_s30'];
				// $o_s_s31+=$sql_row['order_s_s31'];
				// $o_s_s32+=$sql_row['order_s_s32'];
				// $o_s_s33+=$sql_row['order_s_s33'];
				// $o_s_s34+=$sql_row['order_s_s34'];
				// $o_s_s35+=$sql_row['order_s_s35'];
				// $o_s_s36+=$sql_row['order_s_s36'];
				// $o_s_s37+=$sql_row['order_s_s37'];
				// $o_s_s38+=$sql_row['order_s_s38'];
				// $o_s_s39+=$sql_row['order_s_s39'];
				// $o_s_s40+=$sql_row['order_s_s40'];
				// $o_s_s41+=$sql_row['order_s_s41'];
				// $o_s_s42+=$sql_row['order_s_s42'];
				// $o_s_s43+=$sql_row['order_s_s43'];
				// $o_s_s44+=$sql_row['order_s_s44'];
				// $o_s_s45+=$sql_row['order_s_s45'];
				// $o_s_s46+=$sql_row['order_s_s46'];
				// $o_s_s47+=$sql_row['order_s_s47'];
				// $o_s_s48+=$sql_row['order_s_s48'];
				// $o_s_s49+=$sql_row['order_s_s49'];
				// $o_s_s50+=$sql_row['order_s_s50'];
				
			}
			
			//$total_order_qtys=($o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
			$sql="select tid as \"tid_db\", coalesce(carton_act_qty,0) as \"tot_carton_qty\" from $bai_pro3.packing_summary where order_del_no in ($schedule)";
			//echo $sql;
			$tid_db=array();
			mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$tid_db[]=$sql_row['tid_db'];
				$tot_carton_qty+=$sql_row['tot_carton_qty'];
			}
			
			$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule) and status=\"DONE\"";
			mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$done_count=mysqli_num_rows($sql_result);
			
			//echo "Carton Qty:".$tot_carton_qty."<br/>";
			//echo "Order Qty:".$total_order_qtys."<br/>";
			//echo "Scanned:".$done_count."<br/>";
			
			if(($total_order_qtys!=$tot_carton_qty) and $tot_carton_qty!=0 and $done_count==0)
			{
				
				$sql="insert into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log 
				      where tid in (".implode(",",$tid_db).")";
				mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="delete from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
				//mysql_query($sql,$link) or exit("Sql Error10".mysql_error());
				
				$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL 
					  where order_del_no in ($schedule)";
				mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				//echo "<h2><font color=green>Successfully Done</font></h2>";
			}
			
		}
	}else{
		if($schedule>0)
		{	
			$sql="select * from $bai_pro3.bai_orders_db_confirm where $filter_joins order_del_no=\"$schedule\" and order_col_des=\"$sel_color\"";
			mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				// $o_xs+=$sql_row['order_s_xs'];
				// $o_s+=$sql_row['order_s_s'];
				// $o_m+=$sql_row['order_s_m'];
				// $o_l+=$sql_row['order_s_l'];
				// $o_xl+=$sql_row['order_s_xl'];
				// $o_xxl+=$sql_row['order_s_xxl'];
				// $o_xxxl+=$sql_row['order_s_xxxl'];
				
				// $o_s_s01+=$sql_row['order_s_s01'];
			// $o_s_s02+=$sql_row['order_s_s02'];
			// $o_s_s03+=$sql_row['order_s_s03'];
			// $o_s_s04+=$sql_row['order_s_s04'];
			// $o_s_s05+=$sql_row['order_s_s05'];
			// $o_s_s06+=$sql_row['order_s_s06'];
			// $o_s_s07+=$sql_row['order_s_s07'];
			// $o_s_s08+=$sql_row['order_s_s08'];
			// $o_s_s09+=$sql_row['order_s_s09'];
			// $o_s_s10+=$sql_row['order_s_s10'];
			// $o_s_s11+=$sql_row['order_s_s11'];
			// $o_s_s12+=$sql_row['order_s_s12'];
			// $o_s_s13+=$sql_row['order_s_s13'];
			// $o_s_s14+=$sql_row['order_s_s14'];
			// $o_s_s15+=$sql_row['order_s_s15'];
			// $o_s_s16+=$sql_row['order_s_s16'];
			// $o_s_s17+=$sql_row['order_s_s17'];
			// $o_s_s18+=$sql_row['order_s_s18'];
			// $o_s_s19+=$sql_row['order_s_s19'];
			// $o_s_s20+=$sql_row['order_s_s20'];
			// $o_s_s21+=$sql_row['order_s_s21'];
			// $o_s_s22+=$sql_row['order_s_s22'];
			// $o_s_s23+=$sql_row['order_s_s23'];
			// $o_s_s24+=$sql_row['order_s_s24'];
			// $o_s_s25+=$sql_row['order_s_s25'];
			// $o_s_s26+=$sql_row['order_s_s26'];
			// $o_s_s27+=$sql_row['order_s_s27'];
			// $o_s_s28+=$sql_row['order_s_s28'];
			// $o_s_s29+=$sql_row['order_s_s29'];
			// $o_s_s30+=$sql_row['order_s_s30'];
			// $o_s_s31+=$sql_row['order_s_s31'];
			// $o_s_s32+=$sql_row['order_s_s32'];
			// $o_s_s33+=$sql_row['order_s_s33'];
			// $o_s_s34+=$sql_row['order_s_s34'];
			// $o_s_s35+=$sql_row['order_s_s35'];
			// $o_s_s36+=$sql_row['order_s_s36'];
			// $o_s_s37+=$sql_row['order_s_s37'];
			// $o_s_s38+=$sql_row['order_s_s38'];
			// $o_s_s39+=$sql_row['order_s_s39'];
			// $o_s_s40+=$sql_row['order_s_s40'];
			// $o_s_s41+=$sql_row['order_s_s41'];
			// $o_s_s42+=$sql_row['order_s_s42'];
			// $o_s_s43+=$sql_row['order_s_s43'];
			// $o_s_s44+=$sql_row['order_s_s44'];
			// $o_s_s45+=$sql_row['order_s_s45'];
			// $o_s_s46+=$sql_row['order_s_s46'];
			// $o_s_s47+=$sql_row['order_s_s47'];
			// $o_s_s48+=$sql_row['order_s_s48'];
			// $o_s_s49+=$sql_row['order_s_s49'];
			// $o_s_s50+=$sql_row['order_s_s50'];
				foreach ($sizes_array as $key => $value)
				{
					$order = 'order_s_'.$sizes_array[$key];
					$total_order_qtys += $sql_row[$order];
				}	
			}
			//$total_order_qtys=($o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
			$sql="select tid as \"tid_db\", coalesce(carton_act_qty,0) as \"tot_carton_qty\" from $bai_pro3.packing_summary where order_del_no in ($schedule) and order_col_des=\"$sel_color\"";
			//echo $sql;
			$tid_db=array();
			mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$tid_db[]=$sql_row['tid_db'];
				$tot_carton_qty+=$sql_row['tot_carton_qty'];
			}
			
			$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule) and order_col_des=\"$sel_color\" and status=\"DONE\"";
			mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$done_count=mysqli_num_rows($sql_result);
			
			// echo "Carton Qty:".$tot_carton_qty."<br/>";
			// echo "Order Qty:".$total_order_qtys."<br/>";
			// echo "Scanned:".$done_count."<br/>";
			
			if(($total_order_qtys!=$tot_carton_qty) and $tot_carton_qty!=0 and $done_count==0)
			{
				
				$sql="insert into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log 
					  where tid in (".implode(",",$tid_db).")";
				mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="delete from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
				//mysql_query($sql,$link) or exit("Sql Error10".mysql_error());
				
				$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL where order_del_no in ($schedule) and order_col_des=\"$sel_color\" ";
				mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				//echo "<h2><font color=green>Successfully Done</font></h2>";
			}
		}
	}//closing else block
?>
</form>

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$sel_color=$_POST['sel_color'];
	$schedule=$_POST['schedule'];
	
	if($sel_color=='0')
	{
		$sql="select order_div,count(order_col_des) as color_count from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and order_del_no=\"$schedule\"";
	}
	else
	{
		$sql="select order_div,count(order_col_des) as color_count from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
	}
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$customer=$sql_row['order_div'];
		$color_count=$sql_row['color_count'];
	}
	
	if($color_count==1)
	{
		$url = getFullURL($_GET['r'],'main_interface_assort_2.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url&color=$color&style=$style&schedule=$schedule\"; }</script>";
	}
	else
	{
		$url = getFullURL($_GET['r'],'main_interface_assort.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url&style=$style&schedule=$schedule&color=$sel_color\"; }</script>";
	}
			
	
}

?>
	</div><!-- panel body -->
</div><!-- panel -->
