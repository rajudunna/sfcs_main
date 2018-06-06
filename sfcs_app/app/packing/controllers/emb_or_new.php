<?php
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));
$view_access=user_acl("SFCS_0231",$username,1,$group_id_sfcs); 
$author_id_db=user_acl("SFCS_0231",$username,7,$group_id_sfcs); 
?>
<?php

/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$author_id_db=array("lilanku","sasidharch","chandrasekharka","rasools","venkateshch","muralip","kirang","amulyap");
*/
if(in_array($username,$author_id_db))
{
	
}
else
{
	header("Location:restricted.php");
}

?>
<?php //include("header_scripts.php"); ?>
<script>

function fill_up()
	{
	
		var gtype=document.getElementById('gtype').value;
		var doc_ref=document.getElementById('doc_ref').value;
		var sourceid=document.getElementById('sourceid').value;
		var source=document.getElementById('source').value;

		if(source=='' || doc_ref=='' )
		{
			sweetAlert('Please Fill The Mandatory Fields','','warning');
			return false;
		}
		else
		{
			return true;
		}

	}
function dodisable()
{
enableButton();
 
document.input.update.style.visibility="hidden"; 

}


</script>

<script>

function firstbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>

<!-- <style>
body
{
	font-family: arial;
}
table
{
	border-collapse:collapse;
	font-size:12px;
}
td
{
	border: 1px solid black;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid black;
	white-space:nowrap;
	border-collapse:collapse;
	width: 150px;
}
</style> -->

<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>


<body onload="dodisable()">
<div class="panel panel-primary">
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], 'common/config/config.php', 3,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], 'common/config/m3_bulk_or_proc.php', 3, "R"));
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

<div class="panel-heading">Embellishment - Excess Garments Entry Form</div>
<div class="panel-body">
<form name="test" action="<?php echo getFullURL($_GET['r'], "emb_or_new.php", "N"); ?>" method="post">
<?php

/*
echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from bai_orders_db_confirm where LENGTH(style_id)>0 order by order_style_no";	
//}
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysql_fetch_array($sql_result))
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
*/
?>

<?php

echo "<div class=\"col-sm-12\"><div class=\"col-md-4\"><h5 style=\"color: #000000\">Select Schedule:</h5> <select class=\"form-control\" name=\"schedule\" onchange=\"secondbox();\" >";

$sql="select distinct order_del_no from bai_orders_db_confirm where LENGTH(style_id)>0 order by order_del_no";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
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

echo "<div class=\"col-md-4\"><h5 style=\"color: #000000\">Select Color:</h5> <select class=\"form-control\" name=\"color\" onchange=\"thirdbox();\" id=\"color\" >";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from bai_orders_db_confirm where order_del_no=\"$schedule\" and LENGTH(style_id)>0";
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
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

$sql="select distinct order_col_des from bai_orders_db_confirm_archive where order_del_no=\"$schedule\" and LENGTH(style_id)>0";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
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

echo "<div class=\"col-md-4\"><br/><br/><input class=\"btn btn-sm btn-primary\" type=\"submit\" value=\"Show\" name=\"submit\" id='sub' disabled ></div></div>";	
$sql_mods[]=1;
$sql_mods[]=2;
if($schedule>0)
{
	//$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	$sql="select distinct ims_mod_no as mods from (select ims_mod_no from bai_pro3.ims_log where ims_mod_no>0 and ims_schedule=$schedule and ims_color='$color'
	union
	select ims_mod_no from bai_pro3.ims_log_backup where ims_mod_no>0  and ims_schedule=$schedule and ims_color='$color') t";
	//echo $sql;
	$result7=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result7))
	{
		//$sql_mod=$sql_row["mods"];
		$sql_mods[]=$sql_row["mods"];
	}
//var_dump($sql_mods);

	//$sql_mods=explode(",",$sql_mod);
}
?>
</form>


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	
	
	$table_name="bai_orders_db_confirm";
	// var_dump($sizes_array);
	$sql="select * from $table_name where  order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['order_style_no'];
		foreach ($sizes_array as $key => $value) {
			if($sql_row['old_order_s_'.$value]>0) {  
				$qty[]=$sql_row['order_s_'.$value]; 
				$sizes[]= $sql_row['title_size_'.$value];
			}	
		}
		// if($sql_row['old_order_s_xs']>0) { $qty[]=$sql_row['order_s_xs']; $sizes[]=str_replace("order_s_","","order_s_xs");}
		// if($sql_row['old_order_s_s']>0) { $qty[]=$sql_row['order_s_s'];  $sizes[]=str_replace("order_s_","","order_s_s");}	
		// if($sql_row['old_order_s_m']>0) {  $qty[]=$sql_row['order_s_m']; $sizes[]=str_replace("order_s_","","order_s_m");}	
		// if($sql_row['old_order_s_l']>0) {  $qty[]=$sql_row['order_s_l']; $sizes[]=str_replace("order_s_","","order_s_l");}	
		// if($sql_row['old_order_s_xl']>0) {  $qty[]=$sql_row['order_s_xl']; $sizes[]=str_replace("order_s_","","order_s_xl");}	
		// if($sql_row['old_order_s_xxl']>0) {  $qty[]=$sql_row['order_s_xxl']; $sizes[]=str_replace("order_s_","","order_s_xxl");}	
		// if($sql_row['old_order_s_xxxl']>0) {  $qty[]=$sql_row['order_s_xxxl']; $sizes[]=str_replace("order_s_","","order_s_xxxl");}	
		// if($sql_row['old_order_s_s01']>0) {  $qty[]=$sql_row['order_s_s01']; $sizes[]= $sql_row['title_size_s01'];}
		// if($sql_row['old_order_s_s02']>0) {  $qty[]=$sql_row['order_s_s02']; $sizes[]=$sql_row['title_size_s02'];}
		// if($sql_row['old_order_s_s03']>0) {  $qty[]=$sql_row['order_s_s03']; $sizes[]=$sql_row['title_size_s03'];}
		// if($sql_row['old_order_s_s04']>0) {  $qty[]=$sql_row['order_s_s04']; $sizes[]=$sql_row['title_size_s04'];}
		// if($sql_row['old_order_s_s05']>0) {  $qty[]=$sql_row['order_s_s05']; $sizes[]=$sql_row['title_size_s05'];}
		// if($sql_row['old_order_s_s06']>0) {  $qty[]=$sql_row['order_s_s06']; $sizes[]=$sql_row['title_size_s06'];}
		// if($sql_row['old_order_s_s07']>0) {  $qty[]=$sql_row['order_s_s07']; $sizes[]=$sql_row['title_size_s07'];}
		// if($sql_row['old_order_s_s08']>0) {  $qty[]=$sql_row['order_s_s08']; $sizes[]=$sql_row['title_size_s08'];}
		// if($sql_row['old_order_s_s09']>0) {  $qty[]=$sql_row['order_s_s09']; $sizes[]=$sql_row['title_size_s09'];}
		// if($sql_row['old_order_s_s10']>0) {  $qty[]=$sql_row['order_s_s10']; $sizes[]=$sql_row['title_size_s10'];}
		// if($sql_row['old_order_s_s11']>0) {  $qty[]=$sql_row['order_s_s11']; $sizes[]=$sql_row['title_size_s11'];}
		// if($sql_row['old_order_s_s12']>0) {  $qty[]=$sql_row['order_s_s12']; $sizes[]=str_replace("order_s_","","order_s_s12");}
		// if($sql_row['old_order_s_s13']>0) {  $qty[]=$sql_row['order_s_s13']; $sizes[]=str_replace("order_s_","","order_s_s13");}
		// if($sql_row['old_order_s_s14']>0) {  $qty[]=$sql_row['order_s_s14']; $sizes[]=str_replace("order_s_","","order_s_s14");}
		// if($sql_row['old_order_s_s15']>0) {  $qty[]=$sql_row['order_s_s15']; $sizes[]=str_replace("order_s_","","order_s_s15");}
		// if($sql_row['old_order_s_s16']>0) {  $qty[]=$sql_row['order_s_s16']; $sizes[]=str_replace("order_s_","","order_s_s16");}
		// if($sql_row['old_order_s_s17']>0) {  $qty[]=$sql_row['order_s_s17']; $sizes[]=str_replace("order_s_","","order_s_s17");}
		// if($sql_row['old_order_s_s18']>0) {  $qty[]=$sql_row['order_s_s18']; $sizes[]=str_replace("order_s_","","order_s_s18");}
		// if($sql_row['old_order_s_s19']>0) {  $qty[]=$sql_row['order_s_s19']; $sizes[]=str_replace("order_s_","","order_s_s19");}
		// if($sql_row['old_order_s_s20']>0) {  $qty[]=$sql_row['order_s_s20']; $sizes[]=str_replace("order_s_","","order_s_s20");}
		// if($sql_row['old_order_s_s21']>0) {  $qty[]=$sql_row['order_s_s21']; $sizes[]=str_replace("order_s_","","order_s_s21");}
		// if($sql_row['old_order_s_s22']>0) {  $qty[]=$sql_row['order_s_s22']; $sizes[]=str_replace("order_s_","","order_s_s22");}
		// if($sql_row['old_order_s_s23']>0) {  $qty[]=$sql_row['order_s_s23']; $sizes[]=str_replace("order_s_","","order_s_s23");}
		// if($sql_row['old_order_s_s24']>0) {  $qty[]=$sql_row['order_s_s24']; $sizes[]=str_replace("order_s_","","order_s_s24");}
		// if($sql_row['old_order_s_s25']>0) {  $qty[]=$sql_row['order_s_s25']; $sizes[]=str_replace("order_s_","","order_s_s25");}
		// if($sql_row['old_order_s_s26']>0) {  $qty[]=$sql_row['order_s_s26']; $sizes[]=str_replace("order_s_","","order_s_s26");}
		// if($sql_row['old_order_s_s27']>0) {  $qty[]=$sql_row['order_s_s27']; $sizes[]=str_replace("order_s_","","order_s_s27");}
		// if($sql_row['old_order_s_s28']>0) {  $qty[]=$sql_row['order_s_s28']; $sizes[]=str_replace("order_s_","","order_s_s28");}
		// if($sql_row['old_order_s_s29']>0) {  $qty[]=$sql_row['order_s_s29']; $sizes[]=str_replace("order_s_","","order_s_s29");}
		// if($sql_row['old_order_s_s30']>0) {  $qty[]=$sql_row['order_s_s30']; $sizes[]=str_replace("order_s_","","order_s_s30");}
		// if($sql_row['old_order_s_s31']>0) {  $qty[]=$sql_row['order_s_s31']; $sizes[]=str_replace("order_s_","","order_s_s31");}
		// if($sql_row['old_order_s_s32']>0) {  $qty[]=$sql_row['order_s_s32']; $sizes[]=str_replace("order_s_","","order_s_s32");}
		// if($sql_row['old_order_s_s33']>0) {  $qty[]=$sql_row['order_s_s33']; $sizes[]=str_replace("order_s_","","order_s_s33");}
		// if($sql_row['old_order_s_s34']>0) {  $qty[]=$sql_row['order_s_s34']; $sizes[]=str_replace("order_s_","","order_s_s34");}
		// if($sql_row['old_order_s_s35']>0) {  $qty[]=$sql_row['order_s_s35']; $sizes[]=str_replace("order_s_","","order_s_s35");}
		// if($sql_row['old_order_s_s36']>0) {  $qty[]=$sql_row['order_s_s36']; $sizes[]=str_replace("order_s_","","order_s_s36");}
		// if($sql_row['old_order_s_s37']>0) {  $qty[]=$sql_row['order_s_s37']; $sizes[]=str_replace("order_s_","","order_s_s37");}
		// if($sql_row['old_order_s_s38']>0) {  $qty[]=$sql_row['order_s_s38']; $sizes[]=str_replace("order_s_","","order_s_s38");}
		// if($sql_row['old_order_s_s39']>0) {  $qty[]=$sql_row['order_s_s39']; $sizes[]=str_replace("order_s_","","order_s_s39");}
		// if($sql_row['old_order_s_s40']>0) {  $qty[]=$sql_row['order_s_s40']; $sizes[]=str_replace("order_s_","","order_s_s40");}
		// if($sql_row['old_order_s_s41']>0) {  $qty[]=$sql_row['order_s_s41']; $sizes[]=str_replace("order_s_","","order_s_s41");}
		// if($sql_row['old_order_s_s42']>0) {  $qty[]=$sql_row['order_s_s42']; $sizes[]=str_replace("order_s_","","order_s_s42");}
		// if($sql_row['old_order_s_s43']>0) {  $qty[]=$sql_row['order_s_s43']; $sizes[]=str_replace("order_s_","","order_s_s43");}
		// if($sql_row['old_order_s_s44']>0) {  $qty[]=$sql_row['order_s_s44']; $sizes[]=str_replace("order_s_","","order_s_s44");}
		// if($sql_row['old_order_s_s45']>0) {  $qty[]=$sql_row['order_s_s45']; $sizes[]=str_replace("order_s_","","order_s_s45");}
		// if($sql_row['old_order_s_s46']>0) {  $qty[]=$sql_row['order_s_s46']; $sizes[]=str_replace("order_s_","","order_s_s46");}
		// if($sql_row['old_order_s_s47']>0) {  $qty[]=$sql_row['order_s_s47']; $sizes[]=str_replace("order_s_","","order_s_s47");}
		// if($sql_row['old_order_s_s48']>0) {  $qty[]=$sql_row['order_s_s48']; $sizes[]=str_replace("order_s_","","order_s_s48");}
		// if($sql_row['old_order_s_s49']>0) {  $qty[]=$sql_row['order_s_s49']; $sizes[]=str_replace("order_s_","","order_s_s49");}
		// if($sql_row['old_order_s_s50']>0) {  $qty[]=$sql_row['order_s_s50']; $sizes[]=str_replace("order_s_","","order_s_s50");}
		$order_tid=$sql_row['order_tid'];
	}
	
	$cat_ref_id=array();
	
	$sql="select cat_ref,sum(p_xs*p_plies) AS \"xs\",sum(p_s*p_plies) AS \"s\",sum(p_m*p_plies) AS \"m\",sum(p_l*p_plies) AS \"l\",sum(p_xl*p_plies) AS \"xl\",sum(p_xxl*p_plies) AS \"xxl\",sum(p_xxxl*p_plies) AS \"xxxl\",sum(p_s01 * p_plies) as \"s01\", sum(p_s02 * p_plies) as \"s02\", sum(p_s03 * p_plies) as \"s03\", sum(p_s04 * p_plies) as \"s04\", sum(p_s05 * p_plies) as \"s05\", sum(p_s06 * p_plies) as \"s06\", sum(p_s07 * p_plies) as \"s07\", sum(p_s08 * p_plies) as \"s08\", sum(p_s09 * p_plies) as \"s09\", sum(p_s10 * p_plies) as \"s10\", sum(p_s11 * p_plies) as \"s11\", sum(p_s12 * p_plies) as \"s12\", sum(p_s13 * p_plies) as \"s13\", sum(p_s14 * p_plies) as \"s14\", sum(p_s15 * p_plies) as \"s15\", sum(p_s16 * p_plies) as \"s16\", sum(p_s17 * p_plies) as \"s17\", sum(p_s18 * p_plies) as \"s18\", sum(p_s19 * p_plies) as \"s19\", sum(p_s20 * p_plies) as \"s20\", sum(p_s21 * p_plies) as \"s21\", sum(p_s22 * p_plies) as \"s22\", sum(p_s23 * p_plies) as \"s23\", sum(p_s24 * p_plies) as \"s24\", sum(p_s25 * p_plies) as \"s25\", sum(p_s26 * p_plies) as \"s26\", sum(p_s27 * p_plies) as \"s27\", sum(p_s28 * p_plies) as \"s28\", sum(p_s29 * p_plies) as \"s29\", sum(p_s30 * p_plies) as \"s30\", sum(p_s31 * p_plies) as \"s31\", sum(p_s32 * p_plies) as \"s32\", sum(p_s33 * p_plies) as \"s33\", sum(p_s34 * p_plies) as \"s34\", sum(p_s35 * p_plies) as \"s35\", sum(p_s36 * p_plies) as \"s36\", sum(p_s37 * p_plies) as \"s37\", sum(p_s38 * p_plies) as \"s38\", sum(p_s39 * p_plies) as \"s39\", sum(p_s40 * p_plies) as \"s40\", sum(p_s41 * p_plies) as \"s41\", sum(p_s42 * p_plies) as \"s42\", sum(p_s43 * p_plies) as \"s43\", sum(p_s44 * p_plies) as \"s44\", sum(p_s45 * p_plies) as \"s45\", sum(p_s46 * p_plies) as \"s46\", sum(p_s47 * p_plies) as \"s47\", sum(p_s48 * p_plies) as \"s48\", sum(p_s49 * p_plies) as \"s49\", sum(p_s50 * p_plies) as \"s50\" from plandoc_stat_log where cat_ref in (select tid from cat_stat_log where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\"))";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	//echo $sql."<br>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		if($sql_row["cat_ref"]){
			$cat_ref_id[]=$sql_row["cat_ref"];
		}		
		if($sql_row['xs']>0) { $acut[]=$sql_row['xs'];}
		if($sql_row['s']>0) { $acut[]=$sql_row['s'];}
		if($sql_row['m']>0) { $acut[]=$sql_row['m'];}
		if($sql_row['l']>0) { $acut[]=$sql_row['l'];}
		if($sql_row['xl']>0) { $acut[]=$sql_row['xl'];}
		if($sql_row['xxl']>0) { $acut[]=$sql_row['xxl'];}
		if($sql_row['xxxl']>0) { $acut[]=$sql_row['xxxl'];}
		if($sql_row['s01']>0) { $acut[]=$sql_row['s01'];}
		if($sql_row['s02']>0) { $acut[]=$sql_row['s02'];}
		if($sql_row['s03']>0) { $acut[]=$sql_row['s03'];}
		if($sql_row['s04']>0) { $acut[]=$sql_row['s04'];}
		if($sql_row['s05']>0) { $acut[]=$sql_row['s05'];}
		if($sql_row['s06']>0) { $acut[]=$sql_row['s06'];}
		if($sql_row['s07']>0) { $acut[]=$sql_row['s07'];}
		if($sql_row['s08']>0) { $acut[]=$sql_row['s08'];}
		if($sql_row['s09']>0) { $acut[]=$sql_row['s09'];}
		if($sql_row['s10']>0) { $acut[]=$sql_row['s10'];}
		if($sql_row['s11']>0) { $acut[]=$sql_row['s11'];}
		if($sql_row['s12']>0) { $acut[]=$sql_row['s12'];}
		if($sql_row['s13']>0) { $acut[]=$sql_row['s13'];}
		if($sql_row['s14']>0) { $acut[]=$sql_row['s14'];}
		if($sql_row['s15']>0) { $acut[]=$sql_row['s15'];}
		if($sql_row['s16']>0) { $acut[]=$sql_row['s16'];}
		if($sql_row['s17']>0) { $acut[]=$sql_row['s17'];}
		if($sql_row['s18']>0) { $acut[]=$sql_row['s18'];}
		if($sql_row['s19']>0) { $acut[]=$sql_row['s19'];}
		if($sql_row['s20']>0) { $acut[]=$sql_row['s20'];}
		if($sql_row['s21']>0) { $acut[]=$sql_row['s21'];}
		if($sql_row['s22']>0) { $acut[]=$sql_row['s22'];}
		if($sql_row['s23']>0) { $acut[]=$sql_row['s23'];}
		if($sql_row['s24']>0) { $acut[]=$sql_row['s24'];}
		if($sql_row['s25']>0) { $acut[]=$sql_row['s25'];}
		if($sql_row['s26']>0) { $acut[]=$sql_row['s26'];}
		if($sql_row['s27']>0) { $acut[]=$sql_row['s27'];}
		if($sql_row['s28']>0) { $acut[]=$sql_row['s28'];}
		if($sql_row['s29']>0) { $acut[]=$sql_row['s29'];}
		if($sql_row['s30']>0) { $acut[]=$sql_row['s30'];}
		if($sql_row['s31']>0) { $acut[]=$sql_row['s31'];}
		if($sql_row['s32']>0) { $acut[]=$sql_row['s32'];}
		if($sql_row['s33']>0) { $acut[]=$sql_row['s33'];}
		if($sql_row['s34']>0) { $acut[]=$sql_row['s34'];}
		if($sql_row['s35']>0) { $acut[]=$sql_row['s35'];}
		if($sql_row['s36']>0) { $acut[]=$sql_row['s36'];}
		if($sql_row['s37']>0) { $acut[]=$sql_row['s37'];}
		if($sql_row['s38']>0) { $acut[]=$sql_row['s38'];}
		if($sql_row['s39']>0) { $acut[]=$sql_row['s39'];}
		if($sql_row['s40']>0) { $acut[]=$sql_row['s40'];}
		if($sql_row['s41']>0) { $acut[]=$sql_row['s41'];}
		if($sql_row['s42']>0) { $acut[]=$sql_row['s42'];}
		if($sql_row['s43']>0) { $acut[]=$sql_row['s43'];}
		if($sql_row['s44']>0) { $acut[]=$sql_row['s44'];}
		if($sql_row['s45']>0) { $acut[]=$sql_row['s45'];}
		if($sql_row['s46']>0) { $acut[]=$sql_row['s46'];}
		if($sql_row['s47']>0) { $acut[]=$sql_row['s47'];}
		if($sql_row['s48']>0) { $acut[]=$sql_row['s48'];}
		if($sql_row['s49']>0) { $acut[]=$sql_row['s49'];}
		if($sql_row['s50']>0) { $acut[]=$sql_row['s50'];}

	}
	
	//var_dump($cat_ref_id);
	
	echo "<form name=\"input\" method=\"post\" action=\"".getFullURL($_GET['r'], "emb_or_new.php", "N")."\">";
	echo "<div class=\"table-responsive\"><table class=\"table table-bordered jumbo_table bulk_action\" style=\"color: #000000\">";
	echo "<tr><th>Sizes</th>";
	$sizes_db=array();
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			echo "<th>".strtoupper($sizes[$i])."</th>";
			$sizes_db[]=$sizes[$i];
		}
	}
	echo "</tr>";
	
	echo "<tr><th>Excess Acceptable Upto</th>";
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			echo "<th>".($acut[$i]-$qty[$i])."</th>";
		}
	}
	echo "</tr>";
	
	/*
	echo "<tr><th>Excess Cut</th>";
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			echo "<th>".($acut[$i]-$qty[$i])."</th>";
		}
	}
	echo "</tr>";
	*/
	
	$qms_qty_ref=array();
	echo "<tr><th>Samples<br/>Garments Sent so far</th>";
	$l=0;
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			
			$sql="select coalesce(sum(qms_qty),0) as \"qms_qty\"  from bai_emb_excess_db where  qms_schedule=\"".$schedule."\" and qms_color=\"".$color."\" and qms_size=\"".$sizes[$i]."\"";

			$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qms_qty=$sql_row['qms_qty'];
				$qms_qty_ref[$l]=$sql_row['qms_qty'];
			}
			
			//KiranG  2015-08-31 changed ASPR to ASPS 
			$sql="select coalesce(sum(sfcs_qty),0) as \"qms_qty\"  from m3_bulk_ops_rep_db.m3_sfcs_tran_log where  sfcs_schedule=\"".$schedule."\" and sfcs_color=\"".$color."\" and sfcs_size=\"".$sizes[$i]."\" and m3_op_des='ASPS' and sfcs_reason<>''";

			$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qms_qty+=$sql_row['qms_qty'];
				$qms_qty_ref[$l]+=$sql_row['qms_qty'];
			}
			
			//Samples input to be considered.
			$sample_qty=0;
			$sql="select COALESCE(sum(ims_qty),0) as ims_qty from bai_pro3.ims_log where ims_schedule='$schedule' and ims_color='$color' and ims_size='a_".$sizes[$i]."' and ims_remarks='SAMPLE'";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sample_qty=$sql_row['ims_qty'];	
			}
			
			$sql="select COALESCE(sum(ims_qty),0) as ims_qty from bai_pro3.ims_log_backup where ims_schedule='$schedule' and ims_color='$color' and ims_size='a_".$sizes[$i]."' and ims_remarks='SAMPLE'";
			//echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sample_qty+=$sql_row['ims_qty'];	
			}
			
			$qms_qty+=$sample_qty;
			$qms_qty_ref[$l]+=$sample_qty;
			
			$l++;
			
			echo "<th>".$sample_qty."<br/>".($qms_qty-$sample_qty)."</th>";
		}
	}
	echo "</tr>";
	
	echo "<tr><th>Update</th>";
	$l=0;
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			//echo "<th>".(($acut[$i]-$qty[$i])-$qms_qty_ref[$i])."</th>";
			echo "<th><input class=\"form-control integer\" type=\"text\" value=\"0\" name=\"qty[]\" autocomplete=\"off\"  onchange=\"if(this.value>".(($acut[$i]-$qty[$i])-$qms_qty_ref[$l]).") {this.value=0;}\"></th>";
			
			$l++;
		}
	}
	echo "</tr>";
	echo "</table></div><br><br>";
	
	echo "<table class=\"table table-bordered jumbo_table bulk_action\" style=\"color: #000000\">";
	
	/*
	$sql_del="select order_date from $table_name where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	$sql_result5=mysql_query($sql_del,$link) or exit("Sql Error".mysql_error());
	while($sql_row5=mysql_fetch_array($sql_result5))
	{
		$ex_date=$sql_row5["order_date"];
		//$ex_date="2012-02-15";
		echo "<tr><th>Ex-Fact Date</th><td>".$ex_date."</td></tr>";
		$dates=explode("-",$ex_date);
		$ex_dates=mktime(0,0,0,$dates[1],$dates[2],$dates[0]);
		$week=(int)date("W",$ex_dates);
		echo "<tr><th>Week No</th><td>".$week."</td></tr>";
	}
	*/
	//Capturing the Docket no of selected Style,Schedule and Color with cat reference
	if(count($cat_ref_id)>0){
		$sql_cat="select acutno,doc_no,color_code from order_cat_doc_mix where cat_ref in (".implode(",",$cat_ref_id).")";
		$sql_result_cat=mysqli_query($link, $sql_cat) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($sql_row_cat=mysqli_fetch_array($sql_result_cat))
		{
			$acutno_ref[]=chr($sql_row_cat['color_code'])."00".$sql_row_cat["acutno"];
			$doc_no_ref[]=$sql_row_cat["doc_no"];
		}	
	}else{
		echo "<h2>Data Issue!!</h2> No proper data is available Please try again..";
	}
	
	
	
	//Capturing the Recut Docket no of selected Style,Schedule and Color with cat reference
/*	$sql_cat="select acutno,doc_no from recut_v2 where cat_ref=\"".$cat_ref_id."\"";
	$sql_result_cat=mysql_query($sql_cat,$link) or exit("Sql Error".mysql_error());
	while($sql_row_cat=mysql_fetch_array($sql_result_cat))
	{
		$acutno_ref[]="R".$sql_row_cat["acutno"];
		$doc_no_ref[]="R".$sql_row_cat["doc_no"];
	}
	*/
	
	echo "<input type=\"hidden\" name=\"sizes\" value=\"".implode(",",$sizes_db)."\">";
	echo "<input type=\"hidden\" name=\"style\" value=\"".$style."\">";
	echo "<input type=\"hidden\" name=\"schedule\" value=\"".$schedule."\">";
	echo "<input type=\"hidden\" name=\"color\" value=\"".$color."\">";
	
	echo "<tr><th>Garment Category: </th><td><div class=\"col-md-4\"><select class=\"form-control\" name=\"gtype\" id=\"gtype\" >";
	echo "<option value=\"Good Garments\">Good Garments</option>";
	//echo "<option value=\"Without Label\">Without Label</option>";
	//echo "<option value=\"Without Heatseal\">Without Heatseal</option>";
	//echo "<option value=\"Panel form\">Panel Form</option>";
	//Date 2013-11-15
	//Added semi stitched option
	//echo "<option value=\"Semi Stitched\">Semi Stitched</option>";
	echo "</select></div></td></tr>";
	
	echo "<tr><th>Cut No : *</th><td><div class=\"col-md-4\"><select class=\"form-control\" name=\"doc_ref\" id=\"doc_ref\" >";
	for($i2=0;$i2<sizeof($doc_no_ref);$i2++)
	{
		echo "<option value=\"".$doc_no_ref[$i2]."\">".$acutno_ref[$i2]."</option>";
	}
	echo "</select></div></td></tr>";
	echo "<tr><th>Shift: </th><td>
	<div class=\"col-md-4\"><select class=\"form-control\" name=\"sourceid\" id=\"sourceid\" >
	<option value=\"A\">A</option>
	<option value=\"B\">B</option>
	</select></div></td></tr>";
	
	echo "<tr><th>Module: *</th><td><div class=\"col-md-4\"><select class=\"form-control\" name=\"source\" id=\"source\" >";
	echo "<option value=\" \"></option>";
	//echo "<option value=\"-1\">Production (O.R)</option>";
	//echo "<option value=\"SAM\">Sample (O.R)</option>";
	//echo "<option value=\"ENP\">Embellishment (O.R)</option>";
	//Added cutting, packing and fg in source departments
	//echo "<option value=\"CUT\">Cutting (O.R)</option>";
	//echo "<option value=\"PCK\">Packing (O.R)</option>";
	//echo "<option value=\"FG\">FG (O.R)</option>";
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
	echo "</select></div></td></tr>";

	//echo "<tr><td colspan='2'><input type=\"submit\" name=\"update\" value=\"Update\"></td></tr>";
	
	echo "</table>";
	echo "<input class=\"btn btn-primary btn-sm\" type=\"submit\" name=\"update\" value=\"Update\" id=\"add\" onclick=\"return fill_up();\">";
	echo "</form>";
	

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
	$temp="0";
	
	//echo $source."-".$doc_no_id;
	
	$usr_msg="The following entries are failed to update due to M3 system validations:<br/>
				<table class=\"table table-bordered jumbo_table bulk_action\">
					<tr><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
	
		//M3 Bulk Operation Reporting
		
	
	for($i=0;$i<sizeof($sizes_db);$i++)
	{
		
		$sql="select tid from packing_summary where order_del_no=$schedule and size_code='".$sizes_db[$i]."' AND (LEFT(STATUS,1) NOT IN ('D','E') OR STATUS IS NULL)";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//echo mysql_num_rows($sql_result);
			
		if($qty[$i]>0)
		{
			//rejection_validation_m3($m3_operation_code,$schedule,$color,$sizes_db[$i],$qty[$i],0,$username)=='TRUE' and
			if($qty[$i]>0 and m3_cpk_validation('ASPS','SOT',$schedule,$color,$sizes_db[$i],$qty[$i])=='TRUE' and mysqli_num_rows($sql_result)==0)
			{
				//Changed Query for capturing the docket number
				$sql="insert into bai_emb_excess_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,remarks,log_date,ref1,doc_no) values (\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$sizes_db[$i]."\",".$qty[$i].",$temp,\"".$source."\",\"".date("Y-m-d")."\",\"$gtype\",\"$doc_no_id\")";
				//echo $sql."<br>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$usr_msg.="<tr><td>".$schedule."</td><td>".$color."</td><td>".$sizes_db[$i]."</td><td>".$qty[$i]."</td></tr>";
			}
		}
	}
	$usr_msg.="</table>";
	
	
	//Validations
	echo $usr_msg;
	
	echo "<h2>Successfully Updated.</h2>";
}

?>
</div></div>
</div>
</body>

<?php
if(isset($_GET['color']))
     echo "<script>document.getElementById('sub').disabled = false;</script>";
?>