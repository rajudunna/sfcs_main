<?php
include("../../../../common/config/config_ajax.php");
// include("../../../../common/config/functions.php");
if(isset($_POST['data'])) 
  {
        $store_in_id=$_POST['store_id'];
        $dataArray = json_decode($_POST['data'], true);

        $check_val = "select insp_child_id from $bai_rm_pj1.four_points_table where insp_child_id='" . $store_in_id . "'";
        $check_val_ref = mysqli_query($link, $check_val) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $rows_id = mysqli_num_rows($check_val_ref);
    
        if($rows_id>0)
        {
            // echo "haii";
            $delete_child = "Delete from  $bai_rm_pj1.four_points_table where insp_child_id='" .$store_in_id. "'";
            $roll_inspection_delete = $link->query($delete_child) or exit('query error in deleteing222---2');
        }

        $ponits_array=array("1"=>"point_1", "2"=>"point_2", "3"=>"point_3", "4"=>"point_4");
        $insert_four_points = "INSERT IGNORE INTO $bai_rm_pj1.`four_points_table` (`insp_child_id`, `code`, `description`, `selected_point`, `points`) VALUES ";
        foreach ($dataArray as $key => $value) 
        {
            foreach ($ponits_array as $point_key => $point_value) 
            {
                if($value[$point_value]>0)
                {
                    $points_val=$point_key*$value[$point_value];
                    $insert_four_points .= "($store_in_id,'".$value['code']."','".$value['desc']."',$point_key,$points_val),";
                }
            }
         }
        $insert_four_points = rtrim($insert_four_points, ",");
        $success_query = mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));

        if ($success_query) 
        {
            $responseObject = array(
                            'status' => 200,
                            'message' => 'success'
                            );
                return json_encode($responseObject);
        } else {
            $responseObject = array(
            'status' => 404,
            'message' => "error"
        );
            return json_encode($responseObject);
        }
    }
if (isset($_POST['getalldata'])) 
{
    $get_reasons = "select * from $mdm.reasons where department_type = '" . $department_reasons['Inspection'] . "' and internal_reason_code = '". $_POST['getalldata']."'";
    // $get_reasons = "select reject_desc from `bai_rm_pj1`.`reject_reasons` where reject_code='" . $_POST['getalldata'] . "'";
    $details_result = mysqli_query($link_v2, $get_reasons) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $reject_desc = '';
    while ($row1 = mysqli_fetch_array($details_result)) {
        $reject_desc = $row1['internal_reason_description'];
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
    
   // $delete_roll = "delete from $bai_rm_pj1.inspection_population where store_in_id = ' $store_id'";
   // $details_result_fir = mysqli_query($link, $delete_roll) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $delete_roll = "UPDATE $bai_rm_pj1.inspection_population set status=0 where store_in_id = '$store_id'";
    $details_result_fir = mysqli_query($link, $delete_roll) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $delete_roll_inspection = "delete from $bai_rm_pj1.roll_inspection_child where store_in_tid = ' $store_id'";
    $details_result_sec = mysqli_query($link, $delete_roll_inspection) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
   
    $delete_four_points = "delete from $bai_rm_pj1.four_points_table where insp_child_id = ' $store_id'";
    $details_result_third = mysqli_query($link, $delete_four_points) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
    
  //  $update_store_in = "update $bai_rm_pj1.store_in set four_point_status = 0 where tid = '$store_id'";
  //  mysqli_query($link, $update_store_in) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));

    $reject_desc = "success";
    $responseObject = array(
        'status' => 200,
        'message' => $reject_desc
    );
    echo json_encode($responseObject);
}

