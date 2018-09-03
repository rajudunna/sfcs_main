
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
    // http:localhost:81/sfcs_app/app/production/reports/ims_barcode.php?input_job=2&quantity=24&module=2&style=A04KHSF8%20%20%20%20%20%20%20&schedule=528859&color=G&size=M
	$input_job=$_GET['input_job'];
	//echo $input_job;
	$schedule=$_GET['schedule'];
	$quantity=$_GET['quantity'];
	$module=$_GET['module'];
	$style=$_GET['style'];
    $color=$_GET['color'];
    $size=$_GET['size'];
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

       

		$barcode_qry="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job."' order by old_size";		
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{				
			$barcode=$barcode_rslt['tid'];
			//$color=$barcode_rslt['order_col_des'];
			//$style=$barcode_rslt['order_style_no'];
			$cutno=$barcode_rslt['acutno'];
			//$quantity=$barcode_rslt['carton_act_qty'];
			$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$color."' and order_del_no",$schedule,$link);
			
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
							<tr><td><b>Style:</b></td><td>'.$style.'</td><td><b>Schedule:</b></td><td>'.$schedule.'</td></tr>
							<tr><td><b>Job Number:</b></td><td>'.$display1.'</td><td><b>Size:</b></td><td>'.$size.'</td></tr>
							<tr><td><b>Barcode ID:</b></td><td>'.$barcode.'</td><td><b>Cut No:</b></td><td>'.chr($color_code).leading_zeros($cutno, 3).'</td></tr>
							<tr><td><b>Color:</b></td><td colspan=3>'.$color.'</td></tr>
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
