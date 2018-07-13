<?php 
$url1 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include("$url1");  
$url2 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'); 
include("$url2");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0013",$username,1,$group_id_sfcs); 
?>


<style id="Book5_10971_Styles">
th{ color : black;}
td{ color : black;}
.black{
	text-align : right;
	font-weight : bold;
	color : #000;
}
</style>



<script type='text/javascript'>
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

$(document).ready(function() {
	$('#schedule').on('mouseup',function(e){
		style = $('#style').val();
		if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
	});
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
	$('#category').on('mouseup',function(e){
		style = $('#style').val();
		schedule = $('#schedule').val();
		color = $('#color').val();
		if(style === 'NIL' && schedule === 'NIL' && color === 'NIL'){
			sweetAlert('Please Select Style, Schedule and Color','','warning');
		}
		else if(schedule === 'NIL' && color === 'NIL'){
			sweetAlert('Please Select Schedule and Color','','warning');
		}
		else if(color === 'NIL'){
			sweetAlert('Please Select Color','','warning');
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
	$('#submit').on('click',function(e){
		category = $('#category').val();
		if(category === 'NIL') {
			sweetAlert('Please Select Category','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});

});
</script>


<?php 
$url3 = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R');
include("$url3"); 
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
		<b>Style Status Report - Fabric Details</b>
	</div>
	<div class="panel-body">
		<form method="post" name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
			<div class="col-sm-2 form-group">
				<label for='style'>Select Style</label>
				<select required class='form-control' name='style' onchange='firstbox()' id='style'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					$sql="SELECT DISTINCT order_style_no FROM $bai_pro3.bai_orders_db JOIN $bai_pro3.cat_stat_log ON bai_orders_db.order_tid=cat_stat_log.order_tid and cat_stat_log.category<>\"\" order by bai_orders_db.order_style_no";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				<select required class='form-control' name='schedule' onchange='secondbox();' id='schedule'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";	
					$sql="SELECT DISTINCT order_del_no FROM $bai_pro3.bai_orders_db JOIN $bai_pro3.cat_stat_log ON bai_orders_db.order_tid=cat_stat_log.order_tid and cat_stat_log.category<>\"\" and bai_orders_db.order_style_no=\"$style\"";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			<div class="col-sm-2 form-group">
				<label for='color'>Select Color:</label>
				<select required class='form-control' name='color' onchange='thirdbox();' id='color'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					//$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
					$sql="SELECT DISTINCT order_col_des FROM $bai_pro3.bai_orders_db JOIN $bai_pro3.cat_stat_log ON bai_orders_db.order_tid=cat_stat_log.order_tid and cat_stat_log.category<>\"\" and bai_orders_db.order_style_no=\"$style\" and bai_orders_db.order_del_no=\"$schedule\"";
					mysqli_query($link, $sql) or exit();
					$sql_result=mysqli_query($link, $sql) or exit();
					$sql_num_check=mysqli_num_rows($sql_result);	
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)){
							echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
						}
						else{
							echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
						}
					}
				echo "</select>";
				?>
			</div>

			<?php		
				$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";

				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$order_tid=$sql_row['order_tid'];
				}
			?>
			<div class="col-sm-2">
				<label for='category'>Select Category:</label>
				<select required class='form-control' name='category' id='category'>
				<?php				
					$sql="select distinct category from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category<>\"\"";
					//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
					mysqli_query($link, $sql) or exit();
					//$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
					$sql_result=mysqli_query($link, $sql) or exit();
					$sql_num_check=mysqli_num_rows($sql_result);

					echo "<option value=\"NIL\" selected>NIL</option>";
						
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['category'])==str_replace(" ","",$category)){
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
				mysqli_query($link, $sql) or exit();
				$sql_result=mysqli_query($link, $sql) or exit();
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$mo_status=$sql_row['mo_status'];
				}
				if(($mo_status=="Y") && $category!="NIL")
				{
					echo "<br><b>MO Status:</b>"."<font color=GREEN size=5>".$mo_status."es</font>";
					echo "<input class='btn btn-success' type='submit' value='submit' name='submit' id='submit'>";	
				}
			?>
		</form>



<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$category=$_POST['category'];
	
	if($style!="NIL" && $color!="NIL" && $schedule!="NIL" && $category!="NIL"){
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	mysqli_query($link, $sql);
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	$sql_result=mysqli_query($link, $sql);
	//$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
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
		
		
	}	
	}else{
	echo"Please Select All Filters</br>";
	}
	
	$sql="select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category=\"$category\"";
	//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	mysqli_query($link, $sql) or exit();
	$sql_result=mysqli_query($link, $sql) or exit();
	//$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_id=$sql_row['tid'];
	}
	
	$sql="select sum(allocate_xs*plies) as \"a_s_xs\", sum(allocate_s*plies) as \"a_s_s\", sum(allocate_m*plies) as \"a_s_m\", sum(allocate_l*plies) as \"a_s_l\", sum(allocate_xl*plies) as \"a_s_xl\", sum(allocate_xxl*plies) as \"a_s_xxl\", sum(allocate_xxxl*plies) as \"a_s_xxxl\", sum(allocate_s01*plies) as \"a_s_s01\",sum(allocate_s02*plies) as \"a_s_s02\",sum(allocate_s03*plies) as \"a_s_s03\",sum(allocate_s04*plies) as \"a_s_s04\",sum(allocate_s05*plies) as \"a_s_s05\",sum(allocate_s06*plies) as \"a_s_s06\",sum(allocate_s07*plies) as \"a_s_s07\",sum(allocate_s08*plies) as \"a_s_s08\",sum(allocate_s09*plies) as \"a_s_s09\",sum(allocate_s10*plies) as \"a_s_s10\",sum(allocate_s11*plies) as \"a_s_s11\",sum(allocate_s12*plies) as \"a_s_s12\",sum(allocate_s13*plies) as \"a_s_s13\",sum(allocate_s14*plies) as \"a_s_s14\",sum(allocate_s15*plies) as \"a_s_s15\",sum(allocate_s16*plies) as \"a_s_s16\",sum(allocate_s17*plies) as \"a_s_s17\",sum(allocate_s18*plies) as \"a_s_s18\",sum(allocate_s19*plies) as \"a_s_s19\",sum(allocate_s20*plies) as \"a_s_s20\",sum(allocate_s21*plies) as \"a_s_s21\",sum(allocate_s22*plies) as \"a_s_s22\",sum(allocate_s23*plies) as \"a_s_s23\",sum(allocate_s24*plies) as \"a_s_s24\",sum(allocate_s25*plies) as \"a_s_s25\",sum(allocate_s26*plies) as \"a_s_s26\",sum(allocate_s27*plies) as \"a_s_s27\",sum(allocate_s28*plies) as \"a_s_s28\",sum(allocate_s29*plies) as \"a_s_s29\",sum(allocate_s30*plies) as \"a_s_s30\",sum(allocate_s31*plies) as \"a_s_s31\",sum(allocate_s32*plies) as \"a_s_s32\",sum(allocate_s33*plies) as \"a_s_s33\",sum(allocate_s34*plies) as \"a_s_s34\",sum(allocate_s35*plies) as \"a_s_s35\",sum(allocate_s36*plies) as \"a_s_s36\",sum(allocate_s37*plies) as \"a_s_s37\",sum(allocate_s38*plies) as \"a_s_s38\",sum(allocate_s39*plies) as \"a_s_s39\",sum(allocate_s40*plies) as \"a_s_s40\",sum(allocate_s41*plies) as \"a_s_s41\",sum(allocate_s42*plies) as \"a_s_s42\",sum(allocate_s43*plies) as \"a_s_s43\",sum(allocate_s44*plies) as \"a_s_s44\",sum(allocate_s45*plies) as \"a_s_s45\",sum(allocate_s46*plies) as \"a_s_s46\",sum(allocate_s47*plies) as \"a_s_s47\",sum(allocate_s48*plies) as \"a_s_s48\",sum(allocate_s49*plies) as \"a_s_s49\",sum(allocate_s50*plies) as \"a_s_s50\"
 		  from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref='$cat_id'";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
	
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			$a_s[$sizes_code[$s]]=$sql_row["a_s_s".$sizes_code[$s].""];
		}
		$a_total=array_sum($a_s);
		
	}	
		
	
	
	$fab_rec_total=0;
	$fab_ret_total=0;
	$damages_total=0;
	$shortages_total=0;
	$act_total_sum=0;
	


	$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$mk_ref=$sql_row1['mk_ref'];
		$a_plies=$sql_row['p_plies']; //20110911
		
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
		
		$fab_rec=0;
		$fab_ret=0;
		$damages=0;
		$shortages=0;
			
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


		$order_tid=$sql_row1['order_tid'];
		//Binding Consumption / YY Calculation
	
		$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$bind_con=$sql_row2['binding_con'];
		}
		
		$doc_req+=$act_total*$bind_con;
		
		//Binding Consumption / YY Calculation		
		
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
		
		
		unset($act_s);
	
	}


	
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
	
	$newyy2=$newyy/$new_order_qty;
	if($cat_yy>0){
		$savings_new=round((($cat_yy-$newyy2)/$cat_yy)*100,0);
	}
	if($act_total_sum>0){
		$act_con_summ=($fab_rec_total-$fab_ret_total)/$act_total_sum;
		$net_con_summ=($fab_rec_total-$fab_ret_total-$damages_total-$shortages_total)/$act_total_sum;
	}
	if($cat_yy>0){
		$act_con_summ_sav=round((($cat_yy-$act_con_summ)/$cat_yy)*100,0);
		$net_con_summ_sav=round((($cat_yy-$net_con_summ)/$cat_yy)*100,0);
	}	
?>
<hr>
<div class="col-sm-12 ">
	<div class="row">
			<h4>RMS Request Report</h4>
	</div><br>
	<div class="row">
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Style : </b></div>
			<div class="col-sm-6 "><p class='text-danger'><?php echo $style ?></p></div>
		</div>
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Schedule : </b></div>
			<div class="col-sm-6"><p class='text-danger'><?php echo $schedule ?></p></div>
		</div>
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Color : </b></div>
			<div class="col-sm-6"><p class='text-danger'><?php echo $color ?></p></div>
		</div>
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Category : </b></div>
			<div class="col-sm-6"><p class='text-danger'><?php echo $category ?></p></div>
		</div>
	</div>
</div>

<div class='col-sm-6' style='overflow-x:scroll'>
	<table class="table table-bordered table-responsive">
		<tr>
			<th class='danger'>Size</th>
			<?php
				for($s=0;$s<sizeof($s_tit);$s++){
						echo "<td class='danger'>".$s_tit[$sizes_code[$s]]."</td>";
					}
			?>
		</tr>
		<tr>
			<th class='danger'>Order Qty</th>
			<?php
				for($s=0;$s<sizeof($s_tit);$s++)
					{
						echo "<td>".$o_s[$sizes_code[$s]]."</td>";
					}
			?>
		</tr>
		<tr>
			<th class='danger'>Extra Cut</th>
			<?php
				for($s=0;$s<sizeof($s_tit);$s++)
					{
						echo "<td>".($a_s[$sizes_code[$s]]-$o_s[$sizes_code[$s]])."</td>";
					}
			?>
		</tr>		
	</table>
</div>


 <div class='col-sm-3'>
	<table class="table table-bordered table-responsive">
			<tr>
				<th class='success'>Ordering Consumption:</th>
				<td><?php echo $cat_yy; ?></td>
				<td>Saving</td>
			</tr>
			<tr>
				<th class='success'>CAD Consumption:</th>
				<td><?php  echo round($newyy2,4);  ?></td>
				<td><?php  echo $savings_new; ?>%</td>
			</tr>
			<tr>
				<th class='success'>Actual Consumption:</th>
				<td><?php echo round($act_con_summ,4);  ?></td>
				<td><?php echo $act_con_summ_sav; ?>% </td>
			</tr>	
			<tr>
				<th class='success'>Net Consumption:</th>
				<td><?php echo round($net_con_summ,4);  ?></td>
				<td><?php echo $net_con_summ_sav; ?>%</td>
			</tr>	
	</table>
</div>
<div class='col-sm-3'>
	<table class="table table-bordered table-responsive">
			<tr>
				<th class='success'>Ordered Fabric:</th>
				<td><?php echo round(($cat_yy*$o_total),0); ?></td>
			</tr> 
			<tr>
				<th class='success'>Allocated Fabric:</th>
				<td><?php echo round(($newyy2*$act_total_sum),0); ?></td>
			</tr>
			<tr>
				<th class='success'>Actual Utilization:</th>
				<td><?php echo round(($fab_rec_total-$fab_ret_total),0); ?></td>
			</tr>
			<tr>
				<th class='success'>Net Utilization:</th>
				<td><?php echo round(($fab_rec_total-$fab_ret_total-$damages_total-$shortages_total),0); ?></td>
			</tr>
			<tr>
				<th class='success'>Fabric Shortage:</th>
				<td><?php echo ($shortages_total); ?></td>
			</tr>
			<tr>
				<th class='success'>Fabric Damage:</th>
				<td><?php echo ($damages_total); ?></td>
			</tr>
	</table>
</div>


<?php 
 if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$category=$_POST['category'];
	
	if($style!="NIL" && $color!="NIL" && $schedule!="NIL" && $category!="NIL"){
 	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
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
		
		
	}	
	
	
	$sql="select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category=\"$category\"";
	// mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	mysqli_query($link, $sql) or exit();
	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	$sql_result=mysqli_query($link, $sql) or exit();
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_id=$sql_row['tid'];
	}
	
	$sql="select sum(allocate_xs*plies) as \"a_s_xs\", sum(allocate_s*plies) as \"a_s_s\", sum(allocate_m*plies) as \"a_s_m\", sum(allocate_l*plies) as \"a_s_l\", sum(allocate_xl*plies) as \"a_s_xl\", sum(allocate_xxl*plies) as \"a_s_xxl\", sum(allocate_xxxl*plies) as \"a_s_xxxl\", sum(allocate_s01*plies) as \"a_s_s01\",sum(allocate_s02*plies) as \"a_s_s02\",sum(allocate_s03*plies) as \"a_s_s03\",sum(allocate_s04*plies) as \"a_s_s04\",sum(allocate_s05*plies) as \"a_s_s05\",sum(allocate_s06*plies) as \"a_s_s06\",sum(allocate_s07*plies) as \"a_s_s07\",sum(allocate_s08*plies) as \"a_s_s08\",sum(allocate_s09*plies) as \"a_s_s09\",sum(allocate_s10*plies) as \"a_s_s10\",sum(allocate_s11*plies) as \"a_s_s11\",sum(allocate_s12*plies) as \"a_s_s12\",sum(allocate_s13*plies) as \"a_s_s13\",sum(allocate_s14*plies) as \"a_s_s14\",sum(allocate_s15*plies) as \"a_s_s15\",sum(allocate_s16*plies) as \"a_s_s16\",sum(allocate_s17*plies) as \"a_s_s17\",sum(allocate_s18*plies) as \"a_s_s18\",sum(allocate_s19*plies) as \"a_s_s19\",sum(allocate_s20*plies) as \"a_s_s20\",sum(allocate_s21*plies) as \"a_s_s21\",sum(allocate_s22*plies) as \"a_s_s22\",sum(allocate_s23*plies) as \"a_s_s23\",sum(allocate_s24*plies) as \"a_s_s24\",sum(allocate_s25*plies) as \"a_s_s25\",sum(allocate_s26*plies) as \"a_s_s26\",sum(allocate_s27*plies) as \"a_s_s27\",sum(allocate_s28*plies) as \"a_s_s28\",sum(allocate_s29*plies) as \"a_s_s29\",sum(allocate_s30*plies) as \"a_s_s30\",sum(allocate_s31*plies) as \"a_s_s31\",sum(allocate_s32*plies) as \"a_s_s32\",sum(allocate_s33*plies) as \"a_s_s33\",sum(allocate_s34*plies) as \"a_s_s34\",sum(allocate_s35*plies) as \"a_s_s35\",sum(allocate_s36*plies) as \"a_s_s36\",sum(allocate_s37*plies) as \"a_s_s37\",sum(allocate_s38*plies) as \"a_s_s38\",sum(allocate_s39*plies) as \"a_s_s39\",sum(allocate_s40*plies) as \"a_s_s40\",sum(allocate_s41*plies) as \"a_s_s41\",sum(allocate_s42*plies) as \"a_s_s42\",sum(allocate_s43*plies) as \"a_s_s43\",sum(allocate_s44*plies) as \"a_s_s44\",sum(allocate_s45*plies) as \"a_s_s45\",sum(allocate_s46*plies) as \"a_s_s46\",sum(allocate_s47*plies) as \"a_s_s47\",sum(allocate_s48*plies) as \"a_s_s48\",sum(allocate_s49*plies) as \"a_s_s49\",sum(allocate_s50*plies) as \"a_s_s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
	
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			$a_s[$sizes_code[$s]]=$sql_row["a_s_s".$sizes_code[$s].""];
		}

		$a_total=array_sum($a_s);
		
	}	
		
	
	
	
	$fab_rec_total=0;
	$fab_ret_total=0;
	$damages_total=0;
	$shortages_total=0;
	$act_total_sum=0;
	
	

	$sql1="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result1)>0)
	{
				echo "<div class='col-sm-12' style='overflow-x:scroll'>
	<table class='table table-sm table-bordered table-responsive'>
		<tr class='info'>
			<th>DocketNo</th>
			<th>Cut No</th>
			<th>Total</th>
			<th>Cut Status</th>
			<th>Input Status</th>
			<th>Docket Requested</th>
			<th>Fabric Received</th>
			<th>Fabric Returned</th>
			<th>Damages</th>
			<th>Shortages</th>
			<th>Net Utlization</th>
			<th>Ordering Consumption</th>
			<th>Actual Consumption</th>
			<th>Net Consumption</th>
			<th>Actual Saving</th>
			<th>Pct</th>
			<th>Net Saving</th>
			<th>Pct</th>
		</tr>";
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{

		
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			$act_s[$sizes_code[$s]]=$sql_row1["a_s".$sizes_code[$s].""]*$sql_row1['a_plies'];
		}	
		$act_doc_no=$sql_row1['doc_no'];
		$act_cut_no=$sql_row1['acutno'];
		


		$act_total=array_sum($act_s);
		$cut_status=$sql_row1['act_cut_status'];
		$input_status=$sql_row1['act_cut_issue_status'];
		$doc_date=$sql_row1['date'];
		$mk_ref=$sql_row1['mk_ref'];
		$a_plies=$sql_row1['p_plies']; //20110911
		
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
		
		$fab_rec=0;
		$fab_ret=0;
		$damages=0;
		$shortages=0;
		
		
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
		
		$order_tid=$sql_row1['order_tid'];
		//Binding Consumption / YY Calculation
	
		$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$bind_con=$sql_row2['binding_con'];
		}
		
		$doc_req+=$act_total*$bind_con;
		
		//Binding Consumption / YY Calculation
		
		
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
		$act_saving_pct=round((($cat_yy-$act_con)/$cat_yy)*100,0);
		$net_saving=round(($cat_yy*$act_total)-($net_con*$act_total),1);
		$net_saving_pct=round((($cat_yy-$net_con)/$cat_yy)*100,0);

		echo "<tr>";
		echo "<td>".leading_zeros($act_doc_no,9)."</td>";
		echo "<td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>";
		echo "<td>$act_total</td>";
		echo "<td>$cut_status</td>";
		echo "<td>$input_status</td>";
		echo "<td>".($doc_req+round($doc_req*0.01,2))."</td>";
		echo "<td>$fab_rec</td>";
		echo "<td>$fab_ret</td>";
		echo "<td>$damages</td>";
		echo "<td>$shortages</td>";
		echo "<td>$net_util</td>";
		echo "<td>$cat_yy</td>";
		echo "<td>$act_con</td>";
		echo "<td>$net_con</td>";
		echo "<td>$act_saving</td>";
		echo "<td>$act_saving_pct%</td>";
		echo "<td>$net_saving</td>";
		echo "<td>$net_saving_pct%</td>";
		echo "</tr>";
	}
		echo "	</table></div>";

	}
	else
	{
		echo "<h4>No Data Found</h4>";
	}
  }
 }
}//closing isset(POST) 
?>

</div><!-- panel body -->
</div><!--  panel -->
</div>

 