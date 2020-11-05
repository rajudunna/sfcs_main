<?php
	set_time_limit(50000);
	// require_once('phplogin/auth.php');
	$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
	$plant_code = $_SESSION['plantCode'];
	$username = $_SESSION['userName'];
	$current_date = date('Y-m-d h:i:s');
	?>


<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/filtergrid.css',3,'R'); ?>" type="text/css" media="all" />

<body onload="dodisable();">
<?php  include("stock_in.php"); ?>
<?php

if(isset($_POST['submit']) or isset($_GET['ref']))
{
	if(isset($_POST['submit']))
	{
		if(isset($_POST['lot_no'])){
			$lot_no = $_POST['lot_no'];
			$main_sql = "select lot_no,rec_qty,rec_no,item,item_name,item_desc,inv_no,po_no,batch_no,product_group,pkg_no,grn_date from $wms.sticker_report where plant_code = '$plant_code' and lot_no = '$lot_no' or rec_no = '$lot_no' ";
		}else{
			$ref=$_POST['reference'];
			$main_sql = "select lot_no,rec_qty,rec_no,item,item_name,item_desc,inv_no,po_no,batch_no,product_group,pkg_no,grn_date from $wms.sticker_report where plant_code = \"".$plant_code."\" and inv_no=\"".$ref."\" or po_no=\"".$ref."\" or batch_no=\"".$ref."\"";
		}
	}else{
		$ref=$_GET['ref'];
		$main_sql = "select lot_no,rec_qty,rec_no,item,item_name,item_desc,inv_no,po_no,batch_no,product_group,pkg_no,grn_date from $wms.sticker_report where plant_code = \"".$plant_code."\" and inv_no=\"".$ref."\" or po_no=\"".$ref."\" or batch_no=\"".$ref."\"";
	}
	// echo $ref;
	

	

	$main_result = mysqli_query($link, $main_sql) or exit("Sql Error_888: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($main_result)>0)
	{
		echo '<form method="post" name="test" action="'.getFullURL($_GET['r'],'quick_insert_v1.php','N').'" >';
		echo '<table id="new" class="test" boarder=0>
		<tr boarder=0>';
echo'<td>Date:</td><td> <input type="text" class="form-control" name="date" value="'.date("Y-m-d").'"></td>';

echo '<td style="padding:4px;">Locaton:</td><td><select class="form-control" name="ref1">';

$sql="select location_id from $wms.location_db where plant_code='$plant_code' and status=1 order by sno";
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_check=mysqli_num_rows($sql_result);
echo "<option>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	echo "<option value=\"".$sql_row['location_id']."\">".$sql_row['location_id']."</option>";
}


echo '</select></td>';
echo '<td><input type="checkbox" name="option"  id="option" style="margin: 4px 6px 0;" onclick="javascript:enableButton();">Enable
<input type="submit" value="Submit" name="put" id="put" onclick="return button_disable();" class="btn btn-success"/>';



echo '</td>';
$url=  getFullURLLevel($_GET['r'],'common/lib/mpdf7/labels_v2.php',3,'R');
echo "<td><a href=\"$url?lot_no=$ref\" onclick=\"Popup=window.open('$url?lot_no=$ref"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><h2>Print Labels</h2></a></td>";

			//echo'<td><label>Date:</label>&nbsp;&nbsp;</td><td> <input type="text" name="date" value="'.date("Y-m-d").'" class="form-control"></td>';
			//echo '<td>&nbsp;&nbsp;Locaton:</td><td><select name="ref1" class="form-control">';
			//echo "<option value=\"\"></option>";
			//$sql="select * from location_db where status=1 order by sno";
			//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			//$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			//$sql_num_check=mysqli_num_rows($sql_result);
			//while($sql_row=mysqli_fetch_array($sql_result))
			//{
				//echo "<option value=\"".$sql_row['location_id']."\">".$sql_row['location_id']."</option>";
			//}
			//echo '</select></td>';
			//echo '<td>&nbsp;&nbsp;<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();"><b>Enable</b>&nbsp;&nbsp;<input type="submit" value="Submit" name="put" id="put" onclick="javascript:button_disable();" class="btn btn-primary btn-sm"/>';
			//echo '</td>';
			//$url=  getFullURL($_GET['r'],'mpdf50/examples/labels_v2.php','N');
			//echo "<td><a href=\"$url&lot_no=$ref\" onclick=\"Popup=window.open('$url&lot_no=$ref"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\" class=\"btn btn-info btn-sm\"><i class=\"fa fa-print\"></i>  Print Labels</a></td>";
		echo '</tr>';
		echo "</table>";
		//echo '<div id="process_message"><h2><font color="red">Please wait!!</font></h2></div>';
		echo "<input type=\"hidden\" size=\"5\" name=\"ref\" value=\"".$ref."\">";


		echo "<div class='col-sm-12' style='overflow:scroll;max-height:500px;'>";		
		echo '<hr><div>
				 <table id="table1" class="table table-bordered">
				 <thead>
				 <tr><th>Receiving #</th><th>Item</th><th>Item Name</th>
					 <th>Item Description</th><th>Invoice #</th><th>PO #</th><th>Qty</th><th>Labeled</th><th>IN Qty</th><th>Box #</th><th>REF#</th><th>Lot#</th>
					 <th>Batch #</th><th>Product</th><th>PKG No</th><th>GRN Date</th>
				 </tr></thead><tbody>';
				 $i=0;
		//echo '<hr><div class="table-responsive"><table id="table1" class="table table-bordered"><tr><th>Receiving #</th><th>Item</th><th>Item Name</th><th>Item Description</th><th>Invoice #</th><th>PO #</th><th>Qty</th><th>Labeled</th><th>IN Qty</th><th>Box #</th><th>REF#</th><th>Lot#</th><th>Batch #</th><th>Product</th><th>PKG No</th><th>GRN Date</th></tr>';

		// $sql1="select * from sticker_report where inv_no=\"".$ref."\" or po_no=\"".$ref."\" or batch_no=\"".$ref."\"";
		// $sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		while($sql_row1=mysqli_fetch_array($main_result))
		{
			
			$sql="select coalesce(sum(qty_rec),0) as \"in\" from $wms.store_in where plant_code='$plant_code' and lot_no=\"".$sql_row1['lot_no']."\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$in=$sql_row['in'];
			}
			$balance_qty=$sql_row1['rec_qty']-$in;
			$url=  getFullURL($_GET['r'],'insert_v1.php','N');
			echo "<tr><td><a href=\"$url&lot_no=".$sql_row1['lot_no']."\" class=\"btn btn-info btn-xs\">".$sql_row1['rec_no']."</a></td><td>".$sql_row1['item']."</td><td>".$sql_row1['item_name']."</td>
				  <td>".rtrim($sql_row1['item_desc'],'/ ')."</td><td>".$sql_row1['inv_no']."</td><td>".$sql_row1['po_no']."</td><td>".(float)$sql_row1['rec_qty']."</td><td>$in</td><td><input type=\"text\" size=\"5\" name=\"qty[$i]\" id=\"qty[$i]\" value=\"".$balance_qty."\" onchange='return check_qty($i);'></td>";
			echo "<td><input type=\"text\" size=\"5\" name=\"box[]\"><td><input type=\"text\" size=\"5\" name=\"rmks[]\"><input type=\"hidden\" size=\"5\" name=\"lot_no[]\" value=\"".$sql_row1['lot_no']."\"><input type=\"hidden\" size=\"5\" name=\"balance_qty[$i]\"  id=\"balance_qty[$i]\" value=\"".$balance_qty."\"></td>";
			//echo "<td><input type=\"text\" size=\"5\" name=\"qty[]\" onchange=\"if(check(this.value,".($sql_row1['rec_qty']-$in).")==1010) { this.value=0; }\" readonly></td><td><input type=\"text\" size=\"5\" name=\"box[]\"><td><input type=\"text\" size=\"5\" name=\"rmks[]\"><input type=\"hidden\" size=\"5\" name=\"lot_no[]\" value=\"".$sql_row1['lot_no']."\"></td>";
			echo "<td>".$sql_row1['lot_no']."</td><td>".$sql_row1['batch_no']."</td><td>".$sql_row1['product_group']."</td><td>".$sql_row1['pkg_no']."</td><td>".$sql_row1['grn_date']."</td>";
			echo "</tr>";
			$i++;
		}
		echo '<tr class="bottom danger">
			<td>Total:</td>
			<td></td><td></td><td></td><td></td><td></td>
			<td id="table1Tot1" style="background-color:#FFFFCC;"></td>
			<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			</tr></tbody>';
			
		echo "</table></div>";
		echo "</div>";
		echo '</form>';
	}
	else
	{
		// echo "<table class='table table-bordered'><tr class='danger'><td align='center'>No Records Found </td></tr></table>";
		echo "<script>sweetAlert('No Records Found','','warning');</script>";
	}
}
echo "</div></div></div>";
?>

<script language="javascript" type="text/javascript">
//<![CDATA[
var table2_Props = { 
						// btn_reset: true,  
						// btn_reset_text: "Reset Table Filters",
						display_all_text: " [ Show all ] ",
						sort_select: true,
						// btn_reset : true,
						col_operation: { 
									id: ["table1Tot1"],
									col: [6],
									operation: ["sum"],
									write_method: ["innerHTML","setValue"] 
								},
						
						//rows_always_visible: [grabTag(grabEBI('table1'),"tr").length],
				};

	setFilterGrid( "table1", table2_Props);
 	
//]]>
function check_qty(id) {
	var entered_qty=document.getElementById('qty['+id+']').value;
	var balance_qty=document.getElementById('balance_qty['+id+']').value;

	if(Number(entered_qty) > Number(balance_qty))
	{
		swal('You cannot enter more than Qty','Please Enter Correct Qty','warning');
		document.getElementById('qty['+id+']').value=balance_qty;
	}

}
</script>


<?php


if(!empty($_POST['put']) && isset($_POST['put']))
{
	//make variables safe to insert

  
  $date=$_POST['date'];
  $ref1=$_POST['ref1'];
  
  $qty=$_POST['qty'];
  $lot_no=$_POST['lot_no'];
  $remarks=$_POST['rmks'];
  $box=$_POST['box'];
  $user_name=$_SESSION['SESS_MEMBER_ID'];
  $ref=$_POST['ref'];
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
		
		$sql="insert into $wms.store_in (lot_no, ref1, ref2, qty_rec, date, remarks, log_user,plant_code,created_user,created_at,updated_user,updated_at) values ('$lot_no[$i]', '$ref1', '$box[$i]', $qty[$i], '$date', '$remarks[$i]','$user_name','$plant_code','$username','$current_date','$username','$current_date')";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$last_id = mysqli_insert_id($link);

		$update_query="UPDATE `$wms`.`store_in` SET barcode_number=CONCAT('".$global_facility_code."-',tid),updated_user='$username',updated_at='$current_date' where plant_code='$plant_code' AND tid='$last_id'";
		$sql_result1=mysqli_query($link, $update_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	$url=  getFullURL($_GET['r'],'quick_insert_v1.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url&ref=$ref\"; }</script>";
  
}

?>
<style>
.bottom td{
	border : 1px solid white;
}
#reset_table1{
	color : #ffffff;
	background-color: lightgreen;
    text-align: center;
    display: inline-block;
    font-size: 15px;
}
</style>