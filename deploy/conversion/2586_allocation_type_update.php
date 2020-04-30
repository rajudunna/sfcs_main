<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$sql11="SELECT docket,roll_no FROM `bai_pro3`.`docket_roll_info`";
echo $sql11.'<br/>';
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error11--".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result11)>0){

	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
		$docket=$sql_row11['docket'];
		$roll_no=$sql_row11['roll_no'];
        $sql14="SELECT tran_pin FROM `bai_rm_pj1`.fabric_cad_allocation WHERE doc_no ='$docket' and roll_id='$roll_no' ";
        echo  $sql14.'<br/>';
		$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error14--".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row14=mysqli_fetch_array($sql_result14))
		{   
			$tran_pin=$sql_row14['tran_pin'];
			$sql15="update `bai_pro3`.`docket_roll_info` set `alloc_type` ='Fabric',alloc_type_id=$tran_pin where docket='$docket' and roll_no='$roll_no'";
			echo $sql15."<br>";
			$sql_result15=mysqli_query($link, $sql15) or exit("Sql Error15--".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($sql_result15)
			{
					echo "</br>successfully updated : docket-".$docket." and roll no-".$roll_no."</br>";
			}
			else
			{
				echo "</br>failed to  update : docket-".$docket." and roll no-".$roll_no."</br>";
			}
		}
	}
}
	

?>