
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../../../common/config/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php'; ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php

	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [65, 105], 
		'orientation' => 'L'
	]);

	$schedule=$_GET['schedule'];
	$job_no=$_GET['job_no'];

	//echo $style.'<br>'.$schedule.'<br>'.$color.'<br>'.$size.'<br>'.$job_no.'<br>'.$tid.'<br>'.$doc;

	$query="SELECT * FROM  $bai_pro3.bai_orders_db where order_del_no='$schedule'";
	$query_result=mysqli_query($link, $query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowq=mysqli_fetch_array($query_result);
	$country=$rowq['destination'];

	$sql="SELECT * FROM  $bai_pro3.pac_stat_log where schedule='$schedule' AND input_job_number='$job_no'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

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
					margin:0px;
				}
				@page {
				margin-top: 7px;
				margin-bottom: 2px;
				}
					#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt}

				</style>
				<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
				<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>


				</head>
				<body>';

	while($rows=mysqli_fetch_array($sql_result)){
		$tid=$rows['tid'];
		$doc=$tid;
		$st=$rows['style'];
		$color=$rows['color'];
		$size=$rows['size_code'];
		$module=$rows['module'];

		$sql="SELECT title_size_".$size." as size FROM $bai_pro3.bai_orders_db WHERE order_del_no=\"$schedule\" AND order_col_des=\"$color\"";
		// echo $sql;
		$sql_result1=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($title_size = mysqli_fetch_array($sql_result1))
		{	
			// echo "size".$title_size["size"];
			$title_size_ref=$title_size["size"];
		}

		 $html.= '<br/><br/><div><table><tr><td colspace="4"><barcode code="'.$doc.'" type="C39"/ height="0.80" size="1.1" text="1"></td><td></td></tr></table>
		 
		 <table><tr><td>Style:</td><td>'.$st.'</td><td>Barcode ID:</td><td>'.$doc.'</td></tr>
		 <tr><td>Schedule:</td><td>'.$schedule.'</td><td>Module No:</td><td>'.$module.'</td></tr>
		 <tr><td>Color:</td><td>'.$color.'</td><td>Country:</td><td>'.$country.'</td></tr>
		 <tr><td>Job Number:</td><td>J0'.$job_no.'</td></tr>
		 <tr><td>Size :</td><td>'.strtoupper($title_size_ref).'</td>
		 <td>Quantity</td><td>'.$rows['carton_act_qty'].'</td></tr>
		 </table>					 
		 </div><br/><br/><br/>';
	}
	$html.='
			</body>
		</html>';

$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8', 
	'format' => [65, 110], 
	'orientation' => 'L'
]);
$mpdf->WriteHTML($html);
$mpdf->Output(); 

exit;

?>