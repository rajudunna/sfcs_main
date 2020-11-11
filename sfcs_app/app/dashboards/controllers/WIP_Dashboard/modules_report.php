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
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
// error_reporting(E_ALL);
$plantcode = $_session['plantCode'];
$plantcode ='AIP';
$username =  $_session['userName'];
$username =  'sfcsproject1';


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
<title>Modules Report</title>
<style>
	table, th, td {
		text-align: center;
	}
</style>



<script type="text/javascript" src="../../../../common/js/jquery.js"></script> 
<script src="../../../../common/js/jquery.min.js"></script>


</head>

<body>

<?php
$work_station_id=$_GET['module_id'];
$work_station=$_GET['module_code'];
$operation=$_GET['operation_code'];
$department='SEWING';
ini_set('max_execution_time', 30000);

$qryMoudleName="SELECT workstation_description FROM $pms.`workstation` WHERE workstation_id ='$work_station_id'";
$MoudleName_result=mysqli_query($link_new, $qryMoudleName) or exit("Problem in getting section".mysqli_error($GLOBALS["___mysqli_ston"]));
while($MoudleName_row=mysqli_fetch_array($MoudleName_result))
{
	$workstation_description=$MoudleName_row['workstation_description'];
}



?>

<?php
echo "<br/><div class='container-fluid'>";

	echo "<div class='panel panel-primary'>";
		echo "<div class='panel-heading'>Module - ".$workstation_description." Summary</div>";
		
            echo "<div class='panel-body'>";
				echo "<div class='table-responsive'>";
					echo "<input id='excel' type='button'  class='btn btn-success' value='Export To Excel' onclick='getCSVData()'>";
					echo "</br>";
					echo "</br>";
                	echo "<form name='test' action='modules_report.php' class='form-inline' method='post'>";

						echo "<table class=\"table table-bordered table-striped\" id=\"table1\"> 
							<tr class='info'>
								<th>Select</th>
								<th>Bundle No</th>
								<th>Style</th>
								<th>Schedule</th>
								<th>Color</th>
								<th style='max-width: 80px'>Input Job No</th>
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

							// $qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id='".$job['taskJobId']."' and plant_code='$plantcode' and is_active=1";
							// $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
		
							$rowcount_check=0;
							$row_counter=0;
							$jobsArray = getJobsForWorkstationIdTypeSewing($plantcode,$work_station_id,'');
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
								// var_dump($job_num,"job_num<br/>");
									//To get finished_good_id
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
								// echo $current_op_query."<br/>";

							
								$currentOperationResult=mysqli_query($link_new, $current_op_query) or exit("Transactions not found".mysqli_error($GLOBALS["___mysqli_ston"]));
								// $rejQtyOps=array();
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
									// var_dump($sewingjobno,"sewingjobno<br/>");
									$previous_op_query = "select sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity from $pts.transaction_log where style='$style' and schedule='$schedule' and color='$color' and size='$size' and plant_code='$plantcode' and parent_job='$sewingjobno' and parent_barcode='$parent_barcode' and operation ='$operation'";
									// echo $previous_op_query."<br/>";
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
									// var_dump($balance,"~~~~~~~~~~~~~~~~~~~~balance<br/>");
								
								if($balance > 0)
								{
									if($toggle%2==0)
									{
										// $tr_color="#66DDAA";
										$tr_color="blue";
									} else if($toggle==1){
										$tr_color="white";
									}
									$toggle++;
									
									foreach($test_array as $key => $test){
										
											
											// echo "<td style='border-top:1.5pt solid #fff;'>$work_station</td>";
											if($test['current_ops_qty']==0)
											{
												echo "<td><input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$key."\"></td>"; 
											}
											else 
											{ 
												echo "<td>N/A</td>"; 
											}
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
											// if($rowcount_check==1)
											// {
												echo "<td>".$test['bundle_wise_balance']."</td>";
											// }
											$rowcount_check=0;
											$row_counter++;
											echo "</tr>";
										
									}
								}
							}
						echo "</table>";
						
						// echo 'test';
						?>

						<label>Select Module:</label> 

						<select class='form-control' name="module_ref"  id='module_ref' required>
                        	<option value=''>Please Select</option>
                            <?php
							 $departmentType = DepartmentTypeEnum::SEWING;
							 var_dump($departmentType);
                             /**getting workstations based plant and department*/
                             $workstationsResult=getWorkstations($departmentType,$plantcode);
                             $workStations=$workstationsResult['workstation'];
                                // for($x=0;$x<sizeof($work_mod);$x++)
                                foreach($workStations as $key=>$value)
                                {
                                  echo "<option value=\"".$key."\" >".$value."</option>";
                                  //$module=$mods[$x];
                                }
                            ?>
                    	</select>
						<?php 
						echo '<input type="button" name="submit" id="submit" class="btn btn-primary " value="Input Transfer"> 
						<input type="hidden" value="'.$work_station_id.'" name="module"> 
						<input type="hidden" value="'.$work_station.'" name="plant_code">
						<input type="hidden" value="'.$operation.'" name="operation">
						<input type="hidden" value="'.$user_name.'" name="user_name">'; 
		
					echo "</form>
				</div>
			</div>
		</div>
	</div>
</div>";
	    // echo '<script type="text/javascript">getCSVData();</script>';
	    // echo"<script>alert(143);</script>";

	    
		
		?>
<script>
$(document).ready(function(){
       $('body').on('click','#submit',function(){
           if($('#count').val() == 1){
            swal('Can Not Transfer','Module has only one bundle','error');
           } else {
                var bundles=[];
                $('input[type=checkbox]').each(function (){
                    if(this.checked){
                        //console.log($(this).val());
                        bundles.push($(this).val())

                    }
                });
                var module = $('#module_ref').val();
                var plantcode = '<?= $plantcode?>';
                var module1 = '<?= $module?>';
                var user_name = '<?= $user_name?>';
				var module_id = '<?= $work_station_id ?>';
				var module_code = '<?= $work_station ?>';
				var operation = '<?= $operation ?>';
                const data={
                                "bundleNumber": bundles,
                                "plantcode": '<?= $plantcode ?>',
                                "resourceId": module,
                                "createdUser": '<?= $user_name ?>'
                            }
                            var bearer_token;
				bearer_token = '<?= $_SESSION['authToken'] ?>';
				$.ajax({
					type: "POST",
					url: "<?php echo $PPS_SERVER_IP?>/jobs-generation/transferBundlesToWorkStation",
					headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
					data: data,
					success: function (res) {
						// console.log(res);
						if(res.status)
						{
							swal('','Bundle Transfered Successfully','success')
							setTimeout(function(){window.location.replace("modules_report.php?module_id="+module_id+"&module_code="+module_code+"&operation_code="+operation)} , 3000);
							
						}
						else
						{
							swal('',res.internalMessage,'error');
							setTimeout(function(){window.location.replace("modules_report.php?module_id="+module_id+"&module_code="+module_code+"&operation_code="+operation)} , 3000);
						}                       
						//$('#loading-image').hide();
					},
					error: function(res){
						swal('Error in getting data');
						setTimeout(function(){window.location.replace("modules_report.php?module_id="+module_id+"&module_code="+module_code+"&operation_code="+operation)} , 3000);
						//$('#loading-image').hide();
					}
				});
            }
        });
    });
</script>	
<script language="javascript" type="text/javascript">
    var table2_Props =  {            
        display_all_text: "All",
        col_0: "none",
        col_1: "none",
        col_2: "none",
        col_3: "select",
        col_4: "select", 
        col_5: "select",
        col_6: "select",
        col_7: "select",
        col_8: "none",
        col_9: "none",
        col_10: "none",
        col_11: "none",
        col_12: "none",
        col_13: "none",
        col_14: "none",
        col_15: "none",
        sort_select: true,
        paging: true,  
        paging_length: 100, 
        rows_counter: true,  
        rows_counter_text: "Displaying Rows:",  
        btn_reset: true,
        btn_reset_text: 'Reset Filter', 
        loader: true,  
        loader_text: "Filtering data..."
    };
    setFilterGrid( "table1", table2_Props);
</script>	
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
    link.download = "Module Wise WIP Report.xls";
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