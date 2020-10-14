
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<?php 

	if($_POST['sdate'])
	{
		$sdate=$_POST['sdate'];
		$edate=$_POST['edate'];
	}
	else
	{
		$sdate="";
		$edate="";
	}	

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
$plant_code = $_SESSION['plantCode'];
$username =  $_SESSION['userName'];	
?>

<script type="text/javascript">

	function verify_date(){
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}
	
</script>
</head>
<body>
   <div class="panel panel-primary">
	<div class="panel-heading"><b>Performance Report</b></div>
	<div class="panel-body">
        <div class="row">
		    <form method="post" name="test" action="#">
            <div class="col-md-2">
			<label>Start Date:</label> 
			<input type="text" data-toggle="datepicker" class="form-control"  name="sdate" id="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10">
			</div>
			<div class="col-md-2"><label>End Date:</label>
			<input type="text" data-toggle="datepicker" class="form-control"  name="edate" id="edate" onchange='return verify_date()' value="<?php  if($edate==""){ echo date("Y-m-d"); } else { echo $edate; } ?>" size="10">
			</div>
			<div class="col-md-2">
			<input type="submit" class="btn btn-primary btn-sm" value="Show" onclick='return verify_date()' name="submit" style="margin-top:25px;">
			</div>      
            </form>
        </div>
	<br/>
        <div class="row">
        <?php 
          if(isset($_POST['submit']))
          {
				$sdate=$_POST['sdate'];
				$edate=$_POST['edate'];
				  
				$r_name='Day wise performance Report';
				echo "<div class='col-md-5'><h3>&nbsp; Day wise performance Report </h3>";
				echo '</div>';
				echo '<div class="col-md-6">';
				echo '</div>';
				echo '<div class="col-md-1">';
				echo '<form action="'.getFullURL($_GET['r'],'export_to_excel_3.php','R').'" method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input type="hidden" name="csvname" id="csvname" value="'.$r_name.'">
				<input type="submit" class="btn btn-info btn-xs" id="expexc" name="expexc" value="Export Excel" onclick="getCSVData()">
				</form>';
				echo '</div>';
				echo '</div>';
                
				$sql_operation="SELECT operation_code AS ops_code,operation_name AS ops_name FROM $pms.operation_mapping WHERE plant_code='$plant_code' AND is_active=1 ORDER BY operation_code*1"; 
				$select_opertation=mysqli_query($link,$sql_operation) or exit($sql_operation."Error at something");
				echo "<div class='table-scroll' id='table-scroll' style='height:500px;overflow-y: scroll;'>";
				echo '<table class="table table-bordered table-fixed" id="report" name="report">
				<thead>
				<tr>
				<th>Date</th>
				<th>Module</th>
				<th>Shift</th>
				<th>Style</th>
				<th>Schedule</th>				
				<th>Color</th>
				<th>Size</th>';
				$operation_codes=array();
				while( $row_1 = mysqli_fetch_assoc( $select_opertation ) )
				{
					$operation_codes[]=$row_1['ops_code'];
					echo "<th>".$row_1['ops_name']."[".$row_1['ops_code']."] - Good</th>";
					echo "<th>".$row_1['ops_name']."[".$row_1['ops_code']."] - Rejected</th>";
				}				
				echo "<th>SAH</th></tr></thead><tbody>";				
				$i=0;
				$date=array();
				$mod=array();
				$shift=array();
				$style=array();
				$schedule=array();
				$color=array();
				$size_title=array();
				$operation_id=array();
				$reject=array();
				$good=array();
				$smv=array();
				$sah=array();
				$query='';

				for ($jj=0; $jj< count($operation_codes); $jj++) 
				{
				
					$query .= "sum(if(operation=".$operation_codes[$jj].",good_quantity,0)) as good_".$operation_codes[$jj].",sum(if(operation=".$operation_codes[$jj].",rejected_quantity,0)) as reject_".$operation_codes[$jj].",";
				
				}
				$selectSQL = "SELECT DATE(created_at) as dates,resource_id,shift,style,schedule,color,parent_job,$query size FROM 
				$pts.`transaction_log` WHERE DATE(created_at) BETWEEN '".$sdate."' AND '".$edate."' AND plant_code='$plant_code' AND is_active=1 GROUP BY DATE(created_at),resource_id,shift,style,schedule,color,size,parent_job";
				// echo $selectSQL."<br>";
				//die();
				$selectRes=mysqli_query($link,$selectSQL) or exit($selectSQL."Error at retirieving the info");
				while($row = mysqli_fetch_assoc( $selectRes ))
				{                                                    
					$tid[]=$i;
					$date[$i]=$row['dates'];
					$mod[$i]=$row['resource_id'];
					$shift[$i]=$row['shift'];
					$style[$i] = $row['style'];
					$schedule[$i] = $row['schedule'];
					$color[$i] = $row['color'];
					$size_title[$i] = $row['size'];
					$jobnumber[$i] = $row['parent_job'];
					for ($jjj=0; $jjj< count($operation_codes); $jjj++) 
					{
						//To get SMV 
						$get_smv="SELECT smv FROM $pps.`monthly_production_plan` WHERE product_code='".$style[$i]."' AND colour='$color[$i]' AND plant_code='$plant_code'";
						$query_result1=mysqli_query($link_new, $get_smv) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($smv_row=mysqli_fetch_array($query_result1))
						{
							$smv_row=$smv_row['smv'];
						}
						$sewing_job_enum=TaskAttributeNamesEnum::SEWINGJOBNO;
						//To get task_job_id
						 $qry_toget_jobids="SELECT task_jobs_id FROM $tms.task_attributes WHERE plant_code='$plant_code' AND attribute_name='$sewing_job_enum' AND attribute_value='$jobnumber[$i]' AND is_active=1";
						 $toget_jobids_result=mysqli_query($link_new, $qry_toget_jobids) or exit("Sql Error at qry_toget_jobids".mysqli_error($GLOBALS["___mysqli_ston"]));
						 while($toget_jobids_row=mysqli_fetch_array($toget_jobids_result))
						 {
							$taskjobids=$toget_jobids_row['task_jobs_id'];
						 }
                        /**
						 * getting min and max operations
						 */
						$qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$taskjobids."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
						$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
						if(mysqli_num_rows($maxOperationResult)>0){
							while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
								$maxOperation=$maxOperationResultRow['operation_code'];
							}
						}
						if($smv_row>0)
						{
							if($maxOperation==$operation_codes[$jjj])
							{
								$sah[$i] = round($row["good_".$operation_codes[$jjj].""]*$smv_row/60,2);
								$smv[$i] = $smv_row;
							}
						}
						else
						{
							$sah[$i]=0;
						}
						$good[$i][$operation_codes[$jjj]]=$row["good_".$operation_codes[$jjj].""];
						$reject[$i][$operation_codes[$jjj]]=$row["reject_".$operation_codes[$jjj].""];
					}					
					$i++;
				}
				for($ii=0;$ii<$i;$ii++)
				{ 
					//To get workstation description
					$query_get_workdes = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '$mod[$ii]' AND is_active=1";
					$result3 = $link->query($query_get_workdes);
					while($des_row = $result3->fetch_assoc())
					{
						$workstation_code = $des_row['workstation_code'];
					}                                    
					echo "<tr><td>".$date[$ii]."</td><td>".$workstation_code."</td><td>".$shift[$ii]."</td><td>".$style[$ii]."</td><td>".$schedule[$ii]."</td><td>".$color[$ii]."</td><td>".$size_title[$ii]."</td>";
					
								
					for ($j=0; $j< count($operation_codes); $j++) 
					{
						if($good[$ii][$operation_codes[$j]]==""){
							echo "<td>0</td>";
						}else{
								echo "<td>".$good[$ii][$operation_codes[$j]]."</td>";
						}
						
						if($reject[$ii][$operation_codes[$j]]==""){
							echo "<td>0</td>";
						}else{
								echo "<td>".$reject[$ii][$operation_codes[$j]]."</td>";
						}						
					}
					echo "<td>".$sah[$ii]."</td></tr>";
				}
				?>
				</tbody>
				</table>
				</div>
			</div>
				<?php
			 }
 ?>
                            
<script>
function getCSVData(){
	var dummytable = $('.fltrow').html();
	var dummytotal = $('.total_excel').html();
	$('.fltrow').html('');
	$('.total_excel').html('');
	var csv_value= $("#report").table2CSV({delivery:'value',excludeRows: '.fltrow .total_excel'});
	$("#csv_text").val(csv_value);	
	$('.fltrow').html(dummytable);
	$('.total_excel').html(dummytotal);

}
	
</script>
<style>
	table
{
	font-family:calibri;
	font-size:15px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}
h3{
    background-color: #221572;
    color:white; 
}
/* table th
{
	border: 1px solid black;
	text-align: center;
	background-color: #337ab7;
	border-color: #337ab7;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
} */

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:15px;
}
#reset{
	width : 50px;
	color : #ec971f;
	margin-top : 10px;
	margin-left : 0px;
	margin-bottom:15pt;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  height: 350px;
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #2687ad;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

</style>
