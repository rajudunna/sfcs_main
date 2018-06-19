<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));  ?>
<?php
	//require_once('phplogin/auth.php');
	if(date("Y-m-d") >= "2012-11-16")
	{
		//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
		//$username=strtolower($username_list[1]);
	}
	else
	{
		$user_name="baiadmn";
	}	
// $auth_to_modify=array("kirang","ravipu","sarojiniv","kirang","baiadmn","sfcsproject1");
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
//$view_access=user_acl("SFCS_0159",$username,1,$group_id_sfcs); 
//$auth_to_modify=user_acl("SFCS_0159",$username,2,$group_id_sfcs);
$has_permission = haspermission($_GET['r']);
?>





<!-- <script type="text/javascript" src="<?= getFullURL($_GET['r'],'ajax-autocomplete/jquery.js','R'); ?>"></script>
<script type='text/javascript' src="<?= getFullURL($_GET['r'],'ajax-autocomplete/jquery.autocomplete.js','R'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURL($_GET['r'],'ajax-autocomplete/jquery.autocomplete.css','R'); ?>" /> -->

<script type="text/javascript">
// $().ready(function() {
// 	$("#course").autocomplete("ajax-autocomplete/get_course_list.php", {
// 		width: 260,
// 		matchContains: true,
// 		//mustMatch: true,
// 		//minChars: 0,
// 		//multiple: true,
// 		//highlight: false,
// 		//multipleSeparator: ",",
// 		selectFirst: false
// 	});
// });

function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

function isNumberKey(evt,issued_qty)
{
	var myVal = event.target.value;
	if(myVal > issued_qty){
		event.target.value = myVal.substring(0,myVal.length-1)
		return false;
	}
	return true;
}
</script>

  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R');  ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/page_style.css',3,'R'); ?>" type="text/css" media="all" />
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->


<div class="panel panel-primary">
<div class="panel-heading">Update RM Returns</div>
<div class="panel-body">

<body onload="dodisable();">
<?php 
// echo '<!---<div id="page_heading"><span style="float: left"><h3>Update RM Returns </h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->';
// include("menu_content.php"); 
	// include($_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'menu_content.php','R'));
?>



<form method="post" name="input2" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
	<div class="row">
		<div class='col-md-3'>
		<label>Search Lot No: </label><input type="text" id="course" onkeypress="return validateQty(event);" class="form-control" name="lot_no" oninvalid="this.setCustomValidity('Please Enter Lot Number')" required />
		</div>
		<input type="submit" id="submit" name="submit" class="btn btn-success" value="Search" style="margin-top: 18px;">
	</div>
</form>


<?php
if(isset($_POST['submit']))
{
	$lot_no=$_POST['lot_no'];
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"insert.php?lot_no=$lot_no_new\"; }</script>";
}
else
{
	$lot_no=$_GET['lot_no'];
}
?>



<?php

if(strlen($lot_no)>0)
{

$sql="select * from $bai_rm_pj1.sticker_report where lot_no=\"".trim($lot_no)."\"";
// echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check1=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$product_group=$sql_row['product_group'];
	$item=$sql_row['item'];
	$item_name=$sql_row['item_name'];
	$item_desc=$sql_row['item_desc'];
	$inv_no=$sql_row['inv_no'];
	$po_no=$sql_row['po_no'];
	$rec_no=$sql_row['rec_no'];
	$rec_qty=$sql_row['rec_qty'];
	$batch_no=$sql_row['batch_no'];
	$buyer=$sql_row['buyer'];
	$pkg_no=$sql_row['pkg_no'];
}

$sql="select sum(qty_rec) as \"qty_rec\" from $bai_rm_pj1.store_in where lot_no=\"".trim($lot_no)."\"";
// echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check2=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$qty=$sql_row['qty_rec'];
}
$diff=$rec_qty-$qty;
if($sql_num_check1>0){
	echo "<br/><div class='table-responsive'><table class='table table-bordered'>";
	echo "<tr><td>Lot No</td><td>:</td><td>$lot_no</td></tr>";
	echo "<tr><td>Batch</td><td>:</td><td>$batch_no</td></tr>";
	echo "<tr><td>Item Description</td><td>:</td><td>$item_desc</td></tr>";
	echo "<tr><td>Item Name</td><td>:</td><td>$item_name</td></tr>";
	echo "<tr><td>Product</td><td>:</td><td>$product_group</td></tr>";
	echo "</table></div><br/>";
	$flag=1;
}else{
	$flag=0;
}

if($flag!=0){

	echo '<div class="table-responsive"><form id="myForm" name="input" action='.getFullURLLevel($_GET['r'],'stock_returns.php',0,'N').' method="post">';
	echo "<table class='table table-bordered'>";
	echo "<tr><th>Location</th><th>Box/Roll No</th><th>Available Qty</th><th>Issued Qty</th><th>Date</th>";

switch (trim($product_group))
{
	case "Elastic":
	{
		echo "<th>Return Qty (MTR)</th><th>Remarks</th></tr>";
		if(!in_array($view,$has_permission))
		{
			header("Location: restrict.php");
		}
		break;
	}
	case "Lace":
	{
		echo "<th>Return Qty ($fab_uom)</th><th>Remarks</th></tr>";
		if(!in_array($view,$has_permission))
		{
			header("Location: restrict.php");
		}
		break;
	}
	case "Fabric":
	{
		echo "<th>Return Qty (MTR)</th><th>Remarks</th></tr>";
		if(!in_array($view,$has_permission))
		{
			header("Location: restrict.php");
		}
		break;
	}
	case "Thread":
	{
		echo "<th>Return Qty</th><th>Remarks</th></tr>";
		if(!in_array($view,$has_permission))
		{
			header("Location: restrict.php");
		}
		break;
	}
	default:
	{
		echo "<th>Return Qty</th><th>Remarks</th></tr>";
		if(!in_array($view,$has_permission))
		{
			header("Location: restrict.php");
		}
		break;
	}
}

$sql="select * from $bai_rm_pj1.store_in where lot_no=\"".trim($lot_no)."\"";
// echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$tid=$sql_row['tid'];
	$location=$sql_row['ref1'];
	$box=$sql_row['ref2'];
	$qty_rec=$sql_row['qty_rec'];
	$status=$sql_row['status'];
	$qty_issued=$sql_row['qty_issued']-$sql_row['qty_ret'];
	$available=$qty_rec-$sql_row['qty_issued']+$sql_row['qty_ret'];
	
	echo "<tr>";
		echo "<td>$location</td><td>$box</td><td>$available</td><td>$qty_issued</td>";
		echo '<td><input type="text" class="form-control" name="date[]" value="'.date("Y-m-d").'" readonly></td>';
		echo '<td><input type="text" class="form-control integer" name="qty_return[]" value="" id="return_qty'.$count.'" onkeypress="return isNumberKey(event,'.$qty_issued.');" onkeyup="return isNumberKey(event,'.$qty_issued.');" onchange="if(check2(this.value)==1010){ this.value=0;}"></td>';
		echo '<td><input type="text" class="form-control" name="remarks[]" value="">';
		echo '<input type="hidden" name="tid[]" value="'.$tid.'"><input type="hidden" name="status[]" value="'.$status.'"></td>';
	echo "</tr>";	
}

echo "</table></div>";
echo '<div style="padding-left:10px;"><input type="hidden" name="lot_no" value="'.$lot_no.'">';

echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable <input type="submit" class="btn btn-success" value="Submit" name="put" id="put" onclick="javascript:button_disable();"/></div></form>';

echo "<script>sweetAlert('Note','RM Return will happen only when Return Material Less than or Equal to the Issued Material..','success')</script>";
// echo " Note: RM Return will happen only when Return Material Lessthan or Equal to the Issued Material.. </h2>";
}else{
	echo "<script>sweetAlert('Please select valid lot no','','warning');</script>";
}

}



if(isset($_POST['put']))
{
	$date=$_POST['date'];
	$qty_return=$_POST['qty_return'];
	$remarks=$_POST['remarks'];
	$tid=$_POST['tid'];
	$status=$_POST['status'];
	$lot_no_new=$_POST['lot_no'];
	//$user_name=$_SESSION['SESS_MEMBER_ID'];
	
	for($i=0; $i<sizeof($qty_return); $i++)
	{	
		$username='sfcsproject1';
		if($qty_return[$i]>0)
		{
			$qty_returned_new=0;
			
			$sql1="select qty_issued from $bai_rm_pj1.store_in where tid=".$tid[$i];
			//echo $sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check1=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$qty_issued=$sql_row1['qty_issued'];
			}
				
			$sql="select qty_ret from $bai_rm_pj1.store_in where tid=".$tid[$i];
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qty_returned_new=$sql_row['qty_ret'];
			}			
			$qty_returned_new=$qty_returned_new+$qty_return[$i];
			//echo "qty_issued : ".$qty_issued."- Qty Returned : ".$qty_returned_new."</br>";	
			//echo $qty_issued>=$qty_returned_new;
			if($qty_issued>=$qty_returned_new)
			{
				$sql="insert into $bai_rm_pj1.store_returns (tran_tid, qty_returned, date, remarks, updated_by) values (".$tid[$i].",".$qty_return[$i].",'".$date[$i]."','".$remarks[$i]."','$username')";
				//echo "<br/>".$sql."<br/>";
				//die();
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				if($status[$i]==1)
				{
					$sql="update $bai_rm_pj1.store_in set qty_ret=".$qty_returned_new.", status=1, allotment_status=0 where tid=".$tid[$i];
					echo "<br/>".$sql."<br/>";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$sql="update $bai_rm_pj1.store_in set qty_ret=".$qty_returned_new.", status=0, allotment_status=0 where tid=".$tid[$i];
					//echo "<br/>".$sql."<br/>";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
			}
			
			
		}
	}
	echo "<script>sweetAlert('Returns updated scuccessfully',' ','success')</script>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"index.php?r=". $_GET['r'] ."&lot_no=$lot_no_new\"; }</script>";
	
}

?>

</body>

</div>
</div>
</div>



