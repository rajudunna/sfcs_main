<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); 	
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 	
	$plant_code = $_SESSION['plantCode'];
    $username =  $_SESSION['userName'];	

	$list=$_POST['listOfItems'];
	
	/** Function to send */
	$planned_respo=updatePlanDocketJobs($list,$jobtype,$plant_code);
	if($planned_respo=1){
		   $url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/cut_table_dashboard/cut_table_dashboard_cutting.php',3,'N');
   echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";
	}else{
		echo "<script>swal('Error in Planning','Please Verify dockets Once','danger');</script>";
	}
	
	

?>