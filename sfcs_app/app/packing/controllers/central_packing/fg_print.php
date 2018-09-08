<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'fg_print.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
	}

</script>
</head>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
	
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Pack Method</b></div>
	<div class="panel-body">
	<?php

	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
		// echo $style;
	    $schedule=$_POST['schedule'];
		// echo $schedule;
	}
	else
	{
		$style=$_GET['style'];
		echo $style;
		$schedule=$_GET['schedule'];
		echo $schedule;
	}
				echo "<form name=\"mini_order_report\" action=\"#\" method=\"post\" >";
				echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
						$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Style</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
						echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
					?>

					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
						$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					&nbsp;&nbsp;
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit" style="margin-top: 18px;">
					</div>
				</form>
		<div class="col-md-12">
			<?php
			$page = mysql_escape_string($_GET['page']);
		if($page)
		{
			$start = ($page - 1) * $limit; 
		}
		else
		{
			$start = 0;	
		}
			if(isset($_POST['submit']))
			{	
				
				//packing method details
				$style1=$_POST['style'];
				$schedule=$_POST['schedule'];
				$sql_style="select product_style from $brandix_bts.tbl_orders_style_ref where id='".$style."'";
				$sql_style_res=mysqli_query($link, $sql_style) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row1 = mysqli_fetch_row($sql_style_res);
				$style_id=$row1[0];
				// echo $style_id;
				$sql_schedule="select product_schedule from $brandix_bts.tbl_orders_master where id='$schedule'";
				$sql_schedule_res=mysqli_query($link, $sql_schedule) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row2 = mysqli_fetch_row($sql_schedule_res);
				$schedule_id=$row2[0];
				// echo $schedule_id;
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error k".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_confirm=mysqli_num_rows($sql_result);

				$old = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
				// echo $old ; die();
				$old_result=mysqli_query($link, $old) or exit("Sql Error l".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($old_row=mysqli_fetch_array($old_result)) {
		$old_s_s01+=$old_row['old_order_s_s01'];
		$old_s_s02+=$old_row['old_order_s_s02'];
		$old_s_s03+=$old_row['old_order_s_s03'];
		$old_s_s04+=$old_row['old_order_s_s04'];
		$old_s_s05+=$old_row['old_order_s_s05'];
		$old_s_s06+=$old_row['old_order_s_s06'];
		$old_s_s07+=$old_row['old_order_s_s07'];
		$old_s_s08+=$old_row['old_order_s_s08'];
		$old_s_s09+=$old_row['old_order_s_s09'];
		$old_s_s10+=$old_row['old_order_s_s10'];
		$old_s_s11+=$old_row['old_order_s_s11'];
		$old_s_s12+=$old_row['old_order_s_s12'];
		$old_s_s13+=$old_row['old_order_s_s13'];
		$old_s_s14+=$old_row['old_order_s_s14'];
		$old_s_s15+=$old_row['old_order_s_s15'];
		$old_s_s16+=$old_row['old_order_s_s16'];
		$old_s_s17+=$old_row['old_order_s_s17'];
		$old_s_s18+=$old_row['old_order_s_s18'];
		$old_s_s19+=$old_row['old_order_s_s19'];
		$old_s_s20+=$old_row['old_order_s_s20'];
		$old_s_s21+=$old_row['old_order_s_s21'];
		$old_s_s22+=$old_row['old_order_s_s22'];
		$old_s_s23+=$old_row['old_order_s_s23'];
		$old_s_s24+=$old_row['old_order_s_s24'];
		$old_s_s25+=$old_row['old_order_s_s25'];
		$old_s_s26+=$old_row['old_order_s_s26'];
		$old_s_s27+=$old_row['old_order_s_s27'];
		$old_s_s28+=$old_row['old_order_s_s28'];
		$old_s_s29+=$old_row['old_order_s_s29'];
		$old_s_s30+=$old_row['old_order_s_s30'];
		$old_s_s31+=$old_row['old_order_s_s31'];
		$old_s_s32+=$old_row['old_order_s_s32'];
		$old_s_s33+=$old_row['old_order_s_s33'];
		$old_s_s34+=$old_row['old_order_s_s34'];
		$old_s_s35+=$old_row['old_order_s_s35'];
		$old_s_s36+=$old_row['old_order_s_s36'];
		$old_s_s37+=$old_row['old_order_s_s37'];
		$old_s_s38+=$old_row['old_order_s_s38'];
		$old_s_s39+=$old_row['old_order_s_s39'];
		$old_s_s40+=$old_row['old_order_s_s40'];
		$old_s_s41+=$old_row['old_order_s_s41'];
		$old_s_s42+=$old_row['old_order_s_s42'];
		$old_s_s43+=$old_row['old_order_s_s43'];
		$old_s_s44+=$old_row['old_order_s_s44'];
		$old_s_s45+=$old_row['old_order_s_s45'];
		$old_s_s46+=$old_row['old_order_s_s46'];
		$old_s_s47+=$old_row['old_order_s_s47'];
		$old_s_s48+=$old_row['old_order_s_s48'];
		$old_s_s49+=$old_row['old_order_s_s49'];
		$old_s_s50+=$old_row['old_order_s_s50'];

		$old_xs+=$old_row['old_order_s_xs'];
		$old_s+=$old_row['old_order_s_s'];
		$old_m+=$old_row['old_order_s_m'];
		$old_l+=$old_row['old_order_s_l'];
		$old_xl+=$old_row['old_order_s_xl'];
		$old_xxl+=$old_row['old_order_s_xxl'];
		$old_xxxl+=$old_row['old_order_s_xxxl'];

	$old_order_qtys=array($old_s_s01,$old_s_s02,$old_s_s03,$old_s_s04,$old_s_s05,$old_s_s06,$old_s_s07,$old_s_s08,$old_s_s09,$old_s_s10,$old_s_s11,$old_s_s12,$old_s_s13,$old_s_s14,$old_s_s15,$old_s_s16,$old_s_s17,$old_s_s18,$old_s_s19,$old_s_s20,$old_s_s21,$old_s_s22,$old_s_s23,$old_s_s24,$old_s_s25,$old_s_s26,$old_s_s27,$old_s_s28,$old_s_s29,$old_s_s30,$old_s_s31,$old_s_s32,$old_s_s33,$old_s_s34,$old_s_s35,$old_s_s36,$old_s_s37,$old_s_s38,$old_s_s39,$old_s_s40,$old_s_s41,$old_s_s42,$old_s_s43,$old_s_s44,$old_s_s45,$old_s_s46,$old_s_s47,$old_s_s48,$old_s_s49,$old_s_s50);
	$old_total=$old_xs+$old_s+$old_m+$old_l+$old_xl+$old_xxl+$old_xxxl+$old_s_s01+$old_s_s02+$old_s_s03+$old_s_s04+$old_s_s05+$old_s_s06+$old_s_s07+$old_s_s08+$old_s_s09+$old_s_s10+$old_s_s11+$old_s_s12+$old_s_s13+$old_s_s14+$old_s_s15+$old_s_s16+$old_s_s17+$old_s_s18+$old_s_s19+$old_s_s20+$old_s_s21+$old_s_s22+$old_s_s23+$old_s_s24+$old_s_s25+$old_s_s26+$old_s_s27+$old_s_s28+$old_s_s29+$old_s_s30+$old_s_s31+$old_s_s32+$old_s_s33+$old_s_s34+$old_s_s35+$old_s_s36+$old_s_s37+$old_s_s38+$old_s_s39+$old_s_s40+$old_s_s41+$old_s_s42+$old_s_s43+$old_s_s44+$old_s_s45+$old_s_s46+$old_s_s47+$old_s_s48+$old_s_s49+$old_s_s50;
}

	if($sql_num_confirm>0)
		{
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
		}
		else
		{
			$sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
		}


$sql_result=mysqli_query($link, $sql) or exit("Sql Error m".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color.=$sql_row['order_col_des']."/"; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code.=chr($sql_row['color_code']); //Color Code
	$orderno=$sql_row['order_no']; 
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
			
			if($flag==0)
			{
				$size01="01";
				$size02="02";
				$size03="03";
				$size04="04";
				$size05="05";
				$size06="06";
				$size07="07";
				$size08="08";
				$size09="09";
				$size10="10";
				$size11="11";
				$size12="12";
				$size13="13";
				$size14="14";
				$size15="15";
				$size16="16";
				$size17="17";
				$size18="18";
				$size19="19";
				$size20="20";
				$size21="21";
				$size22="22";
				$size23="23";
				$size24="24";
				$size25="25";
				$size26="26";
				$size27="27";
				$size28="28";
				$size29="29";
				$size30="30";
				$size31="31";
				$size32="32";
				$size33="33";
				$size34="34";
				$size35="35";
				$size36="36";
				$size37="37";
				$size38="38";
				$size39="39";
				$size40="40";
				$size41="41";
				$size42="42";
				$size43="43";
				$size44="44";
				$size45="45";
				$size46="46";
				$size47="47";
				$size48="48";
				$size49="49";
				$size50="50";
			}

$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50;
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
	$packing_method=$sql_row['packing_method'];
	$carton_id=$sql_row['carton_id'];
}
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid in(select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id')";
// echo $sql;
// die();
//mysqli_query($link, $sql) or exit("Sql Error n".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error n".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$p_xs=$sql_row['p_xs'];
	$p_s=$sql_row['p_s'];
	$p_m=$sql_row['p_m'];
	$p_l=$sql_row['p_l'];
	$p_xl=$sql_row['p_xl'];
	$p_xxl=$sql_row['p_xxl'];
	$p_xxxl=$sql_row['p_xxxl'];
	$p_s01=$sql_row['p_s01'];
		$p_s02=$sql_row['p_s02'];
		$p_s03=$sql_row['p_s03'];
		$p_s04=$sql_row['p_s04'];
		$p_s05=$sql_row['p_s05'];
		$p_s06=$sql_row['p_s06'];
		$p_s07=$sql_row['p_s07'];
		$p_s08=$sql_row['p_s08'];
		$p_s09=$sql_row['p_s09'];
		$p_s10=$sql_row['p_s10'];
		$p_s11=$sql_row['p_s11'];
		$p_s12=$sql_row['p_s12'];
		$p_s13=$sql_row['p_s13'];
		$p_s14=$sql_row['p_s14'];
		$p_s15=$sql_row['p_s15'];
		$p_s16=$sql_row['p_s16'];
		$p_s17=$sql_row['p_s17'];
		$p_s18=$sql_row['p_s18'];
		$p_s19=$sql_row['p_s19'];
		$p_s20=$sql_row['p_s20'];
		$p_s21=$sql_row['p_s21'];
		$p_s22=$sql_row['p_s22'];
		$p_s23=$sql_row['p_s23'];
		$p_s24=$sql_row['p_s24'];
		$p_s25=$sql_row['p_s25'];
		$p_s26=$sql_row['p_s26'];
		$p_s27=$sql_row['p_s27'];
		$p_s28=$sql_row['p_s28'];
		$p_s29=$sql_row['p_s29'];
		$p_s30=$sql_row['p_s30'];
		$p_s31=$sql_row['p_s31'];
		$p_s32=$sql_row['p_s32'];
		$p_s33=$sql_row['p_s33'];
		$p_s34=$sql_row['p_s34'];
		$p_s35=$sql_row['p_s35'];
		$p_s36=$sql_row['p_s36'];
		$p_s37=$sql_row['p_s37'];
		$p_s38=$sql_row['p_s38'];
	    $p_s39=$sql_row['p_s39'];
		$p_s40=$sql_row['p_s40'];
		$p_s41=$sql_row['p_s41'];
		$p_s42=$sql_row['p_s42'];
		$p_s43=$sql_row['p_s43'];
		$p_s44=$sql_row['p_s44'];
		$p_s45=$sql_row['p_s45'];
		$p_s46=$sql_row['p_s46'];
		$p_s47=$sql_row['p_s47'];
		$p_s48=$sql_row['p_s48'];
		$p_s49=$sql_row['p_s49'];
		$p_s50=$sql_row['p_s50'];
}

$size_titles=array("XS","S","M","L","XL","XXL","XXXL",$size01,$size02,$size03,$size04,$size05,$size06,$size07,$size08,$size09,$size10,$size11,$size12,$size13,$size14,$size15,$size16,$size17,$size18,$size19,$size20,$size21,$size22,$size23,$size24,$size25,$size26,$size27,$size28,$size29,$size30,$size31,$size32,$size33,$size34,$size35,$size36,$size37,$size38,$size39,$size40,$size41,$size42,$size43,$size44,$size45,$size46,$size47,$size48,$size49,$size50);
$size_titles_qry=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
$order_qtys=array($o_xs,$o_s,$o_m,$o_l,$o_xl,$o_xxl,$o_xxxl,$o_s_s01,$o_s_s02,$o_s_s03,$o_s_s04,$o_s_s05,$o_s_s06,$o_s_s07,$o_s_s08,$o_s_s09,$o_s_s10,$o_s_s11,$o_s_s12,$o_s_s13,$o_s_s14,$o_s_s15,$o_s_s16,$o_s_s17,$o_s_s18,$o_s_s19,$o_s_s20,$o_s_s21,$o_s_s22,$o_s_s23,$o_s_s24,$o_s_s25,$o_s_s26,$o_s_s27,$o_s_s28,$o_s_s29
,$o_s_s30,$o_s_s31,$o_s_s32,$o_s_s33,$o_s_s34,$o_s_s35,$o_s_s36,$o_s_s37,$o_s_s38,$o_s_s39,$o_s_s40,$o_s_s41,$o_s_s42,$o_s_s43,$o_s_s44,$o_s_s45,$o_s_s46,$o_s_s47
,$o_s_s48,$o_s_s49,$o_s_s50);
$carton_qtys=array($$p_xs,$p_s,$p_m,$p_l,$p_xl,$o_xxl,$p_xxxl,$p_s01,$p_s02,$p_s03,$p_s04,$p_s05,$p_s06,$p_s07,$p_s08,$p_s09,$p_s10,$p_s11,$p_s12,$p_s13,$p_s14,$p_s15,$p_s16,$p_s17,$p_s18,$p_s19,$p_s20,$p_s21,$p_s22,$p_s23,$p_s24,$p_s25,$p_s26,$p_s27,$p_s28,$p_s29,$p_s30,$p_s31,$p_s32,$p_s33,$p_s34,$p_s35,$p_s36,$p_s37,$p_s38,$p_s39,$p_s40,$p_s41,$p_s42,$p_s43,$p_s44,$p_s45,$p_s46,$p_s47,$p_s48,$p_s49,$p_s50);	
  
  
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$size_titles[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count-1;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  echo "<td class=xl7019400>Total</td>";
  echo"</tr>";
  
			echo "<tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
				<td height=21 class=xl7419400 style='height:15.75pt'>Order Qty:</td>";

				
				$count=0;
				for($i=0;$i<sizeof($old_order_qtys);$i++)
				{
					if($old_order_qtys[$i]>0)
				{
					echo "<td class=xl7019400>".$old_order_qtys[$i]."</td>";
					$count++;
				}
				}
				for($i=0;$i<13-$count-1;$i++)
				{
					echo "<td class=xl7019400>&nbsp;</td>";
				}
				echo "<td class=xl7019400>$old_total</td>";

				
			echo "</tr>";
			echo "<tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7419400 style='height:15.75pt'>Plan Qty:</td>";
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$carton_qtys[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  echo"<td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>";
  

				
				//end logic
				$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where ref_order_num=$schedule AND style_code='$style1'"; 
				// echo $get_pack_id;die();
				$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row = mysqli_fetch_row($get_pack_id_res);
				$pack_id=$row[0];
				// echo $pack_id;
				// die();
				$pack_meth_qry="SELECT *,parent_id,SUM(garments_per_carton) as qnty,sum(poly_bags_per_carton) as carton,GROUP_CONCAT(size_title) as size ,GROUP_CONCAT(color) as color,seq_no,pack_method FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id='$pack_id' GROUP BY pack_method";
				// echo $pack_meth_qry;
				// $sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo "<table class=\"table table-bordered\">";
			echo "<div class='col-md-12'>";
			echo "<div class='col-md-4'>Style: ".$style."</div>";
			echo "<div class='col-md-4'>Buyer Division: </div>";
			echo "<div class='col-md-4'>Schedule No: ".$schedule_id."</div>";
			
			echo "</div>";
			echo "<div class='col-md-12'>";
			echo "<div class='col-md-4'>MPO: </div>";
			echo "<div class='col-md-4'>CPO: </div>";
			echo "<div class='col-md-4'>Customer Order :</div>";
			
			echo "</div>";
			// echo "</table>";
				echo "<div class='col-md-6' style='float: right; margin: center;'> <a class='btn btn-warning' href='$url?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print All packing list
				<a class='btn btn-warning' href='$url1?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print All Carton track
				<a class='btn btn-warning' href='$url2?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print All Labels</a>";
			echo "</div>";
					echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr>
									<th>S.No</th>
									<th>Packing Method</th>
									<th>Description</th>
									<th>No Of Colors</th>
									<th>No Of Sizes</th>
									<th>No Of Cartons</th>
									<th>Quantity</th>
									<th>Controlls</th></tr>";
								while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									// var_dump($operation);
									$seq_no=$pack_result1['seq_no'];
									$parent_id=$pack_result1['parent_id'];
									$pack_method=$pack_result1['pack_method'];
									// echo $pack_method;
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><tr><td>".++$start."</td>";
									echo"<td>".$operation[$pack_method]."</td>";
									echo "<td>".$pack_result1['pack_description']."</td>";
									echo "<td>".$pack_result1['color']."</td>";
									echo "<td>".$pack_result1['size']."</td>";
									echo "<td>".$pack_result1['carton']."</td>";
									echo "<td>".$pack_result1['qnty']."</td>";
									$url=getFullURL($_GET['r'],'#','N');
									$url1=getFullURL($_GET['r'],'#','N');
									$url2=getFullURL($_GET['r'],'#','N');
									// $url3=getFullURL($_GET['r'],'.php','R');
									// $url4=getFullURL($_GET['r'],'.php','R');
									echo "<td>
									<a class='btn btn-warning' href='$url&seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >FG Check List
									<a class='btn btn-warning' href='$url1&seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Carton Track
									<a class='btn btn-warning' href='$url2&seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print Lables</a>
									</td>";
									echo "<tr>";
									
								}	
							
						echo "</table></div>";
												
			}
				
			?> 
		</div>
	</div>
</div>