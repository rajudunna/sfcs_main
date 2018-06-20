<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sewing Orders</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
	include("dbconf.php");
	$has_permission=haspermission($_GET['r']);
	if(isset($_POST['style']) && isset($_POST['schedule']) && isset($_POST['color'])&&isset($_POST['cut_num'])&&isset($_POST['operation_code'])&&isset($_POST['bundles_list'])){
		$style=$_POST['style'];
		$schedule=$_POST['schedule'];
		$color=$_POST['color'];
		$cut_num=$_POST['cut_num'];
		$operation_code=$_POST['operation_code'];
		$bundles_list=$_POST['bundles_list'];
		$operation_ids=$_POST['operation_ids'];
		//$assigned_module=$_POST['module_name'];
		//echo $style,$schedule,$color,$cut_num.$operation_code.$bundles_list.$operation_ids.$assigned_module;
		//echo $assigned_module;exit;
		//print_r($operation_ids);
		// for($op_id_count = 0; $op_id_count < count($operation_ids); $op_id_count++)
		// {
			// $op_ids.=$operation_ids[$op_id_count].",";
		// }
		// $op_ids.=$operation_code;
		//print_r($bundles_list);
		$sewing_ord_qnty_qry='select max(sewing_order) as sewing_order from brandix_bts.bundle_creation_data WHERE TRIM(style)="'.$style.'" AND TRIM(SCHEDULE)="'.$schedule.'" AND TRIM(color)="'.$color.'" and ops_dependency="'.$operation_code.'"';
		$sewing_ord_qnty_res=mysqli_query($link,$sewing_ord_qnty_qry);
		//echo $sewing_ord_qnty_qry."</br>";exit;
		if(mysqli_num_rows($sewing_ord_qnty_res)>0){
			$sewing_order_res=mysqli_fetch_object($sewing_ord_qnty_res);
			$sewing_order=$sewing_order_res->sewing_order+1;
		}else{
			$sewing_order=1;
		}
		//echo $sewing_order;
		for($j = 0; $j < count($bundles_list); $j++)
		{
			$bundle_number=$bundles_list[$j];
			$sewing_qnty_qry='SELECT min(recevied_qty) as qnty FROM brandix_bts.bundle_creation_data WHERE TRIM(style)="'.$style.'" AND TRIM(SCHEDULE)="'.$schedule.'" AND TRIM(color)="'.$color.'" AND cut_number="'.$cut_num.'" AND ops_dependency="'.$operation_code.'" and bundle_number="'.$bundle_number.'"';
			//echo $sewing_qnty_qry."</br>";
			$sewing_qnty_qry_result=mysqli_query($link,$sewing_qnty_qry);
			if(mysqli_num_rows($sewing_qnty_qry_result)>0){
				//get Maximum number of sewing orders					
				$sewing_qnty_res=mysqli_fetch_object($sewing_qnty_qry_result);
				$bundle_quantity=$sewing_qnty_res->qnty;
				$sewing_update_qry="update brandix_bts.bundle_creation_data set sewing_order=$sewing_order,sewing_order_status='Yes',send_qty=$bundle_quantity where bundle_number='".$bundle_number."' and operation_id=$operation_code";
				//$sewing_update_qry="update brandix_bts.bundle_creation_data set sewing_order=$sewing_order,sewing_order_status='Yes',send_qty=$bundle_quantity where bundle_number='".$bundle_number."' and operation_id=$operation_code";
				//echo $sewing_update_qry.";</br>";
				mysqli_query($link,$sewing_update_qry);
				$sewing_status_update_qry="update brandix_bts.bundle_creation_data set sewing_order=$sewing_order,sewing_order_status='Yes',left_over=recevied_qty-$bundle_quantity where bundle_number='".$bundle_number."' and operation_id in(".$operation_ids.")";
				//echo $sewing_status_update_qry.";</br>";
				mysqli_query($link,$sewing_status_update_qry);
				 echo "<div class='alert alert-success'>Sewing orders generated Successfully</div>";
				 header('Location: sewing_orders_form.php?style_id='.$style.'&schedule='.$schedule.'&color='.$color.'&cut_id='.$cut_num.'&operation_code='.$operation_code);
				 
			}
		}
		echo "<style>.bs-example{display:none;}</style>";
		
	}else{
		echo "<div class='alert alert-danger'>Please fill the values</div>";
		echo "<a href='sewing_orders_form.php'>Click here</a>";
		 
	}
?>
	
</body>
</html>