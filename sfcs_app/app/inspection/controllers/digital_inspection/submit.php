<?php
include("../../../../common/config/config_ajax.php");
// include("../../../../common/config/functions.php");

if (isset($_POST['getalldata'])) {
    $get_reasons = "select reject_desc from `bai_rm_pj1`.`reject_reasons` where reject_code='" . $_POST['getalldata'] . "'";
    $details_result = mysqli_query($link, $get_reasons) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $reject_desc = '';
    while ($row1 = mysqli_fetch_array($details_result)) {
        $reject_desc = $row1['reject_desc'];
    }


    // echo json_encode($reject_code);
    if ($reject_desc) {
        $responseObject = array(
            'status' => 200,
            'message' => $reject_desc
        );
        echo json_encode($responseObject);
    } else {
        $responseObject = array(
            'status' => 404,
            'message' => "Please Enter Valid Damage Code.....!"
        );
        echo json_encode($responseObject);
    }
}

if (isset($_POST['delete_id'])) {
    $store_id = $_POST['delete_id'];
    
    $delete_roll = "delete from $bai_rm_pj1.inspection_population where store_in_id = ' $store_id'";
    $details_result_fir = mysqli_query($link, $delete_roll) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $delete_roll_inspection = "delete from $bai_rm_pj1.roll_inspection_child where store_in_tid = ' $store_id'";
    $details_result_sec = mysqli_query($link, $delete_roll_inspection) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
   
    $delete_four_points = "delete from $bai_rm_pj1.four_points_table where insp_child_id = ' $store_id'";
    $details_result_third = mysqli_query($link, $delete_four_points) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $update_store_in = "update $bai_rm_pj1.store_in set four_point_status = 0 where tid = '$store_id'";
    mysqli_query($link, $update_store_in) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));

    $reject_desc = "success";
    $responseObject = array(
        'status' => 200,
        'message' => $reject_desc
    );
    echo json_encode($responseObject);
}