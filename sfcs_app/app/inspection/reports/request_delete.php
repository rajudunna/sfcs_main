<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R')); 

// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$has_permission=haspermission($_GET['r']);
?>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<script type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=900,width=600,resizable=yes,scrollbars=yes');
	if (window.focus) {newwindow.focus()}
	return false;
}

function refreshAndClose() {
    window.opener.location.reload(true);
    window.close();
}
</script>
</head>
<body>
<div class="panel panel-primary">
<?php
echo '<div class="panel-heading">Supplier Claim Delete Form</div>';
echo '<div class="panel-body">';
?>
<?php

$ref_no=$_GET["tid"];
//kirang/2016-12-14/Added complaint no clause in query to eliminate the multiple records deletion of same ref no.
$complaint_no=$_GET["complaint_no"];
	
	echo "<div class=\"table-responsive\"><table cellspacing=\"0\" id=\"table1\" class=\"table table-striped jambo_table bulk_action\" border=1>";	
	echo "<thead><tr><th>Complaint No</th><th>Complaint Category</th><th>Report No</th><th>Product Category</th><th>Complaint Type</th><th>Request Date</th><th>Request User</th><th>Supplier Name</th><th>Buyer Name</th><th>Item Desc</th><th>Item Codes</th><th>Item Colors</th><th>Batch No</th><th>Invoice No</th><th>PO No</th><th>Lot#</th><th>Purchase Width</th><th>Actual Width</th><th>Purchase GSM</th><th>Actual GSM</th><th>Inspected Qty</th><th>Reject Roll Qty</th><th>Length Short Qty</th><th>Total Replacement Required</th>
<th>UOM</th><th>Complaint Remarks</th><th>Supplier Approved Date</th><th>Replacement Category</th><th>Supplier Remarks</th><th>Claim Note No</th></th><th>New Invoice No</th><th>Supplier Replace Approved Qty</th>
<th>Supplier Claim Approved Qty</th><th>Credit Note No</th><th>Complaint Status</th><th>Mail Status</th>";
	
	if(in_array($authorized,$has_permission))
	{
		echo "<th>Controls</th>";
	}
	
	echo "</tr></thead>";
	
	//kirang/2016-12-14/Added complaint no clause in query to eliminate the multiple records deletion of same ref no.
	$sql="select * from $bai_rm_pj1.inspection_complaint_db where ref_no=\"".$ref_no."\" and complaint_no=\"".$complaint_no."\"";
	// echo $sql;
	$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		echo "<td>$supplier_remarks</td><td>$supplier_claim_no</td><td>$new_invoice_no</td><td>$supplier_replace_approved_qty</td><td>$supplier_claim_approved_qty</td><td>$supplier_claim_no</td>";
		
		if(in_array($authorized,$has_permission))
		{
			if($complaint_status == 0)
			{
				echo "<td><a class=\"btn btn-sm btn-primary\" href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&sno=$complaint_no'>Waiting</a></td>";
			}
			else if($complaint_status == 1)
			{
				echo "<td><a class=\"btn btn-sm btn-primary\" href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&sno=$complaint_no'>Not Agreed</a></td>";
			}
			else if($complaint_status == 2)
			{
				echo "<td><a class=\"btn btn-sm btn-primary\" href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&sno=$complaint_no'>Hold</a></td>";
			}
			else if($complaint_status == 3)
			{
				echo "<td><a class=\"btn btn-sm btn-primary\" href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&sno=$complaint_no'>Agreed</a></td>";
			}
			else
			{
				echo "<td><a class=\"btn btn-sm btn-primary\" href='".getFullURLLevel($_GET['r'],'controllers/Supplier_Claim_Update_Form.php',1,'N')."&sno=$complaint_no'>Not Agreed</a></td>";
			}
			
			
			// echo "<td><a class=\"btn btn-sm btn-primary\" href=\"http://localhost/sfcs/projects/Beta/RM_Projects/BAI_RM_PJ1/mpdf7/Supplier_Print_PDF.php?&sno=\".$complaint_no.\"&status=2\" target=\"_blank\" disabled>Print</a></td>";
		
			if($mail_status == 0)
			{
				echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "Supplier_Print_PDF.php", "N")."&sno=$complaint_no&status=0\" onclick=\"return popitup('Supplier_Print_PDF.php?sno=$complaint_no&status=0')\">Not Sent</a></td>";
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
				
				
				// echo "<td><a class=\"btn btn-sm btn-primary\" href=\"http://localhost/sfcs/projects/Beta/RM_Projects/BAI_RM_PJ1/mpdf7/Supplier_Print_PDF.php?&sno=$complaint_no&status=2\" target=\"_blank\" disabled>Print</a></td>";				
				if($mail_status == 0)
				{
					echo "<td>Not Sent</td>";
				}
				else
				{
					echo "<td>Sent</td>";
				}			
	    }	
		
		// $sHTML_Content .="<td bgcolor=\"$id\"><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "status_update.php", "N")."&tid=$ref_id&&schedule=$schedule\" onclick=\"return popitup('status_update.php?tid=$ref_id&&schedule=$schedule')\">".$x."</a><input type=\"hidden\" name=\"rtid[]\" value=\"".$ref_id."\" /><input type=\"hidden\" name=\"tid[]\" value=\"".$ship_tid."\" /></td>";
		if(in_array($authorized,$has_permission))
		{
			echo "<td><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "request_delete.php", "R")."&tid=$ref_no\"  onclick=\"return popitup('request_delete.php?tid=$ref_no')\">Delete</a></td>";
		}
		echo "</tr>";
	
		//kirang/2016-12-14/Added complaint no clause in query to eliminate the multiple records deletion of same ref no.
		$sql_dump='insert into '.$bai_rm_pj1.'.inspection_complaint_db_delete_log select complaint_no, ref_no, product_categoy, complaint_category, req_date, complaint_raised_by, complaint_remarks, supplier_name, buyer_name, reject_item_codes, reject_item_color, reject_item_desc, reject_batch_no, reject_po_no, reject_inv_no, reject_lot_no, reject_roll_qty, reject_len_qty, uom, supplier_approved_date, supplier_status, supplier_remarks, new_invoice_no, supplier_replace_approved_qty, supplier_credit_no, supplier_claim_no, supplier_claim_approved_qty, complaint_status, mail_status, purchase_width, actual_width, purchase_gsm, actual_gsm, inspected_qty, complaint_cat_ref,"'.$username.'","'.date("Y-m-d H:i:s").'","'.$host_name.'" from '.$bai_rm_pj1.'.inspection_complaint_db where ref_no="'.$ref_no.'" and complaint_no="'.$complaint_no.'"';
		// echo $sql_dump;

		mysqli_query($link, $sql_dump) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//kirang/2016-12-14/Added complaint no clause in query to eliminate the multiple records deletion of same ref no.
		$sql_delete='delete from '.$bai_rm_pj1.'.inspection_complaint_db WHERE ref_no="'.$ref_no.'" and complaint_no="'.$complaint_no.'"';
		//echo $sql_delete."<br>";
		mysqli_query($link, $sql_delete) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		echo "<script>sweetAlert('Deleted successfully','','Info')</script>";

		// $url_back = getFullURLLevel($_GET['r'],'supplier_claim_log_form.php',0,'N');
		// echo "<script>
		// 	setTimeout(redirect(),500);
		// 	function redirect(){
		//         location.href = '$url_back';
		// 	}</script>";
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];
		$stat = $_GET['stat'];
		$bat = $_GET['bat'];
		$url_back = getFullURL($_GET['r'],'Supplier_Claim_Log_Form.php','N');
		$url_back = $url_back."&sdate=$sdate&edate=$edate&stat=$stat&bat=$bat&show=1";
		echo "<script>
				setTimeout(redirect,100);
				function redirect(){
					sweetAlert('Deleted successfully','','success');
			        location.href = '$url_back';
				}
			</script>";
		
	}
	echo "</table></div>";
	
	
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
</html>