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


function update_reject(x,quantity)
{
	//swal(x);
	//swal(quantiy);
	var i=x;
	var j=quantity;
	var k=j-i;
	//swal(k);
	//var j=quantity;	
	//var r=document.getElementById('reject').value;
	if(j >= i)
	{
		//swal("Text");
		document.getElementById('quantity').value=j-i;
	}
	else
	{
		swal("Please update correct quantity.");
		document.getElementById('reject').value=0;
		document.getElementById('quantity').value=j;
	}
	//swal("Test");
}


</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Bundle Updation form</div>
	<div class="panel-body">
<?php
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
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
		$qty=echo_title("tbl_miniorder_data","quantity","bundle_number",$bundle_id,$link);
		//$reject_already=echo_title("bundle_transactions_20_repeat","rejection_quantity","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
	}
	else
	{
		$qty=echo_title("bundle_transactions_20_repeat","quantity","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
		//$reject_already=echo_title("bundle_transactions_20_repeat","rejection_quantity","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
	}	
	
	?>
	<form method="POST" action="?r=<?php echo $_GET['r']; ?>" >
	<?php
	echo "<input type=\"hidden\" value=\"$id\" name=\"id\"><input type=\"hidden\" value=\"$mod_id\" name=\"mod_id\">";
	echo "<table class='table table-bordered' border='1px' ><tr><th>Bundle Number</th><th>Operation</th><th>Bundle Quantity</th><th>Rejection Quantity</th><th colspan=2>Control</th></tr>";
	$sql="select * from $brandix_bts.bundle_transactions_20_repeat where bundle_id='$bundle_id' and operation_id='$operation_id'";
	$result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{
		echo "<tr><td><input type=\"hidden\" name='bundle_id' value='".$row['bundle_id']."' id='bundle_id'>".$row['bundle_id']."</td>
		<td><input type=\"hidden\" name='ops' value='".$row['operation_id']."' id='ops'>".$row['operation_id']."</td>
		<td><input type=\"textbox\" class='form-control' name='quantity' value='".$qty."' id='quantity' readonly='true'>".$qty."</td>
		<td><input type=\"textbox\" class='form-control' name='reject' value='".$row['rejection_quantity']."' onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value='0';}\" id='reject' onkeyup=\"update_reject(this.value,".$qty.")\"></td>
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
	$url_01 =  getFullUrl($_GET['r'],'bundle_scan_ops.php','N');
	header("Location:$url_01&update_ajax=2&id=$id&mod_id=$mod_id");
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
		$qty=echo_title("tbl_miniorder_data","quantity","bundle_number",$bid,$link);
	}
	else
	{
		$qty=echo_title("bundle_transactions_20_repeat","quantity","operation_id='".$ops_id."' and bundle_id",$bid,$link);
	}
	//$qty-$reject;	
	if((($qty-$reject)>0 and $reject>0) or (($qty-$reject)==0 and $reject>0)) //to avoid -ve values in output reporting #2611 reopen ticket on 15-02-2018
	{
	$sql="update $brandix_bts.bundle_transactions_20_repeat set quantity=($qty-$reject),rejection_quantity=".$reject." where bundle_id='".$bid."' and operation_id='".$ops_id."'";
	$result=mysqli_query($link, $sql) or exit("Sql Error-reject_update5".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$url_01 =  getFullUrl($_GET['r'],'bundle_scan_ops.php','N');
	header("Location:$url_01&update_ajax=1&id=$id&mod_id=$mod_id");
}
if(isset($_POST['cancel']))
{
	//echo "Test"."<br>";
	$id=$_POST['id'];
	$mod_id=$_POST['mod_id'];
	$bid=$_POST['bundle_id'];
	$ops_id=$_POST['ops'];
	$reject=$_POST['reject'];
	$url_01 =  getFullUrl($_GET['r'],'bundle_scan_ops.php','N');
	header("Location:$url_01&update_ajax=3&id=$id&mod_id=$mod_id");
}
?>
</div>
</div>
