<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
if (isset($_GET['plant_code']))
{
    $plant_code=$_POST['plant_code'];
    $doc_no=$_POST['doc_no'];
    $marker_version=$_POST['marker_version'];
    $username=$_POST['username'];
    $updateMarker_Query = "update $pps.jm_dockets set marker_version_id='".$marker_version."',udpated_user='".$username."',updated_at=Now() where plant_code='".$plantCode."' and jm_docket_id= '".$doc_no."' and is_active=1";
    echo $updateMarker_Query."<br>";
    // $udpatedQueryResult = mysqli_query($link_new,$updateMarker_Query) or exit('Problem in updating in marker');
    // if(mysqli_affected_rows($udpatedQueryResult)>0){
    //     $result_array['status'] = 1;
    // } else {
    //     $result_array['status'] = 2;
    // }
    echo json_encode($result_array);
}
?>
