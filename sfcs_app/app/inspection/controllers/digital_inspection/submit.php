<?php 
 include("../../../../common/config/config_ajax.php");
// include("../../../../common/config/functions.php");
    if(isset($_POST['getalldata']))
    {
        $get_reasons="select reject_desc from `bai_rm_pj1`.`reject_reasons` where reject_code='".$_POST['getalldata']."'";
        $details_result=mysqli_query($link,$get_reasons) or exit("get_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));

        while($row1=mysqli_fetch_array($details_result))
        {
            $reject_desc = $row1['reject_desc'];
        }
     
       // echo json_encode($reject_code);
       echo $reject_desc;
    }

?>