<?php
	// error_reporting(0);
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    //To update onscreen comments update
    $tid=$_GET['tid'];
    $val=$_GET['val'];
    if($val != 'Update Comments')
    {
        $sql="update bai_pro3.ims_log set team_comm='$val' where tid=$tid";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_affected_rows($link)>0)
        {
            echo "0";
        }
    }
    elseif($val == 'Update Comments')
    {
        echo "0";
    }
?>
