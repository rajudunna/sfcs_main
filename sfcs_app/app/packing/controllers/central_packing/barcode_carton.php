
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
		$filter="";$filter1="";
		if(isset($_GET['seq_no'])>0)
		{
			$filter=" and seq_no='".$_GET['seq_no']."'";
		}
		if(isset($_GET['carton_no'])>0)
		{
			$filter1=" and carton_no in (".$_GET['carton_no'].")";
		}		
		$barcode_qry1="select seq_no,count(distinct carton_no) as cart from $bai_pro3.packing_summary where order_del_no='".$schedule."' $filter group by seq_no order by seq_no*1";
		$sql_barcode1=mysqli_query($link, $barcode_qry1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($barcode_rslt1 = mysqli_fetch_array($sql_barcode1))
		{	
			$tot_cart=$barcode_rslt1['cart'];
			$barcode_qry="SELECT pac_stat_id,carton_no,order_style_no, order_del_no, GROUP_CONCAT(DISTINCT TRIM(order_col_des) SEPARATOR ',') AS colors, GROUP_CONCAT(DISTINCT TRIM(size_tit) SEPARATOR ',') AS sizes, SUM(carton_act_qty) AS carton_qty FROM $bai_pro3.`packing_summary` WHERE order_del_no='".$schedule."' and seq_no='".$barcode_rslt1['seq_no']."' $filter1 group by pac_stat_id";
			$printrslt=mysqli_query($link, $barcode_qry) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rowss=mysqli_fetch_array($printrslt))
			{
				$style=$rowss['order_style_no'];
				$pac_stat_id=$rowss['pac_stat_id'];
				$schedule=$rowss['order_del_no'];
				$color=$rowss['colors'];
				$cartonno=$rowss['carton_no'];
				$size1=$rowss['sizes'];
				$size = rtrim($size1, ',');
				$cartqty=$rowss['carton_qty'];
				$mpocponos="select co_no,vpo,destination,order_date from $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule'";
				$nosrslt=mysqli_query($link, $mpocponos) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($norows=mysqli_fetch_array($nosrslt))
				{
					$cono=$norows['co_no'];
					$vpo=$norows['vpo'];
					$destination=$norows['destination'];
					$ex_fact_date=$norows['order_date'];

				}				
				$html.= '<div>								
					<table>
						<tr>
							<td ><barcode code="'.leading_zeros($pac_stat_id,10).'" type="C39"/ height="0.80" size="0.8" text="1"></td>
							<td >'.leading_zeros($pac_stat_id,10).'</td>
						</tr>
						
						<tr>
							<td style="width:100px;"><b>Style:</b>'.$style.' </td>
							<td> <b>Schedule:</b>'.$schedule.'</td>
						</tr>
						<tr rowspan=3>
							<td colspan=2><b>Color:</b>'.substr($color,0,220).' </td>
						</tr>
						<tr>
							<td colspan=2><b>Size:</b>'.$size.' </td>
						</tr>
						<tr>
							<td><b>Carton No:</b>'.$cartonno.'/'.$tot_cart.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Qty:</b>'.$cartqty.' </td><td> <b>Country :</b>'.$destination.'</td>
						</tr>
						<tr>
							<td><b>Co No:</b>'.$cono.' </td>
							<td><b>VPO:</b>'.$vpo.' </td>
						</tr>
						<tr>
						<td><b>Ex-Factory:</b>'.$ex_fact_date.'</td>
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
