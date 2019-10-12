
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
                    // $compo_no = $sql_row1['compo_no'];
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
				$barcode_qry="SELECT doc_no,size, barcode,quantity FROM $bai_pro3.emb_bundles where doc_no=".$doc_no."";
				
				// echo $barcode_qry;
				// die();
                    // echo $barcode_qry;		
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
                    
			$html.=   '<div>
						    <table>
							     <tr rowspan=2>
								 <td colspan=13><b>Stab Here:</b></td>
								 <td colspan=3>
								 <svg height="20" width="20">
								 <circle cx="10" cy="10" r="8"  />
								 </svg>
								 </td>
								 <td colspan=5 style="border: 4px solid black;width:50px; height:40px; text-align:center;"><p style= "font-size: 15px;"><b>'.$seq_num.'</b></p></td>
							     </tr>	
                                 <tr><td colspan=3><b>Style:</b></td><td colspan=7>'.$style.'</td>
                                 <td colspan=1><b>Size:</b></td><td colspan=4>'.$size.'</td>
								 </tr>';
					
                        $html.= '<tr><td colspan=3><b>schedule:</b></td><td colspan=7>'.$schedule.'</td>
                                <td colspan=1><b>Doc_no:</b></td><td colspan=1>'.$doc_no.'</td>
						         </tr>';
				
						
					    $html.= '<tr><td colspan=3><b>BarcodeID:</b></td><td colspan=7>'.$barcode.'</td>
							    <td colspan=1><b>CutNo:</b></td><td colspan=5>'.$cut_no.'</td>
							    </tr>
							    <tr>
							    <td colspan=1><b>Color:</b></td><td colspan=15>'.substr($color,0,35).'</td>
							    </tr>

							    <tr><td colspan=1><b>qty:</b></td><td colspan=3>'.$quantity.'</td></tr>
							</table>
							    <div style="margin-left:60px;"><barcode code="'.$barcode.'" type="C39"/ height="0.80" size="0.8" text="1"></div>
									
						 
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
