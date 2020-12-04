<?php
$doc_no = $_GET['doc_no'];
 include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

$plantcode=$_SESSION['plantCode'];
//Check whether fabric requested or not
$get_docket_id="SELECT jm_docket_id FROM $pps.jm_dockets WHERE docket_number='".$doc_no."' and plant_code='$plantcode'";
$get_docket_id_result = mysqli_query($link,$get_docket_id); 
while($id_row = mysqli_fetch_array($get_docket_id_result)){
   $jm_docket_id = $id_row['jm_docket_id'];

   $check_fabric_status="SELECT fabric_status FROM $pps.requested_dockets WHERE plant_code='$plantcode' and jm_docket_id='$jm_docket_id'";
   $check_fabric_status_result = mysqli_query($link,$check_fabric_status);
   $sql_num=mysqli_num_rows($check_fabric_status_result);
   if($sql_num > 0)
   {
     $row_fabric = mysqli_fetch_array($check_fabric_status_result);
       $fabric_status=$row_fabric['fabric_status'];
       $response_data['fabric_status']   = $fabric_status;
       echo json_encode($response_data);
       exit();
   }
   else
   {
    $response_data['fabric_status'] = 0;
    echo json_encode($response_data);
    exit();
   } 
}
?>