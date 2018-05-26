<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/

h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	var url1 = '<?= getFullUrl($_GET['r'],'bundle_tag_gen.php','N'); ?>';
	window.location.href = url1+"&style="+document.mini_order_report.style.value;
}

function secondbox()
{
	//alert('test');
	var url1 = '<?= getFullUrl($_GET['r'],'bundle_tag_gen.php','N'); ?>';
	window.location.href = url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
}

function check_val()
{
	//alert('dfsds');
	var style=document.bundle_operation.style.value;
	var c_block=document.bundle_operation.c_block.value;
	var schedule=document.bundle_operation.schedule.value;
	var barcode=document.bundle_operation.barcode.value;
	//alert(style);
	//alert(c_block);
	//alert(schedule);
		if(style==0 || c_block=='NIL' || schedule=='NIL' || barcode=='NIL')
		{
			alert('Please select the values');
			return false;
		}
		
}

function check_val_2()
{
	//alert('dfsds');
	
	var count=document.barcode_mapping_2.count_qty.value;
	//alert(count);
	//alert('qty');
	var check_exist=0;
	for(i=0;i<5;i++)
	{
		var qty=document.getElementById("qty["+i+"]").value;
		if(qty!=0)
	    {
			var check_exist=1;
		}
	}
	if(check_exist==0)
	{
		alert('Please fill the values');
		return false;
	}
	//return false;	
}
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('txtPhn');
//comparing pressed keycodes
if ((keycode < 48 || keycode > 57) && (keycode<46 || keycode>47))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Binding Tag Generation</div>
<div class="panel-body">

<?php 
// include("dbconf.php"); 
// include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0288",$username,1,$group_id_sfcs);
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$static=array(1,2,3,4,5,6,7);
$dynamic=array(8,9,10,11,12,13,14,15,16,17,18,19,20);
if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$mini_order_ref=echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	// $mini_order_ref=echo_title("brandix_bts.tbl_miniorder_data","id","ref_crt_schedule",$schedule,$link);
	//$mini_order_num=$_POST['mini_order_num']; 
	
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$mini_order_ref=echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	//$mini_order_num=$_GET['mini_order_num'];
	$color=$_GET['color']; 
}

//echo $style.$schedule.$color;
?>

<form name="mini_order_report" id="mini_order_report" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class="form-group col-lg-2">
<label>Select Style:</label>
<?php

echo "<select name=\"style\" id='style' onchange=\"firstbox();\" class='form-control'>";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref";	
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
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

?>
</div>
<div class="form-group col-lg-2">
<label>Select Schedule:</label>
<?php

echo "<select name=\"schedule\" id='schedule' onchange=\"secondbox();\" class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";	
	//$sql="select product_schedule as schedule,id from tbl_orders_master where ref_product_style=$style group by schedule";
//}
//echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
/*
if(str_replace(" ","",0)==str_replace(" ","",$c_block))
{
echo "<option value=\"0\" selected>All Country blocks</option>";
}
else
{
	echo "<option value=\"0\">All Country block</option>";
}*/
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
}

}


echo "</select>";

?>
</div>
<div class="col-lg-2 form-group">
<label>Select Color:</label>
<?php

echo "<select name=\"color\" id='color' class='form-control'>";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct color from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'";	
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['color'])==str_replace(" ","",$color))
	{
		echo "<option value=\"".$sql_row['color']."\" selected>".$sql_row['color']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['color']."\">".$sql_row['color']."</option>";
	}

}

echo "</select>";

?>
</div>
<div class="form-group col-lg-2">
 <?php
	echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
	echo "<input class='btn btn-primary' type=\"submit\" value=\"submit\" name=\"submit\" style='margin-top: 20px'>";	
?>
</div>


</form>


<?php
if(isset($_POST['submit']))
{

	
	$style_code=$_POST['style'];
	//$color=$_POST['color'];
	$shcedule_code=$_POST['schedule'];
	$color=$_POST['color'];
	
	//$schedule=$_POST['schedule'];
	$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	//$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
	$order_tid=$style.$schedule.$color;
	$sql33="select * from bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$color_code=$sql_row33['color_code']; //Color Code
	}
	$data_sym="$";
	$File = "bundle_tag_code.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."style=\"".$style."\"; ".$data_sym."schedule=\"".$schedule."\"; ".$data_sym."color=\"".$color."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	$sql="select * from bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<table class='table table-bordered' border=1px><tr><th>Color</th><th>Cut No</th><th>Control</th></tr>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$print_url = getFullUrl($_GET['r'],'bundle_tag_gen_print.php','N');
		//echo $cutno."<br>";
		$cutno=$sql_row['acutno'];
		$doc_no=$sql_row['doc_no'];
		$cut_code=chr($color_code).leading_zeros($cutno,3);
		$cut_pcs=$sql_row['a_plies'];
		echo "<tr><td>".$color."</td>";
		echo "<td>".$cut_code."</td>";
		echo "<td><a href=\"$print_url&order_tid=$order_tid&doc_no=$doc_no&col_code=$color_code\" target=\"_blank\">Click Here to print</a></td></tr>";
	}
	echo "</table>";
	
}
?> 
</div>
</div>

<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>