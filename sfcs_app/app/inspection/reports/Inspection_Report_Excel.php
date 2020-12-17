<?php
error_reporting(0);
$file_name = "Fabric_Inspection_Summary_".date("Y-m-d_H_i")."";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$file_name.".csv\"");
$data=stripcslashes($_POST['csv_text']);
echo $data;
?>
</body>

</html>




