
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [40, 60], 
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
				body {font-family: arial;
					font-size: 12px;
				}


			
				@page {
				margin-top: 7px;
				margin-left:4px;  
				margin-right:2px;
				margin-bottom:10px; 
				}
					#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt}

				</style>
				<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
				<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>


				</head>
				<body>';

		$barcode_qry="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job."' order by input_job_no*1";			
		$sql_barcode=mysqli_query($link, $barcode_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($barcode_rslt = mysqli_fetch_array($sql_barcode))
		{	
			$barcode=$barcode_rslt['tid'];
			$color=$barcode_rslt['order_col_des'];
			$style=$barcode_rslt['order_style_no'];
			$html.= '<div>
			<table>
					 <tr><td></td></tr>	
					 <tr><td>Style:</td><td>'.$barcode_rslt['order_style_no'].'</td><td>Schedule:</td><td>'.$schedule.'</td></tr>
					 <tr><td></td></tr>	
					 <tr><td>input#:</td><td>'.$input_job.'</td><td>Size#</td><td>'.$barcode_rslt['size_code'].'</td></tr>
					 <tr><td></td></tr>	
					 <tr><td>B#:</td><td>'.$barcode.'</td></tr>
					 <tr><td></td></tr>	
				 	 <tr><td>color# </td><td colspan=3>'.$barcode_rslt['order_col_des'].'</td></tr>
					 </table></div><br><br><br><br><br><br>';
			$operation_det="SELECT tor.operation_name as operation_name,tsm.operation_name as operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style ' AND color='$color'";
			$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];
				$opscode=$ops['operation_code'];

				$html.= '<div><table><tr><td colspace="4"><barcode code="'.$barcode.'" type="C39"/ height="0.80" size="1.1"
				 text="1"></td><td></td></tr></table>';
				$html.= '<table><tr><td>Style:</td><td>'.$barcode_rslt['order_style_no'].'</td><td>Schedule:</td><td>'.$schedule.'</td></tr>
					 <tr><td colspan=4>input#:'.$input_job.' Size# '.$barcode_rslt['size_code'].' B#:'.$barcode.'</td></tr>
				 	 <tr><td>color# </td><td colspan=3>'.$barcode_rslt['order_col_des'].'</td></tr>
				 	 <tr><td colspan=4>opsc#:'.$opscode.' ops#:'.$operations.'</td></tr>
					 </table></div><br><br><br><br><br>';			 
			}
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>