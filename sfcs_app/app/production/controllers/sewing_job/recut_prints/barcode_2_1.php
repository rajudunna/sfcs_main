
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

	$id=$_GET['recut_id'];
	$sticker_type=$_GET['sticker_type'];
	$sequence=$_GET['sequence'];
	
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
		$get_bundles="select bcd_id,issued_qty from $bai_pro3.recut_v2_child_issue_track where recut_id='".$id."' and status=".$sequence."";
	//	echo $get_bundles."<br>";
		$get_bundles_result=mysqli_query($link, $get_bundles) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($bundle_data = mysqli_fetch_array($get_bundles_result))
		{
			$ids[]=$bundle_data['bcd_id'];
			$ids_qty[$bundle_data['bcd_id']]=$bundle_data['issued_qty'];
		}
		$get_bundles_data="select bundle_number,id from $brandix_bts.bundle_creation_data where id in (".implode(",",$ids).")";
	//	echo $get_bundles_data."<br>";
		$get_bundles_result_data=mysqli_query($link, $get_bundles_data) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($bundle_data_data = mysqli_fetch_array($get_bundles_result_data))
		{
			$bundle_info[]=$bundle_data_data['bundle_number'];
			$bcd_id[$bundle_data_data['bundle_number']]=$bundle_data_data['id'];
		}
		$barcode_qry="select * from $bai_pro3.packing_summary_input where tid in (".implode(",",$bundle_info).") order by tid";
		//echo $barcode_qry."<br>"; 
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{
			$sewing_job_random_id=$barcode_rslt['input_job_no_random'];
			$job_no=$barcode_rslt['input_job_no'];
			$barcode=leading_zeros($barcode_rslt['tid'],4);
			$color=$barcode_rslt['order_col_des'];
			$style=$barcode_rslt['order_style_no'];
			$schedule=$barcode_rslt['order_del_no'];
			$cutno=$barcode_rslt['acutno'];
			$quantity=$ids_qty[$bcd_id[$barcode_rslt['tid']]];
			$type=$barcode_rslt['type_of_sewing'];
			$size=$barcode_rslt['size_code'];
			$seq_num=$barcode_rslt['barcode_sequence'];
			$shade = strtoupper($barcode_rslt['shade_group']);
			$color_code='Recut';
			$get_destination="select destination from $bai_pro3.bai_orders_db where order_style_no='".$style."' and order_del_no='".$schedule."' and order_col_des='".$color."' ";
			$destination_result=mysqli_query($link, $get_destination)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($dest_row = mysqli_fetch_array($destination_result))
            {
            	$destination=$dest_row['destination'];
			}
			$get_prefix="select prefix from $brandix_bts.tbl_sewing_job_prefix where id=".$type."";
			$prefix_result=mysqli_query($link, $get_prefix)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($prefix_row = mysqli_fetch_array($prefix_result))
            {
				$display1 = $prefix_row['prefix'].leading_zeros($job_no,3);
			}
			
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
									<td colspan=6><b>CutNo:</b>'.$color_code.'</td>
								</tr>
							</table>
						</div><br><br><br><br><br>';
			}
			//Dummy sticker Ends
			// With Operation if sticker type is 1
			if($sticker_type==1)
			{
				$operation_det="SELECT tor.operation_name as operation_name,tor.operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style ' AND color='$color' and tsm.barcode='Yes' and tor.category = 'sewing' AND tor.display_operations='yes' ORDER BY tsm.operation_order*1";
				//echo $operation_det."<br>";
				$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($ops = mysqli_fetch_array($sql_result1))
				{	
					$operations=$ops['operation_name'];
					$opscode=$ops['operation_code'];
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
							<barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="1.73" size="0.65" text="1">
							</div><br/>
							<center>'.trim($barcode).'</td>
						</tr>
						<tr>
							<td colspan=8>'.trim($barcode_rslt['size_code']).' / '.trim($destination);
							if($shade != '')
								$html.= " / <b>$shade</b></td>";	
							else
								$html.= "</td>";	
							$html.='</tr> 
						<tr>	
							<td colspan=>'.$color_code.' / '.$display1.' / '.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
						</tr>
					</table>
					</div><br><br><br><br><br>';			 
				}
			}
			else
			{
				$html.= '<div>
					<table width="98%" style="font-size:4px;">
					<tr>	
						<td colspan=6> '.str_replace(' ','',$barcode_rslt['order_style_no']).'/'.$schedule.'</td>
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
						<barcode code="'.$barcode.'" type="C39"/ height="1.73" size="0.65" text="1">
						</div><br/>
						<center>'.trim($barcode).'</td>
					</tr>
					<tr>
						<td colspan=8>'.trim($barcode_rslt['size_code']).' / '.trim($destination);
						if($shade != '')
							$html.= " / <b>$shade</b></td>";	
						else
							$html.= "</td>";	
						$html.='</tr> 
					<tr>	
						<td colspan=>'.$color_code.' / '.$display1.' / '.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
					</tr>
				</table>
				</div><br><br><br><br><br>';
			}
		}
	$html.='</body></html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>

