
<style type="text/css" media="screen">
/* @import "TableFilter_EN/filtergrid.css"; */
</style>
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script>External script -->

<?php include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); ?>
<div class="panel panel-primary">
	<div class="panel-heading">Quick Transaction Audit</div>
	<div class="panel-body">
<?php
if(isset($_POST['submit']))
{
	$sdate=$_REQUEST['sdate'];
	$schedule=$_REQUEST['schedule'];
	$status=$_REQUEST['statuscode'];
	$opscode=$_REQUEST['opscode'];
}
?>
<script type="text/javascript">
$(document).ready(function() {
	// $('#sdate').on('mouseup',function(e){
		// schedule = $('#schedule').val();
		// if(schedule === ''){
			// swal('Please Enter Schedule','','warning');
		// }
	// });
	$('#status').on('mouseup',function(e){
		schedule = $('#schedule').val();
		sdate = $('#sdate').val();
		if(schedule != ''){
			console.log('schedule');
		}else if(sdate!= '' || schedule!=''){
			console.log(schedule);
			console.log(sdate);
		}else{
			swal('Please Enter Schedule OR Date','','warning');
		}
	});
	$('#operation').on('mouseup',function(e){
		schedule = $('#schedule').val();
		sdate = $('#sdate').val();
		status = $('#status').val();
		if(schedule === '' && sdate === ''){
			swal('Please Enter Schedule OR Date','','warning');
		}
	});
	// $('#submit').on('click',function(e){
	// 	schedule = $('#schedule').val();
	// 	sdate = $('#sdate').val();
	// 	if(sdate === '' || schedule === ''){
	// 		swal('Please Enter Schedule and Date','','warning');
	// 		document.getElementById("submit").disabled = true;
	// 	}
	// 	else {
	// 		document.getElementById("submit").disabled = false;
	// 	}
		
	// });
});

function validate(){
	var schedule = document.getElementById('schedule').value;
	var sdate = document.getElementById('sdate').value;
	if(schedule!= '' || sdate!=''){
		console.log('hi');
	}else{
		sweetAlert('Please Enter Schedule OR Date','','warning');
		return false;
	}
	
	return true;
}

</script>

<form name="text" method="post" action="index.php?r=<?= $_GET['r']; ?>">
<div class="row">
	<div class="col-md-2">
		<label>Enter Schedule :</label>
		<input type="text" name="schedule" value="<?php echo $_REQUEST['schedule']; ?>" class="form-control integer" id="schedule">
	</div>
	<div class="col-md-2">
		<label>Date :</label>
		<input type="text" data-toggle="datepicker" class="form-control" name="sdate" id="sdate" value="<?php echo $_REQUEST['sdate']; ?>" readonly="readonly"> 
	</div>
	<!-- onclick="ds_sh(this);" -->
	<div class="col-md-2">
		<label>Status Code: </label>
		<select name="statuscode" class="form-control" id="status">
		<option value="-1">ALL</option>
		<option value="0">0-Created</option>
		<option value="10">10-Validated</option>
		<option value="15">15-Confirmed</option>
		<option value="16">16-Reconfirmed</option>
		<option value="20">20-M3 Log Created</option>
		<option value="30">30- Success</option>
		<option value="40">40-Failed</option>
		<option value="50">50-Manually Updated</option>
		<option value="60">60-Success Archived</option>
		<option value="70">70-Failed Archived</option>
		<option value="90">90-Ignored</option>
		</select>
	</div>
	<div class="col-md-2">
		<label>Operation:</label>
		<select name="opscode" class="form-control" id="operation">
		<option value="">ALL</option>
		<option value="LAY">LAY-Laying</option>
		<option value="CUT">CUT-Cutting</option>
		<option value="SIN">SIN-Sewing In</option>
		<option value="SOT">SOT-Sewing Out</option>
		<option value="CPK">CPK-Carton Packing</option>
		<option value="PS">PS-Panel Form Sent </option>
		<option value="PR">PR-Panel Form Received</option>
		<option value="ASPS">ASPS-Garment Form Sent</option>
		<option value="ASPR">ASPR-Garment Form Received</option>
		</select>
	</div>
	<div class="col-md-1">
		<label></label><br/>
		<input type="submit" value="Filter" name="submit" id="submit" onclick='return validate()' class="btn btn-sm btn-success">
	</div>
</div>
</form>

<?php

if(isset($_POST['submit']))
{
	
	// echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	


//echo "<h2>Transaction Audit Log</h2>";
echo "<br/><hr/><u>Status Legend:</u> 0-Created, 10-Validated, 15-Confirmed, 16-Reconfirmed, 20-M3 Log Created,  30- Success, 40-Failed, 50-Manually Updated, 60-Success Archived, 70-Failed Archived, 90-Ignored<br/><u>M3 Operation Description:</u> LAY-Laying, CUT-Cutting, SIN-Sewing In, SOT-Sewing Out, CPK-Carton Packing, <b>Embellishment:</b> PS-Panel Form Sent , PR-Panel Form Received, ASPS-Garment Form Sent, ASPR-Garment Form Received ";

echo "<div style='max-height:600px;overflow-y:scroll;max-width:1200px;'><table id=\"table111\" border=1 class='table table-bordered table-responsive'>";
echo "<tr class='danger'><th>Transaction ID</th>
		  <th class='aut'>Date</th><th>Style</th><th>Schedule</th><th class='aut'>Color</th>
		  <th>SFCS Size Code</th><th>M3 Size Code</th>
		  <th>Status</th><th>MO Number</th><th>M3 Operation Code</th><th>SFCS Job #</th><th>Docket #</th>
		  <th>Reported Qty</th><th>Rejection Reasons</th><th>Remarks</th><th>Log User</th><th>Log Time</th>
		  <th>Module #</th><th>Shift</th><th>M3 Operation Des.</th><th>SFCS Tran. Ref. ID</th><th>M3 Error Code</th>
</tr>";

$sql="select * from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where 1=1 ".(strlen($schedule)>0?" and sfcs_schedule in ($schedule)":"").(strlen($sdate)>0?" and sfcs_date='$sdate'":"").($status>=0?" and sfcs_status='$status'":"").(strlen($opscode)>0?" and m3_op_des='$opscode'":"")." union select * from $m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup where 1=1 ".(strlen($schedule)>0?" and sfcs_schedule in ($schedule)":"").(strlen($sdate)>0?" and sfcs_date='$sdate'":"").($status>=0?" and sfcs_status='$status'":"").(strlen($opscode)>0?" and m3_op_des='$opscode'":"") ;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
$sfcs_tid=$sql_row['sfcs_tid'];
$sfcs_date=$sql_row['sfcs_date'];
$sfcs_style=$sql_row['sfcs_style'];
$sfcs_schedule=$sql_row['sfcs_schedule'];
$sfcs_color=$sql_row['sfcs_color'];
$sfcs_size=$sql_row['sfcs_size'];
$m3_size=$sql_row['m3_size'];
$sfcs_doc_no=$sql_row['sfcs_doc_no'];
$sfcs_qty=$sql_row['sfcs_qty'];
$sfcs_reason=$sql_row['sfcs_reason'];
$sfcs_remarks=$sql_row['sfcs_remarks'];
$sfcs_log_user=$sql_row['sfcs_log_user'];
$sfcs_log_time=$sql_row['sfcs_log_time'];
$sfcs_status=$sql_row['sfcs_status'];
$m3_mo_no=$sql_row['m3_mo_no'];
$m3_op_code=$sql_row['m3_op_code'];
$sfcs_job_no=$sql_row['sfcs_job_no'];
$sfcs_mod_no=$sql_row['sfcs_mod_no'];
$sfcs_shift=$sql_row['sfcs_shift'];
$m3_op_des=$sql_row['m3_op_des'];
$sfcs_tid_ref=$sql_row['sfcs_tid_ref'];
$m3_error_code=$sql_row['m3_error_code'];


echo "<tr><td>$sfcs_tid</td><td>$sfcs_date</td><td>$sfcs_style</td><td>$sfcs_schedule</td><td>$sfcs_color</td><td>$sfcs_size</td><td>$m3_size</td><td>$sfcs_status</td><td>$m3_mo_no</td><td>$m3_op_code</td><td>$sfcs_job_no</td><td>$sfcs_doc_no</td><td>$sfcs_qty</td><td>".(strlen($sfcs_reason)==0?'GOOD':$sfcs_reason)."</td><td>$sfcs_remarks</td><td>$sfcs_log_user</td><td>$sfcs_log_time</td><td>$sfcs_mod_no</td><td>$sfcs_shift</td><td>$m3_op_des</td><td>$sfcs_tid_ref</td><td>$m3_error_code</td></tr>";

}

// echo '<tr><td>Total:</td><td id="table111Tot1" style="background-color:#FFFFCC; color:red;" colspan=21></td></tr>';
echo "</table></div>";


}
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	//setFilterGrid( "table111" );
var fnsFilters = {
	
	col_6:"select",
	col_7:"select",
	col_10:"select",
	col_13:"select",
	col_19:"select",
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table111Tot1"],
						 col: [12],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table111'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table111",fnsFilters);
//]]>
</script>

<script>
	document.getElementById("msg").style.display="none";		
</script>


<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
<tr><td id="ds_calclass">
</td></tr>
</table>

<script type="text/javascript">
// <!-- <![CDATA[

// Project: Dynamic Date Selector (DtTvB) - 2006-03-16
// Script featured on JavaScript Kit- http://www.javascriptkit.com
// Code begin...
// Set the initial date.
var ds_i_date = new Date();
ds_c_month = ds_i_date.getMonth() + 1;
ds_c_year = ds_i_date.getFullYear();

// Get Element By Id
function ds_getel(id) {
	return document.getElementById(id);
}

// Get the left and the top of the element.
function ds_getleft(el) {
	var tmp = el.offsetLeft;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetLeft;
		el = el.offsetParent;
	}
	return tmp;
}
function ds_gettop(el) {
	var tmp = el.offsetTop;
	el = el.offsetParent
	while(el) {
		tmp += el.offsetTop;
		el = el.offsetParent;
	}
	return tmp;
}

// Output Element
var ds_oe = ds_getel('ds_calclass');
// Container
var ds_ce = ds_getel('ds_conclass');

// Output Buffering
var ds_ob = ''; 
function ds_ob_clean() {
	ds_ob = '';
}
function ds_ob_flush() {
	ds_oe.innerHTML = ds_ob;
	ds_ob_clean();
}
function ds_echo(t) {
	ds_ob += t;
}

var ds_element; // Text Element...

var ds_monthnames = [
'January', 'February', 'March', 'April', 'May', 'June',
'July', 'August', 'September', 'October', 'November', 'December'
]; // You can translate it for your language.

var ds_daynames = [
'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'
]; // You can translate it for your language.

// Calendar template
function ds_template_main_above(t) {
	return '<table cellpadding="3" cellspacing="1" class="ds_tbl">'
	     + '<tr>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_py();"><<</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_pm();"><</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_hi();" colspan="3">[Close]</td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_nm();">></td>'
		 + '<td class="ds_head" style="cursor: pointer" onclick="ds_ny();">>></td>'
		 + '</tr>'
	     + '<tr>'
		 + '<td colspan="7" class="ds_head">' + t + '</td>'
		 + '</tr>'
		 + '<tr>';
}

function ds_template_day_row(t) {
	return '<td class="ds_subhead">' + t + '</td>';
	// Define width in CSS, XHTML 1.0 Strict doesn't have width property for it.
}

function ds_template_new_week() {
	return '</tr><tr>';
}

function ds_template_blank_cell(colspan) {
	return '<td colspan="' + colspan + '"></td>'
}

function ds_template_day(d, m, y) {
	return '<td class="ds_cell" onclick="ds_onclick(' + d + ',' + m + ',' + y + ')">' + d + '</td>';
	// Define width the day row.
}

function ds_template_main_below() {
	return '</tr>'
	     + '</table>';
}

// This one draws calendar...
function ds_draw_calendar(m, y) {
	// First clean the output buffer.
	ds_ob_clean();
	// Here we go, do the header
	ds_echo (ds_template_main_above(ds_monthnames[m - 1] + ' ' + y));
	for (i = 0; i < 7; i ++) {
		ds_echo (ds_template_day_row(ds_daynames[i]));
	}
	// Make a date object.
	var ds_dc_date = new Date();
	ds_dc_date.setMonth(m - 1);
	ds_dc_date.setFullYear(y);
	ds_dc_date.setDate(1);
	if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) {
		days = 31;
	} else if (m == 4 || m == 6 || m == 9 || m == 11) {
		days = 30;
	} else {
		days = (y % 4 == 0) ? 29 : 28;
	}
	var first_day = ds_dc_date.getDay();
	var first_loop = 1;
	// Start the first week
	ds_echo (ds_template_new_week());
	// If sunday is not the first day of the month, make a blank cell...
	if (first_day != 0) {
		ds_echo (ds_template_blank_cell(first_day));
	}
	var j = first_day;
	for (i = 0; i < days; i ++) {
		// Today is sunday, make a new week.
		// If this sunday is the first day of the month,
		// we've made a new row for you already.
		if (j == 0 && !first_loop) {
			// New week!!
			ds_echo (ds_template_new_week());
		}
		// Make a row of that day!
		ds_echo (ds_template_day(i + 1, m, y));
		// This is not first loop anymore...
		first_loop = 0;
		// What is the next day?
		j ++;
		j %= 7;
	}
	// Do the footer
	ds_echo (ds_template_main_below());
	// And let's display..
	ds_ob_flush();
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// A function to show the calendar.
// When user click on the date, it will set the content of t.
function ds_sh(t) {
	// Set the element to set...
	ds_element = t;
	// Make a new date, and set the current month and year.
	var ds_sh_date = new Date();
	ds_c_month = ds_sh_date.getMonth() + 1;
	ds_c_year = ds_sh_date.getFullYear();
	// Draw the calendar
	ds_draw_calendar(ds_c_month, ds_c_year);
	// To change the position properly, we must show it first.
	ds_ce.style.display = '';
	// Move the calendar container!
	the_left = ds_getleft(t);
	the_top = ds_gettop(t) + t.offsetHeight;
	ds_ce.style.left = the_left + 'px';
	ds_ce.style.top = the_top + 'px';
	// Scroll it into view.
	ds_ce.scrollIntoView();
}

// Hide the calendar.
function ds_hi() {
	ds_ce.style.display = 'none';
}

// Moves to the next month...
function ds_nm() {
	// Increase the current month.
	ds_c_month ++;
	// We have passed December, let's go to the next year.
	// Increase the current year, and set the current month to January.
	if (ds_c_month > 12) {
		ds_c_month = 1; 
		ds_c_year++;
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous month...
function ds_pm() {
	ds_c_month = ds_c_month - 1; // Can't use dash-dash here, it will make the page invalid.
	// We have passed January, let's go back to the previous year.
	// Decrease the current year, and set the current month to December.
	if (ds_c_month < 1) {
		ds_c_month = 12; 
		ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	}
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the next year...
function ds_ny() {
	// Increase the current year.
	ds_c_year++;
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous year...
function ds_py() {
	// Decrease the current year.
	ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
	// Redraw the calendar.
	ds_draw_calendar(ds_c_month, ds_c_year);
}

// Format the date to output.
function ds_format_date(d, m, y) {
	// 2 digits month.
	m2 = '00' + m;
	m2 = m2.substr(m2.length - 2);
	// 2 digits day.
	d2 = '00' + d;
	d2 = d2.substr(d2.length - 2);
	// YYYY-MM-DD
	return y + '-' + m2 + '-' + d2;
}

// When the user clicks the day.
function ds_onclick(d, m, y) {
	// Hide the calendar.
	ds_hi();
	// Set the value of it, if we can.
	if (typeof(ds_element.value) != 'undefined') {
		ds_element.value = ds_format_date(d, m, y);
	// Maybe we want to set the HTML in it.
	} else if (typeof(ds_element.innerHTML) != 'undefined') {
		ds_element.innerHTML = ds_format_date(d, m, y);
	// I don't know how should we display it, just alert it to user.
	} else {
		alert (ds_format_date(d, m, y));
	}
}

// And here is the end.

// ]]> -->
</script>
</div>
</div>

<style>
th,td{
	max-width  :500px;
	min-width  : 120px;
}
</style>