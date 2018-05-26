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
	window.location.href ="../mini_order_report/mini_order_report.php?style="+document.mini_order_report.style.value
}

function secondbox()
{
	//alert('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
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
<div id="page_heading"><span style="float: left"><h3>Bundle Scanning Form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php include("dbconf.php"); ?>

<?php
error_reporting(0);
$shift=$_POST['shift'];
$module=$_POST['module'];
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
//$view_access=user_acl("SFCS_0273",$username,1,$group_id_sfcs);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
?>

<form action="bundle_scan_form.php" method="post">
<table class="mytable1" border=0 cellpadding=0 cellspacing=0>
<tr><th>Select Hour:</th>
<td><select name="stime"><?php
			for($l=6;$l<=22;$l++)
			{
				if($l<13)
					{
						if($l==12)
						{
							echo "<option value=\"".$l."\">".$l." P.M</option>";
						}
						else
						{
							echo "<option value=\"".$l."\">".$l." A.M</option>";
						}	
					}
					else
					{
						$r=$l-12;
						echo "<option value=\"".$l."\">".$r." P.M</option>";
					}
								
			}
	?></select></td>
<th>Shift:</th><td> <select name="shift">
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
</td>
<th>Module:</th><td> <select name="module">
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
</select></td>
<th>Employee Id :</th><td> <input type="textbox" autocomplete="off" name="emp_no" value="<?php echo $_POST['emp_no']?>"></td>
<td><td><span id="msg" style="display:none;">Please Wait...</span>
	<input type="submit" name="submit" value="Submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"></td>
</table>

</form>


<?php
if(isset($_POST['submit']))
{

	
	$emp_id=$_POST['emp_no'];
	$module_id=$_POST['module'];
	$time=$_POST['stime'];
	$shift=$_POST['shift'];
	$cr=date("Y-m-d H:i:s");
	//$cr=date("Y-m-d h:i:s");
	//$cr="2016-09-24 12:00:00";
	$hour=date("H",strtotime($cr));
	//$date_cur=date()
	//echo $emp_id."--".$module_id."---".$shift."<br>";
	//echo $date."<br>";
	//echo $time."<br>";
	//$sql="insert into(date_time,operation_time,employee_id,shift,trans_status,module_id) values('".date("Y-m-d H:i:s")."','$date $time:00','".$emp_id."','".$shift."','Yes','".$module_id."')";
	$sql="INSERT INTO `brandix_bts`.`bundle_transactions` (`date_time`, `operation_time`, `employee_id`, `shift`, `trans_status`, `module_id`) VALUES ('".date("Y-m-d $time:i:s")."','".date("Y-m-d h:i:s")."','".$emp_id."','".$shift."','Yes','".$module_id."')";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
	//echo $id."<br>"
	header("Location:bundle_scan_ops.php?id=$id&module=$module_id&hr=$hour");
	//$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","group_concat(id)","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	//$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
	//echo $bundles."<br>";

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