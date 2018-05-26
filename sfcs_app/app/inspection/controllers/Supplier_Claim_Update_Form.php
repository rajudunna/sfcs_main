<html>
<title>Supplier Claim Request Form</title>
<head>
<style type="text/css">

th, td
{
	white-space: nowrap;
}
</style>

<script>


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('submitx').disabled='';
	} 
	else 
	{
		document.getElementById('submitx').disabled='true';
	}
}

function button_disable()
{
	var sraq = document.getElementById('txtsuprepqty').value;
	var scaq = document.getElementById('txtsupcrdqty').value;

	if($('#comp_status_code').val() != 3){
		return true;
	}

	if(  (sraq == '' && scaq == '') || (Number(sraq) <= 0  && Number(scaq) <= 0) ){
		sweetAlert('Atleast One quantity to be filled','','info');
		return false;
	}
	return true;
}
</script>

</head>
<body>
<div class="panel panel-primary">
<?php
echo '<div class="panel-heading">Supplier Claim Update Form</div>';
echo "<div class=\"panel-body\">";
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 

?>	
<?php
if(isset($_GET["sno"]))
{
	$comaplint_no=$_GET["sno"];	
	$status_comp = $_GET['stat'];
}
else
{
	$comaplint_no=$_POST["txtcomsno"];	
}
?>
<form action="<?php echo getFullURL($_GET['r'], "Supplier_Claim_Update_Form.php", "N")?>" method="POST">
<?php
	
	echo "<div class='table-responsive'><table cellspacing=\"0\" id=\"table2\" class=\"table table-striped jambo_table bulk_action\" border=1>";	
	echo "<thead><tr><th>Complaint No</th><th>Product Category</th><th>Complaint Category</th><th>Request Date</th><th>Request User</th><th>Supplier Name</th><th>Buyer Name</th><th>Reject Item Codes</th><th>Reject Item Colors</th><th>Batch No</th><th>PO No</th><th>Lot No</th><th>Reject Roll Qty</th><th>Reject Len Qty</th>
<th>UOM</th><th>Complaint Remarks</th></tr></thead>";

	$sql="select * from $bai_rm_pj1.inspection_complaint_db where complaint_no=\"".$comaplint_no."\"";
	
	$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{
		$complaint_no=$row["complaint_no"];
		$product_categoy=$row["product_categoy"];
		$complaint_category=$row["complaint_category"];
		$req_date=$row["req_date"];
		$complaint_raised_by=$row["complaint_raised_by"];
		$supplier_name=$row["supplier_name"];
		$buyer_name=$row["buyer_name"];
		$reject_item_codes=$row["reject_item_codes"];
		$reject_item_color=$row["reject_item_color"];
		$reject_batch_no=$row["reject_batch_no"];
		$reject_po_no=$row["reject_po_no"];
		$reject_lot_no=$row["reject_lot_no"];
		$reject_roll_qty=$row["reject_roll_qty"];
		$reject_len_qty=$row["reject_len_qty"];
		$uom=$row["uom"];
		$supplier_approved_date=$row["supplier_approved_date"];
		$supplier_status=$row["supplier_status"];
		$supplier_remarks=$row["supplier_remarks"];
		$new_invoice_no=$row["new_invoice_no"];
		$supplier_replace_approved_qty=$row["supplier_replace_approved_qty"];
		$supplier_claim_approved_qty=$row["supplier_claim_approved_qty"];
		$complaint_status=$row["complaint_status"];
		$comaplint_remarks=$row["complaint_remarks"];
		$supplier_claim_no=$row["supplier_claim_no"];
		$supplier_credit_no=$_row["supplier_credit_no"];
		
		echo "<tr>";
		echo "<td>$complaint_no</td><td>$product_categoy</td><td>$complaint_category</td><td>$req_date</td><td>$complaint_raised_by</td><td>$supplier_name</td><td>$buyer_name</td><td>$reject_item_codes</td><td>$reject_item_color</td><td>$reject_batch_no</td><td>$reject_po_no</td><td>$reject_lot_no</td><td>$reject_roll_qty</td><td>$reject_len_qty</td><td>$uom</td><td>$comaplint_remarks</td></tr>";
	}
	
	if(strlen($supplier_approved_date) > 0)
	{
		$supplier_approved_date=$supplier_approved_date;
	}
	else
	{
		$supplier_approved_date=date("Y-m-d");
	}
	
	if(strlen($supplier_replace_approved_qty) > 0)
	{
		$supplier_replace_approved_qty=$supplier_replace_approved_qty;
	}
	else
	{
		$supplier_replace_approved_qty=0;
	}
	
	if(strlen($supplier_claim_approved_qty) > 0)
	{
		$supplier_claim_approved_qty=$supplier_claim_approved_qty;
	}
	else
	{
		$supplier_claim_approved_qty=0;
	}
	
	if(strlen($supplier_remarks) > 0)
	{
		$supplier_remarks=$supplier_remarks;
	}
	else
	{
		$supplier_remarks="";
	}
	
	$supplier_status_codes=array("Replacement","Both","Credit Note");
	$comaplint_status_codes=array("Waiting","Not Agreed","Hold","Agreed");
	
	echo "</table></div>";
	echo "<br><br>";
	echo "<div class=\"table-responsive \"><table class=\"table jambo_table bulk_action table-bordered\" width=\"100%\" cellpadding=\"5\" cellspacing=\"5\"  style=\"color: #000000\">";
	echo "<tr>";
	echo "<th class=\"style1\">Supplier Claim Status Date</th><td><input type=\"hidden\" class=\"form-control\" name=\"txtcomsno\" value=\"".$comaplint_no."\" />
		  <input class=\"form-control\" type=\"text\" data-toggle=\"datepicker\" name=\"txtsupdate\" value=\"".$supplier_approved_date."\" />
		  </td>";
	echo "<th>Complaint Status</th><td><select class=\"form-control\" id='comp_status_code' name=\"selcomsta\" onchange='disable_all(this)'>";
	
	for($i=0;$i<sizeof($comaplint_status_codes);$i++)
	{	
		
		if($i==$status_comp){
			echo "<option value=\"".$i."\" selected>".$comaplint_status_codes[$i]."</option>";
			
		}else{
			echo "<option value=\"".$i."\" >".$comaplint_status_codes[$i]."</option>";
		}
	}	
	echo "</td>";	  
	echo "<th class='fixed'>Supplier Agreed For</th><td>
	<select class=\"form-control\" name=\"selsupcat\" id=\"selsupcat\" onchange=\"sagree()\">";
	for($i=0;$i<sizeof($supplier_status_codes);$i++)
	{
		if($supplier_status_codes[$i]=='Both')
		{
			echo "<option value=\"".$i."\" selected>".$supplier_status_codes[$i]."</option>";
			continue;
		}
		echo "<option value=\"".$i."\">".$supplier_status_codes[$i]."</option>";
	
	}		
	echo "</select></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th class=\"style1\">Supplier Remarks</th><td><textarea class=\"form-control\" name=\"txtsupremarks\" rows=\"4\" cols=\"20\">$supplier_remarks</textarea></td>";
	echo "<th class=\"style2\">New Invoice No</th><td><input class=\"form-control alpha\" type=\"text\" name=\"txtnewinv\" id=\"txtnewinv\" value=\"$new_invoice_no\" /></td>";
	echo "<th class='fixed'>Supplier Replacement Agreed <br/>Qty</th><td><input class=\"form-control float\" type=\"text\" name=\"txtsuprepqty\"  id=\"txtsuprepqty\" value=\"$supplier_replace_approved_qty\" onkeyup=\"validateqty()\"/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Supplier Credit Agreed Qty</th><td><input class=\"form-control float\" type=\"text\" name=\"txtsupcrdqty\"  id=\"txtsupcrdqty\" value=\"$supplier_claim_approved_qty\" onkeyup=\"validateqty()\"/></td>";
	echo "<th>Supplier Credit Note No</th><td><input class=\"form-control alpha\" type=\"text\" name=\"txtsupcrdno\" id=\"txtsupcrdno\" value=\"$supplier_credit_no\" /></td>";
	echo "<th class='fixed'>Claim Note No</th><td><input class=\"form-control alpha\" type=\"text\" name=\"txtsupclmno\" id='claim_note_no' value=\"$supplier_claim_no\" /></td>";
	
	echo "</tr>";
	echo "</table></div>";
	
	echo '<div class="col-md-offset-10"><p align=\"center\"><input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
	echo "<input type=\"submit\" class= \"btn btn-sm btn-primary\" id=\"submitx\" disabled class=\"form-control\" name=\"submitx\" value=\"Update\" onclick=\"return button_disable();\"></div>";
	
?>
</form>	
</div>	
<?php
if(isset($_POST['submitx']))
{
	$comaplint_no_ref=$_POST["txtcomsno"];
	$supplier_approved_date=$_POST["txtsupdate"];
	$supplier_status=$_POST["selsupcat"];
	$supplier_remarks=$_POST["txtsupremarks"];
	$new_invoice_no=$_POST["txtnewinv"];
	$supplier_replace_approved_qty=$_POST["txtsuprepqty"];
	$supplier_claim_approved_qty=$_POST["txtsupcrdqty"];
	$complaint_status=$_POST["selcomsta"];
	$credit_note_no=$_POST["txtsupcrdno"];
	$claim_note_no=$_POST["txtsupclmno"];
	
	$sql2="update $bai_rm_pj1.inspection_complaint_db set supplier_approved_date=\"$supplier_approved_date\",supplier_status=\"$supplier_status\",supplier_remarks=\"$supplier_remarks\",new_invoice_no=\"$new_invoice_no\",supplier_replace_approved_qty=\"$supplier_replace_approved_qty\",supplier_claim_approved_qty=\"$supplier_claim_approved_qty\",complaint_status=\"$complaint_status\",supplier_credit_no=\"$credit_note_no\",supplier_claim_no=\"".$claim_note_no."\" WHERE complaint_no=\"$comaplint_no_ref\"";
	mysqli_query($link, $sql2) or die("Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo "<script>sweetAlert('Data Updated Successfully','','success')</script>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURL($_GET['r'], "Supplier_Claim_Request_Form.php", "N")."\"; }</script>";	
}
?>
	 
</body>
</html>

<script>
function sagree()
{
	var supagree=document.getElementById('selsupcat').value;
	// alert(supagree);
	if(supagree==0)
	{
		document.getElementById("txtsupcrdqty").readOnly = true;
		document.getElementById("txtsupcrdno").readOnly = true;
		document.getElementById("txtsupcrdqty").value = '';
		document.getElementById("txtsupcrdno").value = '';
		document.getElementById("txtsuprepqty").readOnly = false;
	}
	if(supagree==2)
	{
		document.getElementById("txtsuprepqty").readOnly = true;
		document.getElementById("txtsuprepqty").value = '';
		document.getElementById("txtsupcrdqty").readOnly = false;
		document.getElementById("txtsupcrdno").readOnly = false;
	}
	if(supagree==1)
	{
		document.getElementById("txtsupcrdqty").readOnly = false;
		document.getElementById("txtsupcrdno").readOnly = false;
		document.getElementById("txtsuprepqty").readOnly = false;
	}
	
}


function validateqty()
{
	// alert("hiiii");
	var supagreedqty=document.getElementById("txtsuprepqty").value;
	var supcredagreqty=document.getElementById("txtsupcrdqty").value;
	var tot=Number(supagreedqty)+Number(supcredagreqty);
	
	var rejlenqty='<?php echo $reject_len_qty;?>';
	var rejrolqty='<?php echo $reject_roll_qty;?>';
	
	var tot1=Number(rejlenqty)+Number(rejrolqty);
	
	if(tot > tot1)	
	{
		sweetAlert("You cant enter more than Reject Len and Reject Roll Qty","","warning");
		document.getElementById("txtsuprepqty").value="0";
	    document.getElementById("txtsupcrdqty").value="0";
	}
}

function disable_all(t){
	var v = t.value;
	if(v!=3){
		document.getElementById("txtsupcrdqty").readOnly = true;
		document.getElementById("txtsupcrdno").readOnly = true;
		document.getElementById("txtsuprepqty").readOnly = true;
		document.getElementById("claim_note_no").readOnly = true;
		document.getElementById("txtnewinv").readOnly = true;
		document.getElementById("selsupcat").disabled = true;

		document.getElementById("txtsupcrdqty").value = '';
		document.getElementById("txtsupcrdno").value = '';
		document.getElementById("txtsuprepqty").value = '';
		document.getElementById("claim_note_no").value = '';
		document.getElementById("txtnewinv").value = '';

		//document.getElementById('submitx').disabled=true;
		//document.getElementById("option").style.display = 'none';
	
	}else{
		document.getElementById("txtsupcrdqty").readOnly = false;
		document.getElementById("txtsupcrdno").readOnly = false;
		document.getElementById("txtsuprepqty").readOnly = false;
		document.getElementById("claim_note_no").readOnly = false;
		document.getElementById("txtnewinv").readOnly = false;
		document.getElementById("selsupcat").disabled = false;
	
	}
}

$('document').ready(function(){
	if($('#comp_status_code').val() != 3){
		document.getElementById("txtsupcrdqty").readOnly = true;
		document.getElementById("txtsupcrdno").readOnly = true;
		document.getElementById("txtsuprepqty").readOnly = true;
		document.getElementById("claim_note_no").readOnly = true;
		document.getElementById("txtnewinv").readOnly = true;
		document.getElementById("selsupcat").disabled = true;
		document.getElementById("txtsupcrdqty").value = '';
		document.getElementById("txtsupcrdno").value = '';
		document.getElementById("txtsuprepqty").value = '';
		document.getElementById("claim_note_no").value = '';
		document.getElementById("txtnewinv").value = '';
		//document.getElementById('submitx').disabled=true;
		//document.getElementById("option").style.display = 'none';
	}
})
</script>
<style>
	.fixed{
		width : 100px;
	}
</style>

