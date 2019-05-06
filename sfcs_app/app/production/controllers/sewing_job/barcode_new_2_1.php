
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [25, 50], 
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
						body {
							font-family: arial;
							font-size: 12px;
						}
						table{
							font-size : 12px;
						}
						@page {
							margin-top: 3.5px;
							margin-left:3.50px;  
							margin-right:2px;
							margin-bottom:1.50px; 
						}
						#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt}
					</style>
					<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
					<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>
				</head>
				<body>';

		$barcode_qry="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job."' order by doc_no*1,barcode_sequence*1";

		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	
		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{
			$sewing_job_random_id=$barcode_rslt['input_job_no_random'];
			//$barcode=$barcode_rslt['tid'];
			$barcode=leading_zeros($barcode_rslt['tid'],4);
			$color=$barcode_rslt['order_col_des'];
			$style=$barcode_rslt['order_style_no'];
			$cutno=$barcode_rslt['acutno'];
			$quantity=$barcode_rslt['carton_act_qty'];
			$size=$barcode_rslt['size_code'];
			$seq_num=$barcode_rslt['barcode_sequence'];
			$shade = strtoupper($barcode_rslt['shade_group']);
			

			$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$color."' and order_del_no",$schedule,$link);
			//$display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
			$get_destination="select destination from bai_pro3.bai_orders_db where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."' ";
			$destination_result=mysqli_query($link, $get_destination)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($dest_row = mysqli_fetch_array($destination_result))
            {
            	$destination=$dest_row['destination'];
			}
			$display1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$input_job,$sewing_job_random_id,$link);
			//A dummy sticker for each bundle
			//echo $detailed_bundle_sticker.'-';
			if((int)$detailed_bundle_sticker == 1)
			{
				$html.= '<div>
							<table width="100%" style="font-size:4px;">
								<tr>
									<td colspan=6>
										<div></div>
									</td>
									<td colspan=2 style="border: 4px solid black;	border-top-right-radius: 30px 12px; font-size:12px; width:60px; height:40px; text-align:center;">
										<p style= "font-size: 15px;font-weight: bold;">'.$seq_num.'</p>
									</td>
								</tr>
								<tr>
									<td colspan=2><b></b>'.$barcode_rslt['order_style_no'].'</td>
									<td colspan=2><b>Schedule:</b>'.$schedule.'</td>
								</tr>
								<tr>
									<td colspan=2><b>Color:</b>'.$color.'</td>
								</tr>
								<tr>
									<td colspan=2><b>Barcode ID:</b>'.trim($barcode).'</td>
									<td colspan=2><b>Qty:</b>'.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
									<td colspan=2><b>Country:</b>'.trim($destination).'</td>
								</tr>
								
								<tr>
									<td colspan=2><b>Job Number:</b>'.$display1.'</td>
									<td colspan=2><b>Size:</b>'.trim($barcode_rslt['size_code']).'</td>';
						if($shade != '')
							$html.= "<td colspan=4><b>Shade:</b>$shade</td>";	
						else
							$html.= "<td colspan=4></td>";
						$html.='</tr> 
								<tr>
									<td colspan=9><b>Color:</b>'.substr($barcode_rslt['order_col_des'],0,25).'</td>
								</tr>
								<tr>	
									<td colspan=6><b>CutNo:</b>'.chr($color_code).leading_zeros($cutno, 3).'</td>
								</tr>
							</table>
						</div><br><br><br><br><br>';
			}
			//Dummy sticker Ends
			$operation_det="SELECT tor.operation_name as operation_name,tor.operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style ' AND color='$color' and tsm.barcode='Yes' and tor.operation_code not in (10,15,200) ORDER BY operation_order";
			$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];
				$opscode=$ops['operation_code'];
				//$display1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
				
				$html.= '<div>
							<table width="98%" style="font-size:4px;">
							   <tr>	
							      <td colspan=6> '.str_replace(' ','',$barcode_rslt['order_style_no']).'/'.$schedule.'/'.substr(str_replace(' ','',$operations),0,18).' - '.$opscode.'</td>
							      <td rowspan="0" style="border: 1px solid black;	border-top-right-radius: 1px 1px; font-size:4px; text-align:center;width:10%">
								           <p style= "font-size: 4px;font-weight: bold;">'.$seq_num.'</p>
							</td>							
						   </tr>
						   
						    <tr>
									<td colspan=4>'.$color.'</td>
							</tr>	
						   <tr>
							  <td colspan=8>
										<div>
											<barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="1.50" size="0.65" text="1">
										</div><br/>
									<center style="font-size:6px;">'.trim($barcode).'</td>
							</tr>
							<tr>
									<td colspan=8>'.trim($barcode_rslt['size_code']).' / '.trim($destination);

						if($shade != '')
							$html.= " / <b>$shade</b></td>";	
						else
							$html.= "</td>";	
						$html.='</tr> 
						<tr>	
						<td colspan=><b>'.chr($color_code).leading_zeros($cutno,3).'</b> / '.$display1.' / '.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
						
			           </tr>
							</table>
						</div><br><br><br><br><br>';
				$update_bundle_print_status="UPDATE $bai_pro3.pac_stat_log_input_job SET bundle_print_status='1', bundle_print_time=now() WHERE tid='".$barcode."'";	
				mysqli_query($link, $update_bundle_print_status)  or exit("Error while updatiing bundle print status for bundle: ".$barcode);			 
			}
			$seq_num++;
			//reset sequence number by size and color
			$size_temp=$size;
			$color_temp=$color;
			$cutno_temp=$cutno;
			$update_bundle_print_status="UPDATE $bai_pro3.pac_stat_log_input_job SET bundle_print_status='1', bundle_print_time=now() WHERE tid='".$barcode."'";	
			mysqli_query($link, $update_bundle_print_status)  or exit("Error while updatiing bundle print status for bundle: ".$barcode);
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>
