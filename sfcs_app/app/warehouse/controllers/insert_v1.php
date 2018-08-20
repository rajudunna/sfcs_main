<!--
Change Log: 
2014-12-16/ kirang/ service request #780212  / add the User Names from database level

2015-04-17/ kirang/ Service Request #116858 / Added Validation For Auto Quantity Fill Textbox to avoid the Negative Entries

-->
<?php
	$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
	// require_once('phplogin/auth.php');
	ob_start();
	$has_permission = haspermission($_GET['r']);
	
	// require_once "ajax-autocomplete/config.php";
	// $url = getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R');
	// include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
	// $url = getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R');
	// include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 
	// $view_access=user_acl("SFCS_0158",$username,1,$group_id_sfcs);
?>

<?php
//$authorized=array("kirang","maheswararaok","nazeers","sureshg","sivashankarb","baiadmn","bainet","kirang","apparaoo","kirang","narasingaraon","ramprasadk","demudun","pothurajus","kirang");

/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$sql="select * from menu_index where list_id=161";
$result=mysql_query($sql,$link1) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$auth_users=explode(",",$users);
*/
if(in_array($view,$has_permission))
{
	
} 
else
{
	header("Location:restrict.php");		
}

?>

<!-- <script type="text/javascript" src="ajax-autocomplete/jquery.js"></script>
<script type='text/javascript' src='ajax-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="ajax-autocomplete/jquery.autocomplete.css" /> -->

<script type="text/javascript">
// $().ready(function() {
// 	$("#course").autocomplete("ajax-autocomplete/get_course_list_rec_no.php", {
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
</script>


  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>


<style>
#leftcolumn { /* width: 300px; */ margin-left:5px;float: right; }
#rightcolumn { width: 300px;padding-left:5px; margin-left:75px; float: right; }
#heading { width: 300px; float: left; }
.clear { clear: both;}

</style>

<body onload="dodisable();">

<?php 
	include("stock_in.php"); 
?>

<?php

if(isset($_POST['submit']))
{	
	$sql="select lot_no from $bai_rm_pj1.sticker_report where lot_no=\"".trim($_POST['lot_no'])."\" or rec_no=\"".trim($_POST['lot_no'])."\"";
	$sql_result=mysqli_query($link, $sql);
	// echo $sql.'<br>';
	// echo "Rows".mysql_num_rows($sql_result);
	if(mysqli_num_rows($sql_result)>0)
	{
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$lot_no=$sql_row['lot_no'];
		}
	}else{
		// echo "<table class='table table-bordered'><tr class='danger'><td align='center'>Lot Number not found</td></tr></table>";
		echo "<script>sweetAlert('Receiving / Lot Number not found','','warning')</script>";
	}		
	
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
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
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
	$uom=$sql_row['uom'];
	$grn_type=$sql_row['grn_type'];
	
	$message="<font color=green><b>In Stock</b></font>";
	if($sql_row['backup_status']==1)
	{
		$message="<font color=red><b>Account Closed</b></font>";
	}
	
	//NEW SYSTEM IMPLEMENTATION RESTRICTION
	
	
	// $new_ref_date=substr($grn_date,0,4)."-".substr($grn_date,4,2)."-".substr($grn_date,6,2);
	// if($new_ref_date>"2017-01-01")
	// {
		
	// }
	// else
	// {
	// 	// echo "<br/> GRN Date:".$new_ref_date."<br/>";
	// 	//echo "test";
	// 	//header("Location:restrict.php");
	// }
	//NEW SYSTEM IMPLEMENTATION RESTRICTION
}

$sql="select sum(qty_rec) as \"qty_rec\" from $bai_rm_pj1.store_in where lot_no=\"".trim($lot_no)."\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$qty=$sql_row['qty_rec'];
}

$diff=round(($rec_qty-$qty),2);

//echo $diff;
$url = getFullURL($_GET['r'],'quick_search.php','N');
if ($inv_no=='') {
	$inv='<font color=red>No Invoice Number for this Lot</font>';
} else {
	$inv="<a href=\"$url&ref=$inv_no\" class=\"btn btn-info btn-xs\">$inv_no</a>";
}

if ($po_no=='') {
	$po='<font color=red>No PO Number for this Lot</font>';
} else {
	$po="<a href=\"$url&ref=$po_no\" class=\"btn btn-info btn-xs\">$po_no</a>";
}

if ($batch_no=='') {
	$bat='<font color=red>No Batch Number for this Lot</font>';
} else {
	$bat=$batch_no;
}
$url=  getFullURLLevel($_GET['r'],'common/lib/mpdf7/labels.php',3,'R');

echo '<form name="test" id="myForm" action="'.getFullURL($_GET['r'],'data_v1.php','N').'" method="post" enctype="multipart/form-data">';
echo "<div class='panel panel-default'>
		<div class='panel-body'>
			<div class='row'>
				<div class='col-md-3'>
					<b>Lot No :</b> $lot_no
				</div>
				<div class='col-md-3'>
					<b>Batch :</b> $bat
				</div>
				<div class='col-md-3'>
					<b>PO No :</b> $po
				</div>
				<div class='col-md-3'>
					<b>Receiving No :</b> $rec_no
				</div>
			</div>
			<br/>
			<div class='row'>
				<div class='col-md-3'>
					<b>Item Code :</b> $item
				</div>
				<div class='col-md-3'>
					<b>Invoice # :</b> $inv
				</div>
				<div class='col-md-3'>
					<b>Item Description :</b> $item_desc
				</div>
				<div class='col-md-3'>
					<b>Item Name :</b> $item_name
				</div>
			</div>
			<br/>
			<div class='row'>
				<div class='col-md-3'>
					<b>Product :</b> $product_group
				</div>
				<div class='col-md-3'>
					<b>UOM :</b> $uom
				</div>
				<div class='col-md-3'>
					<b>Package :</b> $pkg_no
				</div>
				<div class='col-md-3'>
					<b>GRN Date :</b> $grn_date
				</div>
			</div>
			<br/>
			<div class='row'>
				<div class='col-md-3'>
					<b>Received Qty :</b> $rec_qty
				</div>
				<div class='col-md-3'>
					<b>Labeled Qty :</b> $qty
				</div>
				<div class='col-md-3'>
					<b>Balance to be Labeled :</b> <input type=\"hidden\" value=\"$diff\" name=\"available\" id=\"available\">$diff
				</div>
				<div class='col-md-3'>
					<b>Balance to enter :</b> <input type='number' name='balance_new11' id='balance_new11' readonly='readonly' value='".$diff."' style='width: 120px;border:0px;'>
					<input type='hidden' id='dummy_available' value='".$diff."'>
				</div>
			</div>
			<br/>
			<div class='row'>
				<div class='col-md-3'>
					<b>Status : </b>$message
				</div>
				<div class='col-md-3'>
					<b>Print Labels : </b>";
					if($qty>0){
						echo "<a href=\"#\" onclick=\"Popup=window.open('$url?lot_no=$lot_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\" class=\"btn btn-warning btn-xs\"><i class=\"fa fa-print\"></i>&nbsp;Print Labels Here</a>";
					}else{
						echo "<a href=\"#\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-print\"></i>&nbsp;No Rolls Updated</a>";
					}
					
		echo "</div>";
		echo "<div class='col-md-3'>
					<b>GRN Type : </b>$grn_type
			</div>
			</div>
		</div></div>";

// echo "<div class='col-md-4'>";
// 	echo "<table class='table table-bordered'>";
// 	echo "<tr><td>Lot No</td><td>:</td><td>$lot_no</td></tr>";
// 	echo "<tr><td>Batch</td><td>:</td><td>".$bat."</td></tr>";
// 	echo "<tr><td>PO No</td><td>:</td><td>".$po."</td></tr>";
// 	echo "<tr><td>Receiving No</td><td>:</td><td>$rec_no</td></tr>";

// 	echo "<tr><td>Item Code</td><td>:</td><td>$item</td></tr>";
// 	echo "<tr><td>Invoice #</td><td>:</td><td>".$inv."</td></tr>";

// 	echo "<tr><td>Item Description</td><td>:</td><td>$item_desc</td></tr>";
// 	echo "<tr><td>Item Name</td><td>:</td><td>$item_name</td></tr>";
// 	echo "<tr><td>Product</td><td>:</td><td>$product_group</td></tr>";
// 	echo "<tr><td>Package</td><td>:</td><td>$pkg_no</td></tr>";
// 	echo "<tr><td>GRN Date</td><td>:</td><td>$grn_date</td></tr>";
// 	echo "<tr><td>Received Qty</td><td>:</td><td>$rec_qty</td></tr>";
// 	echo "<tr><td>Labeled Qty</td><td>:</td><td>$qty</td></tr>";
// 	echo "<tr><td>Balance to be Labeled</td><td>:</td><td><input type=\"hidden\" value=\"$diff\" name=\"available\" id=\"available\">$diff</td></tr>";
// 	echo '<tr><td>Balance to enter</td><td>:</td><td><input type="text" name="balance_new11" id="balance_new11" readonly="readonly" value="'.$diff.'" class="form-control"></td></tr>';
// 	echo "</table></div>";

//echo "</td><td>";


$labels=array();
$status=array();
$names=array();

switch (trim($product_group))
{
	case "Elastic":
	{
		$labels=array("Box No:", "", "Received Qty:");
		$status=array("text", "hidden", "text");
		$names=array("ref2", "ref3", "qty");
		$uoe="YRD";
		break;
	}
	case "Lace":
	{
		$labels=array("Box No:", "Art No:", "Received Qty:");
		$status=array("text", "text", "text");
		$names=array("ref2", "ref3", "qty");
		$uoe=$fab_uom;
		break;
	}
	case "Fabric":
	{
		$labels=array( "Roll No:", "", "Roll Qty:");
		$status=array("text", "hidden", "text");
		$names=array("ref2", "ref3", "qty");
		$uoe="YRD";
		break;
	}
	case "Thread":
	{
		$labels=array( "Box No:", "", "Received Qty:");
		$status=array("text", "hidden", "text");
		$names=array("ref2", "ref3", "qty");
		$uoe="CON";
		break;
	}
	default:
	{
		$labels=array( "BOX No", "", "Received Qty:");
		$status=array("text", "hidden", "text");
		$names=array("ref2", "ref3", "qty");
		$uoe="PC";
		break;
	}
}

echo '<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-3">
					<label>Date : </label>
					<input type="text" name="date" value="'.date("Y-m-d").'" class="form-control" readonly="true">
				</div>
				<div class="col-md-3">
					<label>Remarks/ REF No : </label>
					<input type="text" name="remarks" value="" class="form-control">
				</div>
				<div class="col-md-3">
					<label>Choose File : </label>
					<select name="selectsearch" id="selectsearch1" class="form-control">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
					</select>
					<div id="upload">Select file:<input type="file" name="file" id="file" accept=".csv" /></br><a href="'.$url=  getFullURL($_GET['r'],'samplefile.csv','R').'" class="btn btn-warning btn-xs"><i class="fa fa-download"></i>  Download Sample CSV file</a></div>
				</div>
				<div class="col-md-3">
					<input type="hidden" value="'.$lot_no.'" name="lot_no">
					<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();"  style="margin-top:33px;">Enable
					<input type="submit" value="Submit" name="put" id="put" onclick="return button_disable();" class="btn btn-success style="margin-top:33px;"/>
				</div>
			</div>
		</div></div>';

// echo '<div class="col-md-8">
// <table class="table table-bordered"><tr><th>Field Name</th><th>Value</th></tr>

// <tr>
// <td>Date:</td><td><div class="col-md-6"><input type="text" name="date" value="'.date("Y-m-d").'" class="form-control" readonly="true"></div></td></tr>';

// echo '<tr><td style="display:none;">Location:</td><td style="display:none;"><select name="ref1">';
// echo "<option value=\"\"></option>";
// $sql="select * from location_db where status=1 order by sno";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_num_check=mysqli_num_rows($sql_result);
// while($sql_row=mysqli_fetch_array($sql_result))
// {
// 	echo "<option value=\"".$sql_row['location_id']."\">".$sql_row['location_id']."</option>";
// }


// echo '</select></td></tr>';
// echo '<tr><td>Remarks/ REF No:</td><td><div class="col-md-6"><input type="text" name="remarks" value="" class="form-control"></div></td></tr>';
// echo '<tr><td>Choose File :
// 		<select name="selectsearch" id="selectsearch1" class="form-control">
// 			<option value="No">No</option>
// 			<option value="Yes">Yes</option>
// 		</select> </td>
// 		<td width="80%"><div id="upload">Select file:<input type="file" name="file" id="file" accept=".csv" /></br><a href="'.$url=  getFullURL($_GET['r'],'samplefile.csv','R').'" class="btn btn-warning btn-xs"><i class="fa fa-download"></i>  Download Sample CSV file</a></div></td>
// 	   </tr>';
// echo '<tr>
// 		<td>
// 			<input type="hidden" value="'.$lot_no.'" name="lot_no">
// 			<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable
// 			<input type="submit" value="Submit" name="put" id="put" onclick="return button_disable();" class="btn btn-success btn-xs"/>';
// // echo '<div id="process_message"><h2><font color="red">Please wait!!</font></h2></div>';
// echo '</td>';
// $url=  getFullURL($_GET['r'],'/mpdf7/labels.php','R');
// if($qty>0){
// 	echo "<td><a href=\"$url?lot_no=$lot_no\" onclick=\"Popup=window.open('$url?lot_no=$lot_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\" class=\"btn btn-warning btn-xs\"><i class=\"fa fa-print\"></i>Print Labels Here</a></td></tr>";
// }else{
// 	echo "<td><a href=\"#\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-print\"></i>No Rolls Updated</a></td></tr>";
// }
//echo "<tr><td><a href=\"#\" onclick=\"javascript:fill_sr();\">Fill Series</a></td><td><a href=\"#\" onclick=\"javascript:clear_sr();\">Clear Series</a></td></tr>";
 

 
//  echo "<tr><td>Updating Unit</td><td>";
 
//  if(trim($product_group)=="Elastic" or trim($product_group)=="Fabric")
//  {
//  	echo "<input type=\"radio\" name=\"convert\" value=\"1\" > $fab_uom Nos <input type=\"radio\" name=\"convert\" value=\"2\" checked> YRD";
//  }
//  else
//  {
//  	echo "<input type=\"radio\" name=\"convert\" value=\"1\" checked> $fab_uom/Nos <input type=\"radio\" name=\"convert\" value=\"2\"> YRD";
//  }
 
// echo "</td></tr>";
echo "<input type=\"radio\" name=\"convert\" value=\"2\" checked style='display:none;'>";






//2015-04-17/ kirang/ Service Request #116858 / Added Validation For Auto Quantity Fill Textbox to avoid the Negative Entries

//  echo "<tr><td>Fixed Values Auto Fill <br></td>
// 			<td>
// 				<div class='row'>
// 					<div class='col-sm-1'><label>Qty:</label></div>
// 					<div class=\"col-md-2\">
// 					<input type=\"text\" size=\"5\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\"  name=\"auto_qty\" id=\"auto_qty\" class=\"form-control float\">
// 					</div>
// 					<div class='col-sm-3'><label>X Number of Rolls</label></div> 
// 					<div class=\"col-md-2\"><input type=\"text\" size=\"5\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" name=\"auto_rows\" id=\"auto_rows\" class=\"form-control integer\">
// 					</div>
// 					<a href=\"#\" onclick=\"javascript:fill_vsr();\" class=\"btn btn-info btn-xs\">Fill Values</a> | <a href=\"#\" onclick=\"javascript:clear_sr();\"  class=\"btn btn-danger btn-xs\">Clear Values</a>
// 				<br/><div class='col-sm-12'><font color='red'><label>Note : Auto-Complete is for One Time Use Only</label></font></div>
// 			</td>
// 		</tr>";
// echo "<tr><td>Status</td><td><h2>$message</h2></td></tr>";

// //echo "<tr><td colspan=2><a href=\"quick_insert_v1.php\"><h2>Bulk Entry Form (Price Tickets)</h2></a></td></tr>";
// echo "</table>";

// echo "</div>";
// echo"<br>";

/* echo"<form style='float:left' method='GET'>
		Choose File :
		<select name='selectsearch' id='selectsearch1'>
			<option value='No'>No</option>
			<option value='Yes'>Yes</option>
		</select>
	</form>";
echo"<table width='400' id='upload'>
		<form  method='post' enctype='multipart/form-data' >
			<tr>
				<td width='20%'>Select file</td>
				<td width='80%'><input type='file' name='file' id='file' /></td>
			</tr>
		</form>
	</table></br>"; */
// echo "<div class='panel panel-default'><div class='panel-body'>";
echo "<div class='row col-md-12' style='width:102%;'><table id='table1' class='table table-bordered'>";
echo "<tr><td><div class=\"col-md-12 col-md-offset-3\"><input type=\"text\" size=\"5\" value=\"1\" name=\"s_start\" class='integer'>&nbsp;&nbsp;<a href=\"#\" onclick=\"javascript:fill_sr();\" class=\"btn btn-info btn-xs\" style='margin-top:4px;'>Fill Series</a></div></td>
	<td>
	<div class='row'>
		<div class='col-md-12 col-md-offset-2'><b>Qty :</b>&nbsp;<input type=\"text\" size=\"5\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\"  name=\"auto_qty\" id=\"auto_qty\" class=\"float\">
		<b>X Number of Rolls</b>
		<input type=\"text\" size=\"5\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" name=\"auto_rows\" id=\"auto_rows\" class=\"integer\">
		<a href=\"#\" onclick=\"javascript:fill_vsr();\" class=\"btn btn-info btn-xs\" style='margin-top:4px;'>Fill Values</a> | <a href=\"#\" onclick=\"javascript:clear_sr();\"  class=\"btn btn-danger btn-xs\" style='margin-top:4px;'>Clear Values</a>
		</div>
	<br/><div class='col-sm-12 col-md-offset-3'><font color='red'><label>Note : Auto-Complete is for One Time Use Only</label></font></div>
	</td>
</tr>";
echo "<tr>";
for($i=0; $i<sizeof($labels);$i++)
{
	if($labels[$i] != null){
		if($names[$i]=="qty")
		{
			echo "<th style='text-align:center'>".$labels[$i]." <b style='color:red'>*</b> </th>";
		}
		else
		{
			echo "<th style='text-align:center'>".$labels[$i]."<b style='color:red'>*</b></th>";	
		}
		echo "<input type='hidden' value='$labels[$i]' id='label'>";
	}

}

echo "</tr>";

$counter = 0;
for($j=0;$j<100;$j++)
{
	echo "<tr>";
	for($i=0; $i<sizeof($labels);$i++)
	{
		if($labels[$i] != null){
			if($names[$i]=="qty")
			{
				$counter++;
				// <b>'.$uoe.'</b>
				//echo '<td><input type="'.$status[$i].'" name="'.$names[$i].'['.$j.']" value="" onchange="if(check3(this.value,'.$diff.','.$j.",'qty[]'".')==1010){ this.value=0;}">'.$uoe.'</td>';
				echo '<td><div class="col-md-6 col-md-offset-3">
				<input type="'.$status[$i].'" name="'.$names[$i].'['.$j.']" id=name="'.$names[$i].'['.$j.']" 
				value="" onChange="quantity(this);" class="form-control float">
				</div>';

				if($counter == 1){
					echo "
					<div class='col-md-3' id='parent'>
						<div id='floater'><b class='label label-info'>Balance Qty :</b> 
						<input type='number' name='balance_new11_qty' id='balance_new11_qty' readonly='readonly' value='".$diff."' style='width: 80px;border:0px;color:red'>
						</div>
					</div>";
				}
				echo '</td>';
			}
			else
			{
				// echo '<td><input type="'.$status[$i].'" name="'.$names[$i].'['.$j.']" value=""  onkeypress="return validate2(event)"></td>';	
				echo '<td><div class="col-md-6 col-md-offset-3">
				<input type="'.$status[$i].'" name="'.$names[$i].'['.$j.']"  
				value="" class="form-control alpha" onChange="verify_dup_box_no(this)"/>
				</div></td>';	
			}
		}
	}
	//echo $status[$i]; 
	echo "</tr>";

}
echo '</table></div>';
echo '</form></div>';
// echo "</div></div>";


}
?>
<div class="clear">
</div>
</div>
</div>
</div>
<script>
jQuery(document).ready(function($){
   $('#course1').keypress(function (e) {
       var regex = new RegExp("^[0-9a-zA-Z\]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});
$(document).ready(function()
{	
	$(window).scroll(function(){
		var h = $('#floater').offset().top;
		var p = $('#parent').offset().top;
		h = (h - $(window).scrollTop());//actual scrolling div
		p = (p - $(window).scrollTop());//refference scrolling div to manipulate scrollling div
	
		if(h < 50){
			$('#floater').addClass('sticky');	
		}
		if(p>0){
			$('#floater').removeClass('sticky');
		}
	});


	$('#upload').hide();
	$('#selectsearch1').change(function()
	{
		if ($('#selectsearch1').val() == 'Yes')
		{
			$('#upload').show();
			$('#table1').hide();
		}
		if ($('#selectsearch1').val() == 'No')
		{
			$('#upload').hide();
			$('#table1').show();
		}
	});

	var uploadField = document.getElementById("file");
	if(uploadField != null){
		uploadField.onchange = function() {
			if(this.files[0].size > 5300000){
			sweetAlert('File is too big','Cant Upload','info');
			this.value = "";
			};
		};
	}

});



</script>

<style>
.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}
.actual {
  position: absolute;
  top: 0;
  width: 100%;
}
</style>