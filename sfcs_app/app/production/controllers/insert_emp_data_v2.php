<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));

$date=$_POST['date'];
$shift=$_POST['shift'];
$shift_start_time=$_POST['shift_start_time'];
$shift_end_time=$_POST['shift_end_time'];
$break_hours=$_POST['break_hours'];

  
$sql="select * from $bai_pro.pro_atten_hours where date='$date' and shift='$shift'";
$sql_res=mysqli_query($link, $sql) or exit("Sql Errora $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
$count=mysqli_num_rows($sql_res);
if($count == 0){
	$sql1="insert INTO $bai_pro.pro_atten_hours (date,shift,start_time,end_time) VALUES ('".$date."','".$shift."','".$shift_start_time."','".$shift_end_time."')";
	mysqli_query($link, $sql1) or exit("Sql Errorb $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
}else{
	$sql2="update $bai_pro.pro_atten_hours set start_time='".$shift_start_time."',end_time='".$shift_end_time."' where date='".$date."' and shift='".$shift."' ";
	mysqli_query($link, $sql2) or exit("Sql Errorc $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
}
$modules_array = array();	$modules_id_array=array();
$get_modules = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1;";
$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
while($module_row=mysqli_fetch_array($modules_result))
{
	$modules_array[]=$module_row['module_name'];
	$modules_id_array[$module_row['module_name']]=$module_row['id'];
}

for($i=0;$i<sizeof($modules_array);$i++)
{
	 $pra_id = 'pra'.$modules_id_array[$modules_array[$i]];
	$jumper_id = 'jumper'.$modules_id_array[$modules_array[$i]];
	$adjustment_type = 'adjustment_type'.$modules_id_array[$modules_array[$i]];
	$adjustment_smo = 'adjustment_smo'.$modules_id_array[$modules_array[$i]];
	$working_hours_min = 'working_hours_min'.$modules_id_array[$modules_array[$i]];
	$adjustment_min = 'adjustment_min'.$modules_id_array[$modules_array[$i]];
	$adjustment_hours = 'adjustment_hours'.$modules_id_array[$modules_array[$i]];

	$sqla="Select * from $bai_pro.pro_attendance where date=\"$date\" and module=\"$modules_array[$i]\" and shift='".$shift."'";

	$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sqlresa)==0)
	{
		$sql1="INSERT INTO $bai_pro.pro_attendance (date,module,shift) VALUES ('".$date."','$modules_array[$i]','".$shift."')";
		mysqli_query($link, $sql1) or exit("Sql Errore $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql23="update $bai_pro.pro_attendance set present='".$_POST[$pra_id]."',jumper='".$_POST[$jumper_id]."',break_hours='".$_POST['break_hours']."'  where date='".$date."' and module='$modules_array[$i]' and shift='".$shift."'";
		mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}else{
		$sql22="update $bai_pro.pro_attendance  set present='".$_POST[$pra_id]."',jumper='".$_POST[$jumper_id]."',break_hours='".$_POST['break_hours']."'  where date='".$date."' and module='$modules_array[$i]' and shift='".$shift."'";
		// echo $sql22."</br>";
		mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	
}
if(isset($_POST['data'])) 
  {
	$date1=$_POST['date1'];
	$team=$_POST['team'];
	$module=$_POST['module'];
	$dataArray = json_decode($_POST['data'], true);
	$check_val = "select * from $bai_pro.pro_attendance_adjustment where date=\"$date1\" and shift='".$team."'";
	$check_val_ref = mysqli_query($link, $check_val) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows_id = mysqli_num_rows($check_val_ref);
	if($rows_id>0){
		$delete_child = "Delete from  $bai_pro.`pro_attendance_adjustment` where date='" .$date1. "' and shift='" .$team. "'";
		$roll_inspection_delete = $link->query($delete_child) or exit('query error in deleteing222---2');
		$insert_four_points = "INSERT  INTO $bai_pro.`pro_attendance_adjustment` (`date`,`module`, `shift`, `smo`, `adjustment_type`, `smo_minutes`,`smo_adjustment_min`,`smo_adjustment_hours`) VALUES ";
		foreach ($dataArray as $key => $value) 
		{
			
				
					$insert_four_points .= "('".$date1."','".$value['module']."','".$team."','".$value['adjustment_smo']."','".$value['adjustment_type']."','".$value['working_min']."','".$value['adjustment_min']."','".$value['adjustment_hours']."'),";
				
			
		}
		$insert_four_points = rtrim($insert_four_points, ",");
	 $success_query = mysqli_query($link, $insert_four_points) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
	}else{
	$insert_four_points = "INSERT  INTO $bai_pro.`pro_attendance_adjustment` (`date`,`module`, `shift`, `smo`, `adjustment_type`, `smo_minutes`,`smo_adjustment_min`,`smo_adjustment_hours`) VALUES ";
	foreach ($dataArray as $key => $value) 
	{
		
			
				$insert_four_points .= "('".$date1."','".$value['module']."','".$team."','".$value['adjustment_smo']."','".$value['adjustment_type']."','".$value['working_min']."','".$value['adjustment_min']."','".$value['adjustment_hours']."'),";
			
		
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
	
  }
  echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
  		function Redirect() {
  			sweetAlert('Attandance Details Sucessfully Updated','','success');
  			location.href = \"".getFullURLLevel($_GET['r'], "update_emp_details_v2.php", "0", "N")."\";
  			}
		  </script>";

		 
		 
?>
