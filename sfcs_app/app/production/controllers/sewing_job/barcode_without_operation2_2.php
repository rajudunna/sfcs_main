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

		$barcode_qry="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job."' order by doc_no*1,barcode_sequence*1";			
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{				
			//$barcode=$barcode_rslt['tid'];
			$barcode=leading_zeros($barcode_rslt['tid'],4);
			$color=$barcode_rslt['order_col_des'];
			$style=$barcode_rslt['order_style_no'];
			$cutno=$barcode_rslt['acutno'];
			$quantity=$barcode_rslt['carton_act_qty'];
			$size=$barcode_rslt['size_code'];
			$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$color."' and order_del_no",$schedule,$link);
			$seq_num=$barcode_rslt['barcode_sequence'];
			$shade = strtoupper($barcode_rslt['shade_group']);

            $get_destination="select TRIM(destination) as destinations from bai_pro3.bai_orders_db where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."' ";
			
			$destination_result=mysqli_query($link, $get_destination)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($dest_row = mysqli_fetch_array($destination_result))
            {
            	$destination=$dest_row['destinations'];
            }
			
            
			//$display1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
			$display1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$input_job,$sewing_job_random_id,$link);
			$html.= '<div>
			<table width="98%" style="font-size:4px;">
				<tr>	
					<td colspan=7>'.str_replace(' ','',$barcode_rslt['order_style_no']).'/'.$schedule.'</td>
					<td rowspan="0" style="border: 1px solid black;	border-top-right-radius: 1px 1px; font-size:4px; text-align:center;width:10%">
								    <p style= "font-size: 4px;font-weight: bold;">'.$seq_num.'</p>
							</td>
					
				</tr>
				<tr>
					<td colspan=8>'.substr($barcode_rslt['order_col_des'],0,25).'</td>
				</tr>
				<tr>
					<td colspan=8>
						<div>
							<barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="0.80" size="0.8" text="1">
						</div><br/>
					<center style="font-size:6px;">'.trim($barcode).'</b></td>
				</tr>
				<tr>
					<td colspan=8>'.trim($barcode_rslt['size_code']).'/'.trim($destination).'</td>';

		if($shade != '')
		        $html.= "/<b>$shade</b></td>";		
		else
			$html.= "</td>";	
		$html.='</tr> 
			<tr>	
			<td colspan=8><b></b>'.chr($color_code).leading_zeros($cutno,3).'/'.$display1.'/'.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
					
			</tr>

			</table>
		</div><br>';
		
			$seq_num++;
			//reset sequence number by size and color
			$size_temp=$size;
			$color_temp=$color;
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
