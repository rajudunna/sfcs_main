
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../common/php/functions.php'); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/js/mpdf7/vendor/autoload.php'; ?>

<?php
	$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => [65, 105], 
		'orientation' => 'L'

	]);
?>

<?php
	$schedule=$_GET['schedule'];
	$job_no=$_GET['job_no'];
	//echo $style.'<br>'.$schedule.'<br>'.$color.'<br>'.$size.'<br>'.$job_no.'<br>'.$tid.'<br>'.$doc;

	$query="SELECT * FROM $bai_pro3.bai_orders_db where order_del_no='$schedule'";
	$query_result=mysqli_query($link, $query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowq=mysqli_fetch_array($query_result);
	$country=$rowq['destination'];

//$sql="SELECT * FROM pac_stat_log_new where schedule='$schedule' AND input_job_no='$job_no'";

	$sql="SELECT * FROM $bai_pro3.pac_stat_log_new WHERE schedule='$schedule' AND input_job_no='$job_no' ORDER BY
					CASE size_code
					WHEN 'xs' THEN 1
					WHEN 's' THEN 2
					WHEN 'm' THEN 3
					WHEN 'l' THEN 4
					WHEN 'xl' THEN 5
					WHEN 'xxl' THEN 6
					WHEN 'xxxl' THEN 7
					END ASC,carton_act_qty DESC";
					// echo $sql;
					
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$q1="SELECT GROUP_CONCAT(DISTINCT TRIM(order_col_des)  ORDER BY tid SEPARATOR \" + \") AS \"color_title\" FROM packing_summary_input WHERE order_del_no='$schedule'";
	$q1_result=mysqli_query($link, $q1) or exit("Sql Error88 $q1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$q1_row=mysqli_fetch_array($q1_result);
	$col=$q1_row['color_title'];

?>	



<?php

	$html = '
			<html>
				<head>
				<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
				<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>

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
					font-size:22px;
					font-weight: bold;
				}
				.new_td3
				{
					font-size:20px;
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
				</head>
				<body>';
	$j=1;
	while($rows=mysqli_fetch_array($sql_result)){
			$tid=$rows['tid'];
			$doc=$tid;
			$st=$rows['style'];
			$color=$rows['color'];
			$size=$rows['size_code'];
			$qty=$rows['carton_act_qty'];
			$random_job=$rows['input_job_no_random'];
			$size1=strtoupper($size);
			$remarks=$rows['remarks'];
			$style=$rows['style'];
			
			$temp1=array();
			$temp1=explode("*",$remarks);
			$temp2=array();
			$temp2=explode("$",$temp1[0]);
			$packs=$qty/array_sum($temp2);
			$ratio=implode(":",$temp2);
	    	
			$ss="SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$random_job'";
			$ss_result=mysqli_query($link, $ss) or exit("Sql Error88 $ss".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rs=mysqli_fetch_array($ss_result);

			$ss1="SELECT ims_mod_no FROM $bai_pro3.ims_combine WHERE rand_track='$random_job'";
			$ss1_result=mysqli_query($link, $ss1) or exit("Sql Error88 $ss1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rs1=mysqli_fetch_array($ss1_result);
		

			if($rs){
				$mod=$rs['input_module'];
			}else if(!$rs && $rs1){
				$mod=$rs1['ims_mod_no'];
			}else if(!$rs && !$rs1){
				$mod='Not Process';
			}
				  
			$html.= '<div><table>
					  <tr><td colspan=3><barcode code="'.$tid.'" type="C39"/ height="0.80" size="1.1" text="1"></td>
					  <td align="middle">'.$tid.'</td></tr>';
			$html.= '<tr><td>Style:</td><td class="new_td">'.$style.'</td><td>Schedule:</td>
					 <td class="new_td3">'.$schedule.'</td></tr>';
			$html.= '<tr><td colspan=4>Color:  <font size=2><b>'.$col.'</b></font></td></tr>';
			$html.= '<tr><td>Assort:</td><td><font size=2>'.$ratio.'</font></td><td>Module:</td>
			         <td class="new_td3"><b>'.$mod.'</b></td></tr>';
			$html.= '<tr><td>Jobs:</td><td>J00'. $job_no.'</td><td>Size:<span new_td3><b>'.$size1.'</b></span></td>
					 <td>Qty:<span new_td3><b>'.$qty.'</b></span></td></tr>';
			$html.= '<tr><td>Carton:</td><td>#'.$j.'</td>
					 <td><span new_td3><b><span style="font-size:150%;color:black;">***</span></b></span></td></tr>';
			$html.= '</table></div>';
			$j++;
										
		}
	$html.='
				</body>
			</html>
		';
	// echo $html;
	$mpdf->WriteHTML($html); 
	$mpdf->Output();
	exit();

?>