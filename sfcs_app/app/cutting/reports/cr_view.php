
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',3,'R'));
// $view_access=user_acl("SFCS_0005",$username,1,$group_id_sfcs); 
?>


<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">


<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="../common/filelist.xml">


<script>

function firstbox()
{
	console.log('Hello');
	var ajax_url ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
	Ajaxify(ajax_url,'report_body'); 
}

function secondbox()
{
	var ajax_url ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	Ajaxify(ajax_url,'report_body'); 
}

function thirdbox()
{
	var ajax_url ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
	Ajaxify(ajax_url,'report_body'); 
}

function fourthbox()
{
	var ajax_url ="<?php echo 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&category="+document.test.category.value;
	Ajaxify(ajax_url,'report_body'); 
}


$(document).ready(function() {
	$('#schedule').on('mouseup',function(e){
		style = $('#style').val();
		if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
	});
});

$(document).ready(function() {
	$('#color').on('mouseup',function(e){
		style = $('#style').val();
		schedule = $('#schedule').val();
		if(style === 'NIL' && schedule === 'NIL'){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
		else if(schedule === 'NIL'){
			sweetAlert('Please Select Schedule','','warning');
		}
	});
});

$(document).ready(function() {
	$('#category').on('mouseup',function(e){
		style = $('#color').val();
		if(style === 'NIL'){
			sweetAlert('Please Select Style,schedule and color','','warning');
		}
	});
});
</script>

<style>
	.right{
		text-align : right;
		font-weight : bold;
	}
	.const td{
		width : 20%;
	}
	td{
		color : #000;
	}
</style>


<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/header_scripts.php',1,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/menu_content.php',1,'R')); ?>

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



//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<span style="float"><b>Consumption Report</b></span>
	</div>
	<div class="panel-body">
		<form name="test" action="index.php?r=<?= $_GET['r'] ?>" method="post">
			<div class="col-sm-2 form-group">
				<label for='style'>Select Style</label>
				<?php
				echo "<select class='form-control' name=\"style\" onchange=\"firstbox()\" id='style'>";
				echo "<option value=\"NIL\" selected>Select</option>";
				//$sql="select distinct order_style_no from bai_orders_db";
				$sql="SELECT DISTINCT order_style_no FROM $bai_pro3.bai_orders_db bd JOIN $bai_pro3.cat_stat_log cl ON bd.order_tid=cl.order_tid and cl.category<>\"\" order by bd.order_style_no";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);

				while($sql_row=mysqli_fetch_array($sql_result))
				{
					if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
					{
						echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
					}else{
						echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
					}
				}
				echo "</select>";
				?>
			</div>
			<div class="col-sm-2 form-group">
				<label for="schedule"> Select Schedule</label>
				<?php
				echo "<select class='form-control' name=\"schedule\" onchange=\"secondbox();\" id='schedule'>";
				echo "<option value=\"NIL\" selected>Select</option>";	
				//$sql="select distinct order_del_no from bai_orders_db where order_style_no=\"$style\"";
				$sql="SELECT DISTINCT order_del_no FROM $bai_pro3.bai_orders_db bd JOIN cat_stat_log cl ON bd.order_tid=cl.order_tid and cl.category<>\"\" and bd.order_style_no=\"$style\"";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
					{
						echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
					}else{
						echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
					}
				}
				echo "</select>";
				?>
			</div>
			<div class='col-sm-2 form-group'>
				<label for='color'>Select Color</label>
				<?php
				echo "<select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color'>";
				//$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
				$sql="SELECT DISTINCT order_col_des FROM $bai_pro3.bai_orders_db bd JOIN cat_stat_log cl ON bd.order_tid=cl.order_tid and cl.category<>\"\" and bd.order_style_no=\"$style\" and bd.order_del_no=\"$schedule\"";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);

				echo "<option value=\"NIL\" selected>Select</option>";
			
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
					{
						echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
					}else{
						echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
					}
				}
		echo "</select>";
		?>
		</div>
		<?php
			$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$order_tid=$sql_row['order_tid'];
			}
	
		?>
		<div class="col-sm-2"> 
			<label for='category'>Select Category</label>
			<?php
			echo "<select class='form-control' name=\"category\" onchange='fourthbox();' id='category'>";
			$sql="select distinct category from cat_stat_log where order_tid=\"$order_tid\" and category<> '' ";
	
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>Select</option>";
				
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				if(str_replace(" ","",$sql_row['category'])==str_replace(" ","",$category))
				{
					echo "<option value=\"".$sql_row['category']."\" selected>".$sql_row['category']."</option>";
				}else{
					echo "<option value=\"".$sql_row['category']."\">".$sql_row['category']."</option>";
				}
			}
			echo "</select>";
			?>
		</div>


		<?php
	
		$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category<>\"\"";
		//echo $sql;
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$mo_status=$sql_row['mo_status'];
		}

		if($mo_status=="Y" && $category!="NIL")
		{
			echo "<div class='col-sm-2'><br>";
			echo "MO Status:"."<font color=GREEN size=5>".$mo_status."es</font>";
			echo "</div>";
			echo "<div class='col-sm-1'><br>";
			echo "<input class='btn btn-success' type='submit' value='submit' name='submit'>";
			echo "</div>";	
		}
		?>
		</form>
		<br><br>

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$category=$_POST['category'];
    
    if ($style=='NIL' or $color=='NIL' or $schedule=='NIL' or $category=='NIL') {
    	echo "<div class='alert alert-danger'><strong>Warning!</strong> Please Select all Values</div>";
    } else {
    	# code...
    // }
    

	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	// mysqli_query($link, $sql) or exit("Sql Error testing".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		//($o_s_xs+$o_s_s+$o_s_m+$o_s_l+$o_s_xl+$o_s_xxl+$o_s_xxxl+$o_s_s08+$o_s_s10+$o_s_s12+$o_s_s14+$o_s_s16+$o_s_s18+$o_s_s20+$o_s_s22+$o_s_s24+$o_s_s26+$o_s_s28);
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
	
	$sql="select sum(allocate_s01*plies) as \"a_s_s01\", sum(allocate_s02*plies) as \"a_s_s02\", sum(allocate_s03*plies) as \"a_s_s03\", sum(allocate_s04*plies) as \"a_s_s04\", sum(allocate_s05*plies) as \"a_s_s05\", sum(allocate_s06*plies) as \"a_s_s06\", sum(allocate_s07*plies) as \"a_s_s07\", sum(allocate_s08*plies) as \"a_s_s08\", sum(allocate_s09*plies) as \"a_s_s09\", sum(allocate_s10*plies) as \"a_s_s10\", sum(allocate_s11*plies) as \"a_s_s11\", sum(allocate_s12*plies) as \"a_s_s12\", sum(allocate_s13*plies) as \"a_s_s13\", sum(allocate_s14*plies) as \"a_s_s14\", sum(allocate_s15*plies) as \"a_s_s15\", sum(allocate_s16*plies) as \"a_s_s16\", sum(allocate_s17*plies) as \"a_s_s17\", sum(allocate_s18*plies) as \"a_s_s18\", sum(allocate_s19*plies) as \"a_s_s19\", sum(allocate_s20*plies) as \"a_s_s20\", sum(allocate_s21*plies) as \"a_s_s21\", sum(allocate_s22*plies) as \"a_s_s22\", sum(allocate_s23*plies) as \"a_s_s23\", sum(allocate_s24*plies) as \"a_s_s24\", sum(allocate_s25*plies) as \"a_s_s25\", sum(allocate_s26*plies) as \"a_s_s26\", sum(allocate_s27*plies) as \"a_s_s27\", sum(allocate_s28*plies) as \"a_s_s28\", sum(allocate_s29*plies) as \"a_s_s29\", sum(allocate_s30*plies) as \"a_s_s30\", sum(allocate_s31*plies) as \"a_s_s31\", sum(allocate_s32*plies) as \"a_s_s32\", sum(allocate_s33*plies) as \"a_s_s33\", sum(allocate_s34*plies) as \"a_s_s34\", sum(allocate_s35*plies) as \"a_s_s35\", sum(allocate_s36*plies) as \"a_s_s36\", sum(allocate_s37*plies) as \"a_s_s37\", sum(allocate_s38*plies) as \"a_s_s38\", sum(allocate_s39*plies) as \"a_s_s39\", sum(allocate_s40*plies) as \"a_s_s40\", sum(allocate_s41*plies) as \"a_s_s41\", sum(allocate_s42*plies) as \"a_s_s42\", sum(allocate_s43*plies) as \"a_s_s43\", sum(allocate_s44*plies) as \"a_s_s44\", sum(allocate_s45*plies) as \"a_s_s45\", sum(allocate_s46*plies) as \"a_s_s46\", sum(allocate_s47*plies) as \"a_s_s47\", sum(allocate_s48*plies) as \"a_s_s48\", sum(allocate_s49*plies) as \"a_s_s49\", sum(allocate_s50*plies) as \"a_s_s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		//($a_s_xs+$a_s_s+$a_s_m+$a_s_l+$a_s_xl+$a_s_xxl+$a_s_xxxl+$a_s_s08+$a_s_s10+$a_s_s12+$a_s_s14+$a_s_s16+$a_s_s18+$a_s_s20+$a_s_s22+$a_s_s24+$a_s_s26+$a_s_s28);
		
	}	

	$fab_rec_total=0;
	$fab_ret_total=0;
	$damages_total=0;
	$shortages_total=0;
	$act_total_sum=0;
	

	$act_s=array();
	$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
	//echo $sql1."<br>";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$act_doc_no=$sql_row1['doc_no'];
		$act_cut_no=$sql_row1['acutno'];
		$a_plies=$sql_row1['p_plies']; //20110911
		
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			//echo $sizes_code[$s]."<br>";
			$act_s[$sizes_code[$s]]+=$sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies'];
			//echo $sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies']."<br>";
		}		
		

		$act_total=array_sum($act_s);
		//$act_s01+$act_s02+$act_s03+$act_s04+$act_s05+$act_s06+$act_s07+$act_s08+$act_s09+$act_s10+$act_s11+$act_s12+$act_s13+$act_s14+$act_s15+$act_s16+$act_s17+$act_s18+$act_s19+$act_s20+$act_s21+$act_s22+$act_s23+$act_s24+$act_s25+$act_s26+$act_s27+$act_s28+$act_s29+$act_s30+$act_s31+$act_s32+$act_s33+$act_s34+$act_s35+$act_s36+$act_s37+$act_s38+$act_s39+$act_s40+$act_s41+$act_s42+$act_s43+$act_s44+$act_s45+$act_s46+$act_s47+$act_s48+$act_s49+$act_s50;
		//$act_total=$act_s01+$act_s02+$act_s03+$act_s04+$act_s05+$act_s06+$act_s07+$act_s08+$act_s09+$act_s10+$act_s11+$act_s12+$act_s13+$act_s14+$act_s15+$act_s16+$act_s17+$act_s18+$act_s19+$act_s20+$act_s21+$act_s22+$act_s23+$act_s24+$act_s25+$act_s26+$act_s27+$act_s28+$act_s29+$act_s30+$act_s31+$act_s32+$act_s33+$act_s34+$act_s35+$act_s36+$act_s37+$act_s38+$act_s39+$act_s40+$act_s41+$act_s42+$act_s43+$act_s44+$act_s45+$act_s46+$act_s47+$act_s48+$act_s49+$act_s50;
		$cut_status=$sql_row1['act_cut_status'];
		$input_status=$sql_row1['act_cut_issue_status'];
		$doc_date=$sql_row1['date'];
		$mk_ref=$sql_row1['mk_ref'];
		
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
	
		/* NEW */		
		
	$sql="select * from $bai_pro3.act_cut_status where doc_no=$act_doc_no";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$fab_rec=$sql_row['fab_received'];
		$fab_ret=$sql_row['fab_returned'];
		$damages=round($sql_row['damages'],2);
		$shortages=round($sql_row['shortages'],2);
	
	}
	
	$fab_rec_total=$fab_rec_total+$fab_rec;
	$fab_ret_total=$fab_ret_total+$fab_ret;
	$damages_total=$damages_total+$damages;
	$shortages_total=$shortages_total+$shortages;
	$act_total_sum=$act_total_sum+$act_total;
	
		
		$sql2="select mklength from $bai_pro3.maker_stat_log where tid=$mk_ref";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$mk_length=$sql_row2['mklength'];
		}
		
		$doc_req=$mk_length*$a_plies;
		
		
		$sql11="select * from $bai_pro3.cat_stat_log where tid=$cat_id";
		mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$cat_yy=$sql_row11['catyy'];
		}	
	
		$net_util=$fab_rec-$fab_ret-$damages-$shortages;
		$act_con=round(($fab_rec-$fab_ret)/$act_total,4);
		$net_con=round($net_util/$act_total,4);
		$act_saving=round(($cat_yy*$act_total)-($act_con*$act_total),1);
		$act_saving_pct=round((($cat_yy-$act_con)/$cat_yy)*100,1);
		$net_saving=round(($cat_yy*$act_total)-($net_con*$act_total),1);
		$net_saving_pct=round((($cat_yy-$net_con)/$cat_yy)*100,1);	
	}

	echo "</table>";

	/* NEW */
	
	/* NEW 2010-05-22 */
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select * from $bai_pro3.maker_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";

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
	
	$sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty=$sql_row2['sum'];
	}
	
	//Binding Consumption / YY Calculation
	
	$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$bind_con=$sql_row2['binding_con'];
	}
	
	$newyy+=($new_order_qty*$bind_con);
	
	//Binding Consumption / YY Calculation
	$newyy2=0;
	if($new_order_qty > 0)
	{
		$newyy2=$newyy/$new_order_qty;
	}
	$savings_new=0;
	if($cat_yy > 0)
	{
		$savings_new=round((($cat_yy-$newyy2)/$cat_yy)*100,0);
	}
	$act_con_summ=0;
	$net_con_summ=0;
	if($act_total_sum > 0)
	{
		$act_con_summ=($fab_rec_total-$fab_ret_total)/$act_total_sum;
		$net_con_summ=($fab_rec_total-$fab_ret_total-$damages_total-$shortages_total)/$act_total_sum;
	}
	$act_con_summ_sav=0;
	$net_con_summ_sav=0;
	if($cat_yy > 0)
	{
		$act_con_summ_sav=round((($cat_yy-$act_con_summ)/$cat_yy)*100,0);
		$net_con_summ_sav=round((($cat_yy-$net_con_summ)/$cat_yy)*100,0);	
	}
	
// }
	?>
	<!--
	<div class="col-sm-12">
		<div class="col-sm-5">
			<div class="row">
				<div class="col-sm-3">Style : </div>
				<div class="col-sm-2"><?php echo $style; ?></div>
			</div>
			<div class="row">
				<div class="col-sm-3">Schedule : </div>
				<div class="col-sm-2"><?php echo $schedule; ?></div>
			</div>
			<div class="row">
				<div class="col-sm-3">Color : </div>
				<div class="col-sm-2"><?php echo $color; ?></div>
			</div>
			<div class="row">
				<div class="col-sm-3">Category : </div>
				<div class="col-sm-2"><?php echo $category ?></div>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="row">
				<div class="col-sm-3">Order Consumption : </div>
				<div class="col-sm-2"><?php echo $cat_yy; ?> Saving </div>
			</div>
			<div class="row">
				<div class="col-sm-3">CAD Consumption : </div>
				<div class="col-sm-2"><?php echo round($newyy2,4); ?> <?php echo $savings_new; ?>%</div>
			</div>
			<div class="row">
				<div class="col-sm-3">Actual Consumption : </div>
				<div class="col-sm-2"><?php echo round($act_con_summ,4); ?><?php echo $act_con_summ_sav; ?>%</div>
			</div>
		</div>
	</div>
	-->

<table class="table table-bordered table-responsive">
	<tr>
		<td colspan='5' class='info'><b>Consumption Report</b></td>
	</tr>
	<tr class='const'>
		<td class='right'>Style :</td>
		<td><?php echo $style; ?></td>
		<td class='right'>Order Consumption :</td>
		<td><?php echo $cat_yy; ?></td>
		<td>Saving</td>
	</tr>
	<tr class='const'>
		<td class='right'>Schedule : </td>
		<td><?php echo $schedule; ?></td>
		<td class='right'>CAD Consumption : </td>
		<td><?php echo round($newyy2,4); ?></td>
		<td><?php echo $savings_new; ?>%</td>
	</tr>
	<tr class='const'>
		<td class='right'>Color : </td>
		<td><?php echo $color; ?></td>
		<td class='right'>Actual Consumption : </td>
		<td><?php echo round($act_con_summ,4); ?></td>
		<td><?php echo $act_con_summ_sav; ?>%</td>
	</tr>
	<tr class='const'>
		<td class='right'>Category : </td>
		<td><?php echo $category ?></td>
		<!-- <td class='right'>Actual Consumption</td>
		<td><?php echo round($act_con_summ,4); ?></td>
		<td><?php echo $act_con_summ_sav; ?>%</td> -->
	</tr>
</table>
<table class="table table-bordered table-responsive table-sm table-hover">
	<tr>
		<td class='danger'><b>Size</b></td>
		<?php
		for($s=0;$s<sizeof($s_tit);$s++){
			echo "<td>".$s_tit[$sizes_code[$s]]."</td>";
		}
	?>
	</tr>
	<tr>
		<td class='danger'><b>Order Quantity</b></td>
		<?php
			for($s=0;$s<sizeof($s_tit);$s++){
				echo "<td>".$o_s[$sizes_code[$s]]."</td>";
			}	
		?>
	</tr>
	<tr>
		<td class='danger'><b>Extra Cut</b></td>
		<?php
		for($s=0;$s<sizeof($s_tit);$s++){
				if($a_s[$sizes_code[$s]] >$o_s[$sizes_code[$s]]){
				echo "<td>".($a_s[$sizes_code[$s]]-$o_s[$sizes_code[$s]])."</td>";
				}
				else
				{
					echo "<td>0</td>";
				}
			}
		?>
	</tr>
</table>

<?php
		}
	}
?>

	</div><!--panel body -->
	</div><!-- panel -->
</div>