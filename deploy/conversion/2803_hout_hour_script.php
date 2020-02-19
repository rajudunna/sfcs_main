<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$sql1="UPDATE bai_pro2.hout SET out_time = CONCAT(out_time,':00') WHERE LENGTH(out_time) = 2";
$sql_result15=mysqli_query($link, $sql1) or exit("Sql Error_hout--".mysqli_error($GLOBALS["___mysqli_ston"]));
if($sql_result15)
{
    //echo $sql1;
    echo "</br>successfully updated  ".mysqli_affected_rows($link)." rows</br>";
}
?>
