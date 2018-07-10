
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [65, 105], 
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

				.new_td
				{
					font-size:18px;
				}

				.new_td2
				{
					font-size:25px;
					font-weight: bold;
				}
				.new_td3
				{
					font-size:18px;
					font-weight: bold;
				}

				table
				{
					margin-left:auto;
					margin-right:auto;
					margin-top:auto;
					margin-bottom:auto;
				}
				@page {
				margin-top: 7px;   
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
			<table><tr><td>Style:</td><td>'.$barcode_rslt['order_style_no'].'</td><td>Schedule:</td><td>'.$schedule.'</td></tr>
					 <tr><td>input#:</td><td>'.$input_job.'</td><td>Size#</td><td>'.$barcode_rslt['size_code'].'</td><td>B#:</td><td>'.$barcode.'</td></tr>
				 	 <tr><td>color# </td><td colspan=3>'.$barcode_rslt['order_col_des'].'</td></tr>
					 </table></div><br><br>';
			$operation_det="select operation_name from $brandix_bts.tbl_style_ops_master where style='$style' AND color='$color'";
			$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];

				$html.= '<div><table><tr><td colspace="4"><barcode code="'.$barcode.'" type="C39"/ height="0.80" size="1.1"
				 text="1"></td><td></td></tr></table>';
				$html.= '<table><tr><td>Style:</td><td>'.$barcode_rslt['order_style_no'].'</td><td>Schedule:</td><td>'.$schedule.'</td></tr>
					 <tr><td>input#:</td><td>'.$input_job.'</td><td>Size#</td><td>'.$barcode_rslt['size_code'].'</td><td>B#:</td><td>'.$barcode.'</td></tr>
				 	 <tr><td>color# </td><td colspan=3>'.$barcode_rslt['order_col_des'].'</td></tr>
					 </table></div>';			 
			}
		}
	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>