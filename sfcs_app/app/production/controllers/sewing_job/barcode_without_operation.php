
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [50, 101], 
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
					font-size: 12px;
				}


			
				@page {
				margin-top: 10px;
				margin-left:20px;  
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
			
			$quantityqry="SELECT carton_act_qty FROM $bai_pro3.`packing_summary_input` WHERE order_del_no='$schedule' AND order_col_des='$color'  AND m3_size_code='$barcode_rslt[size_code]' AND input_job_no='$input_job' AND acutno='$cutno'";
			$sql_result2=mysqli_query($link, $quantityqry) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($qty = mysqli_fetch_array($sql_result2))
			{	
				$quantity=$qty['carton_act_qty'];
			}	
			$display1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
			$html.= '<div>
						<table>
							<tr rowspan=2>
								<td colspan=10><b>Stab Here:</b></td>
								<td colspan=2>
									<svg height="25" width="25">
										<circle cx="10" cy="10" r="8"  />
									</svg>
								</td>
							</tr>	
							<tr><td><b>Style:</b></td><td>'.$barcode_rslt['order_style_no'].'</td><td><b>Schedule:</b></td><td>'.$schedule.'</td></tr>
							<tr><td><b>Job Number:</b></td><td>'.$display1.'</td><td><b>Size:</b></td><td>'.$barcode_rslt['size_code'].'</td></tr>
							<tr><td><b>Barcode ID:</b></td><td>'.$barcode.'</td><td><b>Cut No:</b></td><td>'.chr($color_code).leading_zeros($cutno, 3).'</td></tr>
							<tr><td><b>Color:</b></td><td colspan=3>'.substr($barcode_rslt['order_col_des'],0,35).'</td></tr>
							<tr><td><b>Qty:</b>'.$quantity.'</td></tr>
							</table>
							<div style="margin-left:60px;"><barcode code="'.$barcode.'" type="C39"/ height="0.80" size="0.8" text="1"></div>
									
						 
					 </div><br>';
			
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>
