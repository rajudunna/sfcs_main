
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
				margin-top: 15px;
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

		$barcode_qry="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job."' order by old_size,barcode_sequence";
		//echo "Qry :".$barcode_qry."</br>";
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		$seq_num=1;
		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{
			$sewing_job_random_id=$barcode_rslt['input_job_no_random'];
			$barcode=$barcode_rslt['tid'];
			$color=$barcode_rslt['order_col_des'];
			$style=$barcode_rslt['order_style_no'];
			$cutno=$barcode_rslt['acutno'];
			$quantity=$barcode_rslt['carton_act_qty'];
			$size=$barcode_rslt['size_code'];

			//if(($size_temp!=$barcode_rslt['size_code']) OR ($color_temp!=$barcode_rslt['order_col_des']))
			if(($size_temp!='') AND ($color_temp!='')){	
				if(($size_temp!=$barcode_rslt['size_code'] ) OR ($color_temp!=$barcode_rslt['order_col_des'])){
					$seq_num=1;
				}
			}


			$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$color."' and order_del_no",$schedule,$link);
			//$display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
			$display = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$input_job,$sewing_job_random_id,$link);
			// $html.= '<div>
						// <table>
							// <tr rowspan=2>
								// <td colspan=10><b>Stab Here:</b></td>
								// <td colspan=2>
									// <svg height="25" width="25">
										// <circle cx="10" cy="10" r="8"  />
									// </svg>
								// </td>
							// </tr>
							// <br><br>
							// <tr><td colspan=4><b>Style:</b>'.$barcode_rslt['order_style_no'].'</td><td><b>Schedule:</b>'.$schedule.'</td></tr>
							// <tr><td colspan=4><b>Job Number:</b>'.$display.'</td><td><b>Size:</b>'.$barcode_rslt['size_code'].'</td></tr>
							// <tr><td colspan=4><b>Barcode ID:</b>'.$barcode.'</td><td><b>Cut No:</b>'.chr($color_code).leading_zeros($cutno, 3).'</td></tr>
							// <tr><td colspan=4><b>Color:</b>'.substr($barcode_rslt['order_col_des'],0,30).'</td></tr>
						 // </table>
					 // </div><br><br><br>';

			$get_destination="select destination from bai_pro3.bai_orders_db where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."' ";
			
			$destination_result=mysqli_query($link, $get_destination)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($dest_row = mysqli_fetch_array($destination_result))
            {
            	$destination=$dest_row['destination'];
            }
			$operation_det="SELECT tor.operation_name as operation_name,tor.operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style ' AND color='$color' and tsm.barcode='Yes' and tor.operation_code not in (10,15,200)";
			$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];
				$opscode=$ops['operation_code'];				
				//$display1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
				$display1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$input_job,$sewing_job_random_id,$link);
				$html.= '<div>
							<!--<div style="margin-left:50px;"><barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="0.80" size="0.8" text="1"></div>-->
							<table width="96%">
								<tr>
									<td colspan=4><div><barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="0.80" size="0.8" text="1"></div>
									</td>
									<td style="border: 4px solid black;
									border-top-right-radius: 30px 12px; font-size:12px; width:60px; height:40px; text-align:center;"> <p style= "font-size: 15px;font-weight: bold;">'.$seq_num.'</p></td>
								</tr>
								<tr>
									<td><b>Barcode ID:</b>'.$barcode.' </td>
									<td> <b>Qty:</b>'.$quantity.'</td>
									<td colspan=3> <b>Country: </b>'.$destination.'</td>
								</tr>
								<tr>
									<td><b>Style:</b>'.$barcode_rslt['order_style_no'].'</td>
									<td colspan=4><b>Schedule:</b>'.$schedule.'</td>
								</tr>
								<tr>
									<td><b>Job Number:</b>'.$display1.' </td>
									<td> <b>Size:</b> '.trim($barcode_rslt['size_code']).' </td>
								</tr> 
								<tr>
									<td colspan=5><b>Color: </b>'.substr($barcode_rslt['order_col_des'],0,25).'</td>
									
								</tr>
								<tr>	
									<td><b>Operation:</b>'.trim($operations).' </td>
									<td> <b>Cut No:</b> '.chr($color_code).leading_zeros($cutno, 3).'</td>
								</tr>
							</table>
						</div><br><br><br><br><br>';			 
			}
			$seq_num++;
			//reset sequence number by size and color
			$size_temp=$size;
			$color_temp=$color;
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>
