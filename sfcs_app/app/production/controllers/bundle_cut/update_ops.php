<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
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
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>

<script language="javascript" type="text/javascript">


function update_reject(x,quantity)
{
	//alert(x);
	//alert(quantiy);
	var i=x;
	var j=quantity;
	var k=j-i;
	//alert(k);
	//var j=quantity;	
	//var r=document.getElementById('reject').value;
	if(j >= i)
	{
		//alert("Text");
		document.getElementById('quantity').value=j-i;
	}
	else
	{
		alert("Please update correct quantity.");
		document.getElementById('reject').value=0;
		document.getElementById('quantity').value=j;
	}
	//alert("Test");
}


</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Bundle Updation form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php
// include('dbconf.php');
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
?>


<?php
if($_GET['ops'] == 1)
{
	$id=$_GET['id'];
	$mod_id=$_GET['mod_id'];
	$bundle_barcode=$_GET['bundle_id'];
	$bundle_details=explode("-",$bundle_barcode);
	$bundle_id = ltrim($bundle_details[0], '0');
	$operation_id = ltrim($bundle_details[1], '0');
	if($operation_id==1)
	{
		$qty=echo_title("$brandix_bts.tbl_miniorder_data","quantity","bundle_number",$bundle_id,$link);
		//$reject_already=echo_title("bundle_transactions_20_repeat","rejection_quantity","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
	}
	else
	{
		$qty=echo_title("$brandix_bts.bundle_transactions_20_repeat","quantity","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
		//$reject_already=echo_title("bundle_transactions_20_repeat","rejection_quantity","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
	}	
	
	?>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
	<?php
	echo "<input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"hidden\" value=\"$mod_id\" name=\"mod_id\">";
	echo "<table class='table table-bordered'><tr><th>Bundle Number</th><th>Operation</th><th>Bundle Quantity</th><th>Rejection Quantity</th><th colspan=2>Control</th></tr>";
	$sql="select * from $brandix_bts.bundle_transactions_20_repeat where bundle_id='$bundle_id' and operation_id='$operation_id'";
	$result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{
		echo "<tr><td><input type=\"hidden\" name='bundle_id' value='".$row['bundle_id']."' id='bundle_id'>".$row['bundle_id']."</td>
		<td><input type=\"hidden\" name='ops' value='".$row['operation_id']."' id='ops'>".$row['operation_id']."</td>
		<td><input type=\"textbox\" name='quantity' value='".$qty."' id='quantity' readonly='true'>".$qty."</td>
		<td><input type=\"textbox\" name='reject' value='".$row['rejection_quantity']."' onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value='0';}\" id='reject' onkeyup=\"update_reject(this.value,".$qty.")\"></td>
		<td><input type=\"submit\" name=\"rejects\" value=\"Update\" id=\"rejects\"  onclick=\"document.getElementById('rejects').style.display='none'; document.getElementById('msg').style.display='';\"><span id=\"msg\" style=\"display:none;\">Please Wait...</span></td>
		<td><input type=\"submit\" name=\"cancel\" value=\"Cancel\" id=\"cancel\" onclick=\"document.getElementById('cancel').style.display='none'; document.getElementById('msg').style.display='';\"><span id=\"msg\" style=\"display:none;\">Please Wait...</span></td>
		</tr>";
	}
	?>
	</table>
	</form>
	<?php
}

if($_GET['ops'] == 2)
{
	//echo "Test"."<br>";
	$id=$_GET['id'];
	$mod_id=$_GET['mod_id'];
	$bundle_barcode=$_GET['bundle_id'];
	$bundle_details=explode("-",$bundle_barcode);
	$bundle_id = ltrim($bundle_details[0], '0');
	$operation_id = ltrim($bundle_details[1], '0');
	$sql="delete from $brandix_bts.bundle_transactions_20_repeat where bundle_id='".$bundle_id."' and operation_id='".$operation_id."'";
	//echo $sql."<br>";
	//echo $id."--".$bid."--".$ops_id."--".$reject."<br>";
	$result=mysqli_query($link, $sql) or exit("Sql Error-reject_update5".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$url=getFullURLLevel($_GET['r'],'bundle_scan_ops.php',0,'N');
	
	header("Location:$url&update_ajax=2&id=$id&mod_id=$mod_id");
}
if(isset($_POST['rejects']))
{
	//echo "Test"."<br>";
	$id=$_POST['id'];
	$mod_id=$_POST['mod_id'];
	$bid=$_POST['bundle_id'];
	$ops_id=$_POST['ops'];
	$reject=$_POST['reject'];
	if($ops_id==1)
	{
		$qty=echo_title("$brandix_bts.tbl_miniorder_data","quantity","bundle_number",$bid,$link);
	}
	else
	{
		$qty=echo_title("$brandix_bts.bundle_transactions_20_repeat","quantity","operation_id='".$ops_id."' and bundle_id",$bid,$link);
	}
	//$qty-$reject;	
	if((($qty-$reject)>0 and $reject>0) or (($qty-$reject)==0 and $reject>0)) //to avoid -ve values in output reporting #2611 reopen ticket on 15-02-2018
	{
		$sql="update $brandix_bts.bundle_transactions_20_repeat set quantity=($qty-$reject),rejection_quantity=".$reject." where bundle_id='".$bid."' and operation_id='".$ops_id."'";
		$result=mysqli_query($link, $sql) or exit("Sql Error-reject_update5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql1="update $brandix_bts_uat.view_set_1_snap set bundle_transactions_20_repeat_quantity=($qty-$reject),bundle_transactions_20_repeat_rejection_quantity='".$reject."' where bundle_transactions_20_repeat_id='".$id."' and bundle_transactions_20_repeat_operation_id='".$ops_id."'";
		$result1=mysqli_query($link, $sql1) or exit("Sql Error-reject_update5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql13="update $brandix_bts_uat.view_set_snap_1_tbl set bundle_transactions_20_repeat_quantity=($qty-$reject),bundle_transactions_20_repeat_rejection_quantity='".$reject."' where bundle_transactions_20_repeat_id='".$id."' and bundle_transactions_20_repeat_operation_id='".$ops_id."'";
		$result1=mysqli_query($link, $sql13) or exit("Sql Error-reject_update5".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$url=getFullURLLevel($_GET['r'],'bundle_scan_ops.php',0,'N');
	header("Location:$url&update_ajax=1&id=$id&mod_id=$mod_id");
}
if(isset($_POST['cancel']))
{
	//echo "Test"."<br>";
	$id=$_POST['id'];
	$mod_id=$_POST['mod_id'];
	$bid=$_POST['bundle_id'];
	$ops_id=$_POST['ops'];
	$reject=$_POST['reject'];
	$url=getFullURLLevel($_GET['r'],'bundle_scan_ops.php',0,'N');
	header("Location:$url&update_ajax=3&id=$id&mod_id=$mod_id");
}
?>