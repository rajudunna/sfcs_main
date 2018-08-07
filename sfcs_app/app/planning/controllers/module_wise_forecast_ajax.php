<?php
	include('../../../common/config/config_ajax.php');
	
	if (isset($_GET['edit']))
	{
		$fr_id = $_GET['fr_id'];
		$smv = $_GET['smv'];
		$fr_qty = $_GET['fr_qty'];
		$hours = $_GET['hours'];

		$update_fr_details_query = "UPDATE $bai_pro2.fr_data SET smv='$smv', fr_qty='$fr_qty', hours='$hours' WHERE fr_id='$fr_id'";
		$update_fr_details_result = mysqli_query($link, $update_fr_details_query) or exit("Error updating FR data");
		if ($update_fr_details_result == 1 or $update_fr_details_result == '1')
		{
			echo 1 ;
		} else {
			echo 0 ;
		}
	} 
	else if(isset($_GET['delete']))
	{
		$fr_id = $_GET['fr_id'];

		$update_fr_details_query = "DELETE from  $bai_pro2.fr_data  WHERE fr_id='$fr_id'";
		$update_fr_details_result = mysqli_query($link, $update_fr_details_query) or exit("Error deleting FR data");
		if ($update_fr_details_result == 1 or $update_fr_details_result == '1')
		{
			echo 1 ;
		} else {
			echo 0 ;
		}
	}
?>