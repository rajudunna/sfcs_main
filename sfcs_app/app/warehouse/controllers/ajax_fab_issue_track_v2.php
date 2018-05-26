<?PHP
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
error_reporting(0);


// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$tran_pin=$_GET["s"];
 
		echo "<div class='panel panel-primary'>";
 		echo "<div class='panel-heading'>Fabric Issuing Qty Edition Option</div>";
		echo "<div class='panel-body'>";
	
		$sql1="select tran_pin,doc_no,inv_no,roll_id,doc_type,batch_no,lot_no,ref2 as rollno,ref4 as shade,roll_width,allocated_qty as qty from $bai_rm_pj1.docket_ref where tran_pin=\"$tran_pin\" order by ref4 ";	
		// echo $_GET['r'];
		// $url=getFullURL($_GET['r'],'fab_issue_track_V2.php','R');
		
		echo '<form method="POST" name="form2" action="index.php?r='.$_GET['r'].'">';
	
		echo "<table border=1>";
		//echo "<tr><th>Inv No</th><th>Batch No</th><th>Shade</th><th>Roll ID</th><th>Lable ID</th><th>Roll Width</th><th>Qty Issued</th><th>Time</th></tr>";
		echo "<tr><th>Inv No</th><th>Batch No</th><th>Shade</th><th>Roll ID</th><th>Lable ID</th><th>Issued Qty</th><th>Time</th></tr>";

		$result1=mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($row1=mysqli_fetch_array($result1))
		{
			$tran_pin=$row1["tran_pin"];
			$inv_no=$row1["inv_no"];
			$batch_no=$row1["batch_no"];
			$lot_no=$row1["lot_no"];
			$rollno=$row1["rollno"];
			$roll_id=$row1['roll_id'];
			$roll_width=$row1['roll_width'];
			$shade=$row1["shade"];
			$qty=$row1["qty"];
			$sql="select * from $bai_rm_pj1.store_in where tid='".$roll_id."'";
			$result1=mysqli_query($link, $sql) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row12=mysqli_fetch_array($result1))
			{
				$bal=$row12['qty_rec']+$row12['qty_ret']-($row12['qty_issued']+$row12['partial_appr_qty']);
			}
		
			echo "	<input type='hidden' name='tran_pin' value=\"".$tran_pin."\">
					<input type='hidden' name='doc_no' value=\"".$row1['doc_no']."\">
					<input type='hidden' name='doc_type' value=\"".$row1['doc_type']."\">";
		echo "<tr><td>$inv_no</td>";
		echo "<td>$batch_no</td>";
		echo "<td>$shade</td>"; 
		echo "<td>$rollno</td>"; 
		echo "<td>$roll_id</td>"; 
		//echo "<td>".$roll_width."</td>"; 
		echo "<input type='hidden' name='roll_id' value=\"".$roll_id."\" size='6' class='input'/>";
		//echo "<td><input type='text' name='roll_width' value=\"".$roll_width."\" size='6' class='input'/></td>";
		echo "<input type='hidden' name='qty_issued_chk' id='qty_issued_chk' value=\"".$qty."\" size='6' class='input'>"; 
		echo "<input type='hidden' name='bal_qty' id='bal_qty' value=\"".$bal."\" >"; 
		echo "<td><input type='text' name='qty_issued' id='qty_issued' value=\"".$qty."\" onkeyup=\"validate_qty_2();\" size='6' class='input' onkeypress=\"return numbersOnly(event)\"/></td>"; 
	}
	echo "<td><input type='submit' value='Update' name='update_ajax' id='update' class='btn btn-success btn-xs'></td><tr></table>";
	echo "</form>";
	echo "</div></div>";

?>