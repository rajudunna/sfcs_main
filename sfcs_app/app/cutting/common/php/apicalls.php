<?php
//error_reporting(0);
if(isset($_GET['style']) && empty($_GET['schedule']))
{
	$style = $_GET['style'];
	if($style != '')
	{		
		getscheduledata($style);
	}
}

function getscheduledata($style){	
	header('Content-Type: application/json');
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");

	$schedules="SELECT DISTINCT order_del_no FROM  $bai_pro3.bai_orders_db_confirm WHERE order_tid IN (SELECT DISTINCT order_tid FROM bai_pro3.plandoc_stat_log) AND order_style_no ='".$style."'";
	$schedules_result=mysqli_query($link, $schedules) or exit("Error at getting Schedules".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($schedules_result);
	if($sql_num_check > 0){
		$result = array();
		while ($row = mysqli_fetch_array($schedules_result)) {
			$result[$row['order_del_no']] = $row['order_del_no'];
		}
		echo json_encode($result);
	}
}


if(isset($_GET['schedule']) && isset($_GET['style']) && empty($_GET['color']))
{
	$style = $_GET['style'];
	$schedule = $_GET['schedule'];
	if($style != '' && $schedule != '')
	{		
		getcolordata($schedule,$style);
	}
}

function getcolordata($schedule,$style){	
	header('Content-Type: application/json');
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
	
	$colors="SELECT DISTINCT order_col_des FROM  $bai_pro3.bai_orders_db_confirm WHERE order_tid IN (SELECT DISTINCT order_tid FROM $bai_pro3.plandoc_stat_log) AND order_style_no ='".$style."' and order_del_no=".$schedule." group by order_col_des";	
	$colors_result=mysqli_query($link, $colors) or exit("Error at getting colors".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($colors_result);
	if($sql_num_check > 0){
		$result1 = array();
		while ($row = mysqli_fetch_array($colors_result)) {
			$result1[$row['order_col_des']] = $row['order_col_des'];
		}
		echo json_encode($result1);
	}

}

if(isset($_GET['color']))
{
	$style = $_GET['style'];
	$schedule = $_GET['schedule'];
	$color = $_GET['color'];
	if($style != '' && $schedule != '')
	{		
		getmostatus($schedule,$style,$color);
	}
}

function getmostatus($schedule,$style,$color){	
	header('Content-Type: application/json');
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");

	$getordertid="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";	
	$ordertid_result=mysqli_query($link, $getordertid) or exit("Error at getting order tid".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($ordertid_result);
	while($sql_row=mysqli_fetch_array($ordertid_result)){
		$order_tid=$sql_row['order_tid'];
	}
	$mostatus="select mo_status from $bai_pro3.cat_stat_log where order_tid='".$order_tid."'";
	$mostatus_result=mysqli_query($link, $mostatus) or exit("Error at MO Status".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($mostatus_result);
	while($sql_row=mysqli_fetch_array($mostatus_result)){
		$mo_status=$sql_row['mo_status'];
	}
	if($mo_status=="Y"){
		echo json_encode("Yes");
	}
	else{
		echo json_encode("No");
	}

}


if(isset($_POST['submit']))
{
	$style = $_POST['style'];
	$schedule = $_POST['schedule'];
	$color = $_POST['color'];

	header('Content-Type: application/json');
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
	
	if($style != '' && $schedule != '' && $color!= '')
	{
		$result = array();	
		$getordertid="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."'";	
		$ordertid_result=mysqli_query($link, $getordertid) or exit("Error at getting order tid".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($ordertid_result);
		if($sql_num_check >0){
			while($sql_row=mysqli_fetch_array($ordertid_result)){
				$order_tid=$sql_row['order_tid'];
			}
			if($order_tid){
				$plandocdata="SELECT doc_no,p_plies,a_plies,acutno,act_cut_status,act_cut_issue_status FROM $bai_pro3.plandoc_stat_log WHERE order_tid ='".$order_tid."'";	
				$plandocdata_res=mysqli_query($link, $plandocdata) or exit("Error at getting docket no's".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($plandocdata_res);
				if($sql_num_check >0){
					$mainresult = array();
					while($sql_row=mysqli_fetch_array($plandocdata_res)){
						array_push($mainresult, $sql_row);
					}
					echo json_encode($mainresult);
				}else{
					$result = array('error'=>'Error at finding docket nos');
					echo json_encode($result);
				}
				
			}else{
				$result = array('error'=>'Error at finding order tid');
				echo json_encode($result);
			}
		}else{
			$result = array('error'=>'Error at finding order tid');
			echo json_encode($result);
		}
		
		
	}
}

if(isset($_GET['doc_no']))
{
	$doc_no = $_GET['doc_no'];
	if($doc_no != '')
	{		
		getDocInfo($doc_no);
	}
}

function getDocInfo($doc_no){	
	echo json_encode($doc_no);
}


?>