<!--
Change log:

2014-03-20/ kirang / Ticket #482209 : Add demudun user in $authorized array.

2016-05-17/kirang/SR#10750119/Task: authorised user can delete lot numbers though transactions are availble for the lot number. but issued and returned quantity should be matached. then it will allow authorised user to delete the lot number

-->

<?php
	// require_once('phplogin/auth.php');
?>

<?php 	
    $url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
?>
<?php 	
	$url = getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 
?>

<?php
$has_permission = haspermission($_GET['r']);
// $url = getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R');
// include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
// $url = getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R');
// include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 
// $view_access=user_acl("SFCS_0158",$username,1,$group_id_sfcs);
// $authorised_user=user_acl("SFCS_0147",$username,7,$group_id_sfcs);
/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=$username_list[1];

$sql="select * from menu_index where list_id=164";
	$result=mysql_query($sql,$link1) or mysql_error("Error=".mysql_error());
	while($row=mysql_fetch_array($result))
	{
		$users=$row["auth_members"];
	}

	$auth_users=explode(",",$users);
//$authorized=array("kirang","herambaj","ravipu","demudun","apparaoo","kirang","narasingaraon","ramprasadk","kirang");
*/
if(!(in_array($view,$has_permission)))
{
	header("Location:restrict.php");
}

?>

<title>Delete RM Receiving</title>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>

<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/page_style.css',3,'R'); ?>" type="text/css" media="all" />


<body onload="dodisable();">

<?php 
// include("menu_content.php"); ?>
<div class="panel panel-primary">
	<div class="panel-heading"><b>Delete RM Receiving Form</b></div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<form name="test" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<label>Enter Label Id: </label>
					<input type="text" name="lid" value="" class="form-control integer" /required>
			</div>
			<div class="col-md-3">
					<input type="submit" name="submit" value="Search" class="btn btn-success" style="margin-top:18px;" />
				</form>
			</div>
			<div class="col-md-3">
				<form name="test" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
					<label>Enter Lot #:</label>
					<input type="text" name="lot_no_ref" value="" class="form-control integer" /required>
			</div>
			<div class="col-md-3">
					<input type="submit" name="submit2" value="Search" class="btn btn-success" style="margin-top:18px;" />
				</form>
			</div>
		</div>
		<hr>
	
<?php
if(isset($_POST['submit']))
{
	$lid=$_POST['lid'];
	
	$sql="select lot_no,qty_rec,qty_issued,qty_ret,ref1,ref4 from $bai_rm_pj1.store_in where tid=\"$lid\"";
	$sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_affected_rows($link)>0)
	{
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$qty_rec=round($sql_row['qty_rec'],2);
			$qty_issued=$sql_row['qty_issued'];
			$qty_ret=$sql_row['qty_ret'];
			$ref1=$sql_row['ref1'];
			$ref4=$sql_row['ref4'];
			$lot_no=$sql_row['lot_no'];
		}
	
		$sql="select * from $bai_rm_pj1.sticker_report where lot_no=\"$lot_no\"";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		echo "<table class='table table-bordered'>";
		echo "<tr><td>Lot No</td><td>:</td><td>$lot_no</td></tr>";
		echo "<tr><td>Batch</td><td>:</td><td>$batch_no</td></tr>";
		echo "<tr><td>Item Description</td><td>:</td><td>$item_desc</td></tr>";
		echo "<tr><td>Item Name</td><td>:</td><td>$item_name</td></tr>";
		echo "<tr><td>Product</td><td>:</td><td>$product_group</td></tr>";
		echo "<tr><td>Qty Recieved</td><td>:</td><td>$qty_rec</td></tr>";
		echo "<tr><td>GRN Date</td><td>:</td><td>$grn_date</td></tr>";
		
		echo '<form name="input" method="post" action="'.getFullURL($_GET['r'],'entry_delete.php','N').'">';
		echo '<tr><td>Reason</td><td>:</td><td><div class="row"><div class="col-md-4"><input type="text" name="reason"  id="reason2" class="form-control" required ></div></div></td></tr>';
		
		if(in_array($authorized,$has_permission))
		{
			echo '<tr><td></td><td></td><td><input type="submit" value="delete" name="delete" id="delete" class="btn btn-danger btn-sm confirm-submit" onclick="return check_reason1();" ><input type="hidden" name="lid" value="'.$lid.'" onclick=document.getElementById("delete").style.display="none"; ></td></tr>';
		}
		else
		{
			if($qty_rec>0 and $qty_issued==0 and $qty_ret==0 and strlen($ref1)==0 and strlen($ref4)==0)
			{				
				echo '<tr><td></td><td></td><td><input type="submit" value="delete" name="delete" id="delete" class="btn btn-danger btn-sm confirm-submit" onclick="return check_reason1();" ><input type="hidden" name="lid" value="'.$lid.'" onclick=document.getElementById("delete").style.display="none";></td></tr>';
			}	
		}
		echo '</form>';
		echo "</table>";
	}
	else
	{
		//echo "<table class='table table-bordered'><tr class='danger'><td>Details not available, please enter label id.</td></tr></table>";
		echo "<script>sweetAlert('please enter valid label id.','','warning')</script>";
		$url = getFullURL($_GET['r'],'entry_delete.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";
	}
	
}


if(isset($_POST['delete']))
{
	$lid=$_POST['lid'];
	$reason=$_POST['reason'];
		

	$query = "select qty_issued from $bai_rm_pj1.store_in where tid='$lid'";
	
	$result = mysqli_query($link,$query);
	while($row = mysqli_fetch_array($result)){
		$issued_qty = $row['qty_issued'];
	}
	

	
	if((int)$issued_qty > 0){
	
		echo "<script>sweetAlert('Quantity is issued already','you should not delete it','warning');</script>";
		$url = getFullURL($_GET['r'],'entry_delete.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500); function Redirect() {  location.href = \"$url\"; }</script>";
	
	}else{
		$sql="insert into $bai_rm_pj1.store_in_deleted select * from $bai_rm_pj1.store_in where tid=".$lid;
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error4=".mysqli_error($link));
		
		$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		//echo $id;
		$sql3="update $bai_rm_pj1.store_in_deleted set log_user='".$username."$".$reason."' where tid=".$id;
		// echo  "<br/>".$sql3;	 
		$sql_result3=mysqli_query($link, $sql3) or exit($sql3."<br/>Sql Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_affected_rows($link);
		

		
		$sql_store_in="select lot_no from $bai_rm_pj1.store_in where tid=".$lid;
		$sql_result_store_in=mysqli_query($link, $sql_store_in) or exit($sql_store_in."<br/>Sql Error_store_in=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($sql_row_store_in=mysqli_fetch_array($sql_result_store_in))
		{
			$lot_no=$sql_row_store_in['lot_no'];
		}
		
		$sql_lot="select sum(qty_rec) as 'qty_rec' FROM $bai_rm_pj1.store_in_deleted where lot_no='$lot_no' group by lot_no";
		$sql_result_lot=mysqli_query($link, $sql_lot) or exit($sql_lot."<br/>Sql Error_lot=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($sql_row_lot=mysqli_fetch_array($sql_result_lot))
		{
			$qty_rec=$sql_row_lot['qty_rec'];
		}
		
		$sql_sticker="select rec_qty from $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
		$sql_result_sticker=mysqli_query($link, $sql_sticker) or exit($sql_sticker."<br/>Sql Error_sticker=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($sql_row_sticker=mysqli_fetch_array($sql_result_sticker))
		{
			$rec_qty=$sql_row_sticker['rec_qty'];
		}
		
		//echo "<br/>store in qty recived".round($qty_rec,2);
		
		//echo "<br/> stikcer recived qty".round($rec_qty,2);
		
		if(round($qty_rec,2)==round($rec_qty,2))
		{
			$sql6="insert into $bai_rm_pj1.sticker_report_deleted select * from $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			//echo "<br/>".$sql6;	 
			$sql_result6=mysqli_query($link, $sql6) or exit($sql6."<br/>Sql Error 6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num6=mysqli_affected_rows($link);
			if($num6>0)
			{
				$sql7="delete FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
				//echo "<br/>".$sql7;
				$sql_result7=mysqli_query($link, $sql7) or exit($sql7."<br/>Sql Error 7".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
			$sql1="delete from $bai_rm_pj1.store_in where tid=\"$lid\"";
			$sql_result1=mysqli_query($link, $sql1) or exit($sql1."<br/>Sql Error 1=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		// echo "<table class='table table-bordered'><tr class='success'><td>Label Id Successfully Deleted</td></tr></table>";
		echo "<script>sweetAlert('Label id Successfully Deleted','','success');</script>";
		$url = getFullURL($_GET['r'],'entry_delete.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";
	}
}


if(isset($_POST['submit2']))
{
	$lot_no=$_POST['lot_no_ref'];

	$sql="select * from $bai_rm_pj1.sticker_report where lot_no=\"".trim($lot_no)."\"";
    $sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	if(mysqli_num_rows($sql_result)>0)
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
			
			$message="<font color=red>In Stock</font>";
			if($sql_row['backup_status']==1)
			{
				$message="<font color=green>Account Closed</font>";
			}		
		}
		
	$sql="select sum(qty_rec) as \"qty_rec\" from $bai_rm_pj1.store_in where lot_no=\"".trim($lot_no)."\"";

	$sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$qty=$sql_row['qty_rec'];
		}

			$diff=round(($rec_qty-$qty),2);

			echo "<table class='table table-bordered'>";

			echo '<form name="test" id="myForm" action='.getFullURL($_GET['r'],'entry_delete.php','N').'  method="POST">';
			echo "<tr><td>Lot No</td><td>:</td><td>$lot_no</td></tr>";
			echo "<tr><td>Batch</td><td>:</td><td>$batch_no</td></tr>";
			echo "<tr><td>PO No</td><td>:</td><td>$po_no</td></tr>";
			echo "<tr><td>Receiving No</td><td>:</td><td>$rec_no</td></tr>";

			echo "<tr><td>Item Code</td><td>:</td><td>$item</td></tr>";
			echo "<tr><td>Invoice #</td><td>:</td><td>$inv_no</td></tr>";

			echo "<tr><td>Item Description</td><td>:</td><td>$item_desc</td></tr>";
			echo "<tr><td>Item Name</td><td>:</td><td>$item_name</td></tr>";
			echo "<tr><td>Product</td><td>:</td><td>$product_group</td></tr>";
			echo "<tr><td>Package</td><td>:</td><td>$pkg_no</td></tr>";
			echo "<tr><td>GRN Date</td><td>:</td><td>$grn_date</td></tr>";
			echo "<tr><td>Received Qty</td><td>:</td><td>$rec_qty</td></tr>";
			echo "<tr><td>Labeled Qty</td><td>:</td><td>$qty</td></tr>";
			echo "<tr><td>Balance to be Labeled</td><td>:</td><td><input type=\"hidden\" value=\"$diff\" name=\"available\">$diff</td></tr>";
			echo '<tr><td>Reason</td><td>:</td><td><div class="row"><div class="col-md-6"><input type="textarea" name="reason" id="reason1"  class="form-control" required /></div></div></td></tr>';
			echo "<tr><td colspan=3 align='right'>";
			echo '<div style=" color:blue; display:none;" id="process_message" name="process_message">
			Please Wait
			</div>';
			echo '<input type="hidden" value="'.$lot_no.'" name="lot_no"><input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable<input type="submit" value="Delete" name="put" id="put" onclick="return check_reason();"
			 class="btn btn-danger btn-sm confirm-submit" />';
			//  onclick="javascript:button_disable();"

			echo "</td></tr>";
			echo '</form>';
			echo "</table>";

	}
	else
	{

		// echo "<table class='table table-bordered'><tr class='danger'><td>Details not available, please enter lot no.</td></tr></table>";
		// echo "<script>sweetAlert('Details not available, please enter lot no.','','info');</script>";
		// $url = getFullURL($_GET['r'],'entry_delete.php','N');
		// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"$url\"; }</script>";

		//echo "<table class='table table-bordered'><tr class='danger'><td>Details not available, please enter lot no.</td></tr></table>";
		echo "<script>sweetAlert('please enter valid lot no','','warning')</script>";
        $url = getFullURL($_GET['r'],'entry_delete.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";

	}

}

//TO delete lot number for wrong grns
if(isset($_POST['put']))
{
	
	$lot_no=$_POST['lot_no'];
	$reason=$_POST['reason'];
	
	//$sql="select * from store_in where lot_no=".$lot_no;
	
	$sql="SELECT sum(qty_issued) as total_issued,sum(qty_ret) as total_returned FROM $bai_rm_pj1.store_in where lot_no='$lot_no' group by lot_no";
	
	// echo "<br/>".$sql;
	$sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$total_issued=$sql_row['total_issued'];
		$total_returned=$sql_row['total_returned'];
	}
	
	if($total_issued==$total_returned)
	{
		if(in_array($authorized,$has_permission))
		{
		
		$check=0;
		if(mysqli_num_rows($sql_result)>0)
		{
			$sql2="insert into $bai_rm_pj1.store_in_deleted SELECT * FROM $bai_rm_pj1.store_in where lot_no='$lot_no'"; 
			// echo "<br/>".$sql2;
		 	
			$sql_result2=mysqli_query($link, $sql2) or exit($sql2."<br/>Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_affected_rows($link);
		
			$sql3="update $bai_rm_pj1.store_in_deleted set log_user='".$username."&".$reason."' where lot_no='$lot_no'";
			// echo  "<br/>".$sql3;
		 
			$sql_result3=mysqli_query($link, $sql3) or exit($sql3."<br/>Sql Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3=mysqli_affected_rows($link);
		
		 
			$sql4="delete FROM $bai_rm_pj1.store_in where lot_no='$lot_no'";
			// echo  "<br/>".$sql4;
		
			$sql_result4=mysqli_query($link, $sql4) or exit($sql4."<br/>Sql Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num4=mysqli_affected_rows($link);
		
			if(($num2==$num4))
			{
				$check=1;
			}
		
		}																									
		
			$sql1="SELECT * FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			$sql_result1=mysqli_query($link, $sql1) or exit($sql1."<br/>Sql Error at count".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count1=mysqli_num_rows($sql_result1);
			$num7=0;
			if($count1>0)
			{
			 	$sql5="select * FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			 	// "<br/>".$sql5;
			 
				$sql_result5=mysqli_query($link, $sql5) or exit($sql5."<br/>Sql Error 5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num5=mysqli_affected_rows($link);
				
				
				$sql6="insert into $bai_rm_pj1.sticker_report_deleted select * FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			 	// "<br/>".$sql6;
			 
				$sql_result6=mysqli_query($link, $sql6) or exit($sql6."<br/>Sql Error 6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num6=mysqli_affected_rows($link);
				
				if($num5==$num6)
				{
					$sql7="delete FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			 		// "<br/>".$sql7;
			 
					$sql_result7=mysqli_query($link, $sql7) or exit($sql7."<br/>Sql Error 7".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num7=mysqli_affected_rows($link);
				}
				
			}						
		
				 //echo "<br/>Sticker report ".$count1;
		
			if($check==1 and $num7>0)
			{
				//echo "<h2><font color=green>Lot number deleted successfully</font></h2>";
				echo "<script>sweetAlert('Lot Number Deleted Successfully','','Success')</script>";
				$url = getFullURL($_GET['r'],'entry_delete.php','N');
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";
			}				
			else
			{
				echo "<script>sweetAlert('Unable To Delete','Please Cross Check Details','error')</script>";
				//echo "<h2><font color=red>Transaction un-successful, please cross check the details.</font></h2>";
				$url = getFullURL($_GET['r'],'entry_delete.php','N');
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",3000); function Redirect() {  location.href = \"$url\"; }</script>";
			}		
	
		}									
		else
		{
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<h2><font color=red>Deletion Can't Possible.</font></h2>";
			}
			else
			{
			/*
			$sql="delete from sticker_report where lot_no=\"$lid\"";
			$sql_result=mysql_query($sql,$link) or exit($sql."<br/>Sql Error2=".mysql_error());
			*/
			
			$sql1="SELECT * FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			$sql_result1=mysqli_query($link, $sql1) or exit($sql1."<br/>Sql Error at count".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count1=mysqli_num_rows($sql_result1);
			$num7=0;
				if($count1>0)
				{
			 		$sql5="select * FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			 		// "<br/>".$sql5;
			 
					$sql_result5=mysqli_query($link, $sql5) or exit($sql5."<br/>Sql Error 5".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num5=mysqli_affected_rows($link);
				
				
					$sql6="insert into $bai_rm_pj1.sticker_report_deleted select * FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
			 		// "<br/>".$sql6;
					
					$sql_result6=mysqli_query($link, $sql6) or exit($sql6."<br/>Sql Error 6".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num6=mysqli_affected_rows($link);
				
					if($num5==$num6)
					{
						$sql7="delete FROM $bai_rm_pj1.sticker_report where lot_no='$lot_no'";
						$sql_result7=mysqli_query($link, $sql7) or exit($sql7."<br/>Sql Error 7".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num7=mysqli_affected_rows($link);
					}
				
				}	
			
				echo "<script>sweetAlert('Successfully Updated','','success')</script>";
				echo "<h2><font color=green>Successfully Updated!!</font></h2>";
				$url = getFullURL($_GET['r'],'entry_delete.php','N');
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";
			}
		}																																													
	}
	else
	{
		echo "<script>sweetAlert('Deletion Cant Possible',' Because total issued quantity and total returned quantity is not equal for this lot number','error');</script>";
		$url = getFullURL($_GET['r'],'entry_delete.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",5000); function Redirect() {  location.href = \"$url\"; }</script>";
		//echo "<table class='table table-bordered'><tr class='danger'><td style='text-align:center;'>Deletion Can't Possible. Because total issued quantity and total returned quantity is not equal for this lot number</td></tr></table>";
	}
	
}
echo "</div>";	
?>
</div>
</div>
<script>
		jQuery('input[type="text"]').keyup(function() {
		var raw_text =  jQuery(this).val();
		var return_text = raw_text.replace(/[^a-zA-Z0-9 _]/g,'');
		jQuery(this).val(return_text);
	});

		function check_reason()
		{
			var reason=document.getElementById('reason1').value;
			if(reason=='')
			{
				sweetAlert('Please Enter Reason ','','info');
				return false;
			}
			else
			{
				return true;
			}
		}

		function check_reason1()
		{
			var reason2=document.getElementById('reason2').value;
			if(reason2=='')
			{
				sweetAlert('Please Enter Reason ','','info');
				return false;
			}
			else
			{
				return true;
			}
		}
</script>
