<?php
//Date 2012-06-01
//For getting recut and normal docket fabric issue track details
//Created function In this page with detDetails name and call this function in index_temp.php
	function getDetails($cat,$docket)
	{
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
		// include('..'.getFullURL($_GET['r'],'dbconf.php','R'));
		$total_issue_qty=0;		
		echo "<table class='table tabel-bordered'>";
		echo "<tr><th>Inv No</th><th>Batch No</th><th>Lotno</th><th>Shade</th><th>Roll No</th><th>Qty Allocated</th></tr>";
		
		$sql="select * from $bai_rm_pj1.docket_ref where doc_no=$docket";
		$result=mysqli_query($link, $sql) or die("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($row=mysqli_fetch_array($result))
		{
			$inv_no=$row["inv_no"];
			$batch_no_no=$row["batch_no"];
			$lot_no=$row["lot_no"];
			$shade=$row["ref4"];
			$rollno=$row["ref2"];
			$qty=$row["allocated_qty"];
			$total_issue_qty=$total_issue_qty+$qty;
			echo "<tr><td>$inv_no</td><td>$batch_no_no</td><td>$lot_no</td><td>$shade</td><td>$rollno</td><td>$qty</td></tr>";

		}	
		echo "<tr><th colspan=5 style='text-align:right'>Total Issued Qty</th><th style='background-color:white;color:black;'>$total_issue_qty</th></tr>";
		$total_issue_qty=0;
		echo "</table>";

	}
?>
