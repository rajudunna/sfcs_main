<?php
include("../../config/config.php");
include("../../config/functions.php");
require_once 'vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
if(isset($_GET['doc_no']) && isset($_GET['order_tid'])){		
	//header('Content-Type: application/json');
	$date = date('d/m/Y');
	$doc_no = $_GET['doc_no'];
	$order_tid1 = $_GET['order_tid'];

	//GETTING QUIRES REALTED STYLE AND SCHEDULE
	$doc_details="SELECT order_tid FROM $bai_pro3.plandoc_stat_log WHERE doc_no=".$doc_no;	
	$doc_details_result=mysqli_query($link, $doc_details) or exit("Error at getting Docket details".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($doc_details_result);
	if($sql_num_check > 0){
		$order_tid = mysqli_fetch_row($doc_details_result);		
		$get_doc_details="SELECT order_del_no,order_style_no,order_col_des FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid='".$order_tid[0]."'";	
		$doc_details_result=mysqli_query($link, $get_doc_details) or exit("Error at getting Docket information".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check1=mysqli_num_rows($doc_details_result);
		if($sql_num_check1 >0){
			$result_details = mysqli_fetch_row($doc_details_result);
			$sizes_array_result = array();
			$main_size_array_result = array();
			//$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
			for($i=0;$i<sizeof($sizes_array);$i++){
				$sizes_info="select p_".$sizes_array[$i].",a_plies from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no." and p_".$sizes_array[$i]." > 0";				
				$sizes_info_result=mysqli_query($link, $sizes_info);
				$sizes_info_details = mysqli_fetch_row($sizes_info_result);				
				if($sizes_info_details[0]){
					$sizes_array_result['size_name'] = ims_sizes($order_tid[0],$result_details[0],$result_details[1],$result_details[2],$sizes_array[$i],$link);
					$sizes_array_result['size_ratio'] = $sizes_info_details[0];
					$sizes_array_result['a_plies'] = $sizes_info_details[1];
					//$sizes_array_result['piece_total'] = $sizes_info_details[0] * $sizes_info_details[1];
					array_push($main_size_array_result,$sizes_array_result);
				}			
			}
			//Shade info details..
			$get_shade_details="select shade,sum(plies) as plies from $bai_rm_pj1.fabric_cad_allocation where doc_no=$doc_no group by shade";
			$shade_details_result=mysqli_query($link, $get_shade_details) or exit("Error at getting Shade information".mysqli_error($GLOBALS["___mysqli_ston"]));
			$shade_cnt=mysqli_num_rows($shade_details_result);
			$shade_details = array();
			$main_shade_details = array();
			$shade_total = 0;
			$sizewisepeicecount = 0;
			while ($row = mysqli_fetch_array($shade_details_result)) {
				$shade_details['shade'] = $row['shade'];
				$shade_details['plies'] = $row['plies'];
				$shade_total+= $row['plies'];	
				array_push($main_shade_details,$shade_details);
			}

			//EMB Details
			$get_emb_details="SELECT operation_order,component,tbl_orders_ops_ref.operation_name as name,tbl_suppliers_master.supplier_name as supname FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.tbl_orders_ops_ref ON tbl_style_ops_master.operation_name= tbl_orders_ops_ref.id LEFT JOIN $brandix_bts.tbl_suppliers_master ON tbl_style_ops_master.emb_supplier = tbl_suppliers_master.id WHERE style='".$result_details[1]."' AND color='".$result_details[2]."'  AND emb_supplier>0";
			$emb_details_result=mysqli_query($link, $get_emb_details) or exit("Error at getting EMB information".mysqli_error($GLOBALS["___mysqli_ston"]));
			$emb_cnt=mysqli_num_rows($emb_details_result);
			$emb_details = array();
			$main_emb_details = array();
			while ($row = mysqli_fetch_array($emb_details_result)) {
				$emb_details['supname'] = $row['supname'];
				$emb_details['component'] = $row['component'];
				$emb_details['name'] = $row['name'];
				array_push($main_emb_details,$emb_details);
			}
			 
		}else{
			echo "Docket information is found Please try again!!";
		}
	}else{
		echo "No Dockets found Please try again!!";
	}

	$details="SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid='".$order_tid1."' ORDER BY doc_no";
	$details_result=mysqli_query($link, $details) or exit("Error at getting Docket details".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check1=mysqli_num_rows($details_result);
	if($sql_num_check1 >0){
		$total =1;
		while($row = mysqli_fetch_array($details_result)){
			if($row['doc_no'] == $doc_no){
				$html = '<html>
						<head>
							<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
							<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
							<style>
								#title{
									text-align:center;
								}
								.docdet{
									font-weight: bold;
								}
								.subheader1{
									float:right;
								}
								.subheader2{
									flost:left;
								}
								.sub table, tr, td{
								    border: 1px solid black;
								}
								}
							</style>
						</head>
						<body>
							<div id="title">NUMBERING SHEET</div><br/>
							<div class="header1">
								<table class="table sub">
									<tbody>
									<tr><td>STYLE & DEL</td><td class="docdet">'.trim($result_details[1]).' & '.trim($result_details[0]).'</td><td>PRODUCTION PLANT</td><td class="docdet">'.$plant_name.'</td><td>DATE</td><td class="docdet">'.$date.'</td></tr>
									<tr><td>COLOR</td><td class="docdet">'.$result_details[2].'</td><td>CUT NO</td><td class="docdet">'.$doc_no.'</td></tr>				
									</tbody>
								</table> 
								<table class="table sub">
									<tbody>							
									<tr><td>SIZE</td>';
									foreach ($main_size_array_result as $key => $value) {
										$html.= '<td>'.$value['size_name'].'</td>';
									}
								$html.='</tr>
									<tr><td>RATIO</td>';foreach ($main_size_array_result as $key => $value) {
										$html.= '<td>'.$value['size_ratio'].'</td>';
									}$html.='</tr>							
									</tbody>
								</table> 
							</div>
							<div class="subheader1">
								<table class="table sub">
									<tbody>
										<tr><td>SHADE</td>';
										if($shade_cnt >0){
											foreach ($main_shade_details as $key => $value) {
												$html.= '<td>'.$value['shade'].'</td>';
											}
										}								
										$html.='</tr><tr><td>PLIES</td>';
										if($shade_cnt >0){
											foreach ($main_shade_details as $key => $value) {
												$html.= '<td>'.$value['plies'].'</td>';
											}
										}
										$html.='</tr>								
									</tbody>
								</table> 
							</div>
							<div class="subheader2">
								<table class="table sub">
									<tbody>
										<tr><td>EMB PANEL</td>';foreach ($main_emb_details as $key => $value) {
										$html.= '<td>'.$value['component'].'</td>';
									}
									$html.='</tr>
										<tr><td>GRAPHIC NO</td>';foreach ($main_emb_details as $key => $value) {
										$html.= '<td>'.$value['name'].'</td>';
									}
									$html.='</tr>	
										<tr><td>EMB PLANT</td>';foreach ($main_emb_details as $key => $value) {
										$html.= '<td>'.$value['supname'].'</td>';
									}
									$html.='</tr>												
									</tbody>
								</table>
								<table class="table sub">
									<tbody>								
										<tr><td>SIZE</td>';foreach ($main_size_array_result as $key => $value) {
										$html.= '<td>'.$value['size_name'].'</td>';
									}
									$html.='<td>Total</td></tr>
										<tr><td>QTY</td>';
										$sizewisepeicecount = 0;
										foreach ($main_size_array_result as $key => $value) {
											$html.= '<td>'.$value['size_ratio']*$shade_total.'</td>';
											$sizewisepeicecount += $value['size_ratio']*$shade_total;
										}
									$html.='<td>'.$sizewisepeicecount .'</td></tr>	
									</tbody>
								</table> 
							</div>
							<div class="footer">
								<table class="table sub">
									<tbody>';
									if($shade_cnt >0){
										$html.= '<tr><td>SHADE</td>'; foreach ($main_shade_details as $key => $value) {
											$html.='<td colspan="2"><center>'.$value['shade'].'</center></td></tr>';
										}
										$html.='<tr><td>RATIO</td>';
										foreach ($main_shade_details as $key => $value) {
											$html.='<td>FROM</td><td>TO</td>';
										}		
										$html.='</tr>';					
										foreach ($main_size_array_result as $key => $value) {
											for($i=1;$i<=$value['size_ratio'];$i++){
												$html.='<tr><td>'.$value['size_name'].'-'.$i.'</td>';
												foreach ($main_shade_details as $key => $value1) {
													$to = ($value1['plies']+$total)-1;
													$html.= '<td>'.$total.'</td><td>'.$to.'</td>';
													$total += $value1['plies'];
												}
												$html.='</tr>';
											}
										}
									}else{								
										$html.= '<tr><td>SHADE</td><td colspan="2"><center>#N/A</center></td></tr>
										<tr><td>RATIO</td><td>FROM</td><td>TO</td></tr>';
										foreach ($main_size_array_result as $key => $value) {
											for($i=1;$i<=$value['size_ratio'];$i++){
												$to = ($value['a_plies']+$total)-1;
												$html.= '<tr><td>'.$value['size_name'].'-'.$i.'</td><td>'.$total.'</td><td>'.$to.'</td></tr>';
												$total += $value['a_plies'];
											}
										}
									}
									$html.= '</tbody>
								</table> 
							</div>
						</body>
						<script type="text/javascript" src="../../js/jquery.min1.7.1.js"></script>
						<script type="text/javascript" src="javascript.js"></script>
					</html>';	
				
			$mpdf->WriteHTML($html); 
			$mpdf->Output();

			}else{				
				$from = 1;
				if($shade_cnt >0){
					//$from = 1;						
					foreach ($main_size_array_result as $key => $value) {
						for($i=1;$i<=$value['size_ratio'];$i++){
							foreach ($main_shade_details as $key => $value1) {
								$to = ($value1['plies']+$from)-1;
								$from += $value1['plies'];
							}
						}
					}
					$total = $from;
				}else{								
					//$from = 1;
					foreach ($main_size_array_result as $key => $value) {
						for($i=1;$i<=$value['size_ratio'];$i++){
							$to = ($value['a_plies']+$from)-1;
							$from += $value['a_plies'];
						}
					}
					$total = $from;
				}
			}
		}
	}else{
		echo "Some problem occured while generating PDF.. Please pass Docket No and try again!!";
	}
}else{
	echo "Some problem occured while generating PDF.. Please pass Docket No and try again!!";
}
?>
