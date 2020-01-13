
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php ini_set("pcre.backtrack_limit", "5000000"); ?>

<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [50, 101], 
		'orientation' => 'L'
	]);
    $doc_no=$_GET['doc_no'];
	$ids=$_GET['id'];
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
				$getdetails1="SELECT order_col_des,order_del_no,color_code,acutno FROM $bai_pro3.order_cat_doc_mk_mix  where doc_no='$doc_no'";
			    $getdetailsresult1 = mysqli_query($link,$getdetails1);
                while($sql_row1=mysqli_fetch_array($getdetailsresult1))
                {
                    $schedule = $sql_row1['order_del_no'];
                    $color = $sql_row1['order_col_des'];
                    $cut_no= chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);	
                }

				$sql="select order_style_no from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
				// echo $sql1;
				// die();
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row=mysqli_fetch_array($sql_result))
                {	
                    $style= $sql_row['order_style_no'];	
                }
				// $query="";
				// if($ids>0)
				// {
					// $query = "tran_id=".$ids." and ";
				// }
				
				
				// $update_psl_query = "UPDATE $bai_pro3.emb_bundles set print_status=1 where doc_no=".$doc_no."";  
				// $update_result = mysqli_query($link,$update_psl_query) or exit('Query Error');
				
				
				//$detailed_bundle_sticker=1;
				$check=0;
                $barcode_qry="SELECT acb.id as id,docket as doc_no,size, act.barcode as barcode,original_qty as quantity, ops_code,act_cut_bundle_id,shade FROM $bai_pro3.act_cut_bundle_trn act left join $bai_pro3.act_cut_bundle acb on acb.id=act.act_cut_bundle_id where docket=".$doc_no."";
				$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($barcode_rslt = mysqli_fetch_array($sql_barcode))
				{				
					// $barcode=$barcode_rslt['tid'];
					// $barcode=leading_zeros($barcode_rslt['id'],4);
					$cutno=$barcode_rslt['acutno'];
					$acbid=$barcode_rslt['id'];
					$size=$barcode_rslt['size'];
					$barcode=$barcode_rslt['barcode'];
					$quantity=$barcode_rslt['quantity'];
					$shade=$barcode_rslt['shade'];
					// $numbid=$barcode_rslt['num_id'];
					$code='';
					$get_ops="SELECT tor.operation_name,tsm.barcode FROM $brandix_bts.tbl_orders_ops_ref tor left join $brandix_bts.tbl_style_ops_master tsm on tsm.operation_code=tor.operation_code where tor.operation_code=".$barcode_rslt['ops_code']."";
					$get_ops_res=mysqli_query($link, $get_ops) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($get_ops_row = mysqli_fetch_array($get_ops_res))
					{
						$code=$barcode_rslt['ops_code']." / ". $get_ops_row['operation_name'];
						$barstat=$get_ops_row['barcode'];
					}
					
					if($barstat=='Yes')
					{					
						if($shade!='')
						{
							// get shande and bundno from docket_number_info
							$get_det_qry="select start_no,end_no,shade from $bai_pro3.act_cut_bundle where  id=".$acbid."";
							$get_det_qry_res=mysqli_query($link, $get_det_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($get_det_row = mysqli_fetch_array($get_det_qry_res))
							{
								$shadedet=$get_det_row['start_no']."-".$get_det_row['shade']."-".$get_det_row['end_no'];
							}
						}
						
						// if((int)$detailed_bundle_sticker == 1 && $check<>$barcode_rslt['tran_id'])
						// {
							// $check=$barcode_rslt['tran_id'];
							// $html.=   '
							// <table>
								// <tr rowspan=2>
									// <td colspan=17><b>Stab Here:</b></td>
									// <td colspan=3>
										// <svg height="20" width="20">
											// <circle cx="10" cy="10" r="8"  />
										// </svg>
									// </td>
									
								// </tr>
								 // <tr><td colspan=5><b>Style:</b></td><td colspan=7>'.$style.'</td>
								 // <td colspan=1><b>Size:</b></td><td colspan=4>'.$barcode_rslt['size'].'</td>
								 // </tr>';
					
						// $html.= '<tr><td colspan=5><b>Schedule:</b></td><td colspan=7>'.$schedule.'</td>
								// <td colspan=1><b>Doc no:</b></td><td colspan=2>'.$doc_no.'</td>
								
								 // </tr>';
				
						
						// $html.= '<tr><td colspan=5><b>Barcode:</b></td><td colspan=7>'.$barcode.'</td>
								// <td colspan=1><b>CutNo:</b></td><td colspan=4>'.$cut_no.'</td>
								// </tr>
								// <tr>
								// <td colspan=5><b>Color:</b></td><td colspan=15>'.trim($color).'</td>
								// </tr>';
								// if($shadedet!='')
								// {
									// $html.=	'<td colspan=1><b>S#:</b></td><td colspan=15>'.$shadedet.'</td>';
								// }
								// $html.=	'<tr>
								// <td colspan=5><b>Qty:</b></td><td colspan=7>'.leading_zeros($quantity,4).'</td>
								// <td colspan=5><b>Bundle No:</b></td><td colspan=7>'.leading_zeros($barcode_rslt['tran_id'],7).'</td>
								// <tr>
								// <td colspan=1><b></b></td><td colspan=15></td>
								// </tr>
								// <tr>
								// <td colspan=1><b></b></td><td colspan=15></td>
								// </tr>
								// <tr>
								// <td colspan=1><b></b></td><td colspan=15></td>
								// </tr></table>
								// <br>';		
						// }
						
							
						// $qty[$barcode_rslt['barcode']] = $barcode_rslt['qty'];
						$html.=   '<div>
						<div style="margin-left:40px;"><barcode code="'.$barcode.'" type="C39"/ height="0.80" size="0.8" text="1"></div>
						 </div>
							<table>
								
								 <tr><td colspan=5><b>Style:</b></td><td colspan=7>'.$style.'</td>
								 <td colspan=1><b>Size:</b></td><td colspan=4>'.$barcode_rslt['size'].'</td>
								 </tr>';
					
						$html.= '<tr><td colspan=5><b>Schedule:</b></td><td colspan=7>'.$schedule.'</td>
								<td colspan=1><b>Doc no:</b></td><td colspan=2>'.$doc_no.'</td>
								
								 </tr>';
				
						
						$html.= '<tr><td colspan=5><b>Barcode:</b></td><td colspan=7>'.$barcode.'</td>
								<td colspan=1><b>CutNo:</b></td><td colspan=4>'.$cut_no.'</td>
								</tr>
								<tr>
								<td colspan=5><b>Color:</b></td><td colspan=15>'.trim($color).'</td>
								</tr> 
								<tr>
								<td colspan=4><b>Ops/Des:</b></td><td colspan=15>'.$code.'</td>';
							if($shade!='' && $shade!='None')
							{
								$html.=	'<td colspan=1><b>S#</b></td><td colspan=15>'.$shadedet.'</td>';
							}
								
						$html.=	'</tr>
								<tr>
								<td colspan=5><b>Qty:</b></td><td colspan=7>'.leading_zeros($quantity,4).'</td>
								<td colspan=5><b>Bundle No:</b></td><td colspan=7>'.leading_zeros($barcode_rslt['act_cut_bundle_id'],7).'</td>
								
								<tr>
								<td colspan=1><b></b></td><td colspan=15></td>
								</tr>
								<tr>
								<td colspan=1><b></b></td><td colspan=15></td>
								</tr></table>
								<br>';		
					}
				}
			$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>
