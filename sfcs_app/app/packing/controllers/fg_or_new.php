<?php

//CR#198 /kirang / 2014-11-26 /Added cutting, packing and fg in source departments

//CR#198 /kirang / 2014-12-05 /Capturing the Docket and Recut Docket no of selected Style,Schedule and Color

?>

<?php
	// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
	include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));
	include("../".getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
	include("../".getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));
	$view_access=user_acl("SFCS_0118",$username,1,$group_id_sfcs); 
?>


<script>
	function qty_update(org_qty, id)
	{
		var update_qty = $('#update_qty_'+id).val();
		if(update_qty > org_qty || update_qty == 0){
			sweetAlert('Update quantity should greater than 0 and Excess cut.','','warning');
			$('#update_qty_'+id).val(org_qty);
		}
		
	}
	function fill_up(qty_size)
	{
		var flag = false;
		console.log(qty_size);
		var sourceid=document.getElementById('sourceid').value;
		var source=document.getElementById('source').value;

		// if(flag){
		if(sourceid=='' || source=='')
		{
			sweetAlert('Please Fill The Mandatory Fields','','warning');
			return false;
		}
		else
		{
			for (let index = 0; index < qty_size; index++) {
				if($('#update_qty_'+index).val() > 0){
					flag = true;
					return true;
				}else{
					flag = false;
				}	
			}
			// return true;
			if(flag){
				return true;
			}else{
				sweetAlert('Please enter update quantity for any one size','','warning');
				return false;
			}
		}
		// }
		
	}
	function check_all()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
		var color=document.getElementById('color').value;
		if(style=='NIL' || sch=='NIL' || color=='NIL')
		{
			sweetAlert('Please Enter style ,Schedule and Color','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
	function check_sch()
	{
		var style=document.getElementById('style').value;
		if(style=='NIL' )
		{
			sweetAlert('Please Enter Style First','','warning');
			return false;
		}
		else
		{
			return true;
		}

	}
	function check_sch_sty()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
		if(style=='NIL' )
		{
			sweetAlert('Please Enter Style First','','warning');
			return false;
		}
		else if(sch=='NIL')
		{
			sweetAlert('Please Enter Schedule ','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}

</script>

<script>
	var url = '<?= getFullURL($_GET['r'],'fg_or_new.php','N'); ?>';
	console.log(url);
	function firstbox()
	{
		window.location.href = url+"&style="+document.test.style.value;
	}

	function secondbox()
	{
		window.location.href = url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	}

	function thirdbox()
	{
		window.location.href = url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
		var url001 = url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
	}
</script>
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>



<body>

<?php 
	include("../".getFullURLLevel($_GET['r'], "common/config/m3_bulk_or_proc.php", 3, "R")); 
?>


<?php

if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	$module=$_POST['module'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$color=$_GET['color'];
}


//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
<div class="panel-heading">Good Panel/Garments Entry Form</div>
<div class="panel-body">
<div class="row">
<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
<?php

echo "<div class='col-md-3'><label>Select Style: </label><select name=\"style\" id=\"style\" onchange=\"firstbox();\" class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm where LENGTH(style_id)>0 order by order_style_no";	
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

echo "<div class='col-md-3'><label>Select Schedule: </label><select name=\"schedule\" id=\"schedule\" onclick=\"return check_sch();\" onchange=\"secondbox();\" class='form-control'>";


$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and LENGTH(style_id)>0 order by order_del_no";	

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

$sql11="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm_archive where order_style_no=\"$style\" and LENGTH(style_id)>0 order by order_del_no";	

mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check11=mysqli_num_rows($sql_result11);


while($sql_row11=mysqli_fetch_array($sql_result11))
{

if(str_replace(" ","",$sql_row11['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row11['order_del_no']."\" selected>".$sql_row11['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row11['order_del_no']."\">".$sql_row11['order_del_no']."</option>";
}

}


echo "</select></div>";
?>

<?php

echo "<div class='col-md-3'><label>Select Color: </label><select name=\"color\" id=\"color\" onclick=\"check_sch_sty();\" onchange=\"thirdbox();\" class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and LENGTH(style_id)>0";
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm_archive where order_style_no=\"$style\" and order_del_no=\"$schedule\" and LENGTH(style_id)>0";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

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

echo "</select></div>";

echo "<div class='col-md-3'><input type=\"submit\" value=\"Show\" name=\"submit\" onclick='return check_all();' class='btn btn-primary' style='margin-top:22px;'></div>";	

if($schedule>0)
{
	//$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	$sql="select distinct ims_mod_no as mods from (select ims_mod_no from $bai_pro3.ims_log where ims_mod_no>0 and ims_schedule=$schedule and ims_color='$color'
	union
	select ims_mod_no from $bai_pro3.ims_log_backup where ims_mod_no>0  and ims_schedule=$schedule and ims_color='$color') t";
	//echo $sql;
	$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result7))
	{
		//$sql_mod=$sql_row["mods"];
		$sql_mods[]=$sql_row["mods"];
	}

	//$sql_mods=explode(",",$sql_mod);
}
?>
</form>
</div>

<?php
if(isset($_POST['submit']))
{
	echo "<hr>";
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	
	//date 2012-05-15
	//Added code for getting schedule no from archive table also
	$sql_sch="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\"";
	$sql_result=mysqli_query($link, $sql_sch) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count=mysqli_num_rows($sql_result);
	if($count > 0)
	{
		$table_name="bai_orders_db_confirm";
	}
	else
	{
		$table_name="bai_orders_db_archive";
	}	
	$sql="select * from $bai_pro3.$table_name where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{

		for($i=0;$i<sizeof($sizes_array);$i++)
		{
			if($sql_row["title_size_".$sizes_array[$i]] != '') 
			{ 
				$qty[]=$sql_row["order_s_".$sizes_array[$i].""]; 
				$sizes[]=$sql_row["title_size_".$sizes_array[$i].""];
			}
		}
		$order_tid=$sql_row['order_tid'];
	}

	$sql="select cat_ref,sum(p_xs*p_plies) AS \"xs\",sum(p_s*p_plies) AS \"s\",sum(p_m*p_plies) AS \"m\",sum(p_l*p_plies) AS \"l\",sum(p_xl*p_plies) AS \"xl\",sum(p_xxl*p_plies) AS \"xxl\",sum(p_xxxl*p_plies) AS \"xxxl\",sum(p_s01 * p_plies) as \"s01\", sum(p_s02 * p_plies) as \"s02\", sum(p_s03 * p_plies) as \"s03\", sum(p_s04 * p_plies) as \"s04\", sum(p_s05 * p_plies) as \"s05\", sum(p_s06 * p_plies) as \"s06\", sum(p_s07 * p_plies) as \"s07\", sum(p_s08 * p_plies) as \"s08\", sum(p_s09 * p_plies) as \"s09\", sum(p_s10 * p_plies) as \"s10\", sum(p_s11 * p_plies) as \"s11\", sum(p_s12 * p_plies) as \"s12\", sum(p_s13 * p_plies) as \"s13\", sum(p_s14 * p_plies) as \"s14\", sum(p_s15 * p_plies) as \"s15\", sum(p_s16 * p_plies) as \"s16\", sum(p_s17 * p_plies) as \"s17\", sum(p_s18 * p_plies) as \"s18\", sum(p_s19 * p_plies) as \"s19\", sum(p_s20 * p_plies) as \"s20\", sum(p_s21 * p_plies) as \"s21\", sum(p_s22 * p_plies) as \"s22\", sum(p_s23 * p_plies) as \"s23\", sum(p_s24 * p_plies) as \"s24\", sum(p_s25 * p_plies) as \"s25\", sum(p_s26 * p_plies) as \"s26\", sum(p_s27 * p_plies) as \"s27\", sum(p_s28 * p_plies) as \"s28\", sum(p_s29 * p_plies) as \"s29\", sum(p_s30 * p_plies) as \"s30\", sum(p_s31 * p_plies) as \"s31\", sum(p_s32 * p_plies) as \"s32\", sum(p_s33 * p_plies) as \"s33\", sum(p_s34 * p_plies) as \"s34\", sum(p_s35 * p_plies) as \"s35\", sum(p_s36 * p_plies) as \"s36\", sum(p_s37 * p_plies) as \"s37\", sum(p_s38 * p_plies) as \"s38\", sum(p_s39 * p_plies) as \"s39\", sum(p_s40 * p_plies) as \"s40\", sum(p_s41 * p_plies) as \"s41\", sum(p_s42 * p_plies) as \"s42\", sum(p_s43 * p_plies) as \"s43\", sum(p_s44 * p_plies) as \"s44\", sum(p_s45 * p_plies) as \"s45\", sum(p_s46 * p_plies) as \"s46\", sum(p_s47 * p_plies) as \"s47\", sum(p_s48 * p_plies) as \"s48\", sum(p_s49 * p_plies) as \"s49\", sum(p_s50 * p_plies) as \"s50\" from $bai_pro3.plandoc_stat_log where cat_ref in (select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\"))";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo $sql."<br>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_ref_id=$sql_row["cat_ref"];
		for($k=0;$k<sizeof($sizes);$k++)
		{
			$acut[]=$sql_row[$sizes_array[$i]];
		}
		
		//if($sql_row['s50']>0) { $acut[]=$sql_row['s50'];}
	}
	// echo array_sum($acut);
	var_dump($acut);
	if(array_sum($acut) >= 0){
		echo '<script>sweetAlert("There is no excess cut for selected style, schedule and color.")
					.then((value) => {
						window.location.href = url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
					});</script>';
		
	}else {
	
		
		$url = '?r='.$_GET['r'];
		echo "<form name=\"input\" method=\"post\" action=\"".$url."\">";
		echo "<table class='table table-bordered'>";
		echo "<tr><th>Sizes</th>";
		$sizes_db=array();
		for($i=0;$i<sizeof($qty);$i++)
		{
			//if($qty[$i]>0)
			//{
				echo "<th>".strtoupper($sizes[$i])."</th>";
				$sizes_db[]=$sizes[$i];
			//}
		}
		echo "</tr>";
		
		echo "<tr><th>Order Qty</th>";
		for($i=0;$i<sizeof($qty);$i++)
		{
			//if($qty[$i]>0)
			//{
				echo "<th>".$qty[$i]."</th>";
			//}
		}
		echo "</tr>";
		
		
		echo "<tr><th>Excess Cut</th>";
		for($i=0;$i<sizeof($qty);$i++)
		{
			// if($qty[$i]>0)
			// {
				if($acut[$i] > $qty[$i]){
					echo "<th>".($acut[$i]-$qty[$i])."</th>";
				}else{
					echo "<th>0</th>";
				}
			// }
		}
		echo "</tr>";
		
		
		$qms_qty_ref=array();
		echo "<tr><th>Received so far</th>";
		for($i=0;$i<sizeof($qty);$i++)
		{
			//if($qty[$i]>0)
			//{
				
				$sql="select coalesce(sum(qms_qty),0) as \"qms_qty\"  from $bai_pro3.bai_qms_db where qms_style=\"".$style."\" and qms_schedule=\"".$schedule."\" and qms_color=\"".$color."\" and qms_size=\"".$sizes_array[$i]."\" and qms_tran_type in (5)";

				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$qms_qty=$sql_row['qms_qty'];
					$qms_qty_ref[]=$sql_row['qms_qty'];
				}
				
				echo "<th>".$qms_qty."</th>";
			//}
		}
		echo "</tr>";
		
		echo "<tr><th>Update</th>";
		for($i=0;$i<sizeof($qty);$i++)
		{
			// if($qty[$i]>0)
			// {
				if($acut[$i] > $qty[$i]){
					echo "<th><input type=\"text\" value=\"".($acut[$i]-$qty[$i])."\" name=\"qty[]\" id=\"update_qty_$i\" class='form-control' onchange=\"qty_update(".($acut[$i]-$qty[$i]).", $i)\"></th>";
					// echo "<th>".($acut[$i]-$qty[$i])."</th>";
				}else{
					echo "<th><input type=\"text\" value=\"0\" name=\"qty[]\" class='form-control' id=\"update_qty_$i\" onchange=\"qty_update(0, $i)\"></th>";
					
					// echo "<th>0</th>";
				}
				//echo "<th>".(($acut[$i]-$qty[$i])-$qms_qty_ref[$i])."</th>";
				// echo "<th><div class='row'><div class='col-md-3'><input type=\"text\" value=\"0\" name=\"qty[]\" class='form-control'></div></div></th>";
			// }
		}
		echo "</tr>";
		echo "</table><br>";
		echo "<div class='col-md-8'>";
		echo "<table class='table table-bordered'>";
		
		$sql_del="select order_date from $bai_pro3.$table_name where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		$sql_result5=mysqli_query($link, $sql_del) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row5=mysqli_fetch_array($sql_result5))
		{
			$ex_date=$sql_row5["order_date"];
			//$ex_date="2012-02-15";
			echo "<tr><th>Ex-Fact Date</th><td>".$ex_date."</td></tr>";
			$dates=explode("-",$ex_date);
			$ex_dates=mktime(0,0,0,$dates[1],$dates[2],$dates[0]);
			$week=(int)date("W",$ex_dates);
			echo "<tr><th>Week No</th><td>".$week."</td></tr>";
		}
		
		//Capturing the Docket no of selected Style,Schedule and Color with cat reference
		$sql_cat="select acutno,doc_no from $bai_pro3.plandoc_stat_log where cat_ref=\"".$cat_ref_id."\"";
		$sql_result_cat=mysqli_query($link, $sql_cat) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_cat=mysqli_fetch_array($sql_result_cat))
		{
			$acutno_ref[]="D".$sql_row_cat["acutno"];
			$doc_no_ref[]="D".$sql_row_cat["doc_no"];
		}
		
		//Capturing the Recut Docket no of selected Style,Schedule and Color with cat reference
		$sql_cat="select acutno,doc_no from $bai_pro3.recut_v2 where cat_ref=\"".$cat_ref_id."\"";
		// echo $sql_cat."<br>";
		$sql_result_cat=mysqli_query($link, $sql_cat) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_cat=mysqli_fetch_array($sql_result_cat))
		{
			$acutno_ref[]="R".$sql_row_cat["acutno"];
			$doc_no_ref[]="R".$sql_row_cat["doc_no"];
		}
		
		echo "<input type=\"hidden\" name=\"sizes\" value=\"".implode(",",$sizes_db)."\">";
		echo "<input type=\"hidden\" name=\"style\" value=\"".$style."\">";
		echo "<input type=\"hidden\" name=\"schedule\" value=\"".$schedule."\">";
		echo "<input type=\"hidden\" name=\"color\" value=\"".$color."\">";
		
		echo "<tr><th>Garment Category: </th><td><div class='row'><div class='col-md-4'><select name=\"gtype\" id=\"gtype\" class='form-control'>";
		echo "<option value=\"Good Garments\">Good Garments</option>";
		echo "<option value=\"Without Label\">Without Label</option>";
		echo "<option value=\"Without Heatseal\">Without Heatseal</option>";
		echo "<option value=\"Panel form\">Panel Form</option>";
		//Date 2013-11-15
		//Added semi stitched option
		echo "<option value=\"Semi Stitched\">Semi Stitched</option>";
		echo "</select></div></div></td></tr>";
		
		echo "<tr><th>Cut No</th><td><div class='row'><div class='col-md-4'><select name=\"doc_ref\" id=\"doc_ref\"  class='form-control'>";
		for($i2=0;$i2<sizeof($doc_no_ref);$i2++)
		{
			echo "<option value=\"".$doc_no_ref[$i2]."\">".$acutno_ref[$i2]."</option>";
		}
		echo "</select></div></div></td></tr>";
		echo "<tr><th>Carton No: *</th><td><div class='row'><div class='col-md-4'><input type=\"text\" value=\"\" name=\"sourceid\" id=\"sourceid\"  class='form-control integer'></div></div></td></tr>";
		
		echo "<tr><th>Source : *</th><td><div class='row'><div class='col-md-4'><select name=\"source\" id=\"source\"  class='form-control'>";
		echo "<option value=\" \"></option>";
		//echo "<option value=\"-1\">Production (O.R)</option>";
		echo "<option value=\"SAM\">Sample (O.R)</option>";
		echo "<option value=\"ENP\">Embellishment (O.R)</option>";
		//Added cutting, packing and fg in source departments
		echo "<option value=\"CUT\">Cutting (O.R)</option>";
		echo "<option value=\"PCK\">Packing (O.R)</option>";
		echo "<option value=\"FG\">FG (O.R)</option>";
		for($i=0;$i<sizeof($sql_mods);$i++)
		{
			if($sql_mods[$i]==$module)
			{
			echo "<option value=\"".$sql_mods[$i]."\" selected>".$sql_mods[$i]."</option>";
			}
			else
			{
			echo "<option value=\"".$sql_mods[$i]."\">".$sql_mods[$i]."</option>";
			}	
		}
		//echo "<option value=\"2\">Cut Section - 2</option>";
		//echo "<option value=\"3\">Cut Section - 3</option>"; 
		echo "</select></div></div></td></tr><br>";

		
		echo "</table>";
		echo "</div>";
		echo "<br><div class='col-md-12'><div class='col-md-1'><input type=\"submit\" name=\"update\" value=\"Update\" class='btn btn-primary form-control' id=\"add\" onclick=\"return fill_up(".sizeof($qty).");\"></div></div>";
		echo "</form>";
	}
	

}

?>


<?php

if(isset($_POST['update']))
{
	$qty=$_POST['qty'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$source=$_POST['source'];
	$sizes=$_POST['sizes'];
	$sizes_db=array();
	$sizes_db=explode(",",$sizes);
	$gtype=$_POST['gtype']."^".$_POST['sourceid'];	
	
	//Added DOCKET Number to store in database
	$doc_no_id=$_POST["doc_ref"];
	$temp="5";
	
	//echo $source."-".$doc_no_id;
	
	$usr_msg="<div class='alert alert-danger' role='alert'>The following entries are failed to update due to M3 system validations:</div><br/>
				<div class='col-sm-12'>
				<div class='col-md-4'>
					<table class='table table-bordered'>
						<tr><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
	
		//M3 Bulk Operation Reporting
		//Extract Operation Code and Reason Code
		//ref1=form factor (G/P), ref2=Source, ref3=reason refe
		$sql_sup="select m3_reason_code,m3_operation_code from $m3_bulk_ops_rep_db.rejection_report_matrix where interface='ORREP' and ref1='".$_POST['gtype']."' and ref2='".(is_numeric($_POST['source'])?'0':$_POST['source'])."' and ref3='0'";
		$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
		{
			$m3_reason_code=$sql_row_sup['m3_reason_code'];
			$m3_operation_code=$sql_row_sup['m3_operation_code'];
		}
	
	for($i=0;$i<sizeof($sizes_db);$i++)
	{
		//
		if($qty[$i]>0 and rejection_validation_m3($m3_operation_code,$schedule,$color,$sizes_db[$i],$qty[$i],0,$username)=='TRUE')
		{
			//Changed Query for capturing the docket number
			$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,remarks,log_date,ref1,doc_no) values (\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$sizes_db[$i]."\",".$qty[$i].",$temp,\"".$source."\",\"".date("Y-m-d")."\",\"$gtype\",\"$doc_no_id\")";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			
				//M3 Bulk Operation Reporting
				//Extract Operation Code and Reason Code
				//ref1=form factor (G/P), ref2=Source, ref3=reason refe
				
				$sql_sup="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_reason) values(NOW(),'".$style."','".$schedule."','".$color."','".$sizes_db[$i]."','".substr($doc_no_id,1)."',".$qty[$i].",USER(),'$m3_operation_code',$iLastid,'".(is_numeric($_POST['source'])?$_POST['source']:'0')."','','".$m3_reason_code."')"; 
			
				//echo $sql."<br/>";
				mysqli_query($link, $sql_sup) or exit("Sql Error6$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				//M3 Bulk Operation Reporting
		}
		else
		{
			$usr_msg.="<tr><td>".$schedule."</td><td>".$color."</td><td>".$sizes_db[$i]."</td><td>".$qty[$i]."</td></tr>";
		}
	}
	$usr_msg.="</table></div></div>";
	
	
	//Validations
	echo $usr_msg;
	
	echo "<div class='col-sm-12'><div class=' alert alert-success' role='alert'>Successfully Updated.</div></div>";
}

?>
</div><!-- panel body -->
</div><!-- panel -->
</div>