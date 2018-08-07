<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

 ?>

<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0168",$username,1,$group_id_sfcs);
// Authorization for Cutting, Emblishment and Top Module Selection. 
$authorized=user_acl("SFCS_0168",$username,7,$group_id_sfcs); 
$auth_users=user_acl("SFCS_0168",$username,50,$group_id_sfcs);
?>


<script>
function check1(x,y)
{
	if(x<0 || x=="")
	{
		alert("Please enter correct value");
		return 1010;
	}
	if(x>y)
	{
		alert("Please enter correct value");
		return 1010;
	}
}

function check2(x,y)
{
	if(x<0 || x=="")
	{
		alert("Please enter correct value");
		return 1010;
	}
}
function check3()
{
	var a = document.getElementById("style");
	var stl = a.options[a.selectedIndex].value;
	var b = document.getElementById("schedule");
	var sch = b.options[b.selectedIndex].value;
	var c = document.getElementById("color");
	var clr = c.options[c.selectedIndex].value;
	var d =document.getElementById("module");
	var mod = d.options[d.selectedIndex].value;

	if(stl == 'NIL')
	{
		sweetAlert('Please Select Style','','info');
		return false;		
	}
	else if(sch == 'NIL')
	{
		sweetAlert('Please Select Schedule','','info');
		return false;
	}
	else if(clr == 'NIL')
	{
		sweetAlert('Please Select Color','','info');
		return false;
	}
	else if(mod == 'NIL')
	{
		sweetAlert('Please Select Module','','info');
		return false;
	}
	else
	{
		return true;
	}
}

</script>
<style>
body
{
	font-family:arial;
	font-size:14px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align:left;
	vertical-align:top;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759c;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:14px;
}


</style>

<script>

function firstbox()
{
	var ajax_url ="<?= getFullURLLevel($_GET['r'],'search_test.php',0,'N'); ?>&style="+document.test.style.value;
	Ajaxify(ajax_url);

}

function secondbox()
{
	var ajax_url="<?= getFullURLLevel($_GET['r'],'search_test.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;Ajaxify(ajax_url);

}

function thirdbox()
{
	var ajax_url ="<?= getFullURLLevel($_GET['r'],'search_test.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
	Ajaxify(ajax_url);

}

</script>


<div class="panel panel-primary">
	<div class="panel-heading">Recut / Sample Request Form</div>
	<div class="panel-body">

<?php //include("../menu_content.php"); ?>
<?php

if(isset($_POST['search']))
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

if($schedule>0)
{
	//$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	$sql="select distinct ims_mod_no as mods from (select ims_mod_no from $bai_pro3.ims_log where ims_mod_no>0 and ims_schedule=$schedule and ims_color='$color'
	union
	select ims_mod_no from  $bai_pro3.ims_log_backup where ims_mod_no>0  and ims_schedule=$schedule and ims_color='$color') t";
	//echo $sql;
	$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result7))
	{
		//$sql_mod=$sql_row["mods"];
		$sql_mods[]=$sql_row["mods"];
	}

	//$sql_mods=explode(",",$sql_mod);
}
$search_test_process = getFullURL($_GET['r'],'search_test_process.php','N');


//echo $style.$schedule.$color;
?>

<form id="test" name="test" action="<?= getFullURL($_GET['r'],'search_test_process.php','N'); ?>" method="post" onsubmit="return check3()">
<div class="row">

	<?php

	echo "<div class='col-md-2'><label>Select Style:</label> <select name=\"style\" id =\"style\" onchange=\"firstbox();\" class='form-control'>";

	//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
	//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
	//{
		$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm";	
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

	$sql="select order_div from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\"";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$buyer_cat=$sql_row["order_div"];
	}
	?>


	<?php

	echo "<div class='col-md-2'><label>Select Schedule:</label> <select name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" class='form-control'>";
	$schedule_nos=array();
	$schedule_nos[]=0;
	//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
	//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
	//{
	$sql_sel="select distinct order_del_no from  $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50)>output order by order_del_no";
	mysqli_query($link, $sql_sel) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_resultx=mysqli_query($link, $sql_sel) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_checkx=mysqli_num_rows($sql_resultx);
	echo "<option value=\"NIL\" selected>NIL</option>";
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
	$schedule_nos[]=$sql_rowx['order_del_no'];
	if(str_replace(" ","",$sql_rowx['order_del_no'])==str_replace(" ","",$schedule))
	{
		echo "<option value=\"".$sql_rowx['order_del_no']."\" selected>".$sql_rowx['order_del_no']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_rowx['order_del_no']."\">".$sql_rowx['order_del_no']."</option>";
	}
	}
	echo implode(",",$schedule_nos);
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no not in (".implode(",",$schedule_nos).")";	
	echo $sql;
	//}
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	//echo "<input type=\"text\" id=\"sql\" name=\"sql\" value=\"".$sql."\"/>";
	//echo "<option value=\"NIL\" selected>NIL</option>";
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

echo "<div class='col-md-2'><label>Select Color:</label><select name=\"color\" id=\"color\" onchange=\"thirdbox();\"  class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct $bai_pro3.bai_orders_db_confirm.order_col_des,$bai_pro3.cat_stat_log.col_des from $bai_pro3.bai_orders_db_confirm left join $bai_pro3.cat_stat_log on $bai_pro3.bai_orders_db_confirm.order_tid=$bai_pro3.cat_stat_log.order_tid where $bai_pro3.bai_orders_db_confirm.order_style_no=\"$style\" and $bai_pro3.bai_orders_db_confirm.order_del_no=\"$schedule\" and $bai_pro3.cat_stat_log.purwidth > 0 and $bai_pro3.cat_stat_log.category in ('Body','Front') order by $bai_pro3.bai_orders_db_confirm.order_col_des";
//}
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."&nbsp; &nbsp; - ".$sql_row['col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."&nbsp; &nbsp; - ".$sql_row['col_des']."</option>";
}

}
echo "</select></div>";
?>


<?php
echo "<div class='col-md-1'><label>Module:</label> ";
echo "<select name=\"module\" id=\"module\" class='form-control' style=\"width: 86px;\">";
echo "<option value=\"NIL\">NIL</option>";
// Ticket #883457 give the Authorization to Cutting, Emblishment and Top Module Selection for restrict the cutting operation in Recut from the production people.
if(in_array(strtolower($username),$authorized))
{
	if($module=="CUT")
	{
		echo "<option value=\"CUT\" selected>CUT</option>";
	}
	else
	{
		echo "<option value=\"CUT\">CUT</option>";
	}
	if($module=="ENP")
	{
		echo "<option value=\"ENP\" selected>E/P</option>";
	}
	else
	{
		echo "<option value=\"ENP\">E/P</option>";
	}
	if($module=="TOP")
	{
		echo "<option value=\"TOP\" selected>TOP</option>";
	}
	else
	{
		echo "<option value=\"TOP\">TOP</option>";
	}
}

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

echo "</select></div>";


$sql="select order_tid from $bai_pro3.bai_orders_db_confirm  where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}

?>

<?php

$buyer_cat=substr($buyer_cat,0,((strlen($buyer_cat)-2)*-1));
echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
echo "<input type=\"hidden\" id=\"buyer_cat\" name=\"buyer_cat\" value=\"$buyer_cat\">";
if($buyer_cat != "LB" && $module!="TOP")
{
	if(in_array($username,$auth_users))
	{
		echo "<div class='col-sm-3'><br/><label>Special Request:</label> <span class='label label-success'>Allowed</span><input type='hidden' id=\"user\" name=\"user\" value=\"$username\" /></div>";
	//echo "&nbsp;PW: <input type=\"password\" id=\"user\" name=\"user\" value=\"\" onkeypress=\"hide()\" size=\"10\">";
	}
	else
	{
		echo "<div class='col-sm-3'><br/><label>Special Request:</label> <span class='label label-danger'>Not Allowed</span><input type='hidden' id=\"user\" name=\"user\" value=\"\" /></div>";
	}
}
?>

<div class="col-md-2">
	<br/>
	<!-- <input type="search" name="search" class="btn btn-primary" id="search" value="Search"> -->
	<?= "<div id='button'>
	<input type='submit' name='search' value='Search' class='btn btn-primary' onclick='document.getElementById('button').style.display='none';
	document.getElementById('message').style.display='';'></div><div id='message' style='display:none;'>
	Please Wait...</div>";
	?>
</div>
</div>
</form>


</div>
</div>
</div>