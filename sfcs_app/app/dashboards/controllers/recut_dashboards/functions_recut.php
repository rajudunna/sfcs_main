<?php
if(isset($_GET['recut_id']))
{
	$recut_id = $_GET['recut_id'];
	if($recut_id != '')
	{
		getReCutDetails($recut_id);
	}
}

function getReCutDetails($recut_id)
{
    include("../../../../common/config/config_ajax.php");
    $get_details_qry = "SELECT * FROM `bai_pro3`.`rejection_log_child` WHERE parent_id = $recut_id";
    echo $get_details_qry;
    $result_get_details_qry = $link->query($get_details_qry);
    while($row = $result_get_details_qry->fetch_assoc()) 
    {
        var_dump($row);
    }
}
?>