<?php



include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plantcode='Q01';
?>

<style>
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

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}

</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:50px;
 right:0;
 width:auto;
float:right;
}
</style>



<style type="text/css" media="screen">

h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;}

</style>
<script>

function enable_button()
{
	var checkedStatus = document.getElementById("enable").checked;
	
	if(checkedStatus===true)
	{
		document.getElementById("add").disabled=false;
	}
	else
	{
		document.getElementById("add").disabled=true;
		
	}
}
function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
		
</script>
<script>
function firstbox()
{
	var url4 = '<?= getFullUrl($_GET['r'],'job_summary_view.php','N'); ?>';
	window.location.href =url4+"&mpo="+document.filter.mpo.value;
}

// function secondbox()
// {
// 	var url5 = '<?= getFullUrl($_GET['r'],'job_summary_view.php','N'); ?>';
// 	window.location.href =url5+"&mpo="+document.filter.mpo.value+"&sub_po="+document.filter.sub_po.value;
// }
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
   $('#schedule').keypress(function (e) {
       var regex = new RegExp("^[0-9]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});

function check_spo()
{
	var spo=document.getElementById('sub_po').value;
	if(spo=='')
	{
		sweetAlert('Please Select Sub PO','','warning')
		return false;

	}
	return true;
}
</script>
<?php
$get_mpo=$_GET['mpo'];
$get_sub_po=$_GET['sub_po']; 
?>
<div class="panel panel-primary">
<div class="panel-heading">Sub PO Wise Job Reconciliation Report</div>
<div class="panel-body">

<?php $phppageurl = getFullURL($_GET['r'],'print_input_sheet_ch.php','N'); ?>
<form name="filter" method="post" action="<?= $phppageurl ?>">
<div class="row">
<div class="col-md-4">
		<label>Select Master PO:</label>
		<?php
			$master_po_description=array();
			$qry_toget_master_order="SELECT master_po_description,master_po_number,mpo_serial FROM $pps.mp_order WHERE plant_code='$plantcode'";
			$toget_master_order_result=mysqli_query($link_new, $qry_toget_master_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
			$togetmaster_podescri_num=mysqli_num_rows($toget_master_order_result);
			if($togetmaster_podescri_num>0){
				while($toget_master_order_row=mysqli_fetch_array($toget_master_order_result))
				{
					// $master_po_description[$toget_master_order_row["master_po_description"]]=$toget_master_order_row["master_po_number"];
					$mpo_seq = getMasterPoSequence($toget_master_order_row['mpo_serial'],$plantcode);
					$masterr_po_seq = $mpo_seq."/".$toget_master_order_row["master_po_description"];
					$master_po_description[$masterr_po_seq]=$toget_master_order_row["master_po_number"];
				}
			}
			echo "<select name=\"mpo\" id=\"mpo\" onchange=\"firstbox();\" class='form-control' required>
					<option value=\"NIL\" selected>Please Select</option>";
					foreach ($master_po_description as $key=>$master_po_description_val) {
						if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
						{ 
						 echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
						}
						else
						{
							echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>';
						}
					} 
			echo "</select>";
		?>
	</div>
	<div class="col-md-4">
		<label>Select Sub PO:</label>
		<?php
			
			$sub_po_description=array();
			$qry_toget_sub_order="SELECT po_description,po_number,sub_po_serial FROM $pps.mp_sub_order WHERE plant_code='$plantcode' AND master_po_number='$get_mpo'";
			$toget_sub_order_result=mysqli_query($link_new, $qry_toget_sub_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
			$toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
			if($toget_podescri_num>0){
				while($toget_sub_order_row=mysqli_fetch_array($toget_sub_order_result))
				{
					$mpo_sequence = getMasterPoSequence($toget_sub_order_row['mpo_serial'],$plantcode);
					$spo_sequnce = $mpo_sequence."-".$toget_sub_order_row['sub_po_serial'];
					$spo_seq_desc = $spo_sequnce."/".$toget_sub_order_row['po_description'];
					$sub_po_description[$spo_seq_desc]=$toget_sub_order_row["po_number"];
				}
			}
			echo "<select name=\"sub_po\" id=\"sub_po\"  class='form-control' >
					<option value=\"NIL\" selected>Please Select</option>";
					foreach ($sub_po_description as $key=>$sub_po_description_val) {
						echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>';
					} 
			echo "</select>";
		?>
		<input type="hidden" name="plantcode" id="plantcode" class="form-control" value=<?=$plant_code?>>
	</div>
	<div class="col-md-1"><br/>
		<input type="submit" name="schsbt" value="Submit" class="btn btn-success" onclick="return check_spo();">
	</div>
</div>	
</form>

<?php

if(isset($_POST['confirm']))
{
	
	$tid=$_POST['tid'];
	$location=$_POST['location'];
	$qty=$_POST['qty'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$size=$_POST['size'];
	
	$check=0;
	for($i=0;$i<sizeof($tid);$i++){
		if(strlen($location[$i])>0){
			$sql="update $pps.bai_qms_db set location_id='DESTROYED-".$location[$i]."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and qms_tid in (".$tid[$i].")";
			echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert into $pps.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,plant_code,created_user,created_at) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$qty[$i]."',7,'$plantcode','$username','".date('Y-m-d')."')";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			
			$sql="update $pps.bai_qms_db set location_id='".$location[$i]."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and qms_tid=$iLastid";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			$check=1;
		}
		
	}
	
	if($check==1)
	{
		$sql="insert into $pps.bai_qms_destroy_log (qms_log_user,plant_code,created_user,created_at) values ('$username','$plantcode','$username','".date('Y-m-d')."')";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	echo "Successfully Updated.";
}

?>

<?php


if(isset($_POST['schsbt']))
{
	
$schlist=$_POST['schlist'];
$showall=$_POST['showall'];

$addfilter="qms_schedule in ($schlist) and ";
if($showall=="1")
{
	$addfilter="";
}


if(strlen($schlist)>0 or $showall=="1")
{


$x=0;

$location_id=array();
$location_title=array();
$location_id[]="";
$location_title[]="";
$sql="select * from $pps.bai_qms_location_db where plant_code='$plantcode' and active_status=0 and qms_cur_qty<qms_location_cap order by qms_cur_qty desc,order_by desc";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$location_id[]=$sql_row['qms_location_id'];
	$location_title[]=$sql_row['qms_location_id']."-".$sql_row['qms_cur_qty'];
}

$note_no=1;
$sql="select max(qms_des_note_no) as qms_des_note_no from $pps.bai_qms_destroy_log where plant_code='$plantcode'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$note_no=$sql_row['qms_des_note_no']+1;
}

echo '<form name="update" method="post" action="?r='.$_GET['r'].'">';
echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button()">Enable<input type="submit" name="confirm" value="Confirm Destroy" id="add" disabled="true" onclick="enable_button()">';

$table="<table class=\"mytable\" id=\"table1\">";
$table.="<thead>";
$table.="<tr>";
$table.='<th>SNo</th>';
$table.="<th>Style</th>";
$table.="<th>Schedule</th>";
$table.="<th>Color</th>";
$table.="<th>Size</th>";
$table.="<th>Available Quantity</th>";
$table.="<th>Existing Locations</th>";
$table.="<th>Note #</th>";
$table.="</tr>";
$table.="</thead><tbody>";
echo $table;

$sql="
select 
(
SUM(IF((qms_tran_type= 12 and location_id<>'DESTROYED'),qms_qty,0))
   -SUM(IF((qms_tran_type= 7 and length(location_id)>0),qms_qty,0))
   
   ) as qms_qty,qms_style,qms_schedule,qms_color,qms_size,group_concat(qms_tid) as qms_tid, group_concat(concat(location_id,'-',qms_qty,' PCS<br/>')) as existing_location from $pps.bai_qms_db where plant_code='$plantcode' and $addfilter left(location_id,9)<>'DESTROYED' and location_id<>'PAST_DATA' and qms_tran_type in (12,7) GROUP BY CONCAT(qms_schedule,qms_color,qms_size),location_id order by qms_schedule,qms_color,qms_size
";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if($sql_row['qms_qty']>0)
	{
		$table="<tr class=\"foo\" id=\"rowchk$x\">";
		$table.="<td>".($x+1)."</td>";
		$table.="<td>".$sql_row['qms_style']."</td>";
		$table.="<td>".$sql_row['qms_schedule']."</td>";
		$table.="<td>".$sql_row['qms_color']."</td>";
		$table.="<td>".$sql_row['qms_size']."</td>";
		
		$table.="<td>".$sql_row['qms_qty']."<input type=\"hidden\" name=\"qty[$x]\" value=\"".$sql_row['qms_qty']."\" onchange='if(this.value<0 || this.value>".$sql_row['qms_qty'].") { this.value=0; alert(\"Please enter correct value\"); }'></td>";
		
		
			$table.="<td>".$sql_row['existing_location']."</td>";
		$table.="<td><select name=location[]>";
		$table.="<option value=''></option>";
				$table.="<option value='DEST#$note_no'>DEST#".$note_no."</option>";

		$table.="</select><input type='hidden' name='tid[$x]' value='".$sql_row['qms_tid']."'>
			<input type=\"hidden\" name=\"style[$x]\" value=\"".$sql_row['qms_style']."\">
	<input type=\"hidden\" name=\"schedule[$x]\" value=\"".$sql_row['qms_schedule']."\">
	<input type=\"hidden\" name=\"color[$x]\" value=\"".$sql_row['qms_color']."\">
	<input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['qms_size']."\">
		</td>";
		
		
		$table.="</tr>";
		
		echo $table;
		
			
		$x++;
	}
	
}
echo '<tr><td colspan=5>Total Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
$table='</tbody></table>';
echo $table;

echo '</form>';
}
else
{
		echo "Please enter correct details";
}
}
?>


<script language="javascript" type="text/javascript">
	var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1"],
						 col: [5],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table1",fnsFilters);
</script>




</div>
</div>
</div>

