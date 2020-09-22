<?php
//Date 2012-06-01
//For getting recut and normal docket fabric issue track details
//Created function In this page with detDetails name and call this function in index_temp.php
	function getDetails($docket,$plant_code)
	{
		
		//include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
		$total_issue_qty=0;				
		echo "<table class='table tabel-bordered'>";
		echo "<tr><th>Inv No</th><th>Batch No</th><th>Lotno</th><th>Shade</th><th>Roll No</th><th>Qty Allocated</th></tr>";
		$doc_ype='normal';
			if($docket!='' && $doc_ype!=''){
				$result_docketinfo=getDocketInfo($docket,$doc_ype,$plant_code);
				$roll_det =$result_docketinfo['roll_det'];
				$leng_det =$result_docketinfo['leng_det'];
				$batch_det =$result_docketinfo['batch_det'];
				$shade_det =$result_docketinfo['shade_det'];
				$location_det =$result_docketinfo['location_det'];
				$invoice_no =$result_docketinfo['invoice_no'];
				$locan_det =$result_docketinfo['locan_det'];
				$lot_det =$result_docketinfo['lot_det'];
				$ctex_len =$result_docketinfo['ctex_len'];
				//$ctex_width =$result_docketinfo['ctex_width'];
				$tkt_width =$result_docketinfo['tkt_width'];
				
			}
			for ($x = 0; $x <= sizeof($roll_det); $x++) {
				echo "<tr><td>$invoice_no[$x]</td><td>$batch_det[$x]</td><td>$lot_det[$x]</td><td>$shade_det[$x]</td><td>$roll_det[$x]</td><td>$leng_det[$x]</td></tr>";
				$total_issue_qty=$total_issue_qty+$ctex_len[$x];
			  }
		echo "<tr><th colspan=5 style='text-align:right'>Total Issued Qty</th><th style='background-color:white;color:black;'>$total_issue_qty</th></tr>";
		$total_issue_qty=0;
		echo "</table>";

	}
?>
