<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<script type="text/javascript" src="../../common/js/tablefilter_1.js"></script>
	<script src="../../../../common/js/jquery1.min.js"></script>
    <script src="/sfcs_app/common/js/jquery-ui.js"></script>
    <script language=\"javascript\" type=\"text/javascript\" src=".getFullURL($_GET['r'],'common/js/dropdowntabs.js',4,'R')."></script>
	<title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
if($_session['plantCode']){

$plantcode = $_session['plantCode'];
}else{
$plantcode = $_GET['plantCode'];

}
if($_session['userName']){

$username =  $_session['userName'];
}else{
$username = $_GET['username'];

}
// error_reporting(E_ALL);
// $plantcode = $_session['plantCode'];
// $plantcode ='AIP';
// $username =  $_session['userName'];
ini_set('max_execution_time', 30000);


function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
	$datetime1 = date_create($date_1);
	$datetime2 = date_create($date_2);
	$interval = date_diff($datetime1, $datetime2);
	return $interval->format($differenceFormat);
}
?>

<html>

<head>
<title>Section Report</title>
<style>
	body{ font-family:calibri; }
</style>

<style>


.blue {
	background: #66DDAA;
}
.white {
	background: white;
}

.atip
{
	color:black;
}


.new td
{
	border: 1px solid #337ab7;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid #337ab7;
	white-space:nowrap;
	border-collapse:collapse;
}







</style>

<script type="text/javascript" src="../../../../common/js/jquery.js"></script> 
<script src="../../../../common/js/jquery.min.js"></script>


</head>

<body>

<?php
$operation=$_GET['operations'];
$department = DepartmentTypeEnum::SEWING;

// $department='SEWING';

$result_worksation_id=getWorkstations($department,$plantcode);
$modules=$result_worksation_id['workstation_codes'];

?>

<?php
echo "<br/><div class='container-fluid'>";

	echo "<div class='panel panel-primary'>";
		echo "<div class='panel-heading'>Sections Summary</div>";
		
            echo "<div class='panel-body'>";
				echo "<div class='table-responsive'>";
				echo "<input id='excel' type='button'  class='btn btn-success' value='Export To Excel' onclick='getCSVData()'>";
				echo "<br/>";
				echo "<br/>";
						echo "<table class=\"table table-bordered\" id=\"table1\"> 
							<tr>
								<th>Module</th>
								<th>Bundle No</th>
								<th>Style</th>
								<th>Schedule</th>
								<th>Color</th>
								<th>Input Job No</th>
								<th>Cut No</th>
								<th>Size</th>
								<th>Previous Operation Quantity</th>
								<th>Current Operation ($operation) Quantity</th>
								<th>Rejected Qty</th>
								<th>Balance</th>
								<th>Remarks</th>
								<th>Age</th>
								<th>WIP</th>
							</tr>";
		$toggle=1;
		$j=1;


		// var_dump($modules);
		foreach($modules as $key => $module)
		{

			$rowcount_check=0;
			$row_counter=0;
			$jobsArray = getJobsForWorkstationIdTypeSewing($plantcode,$key,'');

			foreach($jobsArray as $job){
				$job_detail_attributes = [];
				$qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id='".$job['taskJobId']."' and plant_code='$plantcode' and is_active=1";
				// echo $qry_toget_style_sch."</br>";
				$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
					$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
				}
				
				
				$style = $job_detail_attributes[$sewing_job_attributes['style']];
				$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
				$color = $job_detail_attributes[$sewing_job_attributes['color']];
				$cutjobno = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
				$remarks = $job_detail_attributes[$sewing_job_attributes['remarks']];
				$conumber = $job_detail_attributes[$sewing_job_attributes['cono']];
				$docket_number = $job_detail_attributes[$sewing_job_attributes['docketno']];
				$job_num = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
				$masterponumber = $job_detail_attributes[$sewing_job_attributes['masterponumber']];
				if($masterponumber ==''){
				$get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND plant_code='$plantcode' limit 1";
				}else{
					$get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND master_po='$masterponumber' AND plant_code='$plantcode' limit 1";
				}
					// echo $get_details."<br/>";
				$sql_result11=mysqli_query($link_new, $get_details) or exit("Sql Error get_details123".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row_main=mysqli_fetch_array($sql_result11))
				{
					$fg_good_id= $row_main['finished_good_id'];   
				}


				   
				$previous_operation=[];
				$get_operations="SELECT previous_operation FROM $pts.fg_operation WHERE finished_good_id='$fg_good_id'  AND plant_code='$plantcode' and operation_code='$operation'";
				// echo $get_operations;
				$sql_result12=mysqli_query($link_new, $get_operations) or exit("Sql Error get_operations".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($sql_result12))
				{
					$previous_operation[]=$row1['previous_operation'];
				}
				if(sizeof($previous_operation) >0){
					$previous_op = "'" . implode( "','", $previous_operation) . "'";
				}
				
				$current_op_query = "select parent_barcode,parent_job,sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity,operation,DATE(created_at) as input_date,DATEDIFF(NOW(), created_at) AS days,sub_po,style,color,schedule,size from $pts.transaction_log where parent_job='$job_num' and plant_code='$plantcode' and  operation in ($previous_op) group by parent_barcode";

			
				$currentOperationResult=mysqli_query($link_new, $current_op_query) or exit("Transactions not found".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowcount_check=1;
		
				$test_array=[];
				$balance=0;
				$bundle_wise_balance=0;
				while($currentTransRow=mysqli_fetch_array($currentOperationResult)) {
					$sub_po=$currentTransRow['sub_po'];
					$style=$currentTransRow['style'];
					$color=$currentTransRow['color'];
					$schedule=$currentTransRow['schedule'];
					$size=$currentTransRow['size'];
					$parent_barcode = $currentTransRow['parent_barcode'];   
					$sewingjobno = $currentTransRow['parent_job'];   
					$aging=$currentTransRow['days'];
					$previous_ops_qty=$currentTransRow['good_quantity'];
					$previous_op_query = "select sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity from $pts.transaction_log where style='$style' and schedule='$schedule' and color='$color' and size='$size' and plant_code='$plantcode' and parent_job='$sewingjobno' and parent_barcode='$parent_barcode' and operation ='$operation'";
					$previousOperationResult=mysqli_query($link_new, $previous_op_query) or exit("Transactions not found".mysqli_error($GLOBALS["___mysqli_ston"]));
					// $rejQtyOps=array();

						while($previousTransRow=mysqli_fetch_array($previousOperationResult)) {
							$current_ops_qty=$previousTransRow['good_quantity'];
							$rejected=$previousTransRow['rejected_quantity'];
						}
						if($current_ops_qty==''){
							$current_ops_qty=0;
						}
						if($rejected==''){
							$rejected=0;
						}
						$bundle_wise_balance=$previous_ops_qty-($current_ops_qty+$rejected);
						$balance=$balance+$bundle_wise_balance;
						$test_array[$parent_barcode]['size']=$size;
						$test_array[$parent_barcode]['sewingjobno']=$sewingjobno;
						$test_array[$parent_barcode]['cutjobno']=$cutjobno;
						$test_array[$parent_barcode]['aging']=$aging;
						$test_array[$parent_barcode]['previous_ops_qty']=$previous_ops_qty;
						$test_array[$parent_barcode]['current_ops_qty']=$current_ops_qty;
						$test_array[$parent_barcode]['rejected']=$rejected;
						$test_array[$parent_barcode]['bundle_wise_balance']=$bundle_wise_balance;
						
					}
				
			if($balance > 0)
			{
				if($toggle%2==0)
				{
					// $tr_color="#66DDAA";
					$tr_color="blue";
				} else if($toggle%2==1){
					$tr_color="white";
				}
				$toggle++;
				
				foreach($test_array as $key => $test){
					if($rowcount_check==1)
					{	
						if($row_counter == 0)
						echo "<tr class=\"$tr_color\" class=\"new\">
						<td>$module</td>";
						else 
						echo "<tr class=\"$tr_color\"  class=\"new\"><td></td>";
						
						echo "<td>$key</td>";
						echo "<td>$style</td>
						<td>$schedule</td>
						<td>$color</td>
						<td>".$test['sewingjobno']."</td>
						<td>".$test['cutjobno']."</td>
						<td>".$test['size']."</td>
						<td>".$test['previous_ops_qty']."</td>
						<td>".$test['current_ops_qty']."</td>
						<td>".$test['rejected']."</td>
						<td>".$test['bundle_wise_balance']."</td>
						
						<td>$remarks</td>
						<td>".$test['aging']."</td>";
						// $balance=$previous_ops_qty-($current_ops_qty+$rejected);
						if($rowcount_check==1)
						{
							echo "<td>$balance</td>";
						}
						$rowcount_check=0;
						$row_counter++;
						echo "</tr>";
					}
					else
					{			
						if($row_counter == 0)
						echo "<tr class=\"$tr_color\"  class=\"new\"><td>$module</td>";
						else 
						echo "<tr class=\"$tr_color\"  class=\"new\"><td></td>";
						$row_counter++;
						
				
						echo "<td>$key</td>";
						echo "<td>$style</td>";
						echo"<td>$schedule</td>
						<td>$color</td>
						<td>".$test['sewingjobno']."</td>
						<td>".$test['cutjobno']."</td>
						<td>".$test['size']."</td>
						<td>".$test['previous_ops_qty']."</td>
						<td>".$test['current_ops_qty']."</td>
						<td>".$test['rejected']."</td>
						<td>".$test['bundle_wise_balance']."</td>
						
						<td>$remarks</td>
						<td>".$test['aging']."</td>";
						//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
						//if($row_counter > 0)
						echo "<td class=\"$tr_color\" ></td>";
						
						echo "</tr>";
					}
				}
			}
		}
	}	
	echo "</table></div></div></div></div>";
	    // echo '<script type="text/javascript">getCSVData();</script>';
	    // echo"<script>alert(143);</script>";

	    
		
		?>
<script language="javascript">

function getCSVData() {
	$('.blue').css("background-color", "#fff");	
	$('tr').css("border", "0.5pt solid black");	
  $('table').attr('border', '1');
  $('table').removeClass('table-bordered');
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
    var table = document.getElementById('table1').innerHTML;
    // $('thead').css({"background-color": "blue"});
    var ctx = {worksheet: name || 'Modules Report', table : table}
    //window.location.href = uri + base64(format(template, ctx))
    var link = document.createElement("a");
    link.download = "Sections Report.xls";
    link.href = uri + base64(format(template, ctx));
    link.click();
    $('table').attr('border', '0');
    $('table').addClass('table-bordered');
    $('.blue').css("background-color", "#66DDAA");
    $('.blue').css("border", "0px solid black");
    // window.close ();	
}
</script>
</body>
</html>