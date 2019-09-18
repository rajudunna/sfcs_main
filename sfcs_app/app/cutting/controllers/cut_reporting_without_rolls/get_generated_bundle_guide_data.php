<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$doc_no=$_POST['doc_no'];
$schedule=$_POST['schedule'];

$getdetails="SELECT * FROM $bai_pro3.docket_number_info where doc_no=".$doc_no;
$getdetailsresult = mysqli_query($link,$getdetails);
if(mysqli_num_rows($getdetailsresult) > 0)
{
    while($row = mysqli_fetch_array($getdetailsresult))
    {
        $response_data[] = $row;
    }
    echo json_encode($response_data);
}
?>