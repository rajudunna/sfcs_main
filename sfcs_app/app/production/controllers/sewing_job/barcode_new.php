
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [27, 40], 
		'orientation' => 'L'
	]);

	$input_job=$_GET['input_job'];
	$schedule=$_GET['schedule'];
	?>

	<?php


	$html = '
			<html>
				<head>
				<style>
				body {font-family: arial;
					font-size: 9px;
				}


			
				@page {
				margin-top: 7px;
				margin-left:4px;  
				margin-right:2px;
				margin-bottom:10px; 
				}
					#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt}

				</style>
				<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
				<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>


				</head>
				<body>';

		$barcode_qry="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job."' order by input_job_no*1 ";			
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{	
			$barcode=$barcode_rslt['tid'];
			$color=$barcode_rslt['order_col_des'];
			$style=$barcode_rslt['order_style_no'];
			$cutno=$barcode_rslt['acutno'];
			$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$color."' and order_del_no",$schedule,$link);
			$html.= '<div>
						<table>
							<tr rowspan=2>
								<td colspan=2><b>Stab Here:</b></td>
								<td colspan=2>
									<svg height="25" width="25">
										<circle cx="10" cy="10" r="8"  />
									</svg>
								</td>
							</tr>	
							<tr><td><b>Style:</b></td><td>'.$barcode_rslt['order_style_no'].'</td><td><b>Schedule:</b></td><td>'.$schedule.'</td></tr>
							<tr><td><b>InputJob#:</b></td><td>J'.$input_job.'</td><td><b>Size#:</b></td><td>'.$barcode_rslt['size_code'].'</td></tr>
							<tr><td><b>B#:</b></td><td>'.$barcode.'</td><td><b>Cut#:</b></td><td>'.chr($color_code).leading_zeros($cutno, 3).'</td></tr>
							<tr><td><b>Col#:</b></td><td colspan=3>'.substr($barcode_rslt['order_col_des'],0,25).'</td></tr>
						 </table>
					 </div><br>';
			$operation_det="SELECT tor.operation_name as operation_name,tor.operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style ' AND color='$color' and tsm.barcode='Yes' and tor.operation_code not in (10,15,200)";
			$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];
				$opscode=$ops['operation_code'];
				
				$quantityqry="SELECT carton_act_qty FROM $bai_pro3.`packing_summary_input` WHERE order_del_no='$schedule' AND order_col_des='$color'  AND m3_size_code='$barcode_rslt[size_code]' AND input_job_no='$input_job' AND acutno='$cutno'";
				$sql_result2=mysqli_query($link, $quantityqry) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($qty = mysqli_fetch_array($sql_result2))
				{	
					$quantity=$qty['carton_act_qty'];
				}	
				
				$html.= '<div>
							<table>
								<tr>
									<td colspace="4"><barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="0.80" size="0.8" text="1"></td>
									<td></td>
								</tr>
							</table>
							<table>
								<tr>
									<td><b>Style:</b></td><td>'.$barcode_rslt['order_style_no'].'</td>
									<td><b>Schedule:</b></td><td>'.$schedule.'</td>
								</tr>
								<tr>
									<td colspan=4><b>Input#:</b>J'.$input_job.' &nbsp;&nbsp; <b>Size#:</b> '.trim($barcode_rslt['size_code']).' </td>
								</tr>
								<tr>
									<td colspan=4><b>B#:</b>'.$barcode.' &nbsp;&nbsp; <b>Qty:</b>'.$quantity.'</td>
								</tr>
								<tr>
									<td colspan=4><b>Col#: </b>'.substr($barcode_rslt['order_col_des'],0,25).'</td>
								</tr>
								<tr>	
									<td colspan=4><b>OPS#:</b>'.trim($operations).' &nbsp;&nbsp; <b>Cut#:</b> '.chr($color_code).leading_zeros($cutno, 3).'</td>
								</tr>
								
							</table>
						</div><br><br><br><br><br>';			 
			}
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>