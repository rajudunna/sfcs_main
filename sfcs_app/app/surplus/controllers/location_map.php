<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
	// $Page_Id = 'SFCS_0401';
	// $view_access=user_acl($Page_Id,$username,1,$group_id_sfcs);
	$has_permission=haspermission($_GET['r']);
	if(in_array($authorized,$has_permission))
	{
		
	}
	else
	{
		header($_GET['r'],'restricted.php','N');
	}
?>
<?php echo '<link href="'.getFullURLLevel($_GET['r'],'/common/css/sfcs_styles.css',3,'R').'" rel="stylesheet" type="text/css" />'; ?>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script><!-- External script -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<div class="panel panel-primary">
	<div class="panel-heading">Location MAP</div>
	<div class="panel-body">
		<div class="col-sm-12" style='overflow-x:auto;overflow-y:auto;max-height:600px;'>
			<?php
				include("surplus_auto_correct_function.php");

				$table="<table class='table table-bordered table-stripped' id='table1'>";
				$table.="<thead>";
				$table.="<tr class='success'>";
				$table.='<th><center>S.NO</center></th>';
				$table.='<th><center>Location ID</center></th>';
				$table.="<th><center>Description</center></th>";
				$table.="<th><center>Capacity</center></th>";
				$table.="<th><center>Filled</center></th>";
				$table.="<th><center>Balance</center></th>";
				$table.="</tr>";
				$table.="</thead><tbody>";
				echo $table;
				$i=1;

				$sql="select * from $bai_pro3.bai_qms_location_db where location_type in (0,1) and active_status=0 order by qms_cur_qty desc,order_by desc";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result)>0){
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$table="<tr><td ><center>".$i."</center></td><td><center><a class='btn btn-info btn-xs' href='".getFullURL($_GET['r'],'location_update.php','N')."&location=".$sql_row['qms_location_id']."'>".$sql_row['qms_location_id']."</a></center></td>";
						$table.="<td><center>".$sql_row['qms_location']."</center></td>";
						$table.="<td><center>".$sql_row['qms_location_cap']."</center></td>";
						surplus_auto_correct($sql_row['qms_location_id'],$link);
						$table.="<td><center>".$sql_row['qms_cur_qty']."</center></td>";
						$table.="<td><center>".($sql_row['qms_location_cap']-$sql_row['qms_cur_qty'])."</center></td>";
						$table.="</tr>";
						
						echo $table;
						$i++;
					}
					echo '<tr><th colspan=4 style="text-align:right">Total Filled Quantity:</th><td id="table1Tot1" style="background-color:#FFFFCC; color:red;text-align:right;"></td><td></td></tr>';
					$table='</tbody></table>';
					echo $table;
					echo "</br>";
				}
				else {
					$table="<tr><td colspan=6><div class='alert alert-danger' style='text-align:center'><strong>No Data</strong> Found!</div></td></tr>";
					echo $table;
					$table='</tbody></table>';
					echo $table;
				}
			?>
		</div>
	</div>
</div>

<script language="javascript" type="text/javascript">
	$('#reset_table1').addClass('btn btn-warning');
	var fnsFilters = {
		rows_counter: true,
		sort_select: true,
		btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
		col_operation: { 
							id: ["table1Tot1"],
							col: [4],  
							operation: ["sum"],
							decimal_precision: [1],
							write_method: ["innerHTML"] 
						},
		rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]	
	};
	 setFilterGrid("table1",fnsFilters);

	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
</script>
<!-- <script language="javascript" type="text/javascript">  
	// var totRowIndex = tf_Tag(tf_Id('table1'),"tr").length;  
	var fnsFilters = {
			rows_counter: true,
			col_operation: { 
							id: ["table1Tot1"],
							col: [4],  
							operation: ["sum"],
							decimal_precision: [1],
							write_method: ["innerHTML"] 
						},
		};
    var tf7 = setFilterGrid("table1",fnsFilters);
</script>   --> 

<!-- <script language="javascript" type="text/javascript">  
//<![CDATA[  
var totRowIndex = tf_Tag(tf_Id('table7'),"tr").length;  
    var table7_Props =  {  
                    rows_counter: true,  
                    col_operation: {  
                                id: ["table8Tot1","table8Tot2"],  
                                col: [2],  
                                operation: ["sum"],  
                                write_method: ["innerHTML"],  
                                exclude_row: [totRowIndex],  
                                decimal_precision: [1]  
                            },  
                    rows_always_visible: [totRowIndex]  
                };  
var tf7 = setFilterGrid( "table1",table7_Props );  
//*** Note ***  
//You can also write operation results in elements outside the table.  
//]]>  
</script>   -->

<style>
#reset_table1{
	width : 80px;
	color : #fff;
	margin : 10px;
}
</style>






