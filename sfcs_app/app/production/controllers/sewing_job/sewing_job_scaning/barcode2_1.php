
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
  	$doc_no=$_GET['doc_no'];
	$ids=$_GET['id'];
	$reqseqid=$_GET['repseqid'];
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
					<script type="text/javascript" src="../../../../../common/js/jquery.min.js" ></script>
					<script type="text/javascript" src="../../../../../common/js/table2CSV.js" ></script>
				</head>
				<body>';

				$getdetails1="SELECT order_col_des,order_del_no,color_code,acutno FROM $bai_pro3.order_cat_doc_mk_mix  where doc_no=".$doc_no;
				$getdetailsresult1 = mysqli_query($link,$getdetails1);
                while($sql_row1=mysqli_fetch_array($getdetailsresult1))
                {
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
                    $style= $sql_row['style'];	
                }
				
				$query="";
				if($ids>0)
				{
					$query = "tran_id=".$ids." and ";
				}
				
				
				$update_psl_query = "UPDATE $pps.emb_bundles set print_status=1,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and  doc_no=".$doc_no." and report_seq=".$reqseqid."";  
				$update_result = mysqli_query($link,$update_psl_query) or exit('Query Error');
				
				//$detailed_bundle_sticker=1;
				$check=0;               
                $barcode_qry="SELECT tran_id, doc_no,size, barcode,quantity, ops_code,num_id FROM $pps.emb_bundles where plant_code='$plant_code' and $query doc_no=".$doc_no." and report_seq=".$reqseqid."";
				// echo $barcode_qry;		
				$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($barcode_rslt = mysqli_fetch_array($sql_barcode))
				{				
					$barcode=leading_zeros($barcode_rslt['tid'],4);
					$cutno=$barcode_rslt['acutno'];
					$size=$barcode_rslt['size'];
					$barcode=$barcode_rslt['barcode'];
					$quantity=$barcode_rslt['quantity'];
					$numbid=$barcode_rslt['num_id'];
					$get_ops="SELECT operation_name FROM $brandix_bts.tbl_orders_ops_ref where operation_code=".$barcode_rslt['ops_code']."";
					$get_ops_res=mysqli_query($link, $get_ops) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($get_ops_row = mysqli_fetch_array($get_ops_res))
					{
						$code=trim($get_ops_row['operation_name'])."-".$barcode_rslt['ops_code'];
					}
					if($numbid!='')
					{
						//get shande and bundno from docket_number_info
						$get_det_qry="select bundle_start,bundle_end,shade from $bai_pro3.docket_number_info where id=$numbid";
						$get_det_qry_res=mysqli_query($link, $get_det_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($get_det_row = mysqli_fetch_array($get_det_qry_res))
						{
							$shadedet=$get_det_row['bundle_start']."-".$get_det_row['shade']."-".$get_det_row['bundle_end'];
						}
					}
					
					if((int)$detailed_bundle_sticker == 1 && $check<>$barcode_rslt['tran_id'])
					{
						$check=$barcode_rslt['tran_id'];
						$html.= '<div>
									<table width="100%" style="font-size:9px;">
									
										<tr>
											<td colspan=3><b>Sty#</b>'.$style.'</td>
											<td colspan=9><b>Sch#</b>'.$schedule.'</td>	
											<td ><b>Stab#</b></td>	
											<td rowspan="0" style="border: 1px solid black;	border-top-right-radius: 1px 1px; font-size:4px; text-align:center;width:10%">
											  
											</td>
										</tr>
										<tr>
										<td colspan=15></td>
										</tr>
										<tr>
											<td colspan=3><b>Barcode#</b>'.trim($barcode).'</td>
											<td colspan=5><b>Qty#</b>'.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>
											<td colspan=3><b>Bundle#</b>'.leading_zeros($barcode_rslt['tran_id'],4).'</td>
											
										</tr>
										<tr>
										<td colspan=15></td>
										</tr>
										<tr>
											<td colspan=2><b>Doc No#</b>'.$doc_no.'</td>
											<td colspan=6><b>Size:</b>'.substr($barcode_rslt['size'],0,7).'</td>
											<td colspan=3><b>CutNo:</b>'.$cut_no.'</td>';
								$html.='</tr> 
										<tr>
											<td colspan=12><b>Color:</b>'.substr($color,0,30).'</td>
										</tr>
										<tr>
										<td colspan=15></td>
										</tr>
										<tr>';	
										if($shadedet!='')
										{
											$html.='<td><b>S#</b></td><td colspan=15>'.$shadedet.'</td>';
										}
									$html.=	'</tr>
									</table>
								</div><br><br><br><br><br>';
					}
					
						$html.= '<div>
									<table width="98%" style="font-size:7px;">
									   <tr>	<td colspan=15> '.str_replace(' ','',$style).'/'.$schedule.'/'.$code.'</td>
										  
									</td>							
								   </tr>
								   
									<tr>
										<td colspan=8>'.substr($color,0,25).'</td>						
									</tr>	
								   <tr>
									  <td colspan=8>
												<div>
													<barcode code="'.$barcode.'" type="C39"/ height="1.73" size="0.55" text="1">
												</div>
											<center>'.trim($barcode).'</td>
									</tr>
									<tr>
											<td>'.trim($barcode_rslt['size']).' / '.$doc_no.' / '.$cut_no.' / '.trim(str_pad($quantity,3,"0", STR_PAD_LEFT)).'</td>';
											if($shadedet!='')
											{
											$html.='<td><b>S#</b></td><td colspan=15>'.$shadedet.'</td>';
											}
								
							   $html.='</tr>
									</table>
								</div><br><br><br><br><br>';					
				}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>
