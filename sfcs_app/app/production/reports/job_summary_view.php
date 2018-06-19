<?php



include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

/*$author_id_db=array("kirang","chathurangad","dinushapre","sudathra","neilja","rameshk","gayanbu");
if(in_array($username,$author_id_db))
{
	
}
else
{
	header("Location:../restricted.php");
}*/
?>

<style>
body
{
	/* font-family:calibri;
	font-size:12px; */
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


}

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
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
/* @import "../TableFilter_EN/filtergrid.css"; */

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	/* font-family:Arial, Helvetica, sans-serif; font-size:88%;  */
}
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
<!-- <script language="javascript" type="text/javascript" src="../TableFilter_EN/actb.js"></script>External script
<script language="javascript" type="text/javascript" src="../TableFilter_EN/tablefilter.js"></script> -->

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

function check_sch()
{
	var sch=document.getElementById('schedule').value;
	if(sch=='')
	{
		sweetAlert('Please Enter Schedule','','warning')
		return false;

	}
	return true;
}
</script>

<div class="panel panel-primary">
<div class="panel-heading">Schedule Wise Job Reconciliation Report</div>
<div class="panel-body">

<?php $phppageurl = getFullURL($_GET['r'],'print_input_sheet_ch.php','N'); ?>
<form name="filter" method="post" action="<?= $phppageurl ?>">
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-3">
		<label>Enter Schedule number:</label>
		<input type="text" onkeypress="return validateQty(event);"  size="30" name="schedule" id="schedule" class="form-control">
		<!-- <input type="text" value="" required size="30" name="schedule" id="schedule"   class="form-control"> -->
	</div>
	<div class="col-md-1"><br/>
		<input type="submit" name="schsbt" value="Submit" class="btn btn-success" onclick="return check_sch();">
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
			$sql="update $bai_pro3.bai_qms_db set location_id='DESTROYED-".$location[$i]."' where qms_tid in (".$tid[$i].")";
			echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$qty[$i]."',7)";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			
			$sql="update $bai_pro3.bai_qms_db set location_id='".$location[$i]."' where qms_tid=$iLastid";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			$check=1;
		}
		
	}
	
	if($check==1)
	{
		$sql="insert into $bai_pro3.bai_qms_destroy_log (qms_log_user) values ('$username')";
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


//Serial number and Post variable index key
$x=0;

$location_id=array();
$location_title=array();
$location_id[]="";
$location_title[]="";
$sql="select * from $bai_pro3.bai_qms_location_db where active_status=0 and qms_cur_qty<qms_location_cap order by qms_cur_qty desc,order_by desc";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$location_id[]=$sql_row['qms_location_id'];
	$location_title[]=$sql_row['qms_location_id']."-".$sql_row['qms_cur_qty'];
}

$note_no=1;
$sql="select max(qms_des_note_no) as qms_des_note_no from $bai_pro3.bai_qms_destroy_log";
//echo $sql;
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
   
   ) as qms_qty,qms_style,qms_schedule,qms_color,qms_size,group_concat(qms_tid) as qms_tid, group_concat(concat(location_id,'-',qms_qty,' PCS<br/>')) as existing_location from $bai_pro3.bai_qms_db where $addfilter left(location_id,9)<>'DESTROYED' and location_id<>'PAST_DATA' and qms_tran_type in (12,7) GROUP BY CONCAT(qms_schedule,qms_color,qms_size),location_id order by qms_schedule,qms_color,qms_size
";
//echo $sql;
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
//<![CDATA[
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
	//]]>
</script>




</div>
</div>
</div>

