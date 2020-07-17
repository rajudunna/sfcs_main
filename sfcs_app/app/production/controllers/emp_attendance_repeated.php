<?php 
if(isset($_GET['date']) && isset($_GET['shift']))
{
   
    $shift = $_GET['shift'];
    $date = $_GET['date'];
	if($shift != '' && $date != '')
	{		
		getshiftdata($shift,$date);
	}
}
if(isset($_GET['params1']))
{
$params1 = $_GET['params1'];
if($params1 != '')
{
    getshiftdata($params1);
}
}
function getshiftdata($params1){	
error_reporting(0);
	//include("../../../../../common/config/config_ajax.php");
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    $params1 = explode(",",$params1);
    $date=$params1[0];
    $shift=$params1[1];
    $query ="select * from $bai_pro.`pro_attendance_adjustment` where date='" .$date. "' and shift='" .$shift. "'";
   // echo $date;
    $success_query = mysqli_query($link, $query) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($success_query);
	if($sql_num_check > 0){
		//$result1 = array();
		while ($row = $success_query->fetch_assoc()) {
            // $result1[$row['shift']] = $row['shift'];
            // $result1[$row['date']] = $row['date'];
            // $result1[$row['module']] = $row['module'];
            // $result1[$row['adjustment_type']] = $row['adjustment_type'];
            // $result1[$row['smo']] = $row['smo'];
            // $result1[$row['smo_minutes']] = $row['smo_minutes'];
            // $result1[$row['smo_adjustment_min']] = $row['smo_adjustment_min'];
            // $result1[$row['smo_adjustment_hours']] = $row['smo_adjustment_hours'];
            $result_array[] = $row;
		}
		$json_data = json_encode($result_array);
    }
    echo $json_data;

}

?>