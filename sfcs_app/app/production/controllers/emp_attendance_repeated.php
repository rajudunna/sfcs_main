<?php 

if(isset($_GET['date']) && isset($_GET['shift']))
{
   
    $shift = $_GET['shift'];
    $plantcode = $_GET['plantcode'];
	if($shift != '' && $plantcode != '')
	{		
		getshiftdata($shift,$plantcode);
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
if(isset($_GET['params']))
{
$params = $_GET['params'];
if($params != '')
{
    gettimedate($params);
}
}
function getshiftdata($params1){	
     error_reporting(0);
	
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    $params1 = explode(",",$params1);
    $date=$params1[0];
    $shift=$params1[1];
    $plantcode=$params1[2];
    $get_modules = "SELECT * FROM $pms.`pro_attendance_adjustment` where plant_code='$plantcode' and shift='" .$shift. "' and date='" .$date. "'  and smo!='0' group by module ORDER BY module*1;";
	$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
	$count= mysqli_num_rows($modules_result);
	
    while($module_row=mysqli_fetch_array($modules_result))
    {
        $modules_array[]=$module_row['module'];
      
    }

    $modules = implode("','", $modules_array);
   
    $query="SELECT *,(SELECT workstation_id FROM $pms.workstation WHERE workstation_id =pro_attendance_adjustment.module) as module,(SELECT workstation_description FROM $pms.workstation WHERE workstation_id =pro_attendance_adjustment.module) as workstation_description FROM  $pms.`pro_attendance_adjustment` WHERE id NOT IN (SELECT MIN(id) FROM $pms.pro_attendance_adjustment WHERE shift='" .$shift. "' AND date='" .$date. "' AND  module IN('$modules') GROUP BY module ) AND date='" .$date. "' AND shift='" .$shift. "' AND module IN ('$modules') AND smo !='0' ORDER BY id ASC";



  
// $query="select *,workstation_description from $pms.`pro_attendance_adjustment` left join $pms.workstation on workstation.workstation_id=pro_attendance_adjustment.module where pro_attendance_adjustment.plant_code='$plantcode' AND pro_attendance_adjustment.date='" .$date. "' AND pro_attendance_adjustment.shift='" .$shift. "' AND pro_attendance_adjustment.module IN ('$modules') AND pro_attendance_adjustment.smo !='0'";
   $success_query = mysqli_query($link, $query) or exit("$query" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($success_query);
	if($sql_num_check > 0){
        
		while ($row = $success_query->fetch_assoc()) {
           
            $result_array[] = $row;
		}
		$json_data = json_encode($result_array);
        }
    echo $json_data;


}
function gettimedate($params){	
    error_reporting(0);
   include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
   $params = explode(",",$params);
   $shift=$params[0];
   $plantcode=$params[1];


   $sql_query="select shift_start_time,shift_end_time,break_time from $pms.shifts where shift_id='" .$shift. "' AND plant_code='" .$plantcode. "' ";
   $success_query1 = mysqli_query($link, $sql_query) or exit("third ErrorError-21" . mysqli_error($GLOBALS["___mysqli_ston"]));
   
   $sql_num_check1=mysqli_num_rows($success_query1);
   if($sql_num_check1 > 0){

    while ($row = $success_query1->fetch_assoc()) {
           
        $result_array[] = $row;
    }
    $json_data = json_encode($result_array);
    }
    echo $json_data;
   }
?>
