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
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
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
	var ajax_url ="miniorder_recon.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function check_val()
{
	//alert('dfsds');
	var bundle=document.getElementById('bundle').value;
	var emp_no=document.getElementById('emp_no').value;
	var remark=document.getElementById('remark').value;
	//var bundle=document.getElementById('bundle_id').value;
	//alert(bundle);
	//alert(emp_no);
	//alert(remark);
		if(bundle=='' || emp_no=='' || remark=='0')
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
<div id="page_heading"><span style="float: left"><h3>Bundle Re-print form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php 

include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0249",$username,1,$group_id_sfcs); 

?>

<?php


error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include("dbconf.php");
?>

<form name="mini_order_report" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit=" return check_val();">
<br>
Bundle Number&nbsp;&nbsp;<input type="text" size="8" name="bundle" id="bundle" value="<?php echo $_POST['bundle']?>"/>
&nbsp;&nbsp;&nbsp;&nbsp;

Shift <select name="shift">
<?php
$sql1="select * from brandix_bts.tbl_shifts_master";
$result1=mysqli_query($link, $sql1) or exit("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($result1))
{
	if(str_replace(" ","",$sql_row1['id'])==str_replace(" ","",$shift))
	{
		echo "<option value=\"".$sql_row1['id']."\" selected>".$sql_row1['shift_name']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row1['id']."\">".$sql_row1['shift_name']."</option>";
	}
	
}
?>

</select>
&nbsp;&nbsp;&nbsp;&nbsp;
Module <select name="module">
<?php
$sql="select * from brandix_bts.tbl_module_ref";
$result=mysqli_query($link, $sql) or exit("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result))
{
	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$module))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['id']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['id']."</option>";
	}
	
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
Employee Id : <input type="textbox" name="emp_no" value="<?php echo $_POST['emp_no']?>">
Remarks : <select name='remark' id='remark'>
<option value=0>----Select-----</option>
<option value='Human Error' <?php if($_POST['remark']=='Human Error'){ echo "selected";} else{ echo "";}?>>Human error</option>
<option value='Tag card miss in production' <?php if($_POST['remark']=='Tag card miss in production'){ echo "selected";} else{ echo "";}?>>Others</option>
<option value='Sticker is not scanning' <?php if($_POST['remark']=='Sticker is not scanning'){ echo "selected";} else{ echo "";}?>>Sticker is not scanning</option>
<option value='Tag card miss in production' <?php if($_POST['remark']=='Tag card miss in production'){ echo "selected";} else{ echo "";}?>>Tag card Miss in Production Area</option>
</select>
<input type="submit" value="Show" name="show">
</form>


<?php
if(isset($_POST['show']))
{

	$bundle=$_POST['bundle'];
	$emp_no=$_POST['emp_no'];
	$module=$_POST['module'];
	$shift=$_POST['shift'];
	$remark=$_POST['remark'];
	if($shift=='1')
	{
		$shift_val='A';
	}
	else if($shift=='2')
	{
		$shift_val='B';
	}
	
	$mini_order_ref = echo_title("brandix_bts.tbl_miniorder_data","mini_order_ref","bundle_number",$bundle,$link);
	$mini_order_num = echo_title("brandix_bts.tbl_miniorder_data","mini_order_num","bundle_number",$bundle,$link);
	if($mini_order_num>0)
	{
		//$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
		//$style = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
		//$miniordr = echo_title("brandix_bts.tbl_miniorder_data","count(distinct mini_order_num)","mini_order_ref",$miniord_ref,$link);
		//$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
		
		$sql="insert into brandix_bts.re_print_table(bundle_id,emp_id,module_id,shift,user_name,remark) values('".$bundle."','".$emp_no."','".$module."','".$shift_val."','".$username."','".$remark."')";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit($sql."<br/> Error in section table ");
		echo "<table border=1px><tr><th rospan=2>You are going to take bundle print</th>";
		echo "<td rospan=2><a href=\"..\..\packing\labels\mpdf50\\examples\bundle_tag_gen.php?bundle=$bundle&ops=3\" target=\"_blank\" >Print Ticket</a></td></tr>";
		
			//echo "<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule_result&mini_num=$mini_num','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$status</span></td></tr>";
			//unset($scan_bundle);
			//$scan_total=0;
		echo "</table>";
	}
	else
	{
		echo "<h2>Bundle Does not exists.</h2>";
	}	
}


?> 
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