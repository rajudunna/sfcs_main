
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php ini_set("pcre.backtrack_limit", "5000000"); ?>

<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [25, 50], 
		'orientation' => 'L'
	]);
    $order_tid=$_GET['order_tid'];
	$doc_no=$_GET['doc_no'];
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
    $color=$_GET['color'];
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

				$getdetails1="SELECT order_col_des,order_del_no,color_code,acutno FROM $bai_pro3.order_cat_doc_mk_mix  where doc_no=".$doc_no;
				$getdetailsresult1 = mysqli_query($link,$getdetails1);
                while($sql_row1=mysqli_fetch_array($getdetailsresult1))
                {
                    // $compo_no = $sql_row1['compo_no'];
                    $schedule = $sql_row1['order_del_no'];
                    $color = $sql_row1['order_col_des'];
                    $cut_no= chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);	
                }

				$sql="select DISTINCT order_style_no as style from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
				// echo $sql;
				// die();
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row=mysqli_fetch_array($sql_result))
                {	
                    $style= $sql_row['order_style_no'];	
                }
				$barcode_qry="SELECT doc_no,size, barcode,quantity FROM $bai_pro3.emb_bundles where doc_no=".$doc_no."";
				// echo $barcode_qry;
				// die();
              
                    $sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $seq_num=1;
                    while($barcode_rslt = mysqli_fetch_array($sql_barcode))
                    {				
                        // $barcode=$barcode_rslt['tid'];
                        $barcode=leading_zeros($barcode_rslt['tid'],4);
                        $cutno=$barcode_rslt['acutno'];
                        $size=$barcode_rslt['size'];
                        $barcode=$barcode_rslt['barcode'];
                        $quantity=$barcode_rslt['quantity'];
						// $qty[$barcode_rslt['barcode']] = $barcode_rslt['qty'];
			$display1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$input_job,$sewing_job_random_id,$link);
			//A dummy sticker for each bundle
			//echo $detailed_bundle_sticker.'-';
			if((int)$detailed_bundle_sticker == 1)
			{
				$html.= '<div>
							<table width="100%" style="font-size:8px;">
							
								<tr>
									<td colspan=3><b>Sty#</b>'.$barcode_rslt['order_style_no'].'</td>
									<td colspan=9><b>Sch#</b>'.$schedule.'</td>
									<td rowspan="0" style="border: 1px solid black;	border-top-right-radius: 1px 1px; font-size:4px; text-align:center;width:10%">
								           <p style= "font-size: 6px;font-weight: bold;">'.$seq_num.'</p>
									</td>
								</tr>
								<tr>
								<td colspan=15></td>
								</tr>
								<tr>
									<td colspan=3><b>Barcode#</b>'.$barcode.'</td>
									<td colspan=8><b>Qty#</b>'.$quantity.'</td>
									
								</tr>
								<tr>
								<td colspan=15></td>
								</tr>
								<tr>
									<td colspan=6><b>Size:</b>'.$size.'</td>';
						// if($shade != '')
						// 	$html.= "<td colspan=5><b>Sha#</b>$shade</td>";	
						// else
						// 	$html.= "<td colspan=2></td>";
						$html.='</tr> 
								<tr>
								<td colspan=15></td>
								</tr>
								<tr>
									<td colspan=12><b>Color:</b>'.substr($barcode_rslt['order_col_des'],0,30).'</td>
								</tr>
								<tr>
								<td colspan=15></td>
								</tr>
								<tr>	
									<td colspan=3><b>CutNo:</b>'.chr($color_code).leading_zeros($cutno, 3).'</td>
									<td colspan=8><b>Country:</b>'.trim($destination).'</td>
								</tr>
							</table>
						</div><br><br><br><br><br>';
			}
			//Dummy sticker Ends
			$operation_det="SELECT tor.operation_name as operation_name,tor.operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style ' AND color='$color' and tsm.barcode='Yes' and  tor.category in ('Send PF','Receive PF	') AND tor.display_operations='yes' ORDER BY operation_order*1";
			echo $operation_det;
			die();
			$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];
				$opscode=$ops['operation_code'];
				//$display1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job,$link);
				
				$html.= '<div>
							<table width="98%" style="font-size:7px;">
							   <tr>	
							      <td colspan=8> '.str_replace(' ','',$barcode_rslt['order_style_no']).'/'.$schedule.'/'.substr(str_replace(' ','',$operations),0,18).' - '.$opscode.'</td>
							      <td rowspan="0" style="border: 1px solid black;	border-top-right-radius: 1px 1px; font-size:4px; text-align:center;width:10%">
								           <p style= "font-size: 6px;font-weight: bold;">'.$seq_num.'</p>
							</td>							
						   </tr>
						   
						    <tr>
								<td colspan=8>'.substr($color,0,25).'</td>						
							</tr>	
						   <tr>
							  <td colspan=8>
										<div>
											<barcode code="'.$barcode.'-'.$opscode.'" type="C39"/ height="1.73" size="0.55" text="1">
										</div>
									<center>'.trim($barcode).'</td>
							</tr>
							<tr>
									<td colspan=5>'.trim($barcode_rslt['size_code']).' / '.trim($destination);

						if($shade != '')
							$html.= " / <b>$shade</b></td>";	
						else
							$html.= "</td>";	
						$html.='  
							
						<td colspan=5>'.chr($color_code).leading_zeros($cutno,3).' / '.$display1.' / '.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
						
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
