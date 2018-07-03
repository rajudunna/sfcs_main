<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
$excel_form_action = getFullURL($_GET['r'],'export_excel.php','R');
$table_csv = getFullURLLevel($_GET['r'],'common/js/table2CSV.js',1,'R');

?>


<!-- <style>
body
{
	font-family:arial;
	font-size:12px;
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

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style> -->
<style>
th
{
	white-space: nowrap;
}
</style>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>

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
<script type="text/javascript" src="<?php echo $table_csv ?>" ></script>	

	<div class="panel panel-primary">

		<?php 
		
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); ?>

		<?php
			$sdate=$_POST['sdate'];
			$edate=$_POST['edate'];
			$shift=$_POST['shift'];
			$module=$_POST['module'];
		?>


		<div class="panel-heading">Docket Summary - Report</div>
		<div class="panel-body">
			<form name="text" method="post" action="<?php echo getFullURL($_GET['r'], "docket_summary_v1.php", "N"); ?>">

			<div class="row">
			<div class="col-md-3">
			<label>Start Date:</label> 
			<input type="text" data-toggle="datepicker" class="form-control"  name="sdate" id="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10">
			</div>
			<div class="col-md-3"><label>End Date:</label>
	
			<input type="text" data-toggle="datepicker" class="form-control"  name="edate" id="edate" onchange='return verify_date()' value="<?php  if($edate==""){ echo date("Y-m-d"); } else { echo $edate; } ?>" size="10">
			</div>
			<input type="submit" class="btn btn-primary btn-sm" value="Submit" onclick='return verify_date()' name="submit" style="margin-top:25px;">
			</div>

			</form>

			<?php

			if(isset($_POST['submit']))
			{
				echo "<hr/>";
				$sdate=$_POST['sdate'];
				$edate=$_POST['edate'];
				//$shift=$_POST['shift'];
				//$module=$_POST['module'];
				
				/*if($module=="All")
				{
					$module="1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80";
				}
				*/

			//echo "<h2>Docket summary</h2>";
			
			$sql="SELECT b.order_style_no,b.order_del_no,b.order_col_des,p.order_tid,p.doc_no,p.pcutno,p.act_cut_status,p.print_status,
			p.docket_printed_person,p.fabric_status,p.log_update,
			f.log_user AS req_user,f.log_time,f.req_time,l.date_n_time AS fab_ready_time,f.issued_time,p.order_tid
			FROM $bai_pro3.plandoc_stat_log p 
			JOIN $bai_pro3.fabric_priorities f
			ON p.doc_no=f.doc_ref
			JOIN $bai_pro3.bai_orders_db b
			ON p.order_tid=b.order_tid
			LEFT JOIN $bai_pro3.log_rm_ready_in_pool l
			ON p.doc_no=l.doc_no
			WHERE f.log_time between \"$sdate\" and \"$edate\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count_query = mysqli_num_rows($sql_result);
			if($count_query > 0){

			echo "<div class=\"table-responsive\">";
			echo '<span class="pull-right">
			<form action="'.$excel_form_action.'" method ="post" > 
				<input type="hidden" name="csv_123" id="csv_123">
				<input class="btn btn-info btn-sm" type="submit" value="Export to Excel" onclick="getCSVData()">
			</form></span>
		';
			
			echo "<table class=\"table table-bordered\" id=\"table_one\" >";
			echo "<thead><tr class=\"info\"><th>Style</th><th>Schedule</th><th>Color</th><th>Docket#</th><th>Cut#</th><th>Fabric requested user</th>
			<th>CPS status</th><th>CPS status log time</th>
			<th>User log time</th><th>Fab. requested time</th><th>Fab. Ready time</th><th>Fab. Issued time</th><th>Docket print status</th><th>Docket printed user</th><th>Actual cut status</th></tr></thead>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$order_tid=$sql_row['order_tid'];
				$sql33="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
					mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row33=mysqli_fetch_array($sql_result33))
					{
						$color_code=$sql_row33['color_code']; //Color Code
					}
			
				$order_style_no=$sql_row['order_style_no'];
				$order_del_no=$sql_row['order_del_no'];
				$order_col_des=$sql_row['order_col_des'];
				$doc_no=$sql_row['doc_no'];
				$pcutno=$sql_row['pcutno'];
				$act_cut_status=$sql_row['act_cut_status'];
				$print_status=$sql_row['print_status'];
				$docket_printed_person=$sql_row['docket_printed_person'];
				$fabric_status=$sql_row['fabric_status'];
				$log_update=$sql_row['log_update'];
				$req_user=$sql_row['req_user'];
				$log_time=$sql_row['log_time'];
				
				$req_time=$sql_row['req_time'];
				$fab_ready_time=$sql_row['fab_ready_time'];
				if($fab_ready_time=="")
				{
					$fab_ready_time="NULL";
				}
				$issued_time=$sql_row['issued_time'];
				if ($issued_time=="0000-00-00 00:00:00")
				{
					$issued_time="NULL";
				}
				$m=$sql_row['size_m'];
				$l=$sql_row['size_l'];
				$xl=$sql_row['size_xl'];
				$xxl=$sql_row['size_xxl'];
				$xxxl=$sql_row['size_xxxl'];
									
							
					echo "<tr style=\"color: #000000\">";
					
					echo "<td>$order_style_no</td>";
					echo "<td>$order_del_no</td>";
					echo "<td>$order_col_des</td>";
					echo "<td>$doc_no</td>";
					echo "<td>".chr($color_code).leading_zeros($pcutno,3)."</td>";
					echo "<td>$req_user</td>";
					if($fabric_status=="5") { 
						echo "<td>Fab. Issued</td>";
					} else if($fabric_status=="8") { 
						echo "<td>Fab. Ready in Pool</td>";
					}else { 
						echo "<td> - </td>";
					}
					//echo "<td>$fabric_status</td>";
					echo "<td>$log_update</td>";
					echo "<td>$log_time</td>";
					echo "<td>$req_time</td>";
					echo "<td>".$fab_ready_time."</td>";
					echo "<td>$issued_time</td>";
					echo "<td>$print_status</td>";
					echo "<td>$docket_printed_person</td>";					
					echo "<td>$act_cut_status</td>";
					// echo "<td></td>";
					
					

					

					echo "</tr>";
			}

			echo "</table></div>";
			}else{
				echo "<div class='alert alert-danger'>No Data Found...</div>";
			}
			

			}
			?>
			<script language="javascript" type="text/javascript">
			$('#reset_table_one').addClass('btn btn-warning');

			var MyTableFilter = 
			{  
				exact_match: false,
				alternate_rows: true,
				// display_all_text: "Show All",
				// col_0: "select",
				// col_1: "select",
				rows_counter: true,
				rows_counter_text: "Total rows: ",
				btn_reset: true,

				bnt_reset_text: "Clear all "
			}
			setFilterGrid( "table_one", MyTableFilter );
			$(document).ready(function(){
				$('#reset_table_one').addClass('btn btn-warning btn-xs');
			});
			</script>
			<script>
				function getCSVData(){
				var csv_value=$('#table_one').table2CSV({delivery:'value'});
				$("#csv_123").val(csv_value);	
				}
			</script>
			<style>
			#reset_table_one{
				width : 80px;
				color : #fff;
				margin : 10px;
			}
			th,td{
				 text-align: center;
			}
			</style>
		</div>
	</div>
