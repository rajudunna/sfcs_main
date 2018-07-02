<?php
$has_permission=haspermission($_GET['r']);

$reject_roll_qty_sum=0;
$reject_len_qty_sum=0;
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>Previous Claims</div>";
echo "<div class='panel-body'>";
$countqry="select count(*) as cnt from $bai_rm_pj1.inspection_complaint_db where reject_batch_no = \"".$batch_no."\" OR reject_inv_no=\"".$batch_no."\"";
$count=mysqli_query($link, $countqry) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1=mysqli_fetch_array($count))
{
	$count_res=$row1["cnt"];
}

	if($count_res>0)
	{

		echo "<br><br><div class=\"table-responsive\"><div id='spldiv'><table cellspacing=\"0\" class=\"table table-striped jambo_table bulk_action\">";	
		echo "<thead><tr><th bgcolor='#29759C'>Complaint No</th><th bgcolor='#29759C'>Complaint Category</th><th bgcolor='#29759C'>Report No</th><th bgcolor='#29759C'>Product Category</th><th bgcolor='#29759C'>Complaint Type</th><th bgcolor='#29759C'>Request Date</th><th bgcolor='#29759C'>Request User</th><th bgcolor='#29759C'>Supplier Name</th><th bgcolor='#29759C'>Buyer Name</th><th bgcolor='#29759C'>Item Desc</th><th bgcolor='#29759C'>Item Codes</th><th bgcolor='#29759C'>Item Colors</th><th bgcolor='#29759C'>Batch No</th><th bgcolor='#29759C'>Invoice No</th><th bgcolor='#29759C'>PO No</th><th bgcolor='#29759C'>Lot#</th><th bgcolor='#29759C'>Purchase Width</th><th bgcolor='#29759C'>Actual Width</th><th bgcolor='#29759C'>Purchase GSM</th><th bgcolor='#29759C'>Actual GSM</th><th bgcolor='#29759C'>Inspected Qty</th><th bgcolor='#29759C'>Reject Roll Qty</th><th bgcolor='#29759C'>Length Short Qty</th><th bgcolor='#29759C'>Total Replacement Required</th>
		<th bgcolor='#29759C'>UOM</th><th bgcolor='#29759C'>Complaint Remarks</th><th bgcolor='#29759C'>Supplier Approved Date</th>
		<th bgcolor='#29759C'>Replacement Category</th><th bgcolor='#29759C'>Supplier Remarks</th>
		<th bgcolor='#29759C'>Claim Note No</th></th><th bgcolor='#29759C'>New Invoice No</th>
		<th bgcolor='#29759C'>Supplier Replace Approved Qty</th>
		<th bgcolor='#29759C'>Supplier Claim Approved Qty</th>
		<th bgcolor='#29759C'>Credit Note No</th><th bgcolor='#29759C'>Complaint Status</th>";
		// echo "<th bgcolor='#29759C'>Print</th><th bgcolor='#29759C'>Mail Status</th>";
	
		if(in_array($authorized,$has_permission))
		{
			//echo "<th bgcolor='#29759C'>Controls</th>";
		}
	
		echo "</tr></thead>";
		$sql11="select * from $bai_rm_pj1.inspection_complaint_db where reject_batch_no = \"".$batch_no."\" OR reject_inv_no=\"".$batch_no."\"";
		$result11=mysqli_query($link, $sql11) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($row=mysqli_fetch_array($result11))
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
				$reject_roll_qty_sum=$reject_roll_qty_sum+$reject_roll_qty;
				$reject_len_qty=$row["reject_len_qty"];
				$reject_len_qty_sum=$reject_len_qty_sum+$reject_len_qty;
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
						echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "Supplier_Claim_Update_Form.php", "N")."&sno=$complaint_no\">Waiting</a></td>";
					}
					else if($complaint_status == 1)
					{
						echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "Supplier_Claim_Update_Form.php", "N")."&sno=$complaint_no\">Not Agreed</a></td>";
					}
					else if($complaint_status == 2)
					{
						echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "Supplier_Claim_Update_Form.php", "N")."&sno=$complaint_no\">Hold</a></td>";
					}
					else if($complaint_status == 3)
					{
						echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "Supplier_Claim_Update_Form.php", "N")."&sno=$complaint_no\">Agreed</a></td>";
					}
					else
					{
						echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "Supplier_Claim_Update_Form.php", "N")."&sno=$complaint_no\">Not Agreed</a></td>";
					}
					
					//echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "mpdf7/Supplier_Print_PDF.php", "N")."&sno=$complaint_no&status=2\" onclick=\"return popitup('".getFullURL($_GET['r'], "mpdf7/Supplier_Print_PDF.php", "R")."&sno=$complaint_no&status=2')\">Print</a></td>";
				
					if($mail_status == 0)
					{
						//echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "mpdf7/Supplier_Print_PDF.php", "N")."&sno=$complaint_no&status=0\" onclick=\"return popitup('".getFullURL($_GET['r'], "mpdf7/Supplier_Print_PDF.php", "R")."mpdf7/Supplier_Print_PDF.php?sno=$complaint_no&status=0')\">Not Sent</a></td>";
					}
					else
					{
						//echo "<td>Sent</td>";
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
						
						//echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "mpdf7/Supplier_Print_PDF.php", "N")."&sno=$complaint_no&status=2\" onclick=\"return popitup('".getFullURL($_GET['r'], "mpdf7/Supplier_Print_PDF.php", "R")."&sno=$complaint_no&status=2')\">Print</a></td>";
						
						if($mail_status == 0)
						{
							//echo "<td>Not Sent</td>";
						}
						else
						{
							//echo "<td>Sent</td>";
						}
			    }	
				
				if(in_array($authorized,$has_permission))
				{
					
				}
				echo "</tr>";
			}
		echo "</table></div></div>";
	}
	else
	{
		echo " <h5 style='color:red;text-align:center;'>No Data Found..</h5></tr></table></div>";
	}
	echo "</div></div>";

	
?>
