
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../../../common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [50, 101], 
		'orientation' => 'L'
	]);

	$schedule=$_GET['schedule'];
	$color=$_GET['color'];
	$size=$_GET['size'];
	$job_no=$_GET['job_no'];

	?>

	<?php


	$size1=strtoupper($_GET['size']);

	//echo $style.'<br>'.$schedule.'<br>'.$color.'<br>'.$size.'<br>'.$job_no.'<br>'.$tid.'<br>'.$doc;

	$mpocponos="select co_no,vpo,destination,order_date from $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule'";
	$nosrslt=mysqli_query($link, $mpocponos) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($norows=mysqli_fetch_array($nosrslt))
	{
		$cono=$norows['co_no'];
		$vpo=$norows['vpo'];
		$destination=$norows['destination'];
		$ex_fact_date=$norows['order_date'];

	}

	$sql="SELECT * FROM $bai_pro3.pac_stat_log where schedule='$schedule' AND color='$color' AND size_code='$size' AND input_job_number='$job_no'";
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$tot_cart=mysqli_num_rows($sql_result);
	$html = '
			<html>
			<head>
			<style>
			body {font-family: arial;
				font-size: 12px;
			}
			@page {
			margin-top: 5px;
			margin-left:10px;  
			margin-right:2px;
			margin-bottom:1px; 
			}
				#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt}

			</style>
			<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
			<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>


			</head>
			<body>';

	while($rows=mysqli_fetch_array($sql_result)){
			$tid=$rows['tid'];
			$doc=$tid;
			$st=$rows['style'];
			$modu=$rows['module'];
			$input_job_random=$rows['input_job_random'];
			$cartonno=$rows['carton_no'];
			$ss="SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$input_job_random'";
					//echo $ss;
					$ss_result=mysqli_query($link,$ss) or exit("Sql Error3 $ss".mysqli_error($GLOBALS["___mysqli_ston"]));
	                $rs=mysqli_fetch_array($ss_result);
	
	                $ss1="SELECT ims_mod_no FROM $bai_pro3.ims_log WHERE input_job_rand_no_ref='$input_job_random'";
					//echo $ss1;
					$ss1_result=mysqli_query($link,$ss1) or exit("Sql Error4 $ss1".mysqli_error($GLOBALS["___mysqli_ston"]));
	                $rs1=mysqli_fetch_array($ss1_result);
					//die();
					$ss11="SELECT ims_mod_no FROM $bai_pro3.ims_log_backup WHERE input_job_rand_no_ref='$random_job'";
	                $ss1_result1=mysqli_query($link,$ss11) or exit("Sql Error4 $ss11".mysqli_error($GLOBALS["___mysqli_ston"]));
	                $rs11=mysqli_fetch_array($ss1_result1);
                    if($rs){
						$module=$rs['input_module'];
						}else if(!$rs && $rs1){
						$module=$rs1['ims_mod_no'];
						}else if(!$rs1 && !$rs && $rs11){
						$module=$rs11['ims_mod_no'];
						}else if(!$rs && !$rs1 && !$rs11){
						$module='Not Processed';
						}

			$sql="SELECT title_size_".$size." as size,order_date FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no=\"$schedule\" AND order_col_des=\"$color\"";
			// echo $sql;
			$sql_result1=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($title_size = mysqli_fetch_array($sql_result1))
			{	
				// echo "size".$title_size["size"];
				$title_size_ref=$title_size["size"];
				$order_date=$title_size["order_date"];
			}	
			// <td><b>Module No:</b>'.$module.'</td>

			$html.= '<div>
					<table>
					<tr>
						<td><barcode code="'.$doc.'" type="C39"/ height="0.80" size="0.8" text="1"></td>
						<td>'.leading_zeros($doc,10).'</td>
					</tr>
					<tr>
						 <td><b>Style : </b>'.$st.'</td>
						 <td><b>Schedule : </b>'.$schedule.'</td>
					</tr>
					<tr>
						<td><b>Color: </b>'.$color.'</td>
					</tr>
					<tr>
						<td><b>Size : </b>'.strtoupper($title_size_ref).'</td>
						<td><b>Module no : </b>'.$module.'</td>
					</tr>
					<tr>
						<td><b>Carton No:</b>'.$cartonno.'/'.$tot_cart.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Qty:</b>'.$rows['carton_act_qty'].' </td><td> <b>Country :</b>'.$destination.'</td>	 
					
					</tr>
					<tr>
							<td><b>Co No:</b>'.$cono.' </td>
							<td><b>VPO:</b>'.$vpo.' </td>
					</tr>
					<tr>
						<td><b>Job Number : </b>J0'.$job_no.'</td>
						<td><b>Ex-Factory : </b>'.$ex_fact_date.'</td>
					</tr>
					<tr>
					 </tr>
				
				 </table>					 
				 </div>';
			$html.='<pagebreak />';
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>