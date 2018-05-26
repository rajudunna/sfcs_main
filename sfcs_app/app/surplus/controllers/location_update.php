<?php
	include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
	// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
	// $username=strtolower($username_list[1]);
	// $view_access=user_acl("SFCS_0175",$username,1,$group_id_sfcs);
?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script>


<script>

function enable_button()
{
	var x = document.getElementsByName("location[]");
	var i;
	var count = x.length;
    for (i = 0; i < x.length; i++) 
    {
	    if((x[i].value).length > 0)
		{
			count--;
    		document.getElementById("add").disabled=false;
		}
    }
    if(count == x.length){
    	sweetAlert('Please Select Alteast One Location To Update','','warning');
    	document.getElementById("enable").checked=false;
    	document.getElementById("add").disabled=true;
    }
    if(document.getElementById("enable").checked==false)
	{
		document.getElementById("add").disabled=true;
	}
	
}

</script>
<?php
	if(isset($_POST['confirm'])){
		$tid=$_POST['tid'];
		$location=$_POST['location'];
		for($i=0;$i<sizeof($tid);$i++){
			if(strlen($location[$i])>0){
				$sql="update bai_pro3.bai_qms_db set location_id='".$location[$i]."' where qms_tid=".$tid[$i];
				mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		echo "<div class='alert alert-success'><strong>Success!</strong> Successfully Updated</div>";
	}
?>

<?php
$export_excel="";
echo '<div class="panel panel-primary"><div class="panel-heading">Update Location</div>
		<div class="panel-body">';
echo '<form name="update" method="post" action='.getURL(getBASE($_GET['r'])['path'])['url'].'>';
echo "<div  class ='table-responsive' style='overflow:scroll;max-height:700px'>";
$table="<table class='table table-bordered' id='table1'>";
$table.="<thead>";
$table.="<tr class='success'>";
$table.='<th>SNo</th>';
$table.='<th>Reported Date</th>';
$table.="<th>Style</th>";
$table.="<th>Schedule</th>";
$table.="<th>Color</th>";
$table.="<th>Size</th>";
$table.="<th>Available Quantity</th>";
$table.="<th>Transaction Type</th>";
$table.="<th>Location</th>";
$table.="</tr>";
$table.="</thead><tbody>";
echo $table;

//Serial number and Post variable index key
$x=0;
$y=0;

$location_id=array();
$location_title=array();
$location_id[]="";
$location_title[]="";
$sql="select * from bai_pro3.bai_qms_location_db where location_type=0 and qms_location_id not like \"INT%\"and active_status=0 and qms_cur_qty<qms_location_cap order by qms_cur_qty desc,order_by desc";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$location_id[]=$sql_row['qms_location_id'];
	$location_title[]=$sql_row['qms_location_id']."-".$sql_row['qms_cur_qty'];
}
$sql="select * from bai_pro3.bai_qms_db where qms_tran_type in (1,3,5) and length(location_id)=0 order by qms_schedule,qms_color,qms_size";
//To show items in a location
if(isset($_GET['location']))
{
	$sql="select * from bai_pro3.bai_qms_db where location_id='".$_GET['location']."' order by qms_schedule,qms_color,qms_size";
}

$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0) {
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sql2="select COALESCE(SUM(qms_qty),0) as qty from bai_pro3.bai_qms_db where qms_tran_type in (12,13) and ref1=\"".$sql_row['qms_tid']."\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$resr_qty=$sql_row2["qty"];
		}
			$table="<tr  id=\"rowchk$x\">";
			$table.="<td>".($y+1)."</td>";
			$table.="<td>".$sql_row['log_date']."</td>";
			$table.="<td>".$sql_row['qms_style']."</td>";
			$table.="<td>".$sql_row['qms_schedule']."</td>";
			$table.="<td>".$sql_row['qms_color']."</td>";
			$table.="<td>".$sql_row['qms_size']."</td>";
			$table.="<td>".($sql_row['qms_qty']-$resr_qty)."</td>";
			
			$title="";
			switch($sql_row['qms_tran_type'])
			{
				case 1:
				{
					$title="Panel Form";
					break;
				}
				case 3:
				{
					$title="Rejections";
					break;
				}
				case 5:
				{
					$title="Surplus Garments";
					break;
				}
				default:
				{
					$title="U/K";
					break;
				}
			}
				
			$table.="<td>".$sql_row['qms_tran_type']."-".$title."</td>";
			
			//To show items in a location
					if($title=="U")
					{
						$table.="<td>N/A</td>";
					}
					else
					{
						$table.="<td><select name='location[]' id='location[]' class='form-control' >";
						for($i=0;$i<sizeof($location_id);$i++)
						{
							$table.="<option value='".$location_id[$i]."'>".$location_title[$i]."</option>";
						}
						$table.="</select><input type='hidden' name='tid[$x]' value='".$sql_row['qms_tid']."'></td>";
						$x++;
					}
			$table.="</tr>";
			echo $table;
			$y++;
	}
	echo '<tr><td colspan=6>Total Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
	$table='</tbody>
	</table>
	</div>';
	echo $table;
	echo "<br/>";
}
else {
	$table="<tr><td colspan=9><div class='alert alert-danger' style='text-align:center'><strong>No Data</strong> Found!</div></td></tr>";
	echo $table;
	$table='</tbody></table>';
	echo $table;
}
echo '<div class="col-md-1"><input type="checkbox" name="enable"  id="enable" onclick="enable_button()">Enable&nbsp;</div><div class="col-md-2"><input type="submit"  class="btn btn-success " name="confirm" value="Update Locations" id="add" disabled="true" ></div></div>';
echo '</form>';
echo '</div>';
echo '</div>';
?>

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
						col: [6],  
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

<style>
#reset_table1{
	width : 80px;
	color : #fff;
	margin : 10px;
}
</style>