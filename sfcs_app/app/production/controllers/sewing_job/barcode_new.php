
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

	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$color=$_GET['color'];
	$cutno=$_GET['cutno'];
	
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


		$operation_det="select operation_name from $brandix_bts.tbl_style_ops_master where style='$style' AND color='$color'";
		$sql_result1=mysqli_query($link, $operation_det) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($ops = mysqli_fetch_array($sql_result1))
			{	
				$operations=$ops['operation_name'];

				$html.= '<div>
				 <table><tr><td>Style:</td><td>'.$style.'</td><td>Schedule:</td><td>'.$schedule.'</td></tr>
				 <tr><td>Cut No:</td><td>'.$cutno.'</td><td>Operation:</td><td>'.$operations.'</td></tr>
				 <tr><td>Color:</td><td>'.$color.'</td></tr>
				 
				 </table>					 
				 </div>';
			}	


	$html.='
				</body>
			</html>';

	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>