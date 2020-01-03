
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

				$sql_operation="SELECT op_flow.operation_name AS ops_name,op_flow.operation_code AS ops_code 
				FROM $brandix_bts.tbl_orders_ops_ref AS op_flow LEFT JOIN $brandix_bts.default_operation_workflow AS w_flow ON op_flow.operation_code=w_flow.operation_code WHERE op_flow.display_operations='yes' ORDER BY w_flow.`operation_order`"; 
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
				$brandix_bts.`bundle_creation_data_temp` WHERE date_time BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' 
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