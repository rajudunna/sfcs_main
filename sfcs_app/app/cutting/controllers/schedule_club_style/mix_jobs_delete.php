<html>
<head>

<?php
include($_SERVER['DOCUMENT_ROOT']."/server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/server/group_def.php"); 
$view_access=user_acl("SFCS_0092",$username,1,$group_id_sfcs); 
?>

<?php include("header_scripts.php"); 
include("dbconf.php");

//Add extrac cut quantities to first cut of first schedule
$add_excess_qty_to_first_sch=1; //0-Yes, 1-NO
?>
<?php include("menu_content.php"); ?>


<script>

function firstbox()
{
	window.location.href ="mix_jobs.php?style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="mix_jobs.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="mix_jobs.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>
</head>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<body>

<style>
body
{
	font-family:calibri;
	font-size:12px;
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
	text-align: right;
white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>
<div id="page_heading"><span style="float: left"><h3>Mixed Schedule : Job Segregation Panel (PO Level)</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form name="test" method="post" action="mix_jobs.php">

<?php

$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
$po=$_GET['po'];

if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	$po=$_POST['po'];
}


echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from bai_orders_db where order_joins=\"1\" and order_style_no not in ('H18122AA       ','I292550A       ','I292553A       ','I292580A       ','I292653A       ','I296643A       ','I96632AA       ','I96646AA       ','I97183AA','IDUMY929','M04600AA       ','M04600AB       ','M04600AC','M04634AD       ','M04634AE       ','M04634AF','M04634AG','M04641AA       ','M04648AA','M04649AA','M05083AA','M06484AQ       ','M06484AR','M06485AP       ','M07562AA','M09313AE       ','M09313AG       ','M09313AH','M4600GAA       ','M4634LAA','M4634RAA','M7028AAE       ','M7028AAF','N12201AE       ','N19201AD       ','N19801AB       ','N19801AC       ','N7118SAH       ','N7118SAI       ','S16580AA       ','S174815A       ','S174815B       ','S174815C       ','S17761AA       ','S17761AB       ','S17761AC       ','S17764AA       ','S17764AB       ','S17764AC       ','S17767AA       ','S17767AB       ','S17767AC       ','S17775AA       ','S17775AB       ','S17775AC       ','S19876AA       ','S19879AA       ','S19965AA       ','U10098AJ       ','U10217AH       ','U10217AI','U20128AH       ','U20128AI','U30002AH       ','U30002AI','U30148AK       ','U30148AL','U50027AK       ','U50027AL','U60116AK       ','U60117AK       ','U60117AL','U90008AH       ','U90008AI','YCI028AA','YCI278AA','YCI404AA','YCI553AA','YCI931AA','YCL028AA','YCL278AA','YCL404AA','YCL553AA','YCL931AA','YSI028AA','YSI278AA','YSI404AA','YSI553AA','YSI931AA') order by order_style_no";	
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
?>


<?php

echo "Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from bai_orders_db where order_style_no=\"$style\" and order_joins=\"1\" order by order_date";	
//}
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysql_fetch_array($sql_result))
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

echo "Select Color: <select name=\"color\" onchange=\"thirdbox();\" >";
$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins=\"1\"";
//}
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysql_fetch_array($sql_result))
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

<!-- <input type="text" name="schedule" value=""> -->
<?php 
if(strlen($color)>0 and $color!="NIL"){
	//echo '<input type="submit" name="submit" value="Segregate">';
	echo "<input type=\"submit\" value=\"Clear\" name=\"clear\"  id=\"clear\" onclick=\"document.getElementById('clear').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
	echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait data is processing...!<h5></span>";
}

?>
</form>

</body>
</html>

<?php

if(isset($_POST['clear']))
{
	$order_del_no=$_POST['schedule'];
	$order_joins="J".$order_del_no;
	$style=$_POST['style'];
	$color=$_POST['color'];
	$docs=array();
	$sql="slect * from bai_pro3.plando_stat_log where order_tid like \"%".$schedule."%\"";
	$sql_result451=mysql_query($sql,$link) or die("Error".$sql451.mysql_error());
	if(mysql_num_rows($sql_result451)>0)
	{
		while($sql_row457=mysql_fetch_array($sql_result451))
		{		
			$docs[]=$sql_row457["doc_no"];
		}
		$sql4533="select order_tid from bai_pro3.bai_orders_db where order_joins='J".$order_del_no."' and order_col_des=\"".$color."\"";
		$sql_result4533=mysql_query($sql4533,$link) or die("Error".$sql4533.mysql_error());
		while($sql_row4533=mysql_fetch_array($sql_result4533))
		{
			$order_tids[]=$sql_row4533["order_tid"];
		}
		$sql32="slect * from brandix_bts.tbl_miniorder_data where docket_number in (select doc_no from bai_pro3.pladoc_stat_log wherer org_doc_no in (".implode(",",$docs)."))";
		$sql_result451=mysql_query($sql32,$link) or die("Error".$sql451.mysql_error());
		if(mysql_num_rows($sql_result451)==0)
		{
			$sql4536="delete from bai_pro3.allocate_stat_log where order_tid in ('".implode("','",$order_tids)."')";
			echo $sql4536."<br>";
			//$sql_result4536=mysql_query($sql4536,$link) or die("Error".$sql4536.mysql_error());
			
			// $sql323="slect * from brandix_bts.tbl_cut_size_master where preant_id in (slect id from brandix_bts.tbl_cut_master where doc_no in (slect doc_no from bai_pro3.plando_stat_log where org_doc_no in (".implode(",",$docs).")))";
			// $sql_result4513=mysql_query($sql323,$link) or die("Error".$sql451.mysql_error());
						
			// $sql43="slect * from brandix_bts.tbl_cut_master where doc_no in (slect doc from bai_pro3.plando_stat_log where org_doc_no in (".implode(",",$docs)."))";
			// $sql_result4514=mysql_query($sql43,$link) or die("Error".$sql451.mysql_error());
			
			$sql1="slect * from bai_pro3.plando_stat_log where org_doc_no in (".implode(",",$docs).")";
			echo $sql1."<br>";
			//$sql_result4513=mysql_query($sql1,$link) or die("Error".$sql451.mysql_error());
			
			$sql45331="update bai_pro3.bai_orders_db set order_joins='1' where order_order_del_no='".$order_del_no."' and order_col_des=\"".$color."\"";
			$sql_result45313=mysql_query($sql45331,$link) or die("Error".$sql4533.mysql_error());
			
			$sql45331="update bai_pro3.bai_orders_db_confirm set order_joins='1' where order_order_del_no='".$order_del_no."' and order_col_des=\"".$color."\"";
			$sql_result45313=mysql_query($sql45331,$link) or die("Error".$sql4533.mysql_error());
						
		}
		else
		{
			echo "<h3>Mini orders are preapred please delete and try again.</h3>";
		}
	}
}
?>