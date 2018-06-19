<?php 
$url1 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include("$url1");  
$url2 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'); 
include("$url2");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0012",$username,1,$group_id_sfcs); 
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
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
}


function secondbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
function fourthbox()
{
	window.location.href ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&category="+document.test.category.value
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
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
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
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
		
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
			}


			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$n_s[$sizes_code[$s]]=$sql_row["old_order_s_s".$sizes_code[$s].""];
			}


			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
				{
					$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
				}	
			}


			$o_total=array_sum($o_s);
			$order_tid=$sql_row['order_tid'];
			$color_code=$sql_row['color_code'];
			$customer=$sql_row['order_div'];
			
			
		}	
		
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
		
		$sql="select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category=\"$category\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cat_id=$sql_row['tid'];
		}
		
		$sql="select sum(allocate_xs*plies) as \"a_s_xs\", sum(allocate_s*plies) as \"a_s_s\", sum(allocate_m*plies) as \"a_s_m\", sum(allocate_l*plies) as \"a_s_l\", sum(allocate_xl*plies) as \"a_s_xl\", sum(allocate_xxl*plies) as \"a_s_xxl\", sum(allocate_xxxl*plies) as \"a_s_xxxl\", sum(allocate_s01*plies) as \"a_s_s01\", sum(allocate_s02*plies) as \"a_s_s02\", sum(allocate_s03*plies) as \"a_s_s03\", sum(allocate_s04*plies) as \"a_s_s04\", sum(allocate_s05*plies) as \"a_s_s05\", sum(allocate_s06*plies) as \"a_s_s06\", sum(allocate_s07*plies) as \"a_s_s07\", sum(allocate_s08*plies) as \"a_s_s08\", sum(allocate_s09*plies) as \"a_s_s09\", sum(allocate_s10*plies) as \"a_s_s10\", sum(allocate_s11*plies) as \"a_s_s11\", sum(allocate_s12*plies) as \"a_s_s12\", sum(allocate_s13*plies) as \"a_s_s13\", sum(allocate_s14*plies) as \"a_s_s14\", sum(allocate_s15*plies) as \"a_s_s15\", sum(allocate_s16*plies) as \"a_s_s16\", sum(allocate_s17*plies) as \"a_s_s17\", sum(allocate_s18*plies) as \"a_s_s18\", sum(allocate_s19*plies) as \"a_s_s19\", sum(allocate_s20*plies) as \"a_s_s20\", sum(allocate_s21*plies) as \"a_s_s21\", sum(allocate_s22*plies) as \"a_s_s22\", sum(allocate_s23*plies) as \"a_s_s23\", sum(allocate_s24*plies) as \"a_s_s24\", sum(allocate_s25*plies) as \"a_s_s25\", sum(allocate_s26*plies) as \"a_s_s26\", sum(allocate_s27*plies) as \"a_s_s27\", sum(allocate_s28*plies) as \"a_s_s28\", sum(allocate_s29*plies) as \"a_s_s29\", sum(allocate_s30*plies) as \"a_s_s30\", sum(allocate_s31*plies) as \"a_s_s31\", sum(allocate_s32*plies) as \"a_s_s32\", sum(allocate_s33*plies) as \"a_s_s33\", sum(allocate_s34*plies) as \"a_s_s34\", sum(allocate_s35*plies) as \"a_s_s35\", sum(allocate_s36*plies) as \"a_s_s36\", sum(allocate_s37*plies) as \"a_s_s37\", sum(allocate_s38*plies) as \"a_s_s38\", sum(allocate_s39*plies) as \"a_s_s39\", sum(allocate_s40*plies) as \"a_s_s40\", sum(allocate_s41*plies) as \"a_s_s41\", sum(allocate_s42*plies) as \"a_s_s42\", sum(allocate_s43*plies) as \"a_s_s43\", sum(allocate_s44*plies) as \"a_s_s44\", sum(allocate_s45*plies) as \"a_s_s45\", sum(allocate_s46*plies) as \"a_s_s46\", sum(allocate_s47*plies) as \"a_s_s47\", sum(allocate_s48*plies) as \"a_s_s48\", sum(allocate_s49*plies) as \"a_s_s49\", sum(allocate_s50*plies) as \"a_s_s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{		
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$a_s[$sizes_code[$s]]=$sql_row["a_s_s".$sizes_code[$s].""];
				//echo $sql_row["a_s_s".$sizes_code[$s].""]."<br>";
			}
			$a_total=array_sum($a_s);			
		}
		
		
		$cut_qty_total=0;
		$input_qty_total=0;
		
		
		$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$act_doc_no=$sql_row1['doc_no'];
			$act_cut_no=$sql_row1['acutno'];
			
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$act_s[$sizes_code[$s]]=$sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies'];
			}
					
			$act_total=array_sum($act_s);
			$cut_status=$sql_row1['act_cut_status'];
			$input_status=$sql_row1['act_cut_issue_status'];
			$doc_date=$sql_row1['date'];
			
				$cut_date="";
				$cut_section="";
				$cut_shift="";
			
			$sql="select * from $bai_pro3.act_cut_status where doc_no=$act_doc_no";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$cut_date=$sql_row['date'];
				$cut_section=$sql_row['section'];
				$cut_shift=$sql_row['shift'];
			}
			
			if($cut_date!="")
			{
				$cut_qty_total=$cut_qty_total+$act_total;
			}
			unset($act_s);
				$input_date="";
				$input_module="";
				$input_shift="";
			
			$sql="select * from $bai_pro3.act_cut_issue_status where doc_no=$act_doc_no";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$input_date=$sql_row['date'];
				$input_module=$sql_row['mod_no'];
				$input_shift=$sql_row['shift'];
			}
			
			if($input_date!="")
			{
				$input_qty_total=$input_qty_total+$act_total;
			}
			
			unset($act_s);
		}
		?>
		
				<div class="row">
						<h4>RMS Request Report</h4>
				</div>

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

					<th class='danger' style="width:100px;">Size</th>
					<?php
						for($s=0;$s<sizeof($s_tit);$s++){
								echo "<td class='danger'>".$s_tit[$sizes_code[$s]]."</td>";
							}
					?>
				</tr>
				<tr>
					<th class='danger'  style="width:100px;">Size</th>
					<?php
						for($s=0;$s<sizeof($s_tit);$s++)
							{
								echo "<td>".$o_s[$sizes_code[$s]]."</td>";
							}
					?>
				</tr>
				<tr>
					<th class='danger' style="width:100px;">Extra Cut</th>
					<?php
						for($s=0;$s<sizeof($s_tit);$s++)
							{
								echo "<td>".($a_s[$sizes_code[$s]]-$o_s[$sizes_code[$s]])."</td>";
							}
					?>
				</tr>		
			</table>
		</div>
		<div class='col-sm-4' >
			<table class="table table-bordered table-responsive">
					<tr>
						<th class='success'>Size</th>
						<td><?php echo $o_total; ?></td>
						<td>100%</td>
					</tr>
					<tr>
						<th class='success'>Size</th>
						<td><?php  echo $cut_qty_total;  ?></td>
						<td><?php if($o_total>0){echo  round(($cut_qty_total/$o_total)*100,0); }?>%</td>
					</tr>
					<tr>
						<th class='success'>Extra Cut</th>
						<td><?php echo $input_qty_total;  ?></td>
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
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result1)>0)
					{

							?>
							<div class='col-sm-12' style='overflow-x:scroll'>
							<table class='table table-bordered table-responsive'>
							<tr class='info'>
							<th>Docket No</th>
							<th>Cut No</th>
							<?php
							for($s=0;$s<sizeof($s_tit);$s++)
								{
									echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
								}
							?>
							<th>Total</th>
							<th>Cut Status</th>
							<th>Docket Date</th>
							<th>Cut Date</th>
							<th>Section</th>
							<th>Shift</th>
							<th>Input Stats</th>
							<th>Input <span style='mso-spacerun:yes'></span>Date</th>
							<th>Module<span style='mso-spacerun:yes'></span></th>
							<th>Shift</th>
						</tr>
				<?php
					
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$act_doc_no=$sql_row1['doc_no'];
						$act_cut_no=$sql_row1['acutno'];
						for($s=0;$s<sizeof($sizes_code);$s++)
						{
							$act_s[$sizes_code[$s]]=$sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies'];
						}
						
						$act_total=array_sum($act_s);
						$cut_status=$sql_row1['act_cut_status'];
						$input_status=$sql_row1['act_cut_issue_status'];
						$doc_date=$sql_row1['date'];
						
							$cut_date="";
							$cut_section="";
							$cut_shift="";
						
						$sql="select * from $bai_pro3.act_cut_status where doc_no=$act_doc_no";
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$cut_date=$sql_row['date'];
							$cut_section=$sql_row['section'];
							$cut_shift=$sql_row['shift'];
						}
						
						if($cut_date!="")
						{
							$cut_qty_total=$cut_qty_total+$act_total;
						}
						
							$input_date="";
							$input_module="";
							$input_shift="";
						
						$sql="select * from $bai_pro3.act_cut_issue_status where doc_no=$act_doc_no";
						
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$input_date=$sql_row['date'];
							$input_module=$sql_row['mod_no'];
							$input_shift=$sql_row['shift'];
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
					echo "<td>$cut_status</td>";
					echo "<td>$doc_date</td>";
					echo "<td>$cut_date</td>";
					echo "<td>$cut_section</td>";
					echo "<td>$cut_shift</td>";
					echo "<td>$input_status</td>";
					echo "<td>$input_date</td>";
					echo "<td>$input_module</td>";
					echo "<td>$input_shift</td>";
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

