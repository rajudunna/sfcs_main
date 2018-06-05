
<?php include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$sawing_out_excel = '..'.getFullURL($_GET['r'],'sawing_out_excel.php','R');?>
<style>
	th{
		background-color: #003366;
		color: WHITE;
		border-bottom: 5px solid white;
		border-top: 5px solid white;
		padding: 5px;
		white-space:nowrap;
		border-collapse:collapse;
		text-align:center;
		font-family:Calibri;
		font-size:110%;
	}
	table{
		white-space:nowrap; 
		border-collapse:collapse;
		font-size:12px;
		background-color: white;
	}
	td {
		color:black;
		font-size:12px;
		font-weight:bold;
		text-align:center;
	}
	a {
		color:white;
	}
</style>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<script type="text/javascript">
	function check_sch()
	{
		var sch =document.getElementById('sch').value;
		if(sch=='')
		{
			sweetAlert('Please Enter Schedule Number','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}


jQuery(document).ready(function($){
    $('#sch').keypress(function (e) {
        var regex = new RegExp("^[0-9\]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
});

function pop_check()
{
var iChars = "!@#$%^&*()+=-a-zA-Z[]\\\';,./{}|\":<>?";

for (var i = 0; i < document.input2.sch.value.length; i++)
 {
    if (iChars.indexOf(document.input2.sch.value.charAt(i)) != -1)
     {
       sweetAlert('Please Enter Valid Schedule Number','','warning')
       document.input2.sch.value='';
        return false;
    }

}
}
</script>
<script type="text/javascript">
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();

	if(val1 > val2)
	{
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
<div class="panel-heading">SEWING OUT REPORT</div>
<div class="panel-body">

<?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
	$dattime = $date->format('Y-m-d');
	$date1=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $dattime) ) )); ?>
<form name="input2" method="post" class="form_inline" action=<?php getFullURLLevel($_GET['r'],'sawing_out_report.php',0,'N') ?>>
<div class="row">
	<!-- date1=2018-02-15;date1=2018-02-20;-example -->
	<div class="col-md-3"><label>Start Date </label>
		<?php echo '<input type="text" data-toggle="datepicker" onchange="return verify_date();"  class="form-control" id="dat1" name="dat1" value="'.$date1.'">';  ?>
		<!-- <input type='date' class="form-control" id='int' value="<?= $date1; ?>" name='dat1' width=30 required> -->
	</div>
	<div class="col-md-3"><label>End Date </label>
		<!-- <input type='date' class="form-control" id='int' value="<?= $dattime; ?>" name='dat2' width=30 required> -->
		<?php echo '<input type="text" data-toggle="datepicker" class="form-control" id="dat2" name="dat2" onchange="return verify_date();" value="'.$dattime.'">';  ?>
	</div>
	<div class="col-md-3"><label>Schedule </label><input type='text' class="form-control" id='sch'   
	     name='sch' width=30  onchange="return pop_check()"></div>
	<div class="col-md-2"><br/><input type="submit" id='btn'  class="btn btn-primary" value="View" onclick="return check_sch();" name="submit" id='sub'></div>
</div>	
</form><br/><hr/><br/>
<?php
if(isset($_POST['submit']))
{
	$dat1=$_POST['dat1'];	
	$dat2=$_POST['dat2'];
	$sch=$_POST['sch'];
	if($sch==""){
		$sch=='';
		$sql="SELECT * FROM $bai_pro3.pac_sawing_out where outs='1' AND scan_date BETWEEN '$dat1' AND '$dat2'";
		 //echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}else if($sch !=""){
		$sql="SELECT * FROM $bai_pro3.pac_sawing_out where outs='1' AND schedule='$sch' AND scan_date BETWEEN '$dat1' AND '$dat2'";
		// echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
	}
	if(mysqli_num_rows($sql_result)> 0) {
?>
	<?= "<div class='btn btn-success pull-right' style='font-weight:bold;color:WHITE;'>
	<a href='$sawing_out_excel?sdate=$dat1&edate=$dat2&schedule=$sch'>Export to Excel</a></div>"; ?>
	<div class="col-md-12 table-responsive" style="max-height:900px;overflow-y:scroll;">
	<table id="table5" class="table table-bordered">
	<tr><th>Barcode ID</th>
	<th>Date and Time</th>
	<th>Module</th>
	<th>User Style</th>
	<th>Movex Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Cut Job No</th>
	<th>Input Job No</th>
	<th>Size</th>
	<th>Qty</th>
	</tr>
	<?php
	while($rows=mysqli_fetch_array($sql_result)){
		$dat=$rows['scan_date'];
		$module=$rows['module'];
		$bid=$rows['tid'];	
		$sql1="SELECT section_id FROM $bai_pro3.plan_modules WHERE module_id='$module'";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));	
		$rows1=mysqli_fetch_array($sql_result1);
		$sec_id=$rows1['section_id'];
		
		$shift='A';
		$ustyle=$rows['style'];
		$mstyle=$rows['style'];
		$schedule=$rows['schedule'];
		$color=$rows['color'];
		$doc_no=$rows['doc_no'];
		$sql2="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_row2=mysqli_fetch_array($sql_result2);
		$order_tid=$sql_row2['order_tid'];
		$cutno=$sql_row2['acutno'];
		$sql3="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\" ";
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_row3=mysqli_fetch_array($sql_result3);
		$sql4 = "select * from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"$order_tid\"";
		$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_row4=mysqli_fetch_array($sql_result4);
		$color_code=$sql_row3['color_code'];
		
		$cut_job=chr($color_code).'00'.$cutno;
		$job_no='J00'.$rows['input_job_number'];
		$size=$rows['size'];
		$qty=$rows['qty'];
		
	?>
	<tr>
	<td><?= $bid; ?></td>
	<td><?= $dat; ?></td>
	<td><?= $module; ?></td>
	<td><?= $ustyle; ?></td>
	<td><?= $mstyle; ?></td>
	<td><?= $schedule; ?></td>
	<td><?= $color; ?></td>
	<td><?= $cut_job; ?></td>
	<td><?= $job_no; ?></td>
	<td><?= $size; ?></td>
	<td><?= $qty; ?></td>
	</tr>
	<?php
		}
	}
	else {
		echo "<script>sweetAlert('No data Found','','warning')</script>";
	}

?>
</table>
</div>
	<?php
		}
	?>
</div>
</div>
<script language="javascript" type="text/javascript">

var table3Filters = {
		btn: true,
		
		col_2: "select",
		col_3: "select",
		col_4: "select",
		col_5: "select",
		col_6: "select",
		col_7: "select",
		col_8: "select",
		col_9: "select",
		col_10:"select",
		col_11:"select",
		col_12:"select",
		exact_match: true,
		alternate_rows: true,
		loader: true,
		loader_text: "Filtering data...",
		loader: true,
		btn_reset_text: "Clear",
		
		btn_text: ">"
	}
	setFilterGrid("table5",table3Filters);
</script>
</div>