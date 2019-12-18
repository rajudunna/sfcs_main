<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
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
            <div class="col-md-3">
			<label>Start Date:</label> 
			<input type="text" data-toggle="datepicker" class="form-control"  name="sdate" id="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10">
			</div>
			<div class="col-md-3"><label>End Date:</label>
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
				  
				$r_name='Daily wise performance Report';
				echo "<h3>&nbsp; Daily wise performance Report </h3>";
				echo '</div>';
				echo '<div class="col-md-7">';
				echo '</div>';
				echo '<div class="col-md-1">';
				echo '<form action="'.getFullURL($_GET['r'],'export_to_excel3.php','R').'" method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input type="hidden" name="csvname" id="csvname" value="'.$r_name.'">
				<input type="submit" class="btn btn-info" id="expexc" name="expexc" value="Export Excel" onclick="getCSVData()">
				</form>';
				echo '</div>';
				echo '</div>';

				$sql_operation="SELECT op_flow.operation_name AS ops_name,op_flow.operation_code AS ops_code 
				FROM $brandix_bts.tbl_orders_ops_ref AS op_flow LEFT JOIN $brandix_bts.default_operation_workflow AS w_flow ON op_flow.operation_code=w_flow.operation_code WHERE op_flow.display_operations='yes' ORDER BY w_flow.`operation_order`"; 
				$select_opertation=mysqli_query($link,$sql_operation) or exit($sql_operation."Error at something");
				echo "<div class='table-responsive'>";
				echo '<table class="table table-bordered table-responsive" id="report" name="report">
				<tr>
				<th rowspan="2">Date</th>
				<th rowspan="2">Module</th>
				<th rowspan="2">Shift</th>
				<th rowspan="2">Style</th>
				<th rowspan="2">Schedule</th>				
				<th rowspan="2">Color</th>
				<th rowspan="2">Size</th>';
				$ab="";
				$operation_codes=array();
				while( $row_1 = mysqli_fetch_assoc( $select_opertation ) )
				{
					$operation_codes[]=$row_1['ops_code'];
					echo "<th colspan='2' >".$row_1['ops_name']."</th>";
					$ab.="<th>Good Quantity</th>
					<th>Rejected Quantity</th>";
				}				
				echo "<th rowspan='2'>SAH</th></tr><tr>".$ab."</tr>";				
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
				$opcodes=implode(',',$operation_codes);	
				$appilication = 'IMS_OUT';
				$checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication'";
				$result_checking_output_ops_code = $link->query($checking_output_ops_code);
				if($result_checking_output_ops_code->num_rows > 0)
				{
					while($row_result_checking_output_ops_code = $result_checking_output_ops_code->fetch_assoc()) 
					{
					   $output_ops_code = $row_result_checking_output_ops_code['operation_code'];
					}
				}
				else
				{
					$output_ops_code = 130;
				}
				
				for ($jj=0; $jj< count($operation_codes); $jj++) 
				{
					if($operation_codes[$jj]== $output_ops_code)
					{
						$query .= "sum(if(operation_id=".$operation_codes[$jj].",recevied_qty,0)) as good_".$operation_codes[$jj].",sum(if(operation_id=".$operation_codes[$jj].",rejected_qty,0)) as reject_".$operation_codes[$jj].",MAX(sfcs_smv) as smv,";
					}
					else
					{
						$query .= "sum(if(operation_id=".$operation_codes[$jj].",recevied_qty,0)) as good_".$operation_codes[$jj].",sum(if(operation_id=".$operation_codes[$jj].",rejected_qty,0)) as reject_".$operation_codes[$jj].",";
					}
				}
				$selectSQL = "SELECT DATE(date_time) as dates,assigned_module,shift,style,SCHEDULE,color,$query size_title FROM 
				$brandix_bts.`bundle_creation_data_temp` WHERE date_time BETWEEN '".$sdate."' AND '".$edate."' 
				GROUP BY DATE(date_time),assigned_module,shift,style,SCHEDULE,color,size_title";
				//echo $selectSQL."<br>";
				//die();
				$selectRes=mysqli_query($link,$selectSQL) or exit($selectSQL."Error at retirieving the info");
				while($row = mysqli_fetch_assoc( $selectRes ))
				{                                                    
					$tid[]=$i;
					$date[$i]=$row['dates'];
					$mod[$i]=$row['assigned_module'];
					$shift[$i]=$row['shift'];
					$style[$i] = $row['style'];
					$schedule[$i] = $row['SCHEDULE'];
					$color[$i] = $row['color'];
					$size_title[$i] = $row['size_title'];
					for ($jjj=0; $jjj< count($operation_codes); $jjj++) 
					{					
						if($row['smv']>0)
						{
							if($output_ops_code==$operation_codes[$jjj])
							{
								$sah[$i] = round($row["good_".$operation_codes[$jjj].""]*$row['smv']/60,2);
								$smv[$i] = $row['smv'];
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
				   echo "<tr><td>".$date[$ii]."</td><td>".$mod[$ii]."</td><td>".$shift[$ii]."</td><td>".$style[$ii]."</td><td>".$schedule[$ii]."</td><td>".$color[$ii]."</td><td>".$size_title[$ii]."</td>";
				   
				   			
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
				</table>
				</div>
			</div>
				<?php
			 }
 ?>
                            
<script>
function getCSVData(){
 var csv_value=$('#report').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
$(document).ready(function(){
    document.getElementById('reptype').value = "<?php echo $_POST['reptype'];?>";
    $('#reset').addClass('btn btn-warning btn-xs');
});

$('#reset').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "report",table6_Props );
	
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
</style>
