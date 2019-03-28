<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
<!---<style type="text/css">
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
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	window.location.href ="miniorder_recon.php?style="+document.mini_order_report.style.value
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
<div class="panel panel-primary">
<div class="panel-heading">Bundle Re-print form</div>
<div class="panel-body">
<!---<div id="page_heading"><span style="float: left"><h3>Bundle Re-print form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<form name="mini_order_report" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class='col-md-3 col-sm-3 col-xs-12'>
Bundle Number&nbsp;&nbsp;<input type="text" size="8" name="bundle" class="form-control" id="bundle" value="<?php echo $_POST['bundle']?>"/required>
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
Shift <select name="shift" class="select2_single form-control">
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
for ($i=0; $i < sizeof($shifts_array); $i++) {
echo'<option value='.$shifts_array[$i].'>'.$shifts_array[$i].'</option>';
}
?>

</select>
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
Module <select name="module" class="select2_single form-control">
<?php
$sql="SELECT * FROM $bai_pro3.`module_master` ORDER BY module_name*1 ASC";
$result=mysqli_query($link, $sql) or exit("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result))
{
	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$module))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['module_name']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['module_name']."</option>";
	}
	
}
?>
</select>
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
Employee Id : <input type="textbox" class="form-control" name="emp_no" value="<?php echo $_POST['emp_no']?>"/required>
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
Remarks : <select name='remark' id='remark' class='select2_single form-control'>
<option value=0>----Select-----</option>
<option value='Human Error' <?php if($_POST['remark']=='Human Error'){ echo "selected";} else{ echo "";}?>>Human error</option>
<option value='Tag card miss in production' <?php if($_POST['remark']=='Tag card miss in embellishment area'){ echo "selected";} else{ echo "";}?>>Tag card miss in Embellishment Area</option>
<option value='Sticker is not scanning' <?php if($_POST['remark']=='Sticker is not scanning'){ echo "selected";} else{ echo "";}?>>Sticker is not scanning</option>
<option value='Tag card missed in production' <?php if($_POST['remark']=='Tag card miss in production'){ echo "selected";} else{ echo "";}?>>Tag card Miss in Production Area</option>
<option value='Tag card missed in Cuttin Area' <?php if($_POST['remark']=='Tag card miss in Cuttin Area'){ echo "selected";} else{ echo "";}?>>Tag card Miss in Cutting Area</option>
<option value='Tag card miss in production' <?php if($_POST['remark']=='Tag card miss in production'){ echo "selected";} else{ echo "";}?>>Others</option>
</select>
</div>
<div class='col-md-2 col-sm-2 col-xs-12' style='margin-top: 18px;'>
	<input type="submit" value="Show" class="btn btn-primary" name="show">
</div>
</form>
<div class='col-md-1 col-sm-1' style='margin-left:79%;margin-top:-4%;'>
   <?php
   $url = getFullURLLevel($_GET['r'],'reprint_report.php',0,'R');
   echo "<td><a class='btn btn-primary' href='$url' onclick=\"return popitup2('$url')\" target='_blank'><i aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Re-Printed Tags History</a></td>";
   ?>
</div>


<?php
if(isset($_POST['show']))
{

	$bundle=$_POST['bundle'];
	$emp_no=$_POST['emp_no'];
	$module=$_POST['module'];
	$shift=$_POST['shift'];
	$remark=$_POST['remark'];
	
	//validating bundlebarcode existing or not
	$sql_validating_barcode="select * from $bai_pro3.packing_summary_input where tid='$bundle'";
	$sql_result=mysqli_query($link, $sql_validating_barcode) or exit($sql_validating_barcode."<br/> Error in section table ");
	$no_rows=mysqli_num_rows($sql_result);
	if($no_rows>0)
	{
		$sql="insert into $brandix_bts.re_print_table(bundle_id,emp_id,module_id,shift,user_name,remark) values('".$bundle."','".$emp_no."','".$module."','".$shift."','".$username."','".$remark."')";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit($sql."<br/> Error in section table ");
		echo "<table class='table table-bordered'><tr><th rospan=4>You are going to take bundle print</th>";
		$url1 = getFullURLLevel($_GET['r'],'reprint_tagwith_operation.php',0,'R');
		echo "<td><a class='btn btn-info btn-sm' href='$url1?bundle_id=".$bundle."' onclick=\"return popitup2('$url1?bundle_id=".$bundle."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Operation</a></td>";
		$url2 = getFullURLLevel($_GET['r'],'reprint_tagwithout_operation.php',0,'R');
		echo "<td><a class='btn btn-info btn-sm' href='$url2?bundle_id=".$bundle."' onclick=\"return popitup2('$url2?bundle_id=".$bundle."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Out Operation</a></td>";
		echo "</tr>";
		echo "</table>";
	}
	else
	{
		echo "<script>swal('Bundle Does not exists','','warning');</script>";
	}	
}


?>
</div>
</div>
</body> 