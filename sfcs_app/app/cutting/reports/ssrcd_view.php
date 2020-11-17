<?php 
$url1 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include("$url1");  
$url2 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'); 
include("$url2");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));

?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="../common/filelist.xml">

<style id="Book4_5113_Styles">
th{ color : black;}
td{ color : black;}
.black{
	text-align : right;
	font-weight : bold;
	color : #000;
}
</style>
<script type='text/javascript'>
function show_pop1(){
	if($('#style').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}
function show_pop2(){
	if($('#schedule').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}
function show_pop3(){
	if($('#color').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}

function firstbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)));
}


function secondbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)))
}
function fourthbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)))+"&category="+document.test.category.value
}
</script>

<?php 
$url3 = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R');
include("$url3"); 
?>

<?php 
// $url4 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php',2,'R');
// include("$url4"); 
?>

<?php
$style=style_decode($_GET['style']);
$schedule=$_GET['schedule']; 
$color=color_decode($_GET['color']);
$category=$_GET['category'];

if(isset($_POST['style']))
{
	$style=$_POST['style'];
}

if(isset($_POST['schedule']))
{
	$schedule=$_POST['schedule'];
}

if(isset($_POST['color']))
{
	$color=$_POST['color'];
}

if(isset($_POST['category']))
{
	$category=$_POST['category'];
}
?>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>Style Status Report - Cut Details</b>
	</div>
	<div class="panel-body">
		<form method="post" name="test" action="?r=<?= $_GET['r'] ?>">
			<div class="col-sm-2 form-group">
				<label for='style'>Select Style</label>
				<select class='form-control' name='style' id='style' onchange='firstbox()'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					//$sql="select distinct order_style_no from bai_orders_db";
					$sql="SELECT DISTINCT order_style_no FROM $bai_pro3.bai_orders_db JOIN $bai_pro3.cat_stat_log ON bai_orders_db.order_tid=cat_stat_log.order_tid and cat_stat_log.category<>\"\" order by bai_orders_db.order_style_no";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);

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
				echo "</select>";
				?>	
			</div>
			<div class="col-sm-2 form-group">
				<label for='schedule'>Select Schedule</label>
				<select class='form-control' name='schedule' id='schedule' onclick='show_pop1()' onchange='secondbox();' >
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";	
					//$sql="select distinct order_del_no from bai_orders_db where order_style_no=\"$style\"";
					$sql="SELECT DISTINCT order_del_no FROM $bai_pro3.bai_orders_db JOIN $bai_pro3.cat_stat_log ON bai_orders_db.order_tid=cat_stat_log.order_tid and cat_stat_log.category<>\"\" and bai_orders_db.order_style_no=\"$style\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);

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
					echo "</select>";
				?>
			</div>	
			<div class="col-sm-2">
				<label for='color'>Select Color:</label>
				<select class='form-control' name='color' id='color' onclick='show_pop2()' onchange='thirdbox();' >
				<?php
					//$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
					$sql="SELECT DISTINCT order_col_des FROM $bai_pro3.bai_orders_db JOIN $bai_pro3.cat_stat_log ON bai_orders_db.order_tid=cat_stat_log.order_tid and cat_stat_log.category<>\"\" and bai_orders_db.order_style_no=\"$style\" and bai_orders_db.order_del_no=\"$schedule\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>NIL</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
						{
							echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
						}
					}
				echo "</select>";
				?>
			</div>

			<?php		
				$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
				//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$order_tid=$sql_row['order_tid'];
				}
			?>
			<div class="col-sm-2">
				<label for='category'>Select Category:</label>
				<select class='form-control' id='category' onclick='show_pop3()' name='category'>
				<?php				
					$sql="select distinct category from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category<>\"\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>NIL</option>";	
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['category'])==str_replace(" ","",$category))
						{
							echo "<option value=\"".$sql_row['category']."\" selected>".$sql_row['category']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['category']."\">".$sql_row['category']."</option>";
						}
					}
					echo "</select>";
				?>
			</div>	
			<?php
				$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category<>\"\"";
				//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$mo_status=$sql_row['mo_status'];
				}

			if($mo_status=="Y")
			{
				echo "<br>MO Status:"."<font color=GREEN size=5>".$mo_status."es</font>";
				echo "<input class='btn btn-success' type=\"submit\" value=\"submit\" name=\"submit\">";	
			}
			?>
		</form>
		<hr>
		


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$category=$_POST['category'];
	
	if ($style=='NIL' or $schedule=='NIL' or $color=='NIL' or $category=='NIL') {
		echo '<div class="alert alert-danger">
			  <strong>Warning!</strong> Please Provide All Details
			</div>';
	} else 
	{
	
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		// echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{		
			$order_tid=$sql_row['order_tid'];
			$order_no=$sql_row['order_no'];
			$color_code=$sql_row['color_code'];
			$customer=$sql_row['order_div'];
			
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
				{
					$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
				}	
			}
			
			if($order_no==1)
			{
				for($s=0;$s<sizeof($s_tit);$s++)
				{
					$o_s[$sizes_code[$s]]=$sql_row["old_order_s_s".$sizes_code[$s].""];
				}

				for($s=0;$s<sizeof($s_tit);$s++)
				{
					$e_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
					$e_s_q[$sizes_code[$s]]=$e_s[$sizes_code[$s]]-$o_s[$sizes_code[$s]];
				}
				
			}
			else
			{
				for($s=0;$s<sizeof($s_tit);$s++)
				{
					$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
				}

				for($s=0;$s<sizeof($s_tit);$s++)
				{
					$e_s[$sizes_code[$s]]=0;
					$e_s_q[$sizes_code[$s]]=0;
				}
			}			
		}	
		
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
		
		$sql="select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category=\"$category\"";
		mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cat_id=$sql_row['tid'];
		}
		
		$sql="select sum(allocate_xs*plies) as \"a_s_xs\", sum(allocate_s*plies) as \"a_s_s\", sum(allocate_m*plies) as \"a_s_m\", sum(allocate_l*plies) as \"a_s_l\", sum(allocate_xl*plies) as \"a_s_xl\", sum(allocate_xxl*plies) as \"a_s_xxl\", sum(allocate_xxxl*plies) as \"a_s_xxxl\", sum(allocate_s01*plies) as \"a_s_s01\", sum(allocate_s02*plies) as \"a_s_s02\", sum(allocate_s03*plies) as \"a_s_s03\", sum(allocate_s04*plies) as \"a_s_s04\", sum(allocate_s05*plies) as \"a_s_s05\", sum(allocate_s06*plies) as \"a_s_s06\", sum(allocate_s07*plies) as \"a_s_s07\", sum(allocate_s08*plies) as \"a_s_s08\", sum(allocate_s09*plies) as \"a_s_s09\", sum(allocate_s10*plies) as \"a_s_s10\", sum(allocate_s11*plies) as \"a_s_s11\", sum(allocate_s12*plies) as \"a_s_s12\", sum(allocate_s13*plies) as \"a_s_s13\", sum(allocate_s14*plies) as \"a_s_s14\", sum(allocate_s15*plies) as \"a_s_s15\", sum(allocate_s16*plies) as \"a_s_s16\", sum(allocate_s17*plies) as \"a_s_s17\", sum(allocate_s18*plies) as \"a_s_s18\", sum(allocate_s19*plies) as \"a_s_s19\", sum(allocate_s20*plies) as \"a_s_s20\", sum(allocate_s21*plies) as \"a_s_s21\", sum(allocate_s22*plies) as \"a_s_s22\", sum(allocate_s23*plies) as \"a_s_s23\", sum(allocate_s24*plies) as \"a_s_s24\", sum(allocate_s25*plies) as \"a_s_s25\", sum(allocate_s26*plies) as \"a_s_s26\", sum(allocate_s27*plies) as \"a_s_s27\", sum(allocate_s28*plies) as \"a_s_s28\", sum(allocate_s29*plies) as \"a_s_s29\", sum(allocate_s30*plies) as \"a_s_s30\", sum(allocate_s31*plies) as \"a_s_s31\", sum(allocate_s32*plies) as \"a_s_s32\", sum(allocate_s33*plies) as \"a_s_s33\", sum(allocate_s34*plies) as \"a_s_s34\", sum(allocate_s35*plies) as \"a_s_s35\", sum(allocate_s36*plies) as \"a_s_s36\", sum(allocate_s37*plies) as \"a_s_s37\", sum(allocate_s38*plies) as \"a_s_s38\", sum(allocate_s39*plies) as \"a_s_s39\", sum(allocate_s40*plies) as \"a_s_s40\", sum(allocate_s41*plies) as \"a_s_s41\", sum(allocate_s42*plies) as \"a_s_s42\", sum(allocate_s43*plies) as \"a_s_s43\", sum(allocate_s44*plies) as \"a_s_s44\", sum(allocate_s45*plies) as \"a_s_s45\", sum(allocate_s46*plies) as \"a_s_s46\", sum(allocate_s47*plies) as \"a_s_s47\", sum(allocate_s48*plies) as \"a_s_s48\", sum(allocate_s49*plies) as \"a_s_s49\", sum(allocate_s50*plies) as \"a_s_s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{		
			for($s=0;$s<sizeof($s_tit);$s++)
			{
				$a_s[$sizes_code[$s]]=$sql_row["a_s_s".$sizes_code[$s].""];
			}
			$a_total=array_sum($a_s);			
		}
		
		
		$cut_qty_total=0;
		$input_qty_total=0;		
		
		$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$act_doc_no=$sql_row1['doc_no'];
			$act_cut_no=$sql_row1['acutno'];
			$status=$sql_row1['act_cut_status'];
			if($status=='DONE')
			{
				for($s=0;$s<sizeof($s_tit);$s++)
				{
					$act_s[$sizes_code[$s]]=$act_s[$sizes_code[$s]]+$sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies'];
				}
			}

			for($ss=0;$ss<sizeof($s_tit);$ss++)
			{
				$cut_s[$sizes_code[$ss]]=$cut_s[$sizes_code[$ss]]+$sql_row1["p_s".$sizes_code[$ss].""]*$sql_row1['p_plies'];
			}			
		}
		// Getting cuttable percentage from cuttable stat log of respective order tid
		$sql_cuttable="select cuttable_percent from $bai_pro3.cuttable_stat_log where order_tid=\"$order_tid\"";
		mysqli_query($link, $sql_cuttable) or exit("15".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result_cuttable=mysqli_query($link, $sql_cuttable) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_cuttable=mysqli_fetch_array($sql_result_cuttable))
		{
			$cuttable_percent=$sql_row_cuttable['cuttable_percent'];
		}

		// $sql_tot_cut_plan_qty="select * from $bai_pro3.plandoc_stat_log where doc_no=$act_doc_no";
		// mysqli_query($link, $sql_tot_cut_plan_qty) or exit($sql_tot_cut_plan_qty."Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $sql_result_tot_cut_plan_qty=mysqli_query($link, $sql_tot_cut_plan_qty) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
		// echo $sql_tot_cut_plan_qty;
		// while($sql_row_tot_cut_plan_qty=mysqli_fetch_array($sql_result_tot_cut_plan_qty))
		// 	{
		// 		$actual_plies=$sql_row_tot_cut_plan_qty['a_plies'];
		// 		$planned_plies=$sql_row_tot_cut_plan_qty['p_plies'];
		// 		for($s=0;$s<sizeof($sizes_code);$s++)
		// 	{
		// 		$a_s_tot[$sizes_code[$s]]=$sql_row_tot_cut_plan_qty["a_s".$sizes_code[$s].""];
		// 	}
		// 	}

		?>

				<div class='col-sm-12' style='text-align: left';>
						<div class="col-sm-3" >
							<div class="col-sm-6 black"><b>Style : </b></div>
							<div class="col-sm-6 "><p class='text-danger'><?php echo $style;?></p></div>
						</div>
						<div class="col-sm-3">
							<div class="col-sm-6 black"><b>Schedule : </b></div>
							<div class="col-sm-6"><p class='text-danger'><?php echo $schedule; ?></p></div>
						</div>
						<div class="col-sm-3">
							<div class="col-sm-6 black"><b>Color : </b></div>
							<div class="col-sm-6"><p class='text-danger'><?php echo $color; ?></p></div>
						</div>
						<div class="col-sm-3">
							<div class="col-sm-6 black"><b>Category : </b></div>
							<div class="col-sm-6"><p class='text-danger'><?php echo $category; ?></p></div>
						</div>
				</div>

		<br>
		<div class='col-sm-12'>
		<div class='col-sm-8 table-responsive'>
			<table class="table table-bordered  ">
				<tr>

					<th style="width:100px;">Size</th>
					<?php
						for($s=0;$s<sizeof($s_tit);$s++){
							echo "<td>".$s_tit[$sizes_code[$s]]."</td>";
						}
					?>
					<th style="width:100px;">Total</th>
				</tr>
				<tr>
					<th class='success'  style="width:100px;">Order Qty</th>
					<?php
						for($s=0;$s<sizeof($s_tit);$s++)
						{
							$order_qty_tot+=$o_s[$sizes_code[$s]];
							 echo "<td>".$o_s[$sizes_code[$s]]."</td>";
						}
						echo "<td>".$order_qty_tot."</td>";
					?>

				</tr>
				<tr>
					<th class='success' style="width:100px;">Order qty with extra shipment</th>
					<?php
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$order_qty_ext_ship_tot+=$e_s[$sizes_code[$s]];
						echo "<td>".$e_s[$sizes_code[$s]]."</td>";
					}
					echo "<td>".$order_qty_ext_ship_tot."</td>";
					?>
				</tr>
				<tr>
					<th class='success' style="width:100px;">Extra shipment %</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$extra_ship_per =  round((($e_s[$sizes_code[$s]]-$o_s[$sizes_code[$s]])/$o_s[$sizes_code[$s]])*100,2);
						if ($extra_ship_per > 0) {
							// $extra_ship_per_tot+=$extra_ship_per;
							echo "<td>".floor($extra_ship_per)."%</td>";
						} else {
							echo "<td> 0 </td>";
						}
					}echo "<td>".floor($extra_ship_per)."%</td>";
					?>
				</tr>
				<tr>
					<th class='success' style="width:100px;">Planned Excess Cut %</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{	 
						 echo "<td>".$cuttable_percent."</td>";
					}echo "<td>".$cuttable_percent."%</td>";
					?>
				</tr>
				<tr>
					<th class='success' style="width:100px;">Planned Excess Cut Qty</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$planned_excess_qty[$sizes_code[$s]]=($o_s[$sizes_code[$s]]/100)*$cuttable_percent;
						$planned_excess_qty_tot+=($planned_excess_qty[$sizes_code[$s]]);
						echo "<td>".ceil($planned_excess_qty[$sizes_code[$s]])."</td>";
					}echo "<td>".ceil($planned_excess_qty_tot)."</td>";
					?>
				</tr>
				<tr>
					<th class='success' style="width:100px;">Excess due to size ratio</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$total_cut_plan_qty = $cut_s[$sizes_code[$s]];
						$excess_size_ratio = $total_cut_plan_qty-($o_s[$sizes_code[$s]]+$e_s_q[$sizes_code[$s]]+$planned_excess_qty[$sizes_code[$s]]);
						$excess_size_ratio_tot+=floor($excess_size_ratio);
						if ($excess_size_ratio > 0) {
							echo "<td>".floor($excess_size_ratio)."</td>";
						} else {
							echo "<td> 0 </td>";
						}
					}echo "<td>".floor($excess_size_ratio_tot)."</td>";
					?>
				</tr>
				<tr>
					<th class='success' style="width:100px;">Total Cut Plan Qty</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
					$total_cut_plan_qty=$cut_s[$sizes_code[$s]];
					$total_cut_plan_qty_tot+=$total_cut_plan_qty;
					echo "<td>".$total_cut_plan_qty."</td>";
					}echo "<td>".$total_cut_plan_qty_tot."</td>";
					?>
				</tr>
				<tr>
					<th style="width:100px;">Fabric not allocated Qty</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$fablic_alloc_qty = $cut_s[$sizes_code[$s]]-$act_s[$sizes_code[$s]];
						$total_fablic_alloc_qty+=$fablic_alloc_qty;
						if ($fablic_alloc_qty > 0) {
							echo "<td>$fablic_alloc_qty</td>";
						} else {
							echo "<td> 0 </td>";
						}
					}
					echo "<td>".$total_fablic_alloc_qty."</td>";
					?>
					
				</tr>
				<tr>
					<th style="width:100px;">Act Cut Qty</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$act_cut_qty = $act_s[$sizes_code[$s]];
						$act_cut_qty_tot+=$act_cut_qty;
						if ($act_cut_qty > 0) {
							echo "<td>$act_cut_qty</td>";
						} else {
							echo "<td> 0 </td>";
						}
					}echo "<td>".$act_cut_qty_tot."</td>";
					?>
				</tr>
				<tr>
					<th style="width:100px;">Act Cut %</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$act_cut_percent = round(($act_s[$sizes_code[$s]]/$cut_s[$sizes_code[$s]])*100,2);
						if ($act_cut_percent > 0) {
							echo "<td>".$act_cut_percent."%</td>";
						} else {
							echo "<td> 0 %</td>";
						}
					}echo "<td>".$act_cut_percent."%</td>";
					?>
				</tr>
				<tr>
					<th style="width:100px;">Balance to Cut Qty</th>
					<?php 
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						$balance_cut_qty = ($a_s_tot[$sizes_code[$s]]*$planned_plies)-($a_s_tot[$sizes_code[$s]]*$actual_plies);
						$balance_cut_qty_tot+=$balance_cut_qty;
						if ($balance_cut_qty_tot > 0) {
							echo "<td>".$balance_cut_qty."</td>";
						} else {
							echo "<td> 0 </td>";
						}
					}echo "<td>".$balance_cut_qty_tot."</td>";
					?>
				</tr>

			</table>
		</div>
		<div class='col-sm-4' >
			<table class="table table-bordered table-responsive">
					<tr>
						<th class='success'>Order Qty</th>
						<td><?php echo $order_qty_tot; ?></td>
						<td>100%</td>
					</tr>
					<tr>
						<th class='success'>Cut Qty</th>
						<td>
							<?php
								if ($cut_qty_total > $order_qty_tot)
								{
									echo $order_qty_tot;
								}
								else
								{
									echo $cut_qty_total;
								}
							?>
						</td>
						<td>
							<?php
								if ($act_cut_qty_tot == 0 )
								{
									echo "0";
								}
								else
								{
									echo round(($act_cut_qty_tot/$order_qty_tot)*100,2);
								}
							?>
							%
						</td>
					</tr>
					<tr>
						<th class='success'>Extra Cut</th>
						<td>
							<?php 
								if (($cut_qty_total - $o_total) > 0)
								{
									echo $cut_qty_total - $o_total;
								}
								else
								{
									echo "0";
								}
							?>
						</td>
						<td></td>
					</tr>		
			</table>
		</div>
		</div>
		<br>
		

				<?php
				if(isset($_POST['submit']))
				{
					$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
					$sql_result1=mysqli_query($link, $sql1) or exit("19".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result1)>0)
					{
							$size=sizeof($s_tit);
							$table='<div class="col-sm-12" style="overflow-x:scroll">
							<table class="table table-bordered table-responsive">';
							$tr1.='<tr><th></th><th></th>';
							$tr1.='<th colspan="'.$size.'" style="text-align:center">Size Ratios</th>';
							$tr1.='<th></th><th></th><th></th><th></th>';
							$tr1.='<th colspan="'.$size.'" style="text-align:center">Actual Cut details</th>';
							$tr1.='<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>';
							$table.=$tr1;
							echo $table;
							?>
							<tr class='info'>
							<th>Docket No</th>
							<th>Cut No</th>
							<?php
							for($s=0;$s<sizeof($s_tit);$s++)
							{
								echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
							}
							?>
							<th>Total of the size ratio</th>
							<th>Plan Plies</th>
							<th>Fabric Allocated plies</th>
							<th>Actual Plies</th>
							<?php
							for($s=0;$s<sizeof($s_tit);$s++)
							{
								echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
							}
							?>
							<th>Total</th>	
							<th>Cut Status</th>
							<th>Docket printed Date</th>
							<th>Cut Date</th>
							<th>Cut Dashboard </th>
							<th>Shift</th>
							<th>Input Stats</th>
							<th>Input <span style='mso-spacerun:yes'></span>Date(Minimum Date)</th>
							<th>Module<span style='mso-spacerun:yes'></span></th>
							<!--<th>Shift</th> -->
						</tr>
						<?php
							
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								$act_doc_no=$sql_row1['doc_no'];
								$act_cut_no=$sql_row1['acutno'];
								for($s=0;$s<sizeof($sizes_code);$s++)
								{
									$act_s[$sizes_code[$s]]=$sql_row1["p_s".$sizes_code[$s].""];
								}
								
								$act_total=array_sum($act_s);
								$plan_plies=$sql_row1['p_plies'];
								//to take plice from fabric_cad_allocation against doc_no
								$fabric_allocated_plies=0;
								
								$cut_status=$sql_row1['act_cut_status'];
								$manual_flag=$sql_row1['manual_flag'];
								if($cut_status=='DONE')
								{
									$actual_plies=$sql_row1['a_plies'];
									for($s=0;$s<sizeof($sizes_code);$s++)
									{
										$act_cut[$sizes_code[$s]]=$sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies'];
									}
									
									if(($actual_plies == $plan_plies) && $manual_flag==0)
									{
										$cut_status_new='Full Completed';
									}
									else if(($actual_plies <> $plan_plies) && $manual_flag==0)
									{
										$cut_status_new='Partially';
									}
									else if(($actual_plies <> $plan_plies) && $manual_flag==1)
									{
										$cut_status_new='Partially Completed';
									}
									else if($actual_plies==0 && $manual_flag==1)
									{
										$cut_status_new='Cancelled';
									}																			
								}
								else
								{
									$actual_plies=0	;
									for($s=0;$s<sizeof($sizes_code);$s++)
									{
										$act_cut[$sizes_code[$s]]=0;
									}
									$cut_status_new='Not Started';
								}
								
								$act_plies_total=array_sum($act_cut);
								$doc_date=$sql_row1['date'];
							
								$cut_date="";
								$cut_section="";
								$cut_shift="";
								
								$sql="select * from $bai_pro3.act_cut_status where doc_no=$act_doc_no";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row=mysqli_fetch_array($sql_result))
								{
									$cut_date=$sql_row['date'];
									$cut_id=$sql_row['section'];
									$cut_shift=$sql_row['shift'];
									$sql12="select tbl_name from $bai_pro3.tbl_cutting_table where tbl_id=$cut_id";
									$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row12=mysqli_fetch_array($sql_result12))
									{
										$cut_section=$sql_row12['tbl_name'];
									}

								}
								
								
								if($cut_date!="")
								{
									$cut_qty_total=$cut_qty_total+$act_total;
								}
								
								$input_date="";
								$input_module="";
								$input_shift="";
								$input_reported_qty=0;
							
								$sql_ims_log="SELECT min(ims_date) as ims_date,COALESCE(SUM(ims_qty),0) as qty,group_concat(distinct ims_mod_no ORDER BY ims_mod_no) as mod_no from  $bai_pro3.ims_combine where ims_doc_no=$act_doc_no";
								$sql_result_ims_log=mysqli_query($link, $sql_ims_log) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_ims_log=mysqli_fetch_array($sql_result_ims_log))
								{
									$input_date=$sql_row_ims_log['ims_date'];
									$input_module=$sql_row_ims_log['mod_no'];
									$input_reported_qty=$sql_row_ims_log['qty'];
								}

								if($act_total > 0)
								{
									if($input_reported_qty>0)
									{								
										if($act_total>$input_reported_qty)
										{
											$input_status="Partially Reported";	
										}
										else if($act_total<=$input_reported_qty)
										{
											$input_status="Fully Reported";		
										}
										else
										{
											$input_status="Not Yet Reported";	
										}
									}
									else
									{
										$input_status="Not Yet Reported";
									}
									
								}
								else
								{
									$input_status="Not Yet Reported";
								}

								if($input_date!="")
								{
									$input_qty_total=$input_qty_total+$act_total;
								}	
								echo "<tr>";
								echo "<td>".leading_zeros($act_doc_no,9)."</td>";
								echo "<td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>";
								
								for($s=0;$s<sizeof($s_tit);$s++)
								{
									echo "<td class=xl675113 style='border-top:none;border-left:none'>".$act_s[$sizes_code[$s]]."</td>";
								}	
								unset($act_s);
								echo "<td>$act_total</td>";
								echo "<td>$plan_plies</td>";
								echo "<td>$fabric_allocated_plies</td>";
								echo "<td>$actual_plies</td>";
								for($s=0;$s<sizeof($s_tit);$s++)
								{
									echo "<td class=xl675113 style='border-top:none;border-left:none'>".$act_cut[$sizes_code[$s]]."</td>";
								}	
								unset($act_cut);
								echo "<td>$act_plies_total</td>";
								echo "<td>$cut_status_new</td>";
								echo "<td>$doc_date</td>";
								echo "<td>$cut_date</td>";
								echo "<td>$cut_section</td>";
								echo "<td>$cut_shift</td>";
								echo "<td>$input_status</td>";
								echo "<td>$input_date</td>";
								echo "<td>$input_module</td>";
								// echo "<td>$input_shift</td>";
								echo "</tr>";
							
							}
					}
						?>
				 	</table>
					</div>
					<?php
				}
 
	}
}
?>	

</div><!-- panel body
</div><!-  panel -->
</div>