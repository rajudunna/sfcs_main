<?PHP
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

$label_id=$_POST["label"];
$sql="select * FROM $bai_rm_pj1.store_in WHERE barcode_number='".$label_id."'";
$result1=mysqli_query($link, $sql);
$sql_rows=mysqli_num_rows($result1);
if($sql_rows>0)
{
	while($row12=mysqli_fetch_array($result1))
	{
		if($row12['allotment_status']==0)
		{				
			$balance=$row12['qty_rec']+$row12['qty_ret']-($row12['qty_issued']+$row12['partial_appr_qty']+$row12['qty_allocated']);
		}
		else
		{
			$balance=0;
		}
		
	}
	echo $balance;
}		
else
{
	echo 'false';
}

?>
