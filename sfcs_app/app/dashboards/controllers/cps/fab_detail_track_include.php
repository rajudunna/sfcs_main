<?php
//Date 2012-06-01
//For getting recut and normal docket fabric issue track details
//Created function In this page with detDetails name and call this function in index_temp.php
	function getDetails($cat,$docket)
	{
		include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
		// include('..'.getFullURL($_GET['r'],'dbconf.php','R'));
		$total_issue_qty=0;		
		echo "<table class='table tabel-bordered'>";
		echo "<tr><th>Inv No</th><th>Batch No</th><th>Lotno</th><th>Shade</th><th>Roll No</th><th>Qty Issued</th></tr>";
		
		$sql="select tran_tid,qty_issued from $bai_rm_pj1.store_out where cutno=\"$cat".$docket."\"";
		$result=mysqli_query($link, $sql) or die("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($row=mysqli_fetch_array($result))
		{
			$trans_tid=$row["tran_tid"];
			$sql1="select lot_no,ref2,ref4 from $bai_rm_pj1.store_in where tid=\"".$trans_tid."\" ";
			$result1=mysqli_query($link, $sql1) or die("Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($row1=mysqli_fetch_array($result1))
			{
				$lot_no=$row1["lot_no"];
				$rollno=$row1["ref2"];
				$shade=$row1["ref4"];
			}
			
			$sql12="select batch_no,inv_no from $bai_rm_pj1.sticker_report where lot_no=\"".$lot_no."\" ";
			$result12=mysqli_query($link, $sql12) or die("Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($row12=mysqli_fetch_array($result12))
			{
				$batch_no=$row12["batch_no"];
				$batch_no_ex=explode(" ",$batch_no);
				$batch_no_no=$batch_no_ex[0];
				$inv_no=$row12["inv_no"];		
			}
			
			$qty=$row["qty_issued"];
			$total_issue_qty=$total_issue_qty+$qty;
			echo "<tr><td>$inv_no</td><td>$batch_no_no</td><td>$lot_no</td><td>$shade</td><td>$rollno</td><td>$qty</td></tr>";
		}	
		echo "<tr><td colspan=4></td><th>Total Issued Qty</th><td>$total_issue_qty</td></tr>";
		$total_issue_qty=0;
		echo "</table>";

	}
?>
