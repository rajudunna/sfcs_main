
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

	$schedule=$_GET['schedule'];


	$html = '
			<html>
				<head>
				<style>
				body {font-family: arial;
					font-size: 12px;
				}


			
				@page {
				margin-top: 5px;
				margin-left:10px;  
				margin-right:2px;
				margin-bottom:1px; 
				}
					#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt}

				</style>
				<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
				<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>


				</head>
				<body>';
		
		if(isset($_GET['seq_no'])>0)
		{
			$barcode_qry="select pac_stat_id from $bai_pro3.packing_summary where order_del_no='".$schedule."' and seq_no='".$_GET['seq_no']."' group by pac_stat_id order by tid*1";
		}
		else
		{
			$barcode_qry="select pac_stat_id from $bai_pro3.packing_summary where order_del_no='".$schedule."' group by pac_stat_id order by tid*1";
		}			
		
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{	
			$tids[]=$barcode_rslt['pac_stat_id'];
		}	
		for($i=0;$i<sizeof($tids);$i++)
		{
			$printdetqry="SELECT carton_no,order_style_no, order_del_no, GROUP_CONCAT(DISTINCT TRIM(order_col_des) SEPARATOR ',') AS colors, GROUP_CONCAT(DISTINCT size_tit SEPARATOR ',') AS sizes, SUM(carton_act_qty) AS carton_qty FROM $bai_pro3.`packing_summary` WHERE pac_stat_id = '".$tids[$i]."' group by pac_stat_id";
			//echo $printdetqry."<br>";
			$printrslt=mysqli_query($link, $printdetqry) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rowss=mysqli_fetch_array($printrslt))
			{
				$style=$rowss['order_style_no'];
				$schedule=$rowss['order_del_no'];
				$color=$rowss['colors'];
				$cartonno=$rowss['carton_no'];
				$size=$rowss['sizes'];
				$cartqty=$rowss['carton_qty'];
				$mpocponos="select co_no,vpo from $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule'";
				$nosrslt=mysqli_query($link, $mpocponos) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($norows=mysqli_fetch_array($nosrslt))
				{
					$cono=$norows['co_no'];
					$vpo=$norows['vpo'];
				}				
				$html.= '<div>
							
									
							<table>
								<tr>
									<td ><barcode code="'.leading_zeros($tids[$i],10).'" type="C39"/ height="0.80" size="0.8" text="1"></td>
									<td >'.leading_zeros($tids[$i],10).'</td>
								</tr>
								
								<tr>
									<td style="width:200px;"><b>Style:</b>'.$style.' </td>
									<td> <b>Schedule:</b>'.$schedule.'</td>
								</tr>
								<tr rowspan=3>
									<td colspan=2><b>Color:</b>'.substr($color,0,80).' </td>
								</tr>
								<tr>
									<td colspan=2><b>Size:</b>'.$size.' </td>
								</tr>
								<tr>
									<td><b>Carton No:</b>'.$cartonno.'/'.sizeof($tids).' </td>
									<td><b>Qty:</b>'.$cartqty.' </td>
								</tr>
								<tr>
									<td><b>Co No:</b>'.$cono.' </td>
									<td><b>VPO:</b>'.$vpo.' </td>
								</tr>
								
							</table>
						</div>';	
						$html.='<pagebreak />';
			}
			
		}
				
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>
