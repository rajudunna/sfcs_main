<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$has_permission=haspermission($_GET['r']);
?>
<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript">
function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
	
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}
</script>
<script language="javascript" type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=900,width=600,resizable=yes,scrollbars=yes');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
</head>
<body>
<?php
if(isset($_POST['selcompro']))
{
	$division=$_POST['selcompro'];
}
else
{
	$division="-1";
}
$Page_Id='SFCS_0057';

?>

<div class="panel panel-primary">
<div class="panel-heading">Supplier Claim Log</div>
<div class="panel-body">
<div class="form-group">
	<?php
if(in_array($authorized,$has_permission))
{
	echo '<a class="btn btn-info btn-xs" href="'.getFullURLLevel($_GET["r"],"controllers/Supplier_Claim_Request_Form.php",1,"N").'">Request Form</a> | <a class="btn btn-info btn-xs" href="'.getFullURL($_GET["r"],"Supplier_Claim_Log_Form.php","N").'">Log</a> <hr>';
}
?>
<form  action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" name="test">

Start Date: 
<input type="text" class="form-control" data-toggle="datepicker" style="width: 150px;  display: inline-block;" id="demo1" name="txtstartdate" value="<?php  if(isset($_POST['txtstartdate'])) { echo $_POST['txtstartdate']; } else { echo date("Y-m-d"); } ?>" />

End Date:
<input type="text" id="demo2" class="form-control" data-toggle="datepicker" onchange="return verify_date();" style="width: 150px;  display: inline-block;" name="txtenddate" value="<?php  if(isset($_POST['txtenddate'])) { echo $_POST['txtenddate']; } else { echo date("Y-m-d"); } ?>" />

Complaint Status <select name="selcompro" class="form-control"  style="width: 120px;  display: inline-block;" >
				 <option value="-1" <?php if($division=="-1"){ echo "selected"; } ?>>All</option>
				 <option value="1" <?php if($division=="1"){ echo "selected"; } ?>>Not Agreed</option>
				 <option value="2" <?php if($division=="2"){ echo "selected"; } ?>>Hold</option>
				 <option value="3" <?php if($division=="3"){ echo "selected"; } ?>>Agreed</option> </select>
Enter Batch / Invoice # : <input type="text"  name="batch" id="batch" class="form-control alpha"  onchange="return pop_check();"  style="width: 150px;  display: inline-block;">
&nbsp;<input type="submit" class="btn btn-success"  value="Show" name="show" onclick="return verify_date();" />				

</form>		
</div>	 
<?php
if(isset($_POST['show']) || isset($_GET['show']))
{
	echo "<br/>";

	if(isset($_GET['show'])){
		$startdate  = $_GET['sdate'];
		$enddate 	= $_GET['edate'];
		$status 	= $_GET['stat'];
		$batch 		= $_GET['bat'];
	}else{
		$startdate=$_POST["txtstartdate"];	
		$enddate=$_POST["txtenddate"];	
		$status=$_POST["selcompro"];	
		$batch=$_POST["batch"];
	}
	

	if($status >= 0)
	{		
		if($batch=="")
		{
		
		$sql="select * from $bai_rm_pj1.inspection_complaint_db where DATE(req_date) between \"".$startdate."\" and \"".$enddate."\" and complaint_status=\"".$status."\"";
		}
		else
		{
			$sql="select * from $bai_rm_pj1.inspection_complaint_db where reject_batch_no = \"".$batch."\" OR reject_inv_no=\"".$batch."\"";
		}
	}
	else
	{
		
		if($batch=="")
		{
		$sql="select * from $bai_rm_pj1.inspection_complaint_db where DATE(req_date) between \"".$startdate."\" and \"".$enddate."\"";
		}
		else
		{
		$sql="select * from $bai_rm_pj1.inspection_complaint_db where reject_batch_no = \"".$batch."\" OR reject_inv_no=\"".$batch."\"";
		}	
	}
	$result=mysqli_query($link, $sql) or die("Error=".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
	$count=mysqli_num_rows($result);
	if($count > 0){
		$flag=true;
		echo "<div id='main_div'>";
		echo "<div class='table-responsive'>";
		echo "<table cellspacing=\"0\" id=\"table1\" class='table table-striped jambo_table bulk_action' border=1  >";	
		echo "<tr class='headings'><th>Complaint No</th><th>Complaint Category</th><th>Report No</th><th>Product Category</th><th>Complaint Type</th><th>Request Date</th><th>Request User</th><th>Supplier Name</th><th>Buyer Name</th><th>Item Desc</th><th>Item Codes</th><th>Item Colors</th><th>Batch No</th><th>Invoice No</th><th>PO No</th><th>Lot#</th><th>Purchase Width</th><th>Actual Width</th><th>Purchase GSM</th><th>Actual GSM</th><th>Inspected Qty</th><th>Reject Roll Qty</th><th>Length Short Qty</th><th>Total Replacement Required</th><th>UOM</th><th>Complaint Remarks</th><th>Supplier Approved Date</th><th>Replacement Category</th><th>Supplier Remarks</th><th>Claim Note No</th></th><th>New Invoice No</th><th>Supplier Replace Approved Qty</th><th>Supplier Claim Approved Qty</th><th>Credit Note No</th><th>Complaint Status</th><th>Print</th><th>Mail Status</th>";
		
		if(in_array($authorized,$has_permission))
		{
			echo "<th>Controls</th>";
		}
		
		echo "</tr>";
		if ($count==0) {
			echo '<div class="alert alert-danger alert-dismissible fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					No Supplier Claims Found 
				</div>';
		} else {	
			while($row=mysqli_fetch_array($result))
			{
				$complaint_no=$row["complaint_no"];
				$ref_no=$row["ref_no"];
				$product_categoy=$row["product_categoy"];
				$complaint_category=$row["complaint_category"];
				$req_date=$row["req_date"];
				$complaint_raised_by=$row["complaint_raised_by"];
				$supplier_name=$row["supplier_name"];
				$buyer_name=$row["buyer_name"];
				$reject_item_desc=$row["reject_item_desc"];
				$reject_item_codes=$row["reject_item_codes"];
				$reject_item_color=$row["reject_item_color"];
				$reject_batch_no=$row["reject_batch_no"];
				$reject_po_no=$row["reject_po_no"];
				$reject_invoice_no=$row["reject_inv_no"];
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
				$mail_status=$row["mail_status"];
				$purchase_width=$row["purchase_width"];
				$actual_width=$row["actual_width"];
				$purchase_gsm=$row["purchase_gsm"];
				$actual_gsm=$row["actual_gsm"];
				$inspqty_lot=$row["inspected_qty"];
				$complaint_cat_ref=$row["complaint_cat_ref"];
				
				$complaint_cat_ref_name="External";
				
				if($complaint_cat_ref==1)
				{
					$complaint_cat_ref_name="Internal";
				}
						
				$batch_lots=0;
				$sql1="select GROUP_CONCAT(DISTINCT lot_no) AS lots from $bai_rm_pj1.sticker_report WHERE batch_no=\"".$reject_batch_no."\"";	
				$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowsx=mysqli_num_rows($result1);
				if($rowsx > 0)
				{
					while($row1=mysqli_fetch_array($result1))
					{
						$batch_lots=$row1["lots"];
					}
				}

				$sql3="select unique_id as uid,log_date as upd from  $bai_rm_pj1.inspection_db where batch_ref=\"".$reject_batch_no."\"";
				$result3=mysqli_query($link, $sql3) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row3=mysqli_fetch_array($result3))
				{
					$unique_id=$row3["uid"];
					$inspc_update=$row3["upd"];
				}	
							
				echo "<tr>";
				echo "<td>$ref_no</td><td>".$complaint_cat_ref_name."</td><td>".date("ymd",strtotime($inspc_update))."/".substr($buyer_name,0,3)."/".$unique_id."</td><td>$product_categoy</td><td>$complaint_category</td><td>$req_date</td><td>$complaint_raised_by</td><td>$supplier_name</td><td>$buyer_name</td><td>$reject_item_desc</td><td>$reject_item_codes</td><td>$reject_item_color</td><td>$reject_batch_no</td><td>$reject_invoice_no</td><td>$reject_po_no</td><td>$reject_lot_no</td><td>$purchase_width</td><td>$actual_width</td><td>$purchase_gsm</td><td>$actual_gsm</td><td>$inspqty_lot</td><td>$reject_roll_qty</td><td>$reject_len_qty</td><td>".($reject_roll_qty+$reject_len_qty)."</td><td>$uom</td><td>$comaplint_remarks</td><td>$supplier_approved_date</td>";
				
				if($supplier_status == 0)
				{
					echo "<td>N/A</td>";
				}
				else if($supplier_status== 1)
				{
					echo "<td>Replacement</td>";
				}
				else if($supplier_status == 2)
				{
					echo "<td>Credit Note</td>";
				}
				else if($supplier_status == 3)
				{
					echo "<td>Both</td>";
				}
				else
				{
					echo "<td>N/A</td>";
				}
				
				echo "<td>$supplier_remarks</td><td>$supplier_claim_no</td><td>$new_invoice_no</td>
		<td>$supplier_replace_approved_qty</td><td>$supplier_claim_approved_qty</td><td>$supplier_claim_no</td>";
				
				if(in_array($authorized,$has_permission))
				{
					if($complaint_status == 0)
					{   
						echo "<td><a class='btn btn-xs btn-primary' href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&stat=$complaint_status&sno=$complaint_no'>Waiting</a></td>";
					}
					else if($complaint_status == 1)
					{
						echo "<td><a class='btn btn-xs btn-primary' href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&stat=$complaint_status&sno=$complaint_no'>Not Agreed</a></td>";

						
					}
					else if($complaint_status == 2)
					{
					echo "<td><a class='btn btn-xs btn-primary' href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&stat=$complaint_status&sno=$complaint_no'>Hold</a></td>";

					}
					else if($complaint_status == 3)
					{
					echo "<td><a class='btn btn-sm btn-primary' href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&stat=$complaint_status&sno=$complaint_no'>Agreed</a></td>";

					}
					else
					{
					echo "<td><a class='btn btn-sm btn-primary' href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&stat=$complaint_status&sno=$complaint_no'>Not Agreed<</a></td>";
					}
					$url=getFullURL($_GET['r'],'Supplier_Print_PDF.php','N');
					
					echo "<td><a class='btn btn-xs btn-primary' href=\"$url&sno=$complaint_no&status=2\" onclick=\"retur popitup('$url&sno=$complaint_no&status=2')\" target=\"_blank\">Print</a></td>";
				
					if($mail_status == 0)
					{
						$url_mail = $url."&sno=$complaint_no&status=0&sdate=$startdate&edate=$enddate&stat=$status&bat=$batch";
						echo "<td><a id='mail_button' class='btn btn-xs btn-warning' href=\"$url_mail\" onclic=\"return popitup('$url&sno=$complaint_no&status=0')\">Not Sent</a></td>";
					}
					else
					{
						echo "<td>Sent</td>";
					}
				}	
				else
				{
						if($complaint_status == 0)
						{
							echo "<td>Waiting</td>";
						}
						else if($complaint_status == 1)
						{
							echo "<td>Not Agreed</td>";
						}
						else if($complaint_status == 2)
						{
							echo "<td>Hold</td>";
						}
						else if($complaint_status == 3)
						{
							echo "<td>Agreed</td>";
						}
						else
						{
							echo "<td>Not Agreed</td>";
						}
						
						echo "<td><a class='btn btn-xs btn-primary' href=\"$url&sno=$complaint_no&status=2\" onclick=\"return popitup('$url&sno=$complaint_no&status=2')\" target=\"_blank\">Print</a></td>";
						
						if($mail_status == 0)
						{
							echo "<td>Not Sent</td>";
						}
						else
						{
							echo "<td>Sent</td>";
						}
				}	
				// $url1=getFullURL($_GET['r'],'status_update.php','N');
				// $sHTML_Content .="<td bgcolor=\"$id\"><a href=\"url1&tid=$ref_id&&schedule=$schedule\" onclic=\"return popitup('$url1&tid=$ref_id&&schedule=$schedule')\">".$x."</a><input type=\"hidden\" name=\"rtid[]\" value=\"".$ref_id."\" /><input type=\"hidden\" name=\"tid[]\" value=\"".$ship_tid."\" /></td>";
				if(in_array($delete,$has_permission))
				{
					
					$url2=getFullURL($_GET['r'],'request_delete.php','N');
					$url2 = $url2."&tid=$ref_no&&complaint_no=$complaint_no&sdate=$startdate&edate=$enddate&stat=$status&bat=$batch";
					echo "<td><a id='delete_btn' class=\"btn btn-sm btn-danger confirm-submit\" href=\"$url2\" >Delete</a></td>";
				}
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div></div>";
	}
	else
	{
		$flag=false;
	}
	if(!$flag){
		echo "<script>sweetAlert('No Data Found','','warning');
		$('#main_div').hide()</script>";
	}
}



?>
<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_1: "select",
	col_3: "select",
	col_4: "select",
	col_7: "select",
	col_21: "select",
	col_27: "select",
	sort_select: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
</script> 
</div>
</div>
</body>