
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
		
		if(isset($_GET['seq_no']) && isset($_GET['packmethod']))
		{
			$barcode_qry="select tid,doc_no_ref from $bai_pro3.pac_stat_log where schedule='".$schedule."' and pac_seq_no='".$_GET['seq_no']."' and pack_method='".$_GET['packmethod']."' group by doc_no_ref order by tid";
		}
		else
		{
			$barcode_qry="select tid,doc_no_ref from $bai_pro3.pac_stat_log where schedule='".$schedule."' group by doc_no_ref order by tid";
		}			
		
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{	
			$tids[]=$barcode_rslt['tid'];
		}	
		for($i=0;$i<sizeof($tids);$i++)
		{
			$docnoqry="select doc_no_ref from $bai_pro3.pac_stat_log where tid='$tids[$i]'";
			$docnorslt=mysqli_query($link, $docnoqry) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($docrow=mysqli_fetch_array($docnorslt))
			{
				$doc_no_ref=$docrow['doc_no_ref'];
			}
			
			$printdetqry="SELECT carton_no,style, schedule, GROUP_CONCAT(DISTINCT TRIM(color) SEPARATOR ',') AS colors, GROUP_CONCAT(DISTINCT size_tit SEPARATOR ',') AS sizes, SUM(carton_act_qty) AS carton_qty,pack_method FROM bai_pro3.`pac_stat_log` WHERE doc_no_ref = '".$doc_no_ref."' order by size_tit";
			$printrslt=mysqli_query($link, $printdetqry) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($printrslt))
			{
				$style=$row['style'];
				$schedule=$row['schedule'];
				$color=$row['colors'];
				$cartonno=$row['carton_no'];
				$size=$row['sizes'];
				$cartqty=$row['carton_qty'];
				$pack_method=$row['pack_method'];
				
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
									<td colspan=2><center><barcode code="'.$tids[$i].'" type="C39"/ height="0.80" size="0.8" text="1"></center></td>
								</tr>
								<tr>
									<td colspan=2><center>'.$tids[$i].'</center></td>
								</tr>
								<tr>
									<td><b>Style:</b>'.$style.' </td>
									<td> <b>Schedule:</b>'.$schedule.'</td>
								</tr>
								<tr>
									<td colspan=2><b>Color:</b>'.substr($color,0,30).' </td>
								</tr>
								<tr>
									<td><b>Carton No:</b>'.$cartonno.'/'.sizeof($tids).' </td>
									<td><b>Size:</b>'.$size.' </td>
								</tr>
								<tr>
									<td><b>Co No:</b>'.$cono.' </td>
									<td><b>VPO:</b>'.$vpo.' </td>
								</tr>
								<tr>
									<td><b>Pack Method:</b>'.$operation[$pack_method].' </td>
									<td><b>Qty:</b>'.$cartqty.' </td>
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
