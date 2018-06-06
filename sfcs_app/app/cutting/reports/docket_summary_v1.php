<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=$username_list[1];
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
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R')?>"></script><!-- External script -->
<script type="text/javascript">

	// $(document).ready(function() {
	// 	$('#edate').on('mouseup',function(e){
	// 		var val1 = $('#sdate').val();
	// 		var val2 = $('#edate').val();
	// 		$d1 = new DateTime($val1);
	// 		$d2 = new DateTime($val2);
	// 		var k = e.which;
	// 		if(d1 < d2){
	// 			sweetAlert('End date should not be greater than Start date','','warning');
	// 			$('#sdate').val('');
	// 		}
	// 	});
	// });

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

	<div class="panel panel-primary">

		<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); ?>
		<?php //include("../".getFullURLLevel($_GET['r'], "dbconf3.php", "1", "R").""); ?>

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
			f.log_user AS req_user,f.log_time,f.req_time,l.date_n_time AS fab_ready_time,f.issued_time
			FROM $bai_pro3.plandoc_stat_log p 
			JOIN $bai_pro3.fabric_priorities f
			ON p.doc_no=f.doc_ref
			JOIN $bai_pro3.bai_orders_db b
			ON p.order_tid=b.order_tid
			LEFT JOIN $bai_pro3.log_rm_ready_in_pool l
			ON p.doc_no=l.doc_no
			WHERE f.log_time between \"$sdate\" and \"$edate\"";

			//echo $sql."<br>";
			//mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count_query = mysqli_num_rows($sql_result);
			if($count_query > 0){

				echo "<div class=\"table-responsive\">";

			echo "<table class=\"table table-bordered\" id=\"table_one\" border=1 >";
			//echo "<tr><th>TID</th><th>Date</th><th>Module</th><th>Section</th><th>Shift</th><th>Qty</th><th>Last Updated</th><th>Log Time</th><th>Controls</th><th>User Style</th><th>Movex Style</th><th>Schedule</th><th>Color</th><th>Cut No</th><th>SMV</th><th>NOP</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>s08</th><th>s10</th><th>s12</th><th>s14</th><th>s16</th><th>s18</th><th>s20</th><th>s22</th><th>s24</th><th>s26</th><th>s28</th></tr>";
			echo "<thead><tr><th class=\"coloum-title\"><center>Style</center></th><th class=\"coloum-title\"><center>Schedule</center></th><th class=\"coloum-title\"><center>Color</center></th><th class=\"coloum-title\"><center>Docket#</center></th><th class=\"coloum-title\"><center>Cut#</center></th><th class=\"coloum-title\"><center>Actual cut status</center></th>
			<th class=\"coloum-title\"><center>Docket print status</center></th><th class=\"coloum-title\"><center>Docket printed user</center></th><th class=\"coloum-title\"><center>CPS status</center></th><th class=\"coloum-title\"><center>CPS status log time</center></th><th class=\"coloum-title\"><center>Fabric requested user</center></th>
			<th class=\"coloum-title\"><center>User log time</center></th><th class=\"coloum-title\"><center>Fab. requested time</center></th><th class=\"coloum-title\"><center>Fab. Ready time</center></th><th class=\"coloum-title\"><center>Fab. Issued time</center></th></tr></thead>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
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
					
					echo "<td class=\"  \"><center>$order_style_no</center></td>";
					echo "<td class=\"  \"><center>$order_del_no</center></td>";
					echo "<td class=\"  \"><center>$order_col_des</center></td>";
					echo "<td class=\"  \"><center>$doc_no</center></td>";
					echo "<td class=\"  \"><center>$pcutno</center></td>";
					echo "<td class=\"  \"><center>$act_cut_status</center></td>";
					echo "<td class=\"  \"><center>$print_status</center></td>";
					echo "<td class=\"  \"><center>$docket_printed_person</center></td>";
					if($fabric_status=="5") { 
						echo "<td class=\"  \"><center>Fab. Issued</center></td>";
					} else if($fabric_status=="8") { 
						echo "<td class=\"  \"><center>Fab. Ready in Pool</center></td>";
					}else { 
						echo "<td class=\"  \"><center> - </center></td>";
					}
					//echo "<td>$fabric_status</td>";
					echo "<td class=\"  \"><center>$log_update</center></td>";
					echo "<td class=\"  \"><center>$req_user</center></td>";
					echo "<td class=\"  \"><center>$log_time</center></td>";
					echo "<td class=\"  \"><center>$req_time</center></td>";
					echo "<td class=\"  \"><center>".$fab_ready_time."</center></td>";
					echo "<td class=\"  \"><center>$issued_time</center></td>";
					// echo "<td class=\"  \"><center></center></td>";
					
					

					

					echo "</tr>";
			}

			echo "</table></div>";
			}else{
				echo "<div class='alert alert-danger'>No Data Found...</div>";
			}
			

			}
			?>
			<script language="javascript" type="text/javascript">
			//<![CDATA[
			//var MyTableFilter = {  exact_match: true }

			//setFilterGrid( "table1");

			var table3Filters = {
					btn: true,
					col_0:"select",
					col_2: "select",
					// col_4:"none",
					// col_5:"none",
					// col_6:"none",
					// col_7:"none",
					// col_8:"none",
					// col_9:"none",
					// col_10:"none",
					// col_11:"none",
					// col_12:"none",
					// col_13:"none",
					// col_14:"none",
					// col_15:"none",
					// col_16:"none",
					
					exact_match: true,
					alternate_rows: true,
					loader: true,
					loader_text: "Filtering data...",
					loader: true,
					btn_reset_text: "Clear",
					display_all_text: "Display all rows",
					btn_text: ">"
				}
				setFilterGrid("table_one",table3Filters);


			//]]>
			</script>
		</div>
	</div>
