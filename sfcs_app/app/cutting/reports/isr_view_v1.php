<?php
ini_set('max_execution_time', 0); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_content.php',1,'R'));
$table_csv = getFullURLLevel($_GET['r'],'common/js/table2CSV.js',1,'R');
$excel_form_action = getFullURL($_GET['r'],'export_excel1.php','R');
function get_size($table_name,$field,$compare,$key,$link)
{
	//GLOBAL $menu_table_name;
	//GLOBAL $link;
	$sql="select $field as result from $table_name where $compare='$key'";
	$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}



?>
<!-- <script src="js/jquery-1.4.2.min.js"></script>
<script src="js/jquery-ui-1.8.1.custom.min.js"></script>
<script src="js/cal.js"></script>
<link href="js/calendar.css" rel="stylesheet" type="text/css" /> -->

<script type="text/javascript">

		function verify_date(){
		var val1 = $('#from_date').val();
		var val2 = $('#to_date').val();
	
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


<script type="text/javascript" src="<?php echo $table_csv ?>" ></script>	

<?php 
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];
$section=$_POST['section'];
$shift=$_POST['shift'];
$reptype=$_POST['reptype'];
?>
<div class="panel panel-primary">
	<div class="panel-heading">Input Status Report</div>
	<div class="panel-body">
		<form class="form-inline" method="post" name="input" action="<?php echo "index.php?r=".$_GET['r']; ?>">
			<div class="form-group">
				<label>From Date:</label>
				<input type="text" class="form-control" data-toggle="datepicker" id="from_date" name="from_date" value="<?php if($from_date=="") {echo  date("Y-m-d"); } else {echo $from_date;}?>">
			</div>
			<div class="form-group">
				<label for="to">To Date:</label>
				<input type="text" class="form-control" data-toggle="datepicker" id="to_date" name="to_date" onchange="return verify_date();" value="<?php if($to_date=="") {echo  date("Y-m-d"); } else {echo $to_date;}?>">
			</div>

			     <div class="form-group">Shift: 
			       <select class="form-control" id="shift" name="shift">
			       <option value="ALL">ALL</option>
			       <?php
					$shifts = (isset($_GET['shift']))?$_GET['shift']:'';
					foreach($shifts_array as $key)
					{
						if($key == $shift)
						{
							echo "<option value='$key' selected>$key</option>";
						}
						else
						{
							echo "<option value='$key' >$key</option>";
						}
					}
				?>
			  </select>   
			</div>


			<button type="submit" id="submit" class="btn btn-primary" name="submit" onclick='return verify_date()'>Show</button>
		</form>
<?php
if(isset($_POST['submit']))
{
	
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
    $to_shift=$_POST['shift'];

	echo '<span class="pull-right">
			<form action="'.$excel_form_action.'" method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input class="btn btn-info btn-sm" type="submit" value="Export to Excel" onclick="getCSVData()">
			</form></span>
		';	
    echo "<div class='col-sm-12' style='overflow-y:scroll;max-height:600px;'>";
	echo "<table class='table table-hover table-bordered'  id='report'>";
	echo "<tr class='danger'>";
	echo "<th>Date</th>";
	echo "<th>Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>Color</th>";
	echo "<th>Module</th>";
	echo "<th>Docket</th>";
	echo "<th>Shift</th>";
	echo "<th>Cut Job</th>";
	echo "<th>Input Job</th>";
	echo "<th>Size</th>";
	echo "<th>Quantity</th>";
	echo "</tr>";
	
	If($to_shift == 'ALL')
	{
       $sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,sum(ims_qty) as ims_qty,ims_style,ims_schedule,ims_color,input_job_no_ref, input_job_rand_no_ref from $bai_pro3.ims_combine where ims_date between \"$from_date\" and \"$to_date\"and ims_mod_no>0 group by ims_style,ims_schedule,ims_color,ims_mod_no,ims_doc_no,ims_size  order by ims_date DESC,ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size";
	}
	else
	{
		$sql="select ims_date,ims_doc_no,ims_mod_no,ims_shift,ims_size,sum(ims_qty) as ims_qty,ims_style,ims_schedule,ims_color,input_job_no_ref, input_job_rand_no_ref from $bai_pro3.ims_combine where ims_date between \"$from_date\" and \"$to_date\"and ims_mod_no>0 and ims_shift = '$to_shift' group by ims_style,ims_schedule,ims_color,ims_mod_no,ims_doc_no,ims_size  order by ims_date DESC,ims_style,ims_schedule,ims_color,ims_doc_no,ims_mod_no,ims_shift,ims_size ";
	}	
	

	//echo $sql;
 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['ims_date']."</td>";
		echo "<td>".$sql_row['ims_style']."</td>";
		echo "<td>".$sql_row['ims_schedule']."</td>";
		echo "<td>".$sql_row['ims_color']."</td>";
		echo "<td>".$sql_row['ims_mod_no']."</td>";
		echo "<td>".$sql_row['ims_doc_no']."</td>";
		echo "<td>".$sql_row['ims_shift']."</td>";
		
		$display_prefix1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$sql_row['input_job_no_ref'],$sql_row['input_job_rand_no_ref'],$link);
		$sql111="select order_div from $bai_pro3.bai_orders_db where order_del_no=".$sql_row['ims_schedule'];
		//echo $sql1;
	 	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error Buyer Divisionsss".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row111=mysqli_fetch_array($sql_result111))
		{						
			$division=$sql_row111['order_div'];
		}
		
		
		$sql1="select color_code,acutno,order_div from $bai_pro3.plandoc_stat_log_cat_log_ref where doc_no=".$sql_row['ims_doc_no'];
		//echo $sql1;
	 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			echo "<td>".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3)."</td>";			
			//$division=$sql_row1['order_div'];			
		}
				
	
		if(mysqli_num_rows($sql_result1)==0)
		{
			echo "<td></td>";
		}
		//echo $sql_row['ims_size'];
		//echo sizeof($size_db_base);
		$scode= str_replace("a_","",$sql_row['ims_size']);
		
		
		echo "<td>".$display_prefix1."</td>";
		$act_size=get_size("$bai_pro3.bai_orders_db_confirm","title_size_".$scode."","order_del_no='".$sql_row['ims_schedule']."' and order_col_des",$sql_row['ims_color'],$link);
	//	echo $act_size."<br>";
		echo "<td>".strtoupper($act_size)."</td>";		
		echo "<td>".$sql_row['ims_qty']."</td>";
		echo "</tr>";
	}
	
	
	
	echo "</table>
	</div>";
}
?>
</div>
</div>
<script>
function getCSVData(){
 var csv_value=$('#report').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>