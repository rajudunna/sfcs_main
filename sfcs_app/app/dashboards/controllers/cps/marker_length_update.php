<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

if (isset($_GET['plant_code']))
{
	$marker_version = $_GET['marker_version'];
	$username = $_GET['username'];
	$plantCode = $_GET['plant_code'];
	$doc_no = $_GET['doc_no'];
	$updateMarker_Query = "update $pps.jm_dockets set marker_version_id='".$marker_version."',updated_user='".$username."',updated_at=Now() where plant_code='".$plantCode."' and jm_docket_id= '".$doc_no."' and is_active=1";
	$udpatedQueryResult = mysqli_query($link_new,$updateMarker_Query) or exit('Problem in updating in marker');
	if(mysqli_affected_rows($link_new)>0){
	    $result_array['status'] = 1;
	} else {
	    $result_array['status'] = 2;
	}
	echo json_encode($result_array);
}

?>