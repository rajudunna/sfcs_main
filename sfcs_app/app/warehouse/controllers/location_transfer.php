<?php $url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url); ?>
<?php
	// require_once('phplogin/auth.php');
	if(date("Y-m-d") >= "2012-11-16")
	{
		$username_list=explode('\\',$_SERVER['REMOTE_USER']);
		$username=strtolower($username_list[1]);
	}
	else
	{
		$user_name="baiadmn";
	}	
//	$auth_to_modify=array("kirang","ravipu","sarojiniv","kirang","baiadmn","kirang");
// $url = getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R');
// include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
// $url = getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R');
// include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
// $view_access=user_acl("SFCS_0150",$username,1,$group_id_sfcs); 
// $auth_to_modify=user_acl("SFCS_0150",$username,2,$group_id_sfcs); 	

	//0 for 
	//1 for lock
	//2 for completed
	$has_permission = haspermission($_GET['r']);
?>

<script type="text/javascript">

	function testing()
	{

		var val = document.getElementById('course');
		
		if((val.value)==''){
			sweetAlert('Please enter Lot No','','info');
			return false;
		}
		
	}


	function pop_test()
	{
		if(document.getElementById('option').checked=false)
		{
			document.getElementById('put').disabled=true;
		}
		var items = document.getElementsByName('qty_issued[]');
		var location = document.getElementsByName('n_location[]');
		var count1=location.length;
		var count=items.length;
		for(var i=0;i<items.length;i++){
			var val=items[i].value;	
			var val1=location[i].value;			

			if(val !='' && val>0 )
			{
				count--;
				
				if(val1!=0)
				{
					count1--;
					document.getElementById('put').disabled=false;
					document.getElementById('option').checked=true;
				}

			}
		
		}

		if(items.length==count )
		{
			sweetAlert('Please Enter Atleast one Transfer Qty','','warning');
				document.getElementById('put').disabled=true;
				document.getElementById('option').checked=false;


		}
		else if(count!=count1)
		{
			sweetAlert('please  select Location for Entered Transfer Qty ','','warning');
				document.getElementById('put').disabled=true;
				document.getElementById('option').checked=false;
		}


		
	}

	function check1(x, y) {
  
    if ((x > y)) {
        sweetAlert("Transfer Qty Must be Less Than Available Qty","","warning");
        return 1010;
    }

}


</script>

<title>Location Transfer Form</title>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>


<div class='panel panel-primary'><div class='panel-heading'>Location Transfer Form</div><div class='panel-body'>




<form method="post" name="input2" action="<?= getFullURL($_GET['r'],'location_transfer.php','N') ?>">
<div class="row">
<div class="col-md-3">
<label>Enter Lot No: </label>
<input type="text" class='form-control integer' id="course" name="lot_no"  />
</div>
<input type="submit" id="submit" name="submit" class='btn btn-info' value="Search" onclick="return testing()" style="margin-top: 22px;">
</div>
</form>

<br>
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

$sql="select * from $bai_rm_pj1.sticker_report where lot_no like \"%".trim($lot_no)."%\"";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
// echo $sql_num_check;
if($sql_num_check>0)
{
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
		$grn_date=$sql_row['grn_date'];
	}

	$sql="select sum(qty_rec) as \"qty_rec\" from $bai_rm_pj1.store_in where lot_no like \"%".trim($lot_no)."%\"";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$qty=$sql_row['qty_rec'];
	}

	$diff=$rec_qty-$qty;


	echo "<table class='table table-bordered'>";
	echo "<tr><td>Lot No</td><td>:</td><td>$lot_no</td></tr>";
	echo "<tr><td>Batch</td><td>:</td><td>$batch_no</td></tr>";
	echo "<tr><td>Item Description</td><td>:</td><td>$item_desc</td></tr>";
	echo "<tr><td>Item Name</td><td>:</td><td>$item_name</td></tr>";
	echo "<tr><td>Product</td><td>:</td><td>$product_group</td></tr>";
	echo "<tr><td>GRN Date</td><td>:</td><td>$grn_date</td></tr>";
	echo "</table><br>";

	echo '<form id="myForm" name="input" action="'.getFullURL($_GET['r'],'location_transfer_process.php','N').'" method="post">';
	echo "<table class='table table-bordered'>";
	echo "<tr class='tblheading'><th>Current Location</th><th>Box/Roll No</th><th>Available Qty</th>";

	switch (trim($product_group))
	{
		case "Elastic":
		{
			echo "<th>Transfer Qty (MTR)</th><th>New Location</th><th>Remarks</th></tr>";	
			if(!in_array($view,$has_permission))
			{
				$url = getFullURL($_GET[r],'restrict.php','N');
				header("Location: ".$url);
			}		
			break;
		}
		case "Lace":
		{
			echo "<th>Transfer Qty ($fab_uom)</th><th>New Location</th><th>Remarks</th></tr>";
			if(!in_array($view,$has_permission))
			{
				$url = getFullURL($_GET[r],'restrict.php','N');
				header("Location: ".$url);
			}
			break;
		}
		case "Fabric":
		{
			echo "<th>Transfer Qty (YARDS)</th><th>New Location</th><th>Remarks</th></tr>";
			if(!in_array($view,$has_permission))
			{
				$url = getFullURL($_GET[r],'restrict.php','N');
				header("Location: ".$url);
			}
			break;
		}
		case "Thread":
		{
			echo "<th>Transfer Qty (CON) </th><th>New Location</th><th>Remarks</th></tr>";
			if(!in_array($view,$has_permission))
			{
				$url = getFullURL($_GET[r],'restrict.php','N');
				header("Location: ".$url);
			}
			break;
		}
		default:
		{
			echo "<th>Transfer Qty (CON) </th><th>New Location</th><th>Remarks</th></tr>";
			if(!in_array($view,$has_permission))
			{
				$url = getFullURL($_GET[r],'restrict.php','N');
				header("Location: ".$url);
			}
			break;
		}
	}

	$sql="select * from $bai_rm_pj1.store_in where lot_no like \"%".trim($lot_no)."%\" and status in (0,1) and ref1<>''";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$tid=$sql_row['tid'];
			$location=$sql_row['ref1'];
			$box=$sql_row['ref2'];
			$qty_rec=$sql_row['qty_rec'];
			$status=$sql_row['status'];
			$available=$qty_rec-$sql_row['qty_issued']+$sql_row['qty_ret'];

			echo "<tr>";
			if($status==0)
			{
				echo "<td>$location</td><td>$box</td><td>$available</td>";
				echo '<td><input type="text" class="form-control float" name="qty_issued[]" value="" onchange="if(check1(this.value, '.$available.')==1010){ this.value=0;} "  ></td>';
				
				echo '<td><select name="n_location[]" class="select2_single form-control">';
				echo "<option value=\"0\">Select Location</option>";
				$sql1="select * from $bai_rm_pj1.location_db where status=1 and location_id NOT IN ('".$location."') order by location_id,sno";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					echo "<option value=\"".$sql_row1['location_id']."\">".$sql_row1['location_id']."</option>";
				}
				echo '</select></td>';
				echo '<td><input type="text" class="form-control" name="remarks[]" value="">';
				echo '<input type="hidden" name="s_location[]" value="'.$location.'"><input type="hidden" name="tid[]" value="'.$tid.'"><input type="hidden" name="available[]" value="'.$available.'"><input type="hidden" name="qty_rec[]" value="'.$qty_rec.'"></td>';
			}
			echo "</tr>";	
		}

		echo "</table><br>";
		echo '<input type="hidden" name="lot_no" value="'.$lot_no.'">';
		echo '<input type="checkbox" name="option"  id="option" onclick="pop_test();">Enable<input type="submit" value="Submit" class="btn btn-info" name="put" id="put" disabled></form>';
		echo "<h2>Transaction Log:</h2>";


		echo "<table class='table table-bordered'>";
		echo "<tr class='tblheading'><th>Date</th><th>Previous Location</th><th>New Location</th><th>Old Qty</th><th>New Qty</th><th>Remarks</th><th>User</th></tr>";
		$sql="select * from $bai_rm_pj1.location_trnsf where lot_no like \"%".trim($lot_no)."%\" order by date";
		// echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$date=$sql_row['date'];
			$prv_location=$sql_row['source_location'];
			$new_location=$sql_row['new_location'];
			$old_qty=$sql_row['old_qty'];
			$new_qty=$sql_row['new_qty'];	
			$remarks=$sql_row['remarks'];
			$user=$sql_row['log_user'];
			
			echo "<tr><td>$date</td><td>$prv_location</td><td>$new_location</td><td>$old_qty</td><td>$new_qty</td><td>$remarks</td><td>$user</td></tr>";
		}
		echo "</table>";
}
else
{
	echo "<script>sweetAlert('Please enter valid lot Number','','warning');</script>";
}

}

?>



</div></div>
